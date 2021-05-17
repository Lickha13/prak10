<?php
include('koneksi.php'); //include file koneksi.php
$persebarannegara = mysqli_query($koneksi,"select * from tb_country"); //menuliskan query untuk mengambil data di tabel tb_country
while($row = mysqli_fetch_array($persebarannegara)){ //extract data hasil query di baris 3 dan datanya kita simpan di variabel $row
	$nama_negara[] = $row['nama_country']; //membuat array dengan nama $nama_negara, dimana array ini digunakan untuk menyimpan nama barang hasil query dibaris 3
	
	$query = mysqli_query($koneksi,"select sum(total_cases) as total_cases from tb_covid where nama_country='".$row['nama_country']."'"); //menuliskan query untuk menjumlahkan nilai pada kolom jumlah di tabel tb_covid, berdasarkan id_country disetiap perulangan data country
	$row = $query->fetch_array(); //membuat variabel $row digunakan untuk menyimpan hasil query di baris 7 kedalam bentuk array dengan perintah fetch_array
	$total_cases[] = $row['total_cases']; //membuat array $total_case untuk menyimpan data jumlah disetiap barang yang terjual di tabel tb_pcovid
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Membuat Grafik Menggunakan Chart JS</title>
	<script type="text/javascript" src="Chart.js"></script> <!-- memanggil file Chart.js agar kita bisa membuat grafik dengan menggunakan Chart.js -->
</head>
<body>
	<div style="width: 800px;height: 800px">
		<canvas id="myChart"></canvas> <!-- membuat sebuah object dengan menggunakan tag <canvas> dimana didalamnya kita menuliskan nama id=”myChart” -->
	</div>
 
 
	<script>
		var ctx = document.getElementById("myChart").getContext('2d'); //menuliskan myChart itu adalah id dari object yang kita buat di baris 20
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($nama_negara); ?>, //menuliskan label dari chart, karena sebelumnya kita telah memiliki array dengan nama $nama_produk yang berisi daftar nama barang, sehingga kita tinggal menggunakan perintah json_encode untuk konversi array $nama_produk menjadi bentuk JSON
				datasets: [{
					label: 'Grafik Persebaran Covid',
					data: <?php echo json_encode($total_cases); ?>, //menuliskan bagian data dari chart, karena sebelumnya kita telah memiliki array dengan nama $jumlah_produk yang berisi jumlah dari penjualan per barang, sehingga kita tinggal menggunakan json_encode untuk konversi array $jumlah_produk menjadi bentuk JSON
					backgroundColor: 'rgba(255, 99, 132, 0.2)', // memodifikasi warna dari chart, dalam contoh ini kita buat warnanya adalah warna merah
					borderColor: 'rgba(255,99,132,1)', //memodifikasi border dari bagian chart
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>