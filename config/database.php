<?php
$con = mysqli_connect("localhost","root","","gudang_yumindo");

if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}

?>