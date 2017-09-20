<?php
namespace apps\home\model;
use core\lib\model;
class rechargeRecord extends model{
  public $table = 'recharge_record';
  /**
   * 写入数据表
   */
  public function add($data){
    $this->insert($this->table,$data);
    return $this->id();
  }

  /**
   * 读取订单编号是否存在
   */
  public function getOrderid($orderid){
    return $this->count($this->table,['orderid'=>$orderid]);
  }

  /**
   * 读取付费查看类型
   */
  public function getPaytype($raid,$uid){
    return $this->select($this->table,'*',['raid'=>$raid,['uid'=>$uid]]);
  }


}

