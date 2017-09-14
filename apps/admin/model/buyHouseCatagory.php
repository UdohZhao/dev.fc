<?php
namespace apps\admin\model;
use core\lib\model;
class buyHouseCatagory extends model{
    public $tabless='recreation_article';
    public $table='recreation_category';
    

    public function checkUser($data){
        return $this->get($this->table,'*',['username'=>$data['username'],'password'=>$data['password']]);
    }
    //check
    public function check($id){
        return $this->select($this->tabless,'*',['rcid'=>$id]);
    }
    // getUsername
    public function getUsername($username){
        return $this->count($this->table,['username'=>$username]);
    }
    // and
    public function and($data){
        $res = $this->insert($this->tabless,$data);
        return $this->id();
    }
    // 更新
  public function saves($id,$data){
    $res = $this->update($this->tabless,$data,['id'=>$id]);
    return $res->rowCount();
  }

    // add
    public function add($data){
        $res = $this->insert($this->table,$data);
        return $this->id();
    }
 
    // sel
    public function sel($search,$limit){
        // sql
        $sql = "
        SELECT
               *
        FROM
                $this->table
        WHERE
                1 = 1
        AND
                cname like '%$search%'
        ORDER BY
            sort ASC
        {$limit}
    ";
        $data = $this->query($sql)->fetchAll(2);
        return $data;
    }

    // getInfo
    public function getInfo($id){
        return $this->get($this->table,'*',['id'=>$id]);
    }

    // upStatus
    public function upStatus($id,$status){
        $res = $this->update($this->table,['status'=>$status],['id'=>$id]);
        return $res->rowCount();
    }
    public function hecid($id){
        return $this->get($this->tabless,'hecid',['hecid'=>$id]);
    }
    // del
    public function del($id){
        $res = $this->delete($this->table,['id'=>$id]);
        return $res->rowCount();
    }

    //del  pid
    public function del_next($pid){
        //查询当前id下面的所有id
        $info = $this->select($this->table,'id',['pid'=>$pid]);
        return $info;
    }
    // cou
    public function cou($pid){
        return $this->count($this->table,['pid'=>$pid]);
    }

    // save
    public function save($id,$data){
        $res = $this->update($this->table,$data,['id'=>$id]);
        return $res->rowCount();
    }

    // getId
    public function getId($cname){
        return $this->get($this->table,'id',['cname'=>$cname]);
    }


    //查询
    public function sel_pcname_info($pcname){
        $this->get($this->table,["[><]$this->table(tb2)"=>['id'=>'tb2.pid'],'*']);
    }

    //查询父级名称
    /*@param $pid  当前pid
     * */
    public function sel_pcname($pid){
        return $this->get($this->table,['cname'],['id'=>$pid]);
    }

    //根据名称查询父级id
    /*
     * @param $pcname 父级名称
     * */
    public function sel_pid($pcname){
        if($pcname == '顶级'){
            return 0;
        }else{
            return $this->get($this->table,['id'],['cname'=>$pcname])['id'];
        }
    }

    //添加文章
    public function add_article($data){
        return $this->insert('house_encyclopedia_article',$data);
    }

    //获取文章内容
    public function show_article($id){
        return $this->select('house_encyclopedia_article','*',['hecid'=>$id]);
    }

    //获取单条文章内容
    public function article_detail($id){
        return $this->get('house_encyclopedia_article','*',['id'=>$id]);
    }

    //修改文章
    public function update_article($id,$data){
         return    $this->update('house_encyclopedia_article',$data,['id'=>$id]);
    }

    //删除文章
    public function del_article($id){
        $res = $this->delete('house_encyclopedia_article',['id'=>$id]);
        return $res->rowCount();
    }
}