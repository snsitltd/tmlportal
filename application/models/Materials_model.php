<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Materials_model extends CI_Model
{ 
	public function GetMaterialData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 

			$this->db->select('tbl_materials.MaterialID ');
			$this->db->select('tbl_materials.MaterialCode');
			$this->db->select('tbl_materials.MaterialName');
			$this->db->select('tbl_materials.Operation');
			$this->db->select('tbl_materials.SicCode');
			$this->db->select('tbl_materials.PriceID');    
			$this->db->from('tbl_materials'); 
			$this->db->where('tbl_materials.MaterialID <> ""'); 	 
			$this->db->where('tbl_materials.Status = 1'); 	 
			// if there is a search parameter, $_REQUEST['search']['value'] contains search parameter 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();  
						$this->db->like('tbl_materials.MaterialCode', $s[$i]);
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_materials.Operation', $s[$i]);
						$this->db->or_like('tbl_materials.SicCode', $s[$i]); 
						$this->db->or_like('tbl_materials.PriceID', $s[$i]);  
						$this->db->group_end(); 
					}
				}  
						
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_materials')->num_rows();
			} 
			$this->db->stop_cache();
			$this->db->order_by($columnName, $columnSortOrder);			  
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_materials');

			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_materials')->num_rows();
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
		
		public function GetMaterialDataInActive(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 

			$this->db->select('tbl_materials.MaterialID ');
			$this->db->select('tbl_materials.MaterialCode');
			$this->db->select('tbl_materials.MaterialName');
			$this->db->select('tbl_materials.Operation');
			$this->db->select('tbl_materials.SicCode');
			$this->db->select('tbl_materials.PriceID');    
			$this->db->from('tbl_materials'); 
			$this->db->where('tbl_materials.MaterialID <> ""'); 	 
			$this->db->where('tbl_materials.Status = 0'); 	 
			// if there is a search parameter, $_REQUEST['search']['value'] contains search parameter 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();  
						$this->db->like('tbl_materials.MaterialCode', $s[$i]);
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_materials.Operation', $s[$i]);
						$this->db->or_like('tbl_materials.SicCode', $s[$i]); 
						$this->db->or_like('tbl_materials.PriceID', $s[$i]);  
						$this->db->group_end(); 
					}
				}  
						
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_materials')->num_rows();
			} 
			$this->db->stop_cache();
			$this->db->order_by($columnName, $columnSortOrder);			  
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_materials');

			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_materials')->num_rows();
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
}

  