<?php
namespace app\index\controller;
use think\Controller;

class Showfix extends Controller{
    public function index(){

        $pub=db('article')->where('arc_type','1')->field('arc_id,arc_title,create_time')->paginate(20);
        $this->assign('pub',$pub);

        return $this->fetch();
    }
}