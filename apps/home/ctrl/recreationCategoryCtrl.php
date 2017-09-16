<?php
namespace apps\home\ctrl;
use apps\home\model\recreationCategory;
use apps\home\model\recreationArticle;
use apps\home\model\banner;
class recreationCategoryCtrl extends baseCtrl{
  public $db;
  public $radb;
  public $bdb;
  // 构造方法
  public function _auto(){
    $this->db = new recreationCategory();
    $this->radb = new recreationArticle();
    $this->bdb = new banner();
  }

  /**
   *  休闲娱乐页面
   */
  public function index(){
    // Get 
    if (IS_GET === true) {
        // 读取banner
        $data['banner'] = $this->bdb->getAll();
        // 读取休闲娱乐类别
        $data['rcData'] = $this->db->getAll();
        foreach ($data['rcData'] AS $k => $v) {
            $data['rcData'][$k]['raData'] = $this->radb->getCorrelation($v['id']);
        }
        // assign 
        $this->assign('data',$data);
        // display 
        $this->display('recreationCategory','index.html');
        die;
    }
  }

}