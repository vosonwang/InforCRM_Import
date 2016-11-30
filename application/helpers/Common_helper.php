<?php
/**
 * Created by PhpStorm.
 * User: voson
 * Date: 2016/11/25
 * Time: 10:42
 */

/*自定义的、通用的辅助函数*/


/*获取文件扩展名
@param string filepath
@return string file_extension
*/
function get_extension($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}


/*读取Excel表格中的数据
@param string filepath | string filename
@return array excel_data
*/
function readExel($path,$filename){


    $ci =& get_instance();

    /*载入PHPExcel库*/
    $ci->load->library('PHPExcel');

    $extension=get_extension($filename);

    //根据不同类型分别操作
    if ($extension == 'xlsx' || $extension == 'xls') {
        $objPHPExcel = PHPExcel_IOFactory::load($path);
    } else if ($extension == 'csv') {
        $objReader = PHPExcel_IOFactory::createReader('CSV')
            ->setDelimiter(',')
            ->setInputEncoding('UTF-8')   //支持俄文、中文等字符，不设置将导致中文列内容返回boolean(false)或乱码
            ->setEnclosure('"')
            ->setLineEnding("\r\n")
            ->setSheetIndex(0);
        $objPHPExcel = $objReader->load($path);

    } else {
        die('Not supported file types!');
    }


    //选择标签页
    $sheet = $objPHPExcel->getSheet(0);

    //获取行数与列数,注意列数需要转换
    $highestRowNum = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $highestColumnNum = PHPExcel_Cell::columnIndexFromString($highestColumn);

    //取得字段，这里测试表格中的第一行为数据的字段，因此先取出用来作后面数组的键名
    $filed = array();
    for ($i = 0; $i < $highestColumnNum; $i++) {
        $cellName = PHPExcel_Cell::stringFromColumnIndex($i) . '1';
        $cellVal = $sheet->getCell($cellName)->getValue();//取得列内容
        $filed [] = $cellVal;
    }

    //开始取出数据并存入数组
    $data = array();



    for ($i = 2; $i <= $highestRowNum; $i++) {//ignore row 1 默认第一行是标题行
        $row = array();
        $z=0;
        for ($j = 0; $j < $highestColumnNum; $j++) {
            $cellName = PHPExcel_Cell::stringFromColumnIndex($j) . $i;
            $cellVal = $sheet->getCell($cellName)->getValue();

            /*将富文本强制转成string*/
            if(is_object($cellVal)){
                $cellVal=$cellVal->__toString();
            }

           if($cellVal!=''){
               $z++;
           }

           /*过滤单元格中的换行符*/
            if (strstr($cellVal, "\n") == true) {
                $cellVal = str_replace(array("/r/n", "/r", "/n", "\n"), "", $cellVal);
            }

            /*针对MSSQL，将单引号转义成双引号*/
            if(is_string($cellVal)){
                $cellVal= str_replace('\'','"',$cellVal);
            }


            $row[$filed[$j]] = $cellVal;
        }
        if($z!=0){
            /*如果该行不是空行，则将该行数据插入到$data数组中*/
            $data [] = $row;
        }

    }

    return $data;
}

//检查[{}{}{}]这类数组对象重复
//返回一个数组，包含两个值（重复个数(int)和不重复的值组成的对象{{}，{}，{}}）
function check_duplicate($data){

    $a=array();
    $b=0;
    foreach ($data as $item){

        /*如果Company Name存在*/
        if(isset($item['Company Name'])){
            if(isset($a[$item['Company Name']])){
                $b++;
             }
             else{
                $a[$item['Company Name']]=1;
            }
        }
        else{
        /*如果Company Name不存在，Company Name in Local Language存在*/
            if(isset($item['Company Name in Local Language'])){
                if(isset($a[$item['Company Name in Local Language']])){
                    $b++;
                 }
                else{

                    $a[$item['Company Name in Local Language']]=1;
                }
            }
            else{
                /*公司名不存在！*/
               $b=-1;
            }
        }
    }


    return $b;
}


//生成Guid
function guid()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = //chr(123). "{"
            substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        //.chr(125); "}"
        return $uuid;
    }
}