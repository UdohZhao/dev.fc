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
    return $this->select($this->table,'type',['raid'=>$raid,'uid'=>$uid]);
  }

  /**
   * SUM相关用户订单充值总额
   */
  public function getSumRecharge($uid){
    // sql
    $sql = "
        SELECT
                sum(money) AS total
        FROM
                `$this->table`
        WHERE
                1 = 1
        AND
                uid = '$uid'
    ";
    return $this->query($sql)->fetchAll(2);
  }

  /**
   * SUM相关用户订单提成总额
   */
  public function getSumRoyalties($uid){
    // sql
    $sql = "
        SELECT
                sum(agency_money) AS total
        FROM
                `$this->table`
        WHERE
                1 = 1
        AND
                uid = '$uid'
    ";
    return $this->query($sql)->fetchAll(2);
  }

  /**
   * SUM相关用户订单提成总额
   */
  public function getSumSecondRoyalties($uid){
    // sql
    $sql = "
        SELECT
                sum(agent_money) AS total
        FROM
                `$this->table`
        WHERE
                1 = 1
        AND
                uid = '$uid'
    ";
    return $this->query($sql)->fetchAll(2);
  }

  /**
   * 读取相关充值记录
   */
  public function getRows($uid){
    // sql
    $sql = "
        SELECT
                *
        FROM
                `$this->table`
        WHERE
                1 = 1
        AND
                uid = '$uid'
        ORDER BY
                ctime DESC
    ";
    return $this->query($sql)->fetchAll(2);
  }


}

