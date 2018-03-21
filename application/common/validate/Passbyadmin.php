<?php
namespace app\common\validate;
use think\Validate;

class Passbyadmin extends Validate{

    protected $rule=[
        'newpass'=>'require',
        'repass'=>'require|confirm:newpass',
    ];

    protected $message=[
        'newpass.require'=>'新密码不能为空',
        'repass.require'=>'确认密码不能为空',
        'repass.confirm'=>'两次密码输入不一致',
    ];
}