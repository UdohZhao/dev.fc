<?php
namespace apps\home\ctrl;
use apps\home\model\demo;
class staffsCtrl extends baseCtrl{
  // 构造方法
  public function _auto(){

  }

  // 职员页面
  public function index(){
    // Get
    if (IS_GET === true) {
      // 读取当前用户提现金额
      $_SESSION['userinfo']['push_money'] = $this->udb->getPushMoney($_SESSION['userinfo']['id']);
      // display
      $this->display('staffs','index.html');
      die;
    }
  }

  // 分享二维码页面
  public function shareQRcode(){
    // Get
    if (IS_GET === true) {
      // display
      $this->display('staffs','shareQRcode.html');
      die;
    }
  }

}