<?php
namespace app\admin\controller;

use think\Request;
use app\common\controller\Admin;

class Article extends Admin{

    protected $db;
    
    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Article();
    }

    public function index(){
        //搜索 search
        $arc_type    = input('get.arc_type');
        $arc_title    = input('get.arc_title');
        
        $pageParam    = ['query' =>[]];

        $Arc=db('article')->alias('a')->join('cate c','c.cate_id=a.arc_type','left')
        ->order('create_time desc');

        $this->assign('type',0);
        $this->assign('title','');
        
        if($arc_type){
            $Arc->where('a.arc_type',$arc_type);
            $this->assign('type',$arc_type);
            $pageParam['query']['arc_type']=$arc_type;
        }

        if($arc_title){
            $Arc->where('a.arc_title','like','%'.$arc_title.'%'); 
            $this->assign('title',$arc_title);
            $pageParam['query']['arc_title']=$arc_title;
        }

        $dataArc=$Arc->paginate(10,false,$pageParam);
        $this->assign('dataArc',$dataArc);
        
        $cate_data=(new \app\common\model\Category())->getAll();
        $this->assign('cate_data',$cate_data);


        $cateData=db('cate')->where('cate_pid','0')->select();
        $this->assign("_cates",$cateData);



        return $this->fetch();
    }


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
        $detail=input('post.arc_content','',null);
        $data=input('post.');
        $data['arc_content']=$detail;
        $data['arc_type']=$cate_id;
        $data['uesr_id']=session('session.userid');
        $file=request()->file('attachment');
        if($file){
            $data['attach_name']=$file->getInfo('name');
            $info	=	$file->validate(['size'=>5*1024*1024,'ext'=>'zip,rar,docx,doc,pdf'])->move(ROOT_PATH.'public'.DS.'uploads'.DS.'attach');
            if($info){
                $data['attach_path']=$info->getSaveName();
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
                $vdata=db('arc_vtype')->where('arc_id',$arc_id)->find();
                $this->assign('vdata',$vdata);
                break;
            default:
                $this->assign('pubdata',$pubdata);
                break;
        }
        if(request()->isPost()){
            $arc_id=input('param.arc_id');
            $detail=input('post.arc_content','',null);
            $data=input('post.');
            $data['arc_content']=$detail;
            $file=request()->file('attachment');
            if($file){
                $data['attach_name']=$file->getInfo('name');
                $arcdata=db('article')->find($arc_id);
                $filepath=ROOT_PATH.'public'.DS.'uploads'.DS.$arcdata['attach_path'];
                if(is_file($filepath)){
                    unlink($filepath);
                }
                
                $info	=	$file->validate(['size'=>5*1024*1024,'ext'=>'zip,rar,docx,doc,pdf'])->move(ROOT_PATH.'public'.DS.'uploads'.DS.'attach');
                if($info){
                    $data['attach_path']=$info->getSaveName();
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

    

    public function downattach(){
        $arc_id=input('param.id');
        $arcdata=db('article')->field('attach_name,attach_path')->find($arc_id);
        $attach_path=$arcdata['attach_path'];
        $attach_name=$arcdata['attach_name'];
        $filepath=ROOT_PATH.'public'.DS.'uploads'.DS.'attach'.DS.$attach_path;
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
    
    public function view(){
        $arc_id=input('param.id');
        $article=db('article')->where('arc_id',$arc_id)->find();
        $this->assign('article',$article);
        $arctype=$article['arc_type'];
        switch($arctype){
            case 1://公告
                $pdt_id=db('arc_pdt')->where('arc_id',$arc_id)->value('pdt_id');
                if($pdt_id){
                    $pdt_data=db('product')->where('pdt_id',$pdt_id)->select();
                    $this->assign('pdt_data',$pdt_data);
                }
                break;
            case 2:
                $tid=db('arc_vtype')->where('arc_id',$arc_id)->value('tid');
                if($tid){
                    $vultype_data=db('vultype')->where('tid',$tid)->select();
                    $this->assign('vultype',$vultype_data);
                }
                break;
            default:
                break;
                
        }
        return $this->fetch();
    }
}