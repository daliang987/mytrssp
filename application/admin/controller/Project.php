<?php
namespace app\admin\controller;


use app\common\controller\Admin;

class Project extends Admin{

    protected $db;

    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Project();
    }

    public function index(){

        $pro_data=db('project')->alias('pro')
        ->join('product pdt','pro.pro_product_id=pdt.pdt_id','left')
        ->join('subcompany sub','sub.subcom_id=pro.pro_subcom_id','left')->paginate(10);
        $this->assign('_project',$pro_data);
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

        $subcomData=(new \app\common\model\Subcom)->getAll();
        $this->assign('_subcom',$subcomData);

        $pro_id=input('param.pro_id');
        $proData=db('project')->find($pro_id);
        $this->assign('_pro_data',$proData);

        $pdtData=db('product')->select();
        $this->assign('_pdt_data',$pdtData);

        return $this->fetch();
    }

    public function store(){
        return $this->fetch();
    }


    public function del(){
        $arc_id=input('get.arc_id');
        $arc_type=input('get.arc_type');

        

    }
}