<?php
namespace apps\admin\model;
use core\lib\model;
class articleComment extends model{
	public $table = 'article_comment';
	public $table1 = 'user';
	public function sel($id,$limit,$search){
		$sql = " 
		SELECT 
				a.*,u.nickname
		FROM 
				$this->table as a
		LEFT JOIN 
				$this->table1 as u
		ON  
				a.uid = u.id 
		WHERE
				a.apid=$id
		AND 
			a.content like '%$search%'
		OR
			u.nickname like '$search'
								
				{$limit}";
		return $this->query($sql)->fetchAll(2);
	}
	  // 删除
  public function delse($id){
    $res = $this->delete($this->table,['id'=>$id]);
    return $res->rowCount();
  }
   // 修改状态
  public function upStatu($id,$status){
    $res = $this->update($this->table,['status'=>$status],['id'=>$id]);
    return $res->rowCount();
  }
    // cou
  public function cou(){
    return $this->count($this->table);
  }
   // getInfo
  public function getInfo($id){
    return $this->get($this->table,'*',['id'=>$id]);
  }
   //修改.....
    public function save($id,$data){
        $res = $this->update($this->table,$data,['id'=>$id]);
        return $res->rowCount();
    }
     public function add($data){
    $res = $this->insert($this->table,$data);
    return $this->id();
  }
}