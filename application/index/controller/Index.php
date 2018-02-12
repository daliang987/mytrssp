<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use think\captcha\Captcha;
use think\Session;

class Index extends Controller
{

    protected $db;

    protected function _initialize(){
        $db=new \app\common\model\User();
    }

    public function index()
    {
        return $this->fetch();
    }


    public function login(){

        if(request()->isPost()){
            $data=input('post.');
            $res=(new \app\common\model\Entry())->login($data);
            if($res['valid']){
                if(session('session.level')>=2){
                    $this->success($res['msg'],'index/project/index');
                }else{
                    $this->success($res['msg'],'admin/project/index');
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
            'fontSize'=>25,
            // 'useCurve'=>true,
            'length'=>3,
            'reset'=>true,
            'useNoise'=>false,
        ];
        $captcha	=	new	Captcha($config);
        return	$captcha->entry();
    }

    public function logout(){
        Session::clear();
        $this->redirect('index');
    }
}
