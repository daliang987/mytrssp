<?php
namespace app\common\model;
use think\Model;
use houdunwang\arr\Arr;
class Category extends Model{
    protected $pk="cate_id";
    protected $table="sp_cate";
    public function store($data){
        
        $result=$this->validate(true)->save($data);
        if($result===false){
            return ['valid'=>0,'msg'=>$this->getError()];
        }else{
            return ['valid'=>1,'msg'=>'栏目添加成功'];
        }
    }
    public function getAll(){
        $data=Arr::tree(db('cate')->order('cate_sort','cate_id')->select(), 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
        return $data;
    }
    public function getCateData($cate_id){
        $data=db('cate')->select();
        // halt($data);
        $exclude_ids=$this->getSon($data,$cate_id);
        $exclude_ids[]=$cate_id;
        // halt($exclude_ids);
        $rdata=db('cate')->whereNotIn('cate_id',$exclude_ids)->select();
        // halt($rdata);
        $tree_rdata=Arr::tree($rdata, 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
        return $tree_rdata;
    }
    public function getSon($data,$cate_id){
        static $temp=[];
        foreach($data as $k=>$v){
            
            if($v['cate_pid']==$cate_id){
                $temp[]=$v['cate_id'];
                $this->getSon($data,$v['cate_id']);
            }
        }
        
        return $temp;
    }
    public function edit($data){
        $result=$this->validate(true)->save($data,[$this->pk=>$data['cate_id']]);
        if($result){
            return ['valid'=>1,'msg'=>'栏目修改成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }
    public function del($cate_id){
        //找到要删除栏目的父id
        $cate_pid=$this->where($this->pk,$cate_id)->value('cate_pid');
        //将其下面栏目的父id改为上面的父id。
        $this->where('cate_pid',$cate_id)->update(['cate_pid'=>$cate_pid]);
        if(Category::destroy($cate_id)){
            return ['valid'=>1,'msg'=>'删除成功'];
        }else{
            return ['valid'=>0,'msg'=>'删除失败'];
        }
    }
    public function getArc($cate_id){
        $data=db('cate')->select();
        $son_ids=$this->getSon($data,$cate_id);
        $son_ids[]=$cate_id;
        $arcdata=db('article')->whereIn('cate_id',$son_ids)->select();
        // halt($arcdata);
        return $arcdata;
    }
}