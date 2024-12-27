<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
class Ticket extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the model
        $this->load->model('ApiModels/Booking1_API_Model');
        $this->load->model('ApiModels/Drivers_API_Model');
        $this->load->database();
    }
    
    public function emailGenerate_post(){
        
        $token = $this->post('token');
        $DriverID = $this->post('DriverID');
        $LoadID = $this->post('LoadID');
        $data = [];
        
        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'tbl_drivers.LorryNo' => $DriverID,'tbl_drivers_login.Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);
            
            
        if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        } else if(empty($DriverID) || empty($LoadID)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
            /* $this->db->select('tbl_booking.*, tbl_booking_loads.TicketUniqueID, tbl_booking_loads.ConveyanceNo,tbl_booking_loads.ReceiptName, tbl_booking_loads.Status as Load_status');
            $this->db->from('tbl_booking_loads');
            $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
            $this->db->where('tbl_booking_loads.LoadID', $LoadID);
            $this->db->where('tbl_booking_loads.DriverID', $DriverID); */
            $this->db->select('	tbl_booking1.*, tbl_booking_loads1.TicketUniqueID, tbl_booking_loads1.ConveyanceNo,tbl_booking_loads1.ReceiptName, tbl_booking_loads1.Status as Load_status, tbl_booking_request.ContactEmail as Email,tbl_booking_request.ContactName');
            $this->db->from('tbl_booking_loads1');
            $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
            $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
            $this->db->where('tbl_booking_loads1.LoadID', $LoadID);
            $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
            $query = $this->db->get();
            if($query->num_rows() > 0){
                $dataarr = $query->result();
                //echo $user['Email'];
                //Email sending..
                if($dataarr[0]->Email) {
                        
                        $config['protocol'] = 'sendmail';
                        //$config['mailpath'] = '/usr/sbin/sendmail';
                        $config['charset'] = 'iso-8859-1';
                        $config['wordwrap'] = TRUE;
                        $config['mailtype'] = 'html'; 
                        $this->email->initialize($config); 
                        $to_email = $dataarr[0]->Email;
                        $mailHTML = '<p>Dear '.$dataarr[0]->ContactName.', <br><br>						Conveyance Note has been Generated, Details as Below. <br><br>						Conveyance Note No.: '.$dataarr[0]->ConveyanceNo.'<br> 						Conveyance Note (PDF) : <a href="'.base_url().'/assets/conveyance/'.$dataarr[0]->TicketUniqueID.'.pdf">Download PDF</a></p>'; 
                        $this->load->library('email'); 
                        $this->email->from('developer@snsitltd.com', 'Thames Materials Ltd');
                        $this->email->to($to_email);
                        //$this->email->bcc('jayesh.breezewaytech@gmail.com');						$this->email->bcc('nilay.panchal@gmail.com');  
                        $this->email->subject('TML Email Receipt');
                        $this->email->message($mailHTML);						$this->email->attach(base_url().'/assets/conveyance/'.$dataarr[0]->ReceiptName); 
                        $this->email->send(); 
                        $status = "1"; 
                        $message ='Email sent successful'; 
                } else {
                    $status = "0";
                    $message ='Email ID not found';
                }
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
    
    public function printGenerate_post(){
        
        $token = $this->post('token');
        $DriverID = $this->post('DriverID');
        $LoadID = $this->post('LoadID');
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
        } else if(empty($DriverID) || empty($LoadID)){
            $status = "0";
            $message ='Please check required fields';
        } else if(empty($user)){
            $status = "0";
            $message ='User id not found or account disabled';
        }else {
            // recipition name
            /* $this->db->select('tbl_booking.*,tbl_booking_loads.TicketUniqueID,tbl_booking_loads.ReceiptName, tbl_booking_loads.Status as Load_status');
            $this->db->from('tbl_booking_loads');
            $this->db->join('tbl_booking', 'tbl_booking_loads.BookingID = tbl_booking.BookingID');
            $this->db->where('tbl_booking_loads.LoadID', $LoadID);
            $this->db->where('tbl_booking_loads.DriverID', $DriverID); */



            $this->db->select('tbl_booking1.*,tbl_booking_loads1.TicketUniqueID,tbl_booking_loads1.ReceiptName, tbl_booking_loads1.Status as Load_status');
            $this->db->from('tbl_booking_loads1');
            $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
            $this->db->where('tbl_booking_loads1.LoadID', $LoadID);
            $this->db->where('tbl_booking_loads1.DriverID', $DriverID);




            $query = $this->db->get();
            
            if($query->num_rows() > 0){
                $dataarr = $query->result();
                
                $grosLID = $LoadID;
                    $GrossWeightQRY = $this->db->query("select TicketNumber,TicketUniqueID,GrossWeight,Tare,Net,is_hold from tbl_tickets where LoadID = '$grosLID'");
                    $GrossWeightName= $GrossWeightQRY->row_array();
                    if($GrossWeightQRY->num_rows() > 0){
                       
                        if($GrossWeightName['is_hold']==0) { 
                            
                            
                            if($dataarr[0]->ReceiptName == ''){
                                $TicketPDF = base_url().'assets/pdf_file/'.$GrossWeightName['TicketUniqueID'].'.pdf';
                            } else {
                                $TicketPDF = base_url().'assets/conveyance/'.$dataarr[0]->ReceiptName;
                            }
                            
                            //$TicketPDF = base_url().'/assets/pdf_file/'.$GrossWeightName['TicketUniqueID'].'.pdf';
                           // $TicketPDF = base_url().'assets/conveyance/'.$dataar->ReceiptName;
                        } else { 
                            $TicketPDF = '';
                        }
                        
                    } else { 
                        //Complated GET PDF
                        if($dataarr[0]->ReceiptName == ''){
                            $TicketPDFGET = '';
                        }else{
                            $TicketPDFGET = base_url().'assets/conveyance/'.$dataarr[0]->ReceiptName;;
                        }
                      
                        $TicketPDF = $TicketPDFGET;
                    }
                    
                    
                    $status = "1";
                    $message ='Print generate';
                    $data[] = array(
                        "PDF"=>$TicketPDF,
                        );
    
            } else {
                $status = "0";
                $message ='Print not generate.';
            }
                
            
        }
        
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
}