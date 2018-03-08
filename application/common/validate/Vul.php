<?php
namespace app\common\validate;

use think\Validate;

class Vul extends Validate{
    protected $rule=[
        'pro_name'=>'require',
        'vul_title'=>'require',
        'pdt_id'=>'require|number|notIn:0',
        'vultype_id'=>'require|number|notIn:0',
        'vul_level'=>'require|in:高危,中危,低危',
        'vul_desc'=>'require|min:10',
        'vul_url'=>'url',
        'vul_detail'=>'require|length:10,65535',
    ];

    protected $message=[
        'pro_name.require'=>'项目名称不能为空',
        'vul_title.require'=>'漏洞标题不能为空',
        'pdt_id.require'=>'产品类别不能为空',
        'pdt_id.number'=>'产品类别必须为数字',
        'pdt_id.notIn'=>'产品类别不能为0',
        'vultype_id.require'=>'漏洞类型必须填写',
        'vultype_id.number'=>'漏洞类型必须为数字',
        'vultype_id.notIn'=>'漏洞类型不能为0',
        'vul_level.require'=>'漏洞等级必须填写',
        'vul_level.in'=>'漏洞等级必须为高危，中危，低危',
        'vul_desc.require'=>'漏洞描述不能为空',
        'vul_desc.min'=>'漏洞描述不得小于10个字',
        'vul_url.url'=>'漏洞地址必须为正确的url地址',
        'vul_detail.require'=>'漏洞详情不能为空',
        'vul_detail.length'=>'漏洞详情必须大于10个字',
        
    ];
}