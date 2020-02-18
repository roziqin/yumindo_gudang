<?php
include '../../config/database.php';
session_start();
$user = $_SESSION['login_user'];
$cabang = $_SESSION['cabang'];
$role = $_SESSION['role'];
$search = $_POST['search']['value']; // Ambil data yang di ketik user pada textbox pencarian
$limit = $_POST['length']; // Ambil data limit per page
$start = $_POST['start']; // Ambil data start

if ($_GET['ket']=='produk') {

	$sql = mysqli_query($con, "SELECT barang_id FROM barang, subkategori, kategori where barang_subkategori=subkategori_id and subkategori_parent=kategori_id"); 
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM barang, subkategori, kategori where barang_subkategori=subkategori_id and subkategori_parent=kategori_id and (barang_nama LIKE '%".$search."%' OR subkategori_nama LIKE '%".$search."%')";

} elseif ($_GET['ket']=='subkategori') {

	$sql = mysqli_query($con, "SELECT subkategori_id FROM subkategori, kategori WHERE subkategori_parent=kategori_id"); 
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM subkategori, kategori where subkategori_parent=kategori_id and (subkategori_nama LIKE '%".$search."%')";
	
} elseif ($_GET['ket']=='kategori') {

	$sql = mysqli_query($con, "SELECT kategori_id FROM kategori"); 
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM kategori where (kategori_nama LIKE '%".$search."%')";
	
} elseif ($_GET['ket']=='user') {

	$sql = mysqli_query($con, "SELECT id FROM users, roles, cabang where role=roles_id and users.cabang=cabang_id"); 
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM users, roles, cabang where role=roles_id and cabang=cabang_id and (name LIKE '%".$search."%')";
	
} elseif ($_GET['ket']=='member') {

	$sql = mysqli_query($con, "SELECT member_id FROM member"); 
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM member where (member_nama LIKE '%".$search."%')";
	
} elseif ($_GET['ket']=='cabang') {

	$sql = mysqli_query($con, "SELECT cabang_id FROM cabang"); 
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM cabang where (cabang_nama LIKE '%".$search."%')";
	
} elseif ($_GET['ket']=='stok') {
	if ($role=='md') {
		
		$sql = mysqli_query($con, "SELECT barang_cabang_id FROM barang_cabang, barang, subkategori WHERE barang_cabang_barang_id=barang_id and barang_subkategori=subkategori_id and barang_cabang_cabang_id='$cabang'"); 
		$sql_count = mysqli_num_rows($sql);
		$query = "SELECT barang_nama, barang_cabang_stok as barang_stok, barang_cabang_batas_stok as barang_batas_stok, barang_cabang_id as barang_id, subkategori_nama FROM barang_cabang, barang, subkategori WHERE barang_cabang_barang_id=barang_id and barang_cabang_cabang_id='$cabang' and barang_subkategori=subkategori_id and (barang_nama LIKE '%".$search."%')";

	} else {

		$sql = mysqli_query($con, "SELECT barang_id FROM barang, subkategori WHERE barang_subkategori=subkategori_id"); 
		$sql_count = mysqli_num_rows($sql);
		$query = "SELECT * FROM barang, subkategori where barang_subkategori=subkategori_id and (barang_nama LIKE '%".$search."%')";
	}
	
} elseif ($_GET['ket']=='batasstok') {
	if ($role=='md') {
		
		$sql = mysqli_query($con, "SELECT barang_cabang_id FROM barang_cabang, barang, subkategori WHERE barang_cabang_barang_id=barang_id and barang_subkategori=subkategori_id and barang_cabang_cabang_id='$cabang' and barang_cabang_batas_stok > barang_cabang_stok"); 
		$sql_count = mysqli_num_rows($sql);
		$query = "SELECT barang_nama, barang_cabang_stok as barang_stok, barang_cabang_batas_stok as barang_batas_stok, barang_cabang_id as barang_id, subkategori_nama FROM barang_cabang, barang, subkategori WHERE barang_cabang_barang_id=barang_id and barang_subkategori=subkategori_id and barang_cabang_cabang_id='$cabang' and barang_cabang_batas_stok > barang_cabang_stok and (barang_nama LIKE '%".$search."%')";

	} else {

		$sql = mysqli_query($con, "SELECT barang_id FROM barang, subkategori WHERE barang_subkategori=subkategori_id and barang_batas_stok > barang_stok"); 
		$sql_count = mysqli_num_rows($sql);
		$query = "SELECT * FROM barang, subkategori where barang_subkategori=subkategori_id and barang_batas_stok > barang_stok and (barang_nama LIKE '%".$search."%')";
	}
	
} elseif ($_GET['ket']=='konfpesanan') {

	$sql = mysqli_query($con, "SELECT * FROM orderbarang, users, cabang where orderbarang_user_pesan=id and users.cabang=cabang_id" ); 
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM orderbarang, users, cabang where orderbarang_user_pesan=id and users.cabang=cabang_id and (orderbarang_no_pesan LIKE '%".$search."%' OR name LIKE '%".$search."%' OR orderbarang_status LIKE '%".$search."%')";
	
} elseif ($_GET['ket']=='konfpesanan-dashboard') {

	$sql = mysqli_query($con, "SELECT * FROM orderbarang, users, cabang where orderbarang_user_pesan=id and users.cabang=cabang_id and orderbarang_status NOT LIKE '%Selesai%'" ); 
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM orderbarang, users, cabang where orderbarang_user_pesan=id and users.cabang=cabang_id and orderbarang_status NOT LIKE '%Selesai%' and (orderbarang_no_pesan LIKE '%".$search."%' OR name LIKE '%".$search."%' OR orderbarang_status LIKE '%".$search."%')";
	
} elseif ($_GET['ket']=='logpesanan') {

	$sql = mysqli_query($con, "SELECT * FROM orderbarang where orderbarang_user_pesan='$user'");
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM orderbarang where orderbarang_user_pesan='$user' and (orderbarang_no_pesan LIKE '%".$search."%')";
	
} elseif ($_GET['ket']=='logpesanan-dashboard') {

	$sql = mysqli_query($con, "SELECT * FROM orderbarang where orderbarang_user_pesan='$user' and orderbarang_status NOT LIKE '%Selesai%'");
	$sql_count = mysqli_num_rows($sql);
	$query = "SELECT * FROM orderbarang where orderbarang_user_pesan='$user' and orderbarang_status NOT LIKE '%Selesai%' and (orderbarang_no_pesan LIKE '%".$search."%')";
	
}

