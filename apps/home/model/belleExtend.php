<?php
namespace apps\home\model;
use core\lib\model;
class belleExtend extends model{
  public $table = 'belle_extend';
  /**
   * 读取相关数据
   */
  public function getCorrelation($raid){
    return $this->get($this->table,'*',['raid'=>$raid]);
  }

}

