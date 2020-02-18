<?php
session_start(); 
$cabang = $_SESSION['cabang'];
$role = $_SESSION['role'];
$user = $_SESSION['login_user'];
?>

<input type="hidden" name="role" id="role" value="<?php echo $role; ?>">
<?php
	if ($role=="md") {
	?>
		<input type="hidden" name="cabangid" id="cabangid" value="<?php echo $cabang; ?>">
	<?php
	} else {
	?>
		<input type="hidden" name="cabangid" id="cabangid" value="0">
	<?php
	}
?>
<?php
if ($role=="md") {
?>
<?php include '../modals/logpesanan.modal.php'; ?>
	<div class="row">
		<div class="col-md-7 col-table">
			<h5>Stok Barang dibawah batas</h5>
			<table id="table-batas-stok" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
		        <thead>
		            <tr>
		                <th>nama</th>
		                <th>subkategori</th>
		                <th>stok</th>
		                <th>batas stok</th>
		            </tr>
		        </thead>
		    </table>
			
		</div>
		<div class="col-md-5 col-table">
			<h5>List Pemesanan</h5>
			<table id="example" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
		        <thead>
		            <tr>
		                <th>tanggal</th>
		                <th>no order</th>
		                <th>status</th>
		            </tr>
		        </thead>
		    </table>
		</div>
		<div class="col-md-12">
			<h5>Grafik Barang Keluar</h5>
			<canvas id="barChartstokkeluar"></canvas>
		</div>
	</div>
	<script type="text/javascript">
      
    $(document).ready(function() {

    	$('#example').DataTable( {
    		"searching":false,
            "processing": true,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=logpesanan-dashboard", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "orderbarang_tanggal" },
                { "data": "orderbarang_no_pesan" },
                { "data": "orderbarang_status" },
            ]
        } );

        $('#table-batas-stok').DataTable( {
    		"searching":false,
            "processing": true,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=batasstok", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "barang_nama" },
                { "data": "subkategori_nama" },
                { "data": "barang_stok" },
                { "data": "barang_batas_stok" },
            ]
        }); 

        var cabang = $('#cabangid').val();
		var role = $('#role').val();
		console.log(cabang+" "+role)
        $.ajax({
	        type:'POST',
	        url:'api/view.api.php?func=laporan-menu-grafik-dashboard',
	        dataType: "json",
        	data:{
        		role:role,
        		cabang:cabang
        	},
	        success:function(data){

	        	console.log(data);

	            var n = 0;
	            var nama = [];
	            var jumlah = [];
	            var background = [];
	            var border = [];
	            var color = [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							];
				var lengthcolor = color.length;
				var bordercolor = [
								'rgba(255,99,132,1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)',
								'rgba(255,99,132,1)'
							];
	            for (var i in data) {
	            	if (n==lengthcolor) {
	            		n = 0;
	            	}
	                nama.push(data[i].barang_nama);
	                jumlah.push(data[i].jumlah);
	                background.push(color[n]);
	                border.push(bordercolor[n]);

	                n++;
	            }

		        var ctxB = document.getElementById("barChartstokkeluar").getContext('2d');
				var myBarChart = new Chart(ctxB, {
					type: 'bar',
					data: {
						labels: nama,
						datasets: [{
							label: '',
							data: jumlah,
							backgroundColor: background,
							borderColor: border,
							borderWidth: 1
						}]
					},
					options: {
		                responsive: true,
		                aspectRatio: 3,
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});

	        }
	    });
    });
    </script>
<?php
} else {
?>
	<div class="row">
		<div class="col-md-7">
			<h5>Stok Barang dibawah batas</h5>
			<table id="table-batas-stok-pusat" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
		        <thead>
		            <tr>
		                <th>nama</th>
		                <th>subkategori</th>
		                <th>stok</th>
		                <th>batas stok</th>
		            </tr>
		        </thead>
		    </table>
			
		</div>
		<div class="col-md-5">
			<h5>List Pemesanan</h5>
			<table id="example" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
		        <thead>
		            <tr>
		                <th>tanggal</th>
		                <th>no order</th>
		                <th>cabang</th>
		                <th>status</th>
		            </tr>
		        </thead>
		    </table>
		</div>
		<div class="col-md-12">
			<h5>Grafik Barang Keluar Bulan ini</h5>
			<canvas id="barChartstokkeluar"></canvas>
		</div>
	</div>
	<script type="text/javascript">
      
    $(document).ready(function() {

    	$('#example').DataTable( {
    		"searching":false,
            "processing": true,
            "serverSide": true,
            "language": {
		    	"emptyTable": "No data available in table"
		    },
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=konfpesanan-dashboard", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "orderbarang_tanggal" },
                { "data": "orderbarang_no_pesan" },
                { "data": "cabang_nama" },
                { "data": "orderbarang_status" },
            ]
        });

        $('#table-batas-stok-pusat').DataTable( {
            "processing": true,
    		"searching":false,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=batasstok", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "barang_nama" },
                { "data": "subkategori_nama" },
                { "data": "barang_stok" },
                { "data": "barang_batas_stok" },
            ]
        });

		var cabang = $('#cabangid').val();
		var role = $('#role').val();
		console.log(cabang+" "+role)
        $.ajax({
	        type:'POST',
	        url:'api/view.api.php?func=laporan-menu-grafik-dashboard',
	        dataType: "json",
        	data:{
        		role:role,
        		cabang:cabang
        	},
	        success:function(data){

	        	console.log(data);

	            var n = 0;
	            var nama = [];
	            var jumlah = [];
	            var background = [];
	            var border = [];
	            var color = [
								'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)',
								'rgba(255, 159, 64, 0.2)'
							];
				var lengthcolor = color.length;
				var bordercolor = [
								'rgba(255,99,132,1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)',
								'rgba(255, 159, 64, 1)',
								'rgba(255,99,132,1)'
							];
	            for (var i in data) {
	            	if (n==lengthcolor) {
	            		n = 0;
	            	}
	                nama.push(data[i].barang_nama);
	                jumlah.push(data[i].jumlah);
	                background.push(color[n]);
	                border.push(bordercolor[n]);

	                n++;
	            }

		        var ctxB = document.getElementById("barChartstokkeluar").getContext('2d');
				var myBarChart = new Chart(ctxB, {
					type: 'bar',
					data: {
						labels: nama,
						datasets: [{
							label: '',
							data: jumlah,
							backgroundColor: background,
							borderColor: border,
							borderWidth: 1
						}]
					},
					options: {
		                responsive: true,
		                aspectRatio: 3,
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});

	        }
	    });
    });
    </script>
<?php

}
?>