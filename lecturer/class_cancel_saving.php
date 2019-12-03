<?php
include '../lock.php';


$reason = $_POST["reason"] == "" ? null : $_POST["reason"]; 
$sub_id = $_POST["sub_id"]; 

$value = $_POST["value"]; // this param 'value' is consisted by time_id and date; format `time_id||date` 
$value = explode("||", $value); // split it into array 

$time_id = $value[0]; 
$dates = $value[1]; 


//=====  load subject class =====//
$sub_class = new Subject($db->conn); 

// ======== insert row class cancel ================= //
$sub_class->insertClassCancel($time_id, $dates, $reason);
$_SESSION["message"] = "The class is cancelled."; 

header("Location: view_subject.php"); 

?>