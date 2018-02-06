<?php
namespace app\common\validate;
use think\Validate;
class Category extends Validate{
    
    protected $rule=[
        'cate_name'=>'require',
        'cate_pid'=>'require',
        'cate_sort'=>'require|number|between:1,99999'
    ];
    protected $message=[
        'cate_name.require'=>'栏目名称必须填写',
        'cate_pid.require'=>'所属栏目必须填写',
        'cate_sort.require'=>'栏目排序不能为空',
        'cate_sort.number'=>'栏目排序必须为数字',
        'cate_sort.between'=>'栏目排序必须在1-99999之间'
    ];
}