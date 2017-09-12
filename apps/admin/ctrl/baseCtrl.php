<?php
namespace apps\admin\ctrl;
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
    if (time() > $_SESSION['expires_in']) {
      $this->wechat->getAccessToken();
    }
    // 站点名称
    $this->assign('websiteName',conf::get('WEBSITE_NAME','admin'));
    // 模版赋值
    if (isset($_SESSION['userinfo'])) {
      $this->assign('userinfo',$_SESSION['userinfo']);
    } else {
      header('Location:/admin/login/index');
      die;
    }

  }

}