<?php
namespace app\common\validate;

use think\Validate;

class Article extends Validate{
    protected $rule=[
        'arc_title'=>'require',
        'arc_author'=>'require',
        'arc_content'=>'require',
    ];

    protected $message=[
        'arc_title.require'=>'文章标题不能为空',
        'arc_author.require'=>'文章作者不能为空',
        'arc_content.require'=>'文章内容不能为空',
    ];
}