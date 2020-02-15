<?php include '../modals/logpesanan.modal.php'; ?>

    <table id="example" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
        <thead>
            <tr>
                <th>tanggal</th>
                <th>waktu</th>
                <th>no order</th>
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
                "url": "api/datatable.api.php?ket=logpesanan", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "orderbarang_tanggal" },
                { "data": "orderbarang_waktu" },
                { "data": "orderbarang_no_pesan" },
                { "data": "orderbarang_status" },
                { "width": "150px", "render": function(data, type, full){
                   return '<a class="btn-floating btn-sm btn-default mr-2 btn-detail" data-toggle="modal" data-target="#modalorder" data-id="' + full['orderbarang_no_pesan'] + '" title="Detail Pesanan"><i class="fas fa-pen"></i></a>';
                  }
                },
            ],
            "drawCallback": function( settings ) {
              $('.btn-detail').on('click',function(){
                  var order_id = $(this).data('id');
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
                                      $('#modalorder p.nama').text('User: '+data[i].user);
                                      $('#modalorder p.nonota').text('No Pesan: '+data[i].notaid);
                                      $('#modalorder p.tanggal').text('Tanggal: '+data[i].tanggal);
                                      $('#modalorder p.waktu').text('Waktu: '+data[i].waktu);
                            } else {
                              $('#listbarang tbody').append("<tr><td>"+data[i].barang_nama+"</td><td>"+data[i].subkategori_nama+"</td><td class='text-right'>"+data[i].order_detail_jumlah+"</td><td class='text-right'>"+data[i].order_detail_status+"</td></tr>");
                            }
                          }

                      }
                  });
              });
              
            }
        } );

      
    } );
    </script>