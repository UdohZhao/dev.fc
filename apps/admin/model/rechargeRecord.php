<?php
namespace apps\admin\model;
use core\lib\model;
class rechargeRecord extends model{
	public $table = 'recharge_record';

	public function getAll($id,$limit,$search){
		$sql = "
			SELECT 
					*
			FROM 
				$this->table 
			WHERE 
				uid=$id 
			and 
				orderid like '%$search%'
			ORDER BY 'ctime' desc 
			{$limit}  
			";
			 return $this->query($sql)->fetchAll(2);
	}
	  // cou
 public function cou($id){
    return $this->count($this->table,['uid'=>$id]);
  }
}