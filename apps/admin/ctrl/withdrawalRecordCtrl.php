<?php
namespace apps\admin\ctrl;
use apps\admin\model\withdrawalRecord;
use core\lib\conf;
use vendor\page\Page;
class withdrawalRecordCtrl extends baseCtrl{
	public $id;
	public $db;
	public $type;
	public function _auto(){
       if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
        }
		 $this->db = new withdrawalRecord();
		 $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	}
	public function index(){

     $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';    
		 // 总记录数
    $cou = $this->db->cou($this->id);
    // 数据分页
    $page = new Page($cou,conf::get('LIMIT','admin'));
    // 结果集

		$data = $this->db->getAll($this->id,$page->limit,$search);
	
		$this->assign('data',$data);
		$this->assign('page',$page->showpage());
		$this->display('withdrawalRecord','index.html');
		die;
	}
	
	 public function status(){
        // Ajax
        if (IS_AJAX === true) {
            // status
            $status = intval($_POST['status']);
            // update
            $res = $this->db->status($this->id,$status);
            if ($res) {
                echo json_encode(true);
                die;
            } else {
                echo json_encode(false);
                die;
            }
        }
    }
}
