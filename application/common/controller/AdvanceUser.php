<?php
namespace app\common\controller;
use think\Controller;

class Auth extends Common{
    
    protected function _initialize(){
        parent::_initialize();
        if(session('session.user_level')<=2){
            $this->error('您没有访问权限');
        }
    }
}