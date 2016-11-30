<?php

/**
 * Created by PhpStorm.
 * User: voson
 * Date: 2016/11/2
 * Time: 10:29
 */
class M_ACCOUNT extends CI_Model
{
    //根据AccountId修改AccountMangerId
    function changeAm($ACCID,$AMID){
        $this->db->set('ACCOUNTMANAGERID', $AMID);
        $this->db->where('ACCOUNTID', $ACCID);
        $this->db->update('Jrexpo.sysdba.ACCOUNT');
    }
}