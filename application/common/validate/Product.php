<?php
namespace app\common\validate;
use think\Validate;

class Product extends Validate{
    
    protected $rule=[
        'pdt_name'=>'require',
        'pdt_version'=>'require'
    ];
    
    protected $message=[
        'pdt_name.require'=>'产品名称必须填写',
        'pdt_version.require'=>'产品版本必须填写'
    ];
}