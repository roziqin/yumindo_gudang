<?php include '../modals/konfpesanan.modal.php'; ?>

    <table id="example" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>tanggal</th>
                <th>no order</th>
                <th>nama</th>
                <th>cabang</th>
                <th>status</th>
                <th></th>
            </tr>
        </thead>
    </table>



    <script type="text/javascript">
      
    $(document).ready(function() {

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=konfpesanan", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "orderbarang_id" },
                { "data": "orderbarang_tanggal" },
                { "data": "orderbarang_no_pesan" },
                { "data": "name" },
                { "data": "cabang_nama" },
                { "data": "orderbarang_status" },
                { "width": "150px", "render": function(data, type, full){
                   return '<a class="btn-floating btn-sm btn-default mr-2 btn-detail" data-toggle="modal" data-target="#modalorderkonf" data-id="' + full['orderbarang_no_pesan'] + '" title="Detail Pesanan"><i class="fas fa-pen"></i></a>';
                  }
                },
            ],
            "drawCallback": function( settings ) {
              $('.btn-detail').on('click',function(){
                  var order_id = $(this).data('id');
                  var status = '';
                  console.log(order_id);
                  $('#listbarang tbody').empty();
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=detailpesanan',
                      dataType: "json",
                      data:{order_id:order_id},
                      success:function(data){
                        console.log(data);
                          for (var i in data) {
                            if (i==0) {
                              $('#modalorderkonf p.nama').text('User: '+data[i].user+' / '+data[i].cabang);
                              $('#modalorderkonf p.nonota').text('No Pesan: '+data[i].notaid);
                              $('#modalorderkonf p.tanggal').text('Tanggal: '+data[i].tanggal);
                              $('#modalorderkonf p.waktu').text('Waktu: '+data[i].waktu);
                              $('#modalorderkonf #form-idpesanan').val(data[i].idpesanan);

                              if (data[i].status=='Proses') {
                                $("#modalorderkonf .btn-proses").addClass('hidden');
                                $("#modalorderkonf .btn-konfirmasi").removeClass('hidden');
                                $("#modalorderkonf .canvas").removeClass('hidden');
                                $("#modalorderkonf .image-ttd").addClass('hidden');
                              } else if (data[i].status=='Selesai') {
                                $("#modalorderkonf .btn-proses").addClass('hidden');
                                $("#modalorderkonf .btn-konfirmasi").addClass('hidden');
                                $("#modalorderkonf .canvas").addClass('hidden');
                                $("#modalorderkonf .image-ttd").removeClass('hidden');
                                $("#modalorderkonf .image-ttd").attr('src','../assets/img/'+data[i].ttd);
                              } else {
                                $("#modalorderkonf .btn-proses").removeClass('hidden');
                                $("#modalorderkonf .btn-konfirmasi").addClass('hidden');
                                $("#modalorderkonf .canvas").addClass('hidden');
                                $("#modalorderkonf .image-ttd").addClass('hidden');
                              }
                            } else {
                              if (data[i].order_detail_status=='Proses') {
                                status = '<a class="btn-floating btn-sm btn-default btn-cek m-0" title="Proses" data-id="'+data[i].order_detail_id+'"><i class="far fa-check-square"></i></a>';
                              } else {
                                status = data[i].order_detail_status;
                              }
                              $('#listbarang tbody').append("<tr><td>"+data[i].barang_nama+"</td><td>"+data[i].subkategori_nama+"</td><td class='text-right'>"+data[i].order_detail_jumlah+"</td><td class='text-right'>"+status+"</td></tr>");
                            }
                          }
                          $(".btn-cek").click(function(){
        
                            var data = new FormData();
                            data.append('ip-id', $(this).data('id'));

                            var indexitem = $(this).parent().parent().index()+1;
                            console.log(indexitem);

                            
                            $.ajax({
                              type: 'POST',
                              url: "controllers/order.ctrl.php?ket=update-status",
                              data: data,
                              cache: false,
                              processData: false,
                              contentType: false,
                              success: function(data) {
                                console.log("sukses edit");
                                $("#listbarang tr:nth-child("+indexitem+") td:nth-child(4)").empty();
                                $("#listbarang tr:nth-child("+indexitem+") td:nth-child(4)").append("Cek");
                              }
                            });
                            
                          });
                      }

                  });
              });
              
            }
        } );

      
    } );
    </script>