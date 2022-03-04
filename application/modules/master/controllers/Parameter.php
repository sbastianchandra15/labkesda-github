<?php
/**
  * Ringkasan dari Controller Parameter
  *
  * COntroller untuk mengelola Parameter
  * @author Firmansyah
  * @version 1.0
  * @package Controller Parameter
  *
  * @param int $id integer
  *
  * @return void
  */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
  * Ringkasan dari Controller Parameter
  *
  * COntroller untuk mengelola Parameter
  * @author Firmansyah
  * @version 1.0
  * @package Controller Parameter
  *
  * @param int $id integer
  *
  * @return void
  */
class Parameter extends MY_Controller {
	/**
	fungsi untuk konstruksi
	*/
	function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Master', 'active_submenu' => 'parameter', 'active_submenu2' => '')); 
        $this->load->model('master/parameter_model');
    }

	/**
	fungsi untuk menampilkan data di menu master paramater
	*/
	function index(){
        $data['data_parameter']     = $this->parameter_model->get_all_parameter();
        $this->template->load('body', 'master/parameter/parameter_view',$data);
	}

	/**
	fungsi untuk menampilkan form pengisian master parameter
	*/
    function form(){
        $this->load->model('master/laboratorium_model');
        $data['data_lab']     = $this->laboratorium_model->get_all(); 
        $this->template->load('body', 'master/parameter/parameter_form',$data);
    }

	/**
	fungsi untuk aksi input parameter
	*/
    function form_act(){
        $save   = $this->parameter_model->act_form();
        jsout(array('success' => true, 'status' => $save ));
    }

	/**
	fungsi untuk menampilkan form edit master parameter
	* @param int $id integer
	*/
    function edit($id){
        $this->load->model('master/laboratorium_model');
        $data['data_lab']     = $this->laboratorium_model->get_all(); 
        $data['detail']       = $this->parameter_model->get_detail($id);  
        $this->template->load('body', 'master/parameter/parameter_edit',$data);
    }

	/**
	fungsi untuk aksi edit parameter
	*/
    function edit_act(){
        $update   = $this->parameter_model->act_edit();
        jsout(array('success' => true, 'status' => $update ));
    }

	/**
	fungsi untuk aksi delete parameter
	*/
    function delete(){
        $delete = $this->parameter_model->act_delete();
        jsout(array('success' => true, 'status' => $delete ));
    }

    

}
?>