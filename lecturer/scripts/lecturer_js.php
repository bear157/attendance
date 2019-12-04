<script type="text/javascript">
    
    function startClass(time_id)
    {
        $.ajax({
            type: "POST", 
            url: "/attendance/lecturer/ajax_start_class.php", 
            data: {time_id: time_id}, 
            success: function(data)
            {
                console.log(data); 
                var output = JSON.parse(data); 
                if(output.success == 1)
                {
                    window.location.reload(); 
                }
            }
        });
    }

    /** 
     * this param 'value' is consisted by time_id and date; format `time_id||date`
     * sub_id is set at view_subject_class.php
     */
    function getClassAttendance(value) 
    {
        $("#attendance-content").load("ajax_class_attendance.php", {value: value, sub_id: sub_id}); 
    }

    // dashboard use
    function getSubjectChart(sub_id) 
    {
        $("#chart-box").load("attendance_chart.php", {sub_id: sub_id}); 
    }
</script>