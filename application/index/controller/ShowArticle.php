<?php
namespace app\index\controller;
// use app\common\controller\Common;
use think\Controller;

class ShowArticle extends Controller{
    public function index(){

        $catedata=db('cate')->where('cate_pid',2)->select();
        $this->assign('_cate',$catedata);

        if(input('param.arc_type')){
            // halt(input('param.arc_type'));
            $pub=db('article')->alias('a')->join('arc_vtype av','a.arc_id=av.arc_id','left')->where('av.tid',input('param.arc_type'))->field('a.arc_id,arc_title,create_time')->paginate(20);
        }else{
            $pub=db('article')->where('arc_type','2')->field('arc_id,arc_title,create_time')->paginate(20);
        }
        
        $this->assign('pub',$pub);

        return $this->fetch();
    }

    public function view(){
        $arc_id=input('param.id');
        $article=db('article')->where('arc_id',$arc_id)->find();
        $this->assign('article',$article);
        $arctype=$article['arc_type'];
        if($arctype=='3'){ //工具类文章禁止访问
            $this->error('无法浏览该文章');exit;
        }
        switch($arctype){
            case 1://公告
                $pdt_id=db('arc_pdt')->where('arc_id',$arc_id)->value('pdt_id');
                if($pdt_id){
                    $pdt_data=db('product')->where('pdt_id',$pdt_id)->select();
                    $this->assign('pdt_data',$pdt_data);
                }
                break;
            case 2://文章
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

    public function downattach(){
        $arc_id=input('param.id');
        $arcdata=db('article')->field('attach_name,attach_path,arc_type')->find($arc_id);
        // halt($arcdata['arc_type']);
        if($arcdata['arc_type']=='3'){ //工具类文章禁止访问
            $this->error('无法下载附件');exit;
        }
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
}