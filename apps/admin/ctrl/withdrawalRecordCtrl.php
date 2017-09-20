<?php
namespace apps\admin\ctrl;
use apps\admin\model\withdrawalRecord;
use core\lib\conf;
use vendor\page\Page;
class withdrawalRecordCtrl extends baseCtrl{
    public $id;
	public $uid;
	public $db;
	public $type;
    public $status;
	public function _auto(){
       if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
        }
		 $this->db = new withdrawalRecord();
         $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
         $this->uid = isset($_GET['uid']) ? intval($_GET['uid']) : 0;
		 $this->status = isset($_GET['status']) ? intval($_GET['status']) : 0;
         $this->assign('uid',$this->uid);
         $this->assign('status',$this->status);
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


    /**
     * 提现记录页面
     */
    public function index(){
        // search
        $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
        // 总记录数
        $totalRows = $this->db->totalRows($this->uid,$this->status);
        // 数据分页
        $page = new Page($totalRows,conf::get('LIMIT','admin'));
        // 读取相关提现记录
        $data = $this->db->getCorrelation($this->uid,$this->status,$search,$page->limit);
        // assign
        $this->assign('data',$data);
        $this->assign('page',$page->showpage());
        // display
        $this->display('withdrawalRecord','index.html');
        die;
    }

    /**
     * 成功 & 失败
     */
    public function commonality(){
        // Ajax
        if (IS_AJAX === true) {
           $res = $this->db->save($this->id,array('status'=>$this->status));
           if ($res) {
                echo J(R(200,'受影响的操作 :)',true));
                die;
           } else {
                echo J(R(400,'请尝试刷新页面后重试 :(',false));
                die;
           }
        }
    }

}
