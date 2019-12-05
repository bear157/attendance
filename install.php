<?php 
include 'classes/Database.php'; 
$host = new Database(true);

try{
    

    $host->conn->beginTransaction(); 
    $sql = file_get_contents('data/init.sql');
    $host->conn->exec($sql); 
    $host->conn->commit(); 
    echo "Install success";
}catch(PDOException $e){
    $host->conn->rollBack(); 
    echo $sql."<br>".$e->getMessage(); 
}


?>