<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Roles (RolesController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Roles extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('roles_model');     
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load all the roles
     */
    public function index()
    {

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->roles_model->rolesListingCount($searchText);

            $returns = $this->paginationCompress ( "/", $count, 10 );
            
            $data['rolesRecords'] = $this->roles_model->rolesListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.': User Roles';
            $this->global['active_menu'] = 'roles'; 
            
            $this->loadViews("Roles/roles", $this->global, $data, NULL);
        }
    }


    /**
     * This function is used to load the add new form
     */
    function addNewRoles()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data = array();
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add User Role';
            $this->global['active_menu'] = 'roles';
            $this->loadViews("Roles/addNewRoles", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to add new user to the system
     */
    function addNewRolesSubmit()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('role','role','trim|required|max_length[128]');            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {               
                $role = $this->input->post('role');                
				$logout_time = $this->input->post('logout_time'); 
                $userInfo = array('role'=>$role,'logout_time'=>$logout_time,'role_permission'=>json_encode($_POST['role_permission']));                
                $result = $this->Common_model->insert("roles",$userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'User role created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User role creation failed');
                }
                
                redirect('roles');
            }
        }
    }  

    
    /**
     * This function is used  roles edit information
     * @param number $userId : Optional : This is role id
     */
    function editroles($roleId = NULL)
    {

       if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($roleId == null)
            {
                redirect('roles');
            }
            
            $data['rolesInfo'] = $this->roles_model->getRolesInfo($roleId); 

            $this->global['pageTitle'] = WEB_PAGE_TITLE.': Edit Roles';
             $this->global['active_menu'] = 'roles';
            
            $this->loadViews("Roles/editroles", $this->global, $data, NULL);
        }
    }    
    
    /**
     * This function is used to edit the role information
     */
    function editrolessubmit()
    {

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $roleId = $this->input->post('roleId');
            
            $this->form_validation->set_rules('role','User Role','trim|required|max_length[128]');
            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editroles($roleId);
            }
            else
            {
                $role = ucwords(strtolower($this->security->xss_clean($this->input->post('role'))));
                              
				$logout_time = $this->input->post('logout_time');                
                
                $rolesInfo = array('role'=>$role,'logout_time'=>$logout_time,'role_permission'=>json_encode($_POST['role_permission']));                
                
                $result = $this->roles_model->editRoles($rolesInfo, $roleId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Role updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Role updation failed');
                }
                
                redirect('roles');
            }
        }
    }


    /**
     * This function is used to delete the user role using roleId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteRoles()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $roleId = $this->input->post('roleId');            
            
            $result = $this->roles_model->deleteRoles($roleId);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }    
   
  
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.': 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }


}

?>