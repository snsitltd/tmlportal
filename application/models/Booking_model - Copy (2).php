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
	
	public function BookingData($BookingID){
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y  %T") as BookingDateTime1 ');  	 	 
		$this->db->select('tbl_booking.*' );   
		$this->db->from('tbl_booking');    
		$this->db->where('tbl_booking.BookingID',$BookingID); 		 
		$query = $this->db->get();
		return $query->row_array();
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
       $this->db->select('LorryNo,DriverName,RegNumber,Haulier,Tare,MobileNo,Email');
       $this->db->from('drivers');
       $this->db->where('DriverName <> ""');
       $this->db->where('RegNumber <> ""'); 
	   $this->db->where('MobileNo <> ""'); 
	   $this->db->where('Password <> ""'); 
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
        $this->db->select(' DATE_FORMAT(tbl_booking_loads.CreateDateTime,"%d/%m/%Y %T") as CreateDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.JobStartDateTime,"%d/%m/%Y %T") as JobStartDateTime ');  
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking_loads.DriverName, tbl_booking_loads.VehicleRegNo, tbl_booking_loads.Status, tbl_booking_loads.ConveyanceNo');
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
		$this->db->select('tbl_booking_loads.ReceiptName ');    
		$this->db->select('tbl_users.name as CreatedByName , tbl_users.email as CreatedByEmail , tbl_users.mobile as CreatedByMobile ');
		$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialName');
		$this->db->select('tbl_booking.Price, tbl_booking.PurchaseOrderNumber, tbl_booking.Email, tbl_booking.Notes, tbl_booking.ContactName, tbl_booking.ContactMobile'); 
		$this->db->select('tbl_company.CompanyName, tbl_booking.CompanyID as ComID, tbl_opportunities.OpportunityName , tbl_booking.OpportunityID as OppID  ');
		$this->db->select('tbl_booking_loads.DriverName,tbl_booking_loads.DriverID, tbl_booking_loads.VehicleRegNo, tbl_booking_loads.Status, 
		tbl_booking_loads.ConveyanceNo, tbl_booking_loads.TicketID, tbl_booking_loads.TicketUniqueID');
		$this->db->select('tbl_drivers.DriverName as dname, tbl_drivers.RegNumber as vrn, tbl_drivers.MobileNo as DriverMobile, tbl_drivers.Email as DriverEmail' );
        $this->db->from('tbl_booking_loads'); 
        $this->db->join('tbl_booking', 'tbl_booking.BookingID = tbl_booking_loads.BookingID'); 
        $this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID'); 
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID'); 
		$this->db->join('tbl_users', 'tbl_users.userId = tbl_booking.BookedBy'); 
		$this->db->join('tbl_tipaddress', 'tbl_tipaddress.TipID = tbl_booking_loads.TipID');  
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_booking_loads.DriverID'); 
        $this->db->join('tbl_materials', 'tbl_materials.MaterialID = tbl_booking_loads.MaterialID');  
        $this->db->where('tbl_booking_loads.LoadID', $LoadID);                     
        $query = $this->db->get(); 
      //  echo $this->db->last_query();       
	  //  exit;
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
		$this->db->select(' tbl_booking.Loads ');
		$this->db->select(' tbl_booking.Notes ');
		$this->db->select(' tbl_booking.Status ');
		$this->db->select(' tbl_booking.OpportunityID ');
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	 
		$this->db->select('(select tbl_users.name FROM tbl_users where tbl_booking.BookedBy = tbl_users.userId ) as BookedName '); 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');  	 
		//$this->db->where('tbl_booking.Status = 0 '); 
		$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID'); 
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID'); 
		
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
					$this->db->group_end();

				}
			}    
        }
		  
		$this->db->order_by($columnName, $columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
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
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		$this->db->select(' tbl_booking.Days ');  	
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
		$this->db->where('tbl_booking.Status = 1 '); 
		$this->db->where('DATE_FORMAT(tbl_booking.BookingDateTime,"%Y-%m-%d") = CURDATE()'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) > 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)'); 
		
				
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
		//$this->db->order_by('TotalLoadAllocated', 'desc');		
		$this->db->order_by($columnName, $columnSortOrder);		
		//$this->db->order_by('tbl_booking.TicketDate', 'DESC'); 
        //$this->db->order_by('tbl_booking.BookingID', 'DESC');        
		
		//$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
       // $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking');
        
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
		
        //We Need Column Index for Ordering
        /*$columns = array(
                0 =>'BookingID', 
                1 => 'BookingDateTime',
				2 => 'CompanyName',
				3 => 'OpportunityName',
				4 => 'Email'
        );*/ 
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		$this->db->select(' tbl_booking.Days ');  	
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
		$this->db->where('tbl_booking.Status = 1 '); 
		$this->db->where('DATE_FORMAT(tbl_booking.BookingDateTime,"%Y-%m-%d") < CURDATE()'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) > 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)'); 
		
				
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
		//$this->db->order_by('TotalLoadAllocated', 'desc');		
		$this->db->order_by($columnName, $columnSortOrder);		
		//$this->db->order_by('tbl_booking.TicketDate', 'DESC'); 
        //$this->db->order_by('tbl_booking.BookingID', 'DESC');        
		
		//$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
       // $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking');
        
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
	
	function FutureBookingListing()
    {
        $this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		$this->db->select(' tbl_booking.Days ');  	
		$this->db->select('CURDATE()  as ndate ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' tbl_booking.BookingDateTime as BookingDateTime1 ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T ") as BookingDateTime ');  	 	  
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated '); 
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() ) as DistinctLorry '); 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');   
		$this->db->where('tbl_booking.Status = 1 '); 
		$this->db->where('DATE(tbl_booking.BookingDateTime) > DATE(CURDATE())'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) > 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)'); 
        $this->db->from('tbl_booking'); 
        //$this->db->order_by('DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T ")', 'DESC'); 
        $query = $this->db->get();
        //echo $this->db->last_query();       
	    //exit;
        $result = $query->result();        
        return $result;
    }  
	
	
	public function GetAllocatedBookingData3(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
        //We Need Column Index for Ordering
        /*$columns = array(
                0 =>'BookingID', 
                1 => 'BookingDateTime',
				2 => 'CompanyName',
				3 => 'OpportunityName',
				4 => 'Email'
        );*/ 
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');    		
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		$this->db->select(' tbl_booking.Days ');  	
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
		$this->db->where('tbl_booking.Status = 1 '); 
		$this->db->where('DATE_FORMAT(tbl_booking.BookingDateTime,"%Y-%m-%d") > CURDATE()'); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) > 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) > 0 
		END)'); 
		
				
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
		//$this->db->order_by('TotalLoadAllocated', 'desc');		
		$this->db->order_by($columnName, $columnSortOrder);		
		//$this->db->order_by('tbl_booking.TicketDate', 'DESC'); 
        //$this->db->order_by('tbl_booking.BookingID', 'DESC');        
		
		//$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
       // $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking');
		
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
	public function GetAllocatedBookingData1(){


		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		
        //We Need Column Index for Ordering
        /*$columns = array(
                0 =>'BookingID', 
                1 => 'BookingDateTime',
				2 => 'CompanyName',
				3 => 'OpportunityName',
				4 => 'Email'
        );*/ 
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache(); 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking.MaterialID ');  	 		
		$this->db->select(' tbl_booking.BookingType');  	 		 		
		$this->db->select(' tbl_booking.LoadType ');  	 		
		$this->db->select(' tbl_booking.Loads ');  	  
		$this->db->select(' tbl_booking.Days ');  	
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T ") as BookingDateTime ');  	 	 
		//$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y  %T") as BookingDateTime ');  	 	 
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated '); 
		$this->db->select('(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()  ) as DistinctLorry '); 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select(' tbl_booking.Email ');   
		$this->db->where('tbl_booking.Status = 1 '); 
		$this->db->where('(CASE WHEN tbl_booking.LoadType=1 THEN tbl_booking.Loads-(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) = 0 ELSE 
		tbl_booking.Loads-(select COUNT(DISTINCT DriverID) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID  AND 
		DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE() ) = 0 
		END)'); 
		
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
		//$this->db->order_by('TotalLoadAllocated', 'desc');		
		$this->db->order_by($columnName, $columnSortOrder);		
		//$this->db->order_by('tbl_booking.TicketDate', 'DESC'); 
        //$this->db->order_by('tbl_booking.BookingID', 'DESC');        
		
		//$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
       // $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking');
        
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
		
        //We Need Column Index for Ordering
        /*$columns = array(
                0 =>'BookingID', 
                1 => 'BookingDateTime',
				2 => 'CompanyName',
				3 => 'OpportunityName',
				4 => 'Email'
        );*/ 
 
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
		$this->db->select(' tbl_drivers.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.CreateDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		$this->db->join('tbl_booking', 'tbl_booking.BookingID = tbl_booking_loads.BookingID'); 		
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_booking_loads.DriverID'); 		
		$this->db->where('tbl_booking_loads.Status <> 4 '); 
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
		$this->db->order_by($columnName, $columnSortOrder);			
		//$this->db->order_by('tbl_booking_loads.BookingID', 'DESC'); 
		//$this->db->order_by('tbl_booking_loads.LoadID', 'DESC'); 
        //$this->db->order_by('tbl_booking.TicketNo', 'DESC');   
		//$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
       // $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_loads');
        
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
		
        //We Need Column Index for Ordering
        /*$columns = array(
                0 =>'BookingID', 
                1 => 'BookingDateTime',
				2 => 'CompanyName',
				3 => 'OpportunityName',
				4 => 'Email'
        );*/ 
 
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
		$this->db->select(' tbl_drivers.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_booking.BookingType ');  	 		
		$this->db->select(' tbl_booking.LoadType ');  	 
		$this->db->select(' tbl_booking.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.CreateDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  	 	  
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		$this->db->join('tbl_booking', 'tbl_booking.BookingID = tbl_booking_loads.BookingID'); 		
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_booking_loads.DriverID'); 		
		$this->db->where('tbl_booking_loads.Status = 4 '); 
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
		$this->db->order_by($columnName, $columnSortOrder);			
		//$this->db->order_by('tbl_booking_loads.BookingID', 'DESC'); 
		//$this->db->order_by('tbl_booking_loads.LoadID', 'DESC'); 
        //$this->db->order_by('tbl_booking.TicketNo', 'DESC');   
		//$this->db->order_by($columns[$_REQUEST['order'][0]['column']], $_REQUEST['order'][0]['dir']);
       // $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_loads');
        
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
		 
 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();  
		$this->db->select(' tbl_booking.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads.TicketUniqueID ');  
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
		$this->db->select(' DATE_FORMAT(tbl_booking_loads.SiteOutDateTime,"%d-%m-%Y %T") as SiteOutDateTime ');  	 	  	 	  
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		$this->db->join('tbl_booking', 'tbl_booking.BookingID = tbl_booking_loads.BookingID'); 		
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_booking_loads.DriverID'); 		
		$this->db->where('tbl_booking_loads.Status = 4 '); 
        if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value']; 
                $this->db->or_like('tbl_booking.ConveyanceNo', $search_value);
				$this->db->or_like('tbl_booking.OpportunityName', $search_value);
				$this->db->or_like('tbl_booking.CompanyName', $search_value);
                $this->db->stop_cache();

                $totalFiltered  = $this->db->get('tbl_booking_loads')->num_rows();
        }
		
        $this->db->stop_cache();  
		$this->db->order_by($columnName, $columnSortOrder);	 
        $query = $this->db->get('tbl_booking_loads');
        
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
		$this->db->select(' tbl_drivers.DriverName ');  	 		 
		$this->db->select(' tbl_driver_message.Status ');  	 		
		$this->db->select(' tbl_driver_message.Message ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_driver_message.CreateDateTime,"%d-%m-%Y %T") as CreateDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_driver_message.UpdateDateTime,"%d-%m-%Y  %T") as UpdateDateTime ');  	 	   
		$this->db->join('tbl_drivers', 'tbl_drivers.LorryNo = tbl_driver_message.DriverID'); 		
		$this->db->where('tbl_driver_message.Message <> "" ');  
		if( !empty($_REQUEST['search']['value']) ){
                $search_value = $_REQUEST['search']['value']; 
                $this->db->or_like('tbl_drivers.DriverName', $search_value);
				$this->db->or_like('tbl_driver_message.Message', $search_value);
				$this->db->or_like('tbl_driver_message.CreateDateTime', $search_value);
                $this->db->stop_cache();

                $totalFiltered  = $this->db->get('tbl_driver_message')->num_rows();
        }
        $this->db->stop_cache();  
		$this->db->order_by($columnName, $columnSortOrder);			 
        $query = $this->db->get('tbl_driver_message');
		
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
 
}

  