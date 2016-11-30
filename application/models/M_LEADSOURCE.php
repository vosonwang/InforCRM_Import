<?php

/**
 * Created by PhpStorm.
 * User: voson
 * Date: 2016/11/3
 * Time: 11:09
 */
class M_LEADSOURCE extends CI_Model
{
    function getLSId($DES){
        $this->db->where('DESCRIPTION', $DES);
        $this->db->select('LEADSOURCEID');
        $query = $this -> db -> get('Jrexpo.sysdba.LEADSOURCE');
        return $query -> row();
    }
}