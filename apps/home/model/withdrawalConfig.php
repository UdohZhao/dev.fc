<?php
namespace apps\home\model;
use core\lib\model;
class withdrawalConfig extends model{
  public $table = 'withdrawal_config';

  /**
   * 统计单条记录
   */
  public function getcRow($uid){
    return $this->count($this->table,['uid'=>$uid]);
  }

  /**
   * 更新数据
   */
  public function save($uid,$data){
    $res = $this->update($this->table,$data,['uid'=>$uid]);
    return $res->rowCount();
  }

  /**
   * 写入数据表
   */
  public function add($data){
    $res = $this->insert($this->table,$data);
    return $res->rowCount();
  }

  /**
   * 读取单条记录
   */
  public function getRow($uid){
    return $this->get($this->table,'*',['uid'=>$uid]);
  }


}

