<?php
namespace apps\admin\ctrl;
use core\lib\conf;
 use apps\admin\model\artiCles;
class articlesCtrl extends baseCtrl{

  public $db;

  // 构造方法
  public function _auto(){
    if (isset($_SESSION['userinfo']) == null) {
          echo "<script>window.location.href='/admin/login/index'</script>";
          die;
      }
  
    // $this->nhcid = isset($_GET['nhcid']) ? intval($_GET['nhcid']) : 0;
     $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    // $this->assign('nhcid',$this->nhcid);
    // $this->nhcdb = new newHouseCatalog();
    // $this->db = new newHouseMain();
       $this->db = new artiCles();

  }
  

  // 新房添加主力户型页面
  public function add(){
    // Get
    if (IS_GET === true) {
      // display
      if($this->id){
         $date = $this->db->getInfo($this->id);
         $atype = $date['atype'];
        $this->assign('atype',$atype);
        $this->assign('date',$date);
        $this->display('articles','add.html');
      die; 
      }else{
        $atype = isset($_GET['atype']) ? intval($_GET['atype']) : 0;
        $this->assign('atype',$atype);
        $this->display('articles','add.html');
        die; 
      }
     
    }
    // $data = $this->getData();
    // var_dump($data);
    // die;
    // Ajax
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
    $data['gold'] = $_POST['gold'];
    $data['type'] = $_POST['type'];
    $data['content'] = $_POST['content'];
    $data['ctime'] = time();
    $data['atype'] = $_POST['atype'];
    $data['status'] = 1;
    return $data;
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
     // flag
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
     // del
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
     // del
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
  //行业动态条目
  public function index(){
      
      $atype = 0;
      $data = $this->db->sel($atype);
      
      // var_dump($ctime);die;
      // $this->assign('ctime',$ctime);
      $this->assign("data",$data);
      $this->display("articles","index.html");
  }
  //赌石技巧条目
  public function indextow(){
      $atype = 1;
      $data = $this->db->sel($atype);
      $this->assign("data",$data);
      $this->display("articles","indextow.html");
  }

  public function comment(){

      $data = $this->db->comment($this->id);
    
      foreach ($data as $k){
        $qwe = $k['ctime'];
      }
      $ctime = date('Y-d-m H:i',$qwe);
      $this->assign("ctime",$ctime);
      $this->assign("data",$data);
      $this->display("articles","comment.html");
  }
  public function comm(){
    $data = $this->db->comm($this->id);
    // var_dump($data);
    // die;

    $this->display("articles","add_comm.html");
  }







}