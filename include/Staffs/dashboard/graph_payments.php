<div style="clear:both;"></div>
<div class="dashboard-widget">

  
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
    </script>
 
   


<div class="col-lg-12">
    <!--h2 style="font-size:20px;font-weight:600;color:#000000;padding-left:10px;padding-top:30px;">Day-wise Stats:</h2-->

     <div id="piechart_3d" style="width: 1000px; height: 500px; margin: auto;"></div>
	
</div> 
</div>