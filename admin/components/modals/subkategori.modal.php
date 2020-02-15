<?php $con = mysqli_connect("localhost","root","","gudang_yumindo"); ?>
<!-------------- Modal tambah subkategori -------------->

<div class="modal fade" id="modaltambahsubkategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Tambah Sub Kategori</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" class="form-subkategori">
        <div class="modal-body mx-3">
            <input type="hidden" id="defaultForm-id" name="ip-id">
            <div class="md-form mb-0">
              <input type="text" id="defaultForm-nama" class="form-control validate mb-3" name="ip-nama">
              <label for="defaultForm-nama">Nama Sub Kategori</label>
            </div>
            <div class="md-form mb-0">
                <select class="mdb-select md-form" id="defaultForm-parent" name="ip-parent">
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
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-primary" id="submit-subkategori" data-dismiss="modal" aria-label="Close">Proses</button>
          <button class="btn btn-primary" id="update-subkategori" data-dismiss="modal" aria-label="Close">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-------------- End modal tambah subkategori -------------->

  <script type="text/javascript">
    $(document).ready(function(){

      $('.mdb-select').materialSelect();

      $("#submit-subkategori").click(function(){
        var data = $('#modaltambahsubkategori .form-subkategori').serialize();
        $.ajax({
          type: 'POST',
          url: "controllers/subkategori.ctrl.php?ket=submit-subkategori",
          data: data,
          success: function() {
            console.log("sukses")
            $('#table-subkategori').DataTable().ajax.reload();
            $("#modaltambahsubkategori #defaultForm-nama").val('');
            $("#modaltambahsubkategori #defaultForm-parent").val('');
          }
        });
      });   


      $("#update-subkategori").click(function(){
        var data = $('#modaltambahsubkategori .form-subkategori').serialize();
        $.ajax({
          type: 'POST',
          url: "controllers/subkategori.ctrl.php?ket=update-subkategori",
          data: data,
          success: function() {
            console.log("sukses edit")
            $('#table-subkategori').DataTable().ajax.reload();
            $("#modaltambahsubkategori #defaultForm-nama").val('');
            $("#modaltambahsubkategori #defaultForm-parent").val('');
          }
        });
      }); 
      
    });
  </script> 