<?php
namespace apps\home\ctrl;
use apps\home\model\recreationIv;
use apps\home\model\demo;

class recreationIvCtrl extends baseCtrl{
	public $id;
	public $db;
	//构造方法
	public function _auto(){
		$this->id = isset($_GET['id']) ? intval($_GET['id']): 0;

		$this->db = new recreationIv();
	}
	public function index(){
		
		$data = $this->db->sel($this->id);

		$this->assign('data',$data);
		$this->display('recreationIv','index.html');
		die;
	}
}