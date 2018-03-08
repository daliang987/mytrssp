<?php
namespace app\index\controller;
use think\Controller;

class Upload extends Controller{

    public function upload(){
        $file = request()->file('file');
        $info = $file->validate(['size'=>5*1024*1024,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads'.DS . 'img');
        if($info){
            $json = ['valid' => 1, 'message' =>'/tp5/public/uploads/img/'.$info->getSaveName()];
            
        }else{
            $json = ['valid' => 0, 'message' => $file->getError()];
        }

        die(json_encode($json));
    }

    public function uploadAttach(){
        $file = request()->file('attachment');
        $info = $file->validate(['size'=>15678,'ext'=>'zip,pdf,doc,docx'])->move(ROOT_PATH . 'public' . DS . 'uploads'.DS . 'attachment');
        if($info){
            $json = ['valid' => 1, 'message' => $info->getSaveName()];
        }else{
            $json = ['valid' => 0, 'message' => $file->getError()];
        }

        die(json_encode($json));
    }

    public function filelist(){
        $files=glob(ROOT_PATH . 'public' . DS . 'uploads'.DS . 'img'.DS.date('Ymd').DS.'*');
        foreach ($files as $f) {
            $data[] = ['url' => '/tp5/public/uploads/img/'.date('Ymd').'/'.basename($f), 'path' => '/tp5/public/uploads/img/'.date('Ymd').'/'.basename($f)];
        }

        $json = ['valid'=>1,'data' => $data,'page'=>[]];
        die(json_encode($json));
    }


}