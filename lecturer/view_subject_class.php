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


    //=====  load subject class =====//
    $sub_class = new Subject($db->conn); 

    // get the subject info
    $sub_info = $sub_class->getSingleSubject($sub_id); 
    $sub_class_time = $sub_class->getSubjectTime($sub_id);

if($sub_info["lecturer"] != USR_ID) 
{
    die(header("Location: view_subject.php")); // if not this lecturer, header to subject page
}

// page header
include "../includes/header.php"; 
// side menu
include "../includes/sidebar_lecturer.php"; 

// weekday array
$arr_week_day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
?>
<div class="col-sm-10 offset-sm-2">

    <h3><?= $sub_info["sub_code"]." - ".$sub_info["sub_name"]; ?></h3>
    <div class="form-group">
        <label class="" for="class-input">
            <span>Class: </span>
            <select class="form-control-sm chosen" name="" id="class-input">
                <?php 
                $end_range = SEM_END > date("Y-m-d") ? date("Y-m-d") : SEM_END; 
                $dateRange = dateRange(SEM_START, $end_range);

                $arr_date = array(); 
                foreach ($sub_class_time as $key => $row) {
                    $class_start = $row["start_time"]; 
                    $class_end = $row["end_time"]; 
                    $week_day = $row["week_day"]; 

                    $dates = array_filter( $dateRange, dateFilter([ $arr_week_day[$week_day] ]) ); 
                    $dates = array_values($dates); 
                    $dates = array_reverse($dates); 
                    $dates = array_map(function ($date) {
                        return $date->format('Y-m-d');
                    }, $dates);
                    ?>
                    <optgroup  label="<?= $arr_week_day[$week_day]; ?> Class (<?= date("g:i a", strtotime($class_start))." - ".date("g:i a", strtotime($class_end)); ?>)">
                        <?php 
                        foreach ($dates as $value) {
                            $class_date = date("Y-m-d", strtotime($value)); 
                            ?>
                            <option value="<?= $class_date; ?>"><?= $class_date; ?></option>
                            <?php
                        }
                        ?>
                    </optgroup>
                    <?php 
                } // end foreach

                
                ?>

            </select>
        </label>
    </div>

    <hr>

</div>
<?php 
// page footer
include "../includes/footer.php";
?>