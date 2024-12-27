<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Booking extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        
        // Load the model
        $this->load->model('ApiModels/Booking_API_Model');
        $this->load->model('ApiModels/Drivers_API_Model');
        $this->load->database();
    }
    
    public function booking_list_post($LorryNo = 0){
        
        
        $token = $this->post('token');
        $BookingID = $this->post('BookingID');
        $DriverID = $this->post('DriverID');
        $Load_status = $this->post('Load_status');
        $BookingType = $this->post('BookingType');
        $BookingID = $this->post('BookingID');
        $data = [];
        
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'LorryNo' => $DriverID,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);
            
            
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($DriverID)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
            if($Load_status=='0' OR ($Load_status != '' OR !empty($Load_status))) {
                $ql = 1; 
                if($BookingID){
                    $qu = 1;
                    $this->db->select('tbl_booking.*, tbl_company.CompanyName, tbl_opportunities.OpportunityName,tbl_opportunities.Street1,IFNULL(tbl_opportunities.Street2, "") as Street2,tbl_opportunities.Town,tbl_opportunities.County,tbl_opportunities.PostCode, tbl_booking_loads.LoadID,tbl_booking_loads.Status as Load_status');
                    $this->db->from('tbl_booking_loads');
                    $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
                    $this->db->join('tbl_company', 'tbl_booking_loads.BookingID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID');
                    $this->db->where('tbl_booking_loads.DriverID', $DriverID);
                    $this->db->where('tbl_booking_loads.Status', $Load_status);
                    $this->db->where('tbl_booking.BookingID', $BookingID);
                    $this->db->group_by('tbl_booking.BookingID');
                    $query = $this->db->get();
                } else if($BookingType){
                    $qu = 2;
                    $this->db->select('tbl_booking.*, tbl_company.CompanyName, tbl_opportunities.OpportunityName,tbl_opportunities.Street1,IFNULL(tbl_opportunities.Street2, "") as Street2,tbl_opportunities.Town,tbl_opportunities.County,tbl_opportunities.PostCode, tbl_booking_loads.LoadID,tbl_booking_loads.Status as Load_status');
                    $this->db->from('tbl_booking_loads');
                    $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
                    $this->db->join('tbl_company', 'tbl_booking_loads.BookingID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID');
                    $this->db->where('tbl_booking_loads.DriverID', $DriverID);
                    $this->db->where('tbl_booking.BookingType', $BookingType);
                    $this->db->group_by('tbl_booking.BookingID');
                    $query = $this->db->get();
                } else {
                    $qu = 3;
                    $this->db->select('tbl_booking.*, tbl_company.CompanyName, tbl_opportunities.OpportunityName,tbl_opportunities.Street1,IFNULL(tbl_opportunities.Street2, "") as Street2,tbl_opportunities.Town,tbl_opportunities.County,tbl_opportunities.PostCode, tbl_booking_loads.LoadID,tbl_booking_loads.Status as Load_status');
                    $this->db->from('tbl_booking_loads');
                    $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
                    $this->db->join('tbl_company', 'tbl_booking_loads.BookingID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID');
                    $this->db->where('tbl_booking_loads.DriverID', $DriverID);
                    $this->db->where('tbl_booking_loads.Status', $Load_status);
                    $this->db->group_by('tbl_booking.BookingID'); 
                    $query = $this->db->get();
                }
            }else {
                $ql = 2; 
                if($BookingID){
                    $qu = 4;
                    $this->db->select('tbl_booking.*, tbl_company.CompanyName, tbl_opportunities.OpportunityName,tbl_opportunities.Street1,IFNULL(tbl_opportunities.Street2, "") as Street2,tbl_opportunities.Town,tbl_opportunities.County,tbl_opportunities.PostCode, tbl_booking_loads.LoadID,tbl_booking_loads.Status as Load_status');
                    $this->db->from('tbl_booking_loads');
                    $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
                    $this->db->join('tbl_company', 'tbl_booking_loads.BookingID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID');
                    $this->db->where('tbl_booking_loads.DriverID', $DriverID);
                    $this->db->where('tbl_booking.BookingID', $BookingID);
                    $this->db->group_by('tbl_booking.BookingID');
                    $query = $this->db->get();
                } else if($BookingType){
                    $qu = 5;
                    $this->db->select('tbl_booking.*, tbl_company.CompanyName, tbl_opportunities.OpportunityName,tbl_opportunities.Street1,IFNULL(tbl_opportunities.Street2, "") as Street2,tbl_opportunities.Town,tbl_opportunities.County,tbl_opportunities.PostCode, tbl_booking_loads.LoadID,tbl_booking_loads.Status as Load_status');
                    $this->db->from('tbl_booking_loads');
                    $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
                    $this->db->join('tbl_company', 'tbl_booking_loads.BookingID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID');
                    $this->db->where('tbl_booking_loads.DriverID', $DriverID);
                    $this->db->where('tbl_booking.BookingType', $BookingType);
                    $this->db->group_by('tbl_booking.BookingID');
                    $query = $this->db->get();
                } else {
                    $qu = 6;
                    $this->db->select('tbl_booking.*, tbl_company.CompanyName, tbl_opportunities.OpportunityName,tbl_opportunities.Street1,IFNULL(tbl_opportunities.Street2, "") as Street2,tbl_opportunities.Town,tbl_opportunities.County,tbl_opportunities.PostCode, tbl_booking_loads.LoadID,tbl_booking_loads.Status as Load_status');
                    $this->db->from('tbl_booking_loads');
                    $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
                    $this->db->join('tbl_company', 'tbl_booking_loads.BookingID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking.OpportunityID = tbl_opportunities.OpportunityID');
                    $this->db->where('tbl_booking_loads.DriverID', $DriverID);
                    $this->db->group_by('tbl_booking.BookingID');
                    $query = $this->db->get();
                }
            }
            if($query->num_rows() > 0){
                $status = "1";
                $message ='Booking Data. '.$ql.' '.$qu;
                $data = $query->result();
            } else {
                $status = "0";
                $message ='Booking data not found. '.$ql.' '.$qu;
            }
                
            
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
    
    public function booking_statuschange_post($LorryNo = 0){
        
        
        $token = $this->post('token');
        $DriverID = $this->post('DriverID');
        $DriverName = $this->post('DriverName');
        $VehicleRegNo = $this->post('VehicleRegNo');
        $LoadID = $this->post('LoadID');
        $Signature = $this->post('Signature');
        $ReceiptName = $this->post('ReceiptName');
        $Load_status = $this->post('Load_status');
        $data = [];
        
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'LorryNo' => $DriverID,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);
            
            
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($DriverID) || empty($DriverName) || empty($VehicleRegNo) || empty($LoadID) || empty($Load_status)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
            $this->db->select('tbl_booking.*, tbl_booking_loads.Status as Load_status');
            $this->db->from('tbl_booking_loads');
            $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
            $this->db->where('tbl_booking_loads.LoadID', $LoadID);
            $this->db->where('tbl_booking_loads.DriverID', $DriverID);
            $query = $this->db->get();
            
            if($query->num_rows() > 0){
                if($Load_status == 1){
                    $udateData = array(
                        "DriverName" => $DriverName,
                        "VehicleRegNo" => $VehicleRegNo,
                        "Status" => 1,
                        "JobStartDateTime" => date("Y-m-d H:i:s"),
                    );
                    $this->db->where('LoadID',$LoadID);
                    $this->db->update("tbl_booking_loads", $udateData);
                    $status = "1";
                    $message ='Status changed successfully';
                } else if($Load_status == 2){
                    $udateData = array(
                        "Status" => 2,
                        "SiteInDateTime" => date("Y-m-d H:i:s"),
                    );
                    $this->db->where('LoadID',$LoadID);
                    $this->db->update("tbl_booking_loads", $udateData);
                    $status = "1";
                    $message ='Status changed successfully';
                } else if($Load_status == 3){
                    
                    
                    //Singnature
                    
                    $config['upload_path']   = './uploads/Signature/'; 
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['encrypt_name'] = TRUE;
                    $config['overwrite']     = FALSE;
                    $this->load->library('upload', $config);
                    if ( ! $this->upload->do_upload('Signature')) {
                        $SignatureUpload = '';
                    } else {
                        $SignatureUpload = $this->upload->data();
                    } 
                    
                    
                    $filesCount = count($_FILES['photos']['name']);
                    for($i = 0; $i < $filesCount; $i++){ 
                        $_FILES['file']['name']     = $_FILES['photos']['name'][$i]; 
                        $_FILES['file']['type']     = $_FILES['photos']['type'][$i]; 
                        $_FILES['file']['tmp_name'] = $_FILES['photos']['tmp_name'][$i]; 
                        $_FILES['file']['error']     = $_FILES['photos']['error'][$i]; 
                        $_FILES['file']['size']     = $_FILES['photos']['size'][$i]; 
                         
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
                            // Uploaded file data 
                            $fileData = $this->upload->data(); 
                            $uploadData[$i]['file_name'] = $fileData['file_name']; 
                            $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s"); 
                            
                           // echo $uploadData[$i]['file_name'].' ';
                           $ImageName = $uploadData[$i]['file_name'];
                           $this->db->query("INSERT INTO `tbl_booking_loads_photos` (`PhotoID`, `LoadID`, `DriverID`, `ImageName`, `CreateDateTime`, `UpdateDateTime`) VALUES 
                           (NULL, '$LoadID', '$DriverID', '$ImageName', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
                        }else{  
                            
                        } 
                    } 
                    
                    //print_r($SignatureUpload);
                    //echo $SignatureUpload['file_name'];
                    //print_r($dataInfo);
                    //exit();
                    $udateData = array(
                        "Signature" => $SignatureUpload['file_name'],
                        "ReceiptName" => $ReceiptName,
                        "Status" => 3,
                        "SiteOutDateTime" => date("Y-m-d H:i:s"),
                    );
                    $this->db->where('LoadID',$LoadID);
                    $this->db->update("tbl_booking_loads", $udateData);
                    $status = "1";
                    $message ='Status changed successfully';
                } else if($Load_status == 4){
                    $udateData = array(
                        "Status" => 4,
                        "TipINDateTIme" => date("Y-m-d H:i:s"),
                    );
                    $this->db->where('LoadID',$LoadID);
                    $this->db->update("tbl_booking_loads", $udateData);
                    $status = "1";
                    $message ='Status changed successfully';
                } else if($Load_status == 5){
                    $udateData = array(
                        "Status" => 5,
                        "TipOutDateTime" => date("Y-m-d H:i:s"),
                    );
                    $this->db->where('LoadID',$LoadID);
                    $this->db->update("tbl_booking_loads", $udateData);
                    $status = "1";
                    $message ='Status changed successfully';
                } else if($Load_status == 6){
                    $udateData = array(
                        "Status" => 6,
                        "JobEndDateTime" => date("Y-m-d H:i:s"),
                    );
                    $this->db->where('LoadID',$LoadID);
                    $this->db->update("tbl_booking_loads", $udateData);
                    $status = "1";
                    $message ='Status changed successfully';
                } else {
                    $status = "0";
                    $message ='Invalid Status code';
                }
                
                
                $data = $query->result();
            } else {
                $status = "0";
                $message ='Booking data not found.';
            }
                
            
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
    
    public function materials_list_post($LorryNo = 0){
        
        
        $token = $this->post('token');
        $DriverID = $this->post('DriverID');
        $BookingType = $this->post('BookingType');
        $data = [];
        
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'LorryNo' => $DriverID,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);
            
            
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($DriverID) || empty($BookingType)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
            if($BookingType == '1'){
                $Operation = 'IN';
            } else {
                $Operation = 'COLLECTION';
            }
            $this->db->select('*');
            $this->db->from('tbl_materials');
            $this->db->where('Operation', $Operation);
            $query = $this->db->get();
            
            if($query->num_rows() > 0){
                $status = "1";
                $message ='Material list';
                $data = $query->result();
            } else {
                $status = "0";
                $message ='Booking data not found.';
            }
                
            
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }

}