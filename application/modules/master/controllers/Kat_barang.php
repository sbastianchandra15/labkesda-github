<?php
/**
  * Ringkasan dari Controller Kategori Barang
  *
  * COntroller untuk mengelola master Kategori Barang
  * @author Firmansyah
  * @version 1.0
  * @package Controller Kategori Barang
  *
  * @param int $id integer
  *
  * @return void
  */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
  * Ringkasan dari Controller Kategori Barang
  *
  * COntroller untuk mengelola master Kategori Barang
  * @author Firmansyah
  * @version 1.0
  * @package Controller Kategori Barang
  *
  * @param int $id integer
  *
  * @return void
  */
class Kat_barang extends MY_Controller {

	/**
	* fungsi untuk konstruksi
	*/
	function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Master', 'active_submenu' => 'kat_barang', 'active_submenu2' => '')); 
        $this->load->model('master/katbarang_model');
    }

	/**
	fungsi untuk menampilkan data kategori barang di menu master kategori barang
	*/
	function index(){
        $data['data_kat_barang']     = $this->katbarang_model->get_all();
        $this->template->load('body', 'master/kat_barang/kat_barang_view',$data);
	}

	/**
	fungsi untuk menampilkan form pengisian master kategori barang
	*/
    function form(){
        $this->template->load('body', 'master/kat_barang/kat_barang_form');
    }


	/**
	fungsi untuk aksi input kategori barang
	*/
    function form_act(){
        $save   = $this->katbarang_model->act_form();
        jsout(array('success' => true, 'status' => $save ));
    }

	/**
	fungsi untuk menampilkan form edit kategori barang
	* @param int @id integer
	*/
    function edit($id){
        $data['detail']       = $this->katbarang_model->detail_katkategori($id);  
        $this->template->load('body', 'master/kat_barang/kat_barang_edit',$data);
    }

	/**
	fungsi untuk proses edit kategori
	*/
    function edit_act(){
        $update   = $this->katbarang_model->act_edit();
        jsout(array('success' => true, 'status' => $update ));
    }

	/**
	fungsi untuk proses delete kategori
	*/
    function delete(){
        $delete = $this->katbarang_model->act_delete();
        jsout(array('success' => true, 'status' => $delete ));
    }

    

}
?>