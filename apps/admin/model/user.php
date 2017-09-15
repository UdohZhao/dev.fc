<?php
namespace apps\admin\model;
use core\lib\model;
class user extends model{
	public $table = 'user';
	public $table1 = 'staffs';

	  public function getAll($type,$id,$limit,$search){
   
    $sql = "
        SELECT
                *,u.id
        FROM
                `$this->table` AS u
        LEFT JOIN  
        		`$this->table1` AS s 
        ON		u.id=s.uid       
       WHERE 
       			
            u.pid=$id 
        AND
            u.type=$type
        AND 
            u.nickname like '%$search%'
        OR        
            s.phone like '$search'
        OR 
            s.cname like '$search'
           
       order by 
            u.id   
            
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
 
}