<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Message extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the model
        //$this->load->model('ApiModels/Booking_API_Model');
        $this->load->model('Common_model'); 
        $this->load->model('ApiModels/Drivers_API_Model');
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
	
	public function messageList_post(){
        
        $token = $this->post('token');
        $DriverID = $this->post('DriverID');
        $driver_id = $this->post('driver_id');
        $lorry_no = $this->post('lorry_no');
        $data = [];
        
        // Check user exists with the given credentials
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
        } else if(empty($driver_id)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
            // recipition name
            $this->db->select('TableID,DriverID,Message,Status,DATE_FORMAT(CreateDateTime, "%d-%m-%Y %h:%i") as CreateDateTime,DATE_FORMAT(UpdateDateTime, "%d-%m-%Y %h:%i") as UpdateDateTime');
            $this->db->from('tbl_driver_message');
            $this->db->where('DriverID', $driver_id);
            $this->db->order_by('TableID', 'DESC');
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $dataarr = $query->result();
                //echo $user['Email'];
                //Email sending..
                    $status = "1";
                    $message ='Message List';
                    $data = $dataarr;
                $udateData = array("Status" => 1);
                $this->db->where('DriverID',$driver_id);
                $this->db->update("tbl_driver_message", $udateData);
    
            } else {
                $status = "0";
                $message ='not foundMessage';
            }
                
            
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
    
    public function chatMessageList_post(){
        
        $token = $this->post('token');
        $DriverID = $this->post('DriverID');
        $driver_id = $this->post('driver_id');
        $lorry_no = $this->post('lorry_no');
		$last_id = $this->post('last_id');
        $data = [];
        
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);
        
        $logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
            
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
        }else {
            // recipition name
			$this->db->select('tbl_drivers_login.DriverName');  	 		 
			$this->db->select('tbl_driver_messages_new.status');  	
			$this->db->select('tbl_driver_messages_new.id');
			$this->db->select('tbl_driver_messages_new.message');
			$this->db->select('tbl_driver_messages_new.driver_id');
			$this->db->select('tbl_driver_messages_new.message_from');
			$this->db->select('tbl_driver_messages_new.admin_user');
            $this->db->select('tbl_driver_messages_new.file_name');
			$this->db->select('DATE_FORMAT(tbl_driver_messages_new.delivered_time,"%d-%m-%Y %T") as delivered_time');  	 	 
			$this->db->select('DATE_FORMAT(tbl_driver_messages_new.read_time,"%d-%m-%Y %T") as read_time');  	 	 
			$this->db->select('DATE_FORMAT(tbl_driver_messages_new.created_at,"%d-%m-%Y %T") as CreateDateTime');  	 	 
			$this->db->select('DATE_FORMAT(tbl_driver_messages_new.updated_at,"%d-%m-%Y  %T") as UpdateDateTime');  	 	   		$this->db->from('tbl_driver_messages_new');
			$this->db->join('tbl_drivers_login', 'tbl_drivers_login.DriverID = tbl_driver_messages_new.driver_id',"LEFT"); 	
			//$this->db->where('tbl_driver_messages_new.message <> "" ');  
			$this->db->where('tbl_driver_messages_new.lorry_no = "'.$lorry_no.'" ');  
			if(isset($last_id) && !empty($last_id)){
				$this->db->where('tbl_driver_messages_new.id > '.$last_id);  
			}
			$this->db->order_by('tbl_driver_messages_new.id', 'asc');	
			$this->db->group_by('tbl_driver_messages_new.id');
			//$query = $this->db->get('tbl_driver_messages_new');
			
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $dataarr = $query->result();
                //echo $user['Email'];
                //Email sending..
                    $status = "1";
                    $message ='Message List';
                    $data = $dataarr;
            } else {
                $status = "1";
                $message ='not foundMessage';
            }
                
            
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }

    public function addChatMessage_post(){
        
        $token = $this->post('token');
        $DriverID = $this->post('DriverID');
        $driver_id = $this->post('driver_id');
        $lorry_no = $this->post('lorry_no');
		$message = $this->post('message');
        $data = [];
        
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);
        
        $logData = [
	        'driver_id' => $this->post('driver_id') ?? "",
	        'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];
        
        $this->log_api_data($logData);
            
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        }else if(!isset($lorry_no) || empty($lorry_no)){
            $status = "0";
            $message ='Invalid Request';
        } else if(empty($driver_id)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($message)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
            
            $MessageInfo = array('driver_id'=> $driver_id, 'message_from'=>'driver' , 'message'=> $message , 'lorry_no'=> $lorry_no ); 
			$messageId = $this->Common_model->insert("tbl_driver_messages_new",$MessageInfo);  
			
			$MessageStatusInfo = array('message_id'=> $messageId, 'driver_id'=>$driver_id ); 
			$result1 = $this->Common_model->insert("tbl_driver_messages_status",$MessageStatusInfo);  

            $status = "1";
            $message ='Message Added Successfully.';
            $data = array();
            
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
}