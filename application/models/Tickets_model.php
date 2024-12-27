<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tickets_model extends CI_Model
{ 
    	function BookingLoadInfo($ConveyanceNo){
			$this->db->select('tbl_booking_loads1.LoadID');  
			$this->db->select('tbl_booking_loads1.Status');   
			$this->db->select('tbl_booking_loads1.ConveyanceNo');     
			$this->db->select('tbl_booking_loads1.DriverName');   
			$this->db->select('tbl_booking_loads1.VehicleRegNo');     
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %H:%i") as SIDateTime ');  
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %H:%i") as SODateTime ');  
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y %H:%i") as JSDateTime ');  
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d-%m-%Y %H:%i") as JEDateTime ');  
			
			$this->db->select('tbl_booking1.LoadType');   
			$this->db->select('tbl_booking1.LorryType');   	
			$this->db->select('tbl_booking1.BookingType');     
			$this->db->select('tbl_booking_loads1.MaterialID');  
			$this->db->select(' tbl_materials.MaterialName ');	 		
			$this->db->select(' tbl_materials.SicCode ');	 
			$this->db->select(' tbl_booking_request.CompanyName ');  
			$this->db->select(' tbl_booking_request.CompanyID '); 			
			$this->db->select(' tbl_booking_request.OpportunityName ');	 
			$this->db->select(' tbl_booking_request.OpportunityID ');	 
			$this->db->select(' tbl_tipaddress.TipName ');	  
			$this->db->select(' tbl_drivers.Haulier ');	  
			$this->db->select(' tbl_drivers.LorryNo ');
			$this->db->select(' tbl_drivers.Tare ');
			
			$this->db->select(' tbl_drivers_login.ltsignature ');
			
			$this->db->from('tbl_booking_loads1'); 
			$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ',"LEFT");  
			$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ',"LEFT");  
			$this->db->join(' tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo  ',"LEFT");   
			$this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ',"LEFT"); 
			$this->db->join(' tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ',"LEFT");   
			$this->db->join(' tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ',"LEFT");   
			$this->db->where('tbl_booking_loads1.ConveyanceNo  ',$ConveyanceNo );		
			$this->db->where('tbl_booking_loads1.TipID > 1 ' );		
			$this->db->where('tbl_booking_loads1.TicketID = 0 ' );	
			$this->db->where('tbl_booking_loads1.Status = 4 ' );	
			$this->db->where('tbl_booking1.BookingType = 1 ' );	
			 
			$query = $this->db->get(); 
			//echo $this->db->last_query();
			//exit;
			return $query->row();
			//return $query->row_array();
		}
		function BookingLoadInfo1($ConveyanceNo){
			$this->db->select('tbl_tickets.TicketNumber');  
			$this->db->select('tbl_booking_loads1.LoadID');  
			$this->db->select('tbl_booking_loads1.Status');   
			$this->db->select('tbl_booking_loads1.ConveyanceNo');     
			$this->db->select('tbl_booking_loads1.DriverName');   
			$this->db->select('tbl_booking_loads1.VehicleRegNo');     
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %H:%i") as SIDateTime ');  
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %H:%i") as SODateTime ');  
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y %H:%i") as JSDateTime ');  
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d-%m-%Y %H:%i") as JEDateTime ');  
			
			$this->db->select('tbl_booking1.LoadType');   
			$this->db->select('tbl_booking1.LorryType');   	
			$this->db->select('tbl_booking1.BookingType');     
			$this->db->select(' tbl_materials.MaterialName ');	 		
			$this->db->select(' tbl_materials.SicCode ');	 
			$this->db->select(' tbl_booking_request.CompanyName ');    
			$this->db->select(' tbl_booking_request.OpportunityName ');	 
			$this->db->select(' tbl_tipaddress.TipName ');	  
			$this->db->select(' tbl_drivers.Haulier ');	  
			$this->db->select(' tbl_drivers.LorryNo ');
			$this->db->select(' tbl_drivers.Tare ');
			$this->db->from('tbl_booking_loads1'); 
			
			$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ',"LEFT");  
			$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ',"LEFT");  
			$this->db->join(' tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo  ',"LEFT");   
			$this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ',"LEFT"); 
			$this->db->join(' tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ',"LEFT");   
			$this->db->join(' tbl_tickets', 'tbl_booking_loads1.ConveyanceNo = tbl_tickets.Conveyance and 
			tbl_booking_request.CompanyID = tbl_tickets.CompanyID AND tbl_booking_request.OpportunityID = tbl_tickets.OpportunityID AND 
			tbl_booking_loads1.DriverID = tbl_tickets.driver_id AND tbl_booking_loads1.MaterialID = tbl_tickets.MaterialID  
			AND  tbl_tickets.TypeOfTicket = "In" ',"LEFT");    
			$this->db->where('tbl_booking_loads1.ConveyanceNo  ',$ConveyanceNo );		
			$this->db->where('tbl_booking_loads1.TipID = 1 ' );		
			$this->db->where('tbl_booking_loads1.TicketID = 0 ' );	
			$this->db->where('tbl_booking_loads1.Status = 4 ' );	
			$this->db->where('tbl_booking1.BookingType = 1 ' );	
			 
			$query = $this->db->get(); 
			//echo $this->db->last_query();
			//exit;
			return $query->row();
			//return $query->row_array();
		}
		

	function CountInCompletedTicketsPDF(){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_tickets');   
		$this->db->where(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y-%m-%d") <> DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');   
		$this->db->where('tbl_tickets.TypeOfTicket','In'); 
		$this->db->where('tbl_tickets.GridUpdate','1'); 
		$this->db->where('tbl_tickets.GrossWeight > 0 '); 
		$this->db->where('tbl_tickets.Tare > 0 ');
		$this->db->where('tbl_tickets.Net > 0 '); 
		$this->db->group_start();  
		$this->db->where(' tbl_tickets.pdf_name = "" '); 		
		$this->db->or_where('  tbl_tickets.pdf_name = ".pdf"  '); 		
		$this->db->group_end();   
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit;
		return $query->result_array();
	}
	
	function CountHoldTicketsPDF(){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_tickets');     
		$this->db->where('tbl_tickets.TypeOfTicket','Out'); 
		$this->db->where('tbl_tickets.GridUpdate','1'); 
		$this->db->where('tbl_tickets.GrossWeight > 0 '); 
		$this->db->where('tbl_tickets.Tare > 0 ');
		$this->db->where('tbl_tickets.Net > 0 '); 
		$this->db->group_start();  
		$this->db->where(' tbl_tickets.pdf_name = "" '); 		
		$this->db->or_where('  tbl_tickets.pdf_name = ".pdf"  '); 		
		$this->db->group_end();   
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit;
		return $query->result_array();
	}
	
	function CountInBoundTicketsPDF(){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_tickets');   
		$this->db->where(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y-%m-%d") = DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');   
		$this->db->where('tbl_tickets.GridUpdate','1'); 
		$this->db->where('tbl_tickets.GrossWeight > 0 '); 
		$this->db->where('tbl_tickets.Tare > 0 ');
		$this->db->where('tbl_tickets.Net > 0 '); 
		$this->db->group_start();  
		$this->db->where(' tbl_tickets.pdf_name = "" '); 		
		$this->db->or_where('  tbl_tickets.pdf_name = ".pdf"  '); 		
		$this->db->group_end();   
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit;
		return $query->result_array();
	}
	function GetPendingHoldPDFTickets(){ 
		$this->db->select('tbl_tickets.TicketNo , tbl_tickets.TicketNumber ,tbl_tickets.TicketUniqueID, tbl_booking_loads1.DriverLoginID ' );   
        $this->db->from('tbl_tickets');  
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID','LEFT'); 		
		$this->db->where('tbl_tickets.TypeOfTicket','Out'); 
		$this->db->where('tbl_tickets.GridUpdate','1'); 
		$this->db->where('tbl_tickets.GrossWeight > 0 '); 
		$this->db->where('tbl_tickets.Tare > 0 ');
		$this->db->where('tbl_tickets.Net > 0 ');
		$this->db->group_start();  
		$this->db->where(' tbl_tickets.pdf_name = "" '); 		
		$this->db->or_where('  tbl_tickets.pdf_name = ".pdf"  '); 		
		$this->db->group_end();   
		$this->db->order_by('TicketNo', 'ASC'); 
		//$this->db->limit(10);
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//exit;
		return $query->result();        
	}
	function GetPendingPDFTickets(){ 
		$this->db->select('tbl_tickets.TicketNo , tbl_tickets.TicketNumber ,tbl_tickets.TicketUniqueID, tbl_booking_loads1.DriverLoginID ' );   
        $this->db->from('tbl_tickets');  
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID','LEFT'); 		
		$this->db->where('tbl_tickets.TypeOfTicket','In'); 
		$this->db->where('tbl_tickets.GridUpdate','1'); 
		$this->db->where('tbl_tickets.GrossWeight > 0 '); 
		$this->db->where('tbl_tickets.Tare > 0 ');
		$this->db->where('tbl_tickets.Net > 0 ');
		$this->db->group_start();  
		$this->db->where(' tbl_tickets.pdf_name = "" '); 		
		$this->db->or_where('  tbl_tickets.pdf_name = ".pdf"  '); 		
		$this->db->group_end();   
		$this->db->order_by('TicketNo', 'ASC'); 
		//$this->db->limit(10);
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//exit;
		return $query->result();        
	}
	 
	function LastTicketDate($TicketNumber){ 
		$this->db->select('DATE_ADD(tbl_tickets.TicketDate, INTERVAL 1 MINUTE) as TicketDate' );   
        $this->db->from('tbl_tickets');    
		$this->db->where('tbl_tickets.TicketNumber',$TicketNumber); 		  
		
		$this->db->where('tbl_tickets.delete_notes IS NULL');  
		$this->db->where('tbl_tickets.is_hold', 0);
		$this->db->where('tbl_tickets.IsInBound', 0);
		$this->db->where('tbl_tickets.GrossWeight > 0');
		
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

	function InCompletedTicketDetails($TicketID){
		$this->db->select('tbl_tickets.*');  
		$this->db->select(' DATE_FORMAT(TicketDate,"%d-%m-%Y %H%i") as TicketDate1 ');  		
        $this->db->from('tbl_tickets'); 
        $this->db->where('tbl_tickets.TicketNo',$TicketID);		
		$query = $this->db->get(); 
		return $query->row_array();
	}
	function getBookingNote($LoadID){
		$this->db->select('tbl_booking_request.Notes');   
        $this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID  = tbl_booking_request.BookingRequestID ','LEFT'); 
        $this->db->where('tbl_booking_loads1.LoadID',$LoadID);		
		$query = $this->db->get(); 
		return $query->row_array();
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
        $this->db->select('o.OpportunityID , o.OpportunityName, o.Status');
        $this->db->from('opportunities as o');        
        $this->db->join('company_to_opportunities as cto', 'o.OpportunityID = cto.OpportunityID ',"LEFT");        
        $this->db->where('cto.CompanyID', $CompanyID);
		$this->db->where('o.OpportunityName <> "" ');
		$this->db->where('o.Status = "1" ');
		$this->db->where('o.OpportunityName <> ",,," ');
		$this->db->group_by("o.OpportunityID "); 
		$this->db->order_by('o.OpportunityName', 'ASC');
        $query = $this->db->get();        
        $result = $query->result();        
        return $result;
    }
	function getAllOpportunitiesByCompany1($CompanyID)
    {
        $this->db->select('o.OpportunityID , o.OpportunityName, o.Status');
        $this->db->from('opportunities as o');        
        $this->db->join('company_to_opportunities as cto', 'o.OpportunityID = cto.OpportunityID ',"LEFT");        
        $this->db->where('cto.CompanyID', $CompanyID);
		$this->db->where('o.OpportunityName <> "" ');
		//$this->db->where('o.Status = "1" ');
		$this->db->where('o.OpportunityName <> ",,," ');
		$this->db->group_by("o.OpportunityID "); 
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
	function CheckDuplicateRegNo($RegNumber){
        $this->db->select('RegNumber');
        $this->db->from('tbl_drivers');         
        $this->db->where('RegNumber', $RegNumber); 
        $query = $this->db->get();           
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
		//$this->db->where('Status', '1');
        $this->db->order_by('MaterialName', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	function getMaterialList2($operation){
        $this->db->select('*');
        $this->db->from('materials');
        $this->db->where('Operation', $operation);
		$this->db->where('Status', '1');
        $this->db->order_by('MaterialName', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    function getMaterialList3($operation){
        $this->db->select('*');
        $this->db->from('materials');
		$operation = array('OUT', 'COLLECTION'); 
        $this->db->where_in('Operation', $operation);
		$this->db->where('Status', '1');
        $this->db->order_by('MaterialName', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	function getMaterialList1($operation){
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
 
	function getSignature($id){
       $this->db->select('tbl_drivers_login.ltsignature');
       $this->db->from('tbl_drivers_login'); 
       $this->db->where('tbl_drivers_login.DriverID',$id); 
       $query = $this->db->get();
       $result = $query->result();        
       return $result[0]->ltsignature; 
    }
    function getLorryNo(){
       $this->db->select('LorryNo,DriverName,RegNumber,Haulier');
       $this->db->from('drivers');
       //$this->db->where('DriverName <> ""');
       $this->db->where('RegNumber <> ""');
	   
       $query = $this->db->get();
       $result = $query->result();        
       return $result; 
    }
	function getLorryNoTML(){ 
       $this->db->select('tbl_drivers.LorryNo,tbl_drivers.RegNumber');
       $this->db->from('tbl_drivers');  
       $this->db->where('tbl_drivers.RegNumber <> ""'); 
	   $this->db->where('tbl_drivers.ContractorID','1');  
       $query = $this->db->get();
       $result = $query->result();        
       return $result; 
    }
    function getLorryNoDetails($id){
       $this->db->select('tbl_drivers.LorryNo');
	   $this->db->select('tbl_drivers.DriverName');
	   //$this->db->select('tbl_drivers_login.DriverName as Dname');
	   $this->db->select('tbl_drivers.RegNumber');
	   $this->db->select('tbl_drivers.Tare');
	   $this->db->select('tbl_drivers.Haulier');
	   $this->db->select('tbl_drivers.ltsignature');
	   //$this->db->select('tbl_drivers.DriverID');
       $this->db->from('tbl_drivers');
	   //$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID','LEFT' ); 
       $this->db->where('tbl_drivers.LorryNo', $id);
       $query = $this->db->get();
       $result = $query->row();        
        return $result; 
    }
	
	/*function getLorryNoDetails($id){
       $this->db->select('*');
       $this->db->from('drivers');
       $this->db->where('LorryNo', $id);
       $query = $this->db->get();
       $result = $query->row();        
        return $result; 
    }*/
	
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
	function TEST(){
       echo "<br>".$totalData  = $this->db->get('tbl_tickets')->num_rows(); //count($data);
	   echo "<br>".$totalData  = $this->db->count_all('tbl_tickets');
	   echo "<br>".$this->db->count_all_results();
	}
	 
	public function GetTicketData(){

		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
   
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
		$this->db->select(' tbl_booking_loads.ReceiptName '); 
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_booking_loads', 'tbl_tickets.LoadID = tbl_booking_loads.LoadID',"LEFT"); 		
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
		 
        //Reset Key Array
        $data = array();
		$data = $query->result_array();
		$totalData  = $this->db->count_all_results();
		$totalFiltered =  $totalData; 
		
        //foreach ($query->result_array() as $val) {
        //        $data[] = $val;
		//		//$data[] = array_values($val);
        //}  
		//$totalData  = $this->db->get('tbl_tickets')->num_rows();    
		//$totalFiltered =  $totalData; 
		  
        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data //$query->result_array() //$data  // total data array
        );

        return $return;

        }
		
		public function GetAllTicketData(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }  
			if($Sort[0]=='Conveyance'){ $columnName = 'tbl_tickets.Conveyance '; } 
			if($Sort[0]=='driver_id'){ $columnName = 'tbl_tickets.driver_id '; } 
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; } 
			if($Sort[0]=='DriverName'){ $columnName = 'tbl_tickets.DriverName '; } 
			if($Sort[0]=='GrossWeight'){ $columnName = 'tbl_tickets.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_tickets.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_tickets.Net '; } 
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));  
		$Conveyance = trim(strtolower($_POST['Conveyance']));  
		$driver_id = trim(strtolower($_POST['driver_id']));  
		$RegNumber = trim(strtolower($_POST['RegNumber']));  
		$DriverName = trim(strtolower($_POST['DriverName']));  
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));  
		$Tare = trim(strtolower($_POST['Tare']));  
		$Net = trim(strtolower($_POST['Net']));  
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));    
		$Reservation = trim(strtolower($_POST['reservation']));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation!=""){
			$RS = explode('-',$Reservation);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
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
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->select(' tbl_tickets_documents.ID  as DOCID '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		
		$this->db->join('tbl_tickets_documents', 'tbl_tickets.TicketNumber = tbl_tickets_documents.FD_16EB2AD9 AND tbl_tickets_documents.DocTypeID = "1036437d" ','LEFT'); 		 
		$this->db->where('tbl_tickets.delete_notes IS NULL');  
		$this->db->where('tbl_tickets.is_hold', 0);
		$this->db->where('tbl_tickets.IsInBound', 0);
		$this->db->where('tbl_tickets.TicketDate > ( DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH,"%Y-%m-01"))' );		 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %T")', $s[$i]);
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
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_tickets.TicketDate) >=', $StartDate);
			$this->db->where('DATE(tbl_tickets.TicketDate) <=', $EndDate); 
 			//$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Conveyance)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.Conveyance ', trim($Conveyance)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($driver_id)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.driver_id', trim($driver_id)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Net', trim($Net)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
        
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
		public function GetAllTicketDataArchived(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }  
			if($Sort[0]=='Conveyance'){ $columnName = 'tbl_tickets.Conveyance '; } 
			if($Sort[0]=='driver_id'){ $columnName = 'tbl_tickets.driver_id '; } 
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; } 
			if($Sort[0]=='DriverName'){ $columnName = 'tbl_tickets.DriverName '; } 
			if($Sort[0]=='GrossWeight'){ $columnName = 'tbl_tickets.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_tickets.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_tickets.Net '; } 
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));  
		$Conveyance = trim(strtolower($_POST['Conveyance']));  
		$driver_id = trim(strtolower($_POST['driver_id']));  
		$RegNumber = trim(strtolower($_POST['RegNumber']));  
		$DriverName = trim(strtolower($_POST['DriverName']));  
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));  
		$Tare = trim(strtolower($_POST['Tare']));  
		$Net = trim(strtolower($_POST['Net']));  
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));    
		$Reservation = trim(strtolower($_POST['reservation']));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation!=""){
			$RS = explode('-',$Reservation);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
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
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->select(' tbl_tickets_documents.ID  as DOCID '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		
		$this->db->join('tbl_tickets_documents', 'tbl_tickets.TicketNumber = tbl_tickets_documents.FD_16EB2AD9 AND tbl_tickets_documents.DocTypeID = "1036437d" ','LEFT'); 		 
		$this->db->where('tbl_tickets.delete_notes IS NULL');  
		$this->db->where('tbl_tickets.is_hold', 0);
		$this->db->where('tbl_tickets.IsInBound', 0);
		$this->db->where('tbl_tickets.TicketDate < ( DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH,"%Y-%m-01"))' );
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %T")', $s[$i]);
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
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_tickets.TicketDate) >=', $StartDate);
			$this->db->where('DATE(tbl_tickets.TicketDate) <=', $EndDate); 
 			//$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Conveyance)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.Conveyance ', trim($Conveyance)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($driver_id)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.driver_id', trim($driver_id)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Net', trim($Net)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
        
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
		public function GetTmlTicketData(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }  
			if($Sort[0]=='Conveyance'){ $columnName = 'tbl_tickets.Conveyance '; } 
			if($Sort[0]=='driver_id'){ $columnName = 'tbl_tickets.driver_id '; } 
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; } 
			if($Sort[0]=='DriverName'){ $columnName = 'tbl_tickets.DriverName '; } 
			if($Sort[0]=='GrossWeight'){ $columnName = 'tbl_tickets.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_tickets.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_tickets.Net '; } 
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));  
		$Conveyance = trim(strtolower($_POST['Conveyance']));  
		$driver_id = trim(strtolower($_POST['driver_id']));  
		$RegNumber = trim(strtolower($_POST['RegNumber']));  
		$DriverName = trim(strtolower($_POST['DriverName']));  
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));  
		$Tare = trim(strtolower($_POST['Tare']));  
		$Net = trim(strtolower($_POST['Net']));  
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));   
        
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
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
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		
		$this->db->where('tbl_tickets.delete_notes IS NULL'); 
		$this->db->where('tbl_tickets.is_tml', '1');		
		$this->db->where('tbl_tickets.is_hold', '0');		
		$this->db->where('tbl_tickets.IsInBound', '0');		
		$this->db->where('tbl_tickets.TicketDate > ( DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH,"%Y-%m-01"))' );		 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %T")', $s[$i]);
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
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Conveyance)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.Conveyance ', trim($Conveyance)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($driver_id)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.driver_id', trim($driver_id)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Net', trim($Net)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		//echo $this->db->last_query();
		//exit;
        
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
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
		public function GetTmlTicketDataArchived(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }  
			if($Sort[0]=='Conveyance'){ $columnName = 'tbl_tickets.Conveyance '; } 
			if($Sort[0]=='driver_id'){ $columnName = 'tbl_tickets.driver_id '; } 
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; } 
			if($Sort[0]=='DriverName'){ $columnName = 'tbl_tickets.DriverName '; } 
			if($Sort[0]=='GrossWeight'){ $columnName = 'tbl_tickets.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_tickets.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_tickets.Net '; } 
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));  
		$Conveyance = trim(strtolower($_POST['Conveyance']));  
		$driver_id = trim(strtolower($_POST['driver_id']));  
		$RegNumber = trim(strtolower($_POST['RegNumber']));  
		$DriverName = trim(strtolower($_POST['DriverName']));  
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));  
		$Tare = trim(strtolower($_POST['Tare']));  
		$Net = trim(strtolower($_POST['Net']));  
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));   
        
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
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
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		
		$this->db->where('tbl_tickets.delete_notes IS NULL'); 
		$this->db->where('tbl_tickets.is_tml', '1');		
		$this->db->where('tbl_tickets.is_hold', '0');		
		$this->db->where('tbl_tickets.IsInBound', '0');		
		$this->db->where('tbl_tickets.TicketDate < ( DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH,"%Y-%m-01"))' );
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %T")', $s[$i]);
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
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Conveyance)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.Conveyance ', trim($Conveyance)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($driver_id)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.driver_id', trim($driver_id)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Net', trim($Net)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		//echo $this->db->last_query();
		//exit;
        
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
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
		public function GetTmlTicketData___OLD(){

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
			$this->db->select(' tbl_drivers_login.DriverName as LoginDriverName ');  
			$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
			$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
			$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
			$this->db->select(' tbl_tickets.TypeOfTicket '); 
			$this->db->select(' tbl_tickets.CompanyID '); 
			$this->db->select(' tbl_tickets.OpportunityID '); 
			$this->db->select(' tbl_tickets.TicketNo '); 
			$this->db->select(' tbl_tickets.pdf_name '); 
			$this->db->select(' tbl_booking_loads.ReceiptName '); 
			$this->db->select(' tbl_tickets.LoadID '); 
			$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID ','LEFT'); 		
			$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID','LEFT'); 		
			$this->db->join('tbl_booking_loads', 'tbl_tickets.LoadID = tbl_booking_loads.LoadID'); 		
			$this->db->join('tbl_drivers_login', 'tbl_booking_loads.DriverLoginID = tbl_drivers_login.DriverID',"LEFT"); 		
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
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y  %T")', $s[$i]);
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
			$data = $query->result_array();
			$totalData  = $this->db->count_all_results();
			$totalFiltered =  $totalData; 
			
			//foreach ($query->result_array() as $val) {
			//        $data[] = $val;
			//		//$data[] = array_values($val);
			//}  
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
		
		public function GetHoldTicketData(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }  
			if($Sort[0]=='Conveyance'){ $columnName = 'tbl_tickets.Conveyance '; } 
			if($Sort[0]=='driver_id'){ $columnName = 'tbl_tickets.driver_id '; } 
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; } 
			if($Sort[0]=='DriverName'){ $columnName = 'tbl_tickets.DriverName '; } 
			if($Sort[0]=='GrossWeight'){ $columnName = 'tbl_tickets.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_tickets.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_tickets.Net '; } 
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));  
		$Conveyance = trim(strtolower($_POST['Conveyance']));  
		$driver_id = trim(strtolower($_POST['driver_id']));  
		$RegNumber = trim(strtolower($_POST['RegNumber']));  
		$DriverName = trim(strtolower($_POST['DriverName']));  
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));  
		$Tare = trim(strtolower($_POST['Tare']));  
		$Net = trim(strtolower($_POST['Net']));  
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));   
        
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
		$this->db->select(' tbl_tickets.driver_id ');  	
		$this->db->select(' tbl_tickets.Conveyance ');  	
		$this->db->select(' tbl_tickets.RegNumber ');  	
		$this->db->select(' tbl_tickets.DriverName ');  	
		$this->db->select(' tbl_drivers_login.DriverName as LoginDriverName ');  
		$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
		$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
		$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
		$this->db->select(' tbl_tickets.TypeOfTicket '); 
		$this->db->select(' tbl_tickets.CompanyID '); 
		$this->db->select(' tbl_tickets.OpportunityID '); 
		$this->db->select(' tbl_tickets.TicketNo '); 
		$this->db->select(' tbl_tickets.pdf_name '); 
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		 
		$this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID',"LEFT"); 		 
		$this->db->where('tbl_tickets.delete_notes IS NULL'); 
		$this->db->where('tbl_tickets.is_hold', '1');	 
		$this->db->where('tbl_tickets.LoadID', '0');	
		$this->db->where('tbl_tickets.IsInBound', '0');		
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T")', $s[$i]);
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
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Conveyance)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.Conveyance ', trim($Conveyance)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($driver_id)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.driver_id', trim($driver_id)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Net', trim($Net)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		//echo $this->db->last_query();
		//exit;
        
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
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
		
		public function GetDeliveryHoldTicketsData(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }  
			if($Sort[0]=='Conveyance'){ $columnName = 'tbl_tickets.Conveyance '; } 
			if($Sort[0]=='driver_id'){ $columnName = 'tbl_tickets.driver_id '; } 
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; } 
			if($Sort[0]=='DriverName'){ $columnName = 'tbl_tickets.DriverName '; } 
			if($Sort[0]=='GrossWeight'){ $columnName = 'tbl_tickets.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_tickets.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_tickets.Net '; } 
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));  
		$Conveyance = trim(strtolower($_POST['Conveyance']));  
		$driver_id = trim(strtolower($_POST['driver_id']));  
		$RegNumber = trim(strtolower($_POST['RegNumber']));  
		$DriverName = trim(strtolower($_POST['DriverName']));  
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));  
		$Tare = trim(strtolower($_POST['Tare']));  
		$Net = trim(strtolower($_POST['Net']));  
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));   
        
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
		$this->db->select(' tbl_tickets.driver_id ');  	
		$this->db->select(' tbl_tickets.Conveyance ');  	
		$this->db->select(' tbl_tickets.RegNumber ');  	
		$this->db->select(' tbl_tickets.DriverName ');  	
		$this->db->select(' tbl_drivers_login.DriverName as LoginDriverName ');  
		$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
		$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
		$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
		$this->db->select(' tbl_tickets.TypeOfTicket '); 
		$this->db->select(' tbl_tickets.CompanyID '); 
		$this->db->select(' tbl_tickets.OpportunityID '); 
		$this->db->select(' tbl_tickets.TicketNo '); 
		$this->db->select(' tbl_tickets.pdf_name '); 
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->select(' tbl_tickets.MaterialID '); 
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		 
		$this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID',"LEFT"); 		 
		$this->db->join('tbl_materials', 'tbl_tickets.MaterialID = tbl_materials.MaterialID ','LEFT');
		$this->db->where('tbl_tickets.delete_notes IS NULL'); 
		$this->db->where('tbl_tickets.is_hold', '1');	
		$this->db->where('tbl_tickets.LoadID <> 0 ');	
		$this->db->where('tbl_booking_loads1.Status','1');	
		//$this->db->where('tbl_tickets.Conveyance <> ""');	
		$this->db->where('tbl_tickets.IsInBound', '0');		
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T")', $s[$i]);
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
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Conveyance)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.Conveyance ', trim($Conveyance)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($driver_id)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.driver_id', trim($driver_id)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Net', trim($Net)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		//echo $this->db->last_query();
		//exit;
        
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
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
		
		public function GetHoldTicketData___OLD(){

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
				  
				//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows();
			}
			$this->db->group_by("tbl_tickets.TicketNo "); 
			  
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
			$data = $query->result_array();
			$totalData  = $this->db->count_all_results();
			$totalFiltered =  $totalData; 
			
			//foreach ($query->result_array() as $val) {
			//        $data[] = $val;
			//		//$data[] = array_values($val);
			//}  
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
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }  
			if($Sort[0]=='Conveyance'){ $columnName = 'tbl_tickets.Conveyance '; } 
			if($Sort[0]=='driver_id'){ $columnName = 'tbl_tickets.driver_id '; } 
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; } 
			if($Sort[0]=='DriverName'){ $columnName = 'tbl_tickets.DriverName '; } 
			if($Sort[0]=='GrossWeight'){ $columnName = 'tbl_tickets.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_tickets.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_tickets.Net '; } 
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));  
		$Conveyance = trim(strtolower($_POST['Conveyance']));  
		$driver_id = trim(strtolower($_POST['driver_id']));  
		$RegNumber = trim(strtolower($_POST['RegNumber']));  
		$DriverName = trim(strtolower($_POST['DriverName']));  
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));  
		$Tare = trim(strtolower($_POST['Tare']));  
		$Net = trim(strtolower($_POST['Net']));  
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));   
        
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
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
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->select(' tbl_tickets.MaterialID '); 
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		
		$this->db->join('tbl_materials', 'tbl_tickets.MaterialID = tbl_materials.MaterialID ','LEFT');
		$this->db->where(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y-%m-%d")= DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');  
		$this->db->where('tbl_tickets.delete_notes IS NULL');  
		$this->db->where('tbl_tickets.IsInBound', '1');		
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T")', $s[$i]);
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
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Conveyance)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.Conveyance ', trim($Conveyance)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($driver_id)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.driver_id', trim($driver_id)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Net', trim($Net)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		//echo $this->db->last_query();
		//exit;
        
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
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
		
		public function GetInboundTicketData___OLD(){

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
			$this->db->where(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y-%m-%d")= DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');  
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

				//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows();
			}
			$this->db->group_by("tbl_tickets.TicketNo "); 
			 
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
			$data = $query->result_array();
			$totalData  = $this->db->count_all_results();
			$totalFiltered =  $totalData; 
			
			//foreach ($query->result_array() as $val) {
			//        $data[] = $val;
			//		//$data[] = array_values($val);
			//}  
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
		
		public function GetIncompletedTicketData(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			//if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }  
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }  
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_materials.MaterialName '; } 
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }  
			if($Sort[0]=='Conveyance'){ $columnName = 'tbl_tickets.Conveyance '; } 
			if($Sort[0]=='driver_id'){ $columnName = 'tbl_tickets.driver_id '; } 
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; } 
			if($Sort[0]=='DriverName'){ $columnName = 'tbl_tickets.DriverName '; } 
			if($Sort[0]=='GrossWeight'){ $columnName = 'tbl_tickets.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_tickets.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_tickets.Net '; } 
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		//$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));  
		
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));  
		$MaterialName = trim(strtolower($_POST['MaterialName']));  
		$Conveyance = trim(strtolower($_POST['Conveyance']));  
		$driver_id = trim(strtolower($_POST['driver_id']));  
		$RegNumber = trim(strtolower($_POST['RegNumber']));  
		$DriverName = trim(strtolower($_POST['DriverName']));  
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));  
		$Tare = trim(strtolower($_POST['Tare']));  
		$Net = trim(strtolower($_POST['Net']));  
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));   
        
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select('CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   
	//	$this->db->select(' DISTINCT  tbl_tickets.TicketNumber  as  TicketNumber1 ');   
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
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
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %H:%i") as SiteOutDateTime ');    	  
		$this->db->select(' tbl_tickets.LoadID '); 
		$this->db->select(' tbl_tickets.MaterialID '); 
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 		
		$this->db->join('tbl_materials', 'tbl_tickets.MaterialID = tbl_materials.MaterialID ','LEFT');
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		
		$this->db->where(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y-%m-%d") <> DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');  
		//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") <> DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');   
		$this->db->where('tbl_tickets.delete_notes IS NULL');  
		$this->db->where('tbl_tickets.IsInBound', '1');			
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						//$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T")', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T")', $s[$i]);
						
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
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
					$this->db->group_end(); 
				}
			}    
        } 
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		
		/*if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }*/
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Conveyance)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.Conveyance ', trim($Conveyance)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($driver_id)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.driver_id', trim($driver_id)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.Net', trim($Net)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		//echo $this->db->last_query();
		//exit;
        
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
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
		
		public function GetIncompletedTicketData___OLD(){

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
			$this->db->where(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y-%m-%d") <> DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');  
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

				//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows();
			}
			$this->db->group_by("tbl_tickets.TicketNo "); 
			 
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
			$data = $query->result_array();
			$totalData  = $this->db->count_all_results();
			$totalFiltered =  $totalData; 
			
			//foreach ($query->result_array() as $val) {
			//        $data[] = $val;
			//		//$data[] = array_values($val);
			//}  
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
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNo'){ $columnName = 'tbl_tickets.TicketNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; } 
			if($Sort[0]=='TicketDate'){  $columnName = ' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_company.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_opportunities.OpportunityName '; }   
			if($Sort[0]=='RegNumber'){ $columnName = 'tbl_tickets.RegNumber '; }  
			if($Sort[0]=='TypeOfTicket'){ $columnName = ' tbl_tickets.TypeOfTicket '; } 
			if($Sort[0]=='delete_notes'){ $columnName = ' tbl_tickets.delete_notes '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$TicketDate = trim(strtolower($_POST['TicketDate']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$RegNumber = trim(strtolower($_POST['RegNumber']));    
		$TypeOfTicket = trim(strtolower($_POST['TypeOfTicket']));   
		$delete_notes = trim(strtolower($_POST['delete_notes']));   
        
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');   	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %H:%i") as TicketDate ');    	 
		$this->db->select(' tbl_opportunities.OpportunityName ');  	
		$this->db->select(' tbl_company.CompanyName ');  	
		$this->db->select(' tbl_tickets.RegNumber ');  	 
		$this->db->select(' tbl_tickets.TypeOfTicket '); 
		$this->db->select(' tbl_tickets.CompanyID '); 
		$this->db->select(' tbl_tickets.OpportunityID '); 
		$this->db->select(' tbl_tickets.TicketNo '); 
		$this->db->select(' tbl_tickets.pdf_name '); 
		$this->db->select(' tbl_tickets.delete_notes '); 
		$this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID',"LEFT"); 		
		$this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID',"LEFT"); 	 		
		$this->db->where('tbl_tickets.delete_notes <> ""'); 	 
			$this->db->where('tbl_tickets.is_hold', '0');	
			$this->db->where('tbl_tickets.IsInBound', '0');			
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T")', $s[$i]);
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_tickets.RegNumber', $s[$i]); 
						$this->db->or_like('tbl_tickets.TypeOfTicket', $s[$i]); 
						$this->db->or_like('tbl_tickets.delete_notes', $s[$i]); 
					$this->db->group_end(); 
				}
			}    
        } 
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap)  ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketDate)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") ', trim($TicketDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_company.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_opportunities.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($RegNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.RegNumber', trim($RegNumber)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($delete_notes)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.delete_notes', trim($delete_notes)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TypeOfTicket)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tickets.TypeOfTicket', trim($TypeOfTicket)); 
 			$this->db->group_end();  
        }
		
		$this->db->group_by("tbl_tickets.TicketNo ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		//echo $this->db->last_query();
		//exit;
        
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
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
		public function GetDeleteTicketData___OLD(){

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
				//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows();
			}
			$this->db->group_by("tbl_tickets.TicketNo ");  
			  
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
			$data = $query->result_array();
			$totalData  = $this->db->count_all_results();
			$totalFiltered =  $totalData; 
			
			//foreach ($query->result_array() as $val) {
			//        $data[] = $val;
			//		//$data[] = array_values($val);
			//}  
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
		
		function GetMatchedBookingDetailsInbound($CompanyID,$OpportunityID,$MaterialID,$RequestDate){ 
			$this->db->select('tbl_booking_date1.BookingDateID');    
			$this->db->select('tbl_booking_date1.BookingID');    
			$this->db->select('tbl_booking1.LoadType');    
			$this->db->select('tbl_booking_date1.BookingRequestID');    
			$this->db->from('tbl_booking_date1');  
			$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID','LEFT'); 		
			$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT'); 		 			 
			$this->db->where('tbl_booking_request.Status','1'); 	 
			$this->db->where('tbl_booking_request.CompanyID',$CompanyID); 	 
			$this->db->where('tbl_booking_request.OpportunityID',$OpportunityID); 	 
			$this->db->where('tbl_booking1.MaterialID',$MaterialID); 	 
			$this->db->where('tbl_booking1.BookingType','1'); 	 
			$this->db->where('tbl_booking_date1.BookingDate',$RequestDate); 	 
			$this->db->where(' tbl_booking_date1.BookingDateStatus = 1 '); 	 
			$this->db->order_by('tbl_booking_date1.BookingDateID', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get(); 
			//echo $this->db->last_query();
			//exit;
			return $query->row_array();
		}

		function CountBookingLoad($BookingDateID){ 
			$this->db->select('count(*) as CountLoads');     
			$this->db->from('tbl_booking_loads1');   
			$this->db->where('tbl_booking_loads1.BookingDateID',$BookingDateID); 	  
			$query = $this->db->get(); 
			//echo $this->db->last_query();
			//exit;
			return $query->row_array();
		}
		
		function GetMatchedBookingDetailsOutbound($CompanyID,$OpportunityID,$MaterialID,$RequestDate){
			$this->db->select('tbl_booking_date1.BookingDateID');    
			$this->db->select('tbl_booking_date1.BookingID');    
			$this->db->select('tbl_booking1.LoadType');    
			$this->db->select('tbl_booking_date1.BookingRequestID');    
			$this->db->from('tbl_booking_date1');  
			$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID','LEFT'); 		
			$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT'); 		 			 
			$this->db->where('tbl_booking_request.CompanyID',$CompanyID); 	 
			$this->db->where('tbl_booking_request.OpportunityID',$OpportunityID); 	 
			$this->db->where('tbl_booking1.MaterialID',$MaterialID); 	 
			$this->db->where('tbl_booking1.BookingType','2'); 	 
			$this->db->where('tbl_booking_date1.BookingDate',$RequestDate); 	 
			$this->db->where(' tbl_booking_date1.BookingDateStatus = 1 '); 	 
			$this->db->order_by('tbl_booking_date1.BookingDateID', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get(); 
			//echo $this->db->last_query();
			//exit;
			return $query->row_array();
		} 
		
		function GetTicketsTemp(){ 
			$this->db->select('tbl_tickets.TicketNo ,tbl_tickets.TicketNumber ,  tbl_tickets.TicketUniqueID, tbl_booking_loads1.DriverLoginID ' );   
			$this->db->from('tbl_tickets');  
			$this->db->join('tbl_booking_loads1', ' tbl_tickets.LoadID = tbl_booking_loads1.LoadID ','LEFT'); 		
			
			$CNO = array('1155');
			$this->db->where_in('tbl_tickets.TicketNumber', $CNO);  
			$this->db->order_by('tbl_tickets.TicketNo', 'ASC'); 
			//$this->db->limit(10);
			$query = $this->db->get(); 
			//echo $this->db->last_query();
			//exit;
			return $query->result();        
		}
 
}