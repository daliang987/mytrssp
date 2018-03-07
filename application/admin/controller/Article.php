<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

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
        $this->assign("_cates",$cateData);

        return $this->fetch();
    }

    // public function store(){

    //     if(request()->isPost()){
    //         $res=$this->db->store(input('post.'));
    //         if($res['valid']){
    //             $this->success($res['msg'],'index');exit;
    //         }else{
    //             $this->error($res['msg']);exit;
    //         }
    //     }

    //     $product=db('product')->disctinct(true)->field('true')->select();
    //     $this->assign('cate_data',$product);

        
    //     return $this->fetch();
    // }


    public function article(){

        $detail_type=db('vultype')->distinct(true)->field('tid,t_second')->select();
        $this->assign('_tag',$detail_type);

        $curr_cate=db('cate')->find(input('param.cate_id'));
        $this->assign('curr_cate',$curr_cate['cate_name']);

        $productData=db('product')->select();
        $this->assign('_product',$productData);

        //获取文章子类
        $parent_arc=db('cate')->where('cate_name','文章')->find();
        $mycate=new \app\common\model\Category();
        $arcCate=$mycate->getSon(db('cate')->select(),$parent_arc['cate_id']);
        $arcSonCate=db('cate')->whereIn('cate_id',$arcCate)->select();
        $this->assign("arc_cate",$arcSonCate);

        return $this->fetch();
    }

    public function arcsave(){
        $cate_id=input('param.cate_id');
        $data=input('post.');
        $data['arc_type']=$cate_id;
        $file=request()->file('attachment');
        if($file){
            $info	=	$file->move(ROOT_PATH.'public'.DS.'uploads');
            if($info){
                $data['attach_path']=$info->getSaveName();
                $data['attach_name']=$info->getFilename();
            }else{
                echo	$file->getError();
            }
        }
              
        $res=$this->db->store($data);
        
        if($res['valid']){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }


    public function edit(){
        $arc_id=input('param.arc_id');
        $arc_type=input('param.arc_type');
        $curr_cate=db('cate')->find($arc_type);
        $this->assign('curr_cate',$curr_cate['cate_name']);
        $pubdata=db('article')->find($arc_id);
        switch($arc_type){
            case 1: //获取公告
                $productData=db('product')->select();
                $this->assign('_product',$productData);
                $pubpdt=db('arc_pdt')->find($arc_id);

                $this->assign('pubdata',$pubdata);
                $this->assign('pubpdt',$pubpdt);
                break;

            case 2:
                //获取文章子类
                $parent_arc=db('cate')->where('cate_name','文章')->find();
                $mycate=new \app\common\model\Category();
                $arcCate=$mycate->getSon(db('cate')->select(),$parent_arc['cate_id']);
                $arcSonCate=db('cate')->whereIn('cate_id',$arcCate)->select();
                $this->assign("arc_cate",$arcSonCate);
                $this->assign('pubdata',$pubdata);
                $detail_type=db('vultype')->distinct(true)->field('tid,t_second')->select();
                $this->assign('_tag',$detail_type);
                $vdata=db('arc_vtype')->find($arc_id);
                $this->assign('vdata',$vdata);
                break;
            default:
                $this->assign('pubdata',$pubdata);
                break;
        }
        if(request()->isPost()){
            $arc_id=input('param.arc_id');
            $data=input('post.');
            $file=request()->file('attachment');
            if($file){
                $arcdata=db('article')->find($arc_id);
                $filepath=ROOT_PATH.'public'.DS.'uploads'.DS.$arcdata['attach_path'];
                if(is_file($filepath)){
                    unlink($filepath);
                }
                
                $info	=	$file->move(ROOT_PATH.'public'.DS.'uploads');
                if($info){
                    $data['attach_path']=$info->getSaveName();
                    $data['attach_name']=$info->getFilename();
                }else{
                    echo $file->getError();
                }
            }
            $res=$this->db->edit($data);
        
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }

        return $this->fetch();
    }



    public function attach(){ //附件下载
        
    }

    public function del(){ 
        $arc_id=input('get.arc_id');
        $arc_type=input('get.arc_type');
        
        $res=$this->db->del($arc_id,$arc_type);
        if($res['valid']){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }

    
}