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
        if($_SESSION == null ){
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
    
        // 写入数据表
        $res = $this->db->and($data);

      if ($res) {
        echo json_encode(true);
        die;
      } else {
        echo json_encode(false);
        die;
      }
    }
    
    }
    // 初始化休闲娱乐文章表
    private function getDat(){
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
        $data['rcid'] = $this->id;
        $data['title'] = $_POST['title'];
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
            $data = $this->db->check($this->id);
            
            $this->assign('data',$data);
        $this->display('buyHouseCatagory','index_article.html');
        die;
        }else{
        // search
        $search = isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '';
        // 总记录数
        $cou = $this->db->cou($this->pid);
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
    // // 修改密码
    // public function ePass(){
    //     // Ajax
    //     if (IS_AJAX === true) {
    //         // password
    //         $password = enPassword(htmlspecialchars($_POST['password']));
    //         // update
    //         $res = $this->db->ePass($this->id,$password);
    //         if ($res) {
    //             echo json_encode(true);
    //             die;
    //         } else {
    //             echo json_encode(false);
    //             die;
    //         }
    //     }
    // }

    // flag展示 隐藏
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

    // del
    public function del(){
    // Ajax
    if (IS_AJAX === true) {
      // 读取下级
      $res = $this->db->cou($this->id);
      if ($res) {
        echo json_encode(1);
        die;
      }
      $res= $this->db->hecid($this->id);
        if($res) {    
        echo json_encode(false);
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

    // public function add_article(){
    //     $update_id=isset($_GET['update_id'])?intval($_GET['update_id']):0;
    //     if(IS_GET === true){
    //         $id=isset($_GET['id'])?intval($_GET['id']):0;
    //         $article_id=isset($_GET['article_id'])?intval($_GET['article_id']):0;
    //         $cname=isset($_GET['cname'])?htmlspecialchars($_GET['cname']):'';
    //         $this->assign('id',$id);
    //         $this->assign('cname',$cname);
    //         if($article_id){
    //             $data=$this->db->article_detail($article_id);
    //             $this->assign('cname',$this->db->getInfo($data['hecid'])['cname']);
    //             $this->assign('data',$data);
    //             $this->assign('id',$data['hecid']);
    //         }
    //         $this->display('buyHouseCatagory','add_article.html');
    //     }

    //     if(IS_AJAX === true){
    //         if($update_id){
    //            if($this->db->update_article($update_id,$this->getArticle())) {
    //                echo json_encode(array('error'=>201,'msg'=>'保存成功'));
    //                die;
    //            }else{
    //                echo json_encode(array('error'=>401,'msg'=>'稍后再试'));
    //                die;
    //            }
    //         }
    //         if($this->db->add_article($this->getArticle())){
    //             echo json_encode(true);
    //         }else{
    //             echo json_encode(false);
    //         }
    //     }
    // }

    //获取文章添加数据
    // private  function getArticle(){
    //     $data=array();
    //     $data['content']=$_POST['content'];
    //     $data['title']=htmlspecialchars($_POST['title']);
    //     $data['ctime']=time();
    //     $data['hecid']=intval($_POST['hecid']);
    //     return $data;
    // }

    // //查看文章列表
    // public function article_list(){
    //     $id=isset($_GET['id'])?intval($_GET['id']):0;
    //     $data=$this->db->show_article($id);
    //     $this->assign('data',$data);
    //     $this->display('buyHouseCatagory','article_list.html');
    // }

    // public function del_article(){
    //     $id=isset($_GET['id'])?intval($_GET['id']):0;
    //     if($this->db->del_article($id)){
    //             echo  json_encode(true);
    //     }else{
    //         echo json_encode(false);
    //     }
    // }
}