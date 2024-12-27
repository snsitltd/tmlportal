<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php'; 
include_once APPPATH.'/third_party/mpdf/mpdf.php';

class Tickets extends BaseController
{
    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tickets_model');        
		$this->load->model('Booking_model');        
        $this->isLoggedIn();  
      
        $roleCheck = $this->Common_model->checkpermission('tickets'); 

        //print_r($roleCheck);die;

        $this->global['isView'] = $this->isView = $roleCheck->view;   
         $this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
         $this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
         $this->global['isDelete'] = $this->isDelete = $roleCheck->delete; 
         $this->global['active_menu'] = 'dashboard'; 

    }
	
	function CheckDuplicateRegNo(){ 
        $RegNo = $_POST['RegNo']; 
        $result['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($RegNo);            
		if($result['duplicate']>0){ echo(json_encode(array('STATUS'=>false))); }else{ echo(json_encode(array('STATUS'=>true))); } 
    }
	function SearchConveyanceAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{ 
			//var_dump($_POST);
			$data['Conveyance']  = trim($this->input->post('Conveyance'));     
			//$data['BookingInfo'] = $this->tickets_model->BookingLoadInfo($data['Conveyance']);  
			$Result = $this->tickets_model->BookingLoadInfo($data['Conveyance']);  
			//var_dump($data['BookingInfo']);
			//echo $data['BookingInfo']['BookingType'];
			//exit; 
			if ($Result > 0) { echo(json_encode($Result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
			
			//$html = $this->load->view('Tickets/SearchConveyanceAJAX', $data, true);  
			//echo json_encode($html);   
        }
    }
	
	function AddConveyanceTicketAJAX(){
				 
				//var_dump($_POST);
				$LoadID  = trim($this->input->post('LoadID'));      
				$GrossWeight  = trim($this->input->post('GrossWeight'));     
				
				$PaymentType  = trim($this->input->post('PaymentType'));   
				$Amount  = trim($this->input->post('Amount'));   
				$VatAmount  = trim($this->input->post('VatAmount'));   
				$TotalAmount  = trim($this->input->post('TotalAmount'));   
				$PaymentRefNo  = trim($this->input->post('PaymentRefNo'));   
				$ticket_notes  = trim($this->input->post('ticket_notes'));   
				$Vat  = trim($this->input->post('Vat')); 
				
		    	
				if($GrossWeight == '0' || $GrossWeight == '' || $LoadID == '0'   ){ 
					echo "Error";
				}

				$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID); 
				
				$TicketUniqueID = $this->generateRandomString();       
				$LastTicketNumber =  $this->tickets_model->LastTicketNo(); 
				if($LastTicketNumber){ 
					$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
				} 
				$Net = $GrossWeight-$data['LoadInfo']->lorry_tare;	
				//echo "<br>";
				//echo $GrossWeight;
				//echo "<br>";
				//echo $data['LoadInfo']->lorry_tare;
				
				if($data['LoadInfo']->LorryType=="0" || $data['LoadInfo']->LorryType==""   ){ $LorryType = '1'; }
				
				$ticketsInfo = array('LoadID'=>$LoadID,'TicketUniqueID'=>$TicketUniqueID,'TicketNumber'=>$TicketNumber, 
				'TicketDate'=>date('Y-m-d H:i:s'), 'OpportunityID'=>$data['LoadInfo']->OpportunityID, 'Conveyance'=>$data['LoadInfo']->ConveyanceNo, 
				'CompanyID'=>$data['LoadInfo']->CompanyID,'DriverName'=>$data['LoadInfo']->DriverName ,'RegNumber'=>$data['LoadInfo']->VehicleRegNo ,
				'Hulller'=>$data['LoadInfo']->Haulier ,'MaterialID'=>$data['LoadInfo']->MaterialID , 
				'GrossWeight'=>$GrossWeight ,'Tare'=>$data['LoadInfo']->lorry_tare ,'Net'=>$Net , 
				'SicCode'=>$data['LoadInfo']->SicCode,'CreateUserID'=>$this->session->userdata['userId'] ,
				'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'In','pdf_name'=>$TicketUniqueID.".pdf",
				'driver_id'=>$data['LoadInfo']->DriverID ,'is_tml'=>'1' ,  
				'driversignature'=>$data['LoadInfo']->dsignature, 
				'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat, 'VatAmount'=>$VatAmount, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo , 'ticket_notes'=>$ticket_notes 	);
				$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
				
				/* =================== Site Logs ===================  */
				$TInfoJson = json_encode($ticketsInfo); 

				$SiteLogInfo = array('TableName'=>'tbl_tickets' ,'PrimaryID'=>$TicketID, 
				'UpdatedValue'=>$TInfoJson, 'UpdatedByUserID'=>$this->session->userdata['userId'],
				'SitePage'=>'add inticket search conveyance','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
				'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
				/* ===================================== */
				
				//exit;
				$LI = array('TicketID'=>$TicketID,'TipID'=>1); 
				$co = array( 'LoadID ' => $LoadID  );  
				$up = $this->Common_model->update("tbl_booking_loads1", $LI, $co);
				
				/* =================== Site Logs ===================  */
				$LIJson = json_encode($LI);
				$coJson = json_encode($co);

				$SiteLogInfo = array('TableName'=>'tbl_booking_loads1' ,'PrimaryID'=>$LoadID, 
				'UpdatedValue'=>$LIJson." => ".$coJson, 'UpdatedByUserID'=>$this->session->userdata['userId'],
				'SitePage'=>'add inticket search conveyance','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
				'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
				/* ===================================== */
				
				$data1['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
				$data1['tickets'] = $this->Common_model->get_pdf_data1($TicketID); 
				
				$html=$this->load->view('Tickets/ticket_pdf', $data1, true);
				 //this the the PDF filename that user will get to download
				$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
				$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
				  
				//load mPDF library
				$this->load->library('m_pdf');

			   //generate the PDF from the given html
				$this->m_pdf->pdf->WriteHTML($html);
				 
				//download it.
				$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
				
				
				$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID); 
				
					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result(); 
					$LT = '';
					if($data['LoadInfo']->LorryType == 1) { $LT = 'Tipper'; }
					else if($data['LoadInfo']->LorryType == 2) { $LT = 'Grab'; }
					else if($data['LoadInfo']->LorryType == 3) { $LT = 'Bin'; }
					else{ $LT = ''; }

					$TB = '';
					if($data['LoadInfo']->TonBook == 1) { $TB = ' Tonnage '; } 
					else{ $TB = ' Load '; }

					$siteInDateTime = '<b>In Time: </b>'.$data['LoadInfo']->SIDateTime.' <br>'; 
					$siteOutDateTime = '<b>Out Time: </b>'.$data['LoadInfo']->SODateTime.' <br>';

					$MaterialText =   $data['LoadInfo']->MaterialName.' Collected '.$LT.' '.$TB;					
					
					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
					<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
						<div style="width:100%; " >
							<div style="width:35%;float: left;" > 		
								<img src="/assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="80"> 
							</div>
							<div style="width:65%;float: right;text-align: right;" > 		 
								<b>'.$PDFContent[0]->outpdf_title.'</b><br/> 		
								'.$PDFContent[0]->address.' <br/> 
								<b>Phone:</b> '.$PDFContent[0]->outpdf_phone.' 											
							</div>
						</div>	
						<div style="width:100%;float: left;" >   
							<b>Email:</b> '.$PDFContent[0]->email.' <br/>		
							<b>Web:</b> '.$PDFContent[0]->website.' <br/>		  
							<b>Waste License No: </b>'.$PDFContent[0]->waste_licence.' <br/> <hr>
							<b>'.$PDFContent[0]->head1.'</b><br/> <br>
							<b>'.$PDFContent[0]->head2.'</b><br/> <br>
							<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
							<b>Conveyance Note No:</b> '.$data['LoadInfo']->ConveyanceNo.'<br>		
							<b>Date Time: </b>'.$data['LoadInfo']->CDateTime.'<br>		 
							'.$siteInDateTime.'
							'.$siteOutDateTime.'
							<b>Company Name: </b> '.$data['LoadInfo']->CompanyName.' <br>		
							<b>Site Address: </b> '.$data['LoadInfo']->OpportunityName.'<br>		 		
							<b>Tip Address: </b> '.$data['LoadInfo']->TipName.','.$data['LoadInfo']->Street1.','.$data['LoadInfo']->Street2.',
							'.$data['LoadInfo']->Town.','.$data['LoadInfo']->County.','.$data['LoadInfo']->PostCode.'<br>	
							<b>Permit Reference No: </b>'.$data['LoadInfo']->PermitRefNo.' <br/>	 		 
							<b>Material: </b> '.$MaterialText.'  <br> 
							<b>SicCode: </b> '.$data['LoadInfo']->LoadSICCODE.'  <br>  
							<b>Vehicle Reg. No. </b> '.$data['LoadInfo']->VehicleRegNo.'  <br> 
							<b>Driver Name: </b> '.$data['LoadInfo']->DriverName.'<br> <br/>   
						</div>
						<div><img src="/assets/DriverSignature/'.$data['LoadInfo']->dsignature.'" width ="100" height="40" style="float:left"> </div>  <br> 
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/'.$data['LoadInfo']->Signature.'" width ="100" height="40" style="float:left"></div>
							'.$data['LoadInfo']->CustomerName.'<br><br>
							<div style="font-size: 9px;"> 
								<b>VAT Reg. No: </b> '.$PDFContent[0]->VATRegNo.' <br>
								<b>Company Reg. No: </b> '.$PDFContent[0]->CompanyRegNo.' <br>  
								'.$PDFContent[0]->FooterText.'  
							</div>
						</div>  
					</div></body></html>'; 
					  
					$pdfFilePath = WEB_ROOT_PATH."/assets/conveyance/".$data['LoadInfo']->ReceiptName;  
					$mpdf =  new mPDF('utf-8', array(70,190),'','',5,5,5,5,5,5); 
					$mpdf->keep_table_proportions = false; 
					$mpdf->WriteHTML($html);  
					$mpdf->Output($pdfFilePath);
					 
						
				    /* =================== Site Logs ===================  */
						$OldFile = $pdfFilePath;
						$NewFileName = date('YmdHis').".pdf";
						$NewFile = WEB_ROOT_PATH."/assets/conveyance/".$NewFileName;
							
						copy($OldFile, $NewFile); 
						 
						$SiteLogInfo = array('TableName'=>'tbl_booking_loads1' ,'PrimaryID'=>$LoadID, 
						'FileName'=> $NewFileName , 'UpdatedByUserID'=>$this->session->userdata['userId'],
				'SitePage'=>'add inticket search conveyance pdf','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
				'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
					/* ===================================== */
					 
			    echo(json_encode(base_url($openPath))); 
				//if ($Result > 0) { echo(json_encode($Result)); }
				//else { echo(json_encode(array('status'=>FALSE))); } 
		 
    }
	
	
	
	
	function LinkConveyanceAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{ 
			//var_dump($_POST);
			$data['Conveyance']  = $this->input->post('Conveyance');     
			$data['TicketNo']  = $this->input->post('TicketNo');     
			$Result = $this->tickets_model->BookingLoadInfo1($data['Conveyance']);  
			//var_dump($data['BookingInfo']);
			//echo $data['BookingInfo']['BookingType'];
			//exit;    
			 
			if ($Result > 0) { echo(json_encode($Result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
			
			//$html = $this->load->view('Tickets/LinkConveyanceAJAX', $data, true);  
			//echo json_encode($html);   
        }
    }
	
	function EditConveyanceTicketAJAX(){  
               
				$LoadID = $this->input->post('LoadID');
				//echo " === ";
				$TicketNo = $this->input->post('TicketNo');
				
				
				$PaymentType  = trim($this->input->post('PaymentType'));   
				$Amount  = trim($this->input->post('Amount'));   
				$VatAmount  = trim($this->input->post('VatAmount'));   
				$TotalAmount  = trim($this->input->post('TotalAmount'));   
				$PaymentRefNo  = trim($this->input->post('PaymentRefNo'));   
				$ticket_notes  = trim($this->input->post('ticket_notes'));   
				$Vat  = trim($this->input->post('Vat')); 
				
				if($LoadID  == null ){ redirect('All-Tickets'); }      
			
				if(LoadID > "0" && $TicketNo > "0" ){  
				  
					$LI = array('TicketID'=>$TicketNo ); 
					$co = array( 'LoadID ' => $LoadID  );  
					$up = $this->Common_model->update("tbl_booking_loads1", $LI, $co);
					
					/* =================== Site Logs ===================  */
					$LIJson = json_encode($LI);
					$coJson = json_encode($co);
					
					$SiteLogInfo = array('TableName'=>'tbl_booking_loads1' ,'PrimaryID'=>$LoadID, 
					'UpdatedValue'=>$LIJson." => ".$coJson, 'UpdatedByUserID'=>$this->session->userdata['userId'],
					'SitePage'=>'edit inticket link conveyance','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
					'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
					/* ================================================== */
					 
					$TInfo = array('LoadID'=>$LoadID, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount , 
					'Vat'=>$Vat, 'VatAmount'=>$VatAmount, 'TotalAmount'=>$TotalAmount , 
					'PaymentRefNo'=>$PaymentRefNo , 'ticket_notes'=>$ticket_notes  ); 
					$TCond = array( 'TicketNo' => $TicketNo  );  
					$this->Common_model->update("tbl_tickets", $TInfo, $TCond);
					
					/* =================== Site Logs ===================  */
					$TInfoJson = json_encode($TInfo);
					$TCondJson = json_encode($TCond);
 
					$SiteLogInfo = array('TableName'=>'tbl_tickets' ,'PrimaryID'=>$TicketNo, 
					'UpdatedValue'=>$TInfoJson." => ".$TCond, 'UpdatedByUserID'=>$this->session->userdata['userId'],
					'SitePage'=>'edit inticket link conveyance','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
					'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
					/* ================================================== */
					
					$data1['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
					$data1['tickets'] = $this->Common_model->get_pdf_data1($TicketNo); 
					$TicketUniqueID = $data1['tickets']['TicketUniqueID']; 
					
					$html=$this->load->view('Tickets/ticket_pdf', $data1, true);
					 //this the the PDF filename that user will get to download
					$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
					$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
					  
					//load mPDF library
					$this->load->library('m_pdf');

				   //generate the PDF from the given html
					$this->m_pdf->pdf->WriteHTML($html);
					 
					//download it.
					$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
					
					echo(json_encode(base_url($openPath))); 
					 
				}else{ echo(json_encode("Error"));  }	 
        
    } 
	
	
	function LinkConveyanceSubmit($LoadID){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($LoadID  == null ){ redirect('All-Tickets'); }      
			  
				$LoadID = $this->input->post('LoadID');
				$TicketNo = $this->input->post('TicketNo');
				  
				if(LoadID > "0" && $TicketNo > "0" ){  
				  
					$LI = array('TicketID'=>$TicketNo ); 
					$co = array( 'LoadID ' => $LoadID  );  
					$up = $this->Common_model->update("tbl_booking_loads1", $LI, $co);
					
					/* =================== Site Logs ===================  */
					$LIJson = json_encode($LI);
					$coJson = json_encode($co);

					$SiteLogInfo = array('TableName'=>'tbl_booking_loads1' ,'PrimaryID'=>$LoadID, 
					'UpdatedValue'=>$LIJson." => ".$coJson, 'UpdatedByUserID'=>$this->session->userdata['userId'],
					'SitePage'=>'edit inticket link conveyance','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
					'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
					/* ================================================== */
					
					$TInfo = array('LoadID'=>$LoadID); 
					$TCond = array( 'TicketNo' => $TicketNo  );  
					$this->Common_model->update("tbl_tickets", $TInfo, $TCond);
					
					/* =================== Site Logs ===================  */
					$TInfoJson = json_encode($TInfo);
					$TCondJson = json_encode($TCond);
 
					$SiteLogInfo = array('TableName'=>'tbl_tickets' ,'PrimaryID'=>$TicketNo, 
					'UpdatedValue'=>$TInfoJson." => ".$TCond, 'UpdatedByUserID'=>$this->session->userdata['userId'],
					'SitePage'=>'edit inticket link conveyance','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
					'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
					$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
					/* ================================================== */
								
				}	
			    
				$this->session->set_flashdata('success', 'Conveyance Number and Ticket Number has been linked Successfully.');                 
				redirect('edit-In-ticket/'.$TicketNo);  
        }
    } 
	function SearchConveyanceSubmit($LoadID){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($LoadID  == null ){ redirect('In-Tickets'); }      
			  
				$LoadID = $this->input->post('LoadID');
				$GrossWeight = $this->input->post('GrossWeight');   
				
				if($GrossWeight == '0' || $GrossWeight == '' || $LoadID == '0'   ){ 
					$this->session->set_flashdata('error', 'Gross Weight Should not be blank. ');          
					redirect('In-Tickets');  
				}

				$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID); 
				
				$TicketUniqueID = $this->generateRandomString();       
				$LastTicketNumber =  $this->tickets_model->LastTicketNo(); 
				if($LastTicketNumber){ 
					$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
				} 
				$Net = $GrossWeight-$data['LoadInfo']->lorry_tare;	
				//echo "<br>";
				//echo $GrossWeight;
				//echo "<br>";
				//echo $data['LoadInfo']->lorry_tare;
				
				if($data['LoadInfo']->LorryType=="0" || $data['LoadInfo']->LorryType==""   ){ $LorryType = '1'; }
				
				$ticketsInfo = array('LoadID'=>$LoadID,'TicketUniqueID'=>$TicketUniqueID,'TicketNumber'=>$TicketNumber, 
				'TicketDate'=>date('Y-m-d H:i:s'), 'OpportunityID'=>$data['LoadInfo']->OpportunityID, 'Conveyance'=>$data['LoadInfo']->ConveyanceNo, 
				'CompanyID'=>$data['LoadInfo']->CompanyID,'DriverName'=>$data['LoadInfo']->DriverName ,'RegNumber'=>$data['LoadInfo']->VehicleRegNo ,
				'Hulller'=>$data['LoadInfo']->Haulier ,'MaterialID'=>$data['LoadInfo']->MaterialID , 
				'GrossWeight'=>$GrossWeight ,'Tare'=>$data['LoadInfo']->lorry_tare ,'Net'=>$Net , 
				'SicCode'=>$data['LoadInfo']->Haulier,'CreateUserID'=>$this->session->userdata['userId'] ,
				'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'In','pdf_name'=>$TicketUniqueID.".pdf",
				'driver_id'=>$data['LoadInfo']->DriverID ,'is_tml'=>$is_tml ,  
				'driversignature'=>$data['LoadInfo']->dsignature  );
				$TicketID = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
				
				/* =================== Site Logs ===================  */
				$TInfoJson = json_encode($ticketsInfo); 

				$SiteLogInfo = array('TableName'=>'tbl_tickets' ,'PrimaryID'=>$TicketID, 
				'UpdatedValue'=>$TInfoJson, 'UpdatedByUserID'=>$this->session->userdata['userId'],
				'SitePage'=>'add inticket search conveyance','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
				'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
				/* ===================================== */
				
				//exit;
				$LI = array('TicketID'=>$TicketID,'TipID'=>1); 
				$co = array( 'LoadID ' => $LoadID  );  
				$up = $this->Common_model->update("tbl_booking_loads1", $LI, $co);
				
				/* =================== Site Logs ===================  */
				$LIJson = json_encode($LI);
				$coJson = json_encode($co);

				$SiteLogInfo = array('TableName'=>'tbl_booking_loads1' ,'PrimaryID'=>$LoadID, 
				'UpdatedValue'=>$LIJson." => ".$coJson, 'UpdatedByUserID'=>$this->session->userdata['userId'],
				'SitePage'=>'add inticket search conveyance','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
				'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
				$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
				/* ===================================== */
				
				$data1['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
				$data1['tickets'] = $this->Common_model->get_pdf_data1($TicketID); 
				
				$html=$this->load->view('Tickets/ticket_pdf', $data1, true);
				 //this the the PDF filename that user will get to download
				$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
				$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
				  
				//load mPDF library
				$this->load->library('m_pdf');

			   //generate the PDF from the given html
				$this->m_pdf->pdf->WriteHTML($html);
				 
				//download it.
				$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
				
				
				$data['LoadInfo'] = $this->Booking_model->BookingLoadInfo1($LoadID); 
				
					$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
					$PDFContent = $PDFContentQRY->result(); 
					$LT = '';
					if($data['LoadInfo']->LorryType == 1) { $LT = 'Tipper'; }
					else if($data['LoadInfo']->LorryType == 2) { $LT = 'Grab'; }
					else if($data['LoadInfo']->LorryType == 3) { $LT = 'Bin'; }
					else{ $LT = ''; }

					$TB = '';
					if($data['LoadInfo']->TonBook == 1) { $TB = ' Tonnage '; } 
					else{ $TB = ' Load '; }

					$siteInDateTime = '<b>In Time: </b>'.$data['LoadInfo']->SIDateTime.' <br>'; 
					$siteOutDateTime = '<b>Out Time: </b>'.$data['LoadInfo']->SODateTime.' <br>';

					$MaterialText =   $data['LoadInfo']->MaterialName.' Collected '.$LT.' '.$TB;					
					
					$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
					<div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
						<div style="width:100%; " >
							<div style="width:35%;float: left;" > 		
								<img src="/assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="80"> 
							</div>
							<div style="width:65%;float: right;text-align: right;" > 		 
								<b>'.$PDFContent[0]->outpdf_title.'</b><br/> 		
								'.$PDFContent[0]->address.' <br/> 
								<b>Phone:</b> '.$PDFContent[0]->outpdf_phone.' 											
							</div>
						</div>	
						<div style="width:100%;float: left;" >   
							<b>Email:</b> '.$PDFContent[0]->email.' <br/>		
							<b>Web:</b> '.$PDFContent[0]->website.' <br/>		  
							<b>Waste License No: </b>'.$PDFContent[0]->waste_licence.' <br/> <hr>
							<b>'.$PDFContent[0]->head1.'</b><br/> <br>
							<b>'.$PDFContent[0]->head2.'</b><br/> <br>
							<div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
							<b>Conveyance Note No:</b> '.$data['LoadInfo']->ConveyanceNo.'<br>		
							<b>Date Time: </b>'.$data['LoadInfo']->CDateTime.'<br>		 
							'.$siteInDateTime.'
							'.$siteOutDateTime.'
							<b>Company Name: </b> '.$data['LoadInfo']->CompanyName.' <br>		
							<b>Site Address: </b> '.$data['LoadInfo']->OpportunityName.'<br>		 		
							<b>Tip Address: </b> '.$data['LoadInfo']->TipName.','.$data['LoadInfo']->Street1.','.$data['LoadInfo']->Street2.',
							'.$data['LoadInfo']->Town.','.$data['LoadInfo']->County.','.$data['LoadInfo']->PostCode.'<br>
							<b>Permit Reference No: </b>'.$data['LoadInfo']->PermitRefNo.' <br/>		 		 
							<b>Material: </b> '.$MaterialText.'  <br> 
							<b>SicCode: </b> '.$data['LoadInfo']->LoadSICCODE.'  <br>  
							<b>Vehicle Reg. No. </b> '.$data['LoadInfo']->VehicleRegNo.'  <br> 
							<b>Driver Name: </b> '.$data['LoadInfo']->DriverName.'<br> <br/>   
						</div>
						<div><img src="/assets/DriverSignature/'.$data['LoadInfo']->dsignature.'" width ="100" height="40" style="float:left"> </div>  <br> 
						<div style="width:100%;float: left;" >
							<b>Produced By: </b><br>
							<div><img src="/uploads/Signature/'.$data['LoadInfo']->Signature.'" width ="100" height="40" style="float:left"></div>
							'.$data['LoadInfo']->CustomerName.'<br><br>
							<div style="font-size: 9px;"> 
								<b>VAT Reg. No: </b> '.$PDFContent[0]->VATRegNo.' <br>
								<b>Company Reg. No: </b> '.$PDFContent[0]->CompanyRegNo.' <br>  
								'.$PDFContent[0]->FooterText.'  
							</div>
						</div>  
					</div></body></html>'; 
					  
					$pdfFilePath = WEB_ROOT_PATH."/assets/conveyance/".$data['LoadInfo']->ReceiptName;  
					$mpdf =  new mPDF('utf-8', array(70,190),'','',5,5,5,5,5,5); 
					$mpdf->keep_table_proportions = false; 
					$mpdf->WriteHTML($html);  
					$mpdf->Output($pdfFilePath);
					  
				    /* =================== Site Logs ===================  */
						$OldFile = $pdfFilePath;
						$NewFileName = date('YmdHis').".pdf";
						$NewFile = WEB_ROOT_PATH."/assets/conveyance/".$NewFileName;
							
						copy($OldFile, $NewFile); 
						 
						$SiteLogInfo = array('TableName'=>'tbl_booking_loads1' ,'PrimaryID'=>$LoadID, 
						'FileName'=> $NewFileName , 'UpdatedByUserID'=>$this->session->userdata['userId'],
				'SitePage'=>'add inticket search conveyance pdf','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
				'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
						$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  
					/* ===================================== */
					
			   
			   
				$this->session->set_flashdata('success', 'Tip Ticket has been Created successfully');                
			   
				redirect('In-Tickets');  
        }
    } 
	public function TEST(){  
	
		require_once(APPPATH.'third_party/fpdf17/fpdf.php');
		require_once(APPPATH.'third_party/FPDI/fpdi.php');
		//require('fpdf.php');
		//require('fpdi.php');

		$files = ['assets/pdf_file/PVNG7FIX1ULH.pdf' , 'assets/pdf_file/B7AKJZRI3V05.pdf'];

		$pdf = new FPDI();

		// iterate over array of files and merge
		foreach ($files as $file) {
			$pageCount = $pdf->setSourceFile($file);
			for ($i = 0; $i < $pageCount; $i++) {
				$tpl = $pdf->importPage($i + 1, '/MediaBox');
				$pdf->addPage();
				$pdf->useTemplate($tpl);
			}
		}

		// output the pdf as a file (http://www.fpdf.org/en/doc/output.htm)
		$pdf->Output('F','test.pdf'); 

/*          $data = array(); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TEST TICKET';
            $this->global['active_menu'] = 'test'; 
            
			$data = $this->tickets_model->TEST();  
			 
            $this->loadViews("Tickets/test", $this->global, $data, NULL);
			$this->output->enable_profiler(TRUE);  */
			
    }
 
    public function index(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();
            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tickets Listing';
            $this->global['active_menu'] = 'tickets'; 
            
            $this->loadViews("Tickets/AjaxTickets", $this->global, $data, NULL);
			//$this->output->enable_profiler(TRUE);
        }
    }

	public function AJAXTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetTicketData(); 
		$this->ajax->send($data);
	}
  
	public function AllTickets(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();
            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : All Tickets Listing';
            $this->global['active_menu'] = 'tickets'; 
            
            $this->loadViews("Tickets/AllTickets", $this->global, $data, NULL); 
        }
    }
	function AllTicketsTableMeta(){
        echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
    }
	public function AllTicketsAJAX(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetAllTicketData(); 
		$this->ajax->send($data);
	}
	public function AllTicketsArchived(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();
            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : All Tickets Listing (Archived)';
            $this->global['active_menu'] = 'tickets'; 
            
            $this->loadViews("Tickets/AllTicketsArchived", $this->global, $data, NULL); 
        }
    }
	function AllTicketsTableMetaArchived(){
        echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
    }
	public function AllTicketsAJAXArchived(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetAllTicketDataArchived(); 
		$this->ajax->send($data);
	}
	
	function TMLTicketsTableMeta(){
        echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
    }
  
    public function tmlTicket(){

        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
			$data=array();	
           // $data['ticketsRecords'] = $this->tickets_model->tmlticketsListing(); 

            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML Tickets Listing';
            $this->global['active_menu'] = 'tmltickets'; 
            
            $this->loadViews("Tickets/tml_tickets", $this->global, $data, NULL);
        }
    }
	
	public function AJAXTmlTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetTmlTicketData();   
		$this->ajax->send($data);
	}
	function TMLTicketsTableMetaArchived(){
        echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
    }
	public function tmlTicketArchived(){

        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
			$data=array();	
           // $data['ticketsRecords'] = $this->tickets_model->tmlticketsListing(); 

            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML Tickets Listing (Archived)';
            $this->global['active_menu'] = 'tmltickets'; 
            
            $this->loadViews("Tickets/tmlticketsArchived", $this->global, $data, NULL);
        }
    } 
	public function AJAXTmlTicketsArchived(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetTmlTicketDataArchived();   
		$this->ajax->send($data);
	}
	  
	public function tmlHoldTicket(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array();
           // $data['ticketsRecords'] = $this->tickets_model->tmlticketsListingHOLD(); 

            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML HOLD Tickets Listing';
            $this->global['active_menu'] = 'tmlholdtickets'; 
            
            $this->loadViews("Tickets/tml_hold_tickets", $this->global, $data, NULL);
        }
    }
	
	public function DeliveryHoldTickets(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array();
			$data['CountHoldTicketsPDF'] = $this->tickets_model->CountHoldTicketsPDF();   	
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML HOLD Tickets Listing';
            $this->global['active_menu'] = 'tmlholdtickets'; 
            
            $this->loadViews("Tickets/DeliveryHoldTickets", $this->global, $data, NULL);
        }
    }
	
	public function AJAXHoldTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetHoldTicketData();   
		$this->ajax->send($data);
	}
	
	public function AJAXDeliveryHoldTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetDeliveryHoldTicketsData();   
		$this->ajax->send($data);
	}
	
	function HoldTicketsTableMeta(){
        echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
    }
	
	function DeliveryHoldTicketsTableMeta(){
        echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
    }
	
	public function InboundTicket(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array(); 
			$data['CountInBoundTicketsPDF'] = $this->tickets_model->CountInBoundTicketsPDF();   	
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Inbound Tickets Listing';
            $this->global['active_menu'] = 'inboundtickets'; 
            
            $this->loadViews("Tickets/InboundTickets", $this->global, $data, NULL);
        }
    }
	
	public function AJAXInboundTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetInboundTicketData();   
		$this->ajax->send($data);
	} 
	
	function InboundTicketsTableMeta(){
        echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
    }
	
	public function IncompletedTicket(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array(); 
			$data['CountInCompletedTicketsPDF'] = $this->tickets_model->CountInCompletedTicketsPDF();   	
			
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Incompleted Tickets Listing';
            $this->global['active_menu'] = 'incompletedtickets'; 
            
            $this->loadViews("Tickets/IncompletedTickets", $this->global, $data, NULL);
        }
    }
	
	public function AJAXIncompletedTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetIncompletedTicketData();   
		$this->ajax->send($data);
	}
	function IncompletedTicketsTableMeta(){
        //echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
		echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"MaterialName","Title":"Material","Searchable":true,"Class":null},{"Name":"Conveyance","Title":"Conveyance","Searchable":true,"Class":null},{"Name":"driver_id","Title":"Lorry","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"GrossWeight","Title":"Gross","Searchable":true,"Class":null},{"Name":"Tare","Title":"Tare","Searchable":true,"Class":null},{"Name":"Net","Title":"Net","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null}]}'; 
    }
	
	public function deleteTickets(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array();
           // $data['ticketsRecords'] = $this->tickets_model->ticketsListingDeleted(); 

            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Deleted Tickets Listing';
            $this->global['active_menu'] = 'deleteTickets'; 
            
            $this->loadViews("Tickets/deleteTickets", $this->global, $data, NULL);
        }
    }    
	
	public function AJAXDeleteTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetDeleteTicketData();   
		$this->ajax->send($data);
	}
	
	function DeletedTicketsTableMeta(){
        echo '{"Name":"AllTickets","Action":true,"Column":[{"Name":"TicketNumber","Title":"TNO","Searchable":true,"Class":null},{"Name":"TicketDate","Title":"Date  ","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Company Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Site Name","Searchable":true,"Class":null},{"Name":"RegNumber","Title":"Veh.No","Searchable":true,"Class":null},{"Name":"TypeOfTicket","Title":"OP","Searchable":true,"Class":null},{"Name":"delete_notes","Title":"Delete Notes","Searchable":true,"Class":null}]}'; 
    } 

    function OfficeTicket(){
        if($this->isAdd == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();         
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") );  
	        //$data['company_list'] = $this->Common_model->CompanyList();
			$data['company_list'] = $this->Common_model->CompanyList1();  
			$data['TicketNumber'] = $this->uri->segment(2); 
			$data['COMID'] = $this->Common_model->GetCompanyID($data['TicketNumber']); 
			 
	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;
			 
            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));  
			$data['county'] = $this->Common_model->get_all('county');
			 
			$this->global['pageTitle'] = WEB_PAGE_TITLE.'ADD Office (GAP) TICKET';
            $this->global['active_menu'] = 'tickets'; 

            $this->loadViews("Tickets/OfficeTicket", $this->global, $data, NULL);
        }
    }

