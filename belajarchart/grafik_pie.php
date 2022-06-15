<?php
include('koneksi.php');
$covid = mysqli_query($conn, "select * from tb_covid");
while ($row = mysqli_fetch_array($covid)){
	$nama_negara[] = $row['country'];
	$query=mysqli_query($conn, "select total_cases from tb_covid where id_country='".$row['id_country']."'");
	$row = $query->fetch_array();
	$totalcases[] = $row['total_cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pie Chart</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div id="canvas-holder" style="width:80%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($totalcases);
					?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(255, 85, 32, 0.2)',
					'rgba(75, 180, 72, 0.2)',
					'rgba(54, 80, 180, 0.2)',
					'rgba(255, 135, 75, 0.2)',
					'rgba(25, 20, 255, 0.2)',
					'rgba(75, 80, 100, 0.2)'],
					borderColor:[
					'rgba(255, 99, 132, 1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(255, 85, 32, 1)',
					'rgba(75, 180, 72, 1)',
					'rgba(54, 80, 180, 1)',
					'rgba(255, 135, 75, 1)',
					'rgba(25, 20, 255, 1)',
					'rgba(75, 80, 100, 1)'],
					label:'Presentase Data Covid'
				}],
				labels:<?php echo json_encode($nama_negara);?>},
				options: {
					responsive: true
				}
				};
				window.onload = function(){
					var ctx = document.getElementById('chart-area').getContext('2d');
					window.myPie = new Chart (ctx, config);
				};
				document.getElementById('randomizeData').addEventListener('click', function(){
					config.data.datasets.forEach(function(dataset){
						dataset.data = dataset.data.map(function(){
							return randomScalingFactor();
						});
					});
					window.myPie.update();
				});
var colorNames = Object.keys(window.chartColors);
document.getElementById('addDataset').addEventListener('click', function(){
	var newDataset ={
		backgroundColor: [],
		data: [],
		label: 'New dataset ' + config.data.datasets.length,};
		for (var index = 0; index < config.data.labels.length; ++index){
			newDataset.data.push(randomScalingFactor());
			var colorName = colorNames[index %colorNames.length];
			var newColor = window.chartColors[colorName];
			newDataset.backgroundColor.push(newColor);
		}
		config.data.datasets.push(newDataset);
		window.myPie.update();
		});
document.getElementById('removeDataset').addEventListener('click', function(){
	config.data.datasets.splice(0, 1);
	window.myPie.update();
});
</script>
</body>
</html>