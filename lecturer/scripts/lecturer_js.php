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

</script>