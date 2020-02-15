<?php 
  session_start();
?>

<!-------------- Modal tambah produk -------------->

<div class="modal fade" id="modalorderkonf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <input type="hidden" name="form-idpesanan" id="form-idpesanan">
        <h4 class="modal-title w-100 font-weight-bold">Detail Pemesanan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="row">
          <div class="col-md-6 col-md-offset-0">
            <p class="tanggal"></p>
          </div>
          <div class="col-md-6 col-md-offset-0">
            <p class="waktu"></p>
          </div>
          <div class="col-md-6 col-md-offset-0">
            <p class="nama"></p>
          </div>
          <div class="col-md-6 col-md-offset-0">
            <p class="nonota"></p>
          </div>
        </div>
        <table id="listbarang" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nama Barang</th>
            <th>Subkategori</th>
            <th width="50px" style="padding-right: 8px; ">Jumlah</th>
            <th class="text-right">Status</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <canvas class="canvas" style="background: #fff;border: 1px solid #000; margin: 10px auto;"></canvas>
        <img class="image-ttd" src="" width="">
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary btn-proses" data-dismiss="modal" aria-label="Close">Proses</button>
        <button class="btn btn-primary btn-konfirmasi" data-dismiss="modal" aria-label="Close">Konfirmasi</button>
      </div>
    </div>
  </div>
</div>

<!-------------- End modal tambah produk -------------->

  <script type="text/javascript">
    $(document).ready(function(){var canvas = document.querySelector("canvas");
        var signaturePad = new SignaturePad(canvas);

      $(".btn-proses").click(function(){
        
        var id = $("#form-idpesanan").val();
        var data = new FormData();
        data.append('ip-id', id);

        console.log(id);
        
        $.ajax({
          type: 'POST',
          url: "controllers/order.ctrl.php?ket=update-pesanan-status",
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          success: function(data) {
            console.log("sukses")
            $('#example').DataTable().ajax.reload();
          }
        });
      }); 

      $(".btn-konfirmasi").click(function(){

        var signature = signaturePad.toDataURL(); 

        var id = $("#form-idpesanan").val();
        var data = new FormData();
        data.append('ip-id', id);
        data.append('ip-ttd', signature);

        console.log(id);
        
        $.ajax({
          type: 'POST',
          url: "controllers/order.ctrl.php?ket=konfirmasi-pesanan",
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          success: function(data) {
            console.log("sukses")
            $('#example').DataTable().ajax.reload();
            var canvas = document.querySelector("canvas");
            new SignaturePad(canvas);
          }
        });
      }); 

    });
  </script> 