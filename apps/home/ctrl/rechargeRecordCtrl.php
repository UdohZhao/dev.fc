<?php
namespace apps\home\ctrl;
use apps\home\model\rechargeRecord;
class rechargeRecordCtrl extends baseCtrl{
  public $db;
  public $uid;
  public $type;
  // 构造方法
  public function _auto(){
    $this->db = new rechargeRecord();
    $this->uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
    $this->type = isset($_GET['type']) ? intval($_GET['type']) : 0;
    $this->assign('type',$this->type);
  }

  /**
   * 充值记录页面
   */
  public function index(){
    // 读取相关用户充值记录
    $data = $this->db->getRows($this->uid);
    // assign
    $this->assign('data',$data);
    // display
    $this->display('rechargeRecord','index.html');
    die;
  }

}