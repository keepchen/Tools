# Tools

#### 一些有用的工具文件、函数、插件等

#### hanzi_convert_pinyin.js

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
