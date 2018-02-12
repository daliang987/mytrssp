<?php
namespace app\common\controller;
use think\Controller;

class Common extends Controller{
    
    protected function _initialize(){
        parent::_initialize();
        if(!session('session.userid')){
            $this->redirect('index/index/login');
        }
    }
}