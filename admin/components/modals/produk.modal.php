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
          <div class="md-form mb-0">
            <input type="text" id="defaultForm-nama" class="form-control validate mb-3" name="ip-nama">
            <label for="defaultForm-nama">Nama Produk</label>
          </div>
          <div class="md-form mb-0">
            <input type="text" id="defaultForm-sku" class="form-control validate mb-3" name="ip-sku">
            <label for="defaultForm-sku">SKU</label>
          </div>
          <div class="md-form mb-0">
              <select class="mdb-select md-form" id="defaultForm-subkategori" name="ip-subkategori">
                  <option value="" disabled selected>Pilih Sub Kategori</option>
              <?php
                  $sql="SELECT * from subkategori";
                  $result=mysqli_query($con,$sql);
                  while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                    /*
                      if ($data['kategori_id']==$data1['kategori_id']) {
                          $select="selected";
                      } else {
                          $select="";
                      }
                      */
                      echo "<option value='$data1[subkategori_id]'>$data1[subkategori_nama]</option>";
                  }
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

      $("#submit-produk").click(function(){
        var data = new FormData();
        data.append('ip-id', $("#defaultForm-id").val());
        data.append('ip-nama', $("#defaultForm-nama").val());
        data.append('ip-subkategori', $("#defaultForm-subkategori").val());
        data.append('ip-sku', $("#defaultForm-sku").val());
        data.append('ip-jual', $("#defaultForm-jual").val());
        data.append('ip-disable', $("#defaultForm-disable").val());

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