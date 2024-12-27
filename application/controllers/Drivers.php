<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
 
class Drivers extends BaseController
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
    
   
    public function index()
    {

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {             
            $data = array();   
			//$data['driverList'] = $this->Common_model->get_all('drivers');   
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Drivers Listing';
            $this->global['active_menu'] = 'drivers';             
            $this->loadViews("Drivers/drivers", $this->global, $data, NULL);
        }
    } 
	
	public function Lorry(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{             
            $data = array();    
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Lorry Listing';
            $this->global['active_menu'] = 'lorry';             
            $this->loadViews("Lorry/Lorry", $this->global, $data, NULL);
        }
    }
	public function LorryOthers(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{             
            $data = array();    
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Other Lorry Listing';
            $this->global['active_menu'] = 'lorry';             
            $this->loadViews("Lorry/LorryOthers", $this->global, $data, NULL);
        }
    }	
	public function AJAXLorry(){  
		$this->load->library('ajax');
		$data = $this->drivers_model->GetLorryData();   
		$this->ajax->send($data);
	}
	function AddLorry(){
		$data = array();
        if($this->isAdd == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
		
			if ($this->input->server('REQUEST_METHOD') === 'POST'){  
					$this->load->library('form_validation');  
					$this->form_validation->set_rules('LorryNo','LorryNo','trim|required|max_length[5]');
					$this->form_validation->set_rules('RegNumber','RegNumber','trim|required|max_length[128]');
					$this->form_validation->set_rules('Tare','Tare','trim|required|max_length[128]');
					$this->form_validation->set_rules('Haulier','Haulier','trim|required'); 
					
					if($this->form_validation->run()){  
					
						$Identifier = $this->security->xss_clean($this->input->post('Identifier')); 
						$IMEI	 = $this->security->xss_clean($this->input->post('IMEI')); 
						$SerialNo = $this->security->xss_clean($this->input->post('SerialNo')); 
						$MacAddress = $this->security->xss_clean($this->input->post('MacAddress')); 						
						
						$DriverName = $this->security->xss_clean($this->input->post('DriverName')); 						
						$LorryNo = $this->security->xss_clean($this->input->post('LorryNo')); 
						
						$RegNumber = $this->security->xss_clean($this->input->post('RegNumber'));
						$RegNumber = preg_replace('/\s+/', '',strtoupper($RegNumber));
						
						$Tare = $this->security->xss_clean($this->input->post('Tare'));
						$Haulier = $this->security->xss_clean($this->input->post('Haulier'));                              
												
						$TruckHeight = $this->security->xss_clean($this->input->post('TruckHeight'));
						$TruckWidth = $this->security->xss_clean($this->input->post('TruckWidth'));
						$TruckLength = $this->security->xss_clean($this->input->post('TruckLength'));
						$TruckWeightTotal = $this->security->xss_clean($this->input->post('TruckWeightTotal'));
						$TruckMaxSpeed = $this->security->xss_clean($this->input->post('TruckMaxSpeed'));
						$TruckWeightAxle = $this->security->xss_clean($this->input->post('TruckWeightAxle'));
						$TruckNoOfAxle = $this->security->xss_clean($this->input->post('TruckNoOfAxle'));
						 
						$driversignature = $this->input->post('driversignature', FALSE);  
						$driversignature1 = str_replace('data:image/png;base64,', '', $driversignature);
						$driversignature1 = str_replace(' ', '+', $driversignature1); 
						$driversignature1 = base64_decode($driversignature1);
						 
						$Signature = 'Lorry-'.$LorryNo.'_'.md5($LorryNo).".png"; 
						
						$file_name = $_SERVER['DOCUMENT_ROOT'].'/assets/DriverSignature/'.$Signature; 
						file_put_contents($file_name,$driversignature1);   
						
						
						
						$AppUser = 1; 
						if($Haulier==1){  
							$Haulier1 = 'Thames Material Ltd.';  
							if(trim($MacAddress)!=""){ $AppUser = 0; }else{ $AppUser = 1;  }  
						}else{ $Haulier1 = '';  $AppUser = 1;  }
						
						$DriverInfo = array( 'LorryNo'=>$LorryNo, 'RegNumber'=>$RegNumber,'Tare'=>$Tare,
						'TruckHeight'=> $TruckHeight,'TruckWidth'=> $TruckWidth,'TruckLength'=> $TruckLength,
						'TruckWeightTotal'=> $TruckWeightTotal,'TruckMaxSpeed'=> $TruckMaxSpeed,'TruckWeightAxle'=> $TruckWeightAxle,'TruckNoOfAxle'=> $TruckNoOfAxle,
						'Haulier'=>$Haulier1, 'ltsignature'=>$driversignature,'Signature'=>$Signature, 'ContractorID'=>$Haulier, 'AppUser'=>$AppUser, 
						'CreateUserID'=>$this->session->userdata['userId'] ,  'CreateDate'=>date('Y-m-d H:i:s'), 'Status'=> '1',
						'MacAddress'=>$MacAddress,'Identifier'=>$Identifier,'IMEI'=>$IMEI,'SerialNo'=>$SerialNo ); 

						$result = $this->Common_model->insert("drivers",$DriverInfo);
						
						if($result > 0){
							$this->session->set_flashdata('success', 'New Lorry has been Added successfully');
							redirect('Lorry');
						}else{
							$this->session->set_flashdata('error', 'Lorry Added Failed, Please Try Again Later. ');
							redirect('Lorry');
						} 
					} 
			}
            $this->load->model('user_model');        
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New Lorry';
            $this->global['active_menu'] = 'addlorry';  
            $this->loadViews("Lorry/AddLorry", $this->global, $data, NULL);
        }
    }
	function EditLorry($id){
		$data = array();
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            $this->load->model('user_model');        
			
			if($id == null) {
                redirect('Lorry');
            }          
            
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$this->load->library('form_validation'); 
				
				$LorryNo = $this->input->post('LorryNo');  
				
				$this->form_validation->set_rules('LorryNo','LorryNo','trim|required|max_length[5]');
				$this->form_validation->set_rules('RegNumber','RegNumber','trim|required|max_length[128]');
				$this->form_validation->set_rules('Tare','Tare','trim|required|max_length[128]');
				//$this->form_validation->set_rules('Haulier','Haulier','trim|required'); 
				 
				if($this->form_validation->run()){ 
				
					$DriverName = $this->security->xss_clean($this->input->post('DriverName')); 						
					$LorryNo = $this->security->xss_clean($this->input->post('LorryNo')); 
					//$LorryID = $this->security->xss_clean($this->input->post('LorryID')); 
					$Status = $this->security->xss_clean($this->input->post('Status')); 
					$is_lorry_assigned = $this->security->xss_clean($this->input->post('is_lorry_assigned')); 
					$MacAddress = $this->security->xss_clean($this->input->post('MacAddress')); 
					$IMEI	 = $this->security->xss_clean($this->input->post('IMEI')); 
					$SerialNo = $this->security->xss_clean($this->input->post('SerialNo'));  
					$Identifier = $this->security->xss_clean($this->input->post('Identifier')); 
					 
					$RegNumber = $this->security->xss_clean($this->input->post('RegNumber'));
					$RegNumber = preg_replace('/\s+/', '',strtoupper($RegNumber));
					
					$Tare = $this->security->xss_clean($this->input->post('Tare'));
				//	$Haulier = $this->security->xss_clean($this->input->post('Haulier'));                              
											
					$TruckHeight = $this->security->xss_clean($this->input->post('TruckHeight'));
					$TruckWidth = $this->security->xss_clean($this->input->post('TruckWidth'));
					$TruckLength = $this->security->xss_clean($this->input->post('TruckLength'));
					$TruckWeightTotal = $this->security->xss_clean($this->input->post('TruckWeightTotal'));
					$TruckMaxSpeed = $this->security->xss_clean($this->input->post('TruckMaxSpeed'));
					$TruckWeightAxle = $this->security->xss_clean($this->input->post('TruckWeightAxle'));
					$TruckNoOfAxle = $this->security->xss_clean($this->input->post('TruckNoOfAxle'));
					                             
					/*$ltsignature = $this->input->post('ltsignature', FALSE);  
					$driversignature1 = str_replace('data:image/png;base64,', '', $ltsignature);
					$driversignature1 = str_replace(' ', '+', $driversignature1); 
					$driversignature1 = base64_decode($driversignature1);
					 
					$Signature = 'Lorry-'.$LorryNo.'_'.md5($LorryNo).".png"; 
					
					$file_name = $_SERVER['DOCUMENT_ROOT'].'/assets/DriverSignature/'.$Signature; 
					file_put_contents($file_name,$driversignature1);   */
					//'ltsignature'=>$ltsignature ,'Signature'=>$Signature , 
					
					if(trim($MacAddress)!=""){ $AppUser = 0; }else{ $AppUser = 1;  }  
					
					$DriverInfo = array( 'MacAddress'=>$MacAddress, 'Status'=>$Status, 'is_lorry_assigned'=>$is_lorry_assigned, 'RegNumber'=>$RegNumber, 'Tare'=> $Tare,'DriverName'=> $DriverName,
					'TruckHeight'=> $TruckHeight,'TruckWidth'=> $TruckWidth,'TruckLength'=> $TruckLength,'AppUser'=>$AppUser, 
					'TruckWeightTotal'=> $TruckWeightTotal,'TruckMaxSpeed'=> $TruckMaxSpeed,'TruckWeightAxle'=> $TruckWeightAxle,'TruckNoOfAxle'=> $TruckNoOfAxle,
					'Identifier'=>$Identifier,'IMEI'=>$IMEI,'SerialNo'=>$SerialNo , 'EditUserID'=>$this->session->userdata['userId']);                  
					$cond = array( 'LorryNo' => $LorryNo ); 
					$result = $this->Common_model->update("drivers",$DriverInfo, $cond);   
					if($result){
						$this->session->set_flashdata('success', 'Lorry has been updated successfully');                
					}else{
						$this->session->set_flashdata('error', 'Please try again later');                
					}
					redirect('Lorry');

				}
			}	
			 
			
			$conditions = array( 'LorryNo' => $id  );
            $data['driver'] = $this->Common_model->select_where("tbl_drivers",$conditions); 

            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Lorry';
            $this->global['active_menu'] = 'editlorry';

            $this->loadViews("Lorry/EditLorry", $this->global, $data, NULL);
        }
    } 
	
    public function AJAXDrivers(){  
		$this->load->library('ajax');
		$data = $this->drivers_model->GetDriverData();   
		$this->ajax->send($data);
	}	 
    public function AJAXDriversOthers(){  
		$this->load->library('ajax');
		$data = $this->drivers_model->GetDriverDataOthers();   
		$this->ajax->send($data);
	} 
    function editDriver($id)
    {
		$data = array();
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            $this->load->model('user_model');        
			
			if($id == null) {
                redirect('Drivers');
            }          
            
			$conditions = array( 'LorryNo' => $id  );
            $data['driver'] = $this->Common_model->select_where("tbl_drivers",$conditions);
			$data['driver_login_list'] = $this->Common_model->DriverLoginList();
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Driver';
            $this->global['active_menu'] = 'editdriver';

            $this->loadViews("Drivers/editDriver", $this->global, $data, NULL);
        }
    }
	function editDriverLogin($id){
		$data = array();
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
		
			if($id == null) { redirect('Drivers'); }          
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				if($this->input->post('submit')){			 
					$this->load->library('form_validation'); 
					$LorryNo = $this->input->post('LorryNo'); 
					
					$this->form_validation->set_rules('MobileNo','MobileNo','trim|required|numeric|max_length[11]|min_length[11]|callback_mobilekey_exists');   
					if($this->form_validation->run()){ 
						$MobileNo = $this->security->xss_clean($this->input->post('MobileNo'));   
						$DriverInfo = array('MobileNo'=>$MobileNo, 'EditUserID'=>$this->session->userdata['userId']  );  
						$cond = array( 'LorryNo' => $LorryNo );
						$this->Common_model->update("drivers",$DriverInfo, $cond);                
						$this->session->set_flashdata('success', 'Mobile Number updated successfully');                
						redirect('drivers'); 
					} 
				}	
				if($this->input->post('submit1')){			 
					$this->load->library('form_validation'); 
					$LorryNo = $this->input->post('LorryNo'); 
					 
					$this->form_validation->set_rules('password','Password','trim|required|min_length[8]|max_length[20]');
					$this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]'); 
					
					if($this->form_validation->run()){ 
						$password = $this->security->xss_clean($this->input->post('password'));   
						$DriverInfo = array('Password'=>md5($password), 'EditUserID'=>$this->session->userdata['userId'] );  
						$cond = array( 'LorryNo' => $LorryNo );
						$this->Common_model->update("drivers",$DriverInfo, $cond);                
						$this->session->set_flashdata('success', 'Password updated successfully');                
						redirect('drivers'); 
					} 
				}	
			}
			$conditions = array( 'LorryNo' => $id  );
            $data['driver'] = $this->Common_model->select_where("tbl_drivers",$conditions);
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Driver Login ';
            $this->global['active_menu'] = 'editdriverlogin';

            $this->loadViews("Drivers/editDriverLogin", $this->global, $data, NULL);
        }
    }
	function mobilekey_exists($key) {
	  $result = $this->Common_model->checkDriverMobileExists($key);
		if ($result) {
			$this->form_validation->set_message(
				'mobilekey_exists',
				'Mobile Number is already exist. Please try different. '
			);
			return false;
		} else {
			return true;
		}
		
	}
	function checkMobileExists(){ 
        $MobileNo = $this->input->post("MobileNo"); 
        $result = $this->Common_model->checkDriverMobileExists($email); 

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
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

    
    function UpdateLorryDriverAJAX(){
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
			  
            $data['LorryNo'] = $this->input->post('LorryNo');  
			
			$conditions = array( 'LorryNo' => $data['LorryNo'] );
            $data['LorryDetails'] = $this->drivers_model->LorryBasicInfo($data['LorryNo']);  
			
			$data['DriverList'] = $this->drivers_model->DriverLoginList($data['LorryNo']);    
			
			$data['CountAllocation'] = $this->drivers_model->CheckLorryDriverAllocation($data['LorryNo'],$data['LorryDetails']['DriverID']);    
			
			//var_dump($data);
			//exit; 
			$html = $this->load->view('Drivers/UpdateLorryDriverAJAX', $data, true);  
			echo json_encode($html); 
        }
    }

	function UpdateLorryDriverAJAXPOST(){
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				$LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));  
				$DriverID = $this->security->xss_clean($this->input->post('DriverID'));  				  
				
				$conditions = array( 'LorryNo' => $LorryNo );
				$data['LorryDetails'] = $this->drivers_model->LorryBasicInfo($LorryNo); 
				//var_dump($data['LorryDetails']); 
				$Res = $this->drivers_model->UpdateLorry($LorryNo,$DriverID,$data['LorryDetails']['RegNumber']); 
				if($Res){
					$this->session->set_flashdata('success', 'Lorry Driver has been Updated successfully');  
				}else{
					$this->session->set_flashdata('error', 'Please Try Again Later');  	
				}  
				//$this->db->query("update tbl_drivers set DriverID = '0' where DriverID = '$DriverLoginID'");
                //$this->db->query("update tbl_drivers set DriverID = '$DriverLoginID' where RegNumber = '$RegNumber'");
				 
				redirect('drivers'); 
			}  
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
            
            //$this->form_validation->set_rules('DriverName','DriverName','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('RegNumber','RegNumber','trim|required|max_length[128]');
            $this->form_validation->set_rules('Tare','Tare','trim|required|max_length[128]');
            //$this->form_validation->set_rules('Haulier','Haulier','trim|required|max_length[128]');
             
            if($this->form_validation->run())
            { 
                //$DriverName = $this->security->xss_clean($this->input->post('DriverName')); 
				$DriverID = $this->security->xss_clean($this->input->post('DriverID')); 
                $RegNumber = $this->security->xss_clean($this->input->post('RegNumber'));
				$RegNumber = preg_replace('/\s+/', '',strtoupper($RegNumber));
				
				$TruckHeight = $this->security->xss_clean($this->input->post('TruckHeight'));
				$TruckWidth = $this->security->xss_clean($this->input->post('TruckWidth'));
				$TruckLength = $this->security->xss_clean($this->input->post('TruckLength'));
				$TruckWeightTotal = $this->security->xss_clean($this->input->post('TruckWeightTotal'));
				$TruckMaxSpeed = $this->security->xss_clean($this->input->post('TruckMaxSpeed'));
				$TruckWeightAxle = $this->security->xss_clean($this->input->post('TruckWeightAxle'));
				
				$AppUser = $this->security->xss_clean($this->input->post('AppUser'));
				if($DriverID==0){ $AppUser = 1;  }else{ $AppUser = 0;  }
				
                $Tare = $this->security->xss_clean($this->input->post('Tare')); 
               // $Haulier = $this->security->xss_clean($this->input->post('Haulier'));                              
                $ltsignature = $this->input->post('ltsignature', FALSE); 
				
				
				$driversignature1 = str_replace('data:image/png;base64,', '', $ltsignature);
				$driversignature1 = str_replace(' ', '+', $driversignature1); 
				$driversignature1 = base64_decode($driversignature1);
				 
				$Signature = 'Lorry-'.$LorryNo.'_'.md5($LorryNo).".png"; 
				
				$file_name = $_SERVER['DOCUMENT_ROOT'].'/assets/DriverSignature/'.$Signature; 
				file_put_contents($file_name,$driversignature1);   
				
                 
                $DriverInfo = array();  
				$DriverInfo = array( 'RegNumber'=>$RegNumber, 'Tare'=> $Tare,
				'TruckHeight'=> $TruckHeight,'TruckWidth'=> $TruckWidth,'TruckLength'=> $TruckLength,
				'TruckWeightTotal'=> $TruckWeightTotal,'TruckMaxSpeed'=> $TruckMaxSpeed,'TruckWeightAxle'=> $TruckWeightAxle,
                'ltsignature'=>$ltsignature ,'Signature'=>$Signature ,  'EditUserID'=>$this->session->userdata['userId']);                  
                $cond = array( 'LorryNo' => $LorryNo ); 
                $this->Common_model->update("drivers",$DriverInfo, $cond);  
 
                $this->session->set_flashdata('success', 'Driver information updated successfully');                
                redirect('drivers');

            }
        }
    }
  
    function deleteDriver(){
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
				}else { echo(json_encode(array('status'=>FALSE))); }
			}else{
				echo(json_encode(array('status'=>FALSE,'count'=>$count)));
			} 
        }
    } 
	function DeleteLorry(){
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
				}else { echo(json_encode(array('status'=>FALSE))); }
			}else{
				echo(json_encode(array('status'=>FALSE,'count'=>$count)));
			} 
        }
    } 	
   
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
