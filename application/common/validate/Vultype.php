<?php

namespace app\common\validate;
use think\Validate;

class Vultype extends Validate{
    protected $rule=[
        't_first'=>'require',
        't_second'=>'require',
    ];

    protected $message=[
        't_first.require'=>'一级分类不能为空',
        't_second.require'=>'漏洞名称不能为空',
    ];
}