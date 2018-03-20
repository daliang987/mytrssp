<?php

namespace app\common\validate;

use think\Validate;

class UserEdit extends Validate{
    
    protected $rule=[
        'realname'=>'require',
        'subcom_id'=>'require|number',
        'department'=>'require',
        'job'=>'require',
        'email'=>'require|email',
        'phone'=>'require|regex:/^1\d{10}$/',
        'level'=>'between:0,1',
    ];

    protected $message=[
        'realname.require'=>'真实用户必须填写',
        'sumcom_id.require'=>'请选择所属分公司',
        'subcom_id.number'=>'所属分公司格式不正确',
        'department.require'=>'部门必须填写',
        'job.require'=>'职位必须填写',
        'email.require'=>'邮箱必须填写',
        'email.email'=>'邮箱格式不正确',
        'phone.require'=>'电话必须填写',
        'phone.regex'=>'电话号码格式不正确',
        'level.between'=>'用户级别不正确',
    ];
}