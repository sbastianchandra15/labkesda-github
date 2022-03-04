<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends MY_Controller {

    function __construct(){
        parent::__construct();
        $this->session->set_userdata('ses_menu', array('active_menu' => 'Report', 'active_submenu' => 'stok', 'active_submenu2' => ''));
        $this->load->model('transaksi/mutasi_model');
        $this->load->model('master/lokasi_model');
    }


    function index(){  
        $data['data_lokasi']    = $this->lokasi_model->get_all();
        $id_lokasi              = '';
        if($this->input->post('id_lokasi')!=''){
            $id_lokasi          = $this->input->post('id_lokasi');
        }
        $data['id_lokasi']      = $id_lokasi;
        $data['data_mutasi']    = $this->mutasi_model->last_stok($id_lokasi);

        $this->template->load('body', 'report/stok',$data);
    }

    function stok_cetak($id){
        $data['data_mutasi']    = $this->mutasi_model->last_stok($id);        
        $this->load->view('report/stok_cetak',$data);
    }

    function history_stok(){  
        $data['data_lokasi']    = $this->lokasi_model->get_all();
        $id_lokasi              = '';
        $data['data_mutasi']    = array('');
        $data['year_now']       = date('Y');
        $data['year_old']       = date('Y')-1;
        $data['data_month']  = array(
                array('id' => '1', 'nama_bulan' => 'January'),
                array('id' => '2', 'nama_bulan' => 'February'),
                array('id' => '3', 'nama_bulan' => 'March'),
                array('id' => '4', 'nama_bulan' => 'April'),
                array('id' => '5', 'nama_bulan' => 'May'),
                array('id' => '6', 'nama_bulan' => 'June'),
                array('id' => '7', 'nama_bulan' => 'July'),
                array('id' => '8', 'nama_bulan' => 'August'),
                array('id' => '9', 'nama_bulan' => 'September'),
                array('id' => '10', 'nama_bulan' => 'October'),
                array('id' => '11', 'nama_bulan' => 'November'),
                array('id' => '12', 'nama_bulan' => 'December'));
        if($this->input->post('id_lokasi')!=''){
            $id_lokasi              = $this->input->post('id_lokasi');
            $data['year1']          = $this->input->post('year');
            $data['month']          = $this->input->post('month');
            $data['data_mutasi']    = $this->mutasi_model->history_stok_barang($id_lokasi,$this->input->post('year'),$this->input->post('month'));
        }
        $data['id_lokasi']      = $id_lokasi;

        $this->template->load('body', 'report/history_stok',$data);
    }

    function history_stok_cetak($id,$year,$month){  

        $data['data_mutasi']    = $this->mutasi_model->history_stok_barang($id,$year,$month);
        $data['id_lokasi']      = $id;
        $data['year']           = $year;
        $data['month']          = $month;

        $this->load->view('report/history_stok_cetak',$data);
    }



























    

    function form(){
        $this->session->unset_userdata('new_mutasi_masuk');

        $this->load->model('master/barang_model');

        $new_mutasi_masuk = $this->session->userdata('new_mutasi_masuk');
        // test($new_mutasi_masuk,1);
        if(!$new_mutasi_masuk){
            $new_mutasi_masuk = array(
                'items' => array()
            );
        }

        $data['data_barang']        = $this->barang_model->get_all();
        $data['data_lokasi']        = $this->lokasi_model->get_all();
        $data['new_mutasi_masuk']   = $new_mutasi_masuk;
        $this->template->load('body', 'transaksi/mutasi/mutasi_masuk_form', $data);
    }

    function add_item(){
        if(!isset($_POST['id_barang'])) return;
        
        $new_mutasi_masuk = $this->session->userdata('new_mutasi_masuk');

        $items = $new_mutasi_masuk['items'];
        $exist = false;
        if($items!=''){
        foreach($items as $key=>$val){
                if($val['id_barang'] == $this->input->post('id_barang')){
                    $new_mutasi_masuk['items'][$key] = array(
                        'id_barang'      => $this->input->post('id_barang'),
                        'nm_barang'      => $this->input->post('nm_barang'),
                        'quantity'       => $this->input->post('quantity'),
                        'no_lot'         => $this->input->post('no_lot'),
                        'kadaluarsa'     => $this->input->post('kadaluarsa'),
                        'harga_perolehan'=> $this->input->post('harga_perolehan'),
                        'no_hasil'       => $this->input->post('no_hasil')
                    );
                    $exist = true;
                    break;
                }
            }
        }

        if(!$exist){
            $new_mutasi_masuk['items'][] = array(
                    'id_barang'      => $this->input->post('id_barang'),
                    'nm_barang'      => $this->input->post('nm_barang'),
                    'quantity'       => $this->input->post('quantity'),
                    'no_lot'         => $this->input->post('no_lot'),
                    'kadaluarsa'     => $this->input->post('kadaluarsa'),
                    'harga_perolehan'=> $this->input->post('harga_perolehan'),
                    'no_hasil'       => $this->input->post('no_hasil')
            );
        }
        
        $this->session->set_userdata('new_mutasi_masuk', $new_mutasi_masuk);        
    }

    function remove_item(){
        if(!isset($_GET['index_id'])) return;
        $index_id = $this->input->get('index_id');
        $new_mutasi_masuk = $this->session->userdata('new_mutasi_masuk');

        $items = $new_mutasi_masuk['items'];
        foreach($items as $key=>$val){
            if($val['no_hasil'] == $index_id){
                unset($new_mutasi_masuk['items'][$key]);
                $new_mutasi_masuk['items'] = array_values($new_mutasi_masuk['items']);
                break;
            }
        }

        $this->session->set_userdata('new_mutasi_masuk', $new_mutasi_masuk);
        jsout(array('success'=>1)); 
    }

    function form_act(){
        $save   = $this->mutasi_model->act_form_masuk();

        $this->session->unset_userdata('new_mutasi_masuk');
        jsout(array('success' => true, 'status' => $save ));
    }

    function approve(){
        $id_mutasi          = $this->input->post('id_mutasi');
        $approve_mutasi     = $this->input->post('approve_mutasi');

        if($approve_mutasi==1){
            $this->mutasi_model->update_status($id_mutasi,$approve_mutasi);
            $this->mutasi_model->stok($id_mutasi);

        }elseif($approve_mutasi==2){
            $this->mutasi_model->update_status($id_mutasi,$approve_mutasi);
        }
    }

    function delete(){
        $delete = $this->mutasi_model->act_delete();
        jsout(array('success' => true, 'status' => $delete ));
    }

    function edit($id){
        $this->session->unset_userdata('new_mutasi_masuk');

        $this->load->model('master/barang_model');
        $this->load->model('master/lokasi_model');

        $new_mutasi_masuk = $this->session->userdata('new_mutasi_masuk');
        $detail     = $this->mutasi_model->mutasi_detail($id)->result();
        $tdetail    = $this->mutasi_model->mutasi_detail($id)->num_rows();
        $no         = 0;
        if($tdetail!=0){
            foreach($detail as $key=>$val){
                $bulan          = substr($val->tgl_kadaluwarsa,5,2);
                $hari           = substr($val->tgl_kadaluwarsa,8,2);
                $tahun          = substr($val->tgl_kadaluwarsa,0,4);
                $tanggal        = $bulan.'/'.$hari.'/'.$tahun;

                $new_mutasi_masuk['items'][$key] = array(
                    'no_hasil'      => $val->id_mutasi_detail,
                    'id_mutasi'     => $val->id_mutasi,
                    'id_barang'     => $val->id_barang,
                    'nm_barang'     => $val->nama,
                    'quantity'      => $val->qty,
                    'no_lot'        => $val->lot_no,
                    'kadaluarsa'    => $tanggal
                );
            }
            $no     = $val->id_mutasi_detail;
        }else{
            $new_mutasi_masuk['items'] = array();
        }

        $this->session->set_userdata('new_mutasi_masuk', $new_mutasi_masuk);
        $data['data_barang']        = $this->barang_model->get_all();
        $data['data_lokasi']        = $this->lokasi_model->get_all();
        $data['new_mutasi_masuk']   = $new_mutasi_masuk;
        $data['no_urut']            = $no;
        $data['header']             = $this->mutasi_model->mutasi_header($id)->row();
        $this->template->load('body', 'transaksi/mutasi/mutasi_masuk_edit', $data);
    }

    function edit_act(){
        $update   = $this->mutasi_model->act_edit_masuk();
        $this->session->unset_userdata('new_mutasi_masuk');
        jsout(array('success' => true, 'status' => $update ));
    }

    function reset(){
        $this->session->unset_userdata('new_mutasi_masuk');
        redirect('transaksi/mutasi_masuk');
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

    function stok_barang(){
        $id         = $this->input->post('id');
        $result     = $this->mutasi_model->stok_barang($id);
        echo json_encode($result);
    }

}
?>