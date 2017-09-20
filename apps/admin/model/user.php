<?php
namespace apps\admin\model;
use core\lib\model;
class user extends model{
	public $table = 'user';
	public $table1 = 'staffs';

	  public function getAll($type,$id,$limit,$search){
      if($id){
        $qwe = " u.pid=$id and u.type=$type";
      }else{
        $qwe = "u.type=$type";
      }

    $sql = "
        SELECT
                *,u.id
        FROM
                `$this->table` AS u
        LEFT JOIN
        		`$this->table1` AS s
        ON		u.id=s.uid
       WHERE

            $qwe

        AND
            u.nickname like '%$search%'
        OR
            s.phone like '$search'

        OR
            s.cname like '$search'

       order by
            u.id   desc

        {$limit}

    ";
    return $this->query($sql)->fetchAll(2);
  }
 // add
  public function add($data){
    $res = $this->insert($this->table1,$data);
    return $this->id();
  }

    public function ePass($id,$type){
    $res = $this->update($this->table,['type'=>$type],['id'=>$id]);
    return $res->rowCount();
  }
   // cou
  public function cou(){
    return $this->count($this->table);
  }

  // 读取pid全部数据
  public function getpidAll($pid,$type,$search,$limit){
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
        AND
                type = '$type'
        AND
                nickname like '%$search%'
        {$limit}
    ";
    return $this->query($sql)->fetchAll(2);
  }

  // 读取type全部数据
  public function gettypeAll($type,$search,$limit){
    // sql
    $sql = "
        SELECT
                *
        FROM
                `$this->table`
        WHERE
                1 = 1
        AND
                type = '$type'
        AND
                nickname like '%$search%'
        {$limit}
    ";
    return $this->query($sql)->fetchAll(2);
  }

  /**
   * 更新数据
   */
  public function save($id,$data){
    $res = $this->update($this->table,$data,['id'=>$id]);
    return $res->rowCount();
  }

  /**
   * 读取pid总记录数
   */
  public function totalpidRows($pid,$type){
    return $this->count($this->table,['pid'=>$pid,'type'=>$type]);
  }

  /**
   * 读取type总记录数
   */
  public function totaltypeRows($type){
    return $this->count($this->table,['type'=>$type]);
  }

}