<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tickets_model extends CI_Model
{ 
	function LastTicketDate($TicketNumber){ 
		$this->db->select('DATE_ADD(tbl_tickets.TicketDate, INTERVAL 1 MINUTE) as TicketDate' );   
        $this->db->from('tbl_tickets');    
		$this->db->where('tbl_tickets.TicketNumber',$TicketNumber); 		 
		$this->db->order_by('TicketGap', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//exit;
		return $query->row_array();
	} 

	function LastTicketNo(){
		$this->db->select('TicketNumber');    
        $this->db->from('tbl_tickets');         
		$this->db->order_by('TicketNumber', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	} 
    function ticketsListing(){ 
        $this->db->select('t.*,c.CompanyName,c.CompanyID');
        $this->db->select(' DATE_FORMAT(t.TicketDate,"%d-%m-%Y  %T") as TicketDate ');  	 	
		$this->db->select(' DATE_FORMAT(TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  	
        $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = t.OpportunityID ) as OpportunityName '); 				
		$this->db->from('tickets as t');
        $this->db->join('company as c', 'c.CompanyID = t.CompanyID'); 
		$this->db->where('t.delete_notes IS NULL'); 
		$this->db->order_by('t.TicketDate', 'DESC'); 
        $this->db->order_by('t.TicketNo', 'DESC'); 
		$query = $this->db->get();
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    } 

 
    function OppTicketListing($oppid) { 
        $this->db->select('tickets.*,c.CompanyName,c.CompanyID');
        $this->db->select(' DATE_FORMAT(TicketDate,"%d-%m-%Y %T") as TicketDate ');  		
		$this->db->from('tickets');
        $this->db->join('company as c', 'c.CompanyID = tickets.CompanyID'); 
		$this->db->where('tickets.delete_notes IS NULL'); 
		$this->db->where('tickets.OpportunityID',$oppid); 
        $this->db->order_by('tickets.TicketNo', 'DESC');
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
       // echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    } 

	
	function getTicketInfo($id){
		$this->db->select('tbl_tickets.*');  
        $this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_tickets.CompanyID ) as CompanyName '); 		
        $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID ) as OpportunityName '); 		
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_tickets.MaterialID ) as MaterialName '); 		
        $this->db->from('tbl_tickets'); 
        $this->db->where('tbl_tickets.TicketNo',$id);		
		$query = $this->db->get(); 
		return $query->row_array();
	}	
	function tmlticketsListing()
    {
        $this->db->select('t.*,c.CompanyName,c.CompanyID');
        $this->db->select(' DATE_FORMAT(TicketDate,"%d-%m-%Y %T") as TicketDate ');  				
		$this->db->select(' DATE_FORMAT(TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  				
        $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = t.OpportunityID ) as OpportunityName '); 				
		$this->db->from('tickets as t');
        $this->db->join('company as c', 'c.CompanyID = t.CompanyID'); 
        $this->db->where('delete_notes IS NULL');
		$this->db->where('t.is_tml', '1');
		$this->db->order_by('t.TicketNo', 'DESC');
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	function tmlticketsListingHOLD()
    {
        $this->db->select('t.*,c.CompanyName,c.CompanyID');
        $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = t.OpportunityID ) as OpportunityName '); 
		$this->db->select(' DATE_FORMAT(TicketDate,"%d-%m-%Y %T") as TicketDate ');  	 
		$this->db->select(' DATE_FORMAT(TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  				
        $this->db->from('tickets as t');
        $this->db->join('company as c', 'c.CompanyID = t.CompanyID');  
		$this->db->where('delete_notes IS NULL');
		$this->db->where('t.is_hold', '1');
		$this->db->order_by('t.TicketNo', 'DESC');
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	function ticketsListingDeleted()
    {
        $this->db->select('t.*,c.CompanyName,c.CompanyID');
        $this->db->select(' DATE_FORMAT(TicketDate,"%d-%m-%Y %T") as TicketDate ');  	
		$this->db->select(' DATE_FORMAT(TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  				
        $this->db->from('tickets as t');
        $this->db->join('company as c', 'c.CompanyID = t.CompanyID');  
		$this->db->where('delete_notes <> ""'); 
		$this->db->order_by('t.TicketNo', 'DESC');
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	
	/* function getAllOpportunitiesByCompany($CompanyID)
    {
        $this->db->select('o.OpportunityID , o.OpportunityName');
        $this->db->from('opportunities as o');        
        $this->db->join('company_to_opportunities as cto', 'cto.OpportunityID = o.OpportunityID');        
        $this->db->where('cto.CompanyID', $CompanyID);
		$this->db->order_by('o.OpportunityName', 'ASC');
        $query = $this->db->get();        
        $result = $query->result();        
        return $result;
    } */
	
	function getAllOpportunitiesByCompany($CompanyID)
    {
        $this->db->select('o.OpportunityID , o.OpportunityName');
        $this->db->from('opportunities as o');        
        $this->db->join('company_to_opportunities as cto', 'cto.OpportunityID = o.OpportunityID');        
        $this->db->where('cto.CompanyID', $CompanyID);
		$this->db->where('o.OpportunityName <> "" ');
		$this->db->where('o.OpportunityName <> ",,," ');
		$this->db->order_by('o.OpportunityName', 'ASC');
        $query = $this->db->get();        
        $result = $query->result();        
        return $result;
    }
	
    function CheckDuplicateTicket($id,$tno){
        $this->db->select('TicketNo');
        $this->db->from('tbl_tickets');         
        $this->db->where('TicketNumber', $tno);
        $this->db->where('TicketGap',$id );		 
        $query = $this->db->get();        
        //$result = $query->result();        
        return $query->num_rows();
    } 


 
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getCounty()
    {
        $this->db->select('*');
        $this->db->from('county');
        $this->db->where('ID !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }


    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getCountry()
    {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->where('id !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }   
   
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewTickets($ticketsInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tickets', $ticketsInfo); 
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete(); 
        return $insert_id;
    }


    function getAllNotes($CompanyID)
    {
        $this->db->select('n.*, u.name');
        $this->db->from('notes as n');
        $this->db->join('users as u', 'u.userId = n.CreateUserID');
        $this->db->join('company_to_note as ctn', 'ctn.NoteID = n.NotesID'); 
        $this->db->order_by('n.NotesID', 'ASC');
        $this->db->where('ctn.CompanyID', $CompanyID);
        $where = '(n.CreateUserID="'.$this->session->userdata['userId'].'" or n.NoteType = 0)';
        $this->db->where($where);
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    } 



    function getSingleNote($NotesID)
    {
        $this->db->select('n.*, u.name');
        $this->db->from('notes as n');
        $this->db->join('users as u', 'u.userId = n.CreateUserID');         
        $this->db->order_by('n.NotesID', 'DESC');
        $this->db->where('n.NotesID', $NotesID);
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->row();        
        return $result;
    } 


    function getAllDocumnets($CompanyID)
    {
        $this->db->select('d.*, u.name');
        $this->db->from('documents as d');
        $this->db->join('users as u', 'u.userId = d.CreatedUserID');
        $this->db->join('company_to_document as ctd', 'ctd.DocumentID = d.DocumentID'); 
        $this->db->order_by('d.DocumentID', 'ASC');
        $this->db->where('ctd.CompanyID', $CompanyID);
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    } 
  
    function getMaterialList($operation){
        $this->db->select('*');
        $this->db->from('materials');
        $this->db->where('Operation', $operation);
        $this->db->order_by('MaterialName', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

/*    function getMaterialListDetails($id){
       
       $this->db->select('m.SicCode,p.TMLPrice as price');
        $this->db->from('materials as m');
        $this->db->join('price as p', 'm.PriceID = p.PriceID',"LEFT");
        $this->db->where('m.MaterialID', $id);
        $query = $this->db->get();
        
        $result = $query->row();        
        return $result;  
    } */

    function getMaterialListDetails($id){
       
        $this->db->select('m.SicCode,p.TMLPrice as price');
        $this->db->from('materials as m');
        $this->db->join('price as p', 'm.PriceID = p.PriceID',"LEFT");
        $this->db->where('m.MaterialID', $id);
        $query = $this->db->get();
        
        $result = $query->row();        
        return $result;  
    }
	function GetWIFNumber($id){
       
        $this->db->select('tbl_documents.DocumentNumber ');
        $this->db->from('tbl_documents');
        $this->db->join('tbl_opportunity_to_document', 'tbl_opportunity_to_document.DocumentID = tbl_documents.DocumentID' ); 
        $this->db->where('tbl_opportunity_to_document.OpportunityID', $id);
		$this->db->where('tbl_documents.DocumentType', '1');
		$this->db->limit(1);
        $query = $this->db->get();        
        $result = $query->row();        
        return $result;  
    }

    function getLorryNo(){
       $this->db->select('LorryNo,DriverName,RegNumber,Haulier');
       $this->db->from('drivers');
       $this->db->where('DriverName <> ""');
       $this->db->where('RegNumber <> ""');
	   
       $query = $this->db->get();
       $result = $query->result();        
       return $result; 
    }
    function getLorryNoDetails($id){
       $this->db->select('*');
       $this->db->from('drivers');
       $this->db->where('LorryNo', $id);
       $query = $this->db->get();
       $result = $query->row();        
        return $result; 
    }
    function getCustomerList(){

       $this->db->select('ContactName,ContactID');
       $this->db->from('contacts');
       $query = $this->db->get();
       $result = $query->result();        
       return $result;
    }

    function getOpportunitiesList(){
       $this->db->select('OpportunityID,OpportunityName');
       $this->db->from('opportunities');
       $this->db->order_by('OpportunityName', 'ASC');
       $query = $this->db->get();
       $result = $query->result();        
       return $result;    
    }
    function getCustomerDetails($id){
       $this->db->select('c.*');
       $this->db->from('company_to_opportunities as co');
       $this->db->join('company as c', 'c.CompanyID = co.CompanyID');
       $this->db->where('co.OpportunityID', $id);
       $this->db->order_by('c.CompanyName', 'ASC');
       $query = $this->db->get();
       $result = $query->row();        
        return $result;     
	}
	
	public function GetTicketData(){

		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
        //$totalData  = $this->db->count_all('tbl_tickets');
        //$totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');  	
		$this->db->select(' tbl_tickets.TicketNumber as TicketNumber_sort ');  	 		
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T") as TicketDate ');  	 	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  	
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_tickets.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_tickets.driver_id ');  	
		$this->db->select(' tbl_tickets.Conveyance ');  	
		$this->db->select(' tbl_tickets.RegNumber ');  	
		$this->db->select(' tbl_tickets.DriverName ');  	
		$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
		$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
		$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
		$this->db->select(' tbl_tickets.TypeOfTicket '); 
		$this->db->select(' tbl_tickets.CompanyID '); 
		$this->db->select(' tbl_tickets.OpportunityID '); 
		$this->db->select(' tbl_tickets.TicketNo '); 
		$this->db->select(' tbl_tickets.pdf_name '); 
		$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID'); 		
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 		
		$this->db->where('tbl_tickets.delete_notes IS NULL');  
		$this->db->where('tbl_tickets.is_hold', 0);
		$this->db->where('tbl_tickets.IsInBound', 0);
				
        // 	if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        //	if( !empty($_REQUEST['search']['value']) ){
		//	$search_value = $_REQUEST['search']['value'];
		if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T")', $s[$i]);
						$this->db->or_like('tbl_company.CompanyName', $s[$i]);
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]);
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_tickets.driver_id', $s[$i]);
						$this->db->or_like('tbl_tickets.DriverName', $s[$i]);
						$this->db->or_like('tbl_tickets.RegNumber', $s[$i]); 
						$this->db->or_like('tbl_tickets.TypeOfTicket', $s[$i]);
						$this->db->or_like('tbl_tickets.GrossWeight', $s[$i]);
						$this->db->or_like('tbl_tickets.Tare', $s[$i]);
						$this->db->or_like('tbl_tickets.Net', $s[$i]); 
					$this->db->group_end();

				}
			}   
			//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows(); 
        }
		$this->db->group_by("tbl_tickets.TicketNo ");  
		if($columnName == 'TicketDate'){
			//$this->db->order_by(DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S"), $columnSortOrder);
			$this->db->order_by('tbl_tickets.TicketNo', $columnSortOrder);			
		}else if($columnName == 'TicketNumber'){
			$this->db->order_by('tbl_tickets.TicketNumber', $columnSortOrder);			
		}else{
			$this->db->order_by($columnName, $columnSortOrder);			
		} 	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		//echo $this->db->last_query();
		//exit;
        $query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		
		//print_r($query->result_array());
		//exit;
		
        //Reset Key Array
        $data = array();
		//$data = $query->result_array();
        foreach ($query->result_array() as $val) {
                $data[] = $val;
				//$data[] = array_values($val);
        } 
		  
		###################################################
		/*
		$this->db->select('count(*) as ticket_count'); 	
		$this->db->from('tbl_tickets');    	
		$this->db->where('tbl_tickets.delete_notes',NULL);			   
		$this->db->where('tbl_tickets.is_hold', 0);
		$this->db->where('tbl_tickets.IsInBound', 0); 
		$query = $this->db->get();
		$row = $query->row_array();   
		$totalData  = $row['ticket_count'];
		*/
		$totalData  = $this->db->get('tbl_tickets')->num_rows(); //count($data);
        $totalFiltered =  $totalData; 
		
		###################################################
		
        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data //$query->result_array() //$data  // total data array
        );

        return $return;

        }
		
		public function GetTmlTicketData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 
			
			$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');  	
			$this->db->select(' tbl_tickets.TicketNumber as TicketNumber_sort ');  	 		
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T") as TicketDate ');  	 	
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  	
			$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_tickets.CompanyID ) as CompanyName '); 
			$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID ) as OpportunityName '); 
			$this->db->select(' tbl_tickets.driver_id ');  	
			$this->db->select(' tbl_tickets.Conveyance '); 
			$this->db->select(' tbl_tickets.RegNumber ');  	
			$this->db->select(' tbl_tickets.DriverName ');  	
			$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
			$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
			$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
			$this->db->select(' tbl_tickets.TypeOfTicket '); 
			$this->db->select(' tbl_tickets.CompanyID '); 
			$this->db->select(' tbl_tickets.OpportunityID '); 
			$this->db->select(' tbl_tickets.TicketNo '); 
			$this->db->select(' tbl_tickets.pdf_name '); 
			$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID'); 		
			$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 		
			$this->db->where('tbl_tickets.delete_notes IS NULL'); 
			$this->db->where('tbl_tickets.is_tml', '1');		
			$this->db->where('tbl_tickets.is_hold', '0');		
			$this->db->where('tbl_tickets.IsInBound', '0');		
			// if there is a search parameter, $_REQUEST['search']['value'] contains search parameter 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
						$this->db->group_start();		
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T")', $s[$i]);
						$this->db->or_like('tbl_company.CompanyName', $s[$i]);
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]);
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_tickets.driver_id', $s[$i]);
						$this->db->or_like('tbl_tickets.DriverName', $s[$i]);
						$this->db->or_like('tbl_tickets.RegNumber', $s[$i]); 
						$this->db->or_like('tbl_tickets.TypeOfTicket', $s[$i]);
						$this->db->or_like('tbl_tickets.GrossWeight', $s[$i]);
						$this->db->or_like('tbl_tickets.Tare', $s[$i]);
						$this->db->or_like('tbl_tickets.Net', $s[$i]); 
						$this->db->group_end();
					}	
				}		
				$this->db->stop_cache();

				//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows();
			}
			$this->db->group_by("tbl_tickets.TicketNo "); 
			$this->db->stop_cache();
			  
			if($columnName == 'TicketDate'){ 
				$this->db->order_by('tbl_tickets.TicketNo', $columnSortOrder);			
			}else if($columnName == 'TicketNumber'){
				$this->db->order_by('tbl_tickets.TicketNumber', $columnSortOrder);			
			}else{
				$this->db->order_by($columnName, $columnSortOrder);			
			} 
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_tickets');

			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			
			
			###################################################
			/*
			$this->db->select('count(*) as ticket_count'); 	
			$this->db->from('tbl_tickets');    	
			$this->db->where('tbl_tickets.delete_notes',NULL);			   
			$this->db->where('tbl_tickets.is_tml', '1');		
			$this->db->where('tbl_tickets.is_hold', '0');		
			$this->db->where('tbl_tickets.IsInBound', '0');		
			$query = $this->db->get();
			$row = $query->row_array();   
			$totalData  = $row['ticket_count'];
			*/
			$totalData  = $this->db->get('tbl_tickets')->num_rows();
			$totalFiltered =  $totalData; 
			
			###################################################
	 		
