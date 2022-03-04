<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran_maknum extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Transaksi', 'active_submenu' => 'pendaftaran', 'active_submenu2' => 'pendaftaran_maknum'));
        $this->load->model('transaksi/pendaftaran_model');
    }


    function index(){  
        $data['data_pendaftaran']  = $this->pendaftaran_model->get_all_maknum();
        $this->template->load('body', 'transaksi/pendaftaran/pendaftaran_maknum_view',$data);
    }

    function form(){
        $this->session->unset_userdata('new_maknum');

        $this->load->model('master/sampel_model');
        $this->load->model('master/parameter_model');

        $new_maknum = $this->session->userdata('new_maknum');

        if(!$new_maknum){
            $new_maknum = array(
                'items' => array()
            );
        }

        $data['data_sampel']        = $this->sampel_model->get_all();
        $data['data_parameter']     = $this->parameter_model->get_detail_by_lab('LM');
        $data['data_lab']           = 'LM';
        $data['new_maknum']         = $new_maknum;
        $this->template->load('body', 'transaksi/pendaftaran/pendaftaran_maknum_form', $data);
    }

    function add_item(){
        if(!isset($_POST['kd_parameter'])) return;
        
        $new_maknum = $this->session->userdata('new_maknum');

        $items = $new_maknum['items'];
        $exist = false;
        if($items!=''){
        foreach($items as $key=>$val){
                if($val['kd_parameter'] == $this->input->post('kd_parameter')){
                    $new_maknum['items'][$key] = array(
                        'kd_parameter'      => $this->input->post('kd_parameter'),
                        'nm_parameter'      => $this->input->post('nm_parameter')
                    );
                    $exist = true;
                    break;
                }
            }
        }

        if(!$exist){
            $new_maknum['items'][] = array(
                    'kd_parameter'      => $this->input->post('kd_parameter'),
                    'nm_parameter'      => $this->input->post('nm_parameter')
            );
        }
        // test($new_maknum,0);
        $this->session->set_userdata('new_maknum', $new_maknum);        
    }

    function remove_item(){
        if(!isset($_GET['index_id'])) return;
        $index_id = $this->input->get('index_id');
        $new_maknum = $this->session->userdata('new_maknum');

        $items = $new_maknum['items'];
        foreach($items as $key=>$val){
            if($val['kd_parameter'] == $index_id){
                unset($new_maknum['items'][$key]);
                $new_maknum['items'] = array_values($new_maknum['items']);
                break;
            }
        }

        $this->session->set_userdata('new_maknum', $new_maknum);
        jsout(array('success'=>1)); 
    }

    function form_act(){
        $save   = $this->pendaftaran_model->act_form_maknum();

        $this->session->unset_userdata('new_maknum');
        jsout(array('success' => true, 'status' => $save ));
    }

    function edit($id){
        $nomor = str_replace("-", "/", $id);
        // test($nomor,1);
        $this->session->unset_userdata('new_maknum');

        $this->load->model('master/sampel_model');
        $this->load->model('master/parameter_model');

        $new_maknum = $this->session->userdata('new_maknum');
        $detail             = $this->pendaftaran_model->detail_parameter_pendaftaran($nomor)->result();
        $tdetail            = $this->pendaftaran_model->detail_parameter_pendaftaran($nomor)->num_rows();
        $no                 = 0;

        if($tdetail!=0){
            foreach($detail as $key=>$val){
                $new_maknum['items'][$key] = array(
                    'kd_parameter'      => $val->kd_par,
                    'nm_parameter'      => $val->nm_parameter
                );
            }

        }else{
            $new_maknum['items'] = array();
        }

        $this->session->set_userdata('new_maknum', $new_maknum);
        $data['header']             = $this->pendaftaran_model->header_pendaftaran($nomor);
        $data['data_sampel']        = $this->sampel_model->get_all();
        $data['data_parameter']     = $this->parameter_model->get_detail_by_lab('LM');
        $data['data_lab']           = 'LM';
        $data['new_maknum']         = $new_maknum;
        $this->template->load('body', 'transaksi/pendaftaran/pendaftaran_maknum_edit', $data);
    }

    function edit_act(){
        $update     = $this->pendaftaran_model->act_edit_maknum();

        $this->session->unset_userdata('new_maknum');
        jsout(array('success' => true, 'status' => $update ));
    }

    // function approve(){
    //     $id_mutasi          = $this->input->post('id_mutasi');
    //     $approve_mutasi     = $this->input->post('approve_mutasi');
    //     // test($id_mutasi.' '.$approve_mutasi,1);
    //     if($approve_mutasi==1){
    //         $this->mutasi_model->update_status($id_mutasi,$approve_mutasi);
    //         $this->mutasi_model->stok_keluar($id_mutasi);

    //     }elseif($approve_mutasi==2){
    //         $this->mutasi_model->update_status($id_mutasi,$approve_mutasi);
    //     }
    // }

    function delete(){
        $delete = $this->pendaftaran_model->act_delete();
        jsout(array('success' => true, 'status' => $delete ));
    }

    function reset(){
        $this->session->unset_userdata('new_maknum');
        redirect('transaksi/pendaftaran_maknum');
    }

    function detail_items_mutasi(){
        $sup_id     = $this->input->post('id');
        $result     = $this->mutasi_model->detail_items_mutasi($sup_id);
        echo json_encode($result);
    }

    function view_popup($id){
        $data['detail']             = $this->mutasi_model->mutasi_detail($id)->result();
        $data['tdetail']            = $this->mutasi_model->mutasi_detail($id)->num_rows();
        $data['header']             = $this->mutasi_model->mutasi_header($id)->row();
        
        $this->load->view('transaksi/mutasi/mutasi_detail_popup',$data);
    }

    function cetak($id){
        $id                     = str_replace(str_split('-'), '/', $id);
        $data['header']         = $this->pendaftaran_model->header_pendaftaran($id);
        $data['detail']         = $this->pendaftaran_model->detail_pendaftaran($id);
        $data['detail_kdpar']   = $this->pendaftaran_model->detail_pendaftaran_par($id);
        $this->template->load('body','transaksi/pendaftaran/pendaftaran_maknum_print',$data);
    }

}
?>