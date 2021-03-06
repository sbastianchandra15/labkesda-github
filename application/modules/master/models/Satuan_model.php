<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Satuan_model extends CI_Model
{

	function __construct(){
        parent::__construct();
        $this->table  = 'm_satuan';
    }

    function get_all()
    {
        $sql ='select * from '.$this->table;
        $query = $this->db->query($sql);
        return $query->result();
    }

    function act_form(){
        $periode = date('Y').date('m');

        $name           = $this->security->xss_clean($this->db->escape_str($this->input->post('name')));
        $location       = $this->security->xss_clean($this->db->escape_str($this->input->post('location')));
        $info           = $this->security->xss_clean($this->db->escape_str($this->input->post('info')));

        $sql    = "INSERT INTO mst_project (project_name,project_location,project_info,pic_input,input_time,is_active) VALUES 
                ('".$name."','".$location."','".$info."','".$this->current_user['user_id']."','".dbnow()."',1)";

        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

    function act_delete_js(){
        $sql = "UPDATE mst_project SET is_active='0', pic_edit = '".$this->current_user['user_id']."', edit_time = '".dbnow()."' WHERE project_id = '".$this->input->post('project_id')."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        return $query;
    }

    function detail_project($id){
        $query = $this->db->query("SELECT project_id,project_name,project_location,project_info FROM mst_project WHERE project_id='".$id."'")->row();
        return $query;
    }

    function act_edit(){
        $sql    = "UPDATE mst_project
                    SET 
                      project_name = '".$this->security->xss_clean($this->db->escape_str($this->input->post('name')))."',
                      project_location = '".$this->security->xss_clean($this->db->escape_str($this->input->post('location')))."',
                      project_info = '".$this->security->xss_clean($this->db->escape_str($this->input->post('info')))."',
                      pic_edit = '".$this->current_user['user_id']."',
                      edit_time = '".dbnow()."'
                    WHERE project_id = '".$this->security->xss_clean($this->db->escape_str($this->input->post('project_id')))."'";
        //test($sql,1);
        $query = $this->db->query($sql);
        
        if ($query === false){
            return "ERROR INSERTT";
        }else{
            return $query; 
        }
    }

}	