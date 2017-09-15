<?php
namespace apps\home\ctrl;
use apps\home\model\articlePay;
use apps\home\model\articleComment;
class indexCtrl extends baseCtrl{
  public $atype;
  public $apdb;
  public $acdb;
  public $id;
  // 构造方法
  public function _auto(){
    $this->atype = isset($_GET['atype']) ? intval($_GET['atype']) : 0;
    $this->apdb = new articlePay();
    $this->acdb = new articleComment();
    $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  }

  // 默认首页
  public function index(){
    // Get
    if (IS_GET === true) {
      // 查询行业动态OR赌石技巧
      $data['atype'.$this->atype] = $this->apdb->getLimit($this->atype);
      // atype 0>行业动态 1>赌石技巧
      if ($this->atype == 0) {
        $atype = 1;
      } elseif ($this->atype == 1) {
        $atype = 0;
      }
      // 查询行业动态OR赌石技巧
      $data['atype'.$atype] = $this->apdb->getLimit($atype);
      // 读取评论数量
      foreach ($data['atype1'] AS $k => $v) {
        $data['atype1'][$k]['comments'] = $this->acdb->getcCount($v['id']);
      }
      // assign 
      $this->assign('data',$data);
      // display
      $this->display('index','index.html');
      die;
    }
  }

  // 文章详细
  public function detail(){
    // Get 
    if (IS_GET === true) {
      // 读取文章详细信息
      $data['apData'] = $this->apdb->getInfo($this->id);
      // 阅读+1
      $data['apData']['reads'] = bcadd($data['apData']['reads'], 1, 0);
      // 更新阅读
      $this->apdb->save($this->id,array('reads'=>$data['apData']['reads']));
      // 读取留言
      $data['acData'] = $this->acdb->getCorrelation($this->id);
      // 读取留言用户头像昵称
      foreach ($data['acData'] AS $k => $v) {
        $data['acData'][$k]['uData'] = $this->udb->getidInfo($v['uid']);
      }
      // assign
      $this->assign('data',$data);
      // display 
      $this->display('index','detail.html');
    }
  }

  // 文章点赞
  public function likes(){
    // Ajax 
    if (IS_AJAX === true) {
      // 点赞数+1
      $likes = bcadd($_POST['likes'], 1, 0);
      // 更新点赞数
      $this->apdb->save($this->id,['likes'=>$likes]);
      echo J($likes);
    }
  }

  // 留言点赞
  public function acLikes(){
    // Ajax 
    if (IS_AJAX === true) {
      // 点赞数+1
      $likes = bcadd($_POST['likes'], 1, 0);
      // 更新点赞数
      $this->acdb->save($this->id,['likes'=>$likes]);
      echo J($likes);
    }
  }  

}