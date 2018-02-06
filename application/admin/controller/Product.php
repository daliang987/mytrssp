<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;

class Product extends Controller{

    protected $db;

    protected function _initialize(){
        parent::_initialize();
        $this->db=new \app\common\model\Product();
    }

   /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $dataPdt=db('product')->paginate(5);
        $this->assign('dataPdt',$dataPdt);
        return $this->fetch();
    }

    public function store()
    {
        if(request()->isPost()){
            $data=input('post.');
            $res=$this->db->store($data);
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }

    
    public function read($id)
    {
        // echo $id;
        $dataPdt=db('product')->find($id);
        // halt($dataPdt);
        $this->assign('pdt',$dataPdt);
        return $this->fetch();
    }


   
    public function edit($pdt_id)
    {
        if(request()->isPost()){
            $data=input('post.');
            $res=$this->db->edit($data);
            
            if($res['valid']){
                $this->success($res['msg'],'index');exit;
            }else{
                $this->error($res['msg']);exit;
            }
        }


        $dataPdt=db('product')->find($pdt_id);
        // halt($dataPdt);
        if($dataPdt){
            $this->assign('dataPdt',$dataPdt);
            return $this->fetch();
        }else{
            $this->error('没有相关数据');exit;
        }
        
    }



    public function del()
    {
        $pdt_id=input('get.pdt_id');
        $res=$this->db->del($pdt_id);
        if($res['valid']){
            $this->success($res['msg'],'index');exit;
        }else{
            $this->error($res['msg']);exit;
        }
    }
}