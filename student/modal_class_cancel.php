<?php
// load subject class
$sub_class = new Subject($db->conn); 


// get cancel class
$cancel_row = $sub_class->getCancelMessage();
?>
<div class="modal" id="modal-cancel-msg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Class Cancel</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Subject</th>
                            <th>Cancel Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($cancel_row as $key => $row) 
                        {
                            $cancel_date = $row["cancel_date"]; 
                            $sub_code = $row["sub_code"]; 
                            $sub_name = $row["sub_name"]; 
                            $reason = $row["reason"]; 

                            ?>
                            <tr>
                                <td><?= $cancel_date; ?></td>
                                <td><?= "$sub_code $sub_name"; ?></td>
                                <td><?= $reason; ?></td>
                            </tr>
                            <?php
                        }// end foreach

                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>