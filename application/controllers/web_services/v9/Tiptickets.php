<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
include_once APPPATH.'/third_party/mpdf/mpdf.php';
//include_once APPPATH.'/third_party/mpdf/mpdf01.php';
class Tiptickets extends REST_Controller {
	
	
	
    public function __construct() { 
        parent::__construct();
        // Load the model
        $this->load->model('ApiModels/Tipticket_API_Model');
		$this->load->model('ApiModels/Drivers_API_Model');
		$this->load->model('Common_model');
        $this->load->database();
    }
    
    private function log_api_data($data) {
        // Load the database library (if not already loaded)
        $this->load->database();
        try {
            // Attempt to insert data into tbl_api_logs
            $this->db->insert('tbl_api_logs', $data);
        } catch (Exception $e) {
            // Handle potential database errors (e.g., logging, notification)
            print_r($e->getMessage());
        }
    }

	public function create_post(){
        
        $token = $this->post('token');
		$siteAddress = $this->post('SiteAddress');
		$tipID = $this->post('TipID');
		//$driverLoginID = $this->post('DriverLoginID');
		$driverName = $this->post('DriverName');
		$materialName = $this->post('MaterialName');
		$tipTicketNo = $this->post('TipTicketNo');
		$remarks = $this->post('Remarks');
		
		$loadID = $this->post('LoadID');
		$companyID = $this->post('CompanyID');
		$opportunityID = $this->post('OpportunityID');
		
		$tipRefNo = $this->post('TipRefNo');
		
		$logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
		
		
		
		$images = $this->post('images');

		$driver_id = $driverLoginID = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');
		
        $data = [];
        $data['tip_ticket_pdf'] = '';
		$data['TipTicketID'] = '';
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);
            
            
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        }else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(empty($driver_id)){
            $status = "0";
            $message ='Please add driver';
        } else if(empty($driverLoginID)){
            $status = "0";
            $message ='Please add driver';
        }else if(empty($siteAddress)){
            $status = "0";
            $message ='Please add site address';
        }else if(empty($tipID)){
            $status = "0";
            $message ='Please add tip';
        }else if(empty($driverName)){
            $status = "0";
            $message ='Please add driver name';
        }else if(empty($materialName)){
            $status = "0";
            $message ='Please add material name';
        }/*else if(empty($tipTicketNo)){
            $status = "0";
            $message ='Please add tipticket number';
        }*//*else if(empty($remarks)){
            $status = "0";
            $message ='Please check required fields';
        }*/ else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
			
            $tipticketsInfo = array(
				'SiteAddress'=>$siteAddress, 
				'TipID'=>$tipID, 
				'DriverLoginID'=>$driverLoginID, 
				'DriverName'=>$driverName,
				'MaterialName'=>$materialName,
				'TipTicketNo'=>$tipTicketNo,
				'Remarks'=>$remarks, 
				'LoadID'=>$loadID, 
				'CompanyID'=>$companyID, 
				'OpportunityID'=>$opportunityID, 
				'TipRefNo'=>$tipRefNo, 
			); 
			
			/*if(isset($_FILES['tipTicketImage']['name']) && !empty($_FILES['tipTicketImage']['name'])){
				$_FILES['file']['name']     = $_FILES['tipTicketImage']['name']; 
				$_FILES['file']['type']     = $_FILES['tipTicketImage']['type']; 
				$_FILES['file']['tmp_name'] = $_FILES['tipTicketImage']['tmp_name']; 
				$_FILES['file']['error']     = $_FILES['tipTicketImage']['error']; 
				$_FILES['file']['size']     = $_FILES['tipTicketImage']['size']; 
				 
				// File upload configuration 
				$uploadPath = './uploads/Photo'; 
				$config['upload_path'] = $uploadPath; 
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['encrypt_name'] = TRUE;
				$config['overwrite']     = FALSE;
				 
				// Load and initialize upload library 
				$this->load->library('upload', $config); 
				$this->upload->initialize($config); 
				 
				// Upload file to server 
				if($this->upload->do_upload('file')){ 
					$fileData = $this->upload->data(); 
					$tipticketsInfo['TicketPhoto'] = $fileData['file_name'];
				}else{  
					$status = "0";
					$message ='Something went wrong while uploading ticket photo.';
					$data = array();
					$data['tip_ticket_pdf'] = '';
					$data['TipTicketID'] = '';
					$this->response([
						'status' => $status,
						'message' => $message,
						'tip_ticket_pdf' => $data['tip_ticket_pdf'],
						'TipTicketID' => $data['TipTicketID'],
						'data' => $data
					], REST_Controller::HTTP_OK);   
				} 
			}*/
			
			
			
			$tipTicketId = $this->Tipticket_API_Model->insert('tbl_tipticket', $tipticketsInfo);
			$tipticketsInfo['CreatedDateTime'] = date("Y-m-d H:i:s");
			$tipticketsInfo['VehicleRegNo'] = '-';
			$this->db->select('tbl_booking_loads1.VehicleRegNo');
            $this->db->from('tbl_booking_loads1');
            $this->db->where('tbl_booking_loads1.LoadID', $loadID);
			$querys = $this->db->get();
			if($querys->num_rows() > 0){
				$dataarrLoad = $querys->result();
				$tipticketsInfo['VehicleRegNo'] = $dataarrLoad[0]->VehicleRegNo;
			}
            
            if(isset($tipTicketId) && !empty($tipTicketId)){
                
				$filesCount = count($_FILES['images']['name']);
				if($filesCount > 0){
					for($i = 0; $i < $filesCount; $i++){ 
						$_FILES['file']['name']     = $_FILES['images']['name'][$i]; 
						$_FILES['file']['type']     = $_FILES['images']['type'][$i]; 
						$_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i]; 
						$_FILES['file']['error']     = $_FILES['images']['error'][$i]; 
						$_FILES['file']['size']     = $_FILES['images']['size'][$i]; 
						 
						// File upload configuration 
						$uploadPath = './uploads/Photo'; 
						$config['upload_path'] = $uploadPath; 
						$config['allowed_types'] = 'jpg|jpeg|png|gif';
						$config['encrypt_name'] = TRUE;
						$config['overwrite']     = FALSE;
						 
						// Load and initialize upload library 
						$this->load->library('upload', $config); 
						$this->upload->initialize($config); 
						 
						// Upload file to server 
						if($this->upload->do_upload('file')){ 
							$fileData = $this->upload->data(); 
							$uploadData = array();
							$uploadData['ImageName'] = $fileData['file_name']; 
							$uploadData['TipTicketID'] = $tipTicketId; 
							$tipTicketPhotoId = $this->Tipticket_API_Model->insert('tbl_tipticket_photos', $uploadData);
						}else{  
							
						} 
					}
					
					
				}
				
					$filesCount = count($_FILES['tipTicketImage']['name']);
					if($filesCount > 0){
						for($i = 0; $i < $filesCount; $i++){ 
							$_FILES['file']['name']     = $_FILES['tipTicketImage']['name'][$i]; 
							$_FILES['file']['type']     = $_FILES['tipTicketImage']['type'][$i]; 
							$_FILES['file']['tmp_name'] = $_FILES['tipTicketImage']['tmp_name'][$i]; 
							$_FILES['file']['error']     = $_FILES['tipTicketImage']['error'][$i]; 
							$_FILES['file']['size']     = $_FILES['tipTicketImage']['size'][$i]; 
							 
							// File upload configuration 
							$uploadPath = './uploads/Photo'; 
							$config['upload_path'] = $uploadPath; 
							$config['allowed_types'] = 'jpg|jpeg|png|gif';
							$config['encrypt_name'] = TRUE;
							$config['overwrite']     = FALSE;
							 
							// Load and initialize upload library 
							$this->load->library('upload', $config); 
							$this->upload->initialize($config); 
							 
							// Upload file to server 
							if($this->upload->do_upload('file')){ 
								$fileData = $this->upload->data(); 
								$uploadData = array();
								$uploadData['ImageName'] = $fileData['file_name']; 
								$uploadData['TipTicketID'] = $tipTicketId; 
								$tipTicketPhotoId = $this->Tipticket_API_Model->insert('tbl_tipticket_images', $uploadData);
							}else{  
								
							} 
						}
					}	
				//$TicketPDF = base_url().'/assets/pdf_file/'.$GrossWeightName['TicketUniqueID'].'.pdf';
				
				//PDF GEN
				
						//TIP Address //
						$tTIPID = $tipID;
						$tipadQRY = $this->db->query("select TipName,Street1,Street2,Town,County,PostCode,PermitRefNo from tbl_tipaddress where TipID = '$tTIPID'");
						$tipadQRY = $tipadQRY->row_array();
                         
                        $PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
                        $PDFContent = $PDFContentQRY->result();
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
                                		<b>Waste License No: </b>'.$PDFContent[0]->waste_licence.' <br/>
										<b>'.$PDFContent[0]->head1.'</b><br/> <br>
										<b>'.$PDFContent[0]->head2.'</b><br/> <br>
										<div style="text-align: center;"><b>Tip Ticket Details</b> </div><br>
                                		<b>Tip Ticket ID:</b> '.$tipTicketId.'<br>	
                                		<b>Permit Reference No: </b>'.$tipadQRY['PermitRefNo'].' <br/>
										<b>Date Time: </b> '.date("d-m-Y H:i:s",strtotime($tipticketsInfo['CreatedDateTime'])).' <br>		
                                		<b>Site Address: </b>'.$siteAddress.' <br>	
                                		<b>TipName: </b> ' . $tipadQRY['TipName']. '<br>
                                		<b>Tip Address: </b> ' . $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'] . '<br>
                                		<b>Driver Name: </b> '.$driverName.' <br>	
										<b>Vehicle Reg. No. </b> '.$tipticketsInfo['VehicleRegNo'].'  <br> 	
                                		<b>Material Name: </b> '.$materialName.'<br>		 		
                                		<b>Tip Ticket No: </b> '.$tipTicketNo.'<br>		
										<b>Tip Reference No: </b> '.$tipRefNo.'<br>	
										<b>Start Time: </b> '.$dataarrLoad[0]->JobStartDateTime.'<br>	
										<b>End Time: </b> '.$dataarrLoad[0]->JobEndDateTime.'<br>	
                                		<b>Remarks: </b> '.$remarks.'  <br> <br/>   
                                	</div>
									<div><img src="/assets/DriverSignature/'.$user['Signature'].'" width ="100" height="40" style="float:left"> </div>  <br> 
                                	<div style="width:100%;float: left;" >
                                		<div style="font-size: 9px;"> 
                                			<b>VAT Reg. No: </b> '.$PDFContent[0]->VATRegNo.' <br>
                                			<b>Company Reg. No: </b> '.$PDFContent[0]->CompanyRegNo.' <br>  
                                			'.$PDFContent[0]->FooterText.'  
                                		</div>
                                	</div>  
                                </div></body></html>';
                        
                        
                        $pdfFilePath = WEB_ROOT_PATH."assets/tiptickets/".$tipTicketId.".pdf";
                        $openPath = "/assets/tiptickets/".$tipTicketId.".pdf";
                        $mpdf =  new mPDF('utf-8', array(70,160),'','',5,5,5,5,5,5);
                        $mpdf->keep_table_proportions = false;
                        $mpdf->WriteHTML($html);
                        $mpdf->Output($pdfFilePath);
                        //END PDF GEN
				
				
				
				
				
				$status = "1";
                $message ='Tip Ticket Added Successfully.';
				$data['tip_ticket_pdf'] = base_url().'/assets/tiptickets/'.$tipTicketId.'.pdf';
				$data['TipTicketID'] = $tipTicketId;
            } else {
                $status = "0";
                $message ='Something went wrong while adding Tip Ticket.';
				$data = array();
				$data['tip_ticket_pdf'] = '';
				$data['TipTicketID'] = '';
            }
            
        }
        $this->response([
            'status' => $status,
            'message' => $message,
			'tip_ticket_pdf' => $data['tip_ticket_pdf'],
			'TipTicketID' => $data['TipTicketID'],
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }

	
	public function update_post(){
        
        $token = $this->post('token');
		$tipTicketID = $tipTicketId = $this->post('TipTicketID');
		$tipTicketNo = $this->post('TipTicketNo');
		$is_tipped = $this->post('is_tipped');
		
		
		
		$siteAddress = $this->post('SiteAddress');
		$tipID = $this->post('TipID');
		$driverName = $this->post('DriverName');
		$materialName = $this->post('MaterialName');
		$remarks = $this->post('Remarks');
		$loadID = $this->post('LoadID');
		$companyID = $this->post('CompanyID');
		$opportunityID = $this->post('OpportunityID');
		$tipRefNo = $this->post('TipRefNo');
		
		
		
		$logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
		
		
		$driver_id = $driverLoginID = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');

		$con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);

		if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        }else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(empty($driver_id)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else{
			$data = [];
			$data['tip_ticket_pdf'] = '';
			// Check user exists with the given credentials
			$con = array();
			$con['conditions'] = array(
				'tbl_tipticket.TipTicketID' => $tipTicketID,
			);
			$ticketExists = $this->Tipticket_API_Model->getRows($con);
				
			if(REST_Controller::TOKEKEYS != $token){
				$status = "0";
				$message ='Invalid API Key';
			}/*else if(empty($tipTicketNo)){
				$status = "0";
				$message ='Please add tipticket number';
			} */else if(empty($ticketExists)){
				$status = "0";
				$message ='Invalid Tip Ticket.';
			}else {
					
				$udateData = array(
					"TipTicketNo" => $tipTicketNo,
				);
				 $udateData = array(
				 	"TipTicketNo" => $tipTicketNo,
					'SiteAddress'=>$siteAddress, 
					'TipID'=>$tipID, 
					'DriverLoginID'=>$driverLoginID, 
					'DriverName'=>$driverName,
					'MaterialName'=>$materialName,
					'TipTicketNo'=>$tipTicketNo,
					'Remarks'=>$remarks, 
					'LoadID'=>$loadID, 
					'CompanyID'=>$companyID, 
					'OpportunityID'=>$opportunityID, 
					'TipRefNo'=>$tipRefNo, 
				); 
				if(isset($is_tipped) && !empty($is_tipped)){
					$udateData['is_tipped'] = 1;
				}
				
				
				$filesCount = count($_FILES['tipTicketImage']['name']);
				if($filesCount > 0){
					for($i = 0; $i < $filesCount; $i++){ 
						$_FILES['file']['name']     = $_FILES['tipTicketImage']['name'][$i]; 
						$_FILES['file']['type']     = $_FILES['tipTicketImage']['type'][$i]; 
						$_FILES['file']['tmp_name'] = $_FILES['tipTicketImage']['tmp_name'][$i]; 
						$_FILES['file']['error']     = $_FILES['tipTicketImage']['error'][$i]; 
						$_FILES['file']['size']     = $_FILES['tipTicketImage']['size'][$i]; 
						
						// File upload configuration 
						$uploadPath = './uploads/Photo'; 
						$config['upload_path'] = $uploadPath; 
						$config['allowed_types'] = 'jpg|jpeg|png|gif';
						$config['encrypt_name'] = TRUE;
						$config['overwrite']     = FALSE;
						
						// Load and initialize upload library 
						$this->load->library('upload', $config); 
						$this->upload->initialize($config); 
						
						// Upload file to server 
						if($this->upload->do_upload('file')){ 
							$fileData = $this->upload->data(); 
							$uploadData = array();
							$uploadData['ImageName'] = $fileData['file_name']; 
							$uploadData['TipTicketID'] = $tipTicketID; 
							$tipTicketPhotoId = $this->Tipticket_API_Model->insert('tbl_tipticket_images', $uploadData);
						}else{  
							
						} 
					}

				}
				
				
				/*if(isset($_FILES['tipTicketImage']['name']) && !empty($_FILES['tipTicketImage']['name'])){
				$_FILES['file']['name']     = $_FILES['tipTicketImage']['name']; 
				$_FILES['file']['type']     = $_FILES['tipTicketImage']['type']; 
				$_FILES['file']['tmp_name'] = $_FILES['tipTicketImage']['tmp_name']; 
				$_FILES['file']['error']     = $_FILES['tipTicketImage']['error']; 
				$_FILES['file']['size']     = $_FILES['tipTicketImage']['size']; 
				 
				// File upload configuration 
				$uploadPath = './uploads/Photo'; 
				$config['upload_path'] = $uploadPath; 
				$config['allowed_types'] = 'jpg|jpeg|png|gif';
				$config['encrypt_name'] = TRUE;
				$config['overwrite']     = FALSE;
				 
				// Load and initialize upload library 
				$this->load->library('upload', $config); 
				$this->upload->initialize($config); 
				 
				// Upload file to server 
				if($this->upload->do_upload('file')){ 
					$fileData = $this->upload->data(); 
					$udateData['TicketPhoto'] = $fileData['file_name'];
				}else{  
					$status = "0";
					$message ='Something went wrong while uploading ticket photo.';
					$data = array();
					$data['tip_ticket_pdf'] = '';
					$data['TipTicketID'] = '';
					$this->response([
						'status' => $status,
						'message' => $message,
						'tip_ticket_pdf' => $data['tip_ticket_pdf'],
						'TipTicketID' => $data['TipTicketID'],
						'data' => $data
					], REST_Controller::HTTP_OK);   
				} 
			}*/
				
				
				
				
				$this->db->where('TipTicketID',$tipTicketID);
				$this->db->update("tbl_tipticket", $udateData);
				
				
				
				$filesCount = count($_FILES['images']['name']);
				if($filesCount > 0){
					for($i = 0; $i < $filesCount; $i++){ 
						$_FILES['file']['name']     = $_FILES['images']['name'][$i]; 
						$_FILES['file']['type']     = $_FILES['images']['type'][$i]; 
						$_FILES['file']['tmp_name'] = $_FILES['images']['tmp_name'][$i]; 
						$_FILES['file']['error']     = $_FILES['images']['error'][$i]; 
						$_FILES['file']['size']     = $_FILES['images']['size'][$i]; 
						
						// File upload configuration 
						$uploadPath = './uploads/Photo'; 
						$config['upload_path'] = $uploadPath; 
						$config['allowed_types'] = 'jpg|jpeg|png|gif';
						$config['encrypt_name'] = TRUE;
						$config['overwrite']     = FALSE;
						
						// Load and initialize upload library 
						$this->load->library('upload', $config); 
						$this->upload->initialize($config); 
						
						// Upload file to server 
						if($this->upload->do_upload('file')){ 
							$fileData = $this->upload->data(); 
							$uploadData = array();
							$uploadData['ImageName'] = $fileData['file_name']; 
							$uploadData['TipTicketID'] = $tipTicketID; 
							$tipTicketPhotoId = $this->Tipticket_API_Model->insert('tbl_tipticket_photos', $uploadData);
						}else{  
							
						} 
					}

				}
				
				
				
				
				
				
				
				
				
				
				
				$ticketExists = $this->Tipticket_API_Model->getRows($con);
				$siteAddress = $ticketExists[0]['SiteAddress'];
				$tipID = $ticketExists[0]['TipID'];
				$driverLoginID = $ticketExists[0]['DriverLoginID'];
				$driverName = $ticketExists[0]['DriverName'];
				$materialName = $ticketExists[0]['MaterialName'];
				$tipTicketNo = $ticketExists[0]['TipTicketNo'];
				$remarks = $ticketExists[0]['Remarks'];
				$tipTicketId = $ticketExists[0]['TipTicketID'];
				$tipRefNo = $ticketExists[0]['TipRefNo'];
				$createdDateTime = $ticketExists[0]['CreatedDateTime'];
				$loadID = $ticketExists[0]['LoadID'];
				
				$this->db->select('tbl_booking_loads1.VehicleRegNo');
				$this->db->from('tbl_booking_loads1');
				$this->db->where('tbl_booking_loads1.LoadID', $loadID);
				$querys = $this->db->get();
				$VehicleRegNo = '';
				if($querys->num_rows() > 0){
					$dataarrLoad = $querys->result();
					$VehicleRegNo = $dataarrLoad[0]->VehicleRegNo;
				}
				
				$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
				$PDFContent = $PDFContentQRY->result();
				
				// Check user exists with the given credentials
				
				$con['returnType'] = 'single';
				$con['conditions'] = array(
					'DriverID' => $driver_id,
					'Status' => 0
				);
				$user = $this->Drivers_API_Model->getRows($con);
				
				
				//TIP Address //
							$tTIPID = $tipID;
							$tipadQRY = $this->db->query("select TipName,Street1,Street2,Town,County,PostCode,PermitRefNo from tbl_tipaddress where TipID = '$tTIPID'");
							$tipadQRY = $tipadQRY->row_array();
							
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
											<b>Waste License No: </b>'.$PDFContent[0]->waste_licence.' <br/>
											<b>'.$PDFContent[0]->head1.'</b><br/> <br>
											<b>'.$PDFContent[0]->head2.'</b><br/> <br>
											<div style="text-align: center;"><b>Tip Ticket Details</b> </div><br>
											<b>Tip Ticket ID:</b> '.$tipTicketId.'<br>		
											<b>Permit Reference No: </b>'.$tipadQRY['PermitRefNo'].' <br/><hr>
											<b>Date Time: </b> '.date("d-m-Y H:i:s",strtotime($createdDateTime)).' <br>		
											<b>Site Address: </b>'.$siteAddress.' <br>		 
											<b>TipName: </b> ' . $tipadQRY['TipName']. '<br>
                                		    <b>Tip Address: </b> ' . $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'] . '<br>
											<b>Driver Name: </b> '.$driverName.' <br>		
											<b>Vehicle Reg. No. </b> '.$VehicleRegNo.'  <br> 
											<b>Material Name: </b> '.$materialName.'<br>		 		
											<b>Tip Ticket No: </b> '.$tipTicketNo.'<br>	
											<b>Tip Reference No: </b> '.$tipRefNo.'<br>		 		 
											<b>Remarks: </b> '.$remarks.'  <br> <br/>   
										</div>
										<div><img src="/assets/DriverSignature/'.$user['Signature'].'" width ="100" height="40" style="float:left"> </div>  <br> 
										<div style="width:100%;float: left;" >
											<div style="font-size: 9px;"> 
												<b>VAT Reg. No: </b> '.$PDFContent[0]->VATRegNo.' <br>
												<b>Company Reg. No: </b> '.$PDFContent[0]->CompanyRegNo.' <br>  
												'.$PDFContent[0]->FooterText.'  
											</div>
										</div>  
									</div></body></html>';
				
				$pdfFilePath = WEB_ROOT_PATH."assets/tiptickets/".$tipTicketId.".pdf";
				if ( file_exists($pdfFilePath) ) { 
					@unlink($pdfFilePath);
				}
				$openPath = "/assets/tiptickets/".$tipTicketId.".pdf";
				$mpdf =  new mPDF('utf-8', array(70,160),'','',5,5,5,5,5,5);
				$mpdf->keep_table_proportions = false;
				$mpdf->WriteHTML($html);
				$mpdf->Output($pdfFilePath);
				
				$data['tip_ticket_pdf'] = base_url().'/assets/tiptickets/'.$tipTicketId.'.pdf';
				
				
				
				
				$status = "1";
				$message = 'Tip Ticket Updated Successfully.';
			}
		}
        $this->response([
            'status' => $status,
            'message' => $message,
			'tip_ticket_pdf' => $data['tip_ticket_pdf'],
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
	
	public function list_get(){
		$token = $this->get('token');
		//$driverLoginID = $this->get('DriverLoginID');
		$driver_id = $driverLoginID = $this->get('driver_id');
        $lorry_no = $DriverID = $this->get('lorry_no');
		$con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        
        $logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
        
        $user = $this->Drivers_API_Model->getRows($con);
		if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        }else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(empty($driver_id) || empty($DriverID)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else if(empty($driverLoginID)){
            $status = "0";
            $message ='Please add driver';
        }else{
			$this->db->select('*');
			$this->db->from('tbl_tipticket');
			$this->db->where('DriverLoginID', $driverLoginID);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$status = "1";
				$message ='';
				$results = $query->result();
				foreach($results as $i=>$result){
					$this->db->select('*');
					$this->db->from('tbl_tipticket_photos');
					$this->db->where('TipTicketID', $result->TipTicketID);
					$query = $this->db->get();
					if($query->num_rows() > 0){
						$images = $query->result();
						$newImages = array();
						foreach($images as $j=>$image){
							$images[$j]->ImageName = base_url().'/uploads/Photo/'.$image->ImageName;
						}
						$results[$i]->images = $images;
					}
					$results[$i]->tip_ticket_pdf = base_url().'/assets/tiptickets/'.$result->TipTicketID.'.pdf';
				}
				$results = array_reverse($results);
				$data = $results;
			} else {
				$status = "0";
				$message ='No Records Found.';
				$data = array();
			}
		}
		$this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK); 
	}
    
    public function tipticketdetail_get(){
		$token = $this->get('token');
		//$driverLoginID = $this->get('DriverLoginID');
		$tipTicketID = $this->get('TipTicketID');
		$driver_id = $driverLoginID = $this->get('driver_id');
        $lorry_no = $DriverID = $this->get('lorry_no');

		$con['returnType'] = 'single';
		$con['conditions'] = array(
			'DriverID' => $driver_id,
			'Status' => 0
		);
		
		$logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
		
		$user = $this->Drivers_API_Model->getRows($con);

		if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        }else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(empty($driver_id) || empty($DriverID)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else if(empty($driverLoginID)){
            $status = "0";
            $message ='Please add driver';
        }else if(empty($tipTicketID)){
            $status = "0";
            $message ='Please add tip ticket';
        }else{
			$this->db->select('*');
			$this->db->from('tbl_tipticket');
			$this->db->where('DriverLoginID', $driverLoginID);
			$this->db->where('TipTicketID', $tipTicketID);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$status = "1";
				$message ='';
				
				
				$results = $query->result();
				foreach($results as $i=>$result){
					
					if(isset($result->TicketPhoto) && !empty($result->TicketPhoto)){
						$result->TicketPhoto = base_url().'/uploads/Photo/'.$result->TicketPhoto;
					}
					
					
					$this->db->select('*');
					$this->db->from('tbl_tipticket_images');
					$this->db->where('TipTicketID', $result->TipTicketID);
					$query = $this->db->get();
					if($query->num_rows() > 0){
						$images = $query->result();
						$newImages = array();
						foreach($images as $j=>$image){
							$images[$j]->ImageName = base_url().'/uploads/Photo/'.$image->ImageName;
						}
						$results[$i]->TicketPhoto = $images;
					}
					
					
				
					$this->db->select('*');
					$this->db->from('tbl_tipticket_photos');
					$this->db->where('TipTicketID', $result->TipTicketID);
					$query = $this->db->get();
					if($query->num_rows() > 0){
						$images = $query->result();
						$newImages = array();
						foreach($images as $j=>$image){
							$images[$j]->ImageName = base_url().'/uploads/Photo/'.$image->ImageName;
						}
						$results[$i]->images = $images;
					}
					$results[$i]->tip_ticket_pdf = base_url().'/assets/tiptickets/'.$result->TipTicketID.'.pdf';
				}
				$data = $results;
			} else {
				$status = "0";
				$message ='No Records Found.';
				$data = array();
			}
		}
		$this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK); 
	}
	
	public function siteaddress_get(){
		$token = $this->get('token');
		$driver_id = $this->get('driver_id');
        $lorry_no = $DriverID = $this->get('lorry_no');

		$con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        
        $logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
        
        $user = $this->Drivers_API_Model->getRows($con);

		if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        }else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(empty($driver_id) || empty($DriverID)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else{
			$this->db->select('*');
			$this->db->from('tbl_tipaddress');
			//$this->db->where('Operation', $Operation);
			$query = $this->db->get();
			
			if($query->num_rows() > 0){
				$status = "1";
				$message ='';
				$data = $query->result();
			} else {
				$status = "0";
				$message ='No Records Found.';
				$data = array();
			}
		}
		$this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
		
	}
	
	public function tipticketopportunity_get(){
		$token = $this->get('token');
		$tipID = $this->get('TipID');
		$driver_id = $this->get('driver_id');
        $lorry_no = $DriverID = $this->get('lorry_no');

		$con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        
        $logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
        
        $user = $this->Drivers_API_Model->getRows($con);
		if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        }else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(empty($driver_id) || empty($DriverID)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else if(empty($tipID)){
            $status = "0";
            $message ='Please add tip';
        }else{
			
			$this->db->select('*');
			$this->db->from('tbl_opportunity_tip');
			$this->db->where("TipID=".$tipID);
			$this->db->where("Status", 0);
			$query = $this->db->get();
			$resultData = array();
			if($query->num_rows() > 0){
				$status = "1";
				$message ='';
				$results = $query->result();
				
				foreach($results as $result){
					$opId = $result->OpportunityID;
					$this->db->select('*');
					$this->db->from('tbl_opportunities');
					$this->db->where("OpportunityID",$opId);
					$query = $this->db->get();
					if($query->num_rows() > 0){
						$innerresults = $query->result();
						$innerresults[0]->TipRefNo = $result->TipRefNo;
						$resultData[] = $innerresults[0];
					}
				}
				
				
				
				
				
				
				$data = $resultData;
			} else {
				$status = "0";
				$message ='No Records Found.';
				$data = array();
			}
			
			
			
			/*$this->db->select('*');
			$this->db->from('tbl_opportunities');
			$this->db->where("TipAutho LIKE '%".$tipID.",%' OR TipAutho LIKE '%,".$tipID."%' OR TipAutho=".$tipID);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$status = "1";
				$message ='';
				$results = $query->result();
				$data = $results;
			} else {
				$status = "0";
				$message ='No Records Found.';
				$data = array();
			}*/
		}
		$this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK); 
	}

	public function tipticketopportunitynew_get()
	{
		$token = $this->get('token');
		$tipID = $this->get('TipID');
		$driver_id = $this->get('driver_id');
		$lorry_no = $DriverID = $this->get('lorry_no');

		// Pagination parameters
		$page = (int)$this->get('page') ?? 1;
		$limit = (int)$this->get('limit') ?? 10;
		if ($page < 1) $page = 1;
		if ($limit < 1) $limit = 10;

		$offset = ($page - 1) * $limit;

		$con['returnType'] = 'single';
		$con['conditions'] = array(
			'DriverID' => $driver_id,
			'Status' => 0
		);

		$logData = [
			'driver_id' => $this->post('driver_id') ?? "",
			'lorry_no' => $this->post('lorry_no') ?? "",
			'api_call' => __METHOD__, // Get current method name
			'api_request' => json_encode($this->post())
		];

		$this->log_api_data($logData);

		$user = $this->Drivers_API_Model->getRows($con);

		if (REST_Controller::TOKEKEYS != $token) {
			$status = "0";
			$message = 'Invalid API Key';
			$data = [];
		} else if (!isset($lorry_no) || empty($lorry_no)) {
			$status = "0";
			$message = 'Invalid Request';
			$data = [];
		} else if (empty($driver_id) || empty($DriverID)) {
			$status = "0";
			$message = 'Please check required fields';
			$data = [];
		} else if (empty($user)) {
			$status = "0";
			$message = 'User id not found or account disabled';
			$data = [];
		} else if (empty($tipID)) {
			$status = "0";
			$message = 'Please add tip';
			$data = [];
		} else {

			// Count total records first
			$this->db->select('COUNT(*) as total');
			$this->db->from('tbl_opportunity_tip');
			$this->db->where("TipID", $tipID);
			$this->db->where("Status", 0);
			$totalQuery = $this->db->get()->row();
			$totalRecords = $totalQuery ? (int)$totalQuery->total : 0;

			// Fetch paginated results
			$this->db->select('*');
			$this->db->from('tbl_opportunity_tip');
			$this->db->where("TipID", $tipID);
			$this->db->where("Status", 0);
			$this->db->limit($limit, $offset);
			$query = $this->db->get();

			$resultData = [];
			if ($query->num_rows() > 0) {
				$status = "1";
				$message = '';
				$results = $query->result();

				foreach ($results as $result) {
					$opId = $result->OpportunityID;
					$this->db->select('*');
					$this->db->from('tbl_opportunities');
					$this->db->where("OpportunityID", $opId);
					$innerQuery = $this->db->get();

					if ($innerQuery->num_rows() > 0) {
						$innerresults = $innerQuery->result();
						$innerresults[0]->TipRefNo = $result->TipRefNo;
						$resultData[] = $innerresults[0];
					}
				}

				$data = [
					'records' => $resultData,
					'pagination' => [
						'total' => $totalRecords,
						'page' => $page,
						'limit' => $limit,
						'total_pages' => ceil($totalRecords / $limit)
					]
				];
			} else {
				$status = "0";
				$message = 'No Records Found.';
				$data = [
					'records' => [],
					'pagination' => [
						'total' => 0,
						'page' => $page,
						'limit' => $limit,
						'total_pages' => 0
					]
				];
			}
		}

		$this->response([
			'status' => $status,
			'message' => $message,
			'data' => $data
		], REST_Controller::HTTP_OK);
	}

}	