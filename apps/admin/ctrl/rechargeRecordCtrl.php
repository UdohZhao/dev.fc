<?php
namespace apps\admin\ctrl;
use apps\admin\model\rechargeRecord;
use core\lib\conf;
use vendor\page\Page;
class rechargeRecordCtrl extends baseCtrl{
	public $id;
	public $db;
	public $type;
  public $uid;
	public function _auto(){
		if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
        }
		 $this->db = new rechargeRecord();
		 $this->type = isset($_GET['type']) ? intval($_GET['type']) : 0;
     $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		 $this->uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
     $this->assign('uid',$this->uid);
	}
	public function index_demo(){
	 $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
	  // 总记录数
    $cou = $this->db->cou($this->id);
    // 数据分页
    $page = new Page($cou,conf::get('LIMIT','admin'));
    // 结果集

		$data = $this->db->getAll($this->id,$page->limit,$search);
		$id = $this->id;

		$this->assign('id',$id);
		$this->assign('data',$data);
		$this->assign('page',$page->showpage());
		$this->display('rechargeRecord','index.html');
		die;
	}

  /**
   * 充值记录页面
   */
  public function index(){
    // search
    $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
    // 总记录数
    $totalRows = $this->db->totalpidRows($this->uid);
    // 数据分页
    $page = new Page($totalRows,conf::get('LIMIT','admin'));
    // 读取相关数据
    $data = $this->db->getCorrelation($this->uid,$search,$page->limit);
    // assign
    $this->assign('data',$data);
    $this->assign('page',$page->showpage());
    // display
    $this->display('rechargeRecord','index.html');
    die;
  }

}
