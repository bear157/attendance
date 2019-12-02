<?php
include '../lock.php';

if(isset($_GET["sub_id"]) && !empty($_GET["sub_id"]))
{
    $sub_id = $_GET["sub_id"]; 
    
}
else
{
    die(header("Location: view_subject.php")); 
}


// load subject class
$sub_class = new Subject($db->conn); 
// get the subject info
$sub_info = $sub_class->getSingleSubject($sub_id); 
if($sub_info["lecturer"] != USR_ID) 
{
    die(header("Location: view_subject.php")); // if not this lecturer, header to subject page
}

// page header
include "../includes/header.php"; 
// side menu
include "../includes/sidebar_lecturer.php"; 
?>
<div class="col-sm-10 offset-sm-2">

    <h3><?= $sub_info["sub_code"]." - ".$sub_info["sub_name"]; ?></h3>
    <div class="form-group">
        <label class="" for="class-input">
            <span>Class: </span>
            <select class="form-control-sm chosen" name="" id="class-input">
                <option></option>
            </select>
        </label>
    </div>

    <hr>

</div>
<?php 
// page footer
include "../includes/footer.php";
?>