<?php
namespace apps\admin\ctrl;
use core\lib\conf;
use apps\admin\model\belleExtend;
use vendor\page\Page;
class belleExtendCtrl extends baseCtrl{
  public $db;
  public $raid;
  public $id;
  // 构造方法
  public function _auto(){

   if (isset($_SESSION['userinfo']) == null) {
            echo "<script>window.location.href='/admin/login/index'</script>";
            die;
        }
    $this->db = new belleExtend();
    $this->raid = isset($_GET['raid']) ? intval($_GET['raid']) : 0;
    $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  }

  /**
   * 添加美妹配置页面
   */
  public function add(){
    // Ajax
    if (IS_AJAX === true) {
      // data
      $data = $this->getData();
      // id
      if ($this->id) {
        // 更新数据表
        $res = $this->db->save($this->id,$data);
      } else {
        // 写入数据表
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
    $data['raid'] = $this->raid;
    $data['qq'] = htmlspecialchars($_POST['qq']);
    $data['wecaht'] = htmlspecialchars($_POST['wecaht']);
    $data['phone'] = htmlspecialchars($_POST['phone']);
    $data['qq_money'] = htmlspecialchars($_POST['qq_money']);
    $data['wechat_money'] = htmlspecialchars($_POST['wechat_money']);
    $data['phone_money'] = htmlspecialchars($_POST['phone_money']);
    return $data;
  }

  /**
   * 读取详细信息
   */
  public function getInfo(){
    // Ajax
    if (IS_AJAX === true) {
      $data = $this->db->getInfo($this->raid);
      if ($data) {
        echo J(R(200,'',$data));
        die;
      } else {
        echo J(R(400,'',$data));
        die;
      }
    }
  }

}