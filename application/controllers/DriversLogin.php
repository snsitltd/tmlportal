<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Contacts (contactController)
 * User Class to control all user related operations.
 * @author : Vikash R
 * @version : 1.0
 * @since : 10 Aug 2018
 */
class DriversLogin extends BaseController
{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('drivers_model');       
        $this->isLoggedIn(); 

        $roleCheck = $this->Common_model->checkpermission('drivers'); 

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
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Drivers Listing';
            $this->global['active_menu'] = 'driverslogin';             
            $this->loadViews("DriversLogin/DriversLogin", $this->global, $data, NULL);
        }
    } 
    public function AJAXDriversLogin(){  
		$this->load->library('ajax');
		$data = $this->drivers_model->GetDriverLoginData();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	
	public function DriversLoginDeleted(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{             
            $data = array();     
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Deleted Drivers Listing';
            $this->global['active_menu'] = 'driverslogin';             
            $this->loadViews("DriversLogin/DriversLoginDeleted", $this->global, $data, NULL);
        }
    } 
    public function AJAXDriversLoginDeleted(){  
		$this->load->library('ajax');
		$data = $this->drivers_model->GetDriverLoginDataDeleted();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}	
	
	 
    public function Subcontractor(){
       // if($this->isView == 0){
        //    $data = array();
        //    $this->global['pageTitle'] = 'Error';             
        //    $this->loadViews("permission", $this->global, $data, NULL);
        //}else{          
            $data = array(); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Subcontractor List';
            $this->global['active_menu'] = 'subcontractor';            
            $this->loadViews("DriversLogin/Subcontractor", $this->global, $data, NULL);
       // }
    }    
	public function AJAXSubcontractor(){  
		$this->load->library('ajax');
		$data = $this->drivers_model->GetSubcontractorData();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	function addSubcontractor(){
        //if($this->isAdd == 0){
        //   $data = array();
        //    $this->global['pageTitle'] = 'Error';             
        //    $this->loadViews("permission", $this->global, $data, NULL);
        //}else{    
			if ($this->input->server('REQUEST_METHOD') == 'POST'){    
				$this->load->library('form_validation');
				$this->form_validation->set_rules('CompanyName','Company Name','trim|required|max_length[128]');              
				$this->form_validation->set_rules('Lorry','Total Lorry','trim|required|max_length[3]');              
				 	
				if($this->form_validation->run()){   
					$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
					$Email = $this->security->xss_clean($this->input->post('Email'));                
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$Postcode = $this->security->xss_clean($this->input->post('Postcode'));
					$Phone = $this->security->xss_clean($this->input->post('Phone'));
					$Mobile = $this->security->xss_clean($this->input->post('Mobile'));  
					$Lorry = $this->security->xss_clean($this->input->post('Lorry'));  
					
					$companyInfo = array('CompanyName'=>$CompanyName, 'Email'=>$Email, 'Street1'=> $Street1,
					'Street2'=>$Street2 ,'Town'=>$Town ,'County'=>$County ,'Postcode'=>$Postcode ,'Phone'=>$Phone ,'Mobile'=>$Mobile ,
					'CreateUserID'=>$this->session->userdata['userId'] ,'EditUserID'=> $this->session->userdata['userId']); 
					$result = $this->Common_model->insert("tbl_driver_subscontractor",$companyInfo);  
					if($result){
						for($i=1;$i<=$Lorry;$i++){
							$LorryInfo = array('DriverName'=>$CompanyName, 'AppUser'=>1 , 'ContractorID'=>$result, 'ContractorLorryNo'=>$i ,
							'CreateUserID'=>$this->session->userdata['userId'] ,'EditUserID'=> $this->session->userdata['userId']); 
							$lr = $this->Common_model->insert("tbl_drivers",$LorryInfo);  
						}	
					}		
					$this->session->set_flashdata('success', 'New subcontractor has been created successfully');                
					redirect('Subcontractor');
				} 
			}	
			$data['county'] = $this->drivers_model->getCounty();
			$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add Subcontractor';
            $this->global['active_menu'] = 'addsubcontractor';

            $this->loadViews("DriversLogin/addSubcontractor", $this->global, $data, NULL);
        //}
    }
	function EditSubcontractor($id){
		$data = array();
    	//if($this->isEdit == 0){
        //    $data = array();
        //    $this->global['pageTitle'] = 'Error';             
        //    $this->loadViews("permission", $this->global, $data, NULL);
        //}else{    
		
			if($id == null) { redirect('Subcontractor'); }          
			$data['subcontractor'] = $this->drivers_model->SubcontractorDetails($id);
			$cond1 = array( 'ContractorID' => $id );
			$data['TotalNoLorry'] = $this->Common_model->select_count_where('tbl_drivers',$cond1); 
			if ($this->input->server('REQUEST_METHOD') == 'POST'){  	 
					$this->load->library('form_validation'); 
					$ContractorID = $this->input->post('ContractorID');  
					$this->form_validation->set_rules('CompanyName','Company Name','trim|required|max_length[128]'); 
					if($this->form_validation->run()){ 
						
						$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
						$Email = $this->security->xss_clean($this->input->post('Email'));                
						$Street1 = $this->security->xss_clean($this->input->post('Street1'));
						$Street2 = $this->security->xss_clean($this->input->post('Street2'));
						$Town = $this->security->xss_clean($this->input->post('Town'));
						$County = $this->security->xss_clean($this->input->post('County'));
						$Postcode = $this->security->xss_clean($this->input->post('Postcode'));
						$Phone = $this->security->xss_clean($this->input->post('Phone'));
						$Mobile = $this->security->xss_clean($this->input->post('Mobile'));    
						$Lorry = $this->security->xss_clean($this->input->post('Lorry'));  
						
						$companyInfo = array('CompanyName'=>$CompanyName, 'Email'=>$Email, 'Street1'=> $Street1,
						'Street2'=>$Street2 ,'Town'=>$Town ,'County'=>$County ,'Postcode'=>$Postcode ,'Phone'=>$Phone ,'Mobile'=>$Mobile ,
						'EditUserID'=> $this->session->userdata['userId']); 
						$cond = array( 'ContractorID' => $ContractorID );
						$this->Common_model->update("tbl_driver_subscontractor",$companyInfo, $cond);                 
						
						if($Lorry!="" && $Lorry!=0 ){		
							for($i=$data['TotalNoLorry']+1;$i<=$data['TotalNoLorry']+$Lorry;$i++){
								$LorryInfo = array('DriverName'=>$CompanyName, 'AppUser'=>1 , 'ContractorLorryNo'=>$i ,'ContractorID'=> $ContractorID, 
								'CreateUserID'=>$this->session->userdata['userId'] ,'EditUserID'=> $this->session->userdata['userId']); 
								$this->Common_model->insert("tbl_drivers",$LorryInfo);  
							}	
						} 
						
						$this->session->set_flashdata('success', 'Contractor has been updated successfully');                
						redirect('Subcontractor'); 
					}  
			}  
			
			$data['county'] = $this->drivers_model->getCounty();
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Subcontractor ';
            $this->global['active_menu'] = 'editsubcontractor';

            $this->loadViews("DriversLogin/EditSubcontractor", $this->global, $data, NULL);
       // }
    }
	
    function addDriverLogin(){
		$data = array();
        if($this->isAdd == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            $this->load->model('user_model');        
			
			if ($this->input->server('REQUEST_METHOD') == 'POST'){  		
					$this->load->library('form_validation');  
					$this->form_validation->set_rules('DriverName','DriverName','trim|required|max_length[128]'); 
					$this->form_validation->set_rules('MobileNo','MobileNo','trim|required|numeric|max_length[11]|min_length[11]');    
					//$this->form_validation->set_rules('MobileNo','MobileNo','trim|required|numeric|max_length[11]|min_length[11]|callback_mobilekey_exists');    
					$this->form_validation->set_rules('UserName','UserName','trim|required|max_length[20]|min_length[4]|callback_usernamekey_exists');    
					 
					if($this->form_validation->run()){  
						$DriverName = $this->security->xss_clean($this->input->post('DriverName'));   
						$MobileNo = $this->security->xss_clean($this->input->post('MobileNo'));   
						$UserName = $this->security->xss_clean($this->input->post('UserName'));   
						$Email = $this->security->xss_clean($this->input->post('Email'));   
						$ltsignature = $this->input->post('ltsignature', FALSE); 
						if($ltsignature!=""){  
							$ltsignature1 = str_replace('data:image/png;base64,', '', $ltsignature);
							$ltsignature1 = str_replace(' ', '+', $ltsignature1); 
							$ltsignature1 = base64_decode($ltsignature1);
							
							$Signature = md5(date("dmYhisA")).".png"; 
							$file_name = './assets/DriverSignature/'.$Signature;
							file_put_contents($file_name,$ltsignature1); 
						}else{
							$Signature = "";
						}	
						$DriverInfo = array('ltsignature'=>$ltsignature,'Signature'=>$Signature, 'UserName'=>$UserName,'MobileNo'=>$MobileNo,'DriverName'=>$DriverName, 'Status'=>0, 
						'Email'=>$Email, 'CreateUserID'=>$this->session->userdata['userId'], 'EditUserID'=>$this->session->userdata['userId']  );  
						 
						$result = $this->Common_model->insert("tbl_drivers_login",$DriverInfo); 
						if($result){
							$this->session->set_flashdata('success', 'New Profile Inserted successfully');                
						}else{
							$this->session->set_flashdata('error', 'Please Try AGain Later.');                	
						}	
						redirect('DriversLogin'); 
					}  
					 
			} 
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New Driver Login';
            $this->global['active_menu'] = 'adddriverlogin';

            $this->loadViews("DriversLogin/addDriverLogin", $this->global, $data, NULL);
        }
    }
	 
	function editDriverProfile($id){
		$data = array();
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
		
			if($id == null) { redirect('Drivers'); }          
			$data['driver'] = $this->drivers_model->DriverDetails($id);
			 
			if ($this->input->server('REQUEST_METHOD') == 'POST'){  	 
					$this->load->library('form_validation'); 
					$DriverID = $this->input->post('DriverID');  
					$this->form_validation->set_rules('DriverName','DriverName','trim|required|max_length[128]');
					//if($data['driver']['MobileNo'] != $this->input->post('MobileNo')){
						//$this->form_validation->set_rules('MobileNo','MobileNo','trim|required|numeric|max_length[11]|min_length[11]|callback_mobilekey_exists');   
						$this->form_validation->set_rules('MobileNo','MobileNo','trim|required|numeric|max_length[11]|min_length[11]');   
					//}
					if($data['driver']['UserName'] != $this->input->post('UserName')){
						$this->form_validation->set_rules('UserName','UserName','trim|required|max_length[20]|min_length[4]|callback_usernamekey_exists');    
					}
					if($this->form_validation->run()){ 
						
						$DriverName = $this->security->xss_clean($this->input->post('DriverName'));   
						$MobileNo = $this->security->xss_clean($this->input->post('MobileNo'));   
						$Email = $this->security->xss_clean($this->input->post('Email'));   
						//$Status = $this->security->xss_clean($this->input->post('Status'));   
						$UserName = $this->security->xss_clean($this->input->post('UserName'));
						$ltsignature = $this->input->post('ltsignature', FALSE);    
						if($ltsignature!=""){  
							$ltsignature1 = str_replace('data:image/png;base64,', '', $ltsignature);
							$ltsignature1 = str_replace(' ', '+', $ltsignature1); 
							$ltsignature1 = base64_decode($ltsignature1);
							
							$Signature = md5(date("dmYhisA")).".png"; 
							$file_name = './assets/DriverSignature/'.$Signature;
							file_put_contents($file_name,$ltsignature1); 
						}else{
							$Signature = "";
						}		 
						$DriverInfo = array('ltsignature'=>$ltsignature,'Signature'=>$Signature, 'UserName'=>$UserName, 
						'MobileNo'=>$MobileNo,'DriverName'=>$DriverName,'Email'=>$Email, 'EditUserID'=>$this->session->userdata['userId']  );  
						$cond = array( 'DriverID' => $DriverID );
						$this->Common_model->update("drivers_login",$DriverInfo, $cond);                 
						$this->session->set_flashdata('success', 'Profile updated successfully');                
						redirect('DriversLogin'); 
					}  
			} 
            //$data['driver'] = $this->drivers_model->DriverDetails($id);
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Driver Profile ';
            $this->global['active_menu'] = 'editdriverprofile';

            $this->loadViews("DriversLogin/editDriverProfile", $this->global, $data, NULL);
        }
    }
	function editDriverPassword($id){
		$data = array();
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{     
			if($id == null) { redirect('DriversLogin'); }          
			if ($this->input->server('REQUEST_METHOD') === 'POST'){   
					$this->load->library('form_validation'); 
					$DriverID = $this->input->post('DriverID');  
					
					$this->form_validation->set_rules('password','Password','trim|required|min_length[8]|max_length[20]');
					$this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]'); 
					
					if($this->form_validation->run()){ 
						$password = $this->security->xss_clean($this->input->post('password'));   
						$DriverInfo = array( 'Password'=>md5($password), 'EditUserID'=>$this->session->userdata['userId'] );  
						$cond = array( 'DriverID' => $DriverID ); 
						$res = $this->Common_model->update("drivers_login",$DriverInfo, $cond);                
						if($res){  
							$this->session->set_flashdata('success', 'Password updated successfully');                
						}else{
							$this->session->set_flashdata('error', 'Please Try Again Later');                
						}
						redirect('DriversLogin'); 
					}  
			}
			$conditions = array( 'DriverID' => $id  );
            $data['driver'] = $this->Common_model->select_where("tbl_drivers_login",$conditions);
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Driver Password ';
            $this->global['active_menu'] = 'editdriverpassword';

            $this->loadViews("DriversLogin/editDriverPassword", $this->global, $data, NULL);
        }
    }
	function mobilekey_exists($key) {
		if($key!=""){
			$result = $this->drivers_model->checkDriverMobileExists($key);
			if ($result) {
				$this->form_validation->set_message(
					'mobilekey_exists',
					'Mobile Number is already exist. Please try different. '
				);
				return false;
			} else {
				return true;
			}
		}else{
			$this->form_validation->set_message(
				'mobilekey_exists',
				'Mobile Number Should Not Be Blank. '
			);
			return false;
		}
		
	}

	function usernamekey_exists($key) {
		if($key!=""){
			$result = $this->drivers_model->checkDriverUserNameExists($key);
			if ($result) {
				$this->form_validation->set_message(
					'usernamekey_exists',
					'UserName is already exist. Please try different. '
				);
				return false;
			} else {
				return true;
			}
		}else{
			$this->form_validation->set_message(
				'usernamekey_exists',
				'UserName Should Not Be Blank. '
			);
			return false;
		}
	}	
    function viewDriver($id)
    {
		$data = array();
    	if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            $this->load->model('user_model');        
			
			if($id == null) { redirect('Drivers'); }          
            
			$conditions = array( 'LorryNo' => $id  );
            $data['driver'] = $this->Common_model->select_where("tbl_drivers",$conditions);
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View Driver';
            $this->global['active_menu'] = 'viewdriver';

            $this->loadViews("Drivers/viewDriver", $this->global, $data, NULL);
        }
    }

    
     
    /**
     * This function is used to edit the Contact information system
     */
    function editdriversubmit()
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
            
            $LorryNo = $this->input->post('LorryNo');
            
            $this->form_validation->set_rules('DriverName','DriverName','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('RegNumber','RegNumber','trim|required|max_length[128]');
            $this->form_validation->set_rules('Tare','Tare','trim|required|max_length[128]');
            $this->form_validation->set_rules('Haulier','Haulier','trim|required|max_length[128]');
            
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->drivers();
            }
            else
            {
                $DriverName = $this->security->xss_clean($this->input->post('DriverName')); 
                $RegNumber = $this->security->xss_clean($this->input->post('RegNumber'));
				$RegNumber = preg_replace('/\s+/', '',strtoupper($RegNumber));
				
                $Tare = $this->security->xss_clean($this->input->post('Tare')); 
                $Haulier = $this->security->xss_clean($this->input->post('Haulier'));                              
                $ltsignature = $this->input->post('ltsignature', FALSE); 
                 
                $DriverInfo = array();     
                $DriverInfo = array('DriverName'=>$DriverName, 'RegNumber'=>$RegNumber, 'Tare'=> $Tare,
                'Haulier'=>$Haulier , 'ltsignature'=>$ltsignature , 'EditUserID'=>$this->session->userdata['userId']); 
                
                $cond = array(
                     'LorryNo' => $LorryNo
                    );
                $this->Common_model->update("drivers",$DriverInfo, $cond);                
                $this->session->set_flashdata('success', 'Driver information updated successfully');                
                redirect('drivers');

            }
        }
    }
    

    /**
     * This function is used to delete the contact using ContactID
     * @return boolean $result : TRUE / FALSE
     */
    function deleteDriver()
    {
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $LorryNo = $this->input->post('LorryNo');  
            $con = array('LorryNo'=>$LorryNo);          
			
			$count = $this->Common_model->CountDriverTickets($LorryNo); 
			if($count==0){
				$result = $this->Common_model->delete('drivers', $con); 
				if ($result > 0) { echo(json_encode(array('status'=>TRUE))); 
				}else { echo(json_encode(array('status'=>FALSE,'last'=>'2'))); }
			}else{
				echo(json_encode(array('status'=>FALSE,'last'=>'1')));
			}
            
        }
    } 
 	
    function deleteDriverLogin(){
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $DriverID = $this->input->post('DriverID');  
            $DriverInfo = array('Status'=>'1');           			    
			$cond = array('DriverID'=>$DriverID);           			    
			$result = $this->Common_model->update("tbl_drivers_login",$DriverInfo, $cond);                  
			if ($result > 0) { echo(json_encode(array('status'=>TRUE))); 
			}else { echo(json_encode(array('status'=>FALSE))); } 
        }
    }
	function restoreDriverLogin(){
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $DriverID = $this->input->post('DriverID');  
            $DriverInfo = array('Status'=>'0');           			    
			$cond = array('DriverID'=>$DriverID);           			    
			$result = $this->Common_model->update("tbl_drivers_login",$DriverInfo, $cond);                  
			if ($result > 0) { echo(json_encode(array('status'=>TRUE))); 
			}else { echo(json_encode(array('status'=>FALSE))); } 
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
   
    function checkRegNumber(){
       // echo "dsadsa";
        $val= $this->input->post('val');
        $result=array();
        $result = $this->Common_model->select_where('drivers', array('RegNumber' => $val ));
        if(count($result) > 0){
              echo 0;
        }else{
            echo 1;
        }
        
        die();
    }
    function checkRegEditNumber(){
       // echo "dsadsa";
        $val= $this->input->post('val');
        $EditLorryNo= $this->input->post('EditLorryNo');
        $result=array();
        $result = $this->Common_model->select_where('drivers', array('RegNumber' => $val,'LorryNo!=' =>$EditLorryNo));
        if(count($result) > 0){
              echo 0;
        }else{
            echo 1;
        }
        
        die();
    }
    
}

?>
