<?php
namespace app\common\validate;
use think\Validate;
class Comment extends Validate{
    
    protected $rule=[
        'user_id'=>'require',
        'vul_id'=>'require|number',
        'comment_content'=>'require'
    ];
    protected $message=[
        'user_id.require'=>'评论用户为空',
        'vul_id.require'=>'漏洞id必须填写',
        'vul_id.number'=>'漏洞id必须为数字',
        'comment_content.require'=>'评论内容必须填写'
    ];
}