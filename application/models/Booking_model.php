<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Booking_model extends CI_Model{ 
    function ShowProductLogs($ProductID)
    {
        $this->db->select(' DATE_FORMAT(tbl_site_logs.CreateDateTime,"%d/%m/%Y %T") as LogDateTime ');        
		$this->db->select(' tbl_site_logs.SitePage, tbl_site_logs.PrimaryID, tbl_site_logs.UpdateType, tbl_site_logs.UpdatedValue, tbl_site_logs.UpdatedCondition  ');        
		$this->db->select('tbl_users.userId , tbl_users.name as CreatedByName '); 
        $this->db->from('tbl_site_logs');
		$this->db->join('tbl_users', 'tbl_site_logs.UpdatedByUserID = tbl_users.userId ','LEFT');  
        $this->db->where('tbl_site_logs.TableName', 'tbl_product');
		$this->db->where('tbl_site_logs.PrimaryID', $ProductID);
		$this->db->order_by('tbl_site_logs.CreateDateTime', 'desc');  
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	
	function ShowBookingLogs($BookingID)
    {
        $this->db->select(' DATE_FORMAT(tbl_site_logs.CreateDateTime,"%d/%m/%Y %T") as LogDateTime ');        
		$this->db->select(' tbl_site_logs.SitePage, tbl_site_logs.PrimaryID, tbl_site_logs.UpdateType, tbl_site_logs.UpdatedValue, tbl_site_logs.UpdatedCondition  ');        
		$this->db->select('tbl_users.userId , tbl_users.name as CreatedByName '); 
        $this->db->from('tbl_site_logs');
		$this->db->join('tbl_users', 'tbl_site_logs.UpdatedByUserID = tbl_users.userId ','LEFT');  
        $this->db->where('tbl_site_logs.TableName', 'tbl_booking1');
		$this->db->where('tbl_site_logs.PrimaryID', $BookingID);
		$this->db->order_by('tbl_site_logs.CreateDateTime', 'desc');  
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
    public function GetBookingDetails($BookingRequestID,$BookingType){
		$this->db->select('tbl_booking1.BookingType');  
		$this->db->select('tbl_booking1.LoadType');  	 	  
		$this->db->select('tbl_booking1.TonBook');  	 	  
		$this->db->select('tbl_booking1.Loads');    
		$this->db->select('tbl_booking1.MaterialName'); 
		$this->db->select('tbl_booking_request.CompanyName'); 
		$this->db->select('tbl_booking_request.OpportunityName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y") as BookingDate '); 
		$this->db->select('tbl_booking_date1.BookingDateID '); 
		$this->db->select('tbl_booking_date1.BookingID '); 
		$this->db->from('tbl_booking_date1');    
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID = tbl_booking1.BookingID ',"LEFT");     
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID',"LEFT");      
		$this->db->where('tbl_booking_date1.BookingRequestID',$BookingRequestID); 		 
		$this->db->where('tbl_booking1.BookingType',$BookingType); 		 
		$query = $this->db->get();
		//echo $this->db->last_query();       
	    //exit;
		$result = $query->result();
		return $result;
	}
	function CheckTicketNumber($ConveyanceNo,$OppoID){
		$this->db->select('tbl_tickets.TicketNumber'); 
		$this->db->select('tbl_tickets.TicketNo'); 		
        $this->db->from('tbl_tickets');
		$this->db->where('tbl_tickets.Conveyance',$ConveyanceNo);
		$this->db->where('tbl_tickets.OpportunityID',$OppoID);
		$this->db->where('tbl_tickets.is_tml','1');
		$this->db->where('tbl_tickets.LoadID','0');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function GetLoadTimeStamp($LoadID)
    { 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteInDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEndDateTime ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOutDateTime ');    
        $this->db->from('tbl_booking_loads1');  
        $this->db->where('tbl_booking_loads1.LoadID', $LoadID);                     
        $query = $this->db->get(); 
        //echo $this->db->last_query();       
	    //exit;
        $result = $query->row_array();  
		//$result = $query->result(); 		  
        return $result;
    }
	function IsTonnageBooking($BookingRequestID){ 
		$this->db->select(' tbl_booking1.TonBook ');  	          
		$this->db->from('tbl_booking1');          
		$this->db->where('tbl_booking1.BookingRequestID', $BookingRequestID);   
		$this->db->limit(1);
        $query = $this->db->get();
        //echo $this->db->last_query();       
	   // exit;
        $result = $query->row_array();        
        return $result;
    }
	function FetchBookingDate($BookingID){
		$this->db->select('tbl_booking_date1.BookingDate');    
        $this->db->from('tbl_booking_date1');          
		$this->db->where('tbl_booking_date1.BookingID',$BookingID); 
		$this->db->order_by('tbl_booking_date1.BookingDate', 'ASC');  		
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}
	function FetchSameBookingMaterialPrice($BookingRequestID,$MaterialID){
		$this->db->select('tbl_booking1.Price');    
        $this->db->from('tbl_booking1');          
		$this->db->where('tbl_booking1.BookingRequestID',$BookingRequestID); 
		$this->db->where('tbl_booking1.MaterialID',$MaterialID); 
		$this->db->order_by('tbl_booking1.BookingID', 'desc');  		
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}
	
	function FetchBookingID($BookingDateID){
		$this->db->select('tbl_booking_date1.BookingID');    
        $this->db->from('tbl_booking_date1');          
		$this->db->where('tbl_booking_date1.BookingDateID',$BookingDateID); 	 
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}
	function FetchLoadIDTickets($TicketNo){
		$this->db->select('tbl_tickets.LoadID');    
        $this->db->from('tbl_tickets');          
		$this->db->where('tbl_tickets.TicketNo',$TicketNo); 	 
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}	
	
	function FetchTicketNumber($ConveyanceNo,$CompanyID,$OpportunityID,$ConveyanceDate,$DriverID){ 
		$this->db->select('tbl_tickets.TicketNo');    
		$this->db->select('tbl_tickets.TicketNumber');    
		$this->db->select('tbl_tickets.pdf_name');     
		$this->db->from('tbl_tickets');    
		$this->db->where('tbl_tickets.CompanyID',$CompanyID); 	 
		$this->db->where('tbl_tickets.Conveyance',$ConveyanceNo);
		$this->db->where('tbl_tickets.OpportunityID',$OpportunityID);  
		$this->db->where('tbl_tickets.driver_id',$DriverID); 	  
		$this->db->where('DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y")',$ConveyanceDate ); 	   
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//exit;
		return $query->row_array();
	}
	
	function FetchDeliveryTicketNumber($TicketNumber){ 
		$this->db->select('tbl_tickets.TicketNo');    
		$this->db->select('tbl_tickets.TicketNumber');     
		$this->db->select('tbl_tickets.GrossWeight');   
		$this->db->select('tbl_tickets.pdf_name');     
		$this->db->select('DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y") as TicketDate');         
		$this->db->from('tbl_tickets');     
		$this->db->where('tbl_tickets.TicketNumber',$TicketNumber); 	   
		$query = $this->db->get(); 
		//echo $this->db->last_query();
		//exit;
		return $query->row_array();
	}
	function GetCountCollectionBooking($BookingRequestID){
		$sql = 'select COUNT(*) as CountCollection from tbl_booking1 
		where tbl_booking1.BookingRequestID = "'.$BookingRequestID.'" and tbl_booking1.BookingType = 1 ';  
		$query = $this->db->query($sql);
		return $query->row();
		//return $query->row_array();
	}
	function GetCountDeliveryBooking($BookingRequestID){
		$sql = 'select COUNT(*) as CountCollection from tbl_booking1 
		where tbl_booking1.BookingRequestID = "'.$BookingRequestID.'" and tbl_booking1.BookingType = 2 ';  
		$query = $this->db->query($sql);
		return $query->row();
		//return $query->row_array();
	}
	
	function CountBookingDateID($ID){
		$sql = 'select COUNT(*) as CNT from tbl_product where tbl_product.BookingDateID = "'.$ID.'" ';  
		$query = $this->db->query($sql);
		return $query->row();
		//return $query->row_array();
	}
	
	function CountProductBookingID($BookingID){
		$sql = 'select COUNT(*) as CNT from tbl_product where tbl_product.BookingID = "'.$BookingID.'" ';  
		$query = $this->db->query($sql);
		return $query->row();
		//return $query->row_array();
	}
	 
	public function GetBookingRequestInfo($BookingDateID){
		   
 		$this->db->select(' tbl_booking_request.OpportunityID');        
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber');        
		$this->db->select(' tbl_booking1.PurchaseOrderNo'); 
		$this->db->select(' tbl_booking1.LorryType');        
		$this->db->select(' tbl_booking1.MaterialID');         
		$this->db->select(' tbl_booking1.Loads');        
		$this->db->select(' tbl_booking_date1.BookingDate ');         
		$this->db->from('tbl_booking_date1');          
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID  = tbl_booking_request.BookingRequestID  ','LEFT');      
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID  = tbl_booking1.BookingID  ','LEFT');      
		$this->db->where('tbl_booking_date1.BookingDateID',$BookingDateID);  
		$this->db->group_by('tbl_booking_date1.BookingDateID');             
		$query = $this->db->get();      
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	public function GetBookingIDRequestInfo($BookingID){
		   
 		$this->db->select(' tbl_booking_request.OpportunityID');        
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber');     
		$this->db->select(' tbl_booking1.PurchaseOrderNo');    
		$this->db->select(' tbl_booking1.LorryType');        
		$this->db->select(' tbl_booking1.MaterialID');         
		$this->db->select(' tbl_booking1.Loads');        
		$this->db->select(' tbl_booking_date1.BookingDate ');  
		$this->db->select(' tbl_booking_date1.BookingDateID ');  		
		$this->db->from('tbl_booking_date1');          
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID  = tbl_booking_request.BookingRequestID  ','LEFT');      
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID  = tbl_booking1.BookingID  ','LEFT');      
		$this->db->where('tbl_booking_date1.BookingID',$BookingID);  
		//$this->db->group_by('tbl_booking_date1.BookingDateID');             
		$this->db->order_by('tbl_booking_date1.BookingDate', 'asc');
		$this->db->limit(1);
		$query = $this->db->get();      
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	
	public function GetBookingRequestDates($BookingRequestID){
		 
		$this->db->select(' tbl_booking1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking1.BookingID ');  	 		  		 
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');   
		$this->db->select(' tbl_booking1.BookingType '); 
		
		$this->db->select(' tbl_booking1.TonBook ');
		$this->db->select(' tbl_booking1.TotalTon ');
		$this->db->select(' tbl_booking1.TonPerLoad ');
		
		$this->db->select(' tbl_booking1.DayWorkType ');
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads ');  
		$this->db->select(' tbl_booking1.Price '); 
		$this->db->select(' tbl_booking1.TotalAmount '); 
		$this->db->select(' tbl_booking1.MaterialID  ');       
		$this->db->select(' tbl_booking1.MaterialName  '); 
		$this->db->select(' tbl_booking1.SICCode  '); 
		$this->db->select(' tbl_booking1.PurchaseOrderNo  '); 
		$this->db->select(' tbl_booking1.OpenPO  '); 
		
		$this->db->select('(select GROUP_CONCAT(DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y") separator ",")  as BookingDate1 FROM tbl_booking_date1 where tbl_booking_date1.BookingID = tbl_booking1.BookingID ) as BookingDate1 ');  
		$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking1.BookingID = tbl_booking_loads1.BookingID  and  tbl_booking1.BookingRequestID = tbl_booking_loads1.BookingRequestID  ) as TotalLoadAllocated ');   
		$this->db->from('tbl_booking1');         
		$this->db->join('tbl_booking_date1', ' tbl_booking1.BookingID  = tbl_booking_date1.BookingID  ','LEFT');      
		$this->db->where('tbl_booking1.BookingRequestID',$BookingRequestID);  
		$this->db->group_by('tbl_booking1.BookingID');             
		$query = $this->db->get();      
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	
	public function GetBookingRequestDatesHaulage($BookingRequestID){
		 
		$this->db->select(' tbl_booking1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking1.BookingID ');  	 		  		 
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');   
		$this->db->select(' tbl_booking1.BookingType '); 
		
		$this->db->select(' tbl_booking1.TonBook ');
		$this->db->select(' tbl_booking1.TotalTon ');
		$this->db->select(' tbl_booking1.TonPerLoad ');
		
		$this->db->select(' tbl_booking1.DayWorkType ');
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads ');  
		$this->db->select(' tbl_booking1.Price '); 
		$this->db->select(' tbl_booking1.TotalAmount '); 
		$this->db->select(' tbl_booking1.MaterialID  ');       
		$this->db->select(' tbl_booking1.MaterialName  '); 
		$this->db->select(' tbl_booking1.SICCode  '); 
		
		$this->db->select(' tbl_booking1.PurchaseOrderNo  '); 
		$this->db->select(' tbl_booking1.OpenPO  '); 
		
		$this->db->select(' tbl_tipaddress.TipID '); 
		$this->db->select(' tbl_tipaddress.TipName '); 
		
		//$this->db->select(' tbl_tipaddress.Street1 '); 
		//$this->db->select(' tbl_tipaddress.Street1 '); 
		//$this->db->select(' tbl_tipaddress.Town '); 
		//$this->db->select(' tbl_tipaddress.County '); 
		//$this->db->select(' tbl_tipaddress.PostCode '); 
		
		
		$this->db->select('(select GROUP_CONCAT(DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y") separator ",")  as BookingDate1 FROM tbl_booking_date1 where tbl_booking_date1.BookingID = tbl_booking1.BookingID ) as BookingDate1 ');  
		$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking1.BookingID = tbl_booking_loads1.BookingID  and  tbl_booking1.BookingRequestID = tbl_booking_loads1.BookingRequestID  ) as TotalLoadAllocated ');   
		$this->db->from('tbl_booking1');         
		$this->db->join('tbl_booking_date1', ' tbl_booking1.BookingID  = tbl_booking_date1.BookingID  ','LEFT');      
		$this->db->join('tbl_tipaddress', ' tbl_booking1.TipID  = tbl_tipaddress.TipID  ','LEFT');      
		$this->db->where('tbl_booking1.BookingRequestID',$BookingRequestID);  
		$this->db->group_by('tbl_booking1.BookingID');             
		$query = $this->db->get();      
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	 
	function GetOppoMaterialListDetails($OpportunityID,$MaterialID,$DateRequired,$LorryType){ 
        $this->db->select('tbl_product.UnitPrice');  	 		 
		$this->db->select('tbl_product.PurchaseOrderNo');  
		
		$this->db->select('tbl_booking1.PurchaseOrderNo as PON');  
		$this->db->select('tbl_booking1.OpenPO');  
		
		$this->db->select('DATE_FORMAT(tbl_product.DateRequired,"%d/%m/%Y") as PriceDate');  
		$this->db->from('tbl_product'); 
		$this->db->join('tbl_booking1', ' tbl_product.BookingID  = tbl_booking1.BookingID  ','LEFT'); 
		$this->db->where('tbl_product.OpportunityID',$OpportunityID);  
		$this->db->where('tbl_product.MaterialID',$MaterialID); 
		$this->db->where('tbl_product.LorryType',$LorryType); 
		$this->db->where('tbl_product.PriceType','0');  		
		$this->db->where('DATE_FORMAT(tbl_product.DateRequired,"%Y-%m-%d") <= "'.trim($DateRequired).'" ');  
		$this->db->order_by('tbl_product.DateRequired', 'desc');
		$this->db->limit(1);
		//$query = $this->db->get('tbl_product');
		$query = $this->db->get();   
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	function GetHaulageOppoMaterialListDetails($OpportunityID,$TipName,$DateRequired,$LorryType){ 
        $this->db->select('tbl_product.UnitPrice');  	 		 
		$this->db->select('tbl_product.PurchaseOrderNo'); 
		
		$this->db->select('tbl_booking1.PurchaseOrderNo as PON');  
		$this->db->select('tbl_booking1.OpenPO');  
		
		$this->db->select('DATE_FORMAT(tbl_product.DateRequired,"%d/%m/%Y") as PriceDate');  
		$this->db->from('tbl_product'); 
		$this->db->join('tbl_booking1', ' tbl_product.BookingID  = tbl_booking1.BookingID  ','LEFT'); 
		$this->db->where('tbl_product.OpportunityID',$OpportunityID);  
		$this->db->where('tbl_product.TipName',$TipName); 
		$this->db->where('tbl_product.LorryType',$LorryType); 
		$this->db->where('tbl_product.PriceType','0');  		
		$this->db->where('DATE_FORMAT(tbl_product.DateRequired,"%Y-%m-%d") <= "'.trim($DateRequired).'" ');  
		$this->db->order_by('tbl_product.DateRequired', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();  
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	 
	function GetOppoMaterialListTonnageDetails($OpportunityID,$MaterialID,$DateRequired,$LorryType){ 
        $this->db->select('tbl_product.UnitPrice');  	 		 
		$this->db->select('tbl_product.PurchaseOrderNo'); 

		$this->db->select('tbl_booking1.PurchaseOrderNo as PON');  
		$this->db->select('tbl_booking1.OpenPO');  
				
		$this->db->select('DATE_FORMAT(tbl_product.DateRequired,"%d/%m/%Y") as PriceDate');  
		
		$this->db->from('tbl_product'); 
		$this->db->join('tbl_booking1', ' tbl_product.BookingID  = tbl_booking1.BookingID  ','LEFT'); 
		$this->db->where('tbl_product.OpportunityID',$OpportunityID);  
		$this->db->where('tbl_product.MaterialID',$MaterialID);  
		$this->db->where('tbl_product.LorryType',$LorryType); 
		$this->db->where('tbl_product.PriceType','1');  
		$this->db->where('DATE_FORMAT(tbl_product.DateRequired,"%Y-%m-%d") <= "'.trim($DateRequired).'" ');  
		$this->db->order_by('tbl_product.DateRequired', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();  
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
	function LastContactID($OpportunityID){ 
        $this->db->select(' tbl_booking_request.ContactID ');  	  
		$this->db->select(' tbl_booking_request.ContactName ');  	  
		$this->db->select(' tbl_booking_request.ContactMobile ');  	  
		$this->db->select(' tbl_booking_request.ContactEmail ');  	  
		$this->db->where('tbl_booking_request.OpportunityID', $OpportunityID); 
		$this->db->order_by('tbl_booking_request.CreateDateTime ','DESC');
		$this->db->limit(1);
		$query = $this->db->get('tbl_booking_request');
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
		$this->db->where('tbl_contacts.MobileNumber <> "" '); 
		$this->db->where('tbl_contacts.Type', '1'); 
		//$this->db->order_by('tbl_contacts.Type', 'DESC');
		$this->db->order_by('tbl_contacts.ContactName', 'ASC');
		$this->db->limit(1);
        $query = $this->db->get();        
        $result = $query->result();        
        return $result;
    }
	function getOppoByID($OpportunityID){
        $this->db->select('tbl_opportunities.OpportunityName ,tbl_opportunities.Street1 , tbl_opportunities.Street2, tbl_opportunities.Town, tbl_opportunities.County, tbl_opportunities.PostCode ');
        $this->db->from('tbl_opportunities');         
        $this->db->where('tbl_opportunities.OpportunityID', $OpportunityID);   
        $query = $this->db->get();        
        return $result = $query->result();         
    }
	
	function GetOpenPO($OpportunityID){
        $this->db->select('tbl_booking_request.PurchaseOrderNumber ');
        $this->db->from('tbl_booking_request');         
        $this->db->where('tbl_booking_request.OpportunityID', $OpportunityID);   
		$this->db->where('tbl_booking_request.OpenPO', '1');   
		$this->db->order_by('tbl_booking_request.BookingRequestID', 'DESC'); 
		$this->db->limit(1);
        $query = $this->db->get();        
        return $result = $query->result();         
    }
	function GetPriceBy($OpportunityID){
        $this->db->select('tbl_booking_request.PriceBy ');
        $this->db->from('tbl_booking_request');         
        $this->db->where('tbl_booking_request.OpportunityID', $OpportunityID);    
		$this->db->order_by('tbl_booking_request.BookingRequestID', 'DESC'); 
		$this->db->limit(1);
        $query = $this->db->get();        
        return $result = $query->result();         
    }
	
	function GetCompanyBookingInfoByID($CompanyID){
        $this->db->select('tbl_company.CompanyID ,tbl_company.CompanyName ,tbl_company.SageURL , tbl_company.PaymentType, tbl_company.CreditLimit, tbl_company.Outstanding  ');
        $this->db->from('tbl_company');         
        $this->db->where('tbl_company.CompanyID', $CompanyID);   
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
		//$this->db->where('tbl_drivers_login.MobileNo <> ""');	
		$this->db->where('tbl_drivers_login.UserName <> ""');		
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
		$this->db->select(' tbl_booking.OpportunityID ');  
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
	function LastInvoiceNo(){
		$this->db->select('InvoiceNumber');    
        $this->db->from('tbl_booking_invoice');         
		$this->db->order_by('InvoiceID', 'DESC');
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
	function BookingRequestLastConNumber(){
		$this->db->select('ConveyanceNo');    
        $this->db->from('tbl_booking_loads1');         
		$this->db->order_by('ConveyanceNo', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}

	function LastConNumber1(){
		$this->db->select('ConveyanceNo','LoadID');    
        $this->db->from('tbl_booking_loads1');         
		$this->db->order_by('LoadID', 'DESC');
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
	function CountLoadsBookingDate($BookingDateID){
		$sql = 'select COUNT(*) as CountLoads from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = "'.$BookingDateID.'" ';  
		$query = $this->db->query($sql);
		//echo $this->db->last_query();       
	    //exit;
	   
	   return $query->row();
		//return $query->row_array();
	}
	function CountBookingID($BookingID){
		$sql = 'select COUNT(*) as CountBookingDate from tbl_booking_date1 where tbl_booking_date1.BookingID = "'.$BookingID.'" ';  
		$query = $this->db->query($sql);
		//echo $this->db->last_query();       
	    //exit;
	   
	   return $query->row();
		//return $query->row_array();
	}	
	function CountBookingRequestID($BookingRequestID){
		$sql = 'select COUNT(*) as CountBooking from tbl_booking1 where tbl_booking1.BookingRequestID = "'.$BookingRequestID.'" ';  
		$query = $this->db->query($sql);
		//echo $this->db->last_query();       
	    //exit;
	   
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
		//$this->db->where('o.Status = "1" ');
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
		$this->db->where('Status', '1');
        $this->db->order_by('MaterialName', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
	function GetMaterials($Type){
        $this->db->select('*');
        $this->db->from('materials');
        $this->db->where('Type', $Type);
		$this->db->where('Status', '1');
        $this->db->order_by('MaterialName', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();       
		//exit;
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
	
	function GetLatestSICCode($OpportunityID,$MaterialID){
        $this->db->select('SICCode');
        $this->db->from('tbl_product');
        $this->db->where('OpportunityID', $OpportunityID);
		$this->db->where('MaterialID', $MaterialID);
        $this->db->order_by('productid', 'desc');
		$this->db->limit(1);
        $query = $this->db->get(); 
		//echo $this->db->last_query();       
	   //exit;
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
       $this->db->select('tbl_drivers_login.DriverID,tbl_drivers.LorryNo,tbl_drivers_login.DriverName,
	   tbl_drivers.RegNumber,tbl_drivers.Haulier,tbl_drivers.Tare,tbl_drivers_login.MobileNo,tbl_drivers_login.Email');
       $this->db->from('tbl_drivers_login');
       $this->db->join('tbl_drivers', 'tbl_drivers_login.DriverID = tbl_drivers.LastDriverID',"LEFT"); 	  
       //$this->db->where('tbl_drivers.RegNumber <> ""'); 
	   //$this->db->where('tbl_drivers.ContractorID = "1"');    
	   $this->db->where('tbl_drivers_login.Password <> ""');
	   $this->db->where('tbl_drivers_login.UserName <> ""'); 
	   $this->db->group_by('tbl_drivers_login.DriverID');             
       $query = $this->db->get();
	   //echo $this->db->last_query();       
	   //exit;
       $result = $query->result();        
       return $result; 
    }
	/*function GetDriverList(){
       $this->db->select('tbl_drivers_login.DriverID,tbl_drivers.LorryNo,tbl_drivers_login.DriverName,
	   tbl_drivers.RegNumber,tbl_drivers.Haulier,tbl_drivers.Tare,tbl_drivers_login.MobileNo,tbl_drivers_login.Email');
       $this->db->from('tbl_drivers_login');
       $this->db->join('tbl_drivers', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID',"LEFT"); 	  
       $this->db->where('tbl_drivers.RegNumber <> ""'); 
	   $this->db->where('tbl_drivers.Haulier = "Thames Material Ltd."');  
	   $this->db->where('tbl_drivers_login.MobileNo <> ""'); 
	   $this->db->where('tbl_drivers_login.Password <> ""'); 
	   $this->db->group_by('tbl_drivers_login.DriverID');             
       $query = $this->db->get();
	   //echo $this->db->last_query();       
	   //exit;
       $result = $query->result();        
       return $result; 
    }*/
	function GetMessageLorryList(){
       $this->db->select('tbl_drivers_login.DriverID,tbl_drivers.LorryNo,tbl_drivers_login.DriverName,
	   tbl_drivers.RegNumber,tbl_drivers.Haulier,tbl_drivers.Tare,tbl_drivers_login.MobileNo ');
       $this->db->from('tbl_drivers');
       $this->db->join('tbl_drivers_login', 'tbl_drivers.LastDriverID = tbl_drivers_login.DriverID',"LEFT"); 	  
       $this->db->where('tbl_drivers.ContractorID = "1" '); 
	   $this->db->where('tbl_drivers.Haulier = "Thames Material Ltd."');   
	   $this->db->group_by('tbl_drivers.LorryNo');             
       $query = $this->db->get();
	   //echo $this->db->last_query();       
	   //exit;
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
        $this->db->join('tbl_drivers_login', 'tbl_booking_loads.DriverID = tbl_drivers_login.DriverID ',"LEFT"); 	
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
		$this->db->select('tbl_booking_loads1.DriverName ');
		$this->db->select('tbl_drivers_login.DriverName as dname ' );
        $this->db->from('tbl_booking_loads1');
        $this->db->join('tbl_tipaddress', ' tbl_booking_loads1.TipID = tbl_tipaddress.TipID  ',"LEFT"); 
		$this->db->join('tbl_drivers', ' tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT"); 
        $this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID  ',"LEFT"); 	   
        $this->db->where('tbl_booking_loads1.BookingDateID', $BookingDateID); 
		$this->db->group_by('tbl_booking_loads1.TipID,tbl_booking_loads1.DriverLoginID,');             
        $query = $this->db->get(); 
        //echo $this->db->last_query();       
	    //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function ShowLoads2($BookingDateID){
        $this->db->select('COUNT(DISTINCT tbl_booking_loads1.DriverID) as QTY ');  
		$this->db->select('tbl_tipaddress.TipName');
		$this->db->select('tbl_booking_loads1.DriverName ');
		$this->db->select('tbl_drivers_login.DriverName as dname ' );
        $this->db->from('tbl_booking_loads1');
        $this->db->join('tbl_tipaddress', ' tbl_booking_loads1.TipID = tbl_tipaddress.TipID  ',"LEFT"); 
		$this->db->join('tbl_drivers', ' tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT"); 
        $this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID  ',"LEFT"); 	   
        $this->db->where('tbl_booking_loads1.BookingDateID', $BookingDateID);
		$this->db->group_by('tbl_booking_loads1.TipID,tbl_booking_loads1.DriverLoginID');             
        $query = $this->db->get(); 
		//echo $this->db->last_query();       
		//exit; 
		$result = $query->result(); 		  
        return $result;
    }
	function ShowLoadDetails($LoadID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEndDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteInDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOutDateTime ');   
		$this->db->select('tbl_booking_loads1.ReceiptName ');    
		$this->db->select('tbl_users.name as CreatedByName , tbl_users.email as CreatedByEmail , tbl_users.mobile as CreatedByMobile ');
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking1.Price, tbl_booking1.PurchaseOrderNo, tbl_booking1.Email, tbl_booking1.Notes, tbl_booking1.ContactName, tbl_booking1.ContactMobile'); 
		$this->db->select('tbl_company.CompanyName, tbl_booking1.CompanyID as ComID, tbl_opportunities.OpportunityName , tbl_booking1.OpportunityID as OppID  ');
		$this->db->select('tbl_booking_loads1.DriverName,tbl_booking_loads1.DriverID, tbl_booking_loads1.VehicleRegNo, tbl_booking_loads1.Status, 
		tbl_booking_loads1.ConveyanceNo, tbl_booking_loads1.TicketID, tbl_booking_loads1.TicketUniqueID');
		$this->db->select('tbl_drivers_login.DriverName as dname, tbl_drivers.RegNumber as vrn, tbl_drivers_login.MobileNo as DriverMobile, tbl_drivers_login.Email as DriverEmail' );
        $this->db->from('tbl_booking_loads1'); 
        $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 
        $this->db->join('tbl_opportunities', 'tbl_booking1.OpportunityID = tbl_opportunities.OpportunityID','LEFT'); 
		$this->db->join('tbl_company', 'tbl_booking1.CompanyID = tbl_company.CompanyID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_booking1.BookedBy = tbl_users.userId ','LEFT'); 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID','LEFT');  
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo','LEFT'); 
        $this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ','LEFT'); 	
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID','LEFT');  
        $this->db->where('tbl_booking_loads1.LoadID', $LoadID);                     
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
        $this->db->join('tbl_booking_loads1', 'tbl_booking_loads_photos.LoadID =tbl_booking_loads1.LoadID','LEFT');   
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
		$this->db->select('tbl_booking_loads1.DriverID');
		$this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") = CURDATE()');   
		$this->db->where('tbl_booking1.BookingType = 2');  
		$this->db->where('tbl_booking1.LoadType = 2');  
		$this->db->where('tbl_booking_loads1.Status < 4');  
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
		$this->db->select('tbl_drivers.LorryNo, tbl_drivers.RegNumber ');
		$this->db->from('tbl_drivers'); 
		$this->db->where('tbl_drivers.RegNumber <> ""');   
		$this->db->where('tbl_drivers.ContractorID = 1 ');  
		$this->db->where('tbl_drivers.AppUser = 0 ');
		$query = $this->db->get();
		return $result = $query->result();     
	}
	function LorryListAJAXNEW(){  
		$this->db->select('tbl_drivers.LorryNo, tbl_drivers.RegNumber, tbl_drivers.next_wordorder_date ');
		$this->db->from('tbl_drivers'); 
		$this->db->where('tbl_drivers.RegNumber <> ""');   
		$this->db->where('tbl_drivers.ContractorID = 1 ');  
		$this->db->where('tbl_drivers.AppUser = 0 ');
		$this->db->where('tbl_drivers.is_under_maintenance = 0 ');
		$query = $this->db->get();
		return $result = $query->result();     
	}
	
	/*function LorryListAJAX(){  
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
	} // 25 05 2022 */
	
	function LorryListNonApp(){  
		$this->db->select('tbl_drivers.LorryNo,tbl_drivers.Tare, tbl_drivers.ContractorID, tbl_drivers.DriverName, tbl_drivers.ContractorLorryNo , tbl_drivers.RegNumber ');
		$this->db->from('tbl_drivers');  
		//$this->db->where('tbl_drivers.Password = "" ');  
		//$this->db->where('tbl_drivers.ContractorID >1 ');  
		$this->db->where('tbl_drivers.ContractorID = 1 ');  
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
		//$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID','left');   
		$this->db->join('tbl_drivers_login', 'tbl_drivers_logs.DriverLoginID = tbl_drivers_login.DriverID','left');   
		$this->db->where(' DATE_FORMAT(tbl_drivers_logs.LoginDatetime,"%Y-%m-%d") = CURDATE()');    
		//$this->db->where('tbl_drivers.DriverID <> 0 ');    
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
	
	function MaterialListAJAX(){  
		$this->db->select('MaterialID,MaterialName,SicCode,Status');
		$this->db->from('tbl_materials'); 
		$this->db->where('tbl_materials.Operation = "IN" ');    
		$this->db->order_by('MaterialID', 'ASC');
		$query = $this->db->get();
		return $result = $query->result();     
	}
	function MaterialListAJAX1(){  
		$this->db->select('MaterialID,MaterialName,SicCode,Status');
		$this->db->from('tbl_materials'); 
		$this->db->where('tbl_materials.Operation = "OUT" ');    
		$this->db->order_by('MaterialID', 'ASC');
		$query = $this->db->get();
		return $result = $query->result();     
	}
	function CompanyOppoRecordsAJAX(){  
		$this->db->select('tbl_opportunities.OpportunityID');
		$this->db->select('tbl_opportunities.OpportunityName');
		$this->db->select('tbl_company.CompanyID');
		$this->db->select('tbl_company.CompanyName'); 
		$this->db->from('tbl_opportunities'); 
		$this->db->join('tbl_company_to_opportunities', 'tbl_opportunities.OpportunityID = tbl_company_to_opportunities.OpportunityID ',"LEFT"); 
		$this->db->join('tbl_company', 'tbl_company_to_opportunities.CompanyID = tbl_company.CompanyID ',"LEFT"); 
		$this->db->where('tbl_opportunities.OpportunityID <> "" ');  
		$this->db->where('tbl_company.CompanyID <> "" ');  
		$this->db->where('tbl_company.CompanyName <> "" ');  
		$this->db->where('tbl_opportunities.OpportunityName <> ",,," ');  
		$this->db->order_by('tbl_company.CompanyName', 'ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();       
	   // exit;
		return $result = $query->result();     
	}	
	function TipListAuthoAJAX($OpportunityID){  
		$this->db->select('tbl_tipaddress.TipName,tbl_tipaddress.TipID,tbl_tipaddress.HType');
		$this->db->from('tbl_opportunity_tip'); 
		$this->db->join('tbl_tipaddress', 'tbl_opportunity_tip.TipID = tbl_tipaddress.TipID',"LEFT"); 
		$this->db->where('tbl_opportunity_tip.OpportunityID ',$OpportunityID);    
		$this->db->where('tbl_opportunity_tip.Status ','0');    
		$this->db->order_by('tbl_tipaddress.TipID', 'ASC');
		$query = $this->db->get();
		//echo $this->db->last_query();       
	    //exit; 
		return $result = $query->result();     
	}
	
	function TipListHaulage($TipID){  
		$this->db->select('tbl_tipaddress.TipName,tbl_tipaddress.TipID ');
		$this->db->from('tbl_tipaddress');  
		$this->db->where('tbl_tipaddress.TipID ',$TipID);     
		$query = $this->db->get();
		//echo $this->db->last_query();       
	    //exit; 
		return $result = $query->result();     
	}
	
	function NonAppBookingDetails($BookingRequestID,$BookingType){  
		$this->db->select("(case when (tbl_booking1.BookingType = '1') then 'Collection'
        when (tbl_booking1.BookingType = '2') then 'Delivery'
        end) as BookingType"); 
		$this->db->select("(case when (tbl_booking1.LorryType = '1') then 'Tipper'
        when (tbl_booking1.LorryType = '2') then 'Grab'
		when (tbl_booking1.LorryType = '3') then 'Bin'
        end) as LorryType"); 
		$this->db->select("(case when (tbl_booking1.LoadType = '1') then 'Loads'
        when (tbl_booking1.LoadType = '2') then 'TurnAround'
        end) as LoadType"); 
		$this->db->select('tbl_booking_date1.BookingID');
		$this->db->select('tbl_booking_date1.BookingDateID');
		$this->db->select('tbl_booking1.MaterialName');
		$this->db->select('tbl_booking1.MaterialID');
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y") as BookingDate ');    		  
		$this->db->from('tbl_booking_date1');  
		$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID',"LEFT"); 
		$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID',"LEFT");  
		$this->db->where('tbl_booking_date1.BookingRequestID ',$BookingRequestID);     
		$this->db->where('tbl_booking1.BookingType',$BookingType);     
		$this->db->order_by('tbl_booking_date1.BookingID', 'ASC');
		$this->db->order_by('tbl_booking_date1.BookingDateID', 'ASC'); 
		$this->db->group_by("tbl_booking_date1.BookingDateID");             
		$query = $this->db->get();
		//echo $this->db->last_query();       
	    //exit; 
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
		$this->db->select(' tbl_booking_loads1.BookingID');  	 		 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads1.Status ');  	 		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y %T") as JobStartDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d-%m-%Y %T") as JobEndDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %T") as SiteInDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  
		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  
		 
		$this->db->select(' tbl_booking_request.OpportunityID ');		   
		$this->db->select(' tbl_booking_request.OpportunityName ');		 
		$this->db->select(' tbl_booking1.MaterialName ');		 
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID '); 		
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID '); 		
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID '); 
		$this->db->join('tbl_drivers', ' tbl_booking_loads1.DriverID = tbl_drivers.LorryNo '); 		
		$this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID'); 	 
		
		//$this->db->where('tbl_booking_loads.Status <> 4 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking1.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]);  
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_date1.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
					$this->db->group_end();

				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads1');
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
		//$this->db->select(' tbl_drivers_login.DriverName as dname ');
		//$this->db->select(' tbl_drivers.DriverName as dname ');  	 		
		//$this->db->select(' tbl_drivers.RegNumber as rname ');  
		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		 
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');		
		
		$this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID ','LEFT'); 		
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID ','LEFT'); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID ','LEFT'); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID  ','LEFT'); 		
		//$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ','LEFT'); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID',"LEFT"); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ',"LEFT"); 		
		 
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
						//$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						//$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_booking_loads.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads.VehicleRegNo', $s[$i]);  
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
		 
		$this->db->select(' tbl_company.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_opportunities.OpportunityName ');		
		 		 
		$this->db->join('tbl_booking', ' tbl_booking_loads.BookingID = tbl_booking.BookingID  ',"LEFT"); 		
		$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID ',"LEFT"); 
		$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID ',"LEFT"); 
		$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID ',"LEFT");  
		$this->db->join('tbl_booking_date', 'tbl_booking_loads.BookingDateID = tbl_booking_date.BookingDateID ',"LEFT"); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads.DriverID = tbl_drivers.LorryNo ',"LEFT"); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID',"LEFT"); 		
		$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ',"LEFT"); 		
		 
		
		
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
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			
			//print_r($Sort);
			//exit;
			//if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; }  
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_tickets.Conveyance '; }  
			if($Sort[0]=='WaitTime'){ $columnName = ' WaitTime '; }  
			///if($Sort[0]=='JobStartDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='TipName'){ $columnName = 'tbl_tipaddress.TipName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			//if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_booking_loads1.DriverName '; } 
			//if($Sort[0]=='Price'){ $columnName = ' tbl_booking1.Price '; } 
			if($Sort[0]=='Price'){ $columnName = ' tbl_booking_loads1.LoadPrice '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($_POST['ConveyanceNo']));  
		$WaitTime = trim(strtolower($_POST['WaitTime']));  
		$Price = trim(strtolower($_POST['Price']));  
		
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));  
		//$JobStartDateTime = trim(strtolower($_POST['JobStartDateTime']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$Status = trim(strtolower($_POST['Status']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
		$TipName = trim(strtolower($_POST['TipName']));   
        $Reservation = trim(strtolower($_POST['Reservation']));
		
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
		 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
				when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
				when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
				when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
		end) as Status");
		//$this->db->select("(case when (tbl_booking_loads1.ReceiptName <> '') then 'Finished'
        ///     when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
        //     when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        //end) as Status"); 
		
		
		//$this->db->select(' 0 as SuppDate ');  
		//$this->db->select(' 0 as SuppNo ');  
		
		//$this->db->select(' td1.FD_650A620E as ConveyanceHW ');  
		//$this->db->select(' td2.FD_650A620E as DeliverySupplier ');  
		$this->db->select(' td3.GUID as ConveyanceGUID ');  
		
		$this->db->select(' trim(tbl_tickets.Conveyance) as TicketConveyance ');   
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		
		$this->db->select(' tbl_tickets.pdf_name ');
		$this->db->select(' tbl_tickets.IsInBound ');		
		$this->db->select(' tbl_tickets.Net  '); 
		$this->db->select(' tbl_tickets.TicketNumber as SuppNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y") as SuppDate ');  	 	  	 	      
		
		$this->db->select(' tbl_tipticket.TipTicketID '); 
		$this->db->select(' tbl_tipticket.TipTicketNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  	 	  	 	      
		
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		  		
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');   		  		
		
		////$this->db->select(' tbl_drivers.RegNumber as rname ');  	 			
		////$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 			
		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	
		 
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');  	
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID '); 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		//$this->db->select(' tbl_booking1.Price ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price  ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_tipaddress.TipName ');
		$this->db->select(' concat(tbl_tipaddress.Street1,tbl_tipaddress.Street2,tbl_tipaddress.Town,tbl_tipaddress.County,tbl_tipaddress.PostCode) as TipAddress '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	       
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as RequestDate ');  	 	  	 	      
	    $this->db->select(' tbl_booking_date1.BookingDateID ');
		$this->db->select(' tbl_booking_date1.BookingRequestID ');
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStart ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteIn ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEnd ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOut ');    
		$this->db->select('ROUND(TIMESTAMPDIFF(MINUTE, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime) - tbl_booking_request.WaitingTime ) AS WaitTime');  
		 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ','LEFT'); 		    
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		    
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo and tbl_tickets.TypeOfTicket = "In" ','LEFT'); 		 
		//$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		 
		 
		$this->db->join('tbl_tickets_documents as td3', 'tbl_tickets.Conveyance = td3.FD_650A620E AND td3.DocTypeID  = "392cf403 " ','LEFT'); 		 
		 
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 1 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]); 
						//$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]); 
						
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						//$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						//$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.LoadPrice', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } 
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60) ,1) ', trim($WaitTime));  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
			$this->db->or_like(' tbl_tickets.Conveyance ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' tbl_booking1.Price ', trim($Price)); 
			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start();
						
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) >=', $StartDate);
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) <=', $EndDate);  
			
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		/*if( !empty(trim($JobStartDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y") ', trim($JobStartDateTime)); 
 			$this->db->group_end();  
        }*/
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
			$this->db->like('tbl_booking_loads1.DriverName', trim($DriverName)); 
 			//$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
			//$this->db->or_like('tbl_drivers_login.DriverName', trim($DriverName));  
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='i' ){ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '8'); 
				$this->db->group_end();  
			} 
			else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
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
		
		
	public function GetDeliveryTickets(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; } 
			if($Sort[0]=='WaitTime'){ $columnName = ' WaitTime '; }  
			//if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking.BookingType '; } 
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			//if($Sort[0]=='Price'){ $columnName = ' tbl_booking1.Price '; } 
			if($Sort[0]=='Price'){ $columnName = ' tbl_booking_loads1.Price '; } 
			if($Sort[0]=='PurchaseOrderNo'){ $columnName = ' tbl_booking1.PurchaseOrderNo '; } 
			if($Sort[0]=='TicketNumber'){ $columnName = ' tbl_tickets.TicketNumber '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($_POST['ConveyanceNo']));  
		$WaitTime = trim(strtolower($_POST['WaitTime']));  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$Status = trim(strtolower($_POST['Status']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
        $Reservation1 = trim(strtolower($_POST['Reservation1']));
		$Price = trim(strtolower($_POST['Price']));
		$PurchaseOrderNo = trim(strtolower($_POST['PurchaseOrderNo']));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation1!=""){
			$RS = explode('-',$Reservation1);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status"); 
		
		$this->db->select(' tbl_tickets.TicketNumber ');      
		$this->db->select(' tbl_tickets.TicketNo ');      
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 	
		$this->db->select(' tbl_booking_loads1.TipID ');  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 			
		
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber '); 
		$this->db->select(' tbl_booking_request.CompanyID');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');  
		$this->db->select(' tbl_materials.Status as MStatus ');
		$this->db->select(' tbl_booking_date1.BookingDateID ');
		$this->db->select(' tbl_booking_date1.BookingRequestID ');
		
		$this->db->select(' tbl_materials.MaterialName '); 
		//$this->db->select(' tbl_booking1.Price '); 
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price '); 
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y") as JobStartDateTime ');  	 	  	 	      
		$this->db->select(' tbl_tickets_documents.ID  as DOCID ');  
		//$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  	 	  	 	      
		$this->db->select('ROUND(TIMESTAMPDIFF(MINUTE, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime) - tbl_booking_request.WaitingTime ) AS WaitTime');   
		//$this->db->select('ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  AS WaitTime');    
		 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStart ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteIn ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEnd ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOut ');    
		  
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 	
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ','LEFT'); 
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		  
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 		 
		$this->db->join('tbl_tickets_documents', 'tbl_tickets.TicketNumber = tbl_tickets_documents.FD_16EB2AD9 AND tbl_tickets_documents.DocTypeID = "1036437d" ','LEFT'); 	 
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 2 '); 
		$this->db->where('tbl_drivers.AppUser = 0 '); 	
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						//$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } 
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.TicketNumber ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' tbl_booking1.Price ', trim($Price)); 
			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='i' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '8'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
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
		
	  
	
	public function GetLoadsMessage(){ 
	
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();  
		$this->db->select(' tbl_drivers.DriverName ');  	 		 
		//$this->db->select(' tbl_drivers_login.DriverName ');  	 		 
		$this->db->select(' tbl_driver_message.Status ');  	 		
		$this->db->select(' tbl_driver_message.Message ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_driver_message.CreateDateTime,"%d-%m-%Y %T") as CreateDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_driver_message.UpdateDateTime,"%d-%m-%Y  %T") as UpdateDateTime ');  	 	   
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_driver_message.DriverID',"LEFT"); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers.DriverID = tbl_drivers_login.DriverID ',"LEFT"); 	
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
	function GetPDAUsers($mydate){  
		$this->db->select('tbl_drivers.LorryNo, tbl_drivers.MacAddress,  tbl_drivers_logs.IPAddress,  tbl_drivers_logs.LogInLoc, 
		tbl_drivers_login.DriverName, DATE_FORMAT(tbl_drivers_logs.LoginDatetime,"%d-%m-%Y %T") as LoginDatetime '); 	 
		$this->db->from('tbl_drivers_logs');    
		$this->db->join('tbl_drivers', 'tbl_drivers_logs.DriverID  = tbl_drivers.LorryNo ','LEFT');   
		$this->db->join('tbl_drivers_login', 'tbl_drivers_logs.DriverLoginID  = tbl_drivers_login.DriverID ','LEFT');   
		$this->db->where('DATE_FORMAT(tbl_drivers_logs.LoginDatetime,"%Y-%m-%d") ',$mydate);    
		$this->db->where('tbl_drivers_logs.DriverID > 0 ');    
		$this->db->where('tbl_drivers_logs.DriverLoginID > 0 ');    
		 
		$this->db->group_by("tbl_drivers_logs.DriverID,tbl_drivers_logs.DriverLoginID ");  
		//$this->db->having("MAX(tbl_drivers_logs.LogID)"); 
		$this->db->order_by('tbl_drivers_logs.LogID ','DESC');
		
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit;
		return $query->result_array();
	}
	public function GetDriverRequestLoadsCollection($start_date,$end_date,$driver){ 
	 
	  //	$sd= explode('/', $start_date,$end_date);    
	//	$firstDate = trim($sd[2]).'-'.trim($sd[1]).'-'.trim($sd[0]); 
		 
		
		$sd = explode('/', $start_date);
		$Start_Date = trim($sd[2]) . '-' . trim($sd[1]) . '-' . trim($sd[0]); 

		$ed = explode('/', $end_date);
		$End_Date = trim($ed[2]) . '-' . trim($ed[1]) . '-' . trim($ed[0]); 



        $per= $this->db->dbprefix;   
	    $this->db->select(' tbl_booking_loads1.BookingID ');  	 		 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.TipNumber ');  
		$this->db->select(' tbl_booking_loads1.Status ');  
		$this->db->select(' tbl_booking_loads1.DriverLoginID '); 	
		$this->db->select(' tbl_booking_loads1.Expenses ');  
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  
		$this->db->select('tbl_booking_loads1.ReceiptName'); 
		//$this->db->select(' DATE_FORMAT(tbl_booking1.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	  		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as AllocatedDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y %T") as JobStartDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d-%m-%Y %T") as JobEndDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %T") as SiteInDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');   
		$this->db->select(' tbl_booking_loads1.TipID ');	 
 		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_materials.MaterialName ');	
		$this->db->select(' tbl_booking_request.CompanyName ');	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		  
		$this->db->select(' tbl_booking_request.OpportunityName ');	 

		$this->db->select(' tbl_tipaddress.TipName ');	  
		$this->db->select(' tbl_tipticket.TipTicketID ');	
		$this->db->select(' tbl_tipticket.TipID as TicketTipID ');	  
		$this->db->select(' tbl_tipticket.TipRefNo as SuppNo ');
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y %T") as TipTicketDateTime ');  	 	  		
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y %T") as TicketDateTime ');  	 	  		 
		$this->db->select(' tbl_tickets.TicketNumber'); 
		$this->db->select(' tbl_tickets.pdf_name as TicketPdfName'); 
		 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ',"LEFT"); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ',"LEFT"); 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID =tbl_tipticket.LoadID ',"LEFT"); 
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID =tbl_tickets.LoadID ',"LEFT");  
		$this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =tbl_tipaddress.TipID ',"LEFT");   
		$this->db->join(' tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");  
		if($driver>0){
			$this->db->where('tbl_booking_loads1.DriverLoginID',$driver); 
		} 
		$this->db->where('tbl_booking_loads1.Status > 3'); 
		$this->db->where(' tbl_booking1.BookingType','1');  
	  	//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") ', $firstDate);    
		//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y-%m-%d") ', $firstDate);    
		$this->db->where("DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime, '%Y-%m-%d') BETWEEN '$Start_Date' AND '$End_Date'");

		
		$this->db->group_by("tbl_booking_loads1.LoadID");             
	    $query = $this->db->get('tbl_booking_loads1');
		

	    return $query->result();
	}
	public function GetDriverRequestLoadsDelivery($start_date,$end_date,$driver){ 
	 
		$sd = explode('/', $start_date);
		$Start_Date = trim($sd[2]) . '-' . trim($sd[1]) . '-' . trim($sd[0]); 

		$ed = explode('/', $end_date);
		$End_Date = trim($ed[2]) . '-' . trim($ed[1]) . '-' . trim($ed[0]); 
 
        $per= $this->db->dbprefix;   
	    $this->db->select(' tbl_booking_loads1.BookingID');  	 		 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as AllocatedDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y %T") as JobStartDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d-%m-%Y %T") as JobEndDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %T") as SiteInDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');   
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.TipNumber ');  
		$this->db->select(' tbl_booking_loads1.Status ');   
		$this->db->select(' tbl_booking_loads1.TipID ');	
		$this->db->select('tbl_booking_loads1.ReceiptName'); 

		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  
        $this->db->select(' tbl_booking_loads1.Expenses ');  
		$this->db->select(' tbl_booking_request.CompanyName ');	    
		
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');  		
		
		$this->db->select(' tbl_tickets.TicketNumber ');   
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_materials.MaterialName ');	 
		//$this->db->select(' DATE_FORMAT(tbl_booking1.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	  		
		
		$this->db->select(' tbl_booking_request.OpportunityID ');		 
		$this->db->select(' tbl_booking_request.OpportunityName ');	 
		 
		$this->db->select(' tbl_tipaddress.TipName ');	  
		$this->db->select(' tbl_tipticket.TipID as TicketTipID ');
		$this->db->select(' tbl_tipticket.TipRefNo as SuppNo ');
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y %T") as TipTicketDateTime ');  	 	  		
		$this->db->select(' tbl_tickets.TicketNumber');  
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y %T") as TicketDateTime '); 		
		$this->db->select(' tbl_tickets.pdf_name as TicketPdfName'); 
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ',"LEFT"); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ',"LEFT"); 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID =tbl_tipticket.LoadID ',"LEFT"); 
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID =tbl_tickets.LoadID ',"LEFT");  
		$this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =tbl_tipaddress.TipID ',"LEFT");   
		$this->db->join(' tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");  
		if($driver>0){
			$this->db->where('tbl_booking_loads1.DriverLoginID',$driver); 
		}
		$this->db->where(' tbl_booking1.BookingType','2'); 
		$this->db->where('tbl_booking_loads1.Status > 3'); 
		//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y-%m-%d") ', $firstDate);    
		$this->db->where("DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime, '%Y-%m-%d') BETWEEN '$Start_Date' AND '$End_Date'");
	  	//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") ', $firstDate);     
		$this->db->group_by("tbl_booking_loads1.LoadID");             
	    $query = $this->db->get('tbl_booking_loads1');
		
		//echo $this->db->last_query(); 
		//exit; 
	    return $query->result();
	} 
	public function GetDriverRequestLoadsDayWork($start_date,$end_date,$driver){ 
	 
		$sd = explode('/', $start_date);
		$Start_Date = trim($sd[2]) . '-' . trim($sd[1]) . '-' . trim($sd[0]); 

		$ed = explode('/', $end_date);
		$End_Date = trim($ed[2]) . '-' . trim($ed[1]) . '-' . trim($ed[0]); 
 
        $per= $this->db->dbprefix;   
	    $this->db->select(' tbl_booking_loads1.BookingID ');  	 		 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.TipNumber ');  
		$this->db->select(' tbl_booking_loads1.Status ');  
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');  		
		//$this->db->select(' DATE_FORMAT(tbl_booking1.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	  		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as AllocatedDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y %T") as JobStartDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d-%m-%Y %T") as JobEndDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %T") as SiteInDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');   
		$this->db->select(' tbl_booking_loads1.TipID ');
		
 		$this->db->select(' tbl_booking_loads1.Expenses ');  
		$this->db->select(' tbl_booking_request.CompanyName ');	 
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_materials.MaterialName ');	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		  
		$this->db->select(' tbl_booking_request.OpportunityName ');	 

		$this->db->select(' tbl_tipaddress.TipName ');	   
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ',"LEFT"); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ',"LEFT");  
		$this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =tbl_tipaddress.TipID ',"LEFT");   
		$this->db->join(' tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");  
		if($driver>0){
			$this->db->where('tbl_booking_loads1.DriverLoginID',$driver); 
		} 
		$this->db->where('tbl_booking_loads1.Status > 3'); 
		$this->db->where(' tbl_booking1.BookingType','3');  
	  	//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") ', $firstDate);    
		//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y-%m-%d") ', $firstDate);    
		$this->db->where("DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime, '%Y-%m-%d') BETWEEN '$Start_Date' AND '$End_Date'");
		$this->db->group_by("tbl_booking_loads1.LoadID");             
	    $query = $this->db->get('tbl_booking_loads1');
		
		//echo $this->db->last_query(); 
		//exit; 
	    return $query->result();
	}
	
	public function GetDriverRequestLoadsHaulage($start_date,$end_date,$driver){ 
	 
		$sd = explode('/', $start_date);
		$Start_Date = trim($sd[2]) . '-' . trim($sd[1]) . '-' . trim($sd[0]); 

		$ed = explode('/', $end_date);
		$End_Date = trim($ed[2]) . '-' . trim($ed[1]) . '-' . trim($ed[0]); 
 
        $per= $this->db->dbprefix;   
	    $this->db->select(' tbl_booking_loads1.BookingID ');  	 		 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.TipNumber ');  
		$this->db->select(' tbl_booking_loads1.Status ');  
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');  		
		//$this->db->select(' DATE_FORMAT(tbl_booking1.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	  		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as AllocatedDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y %T") as JobStartDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d-%m-%Y %T") as JobEndDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %T") as SiteInDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime2,"%d-%m-%Y %T") as SiteInDateTime2 ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y %T") as SiteOutDateTime2 ');   
		$this->db->select(' tbl_booking_loads1.TipID ');	 
 		
 		$this->db->select(' tbl_booking_loads1.Expenses ');  
		$this->db->select(' tbl_booking_request.CompanyName ');	    
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_materials.MaterialName ');	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		  
		$this->db->select(' tbl_booking_request.OpportunityName ');	 

		$this->db->select(' tbl_tipaddress.TipName ');	   
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ',"LEFT"); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ',"LEFT");  
		$this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =tbl_tipaddress.TipID ',"LEFT");   
		$this->db->join(' tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");  
		if($driver>0){
			$this->db->where('tbl_booking_loads1.DriverLoginID',$driver); 
		} 
		$this->db->where('tbl_booking_loads1.Status = 4'); 
		$this->db->where(' tbl_booking1.BookingType','4');  
	  	//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") ', $firstDate);    
		//$this->db->where(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y-%m-%d") ', $firstDate);    
		$this->db->where("DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime, '%Y-%m-%d') BETWEEN '$Start_Date' AND '$End_Date'");
		$this->db->group_by("tbl_booking_loads1.LoadID");             
	    $query = $this->db->get('tbl_booking_loads1');
		
		//echo $this->db->last_query(); 
		//exit; 
	    return $query->result();
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
		$this->db->select('tbl_booking_loads.TipAddressUpdate ');
		$this->db->select('tbl_booking_loads.SiteInDateTime ');
		$this->db->select('tbl_booking_loads.SiteOutDateTime ');		
		$this->db->select('tbl_booking_loads.TicketUniqueID ');		
		$this->db->select(' DATE_FORMAT(SiteInDateTime,"%d/%m/%Y %T") as SIDateTime ');  
		$this->db->select(' DATE_FORMAT(SiteOutDateTime,"%d/%m/%Y %T") as SODateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d-%m-%Y %H:%i") as CDateTime ');    
		
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
	
	function BookingLoadInfo1($id){

		$this->db->select('tbl_booking_loads1.LoadID');  
		$this->db->select('tbl_booking_loads1.Status');   
		$this->db->select('tbl_booking_loads1.ConveyanceNo');   
		$this->db->select('tbl_booking_loads1.DriverName');   
		$this->db->select('tbl_booking_loads1.VehicleRegNo');   
		$this->db->select('tbl_booking_loads1.Signature');   
		$this->db->select('tbl_booking_loads1.Signature2');
		$this->db->select('tbl_booking_loads1.DriverID');   
		$this->db->select('tbl_booking_loads1.DriverLoginID');   
		$this->db->select('tbl_booking_loads1.Tare');    
		$this->db->select('tbl_booking_loads1.Net');    
		$this->db->select('tbl_booking_loads1.CustomerName');  
		$this->db->select('tbl_booking_loads1.CustomerName2');  
		$this->db->select('tbl_booking_loads1.ReceiptName');   
		$this->db->select('tbl_booking_loads1.BookingID');   
		$this->db->select('tbl_booking_loads1.BookingRequestID'); 
		$this->db->select('tbl_booking_loads1.TipID ');	
		$this->db->select('tbl_booking_loads1.TicketID ');	
		$this->db->select('tbl_booking_loads1.TipNumber ');	
		$this->db->select('tbl_booking_loads1.GrossWeight ');	
		$this->db->select('tbl_booking_loads1.TipAddressUpdate ');
		$this->db->select('tbl_booking_loads1.SiteInDateTime ');
		$this->db->select('tbl_booking_loads1.SiteOutDateTime ');		
		$this->db->select('tbl_booking_loads1.TicketUniqueID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %H:%i") as SIDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %H:%i") as SODateTime ');  
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime2,"%d-%m-%Y %H:%i") as HSIDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y %H:%i") as HSODateTime ');  
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %H:%i") as CDateTime ');  
		  
		
		$this->db->select('tbl_booking1.LoadType');   
		$this->db->select('tbl_booking1.LorryType');  
		$this->db->select('tbl_booking1.TonBook'); 		
		$this->db->select('tbl_booking_request.CompanyID ');	
		$this->db->select('tbl_booking1.BookingType');   
		$this->db->select('tbl_booking_request.OpportunityID ');	 
		
		$this->db->select(' tbl_materials.MaterialName ');			
		$this->db->select(' tbl_materials.MaterialID ');		
		$this->db->select(' tbl_materials.SicCode ');			 
        $this->db->select(' tbl_booking1.SICCode as LoadSICCODE ');		
		
		$this->db->select(' tbl_booking_request.CompanyName ');    
		$this->db->select(' tbl_booking_request.OpportunityName ');	  
		 
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
		$this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ',"LEFT");  
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ',"LEFT");  
		$this->db->join(' tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo  ',"LEFT");  
		$this->db->join(' tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID  ',"LEFT"); 
		$this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ',"LEFT"); 
		$this->db->join(' tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ',"LEFT");   
		 
        $this->db->where('tbl_booking_loads1.LoadID ',$id);		
		$query = $this->db->get(); 
		return $query->row();
		//return $query->row_array();
	}
	
	function BookingTicketInfo($TicketID){
        //$this->db->select(' DATE_FORMAT(TicketDate,"%d/%m/%Y %T") as tdate ');  
		$this->db->select(' DATE_FORMAT(TicketDate,"%d/%m/%Y %H:%i") as tdate ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %H:%i") as SiteIn ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %H:%i") as SiteOut ');   
		
		$this->db->select('tbl_tickets.TicketUniqueID ');
		
		$this->db->select('tbl_booking_loads1.Status');
		$this->db->select('tbl_booking_loads1.LoadID');
		$this->db->select('tbl_booking_loads1.CustomerName');
		$this->db->select('tbl_booking_loads1.Signature');
		$this->db->select(' tbl_drivers_login.Signature as dsignature ');	 
		$this->db->select(' tbl_drivers_login.DriverName ');	 
		
		$this->db->select('tbl_tickets.TicketNumber,tbl_tickets.TicketNo, tbl_tickets.RegNumber, tbl_tickets.Hulller, tbl_tickets.SicCode, tbl_tickets.GrossWeight, tbl_tickets.Tare, tbl_tickets.Net '); 
		$this->db->select('tbl_company.CompanyName');
		$this->db->select('tbl_tipaddress.TipName');
		$this->db->select('tbl_tipaddress.Street1');
		$this->db->select('tbl_tipaddress.Street2');
		$this->db->select('tbl_tipaddress.Town');
		$this->db->select('tbl_tipaddress.County');
		$this->db->select('tbl_tipaddress.PostCode');
		$this->db->select('tbl_tipaddress.PermitRefNo');
		$this->db->select('tbl_opportunities.OpportunityName');
		$this->db->select('tbl_materials.MaterialName');
		$this->db->select('tbl_booking1.SICCode as LoadSICCODE');
		$this->db->select('tbl_booking1.TonBook'); 	
		$this->db->select('tbl_booking1.LorryType'); 
        $this->db->from('tbl_tickets');
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID ',"LEFT");  
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID  ',"LEFT");  
		$this->db->join(' tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID  ',"LEFT"); 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ',"LEFT"); 
        $this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID = tbl_opportunities.OpportunityID ',"LEFT"); 
        $this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID ',"LEFT"); 
		$this->db->join('tbl_materials', 'tbl_tickets.MaterialID = tbl_materials.MaterialID',"LEFT"); 
        $this->db->where("tbl_tickets.TicketNo", $TicketID);                     
        $query = $this->db->get(); 
       // echo $this->db->last_query();       
        $result = $query->row_array();        
        return $result;
    }
	
	
	public function GetBookingRequestData(){
		
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		  
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking_date1.BookingRequestID  as BookingRequestID  ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');  	 		
		$this->db->select(' tbl_booking1.BookingType '); 
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads '); 
		$this->db->select(' tbl_booking_request.Notes ');
		$this->db->select(' tbl_booking1.Price ');
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');  
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_materials.MaterialName  ');  
		$this->db->select(' tbl_users.name as BookedName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") as BookingDate ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") as BookingDate1 ');     
		//$this->db->select('(select count(*) from tbl_booking_loads where  tbl_booking1.BookingID = tbl_booking_loads.BookingID ) as TotalLoadAllocated ');   
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID = tbl_booking1.BookingID ','LEFT');   
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT');   
		$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking_date1.BookedBy','LEFT'); 
		
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_date1.BookingRequestID', $s[$i]); 
						$this->db->or_like('tbl_booking1.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking_request.Notes', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking1.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);
						$this->db->or_like('tbl_users.name', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d-%m-%Y %T") ', $s[$i]);
					$this->db->group_end(); 
				}
			}    
        }
		  
		$this->db->order_by($columnName, $columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_date1');
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
	
	public function GetBookingRequestPriceByPending(){
		
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='PurchaseOrderNumber'){ $columnName = 'tbl_booking_request.PurchaseOrderNumber '; } 
			if($Sort[0]=='Price'){ $columnName = 'tbl_booking1.Price '; } 
			if($Sort[0]=='BookingRequestID'){ $columnName = 'tbl_booking_request.BookingRequestID '; } 
			if($Sort[0]=='BookingDate'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") '; } 
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; } 
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			
			if($Sort[0]=='TotalTon'){ $columnName = 'tbl_booking1.TotalTon '; } 
			if($Sort[0]=='TonPerLoad'){ $columnName = 'tbl_booking1.TonPerLoad '; } 
			
			if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking1.BookingType '; } 
			if($Sort[0]=='LoadType'){ $columnName = 'tbl_booking1.LoadType '; } 
			if($Sort[0]=='Loads'){ $columnName = 'tbl_booking1.Loads '; } 
			if($Sort[0]=='LorryType'){ $columnName = 'tbl_booking1.LorryType '; } 
			if($Sort[0]=='Notes'){ $columnName = 'tbl_booking_request.Notes '; } 
			if($Sort[0]=='BookedName'){ $columnName = ' tbl_users.name '; } 
			if($Sort[0]=='CreateDateTime'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%Y%m%d %T") '; } 
			
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingRequestID = trim(strtolower($_POST['BookingRequestID'])); // Search value  
		$Price = trim(strtolower($_POST['Price'])); // Search value  
		$PurchaseOrderNumber = trim(strtolower($_POST['PurchaseOrderNumber'])); // Search value  
		
		$BookingDate = trim(strtolower($_POST['BookingDate'])); // Search value  
		$CompanyName = trim(strtolower($_POST['CompanyName'])); // Search value  
		$OpportunityName = trim(strtolower($_POST['OpportunityName'])); // Search value  
		$MaterialName = trim(strtolower($_POST['MaterialName'])); // Search value    
		
		$TotalTon = trim(strtolower($_POST['TotalTon'])); // Search value  
		$TonPerLoad = trim(strtolower($_POST['TonPerLoad'])); // Search value  
		
		$BookingType = trim(strtolower($_POST['BookingType'])); // Search value  
		$LoadType = trim(strtolower($_POST['LoadType'])); // Search value  
		$Loads = trim(strtolower($_POST['Loads'])); // Search value   		
		$LorryType = trim(strtolower($_POST['LorryType'])); // Search value  
		$Notes = trim(strtolower($_POST['Notes'])); // Search value  
		$BookedName = trim(strtolower($_POST['BookedName'])); // Search value  
		$CreateDateTime = trim(strtolower($_POST['CreateDateTime'])); // Search value  
		
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking_date1.BookingRequestID  as BookingRequestID  ');  	 		
		$this->db->select(' tbl_booking1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');  	 		
		$this->db->select(' tbl_booking1.BookingType '); 
		
		$this->db->select(' tbl_booking1.TonBook ');
		$this->db->select(' tbl_booking1.TotalTon ');
		$this->db->select(' tbl_booking1.TonPerLoad '); 
		
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads '); 
		$this->db->select(' tbl_booking_request.Notes ');
		$this->db->select(' tbl_booking1.Price ');
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');  
		$this->db->select(' tbl_booking1.PriceApproved ');  
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');  
		$this->db->select(' tbl_booking1.PurchaseOrderNo'); 
		
		//$this->db->select(' tbl_materials.MaterialName  ');  
		$this->db->select(' tbl_booking1.MaterialName  ');  
		
		$this->db->select(' tbl_users.name as BookedName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") as BookingDate ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") as BookingDate1 ');     
		//$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_date1.BookingDateID = tbl_booking_loads1.BookingDateID ) as TotalLoadAllocated ');   
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID = tbl_booking1.BookingID ','LEFT');   
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT');   
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking_request.BookedBy','LEFT'); 
		$this->db->where('tbl_booking1.PriceApproved = 0 '); 
		$this->db->where('tbl_booking_request.PriceBy',$this->session->userdata['userId']);  
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_date1.BookingRequestID ', $s[$i]); 
						$this->db->or_like('tbl_booking1.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking_request.Notes', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', $s[$i]);
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking1.Price', $s[$i]);
						$this->db->or_like('tbl_booking_request.PurchaseOrderNumber', $s[$i]);
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);
						$this->db->or_like('tbl_booking1.TotalTon', $s[$i]);
						$this->db->or_like('tbl_booking1.TonPerLoad', $s[$i]);
						$this->db->or_like('tbl_users.name', $s[$i]);
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', $s[$i]);
					$this->db->group_end(); 
				}
			}    
        }
		if( !empty(trim($PurchaseOrderNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.PurchaseOrderNumber ', trim($PurchaseOrderNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingRequestID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_date1.BookingRequestID ', trim($BookingRequestID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingDate)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', trim($BookingDate)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($TotalTon)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TotalTon', trim($TotalTon)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TonPerLoad)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TonPerLoad', trim($TonPerLoad)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Loads)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Loads ', trim($Loads)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($BookedName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_users.name ', trim($BookedName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CreateDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', trim($CreateDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingType)) ){     
			if($BookingType[0]=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '1'); 
				$this->db->group_end();  
			}
			if($BookingType[0]=='d'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '2'); 
				$this->db->group_end();  
			} 
        }
		if( !empty(trim($LoadType)) ){     
			if($LoadType[0]=='l' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->group_end();  
			}
			if($LoadType[0]=='t'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '2'); 
				$this->db->group_end();  
			} 
        }
		if( !empty(trim($LorryType)) ){     
			if($LorryType[0]=='t' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '1'); 
				$this->db->group_end();  
			}
			if($LorryType[0]=='g'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '2'); 
				$this->db->group_end();  
			} 
			if($LorryType[0]=='b'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '3'); 
				$this->db->group_end();  
			} 
			
        }
		if( !empty(trim($Notes)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.Notes', trim($Notes)); 
 			$this->db->group_end();  
        }
		 
		$this->db->group_by("tbl_booking_date1.BookingID");                 
		//$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->order_by($columnName.' '.$columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_date1');
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
	
	public function GetBookingRequestPriceByApproved(){
		
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='PurchaseOrderNumber'){ $columnName = 'tbl_booking_request.PurchaseOrderNumber '; } 
			if($Sort[0]=='Price'){ $columnName = 'tbl_booking1.Price '; } 
			if($Sort[0]=='BookingRequestID'){ $columnName = 'tbl_booking_request.BookingRequestID '; } 
			if($Sort[0]=='BookingDate'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") '; } 
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; } 
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			
			if($Sort[0]=='TotalTon'){ $columnName = 'tbl_booking1.TotalTon '; } 
			if($Sort[0]=='TonPerLoad'){ $columnName = 'tbl_booking1.TonPerLoad '; } 
			
			if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking1.BookingType '; } 
			if($Sort[0]=='LoadType'){ $columnName = 'tbl_booking1.LoadType '; } 
			if($Sort[0]=='Loads'){ $columnName = 'tbl_booking1.Loads '; } 
			if($Sort[0]=='LorryType'){ $columnName = 'tbl_booking1.LorryType '; } 
			if($Sort[0]=='Notes'){ $columnName = 'tbl_booking_request.Notes '; } 
			if($Sort[0]=='BookedName'){ $columnName = ' tbl_users.name '; } 
			if($Sort[0]=='CreateDateTime'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%Y%m%d %T") '; } 
			
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingRequestID = trim(strtolower($_POST['BookingRequestID'])); // Search value  
		$Price = trim(strtolower($_POST['Price'])); // Search value  
		$PurchaseOrderNumber = trim(strtolower($_POST['PurchaseOrderNumber'])); // Search value  
		
		$BookingDate = trim(strtolower($_POST['BookingDate'])); // Search value  
		$CompanyName = trim(strtolower($_POST['CompanyName'])); // Search value  
		$OpportunityName = trim(strtolower($_POST['OpportunityName'])); // Search value  
		$MaterialName = trim(strtolower($_POST['MaterialName'])); // Search value    
		
		$TotalTon = trim(strtolower($_POST['TotalTon'])); // Search value  
		$TonPerLoad = trim(strtolower($_POST['TonPerLoad'])); // Search value  
		
		$BookingType = trim(strtolower($_POST['BookingType'])); // Search value  
		$LoadType = trim(strtolower($_POST['LoadType'])); // Search value  
		$Loads = trim(strtolower($_POST['Loads'])); // Search value   		
		$LorryType = trim(strtolower($_POST['LorryType'])); // Search value  
		$Notes = trim(strtolower($_POST['Notes'])); // Search value  
		$BookedName = trim(strtolower($_POST['BookedName'])); // Search value  
		$CreateDateTime = trim(strtolower($_POST['CreateDateTime'])); // Search value  
		
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking_date1.BookingRequestID  as BookingRequestID  ');  	 		
		$this->db->select(' tbl_booking1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');  	 		
		$this->db->select(' tbl_booking1.BookingType '); 
		
		$this->db->select(' tbl_booking1.TonBook ');
		$this->db->select(' tbl_booking1.TotalTon ');
		$this->db->select(' tbl_booking1.TonPerLoad '); 
		
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads '); 
		$this->db->select(' tbl_booking_request.Notes ');
		$this->db->select(' tbl_booking1.Price ');
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');  
		$this->db->select(' tbl_booking1.PriceApproved ');  
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');  
		$this->db->select(' tbl_booking1.PurchaseOrderNo'); 
		
		//$this->db->select(' tbl_materials.MaterialName  ');  
		$this->db->select(' tbl_booking1.MaterialName  ');  
		
		$this->db->select(' tbl_users.name as BookedName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") as BookingDate ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") as BookingDate1 ');     
		//$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_date1.BookingDateID = tbl_booking_loads1.BookingDateID ) as TotalLoadAllocated ');   
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID = tbl_booking1.BookingID ','LEFT');   
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT');   
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking_request.BookedBy','LEFT'); 
		$this->db->where('tbl_booking1.PriceApproved = 1 '); 
		$this->db->where('tbl_booking_request.PriceBy',$this->session->userdata['userId']);  
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_date1.BookingRequestID ', $s[$i]); 
						$this->db->or_like('tbl_booking1.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking_request.Notes', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', $s[$i]);
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking1.Price', $s[$i]);
						$this->db->or_like('tbl_booking_request.PurchaseOrderNumber', $s[$i]);
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);
						$this->db->or_like('tbl_booking1.TotalTon', $s[$i]);
						$this->db->or_like('tbl_booking1.TonPerLoad', $s[$i]);
						$this->db->or_like('tbl_users.name', $s[$i]);
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', $s[$i]);
					$this->db->group_end(); 
				}
			}    
        }
		if( !empty(trim($PurchaseOrderNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.PurchaseOrderNumber ', trim($PurchaseOrderNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingRequestID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_date1.BookingRequestID ', trim($BookingRequestID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingDate)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', trim($BookingDate)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($TotalTon)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TotalTon', trim($TotalTon)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TonPerLoad)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TonPerLoad', trim($TonPerLoad)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Loads)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Loads ', trim($Loads)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($BookedName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_users.name ', trim($BookedName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CreateDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', trim($CreateDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingType)) ){     
			if($BookingType[0]=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '1'); 
				$this->db->group_end();  
			}
			if($BookingType[0]=='d'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '2'); 
				$this->db->group_end();  
			} 
        }
		if( !empty(trim($LoadType)) ){     
			if($LoadType[0]=='l' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->group_end();  
			}
			if($LoadType[0]=='t'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '2'); 
				$this->db->group_end();  
			} 
        }
		if( !empty(trim($LorryType)) ){     
			if($LorryType[0]=='t' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '1'); 
				$this->db->group_end();  
			}
			if($LorryType[0]=='g'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '2'); 
				$this->db->group_end();  
			} 
			if($LorryType[0]=='b'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '3'); 
				$this->db->group_end();  
			} 
			
        }
		if( !empty(trim($Notes)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.Notes', trim($Notes)); 
 			$this->db->group_end();  
        }
		 
		$this->db->group_by("tbl_booking_date1.BookingID");                 
		//$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->order_by($columnName.' '.$columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_date1');
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
	
	public function GetBookingRequestPriceByAll(){
		
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='PurchaseOrderNumber'){ $columnName = 'tbl_booking_request.PurchaseOrderNumber '; } 
			if($Sort[0]=='Price'){ $columnName = 'tbl_booking1.Price '; } 
			if($Sort[0]=='BookingRequestID'){ $columnName = 'tbl_booking_request.BookingRequestID '; } 
			if($Sort[0]=='BookingDate'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") '; } 
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; } 
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			
			if($Sort[0]=='TotalTon'){ $columnName = 'tbl_booking1.TotalTon '; } 
			if($Sort[0]=='TonPerLoad'){ $columnName = 'tbl_booking1.TonPerLoad '; } 
			
			if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking1.BookingType '; } 
			if($Sort[0]=='LoadType'){ $columnName = 'tbl_booking1.LoadType '; } 
			if($Sort[0]=='Loads'){ $columnName = 'tbl_booking1.Loads '; } 
			if($Sort[0]=='LorryType'){ $columnName = 'tbl_booking1.LorryType '; } 
			if($Sort[0]=='Notes'){ $columnName = 'tbl_booking_request.Notes '; } 
			if($Sort[0]=='BookedName'){ $columnName = ' tbl_users.name '; } 
			if($Sort[0]=='CreateDateTime'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%Y%m%d %T") '; } 
			
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingRequestID = trim(strtolower($_POST['BookingRequestID'])); // Search value  
		$Price = trim(strtolower($_POST['Price'])); // Search value  
		$PurchaseOrderNumber = trim(strtolower($_POST['PurchaseOrderNumber'])); // Search value  
		
		$BookingDate = trim(strtolower($_POST['BookingDate'])); // Search value  
		$CompanyName = trim(strtolower($_POST['CompanyName'])); // Search value  
		$OpportunityName = trim(strtolower($_POST['OpportunityName'])); // Search value  
		$MaterialName = trim(strtolower($_POST['MaterialName'])); // Search value    
		
		$TotalTon = trim(strtolower($_POST['TotalTon'])); // Search value  
		$TonPerLoad = trim(strtolower($_POST['TonPerLoad'])); // Search value  
		
		$BookingType = trim(strtolower($_POST['BookingType'])); // Search value  
		$LoadType = trim(strtolower($_POST['LoadType'])); // Search value  
		$Loads = trim(strtolower($_POST['Loads'])); // Search value   		
		$LorryType = trim(strtolower($_POST['LorryType'])); // Search value  
		$Notes = trim(strtolower($_POST['Notes'])); // Search value  
		$BookedName = trim(strtolower($_POST['BookedName'])); // Search value  
		$CreateDateTime = trim(strtolower($_POST['CreateDateTime'])); // Search value  
		
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking_date1.BookingRequestID  as BookingRequestID  ');  	 		
		$this->db->select(' tbl_booking1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');  	 		
		$this->db->select(' tbl_booking1.BookingType '); 
		
		$this->db->select(' tbl_booking1.TonBook ');
		$this->db->select(' tbl_booking1.TotalTon ');
		$this->db->select(' tbl_booking1.TonPerLoad '); 
		
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads '); 
		$this->db->select(' tbl_booking_request.Notes ');
		$this->db->select(' tbl_booking1.Price ');
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');  
		$this->db->select(' tbl_booking1.PriceApproved ');  
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');  
		$this->db->select(' tbl_booking1.PurchaseOrderNo'); 
		
		//$this->db->select(' tbl_materials.MaterialName  ');  
		$this->db->select(' tbl_booking1.MaterialName  ');  
		
		$this->db->select(' tbl_users.name as BookedName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") as BookingDate ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") as BookingDate1 ');     
		//$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_date1.BookingDateID = tbl_booking_loads1.BookingDateID ) as TotalLoadAllocated ');   
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID = tbl_booking1.BookingID ','LEFT');   
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT');   
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking_request.BookedBy','LEFT');  
		$this->db->where('tbl_booking_request.PriceBy',$this->session->userdata['userId']);  
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_date1.BookingRequestID ', $s[$i]); 
						$this->db->or_like('tbl_booking1.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking_request.Notes', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', $s[$i]);
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking1.Price', $s[$i]);
						$this->db->or_like('tbl_booking_request.PurchaseOrderNumber', $s[$i]);
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);
						$this->db->or_like('tbl_booking1.TotalTon', $s[$i]);
						$this->db->or_like('tbl_booking1.TonPerLoad', $s[$i]);
						$this->db->or_like('tbl_users.name', $s[$i]);
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', $s[$i]);
					$this->db->group_end(); 
				}
			}    
        }
		if( !empty(trim($PurchaseOrderNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.PurchaseOrderNumber ', trim($PurchaseOrderNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingRequestID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_date1.BookingRequestID ', trim($BookingRequestID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingDate)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', trim($BookingDate)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($TotalTon)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TotalTon', trim($TotalTon)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TonPerLoad)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TonPerLoad', trim($TonPerLoad)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Loads)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Loads ', trim($Loads)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($BookedName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_users.name ', trim($BookedName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CreateDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', trim($CreateDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingType)) ){     
			if($BookingType[0]=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '1'); 
				$this->db->group_end();  
			}
			if($BookingType[0]=='d'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '2'); 
				$this->db->group_end();  
			} 
        }
		if( !empty(trim($LoadType)) ){     
			if($LoadType[0]=='l' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->group_end();  
			}
			if($LoadType[0]=='t'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '2'); 
				$this->db->group_end();  
			} 
        }
		if( !empty(trim($LorryType)) ){     
			if($LorryType[0]=='t' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '1'); 
				$this->db->group_end();  
			}
			if($LorryType[0]=='g'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '2'); 
				$this->db->group_end();  
			} 
			if($LorryType[0]=='b'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '3'); 
				$this->db->group_end();  
			} 
			
        }
		if( !empty(trim($Notes)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.Notes', trim($Notes)); 
 			$this->db->group_end();  
        }
		 
		$this->db->group_by("tbl_booking_date1.BookingID");                 
		//$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->order_by($columnName.' '.$columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_date1');
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
	
	
	public function GetBookingRequestData1(){
		
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='PurchaseOrderNo'){ $columnName = 'tbl_booking1.PurchaseOrderNo '; } 
			if($Sort[0]=='Price'){ $columnName = 'tbl_booking1.Price '; } 
			if($Sort[0]=='BookingRequestID'){ $columnName = 'tbl_booking_request.BookingRequestID '; } 
			if($Sort[0]=='BookingDate'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") '; } 
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; } 
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			
			if($Sort[0]=='TotalTon'){ $columnName = 'tbl_booking1.TotalTon '; } 
			if($Sort[0]=='TonPerLoad'){ $columnName = 'tbl_booking1.TonPerLoad '; } 
			
			if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking1.BookingType '; } 
			if($Sort[0]=='LoadType'){ $columnName = 'tbl_booking1.LoadType '; } 
			if($Sort[0]=='Loads'){ $columnName = 'tbl_booking1.Loads '; } 
			if($Sort[0]=='LorryType'){ $columnName = 'tbl_booking1.LorryType '; } 
			if($Sort[0]=='Notes'){ $columnName = 'tbl_booking_request.Notes '; } 
			if($Sort[0]=='BookedName'){ $columnName = ' tbl_users.name '; } 
			if($Sort[0]=='CreateDateTime'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%Y%m%d %T") '; } 
			
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingRequestID = trim(strtolower($_POST['BookingRequestID'])); // Search value  
		$Price = trim(strtolower($_POST['Price'])); // Search value  
		$PurchaseOrderNo = trim(strtolower($_POST['PurchaseOrderNo'])); // Search value  
		
		$BookingDate = trim(strtolower($_POST['BookingDate'])); // Search value  
		$CompanyName = trim(strtolower($_POST['CompanyName'])); // Search value  
		$OpportunityName = trim(strtolower($_POST['OpportunityName'])); // Search value  
		$MaterialName = trim(strtolower($_POST['MaterialName'])); // Search value    
		
		$TotalTon = trim(strtolower($_POST['TotalTon'])); // Search value  
		$TonPerLoad = trim(strtolower($_POST['TonPerLoad'])); // Search value  
		
		$BookingType = trim(strtolower($_POST['BookingType'])); // Search value  
		$LoadType = trim(strtolower($_POST['LoadType'])); // Search value  
		$Loads = trim(strtolower($_POST['Loads'])); // Search value   		
		$LorryType = trim(strtolower($_POST['LorryType'])); // Search value  
		$Notes = trim(strtolower($_POST['Notes'])); // Search value  
		$BookedName = trim(strtolower($_POST['BookedName'])); // Search value  
		$CreateDateTime = trim(strtolower($_POST['CreateDateTime'])); // Search value  
		
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking_date1.BookingRequestID  as BookingRequestID  ');  	 		
		$this->db->select(' tbl_booking1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');  	 		
		$this->db->select(' tbl_booking1.BookingType '); 
		
		$this->db->select(' tbl_booking1.TonBook ');
		$this->db->select(' tbl_booking1.TotalTon ');
		$this->db->select(' tbl_booking1.TonPerLoad '); 
		
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads '); 
		$this->db->select(' tbl_booking_request.Notes ');
		$this->db->select(' tbl_booking1.Price ');
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');  
		$this->db->select(' tbl_booking1.PriceApproved ');  
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');  
		$this->db->select(' tbl_booking1.OpenPO '); 
		//$this->db->select(' tbl_materials.MaterialName  ');  
		$this->db->select(' tbl_booking1.MaterialName  ');  
		
		$this->db->select(' tbl_users.name as BookedName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") as BookingDate ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") as BookingDate1 ');     
		//$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_date1.BookingDateID = tbl_booking_loads1.BookingDateID ) as TotalLoadAllocated ');   
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID = tbl_booking1.BookingID ','LEFT');   
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT');   
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking_request.BookedBy','LEFT'); 
		$this->db->where('tbl_booking_date1.BookingDateStatus = 0 '); 
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_date1.BookingRequestID ', $s[$i]); 
						$this->db->or_like('tbl_booking1.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking_request.Notes', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', $s[$i]);
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking1.Price', $s[$i]);
						$this->db->or_like('tbl_booking1.PurchaseOrderNo', $s[$i]);
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);
						$this->db->or_like('tbl_booking1.TotalTon', $s[$i]);
						$this->db->or_like('tbl_booking1.TonPerLoad', $s[$i]);
						$this->db->or_like('tbl_users.name', $s[$i]);
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', $s[$i]);
					$this->db->group_end(); 
				}
			}    
        }
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingRequestID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_date1.BookingRequestID ', trim($BookingRequestID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingDate)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', trim($BookingDate)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($TotalTon)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TotalTon', trim($TotalTon)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TonPerLoad)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TonPerLoad', trim($TonPerLoad)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Loads)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Loads ', trim($Loads)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($BookedName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_users.name ', trim($BookedName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CreateDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', trim($CreateDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingType)) ){     
			if($BookingType[0]=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '1'); 
				$this->db->group_end();  
			} 
			if($BookingType[1]=='e'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '2'); 
				$this->db->group_end();  
			} 
			if($BookingType[1]=='a'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '3'); 
				$this->db->group_end();  
			}
			if($BookingType[0]=='h'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '4'); 
				$this->db->group_end();  
			}	
        }
		if( !empty(trim($LoadType)) ){     
		
			if (strpos($LoadType, 'l') === 0) {
			//if($LoadType[0]=='l' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->group_end();  
			}
			if (strpos($LoadType, 'tu') === 0) {
			//if($LoadType[0]=='tu'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '2'); 
				$this->db->group_end();  
			}
			if (strpos($LoadType, 'to') === 0) {
			//if($LoadType[0]=='to'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->like(' tbl_booking1.TonBook ', '1'); 
				$this->db->group_end();  
			}	
        }
		if( !empty(trim($LorryType)) ){     
			if($LorryType[0]=='t' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '1'); 
				$this->db->group_end();  
			}
			if($LorryType[0]=='g'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '2'); 
				$this->db->group_end();  
			} 
			if($LorryType[0]=='b'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '3'); 
				$this->db->group_end();  
			} 
			
        }
		if( !empty(trim($Notes)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.Notes', trim($Notes)); 
 			$this->db->group_end();  
        }
		 
		//$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->order_by($columnName.' '.$columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_date1');
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
	
	public function GetBookingRequestData2(){
		
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='BookingRequestID'){ $columnName = 'tbl_booking_request.BookingRequestID '; } 
			if($Sort[0]=='Price'){ $columnName = 'tbl_booking1.Price '; } 
			if($Sort[0]=='PurchaseOrderNo'){ $columnName = 'tbl_booking1.PurchaseOrderNo '; } 
			if($Sort[0]=='BookingDate'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") '; } 
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; } 
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='TotalTon'){ $columnName = 'tbl_booking1.TotalTon '; } 
			if($Sort[0]=='TonPerLoad'){ $columnName = 'tbl_booking1.TonPerLoad '; } 
			
			if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking1.BookingType '; } 
			if($Sort[0]=='LoadType'){ $columnName = 'tbl_booking1.LoadType '; } 
			if($Sort[0]=='Loads'){ $columnName = 'tbl_booking1.Loads '; } 
			if($Sort[0]=='LorryType'){ $columnName = 'tbl_booking1.LorryType '; } 
			if($Sort[0]=='Notes'){ $columnName = 'tbl_booking_request.Notes '; } 
			if($Sort[0]=='BookedName'){ $columnName = ' tbl_users.name '; } 
			if($Sort[0]=='CreateDateTime'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%Y%m%d %T") '; } 
			
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingRequestID = trim(strtolower($_POST['BookingRequestID'])); // Search value  
		$Price = trim(strtolower($_POST['Price'])); // Search value  
		$PurchaseOrderNo = trim(strtolower($_POST['PurchaseOrderNo'])); // Search value  
		
		$BookingDate = trim(strtolower($_POST['BookingDate'])); // Search value  
		$CompanyName = trim(strtolower($_POST['CompanyName'])); // Search value  
		$OpportunityName = trim(strtolower($_POST['OpportunityName'])); // Search value  
		$MaterialName = trim(strtolower($_POST['MaterialName'])); // Search value    
		$TotalTon = trim(strtolower($_POST['TotalTon'])); // Search value  
		$TonPerLoad = trim(strtolower($_POST['TonPerLoad'])); // Search value  
		
		$BookingType = trim(strtolower($_POST['BookingType'])); // Search value  
		$LoadType = trim(strtolower($_POST['LoadType'])); // Search value  
		$Loads = trim(strtolower($_POST['Loads'])); // Search value   		
		$LorryType = trim(strtolower($_POST['LorryType'])); // Search value  
		$Notes = trim(strtolower($_POST['Notes'])); // Search value  
		$BookedName = trim(strtolower($_POST['BookedName'])); // Search value  
		$CreateDateTime = trim(strtolower($_POST['CreateDateTime'])); // Search value  
		
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking_request.BookingRequestID ');  
		$this->db->select(' tbl_booking1.BookingID ');  			
		$this->db->select(' tbl_booking_date1.BookingDateID ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');  	 		
		
		$this->db->select(' tbl_booking1.TonBook ');
		$this->db->select(' tbl_booking1.TotalTon ');
		$this->db->select(' tbl_booking1.TonPerLoad '); 
		
		$this->db->select(' tbl_booking1.BookingType '); 
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads '); 
		$this->db->select(' tbl_booking_request.Notes ');
		$this->db->select(' tbl_booking1.Price ');
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');  
		$this->db->select(' tbl_booking1.PriceApproved ');  
		
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		
		// $this->db->select('tbl_booking_loads1.BookingRequestID as BookingNewId');
		// $this->db->select('tbl_booking_loads1.Status');

		$this->db->select(' tbl_booking1.PurchaseOrderNo ');  
		$this->db->select(' tbl_booking1.OpenPO '); 
		$this->db->select(' tbl_booking1.MaterialName  ');  
		$this->db->select(' tbl_users.name as BookedName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") as BookingDate ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") as BookingDate1 ');     
		//$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_date1.BookingDateID = tbl_booking_loads1.BookingDateID ) as TotalLoadAllocated ');   
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID = tbl_booking1.BookingID ','LEFT');   
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT');   
		// $this->db->join('tbl_booking_loads1', 'tbl_booking_loads1.BookingNewId = tbl_booking_request.BookingRequestID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking_request.BookedBy','LEFT'); 
		$this->db->where('tbl_booking_date1.BookingDateStatus = 1 '); 
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") >= (CURDATE() - INTERVAL 31 DAY)'); 
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_date1.BookingRequestID', $s[$i]); 
						$this->db->or_like('tbl_booking1.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking_request.Notes', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', $s[$i]);
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking1.PurchaseOrderNo', $s[$i]);
						$this->db->or_like('tbl_booking1.Price', $s[$i]);
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);
						$this->db->or_like('tbl_booking1.TotalTon', $s[$i]);
						$this->db->or_like('tbl_booking1.TonPerLoad', $s[$i]);
						$this->db->or_like('tbl_users.name', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d-%m-%Y %T") ', $s[$i]);
					$this->db->group_end();
				}
			}    
        }
		if( !empty(trim($BookingRequestID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.BookingRequestID ', trim($BookingRequestID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TotalTon)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TotalTon', trim($TotalTon)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TonPerLoad)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TonPerLoad', trim($TonPerLoad)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingDate)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', trim($BookingDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Loads)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Loads ', trim($Loads)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($BookedName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_users.name ', trim($BookedName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CreateDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', trim($CreateDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingType)) ){     
			if($BookingType[0]=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '1'); 
				$this->db->group_end();  
			} 
			if($BookingType[1]=='e'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '2'); 
				$this->db->group_end();  
			} 
			if($BookingType[1]=='a'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '3'); 
				$this->db->group_end();  
			}
			if($BookingType[0]=='h'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '4'); 
				$this->db->group_end();  
			}	
        }
		 
		if( !empty(trim($LoadType)) ){     
		
			if (strpos($LoadType, 'l') === 0) {
			//if($LoadType[0]=='l' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->group_end();  
			}
			if (strpos($LoadType, 'tu') === 0) {
			//if($LoadType[0]=='tu'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '2'); 
				$this->db->group_end();  
			}
			if (strpos($LoadType, 'to') === 0) {
			//if($LoadType[0]=='to'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->like(' tbl_booking1.TonBook ', '1'); 
				$this->db->group_end();  
			}	
        }
		if( !empty(trim($LorryType)) ){     
			if($LorryType[0]=='t' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '1'); 
				$this->db->group_end();  
			}
			if($LorryType[0]=='g'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '2'); 
				$this->db->group_end();  
			} 
			if($LorryType[0]=='b'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '3'); 
				$this->db->group_end();  
			} 
			
        }
		if( !empty(trim($Notes)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.Notes', trim($Notes)); 
 			$this->db->group_end();  
        }
		 
		//$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->order_by($columnName.' '.$columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_date1');
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
	
	public function GetBookingRequestDataArchived(){
		
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='BookingRequestID'){ $columnName = 'tbl_booking_request.BookingRequestID '; } 
			if($Sort[0]=='Price'){ $columnName = 'tbl_booking1.Price '; } 
			if($Sort[0]=='PurchaseOrderNo'){ $columnName = 'tbl_booking1.PurchaseOrderNo '; } 
			if($Sort[0]=='BookingDate'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") '; } 
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; } 
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='TotalTon'){ $columnName = 'tbl_booking1.TotalTon '; } 
			if($Sort[0]=='TonPerLoad'){ $columnName = 'tbl_booking1.TonPerLoad '; } 
			
			if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking1.BookingType '; } 
			if($Sort[0]=='LoadType'){ $columnName = 'tbl_booking1.LoadType '; } 
			if($Sort[0]=='Loads'){ $columnName = 'tbl_booking1.Loads '; } 
			if($Sort[0]=='LorryType'){ $columnName = 'tbl_booking1.LorryType '; } 
			if($Sort[0]=='Notes'){ $columnName = 'tbl_booking_request.Notes '; } 
			if($Sort[0]=='BookedName'){ $columnName = ' tbl_users.name '; } 
			if($Sort[0]=='CreateDateTime'){ $columnName = ' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%Y%m%d %T") '; } 
			
			$columnSortOrder = $Sort[1]; 
		}	
		
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingRequestID = trim(strtolower($_POST['BookingRequestID'])); // Search value  
		$Price = trim(strtolower($_POST['Price'])); // Search value  
		$PurchaseOrderNo = trim(strtolower($_POST['PurchaseOrderNo'])); // Search value  
		
		$BookingDate = trim(strtolower($_POST['BookingDate'])); // Search value  
		$CompanyName = trim(strtolower($_POST['CompanyName'])); // Search value  
		$OpportunityName = trim(strtolower($_POST['OpportunityName'])); // Search value  
		$MaterialName = trim(strtolower($_POST['MaterialName'])); // Search value    
		$TotalTon = trim(strtolower($_POST['TotalTon'])); // Search value  
		$TonPerLoad = trim(strtolower($_POST['TonPerLoad'])); // Search value  
		
		$BookingType = trim(strtolower($_POST['BookingType'])); // Search value  
		$LoadType = trim(strtolower($_POST['LoadType'])); // Search value  
		$Loads = trim(strtolower($_POST['Loads'])); // Search value   		
		$LorryType = trim(strtolower($_POST['LorryType'])); // Search value  
		$Notes = trim(strtolower($_POST['Notes'])); // Search value  
		$BookedName = trim(strtolower($_POST['BookedName'])); // Search value  
		$CreateDateTime = trim(strtolower($_POST['CreateDateTime'])); // Search value  
		
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking_date1.BookingRequestID ');  
		$this->db->select(' tbl_booking1.BookingID ');  			
		$this->db->select(' tbl_booking_date1.BookingDateID ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');  	 		
		
		$this->db->select(' tbl_booking1.TonBook ');
		$this->db->select(' tbl_booking1.TotalTon ');
		$this->db->select(' tbl_booking1.TonPerLoad '); 

		// $this->db->select('tbl_booking_request.BookingRequestID');
		$this->db->select('tbl_booking_loads1.Status');
		
		$this->db->select(' tbl_booking1.BookingType '); 
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads '); 
		$this->db->select(' tbl_booking_request.Notes ');
		$this->db->select(' tbl_booking1.Price ');
		$this->db->select(' tbl_booking_date1.BookingDateStatus ');  
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_booking_request.BookingRequestID '); 
		
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');  
		$this->db->select(' tbl_booking1.MaterialName  ');  
		$this->db->select(' tbl_users.name as BookedName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") as BookingDate ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y%m%d ") as BookingDate1 ');     
		$this->db->join('tbl_booking_loads1', 'tbl_booking_loads1.BookingRequestID = tbl_booking_date1.BookingRequestID','LEFT'); 
		//$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_date1.BookingDateID = tbl_booking_loads1.BookingDateID ) as TotalLoadAllocated ');   
		$this->db->join('tbl_booking1', ' tbl_booking_date1.BookingID = tbl_booking1.BookingID ','LEFT');   
		$this->db->join('tbl_booking_request', ' tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT');   
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID','LEFT'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking_request.BookedBy','LEFT'); 
		$this->db->where('tbl_booking_date1.BookingDateStatus = 1 '); 
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") < CURDATE() - INTERVAL 30 DAY');  
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_date1.BookingRequestID', $s[$i]); 
						$this->db->or_like('tbl_booking1.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking_request.Notes', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', $s[$i]);
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking1.PurchaseOrderNo', $s[$i]);
						$this->db->or_like('tbl_booking1.Price', $s[$i]);
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);
						$this->db->or_like('tbl_booking1.TotalTon', $s[$i]);
						$this->db->or_like('tbl_booking1.TonPerLoad', $s[$i]);
						$this->db->or_like('tbl_users.name', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d-%m-%Y %T") ', $s[$i]);
					$this->db->group_end(); 
				}
			}    
        }
		if( !empty(trim($BookingRequestID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.BookingRequestID ', trim($BookingRequestID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TotalTon)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TotalTon', trim($TotalTon)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TonPerLoad)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.TonPerLoad', trim($TonPerLoad)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingDate)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.BookingDate,"%d/%m/%Y ") ', trim($BookingDate)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Loads)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Loads ', trim($Loads)); 
 			$this->db->group_end();  
        }
		
		if( !empty(trim($BookedName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_users.name ', trim($BookedName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CreateDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like('DATE_FORMAT(tbl_booking_date1.CreateDateTime,"%d/%m/%Y %T") ', trim($CreateDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingType)) ){     
			if($BookingType[0]=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '1'); 
				$this->db->group_end();  
			}
			if($BookingType[0]=='d'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType ', '2'); 
				$this->db->group_end();  
			} 
        }
		if( !empty(trim($LoadType)) ){     
		
			if (strpos($LoadType, 'l') === 0) {
			//if($LoadType[0]=='l' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->group_end();  
			}
			if (strpos($LoadType, 'tu') === 0) {
			//if($LoadType[0]=='tu'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '2'); 
				$this->db->group_end();  
			}
			if (strpos($LoadType, 'to') === 0) {
			//if($LoadType[0]=='to'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LoadType ', '1'); 
				$this->db->like(' tbl_booking1.TonBook ', '1'); 
				$this->db->group_end();  
			}	
        }
		if( !empty(trim($LorryType)) ){     
			if($LorryType[0]=='t' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '1'); 
				$this->db->group_end();  
			}
			if($LorryType[0]=='g'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '2'); 
				$this->db->group_end();  
			} 
			if($LorryType[0]=='b'){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.LorryType ', '3'); 
				$this->db->group_end();  
			} 
			
        }
		if( !empty(trim($Notes)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.Notes', trim($Notes)); 
 			$this->db->group_end();  
        }
		 
		//$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->order_by($columnName.' '.$columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_date1');
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
	
	
	function TodayBookingRequests()
    {
        $this->db->select(' tbl_booking_date1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingRequestID  ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID  ');  
		$this->db->select(' tbl_booking_date1.CancelLoads');  
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking1.MaterialID ');    		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.TonBook ');  
		$this->db->select(' tbl_booking1.LoadType ');  
		$this->db->select(' tbl_booking1.LorryType ');		
		$this->db->select(' tbl_booking1.Loads ');  	   
		$this->db->select(' tbl_booking_request.OpportunityID ');
		$this->db->select(' tbl_booking_date1.BookingDate as BookingDateTime1 ');
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');
		
		$this->db->select('(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID and 
		tbl_booking_loads1.AutoCreated = 1 ) as TotalLoadAllocated '); 
		
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID AND 
		DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") = CURDATE() and tbl_booking_loads1.AutoCreated = 1 ) as DistinctLorry ');   
		 
		$this->db->select(' tbl_booking_request.ContactEmail ');   
		$this->db->select(' tbl_booking_request.CompanyName ');	 	
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');
		
		$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');  
		$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID','LEFT');  
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		
		$this->db->where('tbl_booking_date1.BookingDateStatus = 1 '); 
		//$this->db->where('tbl_booking_date1.BookingDateStatus = 0 '); 
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") = CURDATE()');   
		$this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN tbl_booking1.Loads-tbl_booking_date1.CancelLoads-(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ) > 0 
		ELSE tbl_booking1.Loads-tbl_booking_date1.CancelLoads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID  AND 
		DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)'); 
        $this->db->from('tbl_booking_date1');  
		//$this->db->group_by("tbl_booking_date1.BookingID");                
		$this->db->order_by('tbl_booking_date1.BookingID', 'DESC');  
        $query = $this->db->get();
        //echo $this->db->last_query();       
	   // exit;
        $result = $query->result();        
        return $result;
    }
	
	function OverdueBookingRequest()
    { 
		$this->db->select(' tbl_booking_date1.BookingRequestID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID  ');  
		$this->db->select(' tbl_booking_date1.BookingID  ');  
		$this->db->select(' tbl_booking_date1.CancelLoads');   
		$this->db->select(' tbl_booking1.MaterialID ');    		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.TonBook '); 
		$this->db->select(' tbl_booking1.LoadType ');  
		$this->db->select(' tbl_booking1.LorryType ');		
		$this->db->select(' tbl_booking1.Loads ');  	 	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		 
		$this->db->select(' tbl_booking_request.CompanyID');  	 		
		$this->db->select(' tbl_booking_date1.BookingDate as BookingDateTime1 '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	      
		$this->db->select('(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID 
		and tbl_booking_loads1.AutoCreated = 1  ) as TotalLoadAllocated '); 
		  
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID AND 
		tbl_booking_loads1.AutoCreated = 1  ) as DistinctLorry ');  
		
		$this->db->select(' tbl_booking_request.ContactEmail ');   
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');
		    
		$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID','LEFT');  
		$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');   
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
        $this->db->from('tbl_booking_date1');   
		$this->db->where('tbl_booking_date1.BookingDateStatus = 1 ');   
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") < CURDATE()'); 
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") > CURDATE() - INTERVAL 30 DAY');  
		$this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN 
		tbl_booking1.Loads-tbl_booking_date1.CancelLoads-(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ) > 0 
		ELSE tbl_booking1.Loads-tbl_booking_date1.CancelLoads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID  AND 
		DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") < CURDATE()  ) > 0 
		END)');
		$this->db->order_by('tbl_booking_date1.BookingDateID', 'DESC');    
		//$this->db->limit(30);
        $query = $this->db->get();
        //echo $this->db->last_query();       
	    //exit;
        $result = $query->result();        
        return $result;
    }
	function FutureBookingRequest()
    {
        $this->db->select(' tbl_booking_date1.BookingRequestID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID  ');   
		$this->db->select(' tbl_booking1.MaterialID ');    		
		$this->db->select(' tbl_booking1.BookingType ');  	
		$this->db->select(' tbl_booking1.TonBook ');  		
		$this->db->select(' tbl_booking1.LoadType '); 
		$this->db->select(' tbl_booking1.LorryType ');		
		$this->db->select(' tbl_booking1.Loads ');  	    	  
		$this->db->select(' tbl_booking_date1.BookingDate as BookingDateTime1 ');  	 	  
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	      
		$this->db->select('(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID and tbl_booking_loads1.AutoCreated = 1 ) as TotalLoadAllocated ');  
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID AND 
		tbl_booking_loads1.AutoCreated = 1  ) as DistinctLorry ');  
		$this->db->select(' tbl_booking_request.ContactEmail ');   
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');	  
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		
		$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID','LEFT');  
		$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');   
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		
		$this->db->where('tbl_booking_date1.BookingDateStatus = 1 ');  
		$this->db->where(' DATE(tbl_booking_date1.BookingDate) > DATE(CURDATE())'); 
		$this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN tbl_booking1.Loads-(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ) > 0 ELSE 
		tbl_booking1.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID  AND 
		DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") > CURDATE()  ) > 0 
		END)'); 
        $this->db->from('tbl_booking_date1'); 		           
		//$this->db->group_by("tbl_booking_date.BookingID");  
		$this->db->order_by('tbl_booking_date1.BookingID', 'DESC');   
        $query = $this->db->get();
        //echo $this->db->last_query();       
	    //exit;
        $result = $query->result();        
        return $result;
    }  
	public function GetBookingBasicInfo1($BookingDateID){
		$this->db->select(' tbl_booking1.BookingType  ');  	 	 
		$this->db->select(' tbl_booking1.TonBook  ');  	 	 
		$this->db->select(' tbl_booking1.TotalTon  ');  	 	 
		$this->db->select(' tbl_booking1.TonPerLoad	  ');  	 
		$this->db->select(' tbl_booking1.Loads ');   
		$this->db->select(' tbl_booking1.TipID ');
		$this->db->select(' tbl_booking_request.OpportunityID ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDate ');  	 	 
		$this->db->select('tbl_booking_request.CompanyName'); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking1.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_materials.Type FROM tbl_materials where tbl_materials.MaterialID = tbl_booking1.MaterialID ) as MaterialType '); 
		$this->db->select('tbl_booking_request.OpportunityName '); 
		$this->db->from('tbl_booking_date1');    
		$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID',"LEFT");  
		$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');   
		$this->db->where('tbl_booking_date1.BookingDateID',$BookingDateID); 		 
		$query = $this->db->get();
		return $query->row_array();
	}
	
	function DriverTodayTARequestList(){  
		$this->db->select('tbl_booking_loads1.DriverID');
		$this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") = CURDATE()');   
		$this->db->where('tbl_booking1.BookingType = 1');  
		$this->db->where('tbl_booking1.LoadType = 2');  
		$this->db->where('tbl_booking_loads1.Status < 4');  
		$query = $this->db->get(); 
		return $query->result_array(); //$query->result();     
	}
	function DriverTodayTARequestList1(){  
		$this->db->select('tbl_booking_loads1.DriverID');
		$this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") = CURDATE()');   
		$this->db->where('tbl_booking1.BookingType = 2');  
		$this->db->where('tbl_booking1.LoadType = 2');  
		$this->db->where('tbl_booking_loads1.Status < 4');  
		$query = $this->db->get(); 
		return $query->result_array(); //$query->result();     
	}
	function DriverBookedRequestList($Date){  
		$this->db->select('tbl_booking_loads1.DriverID');
		$this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y")',$Date);   
		$this->db->where('tbl_booking1.BookingType = 1');  
		$this->db->where('tbl_booking1.LoadType = 2');  
		$query = $this->db->get(); 
		//echo $this->db->last_query();       
	    //exit;
		return $query->result_array(); //$query->result();     
	}
	function DriverBookedRequestList1($Date){  
		$this->db->select('tbl_booking_loads1.DriverID');
		$this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID',"LEFT"); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y")',$Date);   
		$this->db->where('tbl_booking1.BookingType = 2');  
		$this->db->where('tbl_booking1.LoadType = 2');  
		$query = $this->db->get(); 
		//echo $this->db->last_query();       
	    //exit;
		return $query->result_array(); //$query->result();     
	}
	function ShowBookingRequestDateLoads($BookingDateID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking_loads1.DriverID,tbl_booking_loads1.DriverName, tbl_booking_loads1.VehicleRegNo, tbl_booking_loads1.Status, tbl_booking_loads1.ConveyanceNo, tbl_booking_loads1.AutoCreated ');
		$this->db->select('tbl_drivers_login.DriverName as dname, tbl_drivers.RegNumber as vrn' );
        $this->db->from('tbl_booking_loads1');
        $this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID',"LEFT"); 
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT"); 
        $this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ',"LEFT"); 	
		$this->db->join('tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");    
        $this->db->where('tbl_booking_loads1.BookingDateID', $BookingDateID);
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function ShowBookingDateLoads1($BookingDateID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking_loads1.DriverName, tbl_booking_loads1.VehicleRegNo, tbl_booking_loads1.Status, tbl_booking_loads1.ConveyanceNo, tbl_booking_loads1.AutoCreated ');
		$this->db->select('tbl_drivers_login.DriverName as dname, tbl_drivers.RegNumber as vrn' );
        $this->db->from('tbl_booking_loads1');
        $this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID',"LEFT"); 
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT"); 
        $this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ',"LEFT"); 	
		$this->db->join('tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");    
        $this->db->where('tbl_booking_loads1.BookingDateID', $BookingDateID);
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function GetBookingInfo1($id){
		$this->db->select('tbl_booking1.*');  
		$this->db->select('tbl_booking1.SICCode as LoadSICCODE');  
		$this->db->select('tbl_booking_request.OpportunityID');   
		$this->db->select('tbl_booking_request.CompanyID');   
		$this->db->select('(select tbl_materials.SicCode FROM tbl_materials where tbl_materials.MaterialID = tbl_booking1.MaterialID ) as SicCode '); 		
        $this->db->from('tbl_booking1'); 
		$this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');   
        $this->db->where('tbl_booking1.BookingID',$id);		
		$query = $this->db->get(); 
		return $query->row();
		//return $query->row_array();
	}
	
	public function GetAllocatedBookingRequestData1(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingRequestID ');  	 		
		$this->db->select(' tbl_booking_loads1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID  ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking1.MaterialID ');  	 		
		$this->db->select(' tbl_booking1.BookingType');  
		$this->db->select(' tbl_booking1.TonBook ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 		
		$this->db->select(' tbl_booking1.LorryType ');  	
		$this->db->select(' tbl_booking1.Loads ');  	   
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	  

		$this->db->select(' datediff( CURDATE(), tbl_booking_date1.BookingDate)  as BookingDateDiff ');  	 	  
		
		$this->db->select(' tbl_booking_request.ContactEmail ');    
		$this->db->join('tbl_booking_date1', ' tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ','LEFT'); 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT'); 
		$this->db->join('tbl_booking1', '  tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT');  
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID '); 
		$this->db->where('tbl_booking_date1.BookingDateStatus = 1 ');   
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") > CURDATE() - INTERVAL 30 DAY'); 
		$this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN tbl_booking1.Loads-(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID ) = 0 ELSE 
		tbl_booking1.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID ) = 0 
		END)'); 
		
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking1.BookingID', $s[$i]);  
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end();

				}
			}    
        }  
		//$this->db->group_by("tbl_booking_loads.LoadID");             
		$this->db->group_by("tbl_booking_date1.BookingID"); 
		$this->db->order_by($columnName, $columnSortOrder);		 
        $query = $this->db->get('tbl_booking_loads1');
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
	public function GetAllocatedBookingRequestDataArchived(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingRequestID ');  	 		
		$this->db->select(' tbl_booking_loads1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID  ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking1.MaterialID ');  	 		
		$this->db->select(' tbl_booking1.BookingType');  
		$this->db->select(' tbl_booking1.TonBook ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 		
		$this->db->select(' tbl_booking1.LorryType ');  	
		$this->db->select(' tbl_booking1.Loads ');  	   
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	  
		 
		$this->db->select(' tbl_booking_request.ContactEmail ');    
		$this->db->join('tbl_booking_date1', ' tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ','LEFT'); 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT'); 
		$this->db->join('tbl_booking1', '  tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT');  
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID '); 
		$this->db->where('tbl_booking_date1.BookingDateStatus = 1 '); 
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") < CURDATE() - INTERVAL 30 DAY');  
		$this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN tbl_booking1.Loads-(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID ) = 0 ELSE 
		tbl_booking1.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID ) = 0 
		END)'); 
		
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking1.BookingID', $s[$i]);  
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end();

				}
			}    
        }  
		//$this->db->group_by("tbl_booking_loads.LoadID");             
		$this->db->group_by("tbl_booking_date1.BookingID"); 
		$this->db->order_by($columnName, $columnSortOrder);		 
        $query = $this->db->get('tbl_booking_loads1');
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
	
	public function GetRequestPendingLoadsData(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingDateID ');  	 	 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.LoadID ');   
		$this->db->select(' tbl_booking_loads1.Status ');  	 		 
		$this->db->select(' tbl_booking_loads1.DriverID '); 
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		 		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking1.TonBook ');  	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  
		
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');
		
		$this->db->join('tbl_booking_date1', ' tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ', 'LEFT'); 		 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');   
		$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ', 'LEFT'); 
		 
		$this->db->where('tbl_booking_loads1.Status = 0 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking1.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
					$this->db->group_end(); 
				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads1');
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
	
	public function GetNonAppRequestLoadsData($BookingRequestID){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingDateID ');  	 	 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		
		$this->db->select(' tbl_booking_loads1.GrossWeight ');  	 		 
		$this->db->select(' tbl_booking_loads1.Net ');  	 		
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');    
		$this->db->select(' tbl_booking_loads1.NonAppConveyanceNo ');    
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverLoginID '); 
		
		//$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads1.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.Tare ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking1.TonBook ');  	 
		 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y  %T") as ConveyanceDate '); 
		
		$this->db->select(' tbl_materials.MaterialName ');		
		  
		$this->db->join('tbl_booking_date1', ' tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ', 'LEFT'); 		  
		$this->db->join('tbl_drivers', ' tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		 
		$this->db->join('tbl_drivers_login', ' tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ', 'LEFT'); 		  
		$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ', 'LEFT');   
		
		$this->db->where('tbl_booking_loads1.BookingRequestID',$BookingRequestID); 
		//$this->db->where('tbl_booking_loads1.DriverLoginID = "0" '); 
		$this->db->where('tbl_drivers.AppUser = 1 '); 
		$this->db->where('tbl_booking_loads1.Status < 4 '); 
		$this->db->where('tbl_booking_loads1.Status > 0 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						/*$this->db->or_like('tbl_booking1.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers_login.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   */
					$this->db->group_end();

				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads1');
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
	
	public function GetAllNonAppRequestLoadsData(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingDateID ');  	 	 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		
		$this->db->select(' tbl_booking_loads1.GrossWeight ');  	 		 
		$this->db->select(' tbl_booking_loads1.Net ');  	 		
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');    
		$this->db->select(' tbl_booking_loads1.NonAppConveyanceNo ');    
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverLoginID '); 
		
		//$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads1.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.Tare ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking1.TonBook ');  	 

		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		$this->db->select(' tbl_booking_request.CompanyName ');  	 		 
		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y  %T") as ConveyanceDate '); 
		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');   
		$this->db->join('tbl_booking_date1', ' tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ', 'LEFT'); 		  
		$this->db->join('tbl_drivers', ' tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		 
		$this->db->join('tbl_drivers_login', ' tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ', 'LEFT'); 		  
		$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ', 'LEFT');   
		 
		//$this->db->where('tbl_booking_loads1.DriverLoginID = "0" '); 
		$this->db->where('tbl_drivers.AppUser = 1 '); 
		$this->db->where('tbl_booking_loads1.Status < 4 '); 
		$this->db->where('tbl_booking_loads1.Status > 0 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						/*$this->db->or_like('tbl_booking1.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers_login.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   */
					$this->db->group_end();

				}
			}    
        }
		
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads1');
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
	
	public function GetRequestLoadsData(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingDateID ');  	 	 
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_tickets.TicketNumber ');  
		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverLoginID '); 
		
		//$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads1.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 				
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking1.TonBook ');  	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  
		
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_materials.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');
		
		$this->db->join('tbl_booking_date1', ' tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ', 'LEFT'); 		
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ', 'LEFT'); 		 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT'); 
		$this->db->join('tbl_drivers', ' tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		 
		$this->db->join('tbl_drivers_login', ' tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ', 'LEFT'); 		  
		$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ', 'LEFT'); 
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ', 'LEFT'); 
		
		$this->db->where('tbl_booking_loads1.Status < 4 '); 
		$this->db->where('tbl_booking_loads1.Status > 0 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking1.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers_login.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
					$this->db->group_end();

				}
			}    
        }
 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads1');
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
	
	public function GetRequestLoadsData1(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingDateID '); 		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');
		$this->db->select(' tbl_tickets.TicketNumber '); 
		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads1.Status ');  	 	
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.TonBook ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		 
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');  
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID  ','LEFT'); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ', 'LEFT'); 
		
		$this->db->where('tbl_booking_loads1.Status = 4 '); 
		//$this->db->where('DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%Y-%m-%d") < CURDATE()'); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%Y-%m-%d") > CURDATE() - INTERVAL 10 DAY');  
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking1.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						
					$this->db->group_end(); 
				}
			}    
        }
		 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads1');
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
	public function GetRequestLoadsDataArchived(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingDateID '); 		
		$this->db->select(' tbl_booking_request.CompanyID ');  
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_tickets.TicketNumber '); 
		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads1.Status ');  	 	
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.TonBook ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		 
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');  
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID  ','LEFT'); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ', 'LEFT'); 
		
		$this->db->where('tbl_booking_loads1.Status = 4 '); 
		//$this->db->where('DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%Y-%m-%d") < CURDATE()'); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%Y-%m-%d") < CURDATE() - INTERVAL 30 DAY');  
		
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking1.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						
					$this->db->group_end(); 
				}
			}    
        }
		 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads1');
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
	public function GetRequestLoadsData2(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  

        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingRequestID');  	 		
		$this->db->select(' tbl_booking_loads1.BookingDateID ');	 		
		$this->db->select(' tbl_booking_request.CompanyID  ');  	 		
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_tickets.TicketNumber '); 
		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads1.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');
		//$this->db->select(' tbl_drivers.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking1.TonBook ');  	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		 
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		 		 
		$this->db->join('tbl_booking1', ' tbl_booking_loads1.BookingID = tbl_booking1.BookingID  ',"LEFT"); 		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');  
		//$this->db->join('tbl_materials', 'tbl_booking1.MaterialID = tbl_materials.MaterialID ',"LEFT");  
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ',"LEFT"); 		
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT"); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID',"LEFT"); 		
		$this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ',"LEFT"); 		
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ', 'LEFT'); 
		
		$this->db->where('tbl_booking_loads1.Status = 5 '); 
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking1.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]); 
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);  
						$this->db->or_like('tbl_booking1.MaterialName', $s[$i]);   
						$this->db->or_like('  DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y %T") ', $s[$i]);   
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") ', $s[$i]);   
						
					$this->db->group_end(); 
				}
			}    
        }
		 
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_booking_loads1');
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
	function ShowRequestLoadDetails($LoadID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEndDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteInDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOutDateTime ');
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime2,"%d/%m/%Y %T") as SiteInDateTime2 ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d/%m/%Y %T") as SiteOutDateTime2 ');   
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.CancelDateTime,"%d/%m/%Y %T") as CancelDateTime ');   
		$this->db->select('tbl_booking_loads1.CancelNote ');    
		$this->db->select('tbl_booking_loads1.LoadID ');
		$this->db->select('tu.name as CancelByName , tu.email as CancelByEmail , tu.mobile as CancelByMobile ');
		
		$this->db->select('tbl_booking_loads1.ReceiptName ');     
		$this->db->select('tbl_users.name as CreatedByName , tbl_users.email as CreatedByEmail , tbl_users.mobile as CreatedByMobile ');
		$this->db->select('tbl_tipaddress.TipName,tbl_tipaddress.TipID, tbl_materials.MaterialName');
		$this->db->select('tbl_booking1.Price, tbl_booking1.PurchaseOrderNo, tbl_booking_request.ContactEmail, tbl_booking_request.Notes, tbl_booking_request.ContactName, tbl_booking_request.ContactMobile'); 
		$this->db->select('tbl_booking_request.CompanyName, tbl_booking_request.CompanyID as ComID, tbl_booking_request.OpportunityName , tbl_booking_request.OpportunityID as OppID  ');
		$this->db->select('tbl_booking_loads1.DriverName,tbl_booking_loads1.DriverID, tbl_booking_loads1.VehicleRegNo, tbl_booking_loads1.Status, 
		tbl_booking_loads1.ConveyanceNo, tbl_booking_loads1.TicketID, tbl_booking_loads1.TicketUniqueID');
		$this->db->select('tbl_drivers_login.DriverName as dname, tbl_drivers.RegNumber as vrn, tbl_drivers_login.MobileNo as DriverMobile, tbl_drivers_login.Email as DriverEmail' );
        $this->db->from('tbl_booking_loads1'); 
        $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT');  
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');  
		//$this->db->join('tbl_users', 'tbl_booking1.BookedBy = tbl_users.userId ','LEFT'); 
		$this->db->join('tbl_users', 'tbl_booking_loads1.CreatedBy = tbl_users.userId ','LEFT'); 
		$this->db->join('tbl_users tu', 'tbl_booking_loads1.CancelBy = tu.userId ','LEFT'); 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID','LEFT');  
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo','LEFT'); 
        $this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID ','LEFT'); 	
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID','LEFT');  
        $this->db->where('tbl_booking_loads1.LoadID', $LoadID);                     
        $query = $this->db->get(); 
        //echo $this->db->last_query();       
	    //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	function ShowRequestLoadPhotos($LoadID)
    { 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads_photos1.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');    
		$this->db->select('tbl_booking_loads_photos1.*'); 
        $this->db->from('tbl_booking_loads_photos1'); 
        $this->db->join('tbl_booking_loads1', 'tbl_booking_loads_photos1.LoadID =tbl_booking_loads1.LoadID','LEFT');   
        $this->db->where('tbl_booking_loads_photos1.LoadID', $LoadID);                     
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	
	function BookingRequestLoadInfo($id){
		$this->db->select('tbl_booking_loads1.LoadID');  
		$this->db->select('tbl_booking_loads1.Status');   
		$this->db->select('tbl_booking_loads1.ConveyanceNo');   
		$this->db->select('tbl_booking_loads1.DriverName');   
		$this->db->select('tbl_booking_loads1.VehicleRegNo');   
		$this->db->select('tbl_booking_loads1.Signature');   
		$this->db->select('tbl_booking_loads1.DriverID');   
		$this->db->select('tbl_booking_loads1.DriverLoginID');   
		$this->db->select('tbl_booking_loads1.Tare');    
		$this->db->select('tbl_booking_loads1.CustomerName');  
		$this->db->select('tbl_booking_loads1.ReceiptName');   
		$this->db->select('tbl_booking_loads1.BookingID');   
		$this->db->select('tbl_booking_loads1.TipID ');	
		$this->db->select('tbl_booking_loads1.TicketID ');	
		$this->db->select('tbl_booking_loads1.TipNumber ');	
		$this->db->select('tbl_booking_loads1.GrossWeight ');	
		
		$this->db->select('tbl_booking1.LoadType');   
		$this->db->select('tbl_booking1.LorryType');   
		$this->db->select('tbl_booking1.TonBook'); 
		$this->db->select('tbl_booking_request.CompanyID ');	
		$this->db->select('tbl_booking1.BookingType');   
		$this->db->select('tbl_booking_request.OpportunityID ');	 
		$this->db->select('tbl_booking_request.BookingRequestID  ');
		
		$this->db->select(' tbl_materials.MaterialName ');			
		$this->db->select(' tbl_materials.MaterialID ');		
		$this->db->select(' tbl_materials.SicCode ');			 
		$this->db->select(' tbl_booking1.SICCode as LoadSICCODE ');			 
        
		$this->db->select(' tbl_booking_request.CompanyName ');    
		$this->db->select(' tbl_booking_request.OpportunityName ');	  
		 
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
		$this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ',"LEFT");  
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');  
		$this->db->join(' tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo  ',"LEFT");  
		$this->db->join(' tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID  ',"LEFT");  
		$this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ',"LEFT"); 
		$this->db->join(' tbl_materials', 'tbl_materials.MaterialID = tbl_booking_loads1.MaterialID',"LEFT");   
        $this->db->where('tbl_booking_loads1.LoadID ',$id);		
		$query = $this->db->get(); 
		return $query->row();
		//return $query->row_array();
	}
	public function GetPreInvoiceList(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_request.BookingRequestID ');   	 		
		$this->db->select(' tbl_booking_request.CompanyID  as CompanyID  ');   
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName ');	 	
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		$this->db->select(' tbl_booking_request.InvoiceComment ');		
		$this->db->select(' tbl_booking_request.InvoiceHold');		
		$this->db->select(' tbl_booking1.TonBook ');		
		//$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID  and  tbl_booking_loads1.Status > 3 ) as TotalLoadAllocated ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_request.CreateDateTime,"%d-%m-%Y") as BookingDateTime ');  	    
		$this->db->join('tbl_booking1', 'tbl_booking_request.BookingRequestID = tbl_booking1.BookingRequestID ',"LEFT");  
		$this->db->where('(select count(*) from tbl_booking_loads1 where  tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID  and  tbl_booking_loads1.Status > 3 ) > 0  ');		 
		
		$this->db->where('tbl_booking_request.BookingRequestID > 9200');		 
		//$this->db->join('tbl_booking1', 'tbl_booking_request.BookingRequestID = tbl_booking1.BookingRequestID ',"LEFT");  
		//$this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN tbl_booking1.Loads-(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID and tbl_booking_loads1.Status > 3 ) > 0 ELSE 
		//tbl_booking1.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID and tbl_booking_loads1.Status > 3  ) = 0 
		//END)');  
		
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]);  
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);  
						$this->db->or_like('  DATE_FORMAT(tbl_booking_request.CreateDateTime,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end(); 
				}
			}    
        }    
		$this->db->group_by('tbl_booking_request.BookingRequestID');             
		$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->limit(500);
        $query = $this->db->get('tbl_booking_request');
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
	
	public function GetMyInvoiceList(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();  
		$this->db->select(' tbl_booking_invoice.CompanyID  as CompanyID  ');   
		$this->db->select(' tbl_booking_invoice.InvoiceType ');		
		$this->db->select(' tbl_booking_invoice.OpportunityID ');		
		$this->db->select(' tbl_booking_invoice.CompanyName ');	 	
		$this->db->select(' tbl_booking_invoice.OpportunityName ');		
		$this->db->select(' tbl_booking_invoice.InvoiceNumber ');	 	 
		$this->db->select(' tbl_booking_invoice.InvoiceID ');	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_invoice.InvoiceDate,"%d-%m-%Y") as InvoiceDate ');  	 
		$this->db->where('tbl_booking_invoice.Status','1');  
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						//$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]);  
						//$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						//$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);  
						//$this->db->or_like('  DATE_FORMAT(tbl_booking_request.CreateDateTime,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end(); 
				}
			}    
        }    
		$this->db->group_by('tbl_booking_invoice.InvoiceID');             
		$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->limit(500);
        $query = $this->db->get('tbl_booking_invoice');
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
	
	public function GetInvoiceList(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();  
		$this->db->select(' tbl_booking_invoice.CompanyID  as CompanyID  ');   
		$this->db->select(' tbl_booking_invoice.InvoiceType ');		
		$this->db->select(' tbl_booking_invoice.OpportunityID ');		
		$this->db->select(' tbl_booking_invoice.CompanyName ');	 	
		$this->db->select(' tbl_booking_invoice.OpportunityName ');		
		$this->db->select(' tbl_booking_invoice.InvoiceNumber ');	 	 
		$this->db->select(' tbl_booking_invoice.InvoiceID ');	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_invoice.InvoiceDate,"%d-%m-%Y") as InvoiceDate ');  	 
		$this->db->where('tbl_booking_invoice.Status','1');  
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						//$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]);  
						//$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						//$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);  
						//$this->db->or_like('  DATE_FORMAT(tbl_booking_request.CreateDateTime,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end(); 
				}
			}    
        }    
		$this->db->group_by('tbl_booking_invoice.InvoiceID');             
		$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->limit(500);
        $query = $this->db->get('tbl_booking_invoice');
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
	
	public function GetMyReadyInvoiceList(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();  
		$this->db->select(' tbl_booking_invoice.CompanyID  as CompanyID  ');   
		$this->db->select(' tbl_booking_invoice.InvoiceType ');		
		$this->db->select(' tbl_booking_invoice.OpportunityID ');		
		$this->db->select(' tbl_booking_invoice.CompanyName ');	 	
		$this->db->select(' tbl_booking_invoice.OpportunityName ');		
		$this->db->select(' tbl_booking_invoice.InvoiceNumber ');	 	 
		$this->db->select(' tbl_booking_invoice.InvoiceID ');	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_invoice.InvoiceDate,"%d-%m-%Y") as InvoiceDate ');  	 
		$this->db->where('tbl_booking_invoice.Status','1');  
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						//$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]);  
						//$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						//$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);  
						//$this->db->or_like('  DATE_FORMAT(tbl_booking_request.CreateDateTime,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end(); 
				}
			}    
        }    
		$this->db->group_by('tbl_booking_invoice.InvoiceID');             
		$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->limit(500);
        $query = $this->db->get('tbl_booking_invoice');
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
	
	public function GetReadyInvoiceList(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();  
		$this->db->select(' tbl_booking_invoice.CompanyID  as CompanyID  ');   
		$this->db->select(' tbl_booking_invoice.InvoiceType ');		
		$this->db->select(' tbl_booking_invoice.OpportunityID ');		
		$this->db->select(' tbl_booking_invoice.CompanyName ');	 	
		$this->db->select(' tbl_booking_invoice.OpportunityName ');		
		$this->db->select(' tbl_booking_invoice.InvoiceNumber ');	 	 
		$this->db->select(' tbl_booking_invoice.InvoiceID ');	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_invoice.InvoiceDate,"%d-%m-%Y") as InvoiceDate ');  	 
		$this->db->where('tbl_booking_invoice.Status','1');  
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						//$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]);  
						//$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						//$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);  
						//$this->db->or_like('  DATE_FORMAT(tbl_booking_request.CreateDateTime,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end(); 
				}
			}    
        }    
		$this->db->group_by('tbl_booking_invoice.InvoiceID');             
		$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->limit(500);
        $query = $this->db->get('tbl_booking_invoice');
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
	
	public function GetMyPreInvoiceList(){
 
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking_request.BookingRequestID ');   	 		
		$this->db->select(' tbl_booking_request.CompanyID  as CompanyID  ');   
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName ');	 	
		$this->db->select(' tbl_booking_request.OpportunityName ');		
		$this->db->select(' tbl_booking_request.InvoiceHold ');	
		$this->db->select(' tbl_booking_request.InvoiceComment ');			
		$this->db->select(' tbl_booking1.TonBook ');		
		//$this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID  and  tbl_booking_loads1.Status > 3 ) as TotalLoadAllocated ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_request.CreateDateTime,"%d-%m-%Y") as BookingDateTime ');  	    
		$this->db->join('tbl_booking1', 'tbl_booking_request.BookingRequestID = tbl_booking1.BookingRequestID ',"LEFT");  
		$this->db->where('tbl_booking_request.PriceBy',$this->session->userdata['userId']);  
		$this->db->where('(select count(*) from tbl_booking_loads1 where  tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID  and  tbl_booking_loads1.Status > 3 ) > 0  ');		 
		
		//$this->db->join('tbl_booking1', 'tbl_booking_request.BookingRequestID = tbl_booking1.BookingRequestID ',"LEFT");  
		//$this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN tbl_booking1.Loads-(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID and tbl_booking_loads1.Status > 3 ) > 0 ELSE 
		//tbl_booking1.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID and tbl_booking_loads1.Status > 3  ) = 0 
		//END)');  
		
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]);  
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);  
						$this->db->or_like('  DATE_FORMAT(tbl_booking_request.CreateDateTime,"%d-%m-%Y") ', $s[$i]);    
					$this->db->group_end(); 
				}
			}    
        }    
		$this->db->group_by('tbl_booking_request.BookingRequestID');             
		$this->db->order_by($columnName, $columnSortOrder);		 
		$this->db->limit(100);	
        $query = $this->db->get('tbl_booking_request');
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
	
	function PreInvoiceLoadInfo($BookingRequestID){ 
        $this->db->select('(select count(*) from tbl_booking_loads1 where  tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID and tbl_booking_loads1.Status > 3 ) as TotalLoad ');   
		$this->db->select(' tbl_booking_date1.BookingID ');  	 		
		$this->db->select(' tbl_booking_date1.BookingRequestID  ');  	 		
		$this->db->select(' tbl_booking_date1.BookingDateID  ');  
		$this->db->select(' tbl_booking_date1.CancelLoads');   	
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  
		$this->db->select(' tbl_booking1.LorryType ');		
		$this->db->select(' tbl_booking1.Loads ');  	     
		$this->db->select(' tbl_booking1.TotalTon ');  	     
		
		$this->db->select(' tbl_booking1.Price ');  	     
		$this->db->select(' tbl_booking1.TotalAmount ');  	     
		$this->db->select(' tbl_booking1.MaterialName ');		 
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  
		
		$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');  
		$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID','LEFT');    
		$this->db->from('tbl_booking_date1');         
		
		$this->db->where('tbl_booking_date1.BookingDateStatus = 1 ');  
		$this->db->where('tbl_booking_date1.BookingRequestID',$BookingRequestID);    
		//$this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN tbl_booking1.Loads-(select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID ) = 0 ELSE 
		//tbl_booking1.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID ) = 0 
		//END)'); 
        $this->db->where('(CASE WHEN tbl_booking1.LoadType=1 THEN (select count(*) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID ) > 0 ELSE 
		(select COUNT(DISTINCT DriverID) from tbl_booking_loads1 where tbl_booking_loads1.BookingID = tbl_booking1.BookingID ) > 0 
		END)'); 
		
		$this->db->order_by('tbl_booking_date1.BookingDateID', 'ASC');  
        $query = $this->db->get();
        //echo $this->db->last_query();       
	   // exit;
        $result = $query->result();        
        return $result;
    }
	function BookingInvoiceItems($InvoiceID){ 
	
		$this->db->select(' Description ');  	 		
		$this->db->select(' Qty ');  	 		
		$this->db->select(' UnitPrice ');  	 		
		$this->db->select(' GrossAmount ');  	 		
		$this->db->select(' ItemNumber ');  	 		 
		$this->db->from('tbl_booking_invoice_item');           
		$this->db->where('tbl_booking_invoice_item.InvoiceID ',$InvoiceID);       
		$this->db->order_by('tbl_booking_invoice_item.ItemNumber', 'ASC');  
        $query = $this->db->get();
       // echo $this->db->last_query();       
	   // exit;
        $result = $query->result();        
        return $result;
    }
	function BookingInvoiceLoads($InvoiceID){ 
	
		$this->db->select(' count(LoadID) as TotalQty ');  	 		
		$this->db->select(' SUM(LoadPrice) as TotalPrice ');  	 		
		$this->db->select(' tbl_materials.MaterialName ');  	 		
		$this->db->select(' tbl_materials.MaterialCode ');  	 		
		$this->db->select(' tbl_booking_invoice_load.LoadPrice ');  	 		
		$this->db->select(' tbl_booking_invoice_load.TaxRate ');  	 		
		//$this->db->select(' tbl_booking_invoice_load.TotalPrice	 ');  	
		$this->db->from('tbl_booking_invoice_load');          
		$this->db->join('tbl_materials', 'tbl_booking_invoice_load.MaterialID = tbl_materials.MaterialID','LEFT');  
		$this->db->where('tbl_booking_invoice_load.InvoiceID ',$InvoiceID);     
		//$this->db->group_by('tbl_booking_invoice_load.MaterialID, tbl_booking_invoice_load.LoadPrice ');             
		$this->db->group_by(array("tbl_booking_invoice_load.MaterialID", "tbl_booking_invoice_load.LoadPrice"));              
		$this->db->order_by('tbl_booking_invoice_load.MaterialID', 'ASC');  
        $query = $this->db->get();
       // echo $this->db->last_query();       
	   // exit;
        $result = $query->result();        
        return $result;
    }
	
	function BookingInvoiceLoadsTonnage($InvoiceID){ 
	
		//$this->db->select(' count(LoadID) as TotalQty ');  	 		  		
		$this->db->select(' SUM(TotalTon) as TotalTon ');  	 		
		$this->db->select(' SUM(TotalPrice) as TotalPrice ');  	 		
		$this->db->select(' tbl_materials.MaterialName ');  	 		
		$this->db->select(' tbl_materials.MaterialCode ');  	 		
		$this->db->select(' tbl_booking_invoice_load.LoadPrice ');  	 		
		$this->db->select(' tbl_booking_invoice_load.TaxRate ');  	 		
		//$this->db->select(' tbl_booking_invoice_load.TotalPrice	 ');  	
		$this->db->from('tbl_booking_invoice_load');          
		$this->db->join('tbl_materials', 'tbl_booking_invoice_load.MaterialID = tbl_materials.MaterialID','LEFT');  
		$this->db->where('tbl_booking_invoice_load.InvoiceID ',$InvoiceID);      
		$this->db->group_by(array("tbl_booking_invoice_load.MaterialID", "tbl_booking_invoice_load.LoadPrice"));              
		$this->db->order_by('tbl_booking_invoice_load.MaterialID', 'ASC');  
        $query = $this->db->get();
       // echo $this->db->last_query();       
	   // exit;
        $result = $query->result();        
        return $result;
    }
	
	
	function ShowPreInvoiceLoads($BookingDateID)
    {
        $this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") as TicketDate ');    
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_tickets.TicketNumber ');
		$this->db->select('tbl_tickets.GrossWeight');
		$this->db->select('tbl_tickets.Tare');
		$this->db->select('tbl_tickets.pdf_name as TicketPDF');
		$this->db->select('tbl_booking_loads1.ReceiptName as ConvPDF');
		$this->db->select('tbl_booking_loads1.LoadID '); 
		$this->db->select('tbl_booking1.Price '); 
		$this->db->select('tbl_tickets.Net'); 
		$this->db->select('tbl_booking_request.WaitingCharge');	
		$this->db->select('ROUND(TIMESTAMPDIFF(MINUTE, SiteInDateTime, SiteOutDateTime) - tbl_booking_request.WaitingTime ) AS WaitTime');  
		$this->db->select('tbl_booking_loads1.DriverName, tbl_booking_loads1.VehicleRegNo, tbl_booking_loads1.Status, tbl_booking_loads1.ConveyanceNo, tbl_booking_loads1.AutoCreated ');
		$this->db->select('tbl_drivers.Haulier ' );
        $this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');    
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID','LEFT');    
        $this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID',"LEFT"); 
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID',"LEFT"); 
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT");  
		$this->db->join('tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");    
        $this->db->where('tbl_booking_loads1.BookingDateID', $BookingDateID);
		$this->db->group_by('tbl_booking_loads1.LoadID');             
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }
	
	function ShowPreInvoiceLoadsByRequest($BookingRequestID)
    {
		$this->db->select('tbl_booking_loads1.TipID ');
		$this->db->select('tbl_booking_loads1.NonAppConveyanceNo ');
		$this->db->select('tbl_drivers.AppUser ');
        
		$this->db->select('tbl_tickets.Conveyance as TicketConveyance');
		
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") as TicketDate ');    
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y") as SiteOutDateTime ');    
		$this->db->select('tbl_booking_loads1.BookingDateID ');
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialID, tbl_materials.MaterialName');
		$this->db->select('tbl_tickets.TicketNumber ');
		$this->db->select('tbl_tickets.GrossWeight');
		$this->db->select('tbl_tickets.Tare');
		$this->db->select('tbl_tickets.pdf_name as TicketPDF');
		$this->db->select('tbl_booking_loads1.ReceiptName as ConvPDF');
		$this->db->select('tbl_booking_loads1.LoadID '); 
		$this->db->select('tbl_booking_loads1.TipNumber '); 
		$this->db->select('tbl_booking1.Price '); 
		$this->db->select('tbl_tickets.Net'); 
		$this->db->select('tbl_booking_request.WaitingCharge');	
		$this->db->select('ROUND(TIMESTAMPDIFF(MINUTE, SiteInDateTime, SiteOutDateTime) - tbl_booking_request.WaitingTime ) AS WaitTime');  
		$this->db->select('tbl_booking_loads1.DriverName, tbl_booking_loads1.VehicleRegNo, tbl_booking_loads1.Status, tbl_booking_loads1.ConveyanceNo, tbl_booking_loads1.AutoCreated ');
		$this->db->select('tbl_drivers.Haulier ' );
		
		$this->db->select(' tbl_tipticket.TipTicketID '); 
		$this->db->select(' tbl_tipticket.TipTicketNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  	 	  	 	      
		
        $this->db->from('tbl_booking_loads1'); 
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');    
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID','LEFT');    
        $this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID',"LEFT"); 
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID',"LEFT"); 
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT");  
		$this->db->join('tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");  
		$this->db->join('tbl_booking_invoice_load', ' tbl_booking_loads1.LoadID = tbl_booking_invoice_load.LoadID',"LEFT OUTER");  
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		 
 
		$this->db->where('tbl_booking_invoice_load.LoadID IS NULL');  
		$this->db->where('tbl_booking_loads1.BookingRequestID', $BookingRequestID);
		$this->db->where('tbl_booking_loads1.Status > 3 ');  
		$this->db->where('tbl_booking_loads1.Hold = 0 ');  
		$this->db->group_by('tbl_booking_loads1.LoadID');             
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        $result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result;
    }	
	function BookingDateAllocatedLoadPlus($BookingDateID){
        $sql="UPDATE `tbl_booking_date1` set `AllocatedLoads` =`AllocatedLoads`+1 where `BookingDateID` =  '".$BookingDateID."' ";    
		$resultU = $this->db->query($sql);
		return $resultU; 
    }
	function BookingDateAllocatedLoadMinus($BookingDateID){
        $sql="UPDATE `tbl_booking_date1` set `AllocatedLoads` =`AllocatedLoads`-1 where `BookingDateID` =  '".$BookingDateID."' ";    
		$resultU = $this->db->query($sql);
		return $resultU; 
    }
	
	
	public function WaitTimeSplitExcelConveyanceTickets($OpportunityID,$CompanyName,$OpportunityName,$Reservation,$TipName,$SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status,$Search,$Price){
		//print_r($_POST);
		//exit;
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo));  
		$OpportunityID = trim(strtolower($OpportunityID));  
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$WaitTime = trim(strtolower($WaitTime));   
		$Status = trim(strtolower($Status));     
		$MaterialName = trim(strtolower($MaterialName));   
		$TipName = trim(strtolower($TipName));   
        $Reservation = trim(strtolower($Reservation));
		
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
		 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status"); 
		
		
		$this->db->select(' td3.GUID as ConveyanceGUID ');  
		$this->db->select(' tbl_tickets.Conveyance as TicketConveyance ');  
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		
		$this->db->select(' tbl_tickets.pdf_name '); 		
		$this->db->select(' tbl_tickets.Net  '); 
		$this->db->select(' tbl_tickets.TicketNumber as SuppNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y") as SuppDate ');  
		
		$this->db->select(' tbl_tipticket.TipTicketID '); 
		$this->db->select(' tbl_tipticket.TipTicketNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  
		
		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	  
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		
		
		$this->db->select(' tbl_booking_request.WaitingTime ');
		$this->db->select(' tbl_booking_request.WaitingCharge ');
		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking1.Price ');		 
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_tipaddress.TipName ');
		$this->db->select(' concat(tbl_tipaddress.Street1,tbl_tipaddress.Street2,tbl_tipaddress.Town,tbl_tipaddress.County,tbl_tipaddress.PostCode) as TipAddress '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		$this->db->select('  ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60),2)  as WaitTime ');  	 	  	 	      
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%H.%i ") as ArrivalTime ');  	
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%H.%i ") as DeptTime ');  	 		
			
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo ','LEFT'); 		 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		  
		$this->db->join('tbl_tickets_documents as td3', 'tbl_tickets.Conveyance = td3.FD_650A620E AND td3.DocTypeID  = "392cf403 " ','LEFT'); 		 
		
		
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 1 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	
		$this->db->where('tbl_booking_request.OpportunityID ',$OpportunityID); 	
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
			$this->db->or_like(' tbl_tickets.Conveyance ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityID', trim($OpportunityID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		//$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
		
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	public function WaitTimeSplitExcelConveyanceTicketsAll($CompanyName,$OpportunityName,$Reservation,$TipName,$SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status,$Search,$Price){
		//print_r($_POST);
		//exit;
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo)); 
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));   
		$WaitTime = trim(strtolower($WaitTime));    
		$MaterialName = trim(strtolower($MaterialName));   
		$TipName = trim(strtolower($TipName));   
        $Reservation = trim(strtolower($Reservation));
		
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
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status"); 
		 
		$this->db->select(' td3.GUID as ConveyanceGUID ');  
		$this->db->select(' tbl_tickets.Conveyance as TicketConveyance ');  
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		
		$this->db->select(' tbl_tickets.pdf_name '); 		
		$this->db->select(' tbl_tickets.Net  '); 
		$this->db->select(' tbl_tickets.TicketNumber as SuppNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y") as SuppDate ');  
		
		$this->db->select(' tbl_tipticket.TipTicketID '); 
		$this->db->select(' tbl_tipticket.TipTicketNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  
		 
		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 		  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');
		
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID ');
		
		$this->db->select(' tbl_booking_request.WaitingTime ');
		$this->db->select(' tbl_booking_request.WaitingCharge ');
		
		//$this->db->select(' tbl_booking1.Price ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		//$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_materials.MaterialName ');
		 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_tipaddress.TipName ');
		$this->db->select(' concat(tbl_tipaddress.Street1,tbl_tipaddress.Street2,tbl_tipaddress.Town,tbl_tipaddress.County,tbl_tipaddress.PostCode) as TipAddress '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		
		$this->db->select(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  as WaitTime ');  	 	  	 	      
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%H.%i ") as ArrivalTime ');  	
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%H.%i ") as DeptTime ');  
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		//$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo ','LEFT'); 		 
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		  
		$this->db->join('tbl_tickets_documents as td3', 'tbl_tickets.Conveyance = td3.FD_650A620E AND td3.DocTypeID  = "392cf403 " ','LEFT'); 
		
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 1 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	 
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
			$this->db->or_like(' tbl_tickets.Conveyance ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' tbl_booking1.Price ', trim($Price)); 
			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	
	public function SplitExcelConveyanceTickets($OpportunityID,$CompanyName,$OpportunityName,$Reservation,$TipName,$SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status,$Search,$Price,$NetWeight){
		//print_r($_POST);
		//exit;
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo));  
		$OpportunityID = trim(strtolower($OpportunityID));  
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$WaitTime = trim(strtolower($WaitTime));   
		$Status = trim(strtolower($Status));   
		$NetWeight = trim(strtolower($NetWeight));   
		$MaterialName = trim(strtolower($MaterialName));   
		$TipName = trim(strtolower($TipName));   
        $Reservation = trim(strtolower($Reservation));
		
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
		 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
        end) as Status");  
		
		
		$this->db->select(' td3.GUID as ConveyanceGUID ');  
		$this->db->select(' tbl_tickets.Conveyance as TicketConveyance ');  
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		
		$this->db->select(' tbl_tickets.pdf_name '); 		
		$this->db->select(' tbl_tickets.Net  '); 
		$this->db->select(' tbl_tickets.TicketNumber as SuppNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y") as SuppDate ');  
		
		$this->db->select(' tbl_tipticket.TipTicketID '); 
		$this->db->select(' tbl_tipticket.TipTicketNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  
		
		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	  
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID ');
		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		//$this->db->select(' tbl_booking1.Price ');	
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');	
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_tipaddress.TipName ');
		$this->db->select(' concat(tbl_tipaddress.Street1,tbl_tipaddress.Street2,tbl_tipaddress.Town,tbl_tipaddress.County,tbl_tipaddress.PostCode) as TipAddress '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		$this->db->select('  ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  as WaitTime ');  	 	  	 	      
		  	  	 	      
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo ','LEFT'); 		 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		  
		$this->db->join('tbl_tickets_documents as td3', 'tbl_tickets.Conveyance = td3.FD_650A620E AND td3.DocTypeID  = "392cf403 " ','LEFT'); 		 
		
		
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 1 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	
		$this->db->where('tbl_booking_request.OpportunityID ',$OpportunityID); 	
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
			$this->db->or_like(' tbl_tickets.Conveyance ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' tbl_booking1.Price ', trim($Price)); 
			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityID', trim($OpportunityID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		//$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
		
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	public function SplitExcelConveyanceTicketsAll($CompanyName,$OpportunityName,$Reservation,$TipName,$SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status,$Search,$Price,$NetWeight){
		//print_r($_POST);
		//exit;
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo)); 
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));   
		$WaitTime = trim(strtolower($WaitTime));   
		$NetWeight = trim(strtolower($NetWeight));   
		$MaterialName = trim(strtolower($MaterialName));   
		$TipName = trim(strtolower($TipName));   
        $Reservation = trim(strtolower($Reservation));
		
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
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
        end) as Status");  
		 
		$this->db->select(' td3.GUID as ConveyanceGUID ');  
		$this->db->select(' tbl_tickets.Conveyance as TicketConveyance ');  
		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		
		$this->db->select(' tbl_tickets.pdf_name '); 		
		$this->db->select(' tbl_tickets.Net  '); 
		$this->db->select(' tbl_tickets.TicketNumber as SuppNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y") as SuppDate ');  
		
		$this->db->select(' tbl_tipticket.TipTicketID '); 
		$this->db->select(' tbl_tipticket.TipTicketNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  
		 
		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 		  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');
		
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID ');
		
		//$this->db->select(' tbl_booking1.Price ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_materials.MaterialName ');
		 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_tipaddress.TipName ');
		$this->db->select(' concat(tbl_tipaddress.Street1,tbl_tipaddress.Street2,tbl_tipaddress.Town,tbl_tipaddress.County,tbl_tipaddress.PostCode) as TipAddress '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		
		$this->db->select(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  as WaitTime ');  	 	  	 	      
		 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		//$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo ','LEFT'); 		 
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		  
		$this->db->join('tbl_tickets_documents as td3', 'tbl_tickets.Conveyance = td3.FD_650A620E AND td3.DocTypeID  = "392cf403 " ','LEFT'); 
		
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 1 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	 
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
			$this->db->or_like(' tbl_tickets.Conveyance ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' tbl_booking1.Price ', trim($Price)); 
			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	public function SplitExcelOppoGroup($CompanyName,$OpportunityName,$Reservation,$TipName,$SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status){
		//print_r($_POST);
		//exit;
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($ConveyanceNo));  
		//$Price = trim(strtolower($_POST['Price']));  
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));   
		$WaitTime = trim(strtolower($WaitTime));   
		$MaterialName = trim(strtolower($MaterialName));   
		$TipName = trim(strtolower($TipName));   
        $Reservation = trim(strtolower($Reservation));
		
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
		$this->db->select(' tbl_booking_request.CompanyID ');   
		$this->db->select(' tbl_booking_request.OpportunityID ');	 
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName ');   	 
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		    
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		//$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo ','LEFT');  
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT');  
		
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 1 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	
				 
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
			$this->db->or_like(' tbl_tickets.Conveyance ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		/*if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }*/
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_request.OpportunityID ");   
		$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		//$result = $query->result_array();  
		$result = $query->result(); 		  
        return $result; 
    }
	
	public function SplitExcelDelOppoGroup($CompanyName,$OpportunityName,$Reservation1 ,$SiteOutDateTime,$TicketNumber,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime ,$Status ,$Price ,$Search ,$PurchaseOrderNo ){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; } 
			if($Sort[0]=='WaitTime'){ $columnName = ' WaitTime '; } 
			//if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking.BookingType '; } 
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($Search)); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($ConveyanceNo));  
		$WaitTime = trim(strtolower($WaitTime));  
		$TicketNumber = trim(strtolower($TicketNumber));  
		
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));   
		$MaterialName = trim(strtolower($MaterialName));   
        $Reservation1 = trim(strtolower($Reservation1));
		$Price = trim(strtolower($Price));
		$PurchaseOrderNo = trim(strtolower($PurchaseOrderNo));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation1!=""){
			$RS = explode('-',$Reservation1);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		
		$this->db->select(' tbl_booking_request.CompanyID ');   
		$this->db->select(' tbl_booking_request.OpportunityID ');	 
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName ');  	 	  	 	      
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		  
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 		
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 2 '); 
		$this->db->where('tbl_drivers.AppUser = 0 '); 	
				 
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						//$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.TicketNumber ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_request.OpportunityID ");   
		$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result(); 		  
        return $result;  

        }
		
		public function SplitExcelDelTickets($OpportunityID,$CompanyName,$OpportunityName,$Reservation1 ,$SiteOutDateTime,$TicketNumber,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status,$Price ,$Search ,$PurchaseOrderNo){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; } 
			if($Sort[0]=='WaitTime'){ $columnName = ' WaitTime '; } 
			//if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking.BookingType '; } 
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($Search)); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($ConveyanceNo));  
		$WaitTime = trim(strtolower($WaitTime));  
		
		$TicketNumber = trim(strtolower($TicketNumber));   
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));   
		$MaterialName = trim(strtolower($MaterialName));   
        $Reservation1 = trim(strtolower($Reservation1));
		$Price = trim(strtolower($Price));
		$PurchaseOrderNo = trim(strtolower($PurchaseOrderNo));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation1!=""){
			$RS = explode('-',$Reservation1);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Cancelled Invoice'
        end) as Status");  
		$this->db->select(' tbl_tickets.TicketNumber ');      
		$this->db->select(' tbl_tickets.Net ');  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 	
		$this->db->select(' tbl_booking_loads1.TipID ');  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 			
		
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_booking_request.CompanyID');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');
		$this->db->select(' tbl_tickets_documents.ID  as DOCID '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		//$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  	 	  	 	      
		
		$this->db->select('ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  AS WaitTime');   
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		  
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 		
		$this->db->join('tbl_tickets_documents', 'tbl_tickets.TicketNumber = tbl_tickets_documents.FD_16EB2AD9 AND tbl_tickets_documents.DocTypeID = "1036437d" ','LEFT'); 		 
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 2 '); 
		$this->db->where('tbl_drivers.AppUser = 0 '); 	
		$this->db->where('tbl_booking_request.OpportunityID ',$OpportunityID); 	
				 
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						//$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.TicketNumber ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		//$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	 
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 

        }
		
	public function WaitTimeSplitExcelDelTickets($OpportunityID,$CompanyName,$OpportunityName,$Reservation1 ,$SiteOutDateTime,$TicketNumber,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status,$Price ,$Search ,$PurchaseOrderNo){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; } 
			if($Sort[0]=='WaitTime'){ $columnName = ' WaitTime '; } 
			//if($Sort[0]=='BookingType'){ $columnName = 'tbl_booking.BookingType '; } 
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($Search)); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($ConveyanceNo));  
		$WaitTime = trim(strtolower($WaitTime));  
		
		$TicketNumber = trim(strtolower($TicketNumber));   
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));   
		$MaterialName = trim(strtolower($MaterialName));   
        $Reservation1 = trim(strtolower($Reservation1));
		$Price = trim(strtolower($Price));
		$PurchaseOrderNo = trim(strtolower($PurchaseOrderNo));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation1!=""){
			$RS = explode('-',$Reservation1);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status"); 
		$this->db->select(' tbl_tickets.TicketNumber ');      
		$this->db->select(' tbl_tickets.Net ');  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 	
		$this->db->select(' tbl_booking_loads1.TipID ');  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 			
		
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_booking_request.CompanyID');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus '); 
		
		$this->db->select(' tbl_booking_request.WaitingTime ');
		$this->db->select(' tbl_booking_request.WaitingCharge ');
		
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->select(' tbl_booking1.Price '); 
		$this->db->select(' tbl_tickets_documents.ID  as DOCID '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		//$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  	 	  	 	      
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%H.%i ") as ArrivalTime ');  	
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%H.%i ") as DeptTime ');  	 	
		
		
		$this->db->select('ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  AS WaitTime');   
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		  
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 		
		$this->db->join('tbl_tickets_documents', 'tbl_tickets.TicketNumber = tbl_tickets_documents.FD_16EB2AD9 AND tbl_tickets_documents.DocTypeID = "1036437d" ','LEFT'); 		 
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 2 '); 
		$this->db->where('tbl_drivers.AppUser = 0 '); 	
		$this->db->where('tbl_booking_request.OpportunityID ',$OpportunityID); 	
				 
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						//$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start();  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.TicketNumber ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		//$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	 
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 

        }

		
		
	public function SplitExcelDeliveryTicketsAll($CompanyName,$OpportunityName,$reservation1,$SiteOutDateTime,$TicketNumber,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status,$Search,$Price,$NetWeight,$PurchaseOrderNo){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; }  
			if($Sort[0]=='WaitTime'){ $columnName = 'WaitTime '; }  
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='PurchaseOrderNo'){ $columnName = 'tbl_booking1.PurchaseOrderNo '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($Search)); 
		
		$WaitTime = trim(strtolower($WaitTime));   
		$TicketNumber = trim(strtolower($TicketNumber));   
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));   
		$MaterialName = trim(strtolower($MaterialName));   
        $Reservation1 = trim(strtolower($reservation1));
		$Price = trim(strtolower($Price));
		$NetWeight = trim(strtolower($NetWeight));
		$PurchaseOrderNo = trim(strtolower($PurchaseOrderNo));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation1!=""){
			$RS = explode('-',$Reservation1);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
        end) as Status");
		$this->db->select(' tbl_tickets.TicketNumber ');      
		$this->db->select(' tbl_tickets.Net ');  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 	
		$this->db->select(' tbl_booking_loads1.TipID ');  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 			
		
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_booking_request.CompanyID');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');

		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID ');
		
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->select(' tbl_booking1.Price '); 
		$this->db->select(' tbl_tickets_documents.ID  as DOCID '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		$this->db->select(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) as WaitTime ');  	 	  	 	       
		
		//$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  	 	  	 	      
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		  
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 		
		$this->db->join('tbl_tickets_documents', 'tbl_tickets.TicketNumber = tbl_tickets_documents.FD_16EB2AD9 AND tbl_tickets_documents.DocTypeID = "1036437d" ','LEFT'); 		 
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 2 '); 
		$this->db->where('tbl_drivers.AppUser = 0 '); 	  
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						//$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60) ,1) ', trim($WaitTime));  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.TicketNumber ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		//$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	
		
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 

    }	
	
	public function WaitTimeSplitExcelDeliveryTicketsAll($CompanyName,$OpportunityName,$reservation1,$SiteOutDateTime,$TicketNumber,$MaterialName,$DriverName,$VehicleRegNo,$WaitTime,$Status,$Search,$Price, $PurchaseOrderNo){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort);
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; }  
			if($Sort[0]=='WaitTime'){ $columnName = 'WaitTime '; }  
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='PurchaseOrderNo'){ $columnName = 'tbl_booking1.PurchaseOrderNo '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($Search)); 
		
		$WaitTime = trim(strtolower($WaitTime));   
		$TicketNumber = trim(strtolower($TicketNumber));   
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));   
		$MaterialName = trim(strtolower($MaterialName));   
        $Reservation1 = trim(strtolower($reservation1));
		$Price = trim(strtolower($Price)); 
		$PurchaseOrderNo = trim(strtolower($PurchaseOrderNo));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation1!=""){
			$RS = explode('-',$Reservation1);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status"); 
		$this->db->select(' tbl_tickets.TicketNumber ');      
		$this->db->select(' tbl_tickets.Net ');  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 	
		$this->db->select(' tbl_booking_loads1.TipID ');  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 			
		
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_booking_request.CompanyID');  	 		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');

		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->select(' tbl_booking1.Price '); 
		$this->db->select(' tbl_tickets_documents.ID  as DOCID '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		$this->db->select(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) as WaitTime ');  	 	  	 	       
		
		$this->db->select(' tbl_booking_request.WaitingTime ');
		$this->db->select(' tbl_booking_request.WaitingCharge ');
		 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%H.%i ") as ArrivalTime ');  	
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%H.%i ") as DeptTime ');  	 	
		 
		//$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  	 	  	 	      
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		  
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 		
		$this->db->join('tbl_tickets_documents', 'tbl_tickets.TicketNumber = tbl_tickets_documents.FD_16EB2AD9 AND tbl_tickets_documents.DocTypeID = "1036437d" ','LEFT'); 		 
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 2 '); 
		$this->db->where('tbl_drivers.AppUser = 0 '); 	  
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						//$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.TicketNumber', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60) ,1) ', trim($WaitTime));  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.TicketNumber ', trim($TicketNumber)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking1.Price ', trim($Price)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($PurchaseOrderNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking1.PurchaseOrderNo ', trim($PurchaseOrderNo)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			} 
			if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		//$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	
		
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 

    }	
	
		
	function BookingComments($BookingRequestID){
        $this->db->select(' DATE_FORMAT(tbl_booking_preinvoice_comments.CreateDateTime,"%d/%m/%Y %T") as CommentDate ');       
		$this->db->select('tbl_booking_preinvoice_comments.Comment ' );
		$this->db->select('tbl_users.userId , tbl_users.name as CreatedByName , tbl_users.email as CreatedByEmail , tbl_users.mobile as CreatedByMobile '); 
        $this->db->from('tbl_booking_preinvoice_comments');    
		$this->db->join('tbl_users', 'tbl_booking_preinvoice_comments.CommentBy = tbl_users.userId ','LEFT'); 
		$this->db->where('tbl_booking_preinvoice_comments.BookingRequestID', $BookingRequestID);
		$this->db->where('tbl_booking_preinvoice_comments.InvoiceID','0');     
		$this->db->group_by('tbl_booking_preinvoice_comments.TableID');             
		$this->db->order_by('tbl_booking_preinvoice_comments.CreateDateTime ', 'DESC');	 
        $query = $this->db->get(); 
		//echo $this->db->last_query();       
		//exit;
        //$result = $query->result_array();   
		$result = $query->result(); 		  
        return $result;
    }

	function BookingCommentsInvoice($InvoiceID){
        $this->db->select(' DATE_FORMAT(tbl_booking_preinvoice_comments.CreateDateTime,"%d/%m/%Y %T") as CommentDate ');       
		$this->db->select('tbl_booking_preinvoice_comments.Comment ' );
		$this->db->select('tbl_users.userId , tbl_users.name as CreatedByName , tbl_users.email as CreatedByEmail , tbl_users.mobile as CreatedByMobile '); 
        $this->db->from('tbl_booking_preinvoice_comments');    
		$this->db->join('tbl_users', 'tbl_booking_preinvoice_comments.CommentBy = tbl_users.userId ','LEFT');  
		$this->db->where('tbl_booking_preinvoice_comments.InvoiceID',$InvoiceID);     
		$this->db->group_by('tbl_booking_preinvoice_comments.TableID');             
		$this->db->order_by('tbl_booking_preinvoice_comments.CreateDateTime ', 'DESC');	 
        $query = $this->db->get(); 
		//echo $this->db->last_query();       
		//exit;
        //$result = $query->result_array();   
		$result = $query->result(); 		  
        return $result;
    }

	function ShowBookingPriceLogs($BookingID)
    {
        $this->db->select(' DATE_FORMAT(tbl_booking_priceby_logs.CreateDateTime,"%d/%m/%Y %T") as LogDateTime ');        
		$this->db->select('tbl_users.userId , tbl_users.name as CreatedByName , tbl_users.email as CreatedByEmail , tbl_users.mobile as CreatedByMobile '); 
        $this->db->from('tbl_booking_priceby_logs');
		$this->db->join('tbl_users', 'tbl_booking_priceby_logs.UpdatedBy = tbl_users.userId ','LEFT');  
        $this->db->where('tbl_booking_priceby_logs.BookingID', $BookingID);
        $query = $this->db->get(); 
       //echo $this->db->last_query();       
	   //exit;
        //$result = $query->row_array();  
		$result = $query->result(); 		  
        return $result;
    }

	public function GetNonAppConveyanceTickets(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort); 
			if($Sort[0]=='BookingRequestID'){ $columnName = 'tbl_booking_request.BookingRequestID '; }   
			if($Sort[0]=='NonAppConveyanceNo'){ $columnName = 'tbl_booking_loads1.NonAppConveyanceNo '; }   
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='TipName'){ $columnName = 'tbl_tipaddress.TipName '; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='GrossWeight'){ $columnName = ' tbl_booking_loads1.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_booking_loads1.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_booking_loads1.Net '; }  
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingRequestID = trim(strtolower($_POST['BookingRequestID']));  
		$NonAppConveyanceNo = trim(strtolower($_POST['NonAppConveyanceNo']));   
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
		$TipName = trim(strtolower($_POST['TipName']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));      
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));      
		$Tare = trim(strtolower($_POST['Tare']));      
		$Net = trim(strtolower($_POST['Net']));      
		
		 
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache();       
		  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.NonAppConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');      
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		  		
		$this->db->select(' tbl_booking_loads1.GrossWeight ');  	 		 
		$this->db->select(' tbl_booking_loads1.Net ');  	 		
		
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		  
		$this->db->select(' tbl_booking_request.OpportunityID ');		 
		$this->db->select(' tbl_booking_request.BookingRequestID ');
		$this->db->select(' tbl_booking_request.CompanyName '); 
		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.Tare ');  	 				
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->select(' tbl_tipaddress.TipName ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y") as JobStartDateTime ');  	 	  	 	       
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y  %T") as ConveyanceDate '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y  %T") as SiteOutDateTime '); 
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		     
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		  
		$this->db->where('tbl_booking_loads1.Status < 4 '); 
		$this->db->where('tbl_booking_loads1.Status > 0 ');  
		$this->db->where('tbl_booking1.BookingType  = 1 ');  
		$this->db->where('tbl_drivers.AppUser = 1 '); 
		
		
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.NonAppConveyanceNo', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.GrossWeight', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.Tare', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.Net', $s[$i]);  
					$this->db->group_end(); 
				}
			}    
        } 
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingRequestID)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_request.BookingRequestID ', trim($BookingRequestID));  
 			$this->db->group_end();  
        }
		if( !empty(trim($NonAppConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.NonAppConveyanceNo ', trim($NonAppConveyanceNo));  
 			$this->db->group_end();  
        }	
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }

		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.Net', trim($Net)); 
 			$this->db->group_end();  
        }	
		 
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
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
		
		public function GetNonAppDeliveryTickets(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort); 
			if($Sort[0]=='BookingRequestID'){ $columnName = 'tbl_booking_request.BookingRequestID '; }   
			if($Sort[0]=='TicketNumber'){ $columnName = 'tbl_tickets.TicketNumber '; }   
			if($Sort[0]=='NonAppConveyanceNo'){ $columnName = 'tbl_booking_loads1.NonAppConveyanceNo '; }   
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='TipName'){ $columnName = 'tbl_tipaddress.TipName '; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='GrossWeight'){ $columnName = ' tbl_booking_loads1.GrossWeight '; } 
			if($Sort[0]=='Tare'){ $columnName = ' tbl_booking_loads1.Tare '; } 
			if($Sort[0]=='Net'){ $columnName = ' tbl_booking_loads1.Net '; }  
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingRequestID = trim(strtolower($_POST['BookingRequestID']));  
		$TicketNumber = trim(strtolower($_POST['TicketNumber']));  
		$NonAppConveyanceNo = trim(strtolower($_POST['NonAppConveyanceNo']));   
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
		$TipName = trim(strtolower($_POST['TipName']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));      
		$GrossWeight = trim(strtolower($_POST['GrossWeight']));      
		$Tare = trim(strtolower($_POST['Tare']));      
		$Net = trim(strtolower($_POST['Net']));      
		
		 
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache();       
		  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.NonAppConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');      
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		  		
		$this->db->select(' tbl_booking_loads1.GrossWeight ');  	 		 
		$this->db->select(' tbl_booking_loads1.Net ');  	 		
		
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		  
		$this->db->select(' tbl_booking_request.OpportunityID ');		 
		$this->db->select(' tbl_booking_request.BookingRequestID ');
		$this->db->select(' tbl_booking_request.CompanyName '); 
		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.Tare ');  	 				
		$this->db->select(' tbl_materials.MaterialName '); 
		$this->db->select(' tbl_tipaddress.TipName ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y") as JobStartDateTime ');  	 	  	 	       
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y  %T") as ConveyanceDate '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y  %T") as SiteOutDateTime '); 
		
		$this->db->select(' tbl_tickets.TicketNumber '); 
		$this->db->select(' tbl_tickets.GrossWeight as GrossWeight1 '); 
		$this->db->select(' tbl_tickets.Tare as Tare1 '); 
		$this->db->select(' tbl_tickets.Net as Net1 '); 
		
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		     
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo ','LEFT'); 		 
		
		$this->db->where('tbl_booking_loads1.Status < 4 '); 
		$this->db->where('tbl_booking_loads1.Status > 0 ');  
		$this->db->where('tbl_booking1.BookingType  = 2 ');  
		$this->db->where('tbl_drivers.AppUser = 1 '); 
		
		
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.NonAppConveyanceNo', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.GrossWeight', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.Tare', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.Net', $s[$i]);  
					$this->db->group_end(); 
				}
			}    
        } 
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TicketNumber)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_tickets.TicketNumber ', trim($TicketNumber));  
 			$this->db->group_end();  
        }
		if( !empty(trim($BookingRequestID)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_request.BookingRequestID ', trim($BookingRequestID));  
 			$this->db->group_end();  
        }
		if( !empty(trim($NonAppConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.NonAppConveyanceNo ', trim($NonAppConveyanceNo));  
 			$this->db->group_end();  
        }	
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }

		if( !empty(trim($GrossWeight)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.GrossWeight', trim($GrossWeight)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Tare)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.Tare', trim($Tare)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($Net)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.Net', trim($Net)); 
 			$this->db->group_end();  
        }	
		 
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
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
		
		public function GetDayWorkTickets(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			
			//print_r($Sort);
			//exit;
			  
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_tickets.Conveyance '; }  
			 
			///if($Sort[0]=='JobStartDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }  
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; }  
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_booking_loads1.DriverName '; } 
			//if($Sort[0]=='Price'){ $columnName = ' tbl_booking1.Price '; } 
			if($Sort[0]=='Price'){ $columnName = ' tbl_booking_loads1.LoadPrice '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($_POST['ConveyanceNo']));  
		 
		$Price = trim(strtolower($_POST['Price']));  
		
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));  
		//$JobStartDateTime = trim(strtolower($_POST['JobStartDateTime']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$Status = trim(strtolower($_POST['Status']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
		   
        $Reservation = trim(strtolower($_POST['Reservation']));
		
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
		 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status"); 
		  
		 
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		 
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		  		
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');   		  		
		  
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	  	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		
		$this->db->select(' tbl_booking_date1.BookingDateID ');
		$this->db->select(' tbl_booking_date1.BookingRequestID ');
		 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	       
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as RequestDate ');  	 	  	 	      
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStart ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteIn ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEnd ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOut ');    
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ','LEFT');  
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 	  
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');    
		
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 3 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]);  
						//$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]); 
						
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						//$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.LoadPrice', $s[$i]); 
						//$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } 
		 
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start();
						
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) >=', $StartDate);
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) <=', $EndDate);  
			
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		/*if( !empty(trim($JobStartDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y") ', trim($JobStartDateTime)); 
 			$this->db->group_end();  
        }*/
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
			$this->db->like('tbl_booking_loads1.DriverName', trim($DriverName)); 
 			//$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
			//$this->db->or_like('tbl_drivers_login.DriverName', trim($DriverName));  
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
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
		
		
		public function SplitExcelDayWorkTicketsAll1($CompanyName,$OpportunityName,$Reservation,$SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$Status,$Search,$Price){
		//print_r($_POST);
		//exit;
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo)); 
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));      
		$MaterialName = trim(strtolower($MaterialName));    
        $Reservation = trim(strtolower($Reservation));
		
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
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
        end) as Status"); 
		   
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		  
		$this->db->select(' tbl_booking_loads1.LoadID ');    
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  		  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');
		
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber '); 
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_materials.MaterialName ');
		 
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	  	 	      
		 
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT');  		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		 	  
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 3 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	 
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		 
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	
	public function SplitExcelOppoGroupDayWork($CompanyName,$OpportunityName,$Reservation,$SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$Status){
		//print_r($_POST);
		//exit;
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($ConveyanceNo)); 
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));    
		$MaterialName = trim(strtolower($MaterialName));    
        $Reservation = trim(strtolower($Reservation));
		
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
		$this->db->select(' tbl_booking_request.CompanyID ');   
		$this->db->select(' tbl_booking_request.OpportunityID ');	 
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName ');   	 
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		    
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		 	 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		 
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 3 ');  
				 
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		 
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		 
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        } 
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_request.OpportunityID ");   
		$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		//$result = $query->result_array();  
		$result = $query->result(); 		  
        return $result; 
    }
	
	public function SplitExcelDayWorkTickets($OpportunityID,$CompanyName,$OpportunityName,$Reservation, $SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo, $Status,$Search,$Price ){
		 
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo));  
		$OpportunityID = trim(strtolower($OpportunityID));  
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));     
		$MaterialName = trim(strtolower($MaterialName));  
        $Reservation = trim(strtolower($Reservation));
		
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
		 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
        end) as Status");  
		 
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		   
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	  
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		
		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');		 
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber '); 
		$this->db->select(' tbl_booking1.PurchaseOrderNo');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		$this->db->select('  ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  as WaitTime ');  	 	  	 	      
		  	  	 	      
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT');  		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		  
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 3 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	
		$this->db->where('tbl_booking_request.OpportunityID ',$OpportunityID); 	
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		 
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityID', trim($OpportunityID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
		
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	public function SplitExcelDayWorkTicketsAll($CompanyName,$OpportunityName,$Reservation,$SiteOutDateTime,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$Status,$Search,$Price){
		//print_r($_POST);
		//exit;
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo)); 
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime = trim(strtolower($SiteOutDateTime));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));     
		$MaterialName = trim(strtolower($MaterialName));    
        $Reservation = trim(strtolower($Reservation));
		
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
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status"); 
		  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		  
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 		  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID ');
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID ');
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber '); 
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_materials.MaterialName ');
		 
		$this->db->select(' tbl_booking_request.OpportunityName ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		  
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		  
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');  
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 3 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	 
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		 
		
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		  
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime ', 'ASC');	
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	
	
	public function GetHaulageTickets(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			
			//print_r($Sort);
			//exit;
			  
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_tickets.Conveyance '; }  
			 
			///if($Sort[0]=='JobStartDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='SiteOutDateTime2'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%Y%m%d%H%i%S") ';  }  
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; }  
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_booking_loads1.DriverName '; } 
			if($Sort[0]=='Price'){ $columnName = ' tbl_booking_loads1.LoadPrice '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($_POST['ConveyanceNo']));  
		 
		$Price = trim(strtolower($_POST['Price']));  
		
		$SiteOutDateTime2 = trim(strtolower($_POST['SiteOutDateTime2']));  
		//$JobStartDateTime = trim(strtolower($_POST['JobStartDateTime']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$Status = trim(strtolower($_POST['Status']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
		   
        $Reservation = trim(strtolower($_POST['Reservation']));
		
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
		 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status"); 
		  
		 
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		 
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		  		
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');   		  		
		  
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');  	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		
		$this->db->select(' tbl_booking_date1.BookingDateID ');
		$this->db->select(' tbl_booking_date1.BookingRequestID ');
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	       
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y") as SiteOutDateTime2 ');  	 	  	 	       
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as RequestDate ');  	 	  	 	      
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y") as JobStartDateTime ');  
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStart ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteIn ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEnd ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOut ');    
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime2,"%d/%m/%Y %T") as HaulageIn ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d/%m/%Y %T") as HaulageOut ');    
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ','LEFT');  
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 	  
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');    
		
		//$this->db->where('tbl_booking_loads1.Status > 3 ');  
		$this->db->where('tbl_booking1.BookingType  = 4 '); 
		$this->db->group_start(); 
		$this->db->where('tbl_booking_loads1.Status = 4 ');
		$this->db->or_where(' tbl_booking_loads1.Status = 5  ');
		$this->db->or_where(' tbl_booking_loads1.Status = 6  ');
		$this->db->group_end(); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]);  
						//$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y")  ', $s[$i]); 
						
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						//$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.LoadPrice', $s[$i]); 
						//$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } 
		 
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start();
						
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) >=', $StartDate);
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) <=', $EndDate);  
			
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime2) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime2) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime2)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y %T") ', trim($SiteOutDateTime2)); 
 			$this->db->group_end();  
        }
		/*if( !empty(trim($JobStartDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y") ', trim($JobStartDateTime)); 
 			$this->db->group_end();  
        }*/
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
			$this->db->like('tbl_booking_loads1.DriverName', trim($DriverName)); 
 			//$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
			//$this->db->or_like('tbl_drivers_login.DriverName', trim($DriverName));  
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}
			else if(strtolower($Status[0])=='i' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '8'); 
				$this->db->group_end();  
			}
			else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
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
		
		public function SplitExcelHaulageTicketsAll($CompanyName,$OpportunityName,$Reservation,$SiteOutDateTime2,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$Status,$Search,$Price){
		//print_r($_POST);
		//exit;
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo)); 
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime2 = trim(strtolower($SiteOutDateTime2));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));     
		$MaterialName = trim(strtolower($MaterialName));    
        $Reservation = trim(strtolower($Reservation));
		
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
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
        end) as Status");  
		  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		  
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		//$this->db->select(' tbl_booking_loads1.Status ');  	 		  		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');
		
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID ');
		
		$this->db->select(' tbl_booking_loads1.LoadPrice ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber '); 
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		$this->db->select(' tbl_materials.MaterialName '); 
		
		$this->db->select(' tbl_booking_request.OpportunityName ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	      
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y") as SiteOutDateTime2 ');  	 	  	 	      
		  
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		  
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');  
		//$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking1.BookingType  = 4 '); 
		$this->db->group_start(); 
		$this->db->where('tbl_booking_loads1.Status = 4 ');
		$this->db->or_where(' tbl_booking_loads1.Status = 5  ');
		$this->db->or_where(' tbl_booking_loads1.Status = 6  ');
		$this->db->group_end(); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	 
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		 
		
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime2) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime2) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime2)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y") ', trim($SiteOutDateTime2)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		  
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime2 ', 'ASC');	
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	public function SplitExcelOppoGroupHaulage($CompanyName,$OpportunityName,$Reservation,$SiteOutDateTime2,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo,$Status){
		//print_r($_POST);
		//exit;
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($ConveyanceNo)); 
		$SiteOutDateTime2 = trim(strtolower($SiteOutDateTime2));  
		
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));    
		$MaterialName = trim(strtolower($MaterialName));    
        $Reservation = trim(strtolower($Reservation));
		
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
		$this->db->select(' tbl_booking_request.CompanyID ');   
		$this->db->select(' tbl_booking_request.OpportunityID ');	 
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName ');   	 
		
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		    
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT'); 		 
		 	 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		 
		$this->db->where('tbl_booking1.BookingType  = 4 '); 
		$this->db->group_start(); 
		$this->db->where('tbl_booking_loads1.Status = 4 ');
		$this->db->or_where(' tbl_booking_loads1.Status = 5  ');
		$this->db->or_where(' tbl_booking_loads1.Status = 6  ');
		$this->db->group_end(); 
				 
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		 
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		 
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime2) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime2) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime2)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y") ', trim($SiteOutDateTime2)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        } 
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_request.OpportunityID ");   
		$this->db->order_by('tbl_booking_request.CompanyName ', 'ASC');	
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		//$result = $query->result_array();  
		$result = $query->result(); 		  
        return $result; 
    }
	public function SplitExcelHaulageTickets($OpportunityID,$CompanyName,$OpportunityName,$Reservation, $SiteOutDateTime2,$ConveyanceNo,$MaterialName,$DriverName,$VehicleRegNo, $Status,$Search,$Price ){
		 
		  
		//$searchValue = trim(strtolower($_POST['search'])); // Search value   
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo));  
		$OpportunityID = trim(strtolower($OpportunityID));  
		$Price = trim(strtolower($Price));  
		$SiteOutDateTime2 = trim(strtolower($SiteOutDateTime2));  
		$CompanyName = trim(strtolower($CompanyName));  
		$OpportunityName = trim(strtolower($OpportunityName));   
		$VehicleRegNo = trim(strtolower($VehicleRegNo));    
		$DriverName = trim(strtolower($DriverName));   
		$Status = trim(strtolower($Status));     
		$MaterialName = trim(strtolower($MaterialName));  
        $Reservation = trim(strtolower($Reservation));
		
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
		 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
        end) as Status");
		 
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		   
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	  
		$this->db->select(' tbl_booking1.TonBook ');	
		$this->db->select(' tbl_booking1.LorryType ');	
		$this->db->select(' tbl_materials.Status as MStatus ');
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID ');
		
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice ');		 
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');
		
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y") as SiteOutDateTime2 ');  
		$this->db->select('  ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  as WaitTime ');  	 	  	 	      
		  	  	 	      
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 	 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
		$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ','LEFT');  		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT'); 
		  
		$this->db->where('tbl_booking1.BookingType  = 4 '); 
		$this->db->group_start(); 
		$this->db->where('tbl_booking_loads1.Status = 4 ');
		$this->db->or_where(' tbl_booking_loads1.Status = 5  ');
		$this->db->or_where(' tbl_booking_loads1.Status = 6  ');
		$this->db->group_end(); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	
		$this->db->where('tbl_booking_request.OpportunityID ',$OpportunityID); 	
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		 
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start(); 
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime2) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime2) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime2)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y") ', trim($SiteOutDateTime2)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityID', trim($OpportunityID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by('tbl_booking_request.CompanyID ', 'ASC');	
		$this->db->order_by('tbl_booking_request.OpportunityID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.MaterialID ', 'ASC');	
		$this->db->order_by('tbl_booking_loads1.SiteOutDateTime2 ', 'ASC');	
		
        //$this->db->limit($_REQUEST['length'], $_REQUEST['start']);
	     
		$query = $this->db->get('tbl_booking_loads1');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }
	
	function GetMaterialPrice($LoadID){ 
        $this->db->select('tbl_product.UnitPrice');  	 		 
		$this->db->select('tbl_product.PurchaseOrderNo');  
		$this->db->select('DATE_FORMAT(tbl_product.DateRequired,"%d/%m/%Y") as PriceDate');  
		$this->db->where('tbl_product.OpportunityID',$OpportunityID);  
		$this->db->where('tbl_product.MaterialID',$MaterialID); 
		$this->db->where('tbl_product.LorryType',$LorryType); 
		$this->db->where('tbl_product.PriceType','0');  		
		$this->db->where('DATE_FORMAT(tbl_product.DateRequired,"%Y-%m-%d") <= "'.trim($DateRequired).'" ');  
		$this->db->order_by('tbl_product.DateRequired', 'desc');
		$this->db->limit(1);
		$query = $this->db->get('tbl_product');
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	public function GetLogs(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			
			//print_r($Sort);
			//exit;
			//if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; }  
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_tickets.Conveyance '; }  
			if($Sort[0]=='WaitTime'){ $columnName = ' WaitTime '; }  
			///if($Sort[0]=='JobStartDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y%m%d%H%i%S") ';  }   
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }   
			
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='TipName'){ $columnName = 'tbl_tipaddress.TipName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }  
			//if($Sort[0]=='DriverName'){ $columnName = ' tbl_drivers.DriverName '; } 
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_booking_loads1.DriverName '; } 
			//if($Sort[0]=='Price'){ $columnName = ' tbl_booking1.Price '; } 
			if($Sort[0]=='Price'){ $columnName = ' tbl_booking_loads1.LoadPrice '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($_POST['ConveyanceNo']));  
		$WaitTime = trim(strtolower($_POST['WaitTime']));  
		$Price = trim(strtolower($_POST['Price']));  
		
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));  
		//$JobStartDateTime = trim(strtolower($_POST['JobStartDateTime']));  
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$Status = trim(strtolower($_POST['Status']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
		$TipName = trim(strtolower($_POST['TipName']));   
        $Reservation = trim(strtolower($_POST['Reservation']));
		
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
		$this->db->select(' tbl_site_logs.*');  
		  		 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]); 
						//$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]); 
						
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						//$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						//$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.LoadPrice', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } 
	  
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		   
		$query = $this->db->get('tbl_site_logs');
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
	
}

  