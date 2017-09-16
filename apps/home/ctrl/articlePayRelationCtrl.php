<?php
namespace apps\home\ctrl;
use apps\home\model\articlePayRelation;
class articlePayRelationCtrl extends baseCtrl{
  public $db;
  public $apid;
  // 构造方法
  public function _auto(){
    $this->db = new articlePayRelation();
    $this->apid = isset($_GET['apid']) ? intval($_GET['apid']) : 0;
  }

  // 写入数据
  public function add(){
    // Ajax 
    if (IS_AJAX === true) {
      // data
      $data = $this->getData();
      // 写入数据表
      $res = $this->db->add($data);
      if ($res) {
        // code_status 邀请码阅读
        if (!isset($_POST['code_status'])) {
          // 获取付费金币，剩余金币
          $gold = $_POST['gold'];
          $residue = $_POST['residue'];
          $residue = bcsub($residue, $gold, 0);
          // 更新剩余金币
          $this->udb->save($_SESSION['userinfo']['id'],array('residue'=>$residue));
        } else {
          // 更新邀请码状态为已经使用
          $this->udb->save($_SESSION['userinfo']['id'],array('code_status'=>1));
          $_SESSION['userinfo']['code_status'] = 1;
        }
        echo J(R(200,'兑换成功 :)',array('apid'=>$this->apid)));
        die;
      } else {
        echo J(R(400,'兑换失败 :(',false));
        die;
      }
    }
  }

  // 初始化数据
  private function getData(){
    // data 
    $data = array();
    $data['apid'] = $this->apid;
    $data['uid'] = $_SESSION['userinfo']['id'];
    $data['ctime'] = time();
    return $data;
  }





}