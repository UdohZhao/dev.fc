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

        $attachArr = explode(',', '1,0,0');
        see($attachArr);
        die;

        // 读取详细信息
        $data = $this->db->getInfo($this->id);
        $data['beData'] = $this->bedb->getCorrelation($data['id']);
        // 读取当前用户是否已经付费查看QQ号，微信号，手机号
        $data['rrData'] = $this->rrdb->getPaytype($data['id']);
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