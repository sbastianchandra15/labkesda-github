<?php 
$res_par = array();
foreach ($detail as $key => $val1) {
  $res_par[$val1->kd_par][]=$val1;
}
foreach ($res_par as $key => $value) {
  // test($value,0);
}
?>
<style>
  @media print{
    @page {
      size: portrait;

      }
    }
  table{
    border-collapse: collapse;
    font-family: arial;
  }
  .borderluar {
    border: 2px solid black;
    padding: 0px;
  }
  .borderdalem {
    border: 1px solid #000000b0;
    padding: 0px;
  }
  .borderdalemcenter {
    border: 1px solid #000000b0;
    padding: 0px;
    text-align: center;
  }
  .borderdalemangka {
    border: 1px solid #000000b0;
    padding: 0px 5px;
    text-align: right;
  }
  .borderdalemangka_detail {
    padding: 0px 5px;
  }
  .bordertengah {
    border: 1px solid #000000b0;
    padding: 5px 5px 5px 5px; 
  }
  p.two {
    border-style: solid;
    border-width: 1px;
  }
  .header{
    padding: 0px 30px; 
    text-align: center;
  }
  .header_alamat {
    border: 2px solid black;
    padding: 0px 30px; 
    text-align: center;
  }
  .table_detail {
    border-collapse: collapse;
    border: 1px solid black;
  }
  hr {
    border-bottom: 2px solid black;
    box-shadow: 0px 5px 0 black;
  }
</style>

<section class="content-header">
  <h1>
    Transaksi
    <small>Print Pendaftaran Lingkungan</small>
  </h1>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">
          <table style="width:100%;font-family: initial;">
            <tr>
              <td colspan="4">
                <table style='width:100%;font-family: initial;'> 
                  <tr>
                    <td align="left" colspan="2" width='20%' valign="bottom">
                      oke
                    </td>
                    <td colspan="2" width='80%' align="center">
                      <strong style="font-size: 20px;">
                        PEMERINTAH KOTA TANGERANG<br/>
                        DINAS KESEHATAN<br/>
                        UPT LABORATORIUM KESEHATAN DAERAH<br/>
                      </strong>
                      <strong>
                        JL. TMP Taruna Suka Asih Telp/Fax : 021 - 5588737 Kota Tangerang 15111<br/>
                        Email : labkeskota.tangerang@gmail.com
                      </strong>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4" align="center"><hr/></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="4" align="center"><strong style="font-size: 23px;">Invoice Pengujian Sampel Klinik</strong></td>
            </tr>
            <tr>
              <td colspan="4" align="center" height="10"></td>
            </tr>
            <tr>
              <td width="15%">No. Lab</td>
              <td width="25%">: <?php echo $header->no_pendaftaran; ?></td>
              <td width="35%">Jenis Analisa</td>
              <td width="25%">: <?php echo $header->jns_analisa; ?></td>
            </tr>
            <tr>
              <td>Pemilik</td>
              <td>: <?php echo $header->nama; ?></td>
              <td>Keterangan Sampel</td>
              <td>: <?php echo $header->ket_sampel; ?></td>
            </tr>
            <tr>
              <td>Alamat</td>
              <td>: <?php echo $header->alamat; ?></td>
              <td>Tgl. Diterima</td>
              <td>: <?php echo $header->tgl_diterima; ?></td>
            </tr>
            <tr>
              <td>Telepon</td>
              <td>: <?php echo $header->telp; ?></td>
              <td>Tgl. Selesai</td>
              <td>: <?php echo $header->tgl_selesai; ?></td>
            </tr>
            <tr>
              <td>Jenis Sampel</td>
              <td>: <?php echo $header->kd_sampel; ?></td>
              <td>Kondisi</td>
              <td>: <?php echo $header->kondisi; ?></td>
            </tr>
            <tr>
              <td>Umur</td>
              <td>: <?php echo $header->umur; ?></td>
              <td>Dokter</td>
              <td>: <?php echo $header->dokter; ?></td>
            </tr>
            <tr>
              <td>Diagnosa</td>
              <td>: <?php echo $header->diagnosa_klinik; ?></td>
              <td>Kelamin</td>
              <td>: <?php echo $header->jns_kelamin; ?></td>
            </tr>
            <tr>
              <td colspan="4" align="center" height="10"></td>
            </tr>
            <tr>
              <td colspan="4">
                <table style="width:100%;font-family: initial;border: 1px solid black;font-size: 10px">
                  <tr style="border: 1px solid black;">
                    <td>Parameter</td>
                    <td>Jenis Pemeriksaan</td>
                    <td>Keterangan</td>
                    <td width="10%">Harga</td>
                  </tr>
                  <?php 
                  $total    = 0; 
                  foreach ($detail_kdpar as $key => $value) {
                  $nm_parameter     = $value->nm_parameter;
                  ?>
                  <tr style="border: 1px solid black">
                    <td colspan="4">--&nbsp;&nbsp;<?php echo $nm_parameter; ?></td>
                  </tr>
                    <?php
                    foreach ($res_par[$value->kd_par] as $key => $value) {
                    $total    = $total+$value->harga;
                    ?>
                    <tr>
                      <td>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $value->nm_metode; ?></td>
                      <td><?php echo $value->metode_analisa; ?></td>
                      <td><?php echo $value->ket; ?></td>
                      <td align="right"><?php echo money($value->harga); ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                  <?php 
                  }
                  ?>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="3" align="right">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
              <td align="right"><?php echo money($total); ?></td>
            </tr>
            <tr>
              <td colspan="2" style="font-size: 10px">
                Username Anda :<br/> 
                Password Anda :<br/>
                Untuk melihat Status Uji Lab Anda, Silahkan Akses Ke www.labkesda.tangerangkota.go.id<br/><br/>
                Password ini hanya diberikan kepada pelanggan yang menajukan pengujian.
              </td>
              <td valign="bottom" align="center">Pemohon</td>
              <td valign="bottom" >Tanggerang, 27/07/2019<br/>Bagian Penerima Sampel</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td align="center"><br/><br/><br/><br/><br/>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
              <td ><br/><br/><br/><br/><br/>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
</head>
<!-- <script>window.print(); setTimeout(function(){window.close();},500);</script> -->