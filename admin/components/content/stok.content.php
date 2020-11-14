<?php
session_start(); 
include '../modals/stok.modal.php'; ?>

    <input type="hidden" name="form-role" id="form-role" value="<?php echo $_SESSION['role']; ?>">
    <table id="table-stok" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
        <thead>
            <tr>
                <th>nama</th>
                <th>subkategori</th>
                <th>stok</th>
                <th>batas stok</th>
                <th>foto</th>
                <th></th>
            </tr>
        </thead>
    </table>



    <script type="text/javascript">
      
    $(document).ready(function() {
        var role = $("#form-role").val();

        $('#table-stok').DataTable( {
            "pageLength": 100,
            "processing": true,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=stok", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "barang_nama" },
                { "data": "subkategori_nama" },
                { "data": "barang_stok" },
                { "data": "barang_batas_stok" },
                { "width": "240px", "render": function(data, type, full){
                    var n = "";
                    if(full['barang_image_1']!="") {
                      n = '<a href="../assets/img/'+full['barang_image_1']+'" target="_blank"><img src="../assets/img/'+full['barang_image_1']+'" width="70" style="margin-right: 3px;"></a>';
                    }
                    if(full['barang_image_2']!="") {
                      n = n + '<a href="../assets/img/'+full['barang_image_2']+'" target="_blank"><img src="../assets/img/'+full['barang_image_2']+'" width="70" style="margin-right: 3px;"></a>';
                    }
                    if(full['barang_image_3']!="") {
                      n = n + '<a href="../assets/img/'+full['barang_image_3']+'" target="_blank"><img src="../assets/img/'+full['barang_image_3']+'" width="70"></a>';
                    } 
                   return n;
                  }
                },
                { "width": "220px", "render": function(data, type, full){
                    if (role=="md") {
                        return '<a class="btn-floating btn-sm btn-warning mr-2 btn-setstok" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Set Stok"><i class="fas fa-clipboard-list"></i></a><a class="btn-floating btn-sm btn-danger mr-2 btn-revisi" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Revisi Stok"><i class="fas fa-clipboard-list"></i></a><a class="btn-floating btn-sm btn-default mr-2 btn-batas" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Set Batas Stok"><i class="fas fa-pen"></i></a>';
                    } else {
                        return '<a class="btn-floating btn-sm btn-primary mr-2 btn-tambah" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Tambah"><i class="fas fa-plus"></i></a><a class="btn-floating btn-sm btn-warning mr-2 btn-edit" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Kurang"><i class="fas fa-minus"></i></a><a class="btn-floating btn-sm btn-default mr-2 btn-batas" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Set Batas Stok"><i class="fas fa-pen"></i></a>';

                    }
                    
                  }
                },
            ],
            "drawCallback": function( settings ) {
              $('.btn-tambah').on('click',function(){
                  var id = $(this).data('id');
                  console.log(id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editstok',
                      dataType: "json",
                      data:{id:id},
                      success:function(data){
                          $("#modalstok #set-stok").addClass('hidden');
                          $("#modalstok #update-stok").addClass('hidden');
                          $("#modalstok #submit-stok").removeClass('hidden');
                          $("#modalstok #rev-stok").addClass('hidden');
                          $("#modalstok #updatebatas-stok").addClass('hidden');
                          $("#modalstok #submit-stok").removeAttr("disabled").button('refresh');
                          $("#modalstok #set-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #update-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #updatebatas-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #rev-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #md-form-ket").addClass('hidden');
                          $("#modalstok #md-form-jumlah").removeClass('hidden');
                          $("#modalstok #md-form-batas").addClass('hidden');
                          $('#modalstok h4.modal-title').text('Tambah stok');
                          $("#modalstok label").addClass("active");
                          $("#modalstok #defaultForm-id").val(data[0].barang_id);
                          $("#modalstok #defaultForm-nama").val(data[0].barang_nama);
                          $("#modalstok #md-form-jumlahrevisi").addClass('hidden');
                          $("#modalstok #defaultForm-jumlah").val("");
                      }
                  });
              });

              $('.btn-edit').on('click',function(){
                  var id = $(this).data('id');
                  console.log(id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editstok',
                      dataType: "json",
                      data:{id:id},
                      success:function(data){
                          $("#modalstok #set-stok").addClass('hidden');
                          $("#modalstok #update-stok").removeClass('hidden');
                          $("#modalstok #submit-stok").addClass('hidden');
                          $("#modalstok #md-form-ket").removeClass('hidden');
                          $("#modalstok #md-form-jumlah").removeClass('hidden');
                          $("#modalstok #updatebatas-stok").addClass('hidden');
                          $("#modalstok #rev-stok").addClass('hidden');
                          $("#modalstok #update-stok").removeAttr("disabled").button('refresh');
                          $("#modalstok #set-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #submit-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #updatebatas-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #rev-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #md-form-batas").addClass('hidden');
                          $("[name='ip-ket']").attr('required',true);
                          $('#modalstok h4.modal-title').text('Kurangi stok');
                          $("#modalstok label").addClass("active");
                          $("#modalstok #defaultForm-id").val(data[0].barang_id);
                          $("#modalstok #defaultForm-nama").val(data[0].barang_nama);
                          $("#modalstok #md-form-jumlahrevisi").addClass('hidden');
                          $("#modalstok #defaultForm-jumlah").val("");
                      }
                  });
              });

              $('.btn-setstok').on('click',function(){
                  var id = $(this).data('id');
                  console.log(id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editstok',
                      dataType: "json",
                      data:{id:id},
                      success:function(data){
                          $("#modalstok #set-stok").removeClass('hidden');
                          $("#modalstok #update-stok").addClass('hidden');
                          $("#modalstok #submit-stok").addClass('hidden');
                          $("#modalstok #md-form-ket").addClass('hidden');
                          $("#modalstok #md-form-jumlah").removeClass('hidden');
                          $("#modalstok #updatebatas-stok").addClass('hidden');
                          $("#modalstok #rev-stok").addClass('hidden');
                          $("#modalstok #set-stok").removeAttr("disabled").button('refresh');
                          $("#modalstok #submit-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #update-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #updatebatas-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #rev-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #md-form-batas").addClass('hidden');
                          $("[name='ip-ket']").attr('required',true);
                          $('#modalstok h4.modal-title').text('Sisa Stok');
                          $("#modalstok label").addClass("active");
                          $("#modalstok #defaultForm-id").val(data[0].barang_id);
                          $("#modalstok #defaultForm-nama").val(data[0].barang_nama);
                          $("#modalstok #md-form-jumlahrevisi").addClass('hidden');
                          $("#modalstok #defaultForm-jumlah").val("");
                      }
                  });
              });

              $('.btn-batas').on('click',function(){
                  var id = $(this).data('id');
                  console.log(id)
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editstok',
                      dataType: "json",
                      data:{id:id},
                      success:function(data){
                          $("#modalstok #set-stok").addClass('hidden');
                          $("#modalstok #update-stok").addClass('hidden');
                          $("#modalstok #submit-stok").addClass('hidden');
                          $("#modalstok #md-form-ket").addClass('hidden');
                          $("#modalstok #md-form-jumlah").addClass('hidden');
                          $("#modalstok #updatebatas-stok").removeClass('hidden');
                          $("#modalstok #rev-stok").addClass('hidden');
                          $("#modalstok #updatebatas-stok").removeAttr("disabled").button('refresh');
                          $("#modalstok #set-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #update-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #submit-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #rev-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #md-form-batas").removeClass('hidden');
                          $('#modalstok h4.modal-title').text('Edit Batas stok');
                          $("#modalstok label").addClass("active");
                          $("#modalstok #defaultForm-id").val(data[0].barang_id);
                          $("#modalstok #defaultForm-nama").val(data[0].barang_nama);
                          $("#modalstok #defaultForm-batas").val(data[0].barang_batas_stok);
                          $("#modalstok #md-form-jumlahrevisi").addClass('hidden');
                          $("#modalstok #defaultForm-jumlah").val("");
                      }
                  });
              });

             
              $('.btn-revisi').on('click',function(){
                  var id = $(this).data('id');
                  console.log("revisi")
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=editstok',
                      dataType: "json",
                      data:{id:id},
                      success:function(data){
                          $("#modalstok #set-stok").addClass('hidden');
                          $("#modalstok #update-stok").addClass('hidden');
                          $("#modalstok #submit-stok").addClass('hidden');
                          $("#modalstok #rev-stok").removeClass('hidden');
                          $("#modalstok #updatebatas-stok").addClass('hidden');
                          $("#modalstok #rev-stok").removeAttr("disabled").button('refresh');
                          $("#modalstok #set-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #update-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #updatebatas-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #submit-stok").attr("disabled", "disabled").button('refresh');
                          $("#modalstok #md-form-ket").addClass('hidden');
                          $("#modalstok #md-form-jumlah").removeClass('hidden');
                          $("#modalstok #md-form-batas").addClass('hidden');
                          $('#modalstok h4.modal-title').text('Revisi stok');
                          $("#modalstok label").addClass("active");
                          $("#modalstok #defaultForm-id").val(data[0].barang_id);
                          $("#modalstok #defaultForm-nama").val(data[0].barang_nama);
                          $("#modalstok #defaultForm-jumlah").val(data[0].barang_stok);
                          $("#modalstok #md-form-jumlahrevisi").removeClass('hidden');
                      }
                  });
              });
              
            }
        } );

      
    } );
    </script>