$order_field = $_POST['order'][0]['column']; // Untuk mengambil nama field yg menjadi acuan untuk sorting
$order_ascdesc = $_POST['order'][0]['dir']; // Untuk menentukan order by "ASC" atau "DESC"
$order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;
$sql_data = mysqli_query($con, $query.$order." LIMIT ".$limit." OFFSET ".$start); // Query untuk data yang akan di tampilkan
$sql_filter = mysqli_query($con, $query); // Query untuk count jumlah data sesuai dengan filter pada textbox pencarian
$sql_filter_count = mysqli_num_rows($sql_filter); // Hitung data yg ada pada query $sql_filter

if ($_GET['ket']=='produk') {
	$data = array();
	while($dataarray = mysqli_fetch_assoc($sql_data)) {

		$row_array['barang_id'] = $dataarray['barang_id'];
		$row_array['barang_nama'] = $dataarray['barang_nama'];
		$row_array['kategori_nama'] = $dataarray['kategori_nama'];
		$row_array['subkategori_nama'] = $dataarray['subkategori_nama'];
		$row_array['barang_sku'] = $dataarray['barang_sku'];
		$row_array['barang_harga_jual'] = $dataarray['barang_harga_jual'];
		$row_array['barang_disable'] = $dataarray['barang_disable'];
		

        array_push($data,$row_array);
	}
}/* elseif ($_GET['ket']=='batasstok') {
	$data = array();
	while($dataarray = mysqli_fetch_assoc($sql_data)) {
		if ($dataarray['barang_batas_stok'] > $dataarray['barang_stok']) {
			$row_array['barang_nama'] = $dataarray['barang_nama'];
			$row_array['subkategori_nama'] = $dataarray['subkategori_nama'];
			$row_array['barang_stok'] = $dataarray['barang_stok'];
			$row_array['barang_batas_stok'] = $dataarray['barang_batas_stok'];
		} else {

		}
		
        array_push($data,$row_array);
	}
} elseif ($_GET['ket']=='konfpesanan') {
	$data = array();
	$n = 0;
	while($dataarray = mysqli_fetch_assoc($sql_data)) {
		if ($dataarray['orderbarang_status']!="Selesai") {
			$row_array['orderbarang_tanggal'] = $dataarray['orderbarang_tanggal'];
			$row_array['orderbarang_no_pesan'] = $dataarray['orderbarang_no_pesan'];
			$row_array['cabang_nama'] = $dataarray['cabang_nama'];
			$row_array['orderbarang_status'] = $dataarray['orderbarang_status'];
			$n++;
		} else {

		}
		
        array_push($data,$row_array);
	}
	if ($n==0) {
		$row_array['orderbarang_tanggal'] = " ";
		$row_array['orderbarang_no_pesan'] = " ";
		$row_array['cabang_nama'] = "";
		$row_array['orderbarang_status'] = "";
        array_push($data,$row_array);
        $n=1;
	}
	$sql_count = $n;
}*/ else {
	$data = mysqli_fetch_all($sql_data, MYSQLI_ASSOC); // Untuk mengambil data hasil query menjadi array

}
$callback = array(
    'draw'=>$_POST['draw'], // Ini dari datatablenya
    'recordsTotal'=>$sql_count,
    'recordsFiltered'=>$sql_filter_count,
    'data'=>$data
);
header('Content-Type: application/json');
echo json_encode($callback); // Convert array $callback ke j