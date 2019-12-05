<?php
include '../lock.php';

$value = $_POST["value"]; // this param 'value' is consisted by time_id and date; format `time_id||date` 
$value = explode("||", $value); // split it into array

$time_id = $value[0]; 
$dates = $value[1]; 

$sub_id = $_POST["sub_id"]; 


//=====  load subject class =====//
$sub_class = new Subject($db->conn); 

$student_row = $sub_class->getClassStudent($sub_id, $time_id);  // all of student in this class 

// get chart data
list($count_all_student, $count_present_student) = $sub_class->getClassChartData($sub_id, $time_id, $dates); 
$count_absent_student = $count_all_student - $count_present_student; 

// graph object
include("../assets/graph/diagramdraw.php");
$draw = new diagramdraw();

?>
<div class="container-fluid pt-1">

    <!-- Nav tabs -->
    <ul class="nav nav-pills border-bottom mb-3 mt-2 small">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#list">Attendance List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#chart">Chart</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="list">
            <button class="btn btn-success btn-sm d-none" type="button">Verify Attendance <i class="fas fa-check"></i></button>

            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th width="70%">Student / ID</th> 
                        <th>Attendance Status</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // display each student and attendance 
                    foreach ($student_row as $key => $row) 
                    {
                        $student        = $row["usr_id"]; 
                        $student_id     = $row["usr_name"]; 
                        $student_name   = $row["full_name"]; 

                        // get student attendance 
                        $att_row = $sub_class->getStudentAttendance($student, $dates, $time_id); 
                        if( count($att_row) == 0)
                        {
                            $str_attendance = "<span class='bg-danger p-2 rounded-lg'>Absent</span>"; 
                            $str_reject = "";
                        }
                        else 
                        {
                            $punch_datetime = $att_row[0]["punch_time"]; 
                            $punch_time = date("h:i a", strtotime($punch_datetime)); 
                            $str_attendance = "<span class='bg-primary p-2 rounded-lg'>Present</span> 
                            <br><small class='mt-2 badge badge-light border border-secondary'>Time: $punch_time</small>"; 
                            $str_reject = "<button type='button'>Reject</button>";
                        }
                        ?>
                        <tr>
                            <td><?= "$student_name / $student_id"; ?></td>
                            <td><?= $str_attendance; ?></td>
                            <!-- <td><?= $str_reject; ?></td> -->
                        </tr>
                        <?php 
                    } // end foreach ( display student )


                    ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="chart">
            <div align="center">
                <canvas class="col-sm-4" id="pie-chart"></canvas>
                <?php 
                $item = "Present,Absent";
                $value = "$count_present_student,$count_absent_student";
                $canvasId = "pie-chart";
                $color = "#007bff,#dc3545";
                $charttitle = "Attendance Chart"; 
                $draw->pie_chart($item, $value, $canvasId , $color, $charttitle);
                ?>
            </div>
        </div>
    </div>


</div>