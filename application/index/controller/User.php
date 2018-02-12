<?php

namespace app\index\controller;
use app\common\controller\Common;
use think\Controller;

class User extends Common{
    
    public function index(){
        return $this->fetch();
    }

    public function profile(){
        return $this->fetch();
    }


    public function pass(){
        return $this->fetch();
    }

}