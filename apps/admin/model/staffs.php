<?php
namespace apps\admin\model;
use core\lib\model;
class staffs extends model{
  public $table = 'staffs';
  /**
   * 读取相关数据
   */
  public function getCorrelation($uid){
    return $this->get($this->table,'*',['uid'=>$uid]);
  }

  /**
   * 写入数据表
   */
  public function add($data){
    $this->insert($this->table,$data);
    return $this->id();
  }



}