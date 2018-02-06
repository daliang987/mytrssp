<?php
namespace app\common\validate;
use think\Validate;

class Pass extends Validate{

    protected $rule=[
        'password'=>'require',
        'newpass'=>'require',
        'repass'=>'require|confirm:newpass',
    ];

    protected $message=[
        'password.require'=>'原密码不能为空',
        'newpass.require'=>'新密码不能为空',
        'repass.require'=>'确认密码不能为空',
        'repass.confirm'=>'两次密码输入不一致',
    ];
}