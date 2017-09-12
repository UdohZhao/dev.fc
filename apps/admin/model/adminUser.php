<?php
namespace apps\admin\model;
use core\lib\model;
class adminUser extends model{
  public $table = 'admin_user';
  /**
   * 获取用户信息
   */
  public function getInfo($username,$password){
    return $this->get($this->table, '*', ['username'=>$username,'password'=>$password]);
  }

  /**
   * 写入数据表
   */
  public function add($data){
    $this->insert($this->table,$data);
    return $this->id();
  }

  /**
   * 读取id
   */
  public function getId($username){
    return $this->get($this->table,'id',['username'=>$username]);
  }

  /**
   * 读取全部数据
   */
  public function getAll($search){
    $sql = "
        SELECT
                *
        FROM
                `$this->table`
        WHERE
                1 = 1
        AND
                username like '%$search%'
    ";
    return $this->query($sql)->fetchAll();
  }

// getUsername
  public function getUsername($username){
    return $this->count($this->table,['username'=>$username]);
  }
  /**
   * 读取单条数据
   */
  public function getSingle($id){
    return $this->get($this->table,'*',['id'=>$id]);
  }

  /**
   * 更新数据
   */
  public function save($id,$data){
    $res = $this->update($this->table,$data,['id'=>$id]);
    return $res->rowCount();
  }
 // upStatus
  public function Status($id,$status){
    $res = $this->update($this->table,['status'=>$status],['id'=>$id]);
    return $res->rowCount();
  }
  /**
   * 删除数据
   */
  public function del($id){
    $res = $this->delete($this->table,['id'=>$id]);
    return $res->rowCount();
  }

  /**
   * 获取总记录数
   */
  public function totalRow(){
    return $this->count($this->table);
  }
 public function cou(){
    return $this->count($this->table);
  }

}

