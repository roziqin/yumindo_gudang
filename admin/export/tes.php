<?php 
session_start();
include '../../config/database.php';
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');

$cekcabang = $_GET['cabang'];
    
$query="SELECT * from log_stok_hariini where log_stok_hariini_cabang='$cekcabang' ";

$result = mysqli_query($con,$query);


while($data = mysqli_fetch_assoc($result)) {
	$html=$data["log_stok_hariini_text"];
}
echo $html;
?>
