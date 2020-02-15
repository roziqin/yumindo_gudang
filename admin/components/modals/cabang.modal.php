<!-------------- Modal tambah kategori -------------->

<div class="modal fade" id="modalcabang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Tambah cabang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" class="form-cabang">
        <div class="modal-body mx-3">
            <input type="hidden" id="defaultForm-id" name="ip-id">
            <div class="md-form mb-0">
              <input type="text" id="defaultForm-nama" class="form-control validate mb-3" name="ip-nama">
              <label for="defaultForm-nama">Nama Cabang</label>
            </div>
            <div class="md-form mb-0">
              <input type="text" id="defaultForm-alamat" class="form-control validate mb-3" name="ip-alamat">
              <label for="defaultForm-alamat">Alamat Cabang</label>
            </div>
            <div class="md-form mb-0">
              <input type="text" id="defaultForm-harga" class="form-control validate mb-3" name="ip-harga">
              <label for="defaultForm-harga">Selisih Harga Cabang</label>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-primary" id="submit-cabang" data-dismiss="modal" aria-label="Close">Proses</button>
          <button class="btn btn-primary" id="update-cabang" data-dismiss="modal" aria-label="Close">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-------------- End modal tambah cabang -------------->


  <script type="text/javascript">
    $(document).ready(function(){

      $('.mdb-select').materialSelect();

      $("#submit-cabang").click(function(){
        var data = $('#modalcabang .form-cabang').serialize();
        $.ajax({
          type: 'POST',
          url: "controllers/cabang.ctrl.php?ket=submit-cabang",
          data: data,
          success: function() {
            console.log("sukses")
            $('#table-cabang').DataTable().ajax.reload();
            $("#modalcabang #defaultForm-nama").val('');
            $("#modalcabang #defaultForm-alamat").val('');
            $("#modalcabang #defaultForm-harga").val('');
          }
        });
      });   


      $("#update-cabang").click(function(){
        var data = $('#modalcabang .form-cabang').serialize();
        $.ajax({
          type: 'POST',
          url: "controllers/cabang.ctrl.php?ket=update-cabang",
          data: data,
          success: function() {
            console.log("sukses edit")
            $('#table-cabang').DataTable().ajax.reload();
            $("#modalcabang #defaultForm-nama").val('');
            $("#modalcabang #defaultForm-alamat").val('');
            $("#modalcabang #defaultForm-harga").val('');
          }
        });
      }); 
      
    });
  </script> 