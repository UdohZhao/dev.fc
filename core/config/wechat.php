<?php
return array(
  'APPID'   =>    'wxad31bc3e4960dd3d', // appid
  'APPSECRET'   =>    '20206674b6e4e9edb70000294074ab0a', // appsecret
  'REDIRECT_URI'  =>  isHttps() . '/base/getCode', // 回调地址
  'UNIT_PERCENT'    =>    '5', // 提成百分比
  'CONVERSION'      =>    '100', // 兑换比例，测试为100倍，默认为10倍
  'PRESENT'         =>    '1000' //新用户首次充值赠送$1000金币
);