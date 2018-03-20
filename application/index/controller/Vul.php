<?php

namespace app\index\controller;

use think\Controller;
use app\common\controller\Common;

class Vul extends Common{

    protected $db;

    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Vul();
    }

    public function index(){
        $vul_data=db('vul')->where('vul_userid',session('session.userid'))->order('create_time','desc')->field('vul_id,create_time,vul_title,vul_state,vul_level')->select();
        
        $pdt_data=db('product')->select();
        $this->assign('pdt',$pdt_data);
         
        if(request()->isPost()){
            $search=input('post.');

            if($search['vul_state']=='全部'){
                if($search['pdt_id']=='0'){
                    $vul_data=db('vul')->where('vul_userid',session('session.userid'))->order('create_time','desc')->where('vul_title','like','%'.$search['vul_title'].'%')->paginate(10);
                }else{
                    $vul_data=db('vul')->where('vul_userid',session('session.userid'))->order('create_time','desc')->where('pdt_id',$search['pdt_id'])->where('vul_title','like','%'.$search['vul_title'].'%')->paginate(10);
                }
            }else{
                if($search['pdt_id']=='0'){
                    $vul_data=db('vul')->where('vul_userid',session('session.userid'))->order('create_time','desc')->where('vul_state',$search['vul_state'])->where('vul_title','like','%'.$search['vul_title'].'%')->paginate(10);
                }else{
                    $vul_data=db('vul')->where('vul_userid',session('session.userid'))->order('create_time','desc')->where('vul_state',$search['vul_state'])->where('pdt_id',$search['pdt_id'])->where('vul_title','like','%'.$search['vul_title'].'%')->paginate(10);
                }
            }
        }

        $this->assign('vuldata',$vul_data);
        return $this->fetch();
    }

    public function vul(){

        $pdt_data=db('product')->select();
        $this->assign('_pdt',$pdt_data);
        
        $type_first=db('vultype')->distinct(true)->field('t_first')->select();
        $this->assign('type_first',$type_first);

        if(request()->isPost()){
            $data=input('post.');
            $file=request()->file("attach");
            if($file){
                $data['attach_name']=$file->getinfo('name');
                $info	=	$file->validate(['size'=>5*1024*1024,'ext'=>'zip,rar,docx,doc,pdf'])->move(ROOT_PATH.'public'.DS.'uploads');
                if($info){
                    if($info){
                        $data['attach_path']=$info->getSaveName();
                        
                    }else{
                        echo	$file->getError();
                    }
                }
            }
            $data['vul_userid']=session('session.userid');
            $data['vul_state']='已提交';
            $res=$this->db->store($data);
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        return $this->fetch();
    }

    public function getsecond(){
        $first=input('get.first');
        $type_second=db('vultype')->where('t_first',$first)->field('tid,t_second')->select();
        return json_encode($type_second);
    }

    public function view(){
        $vid=input('param.vid');
        $vul_data=db('vul')->where('vul_userid',session('session.userid'))->where('vul_id',$vid)->find();
        if($vul_data){
            $this->assign('vul_data',$vul_data);
            $pdt_name=db('product')->where('pdt_id',$vul_data['pdt_id'])->value('pdt_name');
            $this->assign('pdt_name',$pdt_name); 
            $comment_data=db('comment')->alias('c')->join('user u','c.user_id=u.uid','left')->where('vul_id',$vid)->field('u.username,u.headimg,c.comment_content,c.create_time')->paginate(10);
            $this->assign('_comment',$comment_data);
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

    public function addcomment(){
        if(request()->isPost()){
            $data=input('post.');
            $data['user_id']=session('session.userid');
            $res=(new \app\common\model\Comment())->store($data);
            if($res['valid']){
                $this->success($res['msg']);exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
    }


    public function edit(){
        if(request()->isPost()){
            $data=input('post.');
            $curr_vul=db('vul')->where('vul_userid',session('session.userid'))->where('vul_id',$data['vid'])->find();
            if($curr_vul){
                $res=$this->db->edit($data);
                if($res['valid']){
                    $this->success($res['msg']);exit;
                }else{
                    $this->error($res['msg']);exit;
                }
            }else{
                $this->error('无法修改漏洞状态');exit;
            }
        }
    }
    
}