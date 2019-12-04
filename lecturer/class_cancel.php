<?php
include '../lock.php';
// include date function 
include "../functions/func_date.php"; 


if(isset($_GET["sub_id"]) && !empty($_GET["sub_id"]))
{
    $sub_id = $_GET["sub_id"];     
}
else
{
    die(header("Location: view_subject.php")); 
}

if(isset($_GET["dates"]) && !empty($_GET["dates"]))
{
    $cancel_dates = $_GET["dates"];     
}
else
    $dates = "";

//=====  load subject class =====//
    $sub_class = new Subject($db->conn); 

    // get the subject info
    $sub_info       = $sub_class->getSingleSubject($sub_id); 
    $sub_class_time = $sub_class->getSubjectTime($sub_id);

    // ===== get cancel date ====== //
    $arr_ccl_date   = $sub_class->getCancelDate($sub_id); 


if($sub_info["lecturer"] != USR_ID) 
{
    die(header("Location: view_subject.php")); // if not this lecturer, header to subject page
}

// page header
include "../includes/header.php"; 
// side menu
include "../includes/sidebar_lecturer.php"; 

// set sub_id to js variable
echo "<script>var sub_id = '$sub_id'; </script>"; 



// weekday array
$arr_week_day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
?>
<div class="col-sm-10 offset-sm-2">
    <h3><?= $sub_info["sub_code"]." - ".$sub_info["sub_name"]; ?></h3>
    <hr>
    <h4><u>Class Cancel</u></h4>

    <!-- Nav tabs -->
    <ul class="nav nav-pills border-bottom mb-3 mt-2 small">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#form">Issue Class Cancel</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#history">History</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane active border py-3 border-info rounded" id="form">
            <form method="POST" action="class_cancel_saving.php">
                <input type="hidden" name="sub_id" value="<?= $sub_id; ?>" />

                <div class="form-group row">
                    <label class="col-sm-2 text-right" for="class-input">
                        <span>Class: </span>
                    </label>
                    <div class="col-sm-6">
                        <select class="form-control-sm chosen border-info" id="class-input" name="value">
                            <option value="" disabled selected>Select date</option>
                            <?php 
                            $start_range    = SEM_START < date("Y-m-d") ? date("Y-m-d") : SEM_START; 
                            $dateRange      = dateRange($start_range, SEM_END);

                            $arr_date = array(); 
                            foreach ($sub_class_time as $key => $row) {
                                $time_id        = $row["time_id"]; 
                                $class_start    = $row["start_time"]; 
                                $class_end      = $row["end_time"]; 
                                $week_day       = $row["week_day"]; 

                                $dates = array_filter( $dateRange, dateFilter([ $arr_week_day[$week_day] ]) ); 
                                $dates = array_values($dates); 

                                $dates = array_map(function ($date) {
                                    return $date->format('Y-m-d');
                                }, $dates);
                                ?>
                                <optgroup  label="<?= $arr_week_day[$week_day]; ?> Class (<?= date("g:i a", strtotime($class_start))." - ".date("g:i a", strtotime($class_end)); ?>)">
                                    <?php 
                                    foreach ($dates as $value) {
                                        $class_date = date("Y-m-d", strtotime($value)); 

                                        // if this date is cancel, dont show
                                        if(in_array($class_date, $arr_ccl_date))
                                            continue;

                                        ?>
                                        <option value="<?= $time_id."||".$class_date; ?>" <?= $cancel_dates == $class_date ? "selected" : ""; ?>><?= $class_date; ?></option>
                                        <?php
                                    }
                                    ?>
                                </optgroup>
                                <?php 
                            } // end foreach

                            ?>
                        </select>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-sm-2 text-right" for="ta-reason">
                        <span>Reason: </span>
                    </label>
                    <div class="col-sm-6">
                        <textarea class="form-control form-control-sm noresize border-info" name="reason" id="ta-reason" rows="3" placeholder="Leave the reason. Optional."></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-6">
                        <button class="btn btn-success btn-sm" type="submit">Submit</button>
                    </div>
                </div>
                
            </form>
        </div>
        <div class="tab-pane fade" id="history">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>Cancel Date</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                // ====== get cancel history ======== //
                $history_row = $sub_class->getCancelHistory($sub_id); 
                foreach ($history_row as $key => $row) {
                    $cancel_date    = $row["cancel_date"]; 
                    $reason         = is_null($row["reason"]) ? "-" : $row["reason"]; 

                    ?>
                    <tr>
                        <td><?= $cancel_date; ?></td>
                        <td><?= $reason; ?></td>
                    </tr>
                    <?php

                } // end foreach

                if(count($history_row) == 0) 
                {
                    ?>
                    <tr>
                        <td colspan="2" align="center">No any class cancel history.</td>
                    </tr>
                    <?php 
                } // end if

                ?>

                </tbody>
            </table>
        </div>
    </div> <!-- end tab-content -->
</div>
<?php 
// page footer
include "../includes/footer.php";
?>