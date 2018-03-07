<?php
namespace app\common\model;
use think\Model;

class Arcvtype extends Model{
    protected $table="sp_arc_vtype";

    public function store($data){
        $result=$this->save($data);
        return $result;
    }
}