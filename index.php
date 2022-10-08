
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		

		<!-- Load File bootstrap.min.css yang ada difolder css -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<?php
	ini_set("display_errors",0);
	$server = "localhost"; 
    $dbusername = "root";  
    $dbpassword = "";  
    $namadb="db_ipac";
  
    $koneksi = mysqli_connect($server, $dbusername, $dbpassword,$namadb) or die ("<font size='5px' color='red'>---Terjadi Masalah Koneksi || Tolong di refresh ya---</br></br>Info by Ditto Sefiano</font>");
	?>

	<?php
      $query = mysqli_query($koneksi, "SELECT logo from tbl_instansi");
      list($logo) = mysqli_fetch_array($query);
       echo '<link rel="shortcut icon" href="../../upload/'.$logo.'">';
    ?>
		
		
		<!-- Style untuk Loading -->
		<style>
        #loading{
			background: whitesmoke;
			position: absolute;
			top: 140px;
			left: 82px;
			padding: 5px 10px;
			border: 1px solid #ccc;
		}
		table {
            border-collapse: collapse;
            width: 100%;
        }
 
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
        }
        th {
            background-color: rgb(19, 110, 170);
            color: white;
        }
        tr:hover {background-color: #f5f5f5;}
		</style>
	</head>
	<body>
		<!-- Membuat Menu Header / Navbar -->
		<br>		
		<!-- Content -->
		<div style="padding: 0 15px;">
			<!-- 
			-- Buat sebuah tombol untuk mengarahkan ke form import data
			-- Tambahkan class btn agar terlihat seperti tombol
			-- Tambahkan class btn-success untuk tombol warna hijau
			-- class pull-right agar posisi link berada di sebelah kanan
			-->
			<a href="proses/import_fas/form.php" class="btn btn-success pull-right">
				<span class="glyphicon glyphicon-upload"></span> Import Data
			</a>
			
			
			
					
			<!-- Buat sebuah div dan beri class table-responsive agar tabel jadi responsive -->
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th>No.</th>
						<th>Packing Plan Date</th>
						<th>Order No</th>
						<th>Lot</th>
						<th>CKD Set No</th>
						<th>CKD Set Name</th>
						<th>Destination</th>
						<th>Status</th>
						<th>Plan</th>
						<th>Comp</th>
						<th>Temp</th>
						<th>Packing No</th>
						<th>Model</th>
					</tr>
					<?php
					// Load file koneksi.php
					include "koneksi.php";
					
					// Buat query untuk menampilkan semua data siswa
					$sql = mysqli_query($connect, "SELECT * FROM tbl_fas");
					
					$no = 1; // Untuk penomoran tabel, di awal set dengan 1
					while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
						echo "<tr>";
						echo "<td>".$no."</td>";
						echo "<td>".$data['packing_plan']."</td>";
						echo "<td>".$data['order_no']."</td>";
						echo "<td>".$data['lot']."</td>";
						echo "<td>".$data['ckd_set_no']."</td>";
						echo "<td>".$data['ckd_set_name']."</td>";
						echo "<td>".$data['dest']."</td>";
						echo "<td>".$data['status']."</td>";
						echo "<td>".$data['plan']."</td>";
						echo "<td>".$data['comp']."</td>";
						echo "<td>".$data['temp']."</td>";
						echo "<td>".$data['packing_no']."</td>";
						echo "<td>".$data['model']."</td>";
						echo "</tr>";
						
						$no++; // Tambah 1 setiap kali looping
					}
					?>
				</table>
			</div>
		</div>
	</body>
</html>
