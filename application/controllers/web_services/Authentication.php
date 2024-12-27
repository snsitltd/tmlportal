<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Authentication extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        
        // Load the Driver model
        $this->load->model('ApiModels/Drivers_API_Model');
    }
    
    public function login_post(){
        $token = $this->post('token');
        $MobileNo = $this->post('MobileNo');
        $Password = $this->post('Password');
        $LogInLat = $this->post('LogInLat');
        $LogInLong = $this->post('LogInLong');
        $LogInLoc = $this->post('LogInLoc');
        $fcm_token = $this->post('fcm_token');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key T'.$this->input->post('token');
        } else if(empty($MobileNo) || empty($Password)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
            // Check user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'tbl_drivers_login.MobileNo' => $MobileNo,
                'tbl_drivers_login.Password' => md5($Password),
                'tbl_drivers_login.Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
            
            if($user){
                $DriverID = $user['LorryNo'];
                $DriverLoginID = $user['DriverID'];
                $IPAddress = $this->input->ip_address();
                $this->db->query("insert into tbl_drivers_logs (DriverID,DriverLoginID,IPAddress,VehicleRegNo,LogInLat,LogInLong,LogInLoc) values ('$DriverID','$DriverLoginID','$IPAddress','','$LogInLat','$LogInLong','$LogInLoc')");
                
                $FCMTokenQRY = $this->db->query("select DriverID from tbl_driver_fcm_tokens where DriverID = '$DriverID' OR fcm_tokens = '$fcm_token'");
                
                if($FCMTokenQRY->num_rows()){
                    $this->db->query("update tbl_driver_fcm_tokens set DriverID = '$DriverID', fcm_tokens = '$fcm_token' where DriverID = '$DriverID' OR fcm_tokens = '$fcm_token'");
                } else {
                    $this->db->query("insert into tbl_driver_fcm_tokens (DriverID,fcm_tokens) values ('$DriverID','$fcm_token')");

                }
                
                $status = "1";
                $message ='User login successful.';
                $data[] = $user;
            } else {
                $status = "0";
                $message ='User login failed. Please check MobileNo OR Password.';
            }
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    }
    
    public function registration_post($token){
        $token = $this->post('token');
        $MobileNo = $this->post('MobileNo');
        $Email = $this->post('Email');
        $Password = $this->post('Password');
        $DriverName = $this->post('DriverName');
        $RegNumber = $this->post('RegNumber');
        $Tare = $this->post('Tare');
        $Haulier = $this->post('Haulier');
        $ltsignature = $this->post('ltsignature');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($MobileNo) || empty($Email) || empty($Password) || empty($DriverName)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
            // Check if the given Mobile already exists
            $con['returnType'] = 'count';
            $con['conditions'] = array(
                'MobileNo' => $MobileNo,
            );
            $userCount = $this->Drivers_API_Model->getRows($con);
            
            if($userCount > 0){
                $status = "0";
                $message ='The given MobileNo already exists.';
            } else {
                
                $userData = array(
                    'LorryNoMapKey' => 0,
                    'MobileNo' => $MobileNo,
                    'Email' => $Email,
                    'Password' => md5($Password),
                    'DriverName' => $DriverName,
                    'RegNumber' => $RegNumber,
                    'Tare' => $Tare,
                    'Haulier' => $Haulier,
                    'ltsignature' => $ltsignature,
                );
                $insert = $this->Drivers_API_Model->insert($userData);
                if($insert){
                    $status = "1";
                    $message ='The user has been registed successfully.';
                } else {  
                    $status = "0";
                    $message ='Something went wrong.';
                }
            }
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    }
    
    public function driver_profile_post($LorryNo = 0) {
        
        $token = $this->post('token');
        $LorryNo = $this->post('LorryNo');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($LorryNo)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
           $con['returnType'] = 'single';
            $con['conditions'] = array(
                'tbl_drivers.LorryNo' => $LorryNo,
                'tbl_drivers_login.Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
            $user['address'] = 'London, United Kingdom';
            if($user){
                $status = "1";
                $message ='Profile Data.';
                $data[] = $user;
            } else {
                $status = "0";
                $message ='User data not found.';
            }
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    
    }
    
    public function driver_edit_post($LorryNo = 0) {
        
        $token = $this->post('token');
        $LorryNo = $this->post('LorryNo');
        //$MobileNo = $this->post('MobileNo');
        $Email = $this->post('Email');
        //$Password = $this->post('Password');
        $DriverName = $this->post('DriverName');
        $RegNumber = $this->post('RegNumber');
        $address = $this->post('address');
        $Tare = $this->post('Tare');
        //$Haulier = $this->post('Haulier');
        //$ltsignature = $this->post('ltsignature');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($LorryNo) || /* empty($Email) || */empty($DriverName) || empty($RegNumber)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
           $con['returnType'] = 'single';
            $con['conditions'] = array(
                'tbl_drivers.LorryNo' => $LorryNo,
                'tbl_drivers_login.Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
           if($user){
               
                $userData = array();
                if(!empty($Email)){
                    $userData['Email'] = $Email;
                }
                if(!empty($DriverName)){
                    $userData['DriverName'] = $DriverName;
                }
                /*if(!empty($RegNumber)){
                    $userData['RegNumber'] = $RegNumber;
                }
                if(!empty($Tare)){
                    $userData['Tare'] = $Tare;
                }*/
                $DriverLoginID = $user['DriverID'];
                $this->db->query("update tbl_drivers_login set DriverName = '$DriverName', Email = '$Email' where DriverID = '$DriverLoginID'");
                 $this->db->query("update tbl_drivers set DriverID = '0' where DriverID = '$DriverLoginID'");
                $this->db->query("update tbl_drivers set DriverID = '$DriverLoginID' where RegNumber = '$RegNumber'");
                
                $status = "1";
                $message ='Profile Data updated';
                $data[] = $userData;
            } else {
                $status = "0";
                $message ='User data not found.';
            }
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    
    }
    
    public function driver_vehileReg_post($LorryNo = 0) {
        
        $token = $this->post('token');
        $LorryNo = $this->post('LorryNo');
        $RegNumber = $this->post('RegNumber');
        $Tare = $this->post('Tare');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($LorryNo) || empty($RegNumber)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
           $con['returnType'] = 'single';
            $con['conditions'] = array(
                'tbl_drivers.LorryNo' => $LorryNo,
                'tbl_drivers_login.Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
           if($user){
                if(!empty($RegNumber)){
                    
                    $drivers_lorryQRY = $this->db->query("select Tare from tbl_drivers_lorry where RegNumber = '$RegNumber'");
                    $drivers_lorrys = $drivers_lorryQRY->result();
                    $regtare = $drivers_lorrys[0]->Tare;
                    
                    $userData['RegNumber'] = $RegNumber;
                    $userData['Tare'] = $regtare;
                    $drivers_lorryQRY = $this->db->query("update tbl_drivers_lorry set Status = '1' where RegNumber='$RegNumber'");
                     $drivers_lorryQRY = $this->db->query("update tbl_drivers set RegNumber = '$RegNumber', Tare='$regtare' where LorryNo='$LorryNo'");
                    
                }
                $update = $this->Drivers_API_Model->update($userData, $LorryNo);
                $logup = $this->db->query("update tbl_drivers_logs set VehicleRegNo = '$RegNumber' where DriverID='$LorryNo' order by LogID DESC limit 1");
                $status = "1";
                $message ='Profile Data updated';
                $data[] = $userData;
            } else {
                $status = "0";
                $message ='User data not found.';
            }
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    
    }
    
    public function driver_MacAddress_edit_post($LorryNo = 0) {
        
        $token = $this->post('token');
        $LorryNo = $this->post('LorryNo');
        $MacAddress = $this->post('MacAddress');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($LorryNo) || empty($MacAddress)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
           $con['returnType'] = 'single';
            $con['conditions'] = array(
                'tbl_drivers.LorryNo' => $LorryNo,
                'tbl_drivers_login.Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
           if($user){
                if(!empty($MacAddress)){
                    $userData['MacAddress'] = $MacAddress;
                }
                $DriverLoginID = $user['DriverID'];
                //$update = $this->Drivers_API_Model->update($userData, $LorryNo);
                $update = $this->db->query("update tbl_drivers_login set MacAddress = '$MacAddress' where DriverID = '$DriverLoginID'");
                
                $status = "1";
                $message ='MacAddress updated';
                $data[] = $userData;
            } else {
                $status = "0";
                $message ='User data not found.';
            }
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    
    }
    
    public function logout_post() {
        
        $token = $this->post('token');
        $LorryNo = $this->post('LorryNo');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($LorryNo)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
           $con['returnType'] = 'single';
            $con['conditions'] = array(
                'tbl_drivers.LorryNo' => $LorryNo,
                'tbl_drivers_login.Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
           if($user){
                $LoginDatetime = date('Y-m-d');
                $LogoutDateTIme = date('Y-m-d H:i:s');
                $update = $this->db->query("update tbl_drivers_logs set LogoutDateTIme = '$LogoutDateTIme' where DriverID = '$LorryNo' AND LoginDatetime like '$LoginDatetime%' order by LogID DESC limit 1");
                
                $RegNumber =  $user['RegNumber'];
                $this->db->query("update tbl_drivers_lorry set Status = '0' where RegNumber = '$RegNumber'");
                $status = "1";
                $message ='Logout successful';
            } else {
                $status = "0";
                $message ='User data not found.';
            }
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    
    }
}