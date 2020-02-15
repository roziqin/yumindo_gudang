
<!-------------- Modal tambah produk -------------->

<div class="modal fade" id="modalorder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Detail Pemesanan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3 pl-0 pr-0">
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
          <div class="col-12 pl-0 pr-0 col-table">
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
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal" aria-label="Close">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-------------- End modal tambah produk -------------->



  <script type="text/javascript">
    $(document).ready(function(){


    });
  </script> 