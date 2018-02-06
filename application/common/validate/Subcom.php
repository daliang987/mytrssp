<?php

namespace app\common\validate;
use think\Validate;

class Subcom extends Validate{

    protected $rule=[
        'subcom_name'=>'require',
        'subcom_pid'=>'require|number',
    ];
    
    protected $message=[
        'subcom_name.require'=>'分公司名称必须填写',
        'subcom_pid.require'=>'所属公司不能为空',
        'subcom_pid.number'=>'所属公司必须为数字'
    ];
}