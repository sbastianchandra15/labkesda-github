<?php if (isset($_SESSION['alert'])): ?>
  <script type="text/javascript">
    Command: toastr["info"]("<?php echo $_SESSION['alert']; ?>", "Update Hasil Laboratorium",{
      "closeButton": true,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "5000",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "5000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }).css("width","750px");
  </script>
<?php endif; ?>
<section class="content-header">
  <h1>
    Transaksi
    <small>View Hasil Pemeriksaan Lingkungan</small>
  </h1>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">
          <table id="itemsTable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No Pendaftaran</th>
              <th>Nama</th>
              <th>Laboratorium</th>
              <th>Sampel</th>
              <th>Tgl Terima</th>
              <th>Tgl Pengujian</th>
              <th>Tgl Selesai</th>
              <th>Metode</th>
              <th width="10%">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($data_pendaftaran as $key => $value) {
            ?>
            <tr>
              <td><a href="#" id='detail' onclick="return show_detail(this)" data-no="<?php echo $value->no_pendaftaran; ?>"><?php echo $value->no_pendaftaran; ?></a></td>
              <td><?php echo $value->nama; ?></td>
              <td><?php echo $value->lab; ?></td>
              <td><?php echo $value->nm_sampel; ?></td>
              <td><?php echo $value->tgl_diterima; ?></td>
              <td><?php echo $value->tgl_pengujian; ?></td>
              <td><?php echo $value->tgl_selesai; ?></td>
              <td><?php echo $value->nm_metode; ?></td>
              <td align="center">
                <?php 
                if($value->status==0){
                  echo '<a type="submit" class="btn btn-xs btn-warning disabled">Hasil</a></td>';
                  echo '<a type="submit" class="btn btn-xs btn-warning disabled">Cetak</a></td>';
                }else{
                ?>
                  <a href="<?php echo base_url('transaksi/hasil_lingkungan/update/'.$value->nopendaftar); ?>" type="submit" class="btn btn-xs btn-warning">Hasil</a>
                  <a href="<?php echo base_url('transaksi/hasil_lingkungan/cetak/'.$value->nopendaftar); ?>" type="submit" class="btn btn-xs btn-info">Cetak</a>
                <?php
                }
                ?>
              </td>
            </tr>
            <?php 
            }
            ?>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

<script type="text/javascript">

$(document).ready(function(){
$('#itemsTable').DataTable({
  "paging": true, 
  "bLengthChange": false, // disable show entries dan page
  "bFilter": true,
  "bInfo": true, // disable Showing 0 to 0 of 0 entries
  "bAutoWidth": false,
  "language": {
      "emptyTable": "No Data"
  },
  "aaSorting": [],
});

$('#itemsTable').on('click','#delete',function(e){
  var nomor           = $(this).data('nomor').replace(/-/g, '/');

  BootstrapDialog.show({
    title: 'Hapus Pendaftaraan ',
    type : BootstrapDialog.TYPE_DANGER,
    message: 'Ingin menghapus Pendaftaran '+nomor+' ?',
    closable: false,
    buttons: [
      {
        label: '<i class="fa fa-reply"></i> Cancel', cssClass: 'btn',
        action: function(dia){
          dia.close();
        }
      },
      {
        label: '<i class="fa fa-close"></i> Hapus', cssClass: 'btn-danger', id: 'update_sales', //hotkey: 'alt'+'s',
        // icon: 'glyphicon glyphicon-check',
        action: function(dia){
          dia.close();
          $.ajax({
              data: {
                  nomor : nomor
              },
              type : "POST",
              url: baseUrl+'transaksi/pendaftaran_lingkungan/delete',
              success : function(resp){

                if(resp.status == 'ERROR INSERT' || resp.status == false) {
                  alert('Data Tidak berhasil di Hapus');
                  return false;

                } else {
                  $.notify({
                        icon: "glyphicon glyphicon-save",
                        message: 'Data Berhasil di Hapus'
                      },{
                        type: 'success',
                        onClosed: function(){ location.reload();}
                      });

                  setTimeout(function () {
                    window.location.href = baseUrl+'transaksi/pendaftaran_lingkungan'; //will redirect to google.
                  }, 2000);
                }
              }
          });
        }
      }
    ],
  });
});
})
</script>