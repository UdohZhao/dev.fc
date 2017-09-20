<?php
namespace apps\home\ctrl;
use apps\home\model\recreationCategory;
use apps\home\model\recreationArticle;
use apps\home\model\belleExtend;
use apps\home\model\rechargeRecord;
class recreationArticleCtrl extends baseCtrl{
  public $rcdb;
  public $db;
  public $bedb;
  public $rrdb;
  public $id;
  public $rcid;
  // 构造方法
  public function _auto(){
    $this->rcdb = new recreationCategory();
    $this->db = new recreationArticle();
    $this->bedb = new belleExtend();
    $this->rrdb = new rechargeRecord();
    $this->id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $this->rcid = isset($_GET['rcid']) ? intval($_GET['rcid']) : 0;
  }

  /**
   * 休闲娱乐文章详细页面
   */
  public function index(){
    // Get
    if (IS_GET === true) {
        // 读取详细信息
        $data = $this->db->getInfo($this->id);
        $data['beData'] = $this->bedb->getCorrelation($data['id']);
        // 读取当前用户是否已经付费查看QQ号，微信号，手机号
        $data['rrData'] = $this->rrdb->getPaytype($data['id'],$_SESSION['userinfo']['id']);
        if ($data['rrData']) {
          foreach ($data['rrData'] AS $k => $v) {
            if ($v == 1) {
              $data['qq_show'] = $data['beData']['qq'];
            } else {
              $data['qq_show'] = false;
            }
            if ($v == 2) {
              $data['wechat_show'] = $data['beData']['wecaht'];
            } else {
              $data['wechat_show'] = false;
            }
            if ($v == 3) {
              $data['phone_show'] = $data['beData']['phone'];
            } else {
              $data['phone_show'] = false;
            }
          }
        } else {
          $data['qq_show'] = false;
          $data['wechat_show'] = false;
          $data['phone_show'] = false;
        }
        see($data);
        die;
        // assign
        $this->assign('data',$data);
        // display
        $this->display('recreationArticle','index.html');
        die;
    }
  }

  /**
   *  读取相关休娱乐数据
   */
  public function indexAll(){
      // Get
      if (IS_GET === true) {
        // 读取类别名称
        $cname = $this->rcdb->getCname($this->rcid);
        // 读取相关数据
        $data = $this->db->getAll($this->rcid);
        // assign
        $this->assign('cname',$cname);
        $this->assign('data',$data);
        // display
        $this->display('recreationArticle','indexAll.html');
        die;
      }
  }







}