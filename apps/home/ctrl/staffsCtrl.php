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
      $push_money = $this->udb->getPushMoney($_SESSION['userinfo']['id']);
      // 读取当前用户邀请人数
      $totalLevel = $this->udb->getTotalLevel($_SESSION['userinfo']['id']);
      // assign
      $this->assign('push_money',$push_money);
      $this->assign('totalLevel',$totalLevel);
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

  // 生成二维码
  public function getQRcode(){
    // 引入二维码类
    include ICUNJI.'/vendor/wxpay/phpqrcode/phpqrcode.php';
    $data = isHttps() . '/base/index/pid/' . $_SESSION['userinfo']['id']; 
    $level = 'L';// 纠错级别：L、M、Q、H
    $size = 6;// 点的大小：1到10,用于手机端4就可以了
    $QRcode = new \QRcode();
    ob_start();
    $QRcode->png($data,false,$level,$size);
    $imageString = base64_encode(ob_get_contents());
    return $imageString;
  }






}