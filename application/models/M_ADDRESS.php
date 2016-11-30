<?php

/**
 * Created by PhpStorm.
 * User: voson
 * Date: 2016/11/28
 * Time: 16:06
 */
class M_ADDRESS extends CI_Model
{
    function insert($data){
        $this->db-$this->insert('Jrexpo.sysdba.ADDRESS',$data);
    }
}