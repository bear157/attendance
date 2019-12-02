<?php
include '../lock.php';


// load subject class
$sub_class = new Subject($db->conn); 


// page header
include "../includes/header.php"; 
// side menu
include "../includes/sidebar_lecturer.php"; 
?>
<div class="col-sm-10 offset-sm-2">
    <h2>Subject</h2>
    <hr>
    <div class="row">
        <?php 
        // retrieve subject
        $sub_row = $sub_class->getAllSubject(); 
        foreach ($sub_row as $key => $row) {
            $sub_id = $row["sub_id"]; 
            $sub_name = $row["sub_name"]; 
            $sub_code = $row["sub_code"]; 
            
            ?>

            <div class="col-12 col-sm-6" align="center">
                <div class="card pointer col-11 subject" onclick="window.location='view_subject_class.php?sub_id=<?= $sub_id; ?>';">
                    <div class="card-body">
                        <p><?= $sub_code; ?></p>
                        <p><?= $sub_name; ?></p>
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