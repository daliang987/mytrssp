<?php
namespace app\index\controller;
use think\Controller;

class Fix extends Controller{
    public function index(){
        return $this->fetch();
    }
}