<?php
namespace app\common\controller;
use think\Controller;

class Admin extends Common{
    
    protected function _initialize(){
        parent::_initialize();
        if(session('session.user_level')==0){
            $this->error('您没有访问权限');
        }
    }
}