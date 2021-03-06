<?php

namespace app\common\model;

use think\Model;
use think\Loader;

class User extends Model
{
    protected $pk="uid";
    protected $table="sp_user";


    public function setPasswordAttr($value){
        return md5($value);
    }

    public function store($data){

        $user=db('user')->where('username',$data['username'])->find();
        if($user){
            return ['valid'=>0,'msg'=>'用户名已存在'];
        }

        $result=$this->validate('User.add')->allowField(true)->save($data);
        if($result){
            return ['valid'=>1,'msg'=>'添加用户成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }

    }


    public function edit($data){
        $result=$this->validate('User.edit')->save($data,[$this->pk=>$data['uid']]);
        // halt($result);
        if($result){
            return ['valid'=>1,'msg'=>'修改用户资料成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function passbyadmin($data){

        $user=db('user')->where('uid',$data['uid'])->find();
        if($user){
            $validate	=	new	\app\common\validate\User();
            $dataval	=	$validate->scene('password')->check($data);
            if($dataval){
                $result=$this->save(['password'=>$data['password']],[$this->pk=>$data['uid']]);
                if($result){
                    return ['valid'=>1,'msg'=>'密码修改成功'];
                }else{
                    return ['valid'=>0,'msg'=>$this->getError()];
                }
            }else{
                return ['valid'=>0,'msg'=>$validate->getError()];
            }
        }else{
            return ['valid'=>0,'msg'=>'不存在该用户'];
        }
    }

    public function pass($data){
        $oldpass=$data['old_password'];
        $user=db('user')->where('uid',$data['uid'])->find();
        if($user){
            if($user['password']==md5($oldpass)){
                $validate	=	new	\app\common\validate\User();
                $dataval	=	$validate->scene('password')->check($data);
                if($dataval){
                    $result=$this->save(['password'=>$data['password']],[$this->pk=>$data['uid']]);
                    if($result){
                        return ['valid'=>1,'msg'=>'密码修改成功'];
                    }else{
                        return ['valid'=>0,'msg'=>$this->getError()];
                    }
                }else{
                    return ['valid'=>0,'msg'=>$validate->getError()];
                }
            }else{
                return ['valid'=>0,'msg'=>'原密码不正确'];
            }
        }else{
            return ['valid'=>0,'msg'=>'不存在该用户'];
        }
    }

    public function del($uid){
        $result=User::destroy($uid);
        if($result){
            return ['valid'=>1,'msg'=>'删除用户成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }

    public function modifyhead($headimg,$user){
        $result=$this->save(['headimg'=>$headimg],['username'=>$user]);
        if($result){
            return ['valid'=>1,'msg'=>'用户头像成功'];
        }else{
            return ['valid'=>0,'msg'=>$this->getError()];
        }
    }


    public function view(){
        $username=
        $vulstate=db('vul')->field('count(*) as cc,vul_state')->group('vul_state')->where('vul_userid',session('session.userid'))->select();
        $this->assign('vstate',$vulstate);
        $sum=0;
        foreach($vulstate as $c){
            $sum+=$c['cc'];
        }
        $this->assign('sum',$sum);

        $info=db('user')->alias('u')->join('subcompany s','s.subcom_id=u.subcom_id','left')->where('uid',session('session.userid'))->find();
        $this->assign('userinfo',$info);
    }

}
