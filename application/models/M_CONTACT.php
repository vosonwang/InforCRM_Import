<?php

/**
 * Created by PhpStorm.
 * User: voson
 * Date: 2016/11/28
 * Time: 15:49
 */
class M_CONTACT extends CI_Model
{
    function insert($data){
        $this->db-$this->insert('Jrexpo.sysdba.CONTACT',$data);
    }
}