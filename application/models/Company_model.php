<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model
{
    
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function companyListing()
    {
        $this->db->select('c.*, u.name');
        $this->db->from('company as c');
        $this->db->join('users as u', 'u.userId = c.CreateUserID', "LEFT"); 
        $this->db->order_by('c.CreateDate', 'DESC');
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }    
 
    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getCounty()
    {
        $this->db->select('*');
        $this->db->from('county');
        //$this->db->where('ID !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }


    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getCountry()
    {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->where('id !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }   
   
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewCompany($companyInfo)
    {
        $this->db->trans_start();
        $this->db->insert('company', $companyInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }


    function getAllNotes($CompanyID)
    {
        $this->db->select('n.*, u.name');
        $this->db->from('notes as n');
        $this->db->join('users as u', 'u.userId = n.CreateUserID');
        $this->db->join('company_to_note as ctn', 'ctn.NoteID = n.NotesID'); 
        $this->db->order_by('n.NotesID', 'ASC');
        $this->db->where('ctn.CompanyID', $CompanyID);
        $where = '(n.CreateUserID="'.$this->session->userdata['userId'].'" or n.NoteType = 0)';
        $this->db->where($where);
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    } 



    function getSingleNote($NotesID)
    {
        $this->db->select('n.*, u.name');
        $this->db->from('notes as n');
        $this->db->join('users as u', 'u.userId = n.CreateUserID');         
        $this->db->order_by('n.NotesID', 'DESC');
        $this->db->where('n.NotesID', $NotesID);
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->row();        
        return $result;
    } 


    function getAllDocumnets($CompanyID)
    {
        $this->db->select('d.*, u.name');
        $this->db->from('documents as d');
        $this->db->join('users as u', 'u.userId = d.CreatedUserID');
        $this->db->join('company_to_document as ctd', 'ctd.DocumentID = d.DocumentID'); 
        $this->db->order_by('d.DocumentID', 'ASC');
        $this->db->where('ctd.CompanyID', $CompanyID);
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    } 

	
	public function GetCompanyData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 

			$this->db->select('tbl_company.CompanyName');
			$this->db->select('tbl_company.EmailID');
			$this->db->select('tbl_company.Town');
			$this->db->select('tbl_company.County');
			$this->db->select('tbl_company.PostCode');
			$this->db->select('tbl_company.CompanyID');   
			$this->db->select('tbl_company.Status'); 
			$this->db->select('tbl_company.Phone1');  
			$this->db->from('tbl_company'); 
			$this->db->where('tbl_company.CompanyName <> ""'); 	 
			// if there is a search parameter, $_REQUEST['search']['value'] contains search parameter 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();  
						$this->db->like('tbl_company.CompanyName', $s[$i]);
						$this->db->or_like('tbl_company.Town', $s[$i]); 
						$this->db->or_like('tbl_company.County', $s[$i]);
						$this->db->or_like('tbl_company.PostCode', $s[$i]); 
						$this->db->or_like('tbl_company.Phone1', $s[$i]);  
						$this->db->group_end(); 
					}
				}  
						
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_company')->num_rows();
			} 
			$this->db->stop_cache();
			if($columnName==""){   
				$this->db->order_by("tbl_company.tsupdate_datetime ", "desc");			 
			}else{
				$this->db->order_by($columnName, $columnSortOrder);			  
			}
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_company');

			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_company')->num_rows();
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

  