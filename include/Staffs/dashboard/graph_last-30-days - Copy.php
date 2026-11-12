<div style="clear:both;"></div>
<div class="dashboard-widget">
<div class="col-lg-12">
    <h2 style="font-size:20px;font-weight:600;color:#000000;padding-left:10px;padding-top:30px;">Day-wise Stats:</h2>
    <div id="container" style="width: 100%;">
        <canvas id="canvas4"></canvas>
    </div>
	<script type="text/javascript">
        var config1 = {
			type: 'line',
			data: {
				labels: [
                    <?php
                        $srno = 0;

                        // Comparison function 
                        function date_compare($element1, $element2) { 
                            $datetime1 = strtotime($element1['dated']); 
                            $datetime2 = strtotime($element2['dated']); 
                            return $datetime1 - $datetime2; 
                        } 

                        // Sort the array 
                        usort($jobordersCount, 'date_compare'); 

                        foreach($jobordersCount as $valuePrg){
                            $srno++;
                            if($srno <= 20){
                                if($srno != 20){$comma = ',';}else{$comma = '';}
                                echo "'".(date("j F y", strtotime($valuePrg['dated'])))."'".$comma;
                            }
                        }
                    ?>
                    ],
				datasets: [{
					label: 'No. of Applicants',
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [
						<?php
                        $srno = 0;
                        foreach($jobordersCount as $valuePrg){
                            $srno++;
                            if($srno <= 20){
                                if($srno != 20){$comma = ',';}else{$comma = '';}
                                echo "'".($valuePrg['Total'])."'".$comma;
                            }
                        }
                        ?>
					],
					fill: false,
				}]
			},
			options: {
				responsive: true,
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Applicants'
						}
					}]
				}
			}
		};

		window.onload = function() {

            var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					}
				}
            });
            
			var ctx1 = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx1, config);
            
            var ctx2 = document.getElementById('canvas2').getContext('2d');
			window.myBar = new Chart(ctx2, {
				type: 'bar',
				data: barChartData2,
				options: {
					responsive: true,
					tooltips: {
						mode: 'index',
						intersect: true
					},
					scales: {
						yAxes: [{
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: 'left',
                            id: 'y-axis-1',
                            beginAtZero:true,
						}],
					}
				}
			});

            var ctx3 = document.getElementById('canvas3').getContext('2d');
			window.myBar = new Chart(ctx3, {
				type: 'bar',
				data: barChartData3,
				options: {
					responsive: true,
					tooltips: {
						mode: 'index',
						intersect: true
					},
					scales: {
						yAxes: [{
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: 'left',
                            id: 'y-axis-1',
                            beginAtZero:true,
						}],
					}
				}
			});

            var ctx4 = document.getElementById('canvas4').getContext('2d');
			window.myLine = new Chart(ctx4, config1);

			/*
			var ctx5 = document.getElementById('canvas5').getContext('2d');
			window.myLine = new Chart(ctx5, config2);
			*/
		};

	</script>
</div>
</div>