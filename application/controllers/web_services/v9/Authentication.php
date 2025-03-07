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
    
    public function login_post(){
        $token = $this->post('token');
        $MobileNo = $this->post('MobileNo');
        $UserName = $this->post('UserName');
        
        $Password = $this->post('Password');
        $LogInLat = $this->post('LogInLat');
        $LogInLong = $this->post('LogInLong');
        $LogInLoc = $this->post('LogInLoc');
        $fcm_token = $this->post('fcm_token');
        $lorry_no = $this->post('lorry_no');
		$app_version = $this->post('app_version');
		$api_version = "v9";
        $data = [];
        
        

        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key '.$this->input->post('token');
        } else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(empty($UserName) || empty($Password)){
            $status = "0";
            $message ='Please check required fields';
        }else if(!isset($app_version) || empty($app_version)){
            $status = "0";
            $message ='Please check app version';
        }else {
            // Check user exists with the given credentials
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'UserName' => $UserName,
                'Password' => md5($Password),
                'Status' => 0
            );
            $user = $this->Drivers_API_Model->getRows($con);
            if($user){
                $this->db->select('LorryNo,RegNumber,Tare,Haulier,MacAddress');
                $this->db->where('LorryNo',$lorry_no);
                $this->db->from('tbl_drivers');
                $query = $this->db->get();
                $result = $query->row_array();
                if(!isset($result['LorryNo']) || empty($result['LorryNo'])){
                    $status = "0";
                    $message ='Lorry Not Found.';
                }else{
                    $user['LorryNo'] = $result['LorryNo'];     
                    $user['RegNumber'] = $result['RegNumber'];     
                    $user['Tare'] = $result['Tare'];     
                    $user['Haulier'] = $result['Haulier']; 
                    $user['MacAddress'] = $result['MacAddress']; 
					
					$checkAlreadyloggedIn = $this->db->query("select * from tbl_drivers_logs where DriverLoginID = '".$user['DriverID']."' AND DriverID = '".$lorry_no."' AND LogoutDateTIme = '0000-00-00 00:00:00' order by LogID desc LIMIT 1");
					if($checkAlreadyloggedIn->num_rows()){
                        $LogoutDateTIme = date('Y-m-d H:i:s');
						$update = $this->db->query("update tbl_drivers_logs set LogoutDateTIme = '$LogoutDateTIme' where DriverID = '".$lorry_no."' AND DriverLoginID = '".$user['DriverID']."' AND LogoutDateTIme = '0000-00-00 00:00:00' order by LogID DESC");
					}
                    $checkAlreadyloggedIn = $this->db->query("select * from tbl_drivers_logs where DriverLoginID = '".$user['DriverID']."' AND DriverID = '".$lorry_no."' AND LogoutDateTIme = '0000-00-00 00:00:00' order by LogID desc LIMIT 1");
					
					
					$checkAlreadyloggedInToAnotherLorry = $this->db->query("select * from tbl_drivers_logs where DriverLoginID = '".$user['DriverID']."' AND LogoutDateTIme = '0000-00-00 00:00:00' order by LogID desc LIMIT 1");
					
					if($checkAlreadyloggedIn->num_rows()){
						$status = "0";
						$message ='You are already logged in on another device.';
					}elseif($checkAlreadyloggedInToAnotherLorry->num_rows()){
						$status = "0";
						$message ='You are already logged in on another device.';
					}else{
						$DriverID = $user['LorryNo'];
						$DriverLoginID = $user['DriverID'];
						$IPAddress = $this->input->ip_address();
						
						$this->db->query("insert into tbl_drivers_logs (DriverID,DriverLoginID,IPAddress,VehicleRegNo,LogInLat,LogInLong,LogInLoc,app_version,api_version) values ('$DriverID','$DriverLoginID','$IPAddress','','$LogInLat','$LogInLong','$LogInLoc','$app_version','$api_version')");
						
						$FCMTokenQRY = $this->db->query("select DriverID from tbl_driver_fcm_tokens where DriverID = '$DriverID' OR fcm_tokens = '$fcm_token'");
						
						if($FCMTokenQRY->num_rows()){
							$this->db->query("update tbl_driver_fcm_tokens set DriverID = '$DriverID', fcm_tokens = '$fcm_token' where DriverID = '$DriverID' OR fcm_tokens = '$fcm_token'");
						} else {
							$this->db->query("insert into tbl_driver_fcm_tokens (DriverID,fcm_tokens) values ('$DriverID','$fcm_token')");
						}
						$loginDriverName = $user['DriverName'];
						$loginDriverID = $user['DriverID'];
						
						//$this->db->query("update tbl_drivers set DriverName = '$loginDriverName', LastDriverID = '$loginDriverID' where LorryNo = '$lorry_no'");
						$this->db->query("update tbl_drivers set DriverName = '".$this->db->escape_str($loginDriverName)."', LastDriverID = '$loginDriverID' where LorryNo = '$lorry_no'");
						
						$user['api_version'] = $api_version; 
						$user['app_version'] = $app_version; 
						
						$status = "1";
						$message ='User login successful.';
						$data[] = $user;
					}
                }
            } else {
                $status = "0";
                $message ='User login failed. Please check MobileNo OR Password.';
            }
            
            // Capture the response data
            $response = [
                'status' => $status,
                'message' => $message,
                'data' => $data
            ];
            
            $logData = [
    	        'driver_id' => $user['DriverID'] ?? "",
    	        'lorry_no' => $this->post('lorry_no'),
                'api_call' => __METHOD__, // Get current method name
                'api_request' => json_encode($this->post())
            ];
        
            $this->log_api_data($logData);
            
        }
        
        
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    }
    
    public function driver_profile_post($LorryNo = 0) {
        
        $token = $this->post('token');
        $lorry_no = $this->post('lorry_no');
        $driver_id = $this->post('driver_id');
        
        $logData = [
	        'driver_id' => $this->post('driver_id'),
	        'lorry_no' => $this->post('lorry_no'),
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
        
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        }else if(empty($driver_id)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'DriverID' => $driver_id
            );
            $user = $this->Drivers_API_Model->getRows($con);
            if($user){
                $this->db->select('LorryNo,RegNumber,Tare,Haulier');
                $this->db->where('LorryNo',$lorry_no);
                $this->db->from('tbl_drivers');
                $query = $this->db->get();
                $result = $query->row_array();
                if(!isset($result['LorryNo']) || empty($result['LorryNo'])){
                    $status = "0";
                    $message ='Lorry Not Found.';
                }else{
                    $user['LorryNo'] = $result['LorryNo'];     
                    $user['RegNumber'] = $result['RegNumber'];     
                    $user['Tare'] = $result['Tare'];     
                    $user['Haulier'] = $result['Haulier']; 
                    $status = "1";
                    $message ='Profile Data.';
                    $data[] = $user;
                }
            }else{
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
        $MobileNo = $this->post('MobileNo');
        $Email = $this->post('Email');
        $Password = $this->post('Password');
        $DriverName = $this->post('DriverName');
        //$RegNumber = $this->post('RegNumber');
        //$address = $this->post('address');
        $UserName = $this->post('UserName');
        //$Tare = $this->post('Tare');
        //$Haulier = $this->post('Haulier');
        //$ltsignature = $this->post('ltsignature');
        $lorry_no = $this->post('lorry_no');
        $driver_id = $this->post('driver_id');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        }else if(empty($driver_id) || empty($DriverName)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'DriverID' => $driver_id
            );
            $user = $this->Drivers_API_Model->getRows($con);
           if($user){
                $userData = array();
                if(!empty($DriverName)){
                    $userData['DriverName'] = $DriverName;
                }
                if(!empty($MobileNo)){
                    $userData['MobileNo'] = $MobileNo;
                }
                if(!empty($Email)){
                    $userData['Email'] = $Email;
                }
                if(!empty($Password)){
                    $userData['Password'] = md5($Password);
                }
                /* if(!empty($address)){
                    $userData['address'] = $address;
                } */
                if(!empty($UserName)){
                    $userData['UserName'] = $UserName;
                }

                if(!empty($userData)){
                    $updateString = array();
                    foreach($userData as $key=>$value){
                        $updateString[] = $key." = '".$value."'";
                    }
                    $updateString = implode(", ", $updateString);
                    $DriverLoginID = $user['DriverID'];



                    $this->db->query("update tbl_drivers_login set ".$updateString." where DriverID = '$DriverLoginID'");
                /*    $this->db->query("update tbl_drivers set DriverID = '0' where DriverID = '$DriverLoginID'");
                    $this->db->query("update tbl_drivers set DriverID = '$DriverLoginID' where RegNumber = '$RegNumber'"); */
                    $status = "1";
                    $message ='Profile Data updated';

                    $con['returnType'] = 'single';
                    $con['conditions'] = array(
                        'DriverID' => $driver_id
                    );
                    $user = $this->Drivers_API_Model->getRows($con);
                    $this->db->select('LorryNo,RegNumber,Tare,Haulier');
                    $this->db->where('LorryNo',$lorry_no);
                    $this->db->from('tbl_drivers');
                    $query = $this->db->get();
                    $result = $query->row_array();
                    if(!isset($result['LorryNo']) || empty($result['LorryNo'])){
                        $status = "0";
                        $message ='Lorry Not Found.';
                    }else{
                        $user['LorryNo'] = $result['LorryNo'];     
                        $user['RegNumber'] = $result['RegNumber'];     
                        $user['Tare'] = $result['Tare'];     
                        $user['Haulier'] = $result['Haulier']; 
                        $status = "1";
                        $message ='Profile Data.';
                        $data[] = $user;
                    }
                    //$data[] = $userData;
                }else{
                    $status = "0";
                    $message ='Invalid Data.';
                }
            } else {
                $status = "0";
                $message ='User data not found.';
            }
        }
        
        $logData = [
	        'driver_id' => $this->post('driver_id'),
	        'lorry_no' => $this->post('lorry_no'),
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
        
    
    }
    
    public function logout_post() {
        
        $token = $this->post('token');
        //$LorryNo = $this->post('LorryNo');
        $lorry_no = $this->post('lorry_no');
        $driver_id = $this->post('driver_id');
        $data = [];
        
        $logData = [
	        'driver_id' => $this->post('driver_id'),
	        'lorry_no' => $this->post('lorry_no'),
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
        
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        }else {
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'DriverID' => $driver_id
            );
            $user = $this->Drivers_API_Model->getRows($con);
           if($user){

                $this->db->select('LorryNo,RegNumber,Tare,Haulier');
                $this->db->where('LorryNo',$lorry_no);
                $this->db->from('tbl_drivers');
                $query = $this->db->get();
                $result = $query->row_array();
                if(!isset($result['LorryNo']) || empty($result['LorryNo'])){
                    $status = "0";
                    $message ='Lorry Not Found.';
                }else{
                    $user['LorryNo'] = $result['LorryNo'];     
                    $user['RegNumber'] = $result['RegNumber'];     
                    $user['Tare'] = $result['Tare'];     
                    $user['Haulier'] = $result['Haulier']; 
                    $LoginDatetime = date('Y-m-d');
                    $LogoutDateTIme = date('Y-m-d H:i:s');
                    $update = $this->db->query("update tbl_drivers_logs set LogoutDateTIme = '$LogoutDateTIme' where DriverID = '$lorry_no' AND DriverLoginID = '$driver_id' AND LogoutDateTIme = '0000-00-00 00:00:00' order by LogID DESC");
                    $RegNumber =  $user['RegNumber'];
                    $this->db->query("update tbl_drivers_lorry set Status = '0' where RegNumber = '$RegNumber'");
                    $status = "1";
                    $message ='Logout successful';
                }
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
	public function driver_MacAddress_edit_post() {
        //$LorryNo = $this->post('LorryNo');
        $MacAddress = $this->post('MacAddress');
		$token = $this->post('token');
        //$LorryNo = $this->post('LorryNo');
        $lorry_no = $this->post('lorry_no');
        $driver_id = $this->post('driver_id');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        }else if(!isset($driver_id) || empty($driver_id)){
            $status = "0";
            $message ='Please check required fields';
        }else if(empty($MacAddress)){
            $status = "0";
            $message ='Please check required fields';
        }else {
            
           $con['returnType'] = 'single';
            $con['conditions'] = array(
                'DriverID' => $driver_id
            );
            $user = $this->Drivers_API_Model->getRows($con);
           if($user){
				$userData['MacAddress'] = $MacAddress;
                $DriverLoginID = $user['DriverID'];
                //$update = $this->Drivers_API_Model->update($userData, $LorryNo);
                $update = $this->db->query("update tbl_drivers set MacAddress = '".$MacAddress."', EditUserID = '".$driver_id."' where LorryNo = '".$lorry_no."'");
                
                $status = "1";
                $message ='MacAddress updated';
                $data[] = $userData;
            } else {
                $status = "0";
                $message ='User data not found.';
            }
        }
        
        $logData = [
	        'driver_id' => $this->post('driver_id'),
	        'lorry_no' => $this->post('lorry_no'),
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
        
        $this->response([

            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);           
    }
	public function lorry_version_post() {
        $token = $this->post('token');
        $lorry_no = $this->post('lorry_no');
		$app_version = $this->post('app_version');
		$api_version = $this->post('api_version');
        $data = [];
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(!isset($app_version) || empty($app_version)){
            $status = "0";
            $message ='Invalid App Version';
        } else if(!isset($api_version) || empty($api_version)){
            $status = "0";
            $message ='Invalid API Version';
        }else {
			$this->db->select('LorryNo,RegNumber,Tare,Haulier');
			$this->db->where('LorryNo',$lorry_no);
			$this->db->from('tbl_drivers');
			$query = $this->db->get();
			$result = $query->row_array();
			if(!isset($result['LorryNo']) || empty($result['LorryNo'])){
				$status = "0";
				$message ='Lorry Not Found.';
			}else{
				$userData = array();
				$userData['app_version'] = $app_version;
				$userData['api_version'] = $api_version;
				$userData['lorry_no'] = $lorry_no;
				$update = $this->db->query("update tbl_drivers set app_version = '".$app_version."', api_version = '".$api_version."' where LorryNo = '".$lorry_no."'");
				$status = "1";
				$message ='Versions updated';
				$data[] = $userData;			
			}
        }
        
        $logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no'),
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
}