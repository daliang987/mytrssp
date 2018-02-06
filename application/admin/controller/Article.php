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
    }

    public function pub(){

    }

    public function tool(){

    }


    public function del(){

    }

    
}