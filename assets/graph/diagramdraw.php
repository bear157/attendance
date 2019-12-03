<?php
class diagramdraw {
    
    public function showCharttext() {
        return "<script>
            Chart.plugins.register({
				afterDatasetsDraw: function(chart, easing) {
					var ctx = chart.ctx;

					chart.data.datasets.forEach(function (dataset, i) {
						var meta = chart.getDatasetMeta(i);
						if (!meta.hidden) {
							meta.data.forEach(function(element, index) {
							    ctx.fillStyle = 'rgb(169,169,169)';

						    	var fontSize = 18;
						    	var fontStyle = 'bold';
                                var fontColor = 'black';
						    	var fontFamily = 'Helvetica Neue';
						    	ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);

						    	var dataString = dataset.data[index].toString();
                                
                                if (dataString > 5) {
                                    ctx.font = fontSize+'px '+fontFamily+fontColor;
    						    	ctx.textAlign = 'center';
    						    	ctx.textBaseline = 'middle';
    
    						    	var padding = 5;
    						    	var position = element.tooltipPosition();
    						    	ctx.fillText(dataString+'%', position.x-(fontSize/2)+padding, position.y-padding);
                                }
						    });
					    }
				    });
				}
			});
		</script>";
    }
    public function pie_chart($item,$value,$canvasId,$color,$charttitle){
        $data1 = $item;
        $data2 = $value;
        echo "<script>
            var piedata = {
                type: 'pie',
                data: {
                    datasets: [{
                        data: [$data2],
                        backgroundColor: [";
                        $arr=explode(",",$color);
                        for($i=0; $i<sizeof($arr); $i++) {
                            echo "'$arr[$i]'";
                            if ($i < sizeof($arr)-1) {
                                echo ",";
                            }
                        }
                        echo "],
                        label: 'Dataset 1'
                    }],
                    labels: [";
                    $arr=explode(",",$data1);
                    for($i=0; $i<sizeof($arr); $i++) {
                        echo "'$arr[$i]'";
                        if ($i < sizeof($arr)-1) {
                            echo ",";
                        }
                    }
                    echo "]
                },
                options: {
                    responsive: false,
                    title: {
                        display: true,
                        text: '$charttitle',
                        fontSize: 16,
                        fontColor: 'black'
                    }
                }
            };
            
            var ctx = document.getElementById('$canvasId').getContext('2d');
            window.myPie = new Chart(ctx, piedata);
        </script>";
    }
    
    public function bar_chart($item,$value,$canvasId,$color,$charttitle) {
        $data1 = $item;
        $data2 = $value;
        $arrdata = explode("|",$data2);
        $colorArr = explode(",",$color);
        echo "<script>
            var barChartData = {
                labels: [";
                $arr=explode(",",$data1);
                for($i=0; $i<sizeof($arr); $i++) {
                    echo "'$arr[$i]'";
                    if ($i < sizeof($arr)-1) {
                        echo ",";
                    }
                }
            echo "],
                datasets: [";
                for ($i=0; $i<sizeof($arrdata); $i++) {
                    $data = explode(",",$arrdata[$i]);
                    echo "{
                        label: 'Dataset $i',
                        backgroundColor: '$colorArr[$i]',
                        borderColor: '$colorArr[$i]',
                        borderWidth: 1,
                        data: [";
                        for ($x=0; $x<sizeof($data); $x++) {
                            echo $data[$x];
                            if ($x<sizeof($data)-1) {
                                echo ",";
                            }
                        }
                    echo "]";
                    if ($i == sizeof($arrdata)-1) {
                        echo "}";
                    }
                    else {
                        echo "},";
                    }
                }
        echo "]
            };

            var ctx = document.getElementById('$canvasId').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: false,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: '$charttitle'
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: 'black'
                            }
                        }]
                    }
                }
            });
        </script>";
    }
    
    public function bar_chart_horizontal($item,$value,$canvasId,$color,$charttitle) {
        $data1 = $item;
        $data2 = $value;
        $arrdata = explode("|",$data2);
        $colorArr = explode(",",$color);
        echo "<script>
            var horizontalBarChartData = {
                labels: [";
                $arr=explode(",",$data1);
                for($i=0; $i<sizeof($arr); $i++) {
                    echo "'$arr[$i]'";
                    if ($i < sizeof($arr)-1) {
                        echo ",";
                    }
                }
            echo "],
                datasets: [";
                for ($i=0; $i<sizeof($arrdata); $i++) {
                    $data = explode(",",$arrdata[$i]);
                    echo "{
                        label: 'Dataset $i',
                        backgroundColor: '$colorArr[$i]',
                        borderColor: '$colorArr[$i]',
                        borderWidth: 1,
                        data: [";
                        for ($x=0; $x<sizeof($data); $x++) {
                            echo $data[$x];
                            if ($x<sizeof($data)-1) {
                                echo ",";
                            }
                        }
                    echo "]";
                    if ($i == sizeof($arrdata)-1) {
                        echo "}";
                    }
                    else {
                        echo "},";
                    }
                }
        echo "]
            };
            
            var ctx = document.getElementById('$canvasId').getContext('2d');
            window.myHorizontalBar = new Chart(ctx, {
                type: 'horizontalBar',
                data: horizontalBarChartData,
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                        }
                    },
                    responsive: false,
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: '$charttitle'
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>";
    }
    
    //edited by Jasper
    public function line_chart($item,$value,$canvasId,$color,$charttitle,$label,$xaxis,$yaxis) {
        $data1 = $item;
        $data2 = $value;
        $arrdata = explode("|",$data2);
        $colorArr = explode(",",$color);
        $labelArr = explode(",",$label);
        echo "<script>
            var linedata = {
                type: 'line',
                data: {
                    labels: [";
                        $arr=explode(",",$data1);
                        for($i=0; $i<sizeof($arr); $i++) {
                            echo "'$arr[$i]'";
                            if ($i < sizeof($arr)-1) {
                                echo ",";
                            }
                        }
                    echo "],
                    datasets: [";
                    for ($i=0; $i<sizeof($arrdata); $i++) {
                        $data = explode(",",$arrdata[$i]);
                        echo "{
                            label: '$labelArr[$i]',
                            backgroundColor: '$colorArr[$i]',
                            borderColor: '$colorArr[$i]',
                            data: [";
                            for ($x=0; $x<sizeof($data); $x++) {
                                echo $data[$x];
                                if ($x<sizeof($data)-1) {
                                    echo ",";
                                }
                            }
                        echo "],
                            fill: false,";
                        if ($i == sizeof($arrdata)-1) {
                            echo "}";
                        }
                        else {
                            echo "},";
                        }
                    }
                    echo "]
                    },
                    options: {
                        responsive: false,
                        // title:{
                        //     display:true,
                        //     text:'$charttitle',
                        //     fontSize: 15,
                        //     fontColor: 'black'
                        // },
                        legend: {
                            labels: {
                                fontSize: 13,
                                fontColor: 'black'
                            }
                        },
                        tooltips: {
                            mode: 'index',
                            intersect: false,
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    fontColor: 'black',
                                    fontSize: 13,
                                    labelString: '".$xaxis."'
                                },
                                ticks: {
                                    fontColor: 'black',
                                    autoSkip:false
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    fontColor: 'black',
                                    fontSize: 13,
                                    labelString: '".$yaxis."'
                                },
                                ticks: {
                                    beginAtZero: true,
                                    fontColor: 'black'
                                }
                            }]
                        }
                    }
                };";

                echo "var ctx = document.getElementById('$canvasId').getContext('2d');
                    window.myLine = new Chart(ctx, linedata);
        </script>";
    }
    
    function bar_stack_chart($item,$value,$canvasId,$color,$charttitle) {
        $data1 = $item;
        $data2 = $value;
        $arrdata = explode("|",$data2);
        $colorArr = explode(",",$color);
        echo "<script>
            var barChartData = {
                labels: [";
                $arr=explode(",",$data1);
                for($i=0; $i<sizeof($arr); $i++) {
                    echo "'$arr[$i]'";
                    if ($i < sizeof($arr)-1) {
                        echo ",";
                    }
                }
            echo "],
                datasets: [";
                for ($i=0; $i<sizeof($arrdata); $i++) {
                    $data = explode(",",$arrdata[$i]);
                    echo "{
                        label: 'My $i dataset',
                        backgroundColor: '$colorArr[$i]',
                        borderColor: '$colorArr[$i]',
                        data: [";
                        for ($x=0; $x<sizeof($data); $x++) {
                            echo $data[$x];
                            if ($x<sizeof($data)-1) {
                                echo ",";
                            }
                        }
                    echo "],
                        fill: false,";
                    if ($i == sizeof($arrdata)-1) {
                        echo "}";
                    }
                    else {
                        echo "},";
                    }
                }
                echo "]
            };
            var ctx = document.getElementById('$canvasId').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    title:{
                        display:true,
                        text:'$charttitle'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: false,
                    scales: {
                        xAxes: [{
                            stacked: true,
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        </script>";
    }

    function meter_graph($value,$canvasId,$charttitle) {
        echo "<script>
            var g1 = new JustGage({
                id: '$canvasId',
                value: $value,
                min: 0,
                max: 100,
                title: '$charttitle',
                symbol: '%',
                pointer: true,
                gaugeWidthScale: 0.6,
                customSectors: [{
                    color: '#ff0000',
                    lo: 0,
                    hi: 49
                }, {
                    color: '#ff9900',
                    lo: 50,
                     hi: 59
                }, {
                    color: '#00ff00',
                    lo: 60,
                    hi: 100
                }],
                counter: true
            });
        </script>";
    }
    
}
?>