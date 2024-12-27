<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Tip_model extends CI_Model
{ 
    function ShowRequestTipTicketPhotos($TipTicketID)
		{   
			$this->db->select('tbl_tipticket_photos.*'); 
			$this->db->from('tbl_tipticket_photos');   
			$this->db->where('tbl_tipticket_photos.TipTicketID', $TipTicketID);                     
			$query = $this->db->get(); 
		   //echo $this->db->last_query();       
		   //exit;
			//$result = $query->row_array();  
			$result = $query->result(); 		  
			return $result;
		}
		function ShowRequestTipTicketImages($TipTicketID)
		{   
			$this->db->select('tbl_tipticket_images.*'); 
			$this->db->from('tbl_tipticket_images');   
			$this->db->where('tbl_tipticket_images.TipTicketID', $TipTicketID);                     
			$query = $this->db->get(); 
		   //echo $this->db->last_query();       
		   //exit;
			//$result = $query->row_array();  
			$result = $query->result(); 		  
			return $result;
		}
	
    function TipListing(){
        $this->db->select('*');
        $this->db->from('tbl_tipaddress'); 
        
		$this->db->where('tbl_tipaddress.RandomTIP','0');
        $this->db->order_by('UpdateDateTIme', 'DESC'); 
        $query = $this->db->get();     
        $result = $query->result();        
        return $result;
    }
	
	function __TipRecords($TipID){
        $this->db->select('tbl_tipticket.*');
		$this->db->select('tbl_booking_loads.ConveyanceNo');
		$this->db->select('tbl_booking_loads.ReceiptName');
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y  %T") as TipDateTime ');  	 	 
        $this->db->from('tbl_tipticket'); 
		$this->db->join('tbl_booking_loads', 'tbl_tipticket.LoadID = tbl_booking_loads.LoadID', "LEFT" ); 
		$this->db->where('tbl_tipticket.TipID', $TipID);
        $this->db->order_by('tbl_tipticket.CreatedDateTime', 'DESC'); 
        $query = $this->db->get(); 
        $result = $query->result();        
        return $result;
    }
	function TipRecords($TipID){
        $this->db->select('tbl_tipticket.*');
		$this->db->select('tbl_booking_loads1.ConveyanceNo');
		$this->db->select('tbl_booking_loads1.ReceiptName');
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y  %T") as TipDateTime ');  	 	 
        $this->db->from('tbl_tipticket'); 
		$this->db->join('tbl_booking_loads1', 'tbl_tipticket.LoadID = tbl_booking_loads1.LoadID', "LEFT" ); 
		$this->db->where('tbl_tipticket.TipID', $TipID);
        $this->db->order_by('tbl_tipticket.CreatedDateTime', 'DESC'); 
        $query = $this->db->get(); 
        $result = $query->result();        
        return $result;
    }	
	
    function getCounty()
    {
        $this->db->select('*');
        $this->db->from('county');
        $this->db->where('ID !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }
 
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
	public function GetViewTipTickets(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			//print_r($Sort); 
			
			if($Sort[0]=='TipTicketID'){ $columnName = 'tbl_tipticket.TipTicketID '; }   
			if($Sort[0]=='TipDateTime'){  $columnName = ' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%Y%m%d%H%i%S") ';  }    
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; } 
			if($Sort[0]=='SiteAddress'){ $columnName = 'tbl_tipticket.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_tipticket.MaterialName '; }   
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_tipticket.DriverName '; }  
			if($Sort[0]=='TipTicketNo'){ $columnName = ' tbl_tipticket.TipTicketNo '; }  
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			if($Sort[0]=='Remarks'){ $columnName = ' tbl_tipticket.Remarks '; }  
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		//$BookingType = trim(strtolower($_POST['BookingType']));  
		$TipTicketID = trim(strtolower($_POST['TipTicketID']));  
		$ConveyanceNo = trim(strtolower($_POST['ConveyanceNo']));   
		$TipDateTime = trim(strtolower($_POST['TipDateTime']));  
		$SiteAddress = trim(strtolower($_POST['SiteAddress']));  
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));    
		$TipTicketNo = trim(strtolower($_POST['TipTicketNo']));   
		$Remarks = trim(strtolower($_POST['Remarks']));    
		$TipID = trim(strtolower($_POST['TipID']));    
		$Reservation = trim(strtolower($_POST['Reservation']));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation!=""){
			$RS = explode('-',$Reservation);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache();   
		$this->db->select('(select count(*) from tbl_tipticket_photos where  tbl_tipticket_photos.TipTicketID = tbl_tipticket.TipTicketID  ) as TotalPhotos ');
		$this->db->select('tbl_tipticket.TipTicketID');
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y  %T") as TipDateTime ');  	 	 
		$this->db->select('tbl_booking_loads1.ConveyanceNo');
		$this->db->select('tbl_booking_loads1.ReceiptName'); 
		$this->db->select('tbl_tipticket.SiteAddress');
		$this->db->select('tbl_tipticket.DriverName');
		$this->db->select('tbl_tipticket.MaterialName');
		$this->db->select('tbl_tipticket.TipTicketNo');
		$this->db->select('tbl_tipticket.TipID');
        $this->db->select('tbl_tipaddress.TipName');
		$this->db->select('tbl_tipticket.Remarks');  
		
		$this->db->join('tbl_booking_loads1', 'tbl_tipticket.LoadID = tbl_booking_loads1.LoadID', "LEFT" ); 
		$this->db->where('tbl_tipticket.TipID', $TipID);   		 
		$this->db->join('tbl_tipaddress', 'tbl_tipticket.TipID = tbl_tipaddress.TipID', 'LEFT');
		
		        $this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
             when  (tbl_booking_loads1.Status = '8') then 'Invoice Cancelled'
        end) as Status"); 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_tipticket.TipTicketID', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]);  
						$this->db->or_like(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y")  ', $s[$i]); 
						$this->db->or_like('tbl_tipticket.SiteAddress', $s[$i]);
						$this->db->or_like('tbl_tipticket.DriverName', $s[$i]);  
						$this->db->or_like('tbl_tipticket.MaterialName', $s[$i]);
						$this->db->or_like('tbl_tipticket.TipTicketNo', $s[$i]);  						
						$this->db->or_like('tbl_tipticket.Remarks', $s[$i]);   
					$this->db->group_end(); 
				}
			}    
        } 
        if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start();  
			$this->db->where('DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%Y-%m-%d") >=', $StartDate);
			$this->db->where('DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%Y-%m-%d") <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($TipTicketID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.TipTicketID', trim($TipTicketID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
  
		if( !empty(trim($TipDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") ', trim($TipDateTime)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($SiteAddress)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.SiteAddress', trim($SiteAddress)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }    
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }  
		if( !empty(trim($TipTicketNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.TipTicketNo', trim($TipTicketNo)); 
 			$this->db->group_end();  
        }  
		if( !empty(trim($Remarks)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.Remarks', trim($Remarks)); 
 			$this->db->group_end();  
        }  
		
		$this->db->group_by("tbl_tipticket.TipTicketID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_tipticket');
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit; 
	
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
                "data"            => $data //$query->result_array() //$data  // total data array
        );

        return $return;

        }
        
        public function ExcelTipTickets($TipID,$TipTicketID,$TipDateTime,$reservation,$ConveyanceNo,$SiteAddress,$DriverName,$MaterialName,$TipTicketNo,$Remarks,$Search){
		//print_r($_POST);
		//exit;
		   
		$TipID = trim(strtolower($TipID));  
		$TipTicketID = trim(strtolower($TipTicketID));  
		$TipDateTime = trim(strtolower($TipDateTime));  
		$Reservation = trim(strtolower($reservation));
		$searchValue = trim(strtolower($Search)); // Search value   
		$ConveyanceNo = trim(strtolower($ConveyanceNo)); 
		
		$SiteAddress = trim(strtolower($SiteAddress));      
		$DriverName = trim(strtolower($DriverName));   
		$MaterialName = trim(strtolower($MaterialName));     
		$TipTicketNo = trim(strtolower($TipTicketNo));   
		$Remarks = trim(strtolower($Remarks));     
        
		
		$StartDate = ''; $EndDate = '';
		if($Reservation!=""){
			$RS = explode('-',$Reservation);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		//Only select column that want to show in datatable or you can filte it mnually when send it
        $this->db->start_cache();
		
        //$this->db->select($columns);
		$this->db->start_cache();   
		//$this->db->select('(select GROUP_CONCAT(b.ImageName separator ", ") as PhotoList from tbl_tipticket_photos b where  b.TipTicketID = tbl_tipticket.TipTicketID  ) as Photos ');   
		   
		$this->db->select('tbl_tipticket.TipTicketID');
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y  %T") as TipDateTime ');  	 	 
		$this->db->select('tbl_booking_loads1.ConveyanceNo');
		$this->db->select('tbl_booking_loads1.ReceiptName'); 
		$this->db->select('tbl_tipticket.SiteAddress');
		$this->db->select('tbl_tipticket.DriverName');
		$this->db->select('tbl_tipticket.MaterialName');
		$this->db->select('tbl_tipticket.TipTicketNo');
		$this->db->select('tbl_tipticket.Remarks');  
		$this->db->select('tbl_tipaddress.TipName');  
		$this->db->join('tbl_booking_loads1', 'tbl_tipticket.LoadID = tbl_booking_loads1.LoadID', "LEFT" ); 
		$this->db->join('tbl_tipaddress', 'tbl_tipticket.TipID = tbl_tipaddress.TipID', "LEFT" );  
		$this->db->where('tbl_tipticket.TipID', $TipID);   		
		//$this->db->where('tbl_drivers.AppUser = 0 '); 	 
		
		/*if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } */
		
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start();  
			$this->db->where('DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%Y-%m-%d") >=', $StartDate);
			$this->db->where('DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%Y-%m-%d") <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($TipTicketID)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.TipTicketID', trim($TipTicketID)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
  
		if( !empty(trim($TipDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") ', trim($TipDateTime)); 
 			$this->db->group_end();  
        } 
		if( !empty(trim($SiteAddress)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.SiteAddress', trim($SiteAddress)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }    
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.DriverName', trim($DriverName)); 
 			$this->db->group_end();  
        }  
		if( !empty(trim($TipTicketNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.TipTicketNo', trim($TipTicketNo)); 
 			$this->db->group_end();  
        }  
		if( !empty(trim($Remarks)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipticket.Remarks', trim($Remarks)); 
 			$this->db->group_end();  
        }  
		
		
		$this->db->group_by("tbl_tipticket.TipTicketID ");    
		$query = $this->db->get('tbl_tipticket'); 
		$this->db->stop_cache();
		//echo $this->db->last_query();
		//exit;
		$result = $query->result_array();  
		//$result = $query->result(); 		  
        return $result; 
    }


}

  