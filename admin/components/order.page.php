
    <input type="hidden" id="defaultForm-role" name="ip-role" value="<?php echo $_SESSION['role']; ?>">
    <input type="hidden" id="defaultForm-user" name="ip-user" value="<?php echo $_SESSION['name']; ?>">
    <div class="tab-container-transaksi">
		<div class="tab-box mobile-display">
			<ul class="tab-mobile">
				<li><a href="" class="active" id="tm-barang" data-id="box-barang">Barang</a></li>
				<li><a href="" id="tm-transaksi" data-id="box-transaksi">Transaksi</a></li>
			</ul>
		</div>
	</div>
	<main class="transaksi p-0 mr-0">
		<div class="main-wrapper">
		    <div class="container-fluid">
				<div class="row row-top">
					<div id="box-barang" class="col-md-8 pl-md-0 pr-md-0 tab-box-content container__load active">

					</div>

					<div id="box-transaksi" class="col-md-4 tab-box-content position-relative box-right">
						<div class="row">
							<div class="col-md-12 position-fixed info-color text-white col-right"></div>
							<div class="col-md-12">
								<h3 class="text-white pt-3 float-left">Order List</h3>
								<span class="text-white pt-4 float-right" id="datetime"></span>
								<div class="clear"></div>
								<!-- Search form 
								<div class="form-inline md-form form-sm mt-2 mb-2 form-search info-color-dark">
									<input class="form-control form-control-sm text-white " type="text" placeholder="Cari Menu"
									    aria-label="Search" id="carimenu">
									<i class="fas fa-search text-white" aria-hidden="true"></i>
								</div>
								-->
							</div>
							<div class="col-md-12 text-white mt-3 fadeIn animated" id="listitem">
								<table class="pt-2 pb-2"></table>
							</div>
							<div class="col-md-12 box-bottom info-color-dark pt-2">
								<div class="row pt-0 pb-2">
									<div class="col-md-6 btn-bottom">
										<div class="row">
											<div class="col-md-12 p-0">
												<button type="button" class="btn btn-white waves-effect text-danger" id="batal"><i class="fas fa-trash m-0"></i>Batal</button>
											</div>
											<!--
											<div class="col-md-4 p-0">
												<a href="print/nota-temp.print.php?ordertype=<?php echo $_SESSION['order_type']; ?>" class="btn btn-white waves-effect text-warning" id="print" target="_blank"><i class="fas fa-print m-0"></i>Print</a>
											</div>
											
											<div class="col-md-6 p-0">
												<button type="button" class="btn btn-white waves-effect text-warning" id="discount" data-toggle="modal" data-target="#modaldiscount"><i class="fas fa-tag m-0"></i>Discount</button>
											</div>
											-->
										</div>

									</div>
									<div class="col-md-6 btn-bottom pr-1">
										<button type="button" class="btn btn-white waves-effect text-info" id="bayar" data-toggle="modal" data-target="#modalorder"><i class="fas fa-money-bill m-0"></i>Pesan</button>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
		    </div>
		</div>
	</main>

	<?php include 'partials/footer.php'; ?>

	<?php include 'modals/order.modal.php'; ?>
	<?php include 'modals/discount.modal.php'; ?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.tab-mobile li a').on('click',function(e){
			e.preventDefault();
			var box = $(this).data('id');
			$('.tab-mobile li a').removeClass("active");
			$(this).addClass("active");
			$('.transaksi .row .tab-box-content').removeClass("active");
			$('.transaksi .row #'+box+'.tab-box-content').addClass("active");
		});
		/*
		$.ajax({
            type:'POST',
            url:'api/view.api.php?func=list-member-temp',
            dataType: "json",
            success:function(data){
                $('#listmember table').empty();
                if (data!='') {
					$('#bayar').removeAttr("disabled");
                } else {
					$('#bayar').attr("disabled","true");

                }
            }
        });
		
	    $('.ordertype').on('click',function(){
			var id = $(this).data('id');

            $.ajax({
				type:'POST',
		        url: "controllers/order.ctrl.php?ket=ordertype",
                dataType: "json",
                data:{id:id},
                success:function(data){
                	$('#defaultForm-ordertype').val(data[0]);

					$('#bayar').removeAttr("disabled");
					$('.ordertype').removeAttr("disabled");
					$('#'+data[0]).attr("disabled","true");
					$('.container__load').load('components/content/order.content.php?kond=home');
                	

                }
            });
	    });

		*/
		setInterval(function(){ 
			$('#datetime').empty(); 
			$('#datetime').append(moment(new Date()).format('ddd MMM DD YYYY | HH:mm:ss '));
		
		}, 1000);

		$('.container__load').load('components/content/order.content.php?kond=home');

		$('#carimenu').bind("enterKey",function(e){
			var search = $(this).val();
			$('.container__load').load('components/content/order.content.php?kond=search&q='+search);
			//alert(search);
			/*
			$.ajax({
                type: 'POST',
                url: "components/content/order.content.php?kond=search",
                dataType: "json",
                data:{search:search},
                success: function(data) {
                	console.log(data)
                  //$('.container__load').load(data);
                }
            });
            */
		});
		

		$('#carimenu').keyup(function(e){
			if(e.keyCode == 13) {
				$(this).trigger("enterKey");
			}
		});


		$('#batal').on('click',function(){
			$.ajax({
                type: 'POST',
		        url: "controllers/order.ctrl.php?ket=batal",
                dataType: "json",
                success: function() {
                  	console.log("delete sukses")
					$('.container__load').load('components/content/order.content.php?kond=home');
		        	$('#listitem table').empty();
                }
            });
		});


		$('#bayar').on('click',function(){
			$('#listbarang tbody').empty();
          	$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=list-order-temp',
		        dataType: "json",
		        success:function(data){
		        	console.log(data);
		        	var total = 0;
		        	for (var i in data) {
		        		total += parseInt(data[i].order_detail_temp_total);
	        			$('#listbarang tbody').append("<tr><td>"+data[i].barang_nama+"<br>"+data[i].order_detail_temp_ket+"</td><td>"+data[i].subkategori_nama+"</td><td class='text-right'>"+data[i].order_detail_temp_jumlah+"</td></tr>");
		        		
		            }
                	$("#modalorder #ip-total").val(total);

		        }
		    });
		    /*
		    $("#totalorder").empty();
		    $("#totalorder").append($("#total").text());
        	$('#defaultForm-totalmodal').val($("#defaultForm-total").val());


		    $('.btn.paytype').on('click',function(){
				var id = $(this).data('id');
            	$('#defaultForm-paytype').val(id);

				$('.paytype').removeAttr("disabled");
				$('#'+id).attr("disabled","true");

				$('.btn.paytype').removeClass("select");
				$(this).addClass("select");

				if (id=='cash') {
					$('#price').removeAttr("disabled");
					$('#price').val('');
                  	$("#modalorder label").removeClass("active");
				} else {
                  	$("#modalorder label").addClass("active");
					$('#price').val(formatCurrency($('#defaultForm-totalmodal').val().toString(), ''));
					$('#price').attr("disabled","true");
				}

		    });
			*/
		});

	});
</script>