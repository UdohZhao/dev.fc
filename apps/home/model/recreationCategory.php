<?php
namespace apps\home\model;
use core\lib\model;
class recreationCategory extends model{
    public $table = 'recreation_category';
    /**
     *  读取数据
     */
    public function getAll(){
        // sql
        $sql = "
            SELECT
                    *
            FROM
                    `$this->table`
            WHERE
                    1 = 1
            AND
                    status = '1'
            ORDER BY
                    id DESC
        ";
        return $this->query($sql)->fetchAll(2);
    }

    /**
     * 读取类别名称
     */
    public function getCname($id){
        return $this->get($this->table,'cname',['id'=>$id]);
    }



}

