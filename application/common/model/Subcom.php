<?php

namespace app\common\model;
use think\Model;
use houdunwang\arr\Arr;


class Subcom extends Model{
    protected $pk="subcom_id";
    protected $table="sp_subcompany";

    public function searchAll($key){
        // halt(db('subcompany')->select());
        if($key){
            $dataTree=Arr::tree(db('subcompany')->select(),"subcom_name",$this->pk,"subcom_pid");
            $temp_data=array();
            foreach($dataTree as $data){
                if(strstr($data['_subcom_name'],$key)){
                    array_push($temp_data,$data);
                }
            }
            return $temp_data;
        }else{
            return $this->getAll();
        }
        
    }

    public function getAll(){
        $dataTree=Arr::tree(db('subcompany')->select(),"subcom_name",$this->pk,"subcom_pid");
        return $dataTree;
    }

    public function store($data){
        $result=$this->validate(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }


    public function removeSon($id){
        $dataTree=Arr::tree(db('subcompany')->whereNotIn('subcom_id',$this->getSon($id))->select(),"subcom_name",$this->pk,"subcom_pid");
        return $dataTree;
    }


    public function getSon($id){
        static $temp_ids=array();
        $temp_ids[]=$id;
        $ids=db('subcompany')->where("subcom_pid",$id)->column("subcom_id");
        foreach($ids as $id){
            $temp_ids[]=$id;
            $this->getSon($id);
        }
        return $temp_ids;
    }

    public function edit($data){
        $result=$this->validate(true)->save($data,[$this->pk=>$data["subcom_id"]]);
        if($result){
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function del($id){
        $result=Subcom::destroy($id);
        if($result){
            return ['valid'=>1,'msg'=>'删除成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
}