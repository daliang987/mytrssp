<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\captcha\Captcha;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }


    public function login(){

        
        return $this->fetch();
    }

    public function captcha(){
        $captcha=new Captcha(config('captcha'));
        return $captcha->entry();
    }
}
