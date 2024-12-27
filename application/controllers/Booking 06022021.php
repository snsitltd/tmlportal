<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
include_once APPPATH.'/third_party/mpdf/mpdf.php';

class Booking extends BaseController{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->model('Fcm_model');
		$this->load->model('tickets_model');        
        $this->isLoggedIn();  
      
        $roleCheck = $this->Common_model->checkpermission('tickets'); 

        //print_r($roleCheck);die;

        $this->global['isView'] = $this->isView = $roleCheck->view;   
         $this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
         $this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
         $this->global['isDelete'] = $this->isDelete = $roleCheck->delete; 
         $this->global['active_menu'] = 'dashboard'; 

    }
     
    public function index(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();
            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Booking Listing';
            $this->global['active_menu'] = 'bookings'; 
            
            $this->loadViews("Booking/Bookings", $this->global, $data, NULL);
        }
    }

    public function AllocateBookings(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();    
			//$data['AllocateBookings'] = $this->Booking_model->AllocateBookings(); 			
			$data['TodayBookingRecords'] = $this->Booking_model->TodayBookingListing(); 
			$data['OverdueBookingRecords'] = $this->Booking_model->OverdueBookingListing(); 
			$data['BookingRecords'] = $this->Booking_model->FutureBookingListing();   
			
			//$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX1();  	 
			$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX();  	 
			$data['LorryRecords'] = $this->Booking_model->LorryListAJAX();  	
			
			$data['TipRecords'] = $this->Booking_model->TipListAJAX(); 
			 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Allocate Booking ';
            $this->global['active_menu'] = 'bookingallocate'; 
            
            $this->loadViews("Booking/AllocateBookings", $this->global, $data, NULL);
        }
    }
	public function Loads(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();     
			 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Loads/Lorry List ';
            $this->global['active_menu'] = 'loads'; 
            
            $this->loadViews("Booking/Loads", $this->global, $data, NULL);
        }
    }
	public function AllocateDrivers(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();     
			 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Allocated Drivers';
            $this->global['active_menu'] = 'allocateddrivers'; 
            
            $this->loadViews("Booking/AllocateDrivers", $this->global, $data, NULL);
        }
    }
	public function AjaxAllocateDrivers(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocateDriversData();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	public function ConveyanceTickets(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();     
			 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Conveyance Tickets';
            $this->global['active_menu'] = 'conveyance'; 
            
            $this->loadViews("Booking/ConveyanceTickets", $this->global, $data, NULL);
        }
    }
	public function AllMessage(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();     
			 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : All Message';
            $this->global['active_menu'] = 'message'; 
            
            $this->loadViews("Booking/AllMessage", $this->global, $data, NULL);
        }
    }
	public function Message(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();      
			$data['driverList'] = $this->Booking_model->GetDriverList();   
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Driver Message';
            $this->global['active_menu'] = 'message'; 
            
            $this->loadViews("Booking/Message", $this->global, $data, NULL);
        }
    }
	function SendDriverMessage()
    {
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
		
			$IDS = $this->security->xss_clean($this->input->post('IDS')); 
			$Message = $this->security->xss_clean($this->input->post('Message')); 
			$Id = explode(',',$IDS);	
			for($i=0;$i<count($Id);$i++){
				$MessageInfo = array('DriverID'=> $Id[$i], 'Status'=>0 , 'Message'=> $Message ); 
				$result1 = $this->Common_model->insert("tbl_driver_message",$MessageInfo);  
			}  
			$this->Fcm_model->sendNotication($IDS,$Message,'message');
            //if ($result1 > 0) { 
				echo(json_encode(array('status'=>TRUE,'result'=>$result1))); 
			//}else{ 
			//	echo(json_encode(array('status'=>FALSE,'result'=>$result1))); 
			//}
        }
    }
	
	public function AjaxMessage(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetLoadsMessage();   
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookings(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingData();   
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookings2(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingData2();   
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookings3(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingData3();   
		$this->ajax->send($data);
	}
	public function AjaxAllocatedBookings1(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetAllocatedBookingData1();   
		$this->ajax->send($data);
	}
	public function AjaxLoads(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetLoadsData();   
		$this->ajax->send($data);
	}
	
	public function AjaxLoads1(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetLoadsData1();  
		$this->ajax->send($data);
	}
	public function AjaxLoads2(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetLoadsData2();  
		$this->ajax->send($data);
	}
	public function AjaxConveyanceTickets(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetConveyanceTickets();  
		$this->ajax->send($data);
	}
	
	public function AjaxBookings(){  
		$this->load->library('ajax');
		$data = $this->Booking_model->GetBookingData();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	
	function GetDriverList(){ 
		$result['driver_list'] = $this->Booking_model->LorryListAJAX() ; 
		if ($result > 0) { echo(json_encode($result)); }
		else { echo(json_encode(array('status'=>FALSE))); } 
    }
	function GetTipList(){ 
		$result['tip_list'] = $this->Booking_model->TipListAJAX() ; 
		if ($result > 0) { echo(json_encode($result)); }
		else { echo(json_encode(array('status'=>FALSE))); } 
    }

############################################################################################## 
 
    function AddBooking(){
        if($this->isAdd == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();           
			
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 

				
				$this->load->library('form_validation'); 
				$this->form_validation->set_rules('BookingType','Booking Type','trim|required');
				$this->form_validation->set_rules('BookingDateTime','Booking Date Time','trim|required');  
				$this->form_validation->set_rules('CompanyID','Company Name','trim|required');
				$this->form_validation->set_rules('OpportunityID','Opportunity ','trim|required');  
				$this->form_validation->set_rules('ContactID','Contact','trim|required');  
				$this->form_validation->set_rules('DescriptionofMaterial','Material','trim|required');   
				$this->form_validation->set_rules('ContactMobile','Site Contact Mobile','trim|required');   
				//$this->form_validation->set_rules('Email','Site Contact Email ','trim|required|valid_email|max_length[255]');     
				
				if($this->form_validation->run()){ 
				 
					$BookingType	 = $this->security->xss_clean($this->input->post('BookingType')); 
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID')); 
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
					
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                   
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
					
					$ContactID = $this->security->xss_clean($this->input->post('ContactID')); 
					$ContactName = $this->security->xss_clean($this->input->post('ContactName')); 
					
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
					   
					$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$LoadType = $this->security->xss_clean($this->input->post('LoadType'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					//$Days = $this->security->xss_clean($this->input->post('Days'));
					
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));
					$Email = $this->security->xss_clean($this->input->post('Email'));
					$Notes = $this->security->xss_clean($this->input->post('Notes')); 
 
				   
					if($CompanyID == '0' ){
						if(trim($CompanyName) == '' ){
							$this->session->set_flashdata('error', 'Company Name Must Not be blank');                
							redirect('Bookings');
						}		
						$CompanyID = $this->generateRandomString();
						$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s')); 
						$this->Common_model->insert("tbl_company",$CompanyInfo);
					}	 
					if($OpportunityID == '0'){    
						if(trim($Street1) == '' && trim($Town) == '' && trim($County) == '' && trim($PostCode) == ''  ){
							$this->session->set_flashdata('error', 'Opportunity Must Not be blank');                
							redirect('Bookings');
						}		 
						$OpportunityID = $this->generateRandomString(); 
						$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
						$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 
						'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode); 
						$this->Common_model->insert("tbl_opportunities",$OppoInfo);
						
						$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
						$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
					}
					if($ContactID == '0'){   
						if(trim($ContactName) == '' ){
							$this->session->set_flashdata('error', 'Contact Name Must Not be blank');                
							redirect('Bookings');
						}
						$ContactID = $this->generateRandomString();  
						$ConInfo = array('ContactID'=>$ContactID,'ContactIDMapKey'=>$ContactID,'ContactName'=>$ContactName,'MobileNumber'=>$ContactMobile,'EmailAddress'=>$Email); 
						$this->Common_model->insert("tbl_contacts",$ConInfo);
						
						$OC = array('OpportunityID'=>$OpportunityID, 'ContactID'=>$ContactID ); 
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC); 
					}else{
						$ConInfo = array('ContactName'=>$ContactName,'MobileNumber'=>$ContactMobile,'EmailAddress'=>$Email);  
						$cond = array( 'ContactID' => $ContactID); 
						$this->Common_model->update("tbl_contacts",$ConInfo, $cond); 
					}	
					
					$BID = $this->generateRandomString();    
 					
					$BookingInfo = array('BID' => $BID, 'BookingType'=>$BookingType, 'CompanyID'=>$CompanyID , 
					'OpportunityID'=>$OpportunityID, 'ContactID'=>$ContactID , 
					'MaterialID'=>$DescriptionofMaterial ,'PurchaseOrderNumber'=>$PurchaseOrderNumber ,'Price'=>$Price ,'Days'=>1 ,
					'Loads'=>$Loads,'LoadType'=>$LoadType ,'Email'=>$Email , 'ContactName'=>$ContactName , 'ContactMobile'=>$ContactMobile , 
					'Notes'=>$Notes , 'BookedBy'=>$this->session->userdata['userId'] );

					$ins_id = $this->Common_model->insert("booking",$BookingInfo);
					if($ins_id){ 
						$BDT = explode(',',$BookingDateTime); 
						$BookingDate = array();
						for($i=0;$i<count($BDT);$i++){
							$B = explode('/',$BDT[$i]);
							$BookingDate[$i] = $B[2]."-".$B[1]."-".$B[0] ; 
						}	  
						sort($BookingDate); 
						for($i=0;$i<count($BookingDate);$i++){ 
							$BookingInfo1 = array('BookingID' => $ins_id, 'BookingDate'=> $BookingDate[$i] ); 
							$this->Common_model->insert("tbl_booking_date", $BookingInfo1);	   
						}
						
						$this->session->set_flashdata('success', 'Booking has been Added successfully');                 
					}else{
						$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');                 
					}
					redirect('Bookings');
				}
			}
			 
			$data['company_list'] = $this->Common_model->CompanyList();

            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$data['county'] = $this->Common_model->get_all('county'); 
			$this->global['pageTitle'] =  WEB_PAGE_TITLE.' : ADD Booking';
            $this->global['active_menu'] = 'addbooking'; 

            $this->loadViews("Booking/AddBooking", $this->global, $data, NULL);
        }
    }
  
	function getCompanyList(){ 
			$result['company_list'] = $this->Common_model->CompanyListAJAX() ; 
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
    }
	 
	
    function EditBooking($BookingID){   
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($BookingID == null){ redirect('Bookings'); }          
            
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			
				$this->load->library('form_validation'); 
				$this->form_validation->set_rules('BookingType','Booking Type','trim|required');
				$this->form_validation->set_rules('BookingDateTime','Booking Date Time','trim|required');   
				$this->form_validation->set_rules('DescriptionofMaterial','Material','trim|required');   
				$this->form_validation->set_rules('ContactMobile','Site Contact Mobile','trim|required');   
				//$this->form_validation->set_rules('Email','Site Contact Email ','trim|required|valid_email|max_length[255]');   
				 
				if($this->form_validation->run()){ 
				 
					$BookingID	 = $this->security->xss_clean($this->input->post('BookingID')); 
					$BookingType	 = $this->security->xss_clean($this->input->post('BookingType')); 
					$BookingDateTime = $this->security->xss_clean($this->input->post('BookingDateTime'));  
					$DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial')); 
					$PurchaseOrderNumber = $this->security->xss_clean($this->input->post('PurchaseOrderNumber'));
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$Loads = $this->security->xss_clean($this->input->post('Loads'));
					//$Days = $this->security->xss_clean($this->input->post('Days')); 
					$LoadType = $this->security->xss_clean($this->input->post('LoadType')); 
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));
					$ContactMobile = $this->security->xss_clean($this->input->post('ContactMobile'));
					$Email = $this->security->xss_clean($this->input->post('Email')); 
					$Notes = $this->security->xss_clean($this->input->post('Notes'));  
					
					$BookingInfo = array('PurchaseOrderNumber'=>$PurchaseOrderNumber ,
					'Price'=>$Price ,'Days'=>1 , 'Loads'=>$Loads,'Email'=>$Email , 'ContactName'=>$ContactName , 'ContactMobile'=>$ContactMobile , 
					'Notes'=>$Notes , 'UpdatedBy'=>$this->session->userdata['userId'] );
					
					// Temporary 
					//$BookingInfo = array('BookingType'=>$BookingType,  
					//'MaterialID'=>$DescriptionofMaterial ,'PurchaseOrderNumber'=>$PurchaseOrderNumber ,
					//'Price'=>$Price ,'Days'=>1 ,
					//'Loads'=>$Loads,'LoadType'=>$LoadType ,'Email'=>$Email , 'ContactName'=>$ContactName , 'ContactMobile'=>$ContactMobile , 
					//'Notes'=>$Notes , 'UpdatedBy'=>$this->session->userdata['userId'] );
					
					/*
					$bdate = $this->Booking_model->GetBookingDate1($BookingID);
					
					var_dump($bdate);  
					$bdate1 = array();
					for($i=0;$i<count($bdate);$i++){   
						$bdate1[$i] = $bdate[$i]['BookingDate']; 
					}
					var_dump($bdate1);  
					exit;
					$BDT = explode(',',$BookingDateTime); 
					$BookingDate = array();
					for($i=0;$i<count($BDT);$i++){ 
						$B = explode('/',$BDT[$i]);
						$BookingDate[$i] = $B[2]."-".$B[1]."-".$B[0] ; 
						echo "bingo1"; 
						if(in_array($BookingDate[$i],$bdate)){ echo "bingo"; }
					}	  
					 	
					exit;
					*/
					$cond = array( 'BookingID' => $BookingID  ); 
					//$cond = array( 'BookingID' => $BookingID,'Status' => 0  );  // Temporary 
					$this->Common_model->update("booking",$BookingInfo, $cond);
					 	
					$Delte_Where = array( 'BookingID' => $BookingID);  
					$this->Common_model->delete("tbl_booking_date",$Delte_Where);	   	
					
					$BDT = explode(',',$BookingDateTime); 
					$BookingDate = array();
					for($i=0;$i<count($BDT);$i++){
						$B = explode('/',$BDT[$i]);
						$BookingDate[$i] = $B[2]."-".$B[1]."-".$B[0] ; 
					}	  
					sort($BookingDate); 
					 
					for($i=0;$i<count($BookingDate);$i++){ 
						$BookingInfo1 = array('BookingID' => $BookingID, 'BookingDate'=> $BookingDate[$i] ); 
						$this->Common_model->insert("tbl_booking_date", $BookingInfo1);	   
					} 
					   
					$this->session->set_flashdata('success', 'Booking has been updated successfully');                
					redirect('Bookings');
				}
			}
			
			
            $conditions = array( 'BookingID' => $BookingID );
            $data['bookings'] = $this->Booking_model->BookingData($BookingID);  
			$data['booking_date'] = $this->Booking_model->GetBookingDate($BookingID);
			$data['booking_dateCSV']="";
			for($i=0;$i<count($data['booking_date']);$i++){    
				if($i!=0){ $data['booking_dateCSV'] .= ","; }
				$B = explode('-',$data['booking_date'][$i]->BookingDate); 
				$data['booking_dateCSV'] .= $B[0]."/".$B[1]."/".$B[2]; 
			} 
			$data['company_list'] = $this->Common_model->CompanyList();
            $data['opprtunities'] = $this->Booking_model->getAllOpportunitiesByCompany($data['bookings']['CompanyID']) ;
			$data['contacts'] = $this->Booking_model->getContactsByOpportunity($data['bookings']['OpportunityID']) ;  
		
            //print_r($data['SiteAddress']); die;           
			if($data['bookings']['BookingType'] ==1){  $type = 'IN'; }
			if($data['bookings']['BookingType'] ==2){  $type = 'OUT'; }
	    
	        $Material = $this->Booking_model->getMaterialList($type);
	        $data['Material']=$Material;
 
			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Booking';
            $this->global['active_menu'] = 'editbooking'; 
            
            $this->loadViews("Booking/EditBooking", $this->global, $data, NULL);
		//	$this->output->enable_profiler(TRUE);

        }
    } 
  
	function ApproveBooking()
    {
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            $BookingID = $this->input->post('BookingNo'); 
				
            $con = array('BookingID'=>$BookingID);  
			$BookingInfo = array('Status'=>'1' , 'ApprovedBy'=> $this->session->userdata['userId'],  'UpdatedBy'=> $this->session->userdata['userId']); 
            $result = $this->Common_model->update("booking",$BookingInfo, $con); 
			 
            if ($result > 0) { echo(json_encode(array('status'=>TRUE,'BookingID'=>$BookingID))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	

	function AllocateBookingAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $BookingID = $this->input->post('BookingID');  
			$BookingDateID = $this->input->post('BookingDateID');  
			$BookingDate = $this->input->post('BookingDate');  
			$DriverID = $this->input->post('DriverID'); 
			$TipID = $this->input->post('TipID'); 
			$Qty = $this->input->post('Qty'); 
			$MaterialID = $this->input->post('MaterialID'); 
			$AllocatedDateTime = $this->input->post('AllocatedDateTime'); 
			$Loads = $this->input->post('Loads'); 
			$TotalLoads = $this->input->post('TotalLoads'); 
			$LID = $this->generateRandomString();     
			if($AllocatedDateTime==""){ $AllocatedDateTime = date('Y-m-d H:i:s'); }
			$cond = array( 'BookingDateID' => $BookingDateID);
			$AllocatedLoads = $this->Common_model->select_count_where('tbl_booking_loads',$cond); 
			
			################################################
			
			if($TotalLoads != $AllocatedLoads){
				
				$Booking = $this->Booking_model->GetBookingInfo($BookingID);   
				$Driver = $this->Booking_model->getLorryNoDetails($DriverID);   
				$TicketID = 0;	 $TicketUniqueID = "";
				if($Booking->BookingType==2){
					//echo json_encode($Driver);
					
					$TicketUniqueID = $this->generateRandomString();                
					$TicketNumber = 1;
					$LastTicketNumber =  $this->Booking_model->LastTicketNo(); 
					if($LastTicketNumber){ 
						$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
					}  
					
					$ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID, 'TicketNumber'=>$TicketNumber, 'TicketDate'=>date('Y-m-d H:i:s'), 
					'OpportunityID'=> $Booking->OpportunityID, 'CompanyID'=>$Booking->CompanyID ,'DriverName'=>$Driver->DriverName, 
					'RegNumber'=>$Driver->RegNumber ,'Hulller'=>$Driver->Haulier ,'Tare'=>$Driver->Tare ,'driversignature'=>$Driver->ltsignature , 'driver_id'=>$DriverID, 
					'MaterialID'=>$Booking->MaterialID ,'SicCode'=>$Booking->SicCode, 'CreateUserID'=>$this->session->userdata['userId'] ,
					'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'Out', 'is_hold'=>1 ); 
					$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo); 					
					
				}
				################################################
				
				$LastConNumber =  $this->Booking_model->LastConNumber(); 
				if($LastConNumber){  
					$ConveyanceNo = $LastConNumber['ConveyanceNo']+1;  
				}else{
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));  
					$ConveyanceNo = $data['content']['ConveyanceStart']; 
				}   
				
				$LoadInfo = array('LID' => $LID, 'BookingID'=>$BookingID,'BookingDateID'=>$BookingDateID, 'ConveyanceNo'=>$ConveyanceNo, 'TicketID'=>$TicketID, 
				'TicketUniqueID'=>$TicketUniqueID, 'DriverID'=>$DriverID ,'DriverLoginID'=>$Driver->DriverID , 'MaterialID'=>$MaterialID ,'AllocatedDateTime'=>$AllocatedDateTime , 'TipID'=>$TipID , 
				'Status'=> 0 ,'AutoCreated'=> 1 , 'CreatedBy'=>$this->session->userdata['userId'] ); 
				$result1 = $this->Common_model->insert("tbl_booking_loads",$LoadInfo);  
				
				$Message = 'New load has been allocated';
				$this->Fcm_model->sendNotication($DriverID,$Message,'noti');
				
				if($Booking->BookingType==2){
					$ticketsInfo1 = array('LoadID'=>$result1, 'Conveyance'=>$ConveyanceNo, );   
					$cond = array( 'TicketNo' => $TicketID ); 
					$this->Common_model->update("tbl_tickets" , $ticketsInfo1, $cond); 
				}	
				
				################################################ 
				if($result1> 0) {  
					//if($Booking->LoadType == 2){ 
					//	$TO = $this->Booking_model->GetTurnaroundCount($BookingID);    		
					//	$Loads = $TO->DistinctLorry;
					//}
					if((int)$Loads>0){ (int)$Loads = (int)$Loads-1; }else{ (int)$Loads = 0; } 
					echo( json_encode(array('status'=>TRUE,'loads'=>$Loads,'BookingType'=>$Booking->BookingType,'BookingDateID'=>$BookingDateID,'BookingDate'=>$BookingDate  )) ); 
				}else { 
					echo(json_encode(array('status'=>FALSE))); 
				}
			}else{ 
				echo(json_encode(array('status'=>FALSE,))); 
			}	
            
        }
    }
	/* function AllocateBookingAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $BookingID = $this->input->post('BookingID');  
			$DriverID = $this->input->post('DriverID'); 
			$TipID = $this->input->post('TipID'); 
			$MaterialID = $this->input->post('MaterialID'); 
			$Loads = $this->input->post('Loads'); 
			$TotalLoads = $this->input->post('TotalLoads'); 
			$LID = $this->generateRandomString();     
			
			$cond = array( 'BookingID' => $BookingID);
			$AllocatedLoads = $this->Common_model->select_count_where('tbl_booking_loads',$cond); 
			
			if($TotalLoads != $AllocatedLoads){
				$LoadInfo = array('LID' => $LID, 'BookingID'=>$BookingID, 'DriverID'=>$DriverID , 'MaterialID'=>$MaterialID , 'TipID'=>$TipID , 
				'Status'=> 0 , 'CreatedBy'=>$this->session->userdata['userId'] );
				
				$result = $this->Common_model->insert("tbl_booking_loads",$LoadInfo); 
				if ($result > 0) { if($Loads>0){ $Loads = $Loads-1; }else{ $Loads = 0; } echo(json_encode(array('status'=>TRUE,'loads'=>$Loads,'totalloads'=>$TotalLoads,'BookingID'=>$BookingID))); }
				else { echo(json_encode(array('status'=>FALSE))); }
			}else{ 
				echo(json_encode(array('status'=>FALSE))); 
			}	
            
        }
    } */
	
	function ShowLoadsAJAX(){
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $BookingID = $this->input->post('BookingID');    
			 
			$data['Loads'] = $this->Booking_model->ShowLoads($BookingID); 
			//var_dump($data['Loads']);
			//exit; 
			$html = $this->load->view('Booking/LoadInfoAjax', $data, true);  
			echo json_encode($html); 
        }
    }
	
	function AJAXShowLoadsDetails(){
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $LoadID  = $this->input->post('LoadID');    
			 
			$data['Loads'] = $this->Booking_model->ShowLoadDetails($LoadID); 
			$data['Photos'] = $this->Booking_model->ShowLoadPhotos($LoadID); 
			
			//var_dump($data['Loads']);
			//exit; 
			//echo json_encode(var_dump($data['Loads'])); 
			//exit;
			//$html =  $LoadID." ==== ";
			//$html .=  var_dump($data['Loads']);
			//$html .=  var_dump($data['Photos']);
			$html = $this->load->view('Booking/AJAXLoadTimeline', $data, true);  
			echo json_encode($html); 
        }
    }
	
    function DeleteBooking(){
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $BookingID = $this->input->post('BookingNo');  
            $con = array('BookingID'=>$BookingID);            
            $result = $this->Common_model->delete('booking', $con); 
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    } 
	
	public function DriverLoads(){ 
        $data=array();  
		if($this->input->post('search')){
			$driver = $this->input->post('driver'); 
			$searchdate = $this->input->post('searchdate');  
			$data['searchdate'] = $searchdate;
			$data['DriverLoadsCollection'] = $this->Booking_model->GetDriverLoadsCollection($searchdate,$driver);  
			$data['DriverLoadsDelivery'] = $this->Booking_model->GetDriverLoadsDelivery($searchdate,$driver);  
			$data['DriverDetails'] = $this->Booking_model->GetDriverLoginDetails($driver);  			
		}	
		
		$data['DriverList'] = $this->Booking_model->DriverLoginList(); 
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Driver Loads Reports';
        $this->global['active_menu'] = 'driverloads';
        $this->loadViews("Booking/DriverLoads", $this->global, $data, NULL);
    }
	
    function DeleteLoad(){
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $LoadID = $this->input->post('LoadID');  
            $con = array('LoadID'=>$LoadID,'Status'=>'0');            
            $result = $this->Common_model->delete('booking_loads', $con); 
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	function CancelLoad()
    {
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $LoadID = $this->input->post('LoadID');  
			$Notes = $this->input->post('confirmation');  
			
			$ticketsInfo = array('Status'=>'5','CancelNote'=>$Notes);
			$con = array('LoadID'=>$LoadID);            
            $result = $this->Common_model->update("booking_loads",$ticketsInfo, $con); 
			
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }	
  
    function pageNotFound()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    } 
    function getMaterialList(){
        $type = $_POST['TicketType'];
        if($type=='In'){
        	$type='IN';
        }else{$type='OUT';}
        $result = $this->tickets_model->getMaterialList($type);
        $html='<option value="">-- Select material type--</option>';
        foreach ($result as $key => $value) {
           $html.="<option value='".$value->MaterialID."'>".$value->MaterialName."</option>";
        }
        echo $html;
  
    } 
    function getMaterialListDetails(){

        if($_POST){
             $id = $_POST['id'];
             $result = $this->tickets_model->getMaterialListDetails($id);
             $aray=array();
             if($result){
                $SicCode  = $result->SicCode;
                $price  = $result->price;
                $aray = array('SicCode' =>$SicCode ,'price'=>$price);
             }
             echo json_encode($aray);
        }
    }
  
    function getOpportunitiesList(){

       $result = $this->tickets_model->getOpportunitiesList();
        //print_r($result);
        $html='<option value="">-- Select Opportunity --</option>';
        foreach ($result as $key => $value) {
           $html.="<option value='".$value->OpportunityID."'>".$value->OpportunityName."</option>";
        }
       echo $html;  
    }
 

    function loadAllOpportunitiesByCompany(){

        $id = $_POST['id'];
        $result['Opportunity_list'] = $this->tickets_model->getAllOpportunitiesByCompany($id) ;           
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); }

    }

    function LoadMaterials(){

        $t = $_POST['id'];
		if($t =='1'){ $type = "IN"; }
		if($t =='2'){ $type = "OUT"; }
        $result['material_list'] = $this->Booking_model->getMaterialList($type);   		 
        if ($result > 0) { echo(json_encode($result)); }
        else { echo(json_encode(array('status'=>FALSE))); }

    }
	function LoadOpportunityContacts(){ 
        $id = $_POST['id'];
        $result['contact_list'] = $this->Booking_model->getContactsByOpportunity($id);           
		$result['OppDetails'] = $this->Booking_model->getOppoByID($id);           
		
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
    }
	function DisplayContactDetails(){ 
        $id = $_POST['id'];
        $result['contact'] = $this->Booking_model->getContactDetails($id) ;           
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
    }	
	 
	function BookingStageAtSite($LoadID){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            if($LoadID  == null){ redirect('Loads'); }           
			
			$conditions = array( 'LoadID ' => $LoadID );  
			$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo($LoadID);  
			if($data['LoadInfo']->Status!=1){ redirect('Loads'); }
			 
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				
				$SiteInDateTime =date("Y-m-d H:i:s");
				$Notes1	 = $this->security->xss_clean($this->input->post('Notes1'));  
				$GrossWeight	 = $this->security->xss_clean($this->input->post('GrossWeight'));  
				$TipNumber	 = $this->security->xss_clean($this->input->post('TipNumber'));  
				
				$LoadInfo = array('SiteInDateTime'=>$SiteInDateTime,'Notes1'=>$Notes1, 
				'GrossWeight'=>$GrossWeight, 'TipNumber'=>$TipNumber, 'Status' => 2 );
				$cond = array( 'LoadID ' => $LoadID  );  
				$update = $this->Common_model->update("tbl_booking_loads", $LoadInfo, $cond);
				if($update){  
					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');                
				}else{
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');                
				} 
				redirect('Loads'); 
			}  
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Booking Stage Update to Reach / At Site';
            $this->global['active_menu'] = 'loads';
            
            $this->loadViews("Booking/BookingStageAtSite", $this->global, $data, NULL);
        }
    } 
	function BookingStageLeftSite($LoadID){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            if($LoadID  == null){ redirect('Loads'); }           
			
			$conditions = array( 'LoadID ' => $LoadID );  
			$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo($LoadID);  
			if($data['LoadInfo']->Status!=2){ redirect('Loads'); }
			 
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				 
				$SiteOutDateTime =date("Y-m-d H:i:s");
				$Notes2	 = $this->security->xss_clean($this->input->post('Notes2'));  
				$CustomerName	 = $this->security->xss_clean($this->input->post('CustomerName'));  
				$Signature = $this->input->post('Signature', FALSE); 
				if($Signature!=""){  
					$Signature1 = str_replace('data:image/png;base64,', '', $Signature);
					$Signature1 = str_replace(' ', '+', $Signature1); 
					$Signature1 = base64_decode($Signature1);
					
					$Signature = md5(date("dmYhisA")).".png"; 
					$file_name = './uploads/Signature/'.$Signature;
					file_put_contents($file_name,$Signature1); 
				}else{
					$Signature = "";
				}
				$TicketUniqueID =  $this->generateRandomString(); 
				 
				$LoadInfo = array('SiteOutDateTime'=>$SiteOutDateTime,'Notes2'=>$Notes2, 'ReceiptName'=>$TicketUniqueID.".pdf",
				'Signature'=>$Signature,'CustomerName'=>$CustomerName, 'Status' => 3 );
				$cond = array( 'LoadID ' => $LoadID  );  
				$update = $this->Common_model->update("tbl_booking_loads", $LoadInfo, $cond);
				if($update){
					 
					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result(); 
					
					if($data['LoadInfo']->BookingType==1){ 	
						
						$LastTicketNumber =  $this->tickets_model->LastTicketNo();
						if($LastTicketNumber){ 
							$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
						} else { $TicketNumber = 1; }
						
						$ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID, 'LoadID'=>$LoadID, 'TicketNumber'=>$TicketNumber, 
						'TicketDate'=>date('Y-m-d H:i:s'), 'Conveyance'=> $data['LoadInfo']->ConveyanceNo,
						'OpportunityID'=> $data['LoadInfo']->OpportunityID, 
						'CompanyID'=>$data['LoadInfo']->CompanyID ,
						'DriverName'=> $data['LoadInfo']->DriverName,
						'RegNumber'=>$data['LoadInfo']->VehicleRegNo,
						'Hulller'=> $data['LoadInfo']->Haulier,
						'Tare'=> $data['LoadInfo']->Tare , 
						'driver_id'=> $data['LoadInfo']->DriverID, 
						'DriverLoginID'=>$data['LoadInfo']->DriverLoginID,  
						'MaterialID'=> $data['LoadInfo']->MaterialID,
						'SicCode'=> $data['LoadInfo']->SicCode, 
						'CreateUserID'=>1,
						'CreateDate'=>date('Y-m-d H:i:s'),
						'TypeOfTicket'=>'In', 
						'IsInBound'=>1,
						'pdf_name'=>$TicketUniqueID.'.pdf');
						
						$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
						
								
						
						$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
							<div style="width:100%; " >
								<div style="width:35%;float: left;" > 		
									<img src="/assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="80"> 
								</div>
								<div style="width:65%;float: right;text-align: right;" > 		 
									<b>'.$PDFContent[0]->outpdf_title.'</b><br/> 		
									'.$PDFContent[0]->address.' <br/> 
									<b>Phone:</b> '.$PDFContent[0]->outpdf_phone.' 											
								</div>
							</div>	
							<div style="width:100%;float: left;" >   
								<b>Email:</b> '.$PDFContent[0]->email.' <br/>		
								<b>Web:</b> '.$PDFContent[0]->website.' <br/>		  
								<b>Waste License No: </b>'.$PDFContent[0]->waste_licence.' <br/> 
								<b>Permit Reference No: </b>'.$data['LoadInfo']->PermitRefNo.' <br/><hr>
								<b>'.$PDFContent[0]->head1.'</b><br/> <br>
								<b>'.$PDFContent[0]->head2.'</b><br/> <br>
								<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
								<b>Conveyance Note No:</b> '.$data['LoadInfo']->ConveyanceNo.'<br>		
								<b>Date Time: </b>'.date("d-m-Y H:i").' <br>		 
								<b>Company Name: </b> '.$data['LoadInfo']->CompanyName.' <br>		
								<b>Site Address: </b> '.$data['LoadInfo']->OpportunityName.'<br>		 		
								<b>Tip Address: </b> '.$data['LoadInfo']->Street1.' '.$data['LoadInfo']->Street1.' '.$data['LoadInfo']->Town.' '.$data['LoadInfo']->County.' '.$data['LoadInfo']->PostCode.'<br>		 		 
								<b>Material: </b> '.$data['LoadInfo']->MaterialName.'  <br> 
								<b>SicCode: </b> '.$data['LoadInfo']->SicCode.'  <br>  
								<b>Vehicle Reg. No. </b> '.$data['LoadInfo']->VehicleRegNo.'  <br> 
								<b>Driver Name: </b> '.$data['LoadInfo']->DriverName.'<br> <br/>   
							</div>
							<div><img src="/assets/DriverSignature/'.$data['LoadInfo']->dsignature.'" width ="100" height="40" style="float:left"> </div>  <br> 
							<div style="width:100%;float: left;" >
								<b>Produced By: </b><br>
								<div><img src="/uploads/Signature/'.$Signature.'" width ="100" height="40" style="float:left"></div>
								'.$data['LoadInfo']->CustomerName.'<br><br>
								<div style="font-size: 9px;"> 
									<b>VAT Reg. No: </b> '.$PDFContent[0]->VATRegNo.' <br>
									<b>Company Reg. No: </b> '.$PDFContent[0]->CompanyRegNo.' <br>  
									'.$PDFContent[0]->FooterText.'  
								</div>
							</div>  
						</div></body></html>'; 
				
						$pdfFilePath = WEB_ROOT_PATH."/assets/conveyance/".$TicketUniqueID.'.pdf'; 
						
						$mpdf =  new mPDF('utf-8', array(70,180),'','',5,5,5,5,5,5);
						//$mpdf->_setPageSize(array(70,180),'P');
						//$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
						//$mpdf->AddPage();
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);
						 
					}	
					
					if($data['LoadInfo']->BookingType==2){ 	
                                  
						$data1['tickets'] = $this->Booking_model->BookingTicketInfo($data['LoadInfo']->TicketID); 
						
						$html =  '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
						<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
							<div style="width:100%;" ><div style="width:35%;float: left;" >
							<img src="/assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="80" ></div> 
								<div style="width:65%;float: right;text-align: right;" > 		  
									<b>'.$PDFContent[0]->outpdf_title.'</b><br/>'.$PDFContent[0]->outpdf_address.'<br/> 		 
									<b>Phone:</b> '.$PDFContent[0]->outpdf_phone.'
								</div> 
							</div>	 
							<div style="width:100%;float: left;" >    
								<b>Email:</b> '.$PDFContent[0]->outpdf_email.'<br/>		 
								<b>Web:</b> '.$PDFContent[0]->outpdf_website.' <br/>		 
								<b>Waste License No: </b> '.$PDFContent[0]->waste_licence.' <br/><hr> 
								<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
								<b>Ticket NO:</b> '.$data1['tickets']['TicketNumber'].' <br>		 
								<b>Date Time: </b> '.$data1['tickets']['tdate'].' <br>		   
								<b>Vehicle Reg. No. </b> '.$data1['tickets']['RegNumber'].' <br> 
								<b>Haulier: </b> '.$data1['tickets']['Hulller'].' <br> 
								<b>Driver Name: </b> '.$data['LoadInfo']->DriverName.'<br> 
								<b>Driver Signature: </b> <br> 
								<div><img src="/assets/DriverSignature/'.$data['LoadInfo']->dsignature.'" width ="100" height="40" style="float:left"> </div>
								<b>Company Name: </b> '.$data1['tickets']['CompanyName'].' <br>		 
								<b>Site Address: </b> '.$data1['tickets']['OpportunityName'].' <br>	 
								<b>Material: </b> '.$data1['tickets']['MaterialName'].' <br> 
								<b>SIC Code: </b> '.$data1['tickets']['SicCode'].' <br> 
								<b>Gross Weight: </b> '.round($data1['tickets']['GrossWeight']).' KGs <br>		 
								<b>Tare Weight: </b> '.round($data1['tickets']['Tare']).' KGs <br>		 
								<b>Net Weight: </b> '.round($data1['tickets']['Net']).' KGs <br> 
								<p style="font-size: 7px;"> '.$PDFContent[0]->outpdf_para1.' <br>  
								'.$PDFContent[0]->outpdf_para2.'<br>  
								<b>'.$PDFContent[0]->outpdf_para3.'</b></p></div> 
							<div style="width:100%;float: left;" > 
								<b>Received By: </b><br> 
								<div><img src="/uploads/Signature/'.$Signature.'" width ="100" height="40" style="float:left"></div> 
								'.$data['LoadInfo']->CustomerName.' 
								<p style="font-size: 7px;"><b> '.$PDFContent[0]->outpdf_para4.'</b><br><br> 
									<b>VAT Reg. No: </b> '.$PDFContent[0]->VATRegNo.'<br> 
									<b>Company Reg. No: </b>'.$PDFContent[0]->CompanyRegNo.'<br>
									'.$PDFContent[0]->FooterText.'</p></div></div></body></html>';
						
						$pdfFilePath =  WEB_ROOT_PATH."/assets/conveyance/".$TicketUniqueID.".pdf"; 		   
						$mpdf =  new mPDF('utf-8', array(70,210),'','',5,5,5,5,5,5);	   
						$mpdf->keep_table_proportions = false;
						$mpdf->WriteHTML($html);
						$mpdf->Output($pdfFilePath);
								 
                    } 
					 
					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');                
				}else{
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');                
				} 
				  
				redirect('Loads'); 
			}  
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Booking Stage Update to Left Site';
            $this->global['active_menu'] = 'loads';
            
            $this->loadViews("Booking/BookingStageLeftSite", $this->global, $data, NULL);
        }
    } 
	function BookingStageFinishLoad($LoadID){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            if($LoadID  == null){ redirect('Loads'); }           
			
			$conditions = array( 'LoadID ' => $LoadID );  
			$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo($LoadID);  
			if($data['LoadInfo']->Status!=3){ redirect('Loads'); }
			 
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				 
				$JobEndDateTime =date("Y-m-d H:i:s");
				$Notes	 = $this->security->xss_clean($this->input->post('Notes'));  
				$GrossWeight	 = $this->security->xss_clean($this->input->post('GrossWeight'));  
				$TipNumber	 = $this->security->xss_clean($this->input->post('TipNumber'));  
				
				$LoadInfo = array('JobEndDateTime'=>$JobEndDateTime,'Notes'=>$Notes, 'Status' => 4 ,
				'GrossWeight'=>$GrossWeight, 'TipNumber'=>$TipNumber );
				$cond = array( 'LoadID ' => $LoadID  );  
				$update = $this->Common_model->update("tbl_booking_loads", $LoadInfo, $cond);
				if($update){   
					if(isset($_POST['continue']))  {	  
						$TicketID = 0;	 $TicketUniqueID = "";
						
						$LID = $this->generateRandomString();     
						
						$BDate = date('Y-m-d');
						$insertBookingDate = $this->db->query("insert into tbl_booking_date(BookingID,BookingDate) value('".$data['LoadInfo']->BookingID."','".$BDate."')");
						$BookingDateID = $this->db->insert_id();
						
						$LastConNumber =  $this->Booking_model->LastConNumber(); 
						$LConveyanceNo = $LastConNumber['ConveyanceNo']+1;
						
						$LoadInfo = array('LID' => $LID, 
						'BookingID'=>$data['LoadInfo']->BookingID,
						'BookingDateID'=>$BookingDateID, 
						'ConveyanceNo'=>$LConveyanceNo,  
						'DriverID'=>$data['LoadInfo']->DriverID ,
						'DriverLoginID'=>$data['LoadInfo']->DriverLoginID , 
						'MaterialID'=>$data['LoadInfo']->MaterialID ,
						'AllocatedDateTime'=> date('Y-m-d H:i:s'), 
						'TipID'=>$data['LoadInfo']->TipID , 
						'Status'=> 0 ,
						'AutoCreated'=> 0 , 
						'CreatedBy'=> $this->session->userdata['userId'] ); 
						$result1 = $this->Common_model->insert("tbl_booking_loads",$LoadInfo); 
						
						if($data['LoadInfo']->LoadType==2){ 							
							$TicketUniqueID = $this->generateRandomString();                
							$TicketNumber = 1;
							$LastTicketNumber =  $this->Booking_model->LastTicketNo(); 
							if($LastTicketNumber){ 
								$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
							}  
							
							$ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID, 'TicketNumber'=>$TicketNumber, 'TicketDate'=>date('Y-m-d H:i:s'), 
							'LoadID'=>$result1, 'Conveyance'=>$LConveyanceNo,
							'OpportunityID'=> $data['LoadInfo']->OpportunityID, 'CompanyID'=>$data['LoadInfo']->CompanyID ,'DriverName'=>$data['LoadInfo']->lorry_driver_name, 
							'RegNumber'=> $data['LoadInfo']->lorry_RegNumber  ,'Hulller'=> $data['LoadInfo']->Haulier ,'Tare'=> $data['LoadInfo']->lorry_tare ,
							'driversignature'=> $data['LoadInfo']->lorry_signature , 'driver_id'=> $data['LoadInfo']->DriverID , 
							'MaterialID'=> $data['LoadInfo']->MaterialID ,'SicCode'=>$data['LoadInfo']->SicCode, 'CreateUserID'=>$this->session->userdata['userId'] ,
							'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'Out', 'is_hold'=>1 ); 
							$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo); 					
							
							$LoadInfo1 = array('TicketID'=>$TicketID,'TicketUniqueID'=>$TicketUniqueID );
							$cond1 = array( 'LoadID' => $result1  );  
							$update1 = $this->Common_model->update("tbl_booking_loads", $LoadInfo1, $cond1);
						}
 					}	
				
					$this->session->set_flashdata('success', 'Booking stage has been updated successfully');                
				}else{
					$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');                
				}  
				redirect('Loads'); 
			}  
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Booking Stage Update to Finish Load';
            $this->global['active_menu'] = 'loads';
            
            $this->loadViews("Booking/BookingStageFinishLoad", $this->global, $data, NULL);
        }
    } 
    function generateRandomString($length = 12) {
		return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
}

?>
