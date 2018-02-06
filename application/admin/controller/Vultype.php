<?php
namespace app\admin\controller;

use think\Controller;

class Vultype extends Controller{

    protected $db;

    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Vultype();
    }

    public function index(){

        $dataVtype=db('vultype')->paginate(5);
        $this->assign('vtype',$dataVtype);
        return $this->fetch();
    }


    public function store(){
        if(request()->isPost()){
            $res=$this->db->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }

    public function edit(){
        if(request()->isPost()){
            $res=$this->db->edit(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        $tid=input('param.tid');
        $oldtype=db('vultype')->find($tid);
        $this->assign('vtype',$oldtype);
        return $this->fetch();
    }

    public function del(){
        $tid=input('get.tid');
        $res=$this->db->del($tid);
        if($res['valid']){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }

}