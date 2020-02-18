<?php
session_start();
$con = mysqli_connect("localhost","root","","gudang_yumindo");
$ket = $_GET['ket'];
$role = $_SESSION['role'];
$cabang = $_SESSION['cabang'];

if ($ket=='omset') {

	$col = 'col-md-8';
	$btn = 'btn-proses-laporan-omset';
	
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="daterange" name="ip-daterange">
				            <option value="harian">Harian</option>
				            <option value="bulanan">Bulanan</option>
				        </select>
				    </div>
				</div>
				<?php /*
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-cabang" name="ip-cabang">
		                <?php
		                	$sql="SELECT * from cabang";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[cabang_id]'>$data1[cabang_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				*/ ?>
				<div class="col-md-8">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
					<div class="row form-month hidden">
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startmonth" name="ip-startmonth">
						                    <option value="" disabled selected>Bulan Mulai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startyear" name="ip-startyear">
						                    <option value="" disabled selected>Tahun Mulai</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								        </select>
					            	</div>
					            </div>
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endmonth" name="ip-endmonth">
						                    <option value="" disabled selected>Bulan Sampai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endyear" name="ip-endyear">
						                    <option value="" disabled selected>Tahun Sampai</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								        </select>
					            	</div>
					            </div>
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-omset">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated col-table">
				<div class="col-md-12"><h2 class="text-center mb-4">Omset <span id="namacabang"></span></h2></div>
				<div class="col-md-12">
					<table id="table-omset" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>tanggal</th>
	                            <th style="text-align: right;">Omset</th>
				            </tr>
				        </thead>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-omset hidden" href="" target="_blank">Export</a>
				    </div>
				</div>
				<div class="col-md-12 mb-4">
					<h5>Grafik Omset</h5>
					<div id="chart-box-omset">
						<canvas id="barChartomset"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
} elseif ($ket=='menu') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
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
				<div class="col-md-1">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="daterange" name="ip-daterange">
				            <option value="harian">Harian</option>
				            <option value="bulanan">Bulanan</option>
				        </select>
				    </div>
				</div>
                
                <?php if ($role!="md") { ?>
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-cabang" name="ip-cabang">
		                <?php
		                	$sql="SELECT * from cabang";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[cabang_id]'>$data1[cabang_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
                <?php } else { ?>
                		<input type="hidden"  id="defaultForm-cabang" name="ip-cabang" value="0">
                <?php } ?>

				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-kategori" name="ip-kategori">
		                    <option value="" selected>Pilih kategori</option>
		                <?php
		                	$sql="SELECT * from kategori";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[kategori_id]'>$data1[kategori_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-subkategori" name="ip-subkategori">
		                    <option value="" selected>Pilih Subkategori</option>
				        </select>
				    </div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-menu" name="ip-menu">
		                    <option value="0" selected>Pilih barang</option>
		                <?php
		                	if ($role=="md") {
		                		
			                	$sql="SELECT * from barang, barang_cabang where barang_id=barang_cabang_barang_id and barang_cabang_cabang_id='$cabang'";
			                  	$result=mysqli_query($con,$sql);
			                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			                      	echo "<option value='$data1[barang_cabang_id]'>$data1[barang_nama]</option>";
			                  	}
		                	
		                	} else {
			                	$sql="SELECT * from barang";
			                  	$result=mysqli_query($con,$sql);
			                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			                      	echo "<option value='$data1[barang_id]'>$data1[barang_nama]</option>";
			                  	}
			                }
		                ?>
				        </select>
				    </div>
				</div>
				<div class="col-md-3">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
					<div class="row form-month hidden">
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startmonth" name="ip-startmonth">
						                    <option value="" disabled selected>Bulan Mulai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startyear" name="ip-startyear">
						                    <option value="" disabled selected>Tahun Mulai</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								        </select>
					            	</div>
					            </div>
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endmonth" name="ip-endmonth">
						                    <option value="" disabled selected>Bulan Sampai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endyear" name="ip-endyear">
						                    <option value="" disabled selected>Tahun Sampai</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								        </select>
					            	</div>
					            </div>
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-1">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-menu">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated mb-5 col-table">
				<div class="col-md-12"><h2 class="text-center mb-4">Barang Keluar <span id="namacabang"></span></h2></div>
				<div class="col-md-12">
					<table id="table-menu" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>tanggal</th>
	                            <th>item</th>
	                            <th>kategori</th>
	                            <th>subkategori</th>
	                            <th>jumlah</th>
				            </tr>
				        </thead>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-stok hidden" href="" target="_blank">Export</a>
				    </div>
				</div>
				<div class="col-md-12 mb-4">
					<h5>Grafik Barang Keluar</h5>
					<div id="chart-box">
						<canvas id="barChartstokkeluar"></canvas>
					</div>
				</div>
				<div class="col-md-6">
					<h5>Grafik Barang Keluar per Kategori</h5>
					<div id="chart-pie-box">
						<canvas id="pieChartkategori"></canvas>
					</div>
				</div>
				<div class="col-md-6">
					<h5>Grafik Barang Keluar per SubKategori</h5>
					<div id="chart-pie-sub-box">
						<canvas id="pieChartsubkategori"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php

} 

