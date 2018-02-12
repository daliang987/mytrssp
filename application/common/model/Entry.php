<?php
namespace app\common\model;

use think\Model;
use think\Loader;
use \think\Validate;

class Entry extends Model{
    
    protected $table="sp_user";

    public function login($data){

        $validate=new Validate([
            'username'=>'require',
            'password'=>'require',
            'captcha'=>'require|captcha'
        ],[
            'username.require'=>'用户名不能为空',
            'password.require'=>'密码不能为空',
            'captcha.require'=>'验证码不能为空',
            'captcha.captcha'=>'验证码错误'
        ]);

        if(!$validate->check($data)){
            return ['valid'=>0,'msg'=>$validate->getError()];
        }

        $md5_password=md5($data['password']);

        $result=db('user')->where('username',$data['username'])->where('password',$md5_password)->find();

        if($result){
            session('session.username',$data['username']);
            session('session.userid',$result['uid']);
            session('session.subcom_id',$result['subcom_id']);
            session('session.user_level',$result['level']);
            return ['valid'=>1,'msg'=>'登录成功'];
        }else{
            return ['valid'=>0,'msg'=>'登录失败'];
        }

    }
}