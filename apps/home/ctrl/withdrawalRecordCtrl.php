<?php
namespace apps\home\ctrl;
use apps\home\model\withdrawalRecord;
class withdrawalRecordCtrl extends baseCtrl{
  public $db;
  // 构造方法
  public function _auto(){
    $this->db = new withdrawalRecord();
  }

  // 添加提现记录
  public function add(){
    // Ajax
    if (IS_AJAX === true) {
      // data
      $data = $this->getData();
      // 写入数据表
      $res = $this->db->add($data);
      if ($res) {
        // 更新用户收益
        $this->udb->save($_SESSION['userinfo']['id'],array('push_money'=>0,'status'=>1));
        echo J(R(200,'申请提现成功，工作人员将尽快处理 :)',true));
        die;
      } else {
        echo J(R(400,'申请提现失败，请尝试刷新页面后重试 :(',false));
        die;
      }
    }
  }

  // 初始化数据
  private function getData(){
    $data = array();
    $data['uid'] = $_SESSION['userinfo']['id'];
    $data['orderid'] = createIn();
    $data['money'] = $_POST['push_money'];
    $data['ctime'] = time();
    $data['status'] = 0;
    return $data;
  }

  /**
   * 提现记录页面
   */
  public function index(){
    // 读取当前用户提现记录
    $data = $this->db->getRows($this->userinfo['id']);
    // assign
    $this->assign('data',$data);
    // display
    $this->display('withdrawalRecord','index.html');
    die;
  }

}