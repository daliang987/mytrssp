<?php

namespace app\index\controller;

use app\common\controller\Common;

class Tool extends Common{

    public function tool(){
        $tool=db('article')->where('arc_type','3')->field('arc_id,arc_title,create_time')->paginate(10);
        $this->assign('tool',$tool);

        return $this->fetch();
    }


    public function view(){
        $arc_id=input('param.id');
        $tool=db('article')->find($arc_id);
        $this->assign('tdata',$tool);
        return $this->fetch();
    }

    public function scan(){
        return $this->fetch();
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
    
}