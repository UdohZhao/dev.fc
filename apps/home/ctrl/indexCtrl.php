<?php
namespace apps\home\ctrl;
use apps\home\model\demo;
class indexCtrl extends baseCtrl{
  // 构造方法
  public function _auto(){

  }

  // 默认首页
  public function index(){
    // Get
    if (IS_GET === true) {
      // display
      $this->display('index','index.html');
      die;
    }
  }

}