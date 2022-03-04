<section class="content-header">
  <h1>
    Report
    <small>View History Stok</small>
  </h1>
  <ol class="breadcrumb">
    <!-- <li><a style="color: white" type="submit" class="btn btn-block btn-primary" href="<?php echo base_url('transaksi/mutasi_keluar/form'); ?>">Input</a></li> -->
  </ol>
</section>
<?php 
// test($id_lokasi.' '.$month.' '.$year,0);
?>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <form class="form-horizontal" action="<?= base_url('report/stok/history_stok'); ?>" method='POST'>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-1 control-label">Lokasi</label>
              <div class="col-sm-3">
                <select class="form-control select2" style="width: 100%;" id='id_lokasi' name="id_lokasi">
                  <option value="">- Pilih -</option>
                  <?php 
                  foreach ($data_lokasi as $key => $value) {
                    if($id_lokasi==$value->id_lokasi){
                      echo "<option value='".$value->id_lokasi."' selected>".$value->lokasi."</option>";
                    }else{
                      echo "<option value='".$value->id_lokasi."'>".$value->lokasi."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-1 control-label">Bulan</label>
              <div class="col-sm-2">
                <select class="form-control" id='month' name="month">
                  <option value=""> - </option>
                  <?php 
                  foreach ($data_month as $key => $value) {
                    if($this->input->post('month')==$value['id']){
                      echo '<option value="'.$value['id'].'" selected>'.$value['nama_bulan'].'</option>';
                    }else{
                      echo '<option value="'.$value['id'].'">'.$value['nama_bulan'].'</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <label for="inputEmail3" class="col-sm-1 control-label">Tahun</label>
              <div class="col-sm-2">
                <select class="form-control" id='year' name="year">
                  <option value=""> - </option>
                  <?php 
                  for($year=$year_old;$year<=$year_now;$year++){
                    if($this->input->post('year')==$year){
                      echo '<option value="'.$year.'" selected>'.$year.'</option>';
                    }else{
                      echo '<option value="'.$year.'">'.$year.'</option>';
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-1 control-label"></label>
              <div class="col-sm-5">
                <button type="submit" class="btn btn-warning" id="add-items">Cari</button>
                <?php 
                if($id_lokasi!=''){
                ?>
                <a class="btn btn-info" target="_blank" href="<?= base_url('report/stok/history_stok_cetak/'.$id_lokasi.'/'.$year1.'/'.$month); ?>">Excell</a>
                <?php 
                }  
                ?>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php 
      if($id_lokasi!=''){
      ?>
      <div class="box">
        <div class="box-body">
          <?php 
          foreach ($data_mutasi as $key => $value1) {
          ?>
            <table width="100%" class="table table-bordered table-striped">
              <tr>
                <td width="10%">Kode Barang</td>
                <td><?= $value1->barcode; ?></td>
              </tr>
              <tr>
                <td>Nama Barang</td>
                <td><?= $value1->nama; ?></td>
              </tr>
              <tr>
                <td>Lot Number</td>
                <td><?= $value1->lot_no; ?></td>
              </tr>
            </table>
            <table class="table table-bordered table-striped">
              <thead>
              <tr>
                <th width="9%">Kode</th>
                <th>Nama</th>
                <th width="9%">Tanggal Transaksi</th>
                <th width="9%">Tanggal Kadaluarsa</th>
                <th width="7%">Stok Awal</th>
                <th width="7%">Qty In</th>
                <th width="7%">Qty Out</th>
                <th width="7%">Stok Akhir</th>
              </tr>
              </thead>
              <tbody>
              <?php               
              $query    = "SELECT * FROM `t_stok_detail` a,m_barang b 
              WHERE a.id_barang=b.id_barang AND a.id_barang = '".$value1->id_barang."' AND a.id_lokasi = '".$id_lokasi."' AND a.lot_no = '".$value1->lot_no."' AND
              MONTH(a.tgl_transaksi)='".$month."' AND YEAR(a.tgl_transaksi)='".$year1."'
              ORDER BY a.lot_no DESC,a.id_barang,a.id_stok";
              // test($query,0);
              $history  = $this->db->query($query)->result();

              foreach ($history as $key => $value) {
                $bulan          = substr($value->tgl_kadaluwarsa,5,2);
                $hari           = substr($value->tgl_kadaluwarsa,8,2);
                $tahun          = substr($value->tgl_kadaluwarsa,0,4);
                $tanggal        = $bulan.'/'.$hari.'/'.$tahun;
                if($tanggal=='01/01/1700'){ $tanggal='';}
              ?>
              <tr>
                <td><?= $value->barcode; ?></td>
                <td><?= $value->nama; ?></td>
                <td><?= tgl_singkat($value->tgl_transaksi); ?></td>
                <td><?= $tanggal; ?></td>
                <td><?= $value->old_stock; ?></td>
                <td><?= $value->qty_in; ?></td>
                <td><?= $value->qty_out; ?></td>
                <td><?= $value->current_stock; ?></td>
              </tr>
              <?php 
              }
              ?>
            </table>
            <hr>
          <?php 
          }
          ?>
        </div>
        <!-- /.box-body -->
      </div>
      <?php 
      }
      ?>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>

<script>
function show_detail(e){
  let noId      = $(e).data('id');
  let noPr      = $(e).data('no');

  $.get({
    url: baseUrl + 'transaksi/mutasi_keluar/view_popup/'+noId,
    success: function(resp){
      BootstrapDialog.show({
        title: 'Nomor Mutasi # <strong> '+noPr+' </strong>', 
        nl2br: false, 
        message: resp,
        closable: true,
        size: 'size-full',
        buttons:[
          {
            label: 'Tutup',
            action: function(dia){ dia.close(); }
          }
        ]
      });
    },
    complete: function(){
      $('body').css('cursor','default');
    }
  });
  return false;
  
};

$(document).ready(function(){
  $('#id_lokasi').select2();
  $('#month').select2();
  $('#year').select2();

  $('#itemsTable').DataTable({
    "ordering": false,
    "bPaginate": false
  });

  $('#itemsTable').on('click','#delete', function (e) {
  var id_mutasi   = $(this).data('id_mutasi');
  var name        = $(this).data('name');

  BootstrapDialog.show({
      title: 'Approve Mutasi ',
      type : BootstrapDialog.TYPE_DANGER,
      message: 'Apakah Anda ingin Update Mutasi '+name+' ?',
      closable: false,
      buttons: [
        {
          label: '<i class="fa fa-reply"></i> Batal', cssClass: 'btn',
          action: function(dia){
            dia.close();
          }
        },
        {
          label: '<i class="fa fa-check-circle-o"></i> Approve', cssClass: 'btn-warning', id: 'update_sales', //hotkey: 'alt'+'s',
          // icon: 'glyphicon glyphicon-check',
          action: function(dia){
            dia.close();
            $.ajax({
                data: {
                    id_mutasi       : id_mutasi,
                    approve_mutasi  : 1
                },
                type : "POST",
                url: baseUrl+'transaksi/mutasi_keluar/approve',
                success : function(resp){

                  if(resp.status == 'ERROR INSERT' || resp.status == false) {
                    alert('Data Tidak berhasil di Hapus');
                    return false;

                  } else {
                    $.notify({
                          icon: "glyphicon glyphicon-save",
                          message: 'Data berhasil di Approve'
                        },{
                          type: 'success',
                          onClosed: function(){ location.reload();}
                        });

                    setTimeout(function () {
                      window.location.href = baseUrl+'transaksi/mutasi_keluar'; //will redirect to google.
                    }, 2000);
                  }
                }
            });

          }
        },
        // {
        //   label: '<i class="fa fa-close"></i> Void', cssClass: 'btn-danger', id: 'update_sales', //hotkey: 'alt'+'s',
        //   // icon: 'glyphicon glyphicon-check',
        //   action: function(dia){
        //     dia.close();
        //     $.ajax({
        //         data: {
        //             id_mutasi       : id_mutasi,
        //             approve_mutasi  : 2
        //         },
        //         type : "POST",
        //         url: baseUrl+'transaksi/mutasi_keluar/approve',
        //         success : function(resp){

        //           if(resp.status == 'ERROR INSERT' || resp.status == false) {
        //             alert('Data Tidak berhasil di Hapus');
        //             return false;

        //           } else {
        //             $.notify({
        //                   icon: "glyphicon glyphicon-save",
        //                   message: 'Data berhasil di Void'
        //                 },{
        //                   type: 'success',
        //                   onClosed: function(){ location.reload();}
        //                 });

        //             setTimeout(function () {
        //               window.location.href = baseUrl+'transaksi/mutasi_keluar'; //will redirect to google.
        //             }, 2000);
        //           }
        //         }
        //     });

        //   }
        // }
      ],
    });
  });
})
</script>