<?php 
class Reports_model extends CI_Model{
  public function __construct(){
    parent::__construct();
  } 
  //get ticket report
	public function get_tipped_report($searchdate){

	  	$searchdates= explode('-', $searchdate);
//	    $firstDate = date('Y-m-d',strtotime($searchdates[0]));
//	    $SecondDate = date('Y-m-d',strtotime($searchdates[1]));
		
						
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);


	    $company_id =0 ;
        $per= $this->db->dbprefix;

	   
	    $this->db->select('TicketNumber,TicketDate,DriverName,Conveyance,driver_id,RegNumber,GrossWeight,Tare,Net,count(*) as total_count,sum(Net) as total_net,TypeOfTicket');
	 
	  	$this->db->where('DATE('.$per.'tickets.CreateDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.CreateDate) <=', $SecondDate);
		$this->db->where('delete_notes IS NULL');
	    $this->db->group_by('driver_id'); 
	    $query = $this->db->get('tickets');

	    return $query->result();
	}
	public function get_tml_report($searchdate,$material){

	  	$searchdates= explode('-', $searchdate);
//	    $firstDate = date('Y-m-d',strtotime($searchdates[0]));
//	    $SecondDate = date('Y-m-d',strtotime($searchdates[1]));
		
						
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);


	    $company_id =0 ;
        $per= $this->db->dbprefix;

	 
	    $this->db->select('tickets.TicketNumber,tickets.TicketDate,tickets.MaterialID,tickets.DriverName,tickets.Conveyance,tickets.driver_id,tickets.RegNumber,tickets.GrossWeight,tickets.Tare,tickets.Net,count(tbl_tickets.TicketNumber) as total_count,sum(tbl_tickets.Net) as total_net,tickets.TypeOfTicket,materials.MaterialName');
	    $this->db->join('materials', 'materials.MaterialID = tickets.MaterialID',"LEFT");
	  	$this->db->where('DATE('.$per.'tickets.CreateDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.CreateDate) <=', $SecondDate);
		$this->db->where('tickets.delete_notes IS NULL');
	    if($material != ""){
	    	$this->db->where('tickets.MaterialID', $material);
	    }
	    

	    $this->db->group_by('tickets.MaterialID'); 
	    $query = $this->db->get('tickets');
 
	    return $query->result();
	}
	public function get_tickets_payment_report($searchdate,$paymenttype){

	  	$searchdates= explode('-', $searchdate); 
	    
		//$firstDate = date('Y-m-d',strtotime($searchdates[0]));
	    //$SecondDate = date('Y-m-d',strtotime($searchdates[1]));
		
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
		 
        $per= $this->db->dbprefix;
        
	    $this->db->select('DATE_FORMAT(tbl_tickets.TicketDate, "%d/%m/%Y") as TicketDate,LoadID'); 
        $this->db->select('(select tbl_company.CompanyName FROM tbl_company where tbl_company.CompanyID = tbl_tickets.CompanyID ) as CompanyName '); 		
        $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID = tbl_tickets.OpportunityID ) as OpportunityName '); 		
		$this->db->select('(select tbl_materials.MaterialName FROM tbl_materials where tbl_materials.MaterialID = tbl_tickets.MaterialID ) as MaterialName '); 		
 	    $this->db->select('tbl_tickets.TicketNumber,tbl_tickets.Amount,tbl_tickets.Vat,tbl_tickets.TotalAmount,tbl_tickets.VatAmount');  
	    if($paymenttype!=""){
	    	$this->db->where('tbl_tickets.PaymentType',$paymenttype);
	    } 
	  	$this->db->where('DATE(tbl_tickets.CreateDate) >=', $firstDate); 
	    $this->db->where('DATE(tbl_tickets.CreateDate) <=', $SecondDate); 
		$this->db->where('tbl_tickets.delete_notes IS NULL');
	    $query = $this->db->get('tbl_tickets');
		//echo $this->db->last_query(); 
		//exit; 
	    return $query->result();
	}
    public function get_tickets_report($searchdate,$customer,$material){

	  	$searchdates= explode('-', $searchdate); 
	    
		//$firstDate = date('Y-m-d',strtotime($searchdates[0]));
	    //$SecondDate = date('Y-m-d',strtotime($searchdates[1]));
		
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
		
	    //$company_id =0 ;
        $per= $this->db->dbprefix;
        
	    /*if($customer!=''){
	      
	       $this->db->select('CompanyID');
	       $this->db->where('ContactID',$customer);
	       $cquery = $this->db->get('company_to_contact');
	       $result =  $cquery->row();
	       if($result){
	       	$company_id = $result->CompanyID;
	       } 
	    }*/
	   
	    $this->db->select('DATE_FORMAT(TicketDate, "%d/%m/%Y") as TicketDate,TicketNumber,OpportunityID,DriverName,RegNumber,CompanyName,GrossWeight,Net,Tare,LoadID');
	    $this->db->join('company', 'tickets.CompanyID = company.CompanyID',"LEFT");
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID',"LEFT");
	    if($material!=""){
	    	$this->db->where('tickets.MaterialID',$material);
	    }
	    if($customer!=""){
	    	$this->db->where('tickets.CompanyID',$customer);
	    }
	  	$this->db->where('DATE('.$per.'tickets.CreateDate) >=', $firstDate); 
	    $this->db->where('DATE('.$per.'tickets.CreateDate) <=', $SecondDate); 
		$this->db->where('tickets.delete_notes IS NULL');
	    $query = $this->db->get('tickets');
		//echo $this->db->last_query(); 
		//exit; 
	    return $query->result();
	}
	
	public function GetMaterialReports($searchdate, $type, $tml, $payType, $user ){ 
					 
		$searchdates= explode('-', $searchdate); 			
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
		//print_r($payType);
		//`tbl_tickets`.`TypeOfTicket` <> 'Collection' AND 
		$sql = "SELECT `TypeOfTicket`, `tbl_materials`.`MaterialID`, 
		`tbl_materials`.`MaterialName`, 
		SUM(ROUND(tbl_tickets.Net/1000, 1)) as net_tonnes , 
		SUM(ROUND(tbl_tickets.Net)) as net_tonnes1 , 
		count(tbl_tickets.TicketNo) as CountLoads
		FROM `tbl_tickets`  
		JOIN `tbl_materials` ON `tbl_tickets`.`MaterialID` = `tbl_materials`.`MaterialID`  
		WHERE `tbl_tickets`.`Net` <> 0 AND `tbl_tickets`.`delete_notes` IS NULL
		AND DATE(tbl_tickets.TicketDate) >= '".$firstDate."' AND DATE(tbl_tickets.TicketDate) <= '".$SecondDate."' ";
		if($type !=""){
			$sql .= " AND tbl_tickets.TypeOfTicket = '".$type."' ";
		} 
		if($tml!=""){
			$sql .= " AND tbl_tickets.is_tml = '".$tml."' "; 
		} 
		if($payType){ 
			if(count($payType)>0){ 
				$p = implode(',',$payType);
				
				$sql .= " AND tbl_tickets.PaymentType in('".$p."') "; 
				//$this->db->where_in('tickets.PaymentType', $payType);  
			}
		}
		if($user){ 
			if(count($user)>0){ 
				$u = implode(',',$user); 
				$sql .= " AND tbl_tickets.CreateUserID in(".$u.") ";    
			}
		}
		$sql .= " GROUP BY `tbl_tickets`.`TypeOfTicket`, `tbl_tickets`.`MaterialID` ";
		$sql .= " ORDER BY `tbl_materials`.`MaterialName` ASC ";
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); 
		//exit;
	    return $query->result();
	}
	public function get_ea_report($searchdate, $type,$material,$county, $user){ 
					 
		$searchdates= explode('-', $searchdate); 			
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);

		$sql = "SELECT `TypeOfTicket`, `tbl_materials`.`MaterialName`, `tbl_opportunities`.`County`, 
		SUM(ROUND(Net/1000, 1)) as net_tonnes 
		FROM `tbl_tickets` 
		LEFT JOIN  `tbl_opportunities` ON  `tbl_opportunities`.`OpportunityID` = `tbl_tickets`.`OpportunityID` 
		JOIN `tbl_materials` ON `tbl_tickets`.`MaterialID` = `tbl_materials`.`MaterialID`  
		WHERE `tbl_tickets`.`TypeOfTicket` <> 'Collection' AND `tbl_tickets`.`Net` <> 0 AND `tbl_tickets`.`delete_notes` IS NULL
		AND tbl_tickets.CompanyID != '56SMQ2FGVTJLUX-EZ7WN398-H1CBK4YIDAR'
		AND DATE(tbl_tickets.CreateDate) >= '".$firstDate."' AND DATE(tbl_tickets.CreateDate) <= '".$SecondDate."' ";
		if($type !=""){
			$sql .= " AND tbl_tickets.TypeOfTicket = '".$type."' ";
		}
		if($material !=""){
			$mat = implode("','",$material);	
			$sql .= " AND tbl_tickets.MaterialID IN('".$mat."') ";
		}
		if($county !=""){
			$con = implode("','",$county);
			$sql .= " AND trim(tbl_opportunities.County) in('".$con."') ";
		}
		if($user){ 
			if(count($user)>0){ 
				$u = implode(',',$user); 
				$sql .= " AND tbl_tickets.CreateUserID in(".$u.") ";    
			}
		}
		$sql .= " GROUP BY `tbl_tickets`.`TypeOfTicket`, `tbl_tickets`.`MaterialID`, tbl_opportunities.County ";
		$query = $this->db->query($sql);
		//echo $this->db->last_query(); 
		//exit;
	    return $query->result();
	}

	/* public function get_ea_report($type,$material,$county){ 
 	   
	    $this->db->select('TicketNumber , TypeOfTicket, materials.MaterialName , opportunities.County ,SUM(ROUND(Net/1000,1)) as net_tonnes' );
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID');
		$this->db->join('opportunities', 'tickets.OpportunityID = opportunities.OpportunityID');
		
		//$this->db->select('TicketNumber , TypeOfTicket ,DATE_FORMAT(TicketDate, "%d/%m/%Y") as TicketDate ,  
		//tickets.MaterialID as MaterialID , materials.MaterialName , opportunities.County , ROUND(Net/1000,1) as net_tonnes' );
	    //$this->db->join('materials', 'tickets.MaterialID = materials.MaterialID');
		//$this->db->join('opportunities', 'tickets.OpportunityID = opportunities.OpportunityID');
		//$this->db->join('company', 'tickets.CompanyID = company.CompanyID');
		if($type!=""){
			$this->db->where('tickets.TypeOfTicket',$type); 
		}
		if(!empty($material)){ 
			$this->db->where_in('tickets.MaterialID', $material); 
		}
		if(!empty($county)){ 
			$this->db->where_in('opportunities.County', $county); 
		}		
		$this->db->where('tickets.TypeOfTicket <>', 'Collection'); 
		$this->db->where('tickets.Net <> 0');
	    $this->db->group_by(['tickets.MaterialID' ]);  
	    $query = $this->db->get('tickets');
		echo $this->db->last_query(); 
		exit;
	    return $query->result();
	} */	
	
