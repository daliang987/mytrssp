<?php

namespace app\common\validate;

use think\Validate;

class User extends Validate{
    
    protected $rule=[
        'username'=>'require|unique:user|min:4',
        'realname'=>'require|chs',
        'password'=>'require|min:6',
        'repass'=>'require|confirm:password|min:6',
        'subcom_id'=>'require|number',
        'department'=>'require',
        'job'=>'require',
        'email'=>'require|email',
        'phone'=>'require|regex:/^1\d{10}$/',
        'level'=>'require|between:0,1',
    ];

    protected $message=[
        'username.require'=>'用户名必须填写',
        'username.unique'=>'用户名已存在',
        'username.min'=>'用户名最小长度不小于4位',
        'password.require'=>'密码不能为空',
        'password.min'=>'密码最小长度不小于6位',
        'repass.require'=>'确认密码不能为空',
        'repass.confirm'=>'两次密码输入不一致',
        'repass.min'=>'密码最小长度不小于6位',
        'realname.require'=>'真实用户必须填写',
        'realname.chs'=>'真实姓名必须为汉字',
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

    protected $scene=[
        'password'=>['password','repass'],
        'add'=>['username','realname','password','repass','subcom_id','department','job','email','phone','level'],
        'edit'=>['realname','department','job','email','phone'],
    ];
}