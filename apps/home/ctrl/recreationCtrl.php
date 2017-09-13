<?php
namespace apps\home\ctrl;
use apps\home\model\recreation;
use core\lib\conf;

class recreationCtrl extends baseCtrl{
	//构造方法
	public $db;
	public $id;
	public function _auto(){
		  $this->db = new recreation();
      $this->id = isset($_GET['id']) ? intval($_GET['id']) : 1;
	}
  	 public function index(){
  		$data = $this->db->sel();
  		$data1 = $this->db->sel1($this->id);

  		$this->assign('data1',$data1);
  		$this->assign('data',$data);
      // display
      $this->display('recreation','index.html');
      die;
}

}
	
