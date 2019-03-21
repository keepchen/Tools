<?php

class WeChat
{
    /**
     * @desc 获取微信全局access_token
     * @return void
     * @see https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140183
     */
    public function getWxGlobalAccessToken()
    {
        $get_access_token_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
        $url                  = sprintf($get_access_token_url, env("WX_APP_ID", ""), env("WX_APP_SECRET", ""));
        $response             = Utils::getInstance()->curlGet($url, 5);
        $response_decode      = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "[!] Error weixin server response invalid data.";
            return false;
        }
        if (isset($response_decode["errcode"]) && isset($response_decode["errmsg"])) {
            echo "[!] Warning weixin server response: errcode {" . $response_decode["errcode"] . "} errmsg {" . $response_decode["errmsg"] . "}.";
            return false;
        }
        if (!isset($response_decode["access_token"])) {
            echo "[!] Warning weixin server response: No access_token field.";
            return false;
        }
        $access_token = $response_decode["access_token"];
        SimpleRedisStore::set("global_wx_access_token", $access_token, 60 * 60);
        echo "[^] Info weixin access_token save to cache succeed.";
        exit(0);
    }

    /**
     * @desc 获取微信code后跳转到此方法
     * @param Request $request
     * @return void
     * @see https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140842
     * @extra
     * 将下面链接中的APPID和REDIRECT_URI替换为自己的参数
     * 通过访问此链接获取对应公众号|服务号网页授权跳转到获取code的方法(getWxCode)
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
     */
    public function getWxCode(Request $request)
    {
        $code = $request->get("code");
        //1.获取网页授权access_token
        $get_access_token_url      = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
        $url                       = sprintf($get_access_token_url, env("WX_APP_ID", ""), env("WX_APP_SECRET", ""), $code);
        $get_token_response        = Utils::getInstance()->curlGet($url, 3);
        $get_token_response_decode = json_decode($get_token_response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            exit("(0,1)微信接口数据返回错误");
        }
        if (isset($get_token_response_decode["errormsg"])) {
            exit("(0,2)微信接口数据返回错误: " . $get_token_response_decode["errormsg"]);
        }
        if (
            !isset($get_token_response_decode["access_token"]) &&
            !isset($get_token_response_decode["openid"])
        ) {
            exit("(0,3)微信接口数据返回错误: 未能正确获取到用户信息");
        }
        //2.拉取用户信息
        $get_userinfo_url             = "https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN";
        $url                          = sprintf($get_userinfo_url, $get_token_response_decode["access_token"], $get_token_response_decode["openid"]);
        $get_userinfo_response        = Utils::getInstance()->curlGet($url, 3);
        $get_userinfo_response_decode = json_decode($get_userinfo_response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            exit("(0,4)微信接口数据返回错误");
        }
        if (isset($get_token_response_decode["errormsg"])) {
            exit("(0,5)微信接口数据返回错误: " . $get_userinfo_response_decode["errormsg"]);
        }
        //3.至此，获取用户信息已完成

        //todo... 其他逻辑
    }

    /**
     * @desc 获取微信小程序码
     * @return void
     * @see https://developers.weixin.qq.com/miniprogram/dev/framework/open-ability/qr-code.html
     */
    public function getWxQrcode()
    {
        $get_qrcode_url   = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=%s";
        $query_parameters = "id_10000"; //你的参数
        $access_token     = SimpleRedisStore::get("global_wx_access_token");
        if ($access_token == false || $access_token == null) {
            exit("[!] Warning Global Access Token not exist.");
        }
        $url        = sprintf($get_qrcode_url, $access_token);
        $attributes = [
            "access_token" => $access_token, //这里使用的全局access_token，也就是上面getGlobalAccessToken方法获取到的值
            "scene"        => $query_parameters,
        ];
        $request_data    = json_encode($attributes);
        $response        = Utils::getInstance()->curlPost($url, $request_data, [], 5);
        $response_decode = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            exit("[!] Warning weixin server response: " . $response);
        }
        //成功获取到的数据为二维码二进制数据，写入到文件中
        @file_put_contents(env("QRCODE_DIR", "/qrcode") . "/" . $query_parameters . ".png", $response);
        exit("[^] Info sync qrcode succeed,query_parameters: " . $query_parameters);
    }
}
