<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
 
class Materials extends BaseController
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
        $this->load->model('Materials_model');       
        $this->isLoggedIn();  
        $roleCheck = $this->Common_model->checkpermission('materials'); 

        //print_r($roleCheck);die;

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
            $data = array();           
            //$data['materialsRecords'] = $this->Common_model->get_all('materials');            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Materials Listing';  
            $this->global['active_menu'] = 'materials';          
            $this->loadViews("Materials/materials", $this->global, $data, NULL);
        }
    }
	public function MaterialsInActive()
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
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Materials Listing';  
            $this->global['active_menu'] = 'materials';          
            $this->loadViews("Materials/MaterialsInActive", $this->global, $data, NULL);
        }
    } 
	public function AJAXMaterials(){  
		$this->load->library('ajax');
		$data = $this->Materials_model->GetMaterialData();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}	
	public function AJAXMaterialsInActive(){  
		$this->load->library('ajax');
		$data = $this->Materials_model->GetMaterialDataInActive();  
		//echo "<PRE>";
		//print_r($data);
		//echo "</PRE>";
		//exit;
		$this->ajax->send($data);
	}		

    /**
     * This function is used to load the add new form
     */
    function addNewMaterials()
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
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add New Material';
            $this->global['active_menu'] = 'addmaterial';             

            //print_r($data['company_list']);

            $this->loadViews("Materials/addNewMaterials", $this->global, $data, NULL);
        }
    }

    
       /**
     * This function is used to add new contacts to the system
     */
    function addnewmaterialsubmit()
    {


        //echo "<pre>";print_r($_POST);echo "</pre>";die;


        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('MaterialName','MaterialName','trim|required|max_length[128]'); 
			$this->form_validation->set_rules('MaterialCode','MaterialCode','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('Operation','Operation','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('SicCode','SicCode','trim|required|max_length[10]');            
            
            if($this->form_validation->run()){ 
                
                $Type = $this->security->xss_clean($this->input->post('Type'));
				$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
				$MaterialCode = $this->security->xss_clean($this->input->post('MaterialCode'));
                $Operation = $this->security->xss_clean($this->input->post('Operation'));                
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));                                       
                $EAProduct = $this->security->xss_clean($this->input->post('EAProduct'));
                
                $materialInfo = array('Type'=>$Type,'MaterialName'=>$MaterialName,'MaterialCode'=>$MaterialCode, 'EAProduct'=>$EAProduct, 
				'Operation'=>$Operation, 'SicCode'=> $SicCode, 'PriceID'=>0, 'Status'=>1);                 
                $result = $this->Common_model->insert("materials",$materialInfo);
                
                if($result > 0){
                    foreach ($this->input->post('price') as $key => $value) {
						if($value['TMLPrice']!="" && $value['TMLPrice']!="0"){		
							$PriceInfo = array('MaterialID'=>$result,'TMLPrice'=>$value['TMLPrice'], 
							'CustPrice'=>0, 'StartDate'=> $value['StartDate'],'EndDate'=>$value['EndDate'],  
							'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');                
							$price_id = $this->Common_model->insert("price",$PriceInfo); 
							if (isset($value['defualt'])) {                            
								$this->Common_model->update("materials",array("PriceID"=>$price_id), array("MaterialID"=>$result));  
							} 
						}
                    } 
                    $this->session->set_flashdata('success', 'New material created successfully');
                }else{
                    $this->session->set_flashdata('error', 'Material creation failed');
                } 
                redirect('materiallist');
            }
        }
    }
    
    /**
     * This function is used load contacts edit information
     * @param number $ContactID : Optional : This is contact id
     */
    function editMaterial($MaterialID)
    {
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($MaterialID == null)
            {
                redirect('materiallist');
            }          
            
             $conditions = array(
                 'MaterialID' => $MaterialID
                );

            $data['mInfo'] = $this->Common_model->select_singel_where("materials",$conditions);
            $data['price_list'] = $this->Common_model->select_all_with_where("price",$conditions);
                 

            //print_r($data['price_list']);die;
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Material';
            $this->global['active_menu'] = 'editmaterial'; 
            
            $this->loadViews("Materials/editMaterial", $this->global, $data, NULL);
        }
    }
    
	function ViewMaterial($MaterialID)
    {
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else {  
            if($MaterialID == null){
                redirect('materiallist');
            }          
             
            $data['mInfo'] = $this->Common_model->getMaterialInfo($MaterialID); 
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View Material';
            $this->global['active_menu'] = 'viewmaterial'; 
            
            $this->loadViews("Materials/ViewMaterial", $this->global, $data, NULL);
        }
    }
    
    /**
     * This function is used to edit the Contact information system
     */
    function editmaterialsubmit()
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
            
            $MaterialID = $this->input->post('MaterialID');
            
            $this->form_validation->set_rules('Type','Type','trim|required|max_length[128]'); 
			$this->form_validation->set_rules('MaterialName','MaterialName','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('MaterialCode','MaterialCode','trim|required|max_length[128]'); 
			$this->form_validation->set_rules('Operation','Operation','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('SicCode','SicCode','trim|required|max_length[10]');
            
            if($this->form_validation->run() == FALSE){
                $this->editMaterial($MaterialID);
            }else{
                $Type = $this->security->xss_clean($this->input->post('Type'));
				$MaterialName = $this->security->xss_clean($this->input->post('MaterialName'));
				$MaterialCode = $this->security->xss_clean($this->input->post('MaterialCode'));
                $Operation = $this->security->xss_clean($this->input->post('Operation'));                
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $EAProduct = $this->security->xss_clean($this->input->post('EAProduct'));
                
                $MaterialInfo = array('MaterialName'=>$MaterialName,'Type'=>$Type, 'MaterialCode'=>$MaterialCode, 
                'Operation'=>$Operation, 'SicCode'=> $SicCode, 'EAProduct'=> $EAProduct ); 
                $cond = array( 'MaterialID' => $MaterialID );
                $this->Common_model->update("materials",$MaterialInfo, $cond);   
                $this->Common_model->delete("price",$cond);

					foreach ($this->input->post('price') as $key => $value) {  
						if($value['TMLPrice']!="" && $value['TMLPrice']!="0"){		
							$PriceInfo = array('MaterialID'=>$MaterialID, 'TMLPrice'=>$value['TMLPrice'], 
							'CustPrice'=>0, 'StartDate'=> $value['StartDate'],'EndDate'=>$value['EndDate'], 
							'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> '');                
							$price_id = $this->Common_model->insert("price",$PriceInfo); 
							if (isset($value['defualt'])) {                            
								$this->Common_model->update("materials",array("PriceID"=>$price_id), array("MaterialID"=>$MaterialID));  
							} 
						}
                    }
 
                $this->session->set_flashdata('success', 'Material information updated successfully');                
                redirect('materials');
            }
        }
    }


    /**
     * This function is used to delete the contact using ContactID
     * @return boolean $result : TRUE / FALSE
     */
    function deleteMaterials()
    {
        if($this->isDelete == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            $MaterialID = $this->input->post('MaterialID'); 

            $con = array('MaterialID'=>$MaterialID);           
            
            $result = $this->Common_model->delete('materials', $con);
            
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
