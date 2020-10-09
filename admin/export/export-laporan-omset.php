<?php 

session_start();
include '../../config/database.php';
include '../../include/format_rupiah.php';
date_default_timezone_set('Asia/jakarta');

$tgl = $_GET['date'];
$text_line = explode(":",$_GET['date']);
$tgl11=date("Y-m-j", strtotime($text_line[0]));
$tgl22=date("Y-m-j", strtotime($text_line[1]));

if ($_GET['daterange']=="harian") {
    $ket = "orderbarang_tanggal";
} elseif ($_GET['daterange']=="bulanan") {
    $ket = "orderbarang_bulan";
}

$query ="SELECT orderbarang_tanggal, orderbarang_bulan, sum(orderbarang_total) as total from orderbarang WHERE $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket  ";

$result = mysqli_query($con,$query);
/*
?>

<?php
*/
$html ='
<style type="text/css">
    table {
        margin: 0px auto;
    }
    table th {
        text-transform: capitalize;
        padding: 10px 15px;
    }
    table td {
        padding: 10px 15px;
    }
</style>
		
	<center>
		<h1>Data Omset</h1>
	</center>
	<table width="100%" border="1"  style="font-size: 13px;border-spacing: 0; max-width: 800px;">
		<tr>
            <th>tanggal</th>
            <th style="text-align: right;">omset</th>
		</tr>

';
$jumlah = 0;
while($data = mysqli_fetch_assoc($result)) {
	if ($_GET['daterange']=="harian") {
        $fieldname = $data["orderbarang_tanggal"];
    } elseif ($_GET['daterange']=="bulanan") {
        $fieldname = $data["orderbarang_bulan"];
    }
    $jumlah += $data["total"];
	$html.='
		<tr>
			<td>'.$fieldname.'</td>
			<td style="text-align: right;">Rp. '.format_rupiah($data["total"]).'</td>
		</tr>

	';
}

$html .='
        <tr>
            <td><b>Total</b></td>
            <td style="text-align: right;"><b>Rp. '.format_rupiah($jumlah).'</b></td>
        </tr>
	</table>
';

//echo $html;

require_once '../../include/dompdf/lib/html5lib/Parser.php';
require_once '../../include/dompdf/lib/php-font-lib/src/FontLib/Autoloader.php';
require_once '../../include/dompdf/lib/php-svg-lib/src/autoload.php';
require_once '../../include/dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();


// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'potrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("exportomset-".$tgl.".pdf", array("Attachment"=>0));

?>

<script type="text/javascript">
  window.setTimeout(function() {
    window.close();
  },1000)
</script>