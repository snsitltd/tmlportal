<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
 
class Opportunity extends BaseController
{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
 
    public function __construct(){
        parent::__construct();
        $this->load->model('opportunity_model');       
        $this->load->model('Tickets_model');       
		
        $this->load->model('contacts_model');  
        $this->isLoggedIn();               
        $roleCheck = $this->Common_model->checkpermission('opportunity'); 

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
            $data['opportunityRecords'] = $this->opportunity_model->opportunityListing();   
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Opportunity Listing'; 
            $this->global['active_menu'] = 'opportunity';           
            $this->loadViews("Opportunity/opportunities", $this->global, $data, NULL);
        }
    }
	function DeleteProductPrice(){
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $ProductID = $this->input->post('ProductID');     
            $con = array('productid'=>$ProductID);            
            $result = $this->Common_model->delete('tbl_product', $con); 
            if ($result > 0) { 
				//if($LoadType==1){ /*$this->Booking_model->BookingDateAllocatedLoadMinus($BookingDateID); */ }
				echo(json_encode(array('status'=>TRUE))); 
			} else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	public function AJAXOpportunity(){  
		$this->load->library('ajax');
		$data = $this->opportunity_model->GetOpportunityData();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
    public function wifOppo(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{              
            $data['opportunityRecords'] = $this->opportunity_model->wifopportunityListing();   
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : WIF Opportunity Listing'; 
            $this->global['active_menu'] = 'wifopportunity'; 
            $this->loadViews("Opportunity/wifOppo", $this->global, $data, NULL);
        }
    }
     
    function addNewOpportunity()
    {

        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {    
            $data = array();                 
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New Opportunity';
            $this->global['active_menu'] = 'addopportunity';
            $data['company_list'] = $this->Common_model->select_all_with_where('company',array("status"=>1)) ; 
            $data['county'] = $this->Common_model->get_all('county');
            //$data['country'] = $this->Common_model->get_all('countries');

            //print_r($data['company_list']);
           // $data['contact_list'] = $this->contacts_model->getAllContactlist();

            $this->loadViews("Opportunity/addNewOpportunity", $this->global, $data, NULL);
        }
    }
	function EditAuthoAJAX(){
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $data['TipID'] = $this->input->post('TipID');      
			$data['OpportunityID'] = $this->input->post('OpportunityID');       
			$Cond = array('OpportunityID'=>$data['OpportunityID'], 'TipID'=>$data['TipID']);
			$data['Autho'] = $this->Common_model->select_where('tbl_opportunity_tip',$Cond) ; 
			 
			if($data['Autho']){ 
				$data['TableID'] = $data['Autho']['TableID']; 
			}else{ 
				$data['TableID'] = ""; 
			}
			//var_dump($data);
			//exit; 
			$html = $this->load->view('Opportunity/EditAuthoAJAX', $data, true);  
			echo json_encode($html); 
        }
    }
	function EditAuthoAJAXPOST(){
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $TipID  = $this->input->post('TipID');      
			$OpportunityID = $this->input->post('OpportunityID');      
			$TipRefNo = $this->input->post('TipRefNo'); 
			$Status = $this->input->post('Status');    
			$TableID = $this->input->post('TableID');    
			$LoadInfo = array('TipID'=>$TipID,'OpportunityID'=>$OpportunityID,'TipRefNo'=>$TipRefNo,'Status'=>$Status); 
			if($TableID!=""){  
				$LoadCond = array('TableID'=>$TableID );             
				$result = $this->Common_model->update("tbl_opportunity_tip",$LoadInfo, $LoadCond);  
				//if($result){ 
				$this->session->set_flashdata('success', 'Tip has been Updated successfully');  
				//}else{ $this->session->set_flashdata('error', 'Please Try again ');   }
			}else{
				$result = $this->Common_model->insert("tbl_opportunity_tip",$LoadInfo);   
				if($result){ $this->session->set_flashdata('success', 'Tip has been Updated successfully');  
				}else{ $this->session->set_flashdata('error', 'Please Try again ');   }
			} 
			
			$data['OppoTip'] = $this->opportunity_model->OppoTipNameList($OpportunityID);   
			$TipText = '';
			for($i=0;$i<count($data['OppoTip']);$i++){
				$TipText =  $TipText.$data['OppoTip'][$i]->TipName." - ".$data['OppoTip'][$i]->TipDT."\n";
			} 
			$cond = array( 'OpportunityID' => $OpportunityID ); 
			$opportunityInfo = array(  'TipName'=>$TipText ,'EditUserID'=>$this->session->userdata['userId']); 
			$this->Common_model->update("opportunities",$opportunityInfo, $cond);
					
			redirect('edit-Opportunity/'.$OpportunityID.'#tip');  
        }
    }
	function OppoAuthorizeTip($OpportunityID){

        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error'; 
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
			if($OpportunityID == ""){  redirect('opportunities');  }
			  
			$OpportunityInfo = array('OpportunityID'=>$OpportunityID,'TipID'=>$TipID, 
			'TipRefNo'=>$TipRefNo, 'Street1'=>$Street1, 'Street2'=> $Street2,
			'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode ,'PO_Notes'=>$PO_Notes , 'OpenDate'=>$OpenDate , 
			'WIFRequired'=>$WIFRequired , 'WIF'=>$WIF , 'TipTicketRequired'=>$TipTicketRequired , 'TipName'=>$TipName , 
			'StampRequired'=>$StampRequired , 'Stamp'=>$Stamp , 'SiteInstRequired'=>$SiteInstRequired , 
			'SiteNotes'=>$SiteNotes , 'PORequired'=>$PORequired , 'AccountNotes'=>$AccountNotes , 
			'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');                
			
			$this->Common_model->insert("opportunities",$OpportunityInfo);   
		 
			$rel = array('CompanyID'=>$CompanyID, 'OpportunityID'=>$OpportunityID);
			$this->Common_model->insert("company_to_opportunities",$rel); 
				
			$rel1 = array('ContactID'=>$ContactID, 'OpportunityID'=>$OpportunityID);
			$this->Common_model->insert("opportunity_to_contact",$rel1); 
			
			#############################################################################################################################
			$ContactID = $this->generateRandomString();
			$contactInfo = array('ContactID'=>$ContactID,'ContactIDMapKey'=>$OpportunityID,'ContactName'=>$ContactName, 
			'EmailAddress'=> $EmailAddress,'MobileNumber'=>$MobileNumber ,'CreateUserID'=>$this->session->userdata['userId'] ,
			'CreateDate'=>date('Y-m-d H:i:s'));                 
			$this->contacts_model->addNewContacts($contactInfo); 
			
			$rel = array('OpportunityID'=>$OpportunityID, 'ContactID'=>$ContactID);
			$this->Common_model->insert("tbl_opportunity_to_contact",$rel); 
			
			#############################################################################################################################
			  
			
			$this->session->set_flashdata('success', 'Tip has been Authorized successfully'); 
			
			redirect('edit-Opportunity/');
				  
     
        }
    }
	
	
	function addOpportunity()
    {

        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {   
	
            $data = array();                 

			if ($this->input->server('REQUEST_METHOD') === 'POST'){
				
				$this->load->library('form_validation');
            
				//$this->form_validation->set_rules('OpportunityName','OpportunityName','trim|required|max_length[128]'); 
				$this->form_validation->set_rules('Street1','Street1','trim|required');            
				//$this->form_validation->set_rules('Street2','Street2','trim|required');
				$this->form_validation->set_rules('Town','Town','trim|required');
				$this->form_validation->set_rules('County','County','trim|required');
				$this->form_validation->set_rules('PostCode','PostCode','trim|required');
				
				$this->form_validation->set_rules('ContactName','ContactName','trim|required');
				//$this->form_validation->set_rules('EmailAddress','EmailAddress','trim|required');
				$this->form_validation->set_rules('MobileNumber','MobileNumber','trim|required');
				
				//$this->form_validation->set_rules('PO_Notes','PO_Notes','required'); 
				//$this->form_validation->set_rules('CompanyID','CompanyID','required'); 
				//$this->form_validation->set_rules('ContactID','ContactID','required'); 
				//$this->form_validation->set_rules('OpenDate','Open Date','required'); 
				//$this->form_validation->set_rules('CloseDate','ContactID','required'); 
				//$this->form_validation->set_rules('WIFRequired','ContactID','required'); 
				//$this->form_validation->set_rules('TipTicketRequired','ContactID','required'); 
				//$this->form_validation->set_rules('StampRequired','ContactID','required'); 
				//$this->form_validation->set_rules('SiteInstRequired','ContactID','required'); 
				//$this->form_validation->set_rules('PORequired','ContactID','required');  
				//$this->form_validation->set_rules('AccountNotes','ContactID','required'); 
				
				if($this->form_validation->run()){ 
					$OpportunityID = $this->generateRandomString(); 
					//$OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));                
					$EmailAddress = $this->security->xss_clean($this->input->post('EmailAddress'));                
					$MobileNumber = $this->security->xss_clean($this->input->post('MobileNumber'));                
					
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));                
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
					$careof = $this->security->xss_clean($this->input->post('careof'));
					
					$PO_Notes = $this->security->xss_clean($this->input->post('PO_Notes'));
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID')); 
					$ContactID = $this->security->xss_clean($this->input->post('ContactID'));
					$OpenDate = $this->security->xss_clean($this->input->post('OpenDate'));
					//$CloseDate = $this->security->xss_clean($this->input->post('CloseDate'));
					$WIFRequired = $this->security->xss_clean($this->input->post('WIFRequired'));
					$WIF = $this->security->xss_clean($this->input->post('WIF'));
					$TipTicketRequired = $this->security->xss_clean($this->input->post('TipTicketRequired'));
					$TipName = $this->security->xss_clean($this->input->post('TipName'));
					$StampRequired = $this->security->xss_clean($this->input->post('StampRequired'));
					$Stamp = $this->security->xss_clean($this->input->post('Stamp'));
					$SiteInstRequired = $this->security->xss_clean($this->input->post('SiteInstRequired'));
					$SiteNotes = $this->security->xss_clean($this->input->post('SiteNotes'));
					$PORequired = $this->security->xss_clean($this->input->post('PORequired')); 
					$AccountNotes = $this->security->xss_clean($this->input->post('AccountNotes'));
					$date = str_replace('/', '-', $OpenDate); 
					$OpenDate =   date('Y-m-d  H:i:s',strtotime($date)); 
					//$date1 = str_replace('/', '-', $CloseDate); 
					//$CloseDate =   date('Y-m-d  H:i:s',strtotime($date1)); 
					$cr = "";
					if(trim($careof)!=""){ $cr = ", ".trim($careof); } 
					
					$OpportunityName = $Street1.", ".$Street2.", ".$Town.", ".$County.", ".$PostCode.$cr;
					 
					$OpportunityInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID, 
					'OpportunityName'=>$OpportunityName, 'Street1'=>$Street1, 'Street2'=> $Street2,
					'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode ,'careof'=>$careof , 'PO_Notes'=>$PO_Notes , 'OpenDate'=>$OpenDate , 
					'WIFRequired'=>$WIFRequired , 'WIF'=>$WIF , 'TipTicketRequired'=>$TipTicketRequired , 'TipName'=>$TipName , 
					'StampRequired'=>$StampRequired , 'Stamp'=>$Stamp , 'SiteInstRequired'=>$SiteInstRequired , 
					'SiteNotes'=>$SiteNotes , 'PORequired'=>$PORequired , 'AccountNotes'=>$AccountNotes ,  'Status'=>1, 
					'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');                
					
					$this->Common_model->insert("opportunities",$OpportunityInfo);   
					 
						$rel = array('CompanyID'=>$CompanyID, 'OpportunityID'=>$OpportunityID);
						$this->Common_model->insert("company_to_opportunities",$rel); 
						
						if($OpportunityID!="" && $ContactID !=""){	
							$rel1 = array('ContactID'=>$ContactID, 'OpportunityID'=>$OpportunityID);
							$this->Common_model->insert("opportunity_to_contact",$rel1); 
						}
						/*#############################################################################################################################*/
						if($MobileNumber!="" && $ContactName!=""  ){ 
							$ContactID = $this->generateRandomString();
							$contactInfo = array('ContactID'=>$ContactID,'ContactIDMapKey'=>$OpportunityID,'ContactName'=>$ContactName, 'Type'=>'1','Position'=>'Site Contact', 
							'EmailAddress'=> $EmailAddress,'MobileNumber'=>$MobileNumber ,'CreateUserID'=>$this->session->userdata['userId'] ,
							'CreateDate'=>date('Y-m-d H:i:s'));                 
							$this->contacts_model->addNewContacts($contactInfo); 
							
							$rel = array('OpportunityID'=>$OpportunityID, 'ContactID'=>$ContactID);
							$this->Common_model->insert("tbl_opportunity_to_contact",$rel); 
						
						}
						/*################################################# Add Tip Autho ############################################################################*/ 
						
						$LoadInfo = array('TipID'=>'1','OpportunityID'=>$OpportunityID,'TipRefNo'=>'','Status'=>'0');  
						$this->Common_model->insert("tbl_opportunity_tip",$LoadInfo);  
						
						/*#############################################################################################################################*/
					  
					
					$this->session->set_flashdata('success', 'New Opportunity created successfully'); 
					
					redirect('opportunities');
				}
				
			}
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New Opportunity';
            $this->global['active_menu'] = 'addopportunity';
            $data['company_list'] = $this->Common_model->select_all_with_where('company',array("status"=>1)) ; 
            $data['county'] = $this->Common_model->get_all('county');
            //$data['country'] = $this->Common_model->get_all('countries');

            //print_r($data['company_list']);
           // $data['contact_list'] = $this->contacts_model->getAllContactlist();

            $this->loadViews("Opportunity/addOpportunity", $this->global, $data, NULL);
        }
    }

    
    /**
     * This function is used to add new contacts to the system
     */
    function addnewOpportunitysubmit()
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
            
            $this->form_validation->set_rules('OpportunityName','OpportunityName','trim|required'); 
            $this->form_validation->set_rules('Street1','Street1','trim|required');            
            //$this->form_validation->set_rules('Street2','Street2','trim|required');
            $this->form_validation->set_rules('Town','Town','trim|required');
            $this->form_validation->set_rules('County','County','trim|required');
            $this->form_validation->set_rules('PostCode','PostCode','trim|required');
            //$this->form_validation->set_rules('PO_Notes','PO_Notes','required'); 
            //$this->form_validation->set_rules('CompanyID','CompanyID','required'); 
            //$this->form_validation->set_rules('ContactID','ContactID','required'); 
            
            if($this->form_validation->run() == FALSE)
            {
                
                $this->addNewOpportunity();
            }
            else
            {
                $OpportunityID = $this->generateRandomString(); 
                $OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
                $Street1 = $this->security->xss_clean($this->input->post('Street1'));                
                $Street2 = $this->security->xss_clean($this->input->post('Street2'));
                $Town = $this->security->xss_clean($this->input->post('Town'));
                $County = $this->security->xss_clean($this->input->post('County'));
                $PostCode = $this->security->xss_clean($this->input->post('PostCode'));
                $PO_Notes = $this->security->xss_clean($this->input->post('PO_Notes'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID')); 
                $ContactID = $this->security->xss_clean($this->input->post('ContactID'));
                $DocumentDetail = $this->security->xss_clean($this->input->post('DocumentDetail'));
                $DocumentType = $this->security->xss_clean($this->input->post('DocumentType'));            
                
                $OpportunityInfo = array('OpportunityID'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 'Street1'=>$Street1, 'Street2'=> $Street2,
                                    'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode ,'PO_Notes'=>$PO_Notes ,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');                
                
                $this->Common_model->insert("opportunities",$OpportunityInfo);
                
               
                $rel = array('CompanyID'=>$CompanyID, 'OpportunityID'=>$OpportunityID);
                $this->Common_model->insert("company_to_opportunities",$rel);

                $rel1 = array('ContactID'=>$ContactID, 'OpportunityID'=>$OpportunityID);
                $this->Common_model->insert("opportunity_to_contact",$rel1);

                $name_array = array();
                $count = count($_FILES['DocumentAttachment']['size']);
 

                if($_FILES['DocumentAttachment']['size']['0'] > 0 ){

                foreach($_FILES as $key=>$value){
					for($s=0; $s<=$count-1; $s++) {
						$_FILES['DocumentAttachment']['name']=$value['name'][$s];
						$_FILES['DocumentAttachment']['type']    = $value['type'][$s];
						$_FILES['DocumentAttachment']['tmp_name'] = $value['tmp_name'][$s];
						$_FILES['DocumentAttachment']['error']       = $value['error'][$s];
						$_FILES['DocumentAttachment']['size']    = $value['size'][$s];   
//						$config['upload_path']          = WEB_ROOT_PATH.'assets/Documents/';
						$config['upload_path']          = WEB_ROOT_PATH.'assets/Documents/';
						$config['allowed_types'] = '*';
						$config['max_size'] = 1024 * 8;
						$config['encrypt_name'] = TRUE;
						$this->load->library('upload', $config);
						$this->upload->initialize($config); 
						$this->upload->do_upload('DocumentAttachment');        
						$data = $this->upload->data(); 
						$name_array[] = $data['file_name'];    
						
						$DocumentID = $this->generateRandomString();                   
						$DocumentInfo = array('DocumentID'=>$DocumentID,'DocumentAttachment'=>$data['file_name'], 'DocumentDetail'=> $_POST['DocumentDetail'][$s],
						'DocumentType'=> $_POST['DocumentType'][$s],'CreatedUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');
						$this->Common_model->insert("documents",$DocumentInfo); 				 
						$rel = array('OpportunityID'=>$OpportunityID, 'DocumentID'=>$DocumentID);				 
						$this->Common_model->insert("opportunity_to_document",$rel);
					}
                } 
 
                //$Documentsarray =array_combine($DocumentDetail,$name_array);                  
 
                //foreach ($Documentsarray as $key => $value) {
					//$DocumentID = $this->generateRandomString();                   

					//$DocumentInfo = array('DocumentID'=>$DocumentID,'DocumentAttachment'=>$value, 'DocumentDetail'=> $key,
					//					 'CreatedUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');
					//$this->Common_model->insert("documents",$DocumentInfo); 

					 //$rel = array('OpportunityID'=>$OpportunityID, 'DocumentID'=>$DocumentID);
					 //$this->Common_model->insert("opportunity_to_document",$rel);
                    
                //}

            }


                    $this->session->set_flashdata('success', 'New Opportunity created successfully');
                    redirect('opportunities');
            }
        }
    }

    
    /**
     * This function is used load contacts edit information
     * @param number $ContactID : Optional : This is contact id
     */
	public function AjaxOppoBookings(){  
		$this->load->library('ajax'); 
		$OppoID = $this->input->post('OppoID');
		
		$data = $this->opportunity_model->GetOppoBookingData($OppoID);  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
	 
    function editOpportunity($OpportunityID)
    { 
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
            if($OpportunityID == null){
                redirect('opportunities');
            }       
			//if ($this->input->server('REQUEST_METHOD') === 'POST'){
			if ($this->input->post('submit') == 'SAVE'){ 
				$this->load->library('form_validation'); 
				$OpportunityID = $this->input->post('OpportunityID'); 
				$this->form_validation->set_rules('OpportunityName','OpportunityName','trim|required'); 
				$this->form_validation->set_rules('Street1','Street1','trim|required');            
				//$this->form_validation->set_rules('Street2','Street2','trim|required');
				$this->form_validation->set_rules('Town','Town','trim|required');
				$this->form_validation->set_rules('County','County','trim|required');
				$this->form_validation->set_rules('PostCode','PostCode','trim|required');
				//$this->form_validation->set_rules('PO_Notes','PO_Notes','required'); 
				//$this->form_validation->set_rules('CompanyID','CompanyID','required'); 
				//$this->form_validation->set_rules('ContactID','ContactID','required'); 
				//$this->form_validation->set_rules('OpenDate','Open Date','required'); 
				//$this->form_validation->set_rules('CloseDate','ContactID','required'); 
				//$this->form_validation->set_rules('WIFRequired','ContactID','required'); 
				//$this->form_validation->set_rules('TipTicketRequired','ContactID','required'); 
				//$this->form_validation->set_rules('StampRequired','ContactID','required'); 
				//$this->form_validation->set_rules('SiteInstRequired','ContactID','required'); 
				//$this->form_validation->set_rules('PORequired','ContactID','required');  
				//$this->form_validation->set_rules('AccountNotes','ContactID','required'); 
				 
				if($this->form_validation->run() == FALSE)
				{
					$this->editOpportunity($OpportunityID);
				}
				else
				{
					//$OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
					//$CUST_SiteContactName_024406636 = $this->security->xss_clean($this->input->post('CUST_SiteContactName_024406636'));                
					//$CUST_Mobile_015736621 = $this->security->xss_clean($this->input->post('CUST_Mobile_015736621'));  
					
					$ContactID = $this->security->xss_clean($this->input->post('ContactID')); 
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));                
					$MobileNumber = $this->security->xss_clean($this->input->post('MobileNumber'));  
					
					
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));  
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
					$PO_Notes = $this->security->xss_clean($this->input->post('PO_Notes'));
					//$CompanyID = $this->security->xss_clean($this->input->post('CompanyID')); 
					//$ContactID = $this->security->xss_clean($this->input->post('ContactID')); 
					$OpenDate = $this->security->xss_clean($this->input->post('OpenDate'));
					//$CloseDate = $this->security->xss_clean($this->input->post('CloseDate'));
					$WIFRequired = $this->security->xss_clean($this->input->post('WIFRequired'));
					$WIF = $this->security->xss_clean($this->input->post('WIF'));
					$TipTicketRequired = $this->security->xss_clean($this->input->post('TipTicketRequired'));
					$TipName_ACT = $this->security->xss_clean($this->input->post('TipName_ACT'));
					
					$TipName = $this->security->xss_clean($this->input->post('TipName'));
					$StampRequired = $this->security->xss_clean($this->input->post('StampRequired'));
					$Stamp = $this->security->xss_clean($this->input->post('Stamp'));
					$SiteInstRequired = $this->security->xss_clean($this->input->post('SiteInstRequired'));
					$SiteNotes = $this->security->xss_clean($this->input->post('SiteNotes'));
					$PORequired = $this->security->xss_clean($this->input->post('PORequired')); 
					$AccountNotes = $this->security->xss_clean($this->input->post('AccountNotes'));
					$Status = $this->security->xss_clean($this->input->post('Status'));
					$careof = $this->security->xss_clean($this->input->post('careof'));
					$date = str_replace('/', '-', $OpenDate); 
					$OpenDate =   date('Y-m-d  H:i:s',strtotime($date)); 
					//$date1 = str_replace('/', '-', $CloseDate); 
					//$CloseDate =   date('Y-m-d  H:i:s',strtotime($date1));  
					$s = ""; $cr='';
					if($Street2!=""){ $s = ",".$Street2; }
					if(trim($careof)!=""){ $cr = ", ".trim($careof); }
 					$OpportunityName = $Street1.$s.", ".$Town.", ".$County.", ".$PostCode.$cr; 
					
					$opportunityInfo = array();  
					$opportunityInfo = array( 'OpportunityName'=>$OpportunityName,'Street1'=>$Street1, 'Street2'=> $Street2,
					'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode ,'PO_Notes'=>$PO_Notes ,'OpenDate'=>$OpenDate , 'TipName_ACT'=>$TipName_ACT ,  
					'WIFRequired'=>$WIFRequired , 'WIF'=>$WIF , 'TipTicketRequired'=>$TipTicketRequired , 'TipName'=>$TipName , 'StampRequired'=>$StampRequired , 'Stamp'=>$Stamp , 
					'SiteInstRequired'=>$SiteInstRequired , 'SiteNotes'=>$SiteNotes ,'careof'=>$careof , 'PORequired'=>$PORequired , 'AccountNotes'=>$AccountNotes ,  'Status'=>$Status ,   
					'EditUserID'=>$this->session->userdata['userId']);        
					
					$cond = array( 'OpportunityID' => $OpportunityID );
					$this->Common_model->update("opportunities",$opportunityInfo, $cond);
					 
					if($ContactID==""){	
						$ContactID = $this->generateRandomString();  
						$ConInfo = array('ContactID'=>$ContactID,'ContactName'=>$ContactName,'MobileNumber'=>$MobileNumber,'Type'=>'1', 'Position' => 'Site Contact'); 
						$this->Common_model->insert("tbl_contacts",$ConInfo);
						
						$OC = array('OpportunityID'=>$OpportunityID, 'ContactID'=>$ContactID ); 
						$this->Common_model->insert("tbl_opportunity_to_contact", $OC); 
					}else{ 
						$ConInfo = array('ContactName'=>$ContactName,'MobileNumber'=>$MobileNumber,'Type'=>'1','Position' => 'Site Contact');  
						$cond = array( 'ContactID' => $ContactID); 
						$this->Common_model->update("tbl_contacts",$ConInfo, $cond);  
					}
					//exit;
					//$rel = array('CompanyID'=>$CompanyID);
					//$this->Common_model->update("company_to_opportunities",$rel, $cond);   

					//$rel = array('ContactID'=>$ContactID);
					//$this->Common_model->update("opportunity_to_contact",$rel, $cond); 
					
					$this->session->set_flashdata('success', 'Opportunity updated successfully');
					
					redirect('edit-Opportunity/'.$OpportunityID);
				}
			
			}	/// SUBMIT
			
			if ($this->input->post('submit2') == 'SAVE'){	
				
				$this->load->library('form_validation');
            
				$OpportunityID = $this->input->post('OpportunityID');
				
				$this->form_validation->set_rules('ProductCode','Product Code','required'); 
				$this->form_validation->set_rules('Description','Description ','required'); 
				$this->form_validation->set_rules('Qty','Qty','required'); 
				$this->form_validation->set_rules('DateRequired','Date Required','required'); 
				$this->form_validation->set_rules('UnitPrice','Price ','required'); 
				$this->form_validation->set_rules('PurchaseOrderNo','Purchase Order No.','required'); 
				$this->form_validation->set_rules('JobNo','Job No.','required');  
				 
				
				if($this->form_validation->run())
				{ 
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$ProductCode = $this->security->xss_clean($this->input->post('ProductCode'));
					$Description = $this->security->xss_clean($this->input->post('Description'));                
					$Qty = $this->security->xss_clean($this->input->post('Qty'));
					$DateRequired = $this->security->xss_clean($this->input->post('DateRequired'));
					$UnitPrice = $this->security->xss_clean($this->input->post('UnitPrice'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$JobNo = $this->security->xss_clean($this->input->post('JobNo'));
					$Comments = $this->security->xss_clean($this->input->post('Comments')); 
					 
					$date = str_replace('/', '-', $DateRequired); 
					$DateRequired =   date('Y-m-d  H:i:s',strtotime($date)); 
					 
					$opportunityInfo = array();  
					$opportunityInfo = array('OpportunityID'=>$OpportunityID, 'ProductCode'=>$ProductCode, 'Description'=>$Description, 'Qty'=> $Qty,
					'DateRequired'=>$DateRequired ,'UnitPrice'=>$UnitPrice ,'PurchaseOrderNo'=>$PurchaseOrderNo ,'JobNo'=>$JobNo ,'Comments'=>$Comments ,  
					'CreateUserID'=>$this->session->userdata['userId'],'EditUserID'=>$this->session->userdata['userId']);        
					 
					$this->Common_model->insert("tbl_product",$opportunityInfo); 
					//$this->Common_model->update("opportunities",$opportunityInfo, $cond); 
					$this->session->set_flashdata('success', 'Product Added successfully');
					
					redirect('edit-Opportunity/'.$OpportunityID);
				} 
			
			}	/// SUBMIT
			
			
			if ($this->input->post('submit1') == 'SAVE'){	 
					$OpportunityID = $this->input->post('OpportunityID'); 
					$name_array = array();
					$count = count($_FILES['DocumentAttachment']['size']); 
					$FileSucc = "";
					//exit; 
					if($_FILES['DocumentAttachment']['size']['0'] > 0 ){
						
						foreach($_FILES as $key=>$value){
							for($s=0; $s<=$count-1; $s++) {
								if($value['name'][$s]!=""){
									$_FILES['DocumentAttachment']['name'] = $value['name'][$s];
									$_FILES['DocumentAttachment']['type']    = $value['type'][$s];
									$_FILES['DocumentAttachment']['tmp_name'] = $value['tmp_name'][$s];
									$_FILES['DocumentAttachment']['error']       = $value['error'][$s];
									$_FILES['DocumentAttachment']['size']    = $value['size'][$s];   
									
									//$config['upload_path'] = WEB_ROOT_PATH.'assets/Documents/';
									$config['upload_path'] = WEB_ROOT_PATH.'assets/Documents/';
									//$config['allowed_types'] = '*';
									$config['allowed_types'] = 'gif|jpg|png|GIF|JPG|PNG|JPEG|jpeg|pdf|PDF|doc|docx|DOC|DOCX|xlsx|xls|XLSX|XLS|msg|MSG';
									
									$config['max_size'] = 1024 * 8;
									//$config['encrypt_name'] = TRUE;
									 
									$file_name = preg_replace("/[^a-zA-Z0-9-_.]/", "", $_FILES['DocumentAttachment']['name']);
									$FileSucc .= "<br> <b>".$_FILES['DocumentAttachment']['name']." </b> "; 
									
									$config['file_name'] = $file_name;

									$this->load->library('upload', $config);
									$this->upload->initialize($config); 
									
									if($this->upload->do_upload('DocumentAttachment')){        
									
										$data = $this->upload->data();
										$name_array[] = $data['file_name'];    
										
										$DocumentID = $this->generateRandomString(); 
										$DocumentInfo = array('DocumentID'=>$DocumentID,'DocumentAttachment'=>$data['file_name'], 
										'DocumentNumber'=> $_POST['DocumentNumber'][$s],'DocumentDetail'=> $_POST['DocumentDetail'][$s],
										'DocumentType'=> $_POST['DocumentType'][$s], 'CreatedUserID'=>$this->session->userdata['userId'] ,
										'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');
										$this->Common_model->insert("documents",$DocumentInfo); 
										
										$rel = array('OpportunityID'=>$OpportunityID, 'DocumentID'=>$DocumentID);
										$this->Common_model->insert("opportunity_to_document",$rel);
										
										$FileSucc .= " :  Uploaded Successfully <br>"; 
									
									}else{ 
										$error = array('error' => $this->upload->display_errors());    
										$FileSucc .= " :  ".trim(strip_tags($error['error']))." Please Try Again Later. <br>"; 
									}
								
								} 
							}
						} 
						
						$this->session->set_flashdata('success', $FileSucc); 
						redirect('edit-Opportunity/'.$OpportunityID.'#documents'); 
					} 
					$this->session->set_flashdata('error', 'Ooooops Please try again later.');
					redirect('edit-Opportunity/'.$OpportunityID.'#documents'); 
			}	/// SUBMIT1
			
            $conditions = array( 'OpportunityID' => $OpportunityID );
            $data['opInfo'] = $this->opportunity_model->getOpportunityInformation($OpportunityID);
			if(!$data['opInfo']){ redirect('opportunities');  exit; } 
            //print_r($data['opInfo']);die;
            $data['product_list'] = $this->opportunity_model->GetOppoMaterialList($OpportunityID) ; 
			
			//$data['product_list'] = $this->Common_model->select_all_with_where('tbl_product',array("OpportunityID"=>$OpportunityID)) ; 
			$data['SiteContact'] = $this->opportunity_model->GetSiteContact($OpportunityID) ; 
			$data['opContactList'] = $this->opportunity_model->getOpportunityContactInformation($OpportunityID) ; 
			$data['TipRecords'] = $this->opportunity_model->TipListing();
			$data['TipAuthoListing'] = $this->opportunity_model->TipAuthoListing($OpportunityID);			
			//var_dump($data['TipAuthoListing']);
			//exit;
            $data['company_list'] = $this->Common_model->select_all_with_where('company',array("status"=>1)) ;
            $data['contact_list'] = $this->contacts_model->getAllContactlist();

            //$data['contact_list'] = $this->opportunity_model->getContactlist($data['opInfo']['CompanyID']) ;
            $data['county'] = $this->Common_model->get_all('county');    
            $data['allnotes'] = $this->opportunity_model->getAllNotes($OpportunityID);
            $data['documnetfiles'] = $this->opportunity_model->getAllDocumnets($OpportunityID);  
            //$data['ticketsRecords'] = $this->Tickets_model->OppTicketListing($OpportunityID);   
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Opportunity';      
            $this->global['active_menu'] = 'editopportunity';      
            $this->loadViews("Opportunity/editOpportunity", $this->global, $data, NULL);
        }
    }
	
	public function OppoTickets(){  
		$this->load->library('ajax');
		$OppoID = $this->input->post('OppoID');
		$data = $this->opportunity_model->GetTicketData($OppoID); 
		$this->ajax->send($data);
	}

    function editOpportunityCompany($OpportunityID)
    { 
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {    
		
            if($OpportunityID == null) {
                redirect('opportunities');
            }           
			if ($this->input->server('REQUEST_METHOD') === 'POST'){  
				$this->load->library('form_validation'); 
				$OpportunityID = $this->input->post('OpportunityID'); 
				$this->form_validation->set_rules('CompanyID','Company Name','trim|required');  
				 
				if($this->form_validation->run()){  
					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));   
					 
					$opportunityInfo = array();  
					$opportunityInfo = array('CompanyID'=>$CompanyID );        
					
					$cond = array('OpportunityID' => $OpportunityID );
					
					$isUpdate =  $this->Common_model->update("tbl_company_to_opportunities",$opportunityInfo, $cond);
					if($isUpdate > 0){ 
						$this->Common_model->update("tbl_tickets",$opportunityInfo, $cond);   
						$this->Common_model->update("tbl_booking_request",$opportunityInfo, $cond);   
						$this->Common_model->update("tbl_tipticket",$opportunityInfo, $cond);   
						
						$this->session->set_flashdata('success', 'Company Name updated successfully');
					}else{
						$this->session->set_flashdata('error', 'Error : Please Try Again Later.'); 
					}   
					redirect('edit-Opportunity-Company/'.$OpportunityID);
				} 
			} 
			  
            $conditions = array( 'OpportunityID' => $OpportunityID );
            $data['opInfo'] = $this->opportunity_model->getOpportunityInformation($OpportunityID);  
			$data['company_list'] = $this->Common_model->select_all_with_where('company',array("status"=>1)) ;   
			 
           // $data['ticketsRecords'] = $this->Tickets_model->OppTicketListing($OpportunityID);   
           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Company ';      
            $this->global['active_menu'] = 'editopportunity';      
            $this->loadViews("Opportunity/editCompanyOpportunity", $this->global, $data, NULL);
        }
    }

	 function ViewOpportunity($OpportunityID){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else {    
            if($OpportunityID == null){  redirect('opportunities');  }       
			
            $conditions = array( 'OpportunityID' => $OpportunityID );
            $data['opInfo'] = $this->opportunity_model->getOpportunityView($OpportunityID);
			if(!$data['opInfo']){ redirect('opportunities');  exit; } 
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View Opportunity';      
            $this->global['active_menu'] = 'viewopportunity';      
            $this->loadViews("Opportunity/viewOpportunity", $this->global, $data, NULL);
        }
    }

    function addProduct($OpportunityID){  
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
            if($OpportunityID == null){
                redirect('opportunities');
            }           
			if ($this->input->post('submit2') == 'SAVE'){	 
				$this->load->library('form_validation');
            
				$OpportunityID = $this->input->post('OpportunityID');
				
				$this->form_validation->set_rules('MaterialID','Product Code','required');   
				$this->form_validation->set_rules('DateRequired','Date Required','required'); 
				$this->form_validation->set_rules('UnitPrice','Price ','required');   
				
				if($this->form_validation->run()){  
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					$MaterialID = $this->security->xss_clean($this->input->post('MaterialID'));
					$Description = $this->security->xss_clean($this->input->post('Description'));                
					$Qty = $this->security->xss_clean($this->input->post('Qty'));
					$DateRequired = $this->security->xss_clean($this->input->post('DateRequired'));
					$UnitPrice = $this->security->xss_clean($this->input->post('UnitPrice'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$JobNo = $this->security->xss_clean($this->input->post('JobNo'));
					$Comments = $this->security->xss_clean($this->input->post('Comments')); 
					$ProductInfo = $this->security->xss_clean($this->input->post('ProductInfo')); 
					 
					$date = str_replace('/', '-', $DateRequired); 
					$DateRequired =   date('Y-m-d  H:i:s',strtotime($date)); 
					 
					$opportunityInfo = array();  
					$opportunityInfo = array('OpportunityID'=>$OpportunityID,'LorryType'=>$LorryType, 'MaterialID'=>$MaterialID, 'Description'=>$Description, 'Qty'=> $Qty,
					'DateRequired'=>$DateRequired ,'UnitPrice'=>$UnitPrice ,'PurchaseOrderNo'=>$PurchaseOrderNo ,'JobNo'=>$JobNo ,'Comments'=>$Comments ,'ProductInfo'=>$ProductInfo ,  
					'CreateUserID'=>$this->session->userdata['userId'],'EditUserID'=>$this->session->userdata['userId']);        
					 
					$ProductID = $this->Common_model->insert("tbl_product",$opportunityInfo); 
					//$this->Common_model->update("opportunities",$opportunityInfo, $cond); 
					if($ProductID){ 
					
						$this->session->set_flashdata('success', 'Product Added successfully');
						
						/* ========================================================================= */
						$ProductInfoJson = json_encode($opportunityInfo); 
								
						$SiteLogInfo = array('TableName'=>'tbl_product' ,'PrimaryID'=>$ProductID, 'UpdateType'=>'1','ProductID'=>$ProductID, 
						'UpdatedValue'=>$ProductInfoJson, 'UpdatedByUserID'=>$this->session->userdata['userId'],
						'SitePage'=>'Add Product Opportunity','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
						'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);   
						/* ========================================================================= */
					}else{
						$this->session->set_flashdata('error', 'Please Try Again Later...');
					}
					 
					redirect('edit-Opportunity/'.$OpportunityID.'#product');
				}  
			}  
            $data['opInfo'] = $this->opportunity_model->getOpportunityInformation($OpportunityID);
			$Material = $this->opportunity_model->getMaterialList(); 	
	        $data['Material']=$Material;

            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add Product ';      
            $this->global['active_menu'] = 'addproduct';      
            $this->loadViews("Opportunity/addProduct", $this->global, $data, NULL);
        }
    }
	
    function editProduct($productID){  
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {    
            if($productID == null)
            {
                redirect('opportunities');
            }         
			
			if ($this->input->post('submit2') == 'SAVE'){	
				 
				$this->load->library('form_validation');
              
				//$this->form_validation->set_rules('MaterialID','Product Code','required');  
				//$this->form_validation->set_rules('DateRequired','Date Required','required'); 
				$this->form_validation->set_rules('UnitPrice','Price ','required');  
				  
				if($this->form_validation->run())
				{ 
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					//$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
					//$MaterialID = $this->security->xss_clean($this->input->post('MaterialID'));
					$Description = $this->security->xss_clean($this->input->post('Description'));                
					$Qty = $this->security->xss_clean($this->input->post('Qty'));
					//$DateRequired = $this->security->xss_clean($this->input->post('DateRequired'));
					//$UnitPrice = $this->security->xss_clean($this->input->post('UnitPrice'));
					$PurchaseOrderNo = $this->security->xss_clean($this->input->post('PurchaseOrderNo'));
					$JobNo = $this->security->xss_clean($this->input->post('JobNo'));
					$Comments = $this->security->xss_clean($this->input->post('Comments')); 
					$ProductInfo = $this->security->xss_clean($this->input->post('ProductInfo')); 
					 
					//$date = str_replace('/', '-', $DateRequired); 
					//$DateRequired =   date('Y-m-d  H:i:s',strtotime($date)); 
						
					$opportunityInfo = array();  
					/*$opportunityInfo = array('MaterialID'=>$MaterialID,'LorryType'=>$LorryType, 'Description'=>$Description, 'Qty'=> $Qty,
					'DateRequired'=>$DateRequired ,'UnitPrice'=>$UnitPrice ,'PurchaseOrderNo'=>$PurchaseOrderNo ,'JobNo'=>$JobNo ,'Comments'=>$Comments ,'ProductInfo'=>$ProductInfo , 
					'EditUserID'=>$this->session->userdata['userId']);        */
					
					$opportunityInfo = array(  'Description'=>$Description, 'Qty'=> $Qty, 
					'PurchaseOrderNo'=>$PurchaseOrderNo ,'JobNo'=>$JobNo ,'Comments'=>$Comments ,'ProductInfo'=>$ProductInfo , 
					'EditUserID'=>$this->session->userdata['userId']);        
					 
					 $cond = array(
                     'productid' => $productID
                    );
					$Update = $this->Common_model->update("tbl_product",$opportunityInfo,$cond); 
					
					if($Update){ 
					
						$this->session->set_flashdata('success', 'Product Updated successfully');
						
						/* ========================================================================= */
						$ProductInfoJson = json_encode($opportunityInfo); 
						$ProductInfoCondJson = json_encode($cond); 
								
						$SiteLogInfo = array('TableName'=>'tbl_product' ,'PrimaryID'=>$productID, 'UpdateType'=>'2','ProductID'=>$productID, 
						'UpdatedValue'=>$ProductInfoJson, 'UpdatedCondition'=>$ProductInfoCondJson, 'UpdatedByUserID'=>$this->session->userdata['userId'],
						'SitePage'=>'Update Product Opportunity','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
						'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);   
						/* ========================================================================= */
					}else{
						$this->session->set_flashdata('error', 'Please Try Again Later...');
					}  
					 
					redirect('edit-Opportunity/'.$OpportunityID.'#product');
				} 
			
			}	/// SUBMIT
			 
            $data['prodInfo'] = $this->opportunity_model->getProductInformation($productID);
			$Material = $this->opportunity_model->getMaterialList(); 	
	        $data['Material']=$Material;
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Product ';      
            $this->global['active_menu'] = 'editproduct';      
            $this->loadViews("Opportunity/editProduct", $this->global, $data, NULL);
        }
    } 

    function addContact($OpportunityID)
    {  
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {    
            if($OpportunityID == null)
            {
                redirect('opportunities');
            }    
			
			if ($this->input->post('submit2') == 'SAVE'){	
			
				$this->load->library('form_validation');
            
				$OpportunityID = $this->input->post('OpportunityID');
				
				//$this->form_validation->set_rules('Title','Title','trim|required|max_length[128]'); 
				$this->form_validation->set_rules('ContactName','Contact Name','trim|required|max_length[128]'); 
				//$this->form_validation->set_rules('EmailAddress','Email Address','trim|required|valid_email|max_length[128]');
				//$this->form_validation->set_rules('PhoneNumber','Phone Number','trim|required|max_length[12]');
				//$this->form_validation->set_rules('PhoneExtension','Phone Extension','trim|required|max_length[10]');
				$this->form_validation->set_rules('MobileNumber','Mobile Number','trim|required|max_length[12]');
				//$this->form_validation->set_rules('Position','Position','trim|required|max_length[100]');
				//$this->form_validation->set_rules('Department','Department','required|max_length[100]'); 
				 
				
				if($this->form_validation->run())
				{ 
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));
					$ContactID = $this->generateRandomString(); 
					$Title = $this->security->xss_clean($this->input->post('Title'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));                
					$EmailAddress = $this->security->xss_clean($this->input->post('EmailAddress'));
					$PhoneNumber = $this->security->xss_clean($this->input->post('PhoneNumber'));
					//$PhoneExtension = $this->security->xss_clean($this->input->post('PhoneExtension'));
					$MobileNumber = $this->security->xss_clean($this->input->post('MobileNumber'));
					$Position = $this->security->xss_clean($this->input->post('Position'));
					//$Department = $this->security->xss_clean($this->input->post('Department')); 
					
					$contactInfo = array('ContactID'=>$ContactID,'ContactIDMapKey'=>$OpportunityID,'Title'=>$Title, 'ContactName'=>$ContactName, 
					'EmailAddress'=> $EmailAddress,'PhoneNumber'=>$PhoneNumber , 
					'MobileNumber'=>$MobileNumber ,'Position'=>$Position , 'CreateUserID'=>$this->session->userdata['userId'] ,
					'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');                
					
					$this->contacts_model->addNewContacts($contactInfo); 
					
					$rel = array('OpportunityID'=>$OpportunityID, 'ContactID'=>$ContactID);
					$this->Common_model->insert("tbl_opportunity_to_contact",$rel); 
 
					$this->session->set_flashdata('success', 'Contact Added successfully');
					 
					redirect('edit-Opportunity/'.$OpportunityID);
				} 
			
			}	/// SUBMIT
			 
            $data['opInfo'] = $this->opportunity_model->getOpportunityInformation($OpportunityID);
  
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add Contact ';      
            $this->global['active_menu'] = 'addContact';      
            $this->loadViews("Opportunity/addContact", $this->global, $data, NULL);
        }
    }

    function editContact($contactID)
    {  
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';
             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {    
            if($contactID == null)
            {
                redirect('opportunities');
            }         
			
			if ($this->input->post('submit2') == 'SAVE'){	
				 
				$this->load->library('form_validation');
              
				//$this->form_validation->set_rules('Title','Title','trim|required|max_length[128]'); 
				$this->form_validation->set_rules('ContactName','Contact Name','trim|required|max_length[128]'); 
				//$this->form_validation->set_rules('EmailAddress','Email Address','trim|required|valid_email|max_length[128]');
				//$this->form_validation->set_rules('PhoneNumber','Phone Number','trim|required|max_length[12]');
				//$this->form_validation->set_rules('PhoneExtension','Phone Extension','trim|required|max_length[10]');
				$this->form_validation->set_rules('MobileNumber','Mobile Number','trim|required|max_length[12]');
				//$this->form_validation->set_rules('Position','Position','trim|required|max_length[100]');
				//$this->form_validation->set_rules('Department','Department','required|max_length[100]'); 
				  
				  
				if($this->form_validation->run())
				{ 
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID')); 
					$Title = $this->security->xss_clean($this->input->post('Title'));
					$ContactName = $this->security->xss_clean($this->input->post('ContactName'));                
					$EmailAddress = $this->security->xss_clean($this->input->post('EmailAddress'));
					$PhoneNumber = $this->security->xss_clean($this->input->post('PhoneNumber'));
					//$PhoneExtension = $this->security->xss_clean($this->input->post('PhoneExtension'));
					$MobileNumber = $this->security->xss_clean($this->input->post('MobileNumber'));
					$Position = $this->security->xss_clean($this->input->post('Position'));
					//$Department = $this->security->xss_clean($this->input->post('Department'));  
					 
					$contactInfo = array();  
					$contactInfo = array('Title'=>$Title, 'ContactName'=>$ContactName, 
					'EmailAddress'=> $EmailAddress,'PhoneNumber'=>$PhoneNumber , 
					'MobileNumber'=>$MobileNumber ,'Position'=>$Position , 'EditUserID'=>$this->session->userdata['userId']);         
					$cond = array(  'contactID' => $contactID  );
					
					$this->Common_model->update("tbl_contacts",$contactInfo,$cond);    
					$this->session->set_flashdata('success', 'Contact has been updated successfully');
					 
					redirect('edit-Opportunity/'.$OpportunityID);
				} 
			
			}	/// SUBMIT
			 
            $data['contactInfo'] = $this->opportunity_model->getContactInformation($contactID);
  
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Contact ';      
            $this->global['active_menu'] = 'editContact';      
            $this->loadViews("Opportunity/editContact", $this->global, $data, NULL);
        }
    } 
    
    /**
     * This function is used to edit the Contact information system
     */
    function editOpportunitysubmit()
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
            
            $OpportunityID = $this->input->post('OpportunityID');
            
            $this->form_validation->set_rules('OpportunityName','OpportunityName','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('Street1','Street1','trim|required|max_length[128]');            
            //$this->form_validation->set_rules('Street2','Street2','trim|required|max_length[100]');
            $this->form_validation->set_rules('Town','Town','trim|required|max_length[100]');
            $this->form_validation->set_rules('County','County','trim|required|max_length[10]');
            $this->form_validation->set_rules('PostCode','PostCode','trim|required|max_length[100]');
            //$this->form_validation->set_rules('PO_Notes','PO_Notes','required'); 
            //$this->form_validation->set_rules('CompanyID','CompanyID','required'); 
            //$this->form_validation->set_rules('ContactID','ContactID','required'); 
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOpportunity($OpportunityID);
            }
            else
            {
                $OpportunityName = $this->security->xss_clean($this->input->post('OpportunityName'));
                $Street1 = $this->security->xss_clean($this->input->post('Street1'));                
                $Street2 = $this->security->xss_clean($this->input->post('Street2'));
                $Town = $this->security->xss_clean($this->input->post('Town'));
                $County = $this->security->xss_clean($this->input->post('County'));
                $PostCode = $this->security->xss_clean($this->input->post('PostCode'));
                $PO_Notes = $this->security->xss_clean($this->input->post('PO_Notes'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID')); 
                $ContactID = $this->security->xss_clean($this->input->post('ContactID')); 
                $DocumentDetail = $this->security->xss_clean($this->input->post('DocumentDetail'));              
                
                
                $opportunityInfo = array(); 
              
                
                $opportunityInfo = array('OpportunityName'=>$OpportunityName, 'Street1'=>$Street1, 'Street2'=> $Street2,
                'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode ,'PO_Notes'=>$PO_Notes ,'EditUserID'=>$this->session->userdata['userId'] );        
                
                $cond = array(
                     'OpportunityID' => $OpportunityID
                    );
                $this->Common_model->update("opportunities",$opportunityInfo, $cond);

                $rel = array('CompanyID'=>$CompanyID);
                $this->Common_model->update("company_to_opportunities",$rel, $cond);   

                $rel = array('ContactID'=>$ContactID);
                $this->Common_model->update("opportunity_to_contact",$rel, $cond);

                $name_array = array();
                $count = count($_FILES['DocumentAttachment']['size']);

    //var_dump($_POST);
	//var_dump($_FILES);
	//exit;            

                if($_FILES['DocumentAttachment']['size']['0'] > 0 ){

                foreach($_FILES as $key=>$value){
					for($s=0; $s<=$count-1; $s++) {
						$_FILES['DocumentAttachment']['name']=$value['name'][$s];
						$_FILES['DocumentAttachment']['type']    = $value['type'][$s];
						$_FILES['DocumentAttachment']['tmp_name'] = $value['tmp_name'][$s];
						$_FILES['DocumentAttachment']['error']       = $value['error'][$s];
						$_FILES['DocumentAttachment']['size']    = $value['size'][$s];   
						
						//$config['upload_path']          = WEB_ROOT_PATH.'assets/Documents/';
						$config['upload_path']          = WEB_ROOT_PATH.'assets/Documents/';
						$config['allowed_types'] = '*';
						$config['max_size'] = 1024 * 8;
						$config['encrypt_name'] = TRUE;
						$this->load->library('upload', $config);
						$this->upload->initialize($config); 
						$this->upload->do_upload('DocumentAttachment');        
						$data = $this->upload->data();
						$name_array[] = $data['file_name'];    
						
						$DocumentID = $this->generateRandomString(); 
						$DocumentInfo = array('DocumentID'=>$DocumentID,'DocumentAttachment'=>$data['file_name'], 'DocumentDetail'=> $_POST['DocumentDetail'][$s],
						'DocumentType'=> $_POST['DocumentType'][$s], 'CreatedUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');
						$this->Common_model->insert("documents",$DocumentInfo); 
						$rel = array('OpportunityID'=>$OpportunityID, 'DocumentID'=>$DocumentID);
						$this->Common_model->insert("opportunity_to_document",$rel);  
					}
                } 

               // $Documentsarray =array_combine($DocumentDetail,$name_array);
              //  foreach ($Documentsarray as $key => $value) { 
				//	$DocumentID = $this->generateRandomString(); 
				//	$DocumentInfo = array('DocumentID'=>$DocumentID,'DocumentAttachment'=>$value, 'DocumentDetail'=> $key,
				//						 'CreatedUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');
				//	$this->Common_model->insert("documents",$DocumentInfo); 
				//	$rel = array('OpportunityID'=>$OpportunityID, 'DocumentID'=>$DocumentID);
				//	$this->Common_model->insert("opportunity_to_document",$rel);                    
               // }

                }


                
                $this->session->set_flashdata('success', 'Contact updated successfully');
                
                redirect('opportunities');
            }
        }
    }    
 
    function deleteOpportunity(){
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error'; 
            $this->loadViews("permission", $this->global, $data, NULL);
        }else {
            $OpportunityID = $this->input->post('OpportunityID'); 
			$CountTickets = $this->Common_model->CheckOppoTicket($OpportunityID);
			$CountBooking = $this->Common_model->CheckBooking($OpportunityID);
			$CountTip = $this->Common_model->CheckOppoTip($OpportunityID);
			$CountTipAutho = $this->Common_model->CheckOppoTipAutho($OpportunityID);
			$CountNotes = $this->Common_model->CheckOppoNotes($OpportunityID);
			$CountContacts = $this->Common_model->CheckOppoContacts($OpportunityID);
			$CountDocument = $this->Common_model->CheckOppoDocument($OpportunityID);
			
			if($CountTickets[0]['ccnt']==0 && $CountBooking[0]['ccnt']==0 && $CountTip[0]['ccnt']==0 
			&& $CountNotes[0]['ccnt']==0 &&   $CountDocument[0]['ccnt']==0){
				
				$con = array('OpportunityID'=>$OpportunityID);  
				
				if($CountTipAutho[0]['ccnt']!=0 ){  $result2 = $this->Common_model->delete('tbl_opportunity_tip', $con); }
				if($CountContacts[0]['ccnt']!=0 ){  $result3 = $this->Common_model->delete('tbl_opportunity_to_contact', $con); }
				
				$result = $this->Common_model->delete('opportunities', $con);
				$result1 = $this->Common_model->delete('tbl_company_to_opportunities', $con);
				if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
				else { echo(json_encode(array('status'=>FALSE))); }
				
			}else{
				echo(json_encode(array('status'=>FALSE,'count_ticket'=>$CountTickets[0]['ccnt'],'count_booking'=>$CountBooking[0]['ccnt'],'count_tip'=>$CountTip[0]['ccnt'],'count_tipautho'=>$CountTipAutho[0]['ccnt'], 
				'count_notes'=>$CountNotes[0]['ccnt'],'count_contacts'=>$CountContacts[0]['ccnt'],'count_document'=>$CountDocument[0]['ccnt'] ))); 
			}	
        }
    } 
	 
    function GetMaterialDetails(){

        if($_POST){
             $id = $_POST['id'];
             $result = $this->opportunity_model->GetMaterialDetails($id);
             $aray=array();
             if($result){ 
                $MaterialName  = $result->MaterialName;
                $aray = array('MaterialName' =>$MaterialName );
             }
             echo json_encode($aray);
        }
    }



     /**
     * This function is used to load the add new form
     */
    function addnewopportunitynoteajax()
    {                 
            $OpportunityID = $this->input->post('OpportunityID');
            $NoteType = $this->input->post('NoteType');
            $Regarding = $this->input->post('Regarding');   
            $IsActive = $this->input->post('IsActive');
            $NoteAttachement = ""; 

            if($_FILES['NoteAttachement']['size'] > 0 ){          

            $config['upload_path']          = WEB_ROOT_PATH.'assets/Notes/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;
 
           $this->load->library('upload', $config);
 
            if (!$this->upload->do_upload('NoteAttachement'))
            {
                 echo 'invalid';die;

            }else{

                $data = $this->upload->data();              
                $NoteAttachement = $data['file_name'];               
            }

        }

            $NoteID = $this->generateRandomString();
            $notesInfo = array('NotesID'=>$NoteID,'NoteType'=>$NoteType, 'Regarding'=> $Regarding,
                                    'IsActive'=>$IsActive ,'NoteAttachement'=>$NoteAttachement , 'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');               
                
           $this->Common_model->insert("notes",$notesInfo); 
         
           $rel = array('NoteID'=>$NoteID, 'OpportunityID'=>$OpportunityID);
           $this->Common_model->insert("opportunity_to_note",$rel);

           $noteInfo = $this->opportunity_model->getSingleNote($NoteID);           
           if($noteInfo->NoteType==1) $type = "Private"; else $type = "Public";   
           if($NoteAttachement!="") $NoteAttachement = '<a href="'.base_url('assets/Notes/').$NoteAttachement.'">Download</a>';
           else $NoteAttachement = "No";    

           $html = '<div class="col-md-12"> <div class="box box-success box-solid"> <div class="box-header with-border"> <h3 class="box-title">'.$noteInfo->name.'</h3> <div class="box-tools pull-right"> <button type="button" class="btn btn-box-tool remove-note-button" id="'.$noteInfo->NotesID.'" ><i class="fa fa-times"></i></button> </div></div> <div class="box-body">'.$noteInfo->Regarding.'<span class="label label-info pull-right"> '.$type.' </span> <div> Attachement : '.$NoteAttachement.' </div> <div> Date : '.date("d-m-Y", strtotime($noteInfo->CreateDate)).' </div> </div> </div> </div>'; 

           echo  $html;
        
    } 


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteopportunityNotes()
    {
        
            $NotesID = $this->input->post('NotesID'); 

             $con = array('NotesID'=>$NotesID); 
             $this->Common_model->delete('notes', $con);

             $con = array('NoteID'=>$NotesID); 
             $result = $this->Common_model->delete('opportunity_to_note', $con);

            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
            
            
        
    }


     /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
	function OppoChangeStatus()
    {
        
            $OpportunityID = $this->input->post('OpportunityID');
            $table = $this->input->post('table');
            $Status = $this->input->post('Status');

            $companyInfo = array('Status'=>$Status,'EditUserID'=>$this->session->userdata['userId'], 'EditUserDate'=>date('Y-m-d H:i:s'));
            
            $cond = array(  'OpportunityID' => $OpportunityID  );

            $result =  $this->Common_model->update($table,$companyInfo, $cond);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        
    }
    function deleteOpportunityDocuments()
    {
        
            $DocumentID = $this->input->post('DocumentID'); 

             $con = array('DocumentID'=>$DocumentID); 
             $this->Common_model->delete('documents', $con);

             $con = array('DocumentID'=>$DocumentID); 
             $result = $this->Common_model->delete('opportunity_to_document', $con);

            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
            
            
        
    }


    
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : 404 - Page Not Found';
        $this->global['active_menu'] = 'opportunity';        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
   
}

?>
