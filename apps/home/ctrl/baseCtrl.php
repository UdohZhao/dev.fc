<?php
namespace apps\home\ctrl;
use core\lib\conf;
use vendor\wechat\wechat;
define('TOKEN', 'bainianfc');
class baseCtrl extends \core\icunji{
  public $appid;
  public $appsecret;
  public $wechat;
  // 构造方法
  public function _initialize(){
    //控制器初始化
    if(method_exists($this,'_auto'))
        $this->_auto();
    $this->appid = conf::get('APPID','wechat');
    $this->appsecret = conf::get('APPSECRET','wechat');
    $this->wechat = new wechat(TOKEN,DEBUG,$this->appid,$this->appsecret);
    // access_token检测是否过期
<<<<<<< HEAD
    // if (time() > $_SESSION['expires_in']) {
    //   $this->wechat->getAccessToken();
    // }
=======
    if (isset($_SESSION['expires_in'])) {
      if (time() > $_SESSION['expires_in']) {
        $this->wechat->getAccessToken();
      }
    } else {
      $this->wechat->getAccessToken();
    }
>>>>>>> 9a3547157b4552d9ee47a5cf8ba60dfec402d4b3

  }

}