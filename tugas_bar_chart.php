<?php
include('koneksi.php');  // menyambungkan dengan file koneksi agar tersambung dengan database

	$query 	= "SELECT * FROM tb_covid"; // Menampilkan tb_covid19 yang sudah kita buat
	$result	= mysqli_query($koneksi, $query); // mengecek kembali koneksi dan query

	if( mysqli_num_rows($result) > 0 ){ // menampilkna data jika row lebih dari 0

		while( $row = mysqli_fetch_assoc($result) ){ // row tersebut disimpan didalam result

			$country[] 			= $row['nama_country']; // menyimpan data country dalam row
			$total_cases[]		= $row['total_cases']; // menyimpan data total_cases dalam row
			$new_cases[]		= $row['new_cases'];	// menyimpan data new_cases dalam row
			$total_deaths[]		= $row['total_deaths'];  // menyimpan data total_deaths dalam row
			$new_deaths[]		= $row['new_deaths'];	 // menyimpan data new_deaths dalam row
			$total_recovered[] 	= $row['total_recovered'];  // menyimpan data total_recovered dalam row
			$active_cases[] 	= $row['active_cases'];		// menyimpan data active_cases dalam row

		}

	}else{
		echo "<script> alert('DATA KOSONG'); </script>"; // jika tidak ada data makan akan menampilkan alert
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="Chart.js"></script> <!--menghubungkan dengan file chart.js-->
</head>
<body>

	<div style="width: 100%;">  <!--membuat ukuran menjadi 100 persen-->
		<canvas id="chart_bar"></canvas> <!--membuat canvas-->
	</div>

	<script>

		var ctx  = document.getElementById("chart_bar").getContext("2d"); //cart line diubah menjadi bentuk 2d
		
		var data = {

					labels : <?php echo json_encode($country); ?>, // menampilkan label dari nama negara

					datasets : [
								{
									label 	: "Total Cases", // menampilkan label dari total cases
									data 	: <?php echo json_encode($total_cases); ?>, // data akan menampilkan dari total cases
									backgroundColor : "rgba(255, 181, 234, 1)" // merubah warna
								},

								{
									label 	: "New Cases", // menampilkan label dari new cases
									data 	: <?php echo json_encode($new_cases); ?>, // data akan menampilkan dari new cases
									backgroundColor : "rgba(176, 142, 253, 1)" // merubah warna
								},

								{
									label 	: "Total Deaths", // menampilkan label dari total deaths
									data 	: <?php echo json_encode($total_deaths); ?>, // data akan menampilkan dari total deaths
									backgroundColor : "rgba(220, 211, 255, 1)" // merubah warna
								},

								{
									label 	: "New Deaths", // menampilkan label dari new deaths
									data 	: <?php echo json_encode($new_deaths); ?>, // data akan menampilkan dari new deaths
									backgroundColor : "rgba(173, 248, 218, 1)" // merubah warna
								},
								{
									label 	: "Total Recovered", // menampilkan label dari total recovered
									data 	: <?php echo json_encode($total_recovered); ?>, // data akan menampilkan dari total recovered
									backgroundColor : "rgba(189, 253, 195, 1)" // merubah warna
								},
								{
									label 	: "Active Cases",  // menampilkan label dari active cases
									data 	: <?php echo json_encode($active_cases); ?>, // data akan menampilkan dari active cases
									backgroundColor : "(254, 201, 221, 1)" // merubah warna
								}
					]

		};

		var myLineChart = new Chart(ctx, { // membuat varibel baru
		    type: 'bar', // membuat type menjadi bar
		    data: data,  // membuat varibel data
		    options: {  // membuat options
	    	            scales: {  // membuat scale
	    	            			yAxes: [{  // membuat yAxses
		    	            			ticks: { // membuat ticks ukuran 0
		    	                      		min: 0,
		    	                  		}
	    	              			}],
	    	            			xAxes: [{  // membuat xAxes
	    	                        	gridLines: {  // membuat gridlines
	    	                            	color: "rgba(0, 0, 0, 0)", // merubah color
	    	                        	},
	    	                        	categoryPercentage: 1, // membuat categorypercentage
            							barPercentage: 1  // membuat barpercentage
    	                    		}]
	    	            }
    	            }
		});
	</script>
</body>
</html>