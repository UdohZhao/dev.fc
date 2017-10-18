<?php
namespace apps\home\model;
use core\lib\model;
class landlord extends model{
  public $table = 'landlord';

  /**
   * 写入数据表
   */
  public function add($data){
    $this->insert($this->table,$data);
    return $this->id();
  }

  /**
   * 读取相关信息
   */
  public function getRow($uid){
    return $this->get($this->table,'*',['uid'=>$uid]);
  }

}

