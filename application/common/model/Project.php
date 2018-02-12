<?php

namespace app\common\model;
use think\Model;

class Project extends Model{

    protected $table="sp_project";
    protected $pk="pro_id";

    public function store($data){
        $result=$this->validate(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'添加项目成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function edit($data){
        $result=$this->validate(true)->save($data,[$this->pk=>$data['pro_id']]);
        if($result){
            return ['valid'=>1,'msg'=>'编辑项目成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
}