<?php
namespace apps\admin\ctrl;
use core\lib\conf;
use apps\admin\model\buyHouseCatagory;
use vendor\page\Page;
class buyHouseCatagoryCtrl extends baseCtrl{
    public $db;
    public $id;
    public $pid;
    // 构造方法
    public function _auto(){
      
            if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
        }
        $this->db = new buyHouseCatagory();
        $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    }

    // 添加娱乐页面
    public function add(){
        // Get

        if (IS_GET === true) {   
            // id
            if ($this->id) {
                // var_dump($this->id);
                // die;
                // 获取单条数据
                $data = $this->db->getInfo($this->id);
                // assign
                $this->assign('data',$data);
            }
            // display
            $this->display('buyHouseCatagory','add.html');
            die;
        }
        if (IS_AJAX === true) {
            // data
            $data = $this->getData();
            // id
            
            if ($this->id) {
                $res = $this->db->save($this->id,$data);
            } else {
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
    public function and(){
         if (IS_GET === true) {   
            // id
            if($this->id){
                $this->assign('id',$this->id);
               $this->display('buyHouseCatagory','add_article.html');
            }
            // display
            
        }
       
      // Ajax
    if (IS_AJAX === true) {
      // data  

      $data = $this->getDat();
        
      if($_POST['rcid']){
        
        $res = $this->db->saves($this->id,$data);
      }else{
        // 写入数据表
        $res = $this->db->and($data);
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
    // 修改初始化休闲娱乐文章表
    
    // 初始化休闲娱乐文章表
    private function getDat(){
        $data = array();
        // hpPath
            $ipPath = isset($_POST['ipPath']) ? $_POST['ipPath'] : '';
            if (!$ipPath) {
              $res = upFiles('cover_path');

              if ($res['code'] == 400) {
                echo json_encode($res['msg']);
                die;
              } else {
            $data['cover_path'] = $res['data'];
          }
        } else {
            $data['cover_path'] = $ipPath;
        }
            if($_POST['rcid']){
                $data['rcid'] = $_POST['rcid'];
            }else{
                $data['rcid'] = $this->id;
            }
        $data['title'] = $_POST['title'];
        $data['tips'] = $_POST['tips'];
        $data['content'] = $_POST['content'];
        $data['status'] = 1;
    return $data;
      }
      
    // 初始化休闲娱乐类别表
    private function getData(){
        // data
        $data = array();
        $data['cname'] = htmlspecialchars($_POST['cname']);
        $data['sort'] = intval($_POST['sort']);
        $data['status'] = 1;
        return $data;
    }

    // 房类别列表页面
    public function index(){
        if($this->id){
             // search
        $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
        // 总记录数
        $cou = $this->db->cous($this->id);
        // 数据分页
        $page = new Page($cou,conf::get('LIMIT','admin'));
        $data = $this->db->check($this->id,$search,$page->limit);
            
            $this->assign('id',$this->id);
            $this->assign('page',$page->showpage());
            $this->assign('data',$data);
        $this->display('buyHouseCatagory','index_article.html');
        die;
        }else{
        // search
        $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
        // 总记录数
        $cou = $this->db->cou();
       
        // 数据分页
        $page = new Page($cou,conf::get('LIMIT','admin'));
        // 结果集
        $data = $this->db->sel($search,$page->limit);
        
        // assign
        $this->assign('data',$data);
        $this->assign('page',$page->showpage());
        // display

        $this->display('buyHouseCatagory','index.html');
        die;
    }

    }
  
    // flag展示 隐藏(顶级)
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
    // flag展示 隐藏(二级)
    public function flas(){
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
    //删除二级
    public function dle(){
        if (IS_AJAX === true) {
        $res = $this->db->dle($this->id);
         if($res) {    
            echo json_encode(true);
            die;
          } else {
            echo json_encode(false);
            die;
          }

        }
    }
    // 删除一级
    public function del(){
    // Ajax
    if (IS_AJAX === true) {
      // 读取下级
      $res= $this->db->rcid($this->id);
        if($res) {    
        echo json_encode(1);
        die;
      }
      // 删除
      $res = $this->db->del($this->id);

     if($res) {    
        echo json_encode(true);
        die;
      } else {
        echo json_encode(false);
        die;
      }
    }
  }

  public function modify(){

    if(IS_GET === true){
        if($this->id){
            $data = $this->db->modify($this->id);
      
                if (!file_exists(ICUNJI.$data['cover_path'])) {
                    $data['cover_path'] = '';
                }
                
            // assign
                $this->assign('date',$data);
        }
        
        $this->assign('id',$data['id']);
      
    
    $this->display('buyHouseCatagory','add_article.html');  
    }
    
  }






}