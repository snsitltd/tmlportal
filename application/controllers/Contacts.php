<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Contacts (contactController)
 * User Class to control all user related operations.
 * @author : Vikash R
 * @version : 1.0
 * @since : 10 Aug 2018
 */
class Contacts extends BaseController
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
        $this->load->model('contacts_model');       
        $this->isLoggedIn();

        $roleCheck = $this->Common_model->checkpermission('contact');

         $this->global['isView'] = $this->isView = $roleCheck->view;   
         $this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
         $this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
         $this->global['isDelete'] = $this->isDelete = $roleCheck->delete; 
         $this->global['active_menu'] = 'dashboard';   
    }
    
    /**
     * This function used to load the first screen of the contacts
     */
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
                       
            //$data['contactsRecords'] = $this->contacts_model->contactsListing();   
			$data = array();
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Contact Listing';
            $this->global['active_menu'] = 'contact';            
            $this->loadViews("Contacts/contacts", $this->global, $data, NULL);
        }
    }
	public function AJAXContacts(){  
		$this->load->library('ajax');
		$data = $this->contacts_model->GetContactData();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}	
    

    /**
     * This function is used to load the add new form
     */
    function addNewContacts()
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
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New Contact';
            $this->global['active_menu'] = 'addcontact';
            $data['company_list'] = $this->Common_model->select_all_with_where('company',array("status"=>1)) ; 
            $data['county'] = $this->Common_model->get_all('county');
            $data['country'] = $this->Common_model->get_all('countries');
            $this->loadViews("Contacts/addNewContacts", $this->global, $data, NULL);
        }
    }

    
    /**
     * This function is used to add new contacts to the system
     */
    function addnewcontactsubmit()
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
            
            $this->form_validation->set_rules('Title','Title','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('ContactName','Contact Name','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('EmailAddress','Email Address','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('PhoneNumber','Phone Number','trim|required|max_length[10]');
            $this->form_validation->set_rules('PhoneExtension','Phone Extension','trim|required|max_length[10]');
            $this->form_validation->set_rules('MobileNumber','Mobile Number','trim|required|max_length[10]');
            $this->form_validation->set_rules('Position','Position','trim|required|max_length[100]');
            $this->form_validation->set_rules('Department','Department','required|max_length[100]');
            $this->form_validation->set_rules('CompanyID','CompanyID','required');            
            
            if($this->form_validation->run() == FALSE)
            {
                
                $this->addNewContacts();
            }
            else
            {

                $ContactID = $this->generateRandomString(); 
                $Title = $this->security->xss_clean($this->input->post('Title'));
                $ContactName = $this->security->xss_clean($this->input->post('ContactName'));                
                $EmailAddress = $this->security->xss_clean($this->input->post('EmailAddress'));
                $PhoneNumber = $this->security->xss_clean($this->input->post('PhoneNumber'));
                $PhoneExtension = $this->security->xss_clean($this->input->post('PhoneExtension'));
                $MobileNumber = $this->security->xss_clean($this->input->post('MobileNumber'));
                $Position = $this->security->xss_clean($this->input->post('Position'));
                $Department = $this->security->xss_clean($this->input->post('Department')); 
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID')); 

                
                $contactInfo = array('ContactID'=>$ContactID,'Title'=>$Title, 'ContactName'=>$ContactName, 'EmailAddress'=> $EmailAddress,'PhoneNumber'=>$PhoneNumber ,'PhoneExtension'=>$PhoneExtension ,'MobileNumber'=>$MobileNumber ,'Position'=>$Position ,'Department'=>$Department,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');                
                
                $this->contacts_model->addNewContacts($contactInfo); 
                $rel = array('CompanyID'=>$CompanyID, 'ContactID'=>$ContactID);
                $this->contacts_model->relationWithContact($rel);
                $this->session->set_flashdata('success', 'New contact created successfully'); 
                redirect('contacts');
            }
        }
    }

    
    /**
     * This function is used load contacts edit information
     * @param number $ContactID : Optional : This is contact id
     */
    function editContacts($ContactID)
    {
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {     
            if($ContactID == null)
            {
                redirect('contacts');
            }          
            
             $conditions = array(
                 'ContactID' => $ContactID
                );

            $data['cInfo'] = $this->contacts_model->getContactInformation($ContactID);
            $data['company_list'] = $this->Common_model->select_all_with_where('company',array("status"=>1)) ; 
            $data['county'] = $this->Common_model->get_all('county');
            $data['country'] = $this->Common_model->get_all('countries');            
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Contact';
            $this->global['active_menu'] = 'editcontact';            
            $this->loadViews("Contacts/editContacts", $this->global, $data, NULL);
        }
    }
    
	function viewContacts($ContactID)
    {
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{     
            if($ContactID == null){
                redirect('contacts');
            }          
            
            $conditions = array(  'ContactID' => $ContactID );
            $data['cInfo'] = $this->contacts_model->getViewContact($ContactID); 
             
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View Contact';
            $this->global['active_menu'] = 'viewcontact';            
            $this->loadViews("Contacts/viewContacts", $this->global, $data, NULL);
        }
    }
    
    
    /**
     * This function is used to edit the Contact information system
     */
    function editContactsSubmit()
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
            
            $ContactID = $this->input->post('ContactID');
            
            $this->form_validation->set_rules('Title','Title','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('ContactName','Contact Name','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('EmailAddress','Email Address','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('PhoneNumber','Phone Number','trim|required|max_length[10]');
            $this->form_validation->set_rules('PhoneExtension','Phone Extension','trim|required|max_length[10]');
            $this->form_validation->set_rules('MobileNumber','Mobile Number','trim|required|max_length[10]');
            $this->form_validation->set_rules('Position','Position','trim|required|max_length[100]');
            $this->form_validation->set_rules('Department','Department','required|max_length[100]');
            $this->form_validation->set_rules('CompanyID','CompanyID','required');
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editContacts($ContactID);
            }
            else
            {
                $Title = $this->security->xss_clean($this->input->post('Title'));
                $ContactName = $this->security->xss_clean($this->input->post('ContactName'));                
                $EmailAddress = $this->security->xss_clean($this->input->post('EmailAddress'));
                $PhoneNumber = $this->security->xss_clean($this->input->post('PhoneNumber'));
                $PhoneExtension = $this->security->xss_clean($this->input->post('PhoneExtension'));
                $MobileNumber = $this->security->xss_clean($this->input->post('MobileNumber'));
                $Position = $this->security->xss_clean($this->input->post('Position'));
                $Department = $this->security->xss_clean($this->input->post('Department'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));                
                
                
                $contactInfo = array(); 
              
                
                $contactInfo = array('Title'=>$Title, 'ContactName'=>$ContactName, 'EmailAddress'=> $EmailAddress,
                                    'PhoneNumber'=>$PhoneNumber ,'PhoneExtension'=>$PhoneExtension ,'MobileNumber'=>$MobileNumber ,'Position'=>$Position ,'Department'=>$Department,'EditUserID'=>$this->session->userdata['userId']);         
                
                $cond = array(
                     'ContactID' => $ContactID
                    );
                $this->Common_model->update("contacts",$contactInfo, $cond);

                $rel = array('CompanyID'=>$CompanyID);
                $this->Common_model->update("company_to_contact",$rel, $cond);               
                
                $this->session->set_flashdata('success', 'Contact updated successfully');
                
                redirect('contacts');
            }
        }
    }


    /**
     * This function is used to get the company details using CompanyID
     * @return boolean $result : TRUE / FALSE
     */
    function getCompanyDetails(){
		$company_id = $this->input->post('company_id');                       
		
		$conditions = array(
			 'CompanyID' => $company_id
		);
		$result = $this->Common_model->select_where("company",$conditions);  
		
		$result['contact_list'] = $this->contacts_model->getContactlist($company_id);
		//$result= $this->contacts_model->getContactlist($company_id);
		if ($result > 0) { echo(json_encode($result)); }
		else { echo(json_encode(array('status'=>FALSE))); }
        
    }


    /**
     * This function is used to delete the contact using ContactID
     * @return boolean $result : TRUE / FALSE
     */
    function deleteContacts()
    {
        if($this->isDelete == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else {     

            $ContactID = $this->input->post('ContactID');  
            $con = array('ContactID'=>$ContactID);       
            //$result = $this->Common_model->delete('contacts', $con);
			//$result1 = $this->Common_model->delete('tbl_opportunity_to_contact', $con);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
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
   
}

?>
