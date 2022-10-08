

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Import FAS | AMP</title>

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
		</style>

		<!-- Load File jquery.min.js yang ada difolder js -->
		<script src="js/jquery.min.js"></script>

		<script>
		$(document).ready(function(){
			// Sembunyikan alert validasi kosong
			$("#kosong").hide();
		});
		</script>
	</head>
	<body>
		<!-- Membuat Menu Header / Navbar -->
		<nav class="navbar navbar-inverse" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="#" style="color: white;"><b>Import FAS</b></a>
				</div>
				<p class="navbar-text navbar-right hidden-xs" style="color: white;padding-right: 10px;">
				<p class="navbar-text navbar-right hidden-xs" style="color: white;padding-right: 10px;">
					<a style="background: #d34836; padding: 0 10px; border-radius: 4px; color: #ffffff; text-decoration: none;" href="../../index.php">Main Menu</a>
				</p>
				</p>
			</div>
		</nav>

		<!-- Content -->
		<div style="padding: 0 15px;">
			<!-- Buat sebuah tombol Cancel untuk kemabli ke halaman awal / view data -->
			<a href="../../../i-pack/dashboard.php?page=up_fas" class="btn btn-danger pull-right">
				<span class="glyphicon glyphicon-remove"></span> Cancel
			</a>

			<h3>Form Import Data</h3>
			<hr>

			<!-- Buat sebuah tag form dan arahkan action nya ke file ini lagi -->
			<form method="post" action="" enctype="multipart/form-data">
				<a href="Format.xlsx" class="btn btn-default">
					<span class="glyphicon glyphicon-download"></span>
					Download Format
				</a><br><br>

				<!--
				-- Buat sebuah input type file
				-- class pull-left berfungsi agar file input berada di sebelah kiri
				-->
				<input type="file" name="file" class="pull-left">

				<button type="submit" name="preview" class="btn btn-success btn-sm">
					<span class="glyphicon glyphicon-eye-open"></span> Preview
				</button>
			</form>

			<hr>

			<!-- Buat Preview Data -->
			<?php
			// Jika user telah mengklik tombol Preview
			if(isset($_POST['preview'])){
				//$ip = ; // Ambil IP Address dari User
				$nama_file_baru = 'data.xlsx';

				// Cek apakah terdapat file data.xlsx pada folder tmp
				if(is_file('tmp/'.$nama_file_baru)) // Jika file tersebut ada
					unlink('tmp/'.$nama_file_baru); // Hapus file tersebut

				$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
				$tmp_file = $_FILES['file']['tmp_name'];

				// Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
				if($ext == "xlsx"){
					// Upload file yang dipilih ke folder tmp
					// dan rename file tersebut menjadi data{ip_address}.xlsx
					// {ip_address} diganti jadi ip address user yang ada di variabel $ip
					// Contoh nama file setelah di rename : data127.0.0.1.xlsx
					move_uploaded_file($tmp_file, 'tmp/'.$nama_file_baru);

					// Load librari PHPExcel nya
					require_once 'PHPExcel/PHPExcel.php';

					$excelreader = new PHPExcel_Reader_Excel2007();
					$loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file yang tadi diupload ke folder tmp
					$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

					// Buat sebuah tag form untuk proses import data ke database
					echo "<form method='post' action='import.php'>";

					// Buat sebuah div untuk alert validasi kosong
					echo "<div class='alert alert-danger' id='kosong'>
					Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
					</div>";

					echo "<table class='table table-bordered'>
					<tr>
						<th colspan='5' class='text-center'>Preview Data</th>
					</tr>
					<tr>
						
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
						
						
					</tr>";

					$numrow = 1;
					$kosong = 0;
					foreach($sheet as $row){ // Lakukan perulangan dari data yang ada di excel
						// Ambil data pada excel sesuai Kolom
						$packing_plan = $row['A']; // Ambil data NIS
						$order_no = $row['B']; // Ambil data nama
						$lot = $row['C']; // Ambil data jenis kelamin
						$ckd_set_no = $row['D']; // Ambil data telepon
						$ckd_set_name = $row['E']; // Ambil data alamat
						$dest = $row['F'];
						$status = $row['G'];
						$plan = $row['H'];
						$comp = $row['I'];
						$temp = $row['J'];
						$packing_no = $row['K'];
						$model = substr($ckd_set_no,0,4);


						// Cek jika semua data tidak diisi
						if($packing_plan == "" && $order_no == "" && $lot == "" && $ckd_set_no == "" && $ckd_set_name == "" && $dest == "" && $status == "" && $plan == "" && $packing_no == "")
							continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

						// Cek $numrow apakah lebih dari 1
						// Artinya karena baris pertama adalah nama-nama kolom
						// Jadi dilewat saja, tidak usah diimport
						if($numrow > 1){
							// Validasi apakah semua data telah diisi
							$packing_plan_td = ( ! empty($packing_plan))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
							$order_no_td = ( ! empty($order_no))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
							$lot_td = ( ! empty($lot))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
							$ckd_set_no_td = ( ! empty($ckd_set_no))? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
							$ckd_set_name_td = ( ! empty($ckd_set_name))? "" : " style='background: #E07171;'"; // Jika Telepon kosong, beri warna merah
							$dest_td = ( ! empty($dest))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
							$status_td = ( ! empty($status))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
							$plan_td = ( ! empty($plan))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
							$comp_td = ( ! empty($comp))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
							$temp_td = ( ! empty($temp))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
							$packing_no_td = ( ! empty($packing_no))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
							$model_td = ( ! empty($model))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah

							// Jika salah satu data ada yang kosong
							
							if($packing_plan == "" or $order_no == "" or $lot == "" or $ckd_set_no == "" or $ckd_set_name == "" or $dest == "" or $status == "" or $plan == "" or $packing_no == "")
							{
								//$kosong++; // Tambah 1 variabel $kosong
							}

							echo "<tr>";
							echo "<td".$packing_plan_td.">".$packing_plan."</td>";
							echo "<td".$order_no_td.">".$order_no."</td>";
							echo "<td".$lot_td.">".$lot."</td>";
							echo "<td".$ckd_set_no_td.">".$ckd_set_no."</td>";
							echo "<td".$ckd_set_name_td.">".$ckd_set_name."</td>";
							echo "<td".$dest_td.">".$dest."</td>";
							echo "<td".$status_td.">".$status."</td>";
							echo "<td".$plan_td.">".$plan."</td>";
							echo "<td".$comp_td.">".$comp."</td>";
							echo "<td".$temp_td.">".$temp."</td>";
							echo "<td".$packing_no_td.">".$packing_no."</td>";
							echo "<td".$model_td.">".$model."</td>";

							echo "</tr>";
						}

						$numrow++; // Tambah 1 setiap kali looping
					}

					echo "</table>";

					// Cek apakah variabel kosong lebih dari 1
					// Jika lebih dari 1, berarti ada data yang masih kosong
					if($kosong > 1){
					?>
						<script>
						$(document).ready(function(){
							// Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
							$("#jumlah_kosong").html('<?php echo $kosong; ?>');

							$("#kosong").show(); // Munculkan alert validasi kosong
						});
						</script>
					<?php
					}else{ // Jika semua data sudah diisi
						echo "<hr>";

						// Buat sebuah tombol untuk mengimport data ke database
						echo "<button type='submit' name='import' class='btn btn-primary'><span class='glyphicon glyphicon-upload'></span> Import</button>";
					}

					echo "</form>";
				}else{ // Jika file yang diupload bukan File Excel 2007 (.xlsx)
					// Munculkan pesan validasi
					echo "<div class='alert alert-danger'>
					Hanya File Excel 2007 (.xlsx) yang diperbolehkan
					</div>";
				}
			}
			?>
		</div>
	</body>
</html>
