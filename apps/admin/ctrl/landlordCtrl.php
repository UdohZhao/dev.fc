<?php
namespace apps\admin\ctrl;
use apps\admin\model\landlord;
use core\lib\conf;
use vendor\page\Page;
class landlordCtrl extends baseCtrl{
  public $db;
  public $uid;
  // 构造方法
  public function _auto(){
    $this->db = new landlord();
    $this->uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
  }

  /**
   * 地主信息页面
   */
  public function index(){
    // 读取相关用户地主信息
    $data = $this->db->getRow($this->uid);
    // assign
    $this->assign('data',$data);
    // display
    $this->display("landlord","index.html");
    die;
  }

}