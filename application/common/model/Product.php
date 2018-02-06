<?php

namespace app\common\model;
use think\Model;


class Product extends Model
{

    protected $pk="pdt_id";
    protected $table="sp_product";


    public function store($data){
        // halt($data);
        $result=$this->validate(true)->save($data);

        if($result){
            return ['valid'=>1, 'msg'=>'添加产品成功'];
        }else{
            return ['valid'=>0, 'msg'=>$this->getError()];
        }
    }

    public function edit($data){
        
        $result=$this->save($data,['pdt_id'=>$data['pdt_id']]);

        if($result){
            return ['valid'=>1,'msg'=>'操作成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function del($pdt_id){
        $result=Product::destroy($pdt_id);
        if($result){
            return ['valid'=>1,'msg'=>'删除产品成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

}
