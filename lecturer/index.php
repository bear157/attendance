<?php 
include "../lock.php";

// load subject class
$sub_class = new Subject($db->conn); 



// page header
include "../includes/header.php"; 
// side menu
include "../includes/sidebar_lecturer.php"; 
?>
<div class="col-sm-10 offset-sm-2 dashboard">
    <h2>Dashboard</h2>
    

    <div class="row">
        
        <div class="col-sm-6 col-12 p-4">
            <section class="border border-info px-3 py-2 mb-5 bg-light section-sm">
                <?php 
                if($display_class) // if got qr to display
                {
                    include 'generate_qrcode.php';

                    // ============== content start ===================//
                    ?>
                    <h6>Current class: <?= "$sub_code $sub_name"; ?></h6>
                    <div align="center">
                        <span data-toggle="modal" data-target="#modal-qrcode">
                            <img class="col-10 col-sm-4 dashboard-qrcode pointer align-center border border-dark px-0" title="Click to display QR widely." data-placement="bottom" data-toggle="tooltip" src="<?= $PNG_WEB_DIR.basename($filename); ?>" id="qrcode" />
                        </span>
                    </div>
                    <div class="text-center">
                        <p class="badge label-urgent text-light">Click the QR code to display widely.</p>
                    </div>


                    <?php 
                    
                }
                else
                {
                    // display subject list 
                    $subject_row = $sub_class->getThreeSubject(); 
                    ?>
                    <h6 class="pb-2 border-bottom">Your Subject</h6>
                    <?php 
                    if(count($subject_row)>0)
                    {
                        
                        echo '<div class="list-group list-group-flush">';
                             
                            foreach ($subject_row as $key => $row) {
                                $sub_id = $row["sub_id"]; 
                                $sub_code = $row["sub_code"]; 
                                $sub_name = $row["sub_name"]; 
                                echo "<a href='view_subject_class.php?sub_id=$sub_id' class='list-group-item list-group-item-action py-2 px-3'>$sub_code - $sub_name</a>";
                            } // end foreach
                            

                        echo '</div>'; 
                        echo "<a href='view_subject.php' class='small ml-1'>View all subjects</a>";
                    }
                    else
                    {
                        echo "You have no subject."; 
                    } // end if else
                    ?>

                    <?php

                } // end if else 

                ?>

            </section>

            <section class="border border-warning p-3 bg-light">
                <h6 class="pb-2 border-bottom">Quick Action</h6>
                <button class="btn btn-warning mb-2">Issue Class Cancel <i class="fas fa-ban" data-fa-transform="rotate-90"></i></button>
                <a href="timetable.php" target="_blank" class="btn btn-info mb-2">View Timetable <i class="fas fa-table"></i></a>

            </section>
        </div>

        


        
        <div class="col-sm-6 col-12 p-4">
            <section class="border border-info p-3 bg-light section-lg">
                <h6 class="pb-2 border-bottom">Attendance Chart <i class="fas fa-info-circle pointer" data-toggle="tooltip" title="Show the last attendance chart of the subject."></i></h6>


                <label class="" for="subject-input">
                    <span>Subject: </span>
                    <select class="form-control-sm chosen" name="" id="subject-input" onchange="getSubjectChart(this.value)" >
                        <?php 
                        // ===== get all subject ===== //
                        $sub_row = $sub_class->getAllSubject(); 
                        foreach ($sub_row as $key => $row) 
                        {
                            $sub_code = $row["sub_code"]; 
                            $sub_id = $row["sub_id"]; 
                            $sub_name = $row["sub_name"]; 

                            echo "<option value='$sub_id'>$sub_code $sub_name</option>";
                        }

                        ?>
                    </select>
                </label>

                <div id="chart-box">
                    <?php 
                    if(count($sub_row) > 0)
                    {
                        $selected_sub_id = $sub_row[0]["sub_id"]; 
                        include "attendance_chart.php";
                    }
                    ?>
                </div>


            </section>
        </div>

    </div>



</div>
<?php 
// page footer
include "../includes/footer.php";
?>