///			$totalData  = $this->db->get('tbl_tickets')->num_rows();
///			$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        }
		public function GetHoldTicketData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 
			
			$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');  	
			$this->db->select(' tbl_tickets.TicketNumber as TicketNumber_sort ');  	 		
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T") as TicketDate ');  	 	
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  	
			$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_tickets.CompanyID ) as CompanyName '); 
			$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID ) as OpportunityName '); 
			$this->db->select(' tbl_tickets.driver_id ');  	
			$this->db->select(' tbl_tickets.Conveyance '); 
			$this->db->select(' tbl_tickets.RegNumber ');  	
			$this->db->select(' tbl_tickets.DriverName ');  	
			$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
			$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
			$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
			$this->db->select(' tbl_tickets.TypeOfTicket '); 
			$this->db->select(' tbl_tickets.CompanyID '); 
			$this->db->select(' tbl_tickets.OpportunityID '); 
			$this->db->select(' tbl_tickets.TicketNo '); 
			$this->db->select(' tbl_tickets.pdf_name '); 
			$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID'); 		
			$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 		
			$this->db->where('tbl_tickets.delete_notes IS NULL'); 
			$this->db->where('tbl_tickets.is_hold', '1');	
			$this->db->where('tbl_tickets.IsInBound', '0');				
			
			// if there is a search parameter, $_REQUEST['search']['value'] contains search parameter 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start(); 
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T")', $s[$i]);
						$this->db->or_like('tbl_company.CompanyName', $s[$i]);
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]);
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_tickets.driver_id', $s[$i]);
						$this->db->or_like('tbl_tickets.DriverName', $s[$i]);
						$this->db->or_like('tbl_tickets.RegNumber', $s[$i]); 
						$this->db->or_like('tbl_tickets.TypeOfTicket', $s[$i]);
						$this->db->or_like('tbl_tickets.GrossWeight', $s[$i]);
						$this->db->or_like('tbl_tickets.Tare', $s[$i]);
						$this->db->or_like('tbl_tickets.Net', $s[$i]); 
						$this->db->group_end(); 
					}
				}  
				$this->db->stop_cache();

				//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows();
			}
			$this->db->group_by("tbl_tickets.TicketNo "); 
			$this->db->stop_cache();
			  
			if($columnName == 'TicketDate'){ 
				$this->db->order_by('tbl_tickets.TicketNo', $columnSortOrder);			
			}else if($columnName == 'TicketNumber'){
				$this->db->order_by('tbl_tickets.TicketNumber', $columnSortOrder);			
			}else{
				$this->db->order_by($columnName, $columnSortOrder);			
			} 
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_tickets');

			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			
			###################################################
			/*
			$this->db->select('count(*) as ticket_count'); 	
			$this->db->from('tbl_tickets');    	
			$this->db->where('tbl_tickets.delete_notes',NULL);			   
			$this->db->where('tbl_tickets.is_hold', '1');	
			$this->db->where('tbl_tickets.IsInBound', '0');				
			$query = $this->db->get();
			$row = $query->row_array();   
			$totalData  = $row['ticket_count'];
			*/
			$totalData  = $this->db->get('tbl_tickets')->num_rows();
			$totalFiltered =  $totalData; 
			
			###################################################
			
			//$totalData  = $this->db->get('tbl_tickets')->num_rows();
			//$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        }
		
		public function GetInboundTicketData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 
			
			$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');  	
			$this->db->select(' tbl_tickets.TicketNumber as TicketNumber_sort ');  	 		
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T") as TicketDate ');  	 	
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  	
			$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_tickets.CompanyID ) as CompanyName '); 
			$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID ) as OpportunityName '); 
			$this->db->select(' tbl_tickets.driver_id ');  
			$this->db->select(' tbl_tickets.Conveyance '); 			
			$this->db->select(' tbl_tickets.RegNumber ');  	
			$this->db->select(' tbl_tickets.DriverName ');  	
			$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
			$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
			$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
			$this->db->select(' tbl_tickets.TypeOfTicket '); 
			$this->db->select(' tbl_tickets.CompanyID '); 
			$this->db->select(' tbl_tickets.OpportunityID '); 
			$this->db->select(' tbl_tickets.TicketNo '); 
			$this->db->select(' tbl_tickets.pdf_name '); 
			$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID'); 		
			$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 		
			$this->db->where('tbl_tickets.delete_notes IS NULL');  
			$this->db->where('tbl_tickets.IsInBound', '1');				
			
			// if there is a search parameter, $_REQUEST['search']['value'] contains search parameter 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start(); 
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T")', $s[$i]);
						$this->db->or_like('tbl_company.CompanyName', $s[$i]);
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_tickets.driver_id', $s[$i]);
						$this->db->or_like('tbl_tickets.DriverName', $s[$i]);
						$this->db->or_like('tbl_tickets.RegNumber', $s[$i]); 
						$this->db->or_like('tbl_tickets.TypeOfTicket', $s[$i]);
						$this->db->or_like('tbl_tickets.GrossWeight', $s[$i]);
						$this->db->or_like('tbl_tickets.Tare', $s[$i]);
						$this->db->or_like('tbl_tickets.Net', $s[$i]); 
						$this->db->group_end(); 
					}
				}  
				$this->db->stop_cache();

				//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows();
			}
			$this->db->group_by("tbl_tickets.TicketNo "); 
			$this->db->stop_cache();
			  
			if($columnName == 'TicketDate'){ 
				$this->db->order_by('tbl_tickets.TicketNo', $columnSortOrder);			
			}else if($columnName == 'TicketNumber'){
				$this->db->order_by('tbl_tickets.TicketNumber', $columnSortOrder);			
			}else{
				$this->db->order_by($columnName, $columnSortOrder);			
			} 
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_tickets');

			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			
			
			###################################################
			/*
			$this->db->select('count(*) as ticket_count'); 	
			$this->db->from('tbl_tickets');    	
			$this->db->where('tbl_tickets.delete_notes',NULL);			   
			$this->db->where('tbl_tickets.IsInBound', '1');				
			$query = $this->db->get();
			$row = $query->row_array();   
			$totalData  = $row['ticket_count'];
			*/
			$totalData  = $this->db->get('tbl_tickets')->num_rows();
			$totalFiltered =  $totalData; 
			
			###################################################
			
			//$totalData  = $this->db->get('tbl_tickets')->num_rows();
			//$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        }
		
		public function GetDeleteTicketData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 
			
			$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');  	
			$this->db->select(' tbl_tickets.TicketNumber as TicketNumber_sort ');  	 		
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T") as TicketDate ');  	 	
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  	
			$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_tickets.CompanyID ) as CompanyName '); 
			$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID ) as OpportunityName ');  
			$this->db->select(' tbl_tickets.RegNumber ');  	 
 			$this->db->select(' tbl_tickets.TypeOfTicket '); 
			$this->db->select(' tbl_tickets.CompanyID '); 
			$this->db->select(' tbl_tickets.OpportunityID '); 
			$this->db->select(' tbl_tickets.TicketNo '); 
			$this->db->select(' tbl_tickets.pdf_name '); 
			$this->db->select(' tbl_tickets.delete_notes '); 
			$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID'); 		
			$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 		 
			$this->db->where('tbl_tickets.delete_notes <> ""'); 	 
			$this->db->where('tbl_tickets.is_hold', '0');	
			$this->db->where('tbl_tickets.IsInBound', '0');				
			// if there is a search parameter, $_REQUEST['search']['value'] contains search parameter 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start(); 
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T")', $s[$i]);
						$this->db->or_like('tbl_company.CompanyName', $s[$i]);
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_tickets.driver_id', $s[$i]);
						$this->db->or_like('tbl_tickets.DriverName', $s[$i]);
						$this->db->or_like('tbl_tickets.RegNumber', $s[$i]); 
						$this->db->or_like('tbl_tickets.TypeOfTicket', $s[$i]);
						$this->db->or_like('tbl_tickets.GrossWeight', $s[$i]);
						$this->db->or_like('tbl_tickets.Tare', $s[$i]);
						$this->db->or_like('tbl_tickets.Net', $s[$i]); 
						$this->db->group_end();

					}
				}  
				$this->db->stop_cache();

				//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows();
			}
			$this->db->group_by("tbl_tickets.TicketNo "); 
			$this->db->stop_cache();
			  
			if($columnName == 'TicketDate'){ 
				$this->db->order_by('tbl_tickets.TicketNo', $columnSortOrder);			
			}else if($columnName == 'TicketNumber'){
				$this->db->order_by('tbl_tickets.TicketNumber', $columnSortOrder);			
			}else{
				$this->db->order_by($columnName, $columnSortOrder);			
			} 
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			
			$query = $this->db->get('tbl_tickets');
			$this->db->stop_cache();
			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			
			
			###################################################
			/* $this->db->start_cache(); 
			$this->db->select('count(*) as ticket_count'); 	
			$this->db->from('tbl_tickets');    	
			$this->db->where('tbl_tickets.delete_notes <> ""'); 	 
			$this->db->where('tbl_tickets.is_hold', '0');	
			$this->db->where('tbl_tickets.IsInBound', '0');				
			$query = $this->db->get();
			$this->db->stop_cache();
			$row = $query->row_array();   
			$totalData  = $row['ticket_count'];
			*/
			
			$totalData  = $this->db->get('tbl_tickets')->num_rows();
			$totalFiltered =  $totalData; 
			
			###################################################
			
			//$totalData  = $this->db->get('tbl_tickets')->num_rows();
			//$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        }
 
}

  