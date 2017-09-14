<?php
namespace apps\home\model;
use core\lib\model;
 class recreationIv extends model{
 	public $table = 'recreation_article';

 	public function sel($id){
 		$sql = " SELECT * FROM $this->table where id= '$id' ";
 		$data = $this->query($sql)->fetchAll(2);
 		return $data;
 	}
 }