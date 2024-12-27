<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
 
class Company extends BaseController
{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('company_model');        
        $this->isLoggedIn(); 
        $roleCheck = $this->Common_model->checkpermission('company');

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
            //$data['companyRecords'] = $this->company_model->companyListing(); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Company Listing';
            $this->global['active_menu'] = 'companies';            
            $this->loadViews("Company/companies", $this->global, $data, NULL);
        }
    }    
	
	public function AJAXCompanies(){  
		$this->load->library('ajax');
		$data = $this->company_model->GetCompanyData();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}
    /**
     * This function is used to load the add new form
     */
    function addNewCompany()
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
            $data['county'] = $this->company_model->getCounty();
            $data['country'] = $this->company_model->getCountry();            
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New Company';
            $this->global['active_menu'] = 'addcompanies';

            $this->loadViews("Company/addNewCompany", $this->global, $data, NULL);
        }
    }

    
    /**
     * This function is used to add new user to the system
     */
    function addNewCompanySubmit()
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
            
            $this->form_validation->set_rules('CompanyName','Company Name','trim|required|max_length[128]');            
            //$this->form_validation->set_rules('EmailID','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('Street1','Street 1 ','trim|required|max_length[128]');
            //$this->form_validation->set_rules('Street2','Street 2','trim|required|max_length[128]');
            $this->form_validation->set_rules('Town','Town','trim|required|max_length[128]');
            $this->form_validation->set_rules('County','County','trim|required|max_length[128]');
            //$this->form_validation->set_rules('PostCode','PostCode','trim|required|max_length[20]');
            //$this->form_validation->set_rules('Phone1','Mobile Number 1','required|min_length[10]|max_length[10]');             
            //$this->form_validation->set_rules('Fax','Fax','trim|required|max_length[20]');
            //$this->form_validation->set_rules('Website','Website','trim|required|max_length[100]');
            $this->form_validation->set_rules('Country','Country','trim|required|max_length[5]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNewCompany();
            }
            else
            {
                $CompanyID = $this->generateRandomString();
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $EmailID = $this->security->xss_clean($this->input->post('EmailID'));                
                $Street1 = $this->security->xss_clean($this->input->post('Street1'));
                $Street2 = $this->security->xss_clean($this->input->post('Street2'));
                $Town = $this->security->xss_clean($this->input->post('Town'));
                $County = $this->security->xss_clean($this->input->post('County'));
                $PostCode = $this->security->xss_clean($this->input->post('PostCode'));
                $Phone1 = $this->security->xss_clean($this->input->post('Phone1'));
                $Phone2 = $this->security->xss_clean($this->input->post('Phone2'));
                $Fax = $this->security->xss_clean($this->input->post('Fax'));
                $Website = $this->security->xss_clean($this->input->post('Website'));
                $Country = $this->security->xss_clean($this->input->post('Country'));
				
				
				$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
				$CreditLimit = $this->security->xss_clean($this->input->post('CreditLimit'));
				$Outstanding = $this->security->xss_clean($this->input->post('Outstanding'));
				
				
                $DocumentDetail = $this->security->xss_clean($this->input->post('DocumentDetail'));

                $conditions = array(
                 'country_code' => $Country
                );
                $Country_name = $this->Common_model->select_where("countries",$conditions);
                
                $companyInfo = array('CompanyID'=>$CompanyID,'CompanyName'=>$CompanyName, 
				'EmailID'=>$EmailID, 'Street1'=> $Street1,'Street2'=>$Street2 ,'Town'=>$Town , 
				'County'=>$County ,'PostCode'=>$PostCode ,'Phone1'=>$Phone1 ,'Phone2'=>$Phone2 , 
				'Fax'=>$Fax ,'Website'=>$Website ,'status'=>1 ,'CountryCode'=>$Country , 
				'PaymentType'=>$PaymentType ,'CreditLimit'=>$CreditLimit ,'Outstanding'=>$Outstanding ,
				'Country'=>$Country_name['country_name'] ,'CreateUserID'=>$this->session->userdata['userId'] ,
				'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');
                
                $this->load->model('company_model');
                $this->company_model->addNewCompany($companyInfo);
                
               
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
							$config['upload_path']          = WEB_ROOT_PATH.'assets/Documents/';
							$config['allowed_types'] = '*';
							$config['max_size'] = 1024 * 8;
							$config['encrypt_name'] = TRUE;
							$this->load->library('upload', $config);
							$this->upload->do_upload('DocumentAttachment');        
							$data = $this->upload->data();
							$name_array[] = $data['file_name'];                
						} 
					} 

					$Documentsarray =array_combine($DocumentDetail,$name_array);                

					foreach ($Documentsarray as $key => $value) { 

					  $DocumentID = $this->generateRandomString();
					  $DocumentInfo = array('DocumentID'=>$DocumentID,'DocumentAttachment'=>$value, 'DocumentDetail'=> $key,
										 'CreatedUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');
					 $this->Common_model->insert("documents",$DocumentInfo); 
					 $rel = array('CompanyID'=>$CompanyID, 'DocumentID'=>$DocumentID);
					 $this->Common_model->insert("company_to_document",$rel);
						
					}

                }

                $this->session->set_flashdata('success', 'New company created successfully');                
                redirect('companies');
            }
        }
    }

    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editCompany($CompanyID)
    {
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {   
            if($CompanyID == null)
            {
                redirect('companies');
            }          
            
             $conditions = array( 'CompanyID' => $CompanyID );
            $data['cInfo'] = $this->Common_model->select_where("company",$conditions);
            $data['country'] = $this->company_model->getCountry();
            $data['county'] = $this->company_model->getCounty();
            $data['allnotes'] = $this->company_model->getAllNotes($CompanyID);
            $data['documnetfiles'] = $this->company_model->getAllDocumnets($CompanyID);

            //print_r($data['documnetfiles']);die;

            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Company';
            $this->global['active_menu'] = 'editcompanies';
            
            $this->loadViews("Company/editCompany", $this->global, $data, NULL);
        }
    }
	function SageCompany($CompanyID)
    {
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {   
            if($CompanyID == null)
            {
                redirect('companies');
            }          
            
            $conditions = array( 'CompanyID' => $CompanyID );
            $data['cInfo'] = $this->Common_model->select_where("company",$conditions);   
			
            if($data['cInfo']['SageURL']==''){ redirect('companies'); exit; } 
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Sage Company Details';
            $this->global['active_menu'] = 'editcompanies';
            
            $this->loadViews("Company/SageCompany", $this->global, $data, NULL);
        }
    }

    function viewCompany($CompanyID)
    {
        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            if($CompanyID == null){ redirect('companies');  }          
            $conditions = array(  'CompanyID' => $CompanyID );
            $data['cInfo'] = $this->Common_model->select_where("company",$conditions); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View Company';
            $this->global['active_menu'] = 'viewcompanies';
            $this->loadViews("Company/viewCompany", $this->global, $data, NULL);
        }
    } 
	 
	private function set_upload_options()
		{   
		    //upload an image options
		    $config = array();
		    $config['upload_path'] = WEB_ROOT_PATH.'assets/Notes/';
		    $config['allowed_types'] = '*';
		    $config['max_size']      = '0';
		    $config['overwrite']     = FALSE;
		    return $config;
		}
    
    
    /**
     * This function is used to edit the user information
     */
    function editCompanySubmit()
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
            
            $CompanyID = $this->input->post('CompanyID');
            
            $this->form_validation->set_rules('CompanyName','Company Name','trim|required|max_length[128]');            
            //$this->form_validation->set_rules('EmailID','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('Street1','Street 1 ','trim|required|max_length[128]');
            //$this->form_validation->set_rules('Street2','Street 2','trim|required|max_length[128]');
            $this->form_validation->set_rules('Town','Town','trim|required|max_length[128]');
            $this->form_validation->set_rules('County','County','trim|required|max_length[128]');
           // $this->form_validation->set_rules('PostCode','PostCode','trim|required|max_length[20]');
           // $this->form_validation->set_rules('Phone1','Mobile Number 1','required|min_length[10]|max_length[10]');            
           // $this->form_validation->set_rules('Fax','Fax','trim|required|max_length[20]');
          //  $this->form_validation->set_rules('Website','Website','trim|required|max_length[100]');
            $this->form_validation->set_rules('Country','Country','trim|required|max_length[5]');
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editCompany($CompanyID);
            }
            else
            { 
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$AccountRef = $this->security->xss_clean($this->input->post('AccountRef'));
                $EmailID = $this->security->xss_clean($this->input->post('EmailID'));                
                $Street1 = $this->security->xss_clean($this->input->post('Street1'));
                $Street2 = $this->security->xss_clean($this->input->post('Street2'));
                $Town = $this->security->xss_clean($this->input->post('Town'));
                $County = $this->security->xss_clean($this->input->post('County'));
                $PostCode = $this->security->xss_clean($this->input->post('PostCode'));
                $Phone1 = $this->security->xss_clean($this->input->post('Phone1'));
                $Phone2 = $this->security->xss_clean($this->input->post('Phone2'));
                $Fax = $this->security->xss_clean($this->input->post('Fax'));
                $Website = $this->security->xss_clean($this->input->post('Website'));
                $Country = $this->security->xss_clean($this->input->post('Country'));
				$Status = $this->security->xss_clean($this->input->post('Status'));
				
				$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
				$CreditLimit = $this->security->xss_clean($this->input->post('CreditLimit'));
				$Outstanding = $this->security->xss_clean($this->input->post('Outstanding'));
				
                $DocumentDetail = $this->security->xss_clean($this->input->post('DocumentDetail'));

                //print_r($DocumentDetail);die;
                
                $companyInfo = array();                
               
                $conditions = array(
                 'country_code' => $Country
                );
                $Country_name = $this->Common_model->select_where("countries",$conditions);
                
                $companyInfo = array('CompanyName'=>$CompanyName,'AccountRef'=>$AccountRef, 'EmailID'=>$EmailID, 'Street1'=> $Street1,
                'Street2'=>$Street2 ,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode ,'Phone1'=>$Phone1 ,
				'Phone2'=>$Phone2 ,'Fax'=>$Fax ,'Website'=>$Website , 'CountryCode'=>$Country ,
				'PaymentType'=>$PaymentType ,'CreditLimit'=>$CreditLimit ,'Outstanding'=>$Outstanding ,'Status'=>$Status ,
				'Country'=>$Country_name['country_name'] , 'EditUserID'=>$this->session->userdata['userId']);         
                
                $cond = array(
                     'CompanyID' => $CompanyID
                    );

                $this->Common_model->update("company",$companyInfo, $cond);

                $name_array = array();
                $count = count($_FILES['DocumentAttachment']['size']);

                if($_FILES['DocumentAttachment']['size']['0'] > 0 ){

                foreach($_FILES as $key=>$value){

                for($s=0; $s<=$count-1; $s++) {
                       if($value['size'][$s]>0) {
                            $_FILES['DocumentAttachment']['name']=$value['name'][$s];
                            $_FILES['DocumentAttachment']['type']    = $value['type'][$s];
                            $_FILES['DocumentAttachment']['tmp_name'] = $value['tmp_name'][$s];
                            $_FILES['DocumentAttachment']['error']       = $value['error'][$s];
                            $_FILES['DocumentAttachment']['size']    = $value['size'][$s];   
                                 $config['upload_path']          = WEB_ROOT_PATH.'assets/Documents/';
                                $config['allowed_types'] = '*';
                                $config['max_size'] = 1024 * 8;
                                $config['encrypt_name'] = TRUE;
                            $this->load->library('upload', $config);
                            $this->upload->do_upload('DocumentAttachment');        
                            $data = $this->upload->data();
                            $name_array[] = $data['file_name'];      
                        }          
                    }

                } 
                if(!empty($name_array)){

                        $Documentsarray =array_combine($DocumentDetail,$name_array);                

                        foreach ($Documentsarray as $key => $value) {

                          $DocumentID = $this->generateRandomString();
                          $DocumentInfo = array('DocumentID'=>$DocumentID,'DocumentAttachment'=>$value, 'DocumentDetail'=> $key,
                                             'CreatedUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');
                         $this->Common_model->insert("documents",$DocumentInfo); 

                         $rel = array('CompanyID'=>$CompanyID, 'DocumentID'=>$DocumentID);
                         $this->Common_model->insert("company_to_document",$rel);
                            
                        }
                    }

                }
               
                $this->session->set_flashdata('success', 'Company updated successfully');                
                redirect('companies');
            }
        }
    }
 
	function deleteCompany(){
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            $CompanyID = $this->input->post('CompanyID');  
			$CountCom = $this->Common_model->CheckCompanyOppo($CompanyID);
			if($CountCom[0]['ccnt']==0){  
				$con = array('CompanyID'=>$CompanyID);            
				$result = $this->Common_model->delete('company', $con); 
				if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
				else { echo(json_encode(array('status'=>FALSE))); } 				
			}else{
				echo(json_encode(array('status'=>FALSE,'count'=>$CountCom[0]['ccnt'] ))); 
			}	 
        }
    }
 
    function companyChangeStatus()
    {
        
            $CompanyID = $this->input->post('CompanyID');
            $table = $this->input->post('table');
            $Status = $this->input->post('Status');

            $companyInfo = array('Status'=>$Status,'EditUserID'=>$this->session->userdata['userId'], 'EditUserDate'=>date('Y-m-d H:i:s'));
            
            $cond = array(
                     'CompanyID' => $CompanyID
                    );

            $result =  $this->Common_model->update($table,$companyInfo, $cond);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        
    }


    /**
     * This function is used to load the add new form
     */
    function addnewcompanynoteajax()
    {

                
            $CompanyID = $this->input->post('CompanyID');
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
           

           $rel = array('NoteID'=>$NoteID, 'CompanyID'=>$CompanyID);
           $this->Common_model->insert("company_to_note",$rel);

           $noteInfo = $this->company_model->getSingleNote($NoteID);           
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
    function deleteCompanyNotes()
    {
        
            $NotesID = $this->input->post('NotesID'); 

             $con = array('NotesID'=>$NotesID); 
             $this->Common_model->delete('notes', $con);

             $con = array('NoteID'=>$NotesID); 
             $result = $this->Common_model->delete('company_to_note', $con);

            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }           
            
        
    }

        /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCompanyDocuments()
    {
        
            $DocumentID = $this->input->post('DocumentID'); 

             $con = array('DocumentID'=>$DocumentID); 
             $this->Common_model->delete('documents', $con);

             $con = array('DocumentID'=>$DocumentID); 
             $result = $this->Common_model->delete('company_to_document', $con);

            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); } 
        
    }   


    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function editCompanyDocumentsSubmit()
    {
        
            $DocumentDetail = $this->input->post('DocumentDetail'); 
             $DocumentAttachment = $this->input->post('DocumentAttachment'); 
            print_r($DocumentDetail);
            print_r($DocumentAttachment);die;
        
    }
 

    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    
}

?>