######################################### TML IN OUT REPORT ######################################################
	
	public function get_tml_tickets_report($searchdate,$customer,$material,$tml,$ttype,$payType,$order,$user){

	  	$searchdates= explode('-', $searchdate);  
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
		 
        $per= $this->db->dbprefix;  
		
	    $this->db->select('TicketTitle,TicketNumber,OrderNo,DATE_FORMAT(TicketDate, "%d/%m/%Y") as TicketDate ,
		Conveyance,OpportunityID, DriverName,RegNumber,CompanyName, Hulller, tickets.MaterialID as MaterialID, materials.MaterialName, driver_id, 
		MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter,tickets.CompanyID	 as CompanyID,  TypeOfTicket,  LoadID,
		company.Street1, company.Street2, company.Town, company.County, company.PostCode ');
	    $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID  = tbl_tickets.OpportunityID ) as SiteName '); 						 
		$this->db->join('company', 'tickets.CompanyID = company.CompanyID',"LEFT");
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID',"LEFT");  
		$this->db->where('tickets.Net <> 0');
	    if($tml!=""){
			$this->db->where('tickets.is_tml',$tml);
		}	
		//if($user!=""){
		//	$this->db->where('tickets.CreateUserID',$user);
		//}
		if($material!=""){
	    	$this->db->where('tickets.MaterialID',$material);
	    }
	    if($customer!=""){
	    	$this->db->where('tickets.CompanyID',$customer);
	    }
		if($ttype){
			if(count($ttype)>0){ 
				$this->db->where_in('tickets.TypeOfTicket', $ttype);  
			}
		}
		if($payType){
			if(count($payType)>0){ 
				$this->db->where_in('tickets.PaymentType', $payType);  
			}
		}
		if($user){
			if(count($user)>0){ 
				$this->db->where_in('tickets.CreateUserID', $user);  
			}
		}
	  	$this->db->where('DATE('.$per.'tickets.TicketDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.TicketDate) <=', $SecondDate);
		$this->db->where('tickets.delete_notes IS NULL');
		$this->db->group_by('tickets.TicketUniqueID'); 
		$this->db->order_by('company.CompanyName ', $order);
		$this->db->order_by('materials.MaterialName', $order);
		$this->db->order_by('tickets.TicketDate', 'ASC');
		//$this->db->order_by('tickets.CompanyID', 'ASC');
		//$this->db->order_by('tickets.MaterialID', 'ASC');
	    $query = $this->db->get('tickets');
		//echo $this->db->last_query(); 
		//exit;
	    return $query->result();
	}
	public function get_tml_tickets_report_export($searchdate,$customer,$material,$tml,$ttype,$payType,$order,$user){

	  	$searchdates= explode('-', $searchdate); 
		
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
 
        $per= $this->db->dbprefix; 
		if($tml =='1' ){
			$tmlq = " AND tt.is_tml = '1' "; 
		}else if($tml =='0' ){
			$tmlq = " AND tt.is_tml = '0' "; 
		}else{
			$tmlq = "  "; 
		}	
		$qtext ="";
		if($ttype){
			if(count($ttype)>0){		
				$type = implode("','",$ttype);		
				$qtext = " AND tt.TypeOfTicket IN('".$type."') ";
			} 
		}
		$qtext1 ="";
		if($payType){		
			if(count($payType)>0){		
				$type1 = implode("','",$payType);		
				$qtext1 = " AND tt.PaymentType IN('".$type1."') ";
			} 
		}

	    /*$this->db->select("( select count(*) from tbl_tickets tt  
		where tt.delete_notes IS NULL ".$tmlq."  AND tt.CompanyID = tbl_tickets.CompanyID and tt.MaterialID = tbl_tickets.MaterialID  
		AND DATE(tt.TicketDate) >= '".$firstDate."' AND DATE(tt.TicketDate) <= '".$SecondDate."'  ".$qtext." ".$qtext1." ) as mCount,
		( select SUM(Net) from tbl_tickets tt where tt.delete_notes IS NULL   ".$tmlq."  and tt.CompanyID = tbl_tickets.CompanyID 
		and tt.MaterialID = tbl_tickets.MaterialID AND DATE(tt.TicketDate) >= '".$firstDate."' AND DATE(tt.TicketDate) <= '".$SecondDate."' ".$qtext." ".$qtext1." ) as netTotal,
		TicketTitle,TicketNumber,DATE_FORMAT(TicketDate, '%d/%m/%Y') as TicketDate ,
		CONCAT(tbl_company.CompanyName,' ',tbl_tickets.CompanyID ) AS CID , CONCAT(  tbl_materials.MaterialName,' ',tbl_tickets.MaterialID ) AS MID ,
		Conveyance,OpportunityID,DriverName,RegNumber,CompanyName, Hulller, tickets.MaterialID as MaterialID, materials.MaterialName, driver_id, 
		MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter,tickets.CompanyID	 as CompanyID,  TypeOfTicket,is_tml,
		company.Street1, company.Street2, company.Town, company.County, company.PostCode "); */
		
		$this->db->select(" TicketTitle,TicketNumber,OrderNo,DATE_FORMAT(TicketDate, '%d/%m/%Y') as TicketDate ,
		CONCAT(tbl_company.CompanyName,' ',tbl_tickets.CompanyID ) AS CID , CONCAT(  tbl_materials.MaterialName,' ',tbl_tickets.MaterialID ) AS MID ,
		Conveyance,OpportunityID,DriverName,RegNumber,CompanyName, Hulller, tickets.MaterialID as MaterialID, materials.MaterialName, driver_id, 
		MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter,tickets.CompanyID	 as CompanyID,  TypeOfTicket,is_tml,
		company.Street1, company.Street2, company.Town, company.County, company.PostCode "); 
	    $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID  = tbl_tickets.OpportunityID ) as SiteName '); 						
		$this->db->join('company', 'tickets.CompanyID = company.CompanyID',"LEFT");
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID',"LEFT"); 
		//$this->db->where('tickets.TypeOfTicket <> "Collection"');
	    //if($user!=""){
		//	$this->db->where('tickets.CreateUserID',$user);
		//}
		if($tml!=""){
			$this->db->where('tickets.is_tml',$tml);
		}
	    if($material!=""){
	    	$this->db->where('tickets.MaterialID',$material);
	    }
	    if($customer!=""){
	    	$this->db->where('tickets.CompanyID',$customer);
	    }
		if($ttype){
			if(count($ttype)>0){ 
				$this->db->where_in('tickets.TypeOfTicket', $ttype);  
			}
		}
		if($payType){
			if(count($payType)>0){ 
				$this->db->where_in('tickets.PaymentType', $payType);  
			}
		}
		if($user){
			if(count($user)>0){ 
				$this->db->where_in('tickets.CreateUserID', $user);  
			}
		}
	  	$this->db->where('DATE('.$per.'tickets.TicketDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.TicketDate) <=', $SecondDate);
		 
		$this->db->where('tickets.delete_notes IS NULL'); 
		$this->db->group_by('tickets.TicketUniqueID'); 
		$this->db->order_by('CID', $order);
		$this->db->order_by('MID', 'ASC'); 
		//$this->db->order_by('tickets.CompanyID', 'ASC');
		//$this->db->order_by('company.CompanyName ', 'ASC');
		//$this->db->order_by('tickets.MaterialID', 'ASC');
		//$this->db->order_by('materials.MaterialName', 'ASC');
		$this->db->order_by('tickets.OrderNo', 'ASC');
		$this->db->order_by('tickets.TicketDate', 'ASC');
	    $query = $this->db->get('tickets');
		//echo $this->db->last_query(); 
		//exit;
	    return $query->result();
	}
	public function get_tml_tickets_report_export_material($searchdate,$customer,$material,$tml,$ttype,$payType,$order,$user){

	  	$searchdates= explode('-', $searchdate); 
		
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
 
        $per= $this->db->dbprefix;
  	    if($tml =='1' ){
			$tmlq = " AND tt.is_tml = '1' "; 
		}else if($tml =='0' ){
			$tmlq = " AND tt.is_tml = '0' "; 
		}else{
			$tmlq = "  "; 
		}	
		$qtext ="";
		if($ttype){
			if(count($ttype)>0){		
				$type = implode("','",$ttype);		
				$qtext = " AND tt.TypeOfTicket IN('".$type."') ";
			} 
		}
		$qtext1 ="";
		if($payType){		
			if(count($payType)>0){		
				$type1 = implode("','",$payType);		
				$qtext1 = " AND tt.PaymentType IN('".$type1."') ";
			} 
		}
	    /*$this->db->select("( select count(*) from tbl_tickets tt  
		where tt.delete_notes IS NULL ".$tmlq."
		and tt.CompanyID = tbl_tickets.CompanyID 
		and tt.MaterialID = tbl_tickets.MaterialID  
		AND DATE(tt.TicketDate) >= '".$firstDate."' AND DATE(tt.TicketDate) <= '".$SecondDate."' ".$qtext." ".$qtext1." ) as mCount,
		( select SUM(Net) from tbl_tickets tt  
		where  tt.delete_notes IS NULL ".$tmlq."
		and tt.CompanyID = tbl_tickets.CompanyID 
		and tt.MaterialID = tbl_tickets.MaterialID  
		AND DATE(tt.TicketDate) >= '".$firstDate."' AND DATE(tt.TicketDate) <= '".$SecondDate."' ".$qtext."  ".$qtext1." ) as netTotal,
		tickets.CompanyID as CompanyID,  tickets.MaterialID as MaterialID, TicketTitle,TicketNumber,DATE_FORMAT(TicketDate, '%d/%m/%Y') as TicketDate ,
		CONCAT(tbl_company.CompanyName,' ',tbl_tickets.CompanyID ) AS CID , CONCAT(  tbl_materials.MaterialName,' ',tbl_tickets.MaterialID ) AS MID ,
		Conveyance,OpportunityID,DriverName,RegNumber,CompanyName, Hulller,  materials.MaterialName, driver_id, 
		MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter,TypeOfTicket,is_tml,
		company.Street1, company.Street2, company.Town, company.County, company.PostCode "); */
		
		$this->db->select("tickets.CompanyID as CompanyID,  tickets.MaterialID as MaterialID, OrderNo, TicketTitle,TicketNumber,DATE_FORMAT(TicketDate, '%d/%m/%Y') as TicketDate ,
		CONCAT(tbl_company.CompanyName,' ',tbl_tickets.CompanyID ) AS CID , CONCAT(  tbl_materials.MaterialName,' ',tbl_tickets.MaterialID ) AS MID ,
		Conveyance,OpportunityID,DriverName,RegNumber,CompanyName, Hulller,  materials.MaterialName, driver_id, 
		MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter,TypeOfTicket,is_tml,
		company.Street1, company.Street2, company.Town, company.County, company.PostCode ");
		
	    $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID  = tbl_tickets.OpportunityID ) as SiteName '); 						
		$this->db->join('company', 'tickets.CompanyID = company.CompanyID',"LEFT");
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID',"LEFT"); 
	    //$this->db->where('tickets.TypeOfTicket <> "Collection"');
	    if($user){
			if(count($user)>0){ 
				$this->db->where_in('tickets.CreateUserID', $user);  
			}
		}
		if($tml!=""){
			$this->db->where('tickets.is_tml',$tml);
		}
		if($material!=""){
	    	$this->db->where('tickets.MaterialID',$material);
	    }
	    if($customer!=""){
	    	$this->db->where('tickets.CompanyID',$customer);
	    }
		if($ttype){
			if(count($ttype)>0){
				//$mat = implode("','",$ttype);	
				$this->db->where_in('tickets.TypeOfTicket', $ttype);  
			}
		}
		if($payType){
			if(count($payType)>0){ 
				$this->db->where_in('tickets.PaymentType', $payType);  
			}
		}
	  	$this->db->where('DATE('.$per.'tickets.TicketDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.TicketDate) <=', $SecondDate);	
		$this->db->where('tickets.delete_notes IS NULL');		 
		$this->db->group_by('tickets.TicketUniqueID');   
		$this->db->order_by('MID', $order ); 
		$this->db->order_by('CID', 'ASC');
		//$this->db->order_by('tickets.MaterialID', 'ASC');
		//$this->db->order_by('tickets.CompanyID	', 'ASC');
		//$this->db->order_by('materials.MaterialName', 'ASC');
		//$this->db->order_by('company.CompanyName ', 'ASC');
		$this->db->order_by('tickets.OrderNo', 'ASC'); 
		$this->db->order_by('tickets.TicketDate', 'ASC'); 
	    //$this->db->order_by('tickets.TicketDate', 'ASC');
		$query = $this->db->get('tickets');
		//echo $this->db->last_query(); 
		//exit;
	    return $query->result();
	}	

