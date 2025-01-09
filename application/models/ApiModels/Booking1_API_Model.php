<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Booking1_API_Model extends CI_Model
{
    
    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        $this->Tbl = 'tbl_booking1';
    }


    function BookingLoadInfoApi($conveyanceNo){

		$this->db->select('tbl_booking_loads1.LoadID');  
		$this->db->select('tbl_booking_loads1.Status');   
		$this->db->select('tbl_booking_loads1.ConveyanceNo');   
		$this->db->select('tbl_booking_loads1.DriverName');   
		$this->db->select('tbl_booking_loads1.VehicleRegNo');   
		$this->db->select('tbl_booking_loads1.Signature');   
		$this->db->select('tbl_booking_loads1.Signature2');
		$this->db->select('tbl_booking_loads1.DriverID');   
		$this->db->select('tbl_booking_loads1.DriverLoginID');   
		$this->db->select('tbl_booking_loads1.Tare');    
		$this->db->select('tbl_booking_loads1.Net');    
		$this->db->select('tbl_booking_loads1.CustomerName');  
		$this->db->select('tbl_booking_loads1.CustomerName2');  
		$this->db->select('tbl_booking_loads1.ReceiptName');   
		$this->db->select('tbl_booking_loads1.BookingID');   
		$this->db->select('tbl_booking_loads1.BookingRequestID'); 
		$this->db->select('tbl_booking_loads1.TipID ');	
		$this->db->select('tbl_booking_loads1.TicketID ');	
		$this->db->select('tbl_booking_loads1.TipNumber ');	
		$this->db->select('tbl_booking_loads1.GrossWeight ');	
		$this->db->select('tbl_booking_loads1.TipAddressUpdate ');
		$this->db->select('tbl_booking_loads1.SiteInDateTime ');
		$this->db->select('tbl_booking_loads1.SiteOutDateTime ');		
		$this->db->select('tbl_booking_loads1.TicketUniqueID ');		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d-%m-%Y %H:%i") as SIDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %H:%i") as SODateTime ');  
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime2,"%d-%m-%Y %H:%i") as HSIDateTime ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime2,"%d-%m-%Y %H:%i") as HSODateTime ');  
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %H:%i") as CDateTime ');  
		  
		
		$this->db->select('tbl_booking1.LoadType');   
		$this->db->select('tbl_booking1.LorryType');  
		$this->db->select('tbl_booking1.TonBook'); 		
		$this->db->select('tbl_booking_request.CompanyID ');	
		$this->db->select('tbl_booking1.BookingType');   
		$this->db->select('tbl_booking_request.OpportunityID ');	 
		
		$this->db->select(' tbl_materials.MaterialName ');			
		$this->db->select(' tbl_materials.MaterialID ');		
		$this->db->select(' tbl_materials.SicCode ');			 
        $this->db->select(' tbl_booking1.SICCode as LoadSICCODE ');		
		
		$this->db->select(' tbl_booking_request.CompanyName ');    
		$this->db->select(' tbl_booking_request.OpportunityName ');	  
		 
		$this->db->select(' tbl_tipaddress.TipName ');	 
		$this->db->select(' tbl_tipaddress.PermitRefNo ');	
		$this->db->select(' tbl_tipaddress.Street1 ');	
		$this->db->select(' tbl_tipaddress.Street2 ');	
		$this->db->select(' tbl_tipaddress.Town ');	
		$this->db->select(' tbl_tipaddress.County ');	
		$this->db->select(' tbl_tipaddress.PostCode ');	
		
		$this->db->select(' tbl_drivers.Haulier ');	 
		$this->db->select(' tbl_drivers.DriverName as lorry_driver_name ');	 
		$this->db->select(' tbl_drivers.RegNumber as lorry_RegNumber');	 
		$this->db->select(' tbl_drivers.Tare  as lorry_tare');	  
		$this->db->select(' tbl_drivers.Signature  as driver_signature');	  
		$this->db->select(' tbl_drivers.ltsignature as lorry_signature');	 
		
		$this->db->select(' tbl_drivers_login.Signature as dsignature ');	 
		$this->db->from('tbl_booking_loads1'); 
        $this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID', 'LEFT');
        $this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID', 'LEFT');
        $this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo', 'LEFT');
        $this->db->join('tbl_drivers_login', 'tbl_booking_loads1.DriverLoginID = tbl_drivers_login.DriverID', 'LEFT');
        $this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID', 'LEFT');
        $this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID', 'LEFT');
		 
        $this->db->where('tbl_booking_loads1.ConveyanceNo', $conveyanceNo);
        $query = $this->db->get();

        // Debug: Output the query to verify it
        // echo $this->db->last_query();
        print_r($query->result());
        die();
        // Return the result
        return $query->row();
	}


    /*
     * Get rows from the Driver table
     */
    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from($this->Tbl);
        
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            foreach($params['conditions'] as $key => $value){
                $this->db->where($key,$value);
            }
        }
        
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();    
            }elseif(array_key_exists("returnType",$params) && $params['returnType'] == 'single'){
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->row_array():false;
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():false;
            }
        }

        //return fetched data
        return $result;
    }
    
    /*
     * Insert Driver data
     */
    public function insert($data){
        //add created and modified date if not exists
        if(!array_key_exists("CreateDate", $data)){
            $data['CreateDate'] = date("Y-m-d H:i:s");
        }
        if(!array_key_exists("EditUserDate", $data)){
            $data['EditUserDate'] = date("Y-m-d H:i:s");
        }
        
        //insert Driver data to users table
        $insert = $this->db->insert($this->Tbl, $data);
        
        //return the status
        return $insert?$this->db->insert_id():false;
    }
    
    /*
     * Update Driver data
     */
    public function update($data, $LorryNo){
        //add modified date if not exists
        if(!array_key_exists('EditUserDate', $data)){
            $data['EditUserDate'] = date("Y-m-d H:i:s");
        }
        
        //update Driver data in users table
        $update = $this->db->update($this->Tbl, $data, array('LorryNo'=>$LorryNo));
        
        //return the status
        return $update?true:false;
    }
    
    /*
     * Delete Driver data
     */
    public function delete($id){
        //update Driver from users table
        $delete = $this->db->delete('users',array('id'=>$id));
        //return the status
        return $delete?true:false;
    }
    
    function GetBookingInfo($id){
		$this->db->select('tbl_booking1.*,tbl_booking1.SICCode as Booking_SICCode,tbl_booking_request.CompanyID,tbl_booking_request.CompanyName,tbl_booking_request.OpportunityID,tbl_booking_request.OpportunityName,tbl_booking_request.ContactID,tbl_booking_request.ContactName,tbl_booking_request.ContactMobile,tbl_booking_request.ContactEmail,tbl_booking_request.PurchaseOrderNumber,tbl_booking_request.PriceBy,tbl_booking_request.WaitingTime,tbl_booking_request.WaitingCharge,tbl_booking_request.Notes,tbl_booking_request.SubTotalAmount,tbl_booking_request.VatAmount,tbl_booking_request.PaymentType,tbl_booking_request.PaymentRefNo,tbl_materials.SicCode');   
		//$this->db->select('(select tbl_materials.SicCode FROM tbl_materials where tbl_materials.MaterialID = tbl_booking1.MaterialID ) as SicCode '); 		
        $this->db->join('tbl_booking_request', 'tbl_booking1.BookingRequestID = tbl_booking_request.BookingRequestID');
        $this->db->join('tbl_materials', 'tbl_booking1.MaterialID =  tbl_materials.MaterialID');
        $this->db->from('tbl_booking1'); 
        $this->db->where('tbl_booking1.BookingID',$id);		
		$query = $this->db->get(); 
		return $query->row();
		//return $query->row_array();
	}
	
	function LastConNumber(){
		$this->db->select('ConveyanceNo');    
        $this->db->from('tbl_booking_loads1');         
		$this->db->order_by('ConveyanceNo', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}	

}
  