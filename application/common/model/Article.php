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
        $dataArticle=db('article')->alias('a')->join('vultype t','a.arc_type=t.tid','left')->join('cate c','c.cate_id=a.arc_type','left')->paginate(10);
        return $dataArticle;
    }


    public function store($data){
        switch($data['arc_type']){
            case 1: //公告
                $result=$this->allowField(true)->validate(true)->save($data);
                if($result){
                    $arc_pdt['pdt_id']=$data['pdt_id'];
                    $arc_pdt['arc_id']=$this->arc_id;
                    $pdt_res=(new \app\common\model\Arcpdt())->store($arc_pdt);
                    if($pdt_res){
                        return ['valid'=>1,'msg'=>'发布公告成功'];
                    }else{
                        return ['valid'=>0,'msg'=>$this->getError()];
                    }
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
                break;
            case 2: //文章
                $result=$this->allowField(true)->validate(true)->save($data);
                if($result){
                    $arc_vtype['tid']=$data['cate_id'];
                    $arc_vtype['arc_id']=$this->arc_id;
                    $arc_res=(new \app\common\model\Arcvtype())->store($arc_vtype);
                    if($arc_res){
                        return ['valid'=>1,'msg'=>'发布文章成功'];
                    }else{
                        return ['valid'=>0,'msg'=>$this->getError()];
                    }
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
                break;
            
            default: //工具
                $result=$this->allowField(true)->validate(true)->save($data);
                if($result){
                    return ['valid'=>1,'msg'=>'发布内容成功'];
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
                break;
        }
        
    }

    public function edit($data){
        switch($data['arc_type']){
            case 1: //公告
                $result=$this->allowField(true)->validate(true)->save($data,['arc_id'=>$data['arc_id']]);
                if($result){
                    Arcpdt::get(['arc_id'=>$data['arc_id']])->delete();
                    $arc_pdt['pdt_id']=$data['pdt_id'];
                    $arc_pdt['arc_id']=$this->arc_id;
                    $pdt_res=(new \app\common\model\Arcpdt())->store($arc_pdt);
                    if($pdt_res){
                        return ['valid'=>1,'msg'=>'修改公告成功'];
                    }else{
                        return ['valid'=>0,'msg'=>$this->getError()];
                    }
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
                break;
            case 2: //文章
                $result=$this->allowField(true)->validate(true)->save($data,['arc_id'=>$data['arc_id']]);
                if($result){
                    Arcvtype::get(['arc_id'=>$data['arc_id']])->delete();
                    $arc_vtype['tid']=$data['cate_id'];
                    $arc_vtype['arc_id']=$this->arc_id;
                    $arc_res=(new \app\common\model\Arcvtype())->store($arc_vtype);
                    if($arc_res){
                        return ['valid'=>1,'msg'=>'修改文章成功'];
                    }else{
                        return ['valid'=>0,'msg'=>$this->getError()];
                    }
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
                break;
            
            default: //工具
                $result=$this->allowField(true)->validate(true)->save($data,['arc_id'=>$data['arc_id']]);
                if($result){
                    return ['valid'=>1,'msg'=>'修改内容成功'];
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
                break;
        }
        
    }

    public function del($arc_id,$arc_type){
        $arcdata=db('article')->find($arc_id);
        $filepath=ROOT_PATH.'public'.DS.'uploads'.DS.$arcdata['attach_path'];
        if(is_file($filepath)){
            unlink($filepath);
        }
        switch($arc_type){
            
            case 1://公告
                $res1=Arcpdt::get(['arc_id'=>$arc_id])->delete();
                $res2=Article::destroy($arc_id);
                if($res1 && $res2){
                    return ['valid'=>1,'msg'=>'公告删除成功'];
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
            break;

            case 2:
                $res1=Arcvtype::get(['arc_id'=>$arc_id])->delete();
                $res2=Article::destroy($arc_id);
                if($res1 && $res2){
                    return ['valid'=>1,'msg'=>'文章删除成功'];
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
            break;

            default:
                $res1=Article::destroy($arc_id);
                if($res1){
                    return ['valid'=>1,'msg'=>'内容删除成功'];
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
            break;
        }
    }
}