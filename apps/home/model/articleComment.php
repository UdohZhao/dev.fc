<?php
namespace apps\home\model;
use core\lib\model;
class articleComment extends model{
    public $table = 'article_comment';
    /**
     * 写入数据表
     */
    public function add($data){
        $this->insert($this->table,$data);
        return $this->id();
    }

    /**
     * 获取id
     */
    public function getId($apid,$uid){
        return $this->get($this->table,'id',['apid'=>$apid,'uid'=>$uid]);
    }

    /**
     * 读取相关数据
     */
    public function getCorrelation($apid){
        // sql 
        $sql = "
            SELECT 
                    *
            FROM 
                    `$this->table`
            WHERE 
                    1 = 1
            AND 
                    apid = '$apid'
            AND 
                    status = '1' 
            ORDER BY 
                    likes DESC                               
        ";
        return $this->query($sql)->fetchAll(2);
    }

    /**
     * 读取相关评论总数
     */
    public function getcCount($apid){
        return $this->count($this->table,['apid'=>$apid]);
    }

    /**
     * 更新数据
     */
    public function save($id,$data){
        $res = $this->update($this->table,$data,['id'=>$id]);
        return $res->rowCount();
    }


}

