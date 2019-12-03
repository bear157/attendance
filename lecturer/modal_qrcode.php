<?php
if($display_class)
{
    include 'generate_qrcode.php';

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