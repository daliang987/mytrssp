<?php

namespace app\admin\controller;
use app\common\controller\Admin;

class Vul extends Admin{

    public function index(){
        $vul_data=db('vul')->where('vul_userid',session('session.userid'))->order('create_time','desc')->field('vul_id,create_time,vul_title,vul_state,vul_level')->select();
        $this->assign('vuldata',$vul_data);
        return $this->fetch();
    }

    public function store(){
        $this->fetch();
    }

    public function view(){
        $vid=input('param.vid');
        
        $vul_data=db('vul')->where('vul_userid',session('session.userid'))->where('vul_id',$vid)->find();
        if($vul_data){
            $this->assign('vul_data',$vul_data);
            $pdt_name=db('product')->where('pdt_id',$vul_data['pdt_id'])->value('pdt_name');
            $this->assign('pdt_name',$pdt_name);
            
        }else{
            $this->error('无法获取该漏洞数据','index');
        }
        return $this->fetch();
    }

    public function downattach(){
        $vul_id=input('param.id');
        $vuldata=db('vul')->field('attach_name,attach_path')->where('vul_userid',session('session.userid'))->find($vul_id);
        $attach_path=$vuldata['attach_path'];
        $attach_name=$vuldata['attach_name'];
        $filepath=ROOT_PATH.'public'.DS.'uploads'.DS.$attach_path;
        if (is_file($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.($attach_name ?: basename($filepath)));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: '.filesize($filepath));
            readfile($filepath);
        }else{
            $this->error('无法获取该附件');exit;
        }
    }
}

