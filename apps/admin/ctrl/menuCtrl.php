<?php
namespace apps\admin\ctrl;
use core\lib\conf;
class menuCtrl extends baseCtrl{
  // 构造方法
  public function _auto(){

  }

  // 微信菜单页面
  public function index(){
    // Get
    if (IS_GET === true) {
      // display
      $this->display('menu','index.html');
      die;
    }

  }

}