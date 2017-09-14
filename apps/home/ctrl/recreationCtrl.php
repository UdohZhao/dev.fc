<?php
namespace apps\home\ctrl;
use apps\home\model\recreation;
use apps\home\model\banner;
use core\lib\conf;

class recreationCtrl extends baseCtrl{
	//构造方法
	public $db;
	public $id;
  public $ban;
	public function _auto(){
		  $this->db = new recreation();
      $this->ban = new banner();
      $this->id = isset($_GET['id']) ? intval($_GET['id']) : 1;
      $this->type = isset($_GET['type']) ? intval($_GET['type']): '';
	}
  	 public function index(){

  		$data = $this->db->sel();
      $type = $this->type;
      $banner = $this->ban->sel();
  		$data1 = $this->db->sel1($this->id);
     

      $this->assign('banner',$banner);
      $this->assign('type',$type);
  		$this->assign('data1',$data1);
  		$this->assign('data',$data);
      // display
      $this->display('recreation','index.html');
      die;
}

}
	
