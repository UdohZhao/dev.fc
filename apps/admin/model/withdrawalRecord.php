<?php
namespace apps\admin\model;
use core\lib\model;
class withdrawalRecord extends model{
	public $table = 'withdrawal_record';

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
	   public function status($id,$status){
    $res = $this->update($this->table,['status'=>$status],['id'=>$id]);
    return $res->rowCount();
    }
       // cou
public function cou($id){
    return $this->count($this->table,['uid'=>$id]);
  }

  /**
   * 读取相关提现记录
   */
    public function getCorrelation($uid,$status,$search,$limit){
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
                  status = '$status'
          AND
                  orderid like '%$search%'
          ORDER BY
                  ctime DESC
          {$limit}
      ";
      return $this->query($sql)->fetchAll(2);
    }

    /**
     * 更新数据
     */
    public function save($id,$data){
      $res = $this->update($this->table,$data,['id'=>$id]);
      return $res->rowCount();
    }

    /**
     * 读取相关总记录数
     */
    public function totalRows($uid,$status){
      return $this->count($this->table,['uid'=>$uid,'status'=>$status]);
    }

}