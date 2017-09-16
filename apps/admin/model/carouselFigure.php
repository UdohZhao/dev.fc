<?php
namespace apps\admin\model;
use core\lib\model;
class carouselFigure extends model{
	public $table='banner';

	public function add($data){
        $res = $this->insert($this->table,$data);
        return $this->id();
    }

	public function cou(){
        return $this->count($this->table);
    }
    public function sel($limit){
        // sql
        $sql = "
        SELECT
               *
        FROM
                $this->table
        WHERE
                1 = 1
        ORDER BY
            sort ASC
        {$limit}
    ";
        $data = $this->query($sql)->fetchAll(2);
        return $data;
    }
    // del
    public function del($id){
        $res = $this->delete($this->table,['id'=>$id]);
        return $res->rowCount();
    }

    //edit
    public function edit($id){
        return $this->get($this->table,'*',['id'=>$id]);
    }
       // 修改
  public function save($id,$data){
    $res = $this->update($this->table,$data,['id'=>$id]);
    return $res->rowCount();
  }
}