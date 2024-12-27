<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Livetracking extends REST_Controller
{
    public function __construct() { 
        parent::__construct();
        // Load the model
        //$this->load->model('ApiModels/Tipticket_API_Model');
		$this->load->model('ApiModels/Drivers_API_Model');
		$this->load->model('Common_model');
        $this->load->database();
    }
	public function create_post(){
        
        $token = $this->post('token');
		$driver_id = $this->post('driver_id');
		$lorry_no = $this->post('lorry_no');
		$load_id = $this->post('load_id');
		$latitude = $this->post('latitude');
		$longitude = $this->post('longitude');
		$eta = $this->post('eta');
		$current_speed = $this->post('current_speed');
        $status = $this->post('status');
		if(isset($status)){
		}else{
			$status = 0;
		}
        $data = [];
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'tbl_drivers.DriverID' => $driver_id,
			'tbl_drivers.LorryNo' => $lorry_no
        );
        $user = $this->Drivers_API_Model->getRows($con);
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($driver_id)){
            $status = "0";
            $message ='Please add driver';
        }else if(empty($lorry_no)){
            $status = "0";
            $message ='Please add lorry number';
        }else if(empty($load_id)){
            $status = "0";
            $message ='Please add load ID';
        }else if(empty($latitude)){
            $status = "0";
            $message ='Please add latitude';
        }else if(empty($longitude)){
            $status = "0";
            $message ='Please add longitude';
        }else if(empty($eta)){
            $status = "0";
            $message ='Please add ETA';
        }else if(empty($current_speed)){
            $status = "0";
            $message ='Please add Speed';
        }else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
            $trackingInfo = array(
				'driver_id'=>$driver_id, 
				'lorry_no'=>$lorry_no, 
				'load_id'=>$load_id, 
				'latitude'=>$latitude,
				'longitude'=>$longitude,
				'eta'=>$eta,
				'current_speed'=>$current_speed, 
				'status'=>$status, 
			); 
			$trackingInfoId = $this->Common_model->insert('tbl_live_tracking', $trackingInfo);
            if(isset($trackingInfoId) && !empty($trackingInfoId)){
				$status = "1";
                $message ='Data Added Successfully.';
            } else {
                $status = "0";
                $message ='Something went wrong while adding Live tracking data.';
				$data = array();
            }
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
}	