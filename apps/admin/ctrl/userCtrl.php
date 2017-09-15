<?php
namespace apps\admin\ctrl;
use apps\admin\model\user;
use core\lib\conf;
use vendor\page\Page;

class userCtrl extends baseCtrl{
	public $db;
	public $id;
	public $type;
	public function _auto(){

		$this->db = new user();
		 $this->type = isset($_GET['type']) ? intval($_GET['type']) : 0;
		 $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		 // if($_SESSION['userinfo']['type'] !=0 ){
   //        echo "<script>alert('没有权限');window.location.href='/admin/index/index'</script>";
   //        die;
   //    }
	}
	public function index(){

    // 获取搜索条件
    $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
    
    // 总记录数
    $cou = $this->db->cou();
    // 数据分页
    $page = new Page($cou,conf::get('LIMIT','admin'));
    // 结果集

		$data = $this->db->getAll($this->type,$this->id,$page->limit,$search);
		
    $type = $this->type;
		

		$this->assign('type',$type);
		$this->assign('data',$data);
    $this->assign('page',$page->showpage());
		$this->display('user','index.html');
		die;
	}

	  // 初始化数据
  private function getData(){
    // data
    $data = array();
    $data['cname'] = $_POST['cname'];
    $data['phone'] = $_POST['phone'];
    $data['uid']   = $this->id;
    return $data;
  }

  public function add(){
   // Ajax
    if (IS_AJAX === true) {
        // password
      $type = 1;
      // update
      $delt = $this->db->ePass($this->id,$type);
     
      //data
       $data = $this->getData();
      // insert
       $res = $this->db->add($data);
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