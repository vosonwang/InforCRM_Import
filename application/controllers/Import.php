<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /*载入自定义辅助函数*/
        $this->load->helper('Common');

    }

    function index()
    {
        $this->load->view('header');
        $this->load->view('V_import');
    }

    function getData()
    {
        //获取前台post数据
        $ajaxdata = $this->input->post(null, true);
        $AccountId = explode(',', json_decode($ajaxdata['AccountId']));
        $ContactId = explode(',', json_decode($ajaxdata['ContactId']));
        $AddressId = explode(',', json_decode($ajaxdata['AddressId']));
        $ConAddressId = explode(',', json_decode($ajaxdata['ConAddressId']));
        $Code = explode(',', $ajaxdata['code']);


        /*if ($Code != 'jn@2016') {
            //安全码错误
            echo (1001);
            exit();
        }*/


        //从cookie获取文件名
        $filename = $this->input->cookie('filename', true);
        $path = FCPATH . 'upload/' . $filename;

        if (file_exists($path)) {
            /*如果文件存在*/
            /*读取Excel文件中的数据*/
            $data = readExel($path, $filename);

            /*载入时间辅助函数*/
            $this->load->helper('date');

            /*载入模型*/
            $this->load->model("M_USERINFO");
            $this->load->model("M_LEADSOURCE");

            /*用于判断是否公司已写入*/
            $a = new stdClass();
            $i = 0;

            try {
                foreach ($data as $item) {

                    if (isset($item['AM']) && isset($item['Lead Source'])) {

                        $AMId = $this->M_USERINFO->getAmId($item['AM']);
                        $LSId = $this->M_LEADSOURCE->getLSId($item['Lead Source']);
                        $AMId = $AMId->userid;
                        $LSId = $LSId->LEADSOURCEID;


                        if(isset($item['Company Name']) ){
                            //如果这个公司的公司信息已经创建
                            if (isset($a->$item['Company Name']) ) {

                                //开启事务
                                $this->db->trans_start();

                                //插入联系人地址
                                $this->db->query("insert into Jrexpo.sysdba.ADDRESS (ADDRESSID,ENTITYID,ADDRESS1,ADDRESS2,COUNTY,CITY,STATE,POSTALCODE,COUNTRY,CREATEDATE,CREATEUSER) values ('" . $ConAddressId[$i]. "','" . $ContactId[$i] . "',N'" . $item['Address 1'] . "',N'" . $item['Address 2'] . "',N'" . $item['District / Area'] . "',N'" . $item['City'] . "',N'" . $item['Province / State'] . "','" . $item['Zip'] . "','" . $item['Country'] . "','" . unix_to_human(now()) . "','ADMIN')");


                                //插入contact表
                                $this->db->query("insert into Jrexpo.sysdba.CONTACT(CONTACTID,ACCOUNTID,LASTNAME,LOCAL_FULL_NAME,DEPARTMENT,TITLE,WORKPHONE,HOMEPHONE,FAX,FAX_2,MOBILE,MOBILE_2,EMAIL,SECONDARYEMAIL,PRIMARYLANGUAGE,ADDRESSID,SHIPPINGID,SECCODEID,CREATEDATE,CREATEUSER,MODIFYDATE,MODIFYUSER) values ('" . $ContactId[$i] . "','" . $a->$item['Company Name'] . "',N'" . $item['Full Name'] . "',N'" . $item['Local Full Name'] . "','" . $item['Department'] . "','" . $item['Job Title'] . "','" . $item['Tel 1'] . "','" . $item['Tel 2'] . "','" . $item['Fax 1'] . "','" . $item['Fax 2'] . "','" . $item['Mobile 1'] . "','" . $item['Mobile 2'] . "','" . $item['Email 1'] . "','" . $item['Email 2'] . "','" . $item['Language'] . "','" . $ConAddressId[$i]. "','" . $ConAddressId[$i] . "','SYST00000001','" . unix_to_human(now()) . "','ADMIN','" . unix_to_human(now()) . "','ADMIN')");



                                //插入GLOBALCHANGETRACKING表
                                $this->db->insert('Jrexpo.sysdba.GLOBALCHANGETRACKING', array(
                                    'CHANGEKEY'=>guid(),
                                    'TABLENAME'=>'CONTACT',
                                    'ENTITYID'=> $ContactId[$i] ,
                                    'CHANGETYPE'=>'0',
                                    'CREATEDATE'=>unix_to_human(now()),
                                    'USERID'=>'ADMIN'
                                ));




                                $this->db->trans_complete();


                            }
                            else {

                                $a->$item['Company Name']=$AccountId[$i];

                                //开启事务
                                $this->db->trans_start();


                                //插入联系人地址
                                $this->db->query("insert into Jrexpo.sysdba.ADDRESS (ADDRESSID,ENTITYID,ADDRESS1,ADDRESS2,COUNTY,CITY,STATE,POSTALCODE,COUNTRY,CREATEDATE,CREATEUSER) values ('" . $ConAddressId[$i]. "','" . $ContactId[$i] . "',N'" . $item['Address 1'] . "',N'" . $item['Address 2'] . "',N'" . $item['District / Area'] . "',N'" . $item['City'] . "',N'" . $item['Province / State'] . "','" . $item['Zip'] . "','" . $item['Country'] . "','" . unix_to_human(now()) . "','ADMIN')");


                                //插入contact表
                                $this->db->query("insert into Jrexpo.sysdba.CONTACT(CONTACTID,ACCOUNTID,LASTNAME,LOCAL_FULL_NAME,DEPARTMENT,TITLE,WORKPHONE,HOMEPHONE,FAX,FAX_2,MOBILE,MOBILE_2,EMAIL,SECONDARYEMAIL,PRIMARYLANGUAGE,ADDRESSID,SHIPPINGID,SECCODEID,CREATEDATE,CREATEUSER,MODIFYDATE,MODIFYUSER) values ('" . $ContactId[$i] . "','" . $AccountId[$i] . "',N'" . $item['Full Name'] . "',N'" . $item['Local Full Name'] . "','" . $item['Department'] . "','" . $item['Job Title'] . "','" . $item['Tel 1'] . "','" . $item['Tel 2'] . "','" . $item['Fax 1'] . "','" . $item['Fax 2'] . "','" . $item['Mobile 1'] . "','" . $item['Mobile 2'] . "','" . $item['Email 1'] . "','" . $item['Email 2'] . "','" . $item['Language'] . "','" . $ConAddressId[$i]. "','" . $ConAddressId[$i]. "','SYST00000001','" . unix_to_human(now()) . "','ADMIN','" . unix_to_human(now()) . "','ADMIN')");


                                //插入GLOBALCHANGETRACKING表
                                $this->db->insert('Jrexpo.sysdba.GLOBALCHANGETRACKING', array(
                                    'CHANGEKEY'=>guid(),
                                    'TABLENAME'=>'CONTACT',
                                    'ENTITYID'=> $ContactId[$i] ,
                                    'CHANGETYPE'=>'0',
                                    'CREATEDATE'=>unix_to_human(now()),
                                    'USERID'=>'ADMIN'
                                ));


                                //插入Account表
                                $this->db->query("insert into Jrexpo.sysdba.ACCOUNT(ACCOUNTID,ACCOUNT,ACCOUNT_IN_LOCAL,MAINPHONE,TOLLFREE,WEBADDRESS,SOURECEDETAILS,TYPE,ADDRESSID,SHIPPINGID,SECCODEID,LEADSOURCEID,ACCOUNTMANAGERID,CREATEDATE,CREATEUSER) values ('" . $AccountId[$i] . "',N'" . $item['Company Name'] . "',N'" . $item['Company Name in Local Language'] . "','" . $item['Tel 1'] . "','" . $item['Tel 2'] . "','" . $item['Website'] . "',N'" . $item['Souce detail'] . "','" . $item['Type'] . "','" . $AddressId[$i] . "','" . $AddressId[$i] . "','SYST00000001','" . $LSId . "','" . $AMId . "','" . unix_to_human(now()) . "','ADMIN')");




                                //插入AccountSummary
                                $this->db->insert('Jrexpo.sysdba.ACCOUNTSUMMARY', array(
                                    'ACCOUNTID'=>$AccountId[$i] ,
                                    'SECCODEID'=>'SYST00000001',
                                    'CREATEDATE'=>unix_to_human(now()) ,
                                    'CREATEUSER'=>'ADMIN'
                                ));



                                //插入客户地址
                                $this->db->query("insert into Jrexpo.sysdba.ADDRESS (ADDRESSID,ENTITYID,ADDRESS1,ADDRESS2,COUNTY,CITY,STATE,POSTALCODE,COUNTRY,CREATEDATE,CREATEUSER) values ('" . $AddressId[$i] . "','" . $AccountId[$i] . "',N'" . $item['Address 1'] . "',N'" . $item['Address 2'] . "',N'" . $item['District / Area'] . "',N'" . $item['City'] . "',N'" . $item['Province / State'] . "','" . $item['Zip'] . "','" . $item['Country'] . "','" . unix_to_human(now()) . "','ADMIN')");



                                $this->db->trans_complete();



                            }
                        }else{
                            if(isset($item['Company Name in Local Language'])){
                                //如果这个公司的公司信息已经创建
                                if (isset($a->$item['Company Name in Local Language']) ) {

                                    //开启事务
                                    $this->db->trans_start();

                                    //插入联系人地址
                                    $this->db->query("insert into Jrexpo.sysdba.ADDRESS (ADDRESSID,ENTITYID,ADDRESS1,ADDRESS2,COUNTY,CITY,STATE,POSTALCODE,COUNTRY,CREATEDATE,CREATEUSER) values ('" . $ConAddressId[$i]. "','" . $ContactId[$i] . "',N'" . $item['Address 1'] . "',N'" . $item['Address 2'] . "',N'" . $item['District / Area'] . "',N'" . $item['City'] . "',N'" . $item['Province / State'] . "','" . $item['Zip'] . "','" . $item['Country'] . "','" . unix_to_human(now()) . "','ADMIN')");


                                    //插入contact表
                                    $this->db->query("insert into Jrexpo.sysdba.CONTACT(CONTACTID,ACCOUNTID,LASTNAME,LOCAL_FULL_NAME,DEPARTMENT,TITLE,WORKPHONE,HOMEPHONE,FAX,FAX_2,MOBILE,MOBILE_2,EMAIL,SECONDARYEMAIL,PRIMARYLANGUAGE,ADDRESSID,SHIPPINGID,SECCODEID,CREATEDATE,CREATEUSER,MODIFYDATE,MODIFYUSER) values ('" . $ContactId[$i] . "','" . $a->$item['Company Name'] . "',N'" . $item['Full Name'] . "',N'" . $item['Local Full Name'] . "','" . $item['Department'] . "','" . $item['Job Title'] . "','" . $item['Tel 1'] . "','" . $item['Tel 2'] . "','" . $item['Fax 1'] . "','" . $item['Fax 2'] . "','" . $item['Mobile 1'] . "','" . $item['Mobile 2'] . "','" . $item['Email 1'] . "','" . $item['Email 2'] . "','" . $item['Language'] . "','" . $ConAddressId[$i]. "','" . $item['AddressId'] . "','SYST00000001','" . unix_to_human(now()) . "','ADMIN','" . unix_to_human(now()) . "','ADMIN')");



                                    //插入GLOBALCHANGETRACKING表
                                    $this->db->insert('Jrexpo.sysdba.GLOBALCHANGETRACKING', array(
                                        'CHANGEKEY'=>guid(),
                                        'TABLENAME'=>'CONTACT',
                                        'ENTITYID'=> $ContactId[$i] ,
                                        'CHANGETYPE'=>'0',
                                        'CREATEDATE'=>unix_to_human(now()),
                                        'USERID'=>'ADMIN'
                                    ));




                                    $this->db->trans_complete();


                                }
                                else {

                                    $a->$item['Company Name in Local Language']=$AccountId[$i];

                                    //开启事务
                                    $this->db->trans_start();


                                    //插入联系人地址
                                    $this->db->query("insert into Jrexpo.sysdba.ADDRESS (ADDRESSID,ENTITYID,ADDRESS1,ADDRESS2,COUNTY,CITY,STATE,POSTALCODE,COUNTRY,CREATEDATE,CREATEUSER) values ('" . $ConAddressId[$i]. "','" . $ContactId[$i] . "',N'" . $item['Address 1'] . "',N'" . $item['Address 2'] . "',N'" . $item['District / Area'] . "',N'" . $item['City'] . "',N'" . $item['Province / State'] . "','" . $item['Zip'] . "','" . $item['Country'] . "','" . unix_to_human(now()) . "','ADMIN')");


                                    //插入contact表
                                    $this->db->query("insert into Jrexpo.sysdba.CONTACT(CONTACTID,ACCOUNTID,LASTNAME,LOCAL_FULL_NAME,DEPARTMENT,TITLE,WORKPHONE,HOMEPHONE,FAX,FAX_2,MOBILE,MOBILE_2,EMAIL,SECONDARYEMAIL,PRIMARYLANGUAGE,ADDRESSID,SHIPPINGID,SECCODEID,CREATEDATE,CREATEUSER,MODIFYDATE,MODIFYUSER) values ('" . $ContactId[$i] . "','" . $AccountId[$i] . "',N'" . $item['Full Name'] . "',N'" . $item['Local Full Name'] . "','" . $item['Department'] . "','" . $item['Job Title'] . "','" . $item['Tel 1'] . "','" . $item['Tel 2'] . "','" . $item['Fax 1'] . "','" . $item['Fax 2'] . "','" . $item['Mobile 1'] . "','" . $item['Mobile 2'] . "','" . $item['Email 1'] . "','" . $item['Email 2'] . "','" . $item['Language'] . "','" . $ConAddressId[$i]. "','" . $ConAddressId[$i]. "','SYST00000001','" . unix_to_human(now()) . "','ADMIN','" . unix_to_human(now()) . "','ADMIN')");


                                    //插入GLOBALCHANGETRACKING表
                                    $this->db->insert('Jrexpo.sysdba.GLOBALCHANGETRACKING', array(
                                        'CHANGEKEY'=>guid(),
                                        'TABLENAME'=>'CONTACT',
                                        'ENTITYID'=> $ContactId[$i] ,
                                        'CHANGETYPE'=>'0',
                                        'CREATEDATE'=>unix_to_human(now()),
                                        'USERID'=>'ADMIN'
                                    ));


                                    //插入Account表
                                    $this->db->query("insert into Jrexpo.sysdba.ACCOUNT(ACCOUNTID,ACCOUNT,ACCOUNT_IN_LOCAL,MAINPHONE,TOLLFREE,WEBADDRESS,SOURECEDETAILS,TYPE,ADDRESSID,SHIPPINGID,SECCODEID,LEADSOURCEID,ACCOUNTMANAGERID,CREATEDATE,CREATEUSER) values ('" . $AccountId[$i] . "',N'" . $item['Company Name'] . "',N'" . $item['Company Name in Local Language'] . "','" . $item['Tel 1'] . "','" . $item['Tel 2'] . "','" . $item['Website'] . "',N'" . $item['Souce detail'] . "','" . $item['Type'] . "','" . $AddressId[$i] . "','" . $AddressId[$i] . "','SYST00000001','" . $LSId . "','" . $AMId . "','" . unix_to_human(now()) . "','ADMIN')");


                                    //插入AccountSummary
                                    $this->db->insert('Jrexpo.sysdba.ACCOUNTSUMMARY', array(
                                        'ACCOUNTID'=>$AccountId[$i] ,
                                        'SECCODEID'=>'SYST00000001',
                                        'CREATEDATE'=>unix_to_human(now()) ,
                                        'CREATEUSER'=>'ADMIN'
                                    ));


                                    //插入客户地址
                                    $this->db->query("insert into Jrexpo.sysdba.ADDRESS (ADDRESSID,ENTITYID,ADDRESS1,ADDRESS2,COUNTY,CITY,STATE,POSTALCODE,COUNTRY,CREATEDATE,CREATEUSER) values ('" . $AddressId[$i] . "','" . $AccountId[$i] . "',N'" . $item['Address 1'] . "',N'" . $item['Address 2'] . "',N'" . $item['District / Area'] . "',N'" . $item['City'] . "',N'" . $item['Province / State'] . "','" . $item['Zip'] . "','" . $item['Country'] . "','" . unix_to_human(now()) . "','ADMIN')");


                                    $this->db->trans_complete();



                                }
                            }else{
                                //缺少公司名
                                echo (1003);
                                exit;
                            }
                        }

                        




                    } else {
                        //客户经理或者销售线索为空
                        echo(1002);
                        exit;
                    }

                    $i++;

                }

                echo 'success!';
            } catch (Exception $e) {
                echo 'failed!';
                exit();
            }


        } else {
            //文件不存在
            echo(1004);
        }

    }

    //获取行数
    function getMsg()
    {
        $filename = $this->input->cookie('filename', true);
        $path = FCPATH . 'upload/' . $filename;
        if (file_exists($path)) {
            /*读取Excel文件中的数据*/
            $data = readExel($path, $filename);

            //获取重名的公司个数
            $d = check_duplicate($data);

            echo json_encode(array(count($data), $d));

        } else {
            echo(1004);
        }

    }



}