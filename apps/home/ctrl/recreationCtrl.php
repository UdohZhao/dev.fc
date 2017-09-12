<?php
namespace apps\home\ctrl;
use apps\home\model\recreation;
use core\lib\conf;
use apps\home\model\demo;

class recreationCtrl extends baseCtrl{
	//构造方法
	public $db;
	public $id;
	public function _auto(){
		  $this->db = new recreation();
		  $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
     
	}
  	 public function index(){
  		$data = $this->db->sel('$id');
  		
  		$this->assign('data',$data);
      // display
      $this->display('recreation','index.html');
      die;
}
	
}