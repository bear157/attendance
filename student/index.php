<?php
include '../lock.php';

// page header
include "../includes/header.php"; 
// side menu
include "../includes/sidebar_student.php"; 


// load subject class
$sub_class = new Subject($db->conn); 

// display subject list 
$subject_row = $sub_class->getAllSubject(); 


// weekday array
$arr_week_day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
?>
<div class="col-sm-10 offset-sm-2">

    <h2>Dashboard</h2>
    <hr>    
    <div class="row">
        <div class="offset-1 col-10 border border-warning p-3 mb-3">
            <h5>Quick Action</h5>
            <a href="attendance_status.php" class="btn btn-warning mb-2">View Attendance Status</a>
            <button class="btn btn-warning mb-2" type="button" data-toggle="modal" data-target="#modal-cancel-msg">View Class Cancel</button>
            <a href="timetable.php" target="_blank" class="btn btn-info mb-2">View Timetable <i class="fas fa-table"></i></a>
        </div>
    </div>

    <div class="row">
        <div class="offset-1 col-10 border border-info p-3">
            <h5>Subject Enrolled</h5>

            <div class="row">
            <?php 
            foreach ($subject_row as $key => $row) 
            {
                $sub_code = $row["sub_code"]; 
                $sub_name = $row["sub_name"]; 
                $sub_id = $row["sub_id"]; 
                $lecturer_name = $row["lecturer_name"]; 

                // ===== get subject time ===== //
                $time_row = $sub_class->getSubjectTime($sub_id) ; 

                ?>

                <div class="col-12 col-sm-4 mb-2" align="center">
                    <div class="card pointer subject px-0">
                        <div class="card-body bg-light border border-secondary rounded-lg shadow">
                            <p><?= $sub_code; ?></p>
                            <h6><b><?= $sub_name; ?></b></h6>
                            <b>Lecturer: <?= $lecturer_name; ?> </b>
                            <?php 
                            foreach ($time_row as $key => $info) {
                                $class_start    = date("g:i a", strtotime($info["start_time"]) ); 
                                $class_end      = date("g:i a", strtotime($info["end_time"]) ); 
                                $week_day       = $info["week_day"]; 

                                echo "<div class='badge' style='background-color: ".getRandomColor().";'>".$arr_week_day[$week_day].": $class_start - $class_end </div><br>"; 
                            }

                            ?>
                        </div>
                    </div>
                </div>

                <?php 
            } // end foreach

            ?>
            </div>
        </div>
    </div>

</div>
<?php 
// modal cancel class
include 'modal_class_cancel.php';
// page footer
include "../includes/footer.php";
?>