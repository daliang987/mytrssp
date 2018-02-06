<?php
namespace app\admin\controller;
use think\Controller;
class Category extends Controller{
    protected $db;
    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Category();
    }
    public function index(){
        // $cate_data=db('cate')->select();
        // 层级结构显示
        $cate_data=$this->db->getAll();
        // halt($cate_data);
        $this->assign('cate_data',$cate_data);
        return $this->fetch();
    }
    public function store(){
        
        if(request()->isPost()){
            $res=$this->db->store(input("post."));
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        $cate_data=$this->db->getAll();
        $this->assign('cate_data',$cate_data);
        return $this->fetch();
    }

    public function addson(){
        if(request()->isPost()){
            $res=$this->db->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        // halt(input('param.cate_id'));
        $data=db('cate')->where('cate_id',input('param.cate_id'))->find();
        if($data){
            $this->assign("data",$data);
        }
        return $this->fetch();
    }

    public function edit(){
        $cate_id=input('param.cate_id');
        if(request()->isPost()){
            $data=input('post.');
            $res=$this->db->edit($data);
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        $oldData=$this->db->find($cate_id);
        // $this->db->getSon()
        $list_cate_tree=$this->db->getCateData($cate_id);
        // halt($list_cate_tree);
        $this->assign('cate_tree',$list_cate_tree);
        $this->assign('olddata',$oldData);
        return $this->fetch();
    }
    
    public function del(){
        $cate_id=input('get.cate_id');
        // halt($cate_id);
        $res=$this->db->del($cate_id);
        if($res['valid']){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }
}