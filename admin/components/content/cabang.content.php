<?php include '../modals/cabang.modal.php'; ?>

    <button class="btn btn-primary btn-tambah-cabang" data-toggle="modal" data-target="#modalcabang">Tambah Cabang <i class="fas fa-box-open ml-1"></i></button>
    <table id="table-cabang" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
        <thead>
            <tr>
                <th>nama cabang</th>
                <th>alamat</th>
                <th>selisih harga</th>
                <th></th>
            </tr>
        </thead>
    </table>



    <script type="text/javascript">
      
    $(document).ready(function() {
        $('.btn-tambah-cabang').on('click',function(){
            $("#modalcabang #defaultForm-id").val('');
            $("#modalcabang #defaultForm-nama").val('');
            $("#modalcabang #defaultForm-alamat").val('');
            $("#modalcabang #defaultForm-harga").val('');
            $("#modalcabang #submit-cabang").removeClass('hidden');
            $("#modalcabang #update-cabang").addClass('hidden');
            $("#modalcabang #submit-cabang").removeAttr("disabled").button('refresh');
            $("#modalcabang #update-cabang").attr("disabled", "disabled").button('refresh');
            $('#modalcabang h4.modal-title').text('Tambah Cabang');
        });

        $('#table-cabang').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=cabang", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "cabang_nama" },
                { "data": "cabang_alamat" },
                { "data": "cabang_selisih_harga" },
                { "width": "180px", "render": function(data, type, full){
                     return '<a class="btn-floating btn-sm btn-default mr-2 btn-edit" data-toggle="modal" data-target="#modalcabang" data-id="' + full['cabang_id'] + '" title="Edit"><i class="fas fa-pen"></i></a> <a class="btn-floating btn-sm btn-danger btn-remove" data-id="' + full['cabang_id'] + '" title="Delete"><i class="fas fa-trash"></i></a>';
                    
                  }
                },
            ],
            /*
            "initComplete": function( settings, json ) {
              $('.btn-edit').on('click',function(){
                  var cabang_id = $(this).data('id');
                  console.log(cabang_id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editcabang',
                      dataType: "json",
                      data:{cabang_id:cabang_id},
                      success:function(data){
                        $("#modalcabang #update-cabang").removeClass('hidden');
                        $("#modalcabang #submit-cabang").addClass('hidden');
                        $('#modalcabang h4.modal-title').text('Edit cabang');
                          $("#modalcabang label").addClass("active");
                          $("#modalcabang #defaultForm-id").val(data[0].cabang_id);
                          $("#modalcabang #defaultForm-nama").val(data[0].cabang_nama);
                          $("#modalcabang #defaultForm-jenis").val(data[0].cabang_jenis);

                      }
                  });
                  
              });
            },
            */
            "drawCallback": function( settings ) {
              $('.btn-edit').on('click',function(){
                  var id = $(this).data('id');
                  console.log(id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editcabang',
                      dataType: "json",
                      data:{id:id},
                      success:function(data){
                      $("#modalcabang #update-cabang").removeClass('hidden');
                      $("#modalcabang #submit-cabang").addClass('hidden');
                      $("#modalcabang #update-cabang").removeAttr("disabled").button('refresh');
                      $("#modalcabang #submit-cabang").attr("disabled", "disabled").button('refresh');
                      $('#modalcabang h4.modal-title').text('Edit Cabang');
                          $("#modalcabang label").addClass("active");
                          $("#modalcabang #defaultForm-id").val(data[0].cabang_id);
                          $("#modalcabang #defaultForm-nama").val(data[0].cabang_nama);
                          $("#modalcabang #defaultForm-alamat").val(data[0].cabang_alamat);
                          $("#modalcabang #defaultForm-harga").val(data[0].cabang_selisih_harga);
                      }
                  });
              });

              $('.btn-remove').on('click', function(){
                  var id = $(this).data('id');
                  $.confirm({
                      title: 'Konfirmasi Hapus cabang',
                      content: 'Apakah yakin menghapus cabang ini?',
                      buttons: {
                          confirm: {
                              text: 'Ya',
                              btnClass: 'col-md-6 btn btn-primary',
                              action: function(){
                                  console.log(id);
                                  
                                  $.ajax({
                                    type: 'POST',
                                    url: "controllers/cabang.ctrl.php?ket=remove-cabang",
                                    dataType: "json",
                                    data:{id:id},
                                    success: function(data) {
                                      if (data[0]=="ok") {
                                        $('#table-cabang').DataTable().ajax.reload();
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