?>
<script type="text/javascript">

  $(document).ready(function(){
      	$('.mdb-select').materialSelect();

		$("#defaultForm-kategori").change(function(){
			var kategori = $(this).val();
			$('#defaultForm-subkategori').children('option:not(:first)').remove();
			$('#defaultForm-menu').children('option:not(:first)').remove();

			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=select-subkategori',
		        dataType: "json",
            	data:{
            		kategori:kategori,
            	},
		        success:function(data){
		        	for (var i in data) {
		        		$("#defaultForm-subkategori").append('<option value="'+data[i].subkategori_id+'">'+data[i].subkategori_nama+'</option>');
		        	}
		        }
		    });
		});

		$("#defaultForm-subkategori").change(function(){
			var subkategori = $(this).val();

			var cabang = $('#cabangid').val();
			var role = $('#role').val();

			$('#defaultForm-menu').children('option:not(:first)').remove();

			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=select-barang',
		        dataType: "json",
            	data:{
            		subkategori:subkategori,
            		cabang:cabang,
            		role:role
            	},
		        success:function(data){
		        	var id = 0;
		        	for (var i in data) {
		        		if (role=='md') {
		        			id = data[i].barang_cabang_id;
		        		} else {
		        			id = data[i].barang_id;
		        		}
		        		$("#defaultForm-menu").append('<option value="'+id+'">'+data[i].barang_nama+'</option>');
		        	}
		        }
		    });
		});
		
		$("#daterange").change(function(){
			if ($(this).val()=="harian") {

	            $("#defaultForm-startdate").val('');
	            $("#startmonth").val('');
	            $("#startyear").val('');
	            $("#endmonth").val('');
	            $("#endyear").val('');

	           
	            $(".form-month").addClass('hidden');
	            $(".form-date").removeClass('hidden');
			
			} else if ($(this).val()=="bulanan") {
	        
	            $("#defaultForm-startdate").val('');
	            $("#startmonth").val('');
	            $("#startyear").val('');
	            $("#endmonth").val('');
	            $("#endyear").val('');

	            $(".form-month").removeClass('hidden');
	            $(".form-date").addClass('hidden');
			
			}
		});
		$('.datepicker').datepicker({
			    format: 'yyyy-mm-dd'
			});
		/*
		$('.datepicker').pickadate({
			weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
			showMonthsShort: true
		})
		*/
		function convertToRupiah(angka)
		{
		  var rupiah = '';    
		  var angkarev = angka.toString().split('').reverse().join('');
		  for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		  return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
		}
		
		var dateformat = ["01","02","03","04","05","06","07","08","09","10",
		            "11","12","13","14","15","16","17","18","19","20",
		            "21","22","23","24","25","26","27","28","29","30","31"];

		
		$('.btn-proses-laporan-omset').on('click',function(){
			var daterange = $('#daterange').val();
			var cekcabang = $('#defaultForm-cabang').val();
			var cabangnama = $('#defaultForm-cabang option:selected').text();

			if (daterange=='harian') {

	          	var start = $('#defaultForm-startdate').val();
	          	var end = $('#defaultForm-enddate').val();
	          	var kettext = 'transaksi_tanggal';
				
			} else if (daterange=='bulanan') {

	          	var start = $("#startyear").val()+"-"+$("#startmonth").val();
	          	var end = $("#endyear").val()+"-"+$("#endmonth").val();
	          	var kettext = 'transaksi_bulan';
				
			}
			var date = start+":"+end;
			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-omset',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		cekcabang:cekcabang,
            		cabangnama:cabangnama
            	},
		        success:function(data){
		        	console.log(data);
		        	$('#table-omset').DataTable().clear().destroy();
		        	if (kettext=='transaksi_bulan') {
			        	$('#table-omset').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
						    data: data,
				            deferRender: true,
						    columns: [
						        { data: 'orderbarang_bulan' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                }
						    ]
						} );

		        	} else if (kettext=='transaksi_tanggal') {
			        	$('#table-omset').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
						        { data: 'orderbarang_tanggal' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                }
						    ]
						} );

		        	} 
		        	$("a.export-omset").removeClass("hidden");
			        $("a.export-omset").attr("href","export/export-laporan-omset.php?date="+date+"&daterange="+daterange);
			        
		        	$("#namacabang").empty();
		        	$("#namacabang").append(cabangnama);
		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
		});

		$('.btn-proses-laporan-menu').on('click',function(){
			var daterange = $('#daterange').val();
			var kategori = $('#defaultForm-kategori').val();
			var subkategori = $('#defaultForm-subkategori').val();
			var menu = $('#defaultForm-menu').val();
			var cekcabang = $('#defaultForm-cabang').val();
			var cabangnama = $('#defaultForm-cabang option:selected').text();

			var cabang = $('#cabangid').val();
			var role = $('#role').val();

			if (daterange=='harian') {

	          	var start = $('#defaultForm-startdate').val();
	          	var end = $('#defaultForm-enddate').val();
	          	var kettext = 'transaksi_tanggal';
				
			} else if (daterange=='bulanan') {

	          	var start = $("#startyear").val()+"-"+$("#startmonth").val();
	          	var end = $("#endyear").val()+"-"+$("#endmonth").val();
	          	var kettext = 'transaksi_bulan';
				
			}
			var date = start+":"+end;
			console.log(cekcabang+" - "+cabangnama)
			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-menu',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		kategori:kategori,
            		subkategori:subkategori,
            		menu:menu,
            		role:role,
            		cabang:cabang,
            		cekcabang:cekcabang,
            		cabangnama:cabangnama
            	},
		        success:function(data){
		        	console.log(menu);
		        	$('#table-menu').DataTable().clear().destroy();
			        if(role=="md"){
			        	if (kettext=='transaksi_bulan') {
				        	$('#table-menu').DataTable( {
							    paging: false,
							    searching: false,
							    ordering: false,
							    data: data,
							    columns: [
							        { data: 'order_keluar_bulan' },
							        { data: 'barang_nama' },
							        { data: 'kategori_nama' },
							        { data: 'subkategori_nama' },
							        { data: 'jumlah' }
							    ]
							} );

			        	} else if (kettext=='transaksi_tanggal') {
				        	$('#table-menu').DataTable( {
							    paging: false,
							    searching: false,
							    ordering: false,
							    data: data,
							    columns: [
							        { data: 'order_keluar_tanggal' },
							        { data: 'barang_nama' },
							        { data: 'kategori_nama' },
							        { data: 'subkategori_nama' },
							        { data: 'jumlah' }
							    ]
							} );

			        	} 
			        } else {
			        	$("#namacabang").empty();
			        	$("#namacabang").append(cabangnama);
			        	if (kettext=='transaksi_bulan') {
				        	$('#table-menu').DataTable( {
							    paging: false,
							    searching: false,
							    ordering: false,
							    data: data,
							    columns: [
							        { data: 'orderbarang_bulan' },
							        { data: 'barang_nama' },
							        { data: 'kategori_nama' },
							        { data: 'subkategori_nama' },
							        { data: 'jumlah' }
							    ]
							} );

			        	} else if (kettext=='transaksi_tanggal') {
				        	$('#table-menu').DataTable( {
							    paging: false,
							    searching: false,
							    ordering: false,
							    data: data,
							    columns: [
							        { data: 'orderbarang_tanggal' },
							        { data: 'barang_nama' },
							        { data: 'kategori_nama' },
							        { data: 'subkategori_nama' },
							        { data: 'jumlah' }
							    ]
							} );

			        	} 
			        }

		        	console.log("success "+kettext);
		        	console.log(data);
		        	$("a.export-stok").removeClass("hidden");
			        $("a.export-stok").attr("href","export/export-laporan-stok.php?date="+date+"&daterange="+daterange+"&kategori="+kategori+"&subkategori="+subkategori+"&menu="+menu+"&role="+role+"&cabang="+cabang+"&cekcabang="+cekcabang+"&cabangnama="+cabangnama);
		        }
		    });


		    $.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-menu-grafik',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		kategori:kategori,
            		subkategori:subkategori,
            		menu:menu,
            		role:role,
            		cabang:cabang,
            		cekcabang:cekcabang,
            		cabangnama:cabangnama
            	},
		        success:function(data){

		        	console.log("success bar "+kettext);
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
		            $("#barChartstokkeluar").remove();
		            $('#chart-box').append('<canvas id="barChartstokkeluar"><canvas>');
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
					myBarChart.update();

		        }
		    });

		    $.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-menu-grafik-pie',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		kategori:kategori,
            		subkategori:subkategori,
            		menu:menu,
            		role:role,
            		cabang:cabang,
            		cekcabang:cekcabang,
            		cabangnama:cabangnama,
            		orderby: 'kategori_id'
            	},
		        success:function(data){

		        	console.log("success bar "+kettext);
		        	console.log(data);

		            var n = 0;
		            var nama = [];
		            var jumlah = [];
		            var background = [];
		            var hover = [];
		            var hoverBackgroundColor = ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"];
					var lengthcolor = hoverBackgroundColor.length;
					var backgroundColor = ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"];
		            for (var i in data) {
		            	if (n==lengthcolor) {
		            		n = 0;
		            	}
		                nama.push(data[i].kategori_nama);
		                jumlah.push(data[i].jumlah);
		                hover.push(hoverBackgroundColor[n]);
		                background.push(backgroundColor[n]);

		                n++;
		            }
		            $("#pieChartkategori").remove();
		            $('#chart-pie-box').append('<canvas id="pieChartkategori"><canvas>');
			        var ctxB = document.getElementById("pieChartkategori").getContext('2d');
					var myPieChart = new Chart(ctxB, {
						type: 'pie',
						data: {
							labels: nama,
							datasets: [{
								label: '',
								data: jumlah,
								backgroundColor: background,
								hoverBackgroundColor: hover
							}]
						},
						options: {
			                responsive: true,
			                aspectRatio: 2,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
							}
						}
					});
					myPieChart.update();

		        }
		    });

		    $.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-menu-grafik-pie',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		kategori:kategori,
            		subkategori:subkategori,
            		menu:menu,
            		role:role,
            		cabang:cabang,
            		cekcabang:cekcabang,
            		cabangnama:cabangnama,
            		orderby: 'subkategori_id'
            	},
		        success:function(data){

		            var n = 0;
		            var nama = [];
		            var jumlah = [];
		            var background = [];
		            var hover = [];
		            var hoverBackgroundColor = ["#616774", "#FFC870", "#A8B3C5", "#5AD3D1", "#FF5A5E"];
					var lengthcolor = hoverBackgroundColor.length;
					var backgroundColor = ["#4D5360", "#FDB45C", "#949FB1", "#46BFBD", "#F7464A"];
		            for (var i in data) {
		            	if (n==lengthcolor) {
		            		n = 0;
		            	}
		                nama.push(data[i].subkategori_nama);
		                jumlah.push(data[i].jumlah);
		                hover.push(hoverBackgroundColor[n]);
		                background.push(backgroundColor[n]);

		                n++;
		            }
		            $("#pieChartsubkategori").remove();
		            $('#chart-pie-sub-box').append('<canvas id="pieChartsubkategori"><canvas>');
			        var ctxB = document.getElementById("pieChartsubkategori").getContext('2d');
					var myPieChart = new Chart(ctxB, {
						type: 'pie',
						data: {
							labels: nama,
							datasets: [{
								label: '',
								data: jumlah,
								backgroundColor: background,
								hoverBackgroundColor: hover
							}]
						},
						options: {
			                responsive: true,
			                aspectRatio: 2,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: true
									}
								}]
							}
						}
					});
					myPieChart.update();

		        }
		    });
		});           
	});


</script>