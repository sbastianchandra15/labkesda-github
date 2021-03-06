<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hasil_model extends CI_Model
{

    function get_all()
    {
        $sql ='SELECT a.no_pendaftaran,a.nama,a.uraian_sampel,a.kd_sampel,a.tgl_diterima,a.tgl_pengujian,a.tgl_selesai,a.kd_lab,a.kd_metode,a.jns_analisa,a.status,
                a.ket_sampel,a.umur,a.dokter,a.jns_kelamin,b.nm_sampel,c.lab,d.nm_metode,a.tgl_input
                FROM t_pendaftaran20191121 a 
                LEFT JOIN m_sampel b ON a.kd_sampel=b.kd_sampel
                LEFT JOIN m_lab c ON a.kd_lab=c.kd_lab
                LEFT JOIN m_metode d ON a.kd_metode=d.kd_metode
                WHERE a.status="1"
                ORDER BY a.tgl_input DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_all_klinik()
    {
        $sql ='SELECT a.no_pendaftaran,a.nama,a.uraian_sampel,a.kd_sampel,a.tgl_diterima,a.tgl_pengujian,a.tgl_selesai,a.kd_lab,a.kd_metode,a.jns_analisa,a.status,
                a.ket_sampel,a.umur,a.dokter,a.jns_kelamin,b.nm_sampel,c.lab,d.nm_metode,a.tgl_input,REPLACE(a.no_pendaftaran,"/","-") nopendaftar
                FROM t_pendaftaran a 
                LEFT JOIN m_sampel b ON a.kd_sampel=b.kd_sampel
                LEFT JOIN m_lab c ON a.kd_lab=c.kd_lab
                LEFT JOIN m_metode d ON a.kd_metode=d.kd_metode
                WHERE a.status="1" AND a.kd_lab="LK"
                ORDER BY a.tgl_input DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_all_lingkungan()
    {
        $sql ='SELECT a.no_pendaftaran,a.nama,a.uraian_sampel,a.kd_sampel,a.tgl_diterima,a.tgl_pengujian,a.tgl_selesai,a.kd_lab,a.kd_metode,a.jns_analisa,a.status,
                a.ket_sampel,a.umur,a.dokter,a.jns_kelamin,b.nm_sampel,c.lab,d.nm_metode,a.tgl_input,REPLACE(a.no_pendaftaran,"/","-") nopendaftar
                FROM t_pendaftaran a 
                LEFT JOIN m_sampel b ON a.kd_sampel=b.kd_sampel
                LEFT JOIN m_lab c ON a.kd_lab=c.kd_lab
                LEFT JOIN m_metode d ON a.kd_metode=d.kd_metode
                WHERE a.status="1" AND a.kd_lab="LL"
                ORDER BY a.tgl_input DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_all_maknum(){
        $sql ='SELECT a.no_pendaftaran,a.nama,a.uraian_sampel,a.kd_sampel,a.tgl_diterima,a.tgl_pengujian,a.tgl_selesai,a.kd_lab,a.kd_metode,a.jns_analisa,a.status,
                a.ket_sampel,a.umur,a.dokter,a.jns_kelamin,b.nm_sampel,c.lab,d.nm_metode,a.tgl_input,REPLACE(a.no_pendaftaran,"/","-") nopendaftar
                FROM t_pendaftaran a 
                LEFT JOIN m_sampel b ON a.kd_sampel=b.kd_sampel
                LEFT JOIN m_lab c ON a.kd_lab=c.kd_lab
                LEFT JOIN m_metode d ON a.kd_metode=d.kd_metode
                WHERE a.status="1" AND a.kd_lab="LM"
                ORDER BY a.tgl_input DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_all_masuk(){
        $sql ='SELECT a.id_mutasi,a.no_mutasi,a.tgl,a.keterangan,a.id_lokasi,a.approve_mutasi,b.lokasi FROM t_mutasi a LEFT JOIN m_lokasi b
                ON a.id_lokasi=b.id_lokasi where a.status_mutasi="1" ORDER BY a.id_mutasi DESC';
        $query = $this->db->query($sql);
        return $query->result();
    }

    function max_nomor($kd_lab,$m,$y){
        $query = $this->db->query("SELECT IFNULL(LPAD(MAX(SUBSTRING(no_pendaftaran,12,5))+1,5,'0'),'00001') nomor FROM t_pendaftaran WHERE kd_lab='".$kd_lab."' 
                                    AND MONTH(tgl_input)='".$m."' AND YEAR(tgl_input)='".$y."'")->row();
        return $query;
    }

    

    function header_hasil($id){
        $query      = $this->db->query("SELECT a.*,b.nm_sampel FROM t_pendaftaran a LEFT JOIN m_sampel b ON a.kd_sampel=b.kd_sampel 
                                        WHERE a.no_pendaftaran='".$id."'")->row();
        return $query;
    }

    function detail_hasil($id){
        $query      = $this->db->query("SELECT a.*,b.*,c.nm_parameter FROM t_pendaftaran_detail a LEFT JOIN m_metode b ON a.kd_metode=b.kd_metode
                                        LEFT JOIN m_parameter c ON a.kd_par=c.kd_parameter WHERE a.no_pendaftaran='".$id."'")->Result();
        return $query;
        
    }

    function detail_hasil_par($id){
        $query      = $this->db->query("SELECT a.*,b.nm_metode,c.nm_parameter FROM t_pendaftaran_detail a LEFT JOIN m_metode b ON a.kd_metode=b.kd_metode
                                        LEFT JOIN m_parameter c ON a.kd_par=c.kd_parameter WHERE a.no_pendaftaran='".$id."' GROUP BY a.kd_par")->Result();
        return $query;
        
    }

    function update_lingkungan_act(){
        $no      = $this->security->xss_clean($this->db->escape_str($this->input->post('no')));

        for ($x = 1; $x <= $no; $x++) {
            $no_pendaftaran = $this->input->post('no_pendaftaran')[$x];
            $kd_metode  = $this->input->post('kd_metode')[$x];
            $ket        = $this->input->post('keterangan')[$x];
            $hasil      = $this->input->post('hasil')[$x];

            $this->db->query("UPDATE t_pendaftaran_detail SET nilai = '".$hasil."',ket = '".$ket."' WHERE no_pendaftaran = '".$no_pendaftaran."' AND kd_metode = '".$kd_metode."'");
        }

    }

    function update_maknum_act(){
        $no      = $this->security->xss_clean($this->db->escape_str($this->input->post('no')));
        // test($no,1);
        for ($x = 1; $x <= $no; $x++) {
            $no_pendaftaran = $this->input->post('no_pendaftaran')[$x];
            $kd_metode  = $this->input->post('kd_metode')[$x];
            $ket        = $this->input->post('keterangan')[$x];
            $hasil      = $this->input->post('hasil')[$x];

            $this->db->query("UPDATE t_pendaftaran_detail SET nilai = '".$hasil."',ket = '".$ket."' WHERE no_pendaftaran = '".$no_pendaftaran."' AND kd_metode = '".$kd_metode."'");
        }

    }

    function update_klinik_act(){
        $no      = $this->security->xss_clean($this->db->escape_str($this->input->post('no')));
        // test($no,1);
        for ($x = 1; $x <= $no; $x++) {
            $no_pendaftaran = $this->input->post('no_pendaftaran')[$x];
            $kd_metode  = $this->input->post('kd_metode')[$x];
            $ket        = $this->input->post('keterangan')[$x];
            $hasil      = $this->input->post('hasil')[$x];

            $this->db->query("UPDATE t_pendaftaran_detail SET nilai = '".$hasil."',ket = '".$ket."' WHERE no_pendaftaran = '".$no_pendaftaran."' AND kd_metode = '".$kd_metode."'");
        }

    }


















}   