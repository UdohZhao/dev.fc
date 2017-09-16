<?php
namespace apps\admin\ctrl;
use apps\admin\model\articleComment;
use core\lib\conf;
use vendor\page\Page;
class articleCommentCtrl extends baseCtrl{
	public $db;
	public $id;
	public function _auto(){
if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
        }
		$this->db = new articleComment();	
		$this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;  	
	}
	public function index(){
    // 获取搜索条件
    $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
     // 总记录数
    $cou = $this->db->cou();
    // 数据分页
    $page = new Page($cou,conf::get('LIMIT','admin'));
    // 结果集

		$data = $this->db->sel($this->id,$page->limit,$search);
		$id = $this->id;
    $this->assign('id',$id);
		$this->assign('data',$data);
    $this->assign('page',$page->showpage());
		$this->display('articleComment','index.html');
		die;
	}
	     // 删除
  public function delse(){
    // Ajax
    if (IS_AJAX === true) {
      // delete
      $res = $this->db->delse($this->id);
      if ($res) {
        echo json_encode(true);
        die;
      } else {
        echo json_encode(false);
        die;
      }
    }
  }
      // 修改状态
    public function flae(){
        // Ajax
        if (IS_AJAX === true) {
            // status 

            $status = intval($_POST['status']);
            // update
            $res = $this->db->upStatu($this->id,$status);
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