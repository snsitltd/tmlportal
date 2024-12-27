<?php
class Common_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
 	function TodayBooking($mydate){  
		$this->db->select('tbl_booking_request.BookingRequestID '); 	   
		$this->db->select('tbl_booking_request.OpportunityName'); 	    
		$this->db->select('tbl_booking_request.OpportunityID'); 	     
		
		$this->db->select('(select SUM(TotalTon)  from tbl_booking1   
		LEFT JOIN tbl_booking_date1 as tb1 on tbl_booking1.BookingID = tb1.BookingID 
		where  tbl_booking1.BookingType = 1 and  tbl_booking1.TonBook = 1  
		AND tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID  
		AND DATE_FORMAT(tb1.BookingDate,"%Y-%m-%d") = "'.$mydate.'"  ) as TonCollection   ');			 	
		
		$this->db->select('(select SUM(TotalTon)  from tbl_booking1   
		LEFT JOIN tbl_booking_date1 as tb1 on tbl_booking1.BookingID = tb1.BookingID 
		where  tbl_booking1.BookingType = 2 and  tbl_booking1.TonBook = 1  
		AND tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID  
		AND DATE_FORMAT(tb1.BookingDate,"%Y-%m-%d") = "'.$mydate.'"  ) as TonDelivery   ');			 	
		
		$this->db->select('(select SUM(Loads)  from tbl_booking1   
		LEFT JOIN tbl_booking_date1 as tb1 on tbl_booking1.BookingID = tb1.BookingID 
		where  tbl_booking1.BookingType = 1 and  tbl_booking1.LoadType = 1  
		AND tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID  
		AND DATE_FORMAT(tb1.BookingDate,"%Y-%m-%d") = "'.$mydate.'"  ) as LoadCollection   ');			 	
		
		$this->db->select('(select SUM(Loads)  from tbl_booking1   
		LEFT JOIN tbl_booking_date1 as tb1 on tbl_booking1.BookingID = tb1.BookingID 
		where  tbl_booking1.BookingType = 2 and  tbl_booking1.LoadType = 1  
		AND tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID  
		AND DATE_FORMAT(tb1.BookingDate,"%Y-%m-%d") = "'.$mydate.'"  ) as LoadDelivery   ');			 	
		
		$this->db->select('(select SUM(Loads)  from tbl_booking1   
		LEFT JOIN tbl_booking_date1 as tb1 on tbl_booking1.BookingID = tb1.BookingID 
		where  tbl_booking1.BookingType = 1 and  tbl_booking1.LoadType = 2  
		AND tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID  
		AND DATE_FORMAT(tb1.BookingDate,"%Y-%m-%d") = "'.$mydate.'"  ) as TACollection   ');			 	
		
		$this->db->select('(select SUM(Loads)  from tbl_booking1   
		LEFT JOIN tbl_booking_date1 as tb1 on tbl_booking1.BookingID = tb1.BookingID 
		where  tbl_booking1.BookingType = 2 and  tbl_booking1.LoadType = 2  
		AND tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID  
		AND DATE_FORMAT(tb1.BookingDate,"%Y-%m-%d") = "'.$mydate.'"  ) as TADelivery   ');			 	
		
		$this->db->select('(select SUM(Loads)  from tbl_booking1   
		LEFT JOIN tbl_booking_date1 as tb1 on tbl_booking1.BookingID = tb1.BookingID 
		where  tbl_booking1.BookingType = 3  
		AND tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID  
		AND DATE_FORMAT(tb1.BookingDate,"%Y-%m-%d") = "'.$mydate.'"  ) as LoadDayWork   ');			 	
		
		$this->db->select('(select SUM(Loads)  from tbl_booking1   
		LEFT JOIN tbl_booking_date1 as tb1 on tbl_booking1.BookingID = tb1.BookingID 
		where  tbl_booking1.BookingType = 4  
		AND tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID  
		AND DATE_FORMAT(tb1.BookingDate,"%Y-%m-%d") = "'.$mydate.'"  ) as LoadHaulage   ');	
		
		$this->db->from('tbl_booking_date1');       
		$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID  = tbl_booking_request.BookingRequestID ','LEFT');    
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") ',$mydate);   
		$this->db->group_by("tbl_booking_date1.BookingRequestID ");  
		$this->db->order_by('tbl_booking_date1.BookingRequestID ','ASC');		
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit;
		return $query->result_array(); 
	}
	
	function TodayBookingDriver($mydate){  
		//$this->db->select('tbl_drivers_login.DriverName '); 	   
		$this->db->select('tbl_booking_loads1.DriverName '); 	   
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where   tbl_booking_loads1.Status = 4 and  tbl_booking1.BookingType = 1 and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalCollection   ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 4 and  tbl_booking1.BookingType = 2 and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalDelivery  ');			 	
		
		 
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 4 and  tbl_booking1.BookingType = 3 and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalDayWork  ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 4 and  tbl_booking1.BookingType = 4 and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and DATE_FORMAT(tb1.SiteOutDateTime2,"%Y-%m-%d") = "'.$mydate.'" ) as TotalHaulage  ');
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 5  and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalCancel  ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 6   and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalWasted  ');			 	
		
		$this->db->from('tbl_booking_loads1');        
		$this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID  = tbl_drivers_login.DriverID ','LEFT');    
		//$this->db->where('DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y-%m-%d") ',$mydate);    
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") ',$mydate);    
		$this->db->group_by("tbl_booking_loads1.DriverLoginID ");  
		$this->db->order_by('tbl_booking_loads1.DriverLoginID ','ASC');		
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit;
		return $query->result_array(); 
	}
	
	function TodayBookingDriver1($FirstDate,$SecondDate){  
		//$this->db->select('tbl_drivers_login.DriverName '); 	   
		$this->db->select('tbl_booking_loads1.DriverName '); 	   
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where   tbl_booking_loads1.Status = 4 and  tbl_booking1.BookingType = 1 and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and ( DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") >=  "'.$FirstDate.'" and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") <=  "'.$SecondDate.'"  )  ) as TotalCollection   ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 4 and  tbl_booking1.BookingType = 2 and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and ( DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") >=  "'.$FirstDate.'" and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") <=  "'.$SecondDate.'"  ) ) as TotalDelivery  ');			 	
		 
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 4 and  tbl_booking1.BookingType = 3 and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and ( DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") >=  "'.$FirstDate.'" and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") <=  "'.$SecondDate.'"  ) ) as TotalDayWork  ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 4 and  tbl_booking1.BookingType = 4 and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and ( DATE_FORMAT(tb1.SiteOutDateTime2,"%Y-%m-%d") >=  "'.$FirstDate.'" and DATE_FORMAT(tb1.SiteOutDateTime2,"%Y-%m-%d") <=  "'.$SecondDate.'"  ) ) as TotalHaulage  ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 5  and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and ( DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") >=  "'.$FirstDate.'" and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") <=  "'.$SecondDate.'"  ) ) as TotalCancel  ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking_loads1.Status = 6   and tb1.DriverLoginID = tbl_booking_loads1.DriverLoginID
		and ( DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") >=  "'.$FirstDate.'" and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") <=  "'.$SecondDate.'"  ) ) as TotalWasted  ');			 	
		
		$this->db->from('tbl_booking_loads1');        
		$this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID  = tbl_drivers_login.DriverID ','LEFT');    
		//$this->db->where('DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%Y-%m-%d") ',$mydate);    
		//$this->db->where('DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") ',$mydate);    
		
		$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $FirstDate);
	    $this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $SecondDate);
		
		$this->db->group_by("tbl_booking_loads1.DriverLoginID ");  
		$this->db->order_by('tbl_booking_loads1.DriverLoginID ','ASC');		
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit;
		return $query->result_array(); 
	}
	function TodayBookingOpportunity($mydate){  
		$this->db->select('tbl_booking_request.OpportunityName, tbl_booking_request.OpportunityID'); 	   
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking1.BookingType = 1 and tb1.BookingRequestID = tbl_booking_loads1.BookingRequestID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalCollection   ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking1.BookingType = 2 and tb1.BookingRequestID = tbl_booking_loads1.BookingRequestID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalDelivery  ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking1.BookingType = 3 and tb1.BookingRequestID = tbl_booking_loads1.BookingRequestID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalDayWork  ');			 	
		
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1  
		LEFT JOIN tbl_booking1 on tb1.BookingID = tbl_booking1.BookingID 
		where  tbl_booking1.BookingType = 4 and tb1.BookingRequestID = tbl_booking_loads1.BookingRequestID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as TotalHaulage  ');
		
		$this->db->from('tbl_booking_loads1');       
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID  = tbl_booking_request.BookingRequestID ','LEFT');    
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") ',$mydate);   
		$this->db->group_by("tbl_booking_loads1.BookingRequestID ");  
		$this->db->order_by('tbl_booking_loads1.BookingRequestID ','ASC');		
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit;
		return $query->result_array(); 
	}
	
	function TodayBookingMaterial($mydate){   
		$this->db->select('tbl_materials.MaterialName '); 	   
		$this->db->select('(select count(*)  from tbl_booking_loads1 tb1   
		where   tb1.MaterialID = tbl_booking_loads1.MaterialID
		and DATE_FORMAT(tb1.SiteOutDateTime,"%Y-%m-%d") = "'.$mydate.'" ) as Total   ');			 	
		 
		$this->db->from('tbl_booking_loads1'); 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID  = tbl_materials.MaterialID ','LEFT');    
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") ',$mydate);   
		$this->db->group_by("tbl_booking_loads1.MaterialID ");  
		$this->db->order_by('tbl_booking_loads1.MaterialID ','ASC');		
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit;
		return $query->result_array(); 
	}
	
	function TodayTotalJobsAllocated($mydate){  
		$this->db->select('count(*) as TotalJobsAllocated'); 	 
		$this->db->from('tbl_booking_loads1');     
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID  = tbl_booking_date1.BookingDateID ','LEFT');   
		$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") ',$mydate);   
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['TotalJobsAllocated'];  
	}
	
	function TodayTotalJobsFinished($mydate){   
		
	    $this->db->select('count(*) as TotalJobsFinished'); 	 
		$this->db->from('tbl_booking_loads1');     
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") ',$mydate);    
		$this->db->where('tbl_booking_loads1.Status','4');   
		
		
		//$this->db->select('count(*) as TotalJobsFinished'); 	 
		//$this->db->from('tbl_booking_loads1');     
		//$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID  = tbl_booking_date1.BookingDateID ','LEFT');   
		//$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") ',$mydate);    
		//$this->db->where('tbl_booking_loads1.Status','4');   
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['TotalJobsFinished'];  
	}

	function TodayTotalJobsCancelled($mydate){  
	    $this->db->select('count(*) as TotalJobsCancelled'); 	 
		$this->db->from('tbl_booking_loads1');     
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") ',$mydate);    
		$this->db->where('tbl_booking_loads1.Status','5');   
		
		//$this->db->select('count(*) as TotalJobsCancelled'); 	 
		//$this->db->from('tbl_booking_loads1');     
		//$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID  = tbl_booking_date1.BookingDateID ','LEFT');   
		//$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") ',$mydate);    
		//$this->db->where('tbl_booking_loads1.Status','5');   
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['TotalJobsCancelled'];  
	}
	
	function TodayTotalJobsWasted($mydate){  
	    $this->db->select('count(*) as TodayTotalJobsWasted'); 	 
		$this->db->from('tbl_booking_loads1');     
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") ',$mydate);    
		$this->db->where('tbl_booking_loads1.Status','6');   
		
		//$this->db->select('count(*) as TodayTotalJobsWasted'); 	 
		//$this->db->from('tbl_booking_loads1');     
		//$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID  = tbl_booking_date1.BookingDateID ','LEFT');   
		//$this->db->where('DATE_FORMAT(tbl_booking_date1.BookingDate,"%Y-%m-%d") ',$mydate);    
		//$this->db->where('tbl_booking_loads1.Status','6');   
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['TodayTotalJobsWasted'];  
	}
	 
	 
	function TodayPDAUsers($mydate){  
		$this->db->select('tbl_drivers.LorryNo, tbl_drivers.MacAddress,  tbl_drivers_logs.DriverLoginID,tbl_drivers_logs.IPAddress,  tbl_drivers_logs.LogInLoc, tbl_drivers_logs.LogID,
		tbl_drivers_login.DriverName, DATE_FORMAT(tbl_drivers_logs.LoginDatetime,"%d-%m-%Y %T") as LoginDatetime ,
		DATE_FORMAT(tbl_drivers_logs.LogoutDateTIme,"%d-%m-%Y %T") as LogoutDateTIme '); 	 
		$this->db->from('tbl_drivers_logs');    
		$this->db->join('tbl_drivers', 'tbl_drivers_logs.DriverID  = tbl_drivers.LorryNo ','LEFT');   
		$this->db->join('tbl_drivers_login', 'tbl_drivers_logs.DriverLoginID  = tbl_drivers_login.DriverID ','LEFT');   
		$this->db->where('DATE_FORMAT(tbl_drivers_logs.LoginDatetime,"%Y-%m-%d") ',$mydate);    
		$this->db->where('tbl_drivers_logs.DriverID > 0 ');    
		$this->db->where('tbl_drivers_logs.DriverLoginID > 0 ');     
		//$this->db->group_by("tbl_drivers_logs.DriverID,tbl_drivers_logs.DriverLoginID ");   
		$this->db->order_by('tbl_drivers_logs.LogID ','DESC');
		
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit;
		return $query->result_array();
	}
	 
	
	function CheckOppoTicket($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_tickets');   
		$this->db->where('OpportunityID ',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function CheckBooking($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_booking_request');   
		$this->db->where('OpportunityID ',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function CheckOppoTip($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_tipticket');   
		$this->db->where('OpportunityID ',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function CheckOppoNotes($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_opportunity_to_note');   
		$this->db->where('OpportunityID ',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function CheckOppoContacts($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_opportunity_to_contact');   
		$this->db->where('OpportunityID ',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function CheckOppoDocument($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_opportunity_to_document');   
		$this->db->where('OpportunityID ',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function CheckOppoTipAutho($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_opportunity_tip');   
		$this->db->where('OpportunityID ',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function CheckCompanyTicket($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_tickets');   
		$this->db->where('CompanyID',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function CheckCompanyOppo($ID){
		$this->db->select('count(*) as ccnt '); 
		$this->db->from('tbl_company_to_opportunities');   
		$this->db->where('CompanyID',$ID); 
		$query = $this->db->get();
		return $query->result_array();
	}
	function ApprovalUserList(){  
		$this->db->select('tbl_users.userId '); 	 
		$this->db->select('tbl_users.name '); 	 
		$this->db->from('tbl_users');   
		$this->db->join('tbl_roles', 'tbl_users.roleId = tbl_roles.roleId'); 
		$this->db->where('JSON_EXTRACT( JSON_EXTRACT( tbl_roles.role_permission, "$.booking") , "$.papprove") = "1"');			 
		$this->db->order_by('tbl_users.name ','ASC');
		$query = $this->db->get();
		//echo $this->db->last_query(); 
		//exit;
		return $query->result_array();
	} 
	
  function getTicketLimitCompanyList(){ 
    $this->db->select('count(*) as ccnt '); 
    $this->db->select('tbl_company.CompanyID '); 	
	$this->db->select('tbl_company.CompanyName '); 	
    $this->db->select('tbl_opportunities.OpportunityName'); 	
	$this->db->select('tbl_opportunities.OpportunityID '); 	
    $this->db->from('tbl_tickets');   
    $this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID ','LEFT'); 
    $this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID=tbl_opportunities.OpportunityID','LEFT'); 
	//$this->db->join('tbl_opportunity_to_document','tbl_opportunities.OpportunityID=tbl_opportunity_to_document.OpportunityID', "LEFT");  
	//$this->db->join('tbl_documents','tbl_documents.DocumentID=tbl_opportunity_to_document.DocumentID', "LEFT");  
	$this->db->where('tbl_tickets.TypeOfTicket','In');			 	 
	//$this->db->where('(select count(*) from tbl_documents d1 join tbl_opportunity_to_document d2 on d1.DocumentID = d2.DocumentID  where d2.OpportunityID = tbl_tickets.OpportunityID ) = 0  ');			 
	$this->db->group_by("tbl_tickets.OpportunityID "); 
	$this->db->having('ccnt > (select ticket_limit from tbl_content_settings limit 1 ) AND
	(select count(*) from tbl_documents tbl_documents join tbl_opportunity_to_document on tbl_documents.DocumentID = tbl_opportunity_to_document.DocumentID  AND tbl_documents.DocumentType  = 1
	where tbl_opportunity_to_document.OpportunityID = tbl_tickets.OpportunityID ) = 0  ');   
    $this->db->order_by('tbl_tickets.OpportunityID ','ASC');
    $query = $this->db->get();
	//echo $this->db->last_query(); 
	//exit;
    return $query->result_array();
  }
  
  /*function getTicketLimitCompanyList(){ 
    $this->db->select('count(*) as ccnt '); 
    $this->db->select('tbl_company.CompanyID '); 	
	$this->db->select('tbl_company.CompanyName '); 	
    $this->db->select('tbl_opportunities.OpportunityName'); 	
	$this->db->select('tbl_opportunities.OpportunityID '); 	
    $this->db->from('tbl_tickets');   
    $this->db->where('tbl_tickets.TypeOfTicket','In');			
	$this->db->where('(select count(*) from tbl_documents d1 join tbl_opportunity_to_document d2 on d1.DocumentID = d2.DocumentID where d2.OpportunityID = tbl_tickets.OpportunityID ) = 0  ');			
    $this->db->join('tbl_company', 'tbl_tickets.CompanyID = tbl_company.CompanyID ','LEFT'); 
    $this->db->join('tbl_opportunities', 'tbl_tickets.OpportunityID=tbl_opportunities.OpportunityID','LEFT'); 
	//$this->db->join('tbl_opportunity_to_document','tbl_opportunities.OpportunityID=tbl_opportunity_to_document.OpportunityID', "LEFT");  
	//$this->db->join('tbl_documents','tbl_documents.DocumentID=tbl_opportunity_to_document.DocumentID', "LEFT");  
	$this->db->group_by("tbl_tickets.OpportunityID "); 
	$this->db->having('ccnt > (select ticket_limit from tbl_content_settings limit 1 ) ');   
    $this->db->order_by('tbl_tickets.OpportunityID ','ASC');
    $query = $this->db->get();
	//echo $this->db->last_query(); 
	//exit;
    return $query->result_array();
  }*/
  
  
  function ListOfAPK(){  
    $this->db->select('*'); 	 
	$this->db->select('DATE_FORMAT(tbl_apk.VersionDate,"%d-%m-%Y") as vdate'); 	  
    $this->db->from('tbl_apk');     
    $this->db->order_by('tbl_apk.TableID ','DESC');
    $query = $this->db->get();
    return  $query->result();   
  }
   function CompanyList1(){  
    $this->db->select('tbl_company.CompanyID '); 	
	$this->db->select('tbl_company.CompanyName '); 	 
    $this->db->from('tbl_company');   
    $this->db->join('tbl_company_to_opportunities', 'tbl_company.CompanyID = tbl_company_to_opportunities.CompanyID',"LEFT");  
    $this->db->where('tbl_company_to_opportunities.CompanyID  <> ""');			
	$this->db->where('tbl_company_to_opportunities.OpportunityID  <> ""');			
	//$this->db->where('tbl_company.status',1);			
	$this->db->where('tbl_company.CompanyName <> ""');			
	$this->db->group_by("tbl_company.CompanyID ");  
    $this->db->order_by('tbl_company.CompanyName ','ASC');
    $query = $this->db->get();
	//echo $this->db->last_query(); 
	//exit;
    return $query->result_array();
  }
  function CompanyList(){  
    $this->db->select('tbl_company.CompanyID '); 	
	$this->db->select('tbl_company.CompanyName '); 
	$this->db->select('tbl_company.Status '); 	
    $this->db->from('tbl_company');   
    $this->db->join('tbl_company_to_opportunities', 'tbl_company.CompanyID = tbl_company_to_opportunities.CompanyID',"LEFT");  
    $this->db->where('tbl_company_to_opportunities.CompanyID  <> ""');			
	$this->db->where('tbl_company_to_opportunities.OpportunityID  <> ""');			
	//$this->db->where('tbl_company.status',1);			
	$this->db->where('tbl_company.CompanyName <> ""');			
	$this->db->group_by("tbl_company.CompanyID ");  
    $this->db->order_by('tbl_company.CompanyName ','ASC');
    $query = $this->db->get();
    return $query->result_array();
  }
  
  public function DriverLoginList(){  
    $this->db->select('tbl_drivers_login.DriverName '); 	
	$this->db->select('tbl_drivers_login.DriverID '); 	
	$this->db->select('tbl_drivers_login.MobileNo '); 	 
    $this->db->from('tbl_drivers_login');    
    $this->db->where('tbl_drivers_login.MobileNo  <> ""');	  
    $this->db->order_by('tbl_drivers_login.DriverName ','ASC');
    $query = $this->db->get();
    return $query->result_array();
  } 	
  function CompanyListAJAX(){  
    $this->db->select('tbl_company.CompanyID '); 	
	$this->db->select('tbl_company.CompanyName '); 	 
    $this->db->from('tbl_company');   
    $this->db->join('tbl_company_to_opportunities', 'tbl_company.CompanyID = tbl_company_to_opportunities.CompanyID');  
    $this->db->where('tbl_company_to_opportunities.CompanyID  <> ""');			
	$this->db->where('tbl_company_to_opportunities.OpportunityID  <> ""');			
	$this->db->where('tbl_company.status',1);			
	$this->db->where('tbl_company.CompanyName <> ""');			
	$this->db->group_by("tbl_company.CompanyID ");  
    $this->db->order_by('tbl_company.CompanyName ','ASC');
    $query = $this->db->get();
	return $result = $query->result();     
  }
  function LorryListAJAX(){  
    $this->db->select('LorryNo,DriverName,RegNumber,Haulier');
	$this->db->from('drivers');
	$this->db->where('DriverName <> ""');
	$this->db->where('RegNumber <> ""');  
    $query = $this->db->get();
	return $result = $query->result();     
  }  
  public function GetAllUsers(){    
    $this->db->select('name,userId');
	$this->db->from('tbl_users'); 
    $query = $this->db->get(); 
    return $query->result();
  }
  
  function getRecentlyAddedSites(){  
    $this->db->select('tbl_company.CompanyID '); 	
	$this->db->select('tbl_company.CompanyName '); 	
    $this->db->select('tbl_opportunities.OpportunityName'); 	
	$this->db->select('tbl_opportunities.OpportunityID '); 	
    $this->db->from('tbl_opportunities');    
	$this->db->join('tbl_company_to_opportunities', 'tbl_opportunities.OpportunityID = tbl_company_to_opportunities.OpportunityID ','LEFT');  
    $this->db->join('tbl_company', ' tbl_company_to_opportunities.CompanyID = tbl_company.CompanyID','LEFT');  
	$this->db->group_by("tbl_opportunities.OpportunityID ");  
    $this->db->order_by('tbl_opportunities.CreateDate ','DESC');
	$this->db->limit(10);               
    $query = $this->db->get();
    return $query->result_array();
  }
  function getRecentlyAddedCompany(){  
    $this->db->select('tbl_company.CompanyID '); 	
	$this->db->select('tbl_company.CompanyName '); 	 
    $this->db->from('tbl_company');       
	$this->db->where('tbl_company.CompanyName  <> ""');
    $this->db->order_by('tbl_company.tscreate_datetime ','DESC');
	$this->db->limit(10);               
    $query = $this->db->get();
    return $query->result_array();
  }	
  
  function getMaterialInfo($id){
		$this->db->select('tbl_materials.*');  
        $this->db->select('(select tbl_price.TMLPrice FROM tbl_price where tbl_price.PriceID = tbl_materials.PriceID ) as TMLPrice '); 		 
        $this->db->from('tbl_materials'); 
        $this->db->where('tbl_materials.MaterialID',$id);		
		$query = $this->db->get(); 
		return $query->row_array();
  }
	function GetCompanyID($TicketNumber){
		$this->db->select('tbl_tickets.CompanyID');   
		$this->db->from('tbl_tickets'); 
		$this->db->where('tbl_tickets.TicketNumber',$TicketNumber);		
		$query = $this->db->get(); 
		return $query->row_array();
	}
	
  function get_all_records($table ,$status=''){
   
    $this->db->select('*');
    $this->db->from($table);   
    if(!empty($status)){
      $this->db->where('status','1');
    }
    $this->db->order_by('id','DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
function checkDriverMobileExists($key){
	$this->db->where('MobileNo',$key);
	$this->db->where('Status',0);
	$query = $this->db->get('tbl_drivers');
	if ($query->num_rows() > 0){
		return true;
	}else{
		return false;
	}
} 
 
   // Common function for insert data
  public function insert($table,$data){
      $this->db->insert($table,$data);
	  //echo $this->db->last_query(); 
      return  $this->db->insert_id();
  }
  // update data
  public function update($table, $data, $where){ 
      $this->db->update($table, $data, $where);
      //$this->db->last_query(); 
	   
      return $this->db->affected_rows();
  }
  public function direct_update($table, $data, $where) {
        // Construct SET part of the query
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "{$column} = " . $this->db->escape($value);
        }
        $set_clause = implode(', ', $set);
    
        // Construct WHERE part of the query
        $conditions = [];
        foreach ($where as $column => $value) {
            $conditions[] = "{$column} = " . $this->db->escape($value);
        }
        $where_clause = implode(' AND ', $conditions);
    
        // Build and execute the query
        $sql = "UPDATE {$table} SET {$set_clause} WHERE {$where_clause}";
        $this->db->query($sql);
    
        // Debug: Uncomment to check query and errors
        // echo $this->db->last_query();
        // var_dump($this->db->error());
    
        // Return the number of affected rows
        return $this->db->affected_rows();
    }
  // Delete data
  public function delete($table,$whre){
      $this->db->where($whre);
      $this->db->delete($table);
      return $this->db->affected_rows();
  }

  // Delete data
  public function delete_not_in($table,$userid,$products){

    //print_r($products);die;
      $this->db->where('user_id',$userid);
      $this->db->where_not_in('product_id',$products);
      //$this->db->where('product_id','NOT IN('.implode(',',$products).')', NULL, FALSE);

      $this->db->delete($table);
      return $this->db->affected_rows();
  }

    // Delete data
  public function delete_in($table,$id){ 
		$id = explode(',',$id); 
		$this->db->where_in('id',$id);
		//$this->db->where('product_id','NOT IN('.implode(',',$products).')', NULL, FALSE); 
	  $this->db->delete($table);
	  return $this->db->affected_rows();
  }
  public function update_in($table,$data,$field,$where_in){  
    $where_in = explode(',',$where_in); 
    $this->db->where_in($field,$where_in);
	$this->db->update($table,$data);
    //$this->db->where('product_id','NOT IN('.implode(',',$products).')', NULL, FALSE); 
    //$this->db->delete($table);
	echo $this->db->last_query();       
	exit;
    return $this->db->affected_rows();
  }	

    // get data with where condition
  public function get_all($table){    
    $query = $this->db->get($table);
    return $query->result();
  }


  // get data with where condition
  public function select_all_with_where_result($table,$field){
    $this->db->where($field);
    $query = $this->db->get($table);
    return $query->result();
  }
 
  // get data with where condition
  public function select_all_with_where($table,$field){
    $this->db->where($field);
    $query = $this->db->get($table);
    return $query->result_array();
  }


  // get data with where condition
  public function select_all_where_order_custom($table,$field,$order_by){
    
    $this->db->where($field);
    $this->db->order_by($order_by['0'],$order_by['1']);
    $query = $this->db->get($table);
    return $query->result_array();
  }



  // get data with where condition
  public function select_where($table,$field){
    $this->db->where($field);
    $query = $this->db->get($table);
    return $query->row_array();
  }

    // get data with where condition
  public function select_singel_where($table,$field){
    $this->db->where($field);
    $query = $this->db->get($table);
    return $query->row();
  }

   // get data with where condition
  public function select_all_where($table,$field){
    $this->db->where($field);
    $this->db->order_by('id','DESC');
    $query = $this->db->get($table);
    return $query->result_array();
  }

     // get data with where condition
  public function select_all_where_order($table,$field){
    $this->db->where($field);
    $this->db->order_by('name','ASC');
    $query = $this->db->get($table);
    return $query->result_array();
  }
 
	public function CountHoldTicket(){
		$this->db->select('count(*) as count_hold'); 	
		$this->db->from('tbl_tickets');   
		$this->db->where('is_hold',1);		
		$this->db->where('LoadID',0);		
		$this->db->where('delete_notes',NULL);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['count_hold'];  
	} 
	public function CountDeliveryHoldTicket(){
		$this->db->select('count(*) as count_hold'); 	
		$this->db->from('tbl_tickets');   
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		 
		$this->db->where('tbl_booking_loads1.Status',1);		
		$this->db->where('tbl_tickets.is_hold',1);		
		$this->db->where('tbl_tickets.LoadID > 0 ');				
		$this->db->where('tbl_tickets.delete_notes',NULL);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['count_hold'];  
	}
	
	public function CountInBound(){
		$this->db->select('count(*) as count_inbound'); 	
		$this->db->from('tbl_tickets');   
		$this->db->where('IsInBound',1);			
		$this->db->where(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y-%m-%d") = DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');
		$this->db->where('delete_notes',NULL);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['count_inbound'];  
	}
	public function CountInCompleted(){
		$this->db->select('count(*) as count_incompleted'); 	
		$this->db->from('tbl_tickets');   
		$this->db->where('IsInBound',1);			
		$this->db->where(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y-%m-%d") <> DATE_FORMAT(CURDATE(),"%Y-%m-%d") ');
		$this->db->where('delete_notes',NULL);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['count_incompleted'];  
	}
	public function CountTicket(){
		$this->db->select('count(*) as ticket_count'); 	
		$this->db->from('tbl_tickets');    	
		$this->db->where('delete_notes',NULL);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['ticket_count'];  
	}
	public function CountDriverTickets($driver_id){
		$this->db->select('count(*) as ticket_count'); 	
		$this->db->from('tbl_tickets');    	
		//$this->db->where('delete_notes',NULL);			  
		$this->db->where('driver_id',$driver_id);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['ticket_count'];  
	}
	public function CountContacts(){
		$this->db->select('count(*) as contact_count'); 	
		$this->db->from('tbl_contacts'); 
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['contact_count'];  
	}
	public function CountCompany(){
		$this->db->select('count(*) as company_count'); 	
		$this->db->from('tbl_company');  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['company_count'];  
	}
	
  // get data with where condition
  public function select_count_where($table,$field){
      $this->db->where($field);
      $query = $this->db->get($table);
      return $query->num_rows();

  }

    // get data with where condition
  public function select_count($table){
      $query = $this->db->get($table);
      return $query->num_rows();

  }

  // get data with where condition
  public function checkpermission($module){

    $this->db->where("roleId",$this->session->userdata('role'));
    $query = $this->db->get('roles');
    $res = $query->row_array();
    $res = json_decode($res['role_permission']);
    return $res->$module;       

  }

  function get_invoice_list(){
        $this->db->select('a.INVOICE_NUMBER,a.ACCOUNT_REF, a.INVOICE_DATE, b.job_site_address, b.TML_Ref, b.Pages_No,b.cust_name,b.GUID,b.ActRevision');
        $this->db->from('documents1 as b');
        $this->db->join('invoice as a', 'b.Invoice_No=a.INVOICE_NUMBER'); 
        $this->db->where("a.ACCOUNT_REF", 'ROCHFORD'); 
        $this->db->limit(61);               
        $query = $this->db->get(); 
       // echo $this->db->last_query();       
        $result = $query->result_array();        
        return $result;
    } 


    function get_invoice_images($GUID,$ActRevision)
    {
        $this->db->select('*');
        $this->db->from('images');       
        $this->db->where("DocGUID", $GUID);  
        $this->db->where("RevNo", $ActRevision); 
        $this->db->group_by("PageNo");             
        $query = $this->db->get();        
        $result = $query->result_array();        
        return $result;
    } 


    function get_invoice_images_any($GUID)
    {
        $this->db->select('*');
        $this->db->from('images');       
        $this->db->where("DocGUID", $GUID);          
        $this->db->where("sourcefileName LIKE '%.xls%'");
        $this->db->group_by("PageNo");  
        $this->db->limit(1);           
        $query = $this->db->get();        
        $result = $query->result_array();        
        return $result;
    } 



    function get_invoice_info($invoice_id)
    {
        $this->db->select('a.*, b.job_site_address, b.cust_name, b.TML_Ref, b.Pages_No');
        $this->db->from('documents1 as b');
        $this->db->join('invoice as a', 'a.INVOICE_NUMBER = b.Invoice_No'); 
        $this->db->where("a.INVOICE_NUMBER", $invoice_id);                     
        $query = $this->db->get(); 
       // echo $this->db->last_query();       
        $result = $query->row_array();        
        return $result;
    }
		
    function get_pdf_data($invoice_id)
    {
        $this->db->select(' DATE_FORMAT(TicketDate,"%d/%m/%Y %T") as tdate ');  
		$this->db->select('a.*, b.*,c.CompanyName,d.MaterialName');
		$this->db->select('tbl_booking1.LorryType');
		$this->db->select('b.LorryType as LorryTypeT');
        $this->db->from('tbl_tickets as b');
        
		$this->db->join('tbl_opportunities as a', ' b.OpportunityID = a.OpportunityID','LEFT'); 
        $this->db->join('tbl_company as c', 'b.CompanyID = c.CompanyID ','LEFT'); 
		$this->db->join('tbl_materials as d', 'b.MaterialID = d.MaterialID','LEFT'); 
		$this->db->join('tbl_booking_loads1', 'b.LoadID = tbl_booking_loads1.LoadID','LEFT'); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID','LEFT'); 
		 
		//$this->db->join('tbl_opportunities as a', 'a.OpportunityID = b.OpportunityID'); 
        //$this->db->join('tbl_company as c', 'c.CompanyID = b.CompanyID'); 
		//$this->db->join('tbl_materials as d', 'b.MaterialID = d.MaterialID'); 
		
        $this->db->where("b.TicketNo", $invoice_id);                     
        $query = $this->db->get(); 
        //echo $this->db->last_query();       
		//exit;
        $result = $query->row_array();        
        return $result;
    } 
	function get_pdf_data1($invoice_id)
    {
        $this->db->select(' DATE_FORMAT(TicketDate,"%d/%m/%Y %T") as tdate ');  
		$this->db->select('a.*, b.*,c.CompanyName,d.MaterialName');
		$this->db->select('tbl_booking1.LorryType');
		$this->db->select('tbl_drivers_login.ltsignature as driversignature');
		$this->db->select('b.LorryType as LorryTypeT');
        $this->db->from('tbl_tickets as b');
        
		$this->db->join('tbl_opportunities as a', ' b.OpportunityID = a.OpportunityID','LEFT'); 
        $this->db->join('tbl_company as c', 'b.CompanyID = c.CompanyID ','LEFT'); 
		$this->db->join('tbl_materials as d', 'b.MaterialID = d.MaterialID','LEFT'); 
		$this->db->join('tbl_booking_loads1', 'b.LoadID = tbl_booking_loads1.LoadID','LEFT'); 
		$this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID','LEFT'); 
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID','LEFT'); 
		 
		//$this->db->join('tbl_opportunities as a', 'a.OpportunityID = b.OpportunityID'); 
        //$this->db->join('tbl_company as c', 'c.CompanyID = b.CompanyID'); 
		//$this->db->join('tbl_materials as d', 'b.MaterialID = d.MaterialID'); 
		
        $this->db->where("b.TicketNo", $invoice_id);                     
        $query = $this->db->get(); 
        //echo $this->db->last_query();       
		//exit;
        $result = $query->row_array();        
        return $result;
    }  
	function GetDriverDetails($driverid)
    {
        $this->db->select('ltsignature', 'Signature');   
        $this->db->from('tbl_drivers_login'); 	
        $this->db->where("tbl_drivers_login.DriverID", $driverid);                     
        $query = $this->db->get(); 
        //echo $this->db->last_query();       
		//exit;
        $result = $query->row_array();        
        return $result;
    } 
	/*function get_pdf_data_app($invoice_id)
    {
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
    } */


    function get_invoice_items($Invoice_No)
    {
        $this->db->select('*');
        $this->db->from('invoice_item');       
        $this->db->where("INVOICE_NUMBER", $Invoice_No);                   
        $query = $this->db->get();        
        $result = $query->result_array();        
        return $result;
    } 


     function get_invoice_documents($Invoice_No) 
    {
        $this->db->select('GUID,ActRevision');
        $this->db->from('documents1');       
        $this->db->where("Invoice_No", $Invoice_No);                   
        $query = $this->db->get();        
        $result = $query->row_array();        
        return $result;
    }
	
	public function CountLoads($BookingDateID){
		$this->db->select('count(*) as LoadCount'); 	
		$this->db->from('tbl_booking_loads');    	
		$this->db->where('tbl_booking_loads.BookingDateID',$BookingDateID);			  
		$this->db->where('tbl_booking_loads.AutoCreated',1);			  
		$query = $this->db->get();
		$row = $query->row_array();
		return $row['LoadCount'];  
	}
	public function CountLoads1($BookingDateID){
		$this->db->select('count(*) as LoadCount'); 	
		$this->db->from('tbl_booking_loads1');    	
		$this->db->where('tbl_booking_loads1.BookingDateID',$BookingDateID);			  
		$this->db->where('tbl_booking_loads1.AutoCreated',1);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['LoadCount'];  
	}
	public function CountLorry($BookingDateID){
		$this->db->select('COUNT(DISTINCT DriverID) as LorryCount'); 	
		$this->db->from('tbl_booking_loads');    	
		$this->db->where('tbl_booking_loads.BookingDateID', $BookingDateID);			  
		$this->db->where('DATE_FORMAT(tbl_booking_loads.AllocatedDateTime,"%Y-%m-%d") = CURDATE()');			  
		$this->db->where('tbl_booking_loads.AutoCreated',1);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['LorryCount'];  
	}
	public function CountLorry1($BookingDateID){
		$this->db->select('COUNT(DISTINCT DriverID) as LorryCount'); 	
		$this->db->from('tbl_booking_loads1');    	
		$this->db->where('tbl_booking_loads1.BookingDateID', $BookingDateID);			  
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%Y-%m-%d") = CURDATE()');			  
		$this->db->where('tbl_booking_loads1.AutoCreated',1);			  
		$query = $this->db->get();
		$row = $query->row_array();   
		return $row['LorryCount'];  
	}
	
	function GetBookingDateIDs($BookingRequestID){
		$this->db->select('tbl_booking_date1.BookingDateID');   
		$this->db->from('tbl_booking_date1'); 
		$this->db->where('tbl_booking_date1.BookingRequestID',$BookingRequestID);		
		$query = $this->db->get(); 
		//echo $this->db->last_query();       
		//exit;
		return $query->result();
	}
	
	function GetBookingPriceTotal($BookingRequestID){
		$this->db->select('SUM(TotalAmount) as TotalAmount');   
		$this->db->from('tbl_booking1'); 
		$this->db->where('tbl_booking1.BookingRequestID',$BookingRequestID);		
		$query = $this->db->get(); 
		//echo $this->db->last_query();       
		//exit;
		return $query->result();
	}
	
	public function UpdatePON($PurchaseOrderNo, $BookingDateIDs ){
        $sql="UPDATE `tbl_product` set `PurchaseOrderNo` = '".$PurchaseOrderNo."' where `BookingDateID` IN (".$BookingDateIDs.") ";    
		$resultU = $this->db->query($sql);
		///echo $this->db->last_query();       
		//exit;
		return $resultU; 
    }
	
	public function HoldLoadOnInvoice($LoadIDS ){
        $sql="UPDATE `tbl_booking_loads1` set `Hold` = '1' where `LoadID` IN (".$LoadIDS.") ";    
		$resultU = $this->db->query($sql);
		///echo $this->db->last_query();       
		//exit;
		return $resultU; 
    }
	  
 }
