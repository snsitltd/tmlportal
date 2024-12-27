<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
 
class Tips extends BaseController
{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tip_model');        
        $this->isLoggedIn(); 
        $roleCheck = $this->Common_model->checkpermission('company');

         $this->global['isView'] = $this->isView = $roleCheck->view;   
         $this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
         $this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
         $this->global['isDelete'] = $this->isDelete = $roleCheck->delete; 
         $this->global['active_menu'] = 'dashboard';

    }
  
    public function index()
    { 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{           
            $data['TipRecords'] = $this->Tip_model->TipListing(); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tip Address Listing';
            $this->global['active_menu'] = 'tips';            
            $this->loadViews("Tips/Tips", $this->global, $data, NULL);
        }
    }
	public function ViewTipTickets($TipID){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            if($TipID == null){ redirect('Tips'); }           
            //$data['TipRecords'] = $this->Tip_model->TipRecords($TipID);  
			  
			$conditions = array( 'TipID' => $TipID ); 
            $data['TipInfo'] = $this->Common_model->select_where("tbl_tipaddress",$conditions); 
			 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tip Tickets Listing';
            $this->global['active_menu'] = 'tips'; 
            
            $this->loadViews("Tips/TipTickets", $this->global, $data, NULL);
        }
    }
	
	function AJAXShowTipTicketImages(){
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $TipTicketID  = $this->input->post('TipTicketID');    
			  
			$data['Photos'] = $this->Tip_model->ShowRequestTipTicketPhotos($TipTicketID); 
			$data['Images'] = $this->Tip_model->ShowRequestTipTicketImages($TipTicketID); 
			
			//var_dump($data['Photos']);
			//exit; 
			//echo json_encode(var_dump($data['Loads'])); 
			//exit;
			//$html =  $LoadID." ==== ";
			//$html .=  var_dump($data['Loads']);
			//$html .=  var_dump($data['Photos']);
			$html = $this->load->view('Tips/TipImages', $data, true);  
			echo json_encode($html); 
        }
    }
	public function AjaxViewTipTickets(){  
		$this->load->library('ajax'); 
		$data = $this->Tip_model->GetViewTipTickets();  
		$this->ajax->send($data);
	}
	function ViewTipTicketsTableMeta(){   
		echo '{"Name":"TipTickets","Action":true,"Column":[{"Name":"TipTicketID","Title":"TipTicketID","Searchable":true,"Class":null},{"Name":"TipDateTime","Title":"TipDateTime","Searchable":true,"Class":null},{"Name":"ConveyanceNo","Title":"ConveyanceNo","Searchable":true,"Class":null},{"Name":"SiteAddress","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material Name","Searchable":true,"Class":null},{"Name":"TipTicketNo","Title":"SuppTkt No","Searchable":true,"Class":null},{"Name":"Status","Title":"Status","Searchable":true,"Class":null},{"Name":"Remarks","Title":"Remarks","Searchable":true,"Class":null} ]}';
		//echo '{"Name":"TipTickets","Action":true,"Column":[{"Name":"TipTicketID","Title":"TipTicketID","Searchable":true,"Class":null},{"Name":"TipDateTime","Title":"TipDateTime","Searchable":true,"Class":null},{"Name":"ConveyanceNo","Title":"ConveyanceNo","Searchable":true,"Class":null},{"Name":"SiteAddress","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material Name","Searchable":true,"Class":null},{"Name":"TipTicketNo","Title":"TipTicketNo","Searchable":true,"Class":null},{"Name":"Remarks","Title":"Remarks","Searchable":true,"Class":null}]}'; 
    }
	function TipTicketNoUpdateAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$TipTicketNo  = $this->input->post('TipTicketNo');       
			$TipTicketID  = $this->input->post('TipTicketID');       
			
			$Tinfo = array('TipTicketNo'=>$TipTicketNo ); 
			$Cond = array( 'TipTicketID' => $TipTicketID  );  
			$result = $this->Common_model->update("tbl_tipticket", $Tinfo, $Cond);
			 
			if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TipTicketID'=>$TipTicketID ))); }
            else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
    function TipTicketExcelExport(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{     
		
			//var_dump($_POST); 			
			$TipID   = $this->input->post('TipID');  
			$TipTicketID   = $this->input->post('TipTicketID');  
			$Search   = $this->input->post('Search');    
			$TipDateTime   = $this->input->post('TipDateTime');  
			$reservation   = $this->input->post('reservation');  
			$ConveyanceNo   = $this->input->post('ConveyanceNo');   
			$SiteAddress   = $this->input->post('SiteAddress');   
			$DriverName   = $this->input->post('DriverName');  
			$MaterialName   = $this->input->post('MaterialName');  
			$TipTicketNo   = $this->input->post('TipTicketNo');  
			$Remarks   = $this->input->post('Remarks');   
			 
			$data['ExcelTipTickets'] = $this->Tip_model->ExcelTipTickets($TipID,$TipTicketID,$TipDateTime,$reservation,$ConveyanceNo,$SiteAddress,$DriverName,$MaterialName,$TipTicketNo,$Remarks,$Search); 			
			
			//var_dump($data['ExcelTipTickets']); 
			//exit;
			$this->load->library("excel"); 
				$object = new PHPExcel();
				//print_r($_POST); die;
				$object->setActiveSheetIndex(0);
				  
				$table_columns = array("TipTicketID","Tip Ticket DateTime","Conveyance No", "Job Site Address", "Driver Name","Material Name","TipTicketNo" ,"Remarks" ); 
				 
				$column = 0; 
				foreach($table_columns as $field)
				{
					$object->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold( true );		
					$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
					$column++;
				}

				$excel_row = 2; 
				foreach( $data['ExcelTipTickets'] as $row){ 	 
					
					if($row['TipTicketNo']!=""){ 
							$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['TipTicketID']); 
							$object->getActiveSheet()->getCell('A'.$excel_row)->getHyperlink()->setUrl('http://193.117.210.98:8081/ticket/Supplier/'.trim($row['TipName']).'-'.trim($row['TipTicketNo']).'.pdf'); 	      
					}else{
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row['TipTicketID']);  
					}	 
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row['TipDateTime']);
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row['ConveyanceNo']); 
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row['SiteAddress'] );
					$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row['DriverName'] );  
					$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row['MaterialName'] );    
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row['TipTicketNo'] );     
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row['Remarks'] );
					
					/*$Ph = explode(',',$row['Photos']);   
					
					if(count($Ph)>0){ 
						$Photo_Column = "";	
						for($i=0;$i<$Ph;$i++){
						    $url = base_url('uploads/Photo/'.$Ph[$i]);
							$Photo_Column .= '<a href=".$url."  > View </a>  ';
						}
						$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $Photo_Column );   	
					}*/
					 
					
					$excel_row++;
				}
				 
				for ($i = 'A'; $i !=  $object->getActiveSheet()->getHighestColumn(); $i++) {
					$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
				}
				$FileName = "TipTickets_".date("Y-m-d-H:i").".xls";		
			 
				
				
				// Remove anything which isn't a word, whitespace, number
				// or any of the following caracters -_~,;[](). 
				$FileName = mb_ereg_replace("([^\w\s\d\-_~@&,;\[\]\(\).])", '', $FileName);
				// Remove any runs of periods (thanks falstro!)
				$FileName = mb_ereg_replace("([\.]{2,})", '', $FileName);
				
				//$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
				$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
				
				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				//application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
				header('Content-Disposition: attachment;filename="'.$FileName.'"');
				//$object_writer->save('php://output'); 
				
				ob_start();
				$object_writer->save("php://output");
				//$objWriter->save(base_url("12121212.xls")); 
				$xlsData = ob_get_contents();
				ob_end_clean(); 

				$response =  array(
						'op' => 'ok',
						'FileName' => $FileName ,
						'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
				); 
				die(json_encode($response)); 
        }
    }
	/*public function ViewTipTickets($TipID){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{           
			if($TipID == null){ redirect('Tips'); }           
            $data['TipRecords'] = $this->Tip_model->TipRecords($TipID); 
			
			$conditions = array( 'TipID' => $TipID ); 
            $data['TipInfo'] = $this->Common_model->select_where("tbl_tipaddress",$conditions); 
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tip Tickets Listing';
            $this->global['active_menu'] = 'tips';            
            $this->loadViews("Tips/TipTickets", $this->global, $data, NULL);
        }
    }*/	
 
    function AddTip()
    {
        if($this->isAdd == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            $this->load->model('user_model');            
            $data['county'] = $this->Tip_model->getCounty(); 
            
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				
				$this->load->library('form_validation');
            
				$this->form_validation->set_rules('TipName','Tip Name','trim|required|max_length[255]');             
				$this->form_validation->set_rules('Street1','Street 1 ','trim|required|max_length[255]'); 
				$this->form_validation->set_rules('Town','Town','trim|required|max_length[50]');
				$this->form_validation->set_rules('County','County','trim|required|max_length[50]');
				$this->form_validation->set_rules('PostCode','PostCode','trim|required|max_length[20]'); 
				
				if($this->form_validation->run()){  
					$TipName = $this->security->xss_clean($this->input->post('TipName'));                 
					$HType1 = $this->security->xss_clean($this->input->post('HType'));                 
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode')); 
					$PermitRefNo = $this->security->xss_clean($this->input->post('PermitRefNo')); 
  					
					//var_dump($HType1);
					$HType = implode(',',$HType1);
					//exit;
					$TipInfo = array('TipName'=>$TipName,'HType'=>$HType, 'Price'=>$Price, 'Street1'=> $Street1,'Street2'=>$Street2 ,
					'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode,'PermitRefNo'=>$PermitRefNo, 'Status'=>0 , 
					'CreatedBy'=>$this->session->userdata['userId'] ,'UpdatedBy'=>$this->session->userdata['userId']);
					  
					$insert = $this->Common_model->insert("tbl_tipaddress",$TipInfo);
					if($insert){  
						$this->session->set_flashdata('success', 'New Tip Address created successfully');                
					}else{
						$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');                
					}
					redirect('Tips');
				}  
			} 
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add Tip Address';
            $this->global['active_menu'] = 'addtip';

            $this->loadViews("Tips/AddTip", $this->global, $data, NULL);
        }
    }
   
    function EditTip($TipID)
    {
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            if($TipID == null){ redirect('Tips'); }           
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				
				$this->load->library('form_validation');
            
				$this->form_validation->set_rules('TipName','Tip Name','trim|required|max_length[255]');             
				$this->form_validation->set_rules('Street1','Street 1 ','trim|required|max_length[255]'); 
				$this->form_validation->set_rules('Town','Town','trim|required|max_length[50]');
				$this->form_validation->set_rules('County','County','trim|required|max_length[50]');
				$this->form_validation->set_rules('PostCode','PostCode','trim|required|max_length[20]'); 
				
				if($this->form_validation->run()){  
					$TipName = $this->security->xss_clean($this->input->post('TipName'));                 
					$HType1 = $this->security->xss_clean($this->input->post('HType'));                 
					$Price = $this->security->xss_clean($this->input->post('Price'));
					$Street1 = $this->security->xss_clean($this->input->post('Street1'));
					$Street2 = $this->security->xss_clean($this->input->post('Street2'));
					$Town = $this->security->xss_clean($this->input->post('Town'));
					$County = $this->security->xss_clean($this->input->post('County'));
					$PostCode = $this->security->xss_clean($this->input->post('PostCode')); 
  					$PermitRefNo = $this->security->xss_clean($this->input->post('PermitRefNo'));
					
					$HType = implode(',',$HType1);
					
					$TipInfo = array('TipName'=>$TipName,'HType'=>$HType,'Price'=>$Price,  'Street1'=> $Street1,'Street2'=>$Street2 ,
					'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode, 'PermitRefNo'=>$PermitRefNo, 'Status'=>0 , 
					'CreatedBy'=>$this->session->userdata['userId'] ,'UpdatedBy'=>$this->session->userdata['userId']);
					$cond = array( 'TipID' => $TipID );  
					$update = $this->Common_model->update("tbl_tipaddress",$TipInfo,$cond);
					if($update){  
						$this->session->set_flashdata('success', 'Tip Address has been updated successfully');                
					}else{
						$this->session->set_flashdata('error', 'Oooops, Please Try Again Later. ');                
					}
					redirect('Tips');
				}  
			} 
            $conditions = array( 'TipID' => $TipID ); 
            $data['TipInfo'] = $this->Common_model->select_where("tbl_tipaddress",$conditions); 
			
            $data['county'] = $this->Tip_model->getCounty();   
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Tip Address';
            $this->global['active_menu'] = 'edittip';
            
            $this->loadViews("Tips/EditTip", $this->global, $data, NULL);
        }
    }
    
    function DeleteTip(){
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            $TipID = $this->input->post('TipID');  
            $con = array('TipID'=>$TipID);            
            //$result = $this->Common_model->delete('tbl_tipaddress', $con); 
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
 
    function pageNotFound()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    
}

?>
