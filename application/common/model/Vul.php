<?php
namespace app\common\model;
use think\Model;

class Vul extends Model{

    protected $table="sp_vul";
    protected $pk="vul_id";
    protected $insert=['create_time'];
    protected $update=['update_time'];

    protected function setCreateTimeAttr(){
        return time();
    }

    protected function setUpdateTimeAttr(){
        return time();
    }

    public function store($data){
        $result=$this->validate(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'漏洞保存成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }


}