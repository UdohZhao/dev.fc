<?php
namespace apps\admin\model;
use core\lib\model;
class landlord extends model{
  public $table = 'landlord';

  /**
   * 读取单条记录
   */
  public function getRow($uid){
    return $this->get($this->table,'*',['uid'=>$uid]);
  }

}