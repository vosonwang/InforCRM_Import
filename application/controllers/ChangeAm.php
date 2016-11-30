<?php defined('BASEPATH') OR exit('No direct script access allowed');
class ChangeAm extends CI_Controller {
    public  function  index(){
        $this -> load -> view('header');
        $this -> load -> view('V_ChangeAm');
    }

    public function change(){
        try{
            $json=$this->input->post(null,true);

            //获取groupId
            $this -> load -> model('M_PLUGIN');
            $GID=$this->M_PLUGIN->getGroupId($json['json']['GroupName']);

            //获取AccountId
            $this -> load -> model('M_ADHOCGROUP');
            $ACCID=$this->M_ADHOCGROUP->getAccId($GID[0]->PLUGINID);

            //修改AccountMangerId
            $this -> load -> model('M_ACCOUNT');
            foreach ($ACCID as $item){
                $this->M_ACCOUNT->changeAm($item->ENTITYID,$json['json']['ACCOUNTMANAGERID']);
            }

            echo "Success!";

        }catch(Exception $e){
            echo $e->getMessage();
        }

    }
}