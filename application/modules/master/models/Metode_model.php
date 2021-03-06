<?php
/**
  * Ringkasan dari Metode_model
  *
  * Model untuk mengelola Metode
  * @author Firmansyah
  * @version 1.0
  * @package Model Metode
  *
  * @param int $id integer
  *
  * @return void
  */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
  * Ringkasan dari Metode_model
  *
  * Model untuk mengelola Metode
  * @author Firmansyah
  * @version 1.0
  * @package Model Metode
  *
  * @param int $id integer
  *
  * @return void
  */
class Metode_model extends CI_Model
{
	/** fungsi untuk mendefinisikan tabel metode */
    function get_all()
    {
        $sql ='SELECT a.*,b.nm_parameter,c.lab FROM m_metode a LEFT JOIN m_parameter b ON a.kd_parameter=b.kd_parameter
                LEFT JOIN m_lab c ON a.kd_lab=c.kd_lab
                WHERE a.aktif="Y" order by a.kd_metode DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }
	/** fungsi untuk input ke tabel metode */
    function act_form(){
        $new_metode   = $this->session->userdata('new_metode');


        $kd_metode          = $this->max_id()->kd_metode;
        $nama               = $this->security->xss_clean($this->db->escape_str($this->input->post('nama')));
        $satuan             = $this->security->xss_clean($this->db->escape_str($this->input->post('satuan')));
        $kadar              = $this->security->xss_clean($this->db->escape_str($this->input->post('kadar')));
        $metode_analisa     = $this->security->xss_clean($this->db->escape_str($this->input->post('metode_analisa')));
        $alias              = $this->security->xss_clean($this->db->escape_str($this->input->post('alias')));
        $akreditas          = $this->security->xss_clean($this->db->escape_str($this->input->post('akreditas')));
        $harga              = $this->security->xss_clean($this->db->escape_str($this->input->post('harga')));
        $jumlah             = $this->security->xss_clean($this->db->escape_str($this->input->post('jumlah')));
        $zoder              = $this->security->xss_clean($this->db->escape_str($this->input->post('zoder')));
        $kd_parameter       = $this->security->xss_clean($this->db->escape_str($this->input->post('kd_parameter')));
        $kd_lab             = $this->security->xss_clean($this->db->escape_str($this->input->post('kd_lab')));
        
        $sql    = "INSERT INTO m_metode (kd_metode,nm_metode,satuan,kadar,metode_analisa,alias,kd_parameter,kd_lab,akreditasi,harga,jml_pengecekan,zorder,aktif)VALUES
                ('".$kd_metode."','".$nama."','".$satuan."','".$kadar."','".$metode_analisa."','".$alias."','".$kd_parameter."','".$kd_lab."','".$akreditas."','".$harga."','".$jumlah."','".$zoder."','Y')";

        if(isset($new_metode['items'])){
            $items          = $new_metode['items'];
            foreach ($items as $key => $value) {
                $id_detail      = $this->max_id_detail()->id_metode_detail;
                $sql_detail     = "INSERT INTO m_metode_detail (id_metode_detail,kd_metode,hasil_lab)VALUES('".$id_detail."','".$kd_metode."','".$value['hasil_lab']."')";
                $query          = $this->db->query($sql_detail);
            }
        }
        
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function max_id_detail(){
        $query = $this->db->query("SELECT IFNULL(MAX(id_metode_detail),0)+1 id_metode_detail FROM m_metode_detail")->row();
                
        return $query;
    }

    function max_id(){
        $query = $this->db->query("SELECT MAX(kd_metode)+1 kd_metode FROM m_metode")->row();
                
        return $query;
    }
	/** 
	* fungsi untuk delete ke tabel metode 
	*/
    function act_delete(){
        $sql = "UPDATE m_metode SET aktif = 'N' WHERE kd_metode = '".$this->input->post('kd_metode')."'";
        $query = $this->db->query($sql);
        return $query;
    }
	/** fungsi intuk menampilkan detail metode berdasarkan id metode 
	* @param int $id integer
	*/
    function metode_detail($id){
        $sql    = "SELECT id_metode_detail,kd_metode,hasil_lab FROM m_metode_detail WHERE kd_metode='".$id."'";
        $query  = $this->db->query($sql);
        return $query;
    }
	/** fungsi intuk menampilkan header metode berdasarkan id metode 
	* @param int $id integer
	*/
    function metode_header($id){
        $sql    = "SELECT * FROM m_metode WHERE kd_metode='".$id."'";
        $query  = $this->db->query($sql);
        return $query;
    }
	/** 
	* fungsi untuk edit ke tabel metode 
	*/
    function act_edit(){
        $new_metode   = $this->session->userdata('new_metode');

        $kd_metode          = $this->security->xss_clean($this->db->escape_str($this->input->post('kd_metode')));
        $nama               = $this->security->xss_clean($this->db->escape_str($this->input->post('nama')));
        $satuan             = $this->security->xss_clean($this->db->escape_str($this->input->post('satuan')));
        $kadar              = $this->security->xss_clean($this->db->escape_str($this->input->post('kadar')));
        $metode_analisa     = $this->security->xss_clean($this->db->escape_str($this->input->post('metode_analisa')));
        $alias              = $this->security->xss_clean($this->db->escape_str($this->input->post('alias')));
        $akreditas          = $this->security->xss_clean($this->db->escape_str($this->input->post('akreditas')));
        $harga              = $this->security->xss_clean($this->db->escape_str($this->input->post('harga')));
        $jumlah             = $this->security->xss_clean($this->db->escape_str($this->input->post('jumlah')));
        $zoder              = $this->security->xss_clean($this->db->escape_str($this->input->post('zoder')));
        $kd_parameter       = $this->security->xss_clean($this->db->escape_str($this->input->post('kd_parameter')));
        $kd_lab             = $this->security->xss_clean($this->db->escape_str($this->input->post('kd_lab')));
        
        $sql    = "INSERT INTO m_metode (kd_metode,nm_metode,satuan,kadar,metode_analisa,alias,kd_parameter,kd_lab,akreditasi,harga,jml_pengecekan,zorder,aktif)VALUES
                ('".$kd_metode."','".$nama."','".$satuan."','".$kadar."','".$metode_analisa."','".$alias."','".$kd_parameter."','".$kd_lab."','".$akreditas."','".$harga."','".$jumlah."','".$zoder."','Y')";

        $sql    = "UPDATE m_metode
                    SET nm_metode = '".$nama."',
                        satuan = '".$satuan."',
                        kadar = '".$kadar."',
                        metode_analisa = '".$metode_analisa."',
                        alias = '".$alias."',
                        kd_parameter = '".$kd_parameter."',
                        kd_lab = '".$kd_lab."',
                        akreditasi = '".$akreditas."',
                        harga = '".$harga."',
                        jml_pengecekan = '".$jumlah."',
                        zorder = '".$zoder."'
                    where kd_metode = '".$kd_metode."'";

        $delete = "DELETE FROM m_metode_detail WHERE kd_metode = '".$kd_metode."'";
        $query = $this->db->query($delete);
                    
        if(isset($new_metode['items'])){
            $items          = $new_metode['items'];
            foreach ($items as $key => $value) {
                $id_detail      = $this->max_id_detail()->id_metode_detail;
                $sql_detail     = "INSERT INTO m_metode_detail (id_metode_detail,kd_metode,hasil_lab)VALUES('".$id_detail."','".$kd_metode."','".$value['hasil_lab']."')";
                $query          = $this->db->query($sql_detail);
            }
        }
        
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function kind_supplier(){
        $sql ='SELECT   supplier_kind_id,kind_name FROM mst_supplier_kind WHERE is_active=1';
        $query = $this->db->query($sql);
        return $query->result();
    }





















    function detail_supplier($id){
        $query = $this->db->query("SELECT supplier_id,supplier_code,supplier_kind_id,supplier_name,npwp,siup,address,city,contact1,contact2,contact3,email1,email2,pic_sales,top,
                                    supplier_info,is_ppn,file_npwp FROM mst_supplier WHERE supplier_id='".$id."'")->row();
                
        return $query;
    }

    function detail_items_supplier($id){
        $query = $this->db->query("SELECT a.items_id item_id,b.items_name item_name,a.items_price FROM mst_supplier_items a,mst_items b WHERE a.supplier_id='".$id."' AND a.items_id=b.items_id")->result();
                
        return $query;
    }

    function jumlah_items_supplier($id){
        $query = $this->db->query("SELECT a.items_id item_id,b.items_name item_name,a.items_price FROM mst_supplier_items a,mst_items b WHERE a.supplier_id='".$id."' AND a.items_id=b.items_id")->num_rows();
                
        return $query;
    }

    function get_supplier_id(){
        $query = $this->db->query("SELECT IFNULL(MAX(supplier_id)+1,1) supplier_id FROM mst_supplier")->row();
        return $query;
    }

    function get_nomor_dok($tahun){
        $query = $this->db->query("SELECT IFNULL(LPAD(MAX(SUBSTRING(supplier_code,7,5))+1,5,'0'),'00001') nomor_dok FROM mst_supplier WHERE SUBSTR(supplier_code,3,4)='".$tahun."'")->row();
        return $query;
    }

    

}   