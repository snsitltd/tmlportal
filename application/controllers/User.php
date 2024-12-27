<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class User extends BaseController
{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
    
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model('user_model');
        
        require_once(APPPATH.'third_party/fpdf17/fpdf.php');
        require_once(APPPATH.'third_party/FPDI/fpdi.php');
        
        $this->isLoggedIn();  
        $roleCheck = $this->Common_model->checkpermission('user');
        $this->load->library("excel");
         $this->global['isView'] = $this->isView = $roleCheck->view;   
         $this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
         $this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
         $this->global['isDelete'] = $this->isDelete = $roleCheck->delete;
         $this->global['active_menu'] = 'dashboard';          

    }
    
    /**
     * This function used to load the first screen of the user
     */
   public function index()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Dashboard';
        $this->global['active_menu'] = 'dashboard';
        
		//$data['contact_count'] = $this->Common_model->select_count('contacts') ; 
		$data['contact_count'] = $this->Common_model->CountContacts() ; 
        
		//$data['company_count'] = $this->Common_model->select_count('company') ; 
		$data['company_count'] = $this->Common_model->CountCompany() ; 
		
//        $data['ticket_count'] = $this->Common_model->select_count('tickets') ; 
        $data['ticket_count'] = $this->Common_model->CountTicket(); 
		
        $data['ticket_limit_company'] = $this->Common_model->getTicketLimitCompanyList();   
		$data['new_company'] = $this->Common_model->getRecentlyAddedSites() ; 
		$data['new_company1'] = $this->Common_model->getRecentlyAddedCompany() ; 
		
		
		$SearchDate = date("Y-m-d"); 
		
        $data['TodayPDAUsers'] = $this->Common_model->TodayPDAUsers($SearchDate); 
         
		
	//	$data['TodayPDFUsers'] = $this->Common_model->TodayPDFUsers() ; 
		//var_dump($data['ticket_limit_company']);
		//exit;

        $data['user_count'] = $this->user_model->userListingCount() ;  
        //$data['contact_count'] = $this->Common_model->select_count('contacts') ; 
        $this->loadViews("dashboard", $this->global,  $data, NULL);
		//$this->output->enable_profiler(TRUE);

    }
    
    /**
     * This function is used to load the user list
     */
    function userListing()
    {

        //echo date(DATE_FORMATE,strtotime("2019-05-07")); die;
        
        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;            
            $data['userRecords'] = $this->user_model->userListing($searchText);
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : User Listing';  
            $this->global['active_menu'] = 'userListing';         
            
            $this->loadViews("Users/users", $this->global, $data, NULL);
        }
    }
	public function ExecutiveSummary(){
        
        $data=array();

		if($this->input->post('search')){ 
			//$searchdate = $this->input->post('searchdate');  
			$B = explode('/',$this->input->post('SearchDate'));
			$SearchDate	 = $B[2]."-".$B[1]."-".$B[0] ;  
		}else{	 
			$SearchDate = date("Y-m-d");
		}
		$data['SearchDate'] = $SearchDate; 
		
        $data['TodayPDAUsers'] = $this->Common_model->TodayPDAUsers($SearchDate);   
		$data['TodayBooking'] = $this->Common_model->TodayBooking($SearchDate);   
		$data['TodayBookingOpportunity'] = $this->Common_model->TodayBookingOpportunity($SearchDate);   
		
		$data['TodayBookingMaterial'] = $this->Common_model->TodayBookingMaterial($SearchDate);   
		$data['TodayBookingDriver'] = $this->Common_model->TodayBookingDriver($SearchDate);   
		
		
		$data['TodayTotalJobsAllocated'] = $this->Common_model->TodayTotalJobsAllocated($SearchDate);   
		$data['TodayTotalJobsFinished'] = $this->Common_model->TodayTotalJobsFinished($SearchDate);   
		$data['TodayTotalJobsCancelled'] = $this->Common_model->TodayTotalJobsCancelled($SearchDate);   
		$data['TodayTotalJobsWasted'] = $this->Common_model->TodayTotalJobsWasted($SearchDate);   
		
		 
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Executive Summary';
        $this->global['active_menu'] = 'executivesummary';
        $this->loadViews("Users/ExecutiveSummary", $this->global, $data, NULL);
    }
    public function ExecutiveSummaryDriverList(){
        
        $data=array();

		if($this->input->post('search')){ 
			//var_dump($_POST);
				$searchdate = $this->input->post('searchdate');
				$searchdates= explode('-', $searchdate); 
		
				$f = explode('/',$searchdates[0]);
				$FirstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
				$s = explode('/',$searchdates[1]); 
				$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
		  
		}else{	 
			$FirstDate = date("Y-m-d");
			$SecondDate = date("Y-m-d"); 
		 
		}
		
				if(isset($_POST['export']))  {
					$searchdate = $this->input->post('searchdate');
					$searchdates= explode('-', $searchdate); 
			
					$f = explode('/',$searchdates[0]);
					$FirstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
					$s = explode('/',$searchdates[1]); 
					$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
					
                   $object = new PHPExcel();
					//print_r($_POST); 
					//exit;
                    $object->setActiveSheetIndex(0); 
                    $table_columns = array("Driver Name	","Collection", "Delivery", "DayWork","Haulage","Wasted", "Cancel", "Total");  
					
					$column = 0;  
					$object->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold( true );	
                    $object->getActiveSheet()->setCellValueByColumnAndRow(0, 1, "Loads Done By Driver During ( ".$searchdates[0]." - ".$searchdates[1]." ) ");  
					
					foreach($table_columns as $field){
						$object->getActiveSheet()->getStyle('A2:H2')->getFont()->setBold( true );	
                        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 2, $field);
                        $column++;
                    }
					
                    $excel_row = 3; 
		
							$data['TodayBookingDriver1'] = $this->Common_model->TodayBookingDriver1($FirstDate,$SecondDate);    
							$count = count($data['TodayBookingDriver1']);
							
							if(count($data['TodayBookingDriver1'])>0){ 
							
							$i = 1; $TCollection = 0; $TDelivery = 0; $TDayWork = 0; $THaulage = 0;  $TWasted = 0; $TCancel = 0; 
							
							foreach( $data['TodayBookingDriver1'] as $row){ 

								$TCollection = $TCollection + $row['TotalCollection']; 
								$TDelivery = $TDelivery + $row['TotalDelivery']; 
								
								$TDayWork = $TDayWork + $row['TotalDayWork']; 
								$THaulage = $THaulage + $row['TotalHaulage']; 
								
								$TWasted = $TWasted + $row['TotalWasted']; 
								$TCancel = $TCancel + $row['TotalCancel'];  
								
								$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['DriverName']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['TotalCollection']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['TotalDelivery']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['TotalDayWork']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['TotalHaulage']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['TotalWasted']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['TotalCancel']);
								$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['TotalCollection']+$row['TotalDelivery']+$row['TotalDayWork']+$row['TotalHaulage']+$row['TotalWasted']+$row['TotalCancel']); 

								$excel_row++;
								$i++;
								
							}
								$object->getActiveSheet()->getStyle('A'.$excel_row.':H'.$excel_row.'')->getFont()->setBold( true );	
								$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "Grand Total");
								$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $TCollection);
								$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $TDelivery);
								$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $TDayWork);
								$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $THaulage);
								$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $TWasted);
								$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $TCancel);
								$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $TCollection+$TDelivery+$TDayWork+$THaulage+$TWasted+$TCancel); 
	
								$excel_row++;	 
									
							}
				 
					for ($i = 'A'; $i !=  $object->getActiveSheet()->getHighestColumn(); $i++) {
						$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
					}
                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="DriverLoadList.xls"');
                    $object_writer->save('php://output');
                    exit; 
             }
			 if(isset($_POST['export1']))  { 

				$searchdate = $this->input->post('searchdate');
				$searchdates= explode('-', $searchdate); 
		
				$f = explode('/',$searchdates[0]);
				$FirstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
				$s = explode('/',$searchdates[1]); 
				$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
				  
				$data['TodayBookingDriver1'] = $this->Common_model->TodayBookingDriver1($FirstDate,$SecondDate);    
				
				$data['title'] = "Loads Done By Driver During  ".$searchdates[0]." - ".$searchdates[1]."  ";
				 
				 $html=$this->load->view('Users/DriverLoadList_pdf', $data, true);
			  
				//this the the PDF filename that user will get to download 
				//load mPDF library
				$this->load->library('m_pdf'); 
				//generate the PDF from the given html
				$this->m_pdf->pdf->setFooter('<div align="left">Page {PAGENO} of {nbpg}</div>');

				$this->m_pdf->pdf->AddPage('P'); // Adds a new page in Landscape orientation
				$this->m_pdf->pdf->WriteHTML($html); 
//				echo $html;

				//download it.
				$this->m_pdf->pdf->Output("DriverLoadList.pdf", "D");  
                     
             }
			 
			 
			 
		$data['FirstDate'] = $FirstDate;
		$data['SecondDate'] = $SecondDate;
		//$data['SearchDate'] = $SearchDate; 
		//$data['SearchDate1'] = $searchdates[0]; 
		//$data['SearchDate2'] = $searchdates[1]; 		
		
		$data['TodayBookingDriver1'] = $this->Common_model->TodayBookingDriver1($FirstDate,$SecondDate);   
		  
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Loads Done By Driver';
        $this->global['active_menu'] = 'executivesummarydriverlist';
        $this->loadViews("Users/ExecutiveSummaryDriverList", $this->global, $data, NULL);
		//$this->output->enable_profiler(TRUE);

    }
	public function PDAUsers(){
        
        $data=array();

		if($this->input->post('search')){ 
			//$searchdate = $this->input->post('searchdate');  
			$B = explode('/',$this->input->post('SearchDate'));
			$SearchDate	 = $B[2]."-".$B[1]."-".$B[0] ;  
		}else{	 
			$SearchDate = date("Y-m-d");
		}
		$data['SearchDate'] = $SearchDate; 
		
        $data['TodayPDAUsers'] = $this->Common_model->TodayPDAUsers($SearchDate);   
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : PDA Users';
        $this->global['active_menu'] = 'pdausers';
        $this->loadViews("Users/PDAUsers", $this->global, $data, NULL);
    }
	function LogOutDriver()
    {
         
		$LogID = $this->input->post('LogID');  
		$DT = date("Y-m-d H:i:s");
		$DT1 = date("d-m-Y H:i:s");
		$LogInfo = array('LogoutDateTIme'=>$DT);
		$con = array('LogID'=>$LogID);             
		$result = $this->Common_model->update("tbl_drivers_logs",$LogInfo, $con);     

		if ($result > 0) { echo(json_encode(array('status'=>TRUE,'LogoutDateTIme'=>$DT1,'LogID'=>$LogID))); }
		else { echo(json_encode(array('status'=>FALSE))); }
        
    }
    function addNew()
    {
        

        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New User'; 
            $this->global['active_menu'] = 'adduser';
            $this->loadViews("Users/addNew", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('addNew');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {

        

        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit User';
            $this->global['active_menu'] = 'edituser';
            $this->loadViews("Users/editOld", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = $this->security->xss_clean($this->input->post('email'));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('userListing');
            }
        }
    }


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isDelete == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Change Password';
        
        $this->loadViews("changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('loadChangePass');
            }
        }
    }

    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL)
    {
        
            $this->global['active_menu'] = 'dashboard';
            $userId = ($userId == NULL ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "login-history/".$userId."/", $count, 10, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : User Login History';
            
            $this->loadViews("loginHistory", $this->global, $data, NULL);
               
    }
}

?>
