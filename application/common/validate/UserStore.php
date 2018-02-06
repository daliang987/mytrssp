<?php

namespace app\common\validate;

use think\Validate;

class UserStore extends Validate{
    
    protected $rule=[
        'username'=>'require',
        'realname'=>'require',
        'password'=>'require',
        'repass'=>'require|confirm:password',
        'subcom_id'=>'require|number',
        'department'=>'require',
        'job'=>'require',
        'email'=>'require|email',
        'phone'=>'require|regex:/^1\d{10}$/',
        'level'=>'require|between:1,3',
    ];

    protected $message=[
        'username.require'=>'用户名必须填写',
        'password.require'=>'密码不能为空',
        'repass.require'=>'确认密码不能为空',
        'repass.confirm'=>'两次密码输入不一致',
        'realname.require'=>'真实用户必须填写',
        'sumcom_id.require'=>'请选择所属分公司',
        'subcom_id.number'=>'所属分公司格式不正确',
        'department.require'=>'部门必须填写',
        'job.require'=>'职位必须填写',
        'email.require'=>'邮箱必须填写',
        'email.email'=>'邮箱格式不正确',
        'phone.require'=>'电话必须填写',
        'phone.regex'=>'电话号码格式不正确',
        'level.require'=>'用户级别必须填写',
        'level.between'=>'用户格式不正确',
    ];
}