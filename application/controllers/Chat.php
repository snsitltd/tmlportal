<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
include_once APPPATH.'/third_party/mpdf/mpdf.php';
  
class Chat extends BaseController{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
	
	protected $isApprove;
	protected $isPApprove;
	protected $isIApprove;
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Chat_model');
        $this->load->model('Booking_model');
        $this->load->model('Fcm_model');
		$this->load->model('tickets_model');        
		$this->load->model('Common_model'); 
        $this->isLoggedIn();  
      
         $this->global['active_menu'] = 'dashboard'; 

    }
	public function Drivers(){ 
        $data = array();     
		$this->global['pageTitle'] = WEB_PAGE_TITLE.' : All Chat Message';
		$this->global['active_menu'] = 'chatmessage'; 
		$this->loadViews("Chat/Drivers", $this->global, $data, NULL);
    }
	public function AddChatMessage(){ 
        $data = array();      
		//$data['driverList'] = $this->Booking_model->GetDriverList();
		$data['driverList'] = $this->Chat_model->GetDriverList();   
		
		if(isset($_GET['lorry_no']) && !empty($_GET['lorry_no'])){
       		$data['driverMessagesList'] = $this->Chat_model->GetDriverMessages($_GET['lorry_no']);   
        }
		
		
		//$data['driverList'] = $this->Booking_model->GetMessageLorryList();   
		$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Driver Message';
		$this->global['active_menu'] = 'chatmessage'; 
		
		$this->loadViews("Chat/AddChatMessage", $this->global, $data, NULL);
    }
	function SendDriverChatMessage()
    {


        $IDS = $this->security->xss_clean($this->input->post('IDS')); 
        $LorryNo = $this->security->xss_clean($this->input->post('LorryNo')); 
		$Message = $this->security->xss_clean($this->input->post('Message')); 
		$message_from = $this->security->xss_clean($this->input->post('message_from')); 
		$type = $this->security->xss_clean($this->input->post('type')); 
		$message_status = $this->security->xss_clean($this->input->post('message_status')); 
		$message_id = $this->security->xss_clean($this->input->post('message_id')); 

		if(isset($type) && $type == "update_status" && isset($message_status) && !empty($message_status) && isset($message_id) && !empty($message_id)){
			$randomNumberSleep = rand(1, 25);
			usleep( $randomNumberSleep * 1000 );
			$q =  $this->db->select('*')
				  ->from('tbl_driver_messages_new')
				  ->where('id', $message_id)
				  ->get();
			if($q->num_rows() > 0){
				$resultData = $q->result_array();
				$resultData = $resultData[0];
				if($resultData['status'] == 3){
					echo(json_encode(array('status'=>TRUE,'read_time'=>$resultData['read_time'],'delivered_time'=>$resultData['delivered_time'], 'false_entry'=>true, 'condition'=>1)));  exit;
				}elseif(!empty($resultData['read_time'])){
					$this->db->update('tbl_driver_messages_new', array("status"=>3));
					echo(json_encode(array('status'=>TRUE,'read_time'=>$resultData['read_time'],'delivered_time'=>$resultData['delivered_time'], 'false_entry'=>true, 'condition'=>2)));  exit;
				}elseif($resultData['status'] == 2 && $message_status == $resultData['status']){
					echo(json_encode(array('status'=>TRUE,'read_time'=>$resultData['read_time'],'delivered_time'=>$resultData['delivered_time'], 'false_entry'=>true, 'condition'=>3)));  exit;
				}
			}
		
		
		
		
		
		
		
			$this->db->where('id', $message_id);
			$currentTime = date("Y-m-d H:i:s");
			if($message_status == 2){
				$this->db->update('tbl_driver_messages_new', array("status"=>$message_status, "delivered_time"=>$currentTime));
			}elseif($message_status == 3){
				$this->db->update('tbl_driver_messages_new', array("status"=>$message_status, "read_time"=>$currentTime));
			}else{
				$this->db->update('tbl_driver_messages_new', array("status"=>$message_status));
			}
			
			
			$this->db->where('id', $message_id);
			$this->db->select('*'); 	   
			$this->db->from('tbl_driver_messages_new'); 
			//$this->db->where('id = "'.$message_id.'" ');  
			$query = $this->db->get();
			$resultData = $query->result_array();
			$resultData = $resultData[0];
			
			if(empty($resultData['read_time'])){
				$resultData['read_time'] = '';
			}
			if(empty($resultData['delivered_time'])){
				$resultData['delivered_time'] = '';
			}
			
			echo(json_encode(array('status'=>TRUE,'read_time'=>$resultData['read_time'],'delivered_time'=>$resultData['delivered_time'], 'false_entry'=>false)));  exit;
		}
		



		if(isset($message_from) && !empty($message_from)){
			$message_from = "driver";
		}else{
			$message_from = "admin";
		}
		$Id = explode(',',$IDS);
		$Lorry = explode(',',$LorryNo);	
		$sendNotification = true;
		
		if($message_from == "driver"){
		    $randomNumberSleep = rand(1, 25);
		    usleep( $randomNumberSleep * 1000 );
		}
		
		
		$allResultData = array();
		
		for($i=0;$i<count($Id);$i++){


			$file_name = '';
			$label = $this->security->xss_clean($this->input->post('label')); 
			if(isset($label) && !empty($label) && $label == "WEBUPLOAD"){
				if(isset($_FILES['file_upload']) && !empty($_FILES['file_upload'])){
					$file_name = $this->security->xss_clean($this->input->post('file_name')); 
					$file_name = explode(".",$file_name);
					$file_name = strtotime(date("Y-m-d H:i:s.u")).'.'.$file_name[1];
					/* $file_path = './assets/chat/'.$file_name;
					file_put_contents($file_name,$file_path);  */
				}elseif(isset($_POST['file_name']) && !empty($_POST['file_name'])){
					$file_name = $this->security->xss_clean($this->input->post('file_name')); 
				}
			}
			
			if(empty($Id[$i]) || empty($Lorry[$i])){
				continue;
			}
			$q =  $this->db->select('*')
				  ->from('tbl_driver_messages_new')
				  //->where(array('driver_id' => $Id[$i], 'message_from' => $message_from, 'message' => $Message, 'file_name'=> $file_name , 'lorry_no'=> $Lorry[$i], 'admin_user'=> $_SESSION['name']))
				  ->where(array('driver_id' => $Id[$i], 'message_from' => $message_from, 'message' => $Message, 'file_name'=> $file_name , 'lorry_no'=> $Lorry[$i]))
				  ->order_by('id','desc')
				  ->limit(1)
				  ->get();
			if($q->num_rows() == 0){
				$MessageInfo = array('driver_id'=> $Id[$i], 'message_from'=>$message_from , 'message'=> $Message, 'file_name'=> $file_name , 'lorry_no'=> $Lorry[$i], 'admin_user'=> $_SESSION['name'] ); 
				//$messageId = $this->Common_model->insert("tbl_driver_messages_new",$MessageInfo); 
				$this->db->insert("tbl_driver_messages_new",$MessageInfo);
				$messageId = $this->db->insert_id();
	
				
				/*$MessageStatusInfo = array('message_id'=> $messageId, 'driver_id'=>$Id[$i] ); 
				//$result1 = $this->Common_model->insert("tbl_driver_messages_status",$MessageStatusInfo);  
				$this->db->insert("tbl_driver_messages_status",$MessageStatusInfo);
				$result1 = $this->db->insert_id();*/
	
	
				$this->db->select('*'); 	   
				$this->db->from('tbl_driver_messages_new'); 
				$this->db->where('tbl_driver_messages_new.id = "'.$messageId.'" ');  
				$query = $this->db->get();
				$resultData = $query->result_array();
	
				$this->db->select('*'); 	   
				$this->db->from('tbl_drivers_login'); 
				$this->db->where('tbl_drivers_login.DriverID = "'.$Id[$i].'" ');  
				$query = $this->db->get();
				$driverData = $query->result_array();
				$resultData[0]['driver_name'] = $driverData[0]['DriverName'];
				$resultData[0]['existing_entry'] = false;
			}else{
				//$this->db->select('*'); 	   
				//$this->db->from('tbl_driver_messages_new'); 
				//$this->db->where(array('driver_id' => $Id[$i], 'message_from' => $message_from, 'message' => $Message, 'file_name'=> $file_name , 'lorry_no'=> $Lorry[$i], 'admin_user'=> $_SESSION['name']));
				//$query = $this->db->get();
				$query =  $this->db->select('*')
    				  ->from('tbl_driver_messages_new')
    				  ->where(array('driver_id' => $Id[$i], 'message_from' => $message_from, 'message' => $Message, 'file_name'=> $file_name , 'lorry_no'=> $Lorry[$i]))
    				  ->order_by('id','desc')
    				  ->limit(1)
    				  ->get();
				$resultData = $query->result_array();
	
				$this->db->select('*'); 	   
				$this->db->from('tbl_drivers_login'); 
				$this->db->where('tbl_drivers_login.DriverID = "'.$Id[$i].'" ');  
				$query = $this->db->get();
				$driverData = $query->result_array();
				$resultData[0]['driver_name'] = $driverData[0]['DriverName'];
				$sendNotification = false;
			}
			$resultData[0]['existing_entry'] = true;
			$allResultData[$i] = $resultData[0];
			

		}  
		if($sendNotification){
			if(isset($LorryNo) && !empty($LorryNo)){
				$IDS = $LorryNo;
			}
			$this->Fcm_model->sendNotication($IDS,$Message,'message');
		}
		
		echo(json_encode(array('status'=>TRUE,'result'=>$result1,'all_result'=>$allResultData,'resultData'=>$resultData[0]))); 
    }
	
	public function ChatAjaxMessage(){  
		$this->load->library('ajax');
		$data = $this->Chat_model->GetAllActiveDriverMessage();   
		$this->ajax->send($data);
	}
	public function ViewChat(){ 
        $data = array();      
        if(!isset($_GET['lorry_no']) || empty($_GET['lorry_no'])){
            redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
		
		$data['driverList'] = $this->Chat_model->GetDriverList();   
		$data['driverMessagesList'] = $this->Chat_model->GetDriverMessages($_GET['lorry_no']);   
		//$data['driverList'] = $this->Booking_model->GetMessageLorryList();   
		$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Driver Messages';
		$this->global['active_menu'] = 'chatmessage'; 
		$this->loadViews("Chat/ViewChat", $this->global, $data, NULL);
    }
    public function GetAjaxDriverChatMessage(){ 
        $this->load->library('ajax');
        $data = array();      
        if(!isset($_GET['lastMessageId']) || empty($_GET['lastMessageId']) || !isset($_GET['lorry_no']) || empty($_GET['lorry_no'])){
            $data['status'] = false;
            $this->ajax->send($data);
        }
        $data['status'] = true;
		$data['driverMessagesList'] = $this->Chat_model->GetDriverMessages($_GET['lorry_no'],$_GET['lastMessageId']);   
		$this->ajax->send($data);
    }
}

?>
