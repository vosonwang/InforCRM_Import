<?php

/**
 * Created by PhpStorm.
 * User: voson
 * Date: 2016/9/29
 * Time: 14:22
 */
class M_USERINFO extends CI_Model
{
    function getAMList(){
        $this->db->where('userid', 'U6UJ9A000009');
        $this->db->or_where('userid >', 'U6UJ9A000009');
        $this->db->or_where('userid >', 'U6UJ9A00000J');
        $this->db->or_where('userid >', 'U6UJ9A00000K');
        $this->db->or_where('userid >', 'U6UJ9A00000L');
        $this->db->or_where('userid >', 'U6UJ9A00000M');
        $this->db->or_where('userid >', 'U6UJ9A00000T');
        $this->db->or_where('userid >', 'U6UJ9A00000U');
        $this->db->or_where('userid >', 'U6UJ9A00000V');
        $this->db->or_where('userid >', 'U6UJ9A00000W');
        $this->db->or_where('userid >', 'U6UJ9A00000X');
        $this->db->select('userid,username');
        $query = $this -> db -> get('Jrexpo.sysdba.userinfo');
        return $query -> result();
    }

    function getAMId($name){
        $this->db->where('username', $name);
        $this->db->select('userid');
        $query = $this -> db -> get('Jrexpo.sysdba.userinfo');
        return $query -> row();
    }

}