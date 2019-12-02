<?php 

// ============================== check lecturer has class currently or not ==============================//
$sub_class = new Subject($db->conn);
$current_class_row = $sub_class->checkClass(); 
if(count($current_class_row)>0)
{
    //========= if have class ========//
    //========= check lecturer has started class or not ========//
    $act_id = $current_class_row[0]["act_id"]; 
    if(is_null($act_id))
    {
        $not_start_class = true; 
        $display_class = false; 
    }
    else
    {
        $not_start_class = false; 
        $display_class = true; 
    }
}
else
{
    $not_start_class = false; 
    $display_class = false; 
}




?>