<?php
namespace app\common\model;
use think\Model;

class Arcpdt extends Model{
    protected $table="sp_arc_pdt";

    public function store($data){
        $result=$this->save($data);
        return $result;
    }
}