<?php
include '../lock.php';

// page header
include "../includes/header.php"; 
// side menu
include "../includes/sidebar_student.php"; 


// load subject class
$sub_class = new Subject($db->conn); 

// retrieve subject
$sub_row = $sub_class->getAllSubject(); 
?>
<div class="col-sm-10 offset-sm-2">
    <h3>Attendance Status</h3>

    <hr>

    <table class="w-50 font-weight-bold mb-3" cellpadding="1">
        <tr>
            <td width="30%">Student ID:</td>
            <td><?= USR_NAME; ?></td>

        </tr>

        <tr>
            <td>Student Name:</td>
            <td><?= USR_FULL_NAME; ?></td>
        </tr>

        <tr>
            <td>Year / Semester: </td>
            <td class="text-danger"><?= SEM_YEAR." Semester ".SEM_NUMBER; ?></td>
        </tr>
    </table>

    <div>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>No.</th>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Absent Hour(s)</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                foreach ($sub_row as $key => $row) 
                {
                    $sub_code = $row["sub_code"]; 
                    $sub_name = $row["sub_name"]; 
                    $sub_id = $row["sub_id"]; 

                    $absent_hours = $sub_class->getSubjectAbsentHours($sub_id); 
                    ?>
                    <tr>
                        <td><?= ++$key; ?></td>
                        <td><?= $sub_code; ?></td>
                        <td><?= $sub_name; ?></td>
                        <td><?= $absent_hours; ?></td>
                    </tr>
                    <?php 
                } //  end foreach

                ?>
            </tbody>
        </table>
    </div>


</div>
<?php 
// page footer
include "../includes/footer.php";
?>