<?php

namespace app\common\validate;
use think\Validate;

class Project extends Validate{

    protected $rule=[
        'pro_name'=>'require',
        'pro_locate_province'=>'require',
        'pro_locate_city'=>'require',
        'pro_locate_district'=>'require',
        'pro_product_id'=>'require|number',
        'pro_subcom_id'=>'require|number',
        'pro_level'=>'require',
        'pro_net_type'=>'require',
        'pro_url'=>'require|url',
    ];

    protected $message=[
        'pro_name.require'=>'项目名称必须填写',
        'pro_locate_province.require'=>'所在地省份不能为空',
        'pro_locate_city.require'=>'所在地城市不能为空',
        'pro_locate_district.require'=>'所在地区县不能为空',
        'pro_product_id.require'=>'所属产品不能为空',
        'pro_product_id.number'=>'所属产品必须为整数',
        'pro_subcom_id.require'=>'所属分公司不能为空',
        'pro_subcom_id.number'=>'所属分公司必须为整数',
        'pro_level.require'=>'项目性质不能为空',
        'pro_net_type.require'=>'项目网络类型不能为空',
        'pro_url.require'=>'项目地址不能为空',
        'pro_url.url'=>'项目地址格式不正确',
    ];
}