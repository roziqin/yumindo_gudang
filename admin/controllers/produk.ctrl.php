<?php 
session_start();
include '../../config/database.php';
include "../../include/slug.php";
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');

if($_GET['ket']=='submit-produk'){

	$nama = $_POST['ip-nama'];
	$subkategori = $_POST['ip-subkategori'];
	$sku = $_POST['ip-sku'];
	$jual = $_POST['ip-jual'];
	if ($_POST['ip-disable']=='') {
		$disable = '0';
	} else {
		$disable = $_POST['ip-disable'];
	}

	
	$sql = "INSERT into barang(barang_nama,barang_subkategori,barang_sku,barang_harga_jual,barang_disable)values('$nama','$subkategori','$sku','$jual','$disable')";

	

	mysqli_query($con,$sql);
	
} elseif($_GET['ket']=='update-produk'){


	$id = $_POST['ip-id'];
	$nama = $_POST['ip-nama'];
	$subkategori = $_POST['ip-subkategori'];
	$sku = $_POST['ip-sku'];
	$jual = $_POST['ip-jual'];
	if ($_POST['ip-disable']=='') {
		$disable = '0';
	} else {
		$disable = $_POST['ip-disable'];
	}
	$user = $_SESSION['login_user'];

	$sql1="SELECT * from barang where barang_id='$id'";
	$query1=mysqli_query($con,$sql1);
	$data=mysqli_fetch_assoc($query1);

	//mysqli_query($con,"INSERT INTO log_harga(barang_id,harga_beli_awal,harga_beli_baru,harga_jual_awal,harga_jual_baru,user,tanggal) VALUES ('$id','$data[barang_harga_beli]','$beli','$data[barang_harga_jual]','$jual','$user','$tgl')");

	$sql="UPDATE barang set barang_nama='$nama',barang_subkategori='$subkategori',barang_sku='$sku',barang_harga_jual='$jual',barang_disable='$disable' where barang_id='$id'";


	mysqli_query($con,$sql);
	
} elseif($_GET['ket']=='remove-produk'){
	$array_datas = array();
	
	$id = $_POST['produk_id'];
	$sql="DELETE from barang where barang_id='$id'";
	if (!mysqli_query($con,$sql)) {
		$array_datas[] = ["gagal"];
	}else{
		$array_datas[] = ["ok"];
	}
	echo json_encode($array_datas);
	
}

?>  