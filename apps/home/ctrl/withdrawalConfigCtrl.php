<?php
namespace apps\home\ctrl;
use apps\home\model\withdrawalConfig;
use apps\home\model\withdrawalRecord;
class withdrawalConfigCtrl extends baseCtrl{
  public $db;
  public $wrdb;
  // 构造方法
  public function _auto(){
    $this->db = new withdrawalConfig();
    $this->wrdb = new withdrawalRecord();
  }

  /**
   * 添加配置
   */
  public function add(){
    // Get
    if (IS_GET === true) {
      // 读取配置
      $data = $this->db->getRow($this->userinfo['id']);
      $this->assign('data',$data);
      // display
      $this->display('withdrawalConfig','add.html');
      die;
    }
    // Ajax
    if (IS_AJAX === true) {
      // data
      $data = $this->getData();
      // 写入提现记录表
      $res = $this->wrdb->add($data);
      if ($res) {
        $wcData['deposit_bank'] = $data['deposit_bank'];
        $wcData['card_number'] = $data['card_number'];
        $wcData['ctime'] = time();
        // 写入提现配置表
        if ($this->db->getcRow($this->userinfo['id'])) {
          // 更新数据表
          $this->db->save($this->userinfo['id'],$wcData);
        } else {
          // 写入数据表
          $wcData['uid'] = $this->userinfo['id'];
          $this->db->add($wcData);
        }
        // 更新用户提成金额
        $uData['push_money'] = bcsub($this->userinfo['push_money'], $data['money'], 2);
        $uData['status'] = 1;
        $this->udb->save($this->userinfo['id'],$uData);
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
    $data['uid'] = $this->userinfo['id'];
    $data['orderid'] = createIn();
    $data['deposit_bank'] = isset($_POST['deposit_bank']) ? htmlspecialchars($_POST['deposit_bank']) : '';
    $data['card_number'] = isset($_POST['card_number']) ? $_POST['card_number'] : 0;
    $data['money'] = isset($_POST['money']) ? $_POST['money'] : 0;
    $data['ctime'] = time();
    $data['status'] = 0;
    return $data;
  }


}