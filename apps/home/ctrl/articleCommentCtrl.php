<?php
namespace apps\home\ctrl;
use apps\home\model\articlePay;
use apps\home\model\articleComment;
class articleCommentCtrl extends baseCtrl{
  public $apid;
  public $apdb;
  public $db;
  // 构造方法
  public function _auto(){
    $this->apid = isset($_GET['apid']) ? intval($_GET['apid']) : 0;
    $this->assign('apid',$this->apid);
    $this->apdb = new articlePay();
    $this->db = new articleComment();
  }

  /**
   * 添加留言页面
   */
  public function add(){
    // Get 
    if (IS_GET === true) {
       // 读取文章标题
       $title = $this->apdb->getTitle($this->apid); 
       // assign 
       $this->assign('title',$title);
       // display 
       $this->display('articleComment','add.html');
       die;
    }
    // Ajax 
    if (IS_AJAX === true) {
        // 防止重复留言
        $res = $this->db->getId($this->apid,$_SESSION['userinfo']['id']);
        if ($res) {
            echo J(R(401,'请勿重复提交留言 :(',false));
            die;
        }
        // data
        $data = $this->getData();
        // 写入数据表
        $res = $this->db->add($data);
        if ($res) {
            echo J(R(200,'留言提交成功 :)',true));
            die;
        } else {
            echo J(R(400,'留言提交失败 :(',false));
            die;
        }
    }
  }

  /**
   *  初始化数据
   */
  private function getData(){
    // data
    $data = array();
    $data['apid'] = $this->apid;
    $data['uid'] = $_SESSION['userinfo']['id'];
    $data['content'] = htmlspecialchars($_POST['content']);
    $data['reply'] = '';
    $data['ctime'] = time();
    $data['likes'] = 0;
    $data['status'] = 0;
    return $data;
  }



}