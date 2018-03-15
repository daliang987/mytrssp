<?php
namespace app\admin\controller;
use app\common\controller\Admin;

class Scan extends Admin{

    public function scan(){

        return $this->fetch();
    }

}
