<section class="content-header">
  <h1>
    Master
    <small>Edit Metode</small>
  </h1>
</section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border"></div>
        <form class="form-horizontal">
          <div class="box-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Nama Metode</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="nama" placeholder="Nama Metode" value="<?php echo $header->nm_metode; ?>">
                <input type="hidden" name="items" id="sup_items" value='<?php echo json_encode($new_metode["items"]); ?>'/>
                <input type="hidden" id="kd_metode" value="<?php echo $header->kd_metode; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Satuan</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="satuan" placeholder="Satuan" value="<?php echo $header->satuan; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Kadar</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="kadar" placeholder="Kadar" value="<?php echo $header->kadar; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Metode Analisa</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="metode_analisa" placeholder="Motode Analisa" value="<?php echo $header->metode_analisa; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Alias</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="alias" placeholder="Alias" value="<?php echo $header->alias; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Akreditas</label>
              <div class="col-sm-5">
                <label><input type="radio" name="akreditas" id="akreditas" value="Y" <?php echo ($header->akreditasi=='Y')? 'checked' : '' ?>> Ya</label>
                <label><input type="radio" name="akreditas" id="akreditas" value="N" <?php echo ($header->akreditasi=='N')? 'checked' : '' ?>> Tidak</label>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Harga</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="harga" placeholder="Harga" value="<?php echo $header->harga; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Jumlah Pengecekan</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="jumlah" placeholder="Jumlah Pengecekan" value="<?php echo $header->jml_pengecekan; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Zorder</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="zoder" placeholder="Zoder" value="<?php echo $header->zorder; ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Parameter</label>
              <div class="col-sm-5">
                  <select class="form-control select2" style="width: 100%;" id='kd_parameter'>
                  <option disabled="" selected="">- Pilih -</option>
                  <?php 
                  foreach ($data_parameter as $key => $value) {
                    if($value->kd_parameter==$header->kd_parameter){
                      echo "<option value='".$value->kd_parameter."' selected>".$value->nm_parameter."</option>";
                    }else{
                      echo "<option value='".$value->kd_parameter."'>".$value->nm_parameter."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Laboratorium</label>
              <div class="col-sm-5">
                <select class="form-control select2" style="width: 100%;" id='kd_lab'>
                  <option disabled="" selected="">- Pilih -</option>
                  <?php 
                  foreach ($data_lab as $key => $value) {
                    if($value->kd_lab==$header->kd_lab){
                      echo "<option value='".$value->kd_lab."' selected>".$value->lab."</option>";
                    }else{
                      echo "<option value='".$value->kd_lab."'>".$value->lab."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
            </div>
            <hr>  
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Detail Metode</label>
              <div class="col-sm-5">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Hasil Lab</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="hasil_lab" placeholder="Hasil Lab">
                <input type="hidden" id="no_urut" value="<?php echo $no_urut; ?>">
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="detail" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Hasil Lab</th>
                    <th width="10%">Action</th>
                  </tr>
                  </thead>
                </table>
              </div>
            </div>          

            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label"></label>
              <div class="col-sm-5">
                <button type="submit" class="btn btn-warning" id="add-items">Tambah Detail</button>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-info" id="save">Simpan</button>
            <a href="<?php echo base_url('master/metode/reset'); ?>" type="submit" class="btn btn-danger">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- <?php test($new_metode,0); ?> -->
<script>
$(document).ready(function(){
  $('#kd_lab').select2();
  $('#kd_parameter').select2();

  metode = {
    data: {},
    processed: false,
    items: [],
    init: function(){
      this.grids = $('#detail').DataTable({
        "paging": false, 
        "bLengthChange": false, // disable show entries dan page
        "bFilter": false,
        "bInfo": false, // disable Showing 0 to 0 of 0 entries
        "bAutoWidth": false,
        "language": {
            "emptyTable": "Tidak Ada Data"
        },
        columns: [
          { 
            bVisible  : false,
            data      : 'no_hasil' 
          },
          { data: 'hasil_lab', className: "text-left" }, 
          { data: 'act', className: "text-center" }
        ],
      });

      this._set_items($('#sup_items').val());
      $('#add-items').click(metode.add_items);
      $('#save').click(metode.save);

    },

    _set_items: function(items){
      this.no_ajax = true;
      //
      if(items) items = JSON.parse(items);
      // debugger
      this.items = items;
      items.map(function(i,e){
        var data = {
          no_hasil   : i.no_hasil,
          hasil_lab  : i.hasil_lab
        };
        metode._addtogrid(data);
        metode._focusadd();
      });
      this.no_ajax = false;

    },
    
    add_items: function(e){
      e.preventDefault();

      if(!$('#hasil_lab').val()){
        $.notify({
          title: "Erorr : ",
          message: "Hasil Lab Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#hasil_lab").focus();
        return false;
      }

      let hasil_lab = $('#hasil_lab').val();
      let no_hasil  = parseInt($('#no_urut').val())+1;

      if(hasil_lab){
        data = {
          hasil_lab     : hasil_lab,
          no_hasil      : no_hasil
        };

        metode._addtogrid(data);
        metode._clearitem(no_hasil);
        metode._focusadd();

      }
    },

    _addtogrid: function(data){
      // debugger
      let grids = this.grids;
      let exist = metode.grids.row('#'+data.no_hasil).index();
      //
      $('#id').val(data.no_hasil);

      data.act = '<button item-id="'+data.no_hasil+'" onclick="return metode._removefromgrid(this);">x</button>';
      data.DT_RowId = data.no_hasil;
      //
      if(exist===undefined){
        grids.row.add(data).draw();
      }else{ 
        grids.row(exist).data(data).draw(false);
      }

      if(this.no_ajax) return false;

      $.post({
        url: baseUrl+'master/metode/add_item',
        data: {
          hasil_lab     : data.hasil_lab,
          no_hasil      : data.no_hasil
        }
      });
    },

    _clearitem: function(no_hasil){
      // debugger
      $('#hasil_lab').val('');
      $('#no_urut').val(no_hasil);

    },

    _focusadd: function(){
      $('#hasil_lab').focus();
    },

    _removefromgrid: function(el){

      let id = $(el).attr('item-id');
      metode.grids.row("#"+id).remove().draw();
      $.get({
        url: baseUrl+'master/metode/remove_item',
        data: {
          index_id: id
        }
      });
      return false;
    },

    save: function(e){
      e.preventDefault();

      if(!$('#nama').val()){
        $.notify({
          title: "Erorr : ",
          message: "Nama Metode Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#nama").focus();
        return false;
      }

      if(!$('#satuan').val()){
        $.notify({
          title: "Erorr : ",
          message: "Satuan Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#satuan").focus();
        return false;
      }

      if(!$('#kadar').val()){
        $.notify({
          title: "Erorr : ",
          message: "KadarTidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#kadar").focus();
        return false;
      }

      if(!$('#metode_analisa').val()){
        $.notify({
          title: "Erorr : ",
          message: "metode_analisa Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#metode_analisa").focus();
        return false;
      }

      if(!$('#alias').val()){
        $.notify({
          title: "Erorr : ",
          message: "Alias Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#alias").focus();
        return false;
      }

      if(!$('#akreditas').val()){
        $.notify({
          title: "Erorr : ",
          message: "Akreditas Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#akreditas").focus();
        return false;
      }

      if(!$('#harga').val()){
        $.notify({
          title: "Erorr : ",
          message: "Harga Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#harga").focus();
        return false;
      }

      if(!$('#jumlah').val()){
        $.notify({
          title: "Erorr : ",
          message: "Jumlah Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#jumlah").focus();
        return false;
      }

      if(!$('#zoder').val()){
        $.notify({
          title: "Erorr : ",
          message: "Zoder Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $("#zoder").focus();
        return false;
      }

      if(!$('#kd_parameter').val()){
        $.notify({
          title: "Erorr : ",
          message: "Parameter Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $('#kd_parameter').select2('open');
        return false;
      }

      if(!$('#kd_lab').val()){
        $.notify({
          title: "Erorr : ",
          message: "Laboratorium Tidak Boleh Kosong",
          icon: 'fa fa-times' 
        },{
          type: "danger",
          delay: 1000
        });
        $('#kd_lab').select2('open');
        return false;
      }
      $('#save').prop("disabled",true);
      $.ajax({
        url: baseUrl+'master/metode/edit_act',
        type : "POST",  
        data: {
          kd_metode       : $('#kd_metode').val(),
          nama            : $('#nama').val(),
          satuan          : $('#satuan').val(),
          kadar           : $('#kadar').val(),
          metode_analisa  : $('#metode_analisa').val(),
          alias           : $('#alias').val(),
          akreditas       : $('#akreditas:checked').val(),
          harga           : $('#harga').val(),
          jumlah          : $('#jumlah').val(),
          zoder           : $('#zoder').val(),
          kd_parameter    : $('#kd_parameter').val(),
          kd_lab          : $('#kd_lab').val()
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
              window.location.href = baseUrl+'master/metode/'; //will redirect to google.
            }, 2000);
          }
        }
      });

    }

  };
  metode.init();
});
</script>