##############################################################################################

    function inTickets(){
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data = array();          

            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") );
			$data['company_list'] = $this->Common_model->CompanyList( );

            $type = 'IN';
	        
	        $Material = $this->tickets_model->getMaterialList2($type);
	        $data['Material']=$Material;

	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$data['county'] = $this->Common_model->get_all('county');
            //$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add In Ticket';
			$this->global['pageTitle'] = WEB_PAGE_TITLE.'ADD IN TICKET';
            $this->global['active_menu'] = 'intickets'; 

            $this->loadViews("Tickets/inTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################


    function inTickets1()
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

            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") );
			$data['company_list'] = $this->Common_model->CompanyList( );
            $type = 'IN';
	        
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;

	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add In Ticket';
            $this->global['active_menu'] = 'intickets'; 

            $this->loadViews("Tickets/inTickets1", $this->global, $data, NULL);
        }
    }
	
##############################################################################################


    function collectionTickets()
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

           //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList( );	
            $type = 'COLLECTION';
            
            $Material = $this->tickets_model->getMaterialList3($type);
            $data['Material']=$Material;

             $Lorry = $this->tickets_model->getLorryNo();
             $data['Lorry']=$Lorry;

            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$data['county'] = $this->Common_model->get_all('county');
			//$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add Collection Ticket';
			$this->global['pageTitle'] = WEB_PAGE_TITLE.'ADD COLLECTION TICKET';
			
            $this->global['active_menu'] = 'colltickets'; 

            $this->loadViews("Tickets/collectionTickets", $this->global, $data, NULL);
			
        }
    }

