<?php
namespace apps\admin\ctrl;
use core\lib\conf;
use apps\admin\model\carouselFigure;
use vendor\page\Page;
class carouselFigureCtrl extends baseCtrl{
  public $db;
  public $id;
  // 构造方法
  public function _auto(){

      if (isset($_SESSION['userinfo']) == null) {
          echo "<script>window.location.href='/admin/login/index'</script>";
          die;
      }
    $this->db = new carouselFigure();
    $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  }

  // 添加新房条目页面
  public function add(){
      
       if (IS_GET === true) {  
              $this->display('carouselFigure','add.html');
              die;
        }
     // $data = $this->getData();
    
      // display
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

  private function getData(){
        $data = array();
        // // hpPath
            $ipPath = isset($_POST['ipPath']) ? $_POST['ipPath'] : '';
            if (!$ipPath) {
              $res = upFiles('path');

              if ($res['code'] == 400) {
                echo json_encode($res['msg']);
                die;
              } else {
            $data['path'] = $res['data'];
          }
        } else {
            $data['path'] = $ipPath;
        }
        $data['sort'] = $_POST['sort'];
        
    return $data;
      }

  // 新房条目列表
  public function index(){

      if (IS_GET === true) { 
      // 总记录数
        $cou = $this->db->cou();
        // 数据分页
        $page = new Page($cou,conf::get('LIMIT','admin'));
        // 结果集
        $data = $this->db->sel($page->limit); 
           $this->assign('page',$page->showpage());
           $this->assign('data',$data);

        }
    // display
    $this->display('carouselFigure','index.html');
    die;
  }

  public function edit(){

    if(IS_GET === true){
      if($this->id){
        $date = $this->db->edit($this->id);

        if (!file_exists(ICUNJI.$date['path'])) {
                    $date['path'] = '';
                }

        $this->assign('date',$date);
      }
    $this->display('carouselFigure','add.html');  
    }
    
  }

  public function del(){
        if (IS_AJAX === true) {
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

}