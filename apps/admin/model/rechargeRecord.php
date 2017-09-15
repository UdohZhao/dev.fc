<?php
namespace apps\admin\model;
use core\lib\model;
class rechargeRecord extends model{
	public $table = 'recharge_record';
	public $table1 = 'user';

	public function getAll($id){
		$sql = "
			SELECT 
					r.*,u.nickname,u.type
			FROM 
				$this->table as r 
			LEFT JOIN 
				$this->table1 as u 
			ON  
				r.uid = u.id	
			WHERE 
				r.uid=$id 
			ORDER BY 'ctime' 
			";
			 return $this->query($sql)->fetchAll(2);
	}
}