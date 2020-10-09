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
                <th>foto</th>
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
            $("#modalproduk #defaultForm-ceksub").val('');
            $("#modalproduk #defaultForm-kategori").val('');
            $("#modalproduk #defaultForm-sku").val('');
            $("#modalproduk #defaultForm-jual").val('');
            $("#modalproduk #defaultForm-disable").val('');
            $('#modalproduk #defaultForm-subkategori').children('option:not(:first)').remove();
            $("#modalproduk #defaultForm-foto-1").val('');
            $("#modalproduk #textfoto-1").val('');
            $("#modalproduk #defaultForm-foto-2").val('');
            $("#modalproduk #textfoto-2").val('');
            $("#modalproduk #defaultForm-foto-3").val('');
            $("#modalproduk #textfoto-3").val('');
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
                { "width": "240px", "render": function(data, type, full){
                    var n = "";
                    if(full['barang_image_1']!="") {
                      n = '<img src="../assets/img/'+full['barang_image_1']+'" width="70" style="margin-right: 3px;">';
                    }
                    if(full['barang_image_2']!="") {
                      n = n + '<img src="../assets/img/'+full['barang_image_2']+'" width="70" style="margin-right: 3px;">';
                    }
                    if(full['barang_image_3']!="") {
                      n = n + '<img src="../assets/img/'+full['barang_image_3']+'" width="70">';
                    } 
                   return n;
                  }
                },
                { "width": "150px", "render": function(data, type, full){
                   return '<a class="btn-floating btn-sm btn-default mr-2 btn-edit" data-toggle="modal" data-target="#modalproduk" data-id="' + full['barang_id'] + '" title="Edit"><i class="fas fa-pen"></i></a> <a class="btn-floating btn-sm btn-danger btn-remove" data-id="' + full['barang_id'] + '" title="Delete"><i class="fas fa-trash"></i></a>';
                  }
                },
            ],
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
                          $("#modalproduk #defaultForm-sku").val(data[0].barang_sku);
                          $("#modalproduk #defaultForm-jual").val(data[0].barang_harga_jual);
                          $("#modalproduk #defaultForm-disable").val(data[0].barang_disable);
                          $("#modalproduk #defaultForm-kategori").val(data[0].subkategori_parent);
                          if (data[0].barang_image_1!="") {
                            $("#modalproduk .textimg-1").css("display","block");
                            $("#modalproduk .img-1").css("display","block");
                            $("#modalproduk .img-1").attr("src", "../assets/img/"+data[0].barang_image_1);
                          } else {
                            $("#modalproduk .textimg-1").css("display","none");
                            $("#modalproduk .img-1").css("display","none");
                          }
                          if (data[0].barang_image_2!="") {
                            $("#modalproduk .textimg-2").css("display","block");
                            $("#modalproduk .img-2").css("display","block");
                            $("#modalproduk .img-2").attr("src", "../assets/img/"+data[0].barang_image_2);
                          } else {
                            $("#modalproduk .textimg-2").css("display","none");
                            $("#modalproduk .img-2").css("display","none");
                          }
                          if (data[0].barang_image_3!="") {
                            $("#modalproduk .textimg-3").css("display","block");
                            $("#modalproduk .img-3").css("display","block");
                            $("#modalproduk .img-3").attr("src", "../assets/img/"+data[0].barang_image_3);
                          } else {
                            $("#modalproduk .textimg-3").css("display","none");
                            $("#modalproduk .img-3").css("display","none");
                          }
                          $("#modalproduk #defaultForm-foto-1").val('');
                          $("#modalproduk #textfoto-1").val('');
                          $("#modalproduk #defaultForm-foto-2").val('');
                          $("#modalproduk #textfoto-2").val('');
                          $("#modalproduk #defaultForm-foto-3").val('');
                          $("#modalproduk #textfoto-3").val('');
                          $('#modalproduk #defaultForm-subkategori').children('option:not(:first)').remove();
                          var kategori = data[0].subkategori_parent;
                          var subkategori = data[0].barang_subkategori;
                          $.ajax({
                              type:'POST',
                              url:'api/view.api.php?func=select-subkategori',
                              dataType: "json",
                                data:{
                                  kategori:kategori,
                                },
                              success:function(data){
                                for (var i in data) {
                                  $("#modalproduk #defaultForm-subkategori").append('<option value="'+data[i].subkategori_id+'">'+data[i].subkategori_nama+'</option>');
                                }
                              }
                          });
                          $("#modalproduk #defaultForm-ceksub").val(subkategori);

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