<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class CustomerTickets_model extends CI_Model
{ 
	  
	public function GetTicketData($AccRef){

		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
   
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		//$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');  	
		$this->db->select(' tbl_tickets.TicketNumber as TicketNumber ');  	
		$this->db->select(' tbl_tickets.TicketNumber as TicketNumber_sort ');  	 		
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T") as TicketDate ');  	 	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  	 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID ) as OpportunityName '); 	
		$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
		$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
		$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
		$this->db->select(' tbl_tickets.TypeOfTicket ');  
		$this->db->select(' tbl_tickets.OpportunityID '); 
		$this->db->select(' tbl_tickets.Conveyance '); 
		$this->db->select(' tbl_tickets.TicketNo '); 
		$this->db->select(' tbl_tickets.pdf_name ');  
		$this->db->select(' tbl_tickets.LoadID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID'); 		
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 		 
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 	 
		$this->db->where('tbl_tickets.delete_notes IS NULL');  
		$this->db->where('tbl_tickets.is_hold', 0);
		$this->db->where('tbl_tickets.IsInBound', 0);
		if($AccRef!='admin'){
			$this->db->where('tbl_company.AccountRef',$AccRef);
		}
			 
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
		 
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
	//	echo $this->db->last_query();
	//	exit;
        //Reset Key Array
        $data = array();
		$data = $query->result_array();
		$totalData  = $this->db->count_all_results();
		$totalFiltered =  $totalData; 
		 
        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data //$query->result_array() //$data  // total data array
        );

        return $return;

    }
	 
}

  