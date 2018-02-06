<?php

namespace app\index\controller;

use think\Controller;

class Tool extends Controller{
    
    public function tool(){
        return $this->fetch();
    }

    public function scan(){
        return $this->fetch();
    }

    
}