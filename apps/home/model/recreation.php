<?php
namespace apps\home\model;
use core\lib\model;

class recreation extends model{
	public $table = 'recreation';

	public function sel($id){
	 	$sql = " SELECT * FROM $this->table WHERE pid='$id' ORDER BY 'status' ";
	 	$data = $this->query($sql)->fetchAll(2);
    return $data; 
	}
	
	
}