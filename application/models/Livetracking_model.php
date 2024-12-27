<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Livetracking_model extends CI_Model{ 
	
	public function GetLoadsData($driverId='',$type='')
	{
		//$columnIndex = $_POST['order'][0]['column']; // Column index
		//$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		//$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		//$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		 
        //Only select column that want to show in datatable or you can filte it mnually when send it
        //$this->db->start_cache(); 
		$this->db->select(' tbl_booking_loads1.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking_request.CompanyID  as CompanyID  ');  	 		
		$this->db->select(' tbl_booking_loads1.MaterialID ');
		$this->db->select(' tbl_booking_loads1.DriverID ');
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');		
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.LoadID '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');  	 		
		$this->db->select(' tbl_booking_loads1.Status ');  	 		
		$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 		
		$this->db->select(' tbl_drivers.RegNumber as rname ');  	 				
		$this->db->select(' tbl_drivers.AppUser ');  	 
		$this->db->select(' tbl_drivers.LorryNo ');  	 				
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	 
		$this->db->select(' tbl_booking_date1.BookingDateID ');  	 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDateTime ');  	 	 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.AllocatedDateTime,"%d-%m-%Y  %T") as CreateDateTime ');  
		//$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		//$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking_loads.MaterialID ) as MaterialName '); 
		//$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName ');    
		
		
		$this->db->select(' tbl_booking_request.CompanyName ');		
		$this->db->select(' tbl_booking1.MaterialName ');		
		$this->db->select(' tbl_booking_request.OpportunityName ');

		$this->db->select(' tbl_tipaddress.TipName as tipaddress_tipname ');
		$this->db->select(' tbl_tipaddress.Street1 as tipaddress_street1 ');
		$this->db->select(' tbl_tipaddress.Street2 as tipaddress_street2 ');
		$this->db->select(' tbl_tipaddress.Town as tipaddress_town ');
		$this->db->select(' tbl_tipaddress.County as tipaddress_country ');
		$this->db->select(' tbl_tipaddress.PostCode as tipaddress_postcode ');



		/* $this->db->select(' live.latitude ');	
		$this->db->select(' live.longitude ');	
		$this->db->select(' live.eta ');	
		$this->db->select(' live.current_speed ');	
		$this->db->select(' live.status as live_Status ');	 */
		
		
		
		$this->db->join('tbl_booking_date1', ' tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ', 'LEFT');
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ', 'LEFT'); 		 
		$this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID', 'LEFT');
		$this->db->join('tbl_drivers', ' tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ', 'LEFT'); 		
		//$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID', 'LEFT'); 		
		$this->db->join('tbl_drivers_login', ' tbl_drivers.DriverID = tbl_drivers_login.DriverID ', 'LEFT'); 		 
		//$this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID '); 
		//$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID '); 
		//$this->db->join('tbl_materials', 'tbl_booking.MaterialID = tbl_materials.MaterialID '); 

		$this->db->join('tbl_tipaddress', ' tbl_booking_loads1.TipID = tbl_tipaddress.TipID ', 'LEFT'); 		


		//$this->db->join('(select max(id) max_live_tracking_id, latitude, longitude, eta, current_speed 
		//from tbl_live_tracking group by driver_id)', 'tbl_live_tracking.driver_id = tbl_booking_loads.DriverID', 'left');

		//$this->db->join("tbl_live_tracking as live", "live.id = (select max(id) from tbl_live_tracking as e2 where e2.load_id = live.load_id and live.created_at = '".date("Y-m-d")."')", "left");



		if(isset($type) && $type == "completed"){
			$this->db->where('tbl_booking_loads1.Status = 4 '); 
			/* $wherecond = "( tbl_booking_date.BookingDate ='" . date("Y-m-d") . "' OR tbl_booking_date.BookingDate='" . date("Y-m-d",strtotime("-1 days")) . "')";
			$this->db->where($wherecond); */
			$this->db->where("tbl_booking_date1.BookingDate <= '".date("Y-m-d")."'"); 
		}elseif(isset($type) && $type == "due"){
			$this->db->where('tbl_booking_loads1.Status < 4 '); 
			$this->db->where("tbl_booking_date1.BookingDate <= '".date("Y-m-d")."'"); 
		}elseif(isset($type) && $type == "tomorrow"){
			$this->db->where('tbl_booking_loads1.Status < 4 '); 
			$this->db->where("tbl_booking_date1.BookingDate = '".date("Y-m-d", strtotime("+1 day"))."'"); 
		} else{
			$this->db->where('tbl_booking_loads1.Status < 4 '); 
			//$this->db->where('tbl_booking_loads1.Status > 0 '); 
			//$this->db->where("tbl_booking_loads1.JobStartDateTime LIKE '%".date("Y-m-d")."%' "); 
			$this->db->where("tbl_booking_loads1.AllocatedDateTime LIKE '%".date("Y-m-d")."%' "); 
		}
		if(isset($type) && $type == "completed"){
			$this->db->limit(5);  
		}

		if(isset($driverId) && !empty($driverId)){
			$this->db->where('tbl_booking_loads1.DriverID = '.$driverId);
		}
		
		$this->db->order_by('tbl_booking_loads1.BookingID', 'DESC');			 
        $query = $this->db->get('tbl_booking_loads1');
		//echo '<pre>'; print_r($query->result_array()); exit;
		//echo $this->db->last_query(); 
		//exit; 
		
        //$this->db->stop_cache();

		//Reset Key Array
        $data = array();
		$data = $query->result_array();
		foreach($data as $k=>$load){
			$this->db->select('*');
            $this->db->from('tbl_live_tracking');
            $this->db->where('tbl_live_tracking.driver_id = '.$load['DriverLoginID']);
            $this->db->where('tbl_live_tracking.load_id = '.$load['LoadID']);
            $this->db->order_by('tbl_live_tracking.id', 'DESC');
            $query = $this->db->get();
            $live_tracking_data = $query->result_array();
            $data[$k]['live_tracking_data'] = $live_tracking_data;
		}
		$totalData  = $this->db->count_all_results();
		$totalFiltered =  $totalData; 
        //Prepare Return Data
        $return = array(
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data   // total data array 
        ); 
        return $return; 
    }
}

  