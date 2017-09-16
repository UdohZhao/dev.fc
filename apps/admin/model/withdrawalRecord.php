<?php
namespace apps\admin\model;
use core\lib\model;
class withdrawalRecord extends model{
	public $table = 'withdrawal_record';

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
	   public function status($id,$status){
    $res = $this->update($this->table,['status'=>$status],['id'=>$id]);
    return $res->rowCount();
    }
       // cou
public function cou($id){
    return $this->count($this->table,['uid'=>$id]);
  }
}