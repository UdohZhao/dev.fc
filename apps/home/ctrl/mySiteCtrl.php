<?php
namespace apps\home\ctrl;
use core\lib\conf;
class mySiteCtrl extends baseCtrl{
  // 构造方法
  public function _auto(){

  }

  /**
   * 我的地盘页面
   */
  public function index(){
    // display
    $this->display('mySite','index.html');
    die;
  }

}