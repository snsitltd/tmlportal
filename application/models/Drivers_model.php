<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Drivers_model extends CI_Model
{
	
	function DriverLoginList($LorryNo){  
		$this->db->select('tbl_drivers_login.DriverName');
		$this->db->select('tbl_drivers_login.DriverID');
		$this->db->select('tbl_drivers_login.MobileNo');
		$this->db->from('tbl_drivers_login'); 
		$this->db->where('tbl_drivers_login.DriverName <> ""');
		$this->db->where('tbl_drivers_login.DriverID <> 0');
		$this->db->where('tbl_drivers_login.MobileNo <> ""');
		$this->db->where('tbl_drivers_login.Password <> ""'); 
		$this->db->where('tbl_drivers_login.Status = 0');  
		$this->db->order_by('tbl_drivers_login.DriverName', 'ASC'); 
		$query = $this->db->get();
		return $result = $query->result();     
	}
	function LorryBasicInfo($LorryNo){  
		$this->db->select('tbl_drivers.LorryNo  ');
 		$this->db->select('tbl_drivers.DriverName  '); 
		$this->db->select('tbl_drivers.RegNumber '); 
		$this->db->select('tbl_drivers.DriverID ');  
		$this->db->from('tbl_drivers');   
		$this->db->where('tbl_drivers.LorryNo',$LorryNo); 
		$query = $this->db->get();
		return $result = $query->row_array();     
	}
	function UpdateLorry($LorryNo,$DriverID,$RegNumber){
        $sql="UPDATE `tbl_drivers` set `DriverID` = '0' where `DriverID` =  '".$DriverID."' ";    
		$result = $this->db->query($sql);
		
		$sql1="UPDATE `tbl_drivers` set `DriverID` =  '".$DriverID."' , `AppUser` = 0  where `RegNumber` =  '".$RegNumber."' ";    
		$result1 = $this->db->query($sql1);
		 
		return $result1; 
    }
	function CheckLorryDriverAllocation($LorryNo,$DriverID){
        $sql="select count(*) as cnt from `tbl_booking_loads1`  where `DriverID` =  '".$LorryNo."' and `DriverLoginID` =  '".$DriverID."' and Status < 4  ";    
		$query = $this->db->query($sql); 
		return $result = $query->row_array();    
    }
	
	function checkDriverMobileExists($key){
		$this->db->where('MobileNo',$key);
		$this->db->where('Status',0);
		$query = $this->db->get('tbl_drivers_login');
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
	function checkDriverUserNameExists($key){
		$this->db->where('UserName',$key); 
		$query = $this->db->get('tbl_drivers_login');
		if ($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}	
	function DriverDetails($id){  
		$this->db->select('tbl_drivers_login.DriverName');
		$this->db->select('tbl_drivers_login.DriverID');
		$this->db->select('tbl_drivers_login.MobileNo');
		$this->db->select('tbl_drivers_login.Email');
		$this->db->select('tbl_drivers_login.Signature');
		$this->db->select('tbl_drivers_login.ltsignature'); 
		$this->db->select('tbl_drivers_login.Status');
		$this->db->select('tbl_drivers_login.UserName');
		//$this->db->select('tbl_drivers.LorryNo');
		//$this->db->select('tbl_drivers.RegNumber');
		//$this->db->select('tbl_drivers.Haulier');
		//$this->db->select('tbl_drivers.Tare'); 
		$this->db->from('tbl_drivers_login');
		//$this->db->join('tbl_drivers', 'tbl_drivers_login.DriverID = tbl_drivers.DriverID ','left');          
		$this->db->where('tbl_drivers_login.DriverID',$id); 
		$query = $this->db->get();
		return $result = $query->row_array();     
	}
	
	
	function SubcontractorDetails($id){  
		$this->db->select('tbl_driver_subscontractor.*'); 
		$this->db->from('tbl_driver_subscontractor'); 
		$this->db->where('tbl_driver_subscontractor.ContractorID',$id); 
		$query = $this->db->get();
		return $result = $query->row_array();     
	}
	public function GetDriverData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	    
			$this->db->start_cache(); 
 
			$this->db->select('tbl_drivers.DriverName ');  
			$this->db->select('tbl_drivers.LorryNo ');  
			$this->db->select('tbl_drivers.RegNumber');
			$this->db->select('tbl_drivers.Identifier');
			$this->db->select('tbl_drivers.MacAddress');
			$this->db->select('tbl_drivers.ContractorID'); 
			$this->db->select('tbl_drivers.Tare'); 
			$this->db->select('tbl_drivers.AppUser');  
			$this->db->select('tbl_drivers.is_lorry_assigned');  
			$this->db->from('tbl_drivers');    
			$this->db->where('tbl_drivers.LorryNo  <> ""'); 	  
			$this->db->where('tbl_drivers.ContractorID = "1" '); 	  
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();  
						$this->db->like('tbl_drivers.LorryNo', $s[$i]); 
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);
						$this->db->or_like('tbl_drivers.Tare', $s[$i]);  
						$this->db->or_like('tbl_drivers.MacAddress', $s[$i]);  
						$this->db->or_like('tbl_drivers.Identifier', $s[$i]);  
						$this->db->group_end(); 
					}
				}   
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_drivers')->num_rows();
			} 
			$this->db->stop_cache();
			$this->db->group_by('tbl_drivers.LorryNo'); 
			$this->db->order_by($columnName, $columnSortOrder);			  
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_drivers');
			//echo $this->db->last_query();       
			//exit;
			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_drivers')->num_rows();
			$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        }   
		
		public function GetDriverDataOthers(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	    
			$this->db->start_cache();  
			 
			$this->db->select('tbl_drivers.LorryNo  '); 
			$this->db->select('tbl_drivers.DriverName');  
			$this->db->select('tbl_drivers.RegNumber');
			$this->db->select('tbl_drivers.ContractorID'); 
			$this->db->select('tbl_drivers.Tare');
			$this->db->select('tbl_drivers.Haulier');     
			$this->db->select('tbl_drivers.AppUser');  
			$this->db->from('tbl_drivers');   
			$this->db->where('tbl_drivers.LorryNo  <> ""');
			$this->db->where('tbl_drivers.ContractorID <> "1" ');
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();  
						$this->db->like('tbl_drivers.LorryNo', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);
						$this->db->or_like('tbl_drivers.Tare', $s[$i]); 
						$this->db->or_like('tbl_drivers.Haulier', $s[$i]);  
						$this->db->group_end(); 
					}
				}   
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_drivers')->num_rows();
			} 
			$this->db->stop_cache();
			$this->db->order_by($columnName, $columnSortOrder);			  
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_drivers');
			//echo $this->db->last_query();       
			//exit;
			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_drivers')->num_rows();
			$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        }   
		
		public function GetLorryData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	    
			$this->db->start_cache(); 

			 
			$this->db->select('tbl_drivers.LorryNo  '); 
			$this->db->select('tbl_drivers.DriverName');  
			$this->db->select('tbl_drivers.RegNumber');
			$this->db->select('tbl_drivers.ContractorID'); 
			$this->db->select('tbl_drivers.Tare');
			$this->db->select('tbl_drivers.Haulier');     
			$this->db->select('tbl_drivers.AppUser');  
			$this->db->from('tbl_drivers'); 
			 
			$this->db->where('tbl_drivers.LorryNo  <> ""'); 	  
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();  
						$this->db->like('tbl_drivers.LorryNo', $s[$i]);
						$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers.RegNumber', $s[$i]);
						$this->db->or_like('tbl_drivers.Tare', $s[$i]); 
						$this->db->or_like('tbl_drivers.Haulier', $s[$i]);  
						$this->db->group_end(); 
					}
				}   
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_drivers')->num_rows();
			} 
			$this->db->stop_cache();
			$this->db->order_by($columnName, $columnSortOrder);			  
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_drivers');
			//echo $this->db->last_query();       
			//exit;
			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_drivers')->num_rows();
			$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        } 
		public function GetDriverLoginData(){ 
			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 

			$this->db->select('tbl_drivers_login.DriverID '); 
			$this->db->select('tbl_drivers_login.UserName');
			$this->db->select('tbl_drivers_login.DriverName');
			$this->db->select('tbl_drivers_login.MobileNo'); 
			$this->db->select('tbl_drivers_login.Status');      
			$this->db->from('tbl_drivers_login');  
			$this->db->where('tbl_drivers_login.Status','0'); 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();   
						$this->db->or_like('tbl_drivers_login.UserName', $s[$i]); 
						$this->db->or_like('tbl_drivers_login.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers_login.MobileNo', $s[$i]); 
						$this->db->group_end(); 
					}
				}   
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_drivers_login')->num_rows();
			} 
			$this->db->stop_cache();
			$this->db->group_by('tbl_drivers_login.DriverID');             
			$this->db->order_by($columnName, $columnSortOrder);			  
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_drivers_login');
			//echo $this->db->last_query();       
			//exit;
			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_drivers_login')->num_rows();
			$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        }  	
		
		public function GetDriverLoginDataDeleted(){ 
			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 

			$this->db->select('tbl_drivers_login.DriverID '); 
			$this->db->select('tbl_drivers_login.UserName');
			$this->db->select('tbl_drivers_login.DriverName');
			$this->db->select('tbl_drivers_login.MobileNo'); 
			$this->db->select('tbl_drivers_login.Status');      
			$this->db->from('tbl_drivers_login');  
			$this->db->where('tbl_drivers_login.Status','1'); 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();   
						$this->db->or_like('tbl_drivers_login.UserName', $s[$i]); 
						$this->db->or_like('tbl_drivers_login.DriverName', $s[$i]); 
						$this->db->or_like('tbl_drivers_login.MobileNo', $s[$i]); 
						$this->db->group_end(); 
					}
				}   
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_drivers_login')->num_rows();
			} 
			$this->db->stop_cache();
			$this->db->group_by('tbl_drivers_login.DriverID');             
			$this->db->order_by($columnName, $columnSortOrder);			  
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_drivers_login');
			//echo $this->db->last_query();       
			//exit;
			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_drivers_login')->num_rows();
			$totalFiltered =  $totalData; 
			
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data  // total data array
			); 
			return $return; 
        }  	
		
		public function GetSubcontractorData(){ 
			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
			  
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 
			$this->db->select('(select count(*) from tbl_drivers where tbl_drivers.ContractorID = tbl_driver_subscontractor.ContractorID ) as TotalLorry');
			$this->db->select('tbl_driver_subscontractor.ContractorID');
			$this->db->select('tbl_driver_subscontractor.CompanyName');
			$this->db->select('tbl_driver_subscontractor.Email');
			$this->db->select('tbl_driver_subscontractor.Town');
			$this->db->select('tbl_driver_subscontractor.County');
			$this->db->select('tbl_driver_subscontractor.PostCode'); 
			$this->db->select('tbl_driver_subscontractor.Mobile');   
			$this->db->where('tbl_driver_subscontractor.CompanyName <> ""'); 	 
			$this->db->where('tbl_driver_subscontractor.ContractorID >1'); 	 
			if( !empty($searchValue) ){   
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
						 $this->db->group_start();  
						$this->db->like('tbl_driver_subscontractor.CompanyName', $s[$i]);
						$this->db->or_like('tbl_driver_subscontractor.Town', $s[$i]); 
						$this->db->or_like('tbl_driver_subscontractor.County', $s[$i]);
						$this->db->or_like('tbl_driver_subscontractor.PostCode', $s[$i]); 
						$this->db->or_like('tbl_driver_subscontractor.Mobile', $s[$i]);  
						$this->db->group_end();  
					}
				}    
			}
			  
			$this->db->order_by($columnName, $columnSortOrder);		 
			$query = $this->db->get('tbl_driver_subscontractor');
			//echo $this->db->last_query();       
			//exit;
			
			$this->db->stop_cache();
			
			//Reset Key Array
			$data = array();
			$data = $query->result_array();
			$totalData  = $this->db->count_all_results();
			$totalFiltered =  $totalData; 
			 
			//Prepare Return Data
			$return = array(
					"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => $totalData,  // total number of records
					"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array 
			); 
			return $return;  
		
        }
		function getCounty()
		{
			$this->db->select('*');
			$this->db->from('county');
			//$this->db->where('ID !=', 1);
			$query = $this->db->get();
			
			return $query->result();
		}
}

  