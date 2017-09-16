<?php
namespace apps\admin\model;
use core\lib\model;
class articlePay extends model{
	public $table = 'article_pay';

	public function sel($atype,$limit,$search){
		$sql = " 
		SELECT 
				*
		FROM 
			$this->table 
		WHERE
		atype = $atype
    and 
    title like  '%$search%'
    or 
    tips like '$search'

		order by 
			ctime
			desc		
      {$limit} 
		";
		 return $this->query($sql)->fetchAll(2);
	}
	  // add
  public function add($data){
    $res = $this->insert($this->table,$data);
    return $this->id();
  }
  //修改.....
    public function save($id,$data){
        $res = $this->update($this->table,$data,['id'=>$id]);
        return $res->rowCount();
    }
   
      // getInfo
  public function getInfo($id){
    return $this->get($this->table,'*',['id'=>$id]);
  }
       //dle
  public function dle($id){
    $res = $this->delete($this->table,['id'=>$id]);
    return $res->rowCount();
  }
    // upStatus
  public function upStatus($id,$status){
    $res = $this->update($this->table,['status'=>$status],['id'=>$id]);
    return $res->rowCount();
  }
     // cou
  public function cou(){
    return $this->count($this->table);
  }
}