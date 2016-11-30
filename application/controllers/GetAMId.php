<?php defined('BASEPATH') OR exit('No direct script access allowed');
class GetAMId extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this -> load -> model('M_USERINFO');
    }
    public  function  index(){
        $dates=$this->M_USERINFO->getAMList();
        echo json_encode($dates);
    }
}