##############################################################################################


    function outTickets()
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
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList( );
			
            $type = 'OUT';
	        
	        $Material = $this->tickets_model->getMaterialList2($type);
	        $data['Material']=$Material;

	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$data['county'] = $this->Common_model->get_all('county');
			//$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add Out Ticket';
			$this->global['pageTitle'] = WEB_PAGE_TITLE.'ADD OUT TICKET';			
            $this->global['active_menu'] = 'outtickets'; 

            $this->loadViews("Tickets/outTickets", $this->global, $data, NULL);
        }
    }
  
##############################################################################################

	function generateRandomString($length = 12) {
		return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
	
	function GetHoldCount() {
		$conditions = array( 'is_hold' => 1 , 'delete_notes' => NULL );
//		echo $this->Common_model->select_count_where('tbl_tickets',$conditions);  
		echo $this->Common_model->CountHoldTicket();  
		
	}
	function getCompanyList(){ 
			$result['company_list'] = $this->Common_model->CompanyListAJAX() ; 
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
    }
	function getLorryList(){ 
			$result['lorry_list'] = $this->Common_model->LorryListAJAX() ; 
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
    }	

##############################################################################################

	
    function editInTicket($TicketID){   
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($TicketID == null){
                redirect('All-Tickets');
            }          
            
            $conditions = array( 'TicketNo' => $TicketID );
            $data['tickets'] = $this->Common_model->select_where("tickets",$conditions);
			  
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList();
            //$data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany1($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])) ;
		
            //print_r($data['SiteAddress']); die;          
		
            $type = 'IN';
	    
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;

	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Ticket';
            $this->global['active_menu'] = 'editintickets'; 
            
            $this->loadViews("Tickets/editInTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################
	
	function EditInBound($TicketID){  
 
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($TicketID == null){
                redirect('All-Tickets');
            }          
            
            $conditions = array( 'TicketNo' => $TicketID );
            $data['tickets'] = $this->Common_model->select_where("tickets",$conditions);
			$data['BookingNotes'] = $this->tickets_model->getBookingNote($data['tickets']['LoadID']);
			
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList();
            //$data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany1($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])) ;
		
            //print_r($data['SiteAddress']); die;          
		
            $type = 'IN';
	    
	        $Material = $this->tickets_model->getMaterialList1($type);
	        $data['Material']=$Material;
			
			if($data['tickets']['DriverLoginID']!=0){
				$data['Dsignature']	 = $this->tickets_model->getSignature($data['tickets']['DriverLoginID']); 
			}else{ 
				$data['Dsignature']	 = $data['tickets']['driversignature'];
			} 
			
	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Inbound Ticket';
            $this->global['active_menu'] = 'editinbound'; 
            
            $this->loadViews("Tickets/EditInBound", $this->global, $data, NULL);
        }
    }
	
##############################################################################################

##############################################################################################
	
	function EditInCompleted($TicketID){   
	 
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($TicketID == null){
                redirect('All-Tickets');
            }          
            
            $conditions = array( 'TicketNo' => $TicketID );
            //$data['tickets'] = $this->Common_model->select_where("tickets",$conditions);
			$data['tickets'] = $this->tickets_model->InCompletedTicketDetails($TicketID);
			$data['BookingNotes'] = $this->tickets_model->getBookingNote($data['tickets']['LoadID']);
			
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList();
            //$data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany1($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])); 
            //print_r($data['SiteAddress']); die;          
			
            $type = 'IN';
	    
	        $Material = $this->tickets_model->getMaterialList1($type);
	        $data['Material']=$Material;
			
			if($data['tickets']['DriverLoginID']!=0){
				$data['Dsignature']	 = $this->tickets_model->getSignature($data['tickets']['DriverLoginID']); 
			}else{ 
				$data['Dsignature']	 = $data['tickets']['driversignature'];
			} 
			
	        //$Lorry = $this->tickets_model->getLorryNo();
			$Lorry = $this->tickets_model->getLorryNoTML();
			 
	        $data['Lorry']=$Lorry;

			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit InCompleted Ticket';
            $this->global['active_menu'] = 'editincompleted'; 
            
            $this->loadViews("Tickets/EditInCompleted", $this->global, $data, NULL);
        }
    }
	
##############################################################################################

    function ViewInTicket($TicketID)
    {   
	
    	if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null){ redirect('All-Tickets'); }          
            $data['TicketInfo'] = $this->tickets_model->getTicketInfo($TicketID);
			
			if($data['TicketInfo']['TypeOfTicket']!="In"){ redirect('All-Tickets'); }
			  
			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View InTicket';
            $this->global['active_menu'] = 'viewintickets'; 
            
            $this->loadViews("Tickets/ViewInTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################


    function ViewOutTicket($TicketID)
    {   
	
    	if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null){ redirect('All-Tickets'); }          
            $data['TicketInfo'] = $this->tickets_model->getTicketInfo($TicketID);
			
			if($data['TicketInfo']['TypeOfTicket']!="Out"){ redirect('All-Tickets'); }
			  
			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View OutTicket';
            $this->global['active_menu'] = 'viewouttickets'; 
            
            $this->loadViews("Tickets/ViewOutTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################


    function ViewCollectionTicket($TicketID)
    {   
	
    	if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null){ redirect('All-Tickets'); }          
            $data['TicketInfo'] = $this->tickets_model->getTicketInfo($TicketID);
			
			if($data['TicketInfo']['TypeOfTicket']!="Collection"){ redirect('All-Tickets'); }
			  
			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View CollectionTicket';
            $this->global['active_menu'] = 'viewcollectiontickets'; 
            
            $this->loadViews("Tickets/ViewCollectionTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################

 
    function editCollectionTicket($TicketID)
    {   
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null)
            {
                redirect('All-Tickets');
            }          
            
            $conditions = array(
                 'TicketNo' => $TicketID
            );
            $data['tickets'] = $this->Common_model->select_where("tickets",$conditions);
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
            $data['company_list'] = $this->Common_model->CompanyList( );
			//$data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany1($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])) ;

            $type = 'COLLECTION';
            
            //$Material = $this->tickets_model->getMaterialList($type);
            $Material = $this->tickets_model->getMaterialList3($type);
            $data['Material']=$Material;

            $Lorry = $this->tickets_model->getLorryNo();
            $data['Lorry']=$Lorry;


            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Ticket';
            $this->global['active_menu'] = 'editcolltickets'; 
            
            $this->loadViews("Tickets/editCollectionTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################

 
    function editOutTicket($TicketID)
    {   
	
    	if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null){ redirect('All-Tickets');  }          
            
            $conditions = array( 'TicketNo' => $TicketID  );
            $data['tickets'] = $this->Common_model->select_where("tickets",$conditions);   
			$data['BookingNotes'] = $this->tickets_model->getBookingNote($data['tickets']['LoadID']);
			 
            $data['company_list'] = $this->Common_model->CompanyList( );
			//$data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany1($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])) ;
 
            $type = 'OUT';
	        
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;
			
			if($data['tickets']['DriverLoginID']!=0){
				$data['Dsignature']	 = $this->tickets_model->getSignature($data['tickets']['DriverLoginID']); 
			}else{ 
				$data['Dsignature']	 = $data['tickets']['driversignature'];
			} 
			
	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;
 
            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Ticket';
            $this->global['active_menu'] = 'editouttickets'; 
            
            $this->loadViews("Tickets/editOutTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################
        
    function deleteTicket()
    {
        if($this->isDelete == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            $TicketNo = $this->input->post('TicketNo'); 

            $con = array('TicketNo'=>$TicketNo);           
            
            //$result = $this->Common_model->delete('tickets', $con);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

##############################################################################################

 
    function deleteNotes()
    {
        if($this->isDelete == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            $TicketNo = $this->input->post('TicketNo'); 
			$Notes = $this->input->post('confirmation'); 
            $con = array('TicketNo'=>$TicketNo);           
            
             $ticketsInfo = array('delete_notes'=>$Notes);
			//$result = $this->Common_model->delete('tickets', $con);
            $result = $this->Common_model->update("tickets",$ticketsInfo, $con);     

            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	function restoreTicket()
    {
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $TicketNo = $this->input->post('TicketNo'); 
			//$Notes = $this->input->post('confirmation'); 
            $con = array('TicketNo'=>$TicketNo);            
            $ticketsInfo = array('delete_notes'=>null); 
            $result = $this->Common_model->update("tickets",$ticketsInfo, $con);      
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

##############################################################################################


	function AddOfficeTicketAJAX(){   
        if($this->isAdd == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
                $TicketNumber = $this->security->xss_clean($this->input->post('TicketNumber'));
				$TicketGap = $this->security->xss_clean($this->input->post('TicketGap'));
				$TypeOfTicket = $this->input->post('TypeOfTicket');
				$WIFNumber = $this->input->post('WIFNumber');
				//$TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$Street1 = $this->security->xss_clean($this->input->post('Street1'));
				$County = $this->security->xss_clean($this->input->post('County'));
				$Town = $this->security->xss_clean($this->input->post('Town'));
				$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
				
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial')); 
				$SicCode = $this->security->xss_clean($this->input->post('SicCode')); 
				 
				$LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
				$VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
                $VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				$DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$Tare = $this->security->xss_clean($this->input->post('Tare'));
				$ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes'));
				
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Net = $this->security->xss_clean($this->input->post('Net'));
                
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$is_hold = $this->security->xss_clean($this->input->post('is_hold'));
                //$date = str_replace('/', '-', $TicketDate); 
                //$TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo')); 
				$driversignature = $this->input->post('driversignature', FALSE);  
				if($LorryNo == 0){
					$CHKDUP['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($VechicleRegNo);            
					if($CHKDUP['duplicate']>0){ echo "Error"; exit; }
					
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}
				  
				if($CompanyID == '0'){ 
					if(trim($CompanyName)==""){ 	
						echo "Error";
						exit;
					}
					$CompanyID = $this->generateRandomString();
					$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s') ,); 
					$this->Common_model->insert("tbl_company",$CompanyInfo);
				}	 
				if($OpportunityID == '0'){   
					if(trim($Street1)=="" && trim($Town)=="" && trim($County)=="" && trim($PostCode)==""){ 	
						echo "Error";
						exit;
					}
					$OpportunityID = $this->generateRandomString(); 
					$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
					$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 'OpenDate'=>date("Y-m-d") , 
					'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode,'Status'=>1); 
					$this->Common_model->insert("tbl_opportunities",$OppoInfo);
					
					$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
					$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
					
						$LoadInfo = array('TipID'=>'1','OpportunityID'=>$OpportunityID,'TipRefNo'=>'','Status'=>'0');  
						$this->Common_model->insert("tbl_opportunity_tip",$LoadInfo);  
				}  
				
                $TicketUniqueID = $this->generateRandomString();    			
				$lastdate = $this->tickets_model->LastTicketDate($TicketNumber);  
				if($lastdate['TicketDate']){ $TicketDate = $lastdate['TicketDate']; }else{ 
				$TicketDate  = date('Y-m-d H:i:s'); 
				//$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
				}
					
				$ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID,'TicketNumber'=>$TicketNumber,'TicketGap'=>$TicketGap, 'WIFNumber'=>$WIFNumber, 
				'TicketDate'=>$TicketDate, 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,'MaterialID'=>$DescriptionofMaterial ,
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,'Net'=>$Net , 
				'SicCode'=>$SicCode,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>$TypeOfTicket,'pdf_name'=>$TicketUniqueID.".pdf",
				'driver_id'=>$driverid ,'is_tml'=>$is_tml ,'is_hold'=>$is_hold, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,  'VatAmount'=>$VatAmount,
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo ,'driversignature'=>$driversignature,'ticket_notes'=>$ticket_notes );
				
				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
					$Tn = $this->tickets_model->CheckDuplicateTicket($TicketNumber, $TicketGap);   
					if($Tn==0){ 				
						$ticketId = $this->Common_model->insert('tbl_tickets', $ticketsInfo); 
					}else{ 
						echo "Error";
						exit;
					}
					if($ticketId > 0){  
							$conditions = array(
							 'TicketNo' => $ticketId
							);
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($ticketId);  
							if($TypeOfTicket=="Out"){
									$html=$this->load->view('Tickets/ticket_pdf_out', $data, true);
							}else{		
									$html=$this->load->view('Tickets/ticket_pdf', $data, true);
							}		
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf"; 
							 //load mPDF library
							$this->load->library('m_pdf'); 
						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html); 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F");  
							echo base_url($openPath); 
					}else{
						echo "Error";
					}
				}	
                  
        }
    }
	
##############################################################################################
	 
	function AddTicketAJAX(){   
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {    
	//var_dump($_POST);
	 
                $TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
				$WIFNumber = $this->security->xss_clean($this->input->post('WIFNumber'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$Street1 = $this->security->xss_clean($this->input->post('Street1'));
				$County = $this->security->xss_clean($this->input->post('County'));
				$Town = $this->security->xss_clean($this->input->post('Town'));
				$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
				
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                //$MaterialType = $this->security->xss_clean($this->input->post('MaterialType'));
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes'));
				
				$LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
				$VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$Tare = $this->security->xss_clean($this->input->post('Tare'));
				
				$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Net = $this->security->xss_clean($this->input->post('Net'));
                 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$is_hold = $this->security->xss_clean($this->input->post('is_hold'));
                $date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));   
				$OrderNo = $this->security->xss_clean($this->input->post('OrderNo'));
				$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
				$LorryType = $this->security->xss_clean($this->input->post('LorryType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo')); 
				$driversignature = $this->input->post('driversignature', FALSE); 
				if($is_hold==0){ 
					if($GrossWeight<1 || $GrossWeight=='' ){ echo "Error"; exit; }
				}
				if($LorryNo == '0'){
					
					$CHKDUP['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($VechicleRegNo);            
					if($CHKDUP['duplicate']>0){ echo "Error"; exit; }
			
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				
				/* ####################### Auto Allocation Code  #######################  */
				
				//$DLogin = $this->Common_model->select_where('tbl_drivers',array('LorryNo' => $LorryNo));
				//if($DLogin['AppUser']==1){
					if($CompanyID != '0' && $OpportunityID != '0' && $LorryNo !='0' && $is_tml == '1' ){ 
						$RequestDate  = date('Y-m-d');
						$BookingData =  $this->tickets_model->GetMatchedBookingDetailsInbound($CompanyID,$OpportunityID,$DescriptionofMaterial,$RequestDate); 
						if($BookingData){
							if($BookingData['BookingDateID']!="" && $BookingData['BookingDateID']!=0){	
								//var_dump($BookingData); 
								
								$LastConNumber =  $this->Booking_model->LastConNumber1(); 
								if($LastConNumber){  
									$ConveyanceNo = $LastConNumber['ConveyanceNo']+1;  
								}
								//$DLogin = $this->Common_model->select_where('tbl_drivers',array('LorryNo' => $LorryNo));
								$AutoCreated = 1;
								if($BookingData['LoadType'] == '2'){  
									$LoadCount =  $this->tickets_model->CountBookingLoad($BookingData['BookingDateID']); 
									if($LoadCount['CountLoads']==0){
										$AutoCreated = 1; 
									}else{
										$AutoCreated = 0; 
									}
								}
								
								$LoadInfo = array( 'BookingRequestID'=>$BookingData['BookingRequestID'], 'BookingID'=>$BookingData['BookingID'], 
								'BookingDateID'=>$BookingData['BookingDateID'], 'ConveyanceNo'=>$ConveyanceNo, 'AutoCreated'=> $AutoCreated ,'AutoAllocated'=> 1 , 
								'DriverID'=>$LorryNo ,'DriverLoginID'=> '0' , 'DriverName'=>$DriverName , 'VehicleRegNo' =>$VechicleRegNo , 
								'MaterialID'=>$DescriptionofMaterial ,'AllocatedDateTime'=>date('Y-m-d H:i:s') ,'JobStartDateTime'=>date('Y-m-d H:i:s') , 
								'SiteInDateTime'=>date('Y-m-d H:i:s') ,'SiteOutDateTime'=>date('Y-m-d H:i:s') ,'JobEndDateTime'=>date('Y-m-d H:i:s') ,'TipID'=> '1' , 
								'Status'=> '4' , 'CreatedBy'=> '1' ); 
								$LoadID = $this->Common_model->insert("tbl_booking_loads1",$LoadInfo);  
							}else{ $LoadID = 0; } 
						}else{ $LoadID = 0; } 		
					}else{
						$LoadID = 0;
						//echo "ELSE";	
					}
				//}else{ $LoadID = 0; }	
				 
				/* ####################### ####################  #######################  */
				
				if($CompanyID == '0'){ 
					if(trim($CompanyName)==""){ 	
						echo "Error";
						exit;
					}
					$CompanyID = $this->generateRandomString();
					$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s')); 
					$this->Common_model->insert("tbl_company",$CompanyInfo);
				}	 
				if($OpportunityID == '0'){    
					if(trim($Street1)=="" && trim($Town)=="" && trim($County)=="" && trim($PostCode)==""){ 	
						echo "Error";
						exit;
					}
					$OpportunityID = $this->generateRandomString(); 
					$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
					 
					$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 'OpenDate'=>date("Y-m-d") , 
					'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode,'Status'=>1); 
					$this->Common_model->insert("tbl_opportunities",$OppoInfo);
					
					$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
					$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
					
						$LoadInfo = array('TipID'=>'1','OpportunityID'=>$OpportunityID,'TipRefNo'=>'','Status'=>'0');  
						$this->Common_model->insert("tbl_opportunity_tip",$LoadInfo);  
				}  
				
                $TicketUniqueID = $this->generateRandomString();                
				 
				$LastTicketNumber =  $this->tickets_model->LastTicketNo(); 
				if($LastTicketNumber){ 
					$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
				}else{
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
					$TicketNumber = $data['content']['TicketStart'];
				}  
				$TicketDate  = date('Y-m-d H:i:s');
				//$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
				
				/* ####################### Auto Allocation Code  #######################  */ 
				//'LoadID'=>$LoadID,
				$ticketsInfo = array('LoadID'=>$LoadID,'TicketUniqueID'=>$TicketUniqueID,'TicketNumber'=>$TicketNumber, 'TicketDate'=>$TicketDate, 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,'MaterialID'=>$DescriptionofMaterial ,'WIFNumber'=> $WIFNumber, 
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,'Net'=>$Net , 
				'SicCode'=>$SicCode,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'In','pdf_name'=>$TicketUniqueID.".pdf",
				'driver_id'=>$driverid ,'is_tml'=>$is_tml ,'is_hold'=>$is_hold, 'IsInBound'=> 0,  'LorryType'=>$LorryType ,'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat, 'VatAmount'=>$VatAmount, 'OrderNo'=>$OrderNo,
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo ,'driversignature'=>$driversignature,'ticket_notes'=>$ticket_notes  );

				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                 
					$ticketId = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
				 
					if($ticketId > 0){ 
					
						if($is_hold == 0){
							/* ####################### Auto Allocation Code  #######################  */
							if($LoadID!='0'){	
								$LoadInfo1 = array('TicketID'=>$ticketId,  'TicketUniqueID'=>$TicketUniqueID );   
								$LoadInfo1Cond = array( 'LoadID' => $LoadID ); 
								$this->Common_model->update("tbl_booking_loads1" , $LoadInfo1, $LoadInfo1Cond); 
							} 
							/* ####################### Auto Allocation Code  #######################  */
							$conditions = array( 'TicketNo' => $ticketId );
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($ticketId); 
							
							$html=$this->load->view('Tickets/ticket_pdf', $data, true);
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
							  
							 //load mPDF library
							$this->load->library('m_pdf');

						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);
							 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
							echo base_url($openPath);
						}else{
						     if($LoadID!='0'){	
								$LoadInfo1 = array('TicketID'=>$ticketId,  'TicketUniqueID'=>$TicketUniqueID );   
								$LoadInfo1Cond = array( 'LoadID' => $LoadID ); 
								$this->Common_model->update("tbl_booking_loads1" , $LoadInfo1, $LoadInfo1Cond); 
							} 
							//$conditions = array( 'is_hold' => 1 , 'delete_notes' => NULL );
							//$HoldTicket = $this->Common_model->select_count_where('tbl_tickets',$conditions); 
							//echo "HOLD|".$HoldTicket;
							echo "HOLD";
						}	
					}
					else
					{
						echo "Error";
					}
                }  
        }
    }


##############################################################################################

	
	function EditTicketAJAX(){   
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo')); 
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
				$WIFNumber = $this->security->xss_clean($this->input->post('WIFNumber'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes')); 
				if($is_tml!=1){
					$OrderNo = $this->security->xss_clean($this->input->post('OrderNo')); 
				}else{	
					$OrderNo = ''; 
				}
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$LorryType	 = $this->security->xss_clean($this->input->post('LorryType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
                $driversignature = $this->input->post('driversignature', FALSE); 
				
				if($LorryNo == 0){
					$CHKDUP['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($VechicleRegNo);            
					if($CHKDUP['duplicate']>0){ echo "Error"; exit; }
					
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
                $ticketsInfo = array(  'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 'WIFNumber'=> $WIFNumber,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,
				'Tare'=>$Tare ,'Net'=>$Net , 'SicCode'=>$SicCode,  'pdf_name'=> $TicketUniqueID.".pdf",'UpdateUserID'=>$this->session->userdata['userId'] ,
				'TypeOfTicket'=>'In','driver_id'=> $driverid,'is_tml'=>$is_tml, 'is_hold'=>0,'IsInBound'=>0,  
				'ticket_notes'=>$ticket_notes, 'LorryType'=>$LorryType ,'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 'OrderNo'=>$OrderNo, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature );
   
				if($TicketNo != "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                 
					$cond = array(  'TicketNo' => $TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
				 
					if($tupdate==1) {  
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
						
						$html=$this->load->view('Tickets/ticket_pdf', $data, true);
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						 
						//load mPDF library
						$this->load->library('m_pdf');
						//$this->m_pdf->pdf->SetWatermarkImage('rejected.png');
						//$this->m_pdf->pdf->showWatermarkImage = true; 

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
						  
						echo base_url($openPath);
						 	
					}else{
						echo "SAME";
					} 
                }  
        }
    }	

##############################################################################################

	
	function EditInBoundAJAX(){  
 
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo')); 
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
				$LoadID = $this->security->xss_clean($this->input->post('LoadID'));
				$WIFNumber = $this->security->xss_clean($this->input->post('WIFNumber'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes')); 
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
                $driversignature = $this->input->post('driversignature', FALSE); 
				
				if($LorryNo == 0){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID'];  
				$TicketDate  = date('Y-m-d H:i:s');
				//$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
				
                $ticketsInfo = array( 'TicketDate'=>$TicketDate,'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,
				'GrossWeight'=>$GrossWeight , 'Tare'=>$Tare ,'Net'=>$Net , 'SicCode'=>$SicCode, 'pdf_name'=> $TicketUniqueID.".pdf",
				'is_tml'=>$is_tml, 'is_hold'=>0,'IsInBound'=>0,  'CreateUserID'=>$this->session->userdata['userId'] ,
				'ticket_notes'=>$ticket_notes, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);
   
				if($TicketNo != "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                 
					$cond = array(  'TicketNo' => $TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
					
				//	if($LoadID){
						//$LoadInfo = array( 'Status'=> 4 ); 
						//$CondLoad = array( 'LoadID' => $LoadID ); 	 
						//$Lupdate = $this->Common_model->update("tbl_booking_loads1",$LoadInfo, $CondLoad);
				//	}
 
					if($tupdate==1) {  
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
						$html=$this->load->view('Tickets/ticket_pdf', $data, true);
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						 
						//load mPDF library
						$this->load->library('m_pdf');

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
						  
						echo base_url($openPath);
						 	
					}else{
						echo "SAME";
					} 
                }  
        }
    }	
	

##############################################################################################

##############################################################################################

	
	function EditInCompletedAJAX(){   
	 
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo')); 
				$TicketDate = $this->security->xss_clean($this->input->post('TicketDate')); 
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
				$LoadID = $this->security->xss_clean($this->input->post('LoadID'));
				$WIFNumber = $this->security->xss_clean($this->input->post('WIFNumber'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes')); 
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
                $driversignature = $this->input->post('driversignature', FALSE); 
				 
				$t = explode(' ',$TicketDate);   
				$td = explode('-', $t[0]);   
				$TicketDate = $td[2]."-".$td[1]."-".$td[0]." ".$t[1]; 
				
				if($LorryNo == 0){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID'];  
						
                /*$ticketsInfo = array(  'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 'TicketDate'=> $TicketDate, 'WIFNumber'=> $WIFNumber,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,
				'Tare'=>$Tare ,'Net'=>$Net , 'SicCode'=>$SicCode, 'pdf_name'=> $TicketUniqueID.".pdf",
				'TypeOfTicket'=>'In','driver_id'=> $driverid,'is_tml'=>$is_tml, 'is_hold'=>0,'IsInBound'=>0, 'CreateUserID'=>$this->session->userdata['userId'],   
				'ticket_notes'=>$ticket_notes, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature); */
				
				$ticketsInfo = array(   'TicketDate'=> $TicketDate,'MaterialID'=>$DescriptionofMaterial ,
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight , 'Tare'=>$Tare ,'Net'=>$Net , 
				'SicCode'=>$SicCode, 'pdf_name'=> $TicketUniqueID.".pdf", 'is_tml'=>'1', 'is_hold'=>0,'IsInBound'=>0,  'CreateUserID'=>$this->session->userdata['userId'] , 
				'ticket_notes'=>$ticket_notes, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);
					
				if($TicketNo != "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                 
					$cond = array(  'TicketNo' => $TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
					if($LoadID){
						$LoadInfo = array( 'Status'=> 4 ); 
						$CondLoad = array( 'LoadID' => $LoadID ); 	 
						$Lupdate = $this->Common_model->update("tbl_booking_loads1",$LoadInfo, $CondLoad);
					}
					if($tupdate==1) {  
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
						$html=$this->load->view('Tickets/ticket_pdf', $data, true);
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						 
						//load mPDF library
						$this->load->library('m_pdf');

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
						  
						echo base_url($openPath);
						 	
					}else{
						echo "SAME";
					} 
                }  
        }
    }	
	

##############################################################################################


	function AddOutTicketAJAX(){   
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {   
                 
                $TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml')); 
				
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$Street1 = $this->security->xss_clean($this->input->post('Street1'));
				$County = $this->security->xss_clean($this->input->post('County'));
				$Town = $this->security->xss_clean($this->input->post('Town'));
				$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
				
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                //$Cmeter = $this->security->xss_clean($this->input->post('Cmeter'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));  
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
				$SicCode = $this->security->xss_clean($this->input->post('SicCode')); 
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$is_hold = $this->security->xss_clean($this->input->post('is_hold'));
                $date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$LorryType	 = $this->security->xss_clean($this->input->post('LorryType'));
				$OrderNo = $this->security->xss_clean($this->input->post('OrderNo')); 
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
				if($is_hold==0){ 
					if($GrossWeight<1 || $GrossWeight=='' ){ echo "Error"; exit; }
				} 
				if($LorryNo == '0'){
					$CHKDUP['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($VechicleRegNo);            
					if($CHKDUP['duplicate']>0){ echo "Error"; exit; }
					
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				
				/* ####################### Auto Allocation Code  #######################  */
				/*
				if($CompanyID != '0' && $OpportunityID != '0' && $LorryNo !='0' && $is_tml == '1' ){ 
					$RequestDate  = date('Y-m-d');
					$BookingData =  $this->tickets_model->GetMatchedBookingDetailsOutbound($CompanyID,$OpportunityID,$DescriptionofMaterial,$RequestDate); 
					//var_dump($BookingData); 
					if($BookingData){
						if($BookingData['BookingDateID']!="" && $BookingData['BookingDateID']!=0){	
							$LastConNumber =  $this->Booking_model->LastConNumber1(); 
							if($LastConNumber){  
								$ConveyanceNo = $LastConNumber['ConveyanceNo']+1;  
							}
							
							$DLogin = $this->Common_model->select_where('tbl_drivers',array('LorryNo' => $LorryNo));
							$AutoCreated = 1; 
							if($BookingData['LoadType'] == '2'){  
								$LoadCount =  $this->tickets_model->CountBookingLoad($BookingData['BookingDateID']); 
								if($LoadCount['CountLoads']==0){
									$AutoCreated = 1; 
								}else{
									$AutoCreated = 0; 
								}
							} 
							
							$LoadInfo = array( 'BookingRequestID'=>$BookingData['BookingRequestID'], 'BookingID'=>$BookingData['BookingID'], 
							'BookingDateID'=>$BookingData['BookingDateID'], 'ConveyanceNo'=>$ConveyanceNo, 'AutoCreated'=> $AutoCreated ,'AutoAllocated'=> 1 , 
							'DriverID'=>$LorryNo ,'DriverLoginID'=> $DLogin['DriverID'] , 'DriverName'=>$DriverName , 'VehicleRegNo' =>$VechicleRegNo , 
							'MaterialID'=>$DescriptionofMaterial ,'AllocatedDateTime'=>date('Y-m-d H:i:s') , 'TipID'=> '1' , 
							'Status'=> '1' , 'CreatedBy'=> '1' ); 
							$LoadID = $this->Common_model->insert("tbl_booking_loads1",$LoadInfo);  
						}else{ $LoadID = 0; }	
					}else{ $LoadID = 0; }	 
				}else{
					$LoadID = 0;
					//echo "ELSE";	
				} */
				 
				/* ####################### ####################  #######################  */
				
				
				if($CompanyID == '0'){ 
					if(trim($CompanyName)==""){ 	
						echo "Error";
						exit;
					}
					$CompanyID = $this->generateRandomString();
					$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s') ,); 
					$this->Common_model->insert("tbl_company",$CompanyInfo);
				}	 
				if($OpportunityID == '0'){   
					if(trim($Street1)=="" && trim($Town)=="" && trim($County)=="" && trim($PostCode)==""){ 	
						echo "Error";
						exit;
					}
					$OpportunityID = $this->generateRandomString(); 
					$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
					$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 'OpenDate'=>date("Y-m-d") , 
					'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode,'Status'=>1); 
					$this->Common_model->insert("tbl_opportunities",$OppoInfo);
					
					$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
					$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
					
						$LoadInfo = array('TipID'=>'1','OpportunityID'=>$OpportunityID,'TipRefNo'=>'','Status'=>'0');  
						$this->Common_model->insert("tbl_opportunity_tip",$LoadInfo);  
				}  
                $TicketUniqueID = $this->generateRandomString();                
				$LastTicketNumber =  $this->tickets_model->LastTicketNo(); 
				if($LastTicketNumber){ 
					$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
				}else{
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
					$TicketNumber = $data['content']['TicketStart'];
				}  
				$TicketDate  = date('Y-m-d H:i:s');
				//$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
				//'LoadID'=>$LoadID,
                $ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID, 'TicketNumber'=>$TicketNumber,'TicketDate'=>$TicketDate, 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,'MaterialID'=>$DescriptionofMaterial ,
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,'Net'=>$Net  , 'SicCode'=>$SicCode, 'OrderNo'=>$OrderNo,
				'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'Out','pdf_name'=>$TicketUniqueID.".pdf",
				'driver_id'=>$driverid ,'is_tml'=>$is_tml ,'is_hold'=>$is_hold,'IsInBound'=> 0,  'LorryType'=>$LorryType ,'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,  'VatAmount'=>$VatAmount,
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature );
                
				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
					$ticketId = $this->Common_model->insert('tbl_tickets', $ticketsInfo); 					
					if($ticketId > 0){ 
						if($is_hold == 0){
							
							/*if($LoadID!='0'){	
								$LoadInfo1 = array('TicketID'=>$ticketId,  'TicketUniqueID'=>$TicketUniqueID );   
								$LoadInfo1Cond = array( 'LoadID' => $LoadID ); 
								$this->Common_model->update("tbl_booking_loads1" , $LoadInfo1, $LoadInfo1Cond); 
							} */ 
							
							$conditions = array(  'TicketNo' => $ticketId  );
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($ticketId); 
		 
							$html=$this->load->view('Tickets/ticket_pdf_out', $data, true);
							
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
							  
							 //load mPDF library
							$this->load->library('m_pdf');

						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);
							 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
							echo base_url($openPath);
						}else{
							//$conditions = array( 'is_hold' => 1 , 'delete_notes' => NULL );
							//$HoldTicket = $this->Common_model->select_count_where('tbl_tickets',$conditions); 
							//echo "HOLD|".$HoldTicket;
							echo "HOLD";
						}	
					}
					else
					{
						echo "Error";
					} 
                }  
        }
    }


##############################################################################################
	
	    function EditOutTicketAJAX(){   
			if($this->isEdit == 0)
			{
				$data = array();
				$this->global['pageTitle'] = 'Error';             
				$this->loadViews("permission", $this->global, $data, NULL);
			}
			else
			{   
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo'));	 
				$TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml')); 
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress')); 
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));  
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
				$SicCode = $this->security->xss_clean($this->input->post('SicCode')); 
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid')); 
                $date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				if($is_tml!=1){
					$OrderNo = $this->security->xss_clean($this->input->post('OrderNo')); 
				}else{	
					$OrderNo = ''; 
				} 
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$LorryType	 = $this->security->xss_clean($this->input->post('LorryType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
				
				if($LorryNo == 0){
					$CHKDUP['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($VechicleRegNo);            
					if($CHKDUP['duplicate']>0){ echo "Error"; exit; }
					
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
                $ticketsInfo = array(  'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance,'pdf_name'=> $TicketUniqueID.".pdf",
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'UpdateUserID'=>$this->session->userdata['userId'] ,
				'Tare'=>$Tare ,'Net'=>$Net ,'TypeOfTicket'=>'Out', 'driver_id'=>$driverid,'is_tml'=>$is_tml,'is_hold'=>0, 'IsInBound'=>0, 'OrderNo'=>$OrderNo, 
				'PaymentType'=>$PaymentType ,'LorryType'=>$LorryType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 'TotalAmount'=>$TotalAmount , 
				'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature );
              
				if( trim($TicketNo)!= "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
				 
					$cond = array( 'TicketNo' => $TicketNo ); 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
					 //var_dump($tupdate);
					if($tupdate==1){    
						
						$data1['tickets'] = $this->Booking_model->BookingTicketInfo($TicketNo); 
						if($data1['tickets']['Status']<4){
								 
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
							$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
							
								
							$html=$this->load->view('Tickets/ticket_pdf_out', $data, true);
							
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
							 
							//load mPDF library
							$this->load->library('m_pdf');

						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);
							 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
								  
							echo base_url($openPath);
						 
						}else{
							
							$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
							$PDFContent = $PDFContentQRY->result(); 
							
							
							$tInfo = array('ReceiptName'=>$data1['tickets']['TicketUniqueID'].".pdf"); 
							$tcond = array( 'LoadID' => $data1['tickets']['LoadID'] );  
							$this->Common_model->update("tbl_booking_loads1", $tInfo, $tcond);
						
							$LT = '';
							if($data1['tickets']['LorryType'] == 1) { $LT = 'Tipper'; }
							else if($data1['tickets']['LorryType'] == 2) { $LT = 'Grab'; }
							else if($data1['tickets']['LorryType'] == 3) { $LT = 'Bin'; }
							else{ $LT = ''; }
						
							$TB = '';
							if($data1['tickets']['TonBook'] == 1) { $TB = ' Tonnage '; } 
							else{ $TB = ' Load '; }
							
							$MaterialText =   $data1['tickets']['MaterialName'].' Delivered '.$LT.' '.$TB;

							$html =  '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
							<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
								<div style="width:100%;" ><div style="width:35%;float: left;" >
								<img src="/assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="80" ></div> 
									<div style="width:65%;float: right;text-align: right;" > 		  
										<b>'.$PDFContent[0]->outpdf_title.'</b><br/>'.$PDFContent[0]->outpdf_address.'<br/> 		 
										<b>Phone:</b> '.$PDFContent[0]->outpdf_phone.'
									</div> 
								</div>	 
								<div style="width:100%;float: left;" >    
									<b>Email:</b> '.$PDFContent[0]->outpdf_email.'<br/>		 
									<b>Web:</b> '.$PDFContent[0]->outpdf_website.' <br/>		 
									<b>Waste License No: </b> '.$PDFContent[0]->waste_licence.' <br/><hr> 
									<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
									<b>Ticket NO:</b> '.$data1['tickets']['TicketNumber'].' <br>		 
									<b>Date Time: </b> '.$data1['tickets']['tdate'].' <br>		   
									<b>In Time: </b> '.$data1['tickets']['SiteIn'].' <br>		   
									<b>Out Time: </b> '.$data1['tickets']['SiteOut'].' <br>		   
									<b>Vehicle Reg. No. </b> '.$data1['tickets']['RegNumber'].' <br> 
									<b>Haulier: </b> '.$data1['tickets']['Hulller'].' <br> 
									<b>Driver Name: </b> '.$data1['tickets']['DriverName'].'<br> 
									<b>Driver Signature: </b> <br> 
									<div><img src="/assets/DriverSignature/'.$data1['tickets']['dsignature'].'" width ="100" height="40" style="float:left"> </div>
									<b>Company Name: </b> '.$data1['tickets']['CompanyName'].' <br>		 
									<b>Site Address: </b> '.$data1['tickets']['OpportunityName'].' <br>	 
									<b>Tip Address: </b> '.$data1['tickets']['TipName'].', '.$data1['tickets']['Street1'].', '.$data1['tickets']['Street2'].', '.$data1['tickets']['Town'].', '.$data1['tickets']['County'].', '.$data1['tickets']['PostCode'].',								<br>	 
									<b>Waste License No:  </b>'.$data1['tickets']['PermitRefNo'].' <br> 
									<b>Material:  '.$MaterialText.' <br></b> 
									<b>SIC Code: </b> '.$data1['tickets']['LoadSICCODE'].' <br> 
									<b>Gross Weight: </b> '.round($data1['tickets']['GrossWeight']).' KGs <br>		 
									<b>Tare Weight: </b> '.round($data1['tickets']['Tare']).' KGs <br>		 
									<b>Net Weight: </b> '.round($data1['tickets']['Net']).' KGs <br> 
									<p style="font-size: 7px;"> '.$PDFContent[0]->outpdf_para1.' <br>  
									'.$PDFContent[0]->outpdf_para2.'<br>  
									<b>'.$PDFContent[0]->outpdf_para3.'</b></p></div> 
								<div style="width:100%;float: left;" > 
									<b>Received By: </b><br> 
									<div><img src="/uploads/Signature/'.$data1['tickets']['Signature'].'" width ="100" height="40" style="float:left"></div> 
									'.$data1['tickets']['CustomerName'].' 
									<p style="font-size: 7px;"><b> '.$PDFContent[0]->outpdf_para4.'</b><br><br> 
										<b>VAT Reg. No: </b> '.$PDFContent[0]->VATRegNo.'<br> 
										<b>Company Reg. No: </b>'.$PDFContent[0]->CompanyRegNo.'<br>
										'.$PDFContent[0]->FooterText.'</p></div></div></body></html>';
							 
								$pdfFilePath =  WEB_ROOT_PATH."/assets/conveyance/".$data1['tickets']['TicketUniqueID'].".pdf"; 		   
								$mpdf =  new mPDF('utf-8', array(70,220),'','',5,5,5,5,5,5); 	   
								$mpdf->keep_table_proportions = false;
								$mpdf->WriteHTML($html);
								$mpdf->Output($pdfFilePath);
							
							  /* =================== Site Logs ===================  */
								/*$OldFile = $pdfFilePath;
								$NewFileName = date('YmdHis').".pdf";
								$NewFile = WEB_ROOT_PATH."/assets/conveyance/".$NewFileName;
									
								copy($OldFile, $NewFile); 
								 
								$SiteLogInfo = array('TableName'=>'tbl_booking_loads1' ,'PrimaryID'=>$LoadID, 
								'FileName'=> $NewFileName , 'UpdatedByUserID'=>$this->session->userdata['userId'],
					'SitePage'=>'delivery date update pdf','RemoteIPAddress'=>$_SERVER['REMOTE_ADDR'],'BrowserAgent'=>getBrowserAgent(),
					'AgentString'=>$this->agent->agent_string(),'UserPlatform'=>$this->agent->platform());          
								$this->Common_model->insert("tbl_site_logs", $SiteLogInfo);  */
							/* ===================================== */
								$openPath =  "/assets/conveyance/".$data1['tickets']['TicketUniqueID'].".pdf";
							 
								echo base_url($openPath);
							
						}
						
					}else{
						echo "SAME";
					} 
                }  
        }
    }
		function EditOutTicketAJAX_(){   
			if($this->isEdit == 0)
			{
				$data = array();
				$this->global['pageTitle'] = 'Error';             
				$this->loadViews("permission", $this->global, $data, NULL);
			}
			else
			{   
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo'));	 
				$TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml')); 
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress')); 
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));  
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
				$SicCode = $this->security->xss_clean($this->input->post('SicCode')); 
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid')); 
                $date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				
				if($is_tml!=1){
					$OrderNo = $this->security->xss_clean($this->input->post('OrderNo')); 
				}else{	
					$OrderNo = ''; 
				} 
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$LorryType	 = $this->security->xss_clean($this->input->post('LorryType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
				
				if($LorryNo == 0){
					$CHKDUP['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($VechicleRegNo);            
					if($CHKDUP['duplicate']>0){ echo "Error"; exit; }
					
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
                $ticketsInfo = array(  'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance,'pdf_name'=> $TicketUniqueID.".pdf",
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'UpdateUserID'=>$this->session->userdata['userId'] ,
				'Tare'=>$Tare ,'Net'=>$Net ,'TypeOfTicket'=>'Out', 'driver_id'=>$driverid,'is_tml'=>$is_tml,'is_hold'=>0, 'IsInBound'=>0, 'OrderNo'=>$OrderNo, 
				'PaymentType'=>$PaymentType ,'LorryType'=>$LorryType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 'TotalAmount'=>$TotalAmount , 
				'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature );
              
				if( trim($TicketNo)!= "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
				 
					$cond = array( 'TicketNo' => $TicketNo ); 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
					 //var_dump($tupdate);
					if($tupdate==1){    
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
							
						$html=$this->load->view('Tickets/ticket_pdf_out', $data, true);
						
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						 
						//load mPDF library
						$this->load->library('m_pdf');

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
						echo base_url($openPath);
						 	
					}else{
						echo "SAME";
					} 
                }  
        }
    }


##############################################################################################


	function AddCollectionTicketAJAX(){   
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {      
                $TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                //$is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$Street1 = $this->security->xss_clean($this->input->post('Street1'));
				$County = $this->security->xss_clean($this->input->post('County'));
				$Town = $this->security->xss_clean($this->input->post('Town'));
				$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
				
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net'));
                 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
                $is_hold = $this->security->xss_clean($this->input->post('is_hold'));
				$date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				$OrderNo = $this->security->xss_clean($this->input->post('OrderNo'));
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$LorryType	 = $this->security->xss_clean($this->input->post('LorryType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
                if($is_hold==0){ 
					if($GrossWeight<1 || $GrossWeight=='' ){ echo "Error"; exit; }
				}
				if($LorryNo == '0'){
					$CHKDUP['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($VechicleRegNo);            
					if($CHKDUP['duplicate']>0){ echo "Error"; exit; }
					
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				if($CompanyID == '0'){ 
					if(trim($CompanyName)==""){ 	
						echo "CompanyNameError";
						exit;
					}
					$CompanyID = $this->generateRandomString();
					$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s') ,); 
					$this->Common_model->insert("tbl_company",$CompanyInfo);
				}	 
				if($OpportunityID == '0'){   
					if(trim($Street1)=="" && trim($Town)=="" && trim($County)=="" && trim($PostCode)==""){ 	
						echo "OpportunityError";
						exit;
					}
					$OpportunityID = $this->generateRandomString(); 
					$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
					$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 'OpenDate'=>date("Y-m-d") , 
					'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode,'Status'=>1); 
					$this->Common_model->insert("tbl_opportunities",$OppoInfo);
					
					$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
					$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
					
						$LoadInfo = array('TipID'=>'1','OpportunityID'=>$OpportunityID,'TipRefNo'=>'','Status'=>'0');  
						$this->Common_model->insert("tbl_opportunity_tip",$LoadInfo);  
				}  
                $TicketUniqueID = $this->generateRandomString();                
                $LastTicketNumber =  $this->tickets_model->LastTicketNo(); 
				if($LastTicketNumber){ 
					$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
				}else{
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
					$TicketNumber = $data['content']['TicketStart'];
				}    
				$TicketDate  = date('Y-m-d H:i:s');
				//$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
                $ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID, 'TicketNumber'=>$TicketNumber, 'TicketDate'=>$TicketDate, 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,'MaterialID'=>$DescriptionofMaterial ,
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,'Net'=>$Net , 'OrderNo'=>$OrderNo , 
				'SicCode'=>$SicCode,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'Collection', 'VatAmount'=>$VatAmount,  
				'pdf_name'=> $TicketUniqueID.".pdf",'driver_id' => $driverid, 'is_hold'=>$is_hold,'IsInBound'=> 0, 'LorryType'=>$LorryType ,'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);

				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                
					$ticketId = $this->Common_model->insert('tbl_tickets', $ticketsInfo);  
					if($ticketId > 0)
					{ 
						if($is_hold == 0){
							$conditions = array(
							 'TicketNo' => $ticketId
							);
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($ticketId); 
		 
							$html=$this->load->view('Tickets/ticket_pdf', $data, true);
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
							  
							 //load mPDF library
							$this->load->library('m_pdf');

						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);
							 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
							echo base_url($openPath);
						}else{
							//$conditions = array( 'is_hold' => 1 , 'delete_notes' => NULL );
							//$HoldTicket = $this->Common_model->select_count_where('tbl_tickets',$conditions); 
							//echo "HOLD|".$HoldTicket;
							echo "HOLD";
						}	
					}
					else
					{
						echo "Error";
					}
					
				}
                  
        }
    }


##############################################################################################

	
	function EditCollectionTicketAJAX(){   
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {     
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo'));	 
				$TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                //$is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net'));
                
                $OrderNo = $this->security->xss_clean($this->input->post('OrderNo'));
                
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid')); 
				$date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$LorryType	 = $this->security->xss_clean($this->input->post('LorryType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
 
				if($LorryNo == 0){
					$CHKDUP['duplicate'] = $this->tickets_model->CheckDuplicateRegNo($VechicleRegNo);            
					if($CHKDUP['duplicate']>0){ echo "Error"; exit; }
					
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,
					'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,
					'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				  
                $ticketsInfo = array( 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,
				'Net'=>$Net , 'SicCode'=>$SicCode,'TypeOfTicket'=>'Collection','UpdateUserID'=>$this->session->userdata['userId'] ,
				'driver_id'=> $driverid, 'is_hold'=>0,'IsInBound'=>0,  'LorryType'=>$LorryType , 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat, 'VatAmount'=>$VatAmount,'OrderNo'=>$OrderNo,
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);

				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                
					$cond = array( 'TicketNo' => $TicketNo ); 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond); 
					if($tupdate==1){  
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
							$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
							
							$html=$this->load->view('Tickets/ticket_pdf', $data, true);
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
							
							//load mPDF library
							$this->load->library('m_pdf');

						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);
							 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
							echo base_url($openPath);
						 
					}else{
						echo "SAME";
					}  
				} 
        }
    }

##############################################################################################

 
    function pageNotFound()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }


    function getMaterialList(){
        $type = $_POST['TicketType'];
        if($type=='In'){
        	$type='IN';
        }else{$type='OUT';}
        $result = $this->tickets_model->getMaterialList($type);
        $html='<option value="">-- Select material type--</option>';
        foreach ($result as $key => $value) {
           $html.="<option value='".$value->MaterialID."'>".$value->MaterialName."</option>";
        }
        echo $html;
  
    }

    function GetWIFNumber(){
        if($_POST){
			 $id = $_POST['id'];
			 $result = $this->tickets_model->GetWIFNumber($id);
			 $aray=array();
			 if($result){
				$DocumentNumber  = $result->DocumentNumber; 
				$aray = array('DocumentNumber' =>$DocumentNumber);
			 }
			 echo json_encode($aray);
        }
    }

    function getMaterialListDetails(){

        if($_POST){
             $id = $_POST['id'];
             $result = $this->tickets_model->getMaterialListDetails($id);
             $aray=array();
             if($result){
                $SicCode  = $result->SicCode;
                $price  = $result->price;
                $aray = array('SicCode' =>$SicCode ,'price'=>$price);
             }
             echo json_encode($aray);
        }
    }

    function getLorryNo(){
        $result = $this->tickets_model->getLorryNo();
        //print_r($result);
        $html='<option value="">-- Select Lorry No --</option>';
        foreach ($result as $key => $value) {
           $html.="<option value='".$value->LorryNo."'>".$value->LorryNo." | ".$value->DriverName." | ".$value->RegNumber."</option>";
        }
       echo $html;
    }
    
    function getLorryNoDetails(){
        if($_POST){
             $id = $_POST['id'];
             $result = $this->tickets_model->getLorryNoDetails($id);
             $aray=array();
            // print_r($result);
             if($result){
                $LorryNo  = $result->LorryNo;
				//if($result->DriverID!=0){
				//	$DriverName  = $result->Dname;
				//}else{
				//	$DriverName  = $result->DriverName;
				//}
				$DriverName  = $result->DriverName;
                $RegNumber  = $result->RegNumber;
                $Tare  = round($result->Tare,2);
                $Haulier  = $result->Haulier;
				$ltsignature  = $result->ltsignature;
                $aray = array('LorryNo' =>$LorryNo ,'DriverName'=>$DriverName,'RegNumber'=>$RegNumber,'Tare'=>$Tare,'Haulier'=>$Haulier,'ltsignature'=>$ltsignature);
             }
           echo  json_encode($aray);
        }
    }

    function getOpportunitiesList(){

       $result = $this->tickets_model->getOpportunitiesList();
        //print_r($result);
        $html='<option value="">-- Select Opportunity --</option>';
        foreach ($result as $key => $value) {
           $html.="<option value='".$value->OpportunityID."'>".$value->OpportunityName."</option>";
        }
       echo $html;  
    }


    function CheckDuplicateTicket(){

        $id = $_POST['id'];
		$tno = $_POST['tno']; 
        $result['duplicate'] = $this->tickets_model->CheckDuplicateTicket($id,$tno);            
		if($result['duplicate']>0){ echo(json_encode(array('status'=>FALSE))); }else{ echo(json_encode(array('status'=>TRUE,'status1'=>$result['duplicate']))); }
        //    if ($result > 0) { echo(json_encode(array('status'=>FALSE)));   }
        //    else { echo(json_encode($result)); }
    }

    function loadAllOpportunitiesByCompany(){
        $id = $_POST['id'];
        $result['Opportunity_list'] = $this->tickets_model->getAllOpportunitiesByCompany($id) ;           
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); }

    }
	
    function LoadMaterials(){

        $type = $_POST['id'];
        $result['material_list'] = $this->tickets_model->getMaterialList($type);  
		 
        if ($result > 0) { echo(json_encode($result)); }
        else { echo(json_encode(array('status'=>FALSE))); }

    }



    function getCustomerDetails(){

        if($_POST){
             $id = $_POST['id'];
             $result = $this->tickets_model->getCustomerDetails($id);
             $aray=array();
             $aray = array('CompanyID' =>'' ,'CompanyName'=>'','address'=>'');
             if($result){
                $CompanyID  = $result->CompanyID;
                $CompanyName  = $result->CompanyName;
                $address  = $result->Street1.', '.$result->Street2.', '.$result->Town.', '.$result->County.'- '.$result->PostCode;
                
                $aray = array('CompanyID' =>$CompanyID ,'CompanyName'=>$CompanyName,'address'=>$address);
             }
           echo  json_encode($aray);
        }

    }


    function genrateBarcode(){        

         $filename = $this->input->post('TicketUniqueID').'.png';
         $TicketNo=$this->input->post('TicketNo');

        $filepath = WEB_ROOT_PATH.'assets/Invoice/'.$filename;

        $text=$this->input->post('TicketUniqueID'); 
        $size="100";
        $orientation="horizontal";
        $code_type="code128a";
        $print=true;
        $SizeFactor=2;

    $code_string = "";
    // Translate the $text into barcode the correct $code_type
    if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
        $chksum = 104;
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ( $X = 1; $X <= strlen($text); $X++ ) {
            $activeKey = substr( $text, ($X-1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum=($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211214" . $code_string . "2331112";
    } elseif ( strtolower($code_type) == "code128a" ) {
        $chksum = 103;
        $text = strtoupper($text); // Code 128A doesn't support lower case
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ( $X = 1; $X <= strlen($text); $X++ ) {
            $activeKey = substr( $text, ($X-1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum=($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211412" . $code_string . "2331112";
    } elseif ( strtolower($code_type) == "code39" ) {
        $code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

        // Convert to uppercase
        $upper_text = strtoupper($text);

        for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
            $code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
        }

        $code_string = "1211212111" . $code_string . "121121211";
    } elseif ( strtolower($code_type) == "code25" ) {
        $code_array1 = array("1","2","3","4","5","6","7","8","9","0");
        $code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

        for ( $X = 1; $X <= strlen($text); $X++ ) {
            for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
                if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
                    $temp[$X] = $code_array2[$Y];
            }
        }

        for ( $X=1; $X<=strlen($text); $X+=2 ) {
            if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
                $temp1 = explode( "-", $temp[$X] );
                $temp2 = explode( "-", $temp[($X + 1)] );
                for ( $Y = 0; $Y < count($temp1); $Y++ )
                    $code_string .= $temp1[$Y] . $temp2[$Y];
            }
        }

        $code_string = "1111" . $code_string . "311";
    } elseif ( strtolower($code_type) == "codabar" ) {
        $code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
        $code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

        // Convert to uppercase
        $upper_text = strtoupper($text);

        for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
            for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
                if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
                    $code_string .= $code_array2[$Y] . "1";
            }
        }
        $code_string = "11221211" . $code_string . "1122121";
    }

    // Pad the edges of the barcode
    $code_length = 20;
    if ($print) {
        $text_height = 30;
    } else {
        $text_height = 0;
    }
    
    for ( $i=1; $i <= strlen($code_string); $i++ ){
        $code_length = $code_length + (integer)(substr($code_string,($i-1),1));
        }

    if ( strtolower($orientation) == "horizontal" ) {
        $img_width = $code_length*$SizeFactor;
        $img_height = $size;
    } else {
        $img_width = $size;
        $img_height = $code_length*$SizeFactor;
    }

    $image = imagecreate($img_width, $img_height + $text_height);
    $black = imagecolorallocate ($image, 0, 0, 0);
    $white = imagecolorallocate ($image, 255, 255, 255);

    imagefill( $image, 0, 0, $white );
    if ( $print ) {
        imagestring($image, 5, 31, $img_height, $text, $black );
    }

    $location = 10;
    for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
        $cur_size = $location + ( substr($code_string, ($position-1), 1) );
        if ( strtolower($orientation) == "horizontal" )
            imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
        else
            imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
        $location = $cur_size;
    }
    
    // Draw barcode to the screen or save in a file
    if ( $filepath=="" ) {
        header ('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    } else {
        imagepng($image,$filepath);
        imagedestroy($image);       
    }

     $ticketsInfo = array('Barcode'=>$filename);
     $cond = array('TicketNo' => $TicketNo);
     $this->Common_model->update("tickets",$ticketsInfo, $cond);     

    echo $filename;
}  
public function generatePdf($pdfId){
        $conditions = array(
                 'TicketNo' => $pdfId
                );
        $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
        $data['tickets'] = $this->Common_model->get_pdf_data($pdfId); 
        $html=$this->load->view('Tickets/ticket_pdf', $data, true);
         //this the the PDF filename that user will get to download
        $pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$data['tickets']['TicketUniqueID'].".pdf";
         //load mPDF library
        $this->load->library('m_pdf');

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
         
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "F");
        $cond = array(
              'TicketNo' => $pdfId
        );
        $ticketsInfo = array('pdf_name'=> $data['tickets']['TicketUniqueID'].".pdf");
        $this->Common_model->update("tickets",$ticketsInfo, $cond); 
        $data['ticketsRecords'] = $this->tickets_model->ticketsListing();            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tickets Listing';
            $this->global['active_menu'] = 'tickets'; 
            $this->loadViews("Tickets/tickets", $this->global, $data, NULL);
         

    }

	public function mypdf(){   
		include_once APPPATH.'/third_party/mpdf/mpdf.php'; 

		$html='<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
		<div style="width:100%;margin-bottom: 0px;margin-top: 0px;" >	
		<div style="width:100%;float: left;font-size: 12px;" > 		
		<center><img src="'.site_url().'assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="100">  </center>  	
		'.$PDFContent[0]->address.' <br/>		
		<b>Tel:</b>  '.$PDFContent[0]->phone.'   (Head Office)<br/> 		
		<b>Email:</b> '.$PDFContent[0]->email.'  <br/>		
		<b>Web:</b> '.$PDFContent[0]->website.'     <br/><br/> 		
		<b>'.$PDFContent[0]->head1.'</b><br>		
		<b>'.$PDFContent[0]->head2.'</b><br><br>				
		<b>WASTE LICENSE NO.:</b> '.$PDFContent[0]->waste_licence.'<br>
		<b>PERMIT REFERENCE NO:</b> '.$PDFContent[0]->reference.'<br><br><br>
		
		<b>Conveyance Note</b><br><br>
		
		<b>Conveyance Note: </b> #'.$dataarr[0]->ConveyanceNo.'  <br>	
		<b>Date Time: </b>'.date("d-m-Y H:i").' <br> 	
		<b>Company Name: </b> '.$dataarr[0]->CompanyName.' <br>		
		<b>Site Address: </b> '.$dataarr[0]->OpportunityName.'<br>		
		<b>Tip Address: </b> kdfjhskdjhfskjdhfksjhdfk<br><br>		
		
		<b>Material: </b> '.$MaterialnameQRY['MaterialName'].' <br><br>				
		<b>Driver Name: </b> '.$user['DriverName'].'<br>		
		<b>Vehicle Reg. No. </b> '.$user['RegNumber'].' <br><br><br>		 		 
		<img src="'.base_url().'/uploads/Signature/'.$SignatureUploadfile_name.'"><br><br>
		<b>Received By: </b> '.$CustomerName.' <br>
		</div></div></body></html>';						

		$pdfFilePath = WEB_ROOT_PATH."assets/".rand().".pdf"; 
		$mpdf =  new mPDF('utf-8', array(104,254));
		$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
		$mpdf->keep_table_proportions = false;
		$mpdf->WriteHTML($html);
		$mpdf->Output($pdfFilePath); 
		
		/*
		$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
		$data['tickets'] = $this->Common_model->get_pdf_data('141'); 
		//var_dump($data);
		//exit;
         $html=$this->load->view('Tickets/ticket_pdf_test', $data, true); 
         //this the the PDF filename that user will get to download
        $pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$data['tickets']['TicketUniqueID'].".pdf";
         //load mPDF library
        $this->load->library('m_pdf'); 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);  
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
		*/
		exit;

    }
	
	function AJAXUpdateGrossWeight(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$TicketNo  = $this->input->post('TicketNo');     
			$Gross  = $this->input->post('Gross');      
			$Tare  = $this->input->post('Tare');      
			     
			//$VAT = (($SubTotal[0]->TotalAmount*20)/100);
			$Net = $Gross-$Tare;
			
			$Tinfo = array('GrossWeight'=>$Gross ,'Net'=> $Net , 'is_tml'=>'1', 'is_hold'=>0,'IsInBound'=>0 , 'GridUpdate'=>1, 'TicketDate'=>date('Y-m-d H:i:s'), 'CreateUserID'=>$this->session->userdata['userId']); 
			$Cond = array( 'TicketNo' => $TicketNo  );  
			$result = $this->Common_model->update("tbl_tickets", $Tinfo, $Cond);
			 
			if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TicketNo'=>$TicketNo))); }
            else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	
	function AJAXUpdateHoldGrossWeight(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$TicketNo  = $this->input->post('TicketNo');     
			$Gross  = $this->input->post('Gross');      
			$Tare  = $this->input->post('Tare');      
			      
			$Net = $Gross-$Tare;
			
			$Tinfo = array('GrossWeight'=>$Gross ,'Net'=> $Net , 'is_tml'=>'1', 'is_hold'=>0,'IsInBound'=>0 , 'GridUpdate'=>1, 'CreateUserID'=>$this->session->userdata['userId']); 
			$Cond = array( 'TicketNo' => $TicketNo  );  
			$result = $this->Common_model->update("tbl_tickets", $Tinfo, $Cond);
			 
			if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TicketNo'=>$TicketNo))); }
            else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	
	function AJAXUpdateTicketDate(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$TicketNo  = $this->input->post('TicketNo');     
			$TicketDate1  = $this->input->post('TicketDate');        
			//exit;
			$t = explode(' ',trim($TicketDate1));  
			$td = explode('/', trim($t[0]));      
			$TicketDate = $td[2]."-".$td[1]."-".$td[0]." ".$t[1]; 
			    
			$Tinfo = array('TicketDate'=>  $TicketDate,  'is_tml'=>'1', 'is_hold'=>0, 'GridUpdate'=>1, 'CreateUserID'=>$this->session->userdata['userId']); 
			$Cond = array( 'TicketNo' => $TicketNo  );  
			$result = $this->Common_model->update("tbl_tickets", $Tinfo, $Cond);
			 
			if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TicketNo'=>$TicketNo))); }
            else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	
	function AJAXUpdateHoldTicketDate(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$TicketNo  = $this->input->post('TicketNo');     
			$TicketDate1  = $this->input->post('TicketDate');        
			//exit;
			$t = explode(' ',trim($TicketDate1));  
			$td = explode('/', trim($t[0]));      
			$TicketDate = $td[2]."-".$td[1]."-".$td[0]." ".$t[1]; 
			    
			$Tinfo = array('TicketDate'=>  $TicketDate,  'is_tml'=>'1', 'is_hold'=>1, 'GridUpdate'=>1, 'CreateUserID'=>$this->session->userdata['userId']); 
			$Cond = array( 'TicketNo' => $TicketNo  );  
			$result = $this->Common_model->update("tbl_tickets", $Tinfo, $Cond);
			 
			if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TicketNo'=>$TicketNo))); }
            else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	function DeliveryHoldTicketsPDF(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			
			$PendingTickets =  $this->tickets_model->GetPendingHoldPDFTickets(); 
			
			//var_dump($PendingTickets);
			//exit;
			if(count($PendingTickets)>0){ 
			
				for($i=0;$i<count($PendingTickets);$i++){
				//for($i=0;$i<1;$i++){
					$html = '';  
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
					$data['driver'] = $this->Common_model->GetDriverDetails($PendingTickets[$i]->DriverLoginID);  
					
					$ticketsInfo1 = array( 'driversignature'=> $data['driver']['ltsignature'] ,'Signature'=> $data['driver']['Signature'] ); 
					$cond1 = array(  'TicketNo' => $PendingTickets[$i]->TicketNo ); 	 
					$tupdate1 = $this->Common_model->update("tickets",$ticketsInfo1, $cond1); 
					 
					$data['tickets'] = $this->Common_model->get_pdf_data($PendingTickets[$i]->TicketNo);  
					
					$TicketUniqueID = $data['tickets']['TicketUniqueID'];  
					 //this the the PDF filename that user will get to download
					$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";   
					$html=$this->load->view('Tickets/ticket_pdf_out', $data, true);
					//$html=$this->load->view('Tickets/Incompleted_PDF', $data, true);
					//load mPDF library
					//$this->load->library('m_pdf'); 
					
					$mpdf =  new mPDF( '"en-GB-x","A5","","",10,10,10,10,6,3' );
					//generate the PDF from the given html 
					//$this->m_pdf->pdf->WriteHTML($html); 
					$mpdf->WriteHTML($html);
					//download it.
					//$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
					$mpdf->Output($pdfFilePath, "F");
					
					$ticketsInfo = array( 'pdf_name'=> $TicketUniqueID.".pdf"); 
					$cond = array(  'TicketNo' => $PendingTickets[$i]->TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond); 
					
				}
			
				echo "All PDF Created Successfully ... ";
			
			}else{
				
				echo "No Pending Tickets ";	
			} 
			exit; 
			//if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TicketNo'=>$TicketNo))); }
            //else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	function IncompletedPDF(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			
			$PendingTickets =  $this->tickets_model->GetPendingPDFTickets(); 
			
			//var_dump($PendingTickets);
			//exit;
			if(count($PendingTickets)>0){ 
			
				for($i=0;$i<count($PendingTickets);$i++){
				//for($i=0;$i<1;$i++){
					$html = '';  
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
					$data['driver'] = $this->Common_model->GetDriverDetails($PendingTickets[$i]->DriverLoginID);  
					
					$ticketsInfo1 = array( 'driversignature'=> $data['driver']['ltsignature'] ); 
					$cond1 = array(  'TicketNo' => $PendingTickets[$i]->TicketNo ); 	 
					$tupdate1 = $this->Common_model->update("tickets",$ticketsInfo1, $cond1); 
					 
					$data['tickets'] = $this->Common_model->get_pdf_data($PendingTickets[$i]->TicketNo);  
					
					$TicketUniqueID = $data['tickets']['TicketUniqueID'];  
					 //this the the PDF filename that user will get to download
					$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";   
					$html=$this->load->view('Tickets/ticket_pdf', $data, true);
					//$html=$this->load->view('Tickets/Incompleted_PDF', $data, true);
					//load mPDF library
					//$this->load->library('m_pdf'); 
					
					$mpdf =  new mPDF( '"en-GB-x","A5","","",10,10,10,10,6,3' );
					//generate the PDF from the given html 
					//$this->m_pdf->pdf->WriteHTML($html); 
					$mpdf->WriteHTML($html);
					//download it.
					//$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
					$mpdf->Output($pdfFilePath, "F");
					
					$ticketsInfo = array( 'pdf_name'=> $TicketUniqueID.".pdf"); 
					$cond = array(  'TicketNo' => $PendingTickets[$i]->TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond); 
					
				}
			
				echo "All PDF Created Successfully ... ";
			
			}else{
				
				echo "No Pending Tickets ";	
			} 
			exit; 
			//if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TicketNo'=>$TicketNo))); }
            //else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	function InBoundPDF(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			
			$PendingTickets =  $this->tickets_model->GetPendingPDFTickets(); 
			
			//var_dump($PendingTickets);
			//exit;
			if(count($PendingTickets)>0){ 
			
				for($i=0;$i<count($PendingTickets);$i++){
				//for($i=0;$i<1;$i++){
					$html = '';  
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
					$data['driver'] = $this->Common_model->GetDriverDetails($PendingTickets[$i]->DriverLoginID);  
					
					$ticketsInfo1 = array( 'driversignature'=> $data['driver']['ltsignature'] ); 
					$cond1 = array(  'TicketNo' => $PendingTickets[$i]->TicketNo ); 	 
					$tupdate1 = $this->Common_model->update("tickets",$ticketsInfo1, $cond1); 
					 
					$data['tickets'] = $this->Common_model->get_pdf_data($PendingTickets[$i]->TicketNo);  
					
					$TicketUniqueID = $data['tickets']['TicketUniqueID'];  
					 //this the the PDF filename that user will get to download
					$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";   
					$html=$this->load->view('Tickets/ticket_pdf', $data, true);
					//$html=$this->load->view('Tickets/Incompleted_PDF', $data, true);
					//load mPDF library
					//$this->load->library('m_pdf'); 
					
					$mpdf =  new mPDF( '"en-GB-x","A5","","",10,10,10,10,6,3' );
					//generate the PDF from the given html 
					//$this->m_pdf->pdf->WriteHTML($html); 
					$mpdf->WriteHTML($html);
					//download it.
					//$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
					$mpdf->Output($pdfFilePath, "F");
					
					$ticketsInfo = array( 'pdf_name'=> $TicketUniqueID.".pdf"); 
					$cond = array(  'TicketNo' => $PendingTickets[$i]->TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond); 
					
				}
			
				echo "All PDF Created Successfully ... ";
			
			}else{
				
				echo "No Pending Tickets ";	
			} 
			exit; 
			//if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TicketNo'=>$TicketNo))); }
            //else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	function TicketMaterialUpdate($TicketNo){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
            if($TicketNo  == null){ redirect('Incompleted-Tickets'); }           
			
			if ($this->input->server('REQUEST_METHOD') === 'POST'){  
				$MaterialID = $this->input->post('MaterialID1');
				$TicketNo = $this->input->post('TicketNo'); 
			 
				$LoadInfo = array('MaterialID'=>$MaterialID); 
				$cond = array( 'TicketNo ' => $TicketNo  );  
				$update = $this->Common_model->update("tbl_tickets", $LoadInfo, $cond);
			 
				if($update){ 	 		  
					$this->session->set_flashdata('success', 'Material has been updated successfully');                 
					redirect('Incompleted-Tickets');  
				}else{
				    redirect('Incompleted-Tickets'); 
				}
			}  
            
        }
    } 
	function TicketMaterialUpdateAjax(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$data['TicketNo']  = $this->input->post('TicketNo');     
			$data['MaterialID']  = $this->input->post('MaterialID');     
			   
			$data['MaterialRecords'] = $this->Booking_model->MaterialListAJAX(); 
			  
			$html = $this->load->view('Tickets/TicketMaterialUpdateAjax', $data, true);  
			echo json_encode($html);   
			  
        }
    }

	function sigJsonToImage ($json, $options = array()) {
		  $defaultOptions = array(
			'imageSize' => array(399, 199)
			,'bgColour' => array(0xff, 0xff, 0xff)
			,'penWidth' => 2
			,'penColour' => array(0x14, 0x53, 0x94)
			,'drawMultiplier'=> 12
		  );

		  $options = array_merge($defaultOptions, $options);

		  $img = imagecreatetruecolor($options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][1] * $options['drawMultiplier']);

		  if ($options['bgColour'] == 'transparent') {
			imagesavealpha($img, true);
			$bg = imagecolorallocatealpha($img, 0, 0, 0, 127);
		  } else {
			$bg = imagecolorallocate($img, $options['bgColour'][0], $options['bgColour'][1], $options['bgColour'][2]);
		  }

		  $pen = imagecolorallocate($img, $options['penColour'][0], $options['penColour'][1], $options['penColour'][2]);
		  imagefill($img, 0, 0, $bg);

		  if (is_string($json))
			$json = json_decode(stripslashes($json));

		  foreach ($json as $v)
			$this->drawThickLine($img, $v->lx * $options['drawMultiplier'], $v->ly * $options['drawMultiplier'], $v->mx * $options['drawMultiplier'], $v->my * $options['drawMultiplier'], $pen, $options['penWidth'] * ($options['drawMultiplier'] / 2));

		  $imgDest = imagecreatetruecolor($options['imageSize'][0], $options['imageSize'][1]);

		  if ($options['bgColour'] == 'transparent') {
			imagealphablending($imgDest, false);
			imagesavealpha($imgDest, true);
		  }

		  imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $options['imageSize'][0], $options['imageSize'][0], $options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][0] * $options['drawMultiplier']);
		  imagedestroy($img);

		  return $imgDest;
	}

	/**
	 *  Draws a thick line
	 *  Changing the thickness of a line using imagesetthickness doesn't produce as nice of result
	 *
	 *  @param object $img
	 *  @param int $startX
	 *  @param int $startY
	 *  @param int $endX
	 *  @param int $endY
	 *  @param object $colour
	 *  @param int $thickness
	 *
	 *  @return void
	 */
	function drawThickLine ($img, $startX, $startY, $endX, $endY, $colour, $thickness) {
		  $angle = (atan2(($startY - $endY), ($endX - $startX)));

		  $dist_x = $thickness * (sin($angle));
		  $dist_y = $thickness * (cos($angle));

		  $p1x = ceil(($startX + $dist_x));
		  $p1y = ceil(($startY + $dist_y));
		  $p2x = ceil(($endX + $dist_x));
		  $p2y = ceil(($endY + $dist_y));
		  $p3x = ceil(($endX - $dist_x));
		  $p3y = ceil(($endY - $dist_y));
		  $p4x = ceil(($startX - $dist_x));
		  $p4y = ceil(($startY - $dist_y));

		  $array = array(0=>$p1x, $p1y, $p2x, $p2y, $p3x, $p3y, $p4x, $p4y);
		  imagefilledpolygon($img, $array, (count($array)/2), $colour);
	}
	
	
	function UpdateTicketPDFTemp(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			
			$PendingTickets =  $this->tickets_model->GetTicketsTemp(); 
			
			//var_dump($PendingTickets);
			//exit;
			if(count($PendingTickets)>0){ 
			
				for($i=0;$i<count($PendingTickets);$i++){
				//for($i=0;$i<1;$i++){
					$html = '';  
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
					$data['driver'] = $this->Common_model->GetDriverDetails($PendingTickets[$i]->DriverLoginID);  
					
					$ticketsInfo1 = array( 'driversignature'=> $data['driver']['ltsignature'] ); 
					$cond1 = array(  'TicketNo' => $PendingTickets[$i]->TicketNo ); 	 
					$tupdate1 = $this->Common_model->update("tickets",$ticketsInfo1, $cond1); 
					 
					$data['tickets'] = $this->Common_model->get_pdf_data($PendingTickets[$i]->TicketNo);  
					
					$TicketUniqueID = $data['tickets']['TicketUniqueID'];  
					 //this the the PDF filename that user will get to download
					$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";   
					$html=$this->load->view('Tickets/ticket_pdf', $data, true);
					//$html=$this->load->view('Tickets/Incompleted_PDF', $data, true);
					//load mPDF library
					//$this->load->library('m_pdf'); 
					
					$mpdf =  new mPDF( '"en-GB-x","A5","","",10,10,10,10,6,3' );
					//generate the PDF from the given html 
					//$this->m_pdf->pdf->WriteHTML($html); 
					$mpdf->WriteHTML($html);
					//download it.
					//$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
					$mpdf->Output($pdfFilePath, "F");
					
					$ticketsInfo = array( 'pdf_name'=> $TicketUniqueID.".pdf"); 
					$cond = array(  'TicketNo' => $PendingTickets[$i]->TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond); 
					
				}
			
				echo "All PDF Created Successfully ... ";
			
			}else{
				
				echo "No Pending Tickets ";	
			} 
			exit; 
			//if ($result > 0) { echo(json_encode(array('status'=>TRUE,'TicketNo'=>$TicketNo))); }
            //else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	 
    
}

?>
