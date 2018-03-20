<?php

namespace app\index\controller;
use app\common\controller\Common;

class User extends Common{

    protected $db;

    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\User();
    }
    
    public function index(){
        $pub=db('article')->where('arc_type','1')->field('arc_id,arc_title,create_time')->order('create_time desc')->limit(5)->select();
        $this->assign('_pub',$pub);

        $vulstate=db('vul')->field('count(*) as cc,vul_state')->group('vul_state')->where('vul_userid',session('session.userid'))->select();
        $this->assign('vstate',$vulstate);
        $sum=0;
        foreach($vulstate as $c){
            $sum+=$c['cc'];
        }
        $this->assign('sum',$sum);

        $info=db('user')->alias('u')->join('subcompany s','s.subcom_id=u.subcom_id','left')->where('uid',session('session.userid'))->find();
        $this->assign('userinfo',$info);

        return $this->fetch();
    }

    public function profile(){

        $user=db('user')->where('uid',session('session.userid'))->find();
        $this->assign('user',$user);

        $company=(new \app\common\model\Subcom)->getAll();
        $this->assign('sub',$company);

        if(request()->isPost()){
            $data=input('post.');
            if(isset($data['level'])){
                $this->error('前台无法进行用户权限设置');exit;
            }
            $data['uid']=session('session.userid');
            $res=$this->db->edit($data);
            if($res['valid']){
                $this->success($res['msg']);exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        return $this->fetch();
    }


    public function pass(){
        if(request()->isPost()){
            $data=input('post.');
            $data['uid']=session('session.userid');
            $res=$this->db->pass($data);
            if($res['valid']){
                $this->success($res['msg']);exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }

    public function headimg(){
        if(request()->isAjax()){
            $headimg=input('post.headimg');
            $res=$this->db->modifyhead($headimg,session('session.username'));
            if($res['valid']){
                $this->success($res['msg']);exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
    }


}