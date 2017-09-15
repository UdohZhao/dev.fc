<?php
namespace apps\home\model;
use core\lib\model;
class withdrawalRecord extends model{
  public $table = 'withdrawal_record';
  /**
   * 写入数据
   */
  public function add($data){
    $this->insert($this->table,$data);
    return $this->id();
  }

}

