<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Booking_model extends CI_Model{ 
	
	function GetOppoMaterialListDetails($OpportunityID,$MaterialID,$DateRequired){ 
        $this->db->select('tbl_product.UnitPrice');  	 		 
		$this->db->select('tbl_product.PurchaseOrderNo');  
		$this->db->where('tbl_product.OpportunityID',$OpportunityID);  
		$this->db->where('tbl_product.MaterialID',$MaterialID);  
		$this->db->where('DATE_FORMAT(tbl_product.DateRequired,"%Y-%m-%d") <= "'.trim($DateRequired).'" ');  
		$this->db->order_by('tbl_product.DateRequired', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('tbl_product');
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	
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
        $this->db->select('tbl_contacts.ContactID , tbl_contacts.ContactName, tbl_contacts.MobileNumber, tbl_contacts.EmailAddress');
        $this->db->from('tbl_contacts');        
        $this->db->join('tbl_opportunity_to_contact ', 'tbl_opportunity_to_contact.ContactID = tbl_contacts.ContactID');        
        $this->db->where('tbl_opportunity_to_contact.OpportunityID', $OpportunityID); 
		$this->db->where('tbl_contacts.ContactName <> "" '); 
		$this->db->order_by('tbl_contacts.ContactName', 'ASC');
        $query = $this->db->get();        
        $result = $query->result();        
        return $result;
    }
	function getOppoByID($OpportunityID){
        $this->db->select('tbl_opportunities.Street1 , tbl_opportunities.Street2, tbl_opportunities.Town, tbl_opportunities.County, tbl_opportunities.PostCode ');
        $this->db->from('tbl_opportunities');         
        $this->db->where('tbl_opportunities.OpportunityID', $OpportunityID);   
        $query = $this->db->get();        
        return $result = $query->result();         
    }
	
	function getContactDetails($ContactID)
    {
        $this->db->select('tbl_contacts.ContactName, tbl_contacts.MobileNumber, tbl_contacts.EmailAddress');
        $this->db->from('tbl_contacts');         
        $this->db->where('tbl_contacts.ContactID', $ContactID); 
		$this->db->where('tbl_contacts.ContactName <> "" ');  
        $query = $this->db->get();        
        $result = $query->result();        
        return $result;
    }
	function DriverList(){  
		$this->db->select('tbl_drivers.LorryNo '); 	
		$this->db->select('tbl_drivers.DriverName '); 	 
		$this->db->from('tbl_drivers');    
		$this->db->where('tbl_drivers.MobileNo <> ""');			
		$this->db->where('tbl_drivers.Password <> ""');			  
		$this->db->order_by('tbl_drivers.LorryNo ','ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	function DriverLoginList(){   
		$this->db->select('tbl_drivers_login.DriverID '); 	
		$this->db->select('tbl_drivers_login.DriverName '); 	 
		$this->db->from('tbl_drivers_login');    
		$this->db->where('tbl_drivers_login.MobileNo <> ""');			
		$this->db->where('tbl_drivers_login.Password <> ""');			  
		$this->db->order_by('tbl_drivers_login.DriverName ','ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	function GetDriverDetails($Driver){  
		$this->db->select('tbl_drivers.LorryNo '); 	
		$this->db->select('tbl_drivers.DriverName '); 	 
		$this->db->from('tbl_drivers');    
		$this->db->where('tbl_drivers.LorryNo', $Driver);  
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function GetDriverLoginDetails($Driver){   
		$this->db->select('tbl_drivers_login.DriverName '); 	 
		$this->db->from('tbl_drivers_login');    
		$this->db->where('tbl_drivers_login.DriverID', $Driver);  
		$query = $this->db->get();
		return $query->result_array();
	}

	public function BookingData($BookingID){
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y  %T") as BookingDateTime1 ');  	 	 
		$this->db->select('tbl_booking.*' );   
		$this->db->from('tbl_booking');    
		$this->db->where('tbl_booking.BookingID',$BookingID); 		 
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function GetBookingBasicInfo($BookingDateID){
		$this->db->select(' tbl_booking.BookingType  ');  	 	 
		$this->db->select(' tbl_booking.Loads ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDate ');  	 	 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->from('tbl_booking_date');    
		$this->db->join('tbl_booking', 'tbl_booking_date.BookingID = tbl_booking.BookingID',"LEFT");  
		$this->db->where('tbl_booking_date.BookingDateID',$BookingDateID); 		 
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function GetBookingDate($BookingID){
		$this->db->select(' DATE_FORMAT(BookingDate,"%d-%m-%Y") as BookingDate ');  	 	 
		$this->db->select('BookingDateID' );    
		$this->db->from('tbl_booking_date');    
		$this->db->where('BookingID',$BookingID); 		 
		$this->db->order_by('BookingDateID', 'ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit;
		return $result = $query->result();  
		//return $query->row_array();
	}
	public function GetBookingDate1($BookingID){
		$this->db->select(' DATE_FORMAT(BookingDate,"%d/%m/%Y") as BookingDate ');  	 	  
		$this->db->from('tbl_booking_date');    
		$this->db->where('BookingID',$BookingID); 		 
		$this->db->order_by('BookingDateID', 'ASC');
		$query = $this->db->get(); 
		return $query->result_array();
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
	function LastConNumber(){
		$this->db->select('ConveyanceNo');    
        $this->db->from('tbl_booking_loads');         
		$this->db->order_by('ConveyanceNo', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}	
     
	
	function GetBookingInfo($id){
		$this->db->select('tbl_booking.*');   
		$this->db->select('(select tbl_materials.SicCode FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as SicCode '); 		
        $this->db->from('tbl_booking'); 
        $this->db->where('tbl_booking.BookingID',$id);		
		$query = $this->db->get(); 
		return $query->row();
		//return $query->row_array();
	}
	function GetTurnaroundCount($id){
		$sql = 'select COUNT(DISTINCT DriverID) as DistinctLorry from tbl_booking_loads where tbl_booking_loads.BookingID = "'.$id.'" ';  
		$query = $this->db->query($sql);
		return $query->row();
		//return $query->row_array();
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
	function GetDriverList(){
       $this->db->select('tbl_drivers.LorryNo,tbl_drivers_login.DriverName,tbl_drivers.RegNumber,tbl_drivers.Haulier,tbl_drivers.Tare,tbl_drivers_login.MobileNo,tbl_drivers_login.Email');
       $this->db->from('tbl_drivers_login');
       $this->db->join('tbl_drivers', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID',"LEFT"); 	
	   //$this->db->where('DriverName <> ""');
       $this->db->where('tbl_drivers.RegNumber <> ""'); 
	   $this->db->where('tbl_drivers.Haulier = "Thames Material Ltd."');  
	   $this->db->where('tbl_drivers_login.MobileNo <> ""'); 
	   $this->db->where('tbl_drivers_login.Password <> ""'); 
	   $this->db->group_by('tbl_drivers_login.DriverID');             
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
	
	
	function ShowLoads($BookingID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking_loads.DriverName, tbl_booking_loads.VehicleRegNo, tbl_booking_loads.Status, tbl_booking_loads.ConveyanceNo , tbl_booking_loads.AutoCreated ');
		$this->db->select('tbl_drivers_login.DriverName as dname, tbl_drivers.RegNumber as vrn' );
        $this->db->from('tbl_booking_loads');
        $this->db->join('tbl_tipaddress', 'tbl_booking_loads.TipID = tbl_tipaddress.TipID',"LEFT"); 
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ',"LEFT"); 
        $this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ',"LEFT"); 	
		$this->db->join('tbl_materials', ' tbl_booking_loads.MaterialID = tbl_materials.MaterialID',"LEFT");  
        $this->db->where('tbl_booking_loads.BookingID', $BookingID);
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function ShowBookingDateLoads($BookingDateID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking_loads.DriverName, tbl_booking_loads.VehicleRegNo, tbl_booking_loads.Status, tbl_booking_loads.ConveyanceNo, tbl_booking_loads.AutoCreated ');
		$this->db->select('tbl_drivers_login.DriverName as dname, tbl_drivers.RegNumber as vrn' );
        $this->db->from('tbl_booking_loads');
        $this->db->join('tbl_tipaddress', 'tbl_booking_loads.TipID = tbl_tipaddress.TipID',"LEFT"); 
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ',"LEFT"); 
        $this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ',"LEFT"); 	
		$this->db->join('tbl_materials', ' tbl_booking_loads.MaterialID = tbl_materials.MaterialID',"LEFT");    
        $this->db->where('tbl_booking_loads.BookingDateID', $BookingDateID);
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function ShowLoads1($BookingDateID){ 
		$this->db->select('count(*) as QTY , tbl_tipaddress.TipName');
		$this->db->select('tbl_booking_loads.DriverName ');
		$this->db->select('tbl_drivers_login.DriverName as dname ' );
        $this->db->from('tbl_booking_loads');
        $this->db->join('tbl_tipaddress', ' tbl_booking_loads.TipID = tbl_tipaddress.TipID  ',"LEFT"); 
		$this->db->join('tbl_drivers', ' tbl_booking_loads.DriverID = tbl_drivers.LorryNo ',"LEFT"); 
        $this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID  ',"LEFT"); 	   
        $this->db->where('tbl_booking_loads.BookingDateID', $BookingDateID); 
		$this->db->group_by('tbl_booking_loads.TipID,tbl_booking_loads.DriverLoginID,');             
        $query = $this->db->get(); 
        //echo $this->db->last_query();       
	    //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function ShowLoads2($BookingDateID){
        $this->db->select('COUNT(DISTINCT tbl_booking_loads.DriverID) as QTY ');  
		$this->db->select('tbl_tipaddress.TipName');
		$this->db->select('tbl_booking_loads.DriverName ');
		$this->db->select('tbl_drivers_login.DriverName as dname ' );
        $this->db->from('tbl_booking_loads');
        $this->db->join('tbl_tipaddress', ' tbl_booking_loads.TipID = tbl_tipaddress.TipID  ',"LEFT"); 
		$this->db->join('tbl_drivers', ' tbl_booking_loads.DriverID = tbl_drivers.LorryNo ',"LEFT"); 
        $this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID  ',"LEFT"); 	   
        $this->db->where('tbl_booking_loads.BookingDateID', $BookingDateID);
		$this->db->group_by('tbl_booking_loads.TipID,tbl_booking_loads.DriverLoginID');             
        $query = $this->db->get(); 
		//echo $this->db->last_query();       
		//exit; 
		$result = $query->result(); 		  
        return $result;
    }
	function ShowLoadDetails($LoadID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobEndDateTime,"%d/%m/%Y %T") as JobEndDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteInDateTime,"%d/%m/%Y %T") as SiteInDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d/%m/%Y %T") as SiteOutDateTime ');   
		$this->db->select('tbl_booking_loads.ReceiptName ');    
		$this->db->select('tbl_users.name as CreatedByName , tbl_users.email as CreatedByEmail , tbl_users.mobile as CreatedByMobile ');
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking.Price, tbl_booking.PurchaseOrderNumber, tbl_booking.Email, tbl_booking.Notes, tbl_booking.ContactName, tbl_booking.ContactMobile'); 
		$this->db->select('tbl_company.CompanyName, tbl_booking.CompanyID as ComID, tbl_opportunities.OpportunityName , tbl_booking.OpportunityID as OppID  ');
		$this->db->select('tbl_booking_loads.DriverName,tbl_booking_loads.DriverID, tbl_booking_loads.VehicleRegNo, tbl_booking_loads.Status, 
		tbl_booking_loads.ConveyanceNo, tbl_booking_loads.TicketID, tbl_booking_loads.TicketUniqueID');
		$this->db->select('tbl_drivers_login.DriverName as dname, tbl_drivers.RegNumber as vrn, tbl_drivers_login.MobileNo as DriverMobile, tbl_drivers_login.Email as DriverEmail' );
        $this->db->from('tbl_booking_loads'); 
        $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID ','LEFT'); 
        $this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID','LEFT'); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_booking.BookedBy = tbl_users.userId ','LEFT'); 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads.TipID = tbl_tipaddress.TipID','LEFT');  
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo','LEFT'); 
        $this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ','LEFT'); 	
		$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID = tbl_materials.MaterialID','LEFT');  
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
        $this->db->join('tbl_booking_loads', 'tbl_booking_loads_photos.LoadID =tbl_booking_loads.LoadID','LEFT');   
        $this->db->where('tbl_booking_loads_photos.LoadID', $LoadID);                     
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	
	function DriverTodayTAList(){  
		$this->db->select('tbl_booking_loads.DriverID');
		$this->db->from('tbl_booking_loads'); 
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()');   
		$this->db->where('tbl_booking.BookingType = 1');  
		$this->db->where('tbl_booking.LoadType = 2');  
		$this->db->where('tbl_booking_loads.Status < 4');  
		$query = $this->db->get(); 
		return $query->result_array(); //$query->result();     
	}
	function DriverTodayTAList1(){  
		$this->db->select('tbl_booking_loads.DriverID');
		$this->db->from('tbl_booking_loads'); 
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()');   
		$this->db->where('tbl_booking.BookingType = 2');  
		$this->db->where('tbl_booking.LoadType = 2');  
		$this->db->where('tbl_booking_loads.Status < 4');  
		$query = $this->db->get(); 
		return $query->result_array(); //$query->result();     
	}
	function DriverBookedList($Date){  
		$this->db->select('tbl_booking_loads.DriverID');
		$this->db->from('tbl_booking_loads'); 
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y")',$Date);   
		$this->db->where('tbl_booking.BookingType = 1');  
		$this->db->where('tbl_booking.LoadType = 2');  
		$query = $this->db->get(); 
		//echo $this->db->last_query();       
	    //exit;
		return $query->result_array(); //$query->result();     
	}
	function DriverBookedList1($Date){  
		$this->db->select('tbl_booking_loads.DriverID');
		$this->db->from('tbl_booking_loads'); 
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y")',$Date);   
		$this->db->where('tbl_booking.BookingType = 2');  
		$this->db->where('tbl_booking.LoadType = 2');  
		$query = $this->db->get(); 
		//echo $this->db->last_query();       
	    //exit;
		return $query->result_array(); //$query->result();     
	}
	function LorryListAJAX(){  
		$this->db->select('tbl_drivers.LorryNo, tbl_drivers.DriverID, tbl_drivers_login.DriverName, tbl_drivers.RegNumber ');
		$this->db->from('tbl_drivers');
		$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID','left');   
		$this->db->where('tbl_drivers_login.DriverName <> ""');
		$this->db->where('tbl_drivers_login.DriverID <> 0');
		$this->db->where('tbl_drivers_login.MobileNo <> ""');
		$this->db->where('tbl_drivers_login.Password <> ""');
		$this->db->where('tbl_drivers.RegNumber <> ""');  
		$this->db->where('tbl_drivers_login.Status = 0');  
		$query = $this->db->get();
		return $result = $query->result();     
	}
	
	function LorryListNonApp(){  
		$this->db->select('tbl_drivers.LorryNo, tbl_drivers.ContractorID, tbl_drivers.DriverName, tbl_drivers.ContractorLorryNo , tbl_drivers.RegNumber ');
		$this->db->from('tbl_drivers');  
		$this->db->where('tbl_drivers.Password = "" ');  
		//$this->db->where('tbl_drivers.ContractorID >1 ');  
		$this->db->where('tbl_drivers.ContractorID <> 0 ');  
		$this->db->where('tbl_drivers.AppUser = 1 ');  
		$query = $this->db->get();
		//echo $this->db->last_query();       
	    //exit;
		return $result = $query->result();     
	}
	function LorryListAJAX1(){  
		$this->db->select('tbl_drivers_logs.DriverID, tbl_drivers.LorryNo, tbl_drivers_login.DriverName, tbl_drivers.RegNumber');
		$this->db->from('tbl_drivers_logs');
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_drivers_logs.DriverID'); 
		$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID','left');   
		$this->db->where(' DATE_FORMAT(tbl_drivers_logs.LoginDatetime,"%Y-%m-%d") = CURDATE()');    
		$this->db->where('tbl_drivers.DriverID <> 0 ');    
		$this->db->group_by('tbl_drivers_logs.DriverID');             
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
	
	public function GetBookingData(){
		
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		  
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.BookingType, tbl_booking.Status ');
		$this->db->select(' tbl_booking.CompanyID ');
		$this->db->select(' tbl_booking.LoadType ');
		$this->db->select(' tbl_booking.LorryType ');
		$this->db->select(' tbl_booking.Loads ');
		$this->db->select(' tbl_booking.Notes ');
		$this->db->select(' tbl_booking.Status ');
		$this->db->select(' tbl_booking.OpportunityID '); 
		$this->db->select(' tbl_company.CompanyName '); 
		$this->db->select(' tbl_opportunities.OpportunityName '); 
		$this->db->select(' tbl_materials.MaterialName  ');  
		$this->db->select(' tbl_users.name as BookedName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    		
		//$this->db->select(' DATE_FORMAT(tbl_booking.CreateDateTime,"%d/%m/%Y %T") as BookingDate ');    		
		$this->db->select('(select GROUP_CONCAT(DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y")  SEPARATOR "<br>") FROM tbl_booking_date 
		where tbl_booking_date.BookingID = tbl_booking.BookingID order by tbl_booking_date.BookingDateID ASC)  as BookingDate '); 
		//$this->db->select('(select tbl_users.name FROM tbl_users where tbl_booking.BookedBy = tbl_users.userId ) as BookedName ');  
		$this->db->select('(select count(*) from tbl_booking_loads where  tbl_booking.BookingID = tbl_booking_loads.BookingID ) as TotalLoadAllocated ');   
		$this->db->join('tbl_opportunities', ' tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking.BookedBy'); 
		
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking.Notes', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);
						$this->db->or_like('tbl_users.name', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking.CreateDateTime,"%d-%m-%Y %T") ', $s[$i]);
					$this->db->group_end(); 
				}
			}    
        }
		  
		$this->db->order_by($columnName, $columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking');
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
                "data"            => $data  // total data array
        ); 
        return $return; 
    }
	
	public function GetAllocatedBookingData(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		  
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking_date.BookingDateID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		//$this->db->select(' tbl_booking.Days ');  	
		$this->db->select('CURDATE()  as ndate ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		//$this->db->select(' tbl_booking.BookingDateTime as BookingDateTime1 ');  	 	 
		$this->db->select(' tbl_booking_date.BookingDate as BookingDateTime1 ');  	 	 
		//$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T ") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	  
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated '); 
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() ) as DistinctLorry '); 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');     		
		$this->db->join('tbl_booking_date', 'tbl_booking_date.BookingID = tbl_booking.BookingID'); 
		$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID'); 
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID'); 
		$this->db->join('tbl_materials', 'tbl_materials.MaterialID = tbl_booking.MaterialID'); 
		$this->db->where('tbl_booking.Status = 1 '); 
		//$this->db->where('DATE_FORMAT(tbl_booking.BookingDateTime,"%Y-%m-%d") = CURDATE()'); 
		$this->db->where('DATE_FORMAT(tbl_booking_date.BookingDate,"%Y-%m-%d") = CURDATE()'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) > 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)');  
				
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]);  
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end();

				}
			}    
        }
		 
		$this->db->order_by($columnName, $columnSortOrder);		 
        $query = $this->db->get('tbl_booking');
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	public function GetAllocatedBookingData2(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		  
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking_date.BookingDateID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		//$this->db->select(' tbl_booking.Days ');  	
		$this->db->select('CURDATE()  as ndate ');  	 
		$this->db->select(' tbl_booking.OpportunityID '); 
		$this->db->select(' tbl_booking_date.BookingDate as BookingDateTime1 ');  	 	  
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	  
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated '); 
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() ) as DistinctLorry '); 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');   
		$this->db->join('tbl_booking_date', 'tbl_booking_date.BookingID = tbl_booking.BookingID'); 
		$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID'); 
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID'); 
		$this->db->join('tbl_materials', 'tbl_materials.MaterialID = tbl_booking.MaterialID'); 
		$this->db->where('tbl_booking.Status = 1 '); 
//		$this->db->where('DATE_FORMAT(tbl_booking.BookingDateTime,"%Y-%m-%d") < CURDATE()'); 
		$this->db->where('DATE_FORMAT(tbl_booking_date.BookingDate,"%Y-%m-%d") < CURDATE()'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) > 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)'); 
		
		if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]);  
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y %T") ', $s[$i]);    
					$this->db->group_end();

				}
			}    
        }
		 
		  	
		$this->db->order_by($columnName, $columnSortOrder);		 
        $query = $this->db->get('tbl_booking');
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	function TodayBookingListing()
    {
        $this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking_date.BookingDateID  ');  
		$this->db->select(' tbl_booking_date.CancelLoads');  
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  
		$this->db->select(' tbl_booking.LorryType ');		
		$this->db->select(' tbl_booking.Loads ');  	  
		//$this->db->select(' tbl_booking.Days ');
		$this->db->select(' tbl_booking.OpportunityID ');
		$this->db->select(' tbl_booking_date.BookingDate as BookingDateTime1 ');
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID and 
		tbl_booking_loads.AutoCreated = 1 ) as TotalLoadAllocated '); 
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() and tbl_booking_loads.AutoCreated = 1 ) as DistinctLorry ');   
		
		//$this->db->select(' (select GROUP_CONCAT(tbl_booking_loads.DriverID SEPARATOR ",")  
		//from tbl_booking_loads join tbl_booking on tbl_booking.BookingID = tbl_booking_loads.BookingID
		//where DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() 
		//and tbl_booking_loads.Status <> 4 and tbl_booking.BookingType = 1 ) as al_driver_c '); 
		
		//$this->db->select(' (select GROUP_CONCAT(tbl_booking_loads.DriverID SEPARATOR ",")  
		//from tbl_booking_loads join tbl_booking on tbl_booking.BookingID = tbl_booking_loads.BookingID
		//where DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() 
		//and tbl_booking_loads.Status <> 4 and tbl_booking.BookingType = 2 ) as al_driver_d '); 
		
		//$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		//$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		//$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		
		$this->db->select(' tbl_booking.Email ');   
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');
		
		$this->db->join('tbl_booking', 'tbl_booking_date.BookingID = tbl_booking.BookingID'); 
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		
		$this->db->where('tbl_booking.Status = 1 '); 
		//$this->db->where('tbl_booking_date.BookingDateStatus = 0 '); 
		$this->db->where('DATE_FORMAT(tbl_booking_date.BookingDate,"%Y-%m-%d") = CURDATE()');   
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-tbl_booking_date.CancelLoads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ) > 0 
		ELSE tbl_booking.Loads-tbl_booking_date.CancelLoads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)'); 
        $this->db->from('tbl_booking_date'); 
		//$this->db->group_by("tbl_booking_date.BookingDateID");             
		$this->db->group_by("tbl_booking_date.BookingID");             
        //$this->db->order_by('tbl_booking_date.BookingDateID', 'ASC');  
		$this->db->order_by('tbl_booking_date.BookingID', 'DESC');  
        $query = $this->db->get();
        //echo $this->db->last_query();       
	    //exit;
        $result = $query->result();        
        return $result;
    }
	function OverdueBookingListing()
    {
        $this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking_date.BookingDateID  ');  
		$this->db->select(' tbl_booking_date.CancelLoads');  
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  
		$this->db->select(' tbl_booking.LorryType ');		
		$this->db->select(' tbl_booking.Loads ');  	  
		//$this->db->select(' tbl_booking.Days ');  	 	 
		$this->db->select(' tbl_booking.OpportunityID ');		 
		$this->db->select(' tbl_booking_date.BookingDate as BookingDateTime1 '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	      
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID 
		and tbl_booking_loads.AutoCreated = 1  ) as TotalLoadAllocated '); 
		 
		//$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID AND 
		//DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() and tbl_booking_loads.Status <> 4 and tbl_booking_loads.AutoCreated = 1  ) as DistinctLorry '); 
		
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID AND 
		tbl_booking_loads.AutoCreated = 1  ) as DistinctLorry '); 
		
		//$this->db->select(' (select GROUP_CONCAT(tbl_booking_loads.DriverID SEPARATOR ",")  
		//from tbl_booking_loads join tbl_booking on tbl_booking.BookingID = tbl_booking_loads.BookingID
		//where DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() 
		//and tbl_booking_loads.Status <> 4 and tbl_booking.BookingType = 1 ) as al_driver_c '); 
		
		//$this->db->select(' (select GROUP_CONCAT(tbl_booking_loads.DriverID SEPARATOR ",")  
		//from tbl_booking_loads join tbl_booking on tbl_booking.BookingID = tbl_booking_loads.BookingID
		//where DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() 
		//and tbl_booking_loads.Status <> 4 and tbl_booking.BookingType = 2 ) as al_driver_d '); 
		
		//$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		//$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		//$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		
		$this->db->select(' tbl_booking.Email ');   
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');
		
		$this->db->select(' tbl_booking.Email ');   
		$this->db->join('tbl_booking', 'tbl_booking_date.BookingID = tbl_booking.BookingID'); 
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		
		$this->db->where('tbl_booking.Status = 1 ');    
		//$this->db->where('tbl_booking_date.BookingDateStatus = 0 '); 
		$this->db->where('DATE_FORMAT(tbl_booking_date.BookingDate,"%Y-%m-%d") < CURDATE()'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN 
		tbl_booking.Loads-tbl_booking_date.CancelLoads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ) > 0 
		ELSE tbl_booking.Loads-tbl_booking_date.CancelLoads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") < CURDATE()  ) > 0 
		END)'); 
		//$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN 
		//tbl_booking.Loads-tbl_booking_date.CancelLoads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ) > 0 
		//ELSE tbl_booking.Loads-tbl_booking_date.CancelLoads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID  AND 
		//DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") < CURDATE() and tbl_booking_loads.Status <> 4  ) > 0 
		//END)'); 
		
        $this->db->from('tbl_booking_date'); 
		
		//$this->db->group_by("tbl_booking_date.BookingDateID");             
		$this->db->group_by("tbl_booking_date.BookingID"); 
        //$this->db->order_by('tbl_booking_date.BookingDateID', 'ASC');  
		$this->db->order_by('tbl_booking_date.BookingID', 'DESC');    
        $query = $this->db->get();
        //echo $this->db->last_query();       
	    //exit;
        $result = $query->result();        
        return $result;
    }
	function FutureBookingListing()
    {
        $this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking_date.BookingDateID  ');  
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType '); 
		$this->db->select(' tbl_booking.LorryType ');		
		$this->db->select(' tbl_booking.Loads ');  	  
		//$this->db->select(' tbl_booking.Days ');  	 	 
		$this->db->select(' tbl_booking.OpportunityID ');	 
		$this->db->select(' tbl_booking_date.BookingDate as BookingDateTime1 ');  	 	  
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	      
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID and tbl_booking_loads.AutoCreated = 1 ) as TotalLoadAllocated '); 
		
		//$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID AND 
		//DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() and tbl_booking_loads.AutoCreated = 1  ) as DistinctLorry '); 
		
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID AND 
		tbl_booking_loads.AutoCreated = 1  ) as DistinctLorry '); 
		
		//$this->db->select(' (select GROUP_CONCAT(tbl_booking_loads.DriverID SEPARATOR ",")  from tbl_booking_loads 
		//where DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = DATE_FORMAT(tbl_booking_date.BookingDate,"%Y-%m-%d")  and tbl_booking_loads.Status <> 4  ) as al_driver '); 
		
		//$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		//$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		//$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');   
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');		
		
		$this->db->join('tbl_booking', 'tbl_booking_date.BookingID = tbl_booking.BookingID'); 
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		
		$this->db->where('tbl_booking.Status = 1 ');  
		$this->db->where(' DATE(tbl_booking_date.BookingDate) > DATE(CURDATE())'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ) > 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") > CURDATE()  ) > 0 
		END)'); 
        $this->db->from('tbl_booking_date'); 		
		//$this->db->group_by("tbl_booking_date.BookingDateID");             
		$this->db->group_by("tbl_booking_date.BookingID"); 
		//$this->db->order_by('tbl_booking_date.BookingDateID', 'ASC');  
		$this->db->order_by('tbl_booking_date.BookingID', 'DESC');   
        $query = $this->db->get();
        //echo $this->db->last_query();       
	    //exit;
        $result = $query->result();        
        return $result;
    }  
	public function GetAllocatedBookingData1(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking_date.BookingDateID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');  	 		
		$this->db->select(' tbl_booking.BookingType');  	 		 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.LorryType ');  	
		$this->db->select(' tbl_booking.Loads ');  	   
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	  
		//$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated '); 
		//$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		//DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) as DistinctLorry '); 
		
		$this->db->select(' tbl_booking.Email ');    
		$this->db->join('tbl_booking_date', ' tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID '); 
		$this->db->join('tbl_booking', '  tbl_booking_date.BookingID = tbl_booking.BookingID '); 
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		$this->db->where('tbl_booking.Status = 1 '); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) = 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) = 0 
		END)'); 
		
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]);  
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end();

				}
			}    
        }  
		//$this->db->group_by("tbl_booking_loads.LoadID");             
		$this->db->group_by("tbl_booking_date.BookingID"); 
		$this->db->order_by($columnName, $columnSortOrder);		 
        $query = $this->db->get('tbl_booking_loads');
		//echo $this->db->last_query();       
	    //exit;
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	
	public function GetAllocatedBookingData3(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		//$this->db->select(' tbl_booking.Days ');  	
		$this->db->select('CURDATE()  as ndate ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' tbl_booking.BookingDateTime as BookingDateTime1 ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T ") as BookingDateTime ');  	 	 
		//$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y  %T") as BookingDateTime ');  	 	 
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated '); 
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() ) as DistinctLorry '); 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');   
		$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID'); 
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID'); 
		$this->db->join('tbl_materials', 'tbl_materials.MaterialID = tbl_booking.MaterialID'); 
		$this->db->where('tbl_booking.Status = 1 '); 
		$this->db->where('DATE_FORMAT(tbl_booking.BookingDateTime,"%Y-%m-%d") > CURDATE()'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) > 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)'); 
		
		if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]);  
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);    
					$this->db->group_end();

				}
			}    
        }
		 
		 
		$this->db->order_by($columnName, $columnSortOrder);		 
        $query = $this->db->get('tbl_booking');
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	
	
	public function GetAllocateDriversData(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		 
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		 
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d-%m-%Y %T") as JobStartDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobEndDateTime,"%d-%m-%Y %T") as JobEndDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteInDateTime,"%d-%m-%Y %T") as SiteInDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  
		 
		$this->db->select(' tbl_materials.MaterialName ');		 
		$this->db->select(' tbl_opportunities.OpportunityName ');		 
		
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID '); 		
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID '); 
		$this->db->join('tbl_drivers', ' tbl_booking_loads.DriverID = tbl_drivers.LorryNo '); 		
		$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID'); 	
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID  ');  
		$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID = tbl_materials.MaterialID '); 
		
		//$this->db->where('tbl_booking_loads.Status <> 4 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.ConveyanceNo', $s[$i]);  
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.JobEndDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.SiteInDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
					$this->db->group_end();

				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads');
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	public function GetSubcontractorLoadsData($ContractorID){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		   	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		$this->db->join('tbl_booking', 'tbl_booking.BookingID = tbl_booking_loads.BookingID'); 		
		$this->db->join('tbl_booking_date', 'tbl_booking_date.BookingDateID = tbl_booking_loads.BookingDateID'); 		
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_booking_loads.DriverID'); 		  
		$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID'); 
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID'); 
		$this->db->join('tbl_materials', 'tbl_materials.MaterialID = tbl_booking_loads.MaterialID'); 
		$this->db->where('tbl_drivers.ContractorID',$ContractorID); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
					$this->db->group_end();

				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads');
		//echo $this->db->last_query(); 
		//exit; 
		
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	
	public function GetLoadsData(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		//$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		//$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		//$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');
		
		$this->db->join('tbl_booking_date', ' tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID ', 'LEFT'); 		 
		$this->db->join('tbl_drivers', ' tbl_booking_loads.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID', 'LEFT'); 		
		$this->db->join('tbl_drivers_login', ' tbl_drivers.DriverID = tbl_drivers_login.DriverID ', 'LEFT'); 		 
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID ', 'LEFT'); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID ', 'LEFT'); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID ', 'LEFT'); 
		 
		$this->db->where('tbl_booking_loads.Status < 4 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						//$this->db->or_like('  DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like('tbl_booking.BookingDateTime ', $s[$i]);   
						
						$this->db->or_like(' tbl_booking_loads.AllocatedDateTime', $s[$i]);   
						//$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
					$this->db->group_end();

				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads');
		//echo $this->db->last_query(); 
		//exit; 
		
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	public function GetNonAppsLoadsData1(){
 		$this->db->select(' tbl_booking_date.BookingDateID  ');  	 		
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		 
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.DriverName as dDriverName ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');
		
		$this->db->join('tbl_booking', ' tbl_booking_loads.BookingID = tbl_booking.BookingID ' , 'LEFT'); 		
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		 
		
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		
		$this->db->where('tbl_booking_loads.Status < 4 '); 
		$this->db->where('tbl_drivers.ContractorID  <> 0 '); 
		$this->db->where('tbl_drivers.AppUser = 1 ');  
		$this->db->order_by('tbl_booking_loads.LoadID','ASC');			 
        $query = $this->db->get('tbl_booking_loads');
		//echo $this->db->last_query(); 
		//exit;  
		return $result = $query->result();       
    }
	
	public function GetNonAppsLoadsData(){
 		$this->db->select(' tbl_booking_date.BookingDateID  ');  	 		
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		 
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.DriverName as dDriverName ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');
		
		$this->db->join('tbl_booking', ' tbl_booking_loads.BookingID = tbl_booking.BookingID ' , 'LEFT'); 		
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		 
		
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		
		$this->db->where('tbl_booking_loads.Status < 4 '); 
		$this->db->where('tbl_drivers.ContractorID  <> 0 '); 
		$this->db->where('tbl_drivers.AppUser = 1 ');  
		$this->db->order_by('tbl_booking_loads.LoadID','ASC');			 
        $query = $this->db->get('tbl_booking_loads');
		//echo $this->db->last_query(); 
		//exit;  
		return $result = $query->result();       
    }
	
	
	/*public function GetNonAppsLoadsData(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		 
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.DriverName as dDriverName ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');
		
		$this->db->join('tbl_booking', ' tbl_booking_loads.BookingID = tbl_booking.BookingID ' , 'LEFT'); 		
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		 
		
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		
		$this->db->where('tbl_booking_loads.Status < 4 '); 
		$this->db->where('tbl_drivers.ContractorID  <> 0 '); 
		$this->db->where('tbl_drivers.AppUser = 1 '); 
		//$this->db->where('tbl_drivers.ContractorID  > 1 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
					$this->db->group_end();

				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads');
		//echo $this->db->last_query(); 
		//exit; 
		
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    } */
	
	public function GetContractorLoadsData(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		 
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.DriverName as dDriverName ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');
		
		$this->db->join('tbl_booking', ' tbl_booking_loads.BookingID = tbl_booking.BookingID ' , 'LEFT'); 		
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		 
		
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		
		$this->db->where('tbl_booking_loads.Status < 4 '); 
		$this->db->where('tbl_drivers.ContractorID  <> 0 '); 
		$this->db->where('tbl_drivers.AppUser = 1 '); 
		//$this->db->where('tbl_drivers.ContractorID  > 1 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
					$this->db->group_end();

				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads');
		//echo $this->db->last_query(); 
		//exit; 
		
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	
	public function GetLoadsData1(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');
		//$this->db->select(' tbl_drivers.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		
		//$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		//$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		//$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');		
		
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID '); 		
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID  '); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo '); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID',"LEFT"); 		
		$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ',"LEFT"); 		
		
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		 
		$this->db->where('tbl_booking_loads.Status = 4 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						
					$this->db->group_end(); 
				}
			}    
        }
		 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads');
        //echo $this->db->last_query(); 
		//exit; 
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	public function GetLoadsData2(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');
		//$this->db->select(' tbl_drivers.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		//$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		//$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		//$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');		
		 		 
		$this->db->join('tbl_booking', ' tbl_booking_loads.BookingID = tbl_booking.BookingID  '); 		
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID '); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo '); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID',"LEFT"); 		
		$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ',"LEFT"); 		
		 
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 
		
		
		$this->db->where('tbl_booking_loads.Status = 5 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						
					$this->db->group_end(); 
				}
			}    
        }
		 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads');
        //echo $this->db->last_query(); 
		//exit; 
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	
	
	public function GetConveyanceTickets(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
 
        $this->db->start_cache();  
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads.ReceiptName ');  
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.LoadID '); 
		$this->db->select(' tbl_booking_loads.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' tbl_company.CompanyName ');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_opportunities.OpportunityName ');
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  	 	  	 	  
		//$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		//$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		//$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		
		//$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID ','LEFT'); 		
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID '); 		
		//$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ','LEFT'); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo '); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ','LEFT'); 	
		$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID '); 	
		//$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID ','LEFT'); 
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		//$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID ','LEFT'); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		//$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID = tbl_materials.MaterialID '); 
		$this->db->where('tbl_booking_loads.Status = 4 '); 
		$this->db->where('tbl_drivers.AppUser = 0 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d-%m-%Y %T")  ', $s[$i]);
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
					$this->db->group_end(); 
				}
			}    
        }
		 
		$this->db->order_by($columnName, $columnSortOrder);	 
        $query = $this->db->get('tbl_booking_loads');
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	
	public function GetLoadsMessage(){ 
	
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();  
		$this->db->select(' tbl_drivers_login.DriverName ');  	 		 
		$this->db->select(' tbl_driver_message.Status ');  	 		
		$this->db->select(' tbl_driver_message.Message ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_driver_message.CreateDateTime,"%d-%m-%Y %T") as CreateDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_driver_message.UpdateDateTime,"%d-%m-%Y  %T") as UpdateDateTime ');  	 	   
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_driver_message.DriverID'); 		
		$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID'); 	
		$this->db->where('tbl_driver_message.Message <> "" ');  
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_driver_message.Message', $s[$i]); 
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_driver_message.CreateDateTime,"%d-%m-%Y %T")', $s[$i]); 
					$this->db->group_end(); 
				}
			}    
        }
		$this->db->group_by("tbl_driver_message.TableID");              
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_driver_message');
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
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
	
	
	public function GetDriverLoadsCollection($searchdate,$driver){ 
	 
	  	$sd= explode('/', $searchdate);    
		$firstDate = trim($sd[2]).'-'.trim($sd[1]).'-'.trim($sd[0]); 
		 
        $per= $this->db->dbprefix;   
	    $this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		 
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.LoadID ');  
		$this->db->select(' tbl_booking_loads.TipNumber ');  
		$this->db->select(' tbl_booking_loads.Status ');    
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		 
		$this->db->select(' tbl_materials.MaterialName ');	 
		$this->db->select(' tbl_opportunities.OpportunityName ');	 
		$this->db->select(' tbl_booking_loads.TipID ');	 
		$this->db->select(' tbl_tipaddress.TipName ');	  
		$this->db->select(' tbl_tipticket.TipID as TicketTipID ');	  
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y %T") as TipTicketDateTime ');  	 	  		
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y %T") as TicketDateTime ');  	 	  		 
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	  		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as AllocatedDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d-%m-%Y %T") as JobStartDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobEndDateTime,"%d-%m-%Y %T") as JobEndDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteInDateTime,"%d-%m-%Y %T") as SiteInDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');   
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID ',"LEFT"); 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads.LoadID =tbl_tipticket.LoadID ',"LEFT"); 
		$this->db->join('tbl_tickets', 'tbl_booking_loads.LoadID =tbl_tickets.LoadID ',"LEFT"); 
		//$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID  = tbl_booking_date.BookingDateID  ',"LEFT");  
		$this->db->join(' tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID ',"LEFT");  
		$this->db->join(' tbl_tipaddress', 'tbl_booking_loads.TipID =tbl_tipaddress.TipID ',"LEFT"); 
		$this->db->join(' tbl_materials', ' tbl_booking_loads.MaterialID = tbl_materials.MaterialID',"LEFT");  
	    //$this->db->where('tbl_booking_loads.DriverID',$driver); 
		$this->db->where('tbl_booking_loads.DriverLoginID',$driver); 
		$this->db->where(' tbl_booking.BookingType','1'); 
		//$this->db->where(' DATE_FORMAT(tbl_booking_date.BookingDate,"%Y-%m-%d") ', $firstDate);    
	  	$this->db->where(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") ', $firstDate);    
		$this->db->group_by("tbl_booking_loads.LoadID");             
	    $query = $this->db->get('tbl_booking_loads');
		
		//echo $this->db->last_query(); 
		//exit; 
	    return $query->result();
	}
	
	public function GetDriverLoadsDelivery($searchdate,$driver){ 
	 
	  	$sd= explode('/', $searchdate);    
		$firstDate = trim($sd[2]).'-'.trim($sd[1]).'-'.trim($sd[0]); 
		 
        $per= $this->db->dbprefix;   
	    $this->db->select(' tbl_booking_loads.BookingID  as BookingID  ');  	 		 
		$this->db->select(' tbl_booking_loads.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_tickets.TicketNumber ');  
		$this->db->select(' tbl_booking_loads.LoadID ');  
		$this->db->select(' tbl_booking_loads.TipNumber ');  
		$this->db->select(' tbl_booking_loads.Status ');   
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		 
		$this->db->select(' tbl_materials.MaterialName ');	 
		$this->db->select(' tbl_opportunities.OpportunityName ');	 
		$this->db->select(' tbl_booking_loads.TipID ');	 
		$this->db->select(' tbl_tipaddress.TipName ');	  
		$this->db->select(' tbl_tipticket.TipID as TicketTipID ');	  
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y %T") as TipTicketDateTime ');  	 	  		
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	  		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as AllocatedDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d-%m-%Y %T") as JobStartDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobEndDateTime,"%d-%m-%Y %T") as JobEndDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteInDateTime,"%d-%m-%Y %T") as SiteInDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');   
		$this->db->join('tbl_booking', 'tbl_booking.BookingID = tbl_booking_loads.BookingID'); 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads.LoadID =tbl_tipticket.LoadID ',"LEFT"); 
		//$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID  = tbl_booking_date.BookingDateID  ',"LEFT");  
		$this->db->join('tbl_tickets', 'tbl_tickets.TicketNo = tbl_booking_loads.TicketID'); 
		$this->db->join(' tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID');  
		$this->db->join(' tbl_tipaddress', 'tbl_tipaddress.TipID = tbl_booking_loads.TipID'); 
		$this->db->join(' tbl_materials', 'tbl_materials.MaterialID = tbl_booking_loads.MaterialID');  
	    //$this->db->where('tbl_booking_loads.DriverID',$driver); 
		$this->db->where('tbl_booking_loads.DriverLoginID',$driver); 
		$this->db->where(' tbl_booking.BookingType','2'); 
	  	$this->db->where(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") ', $firstDate);    
		//$this->db->where(' DATE_FORMAT(tbl_booking_date.BookingDate,"%Y-%m-%d") ', $firstDate);    
		$this->db->group_by("tbl_booking_loads.LoadID");             
	    $query = $this->db->get('tbl_booking_loads');
		
		//echo $this->db->last_query(); 
		//exit; 
	    return $query->result();
	}
	function BookingLoadInfo($id){
		$this->db->select('tbl_booking_loads.LoadID');  
		$this->db->select('tbl_booking_loads.Status');   
		$this->db->select('tbl_booking_loads.ConveyanceNo');   
		$this->db->select('tbl_booking_loads.DriverName');   
		$this->db->select('tbl_booking_loads.VehicleRegNo');   
		$this->db->select('tbl_booking_loads.Signature');   
		$this->db->select('tbl_booking_loads.DriverID');   
		$this->db->select('tbl_booking_loads.DriverLoginID');   
		$this->db->select('tbl_booking_loads.Tare');    
		$this->db->select('tbl_booking_loads.CustomerName');  
		$this->db->select('tbl_booking_loads.ReceiptName');   
		$this->db->select('tbl_booking_loads.BookingID');   
		$this->db->select('tbl_booking_loads.TipID ');	
		$this->db->select('tbl_booking_loads.TicketID ');	
		$this->db->select('tbl_booking_loads.TipNumber ');	
		$this->db->select('tbl_booking_loads.GrossWeight ');	
		
		$this->db->select('tbl_booking.LoadType');   
		$this->db->select('tbl_booking.LorryType');   
		$this->db->select('tbl_booking.CompanyID ');	
		$this->db->select('tbl_booking.BookingType');   
		$this->db->select('tbl_booking.OpportunityID ');	 
		
		$this->db->select(' tbl_materials.MaterialName ');			
		$this->db->select(' tbl_materials.MaterialID ');		
		$this->db->select(' tbl_materials.SicCode ');			 
        
		$this->db->select(' tbl_company.CompanyName ');    
		$this->db->select(' tbl_opportunities.OpportunityName ');	  
		 
		$this->db->select(' tbl_tipaddress.TipName ');	 
		$this->db->select(' tbl_tipaddress.PermitRefNo ');	
		$this->db->select(' tbl_tipaddress.Street1 ');	
		$this->db->select(' tbl_tipaddress.Street2 ');	
		$this->db->select(' tbl_tipaddress.Town ');	
		$this->db->select(' tbl_tipaddress.County ');	
		$this->db->select(' tbl_tipaddress.PostCode ');	
		
		$this->db->select(' tbl_drivers.Haulier ');	 
		$this->db->select(' tbl_drivers.DriverName as lorry_driver_name ');	 
		$this->db->select(' tbl_drivers.RegNumber as lorry_RegNumber');	 
		$this->db->select(' tbl_drivers.Tare  as lorry_tare');	  
		$this->db->select(' tbl_drivers.ltsignature as lorry_signature');	 
		
		$this->db->select(' tbl_drivers_login.Signature as dsignature ');	 
		$this->db->from('tbl_booking_loads'); 
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID ',"LEFT");  
		$this->db->join(' tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo  ',"LEFT");  
		$this->db->join(' tbl_drivers_login', 'tbl_booking_loads.DriverLoginID = tbl_drivers_login.DriverID  ',"LEFT");  
		$this->db->join(' tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID ',"LEFT");  
		$this->db->join(' tbl_tipaddress', 'tbl_booking_loads.TipID = tbl_tipaddress.TipID ',"LEFT"); 
		$this->db->join(' tbl_materials', 'tbl_materials.MaterialID = tbl_booking_loads.MaterialID',"LEFT");   
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID',"LEFT");  
        $this->db->where('tbl_booking_loads.LoadID ',$id);		
		$query = $this->db->get(); 
		return $query->row();
		//return $query->row_array();
	}
	function BookingTicketInfo($TicketID){
        $this->db->select(' DATE_FORMAT(TicketDate,"%d/%m/%Y %T") as tdate ');  
		$this->db->select('tbl_tickets.TicketNumber, tbl_tickets.RegNumber, tbl_tickets.Hulller, tbl_tickets.SicCode, tbl_tickets.GrossWeight, tbl_tickets.Tare, tbl_tickets.Net '); 
		$this->db->select('tbl_company.CompanyName');
		$this->db->select('tbl_opportunities.OpportunityName');
		$this->db->select('tbl_materials.MaterialName');
        $this->db->from('tbl_tickets');
        $this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID'); 
        $this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 
		$this->db->join('tbl_materials', 'tbl_tickets.MaterialID = tbl_materials.MaterialID'); 
        $this->db->where("tbl_tickets.TicketNo", $TicketID);                     
        $query = $this->db->get(); 
       // echo $this->db->last_query();       
        $result = $query->row_array();        
        return $result;
    }
 
}

  