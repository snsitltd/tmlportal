<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Support_model extends CI_Model
{ 
    function SupportListing()
    {
        $this->db->select('TIMESTAMPDIFF(HOUR, tbl_support.tsupdate_date, CURRENT_TIMESTAMP()) as TIMEDIFFHOUR');
        $this->db->select('tbl_support.*, tbl_users.name as created_by');
		$this->db->select(' DATE_FORMAT(tbl_support.tsupdate_date,"%d-%m-%Y  %T") as tsupdate_date ');  	 	
		$this->db->select(' DATE_FORMAT(tbl_support.tscreate_date,"%d-%m-%Y  %T") as tscreate_date ');  	 	
		$this->db->from('tbl_support');
		$this->db->join('tbl_users', '  tbl_support.icreated_by = tbl_users.userId ', "LEFT"); 
		$this->db->where('tbl_support.iprimary','0');
		$this->db->where('tbl_support.idelete','0');
		//$this->db->where('tbl_support.istatus','0');
		$this->db->where('DATE_FORMAT(tbl_support.tsupdate_date,"%Y") > 2021' ); 	 
        $this->db->order_by('tbl_support.isupport_id', 'DESC'); 
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	function SupportListing1()
    {
        $this->db->select('tbl_support.*, tbl_users.name as created_by');
		$this->db->select(' DATE_FORMAT(tbl_support.tsupdate_date,"%d-%m-%Y  %T") as tsupdate_date ');  	 	
		$this->db->from('tbl_support');
		$this->db->where('tbl_support.iprimary','0');
		$this->db->where('tbl_support.idelete','0');
		$this->db->where('tbl_support.istatus','1');
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_support.icreated_by', "LEFT"); 
        $this->db->order_by('tbl_support.isupport_id', 'DESC'); 
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	function SupportComments($SupportID)
    {
        $this->db->select('tbl_support.*, tbl_users.name as created_by');
		$this->db->select(' DATE_FORMAT(tbl_support.tsupdate_date,"%d-%m-%Y  %T") as tsupdate_date ');  	 	
		$this->db->from('tbl_support');
		$this->db->where('tbl_support.iprimary',$SupportID); 
        $this->db->join('tbl_users', 'tbl_users.userId = tbl_support.icreated_by', "LEFT"); 
        $this->db->order_by('tbl_support.tscreate_date', 'asc'); 
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }	
    
    function addNewSupport($Info){
        $this->db->trans_start();
        $this->db->insert('tbl_support', $Info); 
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete(); 
        return $insert_id;
    } 

}

  