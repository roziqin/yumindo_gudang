<?php 
session_start();
include '../../config/database.php';
date_default_timezone_set('Asia/jakarta');

$id = $_GET['id'];
    
$query="SELECT * from log_stok_hariini WHERE log_stok_hariini_id='$id'";

$result = mysqli_query($con,$query);
while($data = mysqli_fetch_assoc($result)) {
	$tgl =$data["log_stok_hariini_tanggal"];
	$html =$data["log_stok_hariini_text"];
}

$filename = "laporan_logstok_".$tgl.".xls";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$filename);

echo $html;
?>

<script type="text/javascript">
  window.setTimeout(function() {
    window.close();
  },1000)
  
</script>
