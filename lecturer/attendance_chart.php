<?php 
if(!isset($db))
{
    include "../lock.php"; 
    $selected_sub_id = $_POST["sub_id"]; 

    // load subject class
    $sub_class = new Subject($db->conn); 
}


// graph object
include("../assets/graph/diagramdraw.php");
$draw = new diagramdraw();


// get chart data 
list($act_id, $count_all_student, $count_present_student, $dates) = $sub_class->getSubjectChartData($selected_sub_id); 
$count_absent_student = $count_all_student - $count_present_student;


?>
<?php 
if($act_id == 0)
    echo "<p>No attendance record! Check other subject.</p>";
else
{

?>


<div align="center">
    <canvas class="" id="pie-chart"></canvas>
    <?php 
    $item = "Present,Absent";
    $value = "$count_present_student,$count_absent_student";
    $canvasId = "pie-chart";
    $color = "#007bff,#dc3545";
    $charttitle = "Class date: $dates"; 
    $draw->pie_chart($item, $value, $canvasId , $color, $charttitle);
    ?>
</div>

<?php
} // end if else
?>

