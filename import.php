<?php

include "koneksi.php";

if(isset($_POST['import'])){ // Jika user mengklik tombol Import
	$nama_file_baru = 'data.xlsx';

	// Load librari PHPExcel nya
	require_once 'PHPExcel/PHPExcel.php';

	$excelreader = new PHPExcel_Reader_Excel2007();
	$loadexcel = $excelreader->load('tmp/'.$nama_file_baru); // Load file excel yang tadi diupload ke folder tmp
	$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

	$numrow = 1;
	foreach($sheet as $row){
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
			// Buat query Insert
			//$query = "INSERT INTO tbl_packing_master (case_no,case_qty,case_type,cs_gross_weight,packing_line,carton_no,carton_type,seq,part_no,part_name,stock_loc,weight,qty_carton,qty_case,min,max,bag_qty,lot_size,packing_spec,cycle_time) VALUES('".$case_no."','".$case_qty."','".$case_type."','".$cs_gross_weight."','".$packing_line."','".$no."','".$carton_type."'.'".$seq."','".$component_part."','".$component_name."','".$stock_loc."','".$weight."','".$qty_per_carton."','".$qty_per_case."','".$min_carton."','".$max_carton."','".$bag_qty."','".$lot_size."','".$packing_spec."','".$cycle_time."')";
			$query = mysqli_query($connect,"INSERT INTO tbl_fas (id,packing_plan,order_no,lot,ckd_set_no,ckd_set_name,dest,status,plan,comp,temp,packing_no,model) VALUES('','$packing_plan','$order_no','$lot','$ckd_set_no','$ckd_set_name','$dest','$status','$plan','$comp','$temp','$packing_no','$model')");

			//$query = "INSERT INTO tbl_packing_master VALUES('".$case_no."','".$case_qty."','".$case_type."')";
			// Eksekusi $query
			mysqli_query($connect, $query);
		}

		$numrow++; // Tambah 1 setiap kali looping
	}
}

header('location: index.php'); // Redirect ke halaman awal
?>
