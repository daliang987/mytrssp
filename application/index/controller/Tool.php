<?php

namespace app\index\controller;

use think\Controller;
use app\common\controller\AdvanceUser;

class Tool extends AdvanceUser{
    
    public function tool(){
        return $this->fetch();
    }

    public function scan(){
        return $this->fetch();
    }

    
}