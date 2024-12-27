<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Message extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the model
        //$this->load->model('ApiModels/Booking_API_Model');
        $this->load->model('ApiModels/Drivers_API_Model');
        $this->load->database();
    }
    
    public function messageList_post(){
        
        $token = $this->post('token');
        $DriverID = $this->post('DriverID');
        $data = [];
        
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'tbl_drivers.LorryNo' => $DriverID,
 'tbl_drivers_login.Status' => 0
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
            // recipition name
            $this->db->select('TableID,DriverID,Message,Status,DATE_FORMAT(CreateDateTime, "%d-%m-%Y %h:%i") as CreateDateTime,DATE_FORMAT(UpdateDateTime, "%d-%m-%Y %h:%i") as UpdateDateTime');
            $this->db->from('tbl_driver_message');
            $this->db->where('DriverID', $DriverID);
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
                $this->db->where('DriverID',$DriverID);
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

}