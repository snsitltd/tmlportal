<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Opportunity_model extends CI_Model
{ 
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
	function OppoTipNameList($OpportunityID)
    {
        $this->db->select(' tbl_tipaddress.TipName ');   
		$this->db->select(' DATE_FORMAT(tbl_opportunity_tip.CreateDateTime,"%d/%m/%Y ") as TipDT  ');   
        $this->db->from('tbl_opportunity_tip'); 
		$this->db->join('tbl_tipaddress','tbl_opportunity_tip.TipID=tbl_tipaddress.TipID', "LEFT");    
		$this->db->where("tbl_opportunity_tip.OpportunityID",$OpportunityID  );   
		$this->db->where("tbl_opportunity_tip.Status", '0');   
        //$this->db->group_by("op.OpportunityID");
		$this->db->order_by('tbl_tipaddress.TipName', 'ASC'); 
        $query = $this->db->get();
		
       // echo $this->db->last_query();  
		//exit;
        
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
		$this->db->where("c.CompanyName <> '' "); 
		$this->db->where("to.OpportunityName <> '' "); 
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
	function GetOppoMaterialList($id)
    { 
        $this->db->select('(select count(*) from tbl_booking_date1 where tbl_booking_date1.BookingID = tbl_booking1.BookingID ) as TotalDays ');  
        $this->db->select('tbl_product.productid'); 
		$this->db->select('tbl_product.MaterialID');
		$this->db->select('tbl_materials.MaterialName');
		$this->db->select('tbl_materials.MaterialCode'); 
		$this->db->select('tbl_product.Qty'); 
		
		$this->db->select('tbl_booking1.BookingID'); 
		$this->db->select('tbl_product.LorryType as ProductLorryType'); 
		
		$this->db->select('tbl_booking_request.PaymentRefNo'); 
		$this->db->select('tbl_booking_request.BookingRequestID'); 
		$this->db->select('tbl_booking1.LorryType'); 
		$this->db->select('tbl_booking1.TonBook'); 
		$this->db->select('tbl_booking1.LoadType'); 
		
		$this->db->select('tbl_product.JobNo'); 
		$this->db->select('tbl_product.Comments'); 
		$this->db->select('ROUND(tbl_product.UnitPrice,2) as UnitPrice '); 
		$this->db->select('tbl_product.PurchaseOrderNo');  
        $this->db->select(' DATE_FORMAT(tbl_product.DateRequired,"%d/%m/%Y ") as DateRequired ');   
		$this->db->select(' tbl_product.DateRequired as DateRequired1 ');   
		$this->db->select(' tbl_users.name as PriceByName ');   
        $this->db->from('tbl_product');
        $this->db->join('tbl_materials','tbl_product.MaterialID=tbl_materials.MaterialID', "LEFT");      
		//$this->db->join('tbl_booking1','tbl_product.BookingID=tbl_booking1.BookingID', "LEFT");      
		$this->db->join('tbl_booking_date1','tbl_product.BookingDateID=tbl_booking_date1.BookingDateID', "LEFT");      
		$this->db->join('tbl_booking1','tbl_booking_date1.BookingID=tbl_booking1.BookingID', "LEFT");      
		$this->db->join('tbl_booking_request','tbl_booking_date1.BookingRequestID=tbl_booking_request.BookingRequestID', "LEFT");      
		$this->db->join('tbl_users','tbl_booking_request.PriceBy=tbl_users.userId', "LEFT");      
        $this->db->where("tbl_product.OpportunityID", $id);   
		$this->db->order_by('tbl_product.DateRequired', 'DESC');
		//$this->db->group_by('tbl_product.BookingID' );
        $query=$this->db->get();
        //echo $this->db->last_query();
		//exit;
       return $query->result();
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
	function GetSiteContact($id)
    {  
		$this->db->select('tbl_contacts.ContactID');  
		$this->db->select('tbl_contacts.ContactName');  
		$this->db->select('tbl_contacts.MobileNumber');  
        $this->db->from('tbl_opportunity_to_contact');
        $this->db->join('tbl_contacts ','tbl_opportunity_to_contact.ContactID=tbl_contacts.ContactID');    
        $this->db->where("tbl_opportunity_to_contact.OpportunityID", $id);  
		$this->db->where("tbl_contacts.Type", '1');    
        $query=$this->db->get();
        //echo $this->db->last_query();
       return $query->result(); 
    }

    function getMaterialList(){
        $this->db->select('MaterialID');
		$this->db->select('MaterialCode');
		$this->db->select('MaterialName');
        $this->db->from('materials'); 
		$this->db->where("MaterialCode <> ''"); 
		//$this->db->where('Status', '1');
        $this->db->order_by('MaterialName', 'ASC');
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

	function GetMaterialDetails($code){
       
        $this->db->select('MaterialName');
        $this->db->from('materials'); 
        //$this->db->where('MaterialCode', $code);
		$this->db->where('MaterialID', $code);
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
		$this->db->select('tbl_opportunity_to_contact.OpportunityID');
        $this->db->from('tbl_contacts'); 
        $this->db->where("tbl_contacts.ContactID", $id);  
		$this->db->join('tbl_opportunity_to_contact','tbl_contacts.ContactID=tbl_opportunity_to_contact.ContactID','LEFT');               
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
        $this->db->select('d.DocumentDetail, d.DocumentType, d.DocumentNumber, d.DocumentAttachment, d.DocumentID, u.name ');
		//$this->db->select(' DATE_FORMAT(d.CreateDateTime,"%d/%m/%Y  %T") as DocDate ');  
		$this->db->select(' DATE_FORMAT(d.CreateDate,"%d/%m/%Y  %T") as DocDate ');  
        $this->db->from('documents as d');
        $this->db->join('users as u', 'u.userId = d.CreatedUserID');
        $this->db->join('opportunity_to_document as otd', 'otd.DocumentID = d.DocumentID');  
        $this->db->where('otd.OpportunityID', $OpportunityID);
		$this->db->order_by('d.CreateDateTime', 'DESC');
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
		$this->db->select('tbl_opportunities.Status');
		$this->db->select('tbl_opportunities.County');
		$this->db->select('tbl_opportunities.PostCode');
		$this->db->select('tbl_opportunities.OpportunityID'); 
		$this->db->select('tbl_opportunities.CreateDate');  
		$this->db->select(' DATE_FORMAT(tbl_opportunities.OpenDate,"%d/%m/%Y ") as OpenDate1 ');  	
		$this->db->select(' tbl_opportunities.OpenDate  ');  
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
		}
		$this->db->group_by("tbl_opportunities.OpportunityID");

		if($columnName==""){   
			$this->db->order_by("tbl_opportunities.tsupdate_datetime ", "desc");			 
		}else{
			$this->db->order_by($columnName, $columnSortOrder);			  
		}
		$this->db->limit($_REQUEST['length'], $_REQUEST['start']); 
		$this->db->stop_cache();
		$query = $this->db->get('tbl_opportunities'); 
		//echo $this->db->last_query();
		//exit; 
		//Reset Key Array
		$data = array();
		$data = $query->result_array();
		$totalData  = $this->db->count_all_results();
		$totalFiltered =  $totalData; 
		
		//Reset Key Array
		/*$data = array();
		foreach ($query->result_array() as $val) {
				$data[] = $val;
				//$data[] = array_values($val);
		}
		$totalData  = $this->db->get('tbl_opportunities')->num_rows();
		$totalFiltered =  $totalData;  */
		
		//Prepare Return Data
		$return = array(
				"draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
				"recordsTotal"    => $totalData,  // total number of records
				"recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
				"data"            => $data  // total data array
		); 
		return $return; 
    } 
	
	
	
	public function GetTicketData($OppoID){

		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
   
        //Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		  
        //$this->db->select($columns);
		$this->db->start_cache(); 
		$this->db->select(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) as TicketNumber ');  	
		$this->db->select(' tbl_tickets.TicketNumber as TicketNumber_sort ');  	 		
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T") as TicketDate ');  	 	
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S") as TicketDate1 ');  	
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_tickets.CompanyID ) as CompanyName ');  
		$this->db->select(' tbl_tickets.driver_id ');  	
		$this->db->select(' tbl_tickets.Conveyance ');  	
		$this->db->select(' tbl_tickets.RegNumber ');  	
		$this->db->select(' tbl_tickets.DriverName ');  	
		$this->db->select(' ROUND(tbl_tickets.GrossWeight) as GrossWeight ');  	
		$this->db->select(' ROUND(tbl_tickets.Tare) as Tare ');  	
		$this->db->select(' ROUND(tbl_tickets.Net) as Net ');  	
		$this->db->select(' tbl_tickets.TypeOfTicket '); 
		$this->db->select(' tbl_tickets.CompanyID '); 
		$this->db->select(' tbl_tickets.OpportunityID '); 
		$this->db->select(' tbl_tickets.TicketNo '); 
		$this->db->select(' tbl_tickets.pdf_name '); 
		$this->db->select(' tbl_booking_loads1.ReceiptName '); 		
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_tickets.CompanyID'); 		
		$this->db->join('tbl_booking_loads1', 'tbl_tickets.LoadID = tbl_booking_loads1.LoadID',"LEFT"); 		
		$this->db->where('tbl_tickets.delete_notes IS NULL');  
		$this->db->where('tbl_tickets.OpportunityID	', $OppoID);
		$this->db->where('tbl_tickets.is_hold', 0);
		$this->db->where('tbl_tickets.IsInBound', 0);
				
        // 	if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        //	if( !empty($_REQUEST['search']['value']) ){
		//	$search_value = $_REQUEST['search']['value'];
		if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();
						$this->db->like(' CONCAT(tbl_tickets.TicketNumber," ", tbl_tickets.TicketGap) ', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y  %T")', $s[$i]);
						$this->db->or_like('tbl_company.CompanyName', $s[$i]);
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]); 
						$this->db->or_like('tbl_tickets.driver_id', $s[$i]);
						$this->db->or_like('tbl_tickets.DriverName', $s[$i]);
						$this->db->or_like('tbl_tickets.RegNumber', $s[$i]); 
						$this->db->or_like('tbl_tickets.TypeOfTicket', $s[$i]);
						$this->db->or_like('tbl_tickets.GrossWeight', $s[$i]);
						$this->db->or_like('tbl_tickets.Tare', $s[$i]);
						$this->db->or_like('tbl_tickets.Net', $s[$i]); 
					$this->db->group_end();

				}
			}   
			//$totalFiltered  = $this->db->get('tbl_tickets')->num_rows(); 
        }
		$this->db->group_by("tbl_tickets.TicketNo ");  
		if($columnName == 'TicketDate'){
			//$this->db->order_by(DATE_FORMAT(tbl_tickets.TicketDate,"%Y%m%d%H%i%S"), $columnSortOrder);
			$this->db->order_by('tbl_tickets.TicketNo', $columnSortOrder);			
		}else if($columnName == 'TicketNumber'){
			$this->db->order_by('tbl_tickets.TicketNumber', $columnSortOrder);			
		}else{
			$this->db->order_by($columnName, $columnSortOrder);			
		} 	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
		//echo $this->db->last_query();
		//exit;
        
		$query = $this->db->get('tbl_tickets');
		$this->db->stop_cache();
		 
        //Reset Key Array
        $data = array();
		$data = $query->result_array();
		$totalData  = $this->db->count_all_results();
		$totalFiltered =  $totalData; 
		
        //foreach ($query->result_array() as $val) {
        //        $data[] = $val;
		//		//$data[] = array_values($val);
        //}  
		//$totalData  = $this->db->get('tbl_tickets')->num_rows();    
		//$totalFiltered =  $totalData; 
		  
        //Prepare Return Data
        $return = array(
                "draw"            => $_REQUEST['draw'] ,   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                "recordsTotal"    => $totalData,  // total number of records
                "recordsFiltered" => $totalFiltered, // total number of records after searching, if there is no searching then totalFiltered = totalData
                "data"            => $data //$query->result_array() //$data  // total data array
        );

        return $return;

    }
	
	public function GetOppoBookingData($OppoID){
		
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		  
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking_date1.BookingDateID  ');  	 		
		$this->db->select(' tbl_booking_request.BookingRequestID ');  	 		
		$this->db->select(' tbl_booking_request.Notes ');  	 		
		$this->db->select(' tbl_booking1.BookingType, tbl_booking_date1.BookingDateStatus '); 
		$this->db->select(' tbl_booking1.LoadType ');
		$this->db->select(' tbl_booking1.LorryType ');
		$this->db->select(' tbl_booking1.Loads '); 
		$this->db->select(' tbl_booking_request.CompanyID ');
		$this->db->select(' tbl_booking_request.OpportunityID '); 
		$this->db->select(' tbl_booking_request.CompanyName '); 
		$this->db->select(' tbl_booking_request.OpportunityName ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as BookingDate '); 
		$this->db->select('(select tbl_users.name FROM tbl_users where tbl_booking_request.BookedBy = tbl_users.userId ) as BookedName ');   
		$this->db->select(' tbl_booking1.MaterialName  ');  
		//$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated ');  
		$this->db->select('tbl_booking_request.ContactEmail ');  	  
		$this->db->join('tbl_booking_request', 'tbl_booking_date1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		    
		$this->db->join('tbl_booking1', 'tbl_booking_date1.BookingID = tbl_booking1.BookingID ','LEFT'); 		    
		$this->db->where('tbl_booking_request.OpportunityID',$OppoID); 
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking_request.BookingRequestID', $s[$i]); 
						$this->db->or_like('tbl_booking1.Loads', $s[$i]);  
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") ', $s[$i]);
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
					$this->db->group_end();

				}
			}    
        }
		  
		$this->db->order_by($columnName, $columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking_date1');
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
                "data"            => $data  // total data array
        ); 
        return $return; 
    }
	
	/*public function GetOppoBookingData($OppoID){
		
		$columnIndex = $_POST['order'][0]['column']; // Column index
		$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
		$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
		$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
		  
        $this->db->start_cache();
		 
		$this->db->select(' tbl_booking.BookingID  as BookingID  ');  	 		
		$this->db->select(' tbl_booking.BookingType, tbl_booking.Status ');
		$this->db->select(' tbl_booking.CompanyID ');
		$this->db->select(' tbl_booking.LoadType ');
		$this->db->select(' tbl_booking.Loads ');
		$this->db->select(' tbl_booking.Notes ');
		$this->db->select(' tbl_booking.Status ');
		$this->db->select(' tbl_booking.OpportunityID '); 
		$this->db->select('(select GROUP_CONCAT(DATE_FORMAT(tbl_booking_date.BookingDate,"%d-%m-%Y")  SEPARATOR "<br>") FROM tbl_booking_date 
		where tbl_booking_date.BookingID = tbl_booking.BookingID order by tbl_booking_date.BookingDateID ASC)  as BookingDate '); 
		$this->db->select('(select tbl_users.name FROM tbl_users where tbl_booking.BookedBy = tbl_users.userId ) as BookedName '); 
		$this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_booking.CompanyID ) as CompanyName '); 
		$this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_booking.OpportunityID ) as OpportunityName '); 
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_booking.MaterialID ) as MaterialName '); 
		$this->db->select('(select count(*) from tbl_booking_loads where tbl_booking_loads.BookingID = tbl_booking.BookingID ) as TotalLoadAllocated '); 

		$this->db->select(' tbl_booking.Email ');  	 
		$this->db->where('tbl_booking.OpportunityID',$OppoID); 
		$this->db->join('tbl_opportunities', 'tbl_opportunities.OpportunityID = tbl_booking.OpportunityID'); 
		$this->db->join('tbl_company', 'tbl_company.CompanyID = tbl_booking.CompanyID'); 
		
        // if there is a search parameter, $_REQUEST['search']['value'] contains search parameter
        if( !empty($searchValue) ){  
			
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start(); 
						$this->db->or_like('tbl_booking.BookingID', $s[$i]); 
						$this->db->or_like('tbl_booking.Loads', $s[$i]); 
						$this->db->or_like('tbl_booking.Notes', $s[$i]); 
						$this->db->or_like('tbl_company.CompanyName', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking.BookingDateTime,"%d-%m-%Y %T") ', $s[$i]);
						$this->db->or_like('tbl_opportunities.OpportunityName', $s[$i]);
					$this->db->group_end();

				}
			}    
        }
		  
		$this->db->order_by($columnName, $columnSortOrder);		 
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
        $query = $this->db->get('tbl_booking');
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
                "data"            => $data  // total data array
        ); 
        return $return; 
    } */
	
    function TipListing(){
        $this->db->select('*');
        $this->db->from('tbl_tipaddress'); 
        $this->db->order_by('TipID', 'ASC'); 
        $query = $this->db->get();     
        $result = $query->result();        
        return $result;
    }
 	function TipAuthoListing($OpportunityID){
        $this->db->select('tbl_tipaddress.TipID , tbl_tipaddress.TipName, 
		tbl_tipaddress.Town, tbl_tipaddress.County, tbl_opportunity_tip.Status, 
		tbl_opportunity_tip.TableID , tbl_opportunity_tip.TipRefNo ');
        $this->db->from('tbl_tipaddress'); 
		$this->db->join('tbl_opportunity_tip', 'tbl_tipaddress.TipID = tbl_opportunity_tip.TipID and tbl_opportunity_tip.OpportunityID = "'.$OpportunityID.'" ',"LEFT"); 
        $this->db->order_by('TipID', 'ASC'); 
        $query = $this->db->get();     
        $result = $query->result();        
        return $result;
    }	
}

  