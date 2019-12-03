<html>
    <head>
        <script type="text/javascript" src="../jquery/jquery-3.4.1.js"></script>
        <script type="text/javascript" src="js/Chart.bundle.js"></script>
        <script src="js/raphael-2.1.4.min.js"></script>
        <script src="js/justgage.js"></script>
    </head>
    <body>
        <?php
            include("diagramdraw.php");
            $draw = new diagramdraw();
        ?>
        <div id="g1"></div>
        <?php
            $value=68;
            $canvasId="g1";
            $charttitle="Graph 1";
            $draw->meter_graph($value, $canvasId, $charttitle);
        ?>
        <canvas id="graph2"></canvas>
        <?php
            $item = "A,B,C";
            $value = "12,36,20";
            $canvasId = "graph2";
            $color = "#8290e3";
            $charttitle = " ";
            $label = "Item Stock";
            $xaxis = "Item";
            $yaxis = "Quatity";
            $draw->line_chart($item, $value, $canvasId , $color, $charttitle, $label, $xaxis , $yaxis);
        ?>
    </body>
</html>