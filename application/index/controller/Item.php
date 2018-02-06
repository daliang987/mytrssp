<?php
namespace app\index\controller;
use think\Controller;

class Item extends Controller{
    public function index(){
        return $this->fetch();
    }

    public function store(){
        return $this->fetch();
    }
}