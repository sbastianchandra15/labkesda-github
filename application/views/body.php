<?php
// test($this->current_user,1);
if($this->current_user['loginuser']==1){
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LABKESDA</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/_all-skins.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/morris.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-jvectormap.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-dialog.min.css" type="text/css" />

  <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url() ?>assets/js/jquery-ui.min.js"></script>
  <script>
      var baseUrl = '<?php echo base_url(); ?>';
    </script>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>LAB</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Labkesda</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><?php echo $this->current_user['nama']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url('logout') ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li><a href="<?php echo base_url('welcome'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='Master')? 'active menu-open' : ''; ?>">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='kat_barang')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/kat_barang'); ?>"><i class="fa fa-circle-o"></i> Kategori Barang</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='barang')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/barang'); ?>"><i class="fa fa-circle-o"></i> Barang</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='parameter')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/parameter'); ?>"><i class="fa fa-circle-o"></i> Parameter</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='sampel')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/sampel'); ?>"><i class="fa fa-circle-o"></i> Sampel</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='laboratorium')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/laboratorium'); ?>"><i class="fa fa-circle-o"></i> Laboratorium</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='metode')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/metode'); ?>"><i class="fa fa-circle-o"></i> Metode</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='dokter')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/dokter'); ?>"><i class="fa fa-circle-o"></i> Dokter</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='manajemen')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/manajemen'); ?>"><i class="fa fa-circle-o"></i> Manajemen</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='lokasi')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/lokasi'); ?>"><i class="fa fa-circle-o"></i> Lokasi</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='lokasi_sub')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/lokasi_sub'); ?>"><i class="fa fa-circle-o"></i> Sub Lokasi</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='lokasi_assets')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/lokasi_assets'); ?>"><i class="fa fa-circle-o"></i> Lokasi Aset</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='aset')? 'class="active"' : ''; ?>><a href="<?php echo base_url('master/aset'); ?>"><i class="fa fa-circle-o"></i> Aset</a></li>
          </ul>
        </li>
        <li class="treeview <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='Transaksi')? 'active menu-open' : ''; ?>">
          <a href="#">
            <i class="fa fa-share"></i> <span>Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li> -->
            <li class="treeview <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='mutasi')? 'active' : ''; ?>">
              <a href="#"><i class="fa fa-exchange"></i> Mutasi <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu">
                <li <?php echo (!isset($this->session->userdata('ses_menu')['active_submenu2'])=='mutasi_masuk')? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi/mutasi_masuk'); ?>"><i class="fa fa-circle-o"></i> Mutasi Masuk</a></li>
                <li <?php echo (!isset($this->session->userdata('ses_menu')['active_submenu2'])=='mutasi_keluar')? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi/mutasi_keluar'); ?>"><i class="fa fa-circle-o"></i> Mutasi Keluar</a></li>
              </ul>
            </li>
            <li class="treeview <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='pendaftaran')? 'active' : ''; ?>">
              <a href="#"><i class="fa fa-laptop"></i> Pendaftaran <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu">
                <li <?php echo (!isset($this->session->userdata('ses_menu')['active_submenu2'])=='pendaftaran_klinik')? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi/pendaftaran_klinik'); ?>"><i class="fa fa-circle-o"></i> Klinik</a></li>
                <li <?php echo (!isset($this->session->userdata('ses_menu')['active_submenu2'])=='pendaftaran_lingkungan')? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi/pendaftaran_lingkungan'); ?>"><i class="fa fa-circle-o"></i> Lingkungan</a></li>
                <li <?php echo (!isset($this->session->userdata('ses_menu')['active_submenu2'])=='pendaftaran_maknum')? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi/pendaftaran_maknum'); ?>"><i class="fa fa-circle-o"></i> Makanan & Minuman</a></li>
              </ul>
            </li>
            <li class="treeview <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='hasil')? 'active' : ''; ?>">
              <a href="#"><i class="fa fa-edit"></i> Hasil Pemeriksaan <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu">
                <li <?php echo (!isset($this->session->userdata('ses_menu')['active_submenu2'])=='hasil_klinik')? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi/hasil_klinik'); ?>"><i class="fa fa-circle-o"></i> Klinik</a></li>
                <li <?php echo (!isset($this->session->userdata('ses_menu')['active_submenu2'])=='hasil_lingkungan')? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi/hasil_lingkungan'); ?>"><i class="fa fa-circle-o"></i> Lingkungan</a></li>
                <li <?php echo (!isset($this->session->userdata('ses_menu')['active_submenu2'])=='hasil_maknum')? 'class="active"' : ''; ?>><a href="<?php echo base_url('transaksi/hasil_maknum'); ?>"><i class="fa fa-circle-o"></i> Makanan & Minuman</a></li>
              </ul>
            </li>
            <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li> -->
          </ul>
        </li>
        <li class="treeview <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='Report')? 'active menu-open' : ''; ?>">
          <a href="#">
            <i class="fa fa-archive"></i> <span>Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='stok')? 'class="active"' : ''; ?>><a href="<?php echo base_url('report/stok'); ?>"><i class="fa fa-circle-o"></i> Stok</a></li>
            <li <?php echo (!isset($this->session->userdata('ses_menu')['active_menu'])=='history_stok')? 'class="active"' : ''; ?>><a href="<?php echo base_url('report/stok/history_stok'); ?>"><i class="fa fa-circle-o"></i> History Stok</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

      <?php echo $contents; ?>

  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/raphael.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/morris.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.knob.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url() ?>assets/js/adminlte.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/dashboard.js"></script>
<script src="<?php echo base_url() ?>assets/js/demo.js"></script>
<script src="<?php echo base_url() ?>assets/js/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-notify.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-dialog.js"></script>
</body>
</html>

<?php 
}else{
$this->session->set_flashdata('msg','<div class="alert alert-danger text-center"><font size="2">Harap Login Kembali.</font></div>');
redirect('login');
}
?>