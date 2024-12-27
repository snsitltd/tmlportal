<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Livetracking extends BaseController
{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
    
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {

        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Booking_model');
        $this->load->model('Fcm_model');
		$this->load->model('tickets_model');  
        $this->load->model('Drivers_model');
        $this->load->model('Livetracking_model');
          
       
        $this->isLoggedIn();  
        $roleCheck = $this->Common_model->checkpermission('user');

         $this->global['isView'] = $this->isView = $roleCheck->view;   
         $this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
         $this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
         $this->global['isDelete'] = $this->isDelete = $roleCheck->delete;
         $this->global['active_menu'] = 'dashboard_new';          

    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Dashboard';
        $this->global['active_menu'] = 'dashboard_new';
		$data = array();   
        //$data['contact_count'] = $this->Common_model->CountContacts() ; 
		//$data['company_count'] = $this->Common_model->CountCompany() ; 
        //$data['ticket_count'] = $this->Common_model->CountTicket(); 
        //$data['ticket_limit_company'] = $this->Common_model->getTicketLimitCompanyList();   
		//$data['new_company'] = $this->Common_model->getRecentlyAddedSites() ; 
		//$data['new_company1'] = $this->Common_model->getRecentlyAddedCompany() ; 
        //$data['user_count'] = $this->user_model->userListingCount() ;  

        $data['driverList'] = $this->Booking_model->GetDriverList(); 
        //$data['driverList'] = array();
        //$this->db->select('tbl_drivers_login.*');
        //$this->db->from('tbl_drivers_login');
        //$this->db->order_by('tbl_drivers_login.DriverID', 'DESC');
       // $query = $this->db->get();
        //$driverList = $query->result_array();
        //////$data['driverList'] = $driverList;
        //$data['driverList'] = $this->Drivers_model->GetDriverLoginData();  

        if (isset($_GET['booking_id']) && !empty($_GET['booking_id']) && isset($_GET['driver_id']) && !empty($_GET['driver_id']) && isset($_GET['load_id']) && !empty($_GET['load_id']) && isset($_GET['vehicle_reg_no']) && !empty($_GET['vehicle_reg_no']) && isset($_GET['opportunity_id']) && !empty($_GET['opportunity_id'])) {
            //Booking Data for Allocations
            $data['running_loads'] = $this->Livetracking_model->GetLoadsData($_GET['driver_id'],"due");
            $data['completed_loads'] = $this->Livetracking_model->GetLoadsData($_GET['driver_id'],"completed");
            $data['tomorrow_loads'] = $this->Livetracking_model->GetLoadsData($_GET['driver_id'],"tomorrow");
            //$data['completed_loads'] = array();

            $this->db->select('tbl_live_tracking.*');
            $this->db->from('tbl_live_tracking');
            $this->db->where("tbl_live_tracking.created_at >= ' ".date("Y-m-d 00:00:00")."' "); 
            $this->db->where("tbl_live_tracking.created_at <= ' ".date("Y-m-d 23:59:59")."' "); 
            $this->db->where('tbl_live_tracking.driver_id = '.$_GET['driver_id']);
            $this->db->where('tbl_live_tracking.load_id = '.$_GET['load_id']);
            $this->db->order_by('tbl_live_tracking.id', 'DESC');
            $query = $this->db->get();
            $live_tracking_data = $query->result_array();
            $data['live_tracking_data'] = $live_tracking_data;

            if (isset($_GET['is_ajax']) && $_GET['is_ajax'] == 1){ 
                if(empty($data['live_tracking_data'])){
                    echo "no_results"; exit;
                }
                echo json_encode(array("latitude"=>$data['live_tracking_data'][0]['latitude'],"longitude"=>$data['live_tracking_data'][0]['longitude'])); exit;
            }
        }
         
        /*  
        //$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX1();  	 
        $data['LorryRecords1'] = $this->Booking_model->LorryListAJAX();  	 
        $data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();  	  
        $data['LorryRecords'] = $this->Booking_model->LorryListAJAX();  	
        $data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList();  
            
        $data['TipRecords'] = $this->Booking_model->TipListAJAX();  */

        $data['loads'] = $this->Livetracking_model->GetLoadsData();   
        
        if (isset($_GET['is_ajax']) && $_GET['is_ajax'] == 1){ 
            $locations = array();
            if(isset($data['loads']['data']) && !empty($data['loads']['data'])){
                $k = 0;
                foreach($data['loads']['data'] as $row){
                    $singleTracking = array();
                    
                    if(isset($row['live_tracking_data']) && !empty($row['live_tracking_data'])){
                        $lat = $row['live_tracking_data'][0]['latitude'];
                        $long = $row['live_tracking_data'][0]['longitude'];
                    }else{
                        continue;
                    }
                    if (isset($row['VehicleRegNo']) && $row['VehicleRegNo'] != 0) {
                        $vehicleRegNo = $row['VehicleRegNo'];
                        $map_vehicleRegNo = '<b>VehicleRegNo: </b>'.$row['VehicleRegNo'].'<br>';
                    } else {
                        $vehicleRegNo = $row['rname'];
                        $map_vehicleRegNo = '<b>VehicleRegNo: </b>'.$row['rname'].'<br>';
                    }
                    if (isset($row['DriverName']) && !empty($row['DriverName'])) {
                        $map_driverName = '<b>Driver: </b>'.$row['DriverName'].'<br><div style="height:5px; width:100%;"></div>';
                    } else {
                        $map_driverName = '<b>Driver: </b>'.$row['dname'].'<br><div style="height:5px; width:100%;"></div>';
                    }
                    if (isset($row['LorryNo']) && $row['LorryNo'] != 0) {
                        $map_lorryNo = '<b>LorryNo: </b>'.$row['LorryNo'].'<br><div style="height:5px; width:100%;"></div>';
                    } else {
                        $map_lorryNo = '<b>LorryNo: </b>-<br><div style="height:5px; width:100%;"></div>';
                    }
                    $singleTracking[] = $map_driverName.$map_lorryNo.$map_vehicleRegNo;
                    $singleTracking[] = $lat;
                    $singleTracking[] = $long;
                    $singleTracking[] = $k+1;
                    $locations[$k] = $singleTracking;
                    $k++;
                }
            }

            if(empty($locations)){
                echo "no_results"; exit;
            }
            echo json_encode($locations); exit;
        }

        /* $data['driverList'] = array();
        $this->db->select('tbl_drivers_login.*');
        $this->db->from('tbl_drivers_login');
        $this->db->order_by('tbl_drivers_login.DriverID', 'DESC');
        $query = $this->db->get();
        $driverList = $query->result_array();
        $data['driverList'] = $driverList; */



        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Live Tracking Dashboard ';
        $this->global['active_menu'] = 'dashboard_new'; 


        $this->loadViews("dashboard_new", $this->global,  $data, NULL);
    }

    public function replay_activity()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Dashboard';
        $this->global['active_menu'] = 'dashboard_new';
		$data = array();   
        /* $data['contact_count'] = $this->Common_model->CountContacts() ; 
		$data['company_count'] = $this->Common_model->CountCompany() ; 
        $data['ticket_count'] = $this->Common_model->CountTicket(); 
        $data['ticket_limit_company'] = $this->Common_model->getTicketLimitCompanyList();   
		$data['new_company'] = $this->Common_model->getRecentlyAddedSites() ; 
		$data['new_company1'] = $this->Common_model->getRecentlyAddedCompany() ; 
        $data['user_count'] = $this->user_model->userListingCount() ;  
 */
        //$data['driverList'] = $this->Booking_model->GetDriverList(); 
        $data['driverList'] = array();
        $this->db->select('tbl_drivers_login.*');
        $this->db->from('tbl_drivers_login');
        $this->db->order_by('tbl_drivers_login.DriverID', 'DESC');
        $query = $this->db->get();
        $driverList = $query->result_array();
        $data['driverList'] = $driverList;
        //$data['driverList'] = $this->Drivers_model->GetDriverLoginData();  
        $allDrivers = $data['driverList'];
        foreach($allDrivers as $allDriver){
            if($allDriver['DriverID'] == $_GET['driver_id']){
                $data['current_driver'] = (array)$allDriver; 
            }
        }

        if (isset($_GET['start_time']) && !empty($_GET['start_time']) && isset($_GET['end_time']) && !empty($_GET['end_time']) && isset($_GET['driver_id']) && !empty($_GET['driver_id'])) {
            
            $start_time = $_GET['start_time'];
            $start_time = str_replace("/","-",$start_time);
            $end_time = $_GET['end_time'];
            $end_time = str_replace("/","-",$end_time);
            $driver_id = $_GET['driver_id'];
            $start_time = $_GET['start_time'] = date("Y-m-d H:i:s",strtotime($start_time));
            $end_time = $_GET['end_time'] = date("Y-m-d H:i:s",strtotime($end_time));
            $this->db->select('*');
            $this->db->from('tbl_live_tracking');
            $this->db->where("created_at >= ' ".$start_time."' "); 
            $this->db->where("created_at <= ' ".$end_time."' "); 
            $this->db->where('driver_id = '.$driver_id);
            $this->db->order_by('id', 'DESC');
            $query = $this->db->get();
            $live_tracking_data = $query->result_array();

            $data['live_tracking_data'] = $live_tracking_data;


            if (isset($_GET['is_ajax']) && $_GET['is_ajax'] == 1){ 
                if(empty($data['live_tracking_data'])){
                    echo "no_results"; exit;
                }
                echo json_encode(array("latitude"=>$data['live_tracking_data'][0]['latitude'],"longitude"=>$data['live_tracking_data'][0]['longitude'])); exit;
            }

        }
         
        /*  
        //$data['LorryRecords1'] = $this->Booking_model->LorryListAJAX1();  	 
        $data['LorryRecords1'] = $this->Booking_model->LorryListAJAX();  	 
        $data['LorryListNonApp'] = $this->Booking_model->LorryListNonApp();  	  
        $data['LorryRecords'] = $this->Booking_model->LorryListAJAX();  	
        $data['DriverTodayTAList'] = $this->Booking_model->DriverTodayTAList();  
            
        $data['TipRecords'] = $this->Booking_model->TipListAJAX();  */

        //$data['loads'] = $this->Livetracking_model->GetLoadsData();   
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Live Tracking Dashboard - Replay Activity For '.$data['current_driver']['DriverName'];
        $this->global['active_menu'] = 'dashboard_new'; 


        $this->loadViews("dashboard_replay", $this->global,  $data, NULL);
    }
    
}

?>
