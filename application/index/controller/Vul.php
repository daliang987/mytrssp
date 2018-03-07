<?php

namespace app\index\controller;

use think\Controller;
use app\common\controller\Common;

class Vul extends Common{


    public function index(){
        return $this->fetch();
    }

    public function vul(){

        $pdt_data=db('product')->select();
        $this->assign('_pdt',$pdt_data);
        
        $type_first=db('vultype')->distinct(true)->field('t_first')->select();
        $this->assign('type_first',$type_first);


        if(request()->isPost()){
            halt(input('post.'));
        }

        return $this->fetch();
    }

    public function getsecond(){
        $first=input('get.first');
        $type_second=db('vultype')->where('t_first',$first)->field('tid,t_second')->select();
        return json_encode($type_second);
    }


    public function event(){
        return $this->fetch();
    }

    public function draft(){
        return $this->fetch();
    }
    
}