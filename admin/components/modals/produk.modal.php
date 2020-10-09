<?php $con = mysqli_connect("localhost","root","","gudang_yumindo"); ?>

<!-------------- Modal tambah produk -------------->

<div class="modal fade" id="modalproduk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Tambah Produk</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <form method="post" class="form-produk">
          <input type="hidden" id="defaultForm-id" name="ip-id">
          <input type="hidden" id="defaultForm-ceksub" name="ceksubkategori">
          <div class="row">
            <div class="col-md-8">
              <div class="md-form mb-0">
                <input type="text" id="defaultForm-nama" class="form-control validate mb-3" name="ip-nama">
                <label for="defaultForm-nama">Nama Produk</label>
              </div>
              <div class="md-form mb-0">
                <input type="text" id="defaultForm-sku" class="form-control validate mb-3" name="ip-sku">
                <label for="defaultForm-sku">SKU</label>
              </div>
              <div class="md-form mb-0">
                  <select class="mdb-select md-form" id="defaultForm-kategori" name="ip-kategori">
                      <option value="" disabled selected>Pilih Kategori</option>
                  <?php
                      $sql="SELECT * from kategori";
                      $result=mysqli_query($con,$sql);
                      while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                          echo "<option value='$data1[kategori_id]'>$data1[kategori_nama]</option>";
                      }
                  ?>
                  </select>
              </div>
              <div class="md-form mb-0">
                  <select class="mdb-select md-form" id="defaultForm-subkategori" name="ip-subkategori">
                      <option value="" disabled selected>Pilih Sub Kategori</option>
                  ?>
                  </select>
              </div>
              <div class="md-form mb-0 mt-0">
                <input type="text" id="defaultForm-jual" class="form-control validate mb-3" name="ip-jual">
                <label for="defaultForm-jual">Harga Jual</label>
              </div>
              <div class="md-form mb-0 mt-0">
                  <select class="mdb-select md-form" id="defaultForm-disable" name="ip-disable">
                      <option value="" disabled selected>Set Disable</option>
                      <option value="0">Tidak</option>
                      <option value="1">Ya</option>
                  </select>
              </div>
              <div class="md-form mb-0 mt-0">
                  <div class="file-field">
                      <div class="btn btn-primary btn-sm float-left">
                          <span>Choose files</span>
                          <input type="file" id="defaultForm-foto-1" name="ip-foto-1" >
                      </div>
                      <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Upload gambar 1" name="ip-textfoto-1" id="textfoto-1">
                      </div>
                  </div>
              </div>
              <br>
              <div class="md-form mb-0 mt-0">
                  <div class="file-field">
                      <div class="btn btn-primary btn-sm float-left">
                          <span>Choose files</span>
                          <input type="file" id="defaultForm-foto-2" name="ip-foto-2" >
                      </div>
                      <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Upload gambar 2" name="ip-textfoto-2" id="textfoto-2">
                      </div>
                  </div>
              </div>
              <br>
              <div class="md-form mb-0 mt-0">
                  <div class="file-field">
                      <div class="btn btn-primary btn-sm float-left">
                          <span>Choose files</span>
                          <input type="file" id="defaultForm-foto-3" name="ip-foto-3" >
                      </div>
                      <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Upload gambar 3" name="ip-textfoto-3" id="textfoto-3">
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4">
              <label class="textimg-1">Gambar 1</label>
              <img src="" class="img-fluid img-1" alt="Image 1">
              <label class="textimg-2">Gambar 2</label>
              <img src="" class="img-fluid img-2" alt="Image 2">
              <label class="textimg-3">Gambar 3</label>
              <img src="" class="img-fluid img-3" alt="Image 3">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-produk" data-dismiss="modal" aria-label="Close">Proses</button>
        <button class="btn btn-primary" id="update-produk" data-dismiss="modal" aria-label="Close">Edit</button>
      </div>
    </div>
  </div>
</div>

<!-------------- End modal tambah produk -------------->

  <script type="text/javascript">
    $(document).ready(function(){

      $('.mdb-select').materialSelect();
      $('#modalproduk').on('shown.bs.modal', function () {
        if ($('#defaultForm-ceksub')!='') {
          $('#defaultForm-subkategori').val($('#defaultForm-ceksub').val());
        }
      })
      $("#defaultForm-kategori").change(function(){
          var kategori = $(this).val();
          $('#defaultForm-subkategori').children('option:not(:first)').remove();
        
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
      $("#submit-produk").click(function(){
        var data = new FormData();
        data.append('ip-id', $("#defaultForm-id").val());
        data.append('ip-nama', $("#defaultForm-nama").val());
        data.append('ip-subkategori', $("#defaultForm-subkategori").val());
        data.append('ip-sku', $("#defaultForm-sku").val());
        data.append('ip-jual', $("#defaultForm-jual").val());
        data.append('ip-disable', $("#defaultForm-disable").val());
        data.append('ip-foto-1', $("#defaultForm-foto-1")[0].files[0]);
        data.append('ip-foto-2', $("#defaultForm-foto-2")[0].files[0]);
        data.append('ip-foto-3', $("#defaultForm-foto-3")[0].files[0]);

        console.log(data);

        $.ajax({
          type: 'POST',
          url: "controllers/produk.ctrl.php?ket=submit-produk",
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          success: function() {
            console.log("sukses")
            $('#example').DataTable().ajax.reload();
          }
        });
      });   


      $("#update-produk").click(function(){
        
        var data = new FormData();
        data.append('ip-id', $("#defaultForm-id").val());
        data.append('ip-nama', $("#defaultForm-nama").val());
        data.append('ip-subkategori', $("#defaultForm-subkategori").val());
        data.append('ip-sku', $("#defaultForm-sku").val());
        data.append('ip-jual', $("#defaultForm-jual").val());
        data.append('ip-disable', $("#defaultForm-disable").val());
        data.append('ip-foto-1', $("#defaultForm-foto-1")[0].files[0]);
        data.append('ip-foto-2', $("#defaultForm-foto-2")[0].files[0]);
        data.append('ip-foto-3', $("#defaultForm-foto-3")[0].files[0]);

        console.log(data);

        $.ajax({
          type: 'POST',
          url: "controllers/produk.ctrl.php?ket=update-produk",
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          success: function(data) {
            console.log("sukses edit")
            console.log(data)
            $('#example').DataTable().ajax.reload();
          }
        });
      }); 
      
    });
  </script> 