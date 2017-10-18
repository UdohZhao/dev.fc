<?php
namespace apps\home\model;
use core\lib\model;
class user extends model{
  public $table = 'user';
  /**
   * 根据oepnid读取详细信息
   */
  public function getopenidInfo($openid){
    return $this->get($this->table,'*',['openid'=>$openid]);
  }

  /**
   * 根据id读取详细信息
   */
  public function getidInfo($id){
    return $this->get($this->table,'*',['id'=>$id]);
  }

  /**
   * 写入数据表
   */
  public function add($data){
    $this->insert($this->table,$data);
    return $this->id();
  }

  /**
   * 更新数据表
   */
  public function save($id,$data){
    $res = $this->update($this->table,$data,['id'=>$id]);
    return $res->rowCount();
  }

  /**
   * 读取金币
   */
  public function getResidue($id){
    return $this->get($this->table,'residue',['id'=>$id]);
  }

  /**
   * 读取提现金额
   */
  public function getPushMoney($id){
    return $this->get($this->table,'push_money',['id'=>$id]);
  }

  /**
   * 读取下级总数
   */
  public function getTotalLevel($pid){
    return $this->count($this->table,['pid'=>$pid]);
  }

  /**
   * 读取下级
   */
  public function getLevel($pid){
    return $this->select($this->table,'*',['pid'=>$pid]);
  }

  // 读取用户类型
  public function getType($id){
    return $this->get($this->table,'type',['id'=>$id]);
  }

  /**
   * 读取pid下级
   */
  public function getPidRows($pid){
    // sql
    $sql = "
        SELECT
                *
        FROM
                `$this->table`
        WHERE
                1 = 1
        AND
                pid = '$pid'
        ORDER BY
                id DESC
    ";
    return $this->query($sql)->fetchAll(2);
  }

}

