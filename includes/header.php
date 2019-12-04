<!DOCTYPE html>
<html>
<head>
    <title>
        <?php 
        if( empty($page_title) ) 
            $page_title = "SUC Attendance"; 
        echo $page_title; 
        ?>
            
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- jquery -->
    <script type="text/javascript" src="/attendance/assets/jquery/jquery-3.4.1.min.js"></script>
    
    <!-- fontawesome -->
    <link rel="stylesheet" type="text/css" href="/attendance/assets/fontawesome-5.11.2/css/all.min.css">
    <script type="text/javascript" src="/attendance/assets/fontawesome-5.11.2/js/all.min.js"></script>

    <!-- jquery ui -->
    <link rel="stylesheet" type="text/css" href="/attendance/assets/jquery-ui/jquery-ui.min.css">
    <script type="text/javascript" src="/attendance/assets/jquery-ui/jquery-ui.min.js"></script>
    
    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="/attendance/assets/bootstrap-4.3.1/css/bootstrap.min.css">
    <script type="text/javascript" src="/attendance/assets/bootstrap-4.3.1/js/bootstrap.bundle.min.js"></script>
    
    <!-- datatable -->
    <link rel="stylesheet" type="text/css" href="/attendance/assets/datatable/dataTables.bootstrap4.min.css">
    <script type="text/javascript" src="/attendance/assets/datatable/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="/attendance/assets/datatable/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/attendance/assets/datatable/fixedHeader.bootstrap4.min.css">
    <script type="text/javascript" src="/attendance/assets/datatable/dataTables.fixedHeader.min.js"></script>


    <!-- bootbox -->
    <script type="text/javascript" src="/attendance/assets/bootbox/bootbox.all.min.js"></script>

    <!-- jquery chosen -->
    <link rel="stylesheet" type="text/css" href="/attendance/assets/chosen/chosen.min.css">
    <script type="text/javascript" src="/attendance/assets/chosen/chosen.jquery.min.js"></script> 

    <!-- js graph -->
    <script type="text/javascript" src="/attendance/assets/graph/js/Chart.bundle.js"></script>
    <script src="/attendance/assets/graph/js/raphael-2.1.4.min.js"></script>
    <script src="/attendance/assets/graph/js/justgage.js"></script>

    <link rel="stylesheet" type="text/css" href="/attendance/custom/styles/sidebar.css?d=<?= date("YmdHis"); ?>">
    <link rel="stylesheet" type="text/css" href="/attendance/custom/styles/common.css?date=<?= date("YmdHis"); ?>">
    <script type="text/javascript" src="/attendance/custom/scripts/script.js?date=<?= date("YmdHis"); ?>"></script>
    
</head>
<body>
    <?php 
    if(isset($_SESSION["message"]))
    {
        echo "<script>bootbox.alert('".$_SESSION["message"]."')</script>"; 
        unset($_SESSION["message"]); 
    }

    if($page_title != "Timetable") // if timetable page no need show this
    {
        if(USR_TYPE == 2)
        {
            if($not_start_class)
            {
                $sub_name = $current_class_row[0]["sub_name"]; 
                $sub_id = $current_class_row[0]["sub_id"]; 
                $time_id = $current_class_row[0]["time_id"]; 
                ?>
                <div class="col-sm-10 offset-sm-2">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        You have <b><?= $sub_name; ?></b> class now! Please <a class="alert-link" href="#" onclick="startClass('<?= $time_id;  ?>')">click here to start the class</a> or <a href="class_cancel.php?sub_id=<?= $sub_id; ?>&dates=<?= date("Y-m-d"); ?>" class="alert-link">click here to cancel class.</a> 
                    </div>
                </div>
                <?php 
            }

            if($display_class)
            {
                ?>
                <div class="pr-2" align="right">
                    <small class="badge text-light label-urgent">Click the QR icon to show the QR code.</small>
                    <i class="fas fa-qrcode pointer" data-toggle="modal" data-target="#modal-qrcode"></i>
                </div>
                <?php 
            }
        }
    }
    

    ?>