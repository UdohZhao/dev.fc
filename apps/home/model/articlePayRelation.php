<?php
namespace apps\home\model;
use core\lib\model;
class articlePayRelation extends model{
    public $table = 'article_pay_relation';
    /**
     * 写入数据表
     */
    public function add($data){
        $this->insert($this->table,$data);
        return $this->id();
    }

    /**
     * 读取相关统计
     */
    public function getcCount($apid,$uid){
        return $this->count($this->table,['apid'=>$apid,'uid'=>$uid]);
    }




}

