<?php
namespace apps\admin\model;
use core\lib\model;
class rechargeRecord extends model{
	public $table = 'recharge_record';

	public function getAll($id,$limit,$search){
		$sql = "
			SELECT
					*
			FROM
				$this->table
			WHERE
				uid=$id
			and
				orderid like '%$search%'
			ORDER BY 'ctime' desc
			{$limit}
			";
			 return $this->query($sql)->fetchAll(2);
	}
	  // cou
 public function cou($id){
    return $this->count($this->table,['uid'=>$id]);
  }

  /**
   * 读取相关数据
   */
  public function getCorrelation($uid,$search,$limit){
  	// sql
  	$sql = "
  			SELECT
  							*
  			FROM
  							`$this->table`
  			WHERE
  							1 = 1
  			AND
  							uid = '$uid'
        AND
                orderid like '%$search%'
        ORDER BY
                citme DESC
        {$limit}
  	";
  	return $this->query($sql)->fetchAll(2);
  }

  /**
   * 读取相关总记录数
   */
  public function totalpidRows($uid){
    return $this->count($this->table,['uid'=>$uid]);
  }

}