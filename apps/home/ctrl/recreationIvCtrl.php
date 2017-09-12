<?php
namespace apps\home\ctrl;
use apps\home\model\demo;

class recreationIvCtrl extends baseCtrl{

	//构造方法
	public function _auto(){

	}
	public function index(){
		$this->display('recreationIv','index.html');
		die;
	}
}