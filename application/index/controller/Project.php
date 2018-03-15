<?php
namespace app\index\controller;
use think\Controller;
use app\common\controller\Common;

class Project extends Common{

    protected $db;

    public function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Project();
    }

    public function index(){
        $dataSubcom=(new \app\common\model\Subcom)->getAll();
        $this->assign('sub',$dataSubcom);
        $pro_data=db('project')->alias('pro')->join('product pdt','pro.pro_product_id=pdt.pdt_id','left')->where('pro_subcom_id',session('session.subcom_id'))->paginate(10);

        if(request()->isPost()){
            $allids=(new \app\common\model\Subcom())->getSon(input('post.subcom_id'));//获取子id集合
            $allids[]=input('post.subcom_id');//集合中添加自己id
            if(input('post.pro_name')){
                $pro_data=db('project')->alias('pro')->join('product pdt','pro.pro_product_id=pdt.pdt_id','left')
                ->join('subcompany sub','sub.subcom_id=pro.pro_subcom_id','left')
                ->whereIn('subcom_id',$allids)->where('pro_name','like','%'.input('post.pro_name').'%')
                ->where('pro_subcom_id',session('session.subcom_id'))
                ->paginate(10);
            }
        }

        $this->assign('_project',$pro_data);
        return $this->fetch();
    }

    public function store(){

        if(request()->isPost()){
            $data=input('post.');

            $data['pro_subcom_id']=session('session.subcom_id');
            $res=$this->db->store($data);
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        $pdt_data=db('product')->select();
        $this->assign('_pdt_data',$pdt_data);
        return $this->fetch();
    }

    public function edit(){

        if(request()->isPost()){
            $proData=db('project')->where('pro_subcom_id',session('session.subcom_id'))->find(input('post.pro_id'));
            if($proData){
                $res=$this->db->edit(input('post.'));
                if($res['valid']){
                    $this->success($res['msg'],'index');exit;
                }else{
                    $this->error($res['msg']);exit;
                }
            }else{
                $this->error('您没有权限编辑该项目');
            }
        }

        $subcomData=(new \app\common\model\Subcom)->getAll();
        $this->assign('_subcom',$subcomData);

        $pro_id=input('param.pro_id');
        $proData=db('project')->where('pro_subcom_id',session('session.subcom_id'))->find($pro_id);
        if($proData){
            $this->assign('_pro_data',$proData);
        }else{
            $this->error('您没有权限编辑该项目');
        }

        $pdtData=db('product')->select();
        $this->assign('_pdt_data',$pdtData);

        return $this->fetch();
    }
}