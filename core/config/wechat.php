<?php
return array(
  'APPID'   =>    'wxad31bc3e4960dd3d', // appid
  'APPSECRET'   =>    '20206674b6e4e9edb70000294074ab0a', // appsecret
  'REDIRECT_URI'  =>  isHttps() . '/base/getCode', // 回调地址
  'GENERAL_AGENCY_PERCENT'    =>    '5', // 总代理提成百分比
  'AGENT_PERCENT'    =>    '10', // 代理商提成百分比
  'AGENCY_PERCENT'    =>    '15', // 经销商提成百分比
  'CONVERSION'      =>    '100', // 兑换比例，测试为100倍，默认为10倍
  'PRESENT'         =>    '100' //新用户赠送$100金币
);