<?php

include_once "../assets/phpqrcode/qrlib.php"; 
//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
//html PNG location prefix
$PNG_WEB_DIR = 'temp/'; 
//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);


// qrcode properties
$errorCorrectionLevel = 'L';
$matrixPointSize = 5;

// user data 
$act_id = $current_class_row[0]["act_id"]; 
$sub_id = $current_class_row[0]["sub_id"]; 
$sub_name = $current_class_row[0]["sub_name"]; 
$sub_code = $current_class_row[0]["sub_code"]; 

// generate qrcode

$data = "http://".IP.":".PORT_NUMBER."/attendance/index.php?aid=".md5($act_id)."&sub=".md5($sub_id);
// $data = $current_class_row[0]["ref_text"]; 
$filename = $PNG_TEMP_DIR.'class'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

?>