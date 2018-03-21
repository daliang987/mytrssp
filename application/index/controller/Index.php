<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\captcha\Captcha;
use think\Session;
use think\Cookie;

class Index extends Controller
{

    protected $db;

    protected function _initialize(){
        $db=new \app\common\model\User();
    }

    public function index()
    {
        $pub=db('article')->where('arc_type','1')->field('arc_id,arc_title,create_time')->order('create_time desc')->limit(5)->select();
        $this->assign('_pub',$pub);
        $article=db('article')->where('arc_type','2')->field('arc_id,arc_title,create_time')->order('create_time desc')->limit(5)->select();
        $this->assign('_article',$article);
        return $this->fetch();
    }


    public function login(){

        if(request()->isPost()){
            $data=input('post.');
            $res=(new \app\common\model\Entry())->login($data);
            if($res['valid']){
                if(session('session.user_level')!=1){
                    $this->success($res['msg'],'index/project/index');
                }else{
                    $this->success($res['msg'],'admin/vul/index');
                }
            }else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }

    public function captcha(){
        $config	=[
            'codeSet'=>'0123456789',
            // 'fontSize'=>14,
            'useCurve'=>false,
            'length'=>4,
            // 'imageH'=>30,
            'reset'=>true,
            'useNoise'=>false,
        ];
        $captcha	=	new	Captcha($config);
        return	$captcha->entry();
    }

    public function logout(){
        Cookie::clear();
        Session::clear();
        $this->redirect('index');
    }
}
