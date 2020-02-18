<?php
include '../../config/database.php';
session_start();
$bln=date('Y-m');
$user = $_SESSION['login_user'];
$cabang = $_SESSION['cabang'];
$role = $_SESSION['role'];

$func = $_GET['func'];

if ($func=='dasboard-omset') {

	$query = "SELECT transaksi_tanggal, sum(transaksi_total) as total FROM transaksi where transaksi_bulan = '$bln' GROUP BY transaksi_tanggal";

} elseif ($func=='dasboard-pelanggan') {

	$query = "SELECT count(*) as jumlah FROM transaksi where transaksi_bulan = '$bln' GROUP BY transaksi_tanggal";

} elseif ($func=='dasboard-itemsold') {

    $id = $_POST['kategoriid'];
    $query = "SELECT kategori_nama, barang_nama, sum(transaksi_detail_jumlah) as jumlah FROM transaksi, transaksi_detail, barang, subkategori, kategori where transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and barang_subkategori=subkategori_id and subkategori_parent=kategori_id and kategori_id='$id' and transaksi_bulan='$bln' GROUP BY barang_id ORDER BY jumlah DESC LIMIT 10";

} elseif ($func=='getkategori') {

    $query = "SELECT * from kategori ORDER BY kategori_id ASC";

} elseif ($func=='listproduk') {

	$query = "SELECT barang_nama, subkategori_nama, barang_stok, barang_harga_beli, barang_harga_jual, barang_harga_jual_online FROM barang, subkategori, kategori where barang_subkategori=subkategori_id and subkategori_parent=kategori_id";

} elseif ($func=='editproduk') {
	$id = $_POST['produk_id'];
	$query = "SELECT * from barang, subkategori where barang_subkategori=subkategori_id and barang_id='$id'";

} elseif ($func=='select-subkategori') {
    $kategori = $_POST['kategori'];

	$query = "SELECT * FROM subkategori WHERE subkategori_parent='$kategori'";

} elseif ($func=='select-barang') {
    $subkategori = $_POST['subkategori'];
    $cabang = $_POST['cabang'];
    $role = $_POST['role'];

    if ($role=='md') {
        $query = "SELECT * FROM barang, barang_cabang WHERE barang_id=barang_cabang_barang_id AND barang_cabang_cabang_id='$cabang' AND barang_subkategori='$subkategori'";
    } else {
        $query = "SELECT * FROM barang WHERE barang_subkategori='$subkategori'";
    }


} elseif ($func=='listsubkategori') {

    $query = "SELECT * FROM subkategori";

} elseif ($func=='editsubkategori') {
	$id = $_POST['subkategori_id'];
	$query = "SELECT * from subkategori where subkategori_id='$id'";

} elseif ($func=='editkategori') {
    $id = $_POST['kategori_id'];
    $query = "SELECT * from kategori where kategori_id='$id'";

} elseif ($func=='edituser') {
	$id = $_POST['id'];
	$query = "SELECT * from users where id='$id'";

} elseif ($func=='editmember') {
    $id = $_POST['id'];
    $query = "SELECT * from member where member_id='$id'";

} elseif ($func=='editcabang') {
    $id = $_POST['id'];
    $query = "SELECT * from cabang where cabang_id='$id'";

} elseif ($func=='editsetting') {
	$id = 1;
	$query = "SELECT * from pengaturan_perusahaan where pengaturan_id='$id'";

} elseif ($func=='editstok') {
	$id = $_POST['id'];

    if ($role=='md') {
        $query = "SELECT barang_nama, barang_cabang_stok as barang_stok, barang_cabang_batas_stok as barang_batas_stok, barang_cabang_id as barang_id FROM barang_cabang, barang WHERE barang_cabang_barang_id=barang_id and barang_cabang_cabang_id='$cabang' and barang_cabang_id='$id'";
    } else {
    	$query = "SELECT * from barang where barang_id='$id'";
    }

} elseif ($func=='list-order-temp') {
    $query="SELECT * from order_detail_temp, barang, subkategori where order_detail_temp_barang_id=barang_id and subkategori_id=barang_subkategori and order_detail_temp_user='$user' ORDER BY order_detail_temp_id";
} elseif ($func=='list-member-temp') {

    $query="SELECT * from member_temp, member, users where  member_temp_member_id=member_id and member_temp_therapist=id and member_temp_user_id='$user' ORDER BY member_temp_id DESC LIMIT 1";

} elseif ($func=='laporan-omset') {
	
    if ($_POST['daterange']=="harian") {
        $ket = "orderbarang_tanggal"; 
		$tgl11 = date("Y-m-j", strtotime($_POST['start']));
	    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "orderbarang_bulan";     
		$tgl11 = date("Y-m", strtotime($_POST['start']));
	    $tgl22 = date("Y-m", strtotime($_POST['end']));
    }

	$query ="SELECT orderbarang_tanggal, orderbarang_bulan, sum(orderbarang_total) as total from orderbarang WHERE $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket  ";

}  elseif ($func=='laporan-kasir') {
	
    $kasir = $_POST['kasir'];

    if ($kasir==0) {
        $text1 = '';
        $text2 = ', transaksi_user';
    } else {
        $text1 = 'transaksi_user='.$kasir.' and ';
        $text2 = '';

    }

    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
		$tgl11 = date("Y-m-j", strtotime($_POST['start']));
	    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
		$tgl11 = date("Y-m", strtotime($_POST['start']));
	    $tgl22 = date("Y-m", strtotime($_POST['end']));
    }

	$query ="SELECT transaksi_tanggal, transaksi_bulan, sum(transaksi_total) as total, sum(transaksi_diskon) as diskon, transaksi_user, id, name from transaksi, users WHERE transaksi_user=id and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ";

}  elseif ($func=='laporan-menu') {
	
    $kategori = $_POST['kategori'];
    $subkategori = $_POST['subkategori'];
    $menu = $_POST['menu'];
    $role = $_POST['role'];
    $cabang = $_POST['cabang'];
    $cekcabang = $_POST['cekcabang'];
    $cabangnama = $_POST['cabangnama'];

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


        if ($_POST['daterange']=="harian") {
            $ket = "order_keluar_tanggal"; 
            $tgl11 = date("Y-m-j", strtotime($_POST['start']));
            $tgl22 = date("Y-m-j", strtotime($_POST['end']));
        } elseif ($_POST['daterange']=="bulanan") {
            $ket = "order_keluar_bulan";     
            $tgl11 = date("Y-m", strtotime($_POST['start']));
            $tgl22 = date("Y-m", strtotime($_POST['end']));
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


            if ($_POST['daterange']=="harian") {
                $ket = "orderbarang_tanggal"; 
                $tgl11 = date("Y-m-j", strtotime($_POST['start']));
                $tgl22 = date("Y-m-j", strtotime($_POST['end']));
            } elseif ($_POST['daterange']=="bulanan") {
                $ket = "orderbarang_bulan";     
                $tgl11 = date("Y-m", strtotime($_POST['start']));
                $tgl22 = date("Y-m", strtotime($_POST['end']));
            }
            
            $query ="SELECT  kategori_nama, subkategori_nama, orderbarang_tanggal, orderbarang_bulan, barang_nama, barang_id, sum(order_detail_jumlah) as jumlah from orderbarang, order_detail, barang, kategori, subkategori WHERE order_detail_barang_id=barang_id and order_detail_no_pesan=orderbarang_no_pesan and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ORDER BY orderbarang_tanggal ASC";
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


            if ($_POST['daterange']=="harian") {
                $ket = "order_keluar_tanggal"; 
                $tgl11 = date("Y-m-j", strtotime($_POST['start']));
                $tgl22 = date("Y-m-j", strtotime($_POST['end']));
            } elseif ($_POST['daterange']=="bulanan") {
                $ket = "order_keluar_bulan";     
                $tgl11 = date("Y-m", strtotime($_POST['start']));
                $tgl22 = date("Y-m", strtotime($_POST['end']));
            }


            $query ="SELECT  kategori_nama, subkategori_nama, order_keluar_tanggal as orderbarang_tanggal, order_keluar_bulan as orderbarang_bulan, barang_nama, barang_id, sum(order_keluar_jumlah) as jumlah from order_keluar, barang, barang_cabang, kategori, subkategori WHERE order_keluar_barang_id=barang_cabang_id and barang_id=barang_cabang_barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cekcabang' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ORDER BY order_keluar_tanggal ASC";
        }

    }

} elseif ($func=='laporan-menu-grafik') {
    
    $kategori = $_POST['kategori'];
    $subkategori = $_POST['subkategori'];
    $menu = $_POST['menu'];
    $role = $_POST['role'];
    $cabang = $_POST['cabang'];
    $cekcabang = $_POST['cekcabang'];
    $cabangnama = $_POST['cabangnama'];

    if ($role=="md") {
        
        if ($kategori!=0 && $subkategori==0 && $menu==0) {
            $text1 = 'kategori_id='.$kategori.' and ';
            $text2 = 'barang_cabang_id';
        } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
            $text1 = 'subkategori_id='.$subkategori.' and ';
            $text2 = 'barang_cabang_id';
        } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
            $text1 = 'barang_cabang_id='.$menu.' and ';
            $text2 = 'barang_cabang_id';
        } else {
            $text1 = '';
            $text2 = 'barang_cabang_id';
        }


        if ($_POST['daterange']=="harian") {
            $ket = "order_keluar_tanggal"; 
            $tgl11 = date("Y-m-j", strtotime($_POST['start']));
            $tgl22 = date("Y-m-j", strtotime($_POST['end']));
        } elseif ($_POST['daterange']=="bulanan") {
            $ket = "order_keluar_bulan";     
            $tgl11 = date("Y-m", strtotime($_POST['start']));
            $tgl22 = date("Y-m", strtotime($_POST['end']));
        }


        $query ="SELECT barang_nama, barang_id, sum(order_keluar_jumlah) as jumlah from order_keluar, barang, barang_cabang, kategori, subkategori WHERE order_keluar_barang_id=barang_cabang_id and barang_id=barang_cabang_barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cabang' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $text2 ORDER BY barang_id ASC";

    } elseif ($role=="admin" || $role=="administrator"  || $role=="keuangan") {
        if ($cabangnama=="Pusat") {
            if ($kategori!=0 && $subkategori==0 && $menu==0) {
                $text1 = 'kategori_id='.$kategori.' and ';
                $text2 = 'barang_id';
            } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
                $text1 = 'subkategori_id='.$subkategori.' and ';
                $text2 = 'barang_id';
            } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
                $text1 = 'barang_id='.$menu.' and ';
                $text2 = 'barang_id';
            } else {
                $text1 = '';
                $text2 = 'barang_id';
            }


            if ($_POST['daterange']=="harian") {
                $ket = "orderbarang_tanggal"; 
                $tgl11 = date("Y-m-j", strtotime($_POST['start']));
                $tgl22 = date("Y-m-j", strtotime($_POST['end']));
            } elseif ($_POST['daterange']=="bulanan") {
                $ket = "orderbarang_bulan";     
                $tgl11 = date("Y-m", strtotime($_POST['start']));
                $tgl22 = date("Y-m", strtotime($_POST['end']));
            }
            
            $query ="SELECT orderbarang_tanggal, orderbarang_bulan, barang_nama, barang_id, sum(order_detail_jumlah) as jumlah from orderbarang, order_detail, barang, kategori, subkategori WHERE order_detail_barang_id=barang_id and order_detail_no_pesan=orderbarang_no_pesan and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $text2 ORDER BY barang_id ASC";
        } else {

            if ($kategori!=0 && $subkategori==0 && $menu==0) {
                $text1 = 'kategori_id='.$kategori.' and ';
                $text2 = 'barang_cabang_id';
            } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
                $text1 = 'subkategori_id='.$subkategori.' and ';
                $text2 = 'barang_cabang_id';
            } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
                $text1 = 'barang_cabang_id='.$menu.' and ';
                $text2 = 'barang_cabang_id';
            } else {
                $text1 = '';
                $text2 = 'barang_cabang_id';
            }


            if ($_POST['daterange']=="harian") {
                $ket = "order_keluar_tanggal"; 
                $tgl11 = date("Y-m-j", strtotime($_POST['start']));
                $tgl22 = date("Y-m-j", strtotime($_POST['end']));
            } elseif ($_POST['daterange']=="bulanan") {
                $ket = "order_keluar_bulan";     
                $tgl11 = date("Y-m", strtotime($_POST['start']));
                $tgl22 = date("Y-m", strtotime($_POST['end']));
            }


            $query ="SELECT barang_nama, barang_id, sum(order_keluar_jumlah) as jumlah from order_keluar, barang, barang_cabang, kategori, subkategori WHERE order_keluar_barang_id=barang_cabang_id and barang_id=barang_cabang_barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cekcabang' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $text2 ORDER BY barang_id ASC";    
        }
    }

} elseif ($func=='laporan-menu-grafik-pie') {
    
    $kategori = $_POST['kategori'];
    $subkategori = $_POST['subkategori'];
    $menu = $_POST['menu'];
    $role = $_POST['role'];
    $cabang = $_POST['cabang'];
    $cekcabang = $_POST['cekcabang'];
    $cabangnama = $_POST['cabangnama'];
    $orderby = $_POST['orderby'];
    if ($role=="md") {
        
        if ($kategori!=0 && $subkategori==0 && $menu==0) {
            $text1 = 'kategori_id='.$kategori.' and ';
            $text2 = $orderby;
        } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
            $text1 = 'subkategori_id='.$subkategori.' and ';
            $text2 = $orderby;
        } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
            $text1 = 'barang_cabang_id='.$menu.' and ';
            $text2 = $orderby;
        } else {
            $text1 = '';
            $text2 = $orderby;
        }


        if ($_POST['daterange']=="harian") {
            $ket = "order_keluar_tanggal"; 
            $tgl11 = date("Y-m-j", strtotime($_POST['start']));
            $tgl22 = date("Y-m-j", strtotime($_POST['end']));
        } elseif ($_POST['daterange']=="bulanan") {
            $ket = "order_keluar_bulan";     
            $tgl11 = date("Y-m", strtotime($_POST['start']));
            $tgl22 = date("Y-m", strtotime($_POST['end']));
        }


        $query ="SELECT kategori_nama, subkategori_nama, barang_nama, barang_id, sum(order_keluar_jumlah) as jumlah from order_keluar, barang, barang_cabang, kategori, subkategori WHERE order_keluar_barang_id=barang_cabang_id and barang_id=barang_cabang_barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cabang' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $text2 ORDER BY barang_id ASC";

    } elseif ($role=="admin" || $role=="administrator"  || $role=="keuangan") {
        if ($cabangnama=="Pusat") {
            if ($kategori!=0 && $subkategori==0 && $menu==0) {
                $text1 = 'kategori_id='.$kategori.' and ';
                $text2 = $orderby;
            } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
                $text1 = 'subkategori_id='.$subkategori.' and ';
                $text2 = $orderby;
            } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
                $text1 = 'barang_id='.$menu.' and ';
                $text2 = $orderby;
            } else {
                $text1 = '';
                $text2 = $orderby;
            }


            if ($_POST['daterange']=="harian") {
                $ket = "orderbarang_tanggal"; 
                $tgl11 = date("Y-m-j", strtotime($_POST['start']));
                $tgl22 = date("Y-m-j", strtotime($_POST['end']));
            } elseif ($_POST['daterange']=="bulanan") {
                $ket = "orderbarang_bulan";     
                $tgl11 = date("Y-m", strtotime($_POST['start']));
                $tgl22 = date("Y-m", strtotime($_POST['end']));
            }
            
            $query ="SELECT kategori_nama, subkategori_nama, orderbarang_tanggal, orderbarang_bulan, barang_nama, barang_id, sum(order_detail_jumlah) as jumlah from orderbarang, order_detail, barang, kategori, subkategori WHERE order_detail_barang_id=barang_id and order_detail_no_pesan=orderbarang_no_pesan and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $text2 ORDER BY barang_id ASC";
        } else {

            if ($kategori!=0 && $subkategori==0 && $menu==0) {
                $text1 = 'kategori_id='.$kategori.' and ';
                $text2 = $orderby;
            } elseif ($kategori!=0 && $subkategori!=0 && $menu==0) {
                $text1 = 'subkategori_id='.$subkategori.' and ';
                $text2 = $orderby;
            } elseif ($kategori!=0 && $subkategori!=0 && $menu!=0) {
                $text1 = 'barang_cabang_id='.$menu.' and ';
                $text2 = $orderby;
            } else {
                $text1 = '';
                $text2 = $orderby;
            }


            if ($_POST['daterange']=="harian") {
                $ket = "order_keluar_tanggal"; 
                $tgl11 = date("Y-m-j", strtotime($_POST['start']));
                $tgl22 = date("Y-m-j", strtotime($_POST['end']));
            } elseif ($_POST['daterange']=="bulanan") {
                $ket = "order_keluar_bulan";     
                $tgl11 = date("Y-m", strtotime($_POST['start']));
                $tgl22 = date("Y-m", strtotime($_POST['end']));
            }


            $query ="SELECT kategori_nama, subkategori_nama, barang_nama, barang_id, sum(order_keluar_jumlah) as jumlah from order_keluar, barang, barang_cabang, kategori, subkategori WHERE order_keluar_barang_id=barang_cabang_id and barang_id=barang_cabang_barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cekcabang' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $text2 ORDER BY barang_id ASC";    
        }
    }

}  elseif ($func=='laporan-menu-grafik-dashboard') {
    
    $role = $_POST['role'];
    $cabang = $_POST['cabang'];

    if ($role=="md") {
        
        $text1 = '';
        $text2 = 'barang_cabang_id'; 

        $ket = "order_keluar_bulan";     
        $tgl11 = $bln;
        $tgl22 = $bln;


        $query ="SELECT barang_nama, barang_id, sum(order_keluar_jumlah) as jumlah from order_keluar, barang, barang_cabang, kategori, subkategori WHERE order_keluar_barang_id=barang_cabang_id and barang_id=barang_cabang_barang_id and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and barang_cabang_cabang_id='$cabang' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $text2 ORDER BY barang_id ASC";

    } elseif ($role=="admin" || $role=="administrator"  || $role=="keuangan") {
        
        $text1 = '';
        $text2 = 'barang_id';
        $ket = "orderbarang_bulan";     
            
        $tgl11 = $bln;
        $tgl22 = $bln;
        
        $query ="SELECT orderbarang_tanggal, orderbarang_bulan, barang_nama, barang_id, sum(order_detail_jumlah) as jumlah from orderbarang, order_detail, barang, kategori, subkategori WHERE order_detail_barang_id=barang_id and order_detail_no_pesan=orderbarang_no_pesan and kategori_id=subkategori_parent and subkategori_id=barang_subkategori and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $text2 ORDER BY barang_id ASC";

    }

} elseif ($func=='laporan-nota') {
       
    $ket = "transaksi_tanggal"; 
    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    

    $query ="SELECT * from transaksi, users, member WHERE transaksi_member=member_id and transaksi_user=id and transaksi_tanggal BETWEEN '$tgl11' AND '$tgl22'  ";

} elseif ($func=='cek-nota') {
       
    $nota = $_POST['notaid'];

    $query ="SELECT * from transaksi_detail, barang where transaksi_detail_barang_id=barang_id and transaksi_detail_nota='$nota' ORDER BY transaksi_detail_id ASC";

} elseif ($func=='detailpesanan') {
       
    $order_id = $_POST['order_id'];

    $query ="SELECT * from order_detail, barang, subkategori where order_detail_barang_id=barang_id and barang_subkategori=subkategori_id and order_detail_no_pesan='$order_id' ORDER BY order_detail_id ASC";

} elseif ($func=='laporan-stok') {
    
    $menu = $_POST['menu'];

    if ($menu==0) {
        $text1 = '';
        $text2 = ', barang_id';
    } else {
        $text1 = 'barang_id='.$menu.' and ';
        $text2 = '';

    }

        $ket = "tanggal"; 
        $tgl11 = date("Y-m-j", strtotime($_POST['start']));
        $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    

    $query ="SELECT * from log_stok, barang, users WHERE log_stok.barang=barang_id and id=log_stok.user and keterangan='tambah' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' ORDER BY tanggal ASC";

}  elseif ($func=='laporan-stokkeluar') {
    
    $menu = $_POST['menu'];

    if ($menu==0) {
        $text1 = '';
        $text2 = ', barang_id';
    } else {
        $text1 = 'barang_id='.$menu.' and ';
        $text2 = '';

    }
    
    $ket = "transaksi_tanggal"; 
    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));


    $query ="SELECT name, transaksi_tanggal, barang_nama, barang_id, sum(transaksi_detail_jumlah) as jumlah from transaksi, transaksi_detail, barang, users WHERE transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and transaksi_user=users.id and barang_set_stok=1 and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 , users.id ORDER BY transaksi_tanggal ASC";

}  elseif ($func=='laporan-validasi') {

    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));

    $query="SELECT * from  validasi WHERE validasi_tanggal BETWEEN '$tgl11' AND '$tgl22' ORDER BY validasi_id asc";
}


