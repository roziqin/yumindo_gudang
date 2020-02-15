<?php 
session_start();
include '../../config/database.php';
include "../../include/slug.php";
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');
$bln=date('Y-m');
$wkt=date('H:i:s');
$array_datas = array();


$user = $_SESSION['login_user'];
$cabang = $_SESSION['cabang'];

$order_type = '';
if($_GET['ket']=='tambahmenu'){
	
	$id = $_POST['barang_id'];	
	$jumlah = $_POST['jumlah'];
	$ket = $_POST['keterangan'];
	
	$sql="SELECT * from barang where barang_id='$id'";
	$query=mysqli_query($con,$sql);
	$data=mysqli_fetch_assoc($query);
	
	$sqla="SELECT sum(order_detail_temp_jumlah) as order_detail_temp_jumlah from order_detail_temp where order_detail_temp_barang_id='$id' and order_detail_temp_user='$user'";
	$querya=mysqli_query($con,$sqla);
	$dataa=mysqli_fetch_assoc($querya);

	if($dataa!=null) {
		$jml=$dataa['order_detail_temp_jumlah']+$jumlah;
	} else {
		$jml=$jumlah;
	}


	$sqlc="SELECT * from cabang where cabang_id='$cabang'";
	$queryc=mysqli_query($con,$sqlc);
	$datac=mysqli_fetch_assoc($queryc);

	$harga = $data['barang_harga_jual'] + ($datac['cabang_selisih_harga']);
	$total = $harga * $jml;
	if ($jml>$data['barang_stok']) {

		$array_datas['totalordertemp']=["Stok Kurang"];
		//echo ("<script>location.href='../home.php?menu=jumlah&id=$id&nama=$data[barang_nama]&ket=Stok Kurang&pelanggan='</script>");
	} else {
		
		$sql = "INSERT INTO order_detail_temp(order_detail_temp_barang_id,order_detail_temp_jumlah,order_detail_temp_harga,order_detail_temp_total,order_detail_temp_ket,order_detail_temp_status,order_detail_temp_user)values('$id','$jumlah','$harga','$total','$ket','','$user')";

		mysqli_query($con,$sql);
		
		$query="SELECT * from order_detail_temp, barang, subkategori where order_detail_temp_barang_id=barang_id and subkategori_id=barang_subkategori and order_detail_temp_user='$user' ORDER BY order_detail_temp_id DESC LIMIT 1";
		$result = mysqli_query($con,$query);

		while($baris = mysqli_fetch_assoc($result))
		{
		  $array_datas['item']=$baris;
		}

		$array_datas['totalordertemp']='';
	}
	
	echo json_encode($array_datas);
	
} elseif($_GET['ket']=='batal'){

    $sql = "DELETE from order_detail_temp where order_detail_temp_user='$user'";
    mysqli_query($con,$sql);

    $sql1 = "DELETE from member_temp where member_temp_user_id='$user'";
    mysqli_query($con,$sql1);


		$_SESSION['order_type'] = "";
		$array_datas[] = ["ok"];
	echo json_encode($array_datas);

} elseif($_GET['ket']=='removeitem'){
	$id = $_POST['id'];	
    $sql = "DELETE from order_detail_temp where order_detail_temp_id='$id'";
    mysqli_query($con,$sql);

	echo json_encode($array_datas);

} elseif($_GET['ket']=='plusminus'){
	$id = $_POST['id'];
	$idbarang = $_POST['idbarang'];
	$keterangan = $_POST['keterangan'];	

	if ($keterangan=='plus') {
		$jumlah = $_POST['jumlah']+1;
	} else {
		$jumlah = $_POST['jumlah']-1;
	}
	$jml=$jumlah;

	$sql="SELECT * from barang where barang_id='$idbarang'";
	$query=mysqli_query($con,$sql);
	$data=mysqli_fetch_assoc($query);

	$sql1="SELECT * from order_detail_temp where order_detail_temp_id='$id'";
	$query1=mysqli_query($con,$sql1);
	$data1=mysqli_fetch_assoc($query1);
	

	$array_datas['jumlahordertemp']=1;

	$sqlc="SELECT * from cabang where cabang_id='$cabang'";
	$queryc=mysqli_query($con,$sqlc);
	$datac=mysqli_fetch_assoc($queryc);

	$harga = $data['barang_harga_jual'] + ($datac['cabang_selisih_harga']);
	$total = $harga * $jml;

	if ($jml>$data['barang_stok']) {

		$array_datas['totalordertemp']=["Stok Kurang"];

	} else {
		
		if ($keterangan=='minus' && $jumlah==0) {
			$sql="DELETE from order_detail_temp where order_detail_temp_id='$id'";
			$array_datas['jumlahordertemp']=0;
		} else {
			$sql="UPDATE order_detail_temp set order_detail_temp_jumlah='$jumlah', order_detail_temp_harga='$harga', order_detail_temp_total='$total' where order_detail_temp_id='$id'";
	
		}

		mysqli_query($con,$sql);
		
		$query="SELECT * from order_detail_temp, barang, subkategori where order_detail_temp_barang_id=barang_id and subkategori_id=barang_subkategori and order_detail_temp_id=$id";
		$result = mysqli_query($con,$query);

		while($baris = mysqli_fetch_assoc($result)) {
		  $array_datas['item']=$baris;
		}
		
		$array_datas['totalordertemp']='';
	}
	
	echo json_encode($array_datas);

} elseif($_GET['ket']=='prosesorder'){
	
	$total = $_POST['total'];

	$qc= "SELECT COUNT( orderbarang_id ) AS total FROM orderbarang where orderbarang_tanggal='$tgl' and orderbarang_user_pesan='$user' ";
    $rc=mysqli_query($con,$qc);
    $dc=mysqli_fetch_assoc($rc);
    if ($user<10) {
    	$nouser = "0".$user;
    } else {
    	$nouser = $user;
    }
    
    $dtot = ($dc['total']+1);
    if ($dtot<10) {
    	$dtot = "0".$dtot;
    }
	$no_not = date('ymd')."".$nouser."".$dtot;
	
	$sql = "INSERT INTO orderbarang(orderbarang_tanggal,orderbarang_bulan,orderbarang_waktu,orderbarang_no_pesan,orderbarang_user_pesan,orderbarang_user,orderbarang_status,orderbarang_total)values('$tgl','$bln','$wkt','$no_not','$user','','Tunggu Antrian','$total')";

	mysqli_query($con,$sql);

    $_SESSION['no-nota'] = $no_not;	
    
    $query="SELECT * from order_detail_temp where order_detail_temp_user='$user'";
	$result = mysqli_query($con,$query);
	while($baris = mysqli_fetch_assoc($result)) {

    	$barang = $baris['order_detail_temp_barang_id'];
    	$jumlah = $baris['order_detail_temp_jumlah'];
    	$ket = $baris['order_detail_temp_ket'];
    	$status = 'Proses';
    	$user = $baris['order_detail_temp_user'];


    	$a="INSERT into order_detail(order_detail_no_pesan,order_detail_barang_id,order_detail_jumlah,order_detail_ket,order_detail_status,order_detail_user)values('$no_not','$barang','$jumlah','$ket','$status','$user')";
		mysqli_query($con,$a);

		//Select Stok Barang
		$sqlstok="SELECT * from barang where barang_id='$barang'";
        $resultstok=mysqli_query($con,$sqlstok);
	    $datastok=mysqli_fetch_assoc($resultstok);

    	$jml_stok = $datastok['barang_stok'] - $jumlah;
    
        $sqlupdatestok = "UPDATE barang SET barang_stok='$jml_stok' WHERE barang_id='$barang'";
        mysqli_query($con,$sqlupdatestok);    
		
		$query1="SELECT count(*) as jml from barang_cabang where barang_cabang_barang_id='$barang' and barang_cabang_cabang_id='$cabang'";
		$result1 = mysqli_query($con,$query1);
		$baris1 = mysqli_fetch_assoc($result1);
		if ($baris1['jml']==0) {
			$b = "INSERT INTO barang_cabang(barang_cabang_barang_id,barang_cabang_stok,barang_cabang_batas_stok,barang_cabang_cabang_id) VALUES ('$barang','0','0','$cabang')";
			mysqli_query($con,$b);

		}
    }

    //$_SESSION['kembalian'] = $kembalian;
    
    $_SESSION['print'] = 'ya';
    $_SESSION['order']='';

    $sqldelete = "DELETE from order_detail_temp where order_detail_temp_user='$user'";
    mysqli_query($con,$sqldelete);
	
    $array_dataa = array('nota'=>$no_not);

	echo json_encode($array_dataa);

}  elseif($_GET['ket']=='tutupkasir'){

	$uangfisik = $_POST['uangfisik'];
	//$uangfisik = 200000;

	$sqlcek="SELECT count(*) as jml from validasi where validasi_user_id='$user' and validasi_tanggal='$tgl'";
	$querycek=mysqli_query($con,$sqlcek);
	$datacek=mysqli_fetch_assoc($querycek);

	if ($datacek['jml']!=0) {
		$array_datas['ket'] = "gagal";

	} else {

		$sql="SELECT * from users where id='$user'";
		$query=mysqli_query($con,$sql);
		$data=mysqli_fetch_assoc($query);
		$usernama=$data['name'];

		$sql1="SELECT count(order_id) as jumlah, sum(order_total) as total, sum(order_diskon) as diskon from order where order_tanggal='$tgl' and order_user = '$user' group by order_tanggal";
		$query1=mysqli_query($con,$sql1);
		$data1=mysqli_fetch_assoc($query1);

		$sql2="SELECT count(order_id) as jumlah, sum(order_total) as debet, sum(order_diskon) as diskon from order where order_tanggal='$tgl' and order_user = '$user' and order_type_bayar='Debet' group by order_tanggal";
		$query2=mysqli_query($con,$sql2);
		$data2=mysqli_fetch_assoc($query2);

		$sql3="SELECT count(order_id) as jumlah, sum(order_total) as cash, sum(order_diskon) as diskon from order where order_tanggal='$tgl' and order_user = '$user' and order_type_bayar='Cash' group by order_tanggal";
		$query3=mysqli_query($con,$sql3);
		$data3=mysqli_fetch_assoc($query3);

		$a="INSERT into validasi(validasi_tanggal,validasi_waktu,validasi_user_id,validasi_user_nama,validasi_jumlah,validasi_cash,validasi_debet,validasi_omset)values('$tgl','$wkt','$user','$usernama','$uangfisik','$data3[cash]','$data2[debet]','$data1[total]')";
			mysqli_query($con,$a);


		$array_datas['omset'] = $data1['total'];
		$array_datas['debet'] = $data2['debet'];
		$array_datas['cash'] = $data3['cash'];
		$array_datas['uangfisik'] = $uangfisik;
		$array_datas['ket'] = "sukses";

	}
	echo json_encode($array_datas);
	
} elseif($_GET['ket']=='update-status'){

	$id = $_POST['ip-id'];
	
	$sql="UPDATE order_detail set order_detail_status='Cek' where order_detail_id='$id'";

	mysqli_query($con,$sql);
	
} elseif($_GET['ket']=='update-pesanan-status'){

	$id = $_POST['ip-id'];
	
	$sql="UPDATE orderbarang set orderbarang_status='Proses', orderbarang_user='$user' where orderbarang_id='$id'";
	mysqli_query($con,$sql);

	$array_datas['ket'] = "sukses";

	echo json_encode($array_datas);
	
} elseif($_GET['ket']=='konfirmasi-pesanan'){

	$id = $_POST['ip-id'];
	$data_uri = $_POST['ip-ttd'];

	$encoded_image = explode(",", $data_uri)[1];
	$decoded_image = base64_decode($encoded_image);
	file_put_contents("../../assets/img/".$user."_".$id."_".$tgl."-ttd.png", $decoded_image);
	$nama = $user."_".$id."_".$tgl."-ttd.png";
	
	$sql="UPDATE orderbarang set orderbarang_status='Selesai', orderbarang_ttd='$nama' where orderbarang_id='$id'";
	mysqli_query($con,$sql);

	$sql1="SELECT * from orderbarang, users where orderbarang_user_pesan=users.id and orderbarang_id='$id'";
	$query1=mysqli_query($con,$sql1);
	$data1=mysqli_fetch_assoc($query1);
	$idpesan = $data1["orderbarang_user_pesan"];
	$nopesan = $data1["orderbarang_no_pesan"];
	$idcabangppesan = $data1["cabang"];

    $query="SELECT * from order_detail where order_detail_no_pesan='$nopesan'";
	$result = mysqli_query($con,$query);
	while($baris = mysqli_fetch_assoc($result)) {
		$idbarang = $baris["order_detail_barang_id"];
		$jumlah = $baris["order_detail_jumlah"];

		$sql1="SELECT * from barang_cabang where barang_cabang_barang_id='$idbarang' and barang_cabang_cabang_id='$idcabangppesan'";
		$query1=mysqli_query($con,$sql1);
		$data1=mysqli_fetch_assoc($query1);
		$idbarangcabang = $data1["barang_cabang_id"];
		$stokawal = $data1["barang_cabang_stok"];
		$stokakhir = $stokawal+$jumlah;

		$sql="UPDATE barang_cabang set barang_cabang_stok='$stokakhir' where barang_cabang_id='$idbarangcabang'";
		mysqli_query($con,$sql);
	}

	$array_datas['ket'] = "sukses";

	echo json_encode($array_datas);
	
} elseif($_GET['ket']=='tes') {
	$sql1="SELECT * from member_temp where member_temp_user_id='$user'";
	$query1=mysqli_query($con,$sql1);
	$data1=mysqli_fetch_assoc($query1);
	$member = $data1['member_temp_member_id'];
	echo $_SESSION['kembalian'];
}

?>  