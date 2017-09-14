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

}

