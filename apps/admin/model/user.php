<?php
namespace apps\admin\model;
use core\lib\model;
class user extends model{
	public $table = 'user';
	public $table1 = 'staffs';

	  public function getAll($type){
    $sql = "
        SELECT
                *
        FROM
                `$this->table` AS u
        LEFT JOIN  
        		`$this->table1` AS s 
        ON		u.id=s.uid       
       WHERE 
       			type=$type
        
    ";
    return $this->query($sql)->fetchAll(2);
  }
   // add
  public function add($data){
    $res = $this->insert($this->table1,$data);
    return $this->id();
  }
}