<?php
namespace apps\home\ctrl;
use apps\home\model\recreationIv;
use apps\home\model\demo;

class recreationIvCtrl extends baseCtrl{
	public $id;
	public $db;
	//构造方法
	public function _auto(){
		$this->id = isset($_POST['id']) ? intval($_POST['id']): 1;
		$this->db = new recreationIv();
	}
	public function index(){
		$data = $this->db->sel($this->id);
		
		$this->assign('data',$data);
		$this->display('recreationIv','index.html');
		die;
	}
}