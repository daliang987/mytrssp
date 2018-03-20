<?php

namespace app\admin\controller;
use app\common\controller\Admin;
use think\Session;

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


    public function logout(){
        Session::clear();
    }



    public function view(){
        $uid=input('param.uid');
        $vulstate=db('vul')->field('count(*) as cc,vul_state')->group('vul_state')->where('vul_userid',$uid)->select();
        $this->assign('vstate',$vulstate);
        $sum=0;
        foreach($vulstate as $c){
            $sum+=$c['cc'];
        }
        $this->assign('sum',$sum);

        $info=db('user')->alias('u')->join('subcompany s','s.subcom_id=u.subcom_id','left')->where('uid',$uid)->find();
        $this->assign('user',$info);

        $sub=(new \app\common\model\Subcom())->getAll();
        $this->assign('sub',$sub);

        return $this->fetch();
    }


}