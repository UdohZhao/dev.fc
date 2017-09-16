<?php
namespace apps\home\ctrl;
use apps\home\model\articlePay;
use apps\home\model\articleComment;
use apps\home\model\articlePayRelation;
use apps\home\model\banner;
class indexCtrl extends baseCtrl{
  public $atype;
  public $apdb;
  public $acdb;
  public $aprdb;
  public $id;
  public $bdb;
  // 构造方法
  public function _auto(){
    $this->atype = isset($_GET['atype']) ? intval($_GET['atype']) : 0;
    $this->assign('atype',$this->atype);
    $this->apdb = new articlePay();
    $this->acdb = new articleComment();
    $this->aprdb = new articlePayRelation();
    $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $this->bdb = new banner();
  }

  // 默认首页
  public function index(){
    // Get
    if (IS_GET === true) {
      // 读取banner
      $data['banner'] = $this->bdb->getAll();
      // 读取行业动态OR赌石技巧
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
      // 读取当前用户信息
      $userinfo = $this->udb->getidInfo($_SESSION['userinfo']['id']);
      $this->assign('userinfo',$userinfo);
      // 读取文章详细信息
      $data['apData'] = $this->apdb->getInfo($this->id);
      // 截取付费
      if ($data['apData']['atype'] == 1) {
        // 读取当前用户是否已经兑换金币
        $res = $this->aprdb->getcCount($this->id,$_SESSION['userinfo']['id']);
        if (!$res) {
          $data['apData']['content'] = substr_replace($data['apData']['content'], '', stripos($data['apData']['content'], '{vip}'));
          // 获取当前用户剩余金币
          $residue = $this->udb->getResidue($_SESSION['userinfo']['id']);
          // assign 
          $this->assign('residue',$residue);
          // 显示兑换金币按钮
          $this->assign('show',true);
        } else {
          // 不显示兑换金币按钮
          $this->assign('show',false);
        }
      }
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

  /**
   * 查看更多
   */ 
  public function indexAll(){
    // 读取行业动态OR赌石技巧
    $data = $this->apdb->getAll($this->atype);
    // assign 
    $this->assign('data',$data);
    // display 
    $this->display('index','indexAll.html');
    die;
  } 

}