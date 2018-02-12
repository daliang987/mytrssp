<?php
namespace app\admin\controller;

use think\Controller;

class Article extends Controller{

    protected $db;
    
    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Article();
    }

    public function index(){

        $cate_data=(new \app\common\model\Category())->getAll();
        $this->assign('cate_data',$cate_data);

        $dataArc=$this->db->getAll();
        $this->assign('dataArc',$dataArc);

        $cateData=db('cate')->where('cate_pid','0')->select();
        $this->assign("_cate",$cate_data);

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

        $product=db('product')->disctinct(true)->field('true')->select();
        $this->assign('cate_data',$product);

        
        return $this->fetch();
    }


    public function article(){
        $detail_type=db('vultype')->distinct(true)->field('tid,t_second')->select();
        $this->assign('_tag',$detail_type);

        $curr_cate=db('cate')->find(input('param.cate_id'));
        $this->assign('curr_cate',$curr_cate['cate_name']);

        $productData=db('product')->distinct(true)->field('pdt_name')->select();
        $this->assign('_product',$productData);

        //获取文章子类
        $parent_arc=db('cate')->where('cate_name','文章')->find();
        $arcCate=(new \app\common\model\Category())->getSon(db('cate'),$parent_arc['cate_pid']);
        $this->assign("arc_cate",$arcCate);

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

    public function pub(){
        return $this->fetch();
    }

    public function tool(){
        return $this->fetch();

    }


    public function del(){

    }

    
}