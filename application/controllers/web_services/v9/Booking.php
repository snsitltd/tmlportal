<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';
include_once APPPATH . '/third_party/mpdf/mpdf.php';
require APPPATH . '/libraries/BaseController.php';
//include_once APPPATH.'/third_party/mpdf/mpdf01.php';
class Booking extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load the model
        $this->load->model('ApiModels/Booking1_API_Model');
        $this->load->model('ApiModels/Drivers_API_Model');
        $this->load->model('ApiModels/Ticket_API_Model');
        //$this->load->model('Common_model');
        $this->load->database();
    }

    private function log_api_data($data)
    {
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

    public function booking_list_post()
    {


        $token = $this->post('token');
        $BookingID = $this->post('BookingID');
        //$DriverID = $this->post('DriverID');
        $Load_status = $this->post('Load_status');
        $BookingType = $this->post('BookingType');
        //$BookingID = $this->post('BookingID');
        $driver_id = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');
        $LoadID = $this->post('LoadID');
        $data = [];

        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);


        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($DriverID)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {



            if ($Load_status == '0' or ($Load_status != '' or !empty($Load_status))) {
                $ql = 1;
                if ($LoadID) {
                    $qu = 1;
                    $this->db->select(
                        'tbl_booking1.*,
						tbl_users.name as BookedByName, 
						tbl_users.mobile as BookedByMobile, 
                        tbl_booking_request.BookingRequestID, tbl_booking_request.CompanyID, 
                        tbl_booking_request.CompanyName, 
                        tbl_booking_request.OpportunityID, 
                        tbl_booking_request.OpportunityName, 
                        tbl_booking_request.ContactID, 
                        tbl_booking_request.ContactName, 
                        tbl_booking_request.ContactMobile, 
                        tbl_booking_request.ContactEmail, 
                        tbl_booking_request.PurchaseOrderNumber, 
                        tbl_booking_request.PriceBy, 
                        tbl_booking_request.WaitingTime, 
                        tbl_booking_request.WaitingCharge, 
                        tbl_booking_request.Notes, 
                        tbl_booking_request.SubTotalAmount, 
                        tbl_booking_request.VatAmount, 
                        tbl_booking_request.PaymentType, 
                        tbl_booking_request.PaymentRefNo,
						tbl_opportunities.Street1, 
						IFNULL(tbl_opportunities.Street2, "") as Street2, 
						tbl_opportunities.Town, 
						tbl_opportunities.County, 
						tbl_opportunities.PostCode, 
						tbl_opportunities.opp_lat, 
						tbl_opportunities.opp_long, 
						tbl_opportunities.opp_updated_lat, 
						tbl_opportunities.opp_updated_long, 
						tbl_opportunities.opp_latlong_updated_by, 
						tbl_booking_loads1.LoadID, 
						tbl_booking_loads1.TipID, 
						tbl_tipaddress.TipName, 
                        tbl_tipaddress.tip_lat,
                        tbl_tipaddress.tip_long,
                        tbl_tipaddress.tip_updated_lat,
                        tbl_tipaddress.tip_updated_long,
                        tbl_tipaddress.tip_latlong_updated_by,
						tbl_booking_loads1.CustomerName, 
						tbl_booking_loads1.Signature, 
						tbl_booking_loads1.TipNumber, 
						tbl_booking_loads1.GrossWeight as blGrossWeight, 
						tbl_booking_loads1.Tare as blTare, 
						tbl_booking_loads1.Net as blNet, 
						tbl_booking_loads1.Status as Load_status, 
						tbl_booking_loads1.Notes as loadNotes, 
						tbl_booking_loads1.Notes1 as loadNotes1, 
						tbl_booking_loads1.Notes2 as loadNotes2, 
						tbl_booking_loads1.JobStartDateTime, 
						tbl_booking_loads1.ConveyanceNo, 
						tbl_booking_loads1.JobEndDateTime, 
						tbl_booking_loads1.ReceiptName, 
						tbl_booking_loads1.SiteInDateTime,
						tbl_booking_loads1.SiteOutDateTime,
						tbl_booking_loads1.AllocatedDateTime'
                    );

                    $this->db->from('tbl_booking_loads1');
                    $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
                    $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
                    //$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking_request.OpportunityID = tbl_opportunities.OpportunityID');
                    //$this->db->join('tbl_contacts', 'tbl_booking.ContactID =  tbl_contacts.ContactID');
                    //$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID =  tbl_materials.MaterialID');
                    $this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =   tbl_tipaddress.TipID');
                    $this->db->join(' tbl_users', 'tbl_booking1.BookedBy =   tbl_users.userId');
                    $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
                    $this->db->where('tbl_booking_loads1.Status', $Load_status);
                    //$this->db->where('tbl_booking.BookingID', $BookingID);
                    $this->db->where('tbl_booking_loads1.LoadID', $LoadID);
                    if ($Load_status == '4') {
                        $this->db->where('tbl_booking_loads1.DriverLoginID', $driver_id);
                    }
                    $this->db->group_by('tbl_booking_loads1.LoadID');
                    $this->db->order_by('tbl_booking_loads1.LoadID', 'DESC');
                    $query = $this->db->get();
                } else if ($BookingType) {
                    $qu = 2;
                    $this->db->select(
                        'tbl_booking1.*,
						tbl_users.name as BookedByName,
						tbl_users.mobile as BookedByMobile, 
                        tbl_booking_request.BookingRequestID, tbl_booking_request.CompanyID, 
                        tbl_booking_request.CompanyName, 
                        tbl_booking_request.OpportunityID, 
                        tbl_booking_request.OpportunityName, 
                        tbl_booking_request.ContactID, 
                        tbl_booking_request.ContactName, 
                        tbl_booking_request.ContactMobile, 
                        tbl_booking_request.ContactEmail, 
                        tbl_booking_request.PurchaseOrderNumber, 
                        tbl_booking_request.PriceBy, 
                        tbl_booking_request.WaitingTime, 
                        tbl_booking_request.WaitingCharge, 
                        tbl_booking_request.Notes, 
                        tbl_booking_request.SubTotalAmount, 
                        tbl_booking_request.VatAmount, 
                        tbl_booking_request.PaymentType, 
                        tbl_booking_request.PaymentRefNo,
						tbl_opportunities.Street1, 
						IFNULL(tbl_opportunities.Street2, "") as Street2, 
						tbl_opportunities.Town, 
						tbl_opportunities.County, 
						tbl_opportunities.PostCode,  
						tbl_opportunities.opp_lat, 
						tbl_opportunities.opp_long, 
						tbl_opportunities.opp_updated_lat, 
						tbl_opportunities.opp_updated_long, 
						tbl_opportunities.opp_latlong_updated_by, 
						tbl_booking_loads1.LoadID, 
						tbl_booking_loads1.TipID, 
						tbl_tipaddress.TipName,  
                        tbl_tipaddress.tip_lat,
                        tbl_tipaddress.tip_long,
                        tbl_tipaddress.tip_updated_lat,
                        tbl_tipaddress.tip_updated_long,
                        tbl_tipaddress.tip_latlong_updated_by,
						tbl_booking_loads1.CustomerName, 
						tbl_booking_loads1.Signature, 
						tbl_booking_loads1.TipNumber, 
						tbl_booking_loads1.GrossWeight as blGrossWeight, 
						tbl_booking_loads1.Tare as blTare, 
						tbl_booking_loads1.Net as blNet, 
						tbl_booking_loads1.Status as Load_status, 
						tbl_booking_loads1.Notes as loadNotes, 
						tbl_booking_loads1.Notes1 as loadNotes1, 
						tbl_booking_loads1.Notes2 as loadNotes2, 
						tbl_booking_loads1.JobStartDateTime, 
						tbl_booking_loads1.ConveyanceNo, 
						tbl_booking_loads1.JobEndDateTime, 
						tbl_booking_loads1.ReceiptName, 
						tbl_booking_loads1.SiteInDateTime,
						tbl_booking_loads1.SiteOutDateTime,
						tbl_booking_loads1.AllocatedDateTime'
                    );
                    $this->db->from('tbl_booking_loads1');
                    $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
                    $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
                    //$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking_request.OpportunityID = tbl_opportunities.OpportunityID');
                    //$this->db->join('tbl_contacts', 'tbl_booking.ContactID =  tbl_contacts.ContactID');
                    //$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID =  tbl_materials.MaterialID');
                    $this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID =   tbl_tipaddress.TipID');
                    $this->db->join('tbl_users', 'tbl_booking1.BookedBy =   tbl_users.userId');
                    $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
                    $this->db->where('tbl_booking1.BookingType', $BookingType);
                    $this->db->where('tbl_booking_loads1.Status', $Load_status);
                    if ($Load_status == '4') {
                        $this->db->where('tbl_booking_loads1.DriverLoginID', $driver_id);
                    }
                    $this->db->group_by('tbl_booking_loads1.LoadID');
                    $this->db->order_by('tbl_booking_loads1.LoadID', 'DESC');
                    $query = $this->db->get();
                } else {
                    $qu = 3;
                    $this->db->select(
                        'tbl_booking1.*,
						tbl_users.name as BookedByName, 
						tbl_users.mobile as BookedByMobile, 
                        tbl_booking_request.BookingRequestID, tbl_booking_request.CompanyID, 
                        tbl_booking_request.CompanyName, 
                        tbl_booking_request.OpportunityID, 
                        tbl_booking_request.OpportunityName, 
                        tbl_booking_request.ContactID, 
                        tbl_booking_request.ContactName, 
                        tbl_booking_request.ContactMobile, 
                        tbl_booking_request.ContactEmail, 
                        tbl_booking_request.PurchaseOrderNumber, 
                        tbl_booking_request.PriceBy, 
                        tbl_booking_request.WaitingTime, 
                        tbl_booking_request.WaitingCharge, 
                        tbl_booking_request.Notes, 
                        tbl_booking_request.SubTotalAmount, 
                        tbl_booking_request.VatAmount, 
                        tbl_booking_request.PaymentType, 
                        tbl_booking_request.PaymentRefNo,
						tbl_opportunities.Street1, 
						IFNULL(tbl_opportunities.Street2, "") as Street2, 
						tbl_opportunities.Town, 
						tbl_opportunities.County, 
						tbl_opportunities.PostCode,  
						tbl_opportunities.opp_lat, 
						tbl_opportunities.opp_long, 
						tbl_opportunities.opp_updated_lat, 
						tbl_opportunities.opp_updated_long, 
						tbl_opportunities.opp_latlong_updated_by, 
						tbl_booking_loads1.LoadID, 
						tbl_booking_loads1.TipID, 
						tbl_tipaddress.TipName,  
                        tbl_tipaddress.tip_lat,
                        tbl_tipaddress.tip_long,
                        tbl_tipaddress.tip_updated_lat,
                        tbl_tipaddress.tip_updated_long,
                        tbl_tipaddress.tip_latlong_updated_by,
						tbl_booking_loads1.CustomerName, 
						tbl_booking_loads1.Signature, 
						tbl_booking_loads1.TipNumber, 
						tbl_booking_loads1.GrossWeight as blGrossWeight, 
						tbl_booking_loads1.Tare as blTare, 
						tbl_booking_loads1.Net as blNet, 
						tbl_booking_loads1.Status as Load_status, 
						tbl_booking_loads1.Notes as loadNotes, 
						tbl_booking_loads1.Notes1 as loadNotes1, 
						tbl_booking_loads1.Notes2 as loadNotes2, 
						tbl_booking_loads1.JobStartDateTime, 
						tbl_booking_loads1.ConveyanceNo, 
						tbl_booking_loads1.JobEndDateTime, 
						tbl_booking_loads1.ReceiptName, 
						tbl_booking_loads1.SiteInDateTime,
						tbl_booking_loads1.SiteOutDateTime,
						tbl_booking_loads1.AllocatedDateTime'
                    );
                    $this->db->from('tbl_booking_loads1');
                    $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
                    $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
                    //$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking_request.OpportunityID = tbl_opportunities.OpportunityID');
                    //$this->db->join('tbl_contacts', 'tbl_booking.ContactID =  tbl_contacts.ContactID');
                    //$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID =  tbl_materials.MaterialID');
                    $this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =   tbl_tipaddress.TipID');
                    $this->db->join(' tbl_users', 'tbl_booking1.BookedBy =   tbl_users.userId');
                    $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
                    $this->db->where('tbl_booking_loads1.Status', $Load_status);
                    if ($Load_status == '4') {
                        $this->db->where('tbl_booking_loads1.DriverLoginID', $driver_id);
                    }
                    $this->db->group_by('tbl_booking_loads1.LoadID');
                    $this->db->order_by('tbl_booking_loads1.LoadID', 'DESC');
                    $query = $this->db->get();
                }
            } else {
                $ql = 2;
                if ($LoadID) {
                    $qu = 4;
                    $this->db->select(
                        'tbl_booking1.*,
						tbl_users.name as BookedByName, 
						tbl_users.mobile as BookedByMobile, 
                        tbl_booking_request.BookingRequestID, tbl_booking_request.CompanyID, 
                        tbl_booking_request.CompanyName, 
                        tbl_booking_request.OpportunityID, 
                        tbl_booking_request.OpportunityName, 
                        tbl_booking_request.ContactID, 
                        tbl_booking_request.ContactName, 
                        tbl_booking_request.ContactMobile, 
                        tbl_booking_request.ContactEmail, 
                        tbl_booking_request.PurchaseOrderNumber, 
                        tbl_booking_request.PriceBy, 
                        tbl_booking_request.WaitingTime, 
                        tbl_booking_request.WaitingCharge, 
                        tbl_booking_request.Notes, 
                        tbl_booking_request.SubTotalAmount, 
                        tbl_booking_request.VatAmount, 
                        tbl_booking_request.PaymentType, 
                        tbl_booking_request.PaymentRefNo,
						tbl_opportunities.Street1, 
						IFNULL(tbl_opportunities.Street2, "") as Street2, 
						tbl_opportunities.Town, 
						tbl_opportunities.County, 
						tbl_opportunities.PostCode,  
						tbl_opportunities.opp_lat, 
						tbl_opportunities.opp_long, 
						tbl_opportunities.opp_updated_lat, 
						tbl_opportunities.opp_updated_long, 
						tbl_opportunities.opp_latlong_updated_by, 
						tbl_booking_loads1.LoadID, 
						tbl_booking_loads1.TipID, 
						tbl_tipaddress.TipName,  
                        tbl_tipaddress.tip_lat,
                        tbl_tipaddress.tip_long,
                        tbl_tipaddress.tip_updated_lat,
                        tbl_tipaddress.tip_updated_long,
                        tbl_tipaddress.tip_latlong_updated_by,
						tbl_booking_loads1.CustomerName, 
						tbl_booking_loads1.Signature, 
						tbl_booking_loads1.TipNumber, 
						tbl_booking_loads1.GrossWeight as blGrossWeight, 
						tbl_booking_loads1.Tare as blTare, 
						tbl_booking_loads1.Net as blNet, 
						tbl_booking_loads1.Status as Load_status, 
						tbl_booking_loads1.Notes as loadNotes, 
						tbl_booking_loads1.Notes1 as loadNotes1, 
						tbl_booking_loads1.Notes2 as loadNotes2, 
						tbl_booking_loads1.JobStartDateTime, 
						tbl_booking_loads1.ConveyanceNo, 
						tbl_booking_loads1.JobEndDateTime, 
						tbl_booking_loads1.ReceiptName, 
						tbl_booking_loads1.SiteInDateTime,
						tbl_booking_loads1.SiteOutDateTime,
						tbl_booking_loads1.AllocatedDateTime'
                    );
                    $this->db->from('tbl_booking_loads1');
                    $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
                    $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
                    //$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking_request.OpportunityID = tbl_opportunities.OpportunityID');
                    //$this->db->join('tbl_contacts', 'tbl_booking.ContactID =  tbl_contacts.ContactID');
                    //$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID =  tbl_materials.MaterialID');
                    $this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =   tbl_tipaddress.TipID');
                    $this->db->join(' tbl_users', 'tbl_booking1.BookedBy =   tbl_users.userId');
                    $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
                    $this->db->where('tbl_booking_loads1.LoadID', $LoadID);
                    if ($Load_status == '4') {
                        $this->db->where('tbl_booking_loads1.DriverLoginID', $driver_id);
                    }
                    $this->db->group_by('tbl_booking_loads1.LoadID');
                    $this->db->order_by('tbl_booking_loads1.LoadID', 'DESC');
                    $query = $this->db->get();
                } else if ($BookingType) {
                    $qu = 5;
                    $this->db->select(
                        'tbl_booking1.*,
						tbl_users.name as BookedByName, 
						tbl_users.mobile as BookedByMobile, 
                        tbl_booking_request.BookingRequestID, tbl_booking_request.CompanyID, 
                        tbl_booking_request.CompanyName, 
                        tbl_booking_request.OpportunityID, 
                        tbl_booking_request.OpportunityName, 
                        tbl_booking_request.ContactID, 
                        tbl_booking_request.ContactName, 
                        tbl_booking_request.ContactMobile, 
                        tbl_booking_request.ContactEmail, 
                        tbl_booking_request.PurchaseOrderNumber, 
                        tbl_booking_request.PriceBy, 
                        tbl_booking_request.WaitingTime, 
                        tbl_booking_request.WaitingCharge, 
                        tbl_booking_request.Notes, 
                        tbl_booking_request.SubTotalAmount, 
                        tbl_booking_request.VatAmount, 
                        tbl_booking_request.PaymentType, 
                        tbl_booking_request.PaymentRefNo,
						tbl_opportunities.Street1, 
						IFNULL(tbl_opportunities.Street2, "") as Street2, 
						tbl_opportunities.Town, 
						tbl_opportunities.County, 
						tbl_opportunities.PostCode,  
						tbl_opportunities.opp_lat, 
						tbl_opportunities.opp_long, 
						tbl_opportunities.opp_updated_lat, 
						tbl_opportunities.opp_updated_long, 
						tbl_opportunities.opp_latlong_updated_by, 
						tbl_booking_loads1.LoadID, 
						tbl_booking_loads1.TipID, 
						tbl_tipaddress.TipName,  
                        tbl_tipaddress.tip_lat,
                        tbl_tipaddress.tip_long,
                        tbl_tipaddress.tip_updated_lat,
                        tbl_tipaddress.tip_updated_long,
                        tbl_tipaddress.tip_latlong_updated_by,
						tbl_booking_loads1.CustomerName, 
						tbl_booking_loads1.Signature, 
						tbl_booking_loads1.TipNumber, 
						tbl_booking_loads1.GrossWeight as blGrossWeight, 
						tbl_booking_loads1.Tare as blTare, 
						tbl_booking_loads1.Net as blNet, 
						tbl_booking_loads1.Status as Load_status, 
						tbl_booking_loads1.Notes as loadNotes, 
						tbl_booking_loads1.Notes1 as loadNotes1, 
						tbl_booking_loads1.Notes2 as loadNotes2, 
						tbl_booking_loads1.JobStartDateTime, 
						tbl_booking_loads1.ConveyanceNo, 
						tbl_booking_loads1.JobEndDateTime, 
						tbl_booking_loads1.ReceiptName, 
						tbl_booking_loads1.SiteInDateTime,
						tbl_booking_loads1.SiteOutDateTime,
						tbl_booking_loads1.AllocatedDateTime'
                    );
                    $this->db->from('tbl_booking_loads1');
                    $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
                    $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
                    //$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking_request.OpportunityID = tbl_opportunities.OpportunityID');
                    //$this->db->join('tbl_contacts', 'tbl_booking.ContactID =  tbl_contacts.ContactID');
                    //$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID =  tbl_materials.MaterialID');
                    $this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =   tbl_tipaddress.TipID');
                    $this->db->join(' tbl_users', 'tbl_booking1.BookedBy =   tbl_users.userId');
                    $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
                    $this->db->where('tbl_booking1.BookingType', $BookingType);
                    if ($Load_status == '4') {
                        $this->db->where('tbl_booking_loads1.DriverLoginID', $driver_id);
                    }
                    $this->db->group_by('tbl_booking_loads1.LoadID');
                    $this->db->order_by('tbl_booking_loads1.LoadID', 'DESC');
                    $query = $this->db->get();

                    print_r($this->db->last_query());
                    exit;
                } else {
                    $qu = 6;
                    $this->db->select(
                        'tbl_booking1.*,
						tbl_users.name as BookedByName, 
						tbl_users.mobile as BookedByMobile, 
                        tbl_booking_request.BookingRequestID, tbl_booking_request.CompanyID, 
                        tbl_booking_request.CompanyName, 
                        tbl_booking_request.OpportunityID, 
                        tbl_booking_request.OpportunityName, 
                        tbl_booking_request.ContactID, 
                        tbl_booking_request.ContactName, 
                        tbl_booking_request.ContactMobile, 
                        tbl_booking_request.ContactEmail, 
                        tbl_booking_request.PurchaseOrderNumber, 
                        tbl_booking_request.PriceBy, 
                        tbl_booking_request.WaitingTime, 
                        tbl_booking_request.WaitingCharge, 
                        tbl_booking_request.Notes, 
                        tbl_booking_request.SubTotalAmount, 
                        tbl_booking_request.VatAmount, 
                        tbl_booking_request.PaymentType, 
                        tbl_booking_request.PaymentRefNo,
						tbl_opportunities.Street1, 
						IFNULL(tbl_opportunities.Street2, "") as Street2, 
						tbl_opportunities.Town, 
						tbl_opportunities.County, 
						tbl_opportunities.PostCode,  
						tbl_opportunities.opp_lat, 
						tbl_opportunities.opp_long, 
						tbl_opportunities.opp_updated_lat, 
						tbl_opportunities.opp_updated_long, 
						tbl_opportunities.opp_latlong_updated_by, 
						tbl_booking_loads1.LoadID, 
						tbl_booking_loads1.TipID, 
						tbl_tipaddress.TipName,  
                        tbl_tipaddress.tip_lat,
                        tbl_tipaddress.tip_long,
                        tbl_tipaddress.tip_updated_lat,
                        tbl_tipaddress.tip_updated_long,
                        tbl_tipaddress.tip_latlong_updated_by,
						tbl_booking_loads1.CustomerName, 
						tbl_booking_loads1.Signature, 
						tbl_booking_loads1.TipNumber, 
						tbl_booking_loads1.GrossWeight as blGrossWeight, 
						tbl_booking_loads1.Tare as blTare, 
						tbl_booking_loads1.Net as blNet, 
						tbl_booking_loads1.Status as Load_status, 
						tbl_booking_loads1.Notes as loadNotes, 
						tbl_booking_loads1.Notes1 as loadNotes1, 
						tbl_booking_loads1.Notes2 as loadNotes2, 
						tbl_booking_loads1.JobStartDateTime, 
						tbl_booking_loads1.ConveyanceNo, 
						tbl_booking_loads1.JobEndDateTime, 
						tbl_booking_loads1.ReceiptName, 
						tbl_booking_loads1.SiteInDateTime,
						tbl_booking_loads1.SiteOutDateTime,
						tbl_booking_loads1.AllocatedDateTime'
                    );
                    $this->db->from('tbl_booking_loads1');
                    $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
                    $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
                    //$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID');
                    $this->db->join('tbl_opportunities', 'tbl_booking_request.OpportunityID = tbl_opportunities.OpportunityID');
                    //$this->db->join('tbl_contacts', 'tbl_booking.ContactID =  tbl_contacts.ContactID');
                    //$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID =  tbl_materials.MaterialID');
                    $this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =   tbl_tipaddress.TipID');
                    $this->db->join(' tbl_users', 'tbl_booking1.BookedBy =   tbl_users.userId');
                    $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
                    if ($Load_status == '4') {
                        $this->db->where('tbl_booking_loads1.DriverLoginID', $driver_id);
                    }
                    $this->db->group_by('tbl_booking_loads1.LoadID');
                    $this->db->order_by('tbl_booking_loads1.LoadID', 'DESC');
                    $query = $this->db->get();
                }
            }
            if ($query->num_rows() > 0) {
                $status = "1";
                //$message ='Booking Data. '.$ql.' '.$qu;
                $message = 'Booking Data';
                $dataarr = $query->result();


                foreach ($dataarr as $dataar) {

                    if ($dataar->BookingType == 1) {
                        $BookingTypeName = 'Collection';
                    } elseif ($dataar->BookingType == 3) {
                        $BookingTypeName = 'Daywork';
                    } elseif ($dataar->BookingType == 4) {
                        $BookingTypeName = 'Haulage';
                    } else {
                        $BookingTypeName = 'Delivery';
                    }

                    //Images
                    $this->db->select('ImageName');
                    $this->db->from('tbl_booking_loads_photos1');
                    $this->db->where('LoadID', $dataar->LoadID);
                    $this->db->where('is_ticket_photo', 0);
                    $imagesQRY = $this->db->get();
                    if ($imagesQRY->num_rows() > 0) {
                        $imgs = $imagesQRY->result();
                        foreach ($imgs as $img) {
                            $image[] = base_url() . 'uploads/Photo/' . $img->ImageName;
                        }
                    } else {
                        $image = [];
                    }
                    //End Images
                    if ($dataar->Signature) {
                        $Signatureimg = base_url() . 'uploads/Signature/' . $dataar->Signature;
                    } else {
                        $Signatureimg = '';
                    }
                    $LBookingID = $dataar->BookingID;
                    if ($dataar->LoadType == 2) {
                        $creatDatess = $dataar->CreateDateTime;
                        $today = date('Y-m-d H:i:s');
                        $date_diff = abs(strtotime($creatDatess) - strtotime($today));
                        $years = floor($date_diff / (365 * 60 * 60 * 24));
                        $months = floor(($date_diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                        $days = floor(($date_diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                        if ($days <= $dataar->Days) {
                            $con_finish = 1;
                        } else {
                            $con_finish = 0;
                        }
                    } else {
                        $con_finish = 0;
                    }
                    //echo $dataar->Loads;
                    if ($dataar->LoadType == 1) {
                        $LoadTypeName = 'Load';
                        //$con_finish = 0;
                    } else {
                        $LoadTypeName = 'TurnAround';
                        //$con_finish = 1;
                    }

                    $grosLID = $dataar->LoadID;
                    $GrossWeightQRY = $this->db->query("select TicketNumber,TicketUniqueID,GrossWeight,Tare,Net,is_hold from tbl_tickets where LoadID = '$grosLID'");
                    $GrossWeightName = $GrossWeightQRY->row_array();
                    if ($GrossWeightQRY->num_rows() > 0) {
                        $GrossWeight = $GrossWeightName['GrossWeight'];
                        $Tare = $GrossWeightName['Tare'];
                        $Net = $GrossWeightName['Net'];
                        if ($GrossWeightName['is_hold'] == 0) {


                            if ($dataar->ReceiptName == '') {
                                $TicketPDF = base_url() . '/assets/pdf_file/' . $GrossWeightName['TicketUniqueID'] . '.pdf';
                            } else {
                                $TicketPDF = base_url() . 'assets/conveyance/' . $dataar->ReceiptName;
                            }

                            //$TicketPDF = base_url().'/assets/pdf_file/'.$GrossWeightName['TicketUniqueID'].'.pdf';
                            // $TicketPDF = base_url().'assets/conveyance/'.$dataar->ReceiptName;
                        } else {
                            $TicketPDF = '';
                        }
                    } else {
                        //Complated GET PDF
                        if ($dataar->ReceiptName == '') {
                            $TicketPDFGET = '';
                        } else {
                            $TicketPDFGET = base_url() . 'assets/conveyance/' . $dataar->ReceiptName;
                            ;
                        }
                        $GrossWeight = $dataar->blGrossWeight;
                        $Tare = $dataar->blTare;
                        $Net = $dataar->blNet;
                        $TicketPDF = $TicketPDFGET;
                    }

                    if ($GrossWeight == '0.00') {
                        $GrossWeight = '';
                    }


                    $creatDatess = $dataar->CreateDateTime;
                    $today = date('Y-m-d H:i:s');
                    $date_diff = abs(strtotime($creatDatess) - strtotime($today));
                    $years = floor($date_diff / (365 * 60 * 60 * 24));
                    $months = floor(($date_diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($date_diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                    //$dataar->LoadType == 2 AND $days <= $dataar->Days AND $dataar->Load_status != 4
                    //if($dataar->LoadType == 2 AND $days >= $dataar->Days AND $dataar->Load_status != 4){
                    //} else {
                    /*
                  $bd = date("d-m-Y", strtotime($dataar->AllocatedDateTime)); 
                  
                  if($bd <= date('d-m-Y')){
                      $_is_accept = '1';
                  }else { 
                      $_is_accept = 1;
                  }*/

                    $bd = date("d-m-Y", strtotime($dataar->AllocatedDateTime));
                    if ($bd == date('d-m-Y')) {
                        $_is_accept = '1';
                    } else if (strtotime($dataar->AllocatedDateTime) <= strtotime(date('d-m-Y'))) {
                        $_is_accept = '1';
                    } else {
                        $_is_accept = 0;
                    }


                    $this->db->select('tbl_booking_loads1.LoadID, tbl_booking1.BookingType');
                    $this->db->from('tbl_booking_loads1');
                    $this->db->join('tbl_booking1', 'tbl_booking1.BookingID = tbl_booking_loads1.BookingID');
                    $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
                    $this->db->where_in('tbl_booking_loads1.Status', [1, 2, 3]);
                    $query_is_accept_now = $this->db->get();
                    $checkDayWorkJobRunning = $checkOtherJobRunning = false;
                    $currentRunningJob = '';
                    if ($query_is_accept_now->num_rows() > 0) {
                        $acceptdataarr = $query_is_accept_now->result();
                        foreach ($acceptdataarr as $acceptdata) {
                            if ($acceptdata->BookingType == 3) {
                                $checkDayWorkJobRunning = true;
                            } else {
                                $checkOtherJobRunning = true;
                            }
                        }
                        $_is_accept_now = 1; // Allow for accept all job // last changed
                        if ($query_is_accept_now->num_rows() > 1) {
                            $_is_accept_now = 1;
                            $currentRunningJob = 'both';
                        } elseif ($checkDayWorkJobRunning) {
                            $_is_accept_now = 0; // Allow to accept other jobs if daywork is running
                            $currentRunningJob = 'daywork';
                        } elseif ($checkOtherJobRunning) {
                            $_is_accept_now = 1; // Allow to accept other jobs if daywork is running
                            $currentRunningJob = 'collection_delivery';
                        }

                    } else {
                        $_is_accept_now = 0;
                    }


                    $this->db->select('TipTicketID');
                    $this->db->from('tbl_tipticket');
                    $this->db->where('tbl_tipticket.LoadID', $dataar->LoadID);
                    $check_tipticket = $this->db->get();
                    if ($check_tipticket->num_rows() > 0) {
                        $tipticketExists = 1; // Allow for accept all job // last changed
                        $check_tipticket = $check_tipticket->result();
                        $tipticketId = $check_tipticket[0]->TipTicketID;
                    } else {
                        $tipticketExists = 0;
                        $tipticketId = 0;
                    }

                    if ($dataar->BookingType == 3) {
                        if ($dataar->DayWorkType == 1) {
                            $dataar->MaterialName = $dataar->MaterialName . ', Day';
                        } elseif ($dataar->DayWorkType == 2) {
                            $dataar->MaterialName = $dataar->MaterialName . ', Night';
                        } elseif ($dataar->DayWorkType == 3) {
                            $dataar->MaterialName = $dataar->MaterialName . ', Hourly';
                        }
                    }

                    //Traffic Management Code Start
                    $this->db->select('tbl_documents.*');
                    $this->db->from('tbl_documents');
                    $this->db->join('tbl_opportunity_to_document', 'tbl_opportunity_to_document.DocumentID = tbl_documents.DocumentID');
                    $this->db->where('tbl_opportunity_to_document.OpportunityID', $dataar->OpportunityID);
                    $this->db->order_by('tbl_documents.CreateDateTime', 'DESC');
                    $allDocuments = $this->db->get();
                    $trafficDocument = '';
                    if ($allDocuments->num_rows() > 0) {
                        $allDocuments = $allDocuments->result();
                        foreach ($allDocuments as $allDocument) {
                            if ($allDocument->DocumentType == 6) {
                                if (empty($trafficDocument)) {
                                    $trafficDocument = $allDocument->DocumentAttachment;
                                }
                            }
                        }
                    }
                    if (!empty($trafficDocument)) {
                        $trafficDocument = base_url() . '/assets/Documents/' . $trafficDocument;
                    }

                    //Traffic Management Code End


                    //Tip Ticket Photos
                    $this->db->select('*');
                    $this->db->from('tbl_booking_loads_photos1');
                    $this->db->where('LoadID', $dataar->LoadID);
                    $this->db->where('is_ticket_photo', 1);
                    $alltipTicketPhotos = $this->db->get();
                    $tipticketPhotos = array();
                    if ($alltipTicketPhotos->num_rows() > 0) {
                        $alltipTicketPhotos = $alltipTicketPhotos->result();
                        foreach ($alltipTicketPhotos as $allDocument) {
                            $allDocument->ImageName = base_url() . '/uploads/Photo/' . $allDocument->ImageName;
                            $tipticketPhotos[] = $allDocument;
                        }
                    }


                    $data[] = array(

                        "BookingID" => $dataar->BookingID,
                        "BID" => $dataar->BID,

                        "ConveyanceNo" => $dataar->ConveyanceNo,
                        "BookingType" => $dataar->BookingType,
                        "BookingTypeName" => $BookingTypeName,
                        //"BookingDateTime"=>$dataar->BookingDateTime,
                        "BookingDateTime1" => date("d-m-Y H:i", strtotime($dataar->AllocatedDateTime)),
                        "BookingDateTime" => date("d-m-Y H:i", strtotime($dataar->AllocatedDateTime)),
                        "CompanyID" => $dataar->CompanyID,
                        "OpportunityID" => $dataar->OpportunityID,
                        "MaterialID" => $dataar->MaterialID,
                        "MaterialName" => $dataar->MaterialName,
                        "LoadType" => $dataar->LoadType,
                        "LoadTypeName" => $LoadTypeName,
                        "Loads" => $dataar->Loads,
                        "PurchaseOrderNumber" => $dataar->PurchaseOrderNumber,
                        "Price" => $dataar->Price,
                        "ContactID" => $dataar->ContactID,
                        "Email" => $dataar->Email,
                        "Notes" => $dataar->Notes,
                        "BookedBy" => $dataar->BookedBy,
                        "UpdatedBy" => $dataar->UpdatedBy,
                        "ApprovedBy" => $dataar->ApprovedBy,
                        "CreateDateTime" => date("d-m-Y H:i", strtotime($dataar->CreateDateTime)),
                        "UpdateDateTime" => date("d-m-Y H:i", strtotime($dataar->UpdateDateTime)),
                        "Status" => $dataar->Status,
                        "CompanyName" => $dataar->CompanyName,
                        "OpportunityName" => $dataar->OpportunityName,
                        "Street1" => $dataar->Street1,
                        "Street2" => $dataar->Street2,
                        "Town" => $dataar->Town,
                        "County" => $dataar->County,
                        "PostCode" => $dataar->PostCode,
                        "ContactName" => $dataar->ContactName,
                        "LoadID" => $dataar->LoadID,
                        "TipID" => $dataar->TipID,
                        "TipName" => $dataar->TipName,
                        "CustomerName" => $dataar->CustomerName,
                        "MobileNo" => $dataar->ContactMobile,
                        "Load_status" => $dataar->Load_status,
                        "JobStartDateTime" => date("d-m-Y H:i", strtotime($dataar->JobStartDateTime)),
                        "JobEndDateTime" => date("d-m-Y H:i", strtotime($dataar->JobEndDateTime)),
                        "BookedByName" => $dataar->BookedByName,
                        "BookedByMobile" => $dataar->BookedByMobile,
                        "GrossWeight" => $GrossWeight . '',
                        "Tare" => $Tare,
                        "Net" => $Net,
                        "TicketNumber" => $GrossWeightName['TicketNumber'],
                        "TicketPDF" => $TicketPDF,
                        "loadNotes" => $dataar->loadNotes . '',
                        "loadNotes1" => $dataar->loadNotes1 . '',
                        "loadNotes2" => $dataar->loadNotes2 . '',
                        "Signature" => $Signatureimg,
                        "TipNumber" => $dataar->TipNumber,
                        "NewLoadID" => "0",
                        "con_finish" => $con_finish,
                        "images" => $image,
                        "_is_accept" => $_is_accept . '',
                        "_is_accept_now" => $_is_accept_now . '',
                        'current_running_job' => $currentRunningJob,
                        "is_tip_ticket_created" => $tipticketExists,
                        "tip_ticket_id" => $tipticketId,
                        "tonBook" => $dataar->TonBook,
                        "totalTon" => $dataar->TotalTon,
                        "tonPerLoad" => $dataar->TonPerLoad,
                        "SiteInDateTime" => $dataar->SiteInDateTime,
                        "SiteOutDateTime" => $dataar->SiteOutDateTime,
                        "TrafficDocument" => $trafficDocument,
                        "tipticketPhotos" => $tipticketPhotos,
                        "opp_lat" => $dataar->opp_lat,
                        "opp_long" => $dataar->opp_long,
                        "opp_updated_lat" => $dataar->opp_updated_lat,
                        "opp_updated_long" => $dataar->opp_updated_long,
                        "opp_latlong_updated_by" => $dataar->opp_latlong_updated_by,
                        "tip_lat" => $dataar->tip_lat,
                        "tip_long" => $dataar->tip_long,
                        "tip_updated_lat" => $dataar->tip_updated_lat,
                        "tip_updated_long" => $dataar->tip_updated_long,
                        "tip_latlong_updated_by" => $dataar->tip_latlong_updated_by
                    );
                }

                // }

            } else {
                $status = "0";
                $message = 'Booking data not found.';
            }
        }

        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    // Material List EA

    public function material_ea_list_post()
    {
        $this->db->select('MaterialID,MaterialName,EAProduct,');
        $this->db->from('tbl_materials');
        $this->db->where('EAProduct', 1);
        $query = $this->db->get();

        $logData = [
            'driver_id' => $this->post('driver_id') ?? "",
            'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);

        // Check if query was successful
        if ($query) {
            // Retrieve results
            $data = $query->result_array();

            // Return response with data
            $this->response([
                'status' => true,
                'message' => "EAProduct Material List",
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            // If query failed, return error response
            $this->response([
                'status' => false,
                'message' => "Error fetching data"
            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Check Expense

    public function check_expense_post()
    {

        $token = $this->post('token');
        $conv_no = $this->post('conveyence_number');


        $logData = [
            'driver_id' => $this->post('driver_id') ?? "",
            'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);

        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($conv_no) || empty($conv_no)) {
            // Conveyance number is required but not provided
            $status = "0";
            $message = 'Conveyance Number Is Required';

            // Return the error response immediately
            $this->response([
                'status' => false,
                'message' => $message
            ], REST_Controller::HTTP_BAD_REQUEST);

            return; // Exit the function to prevent further execution
        }

        // Proceed with database query only if conveyance number is provided

        $this->db->select('TicketID, Expenses,is_expense_edit');
        $this->db->from('tbl_booking_loads1');
        $this->db->where('ConveyanceNo', $conv_no);
        $this->db->limit(1);
        $query = $this->db->get();

        // Retrieve result data
        $rowData = $query->row_array(); // Assuming you want an array of results 

        if (!empty($rowData)) {
            // Expense found in database
            $message = "Expense Found";
        } else {
            // Expense not found in database
            $message = "Expense Not Found";
        }

        $this->response([
            'status' => true,
            'message' => $message,
            'data' => $rowData
        ], REST_Controller::HTTP_OK);
    }

    // Add Expense

    public function add_expense_post()
    {

        $token = $this->post('token');
        $conv_no = $this->post('conveyence_number');
        $expense = $this->post('expense');

        $logData = [
            'driver_id' => $this->post('driver_id') ?? "",
            'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);

        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($conv_no) || empty($conv_no)) {
            // Conveyance number is required but not provided
            $status = "0";
            $message = 'Conveyance Number Is Required';

            // Return the error response immediately
            $this->response([
                'status' => false,
                'message' => $message
            ], REST_Controller::HTTP_BAD_REQUEST);

            return; // Exit the function to prevent further execution
        } else if (!isset($expense) || empty($expense)) {
            // Conveyance number is required but not provided
            $status = "0";
            $message = 'Expense Is Required';

            // Return the error response immediately
            $this->response([
                'status' => false,
                'message' => $message
            ], REST_Controller::HTTP_BAD_REQUEST);

            return; // Exit the function to prevent further execution
        }

        $data = array(
            'Expenses' => $expense
        );

        // Fetch the current expense value from the database
        $this->db->select('Expenses');
        $this->db->where('ConveyanceNo', $conv_no);
        $query = $this->db->get('tbl_booking_loads1');
        $result = $query->row();

        if ($result && $result->Expenses == '0.00') {
            // If expense in the database is 0.00, set is_expense_edit to 1
            $this->db->set('is_expense_edit', '1');
        } else {
            // If expense in the database is not 0.00, set is_expense_edit to 2
            $this->db->set('is_expense_edit', '2');
        }

        $this->db->set('expense_update_time', 'NOW()', FALSE);
        $this->db->where('ConveyanceNo', $conv_no);
        $this->db->update('tbl_booking_loads1', $data);

        // Check if the expense was successfully updated
        if ($this->db->affected_rows() > 0) {
            $status = "1";
            $message = 'Expense updated successfully';
        } else {
            $status = "0";
            $message = 'Failed to update expense';
        }



        // Return the response
        $this->response([
            'status' => $status,
            'message' => $message
        ], REST_Controller::HTTP_OK);

    }



    public function booking_uncomplicated_list_post()
    {


        $token = $this->post('token');
        //$DriverID = $this->post('DriverID');
        $driver_id = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');
        $data = [];

        $logData = [
            'driver_id' => $this->post('driver_id'),
            'lorry_no' => $this->post('lorry_no'),
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);

        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);


        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($driver_id)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {

            $this->db->select(
                'tbl_booking1.*, 
                tbl_booking_request.BookingRequestID, tbl_booking_request.CompanyID, 
                tbl_booking_request.CompanyName, 
                tbl_booking_request.OpportunityID, 
                tbl_booking_request.OpportunityName, 
                tbl_booking_request.ContactID, 
                tbl_booking_request.ContactName, 
                tbl_booking_request.ContactMobile, 
                tbl_booking_request.ContactEmail, 
                tbl_booking_request.PurchaseOrderNumber, 
                tbl_booking_request.PriceBy, 
                tbl_booking_request.WaitingTime, 
                tbl_booking_request.WaitingCharge, 
                tbl_booking_request.Notes, 
                tbl_booking_request.SubTotalAmount, 
                tbl_booking_request.VatAmount, 
                tbl_booking_request.PaymentType, 
                tbl_booking_request.PaymentRefNo,
                tbl_opportunities.Street1, 
                IFNULL(tbl_opportunities.Street2, "") as Street2, 
                tbl_opportunities.Town, 
                tbl_opportunities.County, 
                tbl_opportunities.PostCode, 
                tbl_opportunities.opp_lat, 
                tbl_opportunities.opp_long, 
                tbl_opportunities.opp_updated_lat, 
                tbl_opportunities.opp_updated_long, 
                tbl_opportunities.opp_latlong_updated_by, 
                tbl_booking_loads1.LoadID, 
                tbl_booking_loads1.TipID, 
                tbl_tipaddress.TipName, 
                tbl_tipaddress.tip_lat,
                tbl_tipaddress.tip_long,
                tbl_tipaddress.tip_updated_lat,
                tbl_tipaddress.tip_updated_long,
                tbl_tipaddress.tip_latlong_updated_by,
                tbl_booking_loads1.CustomerName, 
                tbl_booking_loads1.TipNumber, 
                tbl_booking_loads1.Status as Load_status, 
                tbl_booking_loads1.JobStartDateTime, 
                tbl_booking_loads1.ConveyanceNo, 
                tbl_booking_loads1.JobEndDateTime, 
                tbl_booking_loads1.AllocatedDateTime'
            );
            $this->db->from('tbl_booking_loads1');
            $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
            $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
            //$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID');
            $this->db->join('tbl_opportunities', 'tbl_booking_request.OpportunityID = tbl_opportunities.OpportunityID');
            //$this->db->join('tbl_contacts', 'tbl_booking.ContactID =  tbl_contacts.ContactID');
            //$this->db->join('tbl_materials', 'tbl_booking_loads.MaterialID =  tbl_materials.MaterialID');
            $this->db->join(' tbl_tipaddress', 'tbl_booking_loads1.TipID =   tbl_tipaddress.TipID');
            $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
            $this->db->where('tbl_booking_loads1.Status != ', 0, FALSE);
            $this->db->where('tbl_booking_loads1.Status != ', 4, FALSE);
            $this->db->where('tbl_booking_loads1.Status != ', 5, FALSE);
            $this->db->where('tbl_booking_loads1.Status != ', 6, FALSE);
            $this->db->group_by('tbl_booking1.BookingID');
            $this->db->order_by('tbl_booking_loads1.LoadID', 'DESC');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $status = "1";
                $message = 'Booking uncompleted Data';
                $dataarr = $query->result();
                foreach ($dataarr as $dataar) {

                    if ($dataar->BookingType == 1) {
                        $BookingTypeName = 'Collection';
                    } elseif ($dataar->BookingType == 3) {
                        $BookingTypeName = 'Daywork';
                    } elseif ($dataar->BookingType == 4) {
                        $BookingTypeName = 'Haulage';
                    } else {
                        $BookingTypeName = 'Delivery';
                    }
                    $LBookingID = $dataar->BookingID;
                    if ($dataar->BookingType == 2) {
                        $loadNo = $this->db->query("select * from tbl_booking_loads1 where BookingID = '$LBookingID'");
                        $finishC = $loadNo->num_rows() + 1;
                        if ($dataar->Loads >= $finishC) {
                            $con_finish = 1;
                        } else {
                            $con_finish = 0;
                        }
                    } else {
                        $con_finish = 0;
                    }

                    if ($dataar->LoadType == 1) {
                        $LoadTypeName = 'Load';
                    } else {
                        $LoadTypeName = 'TurnAround';
                    }

                    $grosLID = $dataar->LoadID;
                    $GrossWeightQRY = $this->db->query("select TicketNumber,TicketUniqueID,GrossWeight,Tare,Net,is_hold from tbl_tickets where LoadID = '$grosLID'");
                    $GrossWeightName = $GrossWeightQRY->row_array();
                    if ($GrossWeightQRY->num_rows() > 0) {
                        $GrossWeight = $GrossWeightName['GrossWeight'];
                        $Tare = $GrossWeightName['Tare'];
                        $Net = $GrossWeightName['Net'];
                        if ($GrossWeightName['is_hold'] == 0) {
                            $TicketPDF = base_url() . '/assets/pdf_file/' . $GrossWeightName['TicketUniqueID'] . '.pdf';
                        } else {
                            $TicketPDF = base_url() . '/assets/conveyance/' . $dataarr->ReceiptName;
                        }
                    } else {
                        $GrossWeight = '';
                        $Tare = '';
                        $Net = '';
                        $TicketPDF = base_url() . '/assets/conveyance/' . $dataarr->ReceiptName;
                    }

                    $creatDatess = $dataar->CreateDateTime;
                    $today = date('Y-m-d H:s:i');
                    $date_diff = abs(strtotime($creatDatess) - strtotime($today));
                    $years = floor($date_diff / (365 * 60 * 60 * 24));
                    $months = floor(($date_diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($date_diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));


                    //Traffic Management Code Start
                    $this->db->select('tbl_documents.*');
                    $this->db->from('tbl_documents');
                    $this->db->join('tbl_opportunity_to_document', 'tbl_opportunity_to_document.DocumentID = tbl_documents.DocumentID');
                    $this->db->where('tbl_opportunity_to_document.OpportunityID', $dataar->OpportunityID);
                    $this->db->order_by('tbl_documents.CreateDateTime', 'DESC');
                    $allDocuments = $this->db->get();
                    $trafficDocument = '';
                    if ($allDocuments->num_rows() > 0) {
                        $allDocuments = $allDocuments->result();
                        foreach ($allDocuments as $allDocument) {
                            if ($allDocument->DocumentType == 6) {
                                if (empty($trafficDocument)) {
                                    $trafficDocument = $allDocument->DocumentAttachment;
                                }
                            }
                        }
                    }
                    if (!empty($trafficDocument)) {
                        $trafficDocument = base_url() . '/assets/Documents/' . $trafficDocument;
                    }


                    //Traffic Management Code End

                    //$dataar->LoadType == 2 AND $days <= $dataar->Days AND $dataar->Load_status != 4
                    //     if($dataar->LoadType == 2 AND $days >= $dataar->Days AND $dataar->Load_status != 4){
                    //     } else {

                    $data[] = array(
                        "BookingID" => $dataar->BookingID,
                        "BID" => $dataar->BID,
                        "ConveyanceNo" => $dataar->ConveyanceNo,
                        "BookingType" => $dataar->BookingType,
                        "BookingTypeName" => $BookingTypeName,
                        "BookingDateTime1" => date("d-m-Y H:i", strtotime($dataar->AllocatedDateTime)),
                        "BookingDateTime" => date("d-m-Y H:i", strtotime($dataar->AllocatedDateTime)),
                        "CompanyID" => $dataar->CompanyID,
                        "OpportunityID" => $dataar->OpportunityID,
                        "MaterialID" => $dataar->MaterialID,
                        "MaterialName" => $dataar->MaterialName,
                        "LoadType" => $dataar->LoadType,
                        "LoadTypeName" => $LoadTypeName,
                        "Loads" => $dataar->Loads,
                        "PurchaseOrderNumber" => $dataar->PurchaseOrderNumber,
                        "Price" => $dataar->Price,
                        "ContactID" => $dataar->ContactID,
                        "Email" => $dataar->Email,
                        "Notes" => $dataar->Notes,
                        "BookedBy" => $dataar->BookedBy,
                        "UpdatedBy" => $dataar->UpdatedBy,
                        "ApprovedBy" => $dataar->ApprovedBy,
                        "CreateDateTime" => date("d-m-Y H:i", strtotime($dataar->CreateDateTime)),
                        "UpdateDateTime" => date("d-m-Y H:i", strtotime($dataar->UpdateDateTime)),
                        "Status" => $dataar->Status,
                        "CompanyName" => $dataar->CompanyName,
                        "OpportunityName" => $dataar->OpportunityName,
                        "Street1" => $dataar->Street1,
                        "Street2" => $dataar->Street2,
                        "Town" => $dataar->Town,
                        "County" => $dataar->County,
                        "PostCode" => $dataar->PostCode,
                        "ContactName" => $dataar->ContactName,
                        "LoadID" => $dataar->LoadID,
                        "JobStartDateTime" => $dataar->JobStartDateTime,
                        "JobEndDateTime" => $dataar->JobEndDateTime,
                        "GrossWeight" => $GrossWeight . '',
                        "Tare" => $Tare,
                        "Net" => $Net,
                        "TicketNumber" => $GrossWeightName['TicketNumber'],
                        "TicketPDF" => $TicketPDF,
                        "TipID" => $dataar->TipID,
                        "TipName" => $dataar->TipName,
                        "CustomerName" => $dataar->CustomerName,
                        "Load_status" => $dataar->Load_status,
                        "NewLoadID" => "0",
                        "con_finish" => $con_finish,
                        "tonBook" => $dataar->TonBook,
                        "totalTon" => $dataar->TotalTon,
                        "tonPerLoad" => $dataar->TonPerLoad,
                        "TrafficDocument" => $trafficDocument,
                        "opp_lat" => $dataar->opp_lat,
                        "opp_long" => $dataar->opp_long,
                        "opp_updated_lat" => $dataar->opp_updated_lat,
                        "opp_updated_long" => $dataar->opp_updated_long,
                        "opp_latlong_updated_by" => $dataar->opp_latlong_updated_by,
                        "tip_lat" => $dataar->tip_lat,
                        "tip_long" => $dataar->tip_long,
                        "tip_updated_lat" => $dataar->tip_updated_lat,
                        "tip_updated_long" => $dataar->tip_updated_long,
                        "tip_latlong_updated_by" => $dataar->tip_latlong_updated_by
                    );
                    // }
                }
            } else {
                $status = "0";
                $message = 'Booking data not found';
            }
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function booking_statuschange_post()
    {


        $token = $this->post('token');
        //$DriverID = $this->post('DriverID');
        //$DriverName = $this->post('DriverName');
        //$VehicleRegNo = $this->post('VehicleRegNo');
        $LoadID = $this->post('LoadID');
        $CustomerName = $this->post('CustomerName');
        $Signature = $this->post('Signature');
        $ReceiptName = $this->post('ReceiptName');
        $Load_status = $this->post('Load_status');
        $TipNumber = $this->post('TipNumber');
        $Notes = $this->post('Notes');
        $GrossWeight = $this->post('GrossWeight');
        $MaterialID = $this->post('MaterialID');
        $finish_load_button = $this->post('finish_load_button');
        //Get Locaton
        $LogInLat = $this->post('LogInLat');
        $LogInLong = $this->post('LogInLong');
        $LogInLoc = $this->post('LogInLoc');

        $post_site_in_time = $this->post('post_site_in_time');
        $post_site_out_time = $this->post('post_site_out_time');

        $logData = [
            'driver_id' => $this->post('driver_id'),
            'lorry_no' => $this->post('lorry_no'),
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);

        $TipID = $this->post('TipID');

        $wastedJourney = $this->post('wasted_journey');
        if (isset($wastedJourney) && $wastedJourney == 1) {
            $wastedJourney = true;
        } else {
            $wastedJourney = false;
        }

        $driver_id = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');

        $stampImage = WEB_ROOT_PATH . "assets/stamp/wasted.png";


        $data = [];

        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);
        $this->db->select('LorryNo,RegNumber,Tare,Haulier');
        $this->db->where('LorryNo', $lorry_no);
        $this->db->from('tbl_drivers');
        $query = $this->db->get();
        $result = $query->row_array();
        if (!isset($result['LorryNo']) || empty($result['LorryNo'])) {
        } else {
            $lorry_LorryNo = $user['LorryNo'] = $result['LorryNo'];
            $lorry_RegNumber = $user['RegNumber'] = $result['RegNumber'];
            $lorry_Tare = $user['Tare'] = $result['Tare'];
            $lorry_Haulier = $user['Haulier'] = $result['Haulier'];
        }


        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($driver_id) || empty($DriverID) || empty($LoadID) || empty($Load_status)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } elseif (!isset($result['LorryNo']) || empty($result['LorryNo'])) {
            $status = "0";
            $message = 'Lorry Not Found.';
        } else {

            $DriverName = $user['DriverName'];
            $VehicleRegNo = $lorry_RegNumber;



            $this->db->select(
                'tbl_booking1.*, 
				tbl_booking1.SICCode as Booking_SICCode, 
                tbl_opportunities.OpportunityName, 
                tbl_booking_request.BookingRequestID, tbl_booking_request.CompanyID, 
                tbl_booking_request.CompanyName, 
                tbl_booking_request.OpportunityID, 
                tbl_booking_request.OpportunityName, 
                tbl_booking_request.ContactID, 
                tbl_booking_request.ContactName, 
                tbl_booking_request.ContactMobile, 
                tbl_booking_request.ContactEmail, 
                tbl_booking_request.PurchaseOrderNumber, 
                tbl_booking_request.PriceBy, 
                tbl_booking_request.WaitingTime, 
                tbl_booking_request.WaitingCharge, 
                tbl_booking_request.Notes, 
                tbl_booking_request.SubTotalAmount, 
                tbl_booking_request.VatAmount, 
                tbl_booking_request.PaymentType, 
                tbl_booking_request.PaymentRefNo,
                tbl_booking_request.JourneyTime,
                tbl_materials.SicCode, 
                tbl_opportunities.Street1, 
                IFNULL(tbl_opportunities.Street2, "") as Street2, 
                tbl_opportunities.Town, 
                tbl_opportunities.County, 
                tbl_opportunities.PostCode, 
                tbl_booking_loads1.LoadID, 
                tbl_booking_loads1.LID, 
                tbl_booking_loads1.TicketID, 
                tbl_booking_loads1.TicketUniqueID, 
                tbl_booking_loads1.ConveyanceNo, 
                tbl_booking_loads1.BookingID, 
                tbl_booking_loads1.MaterialID, 
                tbl_booking_loads1.TipID, 
                tbl_booking_loads1.DriverName, 
                tbl_booking_loads1.VehicleRegNo, 
                tbl_booking_loads1.TicketID, 
                tbl_booking_loads1.TicketUniqueID, 
                tbl_booking_loads1.CustomerName, 
                tbl_booking_loads1.Signature as DriverSign, 
                tbl_booking_loads1.Signature as Signature, 
                tbl_booking_loads1.Status as Load_status, 
                tbl_booking_loads1.SiteInDateTime, 
                tbl_booking_loads1.SiteOutDateTime, 
                tbl_booking_loads1.SiteInDateTime2, 
                tbl_booking_loads1.SiteOutDateTime2, 
                tbl_booking_loads1.CustomerName2, 
                tbl_booking_loads1.Signature2 as DriverSign2, 
                tbl_booking_loads1.Signature2 as Signature2, 
                tbl_booking_loads1.BookingDateID'
            );
            $this->db->from('tbl_booking_loads1');
            $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
            $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
            //$this->db->join('tbl_company', 'tbl_booking.CompanyID = tbl_company.CompanyID');
            $this->db->join('tbl_opportunities', 'tbl_booking_request.OpportunityID = tbl_opportunities.OpportunityID');
            $this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID =  tbl_materials.MaterialID');
            $this->db->where('tbl_booking_loads1.LoadID', $LoadID);
            $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {

                $NewLoadID = 0;
                $con_finish = 0;
                $dataarr = $query->result();
                if (!isset($TipID) || empty($TipID)) {
                    $TipID = $dataarr[0]->TipID;
                }
                //echo $dataarr[0]->Email; exit();
                if ($Load_status == 1) {
                    $udateData = array(
                        "DriverName" => $DriverName,
                        "DriverID" => $lorry_no,
                        "DriverLoginID" => $driver_id,
                        "VehicleRegNo" => $VehicleRegNo,
                        "TipNumber" => $TipNumber,
                        "Status" => 1,
                        "JobStartDateTime" => date("Y-m-d H:i:s"),
                        "JobStartLat" => $LogInLat,
                        "JobStartLong" => $LogInLong,
                        "JobStartLoc" => $LogInLoc,
                    );
                    $this->db->where('LoadID', $LoadID);
                    $this->db->update("tbl_booking_loads1", $udateData);
                    $status = "1";
                    $message = 'Status changed successfully';
                } else if ($Load_status == 2) {
                    $net = $GrossWeight - $user['Tare'];
                    /* if($dataarr[0]->BookingType == 2 AND $dataarr[0]->TipID == 2){
                        
                        $this->db->query("update tbl_tickets set GrossWeight = '$GrossWeight',Net = $net where LoadID = '$LoadID'");
                    } */

                    if (isset($post_site_in_time) && !empty($post_site_in_time)) {
                        $post_site_in_time = date("Y-m-d H:i:s", strtotime($post_site_in_time));
                    } else {
                        $post_site_in_time = date("Y-m-d H:i:s");
                    }

                    $udateData = array(
                        "MaterialID" => $MaterialID,
                        "TipID" => $TipID,
                        "TipNumber" => $TipNumber,
                        "GrossWeight" => $GrossWeight,
                        "Tare" => $user['Tare'],
                        "Net" => $net,
                        "Notes1" => $Notes,
                        "Status" => 2,
                        "SiteInDateTime" => $post_site_in_time,
                        "SiteInLat" => $LogInLat,
                        "SiteInLog" => $LogInLong,
                        "SiteInLoc" => $LogInLoc,
                    );
                    $this->db->where('LoadID', $LoadID);
                    $this->db->update("tbl_booking_loads1", $udateData);
                    $status = "1";
                    $message = 'Status changed successfully';
                } else if ($Load_status == 3) {
                    $net = $GrossWeight - $user['Tare'];
                    //echo base_url().'uploads/Signature/'.$dataarr[0]->DriverSign; exit();
                    if (empty($_FILES['Signature']['name']) and ($dataarr[0]->BookingType == 1 || $dataarr[0]->BookingType == 4) and !$wastedJourney) {
                        $status = "0";
                        $message = 'Customer Signature Required';
                    } else {
                        //Unique Code Generate for PDF name
                        $UniqCodeGen = md5(mt_rand(0, 999999) . date("Y-m-d H:i:s"));
                        sleep(2);
                        //Add Ticket Table
                        $BookingID = $dataarr[0]->BookingID;
                        $Booking = $this->Booking1_API_Model->GetBookingInfo($BookingID);
                        $TicketUniqueID = $this->Ticket_API_Model->generateRandomString();
                        $LastTicketNumber = $this->Ticket_API_Model->LastTicketNo();
                        if ($LastTicketNumber) {
                            $TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
                        } else {
                            $TicketNumber = 1;
                        }


                        if ($dataarr[0]->BookingType == 3) {
                            $ticketsInfo = array(
                                'TicketUniqueID' => $TicketUniqueID,
                                'LoadID' => $LoadID,
                                'TicketNumber' => $TicketNumber,
                                'TicketDate' => date('Y-m-d H:i:s'),
                                'Conveyance' => $dataarr[0]->ConveyanceNo,
                                'OpportunityID' => $Booking->OpportunityID,
                                'CompanyID' => $Booking->CompanyID,
                                'DriverName' => $user['DriverName'],
                                'RegNumber' => $user['RegNumber'],
                                'Hulller' => $user['Haulier'],
                                'Tare' => $user['Tare'],
                                'driver_id' => $user['LorryNo'],
                                'DriverLoginID' => $user['DriverID'],
                                'MaterialID' => $MaterialID,
                                'SicCode' => $Booking->Booking_SICCode,
                                'CreateUserID' => 1,
                                'CreateDate' => date('Y-m-d H:i:s'),
                                'TypeOfTicket' => 'In',
                                'IsInBound' => 0,
                                'is_tml' => 1,
                                'pdf_name' => $TicketUniqueID . '.pdf',
                                'created_by' => "app1"
                            );
                            $TicketID = $this->Ticket_API_Model->insert('tbl_tickets', $ticketsInfo);

                        } elseif ($dataarr[0]->BookingType == 1) {

                            if ($TipID == 1) {
                                $IsInBoundC = 1;
                                sleep(2);
                                $this->db->select('TicketNo,TypeOfTicket');
                                $this->db->from('tbl_tickets');
                                $this->db->where('tbl_tickets.Conveyance', $dataarr[0]->ConveyanceNo);
                                $this->db->where('tbl_tickets.LoadID <> 0 ');
                                $this->db->where('tbl_tickets.is_tml', 1);
                                $this->db->where('tbl_tickets.TypeOfTicket', "In");
                                $queryss = $this->db->get();
                                $dataarrss = $queryss->result();
                                if (($queryss->num_rows() > 0) && !empty($dataarr[0]->ConveyanceNo)) {
                                    $TicketID = $dataarrss[0]->TicketNo;
                                } else {
                                    $ticketsInfo = array(
                                        'TicketUniqueID' => $TicketUniqueID,
                                        'LoadID' => $LoadID,
                                        'TicketNumber' => $TicketNumber,
                                        'TicketDate' => date('Y-m-d H:i:s'),
                                        'Conveyance' => $dataarr[0]->ConveyanceNo,
                                        'OpportunityID' => $Booking->OpportunityID,
                                        'CompanyID' => $Booking->CompanyID,
                                        'DriverName' => $user['DriverName'],
                                        'RegNumber' => $user['RegNumber'],
                                        'Hulller' => $user['Haulier'],
                                        'Tare' => $user['Tare'],
                                        'driver_id' => $user['LorryNo'],
                                        'DriverLoginID' => $user['DriverID'],
                                        'MaterialID' => $MaterialID,
                                        'SicCode' => $Booking->Booking_SICCode,
                                        'CreateUserID' => 1,
                                        'CreateDate' => date('Y-m-d H:i:s'),
                                        'TypeOfTicket' => 'In',
                                        'IsInBound' => $IsInBoundC,
                                        'is_tml' => 1,
                                        'pdf_name' => $TicketUniqueID . '.pdf',
                                        'created_by' => "app2"
                                    );

                                    $TicketID = $this->Ticket_API_Model->insert('tbl_tickets', $ticketsInfo);
                                }
                            }
                        } else {
                            if ($TipID == 1) {
                                $TickIDQRY = $this->db->query("select TicketNo from  tbl_tickets where LoadID = '$LoadID'");
                                $TickIDQRY = $TickIDQRY->row_array();
                                if (count($TickIDQRY) > 0) {
                                    $ticketId = $TickIDQRY['TicketNo'];
                                    $TicketID = $TickIDQRY['TicketNo'];
                                } else {
                                    $TicketID = '0';
                                }
                            } else {
                                $TicketID = '0';
                            }
                        }

                        //echo $TicketID;
                        //exit();

                        //Singnature
                        $config['upload_path'] = './uploads/Signature/';
                        $config['allowed_types'] = 'gif|jpg|png';
                        $config['encrypt_name'] = TRUE;
                        $config['overwrite'] = FALSE;
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('Signature')) {
                            $SignatureUpload = '';
                            $SignatureUploadfile_name = '';
                        } else {
                            $SignatureUpload = $this->upload->data();
                            $SignatureUploadfile_name = $SignatureUpload['file_name'];
                        }

                        //GET Material name //
                        $MaterialnameQRY = $this->db->query("select MaterialName,SicCode from tbl_materials where MaterialID = '$MaterialID'");
                        $MaterialnameQRY = $MaterialnameQRY->row_array();
                        //PDF GEN


                        $PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
                        $PDFContent = $PDFContentQRY->result();

                        //TIP Address //
                        if (isset($TipID) && !empty($TipID)) {
                            $tTIPID = $TipID;
                        } else {
                            $tTIPID = $dataarr[0]->TipID;
                        }

                        $tipadQRY = $this->db->query("select TipName,Street1,Street2,Town,County,PostCode,PermitRefNo from tbl_tipaddress where TipID = '$TipID'");
                        $tipadQRY = $tipadQRY->row_array();

                        $siteOutDateTimeInDB = date("Y-m-d H:i:s");
                        if ($dataarr[0]->BookingType == 3) {
                            if (isset($post_site_out_time) && !empty($post_site_out_time)) {
                                $siteOutDateTimeInDB = date("Y-m-d H:i:s", strtotime($post_site_out_time));
                            } else {
                                $siteOutDateTimeInDB = date("Y-m-d H:i:s");
                            }

                            if (isset($post_site_in_time) && !empty($post_site_in_time)) {
                                $siteInDateTimeInDB = date("Y-m-d H:i:s", strtotime($post_site_in_time));
                            } else {
                                $siteInDateTimeInDB = date("Y-m-d H:i:s");
                            }
                            $dataarr[0]->SiteInDateTime = $siteInDateTimeInDB;
                        }




                        $dataarr[0]->SiteOutDateTime = $siteOutDateTimeInDB;
                        $dataarr[0]->SiteOutDateTime2 = $siteOutDateTimeInDB;




                        $siteInDateTime = $siteOutDateTime = '';
                        if (isset($dataarr[0]->SiteInDateTime) && !empty($dataarr[0]->SiteInDateTime)) {
                            $siteInDateTime = '<b>In Time: </b>' . date("d-m-Y H:i", strtotime($dataarr[0]->SiteInDateTime)) . ' <br>';
                        } else {
                            $siteInDateTime = "In Time: Time Not Found <br>";
                        }
                        if (isset($dataarr[0]->SiteOutDateTime) && !empty($dataarr[0]->SiteOutDateTime)) {
                            $siteOutDateTime = '<b>Out Time: </b>' . date("d-m-Y H:i", strtotime($dataarr[0]->SiteOutDateTime)) . ' <br>';
                        } else {
                            $siteOutDateTime = "Out Time: Time Not Found <br>";
                        }

                        $siteInDateTime2 = $siteOutDateTime2 = '';
                        if (isset($dataarr[0]->SiteInDateTime2) && !empty($dataarr[0]->SiteInDateTime2)) {
                            $siteInDateTime2 = '<b>In Time: </b>' . date("d-m-Y H:i", strtotime($dataarr[0]->SiteInDateTime2)) . ' <br>';
                        } else {
                            $siteInDateTime2 = "In Time: Time Not Found <br>";
                        }
                        if (isset($dataarr[0]->SiteOutDateTime2) && !empty($dataarr[0]->SiteOutDateTime2)) {
                            $siteOutDateTime2 = '<b>Out Time: </b>' . date("d-m-Y H:i", strtotime($dataarr[0]->SiteOutDateTime2)) . ' <br>';
                        } else {
                            $siteOutDateTime2 = "Out Time: Time Not Found <br>";
                        }



                        $LT = '';
                        /* if ($dataarr[0]->LorryType == 1) {
                            $LT = 'Tipper';
                        } else if ($dataarr[0]->LorryType == 2) {
                            $LT = 'Grab';
                        } else if ($dataarr[0]->LorryType == 3) {
                            $LT = 'Bin';
                        } else {
                            $LT = '';
                        } */
                        $lorryType = $dataarr[0]->LorryType;
                        if ($lorryType == 1 || $lorryType == "1") {
                            $lorryType = "Tipper";
                        } elseif ($lorryType == 2 || $lorryType == "2") {
                            $lorryType = "Grab";
                        } elseif ($lorryType == 3 || $lorryType == "3") {
                            $lorryType = "Bin";
                        }

                        $tonBook = $dataarr[0]->TonBook;
                        if ($tonBook == 1 || $tonBook == "1") {
                            $tonBook = "Tonnage";
                        } elseif ($tonBook == 0 || $tonBook == "0") {
                            $tonBook = "Load";
                        } else {
                            $tonBook = "Load";
                        }
                        $dayWorkType = '';
                        if ($dataarr[0]->BookingType == 3) {
                            if ($dataarr[0]->DayWorkType == 1) {
                                $dayWorkType = 'Day';
                            } elseif ($dataarr[0]->DayWorkType == 2) {
                                $dayWorkType = 'Night';
                            } elseif ($dataarr[0]->DayWorkType == 3) {
                                $dayWorkType = 'Hourly';
                            }
                        }


                        //Daywork
                        if ($dataarr[0]->BookingType == 3) {
                            $journeyTime = $dataarr[0]->JourneyTime;
                            $journeyTime = explode(":", $journeyTime);
                            if (!isset($journeyTime[1])) {
                                $journeyTime[1] = 0;
                            }
                            if ($wastedJourney) {
                                $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
                                <div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
                                    <div style="width:100%; " >
                                        <div style="width:35%;float: left;" > 		
                                            <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
                                        </div>
                                        <div style="width:65%;float: right;text-align: right;" > 		 
                                            <b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
                                            ' . $PDFContent[0]->address . ' <br/> 
                                            <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
                                        </div>
                                    </div>	
                                    <div style="width:100%;float: left;" >   
                                        <b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
                                        <b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
                                        <b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
                                        <b>' . $PDFContent[0]->head1 . '</b><br/> <br>
                                        <b>' . $PDFContent[0]->head2 . '</b><br/> <br>
                                        <div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
                                        <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>		
                                        <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                        ' . $siteInDateTime . '
                                        ' . $siteOutDateTime . '
                                        <b>Journey Time: </b> ' . $journeyTime[0] . ' Hours ' . $journeyTime[1] . ' Minutes <br>	
                                        <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		
                                        <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . '<br>		
                                        <b>Permit Reference No: </b>' . $tipadQRY['PermitRefNo'] . ' <br/>
                                        <b>Material:  </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $dayWorkType . ' <br> 
                                        <b>SicCode: </b> ' . $dataarr[0]->Booking_SICCode . '   <br>  
                                        <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . '  <br> 
                                        <b>Lorry Type </b> ' . $lorryType . '  <br> 
                                        <b>Driver Name: </b> ' . $user['DriverName'] . '<br> <br/>   
                                    </div>
                                    <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>  <br> 
                                    <div style="width:100%;float: left;" >
                                        <div style="font-size: 9px;"> 
                                            <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
                                            <b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
                                            ' . $PDFContent[0]->FooterText . '  
                                        </div>
                                    </div>  
                                </div></body></html>';
                                //<img src="'.$user['ltsignature'].'" width ="100" height="40" style="float:left">

                                $pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $UniqCodeGen . ".pdf";

                                $mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);

                                $mpdf->SetWatermarkImage($stampImage);
                                $mpdf->showWatermarkImage = true;
                                $mpdf->watermarkImgBehind = false;
                                $mpdf->watermarkImageAlpha = 0.7;

                                //$mpdf->_setPageSize(array(70,180),'P');
                                //$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
                                //$mpdf->AddPage();

                                $mpdf->keep_table_proportions = false;
                                $mpdf->WriteHTML($html);
                                $mpdf->Output($pdfFilePath);
                                //END PDF GEN 
                            } else {
                                $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
                                <div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
                                    <div style="width:100%; " >
                                        <div style="width:35%;float: left;" > 		
                                            <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
                                        </div>
                                        <div style="width:65%;float: right;text-align: right;" > 		 
                                            <b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
                                            ' . $PDFContent[0]->address . ' <br/> 
                                            <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
                                        </div>
                                    </div>	
                                    <div style="width:100%;float: left;" >   
                                        <b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
                                        <b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
                                        <b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
                                        <b>' . $PDFContent[0]->head1 . '</b><br/> <br>
                                        <b>' . $PDFContent[0]->head2 . '</b><br/> <br>
                                        <div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
                                        <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>		
                                        <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                        ' . $siteInDateTime . '
                                        ' . $siteOutDateTime . '
                                        <b>Journey Time: </b> ' . $journeyTime[0] . ' Hours ' . $journeyTime[1] . ' Minutes <br>	
                                        <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		
                                        <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . '<br>		
                                        <b>Permit Reference No: </b>' . $tipadQRY['PermitRefNo'] . ' <br/>
                                        <b>Material:  </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $dayWorkType . ' <br> 
                                        <b>SicCode: </b> ' . $dataarr[0]->Booking_SICCode . '  <br>  
                                        <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . '  <br> 
                                        <b>Lorry Type </b> ' . $lorryType . '  <br> 
                                        <b>Driver Name: </b> ' . $user['DriverName'] . '<br> <br/>   
                                    </div>
                                    <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>  <br> 
                                    <div style="width:100%;float: left;" >
                                        <b>Produced By: </b><br>
                                        <div><img src="/uploads/Signature/' . $SignatureUploadfile_name . '" width ="100" height="40" style="float:left"></div>
                                        ' . $CustomerName . '<br><br>
                                        <div style="font-size: 9px;"> 
                                            <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
                                            <b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
                                            ' . $PDFContent[0]->FooterText . '  
                                        </div>
                                    </div>  
                                </div></body></html>';
                                //<img src="'.$user['ltsignature'].'" width ="100" height="40" style="float:left">

                                $pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $UniqCodeGen . ".pdf";

                                $mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
                                //$mpdf->_setPageSize(array(70,180),'P');
                                //$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
                                //$mpdf->AddPage();
                                $mpdf->keep_table_proportions = false;
                                $mpdf->WriteHTML($html);
                                $mpdf->Output($pdfFilePath);
                                //END PDF GEN 
                            }
                        }

                        // only Haulage
                        if ($dataarr[0]->BookingType == 4) {
                            $tipadQRYForHau = $this->db->query("select TipName,Street1,Street2,Town,County,PostCode,PermitRefNo from tbl_tipaddress where TipID = '$TipID'");
                            $tipadQRYForHau = $tipadQRYForHau->row_array();

                            $haulageAddress = '';
                            if ($TipID == 1) {
                                // Combine address fields
                                $haulageAddress = $tipadQRYForHau['Street1'] . ' ' . $tipadQRYForHau['Street2'] . ' ' . $tipadQRYForHau['Town'] . ' ' . $tipadQRYForHau['County'] . ' ' . $tipadQRYForHau['PostCode'];
                            } else {
                                // Show TipName
                                $haulageAddress = $tipadQRYForHau['TipName'];
                            }

                            if ($wastedJourney) {
                                $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
                                <div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
                                    <div style="width:100%; " >
                                        <div style="width:35%;float: left;" > 		
                                            <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
                                        </div>
                                        <div style="width:65%;float: right;text-align: right;" > 		 
                                            <b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
                                            ' . $PDFContent[0]->address . ' <br/> 
                                            <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
                                        </div>
                                    </div>	
                                    <div style="width:100%;float: left;" >   
                                        <b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
                                        <b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
                                        <b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
                                        <b>' . $PDFContent[0]->head1 . '</b><br/> <br>
                                        <b>' . $PDFContent[0]->head2 . '</b><br/> <br>
                                        <div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
                                        <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>		
                                        <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                        ' . $siteInDateTime . '
                                        ' . $siteOutDateTime . '
                                        <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>			
                                        <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . '<br>		 		 		
                                        <b>Haulage Address: </b> ' . $haulageAddress . '<br>   	
                                        <b>Permit Reference No: </b>' . $tipadQRY['PermitRefNo'] . ' <br/>
                                        <b>Material:  </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $LT . ' Collected ' . $lorryType . ' ' . $tonBook . ' <br> 
                                        <b>SicCode: </b> ' . $dataarr[0]->Booking_SICCode . '   <br>  
                                        <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . '  <br> 
                                        <b>Driver Name: </b> ' . $user['DriverName'] . '<br> <br/>   
                                    </div>
                                    <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>  <br> 
                                    <div style="width:100%;float: left;" >
                                        <div style="font-size: 9px;"> 
                                            <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
                                            <b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
                                            ' . $PDFContent[0]->FooterText . '  
                                        </div>
                                    </div>  
                                </div></body></html>';
                                //<img src="'.$user['ltsignature'].'" width ="100" height="40" style="float:left">

                                $pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $UniqCodeGen . ".pdf";

                                $mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);

                                $mpdf->SetWatermarkImage($stampImage);
                                $mpdf->showWatermarkImage = true;
                                $mpdf->watermarkImgBehind = false;
                                $mpdf->watermarkImageAlpha = 0.7;

                                //$mpdf->_setPageSize(array(70,180),'P');
                                //$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
                                //$mpdf->AddPage();

                                $mpdf->keep_table_proportions = false;
                                $mpdf->WriteHTML($html);
                                $mpdf->Output($pdfFilePath);
                                //END PDF GEN 
                            } else {
                                $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
                                <div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
                                    <div style="width:100%; " >
                                        <div style="width:35%;float: left;" > 		
                                            <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
                                        </div>
                                        <div style="width:65%;float: right;text-align: right;" > 		 
                                            <b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
                                            ' . $PDFContent[0]->address . ' <br/> 
                                            <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
                                        </div>
                                    </div>	
                                    <div style="width:100%;float: left;" >   
                                        <b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
                                        <b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
                                        <b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
                                        <b>' . $PDFContent[0]->head1 . '</b><br/> <br>
                                        <b>' . $PDFContent[0]->head2 . '</b><br/> <br>
                                        <div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
                                        <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>		
                                        <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                        ' . $siteInDateTime . '
                                        ' . $siteOutDateTime . '
                                        <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		
                                        <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . '<br>		 			
                                        <b>Haulage Address: </b> ' . $haulageAddress . '<br>   	
                                        <b>Permit Reference No: </b>' . $tipadQRY['PermitRefNo'] . ' <br/>
                                        <b>Material:  </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $LT . ' Collected ' . $lorryType . ' ' . $tonBook . ' <br> 
                                        <b>SicCode: </b> ' . $dataarr[0]->Booking_SICCode . '  <br>  
                                        <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . '  <br> 
                                        <b>Driver Name: </b> ' . $user['DriverName'] . '<br> <br/>   
                                    </div>
                                    <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>  <br> 
                                    <div style="width:100%;float: left;" >
                                        <b>Produced By: </b><br>
                                        <div><img src="/uploads/Signature/' . $SignatureUploadfile_name . '" width ="100" height="40" style="float:left"></div>
                                        ' . $CustomerName . '<br><br>
                                        <div style="font-size: 9px;"> 
                                            <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
                                            <b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
                                            ' . $PDFContent[0]->FooterText . '  
                                        </div>
                                    </div>  
                                </div></body></html>';
                                //<img src="'.$user['ltsignature'].'" width ="100" height="40" style="float:left">


                                $pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $UniqCodeGen . ".pdf";

                                $mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
                                //$mpdf->_setPageSize(array(70,180),'P');
                                //$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
                                //$mpdf->AddPage();
                                $mpdf->keep_table_proportions = false;
                                $mpdf->WriteHTML($html);
                                $mpdf->Output($pdfFilePath);
                                //END PDF GEN 
                            }
                        }

                        // only collection
                        if ($dataarr[0]->BookingType == 1) {

                            if ($wastedJourney) {
                                $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
                                <div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
                                    <div style="width:100%; " >
                                        <div style="width:35%;float: left;" > 		
                                            <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
                                        </div>
                                        <div style="width:65%;float: right;text-align: right;" > 		 
                                            <b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
                                            ' . $PDFContent[0]->address . ' <br/> 
                                            <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
                                        </div>
                                    </div>	
                                    <div style="width:100%;float: left;" >   
                                        <b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
                                        <b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
                                        <b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
                                        <b>' . $PDFContent[0]->head1 . '</b><br/> <br>
                                        <b>' . $PDFContent[0]->head2 . '</b><br/> <br>
                                        <div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
                                        <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>		
                                        <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                        ' . $siteInDateTime . '
                                        ' . $siteOutDateTime . '
                                        <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		
                                        <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . '<br>		 		
                                        <b>Tip Address: </b> ' . $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'] . '<br>	
                                        <b>Permit Reference No: </b>' . $tipadQRY['PermitRefNo'] . ' <br/>
                                        <b>Material:  </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $LT . ' Collected ' . $lorryType . ' ' . $tonBook . ' <br> 
                                        <b>SicCode: </b> ' . $dataarr[0]->Booking_SICCode . '   <br>  
                                        <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . '  <br> 
                                        <b>Driver Name: </b> ' . $user['DriverName'] . '<br> <br/>   
                                    </div>
                                    <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>  <br> 

                                    <div style="width:100%;float: left;" >
                                        <div style="font-size: 9px;"> 
                                            <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
                                            <b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
                                            ' . $PDFContent[0]->FooterText . '  
                                        </div>
                                    </div>  
                                </div></body></html>';
                                //<img src="'.$user['ltsignature'].'" width ="100" height="40" style="float:left">

                                $pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $UniqCodeGen . ".pdf";

                                $mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);

                                $mpdf->SetWatermarkImage($stampImage);
                                $mpdf->showWatermarkImage = true;
                                $mpdf->watermarkImgBehind = false;
                                $mpdf->watermarkImageAlpha = 0.7;

                                //$mpdf->_setPageSize(array(70,180),'P');
                                //$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
                                //$mpdf->AddPage();

                                $mpdf->keep_table_proportions = false;
                                $mpdf->WriteHTML($html);
                                $mpdf->Output($pdfFilePath);
                                //END PDF GEN 
                            } else {
                                $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
                                <div style="width:100%;margin-bottom: 0px;margin-top: 0px;font-size: 10px;" >	
                                    <div style="width:100%; " >
                                        <div style="width:35%;float: left;" > 		
                                            <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80"> 
                                        </div>
                                        <div style="width:65%;float: right;text-align: right;" > 		 
                                            <b>' . $PDFContent[0]->outpdf_title . '</b><br/> 		
                                            ' . $PDFContent[0]->address . ' <br/> 
                                            <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . ' 											
                                        </div>
                                    </div>	
                                    <div style="width:100%;float: left;" >   
                                        <b>Email:</b> ' . $PDFContent[0]->email . ' <br/>		
                                        <b>Web:</b> ' . $PDFContent[0]->website . ' <br/>		  
                                        <b>Waste License No: </b>' . $PDFContent[0]->waste_licence . ' <br/> <hr>
                                        <b>' . $PDFContent[0]->head1 . '</b><br/> <br>
                                        <b>' . $PDFContent[0]->head2 . '</b><br/> <br>
                                        <div style="text-align: center;"><b>CONVEYANCE NOTE </b> </div><br>
                                        <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>		
                                        <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                        ' . $siteInDateTime . '
                                        ' . $siteOutDateTime . '
                                        <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		
                                        <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . '<br>		 		
                                        <b>Tip Address: </b> ' . $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'] . '<br>		
                                        <b>Permit Reference No: </b>' . $tipadQRY['PermitRefNo'] . ' <br/>
                                        <b>Material:  </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $LT . ' Collected ' . $lorryType . ' ' . $tonBook . ' <br> 
                                        <b>SicCode: </b> ' . $dataarr[0]->Booking_SICCode . '  <br>  
                                        <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . '  <br> 
                                        <b>Driver Name: </b> ' . $user['DriverName'] . '<br> <br/>   
                                    </div>
                                    <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>  <br> 
                                    <div style="width:100%;float: left;" >
                                        <b>Produced By: </b><br>
                                        <div><img src="/uploads/Signature/' . $SignatureUploadfile_name . '" width ="100" height="40" style="float:left"></div>
                                        ' . $CustomerName . '<br><br>
                                        <div style="font-size: 9px;"> 
                                            <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . ' <br>
                                            <b>Company Reg. No: </b> ' . $PDFContent[0]->CompanyRegNo . ' <br>  
                                            ' . $PDFContent[0]->FooterText . '  
                                        </div>
                                    </div>  
                                </div></body></html>';
                                //<img src="'.$user['ltsignature'].'" width ="100" height="40" style="float:left">

                                $pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $UniqCodeGen . ".pdf";

                                $mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
                                //$mpdf->_setPageSize(array(70,180),'P');
                                //$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
                                //$mpdf->AddPage();
                                $mpdf->keep_table_proportions = false;
                                $mpdf->WriteHTML($html);
                                $mpdf->Output($pdfFilePath);
                                //END PDF GEN 
                            }
                        }
                        //PDF GEN //
                        $TicketUniqueID = $dataarr[0]->TicketUniqueID;

                        if ($dataarr[0]->BookingType == 2) {
                            if ($wastedJourney) {
                                if ($TipID == 1) {
                                    $data1['tickets'] = $this->Ticket_API_Model->get_pdf_data_app($ticketId);

                                    $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
                                    <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                                        <div style="width:100%;" ><div style="width:35%;float: left;" >
                                        <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
                                            <div style="width:65%;float: right;text-align: right;" > 		  
                                                <b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
                                                <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
                                            </div> 
                                        </div>	 
                                        <div style="width:100%;float: left;" >    
                                            <b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
                                            <b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
                                            <b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
                                            <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
                                            <b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>
                                            <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>
                                            <b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>	
                                            ' . $siteInDateTime . '
                                            ' . $siteOutDateTime . '
                                            <b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
                                            <b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
                                            <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                                            <b>Driver Signature: </b> <br> 
                                            <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                                            <b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
                                            <b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
                                            <b>Tip Address: </b> ' . $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'] . '<br>
                                            <b>Material:  </b>' . $data1['tickets']['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . ' <br> 
                                            <b>SIC Code: </b> ' . $data1['tickets']['SicCode'] . ' <br> 
                                            <b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>
                                            <b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
                                            <b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
                                            <p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
                                            ' . $PDFContent[0]->outpdf_para2 . '<br>  
                                            <b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
                                        <div style="width:100%;float: left;" > 
                                            <p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
                                                <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
                                                <b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
                                                ' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

                                    $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $UniqCodeGen . ".pdf";
                                    $mpdf = new mPDF('utf-8', array(70, 250), '', '', 5, 5, 5, 5, 5, 5);
                                    $mpdf->SetWatermarkImage($stampImage);
                                    $mpdf->showWatermarkImage = true;
                                    $mpdf->watermarkImgBehind = false;
                                    $mpdf->watermarkImageAlpha = 0.7;
                                    $mpdf->keep_table_proportions = false;
                                    $mpdf->WriteHTML($html);
                                    $mpdf->Output($pdfFilePath);
                                } else {
                                    $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
                                    <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                                        <div style="width:100%;" ><div style="width:35%;float: left;" >
                                        <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
                                            <div style="width:65%;float: right;text-align: right;" > 		  
                                                <b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
                                                <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
                                            </div> 
                                        </div>	 
                                        <div style="width:100%;float: left;" >    
                                            <b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
                                            <b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
                                            <b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
                                            <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
                                            <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                            ' . $siteInDateTime . '
                                            ' . $siteOutDateTime . '
                                            <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>
                                            <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . ' <br> 
                                            <b>Haulier: </b> ' . $user['Haulier'] . ' <br> 
                                            <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                                            <b>Driver Signature: </b> <br> 
                                            <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                                            <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		 
                                            <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . ' <br>	 
                                            <b>Tip Address: </b> ' . $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'] . '<br>
                                            <b>Material:   </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . '<br> 
                                            <b>SIC Code: </b> ' . $dataarr[0]->Booking_SICCode . '  <br> 
                                            <b>Gross Weight: </b> ' . round($GrossWeight) . ' KGs<br>	
                                            <b>Tare Weight: </b> ' . round($user['Tare']) . ' KGs <br>		 
                                            <b>Net Weight: </b> ' . round($GrossWeight - $user['Tare']) . ' KGs <br> 
                                            <p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
                                            ' . $PDFContent[0]->outpdf_para2 . '<br>  
                                            <b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
                                        <div style="width:100%;float: left;" > 
                                            <p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
                                                <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
                                                <b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
                                                ' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

                                    $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $UniqCodeGen . ".pdf";
                                    $mpdf = new mPDF('utf-8', array(70, 250), '', '', 5, 5, 5, 5, 5, 5);
                                    $mpdf->SetWatermarkImage($stampImage);
                                    $mpdf->showWatermarkImage = true;
                                    $mpdf->watermarkImgBehind = false;
                                    $mpdf->watermarkImageAlpha = 0.7;
                                    $mpdf->keep_table_proportions = false;
                                    $mpdf->WriteHTML($html);
                                    $mpdf->Output($pdfFilePath);
                                }
                            } else {
                                if ($TipID == 1) {
                                    $data1['tickets'] = $this->Ticket_API_Model->get_pdf_data_app($ticketId);

                                    $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
                                    <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                                        <div style="width:100%;" ><div style="width:35%;float: left;" >
                                        <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
                                            <div style="width:65%;float: right;text-align: right;" > 		  
                                                <b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
                                                <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
                                            </div> 
                                        </div>	 
                                        <div style="width:100%;float: left;" >    
                                            <b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
                                            <b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
                                            <b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
                                            <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>
                                            <b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>	
                                            <b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>	
                                            ' . $siteInDateTime . '
                                            ' . $siteOutDateTime . '
                                            <b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
                                            <b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
                                            <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                                            <b>Driver Signature: </b> <br> 
                                            <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                                            <b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
                                            <b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
                                            <b>Tip Address: </b> ' . $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'] . '<br>
                                            <b>Material:  </b>' . $data1['tickets']['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . ' <br> 
                                            <b>SIC Code: </b> ' . $data1['tickets']['SicCode'] . ' <br> 
                                            <b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>
                                            <b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
                                            <b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
                                            <p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
                                            ' . $PDFContent[0]->outpdf_para2 . '<br>  
                                            <b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
                                        <div style="width:100%;float: left;" > 
                                            <b>Received By: </b><br> 
                                            <div><img src="/uploads/Signature/' . $SignatureUploadfile_name . '" width ="100" height="40" style="float:left"></div> 
                                            ' . $CustomerName . ' 
                                            <p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
                                                <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
                                                <b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
                                                ' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

                                    $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $UniqCodeGen . ".pdf";
                                    $mpdf = new mPDF('utf-8', array(70, 220), '', '', 5, 5, 5, 5, 5, 5);
                                    $mpdf->keep_table_proportions = false;
                                    $mpdf->WriteHTML($html);
                                    $mpdf->Output($pdfFilePath);
                                } else {
                                    $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
                                    <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                                        <div style="width:100%;" ><div style="width:35%;float: left;" >
                                        <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
                                            <div style="width:65%;float: right;text-align: right;" > 		  
                                                <b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
                                                <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
                                            </div> 
                                        </div>	 
                                        <div style="width:100%;float: left;" >    
                                            <b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
                                            <b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
                                            <b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
                                            <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>
                                            <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                            ' . $siteInDateTime . '
                                            ' . $siteOutDateTime . '
                                            <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>	 
                                            <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . ' <br> 
                                            <b>Haulier: </b> ' . $user['Haulier'] . ' <br> 
                                            <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                                            <b>Driver Signature: </b> <br> 
                                            <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                                            <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		 
                                            <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . ' <br>	 
                                            <b>Tip Address: </b> ' . $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'] . '<br>
                                            <b>Material:  </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . ' <br> 
                                            <b>SIC Code: </b> ' . $dataarr[0]->Booking_SICCode . '  <br> 
                                            <b>Gross Weight: </b> ' . round($GrossWeight) . ' KGs<br>	
                                            <b>Tare Weight: </b> ' . round($user['Tare']) . ' KGs <br>		 
                                            <b>Net Weight: </b> ' . round($GrossWeight - $user['Tare']) . ' KGs <br> 
                                            <p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
                                            ' . $PDFContent[0]->outpdf_para2 . '<br>  
                                            <b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
                                        <div style="width:100%;float: left;" > 
                                            <b>Received By: </b><br> 
                                            <div><img src="/uploads/Signature/' . $SignatureUploadfile_name . '" width ="100" height="40" style="float:left"></div> 
                                            ' . $CustomerName . ' 
                                            <p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
                                                <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
                                                <b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
                                                ' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

                                    $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $UniqCodeGen . ".pdf";
                                    $mpdf = new mPDF('utf-8', array(70, 250), '', '', 5, 5, 5, 5, 5, 5);
                                    $mpdf->keep_table_proportions = false;
                                    $mpdf->WriteHTML($html);
                                    $mpdf->Output($pdfFilePath);
                                }
                            }
                        }
                        //$pdf_nameG = $TicketUniqueID.'.pdf'; 
                        $pdf_nameG = $UniqCodeGen . '.pdf';
                        $net = $GrossWeight - $user['Tare'];
                        if ($dataarr[0]->BookingType == 2) {
                            if ($TipID == 1) {
                                $TickIDQRY = $this->db->query("select TicketNo from  tbl_tickets where LoadID = '$LoadID'");
                                $TickIDQRY = $TickIDQRY->row_array();
                                $ticketId = $TickIDQRY['TicketNo'];
                                $this->db->query("update tbl_tickets set is_hold = '0',pdf_name = '$pdf_nameG' where LoadID = '$LoadID'");
                            } else if ($TipID >= 2) {

                                $ticketId = $TicketID = '';
                            }
                        } elseif ($dataarr[0]->BookingType == 3) {
                            $pdf_nameG = $TicketUniqueID . '.pdf';
                            $this->db->query("update tbl_tickets set GrossWeight = '$GrossWeight', pdf_name = '$pdf_nameG' where LoadID = '$LoadID'");
                        } else {
                            $pdf_nameG = $TicketUniqueID . '.pdf';
                            if ($TipID == 1) {
                                $this->db->query("update tbl_tickets set GrossWeight = '$GrossWeight', pdf_name = '$pdf_nameG' where LoadID = '$LoadID'");
                            }
                        }

                        $udateData = array(
                            "TicketID" => $TicketID,
                            "TicketUniqueID" => $TicketUniqueID,
                            "MaterialID" => $MaterialID,
                            "TipID" => $TipID,
                            "CustomerName" => $CustomerName,
                            "Signature" => $SignatureUploadfile_name,
                            "ReceiptName" => $UniqCodeGen . '.pdf',
                            "TipNumber" => $TipNumber,
                            "GrossWeight" => $GrossWeight,
                            "Tare" => $user['Tare'],
                            "Net" => $net,
                            "Notes2" => $Notes,
                            "Status" => 3,
                            //"SiteOutDateTime" => date("Y-m-d H:i:s"),
                            //"SiteInDateTime" => $siteInDateTimeInDB,
                            "SiteOutDateTime" => $siteOutDateTimeInDB,
                            "SiteOutLat" => $LogInLat,
                            "SiteOutLong" => $LogInLong,
                            "SiteOutLoc" => $LogInLoc,
                        );
                        if (isset($siteInDateTimeInDB) && !empty($siteInDateTimeInDB)) {
                            $udateData['SiteInDateTime'] = $siteInDateTimeInDB;
                        }
                        $this->db->where('LoadID', $LoadID);
                        $this->db->update("tbl_booking_loads1", $udateData);


                        $status = "1";
                        $message = 'Receipt has been generated Successfully';
                    }
                } else if ($Load_status == 4) {
                    if ($dataarr[0]->BookingType == 1 and $TipID >= 2) {
                        $net = $GrossWeight - $user['Tare'];
                        //$this->db->query("update tbl_tickets set GrossWeight = '$GrossWeight',Net = $net where LoadID = '$LoadID'");
                    }
                    if ($TipID == 1) {
                        $TickIDQRY = $this->db->query("select TicketNo from  tbl_tickets where LoadID = '$LoadID'");
                        $TickIDQRY = $TickIDQRY->row_array();
                        $ticketId = $TickIDQRY['TicketNo'];
                    } else if ($TipID >= 2) {
                        $ticketId = $dataarr[0]->TicketID;
                    }


                    if ($wastedJourney) {
                        $updateStatus = 6;
                    } else {
                        $updateStatus = 4;
                    }

                    if ($dataarr[0]->BookingType == 1 and $TipID != 1) {
                        $net = $GrossWeight - $user['Tare'];
                        $udateData = array(
                            "TipNumber" => $TipNumber,
                            "CustomerName" => $CustomerName,
                            "GrossWeight" => $GrossWeight . '',
                            "Tare" => $user['Tare'],
                            "Net" => $net,
                            "Notes" => $Notes,
                            "Status" => $updateStatus,
                            "JobEndDateTime" => date("Y-m-d H:i:s"),
                            "JobEndLat" => $LogInLat,
                            "JobEndLong" => $LogInLong,
                            "JobEndLoc" => $LogInLoc,
                        );
                    } else {
                        $udateData = array(
                            "TipNumber" => $TipNumber,
                            "CustomerName" => $CustomerName,
                            "Notes" => $Notes,
                            "Status" => $updateStatus,
                            "JobEndDateTime" => date("Y-m-d H:i:s"),
                            "JobEndLat" => $LogInLat,
                            "JobEndLong" => $LogInLong,
                            "JobEndLoc" => $LogInLoc,
                        );
                    }
                    $this->db->where('LoadID', $LoadID);
                    $this->db->update("tbl_booking_loads1", $udateData);


                    //New Load add
                    $LBookingID = $dataarr[0]->BookingID;
                    $ILID = $dataarr[0]->LID;
                    $ITicketID = $dataarr[0]->TicketID;
                    $LTicketUniqueID = $dataarr[0]->TicketUniqueID;
                    $LastConNumber = $this->Booking1_API_Model->LastConNumber();
                    $LConveyanceNo = $LastConNumber['ConveyanceNo'] + 1;
                    //$LConveyanceNo = $dataarr[0]->ConveyanceNo + 1;
                    $LBookingID = $dataarr[0]->BookingID;
                    $LMaterialID = $dataarr[0]->MaterialID;
                    $LTipID = $TipID;
                    $LDriverName = $dataarr[0]->DriverName;
                    $LVehicleRegNo = $dataarr[0]->VehicleRegNo;
                    $BookingRequestID = $dataarr[0]->BookingRequestID;
                    $insertBookingDateID = $dataarr[0]->BookingDateID;


                    $creatDatess = $dataarr[0]->CreateDateTime;
                    $today = date('Y-m-d H:i:s');
                    $date_diff = abs(strtotime($creatDatess) - strtotime($today));
                    $years = floor($date_diff / (365 * 60 * 60 * 24));
                    $months = floor(($date_diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = floor(($date_diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

                    if ($dataarr[0]->LoadType == 2 and $finish_load_button != 1) {
                        $loadNo = $this->db->query("select * from tbl_booking_loads1 where BookingID = '$LBookingID'");
                        //if($dataarr[0]->Loads >= $loadNo->num_rows()){

                        $finishC = $loadNo->num_rows() + 1;

                        ##################### Insert Booking Date ###################
                        $cndate = date('Y-m-d');
                        //$insertBookingDate = $this->db->query("insert into tbl_booking_date1(BookingID,BookingDate) value('$LBookingID','$cndate')");
                        //$insertBookingDateID = $this->db->insert_id();

                        ##############################################################

                        $dloginid = $user['DriverID'];
                        $insertLoad = $this->db->query("insert into tbl_booking_loads1(LID,TicketID,TicketUniqueID,ConveyanceNo,BookingID,BookingRequestID,BookingDateID,MaterialID,TipID,DriverID,DriverLoginID,DriverName,VehicleRegNo,Status,JobStartDateTime,AllocatedDateTime) value 
                        ('$ILID','$ITicketID','$LTicketUniqueID','$LConveyanceNo','$LBookingID','$BookingRequestID','$insertBookingDateID','$LMaterialID','$LTipID','$DriverID',$dloginid,'$LDriverName','$LVehicleRegNo',0,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)");
                        $NewLoadID = $this->db->insert_id();


                        $BookingID = $dataarr[0]->BookingID;
                        $Booking = $this->Booking1_API_Model->GetBookingInfo($BookingID);
                        $TicketUniqueID = $this->Ticket_API_Model->generateRandomString();
                        $LastTicketNumber = $this->Ticket_API_Model->LastTicketNo();
                        if ($LastTicketNumber) {
                            $TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
                        } else {
                            $TicketNumber = 1;
                        }

                        if ($dataarr[0]->BookingType == 2) {

                            if ($TipID == 1) {
                                sleep(2);
                                $this->db->select('TicketNo,TypeOfTicket');
                                $this->db->from('tbl_tickets');
                                $this->db->where('tbl_tickets.Conveyance', $LConveyanceNo);
                                $this->db->where('tbl_tickets.LoadID <> 0 ');
                                $this->db->where('tbl_tickets.is_tml', 1);
                                $this->db->where('tbl_tickets.TypeOfTicket', "Out");
                                $queryss = $this->db->get();
                                $dataarrss = $queryss->result();
                                if (($queryss->num_rows() > 0) && !empty($LConveyanceNo)) {
                                    $TicketID = $dataarrss[0]->TicketNo;
                                } else {
                                    $ticketsInfo = array(
                                        'TicketUniqueID' => $TicketUniqueID,
                                        'LoadID' => $NewLoadID,
                                        'TicketNumber' => $TicketNumber,
                                        'TicketDate' => date('Y-m-d H:i:s'),
                                        'Conveyance' => $LConveyanceNo,
                                        'OpportunityID' => $Booking->OpportunityID,
                                        'CompanyID' => $Booking->CompanyID,
                                        'DriverName' => $user['DriverName'],
                                        'RegNumber' => $user['RegNumber'],
                                        'Hulller' => $user['Haulier'],
                                        'Tare' => $user['Tare'],
                                        'driver_id' => $user['LorryNo'],
                                        'DriverLoginID' => $user['DriverID'],
                                        'MaterialID' => $dataarr[0]->MaterialID,
                                        'SicCode' => $Booking->Booking_SICCode,
                                        'CreateUserID' => 1,
                                        'CreateDate' => date('Y-m-d H:i:s'),
                                        'TypeOfTicket' => 'Out',
                                        'Is_Hold' => 1,
                                        'IsInBound' => 0,
                                        'is_tml' => 1,
                                        'pdf_name' => $TicketUniqueID . '.pdf',
                                        'created_by' => "app3"
                                    );

                                    $TicketID = $this->Ticket_API_Model->insert('tbl_tickets', $ticketsInfo);
                                }
                            } else {
                                $TicketID = 0;
                            }
                        }
                        //} else { $NewLoadID = 0; }


                    } else {
                        $NewLoadID = 0;
                    }

                    $status = "1";
                    $message = 'Load has been Completed';
                } else if ($Load_status == 5) {

                    $udateData = array(
                        "Notes" => $Notes,
                        "Status" => 5,
                        "JobEndDateTime" => date("Y-m-d H:i:s"),
                    );
                    $this->db->where('LoadID', $LoadID);
                    $this->db->update("tbl_booking_loads1", $udateData);
                    $status = "1";
                    $message = 'Status changed successfully';

                    $status = "0";
                    $message = 'Load has been Completed';
                } else if ($Load_status == 6) {
                    $status = "0";
                    $message = 'Status not available now';
                } else if ($Load_status == 7) {
                    // Haulage Reached On Second Location
                    if (isset($post_site_in_time) && !empty($post_site_in_time)) {
                        $post_site_in_time = date("Y-m-d H:i:s", strtotime($post_site_in_time));
                    } else {
                        $post_site_in_time = date("Y-m-d H:i:s");
                    }
                    $udateData = array(
                        "Notes1_2" => $Notes,
                        "Status" => 7,
                        "SiteInDateTime2" => $post_site_in_time,
                        "SiteInLat2" => $LogInLat,
                        "SiteInLog2" => $LogInLong,
                        "SiteInLoc2" => $LogInLoc,
                    );
                    $this->db->where('LoadID', $LoadID);
                    $this->db->update("tbl_booking_loads1", $udateData);
                    $status = "1";
                    $message = 'Status changed successfully';
                } else if ($Load_status == 8) {
                    $net = $GrossWeight - $user['Tare'];
                    //echo base_url().'uploads/Signature/'.$dataarr[0]->DriverSign; exit();
                    if (empty($_FILES['Signature']['name']) and $dataarr[0]->BookingType == 4 and !$wastedJourney) {
                        $status = "0";
                        $message = 'Customer Signature Required';
                    } else {
                        //Unique Code Generate for PDF name
                        $UniqCodeGen = md5(mt_rand(0, 999999) . date("Y-m-d H:i:s"));
                        sleep(2);
                        //Add Ticket Table
                        $BookingID = $dataarr[0]->BookingID;
                        $Booking = $this->Booking1_API_Model->GetBookingInfo($BookingID);
                        $TicketUniqueID = $this->Ticket_API_Model->generateRandomString();
                        $LastTicketNumber = $this->Ticket_API_Model->LastTicketNo();
                        if ($LastTicketNumber) {
                            $TicketNumber = $LastTicketNumber['TicketNumber'] + 1;
                        } else {
                            $TicketNumber = 1;
                        }


                        if ($TipID == 1) {
                            $TickIDQRY = $this->db->query("select TicketNo from  tbl_tickets where LoadID = '$LoadID'");
                            $TickIDQRY = $TickIDQRY->row_array();
                            if (count($TickIDQRY) > 0) {
                                $ticketId = $TickIDQRY['TicketNo'];
                                $TicketID = $TickIDQRY['TicketNo'];
                            } else {
                                $TicketID = '0';
                            }
                        } else {
                            $TicketID = '0';
                        }


                        //echo $TicketID;
                        //exit();

                        //Singnature
                        $config['upload_path'] = './uploads/Signature/';
                        $config['allowed_types'] = 'gif|jpg|png';
                        $config['encrypt_name'] = TRUE;
                        $config['overwrite'] = FALSE;
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('Signature')) {
                            $SignatureUpload = '';
                            $SignatureUploadfile_name = '';
                        } else {
                            $SignatureUpload = $this->upload->data();
                            $SignatureUploadfile_name = $SignatureUpload['file_name'];
                        }

                        //GET Material name //
                        $MaterialnameQRY = $this->db->query("select MaterialName,SicCode from tbl_materials where MaterialID = '$MaterialID'");
                        $MaterialnameQRY = $MaterialnameQRY->row_array();
                        //PDF GEN


                        $PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
                        $PDFContent = $PDFContentQRY->result();

                        //TIP Address //
                        if (isset($TipID) && !empty($TipID)) {
                            $tTIPID = $TipID;
                        } else {
                            $tTIPID = $dataarr[0]->TipID;
                        }

                        $tipadQRY = $this->db->query("select TipName,Street1,Street2,Town,County,PostCode,PermitRefNo from tbl_tipaddress where TipID = '$tTIPID'");
                        $tipadQRY = $tipadQRY->row_array();

                        $siteOutDateTimeInDB = date("Y-m-d H:i:s");
                        //$dataarr[0]->SiteOutDateTime = $siteOutDateTimeInDB;
                        $dataarr[0]->SiteOutDateTime2 = $siteOutDateTimeInDB;




                        $siteInDateTime = $siteOutDateTime = '';
                        if (isset($dataarr[0]->SiteInDateTime) && !empty($dataarr[0]->SiteInDateTime)) {
                            $siteInDateTime = '<b>In Time: </b>' . date("d-m-Y H:i", strtotime($dataarr[0]->SiteInDateTime)) . ' <br>';
                        }
                        if (isset($dataarr[0]->SiteOutDateTime) && !empty($dataarr[0]->SiteOutDateTime)) {
                            $siteOutDateTime = '<b>Out Time: </b>' . date("d-m-Y H:i", strtotime($dataarr[0]->SiteOutDateTime)) . ' <br>';
                        }

                        $siteInDateTime2 = $siteOutDateTime2 = '';
                        if (isset($dataarr[0]->SiteInDateTime2) && !empty($dataarr[0]->SiteInDateTime2)) {
                            $siteInDateTime2 = '<b>Haulage In Time: </b>' . date("d-m-Y H:i", strtotime($dataarr[0]->SiteInDateTime2)) . ' <br>';
                        }
                        if (isset($dataarr[0]->SiteOutDateTime2) && !empty($dataarr[0]->SiteOutDateTime2)) {
                            $siteOutDateTime2 = '<b>Haulage Out Time: </b>' . date("d-m-Y H:i", strtotime($dataarr[0]->SiteOutDateTime2)) . ' <br>';
                        }



                        $LT = '';
                        /* if ($dataarr[0]->LorryType == 1) {
                            $LT = 'Tipper';
                        } else if ($dataarr[0]->LorryType == 2) {
                            $LT = 'Grab';
                        } else if ($dataarr[0]->LorryType == 3) {
                            $LT = 'Bin';
                        } else {
                            $LT = '';
                        } */
                        $lorryType = $dataarr[0]->LorryType;
                        if ($lorryType == 1 || $lorryType == "1") {
                            $lorryType = "Tipper";
                        } elseif ($lorryType == 2 || $lorryType == "2") {
                            $lorryType = "Grab";
                        } elseif ($lorryType == 3 || $lorryType == "3") {
                            $lorryType = "Bin";
                        }

                        $tonBook = $dataarr[0]->TonBook;
                        if ($tonBook == 1 || $tonBook == "1") {
                            $tonBook = "Tonnage";
                        } elseif ($tonBook == 0 || $tonBook == "0") {
                            $tonBook = "Load";
                        } else {
                            $tonBook = "Load";
                        }
                        $dayWorkType = '';
                        if ($dataarr[0]->BookingType == 3) {
                            if ($dataarr[0]->DayWorkType == 1) {
                                $dayWorkType = 'Day';
                            } elseif ($dataarr[0]->DayWorkType == 2) {
                                $dayWorkType = 'Night';
                            } elseif ($dataarr[0]->DayWorkType == 3) {
                                $dayWorkType = 'Hourly';
                            }
                        }


                        //PDF GEN //
                        $TicketUniqueID = $dataarr[0]->TicketUniqueID;

                        //Haulage Delivery PDF
                        if ($dataarr[0]->BookingType == 4) {
                            $haulageAddress = '';
                            if ($TipID == 1) {
                                // Combine address fields
                                $haulageAddress = $tipadQRY['Street1'] . ' ' . $tipadQRY['Street2'] . ' ' . $tipadQRY['Town'] . ' ' . $tipadQRY['County'] . ' ' . $tipadQRY['PostCode'];
                            } else {
                                // Show TipName
                                $haulageAddress = $tipadQRY['TipName'];
                            }
                            if ($wastedJourney) {
                                if ($TipID == 1) {
                                    $data1['tickets'] = $this->Ticket_API_Model->get_pdf_data_app($ticketId);

                                    $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
                                    <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                                        <div style="width:100%;" ><div style="width:35%;float: left;" >
                                        <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
                                            <div style="width:65%;float: right;text-align: right;" > 		  
                                                <b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
                                                <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
                                            </div> 
                                        </div>	 
                                        <div style="width:100%;float: left;" >    
                                            <b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
                                            <b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
                                            <b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
                                            <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
                                            <b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
                                            <b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>	
                                            ' . $siteInDateTime . '
                                            ' . $siteOutDateTime . '
                                            ' . $siteInDateTime2 . '
                                            ' . $siteOutDateTime2 . '
                                            <b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
                                            <b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
                                            <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                                            <b>Driver Signature: </b> <br> 
                                            <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                                            <b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
                                            <b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
                                            <b>Haulage Address: </b> ' . $haulageAddress . '<br>
                                            <b>Material:  </b>' . $data1['tickets']['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . ' <br> 
                                            <b>SIC Code: </b> ' . $data1['tickets']['SicCode'] . ' <br> 
                                            <b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>
                                            <b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
                                            <b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
                                            <p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
                                            ' . $PDFContent[0]->outpdf_para2 . '<br>  
                                            <b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
                                        <div style="width:100%;float: left;" > 
                                            <p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
                                                <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
                                                <b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
                                                ' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

                                    $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $UniqCodeGen . ".pdf";
                                    $mpdf = new mPDF('utf-8', array(70, 250), '', '', 5, 5, 5, 5, 5, 5);
                                    $mpdf->SetWatermarkImage($stampImage);
                                    $mpdf->showWatermarkImage = true;
                                    $mpdf->watermarkImgBehind = false;
                                    $mpdf->watermarkImageAlpha = 0.7;
                                    $mpdf->keep_table_proportions = false;
                                    $mpdf->WriteHTML($html);
                                    $mpdf->Output($pdfFilePath);
                                } else {
                                    $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
                                    <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                                        <div style="width:100%;" ><div style="width:35%;float: left;" >
                                        <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
                                            <div style="width:65%;float: right;text-align: right;" > 		  
                                                <b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
                                                <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
                                            </div> 
                                        </div>	 
                                        <div style="width:100%;float: left;" >    
                                            <b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
                                            <b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
                                            <b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
                                            <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
                                            <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>	 
                                            <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                            ' . $siteInDateTime . '
                                            ' . $siteOutDateTime . '
                                            ' . $siteInDateTime2 . '
                                            ' . $siteOutDateTime2 . '
                                            <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . ' <br> 
                                            <b>Haulier: </b> ' . $user['Haulier'] . ' <br> 
                                            <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                                            <b>Driver Signature: </b> <br> 
                                            <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                                            <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		 
                                            <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . ' <br>	 
                                            <b>Haulage Address: </b> ' . $haulageAddress . ' <br>
                                            <b>Material:   </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . '<br> 
                                            <b>SIC Code: </b> ' . $dataarr[0]->Booking_SICCode . '  <br> 
                                            <b>Gross Weight: </b> ' . round($GrossWeight) . ' KGs<br>	
                                            <b>Tare Weight: </b> ' . round($user['Tare']) . ' KGs <br>		 
                                            <b>Net Weight: </b> ' . round($GrossWeight - $user['Tare']) . ' KGs <br> 
                                            <p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
                                            ' . $PDFContent[0]->outpdf_para2 . '<br>  
                                            <b>' . $PDFContent[0]->outpdf_para3 . '</b></p></div> 
                                        <div style="width:100%;float: left;" > 
                                            <p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
                                                <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
                                                <b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
                                                ' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

                                    $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $UniqCodeGen . ".pdf";
                                    $mpdf = new mPDF('utf-8', array(70, 250), '', '', 5, 5, 5, 5, 5, 5);
                                    $mpdf->SetWatermarkImage($stampImage);
                                    $mpdf->showWatermarkImage = true;
                                    $mpdf->watermarkImgBehind = false;
                                    $mpdf->watermarkImageAlpha = 0.7;
                                    $mpdf->keep_table_proportions = false;
                                    $mpdf->WriteHTML($html);
                                    $mpdf->Output($pdfFilePath);
                                }
                            } else {
                                if ($TipID == 1) {
                                    $data1['tickets'] = $this->Ticket_API_Model->get_pdf_data_app($ticketId);

                                    $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
                                    <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                                        <div style="width:100%;" ><div style="width:35%;float: left;" >
                                        <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
                                            <div style="width:65%;float: right;text-align: right;" > 		  
                                                <b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
                                                <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
                                            </div> 
                                        </div>	 
                                        <div style="width:100%;float: left;" >    
                                            <b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
                                            <b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
                                            <b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
                                            <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
                                            <b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
                                            <b>Date Time: </b> ' . $data1['tickets']['tdate'] . ' <br>	
                                            ' . $siteInDateTime . '
                                            ' . $siteOutDateTime . '
                                            ' . $siteInDateTime2 . '
                                            ' . $siteOutDateTime2 . '
                                            <b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
                                            <b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
                                            <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                                            <b>Driver Signature: </b> <br> 
                                            <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                                            <b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
                                            <b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
                                            <b>Haulage Address: </b> ' . $haulageAddress . '<br>
                                            <b>Material:  </b>' . $data1['tickets']['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . ' <br> 
                                            <b>SIC Code: </b> ' . $data1['tickets']['SicCode'] . ' <br> 
                                            <b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>
                                            <b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
                                            <b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
                                            </div> 
                                        <div style="width:100%;float: left;" >
                                            <b>Produced By: </b><br>
                                            <div><img src="/uploads/Signature/' . $dataarr[0]->Signature . '" width ="100" height="40" style="float:left"></div>
                                            ' . $dataarr[0]->CustomerName . '<br><br>
                                        </div>      
                                        <div style="width:100%;float: left;" > 
                                            <b>Received By: </b><br> 
                                            <div><img src="/uploads/Signature/' . $SignatureUploadfile_name . '" width ="100" height="40" style="float:left"></div> 
                                            ' . $CustomerName . ' 
                                            <p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
                                            ' . $PDFContent[0]->outpdf_para2 . '<br>  
                                            <b>' . $PDFContent[0]->outpdf_para3 . '</b></p>
                                            <p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
                                                <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
                                                <b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
                                                ' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

                                    $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $UniqCodeGen . ".pdf";
                                    $mpdf = new mPDF('utf-8', array(70, 250), '', '', 5, 5, 5, 5, 5, 5);
                                    $mpdf->keep_table_proportions = false;
                                    $mpdf->WriteHTML($html);
                                    $mpdf->Output($pdfFilePath);
                                } else {
                                    $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
                                    <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                                        <div style="width:100%;" ><div style="width:35%;float: left;" >
                                        <img src="/assets/Uploads/Logo/' . $PDFContent[0]->logo . '" width ="80" ></div> 
                                            <div style="width:65%;float: right;text-align: right;" > 		  
                                                <b>' . $PDFContent[0]->outpdf_title . '</b><br/>' . $PDFContent[0]->outpdf_address . '<br/> 		 
                                                <b>Phone:</b> ' . $PDFContent[0]->outpdf_phone . '
                                            </div> 
                                        </div>	 
                                        <div style="width:100%;float: left;" >    
                                            <b>Email:</b> ' . $PDFContent[0]->outpdf_email . '<br/>		 
                                            <b>Web:</b> ' . $PDFContent[0]->outpdf_website . ' <br/>		 
                                            <b>Waste License No: </b> ' . $PDFContent[0]->waste_licence . ' <br/><hr> 
                                            <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
                                            <b>Conveyance Note No:</b> ' . $dataarr[0]->ConveyanceNo . '<br>	 
                                            <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                                            ' . $siteInDateTime . '
                                            ' . $siteOutDateTime . '
                                            ' . $siteInDateTime2 . '
                                            ' . $siteOutDateTime2 . '
                                            <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . ' <br> 
                                            <b>Haulier: </b> ' . $user['Haulier'] . ' <br> 
                                            <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                                            <b>Driver Signature: </b> <br> 
                                            <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                                            <b>Company Name: </b> ' . $dataarr[0]->CompanyName . ' <br>		 
                                            <b>Site Address: </b> ' . $dataarr[0]->OpportunityName . ' <br>	 
                                            <b>Haulage Address: </b> ' . $haulageAddress . '<br>
                                            <b>Material:  </b>' . $MaterialnameQRY['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . ' <br> 
                                            <b>SIC Code: </b> ' . $dataarr[0]->Booking_SICCode . '  <br> 
                                            <b>Gross Weight: </b> ' . round($GrossWeight) . ' KGs<br>	
                                            <b>Tare Weight: </b> ' . round($user['Tare']) . ' KGs <br>		 
                                            <b>Net Weight: </b> ' . round($GrossWeight - $user['Tare']) . ' KGs <br> 
                                            </div> 
                                        <div style="width:100%;float: left;" >
                                            <b>Produced By: </b><br>
                                            <div><img src="/uploads/Signature/' . $dataarr[0]->Signature . '" width ="100" height="40" style="float:left"></div>
                                            ' . $dataarr[0]->CustomerName . '<br><br>
                                        </div>       
                                        <div style="width:100%;float: left;" > 
                                            <b>Received By: </b><br> 
                                            <div><img src="/uploads/Signature/' . $SignatureUploadfile_name . '" width ="100" height="40" style="float:left"></div> 
                                            ' . $CustomerName . ' 
                                            <p style="font-size: 7px;"> ' . $PDFContent[0]->outpdf_para1 . ' <br>  
                                            ' . $PDFContent[0]->outpdf_para2 . '<br>  
                                            <b>' . $PDFContent[0]->outpdf_para3 . '</b></p>
                                            <p style="font-size: 7px;"><b> ' . $PDFContent[0]->outpdf_para4 . '</b><br><br> 
                                                <b>VAT Reg. No: </b> ' . $PDFContent[0]->VATRegNo . '<br> 
                                                <b>Company Reg. No: </b>' . $PDFContent[0]->CompanyRegNo . '<br>
                                                ' . $PDFContent[0]->FooterText . '</p></div></div></body></html>';

                                    $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $UniqCodeGen . ".pdf";
                                    $mpdf = new mPDF('utf-8', array(70, 250), '', '', 5, 5, 5, 5, 5, 5);
                                    $mpdf->keep_table_proportions = false;
                                    $mpdf->WriteHTML($html);
                                    $mpdf->Output($pdfFilePath);
                                }
                            }
                        }
                        //$pdf_nameG = $TicketUniqueID.'.pdf'; 
                        $pdf_nameG = $UniqCodeGen . '.pdf';
                        $net = $GrossWeight - $user['Tare'];
                        if ($dataarr[0]->BookingType == 4) {
                            if ($TipID == 1) {
                                $TickIDQRY = $this->db->query("select TicketNo from  tbl_tickets where LoadID = '$LoadID'");
                                $TickIDQRY = $TickIDQRY->row_array();
                                $ticketId = $TickIDQRY['TicketNo'];
                                $this->db->query("update tbl_tickets set is_hold = '0',pdf_name = '$pdf_nameG' where LoadID = '$LoadID'");
                            } else if ($TipID >= 2) {

                                $ticketId = $TicketID = '';
                            }
                        }

                        $udateData = array(
                            "TicketID" => $TicketID,
                            "TicketUniqueID" => $TicketUniqueID,
                            "CustomerName2" => $CustomerName,
                            "Signature2" => $SignatureUploadfile_name,
                            "ReceiptName" => $UniqCodeGen . '.pdf',
                            "Notes2_2" => $Notes,
                            "Status" => 8,
                            "SiteOutDateTime2" => $siteOutDateTimeInDB,
                            "SiteOutLat2" => $LogInLat,
                            "SiteOutLong2" => $LogInLong,
                            "SiteOutLoc2" => $LogInLoc,
                        );

                        $this->db->where('LoadID', $LoadID);
                        $this->db->update("tbl_booking_loads1", $udateData);


                        $status = "1";
                        $message = 'Receipt has been generated Successfully';
                    }
                } else {
                    $status = "0";
                    $message = 'Invalid Status code';
                }


                $data = $query->result();
                $data[0]->NewLoadID = $NewLoadID . '';
                $data[0]->con_finish = $con_finish . '';
            } else {
                $status = "0";
                $message = 'Booking data not found.';
            }
        }

        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function photoUpload_post()
    {


        $token = $this->post('token');
        //$DriverID = $this->post('DriverID');
        $LoadID = $this->post('LoadID');
        $driver_id = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');
        $is_ticket_photo = $this->post('is_ticket_photo');
        if (isset($is_ticket_photo) && !empty($is_ticket_photo)) {
            $is_ticket_photo = 1;
        } else {
            $is_ticket_photo = 0;
        }
        $data = [];

        $logData = [
            'driver_id' => $this->post('driver_id') ?? "",
            'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);

        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);


        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($driver_id) || empty($DriverID) || empty($LoadID)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {
            $this->db->select('tbl_booking1.*, tbl_booking_loads1.Status as Load_status');
            $this->db->from('tbl_booking_loads1');
            $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID');
            $this->db->where('tbl_booking_loads1.LoadID', $LoadID);
            $this->db->where('tbl_booking_loads1.DriverID', $DriverID);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {

                $filesCount = count($_FILES['photos']['name']);
                for ($i = 0; $i < $filesCount; $i++) {
                    $_FILES['file']['name'] = $_FILES['photos']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['photos']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['photos']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['photos']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['photos']['size'][$i];

                    // File upload configuration 
                    $uploadPath = './uploads/Photo';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['encrypt_name'] = TRUE;
                    $config['overwrite'] = FALSE;

                    // Load and initialize upload library 
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    // Upload file to server 
                    if ($this->upload->do_upload('file')) {
                        // Uploaded file data 
                        $fileData = $this->upload->data();
                        $uploadData[$i]['file_name'] = $fileData['file_name'];
                        $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");

                        // echo $uploadData[$i]['file_name'].' ';
                        $ImageName = $uploadData[$i]['file_name'];
                        $DriverLoginID = $user['DriverID'];
                        $this->db->query("INSERT INTO `tbl_booking_loads_photos1` (`PhotoID`, `LoadID`, `DriverID`,`DriverLoginID`, `ImageName`, `is_ticket_photo`, `CreateDateTime`, `UpdateDateTime`) VALUES 
                           (NULL, '$LoadID', '$DriverID', '$DriverLoginID','$ImageName','$is_ticket_photo', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
                        $data[] = array(
                            "image" => $ImageName
                        );
                    } else {
                    }
                }

                //print_r($SignatureUpload);
                //echo $SignatureUpload['file_name'];
                //print_r($dataInfo);
                //exit();
                $status = "1";
                $message = 'photo uploaded';
                //$data = $query->result();
            } else {
                $status = "0";
                $message = 'Booking data not found.';
            }
        }

        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function booking_update_opportunity_post()
    {

        $token = $this->post('token');

        $opp_updated_lat = $this->post('opp_updated_lat');
        $opp_updated_long = $this->post('opp_updated_long');
        $opportunityID = $this->post('OpportunityID');
        $driver_id = $driverLoginID = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');

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

        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($driver_id)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($opp_updated_lat)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($opp_updated_long)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($opportunityID)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {
            $data = [];
            // Check opportunity exists with the given credentials
            $this->db->select('*');
            $this->db->from('tbl_opportunities');
            $this->db->where('OpportunityID', $opportunityID);
            $get_opportunity = $this->db->get();


            if (REST_Controller::TOKEKEYS != $token) {
                $status = "0";
                $message = 'Invalid API Key';
            } else if ($get_opportunity->num_rows() > 0) {
                $udateData = array(
                    "opp_updated_lat" => $opp_updated_lat,
                    'opp_updated_long' => $opp_updated_long,
                    'opp_latlong_updated_by' => $driver_id,
                    'opp_latlong_updated_at' => date('Y-m-d H:i:s')
                );


                $this->db->where('OpportunityID', $opportunityID);
                $this->db->update("tbl_opportunities", $udateData);


                $status = "1";
                $message = 'Lat Long Updated Successfully.';

            } else {

                $status = "0";
                $message = 'Invalid Opportunity ID.';

            }
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function booking_update_tipaddress_post()
    {

        $token = $this->post('token');

        $tip_updated_lat = $this->post('tip_updated_lat');
        $tip_updated_long = $this->post('tip_updated_long');
        $tipID = $this->post('TipID');
        $driver_id = $driverLoginID = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');

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

        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($driver_id)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($tip_updated_lat)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($tip_updated_long)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($tipID)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {
            $data = [];
            // Check opportunity exists with the given credentials
            $this->db->select('*');
            $this->db->from('tbl_tipaddress');
            $this->db->where('TipID', $tipID);
            $get_opportunity = $this->db->get();


            if (REST_Controller::TOKEKEYS != $token) {
                $status = "0";
                $message = 'Invalid API Key';
            } else if ($get_opportunity->num_rows() > 0) {
                $udateData = array(
                    "tip_updated_lat" => $tip_updated_lat,
                    'tip_updated_long' => $tip_updated_long,
                    'tip_latlong_updated_by' => $driver_id,
                    'tip_latlong_updated_at' => date('Y-m-d H:i:s')
                );


                $this->db->where('TipID', $tipID);
                $this->db->update("tbl_tipaddress", $udateData);


                $status = "1";
                $message = 'Lat Long Updated Successfully.';

            } else {

                $status = "0";
                $message = 'Invalid Tip ID.';

            }
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function lorry_details_post()
    {
        $token = $this->post('token');
        //$LorryNo = $this->post('LorryNo');
        $RegNumber = $this->post('RegNumber');
        $driver_id = $this->post('driver_id');
        $lorry_no = $LorryNo = $DriverID = $this->post('lorry_no');

        $logData = [
            'driver_id' => $this->post('driver_id') ?? "",
            'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);
        /*$con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );*/
        //$user = $this->Drivers_API_Model->getRows($con);

        $data = [];
        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (empty($LorryNo) && empty($RegNumber)) {
            $status = "0";
            $message = 'Please check required fields';
        } /*else if (empty($user)) {
      $status = "0";
      $message = 'User id not found or account disabled';
  }*/ else {
            $this->db->select('*');
            $this->db->from('tbl_drivers');
            if (!empty($LorryNo)) {
                $this->db->where('LorryNo', $LorryNo);
            }
            if (!empty($RegNumber)) {
                $this->db->where('RegNumber', $RegNumber);
            }
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $status = "1";
                $message = 'Lorry list';
                $data = $query->result();
            } else {
                $status = "0";
                $message = 'Lorry data not found.';
            }
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function lorry_list_post()
    {
        $token = $this->post('token');
        $data = [];
        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else {
            $this->db->select('LorryNo,RegNumber,Tare,Haulier,MacAddress,is_lorry_assigned');
            $this->db->from('tbl_drivers');
            //$this->db->where('Haulier', 'Thames Material Ltd.');
            $this->db->where('ContractorID', '1');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $status = "1";
                $message = 'Lorry list';
                $data = $query->result();
            } else {
                $status = "0";
                $message = 'Lorry data not found.';
            }
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function materials_list_post()
    {


        $token = $this->post('token');
        //$DriverID = $this->post('DriverID');
        $BookingType = $this->post('BookingType');
        $driver_id = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');
        $data = [];

        // Check user exists with the given credentials
        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);


        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($driver_id) || empty($DriverID) || empty($BookingType)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {
            if ($BookingType == '1') {
                $Operation = 'IN';
            } else {
                $Operation = 'COLLECTION';
            }
            $this->db->select('*');
            $this->db->from('tbl_materials');
            $this->db->where('Operation', $Operation);
            $this->db->where('Status', '1');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $status = "1";
                $message = 'Material list';
                $data = $query->result();
            } else {
                $status = "0";
                $message = 'Booking data not found.';
            }
        }

        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function tipaddress_post()
    {


        $token = $this->post('token');
        //$DriverID = $this->post('DriverID');
        $driver_id = $this->post('driver_id');
        $lorry_no = $DriverID = $this->post('lorry_no');
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


        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($driver_id) || empty($DriverID)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {

            $opportunityID = $this->post('OpportunityID');
            if (isset($opportunityID) && !empty($opportunityID)) {
                $this->db->select('TipID');
                $this->db->from('tbl_opportunity_tip');
                $this->db->where('OpportunityID', $opportunityID);
                $this->db->where('Status', "0");
                $query = $this->db->get();
                $data = $query->result();
                $tipIds = array();
                foreach ($data as $tipss) {
                    $tipIds[] = $tipss->TipID;
                }
                $tipIds = array_unique($tipIds);

                $this->db->select('*');
                $this->db->from('tbl_tipaddress');
                $this->db->where_in('TipID', $tipIds);
                $query = $this->db->get();
            } else {
                $this->db->select('*');
                $this->db->from('tbl_tipaddress');
                $query = $this->db->get();
            }




            if ($query->num_rows() > 0) {
                $status = "1";
                $message = 'Tip Address list';
                $data = $query->result();
            } else {
                $status = "0";
                $message = 'Tip Address not found.';
            }
        }

        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function driver_reg_list_post()
    {


        $token = $this->post('token');
        //$DriverID = $this->post('DriverID');
        $BookingType = $this->post('BookingType');
        $driver_id = $this->post('driver_id');

        $lorry_no = $DriverID = $this->post('lorry_no');
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


        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else if (empty($driver_id) || empty($DriverID)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {
            $this->db->select('RegNumber');
            $this->db->from('tbl_drivers');
            $this->db->where('Haulier', 'Thames Material Ltd.');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $status = "1";
                $message = 'RegNumber list';
                $data = $query->result();
            } else {
                $status = "0";
                $message = 'RegNumber data not found.';
            }
        }

        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function lorry_identifier_post()
    {
        $token = $this->post('token');
        //$LorryNo = $this->post('LorryNo');
        $identifier = $this->post('Identifier');
        $imei = $this->post('IMEI');
        $serialNo = $this->post('SerialNo');
        $driver_id = $this->post('driver_id');
        $lorry_no = $this->post('lorry_no');

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

        $data = [];
        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (empty($identifier)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {
            $udateData = array(
                "Identifier" => $identifier
            );
            if (!empty($serialNo)) {
                $udateData['SerialNo'] = $serialNo;
            }
            if (!empty($imei)) {
                $udateData['IMEI'] = $imei;
            }
            $this->db->where('LorryNo', $lorry_no);
            $this->db->update("tbl_drivers", $udateData);

            $status = "1";
            $message = 'Status changed successfully';
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function lorry_assign_post()
    {

        $token = $this->post('token');
        $lorry_no = $this->post('lorry_no');

        $logData = [
            'driver_id' => $this->post('driver_id') ?? "",
            'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);

        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (!isset($lorry_no) || empty($lorry_no)) {
            $status = "0";
            $message = 'Invalid Request';
        } else {
            $udateData = array(
                "is_lorry_assigned" => 1
            );
            $this->db->where('LorryNo', $lorry_no);
            $this->db->update("tbl_drivers", $udateData);
            $status = "1";
            $message = 'Lorry assigned successfully';
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }

    public function driver_autologout_post()
    {
        $token = $this->post('token');
        //$LorryNo = $this->post('LorryNo');
        $driver_id = $this->post('driver_id');
        $lorry_no = $this->post('lorry_no');

        $logData = [
            'driver_id' => $this->post('driver_id') ?? "",
            'lorry_no' => $this->post('lorry_no') ?? "",
            'api_call' => __METHOD__, // Get current method name
            'api_request' => json_encode($this->post())
        ];

        $this->log_api_data($logData);

        $con['returnType'] = 'single';
        $con['conditions'] = array(
            'DriverID' => $driver_id,
            'Status' => 0
        );
        $user = $this->Drivers_API_Model->getRows($con);

        $data = [];
        if (REST_Controller::TOKEKEYS != $token) {
            $status = "0";
            $message = 'Invalid API Key';
        } else if (empty($lorry_no)) {
            $status = "0";
            $message = 'Please check required fields';
        } else if (empty($driver_id)) {
            $status = "0";

            $message = 'Please check required fields';
        } else if (empty($user)) {
            $status = "0";
            $message = 'User id not found or account disabled';
        } else {

            $this->db->select('is_lorry_assigned');
            $this->db->from('tbl_drivers');
            $this->db->where('LorryNo', $lorry_no);
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $dataarr = $query->result();
                $dataar = $dataarr[0];
                if ($dataar->is_lorry_assigned == "1") {
                    $this->db->select('*');
                    $this->db->from('tbl_drivers_logs');
                    $this->db->where('DriverID', $lorry_no);
                    $this->db->where('DriverLoginID', $driver_id);
                    $curDay = date('Y-m-d');
                    $this->db->where("LoginDatetime LIKE '%" . $curDay . "%'");
                    $this->db->where("LogoutDateTIme", "0000-00-00 00:00:00");
                    $query = $this->db->get();
                    if ($query->num_rows() > 0) {
                        $status = "1";
                        $message = 'Data Found';
                        $data = array();
                    } else {
                        $status = "0";
                        $message = 'Data not found.';
                        $data = array();
                        $LoginDatetime = date('Y-m-d');
                        $LogoutDateTIme = date('Y-m-d H:i:s');
                        $update = $this->db->query("update tbl_drivers_logs set LogoutDateTIme = '$LogoutDateTIme' where DriverID = '$lorry_no' AND DriverLoginID = '$driver_id' order by LogID DESC limit 1");
                    }
                } else {
                    $status = "0";
                    $message = 'Lorry not allocated.';
                    $data = array();
                    $LoginDatetime = date('Y-m-d');
                    $LogoutDateTIme = date('Y-m-d H:i:s');
                    $update = $this->db->query("update tbl_drivers_logs set LogoutDateTIme = '$LogoutDateTIme' where DriverID = '$lorry_no' AND DriverLoginID = '$driver_id' order by LogID DESC limit 1");
                }
            } else {
                $status = "0";
                $message = 'Lorry not found.';
                $data = array();
                $LoginDatetime = date('Y-m-d');
                $LogoutDateTIme = date('Y-m-d H:i:s');
                $update = $this->db->query("update tbl_drivers_logs set LogoutDateTIme = '$LogoutDateTIme' where DriverID = '$lorry_no' AND DriverLoginID = '$driver_id' order by LogID DESC limit 1");
            }
        }
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);
    }



    public function update_signature_post()
    {
        $conveyanceNumbers = $this->post('conveyanceNumbers') ?? "";

        foreach ($conveyanceNumbers as $conveyanceNumber) {
            // $conveyanceNumber = $this->db->escape($conveyanceNumber); // Escape the input to prevent SQL injection

            $loadInfo = $this->Booking1_API_Model->BookingLoadInfoApi($conveyanceNumber);

            // if ($loadInfo->num_rows() == 0) {
            //     echo "No data found for Conveyance Number: " . $conveyanceNumber . "<br>";
            //     continue;
            // }

            // $loadInfo = $query->row(); // Get data as object for easier access

            // Fetch PDF Content Settings
            $PDFContentQRY = $this->db->query("SELECT * FROM tbl_content_settings WHERE id = '1'");
            $PDFContent = $PDFContentQRY->row();

            // Determine Lorry Type
            $lorryType = '';
            switch ($loadInfo->LorryType) {
                case 1:
                    $lorryType = 'Tipper';
                    break;
                case 2:
                    $lorryType = 'Grab';
                    break;
                case 3:
                    $lorryType = 'Bin';
                    break;
            }

            // Determine Tonnage or Load
            $tonBook = ($loadInfo->TonBook == 1) ? 'Tonnage' : 'Load';
            // Prepare HTML content for the PDF
            $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body> 
        <div style="width:100%;margin-bottom:0px;margin-top:0px;font-size:10px;">    
            <div style="width:100%;">
                <div style="width:35%;float:left;">         
                    <img src="/assets/Uploads/Logo/' . $PDFContent->logo . '" width="80"> 
                </div>
                <div style="width:65%;float:right;text-align:right;">      
                    <b>' . $PDFContent->outpdf_title . '</b><br/>       
                    ' . $PDFContent->address . ' <br/> 
                    <b>Phone:</b> ' . $PDFContent->outpdf_phone . '                                               
                </div>
            </div>
            <div style="width:100%;float:left;">   
                <b>Email:</b> ' . $PDFContent->email . ' <br/>     
                <b>Web:</b> ' . $PDFContent->website . ' <br/>          
                <b>Waste License No: </b>' . $PDFContent->waste_licence . ' <br/> <hr>
                <b>' . $PDFContent->head1 . '</b><br/> <br>
                <b>' . $PDFContent->head2 . '</b><br/> <br>
                <div style="text-align:center;"><b>CONVEYANCE NOTE </b></div><br>
                <b>Conveyance Note No:</b> ' . $loadInfo->ConveyanceNo . '<br>     
                <b>Date Time: </b>' . date('d-m-Y H:i', strtotime($loadInfo->CDateTime)) . '<br>
                <b>In Time: </b>' . date('d-m-Y H:i', strtotime($loadInfo->SiteInDateTime)) . '<br>
                <b>Out Time: </b>' . date('d-m-Y H:i', strtotime($loadInfo->SiteOutDateTime)) . '<br>
                <b>Company Name: </b>' . $loadInfo->CompanyName . '<br>        
                <b>Site Address: </b>' . $loadInfo->OpportunityName . '<br>              
                <b>Tip Address: </b>' . $loadInfo->TipName . ',' . $loadInfo->Street1 . ',' . $loadInfo->Street2 . ',
                ' . $loadInfo->Town . ',' . $loadInfo->County . ',' . $loadInfo->PostCode . '<br>     
                <b>Permit Reference No: </b>' . $loadInfo->PermitRefNo . ' <br/>                            
                <b>Material: </b>' . $loadInfo->MaterialName . ' Collected ' . $lorryType . ' ' . $tonBook . '<br> 
                <b>SicCode: </b>' . $loadInfo->SicCode . ' <br>  
                <b>Vehicle Reg. No. </b>' . $loadInfo->VehicleRegNo . '<br> 
                <b>Driver Name: </b>' . $loadInfo->DriverName . '<br><br/>   
            </div>
            <div><img src="/assets/DriverSignature/' . $loadInfo->driver_signature . '" width="100" height="40" style="float:left"></div>  
            <br>
            <div style="width:100%;float:left;">
                <b>Produced By: </b><br>
                <div><img src="/uploads/Signature/' . $loadInfo->Signature . '" width="100" height="40" style="float:left"></div>
                ' . $loadInfo->CustomerName . '<br><br>
                <div style="font-size:9px;"> 
                    <b>VAT Reg. No: </b>' . $PDFContent->VATRegNo . '<br>
                    <b>Company Reg. No: </b>' . $PDFContent->CompanyRegNo . '<br>  
                    ' . $PDFContent->FooterText . '  
                </div>
            </div>
        </div>
    </body>
    </html>';

            // Check directory permissions and existence
            $directory = "/home/tmlsnsitltdco/public_html/assets/conveyance/";
            if (!is_writable($directory)) {
                echo "Error: Directory is not writable: " . $directory . "<br>";
                continue;
            }

            if (!file_exists($directory)) {
                echo "Error: Directory does not exist: " . $directory . "<br>";
                continue;
            }

            // Generate PDF file
            $pdfFilePath = WEB_ROOT_PATH . "assets/conveyance/" . $loadInfo->ReceiptName;

            try {
                $mpdf = new mPDF('utf-8', array(70, 190), '', '', 5, 5, 5, 5, 5, 5);
                $mpdf->showWatermarkImage = true;
                $mpdf->watermarkImgBehind = false;
                $mpdf->watermarkImageAlpha = 0.7;
                $mpdf->keep_table_proportions = false;
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath);

                echo "PDF generated successfully for Conveyance Number: " . $conveyanceNumber . "<br>";
            } catch (Exception $e) {
                echo "Error generating PDF for Conveyance Number: " . $conveyanceNumber . ": " . $e->getMessage() . "<br>";
                continue;
            }
        }

        $this->response([
            'status' => "200",
            'message' => "PDF generation completed",
            'data' => "Success"
        ], REST_Controller::HTTP_OK);
    }

    public function delivery_pdf_sign_post()
    {
        $customerName = $this->post('customerName') ?? ""; // Get customer name from the request
        $startDate = "2025-01-06 00:00:00";
        $endDate = "2025-01-07 23:59:59";

        if (empty($customerName)) {
            // If no customer name is provided, return an error response
            $this->response(['status' => false, 'message' => 'Customer name is required.'], 400);
            return;
        }

        // Fetch records for the specified customer and date range
        $this->db->select('CustomerName, Signature, LoadId, TicketID');
        $this->db->from('tbl_booking_loads1');
        $this->db->where('CustomerName', $customerName);
        $this->db->where('CreateDateTime >=', $startDate);
        $this->db->where('CreateDateTime <=', $endDate);

        $query = $this->db->get();
        $records = $query->result_array();

        if (empty($records)) {
            // If no records are found, return an empty response
            $this->response(['status' => false, 'message' => 'No records found for the specified customer and date range.'], 404);
            return;
        }

        $pdfFileNames = [];
        foreach ($records as $record) {
            
            $data1['tickets'] = $this->Ticket_API_Model->get_pdf_data_app_script($record['TicketID']);

            $TipID = $data1['tickets']['TipID']; // Assuming TipID is part of the ticket data
            $UniqCodeGen = uniqid(); // Unique code for the PDF filename

            // Dynamic data for PDF
            $PDFContentQRY = $this->db->query("SELECT * FROM tbl_content_settings WHERE id = '1'");
            $PDFContent = $PDFContentQRY->row();// Assuming this retrieves static content for PDF


            $lorryType = $data1['tickets']['LorryType'] ?? '';
            $tonBook = $data1['tickets']['TonBook'] ?? '';
            $con['returnType'] = 'single';
            $con['conditions'] = array(
                'DriverID' => $data1['tickets']['DriverLoginID'],
                'Status' => 0
            );

            $user = $this->Drivers_API_Model->getRows($con);// Assuming user data comes from the tickets array

            $tipadQRYForHau = $this->db->query("select TipName,Street1,Street2,Town,County,PostCode,PermitRefNo from tbl_tipaddress where TipID = '$TipID'");
            $tipadQRYForHau = $tipadQRYForHau->row_array();

            $haulageAddress = '';
            if ($TipID == 1) {
                // Combine address fields
                $haulageAddress = $tipadQRYForHau['Street1'] . ' ' . $tipadQRYForHau['Street2'] . ' ' . $tipadQRYForHau['Town'] . ' ' . $tipadQRYForHau['County'] . ' ' . $tipadQRYForHau['PostCode'];
            } else {
                // Show TipName
                $haulageAddress = $tipadQRYForHau['TipName'];
            }

            $lorryTypeQry = $this->db->query("SELECT * FROM tbl_booking1 WHERE BookingID = '" . $data1['tickets']['BookingID'] . "'");
            $lorryTypeQryResult = $lorryTypeQry->row_array();  // Fetch the result as an array

            $lorryType = $lorryTypeQryResult['LorryType'];

            print_r($data1);
            die();
            $LT = '';
            if ($lorryType == 1 || $lorryType == "1") {
                $lorryType = "Tipper";
            } elseif ($lorryType == 2 || $lorryType == "2") {
                $lorryType = "Grab";
            } elseif ($lorryType == 3 || $lorryType == "3") {
                $lorryType = "Bin";
            }

            $siteOutDateTimeInDB = date("Y-m-d H:i:s");
            //$dataarr[0]->SiteOutDateTime = $siteOutDateTimeInDB;
            $data1['SiteOutDateTime2'] = $siteOutDateTimeInDB;

            $siteInDateTime = $siteOutDateTime = '';
            if (isset($data1['tickets']['SiteInDateTime']) && !empty($data1['tickets']['SiteInDateTime'])) {
                $siteInDateTime = '<b>In Time: </b>' . date("d-m-Y H:i", strtotime($data1['tickets']['SiteInDateTime'])) . ' <br>';
            }
            if (isset($data1['tickets']['SiteOutDateTime']) && !empty($data1['tickets']['SiteOutDateTime'])) {
                $siteOutDateTime = '<b>Out Time: </b>' . date("d-m-Y H:i", strtotime($data1['tickets']['SiteOutDateTime'])) . ' <br>';
            }

            $siteInDateTime2 = $siteOutDateTime2 = '';
            if (isset($data1['tickets']['SiteInDateTime2']) && !empty($data1['tickets']['SiteInDateTime2'])) {
                $siteInDateTime2 = '<b>Haulage In Time: </b>' . date("d-m-Y H:i", strtotime($data1['tickets']['SiteInDateTime2'])) . ' <br>';
            }
            if (isset($data1['tickets']['SiteOutDateTime2']) && !empty($data1['tickets']['SiteOutDateTime2'])) {
                $siteOutDateTime2 = '<b>Haulage Out Time: </b>' . date("d-m-Y H:i", strtotime($data1['tickets']['SiteOutDateTime2'])) . ' <br>';
            }

            if ($TipID == 1) {
                $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
            <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                <div style="width:100%;" ><div style="width:35%;float: left;" >
                <img src="/assets/Uploads/Logo/' . $PDFContent->logo . '" width ="80" ></div> 
                    <div style="width:65%;float: right;text-align: right;" > 		  
                        <b>' . $PDFContent->outpdf_title . '</b><br/>' . $PDFContent->outpdf_address . '<br/> 		 
                        <b>Phone:</b> ' . $PDFContent->outpdf_phone . '
                    </div> 
                </div>	 
                <div style="width:100%;float: left;" >    
                    <b>Email:</b> ' . $PDFContent->outpdf_email . '<br/>		 
                    <b>Web:</b> ' . $PDFContent->outpdf_website . ' <br/>		 
                    <b>Waste License No: </b> ' . $PDFContent->waste_licence . ' <br/><hr> 
                    <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
                    <b>Ticket NO:</b> ' . $data1['tickets']['TicketNumber'] . ' <br>		 
                    <b>Date Time: </b> ' .  date('d/m/Y H:i:s', strtotime($data1['tickets']['CreateDateTime'])) . ' <br>	
                    ' . $siteInDateTime . '
                    ' . $siteOutDateTime . '
                    ' . $siteInDateTime2 . '
                    ' . $siteOutDateTime2 . '
                    <b>Vehicle Reg. No. </b> ' . $data1['tickets']['RegNumber'] . ' <br> 
                    <b>Haulier: </b> ' . $data1['tickets']['Hulller'] . ' <br> 
                    <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                    <b>Driver Signature: </b> <br> 
                    <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                    <b>Company Name: </b> ' . $data1['tickets']['CompanyName'] . ' <br>		 
                    <b>Site Address: </b> ' . $data1['tickets']['OpportunityName'] . ' <br>	 
                    <b>Tip Address: </b> ' . $haulageAddress . '<br>
                    <b>Material:  </b>' . $data1['tickets']['MaterialName'] . ' ' . $LT . ' Delivered ' . $lorryType . ' ' . $tonBook . ' <br> 
                    <b>SIC Code: </b> ' . $data1['tickets']['SicCode'] . ' <br> 
                    <b>Gross Weight: </b> ' . round($data1['tickets']['GrossWeight']) . ' KGs <br>
                    <b>Tare Weight: </b> ' . round($data1['tickets']['Tare']) . ' KGs <br>		 
                    <b>Net Weight: </b> ' . round($data1['tickets']['Net']) . ' KGs <br> 
                    </div>       
                <div style="width:100%;float: left;" > 
                    <b>Received By: </b><br> 
                    <div><img src="/uploads/Signature/' . $data1['tickets']['Signature'] . '" width ="100" height="40" style="float:left"></div> 
                    ' . $data1['tickets']['CustomerName'] . ' 
                    <p style="font-size: 7px;"> ' . $PDFContent->outpdf_para1 . ' <br>  
                    ' . $PDFContent->outpdf_para2 . '<br>  
                    <b>' . $PDFContent->outpdf_para3 . '</b></p>
                    <p style="font-size: 7px;"><b> ' . $PDFContent->outpdf_para4 . '</b><br><br> 
                        <b>VAT Reg. No: </b> ' . $PDFContent->VATRegNo . '<br> 
                        <b>Company Reg. No: </b>' . $PDFContent->CompanyRegNo . '<br>
                        ' . $PDFContent->FooterText . '</p></div></div></body></html>';

                // Generate the PDF for TipID 1
                $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data1['tickets']['ReceiptName'];
                $mpdf = new mPDF('utf-8', array(70, 250), '', '', 5, 5, 5, 5, 5, 5);
                $mpdf->keep_table_proportions = false;
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath);

                // Add the generated file name to the array
                $pdfFileNames[] = $data1['tickets']['ReceiptName'];

            } else {
                // Use a different template for other TipID
                $html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body>
            <div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	 
                <div style="width:100%;" ><div style="width:35%;float: left;" >
                <img src="/assets/Uploads/Logo/' . $PDFContent->logo . '" width ="80" ></div> 
                    <div style="width:65%;float: right;text-align: right;" > 		  
                        <b>' . $PDFContent->outpdf_title . '</b><br/>' . $PDFContent->outpdf_address . '<br/> 		 
                        <b>Phone:</b> ' . $PDFContent->outpdf_phone . '
                    </div> 
                </div>	 
                <div style="width:100%;float: left;" >    
                    <b>Email:</b> ' . $PDFContent->outpdf_email . '<br/>		 
                    <b>Web:</b> ' . $PDFContent->outpdf_website . ' <br/>		 
                    <b>Waste License No: </b> ' . $PDFContent->waste_licence . ' <br/><hr> 
                    <center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/>  
                    <b>Conveyance Note No:</b> ' . $data1['ConveyanceNo'] . '<br>	 
                    <b>Date Time: </b>' . date("d-m-Y H:i") . ' <br>		 
                    ' . $siteInDateTime . '
                    ' . $siteOutDateTime . '
                    ' . $siteInDateTime2 . '
                    ' . $siteOutDateTime2 . '
                    <b>Vehicle Reg. No. </b> ' . $user['RegNumber'] . ' <br> 
                    <b>Haulier: </b> ' . $user['Haulier'] . ' <br> 
                    <b>Driver Name: </b> ' . $user['DriverName'] . '<br> 
                    <b>Driver Signature: </b> <br> 
                    <div><img src="/assets/DriverSignature/' . $user['Signature'] . '" width ="100" height="40" style="float:left"> </div>
                    <b>Company Name: </b> ' . $user['CompanyName'] . ' <br>		 
                    <b>Site Address: </b> ' . $user['SiteAddress'] . ' <br>	 
                    <b>Tip Address: </b> ' . $haulageAddress . '<br>
                    <b>Material:  </b>' . $user['Material'] . ' <br> 
                    <b>Gross Weight: </b> ' . round($user['GrossWeight']) . ' KGs<br> 
                    <b>Tare Weight: </b> ' . round($user['TareWeight']) . ' KGs <br>		 
                    <b>Net Weight: </b> ' . round($user['NetWeight']) . ' KGs <br> 
                    </div>       
                <div style="width:100%;float: left;" > 
                    <b>Received By: </b><br> 
                    <div><img src="/uploads/Signature/' . $data1['tickets']['Signature'] . '" width ="100" height="40" style="float:left"></div> 
                    ' . $data1['tickets']['CustomerName'] . ' 
                    <p style="font-size: 7px;"> ' . $PDFContent->outpdf_para1 . ' <br>  
                    ' . $PDFContent->outpdf_para2 . '<br>  
                    <b>' . $PDFContent->outpdf_para3 . '</b></p>
                    <p style="font-size: 7px;"><b> ' . $PDFContent->outpdf_para4 . '</b><br><br> 
                        <b>VAT Reg. No: </b> ' . $PDFContent->VATRegNo . '<br> 
                        <b>Company Reg. No: </b>' . $PDFContent->CompanyRegNo . '<br>
                        ' . $PDFContent->FooterText . '</p></div></div></body></html>';


                // Generate the PDF for other TipIDs
                $pdfFilePath = WEB_ROOT_PATH . "/assets/conveyance/" . $data1['tickets']['ReceiptName'];
                $mpdf = new mPDF('utf-8', array(70, 230), '', '', 5, 5, 5, 5, 5, 5);
                $mpdf->keep_table_proportions = false;
                $mpdf->WriteHTML($html);
                $mpdf->Output($pdfFilePath);

                // Add the generated file name to the array
                $pdfFileNames[] = $data1['tickets']['ReceiptName'];
            }
        }

        // Return the list of generated PDF file names
        $this->response(['status' => true, 'pdfFiles' => $pdfFileNames], 200);
    }
    

	public function update_ref_post(){
		$token = $this->post('token');
		if(REST_Controller::TOKEKEYS != $token){
            $status = "0";
            $message ='Invalid API Key';
        }
		$tipTicketId = $this->post('TipTicketID');
		$tipID = $this->post('TipID');
		$tTIPID = $tipID;
		$tipadQRY = $this->db->query("select TipName,Street1,Street2,Town,County,PostCode,PermitRefNo from tbl_tipaddress where TipID = '$tTIPID'");
		$tipadQRY = $tipadQRY->row_array();
                         
                 $query = $this->db->get_where('tbl_tipticket', ['TipTicketID' => $tipTicketId]);
			$result = $query->row_array();

			if ($result) {
				echo json_encode([
					'status' => 'success',
					'data' => $result
				]);
			} else {
				echo json_encode([
					'status' => 'error',
					'message' => 'No data found'
				]);
			}
	}
	
	public function create_test_post()
	{
		echo "method called";

}
}