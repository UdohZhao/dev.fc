<?php
namespace apps\home\ctrl;
use apps\home\model\user;
use apps\home\model\rechargeRecord;
class userCtrl extends baseCtrl{
  public $db;
  public $rrdb;
  // 构造方法
  public function _auto(){
    $this->db = new user();
    $this->rrdb = new rechargeRecord();
  }

  /**
   * 小伙伴页面
   */
  public function index(){
    // 读取一级用户
    $data['oneGrade'] = $this->db->getPidRows($this->userinfo['id']);
    if ($data['oneGrade']) {
      foreach ($data['oneGrade'] AS $k => $v) {
        // 读取一级用户充值总额，当前用户提成总额
        $sumRecharge = $this->rrdb->getSumRecharge($v['id']);
        $sumRoyalties = $this->rrdb->getSumRoyalties($v['id']);
        if ($sumRecharge[0]['total'] == null) {
          $sumRecharge[0]['total'] = '0.00';
        }
        if ($sumRoyalties[0]['total'] == null) {
          $sumRoyalties[0]['total'] = '0.00';
        }
        $data['oneGrade'][$k]['rechargeMoney'] = $sumRecharge[0];
        $data['oneGrade'][$k]['royaltiesMoney'] = $sumRoyalties[0];
        // 读取二级用户
        $twoGrade[] = $this->db->getPidRows($v['id']);
      }
      if ($twoGrade) {
        foreach ($twoGrade AS $k => $v) {
          $data['twoGrade'][] = $twoGrade[$k][0];
        }
        foreach ($data['twoGrade'] AS $k => $v) {
          // 读取二级用户充值总额，当前用户提成总额
          $sumRecharge = $this->rrdb->getSumRecharge($v['id']);
          $sumRoyalties = $this->rrdb->getSumSecondRoyalties($v['id']);
          if ($sumRecharge[0]['total'] == null) {
            $sumRecharge[0]['total'] = '0.00';
          }
          if ($sumRoyalties[0]['total'] == null) {
            $sumRoyalties[0]['total'] = '0.00';
          }
          $data['twoGrade'][$k]['rechargeMoney'] = $sumRecharge[0];
          $data['twoGrade'][$k]['royaltiesMoney'] = $sumRoyalties[0];
        }
      }
    }
    // assign
    $this->assign('data',$data);
    // display
    $this->display('user','index.html');
    die;
  }

}