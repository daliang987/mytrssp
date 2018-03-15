<?php

namespace app\index\controller;
use app\common\controller\Common;

class User extends Common{
    
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

        $info=db('user')->alias('u')->join('subcompany s','s.subcom_id=u.subcom_id','left')->where('uid',session('session.userid'))->value('subcom_name');
        $this->assign('company',$info);

        return $this->fetch();
    }

    public function profile(){
        return $this->fetch();
    }


    public function pass(){
        return $this->fetch();
    }


}