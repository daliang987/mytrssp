<?php
namespace app\common\model;
use think\Model;

class Comment extends Model{
    protected $table="sp_comment";
    protected $pk="c_id";
    protected $insert=['create_time'];


    protected function setCreateTimeAttr(){
        return time();
    }

    public function store($data){
        $result=$this->validate(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'添加评论成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function del($id){
        $result=Comment::destroy($id);
        if($result){
            return ['valid'=>1,'msg'=>'删除评论成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
}