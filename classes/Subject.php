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
                "sem_id"    => SEM_ID, 
                "lecturer"  => USR_ID 
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

public function getThreeSubject()
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
                WHERE sem_id = :sem_id AND lecturer = :lecturer 
                LIMIT 0,3");
            $sql->execute([
                "sem_id"    => SEM_ID, 
                "lecturer"  => USR_ID 
            ]); 

            return $sql->fetchAll(PDO::FETCH_ASSOC);

            break;

    } // end switch 
}

public function getTimetableData()
{

    switch(USR_TYPE)
    {
        // ============= student get subject ============//
        case 1: 

            break;

        // ============= lecturer get subject ============//
        case 2: 
            $sql = $this->conn->prepare("
                SELECT * 
                FROM tbl_subject_time `time` 
                INNER JOIN tbl_subject sub ON sub.sub_id = `time`.sub_id 
                WHERE sub.lecturer = :lecturer AND sub.sem_id = :sem_id 
                ORDER BY `time`.start_time ASC, `time`.week_day ASC"); 
            $sql->execute([
                "sem_id"    => SEM_ID, 
                "lecturer"  => USR_ID 
            ]); 

            $timetable_data = array(); // 4d array; timetable_data[start_hour][week_day][] = array to store class time info
            while($row = $sql->fetch(PDO::FETCH_ASSOC))
            {
                $week_day = $row["week_day"]; 
                $start_time = $row["start_time"]; 
                $start_hour = date("G", strtotime($start_time)); 

                $timetable_data[$start_hour][$week_day][] = $row;
            } // end while
            
            return $timetable_data; 
            break;

    } // end switch 

}


public function checkClass()
{
    // get the date information now
    $time_now = date("H:i");
    $week_day = date("w"); 
    $date_now = date("Y-m-d");  


    $sql = $this->conn->prepare("
        SELECT sub.*, `time`.*, act.act_id, act.ref_text, ccl.ccl_id FROM tbl_subject sub 
        INNER JOIN tbl_subject_time `time` ON `time`.sub_id = sub.sub_id 
        LEFT JOIN tbl_attendance_activity act ON act.time_id = `time`.time_id 
        LEFT JOIN tbl_class_cancel ccl ON ccl.time_id = `time`.time_id AND ccl.cancel_date = :date_now 
        WHERE `time`.start_time <= :time_now AND `time`.end_time >= :time_now AND `time`.week_day = :week_day AND sub.lecturer=:lecturer");
    $sql->execute([
        "time_now" => $time_now, 
        "week_day" => $week_day, 
        "date_now" => $date_now, 
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
        "time_id"       => $time_id, 
        "created_by"    => USR_ID, 
        "ref_text"      => $ref_text 
    ]); 
}


public function getSubjectTime($sub_id) 
{
    $sql = $this->conn->prepare("
        SELECT `time`.time_id, `time`.start_time, `time`.end_time, `time`.week_day 
        FROM tbl_subject sub
        INNER JOIN tbl_subject_time `time` ON `time`.sub_id = sub.sub_id 
        WHERE sub.sub_id = :sub_id "); 
    $sql->execute([
        "sub_id" => $sub_id 
    ]); 
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}

public function getClassStudent($sub_id, $time_id) 
{
    $sql = $this->conn->prepare("
        SELECT usr.* 
        FROM tbl_enrollment enr 
        INNER JOIN tbl_user usr ON usr.usr_id = enr.student 
        INNER JOIN tbl_subject sub ON  enr.sub_id = sub.sub_id 
        INNER JOIN tbl_subject_time `time` ON sub.sub_id = `time`.sub_id 
        WHERE sub.sub_id = :sub_id  AND `time`.time_id = :time_id ");
    $sql->execute([
        "time_id"   => $time_id, 
        "sub_id"    => $sub_id  
    ]); 

    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}

public function getStudentAttendance($student, $dates, $time_id) 
{
    $sql = $this->conn->prepare("
        SELECT * FROM tbl_attendance att 
        INNER JOIN tbl_attendance_activity act ON act.act_id = att.act_id 
        WHERE act.time_id = :time_id AND att.student = :student AND date(act.created_date) = :dates "); 
    $sql->execute([
        "time_id"   => $time_id, 
        "dates"     => $dates, 
        "student"   => $student  
    ]); 

    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}

// ============= get the attendance data by time, subject, date) ========================== //
public function getClassChartData($sub_id, $time_id, $dates) 
{
    // =================== get all student number ========================== //
    $student_row = $this->getClassStudent($sub_id, $time_id); 
    $count_all_student = count($student_row); 

    // =================== get present student number ========================== //
    $sql = $this->conn->prepare("
        SELECT COUNT(DISTINCT att.student) FROM tbl_attendance att 
        INNER JOIN tbl_attendance_activity act ON act.act_id = att.act_id 
        WHERE act.time_id = :time_id AND date(act.created_date) = :dates "); 
    $sql->execute([
        "time_id"   => $time_id, 
        "dates"     => $dates 
    ]); 
    $count_present_student = $sql->fetchColumn(); 

    return array($count_all_student, $count_present_student); 
}

// ============= get the last attendance data by subject ; ** display in dashboard  ========================== //
public function getSubjectChartData($sub_id) // : array
{
    // get latest time id
    $sql = $this->conn->prepare("
        SELECT ifnull(act.act_id,0) as act_id, `time`.time_id, ifnull(date(act.created_date), '0000-00-00') as created_date  FROM tbl_subject_time `time` 
        LEFT JOIN tbl_attendance_activity act ON `time`.time_id = act.time_id 
        WHERE `time`.sub_id = :sub_id 
        ORDER BY act.created_date DESC 
        LIMIT 0,1"); 
    $sql->execute([
        "sub_id"    => $sub_id
    ]); 
    $row            = $sql->fetch(PDO::FETCH_ASSOC);
    $act_id         = $row["act_id"]; 
    $time_id        = $row["time_id"]; 
    $created_date   = $row["created_date"]; 

    if($act_id != 0) 
    {
        // ======== start to get chart data ========= //
        // =================== get all student number ========================== //
        $student_row = $this->getClassStudent($sub_id, $time_id); 
        $count_all_student = count($student_row); 

        // =================== get present student number ========================== //
        $sql = $this->conn->prepare("
            SELECT COUNT(DISTINCT att.student) FROM tbl_attendance att 
            INNER JOIN tbl_attendance_activity act ON act.act_id = att.act_id 
            WHERE act.act_id = :act_id "); 
        $sql->execute([
            "act_id"    => $act_id 
        ]); 
        $count_present_student = $sql->fetchColumn(); 


        return [$act_id, $count_all_student, $count_present_student, $created_date];
    }
    else
    {
        return [$act_id, 0, 0, $created_date];
    }


}


public function insertClassCancel($time_id, $dates, $reason=null) 
{
    $sql = $this->conn->prepare("
        INSERT INTO tbl_class_cancel (time_id, cancel_date, reason) 
        VALUES (:time_id, :cancel_date, :reason) "); 
    $sql->execute([
        "time_id"       => $time_id, 
        "reason"        => $reason, 
        "cancel_date"   => $dates 
    ]); 
} 


public function getCancelDate($sub_id) // : array (of cancel date) 
{
    $sql = $this->conn->prepare("
        SELECT ccl.cancel_date FROM tbl_class_cancel ccl 
        INNER JOIN tbl_subject_time `time` ON `time`.time_id = ccl.time_id 
        WHERE `time`.sub_id = :sub_id AND ccl.status_id = 1");
    $sql->execute([
        "sub_id" => $sub_id 
    ]); 

    $arr_ccl_dates = array(); // this array will be returned
    while($row = $sql->fetch(PDO::FETCH_ASSOC)) 
    {
        $arr_ccl_dates[] = $row["cancel_date"]; // dump the date value to array
    }// end while

    return $arr_ccl_dates; 
}

public function getCancelHistory($sub_id)
{
    $sql = $this->conn->prepare("
        SELECT * FROM tbl_class_cancel ccl 
        INNER JOIN tbl_subject_time `time` ON `time`.time_id = ccl.time_id 
        WHERE `time`.sub_id = :sub_id AND ccl.status_id = 1 
        ORDER BY ccl.cancel_date DESC");
    $sql->execute([
        "sub_id" => $sub_id 
    ]); 
    return $sql->fetchAll(PDO::FETCH_ASSOC); 
}




} //=== end class ===//

?>