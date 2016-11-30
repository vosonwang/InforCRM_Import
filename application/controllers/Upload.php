<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller
{
    function index()
    {
        $this->load->view('header');
        $this->load->view('V_upload');
    }

    function process()
    {
        //初始化文件上传类，自动加载conifg中upload.php的配置
        $this->load->library('upload');


         // 判断当期目录下的 upload 目录是否存在该文件
        if (file_exists(FCPATH.'upload/' .$_FILES["file"]["name"])) {
           //若有，则删除现有文件
            unlink(FCPATH.'upload/'.$_FILES["file"]["name"]);
            //如果$_FILES["file"]["name"]换成$name就会提示没权限
        }

        //将文件上传到upload文件夹下
        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            echo(json_encode($error));
        } else {
            echo(json_encode('1'));
        }
    }







}