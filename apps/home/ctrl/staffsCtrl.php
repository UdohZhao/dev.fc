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
      // 读取当前用户基本信息
      $data['userData'] = $this->udb->getidInfo($_SESSION['userinfo']['id']);
      // 获取当前用户类型 1>总代理 ，2>代理商，3>经销商
      if ($data['userData']['type'] == 1) {
        // 读取代理商信息和总数
        $data['agentData'] = $this->udb->getLevel($_SESSION['userinfo']['id']);
        $data['agentData']['count'] = $this->udb->getTotalLevel($_SESSION['userinfo']['id']);
        $data['agentData']['aaa'] = 111;
        // 读取经销商信息和总数
        foreach ($data['agentData'] AS $k => $v) {
          $data['agencyData'][] = $this->udb->getLevel($v['id']);
          $data['agencyData']['count'][] = $this->udb->getTotalLevel($v['id']);
        }
        see($data);
        die;
        // 读取经销商邀请的用户和总数
        // foreach ($data['agency'] ) {

        // }

      }

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
    // 根据用户类型推理 1>总代理，2>代理商，3经销商
    if ($_SESSION['userinfo']['type'] == 1) {
      $type = 2;
    } else if ($_SESSION['userinfo']['type'] == 2) {
      $type = 3;
    } else if ($_SESSION['userinfo']['type'] == 3) {
      $type = 0;
    }
    $data = isHttps() . '/base/index/pid/' . $_SESSION['userinfo']['id'] .'/type/' . $type;
    $level = 'L';// 纠错级别：L、M、Q、H
    $size = 6;// 点的大小：1到10,用于手机端4就可以了
    $QRcode = new \QRcode();
    ob_start();
    $QRcode->png($data,false,$level,$size);
    $imageString = base64_encode(ob_get_contents());
    return $imageString;
  }






}