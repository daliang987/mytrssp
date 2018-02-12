<?php

namespace app\index\controller;

use think\Controller;
use app\common\controller\Common;

class Vul extends Common{


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