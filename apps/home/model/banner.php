<?php
namespace apps\home\model;
use core\lib\model;
class banner extends model{
    public $table = 'banner';
    /**
     * 读取全部数据
     */
    public function getAll(){
        // sql
        $sql = "
            select
                    *
            from
                    `$this->table`
            order by
                    sort ASC
        ";
        return $this->query($sql)->fetchAll(2);
    }



}