<!-------------- Modal Transaksi -------------->

<div class="modal fade" id="modalorder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h2 class="modal-title w-100 font-weight-bold">Cek Pesanan</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <input type="hidden" name="ip-total" id="ip-total">
        <table id="listbarang" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th width="50px">Jumlah</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-order" data-dismiss="modal" aria-label="Close">Proses</button>
      </div>
    </div>
  </div>
</div>

<!-------------- End modal transaksi -------------->





  <script type="text/javascript">
      
      
      $("#submit-order").click(function(e){
          e.preventDefault();
          var total = $("#ip-total").val();
          $.ajax({
            type: 'POST',
            url: "controllers/order.ctrl.php?ket=prosesorder",
            data: {
              total:total,
            },
            success: function(data) {
                console.log(data);              
                $('.container__load').load('components/content/order.content.php?kond=kembalian');
                $('#listitem table').empty();              
            }
          });
      }); 
    
  </script> 