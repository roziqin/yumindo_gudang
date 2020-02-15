<?php 
session_start();
include '../../config/database.php';
include "../../include/slug.php";
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');

if($_GET['ket']=='submit-cabang'){

	$nama = $_POST['ip-nama'];
	$alamat = $_POST['ip-alamat'];
	$harga = $_POST['ip-harga'];

	$sql = "INSERT into cabang (cabang_nama,cabang_alamat,cabang_selisih_harga)values('$nama','$alamat','$harga')";

	mysqli_query($con,$sql);
	
} elseif($_GET['ket']=='update-cabang'){

	$id = $_POST['ip-id'];
	$nama = $_POST['ip-nama'];
	$alamat = $_POST['ip-alamat'];
	$harga = $_POST['ip-harga'];

	$sql="UPDATE cabang set cabang_nama='$nama', cabang_alamat='$alamat', cabang_selisih_harga='$harga' where cabang_id='$id'";
	mysqli_query($con,$sql);
	
} elseif($_GET['ket']=='remove-cabang'){
	$array_datas = array();
	
	$id = $_POST['id'];
	$sql="DELETE from cabang where cabang_id='$id'";
	if (!mysqli_query($con,$sql)) {
		$array_datas[] = ["gagal"];
	}else{
		$array_datas[] = ["ok"];
	}
	echo json_encode($array_datas);
	
}

?>  