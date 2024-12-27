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
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($MobileNo) || empty($Password)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
            // Check user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'MobileNo' => $MobileNo,
                'Password' => md5($Password),
                'Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
            
            if($user){
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
                'LorryNo' => $LorryNo,
                'Status' => 0
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
        } else if(empty($LorryNo) || empty($Email) || empty($DriverName) || empty($RegNumber) || empty($Tare)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
           $con['returnType'] = 'single';
            $con['conditions'] = array(
                'LorryNo' => $LorryNo,
                'Status' => 0
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
                if(!empty($RegNumber)){
                    $userData['RegNumber'] = $RegNumber;
                }
                if(!empty($Tare)){
                    $userData['Tare'] = $Tare;
                }
                $update = $this->Drivers_API_Model->update($userData, $LorryNo);
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
    
    public function driver_vehileReg_edit_post($LorryNo = 0) {
        
        $token = $this->post('token');
        $LorryNo = $this->post('LorryNo');
        $RegNumber = $this->post('RegNumber');
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
                'LorryNo' => $LorryNo,
                'Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
           if($user){
                if(!empty($RegNumber)){
                    $userData['RegNumber'] = $RegNumber;
                }
                $update = $this->Drivers_API_Model->update($userData, $LorryNo);
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
    
    

}