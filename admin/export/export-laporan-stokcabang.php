<?php 
session_start();
include '../../config/database.php';
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');

$cekcabang = $_GET['cabang'];
    
$query="SELECT * from barang, kategori, subkategori, barang_cabang where barang_cabang_barang_id=barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cekcabang' ORDER BY barang_nama ASC";

$result = mysqli_query($con,$query);

$html ='
		
<style type="text/css">
	table {
		margin: 0px auto;
	}
	table th {
		text-transform: capitalize;
		padding: 10px 0px;
	}
	table td {
		padding: 10px 15px;
	}
</style>
	<center>
		<h1>Stok Hari Ini</h1>
	</center>
    <center>
        <h4>'.$tgl.'</h4>
    </center>
	<table width="100%" border="1"  style="font-size: 13px;border-spacing: 0; max-width: 800px;">
		<tr>
            <th>item</th>
            <th>kategori</th>
            <th>subkategori</th>
            <th>jumlah</th>
		</tr>

';
while($data = mysqli_fetch_assoc($result)) {
	$html.='
		<tr>
			<td>'.$data["barang_nama"].'</td>
            <td>'.$data["kategori_nama"].'</td>
            <td>'.$data["subkategori_nama"].'</td>
			<td style="text-align: center;">'.$data["barang_cabang_stok"].'</td>
		</tr>

	';
}

$html .='
	</table>
';
$sql1 = "INSERT into log_stok_hariini (log_stok_hariini_tanggal,log_stok_hariini_cabang,log_stok_hariini_text)values('$tgl','$cekcabang','$html')";
    mysqli_query($con,$sql1);

$filename = "laporan_stok_".$tgl.".xls";
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$filename);

echo $html;
?>

<script type="text/javascript">
  window.setTimeout(function() {
    window.close();
  },1000)
  
</script>
