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

        $subcom_id=input('get.subcom_id')?input('get.subcom_id'):0;
        $pro_name=input('get.pro_name');

        $this->assign('_subcom',$subcom_id);
        $this->assign('_pro_name','');

        $pageParam=['query'=>[]];
        
        $pro=db('project')->alias('pro')
        ->join('product pdt','pro.pro_product_id=pdt.pdt_id','left')
        ->join('subcompany sub','sub.subcom_id=pro.pro_subcom_id','left')->order('pro.pro_id desc');
        
        //多级分类，subcom_id在为0（全部）或非0（有分类）的情况下都要获取，
        //非多级分类的话，可判断是否为0来控制where条件，详情漏洞Vul搜索功能

        $allids=(new \app\common\model\Subcom())->getSon($subcom_id);//获取子id集合
        $allids[]=$subcom_id;//集合中添加自己id
        $pro->whereIn('subcom_id',$allids);
        $pageParam['query']['subcom_id']=$subcom_id;
        $this->assign('_subcom',$subcom_id);

        if($pro_name){
            $pro->where('pro_name','like','%'.$pro_name.'%');
            $pageParam['query']['pro_name']=$pro_name;
            $this->assign('_pro_name',$pro_name);
        }

        $proData=$pro->paginate(10,false,$pageParam);

        $dataSubcom=(new \app\common\model\Subcom)->getAll();

        $this->assign('sub',$dataSubcom);       

        $this->assign('_project',$proData);

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


    public function statistics(){
         
        $subcom=db('project')->alias('p')->join('subcompany s','s.subcom_id=p.pro_subcom_id','left')->field('s.subcom_id,s.subcom_pid,s.subcom_name,count(*) as cc')->group('p.pro_subcom_id')->select();

        
        foreach($subcom as $i=>$com){ //遍历所有项目数据
            if($com['subcom_pid']=='0'){ //父公司 
                $com_name[$i]=$com['subcom_name'];  //获取名称
                $parentcom[$i]['name']=$com['subcom_name']; //将名称赋给parent变量，以后前端页面中需用到此变量

                $com_count[$i]=$com['cc']; //父公司的项目数量
                $sons=(new \app\common\model\Subcom)->getSon($com['subcom_id']);
                foreach($sons as $son){
                    $com_count[$i]+=$son['cc']; //获取父公司的所有子公司的项目数量的和。
                }
                $parentcom[$i]['count']=$com_count[$i]; //将数量赋给parent变量，以后前端页面中需用到此变量
            }
        }
        
        $this->assign('subcom',json_encode($com_name));
        $this->assign('count',json_encode($com_count));

        $this->assign('parentcom',$parentcom);

        return $this->fetch();
    }

    public function view(){
        $proid=input('param.id');
        $prodata=db('project')->alias('pro')->join('subcompany s','pro.pro_subcom_id=s.subcom_id','left')->join('product pdt','pdt.pdt_id=pro.pro_product_id','left')->find($proid);
        $this->assign('_pro',$prodata);
        return $this->fetch();
    }

}