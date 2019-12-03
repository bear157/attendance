<?php
include '../lock.php';


// load subject class
$sub_class = new Subject($db->conn); 


// page header
include "../includes/header.php"; 
// side menu
include "../includes/sidebar_lecturer.php"; 


// weekday array
$arr_week_day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
?>
<div class="col-sm-10 offset-sm-2">
    <h2>Subject</h2>
    <hr>
    <div class="row">
        <?php 
        // retrieve subject
        $sub_row = $sub_class->getAllSubject(); 
        foreach ($sub_row as $key => $row) {
            $sub_id     = $row["sub_id"]; 
            $sub_name   = $row["sub_name"]; 
            $sub_code   = $row["sub_code"]; 
            
            // ===== get subject time ===== //
            $time_row = $sub_class->getSubjectTime($sub_id) ; 


            ?>

            <div class="col-12 col-sm-6 mb-2" align="center">
                <div class="card pointer col-11 subject px-0" onclick="window.location='view_subject_class.php?sub_id=<?= $sub_id; ?>';">
                    <div class="card-body bg-light">
                        <p><?= $sub_code; ?></p>
                        <h6><b><?= $sub_name; ?></b></h6>
                        <?php 
                        foreach ($time_row as $key => $info) {
                            $class_start    = date("g:i a", strtotime($info["start_time"]) ); 
                            $class_end      = date("g:i a", strtotime($info["end_time"]) ); 
                            $week_day       = $info["week_day"]; 

                            echo "<div class='badge' style='background-color: ".getRandomColor()."; font-size: 14px;'>".$arr_week_day[$week_day].": $class_start - $class_end </div><br>"; 
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
<?php 
// page footer
include "../includes/footer.php";
?>