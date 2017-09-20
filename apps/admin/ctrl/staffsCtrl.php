<?php
namespace apps\admin\ctrl;
use core\lib\conf;
use apps\admin\model\staffs;
class staffsCtrl extends baseCtrl{
  public $db;
  public $uid;
  // 构造方法
  public function _auto(){
    $this->db = new staffs();
    $this->uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
  }

  /**
   * 添加个人信息
   */
  public function add(){
    // Ajax
    if (IS_AJAX === true) {
      // data
      $data = $this->getData();
      // 写入数据表
      $res = $this->db->add($data);
      if ($res) {
        echo J(R(200,'受影响的操作 :)',true));
        die;
      } else {
        echo J(R(400,'请尝试刷新页面后重试 :(',false));
        die;
      }
    }
  }

  /**
   * 初始化数据
   */
  private function getData(){
    $data = array();
    $data['uid'] = $this->uid;
    $data['cname'] = htmlspecialchars($_POST['cname']);
    $data['phone'] = $_POST['phone'];
    return $data;
  }

}