<?php

namespace app\common\model;
use think\Model;

class Article extends Model{

    protected $pk="arc_id";
    protected $table="sp_article";
    protected $insert=['create_time'];
    protected $update=['update_time'];

    protected function setCreateTimeAttr(){
        return time();
    }
    protected function setUpdateTimeAttr(){
        return time();
    }

    public function getAll(){
        $dataArticle=db('article')->alias('a')->join('vultype t','a.arc_type=t.tid')->paginate(10);
        return $dataArticle;
    }


    public function store($data){
        $result=$this->allowField(true)->validate(true)->save($data);
        if($result){
            if(isset($data['type'])){
                foreach($data['type'] as $value){
                    $arc_vtype=[
                        'arc_id'=>$this->arc_id,
                        'tid'=>$value,
                    ];
                    (new \app\common\model\Arcvtype())->save($arc_vtype);
                }
            }
            return ['valid'=>1,'msg'=>'发布文章成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
}