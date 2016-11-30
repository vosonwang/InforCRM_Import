<?php

/**
 * Created by PhpStorm.
 * User: voson
 * Date: 2016/11/2
 * Time: 11:02
 */
class M_ADHOCGROUP extends CI_Model
{
    //根据groupId查找组下面所有的AccountId
    function getAccId($GID){
        $this->db->where('GROUPID', $GID);
        $this->db->select('ENTITYID');
        $query = $this -> db -> get('Jrexpo.sysdba.ADHOCGROUP');
        return $query -> result();
    }
}