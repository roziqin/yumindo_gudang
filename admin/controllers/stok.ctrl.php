<?php 
session_start();
include '../../config/database.php';
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');
$bln=date('Y-m');
$wkt=date('H:i:s');
$cabang = $_SESSION['cabang'];
$role = $_SESSION['role'];
$user = $_SESSION['login_user'];

if($_GET['ket']=='submit-stok'){


	$id = $_POST['ip-id'];
	$user = $_SESSION['login_user'];

	$sql="SELECT * from barang where barang_id='$id'";

	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$awal=$data['barang_stok'];
	$jumlah = $_POST['ip-jumlah']+$awal;
	$n = $_POST['ip-jumlah'];

	$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_akhir,stok_jumlah,tanggal,keterangan)values('$user','$id','$awal','$jumlah','$n','$tgl','tambah')";
	mysqli_query($con,$sql1);

	$sql2="UPDATE barang set barang_stok='$jumlah' where barang_id='$id'";

	mysqli_query($con,$sql2);
	
	
} elseif($_GET['ket']=='update-stok'){


	$id = $_POST['ip-id'];
	$user = $_SESSION['login_user'];

	$ket = $_POST['ip-ket'];

	$sql="SELECT * from barang where barang_id='$id'";

	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$awal=$data['barang_stok'];
	$jumlah = $awal-$_POST['ip-jumlah'];
	$n = $_POST['ip-jumlah'];

	if ($jumlah>=0) {

		$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_akhir,stok_jumlah,tanggal,alasan,keterangan)values('$user','$id','$awal','$jumlah','$n','$tgl','$ket','kurang')";
		mysqli_query($con,$sql1);

		$sql2="UPDATE barang set barang_stok='$jumlah' where barang_id='$id'";

		mysqli_query($con,$sql2);
	}

} elseif($_GET['ket']=='set-stok'){


	$id = $_POST['ip-id'];

	$sql="SELECT * from barang_cabang where barang_cabang_id='$id'";

	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$awal = $data['barang_cabang_stok'];
	$akhir = $_POST['ip-jumlah'];
	$jumlah = $awal - $akhir;

	$sql1 = "INSERT into order_keluar (order_keluar_tanggal,order_keluar_bulan,order_keluar_waktu,order_keluar_barang_id,order_keluar_jumlah,order_keluar_user,order_keluar_cabang)values('$tgl','$bln','$wkt','$id','$jumlah','$user','$cabang')";
	mysqli_query($con,$sql1);

	$sql2="UPDATE barang_cabang set barang_cabang_stok='$akhir' where barang_cabang_id='$id'";
	mysqli_query($con,$sql2);

} elseif($_GET['ket']=='updatebatas-stok'){


	$id = $_POST['ip-id'];
	$batas = $_POST['ip-batas'];
	if ($role=="md") {
		$sql2="UPDATE barang_cabang set barang_cabang_batas_stok='$batas' where barang_cabang_id='$id'";

	} else {
		$sql2="UPDATE barang set barang_batas_stok='$batas' where barang_id='$id'";
	}

	mysqli_query($con,$sql2);
	
} elseif($_GET['ket']=='rev-stok'){


	$id = $_POST['ip-id'];

	$sql="SELECT * from barang_cabang where barang_cabang_id='$id'";

	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);


	$sql1="SELECT * from order_keluar where order_keluar_barang_id='$id' ORDER BY order_keluar_id DESC LIMIT 1";

	$query1=mysqli_query($con, $sql1);
	$data1=mysqli_fetch_assoc($query1);

	$orderid = $data1["order_keluar_id"];

	$awal = $data['barang_cabang_stok'];
	$jumlah_keluar = $data1['order_keluar_jumlah'];

	$jumlahrevisi = $_POST['ip-jumlahrevisi'];

	$n = $awal + $jumlah_keluar;

	$j = $n - $jumlahrevisi;
	$sql3 = "UPDATE order_keluar set order_keluar_jumlah='$j' WHERE order_keluar_id='$orderid'";
	mysqli_query($con,$sql3);

	$sql4="UPDATE barang_cabang set barang_cabang_stok='$jumlahrevisi' where barang_cabang_id='$id'";
	mysqli_query($con,$sql4);

}

?>  