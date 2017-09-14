<?php
namespace apps\home\model;
use core\lib\model;

class banner extends model{
	public $table = 'banner';

	public function sel(){
		$sql = " SELECT * FROM $this->table";
			$data = $this->query($sql)->fetchAll(2);
    return $data; 
	}
}