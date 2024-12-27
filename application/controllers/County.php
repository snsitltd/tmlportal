<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Contacts (contactController)
 * User Class to control all user related operations.
 * @author : Vikash R
 * @version : 1.0
 * @since : 10 Aug 2018
 */
class County extends BaseController
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
        $this->load->model('county_model');       
        $this->isLoggedIn(); 

        $roleCheck = $this->Common_model->checkpermission('county'); 

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
                       
            $data['countyList'] = $this->Common_model->get_all('county');   
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : County Listing';
            $this->global['active_menu'] = 'county';            
            $this->loadViews("County/County", $this->global, $data, NULL);
        }
    }
    

     
    /**
     * This function is used to add new contacts to the system
     */
    function addnewcountysubmit()
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
            
            $this->form_validation->set_rules('County','County','trim|required|max_length[128]'); 
            
            if($this->form_validation->run() == FALSE)
            {
                
                $this->county();
            }
            else
            {
                
                $County = $this->security->xss_clean($this->input->post('County'));                              
                
                $CountyInfo = array('County'=>$County); 
                $result = $this->Common_model->insert("county",$CountyInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New county created successfully');
                    redirect('county');
                }
                else
                {
                    $this->session->set_flashdata('error', 'County creation failed');
                    redirect('county');
                }
                
                
            }
        }
    }

    
      
    /**
     * This function is used to edit the Contact information system
     */
    function editcountysubmit()
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
            
            $ID = $this->input->post('ID');
            
            $this->form_validation->set_rules('County','County','trim|required|max_length[128]'); 
            
            if($this->form_validation->run() == FALSE)
            {
                $this->county();
            }
            else
            {
                $County = $this->security->xss_clean($this->input->post('County'));                               
                
                
                $contactInfo = array();
              
                
                $countyInfo = array('County'=>$County);         
                
                $cond = array(
                     'ID' => $ID
                    );
                $this->Common_model->update("county",$countyInfo, $cond);                
                $this->session->set_flashdata('success', 'County updated successfully');                
                redirect('county');

            }
        }
    }
    

    /**
     * This function is used to delete the contact using ContactID
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCounty()
    {
        if($this->isDelete == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {   
            $ID = $this->input->post('ID'); 

            $con = array('ID'=>$ID);           
            
            $result = $this->Common_model->delete('county', $con);
            
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
