<?php
namespace apps\admin\model;
use core\lib\model;
class belleExtend extends model{
  public $table = 'belle_extend';
  /**
   *  写入数据表
   */
  public function add($data){
    $this->insert($this->table,$data);
    return $this->id();
  }

  /**
   * 读取详细信息
   */
  public function getInfo($raid){
    return $this->get($this->table,'*',['raid'=>$raid]);
  }

  /**
   * 更新数据表
   */
  public function save($id,$data){
    $res = $this->update($this->table,$data,['id'=>$id]);
    return $res->rowCount();
  }

}