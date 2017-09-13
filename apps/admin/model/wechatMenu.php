<?php
namespace apps\admin\model;
use core\lib\model;
class wechatMenu extends model{
  public $table = 'wecaht_menu';
  /**
   * 写入数据
   */
  public function add($data){
    $this->insert($this->table,$data);
    return $this->id();
  }

  /**
   * 读取详细信息
   */
  public function getInfo($id){
    return $this->get($this->table,'*',['id'=>$id]);
  }

  /**
   * 更新数据
   */
  public function save($id,$data){
    $res = $this->update($this->table,$data,['id'=>$id]);
    return $res->rowCount();
  }

  /**
   * 读取重复值
   */
  public function getRepetition($cname){
    return $this->count($this->table,['cname'=>$cname]);
  }

  /**
   * 读取所有数据
   */
  public function getAll(){
    // sql
    $sql = "
      SELECT
              *
      FROM
              `$this->table`
    ";
    return $this->query($sql)->fetchAll(2);
  }

  /**
   * 删除数据
   */
  public function del($id){
    $res = $this->delete($this->table,['id'=>$id]);
    return $res->rowCount();
  }

  /**
   * 读取总记录数
   */
  public function getTotal(){
    return $this->count($this->table);
  }


}