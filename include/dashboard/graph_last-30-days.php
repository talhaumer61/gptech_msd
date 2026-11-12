<div style="clear:both;"></div>
<div class="dashboard-widget">

  
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Orders', 'Dispatched', 'Pending', 'SaveHold'],
		<?php 
		foreach($Mothlyorders as $monthlyorders){ 
          echo  "[
		  			'".$monthlyorders['month']."'			,
					".$monthlyorders['Total']."				,
					".$monthlyorders['totalDispatched']."	,
					".$monthlyorders['totalPending']."		,
					".$monthlyorders['totalSaveHold']."
				],";
		}
        ?>
        ]);

        var options = {
          title : 'Monthly Job Orders',
          vAxis: {title: 'Job Orders'},
          hAxis: {title: 'Month'},
          seriesType: 'bars',
			colors: ['green', 'blue', 'orangered', 'crimson'],
          series: {5: {type: 'line'}}
        };

        var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>






<div class="col-lg-12">
    <!--h2 style="font-size:20px;font-weight:600;color:#000000;padding-left:10px;padding-top:30px;">Day-wise Stats:</h2-->

    <div id="chart_div" style="width: 100% !important; height: 500px;"></div>
	
</div> 
</div>