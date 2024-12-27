<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Support extends BaseController{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Support_model');        
		$this->load->helper('url');
		$this->load->helper('directory'); //load directory helper	
  		$this->load->library('image_lib');
		
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
            $data['SupportRecords'] = $this->Support_model->SupportListing(); 
			$data['SupportRecords1'] = $this->Support_model->SupportListing1(); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Support Tickets';
            $this->global['active_menu'] = 'supports';            
            $this->loadViews("Support/Supports", $this->global, $data, NULL);
        }
    }    
 
    function addSupport(){ 
		$data = array();
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
		
            $this->load->library('form_validation'); 
            $this->form_validation->set_rules('icategory',' Category ','trim|required'); 
			$this->form_validation->set_rules('ipriority',' Priority ','trim|required'); 
			$this->form_validation->set_rules('vtitle',' Title ','trim|required');             
            $this->form_validation->set_rules('ltdesc',' Description ','trim|required'); 
            
            if($this->form_validation->run()){
				 
                $icategory = $this->security->xss_clean($this->input->post('icategory')); 
				$vfile_start = $this->security->xss_clean($this->input->post('vfile_start'));
				$ipriority = $this->security->xss_clean($this->input->post('ipriority')); 
				$vtitle = $this->security->xss_clean($this->input->post('vtitle')); 
				$ltdesc = $this->security->xss_clean($this->input->post('ltdesc'));  
                
                $info = array('icategory'=>$icategory,'ipriority'=>$ipriority,  'vtitle'=>$vtitle,  'ltdesc'=>$ltdesc,  'vfile_start'=>$vfile_start,  
				'icreated_by'=>$this->session->userdata['userId'] , 'iupdated_by'=>$this->session->userdata['userId']);   
				$id = $this->Support_model->addNewSupport($info); 
				if($id){  
					$this->session->set_flashdata('success', 'New Support Ticket Created Successfully');                
				}else{
					$this->session->set_flashdata('error', 'Ooops, Please Try Again Later');                 
				}
                redirect('Supports');
            }
        }
		
		$this->load->model('Support_model');             
		
		$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New Ticket';
		$this->global['active_menu'] = 'addsupport';

		$this->loadViews("Support/addSupport", $this->global, $data, NULL); 
    }  
    function editSupport($SupportID)
    { 
            if($SupportID == null){ redirect('Supports'); }          
			
            $conditions = array( 'isupport_id' => $SupportID );
            $data['cInfo'] = $this->Common_model->select_where("tbl_support",$conditions); 
			
			if($this->session->userdata['userId'] != 1){
				if($data['cInfo']['icreated_by']!= $this->session->userdata['userId']){
					redirect('Supports'); 
				} 
			}
			
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 

				$this->load->library('form_validation'); 
				$this->form_validation->set_rules('icategory',' Category ','trim|required'); 
				$this->form_validation->set_rules('istatus',' Status ','trim|required'); 
				$this->form_validation->set_rules('ipriority',' Priority ','trim|required'); 
				$this->form_validation->set_rules('vtitle',' Title ','trim|required');             
				$this->form_validation->set_rules('ltdesc',' Description ','trim|required'); 

				if($this->form_validation->run()){
					 
					$icategory = $this->security->xss_clean($this->input->post('icategory')); 
					$istatus = $this->security->xss_clean($this->input->post('istatus')); 
					$ipriority = $this->security->xss_clean($this->input->post('ipriority')); 
					$vtitle = $this->security->xss_clean($this->input->post('vtitle')); 
					$ltdesc = $this->security->xss_clean($this->input->post('ltdesc'));  
					
					$info = array('icategory'=>$icategory,'istatus'=>$istatus,'ipriority'=>$ipriority,  'vtitle'=>$vtitle,  'ltdesc'=>$ltdesc,  
					'iupdated_by'=>$this->session->userdata['userId']);    
					$cond = array( 'isupport_id' => $SupportID );
					$id = $this->Common_model->update("support",$info, $cond);
					if($id){  
						$this->session->set_flashdata('success', 'Support Ticket has been updated Successfully');                
					}else{
						$this->session->set_flashdata('error', 'Ooops, Please Try Again Later');                 
					}
					redirect('Supports');
				}
			}

            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View Or Update Support Ticket';
            $this->global['active_menu'] = 'editsupport';
            
            $this->loadViews("Support/editSupport", $this->global, $data, NULL);
       
    }
	function addSupportComment($SupportID){ 
		$data = array();
		if($SupportID == null){ redirect('Supports'); }  
		
		if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
		
            $this->load->library('form_validation');        
            $this->form_validation->set_rules('ltdesc',' Description ','trim|required'); 
            
            if($this->form_validation->run()){
				  
				$vfile_start = $this->security->xss_clean($this->input->post('vfile_start')); 
				$ltdesc = $this->security->xss_clean($this->input->post('ltdesc'));  
                
                $info = array('ltdesc'=>$ltdesc,  'vfile_start'=>$vfile_start, 'iprimary'=>$SupportID ,  	
				'icreated_by'=>$this->session->userdata['userId'] , 'iupdated_by'=>$this->session->userdata['userId']);   
				$id = $this->Common_model->insert("support",$info); 
				if($id){  
					$this->session->set_flashdata('success', 'Comment Created Successfully');                
				}else{
					$this->session->set_flashdata('error', 'Ooops, Please Try Again Later');                 
				}
            } 
			
        } 
        redirect('viewSupport/'.$SupportID);   
    }  
	function viewSupport($SupportID)
    { 
            if($SupportID == null){ redirect('Supports'); }          
			
            $conditions = array( 'isupport_id' => $SupportID );
            $data['cInfo'] = $this->Common_model->select_where("tbl_support",$conditions);  
			
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
		
				$this->load->library('form_validation');        
				$this->form_validation->set_rules('ltdesc',' Description ','trim|required'); 
				
				if($this->form_validation->run()){
					  
					$vfile_start = $this->security->xss_clean($this->input->post('vfile_start')); 
					$isupport_id = $this->security->xss_clean($this->input->post('isupport_id'));  
					$ltdesc = $this->security->xss_clean($this->input->post('ltdesc'));  
					$istatus = $this->security->xss_clean($this->input->post('istatus'));  
					
					$uinfo = array('istatus'=>$istatus, 'iupdated_by'=>$this->session->userdata['userId']);   
					$cond = array( 'isupport_id' => $isupport_id );
					$this->Common_model->update("support",$uinfo,$cond); 
					
					$info = array('ltdesc'=>$ltdesc,  'vfile_start'=>$vfile_start, 'iprimary'=>$SupportID ,'istatus'=>2,  	
					'icreated_by'=>$this->session->userdata['userId'] , 'iupdated_by'=>$this->session->userdata['userId']);   
					$id = $this->Common_model->insert("support",$info); 
					if($id){  
						$this->session->set_flashdata('success', 'Comment Created Successfully');                
					}else{
						$this->session->set_flashdata('error', 'Ooops, Please Try Again Later');                 
					}
				}  
			}  
            
			$data['CommentRecords'] = $this->Support_model->SupportComments($SupportID); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View Support Ticket';
            $this->global['active_menu'] = 'viewsupport';
            
            $this->loadViews("Support/viewSupport", $this->global, $data, NULL); 
    }  
    function deleteSupport()
    { 
		$SupportID = $this->input->post('SupportID');  
		
		$companyInfo = array('idelete'=>1,'iupdated_by'=>$this->session->userdata['userId']); 
		$cond = array( 'isupport_id' => $SupportID );
		$result =  $this->Common_model->update('tbl_support',$companyInfo, $cond);		 
		if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
		else { echo(json_encode(array('status'=>FALSE))); } 
    } 
    function pageNotFound(){
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }
	public function SupportUpload(){ 
		if(!empty($_FILES['file']['name'])){ 
			// Set preference
			$config['upload_path'] = 'assets/support/';	
			$config['allowed_types'] = '*';
			$config['max_size']    = '5072'; // max_size in kb
			$config['file_name'] = $_POST['vfile_start'].'_'.date("Ymdhis"); 		
			//Load upload library
			$this->load->library('upload',$config);			
			$this->upload->initialize($config); 
			$this->upload->overwrite = true;
			$this->upload->do_upload('file');  
		} 
	} 
}

?>
