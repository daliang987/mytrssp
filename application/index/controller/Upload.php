<?php
namespace app\index\controller;
use app\common\controller\Common;

class Upload extends Common{

    public function upload(){
        $file = request()->file('file');
        $username=session('session.username');
        $salt='trs@123.456';
        $info = $file->validate(['size'=>5*1024*1024,'ext'=>'jpg,png,gif'])->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads'.DS . 'img'.DS.$username.DS.substr(sha1($username.$salt),8,16));
        if($info){
            $json = ['valid' => 1, 'message' =>'/tp5/public/uploads/img/'.$username.'/'.substr(sha1($username.$salt),8,16).'/'.$info->getSaveName()];
            
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
        $username=session('session.username');
        $salt='trs@123.456';
        $files=glob(ROOT_PATH . 'public' . DS . 'uploads'.DS . 'img'.DS.DS.$username.DS.substr(sha1($username.$salt),8,16).DS.'*');
        foreach ($files as $f) {
            $data[] = ['url' => '/tp5/public/uploads/img/'.'/'.$username.'/'.substr(sha1($username.$salt),8,16).'/'.basename($f), 'path' => '/tp5/public/uploads/img/'.$username.'/'.substr(sha1($username.$salt),8,16).'/'.basename($f)];
        }

        $json = ['valid'=>1,'data' => $data,'page'=>[]];
        die(json_encode($json));
    }


}