<?php 
session_start();
include '../../config/database.php';
include "../../include/slug.php";
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');

if($_GET['ket']=='submit-subkategori'){

	$nama = $_POST['ip-nama'];
	$parent = $_POST['ip-parent'];
	$slug = slugify($nama);

	$sql = "INSERT into subkategori(subkategori_nama,subkategori_parent,subkategori_slug)values('$nama','$parent','$slug')";

	mysqli_query($con,$sql);
	
} elseif($_GET['ket']=='update-subkategori'){


	$id = $_POST['ip-id'];
	$nama = $_POST['ip-nama'];
	$parent = $_POST['ip-parent'];
	$slug = slugify($nama);

	$sql="UPDATE subkategori set subkategori_nama='$nama',subkategori_parent='$parent', subkategori_slug='$slug' where subkategori_id='$id'";
	mysqli_query($con,$sql);
	
} elseif($_GET['ket']=='remove-subkategori'){
	$array_datas = array();
	
	$id = $_POST['subkategori_id'];
	$sql="DELETE from subkategori where subkategori_id='$id'";
	if (!mysqli_query($con,$sql)) {
		$array_datas[] = ["gagal"];
	}else{
		$array_datas[] = ["ok"];
	}
	echo json_encode($array_datas);
	
}

?>  