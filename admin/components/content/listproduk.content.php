<?php include '../modals/produk.modal.php'; ?>

    <button class="btn btn-primary btn-tambah-produk" data-toggle="modal" data-target="#modalproduk">Tambah Produk <i class="fas fa-box-open ml-1"></i></button>
    <table id="example" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
        <thead>
            <tr>
                <th>nama</th>
                <th>sku</th>
                <th>kategori</th>
                <th>sub kategori</th>
                <th>harga jual</th>
                <th>disable</th>
                <th></th>
            </tr>
        </thead>
    </table>



    <script type="text/javascript">
      
    $(document).ready(function() {

        $('.btn-tambah-produk').on('click',function(){

            $('#modalproduk h4.modal-title').text('Tambah Produk');
            $("#modalproduk #update-produk").addClass('hidden');
            $("#modalproduk #submit-produk").removeClass('hidden');
            $("#modalproduk #submit-produk").removeAttr("disabled").button('refresh');
            $("#modalproduk #update-produk").attr("disabled", "disabled").button('refresh');
            $("#modalproduk label").removeClass("active");
            $("#modalproduk #defaultForm-id").val('');
            $("#modalproduk #defaultForm-nama").val('');
            $("#modalproduk #defaultForm-subkategori").val('');
            $("#modalproduk #defaultForm-sku").val('');
            $("#modalproduk #defaultForm-jual").val('');
            $("#modalproduk #defaultForm-disable").val('');
        });

        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=produk", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "barang_nama" },
                { "data": "barang_sku" },
                { "data": "kategori_nama" },
                { "data": "subkategori_nama" },
                { "render": function(data, type, full){
                   return formatRupiah(full['barang_harga_jual'].toString(), 'Rp. ');
                  }
                },
                { "width": "150px", "render": function(data, type, full){

                    if (full['barang_disable']==1) {
                     return 'Ya';

                    } else {
                     return 'Tidak';
                    }
                  }
                },
                { "width": "150px", "render": function(data, type, full){
                   return '<a class="btn-floating btn-sm btn-default mr-2 btn-edit" data-toggle="modal" data-target="#modalproduk" data-id="' + full['barang_id'] + '" title="Edit"><i class="fas fa-pen"></i></a> <a class="btn-floating btn-sm btn-danger btn-remove" data-id="' + full['barang_id'] + '" title="Delete"><i class="fas fa-trash"></i></a>';
                  }
                },
            ],
            "initComplete": function( settings, json ) {
              $('.btn-edit').on('click',function(){
                  var produk_id = $(this).data('id');
                  console.log(produk_id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editproduk',
                      dataType: "json",
                      data:{produk_id:produk_id},
                      success:function(data){
                          $('#modalproduk h4.modal-title').text('Edit Produk');
                          $("#modalproduk #update-produk").removeClass('hidden');
                          $("#modalproduk #submit-produk").addClass('hidden');
                          $("#modalproduk #update-produk").removeAttr("disabled").button('refresh');
                          $("#modalproduk #submit-produk").attr("disabled", "disabled").button('refresh');
                          $("#modalproduk label").addClass("active");
                          $("#modalproduk #defaultForm-id").val(produk_id);
                          $("#modalproduk #defaultForm-nama").val(data[0].barang_nama);
                          $("#modalproduk #defaultForm-subkategori").val(data[0].barang_subkategori);
                          $("#modalproduk #defaultForm-sku").val(data[0].barang_sku);
                          $("#modalproduk #defaultForm-jual").val(data[0].barang_harga_jual);
                          $("#modalproduk #defaultForm-disable").val(data[0].barang_disable);

                      }
                  });
                  
              });
            },
            "drawCallback": function( settings ) {
              $('.btn-edit').on('click',function(){
                  var produk_id = $(this).data('id');
                  console.log(produk_id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editproduk',
                      dataType: "json",
                      data:{produk_id:produk_id},
                      success:function(data){
                          $('#modalproduk h4.modal-title').text('Edit Produk');
                          $("#modalproduk #update-produk").removeClass('hidden');
                          $("#modalproduk #submit-produk").addClass('hidden');
                          $("#modalproduk #update-produk").removeAttr("disabled").button('refresh');
                          $("#modalproduk #submit-produk").attr("disabled", "disabled").button('refresh');
                          $("#modalproduk label").addClass("active");
                          $("#modalproduk #defaultForm-id").val(produk_id);
                          $("#modalproduk #defaultForm-nama").val(data[0].barang_nama);
                          $("#modalproduk #defaultForm-subkategori").val(data[0].barang_subkategori);
                          $("#modalproduk #defaultForm-sku").val(data[0].barang_sku);
                          $("#modalproduk #defaultForm-jual").val(data[0].barang_harga_jual);
                          $("#modalproduk #defaultForm-disable").val(data[0].barang_disable);

                      }
                  });
              });

              $('.btn-remove').on('click', function(){
                  var produk_id = $(this).data('id');
                  $.confirm({
                      title: 'Konfirmasi Hapus Produk',
                      content: 'Apakah yakin menghapus produk ini?',
                      buttons: {
                          confirm: {
                              text: 'Ya',
                              btnClass: 'col-md-6 btn btn-primary',
                              action: function(){
                                  console.log(produk_id);
                                  
                                  $.ajax({
                                    type: 'POST',
                                    url: "controllers/produk.ctrl.php?ket=remove-produk",
                                    dataType: "json",
                                    data:{produk_id:produk_id},
                                    success: function(data) {
                                      if (data[0]=="ok") {
                                        $('#example').DataTable().ajax.reload();
                                      } else {
                                        alert('Produk gagal dihapus')
                                      }
                                    }
                                  });
                                  
                              }
                          },
                          cancel: {
                              text: 'Tidak',
                              btnClass: 'col-md-6 btn btn-danger text-white',
                              action: function(){
                                  console.log("tidak")
                                 
                              }
                              
                          }
                      }
                  });
              });
              
            }
        } );

      
    } );
    </script>