#######################################################################################################################
	
	public function get_tippedin_report_export($searchdate,$customer,$material){

	  	$searchdates= explode('-', $searchdate); 
		
		$f = explode('/',$searchdates[0]);
		$firstDate = trim($f[2]).'-'.trim($f[1]).'-'.trim($f[0]);
		$s = explode('/',$searchdates[1]); 
		$SecondDate = trim($s[2]).'-'.trim($s[1]).'-'.trim($s[0]);
 
        $per= $this->db->dbprefix; 
	   
	    $this->db->select("( select count(*) from tbl_tickets tt  
		where tt.is_tml = 1 
		and tt.TypeOfTicket = 'In' 
		and  tt.CompanyID = tbl_tickets.CompanyID 
		and tt.MaterialID = tbl_tickets.MaterialID
		AND tt.delete_notes IS NULL  
		AND DATE(tt.CreateDate) >= '".$firstDate."' AND DATE(tt.CreateDate) <= '".$SecondDate."' ) as mCount,
		( select SUM(Net) from tbl_tickets tt  
		where tt.is_tml = 1  
		and tt.TypeOfTicket = 'In' 
		and  tt.CompanyID = tbl_tickets.CompanyID 
		and tt.MaterialID = tbl_tickets.MaterialID
		AND tt.delete_notes IS NULL  
		AND DATE(tt.CreateDate) >= '".$firstDate."' AND DATE(tt.CreateDate) <= '".$SecondDate."' ) as netTotal,
		tickets.CompanyID	 as CompanyID,  tickets.MaterialID as MaterialID, TicketTitle,TicketNumber,DATE_FORMAT(TicketDate, '%d/%m/%Y') as TicketDate ,
		Conveyance,OpportunityID,DriverName,RegNumber,CompanyName, Hulller,  materials.MaterialName, driver_id, 
		MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter,TypeOfTicket,
		company.Street1, company.Street2, company.Town, company.County, company.PostCode ");
	    $this->db->select('(select tbl_opportunities.OpportunityName FROM tbl_opportunities where tbl_opportunities.OpportunityID  = tbl_tickets.OpportunityID ) as SiteName '); 						
		$this->db->join('company', 'tickets.CompanyID = company.CompanyID',"LEFT");
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID',"LEFT");
		$this->db->where('tickets.is_tml',1);
		$this->db->where('tickets.TypeOfTicket',"In"); 
	    if($material!=""){
	    	$this->db->where('tickets.MaterialID',$material);
	    }
	    if($customer!=""){
	    	$this->db->where('tickets.CompanyID',$customer);
	    }
		$this->db->where('tickets.delete_notes IS NULL');
	  	$this->db->where('DATE('.$per.'tickets.CreateDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.CreateDate) <=', $SecondDate);	
		$this->db->order_by('materials.MaterialName', 'ASC');
		$this->db->order_by('company.CompanyName ', 'ASC');
		$this->db->order_by('tickets.TicketDate', 'ASC');
//		$this->db->order_by('tickets.MaterialID', 'ASC');
//		$this->db->order_by('tickets.CompanyID	', 'ASC');
	    $query = $this->db->get('tickets');
		//echo $this->db->last_query(); 
		//exit;
	    return $query->result();
	}	
    public function get_tickets_details($ticketNo){
       
        $this->db->select('TicketTitle,TicketNumber,TicketDate,Conveyance,DriverName,RegNumber,CompanyName,tickets.CompanyID,tickets.OpportunityID, Hulller, MaterialName,tickets.SicCode,GrossWeight,Net,Tare, OpportunityName,company.Street1,company.Street2,company.Town,company.County,company.PostCode');
        $this->db->join('opportunities', 'tickets.OpportunityID = opportunities.OpportunityID',"LEFT");
        $this->db->join('company', 'tickets.CompanyID = company.CompanyID',"LEFT");
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID',"LEFT");
        $this->db->where('tickets.TicketNumber',$ticketNo);
        $query = $this->db->get('tickets');
	    return $query->row();
    }
}
?>