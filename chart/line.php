<?php 
include ('koneksi.php'); 
	$covid = mysqli_query($conn,"select * from tb_covid"); 
	while ($row = mysqli_fetch_array($covid) ) {
		$nama_negara[] = $row['country']; 

		$query = mysqli_query($conn,"select total_cases, new_cases, total_deaths, new_deaths, total_recover, new_recover from tb_covid where id_country='". $row['id_country']."'"); 
		$row = $query->fetch_array(); 
		$semuakasus[] = $row['total_cases']; 
		$kasusbaru[] = $row['new_cases']; 
		$totalkematian[] = $row['total_deaths'];  
		$kematianbaru[] = $row['new_deaths']; 
		$totalsembuh[] = $row['total_recover']; 
		$sembuhbaru[] = $row['new_recover']; 
	}
?>

<!DOCTYPE html> 
<html> 
<head>
	<title>Membuat Grafik Menggunakan Chart JS</title>
<script type="text/javascript" src="Chart.js"></script></head> 
<body>
	<br>
	<h1 style="font-display: Calibri;" "font-family: Calibri;" font align=center>Line Chart - Data Covid 10 Negara</h1>
	<br>
	<div class="container" align="center">
	<div style="width: 800px; height: 800px">
		<canvas id="ChartLine"></canvas>

	</div> 

	<script> 
		var ctx1 = document.getElementById("ChartLine").getContext('2d'); 
		var myChart = new Chart (ctx1, { 
			type: 'line', 
			data: { 
				labels: <?php echo json_encode($nama_negara); ?>, 
				datasets: [{
					label: 'Total Cases', 
					data: <?php echo json_encode($semuakasus);?>,

					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				},
				{
					label: 'New Cases', 
					data: <?php echo json_encode($kasusbaru);?>,

					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				},
				{
			
					label: 'Total Deaths', 
					data: <?php echo json_encode($totalkematian);?>,

					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				},
				{	
					label: 'New Deaths', 
					data: <?php echo json_encode($kematianbaru);?>,

					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				},
				{
					label: 'Total Recovered', 
					data: <?php echo json_encode($totalsembuh);?>,

					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				},
				{
					label: 'New Recovered', 
					data: <?php echo json_encode($sembuhbaru);?>,

					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255,99,132,1)',
					borderWidth: 1
				}]
			}, 
			options: { 
				scales: {
					YAxes: [{
						ticks : { 
							beginAtZero:true 
						}
					}]
				}
			} 
		});
	</script>
</body> 
</html>