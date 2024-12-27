<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Contacts_model extends CI_Model
{
        
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function contactsListing()
    {
        $this->db->select('c.*, com.CompanyName,ctc.CompanyID');
        $this->db->from('contacts as c'); 
        $this->db->join('company_to_contact  ctc','ctc.ContactID=c.ContactID', "LEFT");
        $this->db->join('company com','com.CompanyID=ctc.CompanyID', "LEFT");         
		$this->db->where("c.ContactName <> ''" );  
        $this->db->order_by('c.ContactName', 'ASC');
       // $this->db->limit($page, $segment);
        $query = $this->db->get(); 
        $result = $query->result();        
        return $result;
    } 


    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function getContactInformation($id){
        $this->db->select('con.*,com.*');
        $this->db->from('contacts con');
        $this->db->join('company_to_contact  ctc','ctc.ContactID=con.ContactID');
        $this->db->join('company com','com.CompanyID=ctc.CompanyID');        
        $this->db->where("con.ContactID", $id);  
		$this->db->group_by("con.ContactID");
        $query=$this->db->get();
        //echo $this->db->last_query();  
       return $query->row_array();
    }
	function getViewContact($id){
        $this->db->select('con.*');
        $this->db->from('contacts con'); 
        $this->db->where("con.ContactID", $id);   
        $query=$this->db->get();
        //echo $this->db->last_query();  
       return $query->row_array();
    }
	
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function getContactlist($CompanyID)
    {
        
        $this->db->select('con.*');
        $this->db->from('contacts con');
        $this->db->join('company_to_contact  ctc','ctc.ContactID=con.ContactID');               
        $this->db->where("ctc.CompanyID", $CompanyID);  
        $query=$this->db->get();
        //echo $this->db->last_query();
       return $query->result_array();

    }

    function getAllContactlist()
    {
        
        $this->db->select('con.*');
        $this->db->from('contacts con');
         
        $query=$this->db->get();
       // echo $this->db->last_query();
       return $query->result_array();

    }



    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewContacts($contactInfo)
    {
        $this->db->trans_start();
        $this->db->insert('contacts', $contactInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }

      /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function relationWithContact($rel)
    {
        $this->db->trans_start();
        $this->db->insert('company_to_contact', $rel);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }     
	public function GetContactData(){ 
			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 
			$this->db->select('tbl_contacts.ContactID ');
			$this->db->select('tbl_contacts.Title ');
			$this->db->select('tbl_contacts.ContactName ');
			$this->db->select('tbl_contacts.MobileNumber ');
			$this->db->select('tbl_contacts.EmailAddress ');
			$this->db->select('tbl_contacts.Department ');
			$this->db->select('tbl_contacts.Position ');
			$this->db->select('tbl_company.CompanyName, tbl_company_to_contact.CompanyID');
			$this->db->select('tbl_opportunities.OpportunityName ');
			$this->db->select('tbl_opportunities.OpportunityID '); 
			$this->db->join('tbl_company_to_contact ','tbl_contacts.ContactID = tbl_company_to_contact.ContactID ',"LEFT" );
			$this->db->join('tbl_company','tbl_company_to_contact.CompanyID =tbl_company.CompanyID',"LEFT" );        
			$this->db->join('tbl_opportunity_to_contact','tbl_contacts.ContactID = tbl_opportunity_to_contact.ContactID',"LEFT" );
			$this->db->join('tbl_opportunities','tbl_opportunity_to_contact.OpportunityID  = tbl_opportunities.OpportunityID',"LEFT" );       
			$this->db->where('tbl_contacts.ContactName  <> ""'); 	  
			
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();  
						//$this->db->like('tbl_contacts.Title', $s[$i]);
						$this->db->or_like('tbl_contacts.ContactName', $s[$i]); 
						$this->db->or_like('tbl_contacts.MobileNumber', $s[$i]);
						$this->db->or_like('tbl_contacts.EmailAddress', $s[$i]); 
						$this->db->or_like('tbl_contacts.Department', $s[$i]);  
						$this->db->or_like('tbl_contacts.Position', $s[$i]);  
						$this->db->or_like('tbl_company.CompanyName', $s[$i]);  
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);  
						$this->db->group_end(); 
					}
				}     
			}                
			$this->db->order_by($columnName, $columnSortOrder);			  
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_contacts');
			$this->db->stop_cache();
			
			$data = array();
			$data = $query->result_array();
			//$totalData  = $this->db->count_all_results();
			$totalData  = $this->db->count_all_results();
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

  