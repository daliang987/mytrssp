<?php

namespace app\index\controller;

use think\Controller;

class Vul extends Controller{


    public function index(){
        return $this->fetch();
    }

    public function vul(){
        return $this->fetch();
    }

    public function event(){
        return $this->fetch();
    }

    public function draft(){
        return $this->fetch();
    }
    
}