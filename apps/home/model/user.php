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

}

