<?php
namespace apps\home\ctrl;
use apps\home\model\landlord;
use apps\home\model\user;
class landlordCtrl extends baseCtrl{
  public $db;
  public $udb;
  // 构造方法
  public function _auto(){
    $this->db = new landlord();
    $this->udb = new user();
  }

  /**
   * 添加地主
   */
  public function add(){
    // Get
    if (IS_GET === true) {
      // 读取当前用户地主信息
      $data = $this->db->getRow($this->userinfo['id']);
      // assign
      $this->assign('data',$data);
      // display
      $this->display('landlord','add.html');
      die;
    }
    // Ajax
    if (IS_AJAX === true) {
      // data
      $data = $this->getData();
      // 写入数据表
      $res = $this->db->add($data);
      if ($res) {
        // 更新用户地主状态
        $this->udb->save($_SESSION['userinfo']['id'],array('landlord_status'=>1));
        echo J(R(0,'受影响的操作 :)',true));
        die;
      } else {
        echo J(R(1,'请尝试刷新页面后重试 :(',false));
        die;
      }
    }
  }

  /**
   * 初始化数据
   */
  private function getData(){
    $data['uid'] = $_SESSION['userinfo']['id'];
    $data['pid'] = $_SESSION['userinfo']['pid'];
    $data['phone'] = isset($_POST['phone']) ? $_POST['phone'] : '';
    $data['cname'] = isset($_POST['cname']) ? htmlspecialchars($_POST['cname']) : '';
    $data['id_card'] = isset($_POST['id_card']) ? $_POST['id_card'] : '';
    $data['city'] = isset($_POST['city']) ? htmlspecialchars($_POST['city']) : '';
    $data['ctime'] = time();
    return $data;
  }

}