<?php
$data = explode('-', date('Y-m-d'));

for($i = 1; $i<=12; $i++){
if($i >= 10) $month = $i;
else $month = '0'.$i;
$query = $this->db->query("SELECT ilosc FROM new_graph WHERE data = '".$data[0].' '.$month."'");
$result = $query->row_array();
$wykres[$i] = $result['ilosc'];
if($wykres[$i] == '') $wykres[$i] = 0;
}

/*for($i = 1; $i<=12; $i++){
if($i >= 10) $month = $i;
else $month = '0'.$i;
$stmt = $pdo->query("SELECT ilosc FROM new_graph WHERE data = '".$data[0].' '.$month."'");
$nowi = $stmt->fetchAll(PDO::FETCH_NUM);
$wykres[$i] = $nowi[0][0];
if($wykres[$i] == '') $wykres[$i] = 0;
}*/
?>

<div id="wykres_nowych" class="col-md-12" style="margin-bottom: 15px;">

        <canvas id="wykres" width="100%" style="height: 300px;"></canvas>

</div>
<!-- /.box -->

<script>
var ctx = document.getElementById("wykres").getContext("2d");
var data = {
    labels: ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Pazdziernik", "Listopad", "Grudzień"],
    datasets: [
        {
            label: "<?php echo date("y"); ?>",
            fillColor: "rgba(60,141,188,0.9)",
            strokeColor: "rgba(60,141,188,0.8)",
            pointColor: "#3b8bba",
            pointStrokeColor: "rgba(60,141,188,1)",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(60,141,188,1)",
            data: [<?php for($i = 1; $i<=12; $i++){
                if($i == 12)
                    echo $wykres[$i].'';
                else
                    echo $wykres[$i].',';
                
            } ?>]
        }
    ]
};

var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };
var myLineChart = new Chart(ctx).Line(data, areaChartOptions);
    
$("#wykres_nowych").hide();
</script>