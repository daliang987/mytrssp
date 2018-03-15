<?php

namespace app\index\controller;

use think\Controller;
use app\common\controller\Common;

class Tool extends Common{

    public function index(){
        $tool=db('article')->where('arc_type','3')->field('arc_id,arc_title,create_time')->paginate(20);
        $this->assign('pub',$tool);

        return $this->fetch();
    }
    
    public function tool(){
        $tool=db('article')->where('arc_type','3')->field('arc_id,arc_title,create_time')->paginate(10);
        $this->assign('tool',$tool);

        return $this->fetch();
    }


    public function view(){
        $arc_id=input('param.id');
        $tool=db('article')->find($arc_id);
        $this->assign('tdata',$tool);
        return $this->fetch();
    }

    public function scan(){
        return $this->fetch();
    }

    
}