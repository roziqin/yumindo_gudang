<?php 

session_start();
include '../../config/database.php';
date_default_timezone_set('Asia/jakarta');

$tgl = $_GET['date'];
$text_line = explode(":",$_GET['date']);
$tgl11=date("Y-m-j", strtotime($text_line[0]));
$tgl22=date("Y-m-j", strtotime($text_line[1]));

$kategori = $_GET['kategori'];
$subkategori = $_GET['subkategori'];
$menu = $_GET['menu'];
$role = $_GET['role'];
$cabang = $_GET['cabang'];
$cekcabang = $_GET['cekcabang'];
$cabangnama = $_GET['cabangnama'];

if ($role=="md") {
    
    if ($kategori!=0 && $subkategori==0 && $menu==0) {
        $text1 = 'kategori_id='.$kategori.' and ';
        $text2 = ', barang_cabang_id';
    } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
        $text1 = 'subkategori_id='.$subkategori.' and ';
        $text2 = ', barang_cabang_id';
    } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
        $text1 = 'barang_cabang_id='.$menu.' and ';
        $text2 = '';
    } else {
        $text1 = '';
        $text2 = ', barang_cabang_id';
    }


    if ($_GET['daterange']=="harian") {
        $ket = "order_keluar_tanggal";
    } elseif ($_GET['daterange']=="bulanan") {
        $ket = "order_keluar_bulan";
    }


    $query ="SELECT kategori_nama, subkategori_nama, order_keluar_tanggal, order_keluar_bulan, barang_nama, barang_id, sum(order_keluar_jumlah) as jumlah from order_keluar, barang, barang_cabang, kategori, subkategori WHERE order_keluar_barang_id=barang_cabang_id and barang_id=barang_cabang_barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cabang' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ORDER BY order_keluar_tanggal ASC";

} elseif ($role=="admin" || $role=="administrator"  || $role=="keuangan") {
    if ($cabangnama=="Pusat") {    
        if ($kategori!=0 && $subkategori==0 && $menu==0) {
            $text1 = 'kategori_id='.$kategori.' and ';
            $text2 = ', barang_id';
        } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
            $text1 = 'subkategori_id='.$subkategori.' and ';
            $text2 = ', barang_id';
        } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
            $text1 = 'barang_id='.$menu.' and ';
            $text2 = '';
        } else {
            $text1 = '';
            $text2 = ', barang_id';
        }


        if ($_GET['daterange']=="harian") {
            $ket = "orderbarang_tanggal"; 
        } elseif ($_GET['daterange']=="bulanan") {
            $ket = "orderbarang_bulan";
        }
        
        $query ="SELECT kategori_nama, subkategori_nama, orderbarang_tanggal, orderbarang_bulan, barang_nama, barang_id, sum(order_detail_jumlah) as jumlah from orderbarang, order_detail, barang, kategori, subkategori WHERE order_detail_barang_id=barang_id and order_detail_no_pesan=orderbarang_no_pesan and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ORDER BY orderbarang_tanggal ASC";
    } else {
        if ($kategori!=0 && $subkategori==0 && $menu==0) {
            $text1 = 'kategori_id='.$kategori.' and ';
            $text2 = ', barang_cabang_id';
        } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
            $text1 = 'subkategori_id='.$subkategori.' and ';
            $text2 = ', barang_cabang_id';
        } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
            $text1 = 'barang_cabang_id='.$menu.' and ';
            $text2 = '';
        } else {
            $text1 = '';
            $text2 = ', barang_cabang_id';
        }


        if ($_GET['daterange']=="harian") {
            $ket = "order_keluar_tanggal";
        } elseif ($_GET['daterange']=="bulanan") {
            $ket = "order_keluar_bulan";
        }


        $query ="SELECT kategori_nama, subkategori_nama, order_keluar_tanggal as orderbarang_tanggal, order_keluar_bulan as orderbarang_bulan, barang_nama, barang_id, sum(order_keluar_jumlah) as jumlah from order_keluar, barang, barang_cabang, kategori, subkategori WHERE order_keluar_barang_id=barang_cabang_id and barang_id=barang_cabang_barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cekcabang' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ORDER BY order_keluar_tanggal ASC";
    }

}

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
		<h1>Data Barang Keluar</h1>
	</center>
	<table width="100%" border="1"  style="font-size: 13px;border-spacing: 0; max-width: 800px;">
		<tr>
            <th>tanggal</th>
            <th>item</th>
            <th>kategori</th>
            <th>subkategori</th>
            <th style="text-align: center;">jumlah</th>
		</tr>

';

while($data = mysqli_fetch_assoc($result)) {
	if ($_GET['daterange']=="harian") {
        $fieldname = $data["orderbarang_tanggal"];
    } elseif ($_GET['daterange']=="bulanan") {
        $fieldname = $data["orderbarang_bulan"];
    }
	$html.='
		<tr>
			<td>'.$fieldname.'</td>
			<td>'.$data["barang_nama"].'</td>
            <td>'.$data["kategori_nama"].'</td>
            <td>'.$data["subkategori_nama"].'</td>
			<td style="text-align: center;">'.$data["jumlah"].'</td>
		</tr>

	';
}

$html .='
	</table>
';



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
$dompdf->stream("exportstok-".$tgl.".pdf", array("Attachment"=>0));

?>

<script type="text/javascript">
  window.setTimeout(function() {
    window.close();
  },1000)
</script>
