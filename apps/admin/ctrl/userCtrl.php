<?php
namespace apps\admin\ctrl;
use apps\admin\model\user;
use apps\admin\model\staffs;
use core\lib\conf;
use vendor\page\Page;

class userCtrl extends baseCtrl{
  public $db;
	public $sdb;
	public $id;
  public $pid;
	public $type;
	public function _auto(){
    if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
    }
    $this->db = new user();
		$this->sdb = new staffs();
		$this->type = isset($_GET['type']) ? intval($_GET['type']) : 0;
    $this->pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
    $this->assign('type',$this->type);
    $this->assign('pid',$this->pid);
    $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	}
	public function index(){
    // search
    $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
    // 读取用户信息 type>0 普通用户，1>总代理，2>代理商，3>经销商
    if ($this->pid) {
      // 总记录数
      $totalRows = $this->db->totalpidRows($this->pid,$this->type);
      // 数据分页
      $page = new Page($totalRows,conf::get('LIMIT','admin'));
      $data = $this->db->getpidAll($this->pid,$this->type,$search,$page->limit);
    } else {
      // 总记录数
      $totalRows = $this->db->totaltypeRows($this->type);
      // 数据分页
      $page = new Page($totalRows,conf::get('LIMIT','admin'));
      $data = $this->db->gettypeAll($this->type,$search,$page->limit);
    }
    if ($this->type) {
      foreach ($data AS $k => $v) {
        // 读取用户职员数据
        $data[$k]['sData'] = $this->sdb->getCorrelation($v['id']);
      }
    }
    // assign
    $this->assign('data',$data);
    $this->assign('page',$page->showpage());
    // display
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
      $type = $this->type;
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

  /**
   * 公共操作
   */
  public function commonality(){
    // Ajax
    if (IS_AJAX === true) {
      // 更新用户表设置为总代理
      $data['type'] = 1;
      $res = $this->db->save($this->id,$data);
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