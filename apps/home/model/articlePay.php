<?php
namespace apps\home\model;
use core\lib\model;
class articlePay extends model{

    public $table = "article_pay";
    /**
     *	读取数据
     */	
    public function getLimit($atype){
        // sql 
        $sql = "
            SELECT 
                    *
            FROM 
                    `$this->table`
            WHERE 
                    1 = 1
            AND 
                    atype = '$atype'
            AND 
                    status = '1'        
            ORDER BY 
                    ctime desc        
            LIMIT 
                    0 , 5                         
        ";
        return $this->query($sql)->fetchAll(2);
    }

    /**
     *  读取全部数据
     */ 
    public function getAll($atype){
        // sql 
        $sql = "
            SELECT 
                    *
            FROM 
                    `$this->table`
            WHERE 
                    1 = 1
            AND 
                    atype = '$atype'
            AND 
                    status = '1'        
            ORDER BY 
                    ctime desc                              
        ";
        return $this->query($sql)->fetchAll(2);
    }

    /** 
     *  读取详细信息
     */
    public function getInfo($id){
       return $this->get($this->table,'*',['id'=>$id]);
    }

    /**
     *  读取标题
     */
    public function getTitle($id){
       return $this->get($this->table,'title',['id'=>$id]);
    }

    /**
     * 更新数据
     */
    public function save($id,$data){
       $res = $this->update($this->table,$data,['id'=>$id]);
       return $res->rowCount();
    }


}

