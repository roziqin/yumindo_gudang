<?php include '../modals/subkategori.modal.php'; ?>

    <button class="btn btn-primary btn-tambah-subkategori" data-toggle="modal" data-target="#modaltambahsubkategori">Tambah Sub Kategori <i class="fas fa-box-open ml-1"></i></button>
    <table id="table-subkategori" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
        <thead>
            <tr>
                <th>nama</th>
                <th>kategori</th>
                <th></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>nama</th>
                <th>kategori</th>
                <th></th>
            </tr>
        </tfoot>
    </table>



    <script type="text/javascript">
      
    $(document).ready(function() {
    	
      	$('.btn-tambah-subkategori').on('click',function(){
            $("#modaltambahsubkategori #defaultForm-nama").val('');
            $("#modaltambahsubkategori #defaultForm-parent").val('');
            $("#modaltambahsubkategori #submit-subkategori").removeClass('hidden');
            $("#modaltambahsubkategori #update-subkategori").addClass('hidden');
            $("#modaltambahsubkategori #submit-subkategori").removeAttr("disabled").button('refresh');
            $("#modaltambahsubkategori #update-subkategori").attr("disabled", "disabled").button('refresh');
            $('#modaltambahsubkategori h4.modal-title').text('Tambah Sub Kategori');
      	});
      	
        $('#table-subkategori').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=subkategori", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "subkategori_nama" },
                { "data": "kategori_nama" },

                { "width": "150px", "render": function(data, type, full){
                   return '<a class="btn-floating btn-sm btn-default mr-2 btn-edit" data-toggle="modal" data-target="#modaltambahsubkategori" data-id="' + full['subkategori_id'] + '" title="Edit"><i class="fas fa-pen"></i></a> <a class="btn-floating btn-sm btn-danger btn-remove" data-id="' + full['subkategori_id'] + '" title="Delete"><i class="fas fa-trash"></i></a>';
                }
                },
            ],
            "initComplete": function( settings, json ) {
              $('.btn-edit').on('click',function(){
                  var subkategori_id = $(this).data('id');
                  console.log(subkategori_id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editsubkategori',
                      dataType: "json",
                      data:{subkategori_id:subkategori_id},
                      success:function(data){
        			            $("#modaltambahsubkategori #update-subkategori").removeClass('hidden');
        			            $("#modaltambahsubkategori #submit-subkategori").addClass('hidden');
                          $("#modaltambahsubkategori #update-subkategori").removeAttr("disabled").button('refresh');
                          $("#modaltambahsubkategori #submit-subkategori").attr("disabled", "disabled").button('refresh');
        			            $('#modaltambahsubkategori h4.modal-title').text('Edit subkategori');
                          $("#modaltambahsubkategori label").addClass("active");
                          $("#modaltambahsubkategori #defaultForm-id").val(data[0].subkategori_id);
                          $("#modaltambahsubkategori #defaultForm-nama").val(data[0].subkategori_nama);
                          $("#modaltambahsubkategori #defaultForm-parent").val(data[0].subkategori_parent);

                      }
                  });
                  
              });
            },
            "drawCallback": function( settings ) {
              $('.btn-edit').on('click',function(){
                  var subkategori_id = $(this).data('id');
                  console.log(subkategori_id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editsubkategori',
                      dataType: "json",
                      data:{subkategori_id:subkategori_id},
                      success:function(data){
        			            $("#modaltambahsubkategori #update-subkategori").removeClass('hidden');
        			            $("#modaltambahsubkategori #submit-subkategori").addClass('hidden');
                          $("#modaltambahsubkategori #update-subkategori").removeAttr("disabled").button('refresh');
                          $("#modaltambahsubkategori #submit-subkategori").attr("disabled", "disabled").button('refresh');
        			            $('#modaltambahsubkategori h4.modal-title').text('Edit subkategori');
                          $("#modaltambahsubkategori label").addClass("active");
                          $("#modaltambahsubkategori #defaultForm-id").val(data[0].subkategori_id);
                          $("#modaltambahsubkategori #defaultForm-nama").val(data[0].subkategori_nama);
                          $("#modaltambahsubkategori #defaultForm-parent").val(data[0].subkategori_parent);

                      }
                  });
              });

              $('.btn-remove').on('click', function(){
                  var subkategori_id = $(this).data('id');
                  $.confirm({
                      title: 'Konfirmasi Hapus subkategori',
                      content: 'Apakah yakin menghapus kateogri ini?',
                      buttons: {
                          confirm: {
                              text: 'Ya',
                              btnClass: 'col-md-6 btn btn-primary',
                              action: function(){
                                  console.log(subkategori_id);
                                  
                                  $.ajax({
                                    type: 'POST',
                                    url: "controllers/subkategori.ctrl.php?ket=remove-subkategori",
                                    dataType: "json",
                                    data:{subkategori_id:subkategori_id},
                                    success: function(data) {
                                      if (data[0]=="ok") {
                                        $('#table-subkategori').DataTable().ajax.reload();
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