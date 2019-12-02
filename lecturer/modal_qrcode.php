<?php
if($display_class)
{
    include "../assets/phpqrcode/qrlib.php"; 
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/'; 
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);


    // qrcode properties
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 5;

    // user data 
    $act_id = $current_class_row[0]["act_id"]; 
    $sub_id = $current_class_row[0]["sub_id"]; 
    $sub_name = $current_class_row[0]["sub_name"]; 
    $sub_code = $current_class_row[0]["sub_code"]; 

    $ip = "192.168.43.154"; 
    $data = "http://".$ip.":81/attendance/index.php?aid=".md5($act_id)."&sub=".md5($sub_id);
    // $data = $current_class_row[0]["ref_text"]; 
    $filename = $PNG_TEMP_DIR.'class'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
    QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 

?>
<div class="modal" id="modal-qrcode">
    <div class="modal-dialog modal-lg mw-100 m-2">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?= $sub_code." - ".$sub_name; ?></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div align="center">
                    <?php echo '<img class="col-10 col-sm-4" src="'.$PNG_WEB_DIR.basename($filename).'" id="qrcode" />'; ?>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<?php 
}
?>