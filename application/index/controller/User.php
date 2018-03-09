<?php

namespace app\index\controller;
use app\common\controller\Common;

class User extends Common{
    
    public function index(){
        $pub=db('article')->where('arc_type','1')->field('arc_id,arc_title,create_time')->order('create_time desc')->limit(5)->select();
        $this->assign('_pub',$pub);
        return $this->fetch();
    }

    public function profile(){
        return $this->fetch();
    }


    public function pass(){
        return $this->fetch();
    }


}