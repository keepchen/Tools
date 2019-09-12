# Tools

#### 一些有用的工具文件、函数、插件等

#### hanzi_convert_pinyin.js

> 汉字转拼音

```js
// 调用:
hanzi_convert_pinyin("123，我爱你我的祖国！");
// 结果:
// "123，wǒ ài nǐ wǒ de zǔ guó ！"

// 调用:
hanzi_convert_pinyin("123，我爱你我的祖国！", " ");
// 结果:
// "wǒ ài nǐ wǒ de zǔ guó"

```

#### jianti_fanti_exchange.js

> 中文简体繁体转换

```js
// 调用:
jianti_fanti_exchange("广东");
// 结果:
// "廣東"

// 调用:
jianti_fanti_exchange("廣東", false);
// 结果:
// "广东"
```

#### sms_regions.php

> 全球手机号地区码

```json
[{
	"region_en_name": "China",
	"region_cn_name": "中国",
	"region_code": "CN",
	"region_no": "86"
}, {
	"region_en_name": "Colombia",
	"region_cn_name": "哥伦比亚",
	"region_code": "CO",
	"region_no": "57"
},
]
```
```php
[
  [
    "region_en_name" => "China",
    "region_cn_name" => "中国",
    "region_code"    => "CN",
    "region_no"      => "86"
  ],
  [
    "region_en_name" => "Colombia",
    "region_cn_name" => "哥伦比亚",
    "region_code"    => "CO",
    "region_no"      => "57"
  ],
  ...
]
```

#### WeChat.php

> 微信相关

```php
// 获取微信全局access_token
getWxGlobalAccessToken()

// 公众号|服务号获取微信用户信息
getWxCode()

// 获取微信小程序码(二进制数据)
getWxQrCode()
```


#### decimalConvertN.js

> 十进制转N进制

```js
//十进制转2进制
decimalConvertN(100, 2);

//十进制转16进制
decimalConvertN(100, 16);

//十进制转32进制
decimalConvertN(100, 32);
```

#### quick-copy.js

> 浏览器复制文本功能

```html
<!-- html -->
<span id="copy" data-copy="我要复制的文字">我要复制的文字</span>
<script type="text/javascript" src="./quick-copy.js"></script>
```

```js
//js usage
var el = document.getElementById("copy");
try{
	var flag = quickCopy(el);
	if (flag === true) {
		console.log("succeed");
	} else {
		console.log("failed");
	}
}catch(Error){
	console.log("failed");
}
```


