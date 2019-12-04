<?php 

class Semester
{
private $conn; 

public function __construct($conn)
{
    $this->conn = $conn;
}


public function getCurrentSemester() 
{
    $today = date("Y-m-d"); 
    $sql = $this->conn->prepare("
        SELECT * FROM tbl_semester sem 
        WHERE sem.start_date <= :today AND sem.end_date >= :today "); 
    $sql->execute([
        "today" => $today
    ]); 
    
    if($sql->rowCount() == 0)
    {
        $sem_id = 0;
        $sem_start = 0; 
        $sem_end = 0; 
        $sem_year = 0; 
        $sem_number = 0; 
    }
    else
    {
        $row = $sql->fetch(PDO::FETCH_ASSOC);  
        $sem_id = $row["sem_id"]; 
        $sem_start = $row["start_date"]; 
        $sem_end = $row["end_date"]; 
        $sem_year = $row["sem_year"]; 
        $sem_number = $row["sem_number"]; 
    }
    
    return array( $sem_id, $sem_start, $sem_end, $sem_year, $sem_number ); 

}


} //=== end class ===//

?>