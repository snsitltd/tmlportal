<?php 
class Reports_model extends CI_Model{
  public function __construct()
  {
    parent::__construct();
  }

  //get ticket report
 public function get_tipped_report($searchdate){

	  	$searchdates= explode('-', $searchdate);
	    $firstDate = date('Y-m-d',strtotime($searchdates[0]));
	    $SecondDate = date('Y-m-d',strtotime($searchdates[1]));
	    $company_id =0 ;
        $per= $this->db->dbprefix;

	   
	    $this->db->select('TicketNo,TicketDate,DriverName,Conveyance,driver_id,RegNumber,GrossWeight,Tare,Net,count(*) as total_count,sum(Net) as total_net,TypeOfTicket');
	 
	  	$this->db->where('DATE('.$per.'tickets.CreateDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.CreateDate) <=', $SecondDate);
	    $this->db->group_by('driver_id'); 
	    $query = $this->db->get('tickets');

	    return $query->result();
	}
	 public function get_tml_report($searchdate,$material){

	  	$searchdates= explode('-', $searchdate);
	    $firstDate = date('Y-m-d',strtotime($searchdates[0]));
	    $SecondDate = date('Y-m-d',strtotime($searchdates[1]));
	    $company_id =0 ;
        $per= $this->db->dbprefix;

	 
	    $this->db->select('tickets.TicketNo,tickets.TicketDate,tickets.MaterialID,tickets.DriverName,tickets.Conveyance,tickets.driver_id,tickets.RegNumber,tickets.GrossWeight,tickets.Tare,tickets.Net,count(tbl_tickets.TicketNo) as total_count,sum(tbl_tickets.Net) as total_net,tickets.TypeOfTicket,materials.MaterialName');
	    $this->db->join('materials', 'materials.MaterialID = tickets.MaterialID');
	  	$this->db->where('DATE('.$per.'tickets.CreateDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.CreateDate) <=', $SecondDate);
	    if($material != ""){
	    	$this->db->where('tickets.MaterialID', $material);
	    }
	    

	    $this->db->group_by('tickets.MaterialID'); 
	    $query = $this->db->get('tickets');
 
	    return $query->result();
	}
    public function get_tickets_report($searchdate,$customer,$material){

	  	$searchdates= explode('-', $searchdate);
	    $firstDate = date('Y-m-d',strtotime($searchdates[0]));
	    $SecondDate = date('Y-m-d',strtotime($searchdates[1]));
	    $company_id =0 ;
        $per= $this->db->dbprefix;
        
	    if($customer!=''){
	      
	       $this->db->select('CompanyID');
	       $this->db->where('ContactID',$customer);
	       $cquery = $this->db->get('company_to_contact');
	       $result =  $cquery->row();
	       if($result){
	       	$company_id = $result->CompanyID;
	       }

	    }
	   
	    $this->db->select('TicketTitle,TicketNo,TicketDate,Conveyance,OpportunityID,DriverName,RegNumber,CompanyName, Hulller, MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter');
	    $this->db->join('company', 'tickets.CompanyID = company.CompanyID');
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID');
	    if($material!=""){
	    	$this->db->where('tickets.MaterialID',$material);
	    }
	    if($company_id>0){
	    	$this->db->where('tickets.CompanyID',$company_id);
	    }
	  	$this->db->where('DATE('.$per.'tickets.CreateDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.CreateDate) <=', $SecondDate);
	    $query = $this->db->get('tickets');
		 
	    return $query->result();
	}
	 public function get_tml_tickets_report($searchdate,$customer,$material){

	  	$searchdates= explode('-', $searchdate);
	    $firstDate = date('Y-m-d',strtotime($searchdates[0]));
	    $SecondDate = date('Y-m-d',strtotime($searchdates[1]));
	    $company_id =0 ;
        $per= $this->db->dbprefix;
        
	    if($customer!=''){
	      
	       $this->db->select('CompanyID');
	       $this->db->where('ContactID',$customer);
	       $cquery = $this->db->get('company_to_contact');
	       $result =  $cquery->row();
	       if($result){
	       	$company_id = $result->CompanyID;
	       }

	    }
	   
	    $this->db->select('TicketTitle,TicketNo,DATE_FORMAT(TicketDate, "%d/%m/%Y") as TicketDate ,
		Conveyance,OpportunityID,DriverName,RegNumber,CompanyName, Hulller, tickets.MaterialID as MaterialID, driver_id, 
		MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter,
		company.Street1, company.Street2, company.Town, company.County, company.PostCode ');
	    $this->db->join('company', 'tickets.CompanyID = company.CompanyID');
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID');
		$this->db->where('tickets.is_tml',1);
	    if($material!=""){
	    	$this->db->where('tickets.MaterialID',$material);
	    }
	    if($company_id>0){
	    	$this->db->where('tickets.CompanyID',$company_id);
	    }
	  	$this->db->where('DATE('.$per.'tickets.CreateDate) >=', $firstDate);
	    $this->db->where('DATE('.$per.'tickets.CreateDate) <=', $SecondDate);
	    $query = $this->db->get('tickets');
		 
	    return $query->result();
	}

    public function get_tickets_details($ticketNo){
       
        $this->db->select('TicketTitle,TicketNo,TicketDate,Conveyance,DriverName,RegNumber,CompanyName, Hulller, MaterialName,tickets.SicCode,GrossWeight,Net,Tare,SOM,Rnum,Cmeter,OpportunityName,company.Street1,company.Street2,company.Town,company.County,company.PostCode');
        $this->db->join('opportunities', 'tickets.OpportunityID = opportunities.OpportunityID');
        $this->db->join('company', 'tickets.CompanyID = company.CompanyID');
	    $this->db->join('materials', 'tickets.MaterialID = materials.MaterialID');
        $this->db->where('tickets.TicketNo',$ticketNo);
        $query = $this->db->get('tickets');
	    return $query->row();
    }
}
?>