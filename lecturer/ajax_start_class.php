<?php 
include '../lock.php';

$time_id = $_POST["time_id"]; 
$ref_text = getRandomWord(); 

// include subject class
$sub_class = new Subject($db->conn); 
try
{
    $db->conn->beginTransaction();

    // start class !!
    $sub_class->startClass($time_id, $ref_text);

    $db->conn->commit();
    die( json_encode( array( "success" => 1 ) ) );
}
catch(PDOException $e)
{
    $db->conn->rollBack(); 
    die( json_encode( array( "success" => $e->getMessage() ) ) );
}



?>