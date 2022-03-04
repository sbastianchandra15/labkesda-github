<section class="content-header">
  <h1>
    Master
    <small>Edit Barang</small>
  </h1>
</section>
<?php 
// test($detail,1);
?>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border"></div>
        <form class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Nama </label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="nama" placeholder="Nama Barang" value="<?php echo $detail->nama; ?>">
                <input type="hidden" class="form-control" id="id_barang" placeholder="Nama Barang" value="<?php echo $detail->id_barang; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Kategori Barang</label>
              <div class="col-sm-5">
                <select class="form-control select2" style="width: 100%;" id='id_kat_barang'>
                  <option disabled="" selected="">- Pilih -</option>
                  <?php 
                  foreach ($data_katbarang as $key => $value) {
                    if($value->id_kat_barang==$detail->id_kat_barang){
                      echo "<option value='".$value->id_kat_barang."' selected>".$value->kategori."</option>";
                    }else{
                      echo "<option value='".$value->id_kat_barang."'>".$value->kategori."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Satuan</label>
              <div class="col-sm-5">
                <select class="form-control select2" style="width: 100%;" id='id_satuan'>
                  <option disabled="" selected="">- Pilih -</option>
                  <?php 
                  foreach ($data_satuan as $key => $value) {
                    if($value->id_satuan==$detail->id_satuan){
                    echo "<option value='".$value->id_satuan."' selected>".$value->satuan."</option>";
                    }else{
                    echo "<option value='".$value->id_satuan."'>".$value->satuan."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-info" id="save">Simpan</button>
            <a href="<?php echo base_url('master/barang'); ?>" type="submit" class="btn btn-danger">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script>
$(document).ready(function(){
  $('#id_kat_barang').select2();
  $('#id_satuan').select2();

  $('#save').click(
  function(e){
    e.preventDefault();

    if(!$('#nama').val()){
      $.notify({
        title: "Erorr : ",
        message: "Nama Tidak Boleh Kosong",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $("#nama").focus();
      return false;
    }

    if(!$('#id_kat_barang').val()){
      $.notify({
        title: "Erorr : ",
        message: "Kategori Barang Tidak Boleh Kosong",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#id_kat_barang').select2('open');
      return false;
    }

    if(!$('#id_satuan').val()){
      $.notify({
        title: "Erorr : ",
        message: "Satuan Tidak Boleh Kosong",
        icon: 'fa fa-times' 
      },{
        type: "danger",
        delay: 1000
      });
      $('#id_satuan').select2('open');
      return false;
    }

    $.ajax({
      url: baseUrl+'master/barang/edit_act',
      type : "POST",  
      data: {
        nama          : $('#nama').val(),
        id_kat_barang : $('#id_kat_barang').val(),
        id_satuan     : $('#id_satuan').val(),
        id_barang     : $('#id_barang').val()

      },
      success : function(resp){
        if(resp.status == 'ERROR INSERT' || resp.status == false) {
          $.notify({
            message: 'Data Gagal disimpan'
          },{
            type: 'danger'
          });
          return false;

        } else {
          $.notify({
            message: 'Data Berhasil Disimpan'
          },{
            type: 'info'
          });

          setTimeout(function () {
            window.location.href = baseUrl+'master/barang/'; //will redirect to google.
          }, 2000);
        }
      }
    });

  }
);
})
</script>

            