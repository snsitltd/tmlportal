<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
 
class Schedule extends BaseController
{
     
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Schedule_model');        
        $this->isLoggedIn();   
		
		$roleCheck = $this->Common_model->checkpermission('schedule'); 

        //print_r($roleCheck); exit; die;

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
    }
    

    /**
     * This function is used to load the add new form
     */
    function uploaddata()
    {

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {                     
            $data = array();
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Create Schedule';
            $this->global['active_menu'] = 'uploaddata';
            $this->loadViews("Schedule/uploaddata", $this->global, $data, NULL);
        }
    }

    
    /**
     * This function is used to add new user to the system
     */
    function uploaddatasubmit()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('title','Title','trim|required|max_length[128]');            
            $this->form_validation->set_rules('type','type','trim|required');
            //$this->form_validation->set_rules('isschedule','isschedule','trim|required');           
            
            if($this->form_validation->run() == FALSE)
            {
                $this->uploaddata();
            }
            else
            {
                
                $title = $this->security->xss_clean($this->input->post('title'));
                $type = $this->security->xss_clean($this->input->post('type'));                
                //$isschedule = $this->security->xss_clean($this->input->post('isschedule'));
                        

                    $config['upload_path']          = WEB_ROOT_PATH.'assets/Uploads/';
                    $config['allowed_types'] = '*';
                    $config['max_size'] = 1024 * 8;
                    $config['encrypt_name'] = TRUE;
         
                   $this->load->library('upload', $config);
         
                    if (!$this->upload->do_upload('uploadfile'))
                    {

                        $error = array('error' => $this->upload->display_errors());                        
                         echo 'invalid';die;

                    }else{

                        $data = $this->upload->data();              
                        $uploadfile = $data['file_name'];               
                    } 
                $scheduleInfo = array('title'=>$title, 'type'=>$type, 'is_schedule'=> "No",
                'filename'=>$uploadfile , 'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'));                
                $scheduleID = $this->Common_model->insert("schedule_files",$scheduleInfo);
                
                if($scheduleID > 0)
                {

                redirect('importcsvfile/'.$scheduleID); 

                }
                else
                {
                    $this->session->set_flashdata('error', 'Company creation failed');
                    redirect('uploaddata');
                }
                
                
            }
        }
    }



       /**
     * This function is used load contacts edit information
     * @param number $ContactID : Optional : This is contact id
     */
    function importcsvfile($id)
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            if($id == null)
            {
                redirect('uploaddata');
            }          
            
             $conditions = array(
                 'id' => $id
                );

             $data = array();

            $SInfo = $data['SInfo'] = $this->Common_model->select_where('schedule_files',$conditions) ;
            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Set Schedule';
            $this->global['active_menu'] = 'importcsvfile';

            $file = fopen(WEB_ROOT_PATH.'assets/Uploads/'.$SInfo['filename'], "r");

            $col = $this->db->field_data($SInfo['type']);

            foreach ($col as $key => $value) {  

               // if($value->primary_key==0){

                    $data['database_columns'][] = $value->name;                   

               // }
               
            }           

            //print_r($data['database_columns']);die;

            $data['csv_header'] = fgetcsv($file);
            $data['example_data'] = fgetcsv($file);            
            
            $this->loadViews("Schedule/setschedule", $this->global, $data, NULL);
        }
    }



