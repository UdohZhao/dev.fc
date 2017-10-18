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

  /**
   * 读取相关记录
   */
  public function getRows($uid){
    // sql
    $sql = "
      SELECT
              *
      FROM
              `$this->table`
      WHERE
              1 = 1
      AND
              uid = '$uid'
      ORDER BY
              ctime DESC
    ";
    return $this->query($sql)->fetchAll(2);
  }

}

