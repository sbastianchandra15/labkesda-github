<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil_lingkungan extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Transaksi', 'active_submenu' => 'hasil', 'active_submenu2' => 'hasil_lingkungan'));
        $this->load->model('transaksi/hasil_model');
    }

    function index(){  
        $data['data_pendaftaran']  = $this->hasil_model->get_all_lingkungan();
        $this->template->load('body', 'transaksi/hasil/hasil_lingkungan_view',$data);
    }

    function update($id){
        $id                     = str_replace(str_split('-'), '/', $id);
        $data['header']         = $this->hasil_model->header_hasil($id);
        $data['detail']         = $this->hasil_model->detail_hasil($id);
        $data['detail_kdpar']   = $this->hasil_model->detail_hasil_par($id);

        $this->load->model('master/sampel_model');
        $this->load->model('master/parameter_model');

        $data['data_sampel']        = $this->sampel_model->get_all();
        $data['data_parameter']     = $this->parameter_model->get_detail_by_lab('LL');
        $data['data_lab']           = 'LL';
        $this->template->load('body', 'transaksi/hasil/hasil_lingkungan_form', $data);
    }

    function update_act(){
        $update = $this->hasil_model->update_lingkungan_act();
        $this->session->set_flashdata('alert','Data Berhasil Disimpan');
        redirect('transaksi/hasil_lingkungan/');
    }    

    function view_popup($id){
        $data['detail']             = $this->mutasi_model->mutasi_detail($id)->result();
        $data['tdetail']            = $this->mutasi_model->mutasi_detail($id)->num_rows();
        $data['header']             = $this->mutasi_model->mutasi_header($id)->row();
        
        $this->load->view('transaksi/mutasi/mutasi_detail_popup',$data);
    }

    function cetak($id){
        $id                     = str_replace(str_split('-'), '/', $id);
        $data['header']         = $this->hasil_model->header_hasil($id);
        $data['detail']         = $this->hasil_model->detail_hasil($id);
        $data['detail_kdpar']   = $this->hasil_model->detail_hasil_par($id);
        $this->template->load('body','transaksi/hasil/hasil_lingkungan_print',$data);
    }

}
?>