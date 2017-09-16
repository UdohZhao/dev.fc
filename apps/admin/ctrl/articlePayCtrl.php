<?php
namespace apps\admin\ctrl;
 use apps\admin\model\articlePay;
use core\lib\conf;
use vendor\page\Page;

class articlePayCtrl extends baseCtrl{
	public $db; 
  public $id;
	public $atype;
	public function _auto(){
if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
        }
  $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;  
	$this->atype = isset($_GET['atype']) ? intval($_GET['atype']) : 0;	
	$this->db = new articlePay(); 		
	}
	public function index(){
    // 获取搜索条件
    $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';

    // 总记录数
    $cou = $this->db->cou();
    // 数据分页
    $page = new Page($cou,conf::get('LIMIT','admin'));
    // 结果集

		$data = $this->db->sel($this->atype,$page->limit,$search);
		$atype = $this->atype;

		$this->assign('atype',$atype);
		$this->assign('data',$data);
    $this->assign('page',$page->showpage());
		$this->display('articlePay','index.html');
		die;
	} 
	public function add(){

    
      // Get
    if (IS_GET === true) {
      // display
      if($this->id){
         $date = $this->db->getInfo($this->id);
          if (!file_exists(ICUNJI.$date['cover_path'])) {
          $date['cover_path'] = '';
        }
        // assign
        $this->assign('date',$date);

         $atype = $date['atype'];
         $this->assign('id',$this->id);
        $this->assign('atype',$atype);
        $this->assign('date',$date);
        $this->display('articlePay','add.html');
      die; 
      }else{
        $atype = isset($_GET['atype']) ? intval($_GET['atype']) : 0;
        $this->assign('id',$this->id);
        $this->assign('atype',$atype);
        $this->display('articlePay','add.html');
        die; 
      }
     
    }

		if (IS_AJAX === true) {
      // data  
    
      $data = $this->getData();
     
   if($this->id){
     
        $res = $this->db->save($this->id,$data);
 
      }else{
        // 写入数据表
        $res = $this->db->add($data);
      }
      if ($res) {
        echo json_encode(true);
        die;
      } else {
        echo json_encode(false);
        die;
      }
    }
		$atype = $this->atype;
    $id = $this->id;

    $this->assign('id',$id);
		$this->assign('atype',$atype);
		$this->display('articlePay','add.html');
		die;
	}
	  // 初始化数据
  private function getData(){

    // data
    $data = array();
        // hpPath
      $hpPath = isset($_POST['hpPath']) ? $_POST['hpPath'] : '';
            if (!$hpPath) {
              $res = upFiles('cover_path');

              if ($res['code'] == 400) {
                echo json_encode($res['msg']);
                die;
              } else {
            $data['cover_path'] = $res['data'];
          }
        } else {
            $data['cover_path'] = $hpPath;
        }
    
    $data['title'] = htmlspecialchars($_POST['title']);
    $data['tips'] = htmlspecialchars($_POST['tips']);
    $data['gold'] = isset($_POST['gold']) ? $_POST['gold'] : '';
    $data['type'] = isset($_POST['type']) ? $_POST['type'] : '';
    $data['content'] = isset($_POST['content']) ? $_POST['content'] : '';
    $data['ctime'] = time();
    $data['atype'] = isset($_POST['atype']) ? $_POST['atype'] : '';
    $data['status'] = 1;
    $data['reads'] = isset($_POST['reads']) ? $_POST['reads'] : '';
    $data['likes'] = isset($_POST['likes']) ? $_POST['likes'] : '';
    $data['comments'] = isset($_POST['comments']) ? $_POST['comments'] : '';
    return $data;

  }
   public function dle(){
    // Ajax
    if (IS_AJAX === true) {
      // delete
      $res = $this->db->dle($this->id);
      if ($res) {
        echo json_encode(true);
        die;
      } else {
        echo json_encode(false);
        die;
      }
    }
  }
    // flag
    public function flag(){
        // Ajax
        if (IS_AJAX === true) {
            // status 

            $status = intval($_POST['status']);
            // update
            $res = $this->db->upStatus($this->id,$status);
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