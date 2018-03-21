<?php
namespace app\index\controller;
use app\common\controller\Common;

class Upload extends Common{

    public function upload(){
        $file = request()->file('file');
        $info = $file->validate(['size'=>5*1024*1024,'ext'=>'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads'.DS . 'img'.DS.date('Ymd').DS.session('session.username').DS.session_id());
        if($info){
            $json = ['valid' => 1, 'message' =>'/tp5/public/uploads/img/'.date('Ymd').'/'.session('session.username').'/'.session_id().'/'.$info->getSaveName()];
            
        }else{
            $json = ['valid' => 0, 'message' => $file->getError()];
        }

        die(json_encode($json));
    }
/*
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

*/
    public function filelist(){
        $files=glob(ROOT_PATH . 'public' . DS . 'uploads'.DS . 'img'.DS.date('Ymd').DS.session('session.username').DS.session_id().DS.'*');
        foreach ($files as $f) {
            $data[] = ['url' => '/tp5/public/uploads/img/'.date('Ymd').'/'.session('session.username').'/'.session_id().DS.'/'.basename($f), 'path' => '/tp5/public/uploads/img/'.date('Ymd').'/'.session('session.username').'/'.session_id().'/'.basename($f)];
        }

        $json = ['valid'=>1,'data' => $data,'page'=>[]];
        die(json_encode($json));
    }


}