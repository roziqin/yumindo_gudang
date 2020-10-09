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
	$nama_foto = "";
	if (isset($_FILES['ip-foto-1']) || isset($_FILES['ip-foto-2']) || isset($_FILES['ip-foto-3'])) {
		if ($foto1!="") {
			$file_tmp = $_FILES['ip-foto-1']['tmp_name'];
			move_uploaded_file($file_tmp, '../../assets/img/'.$foto1);
		}

		if ($foto2!="") {
			$file_tmp = $_FILES['ip-foto-2']['tmp_name'];
			move_uploaded_file($file_tmp, '../../assets/img/'.$foto2);
		}

		if ($foto3!="") {
			$file_tmp = $_FILES['ip-foto-3']['tmp_name'];
			move_uploaded_file($file_tmp, '../../assets/img/'.$foto3);
		}

		$sql = "INSERT into barang(barang_nama,barang_subkategori,barang_sku,barang_harga_jual,barang_disable,barang_image_1,barang_image_2,barang_image_3)values('$nama','$subkategori','$sku','$jual','$disable','$foto1','$foto2','$foto3')";

	} else {
		$sql = "INSERT into barang(barang_nama,barang_subkategori,barang_sku,barang_harga_jual,barang_disable)values('$nama','$subkategori','$sku','$jual','$disable')";
	}
	

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

	$foto1 = $data["barang_image_1"];
	$foto2 = $data["barang_image_2"];
	$foto3 = $data["barang_image_3"];

	if (isset($_FILES['ip-foto-1']) || isset($_FILES['ip-foto-2']) || isset($_FILES['ip-foto-3'])) {
		$tempfoto1 = $_FILES['ip-foto-1']['name'];
		$tempfoto2 = $_FILES['ip-foto-2']['name'];
		$tempfoto3 = $_FILES['ip-foto-3']['name'];
		if ($tempfoto1!="") {
			$foto1 = $tempfoto1;
			$file_tmp = $_FILES['ip-foto-1']['tmp_name'];
			move_uploaded_file($file_tmp, '../../assets/img/'.$tempfoto1);
		}

		if ($tempfoto2!="") {
			$foto2 = $tempfoto2;
			$file_tmp = $_FILES['ip-foto-2']['tmp_name'];
			move_uploaded_file($file_tmp, '../../assets/img/'.$tempfoto2);
		}

		if ($tempfoto3!="") {
			$foto3 = $tempfoto3;
			$file_tmp = $_FILES['ip-foto-3']['tmp_name'];
			move_uploaded_file($file_tmp, '../../assets/img/'.$tempfoto3);
		}

		$sql="UPDATE barang set barang_nama='$nama',barang_subkategori='$subkategori',barang_sku='$sku',barang_harga_jual='$jual',barang_disable='$disable', barang_image_1='$foto1', barang_image_2='$foto2', barang_image_3='$foto3' where barang_id='$id'";

	} else {

		$sql="UPDATE barang set barang_nama='$nama',barang_subkategori='$subkategori',barang_sku='$sku',barang_harga_jual='$jual',barang_disable='$disable' where barang_id='$id'";
	}

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