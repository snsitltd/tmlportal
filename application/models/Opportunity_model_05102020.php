<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Opportunity_model extends CI_Model
{
        
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function opportunityListing()
    {
        $this->db->select('op.OpportunityName');
		$this->db->select('op.Town');
		$this->db->select('op.County');
		$this->db->select('op.PostCode');
		$this->db->select('op.OpportunityID'); 
		$this->db->select('op.CreateDate'); 
		$this->db->select('c.CompanyID, c.CompanyName  ');
        $this->db->from('opportunities op');
        $this->db->join('company_to_opportunities  cto','cto.OpportunityID=op.OpportunityID', "LEFT");  
        $this->db->join('company c','c.CompanyID=cto.CompanyID', "LEFT");  
        //$this->db->where("otc.ContactID <> ''" );  		
		$this->db->group_by("op.OpportunityID");
        $this->db->order_by('op.OpportunityID', 'DESC');
		//$this->db->limit('10');
       // $this->db->limit($page, $segment);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        
        $result = $query->result();        
        return $result;
    }
	function wifopportunityListing()
    {
        $this->db->select('td.DocumentNumber'); 
		$this->db->select('td.DocumentAttachment'); 
		$this->db->select('to.OpportunityName'); 
		$this->db->select('to.OpportunityID');  
		$this->db->select('c.CompanyID, c.CompanyName  ');
        $this->db->from('tbl_documents td');
		$this->db->join('tbl_opportunity_to_document  od','td.DocumentID=od.DocumentID', "LEFT");  
		$this->db->join('tbl_opportunities  to','od.OpportunityID=to.OpportunityID', "LEFT");  
        $this->db->join('company_to_opportunities  cto','cto.OpportunityID=to.OpportunityID', "LEFT");  
        $this->db->join('company c','c.CompanyID=cto.CompanyID', "LEFT");   
		$this->db->where("td.DocumentType", '1'); 
		$this->db->where("td.DocumentAttachment <> ''" );  
		$this->db->group_by("td.DocumentID");
        $this->db->order_by('to.OpportunityName', 'ASC'); 
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        
        $result = $query->result();        
        return $result;
    }
    function getOpportunityInformation($id)
    { 
        $this->db->select('op.*,cto.CompanyID,otc.ContactID');
        $this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID  = cto.CompanyID ) as CompanyName '); 						
        $this->db->select(' DATE_FORMAT(op.OpenDate,"%d/%m/%Y ") as OpenDate1 ');  		
        $this->db->select(' DATE_FORMAT(op.CloseDate,"%d/%m/%Y ") as CloseDate1 ');   
        $this->db->from('opportunities op');
        $this->db->join('company_to_opportunities  cto','cto.OpportunityID=op.OpportunityID', "LEFT");
        $this->db->join('opportunity_to_contact otc','otc.OpportunityID=op.OpportunityID', "LEFT");        
        $this->db->where("op.OpportunityID", $id);  
		$this->db->group_by("op.OpportunityID");		
        $query=$this->db->get();
        //echo $this->db->last_query();
		//exit;
       return $query->row_array(); 
    }

    function getOpportunityView($id){
        
        $this->db->select(' DATE_FORMAT(op.OpenDate,"%d/%m/%Y ") as OpenDate1 ');  		
		$this->db->select(' DATE_FORMAT(op.CloseDate,"%d/%m/%Y ") as CloseDate1 ');  		
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID  = cto.CompanyID ) as CompanyName '); 						
		$this->db->select('op.*,cto.CompanyID');
        $this->db->from('opportunities op'); 
        $this->db->join('company_to_opportunities  cto','cto.OpportunityID=op.OpportunityID', "LEFT");
        $this->db->where("op.OpportunityID", $id);  
		$this->db->group_by("op.OpportunityID");			
        $query=$this->db->get();
        //echo $this->db->last_query();
		//exit;
       return $query->row_array(); 
    }

    function getOpportunityContactInformation($id)
    { 
        $this->db->select('tbl_opportunity_to_contact.*');
		$this->db->select('tbl_contacts.*');
        $this->db->from('tbl_opportunity_to_contact');
        $this->db->join('tbl_contacts ','tbl_contacts.ContactID=tbl_opportunity_to_contact.ContactID');    
        $this->db->where("tbl_opportunity_to_contact.OpportunityID", $id);  
		$this->db->group_by("tbl_opportunity_to_contact.ContactID");
		//$this->db->group_by("tbl_opportunity_to_contact.OpportunityID");
        $query=$this->db->get();
        //echo $this->db->last_query();
       return $query->result(); 
    }

    function getMaterialList(){
        $this->db->select('MaterialID');
		$this->db->select('MaterialCode');
        $this->db->from('materials'); 
		$this->db->where("MaterialCode <> ''");  
        $this->db->order_by('MaterialName', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

	function GetMaterialDetails($code){
       
        $this->db->select('MaterialName');
        $this->db->from('materials'); 
        $this->db->where('MaterialCode', $code);
        $query = $this->db->get(); 
        $result = $query->row();        
        return $result;  
    }
	
    function getProductInformation($id)
    { 
        $this->db->select('*');
        $this->db->from('tbl_product'); 
        $this->db->where("tbl_product.productid", $id);  
        $query=$this->db->get();
        //echo $this->db->last_query();
       return $query->row_array(); 
    }

    function getContactInformation($id)
    { 
        $this->db->select('*');
        $this->db->from('tbl_contacts'); 
        $this->db->where("tbl_contacts.ContactID", $id);  
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
        
        $this->db->select('con.ContactID,con.ContactName');
        $this->db->from('contacts con');
        $this->db->join('company_to_contact  ctc','ctc.ContactID=con.ContactID');               
        $this->db->where("ctc.CompanyID", $CompanyID); 
         
        $query=$this->db->get();
        //echo $this->db->last_query();
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


    function getAllNotes($OpportunityID)
    {
        //echo $this->session->userdata['userId'];die; NoteType
        $this->db->select('n.*, u.name');
        $this->db->from('notes as n');
        $this->db->join('users as u', 'u.userId = n.CreateUserID');
        $this->db->join('opportunity_to_note as otn', 'otn.NoteID = n.NotesID'); 
        $this->db->order_by('n.NotesID', 'ASC');
        $this->db->where('otn.OpportunityID', $OpportunityID);
        $where = '(n.CreateUserID="'.$this->session->userdata['userId'].'" or n.NoteType = 0)';
        $this->db->where($where);
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

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


	function getAllDocumnets($OpportunityID)
    {
        $this->db->select('d.*, u.name');
        $this->db->from('documents as d');
        $this->db->join('users as u', 'u.userId = d.CreatedUserID');
        $this->db->join('opportunity_to_document as otd', 'otd.DocumentID = d.DocumentID'); 
        $this->db->order_by('d.DocumentID', 'ASC');
        $this->db->where('otd.OpportunityID', $OpportunityID);
        // $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    } 
	
	public function GetOpportunityData(){

			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
	   
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 

			$this->db->select('tbl_opportunities.OpportunityName');
			$this->db->select('tbl_opportunities.Town');
			$this->db->select('tbl_opportunities.County');
			$this->db->select('tbl_opportunities.PostCode');
			$this->db->select('tbl_opportunities.OpportunityID'); 
			$this->db->select('tbl_opportunities.CreateDate'); 
			$this->db->select('tbl_company.CompanyID, tbl_company.CompanyName  ');
			$this->db->from('tbl_opportunities');
			$this->db->join('tbl_company_to_opportunities ','tbl_company_to_opportunities.OpportunityID = tbl_opportunities.OpportunityID', "LEFT");  
			$this->db->join('tbl_company ','tbl_company.CompanyID = tbl_company_to_opportunities.CompanyID', "LEFT");    
			$this->db->where('tbl_opportunities.OpportunityName <> ""'); 	 
			$this->db->where('tbl_opportunities.OpportunityName <> ", , ,"'); 	 
			// if there is a search parameter, $_REQUEST['search']['value'] contains search parameter 
			if( !empty($searchValue) ){ 
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
					    $this->db->group_start();  
						$this->db->like('tbl_opportunities.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_opportunities.Town', $s[$i]); 
						$this->db->or_like('tbl_opportunities.County', $s[$i]);
						$this->db->or_like('tbl_opportunities.PostCode', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]);  
						$this->db->group_end(); 
					}
				}  
						
						$this->db->stop_cache();

				$totalFiltered  = $this->db->get('tbl_opportunities')->num_rows();
			}
			$this->db->group_by("tbl_opportunities.OpportunityID");
			$this->db->stop_cache();
			if($columnName==""){   
				$this->db->order_by("tbl_opportunities.tsupdate_datetime ", "desc");			 
			}else{
				$this->db->order_by($columnName, $columnSortOrder);			  
			}
			$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
			$query = $this->db->get('tbl_opportunities');

			//Reset Key Array
			$data = array();
			foreach ($query->result_array() as $val) {
					$data[] = $val;
					//$data[] = array_values($val);
			}
			$totalData  = $this->db->get('tbl_opportunities')->num_rows();
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

  