<?php
namespace apps\home\ctrl;
use apps\home\model\recreationCategory;
use apps\home\model\recreationArticle;
use apps\home\model\belleExtend;
class recreationArticleCtrl extends baseCtrl{
  public $rcdb;
  public $db;
  public $bedb;
  public $id;
  public $rcid;
  // 构造方法
  public function _auto(){
    $this->rcdb = new recreationCategory();
    $this->db = new recreationArticle();
    $this->bedb = new belleExtend();
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
        foreach ($data AS $k => $v) {
          $data[$k]['beData'] = $this->bedb->getCorrelation($v['id']);
        }
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