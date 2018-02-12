<?php

namespace app\admin\controller;
use app\common\controller\Admin;
use think\Controller;

class User extends Admin{

    protected $db;

    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\User();
    }

    public function index(){
        $dataSubcom=(new \app\common\model\Subcom)->getAll();
        $this->assign('sub',$dataSubcom);

        if(request()->isPost()){
            $dataUser=$this->db->search(input('post.'));
            $this->assign('dataUser',$dataUser);
            return $this->fetch();
        }

        $dataUser=db('user')->alias('u')->join('subcompany sub','u.subcom_id=sub.subcom_id')->paginate(5);
        $this->assign('dataUser',$dataUser);

        return $this->fetch();
    }

    public function store(){

        
        if(request()->isPost()){
            $res=$this->db->store(input('post.'));
            // halt($res);
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        $dataSubcom=(new \app\common\model\Subcom)->getAll();
        $this->assign('sub',$dataSubcom);

        return $this->fetch();
    }

    public function edit(){

        if(request()->isPost()){
            $res=$this->db->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        $oldUserData=db('user')->find(input('param.uid'));
        $this->assign('user',$oldUserData);

        $dataSubcom=(new \app\common\model\Subcom)->getAll();
        $this->assign('sub',$dataSubcom);

        return $this->fetch();

    }

    public function pass(){

        if(request()->isPost()){
            $res=$this->db->pass(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        $uid=input('param.uid');
        $user=db('user')->find($uid);
        $this->assign('user',$user);
        return $this->fetch();
    }

    public function del(){
        $uid=input('get.uid');
        $res=$this->db->del($uid);
        if($res['valid']){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }

}