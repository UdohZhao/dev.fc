<?php
namespace apps\admin\ctrl;
use apps\admin\model\rechargeRecord;
use core\lib\conf;
use vendor\page\Page;
class rechargeRecordCtrl extends baseCtrl{
	public $id;
	public $db;
	public $type;
	public function _auto(){
		 $this->db = new rechargeRecord();
		 $this->type = isset($_GET['type']) ? intval($_GET['type']) : 0;
		 $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	}
	public function index(){
		$data = $this->db->getAll($this->id);
	
		$this->assign('data',$data);
		$this->display('rechargeRecord','index.html');
		die;
	}
}
