<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Ticket_API_Model extends CI_Model
{
    
    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        $this->Tbl = 'tbl_tickets';
    }
    
    function generateRandomString($length = 12) {
		return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
	
	public function insert($table,$data){
      $this->db->insert($table,$data);
      return  $this->db->insert_id();
    }
	
	function LastTicketNo(){
		$this->db->select('TicketNumber');    
        $this->db->from('tbl_tickets');         
		$this->db->order_by('TicketNumber', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	} 
	function get_pdf_data_app($invoice_id){
        $this->db->select(' DATE_FORMAT(TicketDate,"%d/%m/%Y %T") as tdate ');  
		$this->db->select('tbl_tickets.TicketNumber, tbl_tickets.RegNumber, tbl_tickets.Hulller, tbl_tickets.SicCode, tbl_tickets.GrossWeight, tbl_tickets.Tare, tbl_tickets.Net '); 
		$this->db->select('tbl_company.CompanyName');
		$this->db->select('tbl_opportunities.OpportunityName');
		$this->db->select('tbl_materials.MaterialName');
        $this->db->from('tbl_tickets');
        $this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID'); 
        $this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 
		$this->db->join('tbl_materials', 'tbl_tickets.MaterialID = tbl_materials.MaterialID'); 
        $this->db->where("tbl_tickets.TicketNo", $invoice_id);                     
        $query = $this->db->get(); 
       // echo $this->db->last_query();       
        $result = $query->row_array();        
        return $result;
    } 
}
  