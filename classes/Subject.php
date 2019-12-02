<?php 

class Subject
{
private $conn; 

public function __construct($conn)
{
    $this->conn = $conn;
}


public function getAllSubject() 
{
    switch(USR_TYPE)
    {
        // ============= student get subject ============//
        case 1: 

            break;

        // ============= lecturer get subject ============//
        case 2: 
            $sql = $this->conn->prepare("
                SELECT * FROM tbl_subject sub 
                WHERE sem_id = :sem_id AND lecturer = :lecturer ");
            $sql->execute([
                "sem_id" => SEM_ID, 
                "lecturer" => USR_ID 
            ]); 

            return $sql->fetchAll(PDO::FETCH_ASSOC);

            break;

    } // end switch
}

public function getSingleSubject($sub_id)
{
    $sql = $this->conn->prepare("
        SELECT * FROM tbl_subject sub 
        WHERE sub_id = :sub_id ");
    $sql->execute([
        "sub_id" => $sub_id 
    ]); 

    return $sql->fetch(PDO::FETCH_ASSOC); 
}


public function checkClass()
{
    // get the date information now
    $time_now = date("H:i");
    $week_day = date("w"); 
    $date_now = date("Y-m-d");  


    $sql = $this->conn->prepare("
        SELECT sub.*, `time`.*, act.act_id, act.ref_text FROM tbl_subject sub 
        INNER JOIN tbl_subject_time `time` ON `time`.sub_id = sub.sub_id 
        LEFT JOIN tbl_attendance_activity act ON act.time_id = `time`.time_id 
        WHERE `time`.start_time <= :time_now AND `time`.end_time >= :time_now AND `time`.week_day = :week_day AND sub.lecturer=:lecturer");
    $sql->execute([
        "time_now" => $time_now, 
        "week_day" => $week_day, 
        "lecturer" => USR_ID 
    ]); 
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}


public function startClass($time_id, $ref_text)
{
    $sql = $this->conn->prepare("
        INSERT INTO tbl_attendance_activity (time_id, created_by, ref_text) 
        VALUES (:time_id, :created_by, :ref_text)"); 
    $sql->execute([
        "time_id" => $time_id, 
        "created_by" => USR_ID, 
        "ref_text" => $ref_text 
    ]); 
}


} //=== end class ===//

?>