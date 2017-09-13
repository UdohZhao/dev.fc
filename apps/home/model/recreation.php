<?php
namespace apps\home\model;
use core\lib\model;

class recreation extends model{
	public $table = 'recreation_category';
	public $table1 = 'recreation_article';

	public function sel(){
	 	$sql = " SELECT * FROM $this->table where status='1' ORDER BY 'sort' ";
	 	$data = $this->query($sql)->fetchAll(2);
    return $data; 
	}
	
	public function sel1($id){
		$sql = "SELECT * FROM $this->table1 where rcid='$id'and status='1' ";
		$data = $this->query($sql)->fetchAll(2);
		return $data;
	}
	
}