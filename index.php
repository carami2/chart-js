<?php
    include 'src/helpers.php';
    include 'src/RandomColor.php';
    use \Colors\RandomColor;

    // open csv
    $arrCSV = openCSV("data/2010-2017 MCIAA Passenger movement monthly.csv");

    // use as chart colors
    $arrColor = [
        RandomColor::one(array('luminosity'=>'dark','hue'=>'red','format'=>'rgbCss')),
        RandomColor::one(array('luminosity'=>'dark','hue'=>'blue','format'=>'rgbCss')),
        RandomColor::one(array('luminosity'=>'dark','hue'=>'orange','format'=>'rgbCss')),
        RandomColor::one(array('luminosity'=>'dark','hue'=>'pink','format'=>'rgbCss'))
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/basscss.min.css">
    <link rel="stylesheet" href="css/main.css">
    <!-- http://www.chartjs.org/ and https://github.com/ashiguruma/patternomaly/ plugin -->
	<script src="js/vendor/Chart.min.js"></script>
	<script src='js/vendor/patternomaly.js'></script>
	<title>Chart JS | MCIAA Passenger movement monthly</title>
</head>
<body>
	<div class="container">
        <label for="pattern-switch">
            <input type="checkbox" id="pattern-switch">Toggle patterns
        </label>
		<canvas id="chartHolder"></canvas>
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')
    </script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script>
		Chart.defaults.global.defaultFontColor = '#777';

		let color = Chart.helpers.color;
		let colors = <?php echo json_encode($arrColor) ?>;
		let patterns = pattern.generate(colors);

		function createConfig() {
			return {
				type: 'bar',
				data: {
					labels: <?php echo json_encode($arrCSV['month']); ?>,
					datasets: [
					{
						label: '# of Passengers in 2014',
						data: <?php echo json_encode($arrCSV['2014'], JSON_NUMERIC_CHECK); ?>,
						backgroundColor: color(colors[0]).alpha(0.9).rgbString(),
						borderColor: colors[0]
					},
					{
						label: '# of Passengers in 2015',
						data: <?php echo json_encode($arrCSV['2015'], JSON_NUMERIC_CHECK); ?>,
						backgroundColor: color(colors[1]).alpha(0.9).rgbString(),
						borderColor: colors[1]
					},
					{
						label: '# of Passengers in 2016',
						data: <?php echo json_encode($arrCSV['2016'], JSON_NUMERIC_CHECK); ?>,
						backgroundColor: color(colors[2]).alpha(0.9).rgbString(),
						borderColor: colors[2]
					},
					{
						label: '# of Passengers in 2017',
						data: <?php echo json_encode($arrCSV['2017'], JSON_NUMERIC_CHECK); ?>,
						backgroundColor: color(colors[3]).alpha(0.9).rgbString(),
						borderColor: colors[3]
					}],
				},
				options: {
					animation: {
	                    duration: 2000,
	                },
					title: {
						display: true,
						text: 'MCIAA Passenger movement monthly',
						fontSize: 32,
                        fontColor: '#333'
					},
					layout: {
						padding: {
						    bottom: 10
                        }
					},
					responsive: true,
					scaleShowValues: true,
					scales: {
						yAxes: [{
							display: true,
							scaleLabel: {
	                            display: true,
	                            labelString: 'Amount',
                                fontSize: 24,
                                fontColor: '#333'
	                        },
							ticks: {
								beginAtZero: true
							}
						}],
						xAxes: [{
							display: true,
							scaleLabel: {
	                            display: true,
	                            labelString: 'Month',
                                fontSize: 24,
                                fontColor: '#333'
	                        },
							ticks: {
								autoSkip: false
							}
						}]
					},
					tooltips: {
						position: 'average',
						mode: 'index',
						intersect: false
					}
				}
			};
		}

		// init chart
		let ctx = document.getElementById("chartHolder").getContext('2d');
		let config = createConfig();
		let mciaaBarChart = new Chart(ctx, config);

		// toggle to add pattern
		let patternSwitch = document.querySelector('#pattern-switch');

		patternSwitch.addEventListener('change', function (e) {
			let fill = (e.currentTarget.checked) ? patterns : colors;
			
			for(let i in mciaaBarChart.data.datasets){
				mciaaBarChart.data.datasets[i].backgroundColor = (e.currentTarget.checked) ? fill[i] : color(fill[i]).alpha(0.9).rgbString();
			}
			mciaaBarChart.update();
		});
	</script>
</body>
</html>