<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=namafile.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
?>
          <?php 
          foreach ($data_mutasi as $key => $value1) {
          ?>
            <table width="100%" class="table table-bordered table-striped" border="1">
              <tr>
                <td width="10%">Kode Barang</td>
                <td><?= $value1->barcode; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td> 
              </tr>
              <tr>
                <td>Nama Barang</td>
                <td><?= $value1->nama; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td>Lot Number</td>
                <td><?= $value1->lot_no; ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </table>
            <table class="table table-bordered table-striped" border="1">
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
              WHERE a.id_barang=b.id_barang AND a.id_barang = '".$value1->id_barang."' AND a.id_lokasi = '".$id_lokasi."' AND a.lot_no = '".$value1->lot_no."'AND
              MONTH(a.tgl_transaksi)='".$month."' AND YEAR(a.tgl_transaksi)='".$year."'
              ORDER BY a.lot_no DESC,a.id_barang,a.id_stok";
              // test($query,0);
              $history  = $this->db->query($query)->result();

              foreach ($history as $key => $value) {
                $bulan          = substr($value->tgl_kadaluwarsa,5,2);
                $hari           = substr($value->tgl_kadaluwarsa,8,2);
                $tahun          = substr($value->tgl_kadaluwarsa,0,4);
                $tanggal        = $bulan.'/'.$hari.'/'.$tahun;
                if($tanggal=='//'){ $tanggal='';}
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