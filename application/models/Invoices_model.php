<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Invoices_model extends CI_Model{ 
	public function LastPreInvoiceNo(){
		$this->db->select('tbl_invoice.PreInvoiceNumber');    
        $this->db->select('tbl_invoice.InvoiceID');    
        $this->db->from('tbl_invoice');         
		$this->db->order_by('tbl_invoice.InvoiceID', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		//echo "sdfsdfsdf";
		//echo $this->db->last_query();
		//exit;
        
		return $query->row_array();
	}
	function UpdateInvoiceID($RandNum,$InvoiceID){
		$this->db->query("UPDATE tbl_invoice_load SET InvoiceID='".$InvoiceID."' ,PreInvoiceNumber='".$InvoiceID."' WHERE PreInvoiceNumber = '" .$RandNum."'" );
		$query  = $this->db->get(); 
		
		$this->db->query("UPDATE tbl_invoice SET PreInvoiceNumber='".$InvoiceID."' WHERE PreInvoiceNumber = '" .$RandNum."'" );
		$query1 = $this->db->get(); 
		
		//$this->db->where('PreInvoiceNumber', $PreInvoiceNumber);
		//$this->db->update('InvoiceID', $InvoiceID);  
	}
	function LastInvoiceNo(){
		$this->db->select('InvoiceNumber');    
        $this->db->from('tbl_invoice');         
		$this->db->order_by('InvoiceID', 'DESC');
		$this->db->limit(1);
		$query = $this->db->get(); 
		return $query->row_array();
	}
	
	public function GetOpportunitiesByLoadIDs($LoadIds){
		   
 		$this->db->select(' tbl_booking_request.CompanyID');       
		$this->db->select(' tbl_booking_request.CompanyName');       
		$this->db->select(' tbl_booking_request.OpportunityID');        
		$this->db->select(' tbl_booking_request.OpportunityName');       
		$this->db->select(' tbl_booking1.TonBook');       
		$this->db->select(' tbl_booking1.BookingType');       
		$this->db->select(' tbl_booking1.LoadType');       
		$this->db->from('tbl_booking_loads1');   
		$this->db->join('tbl_booking_request', ' tbl_booking_loads1.BookingRequestID  = tbl_booking_request.BookingRequestID  ','LEFT');      
		$this->db->join('tbl_booking1', ' tbl_booking_loads1.BookingID  = tbl_booking1.BookingID  ','LEFT');      
		$this->db->where_in('tbl_booking_loads1.LoadID',$LoadIds); 
		$this->db->order_by('tbl_booking_request.OpportunityID', 'ASC');  		
		
		$query = $this->db->get();      
        //echo $this->db->last_query();
		//exit;
        $result = $query->result();        
        return $result;
    }
	
	public function GetInvoiceLoads(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			
			//print_r($Sort);
			//exit;
			//if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; }  
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_tickets.Conveyance '; }  
			if($Sort[0]=='WaitTime'){ $columnName = ' WaitTime '; }   
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }    
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='TipName'){ $columnName = 'tbl_tipaddress.TipName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }   
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_booking_loads1.DriverName '; }  
			if($Sort[0]=='Price'){ $columnName = ' tbl_booking_loads1.LoadPrice '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($_POST['ConveyanceNo']));  
		$WaitTime = trim(strtolower($_POST['WaitTime']));  
		$Price = trim(strtolower($_POST['Price']));  
		
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));   
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$Status = trim(strtolower($_POST['Status']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
		$TipName = trim(strtolower($_POST['TipName']));   
        $Reservation = trim(strtolower($_POST['Reservation']));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation!=""){
			$RS = explode('-',$Reservation);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		
		
        $this->db->start_cache(); 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status");  
		$this->db->select(' td3.GUID as ConveyanceGUID ');  
		
		$this->db->select(' tbl_tickets.Conveyance as TicketConveyance ');  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		
		$this->db->select(' tbl_tickets.pdf_name ');
		$this->db->select(' tbl_tickets.IsInBound ');		
		$this->db->select(' tbl_tickets.Net  '); 
		$this->db->select(' tbl_tickets.TicketNumber as SuppNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y") as SuppDate ');  	 	  	 	      
		
		$this->db->select(' tbl_tipticket.TipTicketID '); 
		$this->db->select(' tbl_tipticket.TipTicketNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  	 	  	 	      
		
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		  		
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');   		  		
		
		////$this->db->select(' tbl_drivers.RegNumber as rname ');  	 			
		////$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 			
		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	
		 
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');  	
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID '); 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		//$this->db->select(' tbl_booking1.Price ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price  ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_tipaddress.TipName ');
		$this->db->select(' concat(tbl_tipaddress.Street1,tbl_tipaddress.Street2,tbl_tipaddress.Town,tbl_tipaddress.County,tbl_tipaddress.PostCode) as TipAddress '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	       
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as RequestDate ');  	 	  	 	      
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStart ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteIn ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEnd ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOut ');    
		
		$this->db->select('ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  AS WaitTime');    
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ','LEFT'); 		    
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		    
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo and tbl_tickets.TypeOfTicket = "In" ','LEFT'); 		 
		//$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		  
		$this->db->join('tbl_tickets_documents as td3', 'tbl_tickets.Conveyance = td3.FD_650A620E AND td3.DocTypeID  = "392cf403 " ','LEFT'); 		  		
		$this->db->join('tbl_invoice_load', ' tbl_booking_loads1.LoadID = tbl_invoice_load.LoadID',"LEFT OUTER");
		$this->db->where('tbl_invoice_load.LoadID IS NULL');  
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y-%m-%d") >= (CURDATE() - INTERVAL 31 DAY)'); 
		//$this->db->where('tbl_booking1.BookingType  = 1 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]); 
						//$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]); 
						
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						//$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						//$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.LoadPrice', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } 
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60) ,1) ', trim($WaitTime));  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
			$this->db->or_like(' tbl_tickets.Conveyance ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' tbl_booking1.Price ', trim($Price)); 
			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start();
						
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) >=', $StartDate);
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) <=', $EndDate);  
			
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
			$this->db->like('tbl_booking_loads1.DriverName', trim($DriverName)); 
 			//$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
			//$this->db->or_like('tbl_drivers_login.DriverName', trim($DriverName));  
 			$this->db->group_end();  
        } 
		if( !empty(trim($BookingType)) ){    
			if(strtolower($BookingType[0])=='c' ){ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType = 1  '); 
				$this->db->group_end();  
			}else if(strtolower($BookingType[0])=='de' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType  = 2'); 
				$this->db->group_end();  
			}else if(strtolower($BookingType[0])=='da' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType  = 3'); 
				$this->db->group_end();  
			}else if(strtolower($BookingType[0])=='h' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType  = 4'); 
				$this->db->group_end();  
			}
			 
        }
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
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
		
		public function GetInvoiceLoadsExcluded(){
		//print_r($_POST);
		//exit;
		if( !empty(trim($_POST['sort'])) ){  
			$Sort = explode(' ', trim($_POST['sort'])); 
			
			//print_r($Sort);
			//exit;
			//if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_booking_loads1.ConveyanceNo '; }  
			if($Sort[0]=='ConveyanceNo'){ $columnName = 'tbl_tickets.Conveyance '; }  
			if($Sort[0]=='WaitTime'){ $columnName = ' WaitTime '; }   
			if($Sort[0]=='SiteOutDateTime'){  $columnName = ' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%Y%m%d%H%i%S") ';  }    
			if($Sort[0]=='CompanyName'){ $columnName = 'tbl_booking_request.CompanyName '; } 
			if($Sort[0]=='OpportunityName'){ $columnName = 'tbl_booking_request.OpportunityName '; }   
			if($Sort[0]=='MaterialName'){ $columnName = 'tbl_booking1.MaterialName '; } 
			if($Sort[0]=='TipName'){ $columnName = 'tbl_tipaddress.TipName '; } 
			if($Sort[0]=='VehicleRegNo'){ $columnName = 'tbl_booking_loads1.VehicleRegNo'; }   
			if($Sort[0]=='DriverName'){ $columnName = ' tbl_booking_loads1.DriverName '; }  
			if($Sort[0]=='Price'){ $columnName = ' tbl_booking_loads1.LoadPrice '; } 
			if($Sort[0]=='Status'){ $columnName = ' tbl_booking_loads1.Status '; } 
			 
			$columnSortOrder = $Sort[1]; 
		}	
		  
		$searchValue = trim(strtolower($_POST['search'])); // Search value  
		$BookingType = trim(strtolower($_POST['BookingType']));  
		$ConveyanceNo = trim(strtolower($_POST['ConveyanceNo']));  
		$WaitTime = trim(strtolower($_POST['WaitTime']));  
		$Price = trim(strtolower($_POST['Price']));  
		
		$SiteOutDateTime = trim(strtolower($_POST['SiteOutDateTime']));   
		$CompanyName = trim(strtolower($_POST['CompanyName']));  
		$OpportunityName = trim(strtolower($_POST['OpportunityName']));   
		$VehicleRegNo = trim(strtolower($_POST['VehicleRegNo']));    
		$DriverName = trim(strtolower($_POST['DriverName']));   
		$Status = trim(strtolower($_POST['Status']));   
		$MaterialName = trim(strtolower($_POST['MaterialName']));   
		$TipName = trim(strtolower($_POST['TipName']));   
        $Reservation = trim(strtolower($_POST['Reservation']));
		
		$StartDate = ''; $EndDate = '';
		if($Reservation!=""){
			$RS = explode('-',$Reservation);     
			
			$SD = explode('/',trim($RS[0]));   
			$StartDate = $SD[2].'-'.$SD[1].'-'.$SD[0]; 

			$ED = explode('/',trim($RS[1]));   
			$EndDate = $ED[2].'-'.$ED[1].'-'.$ED[0];   	
			
		}	  
		
		
        $this->db->start_cache(); 
		$this->db->select("(case when (tbl_booking_loads1.Status = '4') then 'Finished'
             when  (tbl_booking_loads1.Status = '5') then 'Cancelled'
             when  (tbl_booking_loads1.Status = '6') then 'Wasted' 
        end) as Status");  
		$this->db->select(' td3.GUID as ConveyanceGUID ');  
		
		$this->db->select(' tbl_tickets.Conveyance as TicketConveyance ');  
		$this->db->select(' tbl_booking_loads1.ConveyanceNo ');  
		$this->db->select(' tbl_booking_loads1.TicketUniqueID ');  
		$this->db->select(' tbl_booking_loads1.ReceiptName ');  
		$this->db->select(' tbl_booking_loads1.MaterialID ');  	 		
		$this->db->select(' tbl_booking_loads1.LoadID ');  
		$this->db->select(' tbl_booking_loads1.AutoAllocated ');  
		
		$this->db->select(' tbl_tickets.pdf_name ');
		$this->db->select(' tbl_tickets.IsInBound ');		
		$this->db->select(' tbl_tickets.Net  '); 
		$this->db->select(' tbl_tickets.TicketNumber as SuppNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d-%m-%Y") as SuppDate ');  	 	  	 	      
		
		$this->db->select(' tbl_tipticket.TipTicketID '); 
		$this->db->select(' tbl_tipticket.TipTicketNo '); 
		$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  	 	  	 	      
		
		$this->db->select(' tbl_booking_loads1.TipID '); 
		$this->db->select(' tbl_booking_loads1.TipAddressUpdate '); 
		$this->db->select(' tbl_booking_loads1.DriverName ');  	 		
		$this->db->select(' tbl_booking_loads1.VehicleRegNo ');   		  		
		$this->db->select(' tbl_booking_loads1.DriverLoginID ');   		  		
		
		////$this->db->select(' tbl_drivers.RegNumber as rname ');  	 			
		////$this->db->select(' tbl_drivers_login.DriverName as dname ');  	 			
		
		$this->db->select(' tbl_booking_request.CompanyID ');  	 		
		$this->db->select(' tbl_booking1.BookingType ');  	 		
		$this->db->select(' tbl_booking1.LoadType ');  	
		 
		$this->db->select(' tbl_booking1.PurchaseOrderNo ');  	
		$this->db->select(' tbl_booking1.MaterialID as BookingMaterialID '); 
		$this->db->select(' tbl_booking_request.OpportunityID ');		
		//$this->db->select(' tbl_booking1.Price ');		
		$this->db->select(' tbl_booking_loads1.LoadPrice as Price  ');		
		$this->db->select(' tbl_booking_request.CompanyName ');
		$this->db->select(' tbl_booking_request.PurchaseOrderNumber ');
		$this->db->select(' tbl_materials.MaterialName ');
		$this->db->select(' tbl_booking_request.OpportunityName '); 
		$this->db->select(' tbl_tipaddress.TipName ');
		$this->db->select(' concat(tbl_tipaddress.Street1,tbl_tipaddress.Street2,tbl_tipaddress.Town,tbl_tipaddress.County,tbl_tipaddress.PostCode) as TipAddress '); 
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y") as SiteOutDateTime ');  	 	  	 	       
		$this->db->select(' DATE_FORMAT(tbl_booking_date1.BookingDate,"%d-%m-%Y") as RequestDate ');  	 	  	 	      
		
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d/%m/%Y %T") as JobStart ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteInDateTime,"%d/%m/%Y %T") as SiteIn ');  
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.JobEndDateTime,"%d/%m/%Y %T") as JobEnd ');   
		$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y %T") as SiteOut ');    
		
		$this->db->select('ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60))  AS WaitTime');    
		$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		   
		$this->db->join('tbl_booking_date1', 'tbl_booking_loads1.BookingDateID = tbl_booking_date1.BookingDateID ','LEFT'); 		    
		$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		    
		$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID ','LEFT'); 		 
		$this->db->join('tbl_materials', 'tbl_booking_loads1.MaterialID = tbl_materials.MaterialID ','LEFT');
		$this->db->join('tbl_tickets', 'tbl_booking_loads1.TicketID = tbl_tickets.TicketNo and tbl_tickets.TypeOfTicket = "In" ','LEFT'); 		 
		//$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID ','LEFT'); 		 
		$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		  
		$this->db->join('tbl_tickets_documents as td3', 'tbl_tickets.Conveyance = td3.FD_650A620E AND td3.DocTypeID  = "392cf403 " ','LEFT'); 		  		
		$this->db->join('tbl_invoice_load', ' tbl_booking_loads1.LoadID = tbl_invoice_load.LoadID',"LEFT OUTER");
		//$this->db->where('tbl_invoice_load.LoadID IS NULL');  
		$this->db->where('tbl_booking_loads1.Status > 3 '); 
		$this->db->where('tbl_booking_loads1.Exclude = 1 ');  
		//$this->db->where('tbl_booking1.BookingType  = 1 '); 
		//$this->db->where('tbl_drivers.AppUser = 0 '); 
				 
		if( !empty($searchValue) ){   
			$s = explode(' ',$searchValue);
			if(count($s)>0){ 
				for($i=0;$i<count($s);$i++){   
					$this->db->group_start();   
						$this->db->or_like('tbl_booking_loads1.ConveyanceNo', $s[$i]); 
						$this->db->or_like('tbl_tickets.Conveyance', $s[$i]); 
						//$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.JobStartDateTime,"%d-%m-%Y")  ', $s[$i]);
						$this->db->or_like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y")  ', $s[$i]); 
						
						$this->db->or_like('tbl_booking_request.CompanyName', $s[$i]); 
						$this->db->or_like('tbl_booking_request.OpportunityName', $s[$i]);
						//$this->db->or_like('tbl_drivers.DriverName', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.DriverName', $s[$i]);  
						$this->db->or_like('tbl_booking_loads1.VehicleRegNo', $s[$i]);  
						$this->db->or_like('tbl_materials.MaterialName', $s[$i]); 
						//$this->db->or_like('tbl_booking1.Price', $s[$i]); 
						$this->db->or_like('tbl_booking_loads1.LoadPrice', $s[$i]); 
						$this->db->or_like('tbl_tipaddress.TipName', $s[$i]); 
						
					$this->db->group_end(); 
				}
			}    
        } 
		if( !empty(trim($WaitTime)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60) ,1) ', trim($WaitTime));  
			$this->db->like(' ROUND((TIMESTAMPDIFF(SECOND, tbl_booking_loads1.SiteInDateTime, tbl_booking_loads1.SiteOutDateTime)/60)) ', trim($WaitTime));  
 			$this->db->group_end();  
        }
		if( !empty(trim($ConveyanceNo)) ){    
			$this->db->group_start(); 
 			$this->db->like(' tbl_booking_loads1.ConveyanceNo ', trim($ConveyanceNo)); 
			$this->db->or_like(' tbl_tickets.Conveyance ', trim($ConveyanceNo));  
 			$this->db->group_end();  
        }
		if( !empty(trim($Price)) ){    
			$this->db->group_start(); 
 			//$this->db->like(' tbl_booking1.Price ', trim($Price)); 
			$this->db->like(' tbl_booking_loads1.LoadPrice ', trim($Price)); 
 			$this->db->group_end();  
        }
		if(trim($StartDate)!="" && trim($EndDate)!=""  ){    
			$this->db->group_start();
						
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) >=', $StartDate);
			//$this->db->where('DATE(tbl_booking_loads1.JobStartDateTime) <=', $EndDate);  
			
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) >=', $StartDate);
			$this->db->where('DATE(tbl_booking_loads1.SiteOutDateTime) <=', $EndDate);  
 			$this->db->group_end();  
        }
		if( !empty(trim($SiteOutDateTime)) ){    
			$this->db->group_start(); 
 			$this->db->like(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d-%m-%Y %T") ', trim($SiteOutDateTime)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($CompanyName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.CompanyName', trim($CompanyName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($OpportunityName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_request.OpportunityName', trim($OpportunityName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($MaterialName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_materials.MaterialName', trim($MaterialName)); 
 			$this->db->group_end();  
        }
		if( !empty(trim($TipName)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_tipaddress.TipName', trim($TipName)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($VehicleRegNo)) ){    
			$this->db->group_start(); 
 			$this->db->like('tbl_booking_loads1.VehicleRegNo', trim($VehicleRegNo)); 
 			$this->db->group_end();  
        }
		 
		if( !empty(trim($DriverName)) ){    
			$this->db->group_start(); 
			$this->db->like('tbl_booking_loads1.DriverName', trim($DriverName)); 
 			//$this->db->like('tbl_drivers.DriverName', trim($DriverName)); 
			//$this->db->or_like('tbl_drivers_login.DriverName', trim($DriverName));  
 			$this->db->group_end();  
        } 
		if( !empty(trim($BookingType)) ){    
			if(strtolower($BookingType[0])=='c' ){ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType = 1  '); 
				$this->db->group_end();  
			}else if(strtolower($BookingType[0])=='de' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType  = 2'); 
				$this->db->group_end();  
			}else if(strtolower($BookingType[0])=='da' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType  = 3'); 
				$this->db->group_end();  
			}else if(strtolower($BookingType[0])=='h' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking1.BookingType  = 4'); 
				$this->db->group_end();  
			}
			 
        }
		if( !empty(trim($Status)) ){     
			if(strtolower($Status[0])=='f' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '4'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='c' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '5'); 
				$this->db->group_end();  
			}else if(strtolower($Status[0])=='w' ){
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '6'); 
				$this->db->group_end();  
			}else{ 
				$this->db->group_start(); 
				$this->db->like(' tbl_booking_loads1.Status ', '11'); 
				$this->db->group_end();  
			} 
        }
		
		$this->db->group_by("tbl_booking_loads1.LoadID ");   
		$this->db->order_by($columnName.' '.$columnSortOrder);	
        $this->db->limit($_REQUEST['length'], $_REQUEST['start']);
		
	    
		$query = $this->db->get('tbl_booking_loads1');
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
		  
		function GetPreInvoiceLoads($InvoiceID)
		{
			
			$this->db->select('tbl_invoice_load.InvoiceID ');
			$this->db->select('tbl_booking_loads1.TipID ');
			$this->db->select('tbl_booking_loads1.NonAppConveyanceNo ');
			$this->db->select('tbl_drivers.AppUser ');
			
			$this->db->select('tbl_tickets.Conveyance as TicketConveyance');
			
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") as TicketDate ');    
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y") as SiteOutDateTime ');    
			$this->db->select('tbl_booking_loads1.BookingDateID ');
			$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialID, tbl_materials.MaterialName');
			$this->db->select('tbl_tickets.TicketNumber ');
			$this->db->select('tbl_tickets.GrossWeight');
			$this->db->select('tbl_tickets.Tare');
			$this->db->select('tbl_tickets.pdf_name as TicketPDF');
			$this->db->select('tbl_booking_loads1.ReceiptName as ConvPDF');
			$this->db->select('tbl_booking_loads1.LoadID '); 
			$this->db->select('tbl_booking_loads1.TipNumber '); 
			$this->db->select('tbl_booking1.Price '); 
			//$this->db->select('tbl_booking_loads1.LoadPrice as Price '); 
			$this->db->select('tbl_booking1.BookingType '); 
			$this->db->select('tbl_tickets.Net'); 
			$this->db->select('tbl_booking_request.WaitingCharge');	
			$this->db->select('ROUND(TIMESTAMPDIFF(MINUTE, SiteInDateTime, SiteOutDateTime) - tbl_booking_request.WaitingTime ) AS WaitTime');  
			$this->db->select('tbl_booking_loads1.DriverName, tbl_booking_loads1.VehicleRegNo, tbl_booking_loads1.Status, tbl_booking_loads1.ConveyanceNo, tbl_booking_loads1.AutoCreated ');
			$this->db->select('tbl_drivers.Haulier ' );
			
			$this->db->select(' tbl_tipticket.TipTicketID '); 
			$this->db->select(' tbl_tipticket.TipTicketNo '); 
			$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  	 	  	 	      
			
			$this->db->from('tbl_invoice_load');  
			$this->db->join('tbl_booking_loads1', 'tbl_invoice_load.LoadID = tbl_booking_loads1.LoadID ','LEFT'); 		    
			$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');    
			$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID','LEFT');    
			$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID',"LEFT"); 
			$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID',"LEFT"); 
			$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT");  
			$this->db->join('tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");   
			$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		    
			$this->db->where('tbl_invoice_load.InvoiceID', $InvoiceID);
			$this->db->where('tbl_booking_loads1.Status > 3 ');  
			$this->db->where('tbl_booking_loads1.Hold = 0 ');  
			$this->db->where('tbl_booking_loads1.Exclude = 0 ');  
			$this->db->group_by('tbl_booking_loads1.LoadID');             
			$query = $this->db->get(); 
		   //echo $this->db->last_query();       
		   //exit;
			$result = $query->result();  
			//$result = $query->result(); 		  
			return $result;
		}	
		
		function GetPreInvoiceLoadsTonnage($InvoiceID)
		{
			$this->db->select('tbl_invoice_load.InvoiceID ');
			$this->db->select('tbl_booking_loads1.TipID ');
			$this->db->select('tbl_booking_loads1.NonAppConveyanceNo ');
			$this->db->select('tbl_drivers.AppUser ');
			
			$this->db->select('tbl_tickets.Conveyance as TicketConveyance');
			
			$this->db->select(' DATE_FORMAT(tbl_tickets.TicketDate,"%d/%m/%Y %T") as TicketDate ');    
			$this->db->select(' DATE_FORMAT(tbl_booking_loads1.SiteOutDateTime,"%d/%m/%Y") as SiteOutDateTime ');    
			$this->db->select('tbl_booking_loads1.BookingDateID ');
			$this->db->select('tbl_tipaddress.TipName, tbl_materials.MaterialID, tbl_materials.MaterialName');
			$this->db->select('tbl_tickets.TicketNumber ');
			$this->db->select('tbl_tickets.GrossWeight');
			$this->db->select('tbl_tickets.Tare');
			$this->db->select('tbl_tickets.pdf_name as TicketPDF');
			$this->db->select('tbl_booking_loads1.ReceiptName as ConvPDF');
			$this->db->select('tbl_booking_loads1.LoadID '); 
			$this->db->select('tbl_booking_loads1.TipNumber '); 
			$this->db->select('tbl_booking_loads1.LoadPrice as Price '); 
			$this->db->select('tbl_booking1.Price '); 
			$this->db->select('tbl_booking1.BookingType '); 
			$this->db->select('tbl_tickets.Net'); 
			$this->db->select('tbl_booking_request.WaitingCharge');	
			$this->db->select('ROUND(TIMESTAMPDIFF(MINUTE, SiteInDateTime, SiteOutDateTime) - tbl_booking_request.WaitingTime ) AS WaitTime');  
			$this->db->select('tbl_booking_loads1.DriverName, tbl_booking_loads1.VehicleRegNo, tbl_booking_loads1.Status, tbl_booking_loads1.ConveyanceNo, tbl_booking_loads1.AutoCreated ');
			$this->db->select('tbl_drivers.Haulier ' );
			
			$this->db->select(' tbl_tipticket.TipTicketID '); 
			$this->db->select(' tbl_tipticket.TipTicketNo '); 
			$this->db->select(' DATE_FORMAT(tbl_tipticket.CreatedDateTime,"%d-%m-%Y") as TipTicketDate ');  	 	  	 	      
			
			$this->db->from('tbl_invoice_load');  
			$this->db->join('tbl_booking_loads1', 'tbl_invoice_load.LoadID = tbl_booking_loads1.LoadID ','LEFT'); 		    
			$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID','LEFT');    
			$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID','LEFT');    
			$this->db->join('tbl_tipaddress', 'tbl_booking_loads1.TipID = tbl_tipaddress.TipID',"LEFT"); 
			$this->db->join('tbl_tickets', 'tbl_booking_loads1.LoadID = tbl_tickets.LoadID',"LEFT"); 
			$this->db->join('tbl_drivers', 'tbl_booking_loads1.DriverID = tbl_drivers.LorryNo ',"LEFT");  
			$this->db->join('tbl_materials', ' tbl_booking_loads1.MaterialID = tbl_materials.MaterialID',"LEFT");   
			$this->db->join('tbl_tipticket', 'tbl_booking_loads1.LoadID = tbl_tipticket.LoadID ','LEFT'); 		    
			$this->db->where('tbl_invoice_load.InvoiceID', $InvoiceID);
			$this->db->where('tbl_booking_loads1.Status > 3 ');  
			$this->db->where('tbl_booking_loads1.Hold = 0 ');  
			$this->db->where('tbl_booking_loads1.Exclude = 0 ');  
			$this->db->group_by('tbl_booking_loads1.LoadID');             
			$query = $this->db->get(); 
		   //echo $this->db->last_query();       
		   //exit;
			$result = $query->result();  
			//$result = $query->result(); 		  
			return $result;
		}	
		
		public function GetPreInvoicesList(){
	 
			$columnIndex = $_POST['order'][0]['column']; // Column index
			$columnName = $_POST['columns'][$columnIndex]['data']; // Column name   
			$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
			$searchValue = trim(strtolower($_POST['search']['value'])); // Search value  
			 
			//Only select column that want to show in datatable or you can filte it mnually when send it
			$this->db->start_cache(); 
			$this->db->select(' tbl_invoice.PreInvoiceNumber ');  
			$this->db->select(' tbl_invoice.InvoiceID ');  
			$this->db->select(' tbl_invoice.CompanyName ');  
			$this->db->select(' tbl_invoice.OpportunityName ');  
			$this->db->select(' tbl_invoice.InvoiceType ');  
			$this->db->select(' DATE_FORMAT(tbl_invoice.PreInvoiceDate,"%d-%m-%Y") as PreInvoiceDate ');  	        
			if( !empty($searchValue) ){  
				
				$s = explode(' ',$searchValue);
				if(count($s)>0){ 
					for($i=0;$i<count($s);$i++){   
						$this->db->group_start(); 
							$this->db->or_like('tbl_invoice.PreInvoiceNumber', $s[$i]);   
							$this->db->or_like('  DATE_FORMAT(tbl_invoice.PreInvoiceDate,"%d-%m-%Y") ', $s[$i]);    
						$this->db->group_end(); 
					}
				}    
			}    
			$this->db->group_by('tbl_invoice.InvoiceID');             
			$this->db->order_by($columnName, $columnSortOrder);		 
			//$this->db->limit(500);
			$query = $this->db->get('tbl_invoice');
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
		
		
		
		public function GetInvoiceLoadsForPreInvoice(){ 
			$this->db->start_cache();  
				$this->db->select(' tbl_booking_loads1.LoadID ');   
				$this->db->select(' tbl_booking_request.CompanyID ');  	 		 
				$this->db->select(' tbl_booking_request.OpportunityID ');		  	
				$this->db->select(' tbl_booking_request.CompanyName '); 
				$this->db->select(' tbl_booking_request.OpportunityName ');  
				$this->db->select(' tbl_booking_loads1.MaterialID ');  
				$this->db->select(' tbl_booking1.TonBook ');				
				$this->db->join('tbl_booking_request', 'tbl_booking_loads1.BookingRequestID = tbl_booking_request.BookingRequestID ','LEFT'); 		    
				$this->db->join('tbl_booking1', 'tbl_booking_loads1.BookingID = tbl_booking1.BookingID ','LEFT'); 		   
				$this->db->join('tbl_invoice_load', ' tbl_booking_loads1.LoadID = tbl_invoice_load.LoadID',"LEFT OUTER");
				
				$this->db->where('tbl_invoice_load.LoadID IS NULL');  
				$this->db->where('tbl_booking_loads1.Status > 3 ');  
				
				$this->db->group_by("tbl_booking_loads1.LoadID ");    
				$query = $this->db->get('tbl_booking_loads1');
			$this->db->stop_cache();   
			//echo $this->db->last_query();
			//exit;
			$result = $query->result_array();     
			return $result;   
        }
		
		   
}

  