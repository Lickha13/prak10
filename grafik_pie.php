<?php
include('koneksi.php'); //include file koneksi.php
$persebarannegara = mysqli_query($koneksi,"select * from tb_country"); //menuliskan query untuk mengambil data di tabel tb_country
while($row = mysqli_fetch_array($persebarannegara)){ //extract data hasil query di baris 3 dan datanya kita simpan di variabel $row
	$nama_negara[] = $row['nama_country']; //membuat array dengan nama $nama_negara, dimana array ini digunakan untuk menyimpan nama barang hasil query dibaris 3
	
	$query = mysqli_query($koneksi,"select sum(total_cases) as total_cases from tb_covid where id_country='".$row['id_country']."'"); //menuliskan query untuk menjumlahkan nilai pada kolom jumlah di tabel tb_covid, berdasarkan id_country disetiap perulangan data country
	$row = $query->fetch_array(); //membuat variabel $row digunakan untuk menyimpan hasil query di baris 7 kedalam bentuk array dengan perintah fetch_array
	$total_cases[] = $row['total_cases']; //membuat array $total_cases untuk menyimpan data jumlah disetiap barang yang terjual di tabel tb_covid
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Pie Chart</title>
	<script type="text/javascript" src="Chart.js"></script> <!-- memanggil file Chart.js agar kita bisa membuat grafik dengan menggunakan Chart.js -->
</head>

<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas> <!-- membuat sebuah object dengan menggunakan tag <canvas> dimana didalamnya kita menuliskan nama id=”canvas-area” -->
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($total_cases); ?>, //menuliskan bagian data dari chart, karena sebelumnya kita telah memiliki array dengan nama $total_cases yang berisi jumlah dari penjualan barang perbulan, sehingga kita tinggal menggunakan json_encode untuk konversi array $total_cases menjadi bentuk JSON
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(255, 50, 132, 0.2)',
					'rgba(50, 200, 30, 0.2)',
					'rgba(255, 20, 180, 0.2)',
					'rgba(80, 150, 60, 0.2)',
					'rgba(200, 100, 60, 0.2)',
					'rgba(40, 100, 30, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(255, 50, 132, 1)',
					'rgba(50, 200, 30, 1)',
					'rgba(255, 20, 180, 1)',
					'rgba(80, 150, 60, 1)',
					'rgba(200, 100, 60, 1)',
					'rgba(40, 100, 30, 1)'
					],
					label: 'Presentase Persebaran Covid' //set bagian judul chart
				}],
				labels: <?php echo json_encode($nama_negara); ?>}, //menuliskan label dari chart, karena sebelumnya kita telah memiliki array dengan nama $nama_negara yang berisi daftar nama barang, sehingga kita tinggal menggunakan perintah json_encode untuk konversi array $nama_negara menjadi bentuk JSON
			options: {
				responsive: true
			}
		};
 
		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d'); //menuliskan bagian ID chart-area yang kita tulis pada baris 22
			window.myPie = new Chart(ctx, config);
		};
 
		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});
 
			window.myPie.update();
		});
 
		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};
 
			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
 
				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}
 
			config.data.datasets.push(newDataset);
			window.myPie.update();
		});
 
		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>
</body>

</html>