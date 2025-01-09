<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Booking_API_Model extends CI_Model
{
    
    public function __construct() {
        parent::__construct();
        
        // Load the database library
        $this->load->database();
        $this->Tbl = 'tbl_booking';
    }

    function getLoadInfoByConveyanceNo($conveyanceNumber){
        print_r($conveyanceNumber);
        die();
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
		$this->db->select('tbl_booking.*');   
		$this->db->select('(select tbl_materials.SicCode FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as SicCode '); 		
        $this->db->from('tbl_booking'); 
        $this->db->where('tbl_booking.BookingID',$id);		
		$query = $this->db->get(); 
		return $query->row();
		//return $query->row_array();
	}
	
	function LastConNumber(){
		$this->db->select('ConveyanceNo');    
        $this->db->from('tbl_booking_loads');         
		$this->db->order_by('ConveyanceNo', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}	

}
  