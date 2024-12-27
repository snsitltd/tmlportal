<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Booking_model extends CI_Model{ 

	function AllocateBookings(){ 
        $this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	 		
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y  %T") as BookingDateTime ');  	 	 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');  	 
		$this->db->where('tbl_booking.Status = 1 ');  
		$query = $this->db->get('tbl_booking');
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }  
	
	function getContactsByOpportunity($OpportunityID)
    {
        $this->db->select('tbl_contacts.ContactID , tbl_contacts.ContactName');
        $this->db->from('tbl_contacts');        
        $this->db->join('tbl_opportunity_to_contact ', 'tbl_opportunity_to_contact.ContactID = tbl_contacts.ContactID');        
        $this->db->where('tbl_opportunity_to_contact.OpportunityID', $OpportunityID);
		$this->db->where('tbl_contacts.ContactName <> "" '); 
		$this->db->order_by('tbl_contacts.ContactName', 'ASC');
        $query = $this->db->get();        
        $result = $query->result();        
        return $result;
    }
	
	
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
	
	public function GetBookingData(){

        //We Need Column Index for Ordering
        $columns = array(
                0 =>'BookingID', 
                1 => 'BookingDateTime',
				2 => 'CompanyName',
				3 => 'OpportunityName',
				4 => 'Email'
        ); 

        //$totalData  = $this->db->count_all('tbl_booking');
        //$totalFiltered =  $totalData; 

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.BookingType, tbl_booking.Status ');
		$this->db->select(' tbl_booking.CompanyID ');
		$this->db->select(' tbl_booking.OpportunityID ');
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y ") as BookingDateTime ');  	 	 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');  	 
		//$this->db->where('tbl_booking.Status = 0 '); 
				
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value'];

                //$this->db->like('tbl_booking.TicketNumber', $search_value);
               // $this->db->or_like('tbl_booking.TicketDate', $search_value);
                $this->db->or_like('tbl_booking.RegNumber', $search_value);
				$this->db->or_like('tbl_booking.OpportunityName', $search_value);
				$this->db->or_like('tbl_booking.CompanyName', $search_value);
                $this->db->stop_cache();

                $totalFiltered  = $this->db->get('tbl_booking')->num_rows();
        }
        $this->db->stop_cache();  
		
		//$this->db->order_by('tbl_booking.TicketDate', 'DESC'); 
        //$this->db->order_by('tbl_booking.TicketNo', 'DESC');        
		 
		$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking');
        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $data[] = $val;
				//$data[] = array_values($val);
        }
		$totalData  = $this->db->get('tbl_booking')->num_rows();
        $totalFiltered =  $totalData; 
		
        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data  // total data array
        ); 
        return $return; 
    }
	function ShowLoads($BookingID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking_loads.DriverName, tbl_booking_loads.VehicleRegNo, tbl_booking_loads.Status');
		$this->db->select('tbl_drivers.DriverName as dname, tbl_drivers.RegNumber as vrn' );
        $this->db->from('tbl_booking_loads');
        $this->db->join('tbl_tipaddress', 'tbl_tipaddress.TipID = tbl_booking_loads.TipID'); 
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_booking_loads.DriverID'); 
        $this->db->join('tbl_materials', 'tbl_materials.MaterialID = tbl_booking_loads.MaterialID');  
        $this->db->where('tbl_booking_loads.BookingID', $BookingID);                     
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function ShowLoadDetails($LoadID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobEndDateTime,"%d/%m/%Y %T") as JobEndDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteInDateTime,"%d/%m/%Y %T") as SiteInDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d/%m/%Y %T") as SiteOutDateTime ');   
		$this->db->select('tbl_users.name as CreatedByName , tbl_users.email as CreatedByEmail , tbl_users.mobile as CreatedByMobile , ');
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking.Price, tbl_booking.PurchaseOrderNumber, tbl_booking.Email, tbl_booking.Notes'); 
		$this->db->select('tbl_company.CompanyName, tbl_booking.CompanyID as ComID, tbl_opportunities.OpportunityName , tbl_booking.OpportunityID as OppID  ');
		$this->db->select('tbl_booking_loads.DriverName,tbl_booking_loads.DriverID, tbl_booking_loads.VehicleRegNo, tbl_booking_loads.Status, tbl_booking_loads.ConveyanceNo');
		$this->db->select('tbl_drivers.DriverName as dname, tbl_drivers.RegNumber as vrn, tbl_drivers.MobileNo as DriverMobile, tbl_drivers.Email as DriverEmail' );
        $this->db->from('tbl_booking_loads'); 
        $this->db->join('tbl_booking', 'tbl_booking.BookingID = tbl_booking_loads.BookingID'); 
        $this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID'); 
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking_loads.createdBy'); 
		$this->db->join('tbl_tipaddress', 'tbl_tipaddress.TipID = tbl_booking_loads.TipID');  
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_booking_loads.DriverID'); 
        $this->db->join('tbl_materials', 'tbl_materials.MaterialID = tbl_booking_loads.MaterialID');  
        $this->db->where('tbl_booking_loads.LoadID', $LoadID);                     
        $query = $this->db->get(); 
        //echo $this->db->last_query();       
	    //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function ShowLoadPhotos($LoadID)
    { 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads_photos.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select('tbl_booking_loads_photos.*'); 
        $this->db->from('tbl_booking_loads_photos'); 
        $this->db->join('tbl_booking_loads', 'tbl_booking_loads.LoadID = tbl_booking_loads_photos.LoadID');   
        $this->db->where('tbl_booking_loads_photos.LoadID', $LoadID);                     
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function LorryListAJAX(){  
		$this->db->select('LorryNo, DriverName, RegNumber ');
		$this->db->from('tbl_drivers');
		$this->db->where('DriverName <> ""');
		$this->db->where('MobileNo <> ""');
		$this->db->where('Password <> ""');
		$this->db->where('RegNumber <> ""');  
		$this->db->where('Status = 0');  
		$query = $this->db->get();
		return $result = $query->result();     
	}
	function TipListAJAX(){  
		$this->db->select('TipName,TipID');
		$this->db->from('tbl_tipaddress'); 
		$this->db->order_by('TipID', 'ASC');
		$query = $this->db->get();
		return $result = $query->result();     
	}  
	public function GetAllocatedBookingData(){

        //We Need Column Index for Ordering
        $columns = array(
                0 =>'BookingID', 
                1 => 'BookingDateTime',
				2 => 'CompanyName',
				3 => 'OpportunityName',
				4 => 'Email'
        ); 
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');  	 		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		$this->db->select(' tbl_booking.Days ');  	
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y ") as BookingDateTime ');  	 	 
		//$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y  %T") as BookingDateTime ');  	 	 
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated '); 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');   
		$this->db->where('tbl_booking.Status = 1 '); 
				
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value']; 
                $this->db->or_like('tbl_booking.RegNumber', $search_value);
				$this->db->or_like('tbl_booking.OpportunityName', $search_value);
				$this->db->or_like('tbl_booking.CompanyName', $search_value);
                $this->db->stop_cache();

                $totalFiltered  = $this->db->get('tbl_booking')->num_rows();
        }
        $this->db->stop_cache();  
		
		//$this->db->order_by('tbl_booking.TicketDate', 'DESC'); 
        $this->db->order_by('tbl_booking.BookingID', 'DESC');        
		
		//$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
       // $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking');
        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $data[] = $val; 
        }
		
		$totalData  = $this->db->get('tbl_booking')->num_rows();
        $totalFiltered =  $totalData; 
		 
        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	
	public function GetLoadsData(){

        //We Need Column Index for Ordering
        $columns = array(
                0 =>'BookingID', 
                1 => 'BookingDateTime',
				2 => 'CompanyName',
				3 => 'OpportunityName',
				4 => 'Email'
        ); 
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		
		$this->db->select(' tbl_drivers.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y ") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.CreateDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		$this->db->join('tbl_booking', 'tbl_booking.BookingID = tbl_booking_loads.BookingID'); 		
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_booking_loads.DriverID'); 		
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        //if( !empty($_REQUEST['search']['value']) ){
        //        $search_value = $_REQUEST['search']['value']; 
        //        $this->db->or_like('tbl_booking.RegNumber', $search_value);
		//		$this->db->or_like('tbl_booking.OpportunityName', $search_value);
		//		$this->db->or_like('tbl_booking.CompanyName', $search_value);
        //        $this->db->stop_cache();

        //        $totalFiltered  = $this->db->get('tbl_booking')->num_rows();
        //}
		
        $this->db->stop_cache();  
		
		$this->db->order_by('tbl_booking_loads.BookingID', 'DESC'); 
		$this->db->order_by('tbl_booking_loads.LoadID', 'DESC'); 
        //$this->db->order_by('tbl_booking.TicketNo', 'DESC');   
		//$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
       // $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_loads');
        //Reset Key Array
        $data = array();
        foreach ($query->result_array() as $val) {
                $data[] = $val; 
        }
		
		$totalData  = $this->db->get('tbl_booking_loads')->num_rows();
        $totalFiltered =  $totalData; 
		 
        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
 
}

  