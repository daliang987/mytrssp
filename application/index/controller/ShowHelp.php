<?php
namespace app\index\controller;
use think\Controller;

class Showhelp extends Controller{
    public function index(){

        $pub=db('article')->where('arc_type','4')->field('arc_id,arc_title,create_time')->paginate(20);
        $this->assign('pub',$pub);

        return $this->fetch();
    }
}