<?php
namespace app\admin\controller;

use think\Controller;

class Subcom extends Controller{

    protected $db;

    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Subcom();
    }

    public function index(){

        if(request()->isPost()){
            $search=input('post.sub_search');
            $dataSubcom=$this->db->searchAll($search);

            $this->assign("dataSubcom",$dataSubcom);
            return $this->fetch();
        }

        $dataSubcom=$this->db->getAll();
        $this->assign("dataSubcom",$dataSubcom);
        return $this->fetch();
    }


    public function store(){

        if(request()->isPost()){
            // halt(input('post.'));
            $res=$this->db->store(input('post.'));
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        $comTree=$this->db->getAll();
        $this->assign("subtree",$comTree);
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

        $subcom_id=input('param.subcom_id');
        $oldSub=db('subcompany')->find($subcom_id);
        $this->assign('oldSub',$oldSub);


        $comTree=$this->db->removeSon($subcom_id);
        $this->assign("subtree",$comTree);

        return $this->fetch();
    }


    public function del(){
        $subcom_id=input('get.subcom_id');
        $res=$this->db->del($subcom_id);
        if($res['valid']){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }

}