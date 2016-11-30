<?php

/**
 * Created by PhpStorm.
 * User: voson
 * Date: 2016/11/2
 * Time: 10:32
 */
class M_PLUGIN extends CI_Model
{
    //根据groupname查找groupId
    function getGroupId($GN){
        $this->db->where('NAME', $GN);
        $this->db->where('FAMILY', 'Account');
        $this->db->select('PLUGINID');
        $query = $this -> db -> get('Jrexpo.sysdba.PLUGIN');
        return $query -> result();
    }
}