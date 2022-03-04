<?php
/**
  * Ringkasan dari Parameter_model
  *
  * Model untuk mengelola Parameter
  * @author Firmansyah
  * @version 1.0
  * @package Model Parameter
  *
  * @param int $id integer
  *
  * @return void
  */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
  * Ringkasan dari Parameter_model
  *
  * Model untuk mengelola Parameter
  * @author Firmansyah
  * @version 1.0
  * @package Model Parameter
  *
  * @param int $id integer
  *
  * @return void
  */
class Parameter_model extends CI_Model
{
	/** fungsi untuk mendefinisikan tabel parameter */
    function __construct(){
        parent::__construct();
        $this->table  = 'm_parameter';
    }
	/** fungsi intuk menampilkan semua data parameter */
	function get_all()
    {
        $sql ='select * from '.$this->table.' ';
        $query = $this->db->query($sql);
        return $query->result();
    }
	/** fungsi intuk menampilkan data parameter berdasarkan id parameter 
	* @param int $id integer
	*/
    function get_detail($id)
    {
        $sql ='select * from '.$this->table.' where kd_parameter="'.$id.'"';
        $query = $this->db->query($sql);
        return $query->row();
    }
	/** fungsi intuk menampilkan data parameter berdasarkan kode laboratorium
	* @param int $id integer
	*/
    function get_detail_by_lab($kd){
        $sql ='select * from '.$this->table.' where kd_lab="'.$kd.'"';
        $query = $this->db->query($sql);
        return $query->result();
    }
	/** fungsi intuk menampilkan semua data parameter dijoinkan ke tabel laboratorium */
    function get_all_parameter()
    {
        $sql =" SELECT a.kd_parameter,a.nm_parameter,a.zorder,a.kd_lab,b.lab FROM ".$this->table." a LEFT JOIN m_lab b ON a.kd_lab=b.kd_lab ORDER BY a.kd_parameter DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
	/** fungsi untuk input ke tabel parameter */
    function act_form(){
        
        $nama           = $this->security->xss_clean($this->db->escape_str($this->input->post('nama')));

        if($this->input->post('zorder')!=''){
            $zorder     = $this->security->xss_clean($this->db->escape_str($this->input->post('zorder')));
        }else{
            $zorder     = 'NULL';
        }
        $kd_lab         = $this->security->xss_clean($this->db->escape_str($this->input->post('kd_lab')));

        $sql    = "INSERT INTO m_parameter (nm_parameter, zorder, kd_lab)VALUES('".$nama."', $zorder, '".$kd_lab."')";
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }

    }
	/** fungsi untuk mendapatkan no dokumen */
    function get_no_doc($periode){
        $sql    = "SELECT IFNULL(LPAD(MAX(SUBSTRING(barcode,7,4))+1,4,'0'),'0001') nomor_dok FROM ".$this->table." WHERE SUBSTRING(barcode,1,6) = '".$periode."'";
        $query  = $this->db->query($sql)->row();
        return $query;

    }
	/** 
	* fungsi untuk edit ke tabel parameter 
	*/
    function act_edit(){

        $nama           = $this->security->xss_clean($this->db->escape_str($this->input->post('nama')));
        $kd_parameter   = $this->security->xss_clean($this->db->escape_str($this->input->post('kd_parameter')));
        if($this->input->post('zorder')!=''){
            $zorder     = $this->security->xss_clean($this->db->escape_str($this->input->post('zorder')));
        }else{
            $zorder     = 'NULL';
        }
        $kd_lab         = $this->security->xss_clean($this->db->escape_str($this->input->post('kd_lab')));

        $sql    = "UPDATE m_parameter SET nm_parameter = '".$nama."',zorder = $zorder ,kd_lab = '".$kd_lab."' WHERE kd_parameter = '".$kd_parameter."'";
        $query  = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }
	/** 
	* fungsi untuk delete ke tabel parameter 
	*/
    function act_delete(){
        $sql = "DELETE FROM m_parameter WHERE kd_parameter = '".$this->input->post('kd_parameter')."'";
        $query = $this->db->query($sql);
        return $query;
    }

}
?>