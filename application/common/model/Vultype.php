<?php

namespace app\common\model;
use think\Model;

class Vultype extends Model{

    protected $pk="tid";
    protected $table="sp_vultype";

    public function edit($data){

        $result=$this->validate(true)->save($data,[$this->pk=>$data['tid']]);
        if($result){
            return ['valid'=>1,'msg'=>'修改漏洞成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function store($data){
        $result=$this->validate(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'添加漏洞成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function del($tid){
        $result=Vultype::destroy($tid);
        if($result){
            return ['valid'=>1,'msg'=>'删除漏洞成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
}