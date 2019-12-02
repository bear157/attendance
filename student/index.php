<?php
include '../lock.php';


// page header
include "../includes/header.php"; 
// side menu
// include "../includes/sidebar_lecturer.php"; 
?>
<div class="col-sm-10 offset-sm-2">
<?= $_SESSION["message"];  ?>
</div>
<?php 
// page footer
include "../includes/footer.php";
?>