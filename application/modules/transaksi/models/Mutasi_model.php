<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mutasi_model extends CI_Model
{

    function get_all()
    {
        $sql ='SELECT a.*,b.nm_parameter,c.lab FROM m_metode a LEFT JOIN m_parameter b ON a.kd_parameter=b.kd_parameter
                LEFT JOIN m_lab c ON a.kd_lab=c.kd_lab
                WHERE a.aktif="Y" order by a.kd_metode DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_all_masuk(){
        $sql ='SELECT a.id_mutasi,a.no_mutasi,a.tgl,a.keterangan,a.id_lokasi,a.approve_mutasi,b.lokasi FROM t_mutasi a LEFT JOIN m_lokasi b
                ON a.id_lokasi=b.id_lokasi where a.status_mutasi="1" ORDER BY a.id_mutasi DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function act_form_masuk(){
        $new_mutasi_masuk   = $this->session->userdata('new_mutasi_masuk');

        $periode            = date('Y').date('m');
        $id_mutasi          = $this->max_id()->id_mutasi;
        $no_mutasi          = $periode.'1'.$this->max_nomor('1',$periode)->no_mutasi;
        $hari               = substr($this->input->post('tanggal'),0,2);
        $bulan              = substr($this->input->post('tanggal'),3,2);
        $tahun              = substr($this->input->post('tanggal'),6,4);
        $tanggal            = $tahun.'-'.$bulan.'-'.$hari;
        $keterangan         = $this->security->xss_clean($this->db->escape_str($this->input->post('keterangan')));
        $id_lokasi          = $this->security->xss_clean($this->db->escape_str($this->input->post('id_lokasi')));
        $id_sub_lokasi      = $this->security->xss_clean($this->db->escape_str($this->input->post('id_sub_lokasi')));
        
        $sql    = "INSERT INTO t_mutasi (id_mutasi,no_mutasi,tgl,keterangan,id_lokasi,id_sub_lokasi,status_mutasi,id_username,tgl_update,approve_mutasi)VALUES
            ('".$id_mutasi."','".$no_mutasi."','".$tanggal."','".$keterangan."','".$id_lokasi."','".$id_sub_lokasi."','1','".$this->current_user['id_username']."','".dbnow()."','0')";
        $query = $this->db->query($sql);

        if(isset($new_mutasi_masuk['items'])){
            $items          = $new_mutasi_masuk['items'];
            foreach ($items as $key => $value) {
                $id_detail      = $this->max_id_detail()->id_mutasi_detail;
                $hari           = substr($value['kadaluarsa'],0,2);
                $bulan          = substr($value['kadaluarsa'],3,2);
                $tahun          = substr($value['kadaluarsa'],6,4);
                $tanggal        = $tahun.'-'.$bulan.'-'.$hari;
                if($tanggal=='--'){
                    $tanggal    = '1700-01-01';
                }
                $sql_detail     = "INSERT INTO t_mutasi_detail (id_mutasi_detail,id_mutasi,id_barang,qty,harga_perolehan,lot_no,tgl_kadaluwarsa)
                                VALUES('".$id_detail."','".$id_mutasi."','".$value['id_barang']."','".$value['quantity']."','".$value['harga_perolehan']."','".$value['no_lot']."','".$tanggal."')";
                $query          = $this->db->query($sql_detail);
            }
        }
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function max_id(){
        $query = $this->db->query("SELECT IFNULL(MAX(id_mutasi),0)+1 id_mutasi FROM t_mutasi")->row();
        return $query;
    }

    function max_nomor($id,$periode){
        $query = $this->db->query("SELECT IFNULL(LPAD(MAX(SUBSTRING(no_mutasi,8,4))+1,4,'0'),'0001') no_mutasi FROM t_mutasi WHERE status_mutasi='".$id."' AND SUBSTRING(no_mutasi,1,6)='".$periode."'")->row();
        return $query;
    }

    function max_id_detail(){
        $query = $this->db->query("SELECT IFNULL(MAX(id_mutasi_detail),0)+1 id_mutasi_detail FROM t_mutasi_detail")->row();
        return $query;
    }

    function update_status($id,$approve){
        return $this->db->query("UPDATE t_mutasi SET approve_mutasi = '".$approve."' WHERE id_mutasi = '".$id."'");
    }

    function stok($id){
        $data   = $this->db->query("SELECT a.id_mutasi_detail,a.id_barang,a.qty,a.lot_no,a.tgl_kadaluwarsa,b.id_lokasi,b.id_sub_lokasi,b.tgl
                            FROM t_mutasi_detail a LEFT JOIN t_mutasi b on a.id_mutasi=b.id_mutasi WHERE a.id_mutasi='".$id."'")->result();

        foreach ($data as $key => $value) {
            $this->db->query("INSERT INTO t_stok (id_barang,qty,lot_no,tgl_kadaluwarsa,id_lokasi,id_sub_lokasi)VALUE
                    ('".$value->id_barang."','".$value->qty."','".$value->lot_no."','".$value->tgl_kadaluwarsa."','".$value->id_lokasi."','".$value->id_sub_lokasi."')");
        }

        foreach ($data as $key => $value) {
            $query      = $this->db->query("SELECT current_stock FROM `t_stok_detail` WHERE id_barang='".$value->id_barang."' AND id_lokasi='".$value->id_lokasi."'
                                            AND lot_no='".$value->lot_no."' ORDER BY id_stok DESC LIMIT 1");
            $current    = $query->num_rows();

            if($current==0){
                $old    = 0;
            }else{
                $old    = $query->row()->current_stock;
            }

            $current_stock      = $old + $value->qty;

            $this->db->query("INSERT INTO t_stok_detail (id_barang,tgl_transaksi,old_stock,qty_in,qty_out,current_stock,lot_no,tgl_kadaluwarsa,id_lokasi,id_sub_lokasi)
                VALUES
            ('".$value->id_barang."','".$value->tgl."','".$old."','".$value->qty."','0','".$current_stock."','".$value->lot_no."','".$value->tgl_kadaluwarsa."','".$value->id_lokasi."','".$value->id_sub_lokasi."')");

        }

    }

    function mutasi_detail($id){
        $sql    = "SELECT a.id_mutasi_detail,a.id_mutasi,a.id_barang,b.nama,a.qty,a.lot_no,a.tgl_kadaluwarsa FROM t_mutasi_detail a LEFT JOIN
                    m_barang b ON a.id_barang=b.id_barang
                    WHERE a.id_mutasi='".$id."'";
        $query  = $this->db->query($sql);
        return $query;
    }

    function mutasi_header($id){
        $sql    = "SELECT a.*,b.lokasi FROM t_mutasi a LEFT JOIN m_lokasi b ON a.id_lokasi=b.id_lokasi WHERE a.id_mutasi='".$id."'";
        $query  = $this->db->query($sql);
        return $query;
    }

    function act_edit_masuk(){
        $new_mutasi_masuk   = $this->session->userdata('new_mutasi_masuk');

        $bulan              = substr($this->input->post('tanggal'),0,2);
        $hari               = substr($this->input->post('tanggal'),3,2);
        $tahun              = substr($this->input->post('tanggal'),6,4);
        $tanggal            = $tahun.'-'.$bulan.'-'.$hari;
        $keterangan         = $this->security->xss_clean($this->db->escape_str($this->input->post('keterangan')));
        $id_lokasi          = $this->security->xss_clean($this->db->escape_str($this->input->post('id_lokasi')));
        $id_mutasi          = $this->security->xss_clean($this->db->escape_str($this->input->post('id_mutasi')));
        
        $sql    = "UPDATE t_mutasi SET tgl = '".$tanggal."',keterangan = '".$keterangan."',id_lokasi = '".$id_lokasi."' WHERE id_mutasi = '".$id_mutasi."'";
        $query = $this->db->query($sql);

        $delete = "DELETE FROM t_mutasi_detail WHERE id_mutasi = '".$id_mutasi."'";
        $query = $this->db->query($delete);
                    
        if(isset($new_mutasi_masuk['items'])){
            $items          = $new_mutasi_masuk['items'];
            foreach ($items as $key => $value) {
                $id_detail      = $this->max_id_detail()->id_mutasi_detail;
                $bulan          = substr($value['kadaluarsa'],0,2);
                $hari           = substr($value['kadaluarsa'],3,2);
                $tahun          = substr($value['kadaluarsa'],6,4);
                $tanggal        = $tahun.'-'.$bulan.'-'.$hari;
                $sql_detail     = "INSERT INTO t_mutasi_detail (id_mutasi_detail,id_mutasi,id_barang,qty,lot_no,tgl_kadaluwarsa)
                                VALUES('".$id_detail."','".$id_mutasi."','".$value['id_barang']."','".$value['quantity']."','".$value['no_lot']."','".$tanggal."')";
                $query          = $this->db->query($sql_detail);
            }
        }
        
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function get_all_keluar(){
        $sql ='SELECT a.id_mutasi,a.no_mutasi,a.tgl,a.keterangan,a.id_lokasi,a.approve_mutasi,b.lokasi FROM t_mutasi a LEFT JOIN m_lokasi b
                ON a.id_lokasi=b.id_lokasi where a.status_mutasi="2" ORDER BY a.id_mutasi DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function stok_barang($id){
        $query = $this->db->query(" SELECT * FROM stok_barang WHERE id_lokasi='".$id."' AND qty>=1 ")->result();                
        return $query;
    }

    function act_form_keluar(){
        $new_mutasi_keluar   = $this->session->userdata('new_mutasi_keluar');
        $periode            = date('Y').date('m');
        $id_mutasi          = $this->max_id()->id_mutasi;
        $no_mutasi          = $periode.'2'.$this->max_nomor('2',$periode)->no_mutasi;
        $hari               = substr($this->input->post('tanggal'),0,2);
        $bulan              = substr($this->input->post('tanggal'),3,2);
        $tahun              = substr($this->input->post('tanggal'),6,4);
        $tanggal            = $tahun.'-'.$bulan.'-'.$hari;
        $keterangan         = $this->security->xss_clean($this->db->escape_str($this->input->post('keterangan')));
        $id_lokasi          = $this->security->xss_clean($this->db->escape_str($this->input->post('id_lokasi')));
        $id_lokasi_tujuan   = $this->security->xss_clean($this->db->escape_str($this->input->post('id_lokasi_tujuan')));
        $id_sub_lokasi      = $this->security->xss_clean($this->db->escape_str($this->input->post('id_sub_lokasi')));
        
        $sql    = "INSERT INTO t_mutasi (id_mutasi,no_mutasi,tgl,keterangan,id_lokasi,id_sub_lokasi,status_mutasi,id_username,tgl_update,approve_mutasi,id_lokasi_tujuan)
            VALUES
            ('".$id_mutasi."','".$no_mutasi."','".$tanggal."','".$keterangan."','".$id_lokasi."','".$id_sub_lokasi."','2','".$this->current_user['id_username']."','".dbnow()."','0','".$id_lokasi_tujuan."')";
        $query = $this->db->query($sql);

        if(isset($new_mutasi_keluar['items'])){
            $items          = $new_mutasi_keluar['items'];
            foreach ($items as $key => $value) {
                $id_detail      = $this->max_id_detail()->id_mutasi_detail;
                $hari           = substr($value['kadaluarsa'],0,2);
                $bulan          = substr($value['kadaluarsa'],3,2);
                $tahun          = substr($value['kadaluarsa'],6,4);
                $tanggal        = $tahun.'-'.$bulan.'-'.$hari;
                if($tanggal=='--'){
                    $tanggal    = '1700-01-01';
                }
                $sql_detail     = "INSERT INTO t_mutasi_detail (id_mutasi_detail,id_mutasi,id_stok,id_barang,qty,lot_no,tgl_kadaluwarsa)VALUES
                ('".$id_detail."','".$id_mutasi."','".$value['id_stok']."','".$value['id_barang']."','".$value['quantity']."','".$value['no_lot']."','".$tanggal."')";

                $query          = $this->db->query($sql_detail);
            }
        }
        
        if($query === false){
            return "ERROR INSERTT";
        }else{
            return $query;
        }
    }

    function stok_keluar($id){
        $data   = $this->db->query("SELECT a.id_mutasi_detail,a.id_barang,a.qty,a.lot_no,a.tgl_kadaluwarsa,b.id_lokasi,a.id_stok,b.id_lokasi_tujuan,b.id_sub_lokasi,b.tgl
                            FROM t_mutasi_detail a LEFT JOIN t_mutasi b on a.id_mutasi=b.id_mutasi WHERE a.id_mutasi='".$id."'")->result();

        // Mengurangi Stok dari Lokasi Awal
        foreach ($data as $key => $value) {
            $qty_stok   = $this->db->query("SELECT qty FROM t_stok WHERE id_stok='".$value->id_stok."'")->row()->qty;
            $stok_akhir = $qty_stok - $value->qty;
            $this->db->query("UPDATE t_stok SET qty = '".$stok_akhir."' WHERE id_stok = '".$value->id_stok."'");
        }

        // Menambah Stok Ke Lokasi Tujuan
        // $data2   = $this->db->query("SELECT a.id_mutasi_detail,a.id_barang,a.qty,a.lot_no,a.tgl_kadaluwarsa,b.id_lokasi,b.id_lokasi_tujuan,b.id_sub_lokasi
        //                     FROM t_mutasi_detail a LEFT JOIN t_mutasi b on a.id_mutasi=b.id_mutasi WHERE a.id_mutasi='".$id."'")->result();

        // foreach ($data2 as $key => $value) {
        //     $this->db->query("INSERT INTO t_stok (id_barang,qty,lot_no,tgl_kadaluwarsa,id_lokasi,id_sub_lokasi)VALUE
        //     ('".$value->id_barang."','".$value->qty."','".$value->lot_no."','".$value->tgl_kadaluwarsa."','".$value->id_lokasi_tujuan."','".$value->id_sub_lokasi."')");
        // }

        // Mengurangi Stok di History
        foreach ($data as $key => $value) {
            $query      = $this->db->query("SELECT current_stock FROM `t_stok_detail` WHERE id_barang='".$value->id_barang."' AND id_lokasi='".$value->id_lokasi."'
                                            AND lot_no='".$value->lot_no."' ORDER BY id_stok DESC LIMIT 1");
            $current    = $query->num_rows();
            $old        = $query->row()->current_stock;

            $current_stock      = $old - $value->qty;

            $this->db->query("INSERT INTO t_stok_detail (id_barang,tgl_transaksi,old_stock,qty_in,qty_out,current_stock,lot_no,tgl_kadaluwarsa,id_lokasi)VALUES
            ('".$value->id_barang."','".$value->tgl."','".$old."','0','".$value->qty."','".$current_stock."','".$value->lot_no."','".$value->tgl_kadaluwarsa."','".$value->id_lokasi."')");
        }

        // Menambah Stok di History
        // foreach ($data2 as $key => $value) {
        //     $query      = $this->db->query("SELECT current_stock FROM `t_stok_detail` WHERE id_barang='".$value->id_barang."' AND id_lokasi='".$value->id_lokasi_tujuan."'");
        //     $current    = $query->num_rows();

        //     if($current==0){
        //         $old    = 0;
        //     }else{
        //         $old    = $query->row()->current_stock;
        //     }

        //     $current_stock      = $old + $value->qty;

        //     $this->db->query("INSERT INTO t_stok_detail (id_barang,old_stock,qty_in,qty_out,current_stock,lot_no,tgl_kadaluwarsa,id_lokasi,id_sub_lokasi)VALUES
        //     ('".$value->id_barang."','".$old."','0','".$value->qty."','".$current_stock."','".$value->lot_no."','".$value->tgl_kadaluwarsa."','".$value->id_lokasi_tujuan."','".$value->id_sub_lokasi."')");
        // }

    }

    function get_all_barang($start=0,$length=10,$search='',$id) {
        // $sql = "SELECT a.request_id, a.request_no, a.request_date,a.requester,c.name dept,a.project_id,d.project_name,d.project_location FROM trn_request_01 a 
        //         LEFT JOIN db_master.mst_user_group c ON c.id_user_group=a.dept
        //         LEFT JOIN db_master.mst_project d ON d.project_id=a.project_id
        //         WHERE a.status_request='2' AND a.status_approve='1' AND (a.request_no LIKE '%".$search."%')
        //         order by a.request_no asc
        //         LIMIT ".$start.", ".$length."";

        $sql = "SELECT a.*,b.nama FROM t_stok a LEFT JOIN m_barang b ON a.id_barang=b.id_barang WHERE a.id_lokasi='".$id."' AND (b.nama LIKE '%".$search."%') AND a.qty>0
                ORDER BY b.nama LIMIT ".$start.", ".$length."";

        $item = $this->db->query($sql)->result();
        return is_for($item) ? $item : false;
    }

    function get_count_display($start,$length,$search = false,$id) {
        $str = '';
        if ($search) {
            $str = " AND (b.nama LIKE '%".$search."%') ";
        }

        $sql = " SELECT COUNT(a.id_stok) total FROM t_stok a LEFT JOIN m_barang b ON a.id_barang=b.id_barang WHERE a.id_lokasi='".$id."' ".$str." ";
        $item = $this->db->query($sql)->row();
        return isset($item->total) ? $item->total : 0;
    }

    function get_count($id){
        $sql ="SELECT COUNT(a.id_stok) total FROM t_stok a LEFT JOIN m_barang b ON a.id_barang=b.id_barang WHERE a.id_lokasi='".$id."' ";
        $item = $this->db->query($sql)->row();
        return isset($item->total) ? $item->total : 0;
    }

    function last_stok($id_lokasi){
        $sql = "SELECT a.*,b.nama,b.barcode,c.lokasi,d.satuan,IF(a.tgl_kadaluwarsa!='1700-01-01',a.tgl_kadaluwarsa,'') tgl,e.tempat FROM t_stok a
                    JOIN m_barang b ON a.id_barang=b.id_barang
                    JOIN m_lokasi c ON a.id_lokasi=c.id_lokasi
                    JOIN m_satuan d ON b.id_satuan=d.id_satuan 
                    LEFT JOIN m_lokasi_sub e ON e.id_sub_lokasi=a.id_sub_lokasi
                    WHERE a.qty > 0 ";
        if($id_lokasi!=''){
            $sql .=" AND a.id_lokasi='".$id_lokasi."' ";
        }

        $sql    .= " Order by c.lokasi,b.nama ";

        return $this->db->query($sql)->result();

    }

    function history_stok_barang($id_lokasi,$year,$month){
        $sql = " SELECT a.*,b.nama,b.barcode,c.lokasi,d.satuan,IF(a.tgl_kadaluwarsa!='1700-01-01',a.tgl_kadaluwarsa,'') tgl,e.tempat 
                    FROM t_stok_detail a 
                    JOIN m_barang b ON a.id_barang=b.id_barang
                    JOIN m_lokasi c ON a.id_lokasi=c.id_lokasi
                    JOIN m_satuan d ON b.id_satuan=d.id_satuan 
                    LEFT JOIN m_lokasi_sub e ON e.id_sub_lokasi=a.id_sub_lokasi
                    WHERE a.id_barang > 0 ";
        // if($id_lokasi!=''){
        $sql .= " AND a.id_lokasi='".$id_lokasi."' ";
        $sql .= " AND MONTH(a.tgl_transaksi)='".$month."' ";
        $sql .= " AND YEAR(a.tgl_transaksi)='".$year."' ";
        // }

        $sql .= " GROUP BY a.id_barang,a.lot_no ORDER BY a.lot_no DESC,a.id_barang,a.id_stok ";

        return $this->db->query($sql)->result();
    }

    function history_stok($id_lokasi){
        $sql = "SELECT a.*,b.nama,b.barcode,c.lokasi,d.satuan,IF(a.tgl_kadaluwarsa!='1700-01-01',a.tgl_kadaluwarsa,'') tgl,e.tempat FROM t_stok a
                    JOIN m_barang b ON a.id_barang=b.id_barang
                    JOIN m_lokasi c ON a.id_lokasi=c.id_lokasi
                    JOIN m_satuan d ON b.id_satuan=d.id_satuan 
                    LEFT JOIN m_lokasi_sub e ON e.id_sub_lokasi=a.id_sub_lokasi
                    WHERE a.qty > 0 ";
        if($id_lokasi!=''){
            $sql .=" AND a.id_lokasi='".$id_lokasi."' ";
        }

        $sql    .= " Order by c.lokasi,b.nama ";

        return $this->db->query($sql)->result();

    }



























    






















    

}   