<?php
namespace apps\admin\ctrl;
use core\lib\conf;
use apps\admin\model\wechatMenu;
class wechatMenuCtrl extends baseCtrl{
  public $db;
  public $id;
  // 构造方法
  public function _auto(){
    if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
        }
    $this->db = new wechatMenu();
    $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  }

  // 微信菜单页面
  public function add(){
    // Get
    if (IS_GET === true) {
      // id
      if ($this->id) {
        // 读取数据
        $data = $this->db->getInfo($this->id);
        $this->assign('data',$data);
      }
      // display
      $this->display('wechatMenu','add.html');
      die;
    }
    // Ajax
    if (IS_AJAX === true) {
      // data
      $data = $this->getData();
      if ($this->id) {
        // 更新数据
        $res = $this->db->save($this->id,$data);
      } else {
        // 防止重复添加
        $res = $this->db->getRepetition($data['cname']);
        if ($res) {
          echo J(R(401,'请勿重复添加 :(',false));
          die;
        }
        // 写入数据
        $res = $this->db->add($data);
      }
      if ($res) {
        echo J(R(200,'受影响的操作 :)',true));
        die;
      } else {
        echo J(R(400,'请尝试刷新页面后重试 :(',false));
        die;
      }

    }

  }

  /**
   * 初始化数据
   */
  private function getData(){
    $data = array();
    $data['cname'] = $_POST['cname'];
    $data['url'] = $_POST['url'];
    $data['type'] = 0;
    return $data;
  }

  /**
   * 微信菜单列表页
   */
  public function index(){
    // 读取全部数据
    $data = $this->db->getAll();
    // assign
    $this->assign('data',$data);
    // display
    $this->display('wechatMenu','index.html');
    die;
  }

  /**
   * 删除
   */
  public function del(){
    // Get
    if (IS_GET === true) {
      $res = $this->db->del($this->id);
      if ($res) {
        echo J(R(200,'受影响的操作 :)',true));
        die;
      } else {
        echo J(R(400,'请尝试刷新页面后重试 :(',false));
        die;
      }
    }
  }

  /**
   * 推送到微信
   */
  public function pushWechat(){
    // Get
    if (IS_GET === true) {
      // 读取菜单栏目，不能超过三个
      $total = $this->db->getTotal();
      if ($total > 3) {
        echo J(R(401,'不能超过3个菜单栏目 :(',false));
        die;
      }
      // 读取菜单栏目
      $data = $this->db->getAll();
      foreach ($data AS $k => $v) {
        $button['button'][$k]['type'] = 'view';
        $button['button'][$k]['name'] = $v['cname'];
        $button['button'][$k]['url'] = $v['url'];
      }
      // 请求API
      $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN";
      $param['access_token'] = $_SESSION['access_token'];
      $url = replaceUrlParam($url,$param);
      // post请求
      $res = CP($url,json_encode($button,JSON_UNESCAPED_UNICODE));
      $res = json_decode($res,true);
      if ($res['errcode'] == 0) {
        foreach ($data AS $k => $v) {
          $this->db->save($v['id'],array('type'=>1));
        }
        echo J(R(200,'受影响的操作 :)',true));
        die;
      } else {
        echo J(R(400,$res['errmsg'],false));
        die;
      }
    }

  }

}