$result = mysqli_query($con,$query);
$array_data = array();
/*
if ($func=="laporan-omset" || $func=="laporan-kasir") {
	
	if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
    }
    
    //$ket = "transaksi_tanggal";
	while($data = mysqli_fetch_assoc($result))
	{
		if ($func=="laporan-kasir") {
	        $text = 'transaksi_user='.$data['id'].' and ';
            $text1 = '';
	    } else {
	    	$text = '';
            $text1 = '';
	    }

		$tglket = $data[$ket];
        $sqlcash="SELECT sum(transaksi_total) as total from transaksi WHERE $text $ket='$tglket' and transaksi_type_bayar='Cash' GROUP BY $ket $text1 ";
        $querycash=mysqli_query($con, $sqlcash);
        $datacash=mysqli_fetch_assoc($querycash);
        $totalcash = 0;
        if ($datacash['total']!='') {
            $totalcash = $datacash['total'];
        }
		
        $sqlonline="SELECT sum(transaksi_total) as total from transaksi WHERE $text $ket='$tglket' and transaksi_type_bayar='GoResto' GROUP BY $ket $text1 ";
        $queryonline=mysqli_query($con, $sqlonline);
        $dataonline=mysqli_fetch_assoc($queryonline);
        $totalonline = 0;
        if ($dataonline['total']!='') {
            $totalonline = $dataonline['total'];
        }

        $sqldebet="SELECT sum(transaksi_total) as total from transaksi WHERE $text $ket='$tglket' and transaksi_type_bayar='Debet' GROUP BY $ket $text1 ";
        $querydebet=mysqli_query($con, $sqldebet);
        $datadebet=mysqli_fetch_assoc($querydebet);
        $totaldebet = 0;
        if ($datadebet['total']!='') {
            $totaldebet = $datadebet['total'];
        }
        
	  //$array_data[]=($ket=>$data[$ket], 'cash'=>$totalcash, 'debet'=>$totaldebet, 'online'=>$totalonline);
        if ($func=="laporan-kasir") {
			$row_array['kasir'] = $data['name'];
        }
		$row_array[$ket] = $data[$ket];
	    $row_array['cash'] = $totalcash;
	    $row_array['debet'] = $totaldebet;
	    $row_array['online'] = $totalonline;
		$row_array['total'] = $data['total'];
        array_push($array_data,$row_array);
	}

} else */
if ($func=="cek-nota") {

    $nota = $_POST['notaid'];
    $sqlnot="SELECT * FROM transaksi, users, member where transaksi_member=member_id and transaksi_user=id and transaksi_id='$nota' ";
    $querynot=mysqli_query($con,$sqlnot);
    $datanot=mysqli_fetch_assoc($querynot);

    $total = $datanot['transaksi_total'];
    $pelanggan = $datanot['member_nama'];
    $therapist = $datanot['transaksi_therapist'];
    $diskon = $datanot['transaksi_diskon'];
    $user = $datanot['name'];

    $sqlt="SELECT * FROM users where id='$therapist' ";
    $queryt=mysqli_query($con,$sqlt);
    $datat=mysqli_fetch_assoc($queryt);
    $namatherapist = $datat['name'];

    $row_array['subtotal'] = $total+$diskon;
    $row_array['total'] = $total;
    $row_array['pelanggan'] = $pelanggan;
    $row_array['user'] = $user;
    $row_array['therapist'] = $namatherapist;
    $row_array['potongan'] = $diskon;
    $row_array['notaid'] = $nota;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data[]=$data;
    }

} elseif ($func=="detailpesanan") {

    $nota = $_POST['order_id'];
    $sqlnot="SELECT * FROM orderbarang, users, cabang where orderbarang_user_pesan=id and users.cabang=cabang_id and orderbarang_no_pesan='$nota' ";
    $querynot=mysqli_query($con,$sqlnot);
    $datanot=mysqli_fetch_assoc($querynot);

    $row_array['idpesanan'] = $datanot['orderbarang_id'];
    $row_array['tanggal'] = $datanot['orderbarang_tanggal'];
    $row_array['waktu'] = $datanot['orderbarang_waktu'];
    $row_array['status'] = $datanot['orderbarang_status'];
    $row_array['ttd'] = $datanot['orderbarang_ttd'];
    $row_array['user'] = $datanot['name'];
    $row_array['cabang'] = $datanot['cabang_nama'];
    $row_array['notaid'] = $nota;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data[]=$data;
    }

} else {
	while($baris = mysqli_fetch_assoc($result))
	{
	  $array_data[]=$baris;
	}
}

if ($func=='listproduk') {
	$array_datas = array();
	$array_datas['data'] = $array_data;
	echo json_encode($array_datas);
} else {

	echo json_encode($array_data);
}

?>


