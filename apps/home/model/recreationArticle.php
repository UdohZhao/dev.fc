<?php
namespace apps\home\model;
use core\lib\model;
class recreationArticle extends model{
    public $table = 'recreation_article';
    /**
     * 读取相关信息
     */
    public function getCorrelation($rcid){
        // sql
        $sql = "
            SELECT
                    *
            FROM
                    `$this->table`
            WHERE
                    1 = 1
            AND
                    rcid = '$rcid'
            AND
                    status = '1'
            ORDER BY
                    id DESC
            LIMIT
                    0,5
        ";
        return $this->query($sql)->fetchAll(2);
    }

    /**
     * 读取全部相关数据
     */
    public function getAll($rcid){
        // sql
        $sql = "
            SELECT
                    *
            FROM
                    `$this->table`
            WHERE
                    1 = 1
            AND
                    rcid = '$rcid'
            AND
                    status = '1'
        ";
        return $this->query($sql)->fetchAll(2);
    }

    /**
     * 读取详细信息
     */
    public function getInfo($id){
        return $this->get($this->table,'*',['id'=>$id]);
    }

}

