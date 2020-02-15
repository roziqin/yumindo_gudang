<!-------------- Modal kategori -------------->

<div class="modal fade" id="modaltambahkategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Tambah kategori</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" class="form-kategori">
        <div class="modal-body mx-3">
            <input type="hidden" id="defaultForm-id" name="ip-id">
            <div class="md-form mb-0">
              <input type="text" id="defaultForm-nama" class="form-control validate mb-3" name="ip-nama">
              <label for="defaultForm-nama">Nama kategori</label>
            </div>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button class="btn btn-primary" id="submit-kategori" data-dismiss="modal" aria-label="Close">Proses</button>
          <button class="btn btn-primary" id="update-kategori" data-dismiss="modal" aria-label="Close">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-------------- End modal kategori -------------->




  <script type="text/javascript">
    $(document).ready(function(){

      $('.mdb-select').materialSelect();

      $("#submit-kategori").click(function(){
        var data = $('#modaltambahkategori .form-kategori').serialize();
        $.ajax({
          type: 'POST',
          url: "controllers/kategori.ctrl.php?ket=submit-kategori",
          data: data,
          success: function() {
            console.log("sukses")
            $('#table-kategori').DataTable().ajax.reload();
            $("#modaltambahkategori #defaultForm-nama").val('');
          }
        });
      });   


      $("#update-kategori").click(function(){
        var data = $('#modaltambahkategori .form-kategori').serialize();
        $.ajax({
          type: 'POST',
          url: "controllers/kategori.ctrl.php?ket=update-kategori",
          data: data,
          success: function() {
            console.log("sukses edit")
            $('#table-kategori').DataTable().ajax.reload();
            $("#modaltambahkategori #defaultForm-nama").val('');
          }
        });
      }); 
      
    });
  </script> 