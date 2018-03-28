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

        $pro_name=input('get.pro_name');

        $this->assign('_pro_name','');

        $pageParam=['query'=>[]];
        
        $pro=db('project')->alias('pro')
        ->join('product pdt','pro.pro_product_id=pdt.pdt_id','left')
        ->join('subcompany sub','sub.subcom_id=pro.pro_subcom_id','left')
        ->where('pro_subcom_id',session('session.subcom_id'))->order('pro.pro_id desc');
        
        //前台用户只能看见自己的区域的项目，所以不需要区域分类搜索。

        if($pro_name){

            $pro->where('pro_name','like','%'.$pro_name.'%');
            $pageParam['query']['pro_name']=$pro_name;
            // halt($pro_name);
            $this->assign('_pro_name',$pro_name);
        }

        $proData=$pro->paginate(2,false,$pageParam);

        $this->assign('_project',$proData);

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


    public function view(){
        $proid=input('param.id');
        $prodata=db('project')->alias('pro')
        ->join('subcompany s','pro.pro_subcom_id=s.subcom_id','left')
        ->join('product pdt','pdt.pdt_id=pro.pro_product_id','left')
        ->where('pro.pro_subcom_id',session('session.subcom_id'))->find($proid);
        $this->assign('_pro',$prodata);
        return $this->fetch();
    }
}