/**
     * This function is used to add new user to the system
     */
    function importcsvfilesubmit()
    {      

        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('isschedule','isschedule','trim|required');  
            $this->form_validation->set_rules('filename','filename','trim|required');
            $this->form_validation->set_rules('id','id','trim|required');         
            
            if($this->form_validation->run() == FALSE)
            {
                $this->uploaddata();
            }
            else
            {               
                            
                   $isschedule = $this->security->xss_clean($this->input->post('isschedule'));
                   $id = $this->security->xss_clean($this->input->post('id'));
                   $filename = $this->security->xss_clean($this->input->post('filename'));
                   $type = $this->security->xss_clean($this->input->post('type'));

                   $csvdb = $_POST['csvdb'];

                   if($isschedule=='No'){
                   $table_cal=array();                     

                   foreach ($csvdb as $key => $col) {
                       $table_cal[] =  $key;
                   }

                   $importDB = array();
                   $ij=0;
                   $file_path = WEB_ROOT_PATH.'assets/Uploads/'.$this->input->post('filename');        
        
                    //open the csv file for reading
                    $handle = fopen($file_path, 'r');

                    // read the first line and ignore it
                    fgets($handle); 

                  while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                       
                        $sql ='( ';
                        foreach ($csvdb as $key => $value) {

                            if($value!=''){
                                $importDB[$ij][$key] = addslashes(trim($data[$value])); 
                            }else{
                                $importDB[$ij][$key] = ''; 
                            }

                             $sql .= "'". $importDB[$ij][$key]."',";         

                        }

                        $sql = substr(trim($sql), 0, -1);
                        $sql .=  ' )'; 

                        $sql_val[] = $sql;
                        $ij++;               
                    }

                    
                   // print_r($sql_val);die;

                     $delete_table = array("company_to_opportunities","company_to_note","company_to_contact","company_to_document","opportunity_to_note","opportunity_to_contact","opportunity_to_document");
                     if (in_array($type, $delete_table)){$this->db->empty_table($type);}


                    $importarrays = array_chunk($sql_val, 500);
                    foreach ($importarrays as $arr) {   

                        $this->db->query("REPLACE INTO tbl_".$type." (".implode(", ", $table_cal).") VALUES ". implode(", ", $arr));
                    } 
                    $this->Common_model->update('schedule_files',array("status"=>1),array("id"=>$id)) ;


                   }else{
                     //print_r($csvdb); die;
                    $this->Common_model->update('schedule_files',array("status"=>0,"mapindexing"=>json_encode($csvdb),'is_schedule'=>$isschedule),array("id"=>$id)) ;

                   }

                   $this->session->set_flashdata('success', 'File successfully added!');
                    redirect('uploaddata');

                
            }
        }
    }    
    
    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteCompany()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $CompanyID = $this->input->post('CompanyID'); 

            $con = array('CompanyID'=>$CompanyID);           
            
            $result = $this->Common_model->delete('company', $con);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    } 



       /**
     * This function is used to load the add new form
     */
    function content()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {                     
            $data = array();             

            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Set content'; 
            $this->global['active_menu'] = 'content'; 
            $this->loadViews("Schedule/content", $this->global, $data, NULL);
        }
    }
    function cron()
    {
		//if($this->isAdmin() == TRUE){
		if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{                      
            $data = array();             
 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Run Cron Jobs Manually '; 
            $this->global['active_menu'] = 'cron'; 
            $this->loadViews("Schedule/cron", $this->global, $data, NULL);
        }
    }
	
	function APKDownload()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {                     
            $data = array();             

            $data['APK'] = $this->Common_model->ListOfAPK();   
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML APK Versions'; 
            $this->global['active_menu'] = 'apk'; 
            $this->loadViews("Schedule/APKDownload", $this->global, $data, NULL);
        }
    }
	
	function TransferTickets()
	{
       // if($this->isAdmin() == TRUE){
       //     $this->loadThis();
       // }else{                      
            $data = array();              
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				
				$this->load->library('form_validation');  
				$this->form_validation->set_rules('CompanyID','Source Company Name','trim|required');
				$this->form_validation->set_rules('OpportunityID','Source Opportunity ','trim|required');   
				$this->form_validation->set_rules('CompanyID1','Destination Company Name','trim|required');
				$this->form_validation->set_rules('OpportunityID1','Destination Opportunity ','trim|required');   
				
				if($this->form_validation->run()){ 


					$CompanyID = $this->security->xss_clean($this->input->post('CompanyID')); 					
					$CompanyID1 = $this->security->xss_clean($this->input->post('CompanyID1')); 					
					$OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID')); 					
					$OpportunityID1 = $this->security->xss_clean($this->input->post('OpportunityID1')); 
					
					$CompanyName1 = $this->security->xss_clean($this->input->post('CompanyName1')); 
					$OpportunityName1 = $this->security->xss_clean($this->input->post('OpportunityName1')); 
 

					$res = $this->Common_model->update("tbl_tickets",array("CompanyID"=>$CompanyID1,"OpportunityID"=>$OpportunityID1), array("CompanyID"=>$CompanyID,"OpportunityID"=>$OpportunityID)); 
					$res1 = $this->Common_model->update("tbl_booking_request",array("CompanyID"=>$CompanyID1,"OpportunityID"=>$OpportunityID1,"OpportunityName"=>$OpportunityName1,"CompanyName"=>$CompanyName1), array("CompanyID"=>$CompanyID,"OpportunityID"=>$OpportunityID));
					//$res2 = $this->Common_model->update("tbl_company_to_opportunities",array("CompanyID"=>$CompanyID1,"OpportunityID"=>$OpportunityID1), array("CompanyID"=>$CompanyID,"OpportunityID"=>$OpportunityID));
					
					$con3 = array('OpportunityID'=>$OpportunityID1); 
					$where3 = array('OpportunityID'=>$OpportunityID);  
					$res3 = $this->Common_model->update("tbl_opportunity_to_contact",$con3, $where3);
					
					$con4 = array('OpportunityID'=>$OpportunityID1); 
					$where4 = array('OpportunityID'=>$OpportunityID);  
					$res4 = $this->Common_model->update("tbl_opportunity_to_document",$con4, $where4);
					
					$con5 = array('OpportunityID'=>$OpportunityID1); 
					$where5 = array('OpportunityID'=>$OpportunityID);  
					$res5 = $this->Common_model->update("tbl_opportunity_to_note",$con5, $where5);
					
					$con6 = array('OpportunityID'=>$OpportunityID);            
					$res6 = $this->Common_model->delete('tbl_opportunity_tip', $con6);
					
					//$con6 = array('OpportunityID'=>$OpportunityID1); 
					//$where6 = array('OpportunityID'=>$OpportunityID);  
					//$res6 = $this->Common_model->update("tbl_opportunity_tip",$con6, $where6);
					
					$con7 = array('OpportunityID'=>$OpportunityID1); 
					$where7 = array('OpportunityID'=>$OpportunityID);  
					$res7 = $this->Common_model->update("tbl_product",$con7, $where7);
					 
					$res8 = $this->Common_model->update("tbl_tipticket",array("CompanyID"=>$CompanyID1,"OpportunityID"=>$OpportunityID1), array("CompanyID"=>$CompanyID,"OpportunityID"=>$OpportunityID));
					
					$this->session->set_flashdata('success', $res.' Tickets | '.$res1.' Booking | '.$res3.' Contacts | '.$res4.' Documents |  '.$res5.' Notes | '.$res6.' Oppo Authorised | '.$res7.' Products | '.$res8.' Tip Tickets    has been Transferred successfully');                 
					  
				}else{
					$this->session->set_flashdata('error', 'Oooops ... Something Error, Please Try Again Later. ');                 
					
				}
				redirect('TransferTickets');
			}
			
			$data['company_list'] = $this->Common_model->CompanyList();
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Transfer Tickets '; 
            $this->global['active_menu'] = 'opportunity1'; 
            $this->loadViews("Schedule/TransferTickets", $this->global, $data, NULL);
			//}
    }
  
    function submitcontent()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
              $this->load->library('form_validation');
        
        
            
				$this->form_validation->set_rules('title','Title','trim|required|max_length[128]'); 
				$this->form_validation->set_rules('VATRegNo','VAT Registration No.','trim|required|max_length[128]'); 
				$this->form_validation->set_rules('CompanyRegNo','Company Registration NO.','trim|required|max_length[128]'); 
				$this->form_validation->set_rules('FooterText','Footer Text','trim|required|max_length[128]'); 
				
				$this->form_validation->set_rules('subtitle','subtitle','trim|required|max_length[128]'); 
				$this->form_validation->set_rules('version','version','trim|required|max_length[128]'); 
				$this->form_validation->set_rules('ticket_limit','Ticket Limit ','required|numeric|max_length[10]');
				$this->form_validation->set_rules('ticket_limit2','Ticket Limit2 ','required|numeric|max_length[10]');
				$this->form_validation->set_rules('TicketStart','First Ticket Number ','required|numeric|max_length[10]');
				$this->form_validation->set_rules('ConveyanceStart','First Conveyance Number ','required|numeric|max_length[10]');
				$this->form_validation->set_rules('vat','VAT ','required|numeric|max_length[10]');
				$this->form_validation->set_rules('id','id','trim|required|max_length[128]');            
            
				if($this->form_validation->run() == FALSE){
					$this->content();
				}else{
					
					$title = $this->security->xss_clean($this->input->post('title'));
					$VATRegNo = $this->security->xss_clean($this->input->post('VATRegNo'));
					$CompanyRegNo = $this->security->xss_clean($this->input->post('CompanyRegNo'));
					$FooterText = $this->security->xss_clean($this->input->post('FooterText'));
					
					$subtitle = $this->security->xss_clean($this->input->post('subtitle')); 
					$version = $this->security->xss_clean($this->input->post('version')); 
					$ticket_limit = $this->security->xss_clean($this->input->post('ticket_limit'));  
					$ticket_limit2 = $this->security->xss_clean($this->input->post('ticket_limit2'));  
					$TicketStart = $this->security->xss_clean($this->input->post('TicketStart'));  					
					$ConveyanceStart = $this->security->xss_clean($this->input->post('ConveyanceStart'));  										
					$vat = $this->security->xss_clean($this->input->post('vat'));  
					$id = $this->security->xss_clean($this->input->post('id')); 

					if($_FILES['logo']['name']!='') {                      
							

					$config['upload_path']          = WEB_ROOT_PATH.'assets/Uploads/Logo/';
					$config['allowed_types'] = '*';
					$config['max_size'] = 1024 * 8;
					$config['encrypt_name'] = TRUE;         
					$this->load->library('upload', $config);
		 
					if (!$this->upload->do_upload('logo'))
					{

						$error = array('error' => $this->upload->display_errors());                   
						 echo 'invalid';die;

					}else{

						$data = $this->upload->data();              
						$uploadfile = $data['file_name'];               
					} 

				}else{
				  
				  $uploadfile = $this->security->xss_clean($this->input->post('oldlogo')); ;

				}
				
                $content = array('title'=>$title, 'VATRegNo'=>$VATRegNo, 'CompanyRegNo'=>$CompanyRegNo, 'FooterText'=>$FooterText, 'subtitle'=>$subtitle, 
				'version'=> $version,'ConveyanceStart'=> $ConveyanceStart,
				'ticket_limit'=> $ticket_limit,'ticket_limit2'=> $ticket_limit2,'TicketStart'=> $TicketStart,'vat'=> $vat, 'logo'=>$uploadfile );                
                $this->Common_model->update("content_settings",$content,array("id"=>$id));
                
                $this->session->set_flashdata('success', 'Information successfully updated..');
                redirect('content');
                 
            }
          
        }
    }

  public function submitheadercontent(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('address','Company Address','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('email','Email','trim|required|max_length[128]|valid_email'); 
            $this->form_validation->set_rules('phone','Phone','required|numeric|max_length[15]');
            $this->form_validation->set_rules('head1','Header Description 1','required'); 
            $this->form_validation->set_rules('head2','Header Description 2','required');  
            $this->form_validation->set_rules('fax','Fax','required|numeric');
             $this->form_validation->set_rules('website','Website','required');            
            
            if($this->form_validation->run() == FALSE)
            {
                $this->content();
            }
            else
            {
                $address = $this->security->xss_clean($this->input->post('address'));
                $email = $this->security->xss_clean($this->input->post('email')); 
                $phone = $this->security->xss_clean($this->input->post('phone')); 
                $fax = $this->security->xss_clean($this->input->post('fax')); 
                $website = $this->security->xss_clean($this->input->post('website'));
                $id = $this->security->xss_clean($this->input->post('id')); 
                $head1 = $this->security->xss_clean($this->input->post('head1')); 
                $head2 = $this->security->xss_clean($this->input->post('head2')); 
                  $reference = $this->security->xss_clean($this->input->post('reference')); 

                if($_FILES['header_logo']['name']!='') {                      
                        

                $config['upload_path']          = WEB_ROOT_PATH.'assets/Uploads/Logo/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 8;
                $config['encrypt_name'] = TRUE;         
                $this->load->library('upload', $config);
     
                if (!$this->upload->do_upload('header_logo'))
                {

                    $error = array('error' => $this->upload->display_errors());                   
                     echo 'invalid';die;

                }else{

                    $data = $this->upload->data();              
                    $uploadfile = $data['file_name'];               
                } 

            }else{
              
              $uploadfile = $this->security->xss_clean($this->input->post('oldlogo')); ;

            }
          
                
                $content = array('address'=>$address, 'email'=>$email, 'phone'=> $phone,
                                    'logo'=>$uploadfile,'fax'=>$fax,'website'=>$website,'head1'=>$head1,'head2'=>$head2,'reference'=>$reference ); 
                                                 
                $this->Common_model->update("content_settings",$content,array("id"=>$id));
                
                $this->session->set_flashdata('success', 'Information successfully updated..');
                    redirect('content');
                
                
                
            }
  }
  public function submitOutHeaderContent(){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('outpdf_title','Title','trim|required|max_length[128]'); 
            $this->form_validation->set_rules('outpdf_email','Email','trim|required|max_length[128]|valid_email'); 
            $this->form_validation->set_rules('outpdf_phone','Phone','required|numeric|max_length[15]');
            $this->form_validation->set_rules('outpdf_address','Address','required');  
            $this->form_validation->set_rules('outpdf_fax','Fax','required|numeric');
            $this->form_validation->set_rules('outpdf_website','Website','required'); 
            $this->form_validation->set_rules('waste_licence','Waste Licence','required');             
            
            if($this->form_validation->run() == FALSE)
            {
                $this->content();
            }
            else
            {

                $ouput_title = $this->security->xss_clean($this->input->post('outpdf_title'));
                $address = $this->security->xss_clean($this->input->post('outpdf_address'));
                $email = $this->security->xss_clean($this->input->post('outpdf_email')); 
                $phone = $this->security->xss_clean($this->input->post('outpdf_phone')); 
                $fax = $this->security->xss_clean($this->input->post('outpdf_fax')); 
                $website = $this->security->xss_clean($this->input->post('outpdf_website'));
                $id = $this->security->xss_clean($this->input->post('id'));  
                $waste_licence = $this->security->xss_clean($this->input->post('waste_licence')); 
				
				$outpdf_para1 = $this->security->xss_clean($this->input->post('outpdf_para1')); 
				$outpdf_para2 = $this->security->xss_clean($this->input->post('outpdf_para2')); 
				$outpdf_para3 = $this->security->xss_clean($this->input->post('outpdf_para3')); 
				$outpdf_para4 = $this->security->xss_clean($this->input->post('outpdf_para4')); 

                if($_FILES['outpdf_header_logo']['name']!='') {                      
                        

                $config['upload_path']          = WEB_ROOT_PATH.'assets/Uploads/Logo/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 1024 * 8;
                $config['encrypt_name'] = TRUE;         
                $this->load->library('upload', $config);
     
                if (!$this->upload->do_upload('outpdf_header_logo'))
                {

                    $error = array('error' => $this->upload->display_errors());                   
                     echo 'invalid';die;

                }else{

                    $data = $this->upload->data();              
                    $uploadfile = $data['file_name'];               
                } 

            }else{
              
              $uploadfile = $this->security->xss_clean($this->input->post('oldlogo')); ;

            } 
                $content = array('outpdf_address'=>$address, 'outpdf_email'=>$email, 'outpdf_phone'=> $phone,
				'outpdf_header_logo'=>$uploadfile,'outpdf_fax'=>$fax,'outpdf_website'=>$website,'waste_licence'=>$waste_licence,'outpdf_title'=>$ouput_title,
				'outpdf_para1'=>$outpdf_para1,'outpdf_para2'=>$outpdf_para2,'outpdf_para3'=>$outpdf_para3,'outpdf_para4'=>$outpdf_para4); 
                                                 
                $this->Common_model->update("content_settings",$content,array("id"=>$id));
                
                $this->session->set_flashdata('success', 'Information successfully updated..');
                redirect('content');
                 
            }
  }
    
}

?>
