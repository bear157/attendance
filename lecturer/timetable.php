<?php
include '../lock.php';
$page_title = "Timetable"; 

    //=====  load subject class =====//
    $sub_class = new Subject($db->conn); 

    // ======== get timetable data ========== // 
    $timetable_data = $sub_class->getTimetableData(); 

    // get subject row 
    // differentiate each subject with different color 
    $subject_row = $sub_class->getAllSubject(); 
    $arr_color = array();  // arr_color[sub_id] = color code (HEX)
    foreach ($subject_row as $key => $row) {
        $sub_id = $row["sub_id"]; 
        $arr_color[$sub_id] = getRandomColor(); 
    }
    

    // page header
    include "../includes/header.php"; 
    // side menu
    // include "../includes/sidebar_lecturer.php"; 

    // weekday array
    $arr_week_day = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

?>
<div class="container">
    
    <div align="center">
        <h4>Timetable (<?= "Year ".SEM_YEAR." Semester ".SEM_NUMBER; ?>)</h4>
        <table>
            <tr>
                <td><?= USR_FULL_NAME; ?></td>
            </tr>
        </table>
    </div>

    <table class="table small timetable">
        <!-- display time -->
        <tr>
            <td></td>
            <?php 
            /** timetable variable in loop
             * $i represents week_day
             * $j represents start_hour
             */

            $start = 7; // college start time (hours) => 7am
            $end = 21; //college close time (hours) => 9pm

            for($i = 1; $i <= 6; $i++)
            {
                echo "<td class='timetable-weekday' width='15%'>".$arr_week_day[$i]."</td>"; 
            } // end for loop

            ?>
        </tr>
        <?php
        $arr_rowspan = array(); // to store which column has rowspan ; arr_rowspan[weekday] = rowspan value
        for($j = $start; $j < $end; $j++) 
        {
            $str_time = date("g:i a", strtotime("{$j}:00"))."<br> - <br>".date("g:i a", strtotime(($j+1).":00"));
            echo "<tr>";
            echo "<td class='timetable-time'>$str_time</td>";
            for($i = 1; $i <= 6; $i++)
            {
                if ( !isset($timetable_data[$j][$i]) ) 
                {
                    if( isset($arr_rowspan[$i]) && $arr_rowspan[$i] > 0 )
                    {
                        $week_day_rowspan = $arr_rowspan[$i];
                        $arr_rowspan[$i] = $week_day_rowspan - 1; 
                    }
                    else
                        echo "<td></td>"; 
                }
                else
                {
                    foreach ($timetable_data[$j][$i] as $key => $row) 
                    {
                        $week_day = $row["week_day"]; 
                        
                        $sub_id         = $row["sub_id"]; 
                        $start_time     = $row["start_time"]; 
                        $end_time       = $row["end_time"]; 
                        $sub_name       = $row["sub_name"]; 
                        $sub_code       = $row["sub_code"]; 

                        // calculate time difference
                        $time1          = strtotime($start_time);    // start time
                        $time2          = strtotime($end_time);      // end time
                        $rowspan        = round(abs($time2 - $time1) / 3600,2); // this part might be problem if got half hour class

                        // store the rowspan value 
                        if( !isset($arr_rowspan[$i]) )
                            $arr_rowspan[$i] = 0;
                        $arr_rowspan[$i] += $rowspan-1; 

                        echo "<td class='has-class' rowspan='$rowspan' style='background-color: ".$arr_color[$sub_id]."; '>$sub_code <br>$sub_name </td>"; 
                    } // end foreach


                }

            } // end inner for loop
            echo "</tr>";
        } // end outer for loop

        ?>
    </table>


</div>
<?php 
// page footer
include "../includes/footer.php";
?>