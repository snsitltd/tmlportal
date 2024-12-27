<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php'; 
class Tickets extends BaseController
{
    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tickets_model');        
        $this->isLoggedIn();  
      
        $roleCheck = $this->Common_model->checkpermission('tickets'); 

        //print_r($roleCheck);die;

        $this->global['isView'] = $this->isView = $roleCheck->view;   
         $this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
         $this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
         $this->global['isDelete'] = $this->isDelete = $roleCheck->delete; 
         $this->global['active_menu'] = 'dashboard'; 

    }
	public function TEST(){  
	
		require_once(APPPATH.'third_party/fpdf17/fpdf.php');
		require_once(APPPATH.'third_party/FPDI/fpdi.php');
		//require('fpdf.php');
		//require('fpdi.php');

		$files = ['assets/pdf_file/PVNG7FIX1ULH.pdf' , 'assets/pdf_file/B7AKJZRI3V05.pdf'];

		$pdf = new FPDI();

		// iterate over array of files and merge
		foreach ($files as $file) {
			$pageCount = $pdf->setSourceFile($file);
			for ($i = 0; $i < $pageCount; $i++) {
				$tpl = $pdf->importPage($i + 1, '/MediaBox');
				$pdf->addPage();
				$pdf->useTemplate($tpl);
			}
		}

		// output the pdf as a file (http://www.fpdf.org/en/doc/output.htm)
		$pdf->Output('F','test.pdf'); 

/*          $data = array(); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TEST TICKET';
            $this->global['active_menu'] = 'test'; 
            
			$data = $this->tickets_model->TEST();  
			 
            $this->loadViews("Tickets/test", $this->global, $data, NULL);
			$this->output->enable_profiler(TRUE);  */
			
    }

##############################################################################################

    public function index(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();
            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tickets Listing';
            $this->global['active_menu'] = 'tickets'; 
            
            $this->loadViews("Tickets/AjaxTickets", $this->global, $data, NULL);
			//$this->output->enable_profiler(TRUE);
        }
    }

	public function AJAXTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetTicketData(); 
		$this->ajax->send($data);
	}
 
##############################################################################################
	
    public function tmlTicket(){

        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
			$data=array();	
           // $data['ticketsRecords'] = $this->tickets_model->tmlticketsListing(); 

            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML Tickets Listing';
            $this->global['active_menu'] = 'tmltickets'; 
            
            $this->loadViews("Tickets/tml_tickets", $this->global, $data, NULL);
        }
    }
	
	public function AJAXTmlTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetTmlTicketData();   
		$this->ajax->send($data);
	}
	
##############################################################################################	
	
	public function tmlHoldTicket(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array();
           // $data['ticketsRecords'] = $this->tickets_model->tmlticketsListingHOLD(); 

            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML HOLD Tickets Listing';
            $this->global['active_menu'] = 'tmlholdtickets'; 
            
            $this->loadViews("Tickets/tml_hold_tickets", $this->global, $data, NULL);
        }
    }
	
	public function AJAXHoldTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetHoldTicketData();   
		$this->ajax->send($data);
	}

##############################################################################################	
	
	public function InboundTicket(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array(); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Inbound Tickets Listing';
            $this->global['active_menu'] = 'inboundtickets'; 
            
            $this->loadViews("Tickets/InboundTickets", $this->global, $data, NULL);
        }
    }
	
	public function AJAXInboundTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetInboundTicketData();   
		$this->ajax->send($data);
	}

##############################################################################################	

##############################################################################################	
	
	public function IncompletedTicket(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array(); 
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Incompleted Tickets Listing';
            $this->global['active_menu'] = 'incompletedtickets'; 
            
            $this->loadViews("Tickets/IncompletedTickets", $this->global, $data, NULL);
        }
    }
	
	public function AJAXIncompletedTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetIncompletedTicketData();   
		$this->ajax->send($data);
	}

##############################################################################################	
		
	public function deleteTickets(){

        if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data=array();
           // $data['ticketsRecords'] = $this->tickets_model->ticketsListingDeleted(); 

            //echo '<pre>';print_r($data['ticketsRecords']);die;           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Deleted Tickets Listing';
            $this->global['active_menu'] = 'deleteTickets'; 
            
            $this->loadViews("Tickets/deleteTickets", $this->global, $data, NULL);
        }
    }    
	public function AJAXDeleteTickets(){  
		$this->load->library('ajax');
		$data = $this->tickets_model->GetDeleteTicketData();   
		$this->ajax->send($data);
	}

##############################################################################################	


    function OfficeTicket(){
        if($this->isAdd == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();         
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") );  
	        $data['company_list'] = $this->Common_model->CompanyList();
			$data['TicketNumber'] = $this->uri->segment(2); 
			$data['COMID'] = $this->Common_model->GetCompanyID($data['TicketNumber']); 
			 
	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;
			 
            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));  
			$data['county'] = $this->Common_model->get_all('county');
			 
			$this->global['pageTitle'] = WEB_PAGE_TITLE.'ADD Office (GAP) TICKET';
            $this->global['active_menu'] = 'tickets'; 

            $this->loadViews("Tickets/OfficeTicket", $this->global, $data, NULL);
        }
    }

##############################################################################################

    function inTickets(){
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data = array();          

            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") );
			$data['company_list'] = $this->Common_model->CompanyList( );

            $type = 'IN';
	        
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;

	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$data['county'] = $this->Common_model->get_all('county');
            //$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add In Ticket';
			$this->global['pageTitle'] = WEB_PAGE_TITLE.'ADD IN TICKET';
            $this->global['active_menu'] = 'intickets'; 

            $this->loadViews("Tickets/inTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################


    function inTickets1()
    {
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
            $data = array();          

            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") );
			$data['company_list'] = $this->Common_model->CompanyList( );
            $type = 'IN';
	        
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;

	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add In Ticket';
            $this->global['active_menu'] = 'intickets'; 

            $this->loadViews("Tickets/inTickets1", $this->global, $data, NULL);
        }
    }
	
##############################################################################################


    function collectionTickets()
    {
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {            
           $data = array();

           //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList( );	
            $type = 'Collection';
            
            $Material = $this->tickets_model->getMaterialList($type);
            $data['Material']=$Material;

             $Lorry = $this->tickets_model->getLorryNo();
             $data['Lorry']=$Lorry;

            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$data['county'] = $this->Common_model->get_all('county');
			//$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add Collection Ticket';
			$this->global['pageTitle'] = WEB_PAGE_TITLE.'ADD COLLECTION TICKET';
			
            $this->global['active_menu'] = 'colltickets'; 

            $this->loadViews("Tickets/collectionTickets", $this->global, $data, NULL);
			
        }
    }

##############################################################################################


    function outTickets()
    {
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {           
            $data = array();            
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList( );
			
            $type = 'OUT';
	        
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;

	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$data['county'] = $this->Common_model->get_all('county');
			//$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Add Out Ticket';
			$this->global['pageTitle'] = WEB_PAGE_TITLE.'ADD OUT TICKET';			
            $this->global['active_menu'] = 'outtickets'; 

            $this->loadViews("Tickets/outTickets", $this->global, $data, NULL);
        }
    }
  
##############################################################################################

	function generateRandomString($length = 12) {
		return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
	function GetHoldCount() {
		$conditions = array( 'is_hold' => 1 , 'delete_notes' => NULL );
//		echo $this->Common_model->select_count_where('tbl_tickets',$conditions);  
		echo $this->Common_model->CountHoldTicket();  
		
	}
	function getCompanyList(){ 
			$result['company_list'] = $this->Common_model->CompanyListAJAX() ; 
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
    }
	function getLorryList(){ 
			$result['lorry_list'] = $this->Common_model->LorryListAJAX() ; 
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); } 
    }	

##############################################################################################

	
    function editInTicket($TicketID){   
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($TicketID == null){
                redirect('All-Tickets');
            }          
            
            $conditions = array( 'TicketNo' => $TicketID );
            $data['tickets'] = $this->Common_model->select_where("tickets",$conditions);
			  
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList();
            $data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])) ;
		
            //print_r($data['SiteAddress']); die;          
		
            $type = 'IN';
	    
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;

	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Ticket';
            $this->global['active_menu'] = 'editintickets'; 
            
            $this->loadViews("Tickets/editInTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################
	
	function EditInBound($TicketID){   
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($TicketID == null){
                redirect('All-Tickets');
            }          
            
            $conditions = array( 'TicketNo' => $TicketID );
            $data['tickets'] = $this->Common_model->select_where("tickets",$conditions);
			$data['BookingNotes'] = $this->tickets_model->getBookingNote($data['tickets']['LoadID']);
			
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList();
            $data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])) ;
		
            //print_r($data['SiteAddress']); die;          
		
            $type = 'IN';
	    
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;
			
			if($data['tickets']['DriverLoginID']!=0){
				$data['Dsignature']	 = $this->tickets_model->getSignature($data['tickets']['DriverLoginID']); 
			}else{ 
				$data['Dsignature']	 = $data['tickets']['driversignature'];
			} 
			
	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Inbound Ticket';
            $this->global['active_menu'] = 'editinbound'; 
            
            $this->loadViews("Tickets/EditInBound", $this->global, $data, NULL);
        }
    }
	
##############################################################################################

##############################################################################################
	
	function EditInCompleted($TicketID){   
    	if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            if($TicketID == null){
                redirect('All-Tickets');
            }          
            
            $conditions = array( 'TicketNo' => $TicketID );
            //$data['tickets'] = $this->Common_model->select_where("tickets",$conditions);
			$data['tickets'] = $this->tickets_model->InCompletedTicketDetails($TicketID);
			$data['BookingNotes'] = $this->tickets_model->getBookingNote($data['tickets']['LoadID']);
			
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
			$data['company_list'] = $this->Common_model->CompanyList();
            $data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])); 
            //print_r($data['SiteAddress']); die;          
			
            $type = 'IN';
	    
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;
			
			if($data['tickets']['DriverLoginID']!=0){
				$data['Dsignature']	 = $this->tickets_model->getSignature($data['tickets']['DriverLoginID']); 
			}else{ 
				$data['Dsignature']	 = $data['tickets']['driversignature'];
			} 
			
	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;

			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit InCompleted Ticket';
            $this->global['active_menu'] = 'editincompleted'; 
            
            $this->loadViews("Tickets/EditInCompleted", $this->global, $data, NULL);
        }
    }
	
##############################################################################################

    function ViewInTicket($TicketID)
    {   
	
    	if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null){ redirect('All-Tickets'); }          
            $data['TicketInfo'] = $this->tickets_model->getTicketInfo($TicketID);
			
			if($data['TicketInfo']['TypeOfTicket']!="In"){ redirect('All-Tickets'); }
			  
			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View InTicket';
            $this->global['active_menu'] = 'viewintickets'; 
            
            $this->loadViews("Tickets/ViewInTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################


    function ViewOutTicket($TicketID)
    {   
	
    	if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null){ redirect('All-Tickets'); }          
            $data['TicketInfo'] = $this->tickets_model->getTicketInfo($TicketID);
			
			if($data['TicketInfo']['TypeOfTicket']!="Out"){ redirect('All-Tickets'); }
			  
			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View OutTicket';
            $this->global['active_menu'] = 'viewouttickets'; 
            
            $this->loadViews("Tickets/ViewOutTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################


    function ViewCollectionTicket($TicketID)
    {   
	
    	if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null){ redirect('All-Tickets'); }          
            $data['TicketInfo'] = $this->tickets_model->getTicketInfo($TicketID);
			
			if($data['TicketInfo']['TypeOfTicket']!="Collection"){ redirect('All-Tickets'); }
			  
			$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : View CollectionTicket';
            $this->global['active_menu'] = 'viewcollectiontickets'; 
            
            $this->loadViews("Tickets/ViewCollectionTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################

 
    function editCollectionTicket($TicketID)
    {   
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null)
            {
                redirect('All-Tickets');
            }          
            
            $conditions = array(
                 'TicketNo' => $TicketID
            );
            $data['tickets'] = $this->Common_model->select_where("tickets",$conditions);
            //$data['company_list'] = $this->Common_model->select_all_where_order_custom('company',array("status"=>1) , array("CompanyName","ASC") ); 
            $data['company_list'] = $this->Common_model->CompanyList( );
			$data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])) ;

            $type = 'Collection';
            
            $Material = $this->tickets_model->getMaterialList($type);
            $data['Material']=$Material;

            $Lorry = $this->tickets_model->getLorryNo();
            $data['Lorry']=$Lorry;


            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Ticket';
            $this->global['active_menu'] = 'editcolltickets'; 
            
            $this->loadViews("Tickets/editCollectionTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################

 
    function editOutTicket($TicketID)
    {   
	
    	if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            if($TicketID == null){ redirect('All-Tickets');  }          
            
            $conditions = array( 'TicketNo' => $TicketID  );
            $data['tickets'] = $this->Common_model->select_where("tickets",$conditions);   
			$data['BookingNotes'] = $this->tickets_model->getBookingNote($data['tickets']['LoadID']);
			 
            $data['company_list'] = $this->Common_model->CompanyList( );
			$data['opprtunities'] = $this->tickets_model->getAllOpportunitiesByCompany($data['tickets']['CompanyID']) ;
            $data['SiteAddress'] = $this->Common_model->select_singel_where('opportunities',array("OpportunityID"=>$data['tickets']['OpportunityID'])) ;
 
            $type = 'OUT';
	        
	        $Material = $this->tickets_model->getMaterialList($type);
	        $data['Material']=$Material;
			
			if($data['tickets']['DriverLoginID']!=0){
				$data['Dsignature']	 = $this->tickets_model->getSignature($data['tickets']['DriverLoginID']); 
			}else{ 
				$data['Dsignature']	 = $data['tickets']['driversignature'];
			} 
			
	        $Lorry = $this->tickets_model->getLorryNo();
	        $data['Lorry']=$Lorry;
 
            $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
			$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Edit Ticket';
            $this->global['active_menu'] = 'editouttickets'; 
            
            $this->loadViews("Tickets/editOutTickets", $this->global, $data, NULL);
        }
    }

##############################################################################################
        
    function deleteTicket()
    {
        if($this->isDelete == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            $TicketNo = $this->input->post('TicketNo'); 

            $con = array('TicketNo'=>$TicketNo);           
            
            //$result = $this->Common_model->delete('tickets', $con);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

##############################################################################################

 
    function deleteNotes()
    {
        if($this->isDelete == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {  
            $TicketNo = $this->input->post('TicketNo'); 
			$Notes = $this->input->post('confirmation'); 
            $con = array('TicketNo'=>$TicketNo);           
            
             $ticketsInfo = array('delete_notes'=>$Notes);
			//$result = $this->Common_model->delete('tickets', $con);
            $result = $this->Common_model->update("tickets",$ticketsInfo, $con);     

            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
	function restoreTicket()
    {
        if($this->isDelete == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{  
            $TicketNo = $this->input->post('TicketNo'); 
			//$Notes = $this->input->post('confirmation'); 
            $con = array('TicketNo'=>$TicketNo);            
            $ticketsInfo = array('delete_notes'=>null); 
            $result = $this->Common_model->update("tickets",$ticketsInfo, $con);      
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

##############################################################################################


	function AddOfficeTicketAJAX(){   
        if($this->isAdd == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
                $TicketNumber = $this->security->xss_clean($this->input->post('TicketNumber'));
				$TicketGap = $this->security->xss_clean($this->input->post('TicketGap'));
				$TypeOfTicket = $this->input->post('TypeOfTicket');
				$WIFNumber = $this->input->post('WIFNumber');
				//$TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$Street1 = $this->security->xss_clean($this->input->post('Street1'));
				$County = $this->security->xss_clean($this->input->post('County'));
				$Town = $this->security->xss_clean($this->input->post('Town'));
				$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
				
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial')); 
				$SicCode = $this->security->xss_clean($this->input->post('SicCode')); 
				 
				$LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
				$VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
                $VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				$DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$Tare = $this->security->xss_clean($this->input->post('Tare'));
				$ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes'));
				
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Net = $this->security->xss_clean($this->input->post('Net'));
                
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$is_hold = $this->security->xss_clean($this->input->post('is_hold'));
                //$date = str_replace('/', '-', $TicketDate); 
                //$TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo')); 
				$driversignature = $this->input->post('driversignature', FALSE);  
				if($LorryNo == 0){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}
				  
				if($CompanyID == '0'){ 
					if(trim($CompanyName)==""){ 	
						echo "Error";
						exit;
					}
					$CompanyID = $this->generateRandomString();
					$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s') ,); 
					$this->Common_model->insert("tbl_company",$CompanyInfo);
				}	 
				if($OpportunityID == '0'){   
					if(trim($Street1)=="" && trim($Town)=="" && trim($County)=="" && trim($PostCode)==""){ 	
						echo "Error";
						exit;
					}
					$OpportunityID = $this->generateRandomString(); 
					$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
					$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 
					'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode); 
					$this->Common_model->insert("tbl_opportunities",$OppoInfo);
					
					$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
					$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
				}  
				
                $TicketUniqueID = $this->generateRandomString();    			
				$lastdate = $this->tickets_model->LastTicketDate($TicketNumber);  
				if($lastdate['TicketDate']){ $TicketDate = $lastdate['TicketDate']; }else{ 
				//$TicketDate  = date('Y-m-d H:i:s'); 
				$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
				}
					
				$ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID,'TicketNumber'=>$TicketNumber,'TicketGap'=>$TicketGap, 'WIFNumber'=>$WIFNumber, 
				'TicketDate'=>$TicketDate, 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,'MaterialID'=>$DescriptionofMaterial ,
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,'Net'=>$Net , 
				'SicCode'=>$SicCode,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>$TypeOfTicket,'pdf_name'=>$TicketUniqueID.".pdf",
				'driver_id'=>$driverid ,'is_tml'=>$is_tml ,'is_hold'=>$is_hold, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,  'VatAmount'=>$VatAmount,
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo ,'driversignature'=>$driversignature,'ticket_notes'=>$ticket_notes );
				
				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
					$Tn = $this->tickets_model->CheckDuplicateTicket($TicketNumber, $TicketGap);   
					if($Tn==0){ 				
						$ticketId = $this->Common_model->insert('tbl_tickets', $ticketsInfo); 
					}else{ 
						echo "Error";
						exit;
					}
					if($ticketId > 0){  
							$conditions = array(
							 'TicketNo' => $ticketId
							);
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($ticketId);  
							if($TypeOfTicket=="Out"){
									$html=$this->load->view('Tickets/ticket_pdf_out', $data, true);
							}else{		
									$html=$this->load->view('Tickets/ticket_pdf', $data, true);
							}		
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf"; 
							 //load mPDF library
							$this->load->library('m_pdf'); 
						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html); 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F");  
							echo base_url($openPath); 
					}else{
						echo "Error";
					}
				}	
                  
        }
    }
	
##############################################################################################
	 
	function AddTicketAJAX(){   
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {    
	//var_dump($_POST);
	 
                $TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
				$WIFNumber = $this->security->xss_clean($this->input->post('WIFNumber'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$Street1 = $this->security->xss_clean($this->input->post('Street1'));
				$County = $this->security->xss_clean($this->input->post('County'));
				$Town = $this->security->xss_clean($this->input->post('Town'));
				$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
				
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                //$MaterialType = $this->security->xss_clean($this->input->post('MaterialType'));
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes'));
				
				$LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
				$VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$Tare = $this->security->xss_clean($this->input->post('Tare'));
				
				$CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Net = $this->security->xss_clean($this->input->post('Net'));
                 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$is_hold = $this->security->xss_clean($this->input->post('is_hold'));
                $date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));   
				
				$PaymentType = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo')); 
				$driversignature = $this->input->post('driversignature', FALSE); 
				if($LorryNo == '0'){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				  
				if($CompanyID == '0'){ 
					if(trim($CompanyName)==""){ 	
						echo "Error";
						exit;
					}
					$CompanyID = $this->generateRandomString();
					$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s')); 
					$this->Common_model->insert("tbl_company",$CompanyInfo);
				}	 
				if($OpportunityID == '0'){    
					if(trim($Street1)=="" && trim($Town)=="" && trim($County)=="" && trim($PostCode)==""){ 	
						echo "Error";
						exit;
					}
					$OpportunityID = $this->generateRandomString(); 
					$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
					 
					$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 
					'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode); 
					$this->Common_model->insert("tbl_opportunities",$OppoInfo);
					
					$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
					$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
				}  
				
                $TicketUniqueID = $this->generateRandomString();                
				 
				$LastTicketNumber =  $this->tickets_model->LastTicketNo(); 
				if($LastTicketNumber){ 
					$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
				}else{
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
					$TicketNumber = $data['content']['TicketStart'];
				}  
				//$TicketDate  = date('Y-m-d H:i:s');
				$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
				
				$ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID,'TicketNumber'=>$TicketNumber, 'TicketDate'=>$TicketDate, 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,'MaterialID'=>$DescriptionofMaterial ,'WIFNumber'=> $WIFNumber, 
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,'Net'=>$Net , 
				'SicCode'=>$SicCode,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'In','pdf_name'=>$TicketUniqueID.".pdf",
				'driver_id'=>$driverid ,'is_tml'=>$is_tml ,'is_hold'=>$is_hold, 'IsInBound'=> 0,  'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat, 'VatAmount'=>$VatAmount, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo ,'driversignature'=>$driversignature,'ticket_notes'=>$ticket_notes  );

				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                 
					$ticketId = $this->Common_model->insert('tbl_tickets', $ticketsInfo);
				 
					if($ticketId > 0)
					{ 
						if($is_hold == 0){
							$conditions = array(
							 'TicketNo' => $ticketId
							);
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($ticketId); 
							
							$html=$this->load->view('Tickets/ticket_pdf', $data, true);
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
							  
							 //load mPDF library
							$this->load->library('m_pdf');

						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);
							 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
							echo base_url($openPath);
						}else{
							//$conditions = array( 'is_hold' => 1 , 'delete_notes' => NULL );
							//$HoldTicket = $this->Common_model->select_count_where('tbl_tickets',$conditions); 
							//echo "HOLD|".$HoldTicket;
							echo "HOLD";
						}	
					}
					else
					{
						echo "Error";
					}
                }  
        }
    }


##############################################################################################

	
	function EditTicketAJAX(){   
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo')); 
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
				$WIFNumber = $this->security->xss_clean($this->input->post('WIFNumber'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes')); 
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
                $driversignature = $this->input->post('driversignature', FALSE); 
				
				if($LorryNo == 0){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
                $ticketsInfo = array(  'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 'WIFNumber'=> $WIFNumber,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,
				'Tare'=>$Tare ,'Net'=>$Net , 'SicCode'=>$SicCode,  'pdf_name'=> $TicketUniqueID.".pdf",
				'TypeOfTicket'=>'In','driver_id'=> $driverid,'is_tml'=>$is_tml, 'is_hold'=>0,'IsInBound'=>0,  'UpdateUserID'=>$this->session->userdata['userId'] ,
				'ticket_notes'=>$ticket_notes, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);
   
				if($TicketNo != "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                 
					$cond = array(  'TicketNo' => $TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
				 
					if($tupdate==1) {  
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
						
						$html=$this->load->view('Tickets/ticket_pdf', $data, true);
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						 
						//load mPDF library
						$this->load->library('m_pdf');

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
						  
						echo base_url($openPath);
						 	
					}else{
						echo "SAME";
					} 
                }  
        }
    }	

##############################################################################################

	
	function EditInBoundAJAX(){   
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo')); 
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
				$WIFNumber = $this->security->xss_clean($this->input->post('WIFNumber'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes')); 
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
                $driversignature = $this->input->post('driversignature', FALSE); 
				
				if($LorryNo == 0){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID'];  
				//$TicketDate  = date('Y-m-d H:i:s');
				$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
				
                $ticketsInfo = array(  'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 'WIFNumber'=> $WIFNumber, 'TicketDate'=>$TicketDate,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,
				'Tare'=>$Tare ,'Net'=>$Net , 'SicCode'=>$SicCode, 'pdf_name'=> $TicketUniqueID.".pdf",
				'TypeOfTicket'=>'In','driver_id'=> $driverid,'is_tml'=>$is_tml, 'is_hold'=>0,'IsInBound'=>0, 'CreateUserID'=>$this->session->userdata['userId'],  
				'ticket_notes'=>$ticket_notes, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);
   
				if($TicketNo != "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                 
					$cond = array(  'TicketNo' => $TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
				 
					if($tupdate==1) {  
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
						$html=$this->load->view('Tickets/ticket_pdf', $data, true);
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						 
						//load mPDF library
						$this->load->library('m_pdf');

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
						  
						echo base_url($openPath);
						 	
					}else{
						echo "SAME";
					} 
                }  
        }
    }	
	

##############################################################################################

##############################################################################################

	
	function EditInCompletedAJAX(){   
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{    
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo')); 
				$TicketDate = $this->security->xss_clean($this->input->post('TicketDate')); 
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
				$WIFNumber = $this->security->xss_clean($this->input->post('WIFNumber'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$ticket_notes = $this->security->xss_clean($this->input->post('ticket_notes')); 
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
                $driversignature = $this->input->post('driversignature', FALSE); 
				 
				$t = explode(' ',$TicketDate);   
				$td = explode('-', $t[0]);   
				$TicketDate = $td[2]."-".$td[1]."-".$td[0]." ".$t[1]; 
				
				if($LorryNo == 0){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID'];  
						
                $ticketsInfo = array(  'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance,'TicketDate'=> $TicketDate, 'WIFNumber'=> $WIFNumber,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,
				'Tare'=>$Tare ,'Net'=>$Net , 'SicCode'=>$SicCode, 'pdf_name'=> $TicketUniqueID.".pdf",
				'TypeOfTicket'=>'In','driver_id'=> $driverid,'is_tml'=>$is_tml, 'is_hold'=>0,'IsInBound'=>0,  'CreateUserID'=>$this->session->userdata['userId'],  
				'ticket_notes'=>$ticket_notes, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);
					
				if($TicketNo != "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                 
					$cond = array(  'TicketNo' => $TicketNo ); 	 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
				 
					if($tupdate==1) {  
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
						$html=$this->load->view('Tickets/ticket_pdf', $data, true);
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						 
						//load mPDF library
						$this->load->library('m_pdf');

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
						  
						echo base_url($openPath);
						 	
					}else{
						echo "SAME";
					} 
                }  
        }
    }	
	

##############################################################################################


	function AddOutTicketAJAX(){   
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {   
                 
                $TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml')); 
				
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$Street1 = $this->security->xss_clean($this->input->post('Street1'));
				$County = $this->security->xss_clean($this->input->post('County'));
				$Town = $this->security->xss_clean($this->input->post('Town'));
				$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
				
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                //$Cmeter = $this->security->xss_clean($this->input->post('Cmeter'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));  
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
				$SicCode = $this->security->xss_clean($this->input->post('SicCode')); 
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
				$is_hold = $this->security->xss_clean($this->input->post('is_hold'));
                $date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
				
				if($LorryNo == '0'){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				if($CompanyID == '0'){ 
					if(trim($CompanyName)==""){ 	
						echo "Error";
						exit;
					}
					$CompanyID = $this->generateRandomString();
					$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s') ,); 
					$this->Common_model->insert("tbl_company",$CompanyInfo);
				}	 
				if($OpportunityID == '0'){   
					if(trim($Street1)=="" && trim($Town)=="" && trim($County)=="" && trim($PostCode)==""){ 	
						echo "Error";
						exit;
					}
					$OpportunityID = $this->generateRandomString(); 
					$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
					$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 
					'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode); 
					$this->Common_model->insert("tbl_opportunities",$OppoInfo);
					
					$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
					$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
				}  
                $TicketUniqueID = $this->generateRandomString();                
				$LastTicketNumber =  $this->tickets_model->LastTicketNo(); 
				if($LastTicketNumber){ 
					$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
				}else{
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
					$TicketNumber = $data['content']['TicketStart'];
				}  
				//$TicketDate  = date('Y-m-d H:i:s');
				$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
                $ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID, 'TicketNumber'=>$TicketNumber,'TicketDate'=>$TicketDate, 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance, 
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,'MaterialID'=>$DescriptionofMaterial ,
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,'Net'=>$Net  , 'SicCode'=>$SicCode,
				'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'Out','pdf_name'=>$TicketUniqueID.".pdf",
				'driver_id'=>$driverid ,'is_tml'=>$is_tml ,'is_hold'=>$is_hold,'IsInBound'=> 0,  'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,  'VatAmount'=>$VatAmount,
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature );
                
				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
					$ticketId = $this->Common_model->insert('tbl_tickets', $ticketsInfo); 					
					if($ticketId > 0){ 
						if($is_hold == 0){
							$conditions = array(
							 'TicketNo' => $ticketId
							);
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($ticketId); 
		 
							$html=$this->load->view('Tickets/ticket_pdf_out', $data, true);
							
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
							  
							 //load mPDF library
							$this->load->library('m_pdf');

						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);
							 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
							echo base_url($openPath);
						}else{
							//$conditions = array( 'is_hold' => 1 , 'delete_notes' => NULL );
							//$HoldTicket = $this->Common_model->select_count_where('tbl_tickets',$conditions); 
							//echo "HOLD|".$HoldTicket;
							echo "HOLD";
						}	
					}
					else
					{
						echo "Error";
					} 
                }  
        }
    }


##############################################################################################
	
	
		function EditOutTicketAJAX(){   
			if($this->isEdit == 0)
			{
				$data = array();
				$this->global['pageTitle'] = 'Error';             
				$this->loadViews("permission", $this->global, $data, NULL);
			}
			else
			{   
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo'));	 
				$TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml')); 
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress')); 
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));  
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
				$HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
				$SicCode = $this->security->xss_clean($this->input->post('SicCode')); 
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net')); 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid')); 
                $date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));   
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
				
				if($LorryNo == 0){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
				$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
				
				$CreateUserID = $this->session->userdata['userId'];
				
                $ticketsInfo = array(  'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance,'pdf_name'=> $TicketUniqueID.".pdf",
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,
				'CreateUserID'=> $CreateUserID ,'UpdateUserID'=>$this->session->userdata['userId'] ,
				'Tare'=>$Tare ,'Net'=>$Net ,'TypeOfTicket'=>'Out', 'driver_id'=>$driverid,'is_tml'=>$is_tml,'is_hold'=>0, 'IsInBound'=>0, 
				'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat,'VatAmount'=>$VatAmount, 'TotalAmount'=>$TotalAmount , 
				'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature );
              
				if( trim($TicketNo)!= "" && trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
				 
					$cond = array( 'TicketNo' => $TicketNo ); 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond);
					 //var_dump($tupdate);
					if($tupdate==1){    
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
							
						$html=$this->load->view('Tickets/ticket_pdf_out', $data, true);
						
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						 
						//load mPDF library
						$this->load->library('m_pdf');

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
						echo base_url($openPath);
						 	
					}else{
						echo "SAME";
					} 
                }  
        }
    }


##############################################################################################


	function AddCollectionTicketAJAX(){   
        if($this->isAdd == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {      
                $TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                
				$CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
				$Street1 = $this->security->xss_clean($this->input->post('Street1'));
				$County = $this->security->xss_clean($this->input->post('County'));
				$Town = $this->security->xss_clean($this->input->post('Town'));
				$PostCode = $this->security->xss_clean($this->input->post('PostCode'));
				
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net'));
                 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid'));
                $is_hold = $this->security->xss_clean($this->input->post('is_hold'));
				$date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
 
				if($LorryNo == '0'){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				if($CompanyID == '0'){ 
					if(trim($CompanyName)==""){ 	
						echo "CompanyNameError";
						exit;
					}
					$CompanyID = $this->generateRandomString();
					$CompanyInfo = array('CompanyID'=>$CompanyID,'CompanyIDMapKey'=>$CompanyID, 'CompanyName'=>$CompanyName,'status'=>1,'CreateDate'=>date('Y-m-d H:i:s') ,); 
					$this->Common_model->insert("tbl_company",$CompanyInfo);
				}	 
				if($OpportunityID == '0'){   
					if(trim($Street1)=="" && trim($Town)=="" && trim($County)=="" && trim($PostCode)==""){ 	
						echo "OpportunityError";
						exit;
					}
					$OpportunityID = $this->generateRandomString(); 
					$OpportunityName = $Street1.", ".$Town.", ".$County.", ".$PostCode;
					$OppoInfo = array('OpportunityID'=>$OpportunityID,'OpportunityIDMapKey'=>$OpportunityID,'OpportunityName'=>$OpportunityName, 
					'Street1'=>$Street1,'Town'=>$Town ,'County'=>$County ,'PostCode'=>$PostCode); 
					$this->Common_model->insert("tbl_opportunities",$OppoInfo);
					
					$CO = array('OpportunityID'=>$OpportunityID, 'CompanyID'=>$CompanyID ); 
					$this->Common_model->insert("tbl_company_to_opportunities", $CO); 
				}  
                $TicketUniqueID = $this->generateRandomString();                
                $LastTicketNumber =  $this->tickets_model->LastTicketNo(); 
				if($LastTicketNumber){ 
					$TicketNumber = $LastTicketNumber['TicketNumber']+1;  
				}else{
					$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1)); 
					$TicketNumber = $data['content']['TicketStart'];
				}    
				//$TicketDate  = date('Y-m-d H:i:s');
				$TicketDate  = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime(date("Y-m-d H:i:s"))));
                $ticketsInfo = array('TicketUniqueID'=>$TicketUniqueID, 'TicketNumber'=>$TicketNumber, 'TicketDate'=>$TicketDate, 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,'MaterialID'=>$DescriptionofMaterial ,
				'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,'Net'=>$Net , 
				'SicCode'=>$SicCode,'CreateUserID'=>$this->session->userdata['userId'] ,'CreateDate'=>date('Y-m-d H:i:s'),'TypeOfTicket'=>'Collection', 'VatAmount'=>$VatAmount,
				'pdf_name'=> $TicketUniqueID.".pdf",'driver_id' => $driverid,'is_tml'=>$is_tml ,'is_hold'=>$is_hold,'IsInBound'=> 0, 'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat, 
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);

				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                
					$ticketId = $this->Common_model->insert('tbl_tickets', $ticketsInfo);  
					if($ticketId > 0)
					{ 
						if($is_hold == 0){
							$conditions = array(
							 'TicketNo' => $ticketId
							);
							$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
							$data['tickets'] = $this->Common_model->get_pdf_data($ticketId); 
		 
							$html=$this->load->view('Tickets/ticket_pdf', $data, true);
							 //this the the PDF filename that user will get to download
							$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
							$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
							  
							 //load mPDF library
							$this->load->library('m_pdf');

						   //generate the PDF from the given html
							$this->m_pdf->pdf->WriteHTML($html);
							 
							//download it.
							$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
							  
							echo base_url($openPath);
						}else{
							//$conditions = array( 'is_hold' => 1 , 'delete_notes' => NULL );
							//$HoldTicket = $this->Common_model->select_count_where('tbl_tickets',$conditions); 
							//echo "HOLD|".$HoldTicket;
							echo "HOLD";
						}	
					}
					else
					{
						echo "Error";
					}
					
				}
                  
        }
    }


##############################################################################################

	
	function EditCollectionTicketAJAX(){   
        if($this->isEdit == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {     
				$TicketNo = $this->security->xss_clean($this->input->post('TicketNo'));	 
				$TicketDate = $this->security->xss_clean($this->input->post('TicketDate'));
                $OpportunityID = $this->security->xss_clean($this->input->post('OpportunityID'));                
                $Conveyance = $this->security->xss_clean($this->input->post('Conveyance'));
                $is_tml = $this->security->xss_clean($this->input->post('is_tml'));
                $CompanyName = $this->security->xss_clean($this->input->post('CompanyName'));
                $SiteAddress = $this->security->xss_clean($this->input->post('SiteAddress'));
                $HaullerRegNo = $this->security->xss_clean($this->input->post('HaullerRegNo'));
                $DescriptionofMaterial = $this->security->xss_clean($this->input->post('DescriptionofMaterial'));
                $SicCode = $this->security->xss_clean($this->input->post('SicCode'));
                $LorryNo = $this->security->xss_clean($this->input->post('LorryNo'));
                $VechicleRegNo = $this->security->xss_clean($this->input->post('VechicleRegNo'));
				$VechicleRegNo = preg_replace('/\s+/', '',strtoupper($VechicleRegNo));
				
                $DriverName = $this->security->xss_clean($this->input->post('DriverName'));
                $CompanyID = $this->security->xss_clean($this->input->post('CompanyID'));
                $GrossWeight = $this->security->xss_clean($this->input->post('GrossWeight'));
                $Tare = $this->security->xss_clean($this->input->post('Tare'));
                $Net = $this->security->xss_clean($this->input->post('Net'));
                 
                $MaterialPrice = $this->security->xss_clean($this->input->post('MaterialPrice'));
                $driverid = $this->security->xss_clean($this->input->post('driverid')); 
				$date = str_replace('/', '-', $TicketDate); 
                $TicketDate =   date('Y-m-d  H:i:s',strtotime($date));  
				
				$PaymentType	 = $this->security->xss_clean($this->input->post('PaymentType'));
				$Amount = $this->security->xss_clean($this->input->post('Amount'));
				$Vat = $this->security->xss_clean($this->input->post('Vat'));
				$VatAmount = $this->security->xss_clean($this->input->post('VatAmount'));
				$TotalAmount = $this->security->xss_clean($this->input->post('TotalAmount'));
				$PaymentRefNo = $this->security->xss_clean($this->input->post('PaymentRefNo'));
				$driversignature = $this->input->post('driversignature', FALSE); 
 
				if($LorryNo == 0){
					$DriverInfo = array('DriverName'=>$DriverName,'RegNumber'=>$VechicleRegNo,'Tare'=>$Tare,
					'Haulier'=>$HaullerRegNo,'ltsignature'=>$driversignature,'CreateUserID'=>$this->session->userdata['userId'] ,
					'CreateDate'=>date('Y-m-d H:i:s') ,'EditUserID'=> ''); 
					$driverid = $this->Common_model->insert("drivers",$DriverInfo);
				}else{
					$DriverInfo = array('ltsignature'=>$driversignature, 'EditUserID'=> $this->session->userdata['userId']); 
					$cond1 = array(  'LorryNo' => $driverid ); 	 
					$this->Common_model->update("drivers",$DriverInfo,$cond1); 
				}
				  
                $ticketsInfo = array( 'OpportunityID'=>$OpportunityID, 'Conveyance'=> $Conveyance,
				'CompanyID'=>$CompanyID ,'DriverName'=>$DriverName ,'RegNumber'=>$VechicleRegNo ,'Hulller'=>$HaullerRegNo ,
				'MaterialID'=>$DescriptionofMaterial ,'MaterialPrice'=>$MaterialPrice ,'GrossWeight'=>$GrossWeight ,'Tare'=>$Tare ,
				'Net'=>$Net , 'SicCode'=>$SicCode,'TypeOfTicket'=>'Collection','UpdateUserID'=>$this->session->userdata['userId'] ,
				'driver_id'=> $driverid,'is_tml'=>$is_tml,'is_hold'=>0,'IsInBound'=>0,  'PaymentType'=>$PaymentType ,'Amount'=>$Amount ,'Vat'=>$Vat, 'VatAmount'=>$VatAmount,
				'TotalAmount'=>$TotalAmount ,'PaymentRefNo'=>$PaymentRefNo,'driversignature'=>$driversignature);

				if(trim($OpportunityID)!= "" && trim($DescriptionofMaterial)!= "" && trim($CompanyID)!= "" && trim($driverid)!= "" ){
                
					$cond = array( 'TicketNo' => $TicketNo ); 
					$tupdate = $this->Common_model->update("tickets",$ticketsInfo, $cond); 
					if($tupdate==1){  
						$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
						$data['tickets'] = $this->Common_model->get_pdf_data($TicketNo);  
						$TicketUniqueID = $data['tickets']['TicketUniqueID']; 
						
						$html=$this->load->view('Tickets/ticket_pdf', $data, true);
						 //this the the PDF filename that user will get to download
						$pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
						$openPath =  "/assets/pdf_file/".$TicketUniqueID.".pdf";
						
						//load mPDF library
						$this->load->library('m_pdf');

					   //generate the PDF from the given html
						$this->m_pdf->pdf->WriteHTML($html);
						 
						//download it.
						$this->m_pdf->pdf->Output($pdfFilePath, "F"); 
						  
						echo base_url($openPath);
						 
					}else{
						echo "SAME";
					}  
				} 
        }
    }

##############################################################################################

 
    function pageNotFound()
    {
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }


    function getMaterialList(){
        $type = $_POST['TicketType'];
        if($type=='In'){
        	$type='IN';
        }else{$type='OUT';}
        $result = $this->tickets_model->getMaterialList($type);
        $html='<option value="">-- Select material type--</option>';
        foreach ($result as $key => $value) {
           $html.="<option value='".$value->MaterialID."'>".$value->MaterialName."</option>";
        }
        echo $html;
  
    }

    function GetWIFNumber(){
        if($_POST){
			 $id = $_POST['id'];
			 $result = $this->tickets_model->GetWIFNumber($id);
			 $aray=array();
			 if($result){
				$DocumentNumber  = $result->DocumentNumber; 
				$aray = array('DocumentNumber' =>$DocumentNumber);
			 }
			 echo json_encode($aray);
        }
    }

    function getMaterialListDetails(){

        if($_POST){
             $id = $_POST['id'];
             $result = $this->tickets_model->getMaterialListDetails($id);
             $aray=array();
             if($result){
                $SicCode  = $result->SicCode;
                $price  = $result->price;
                $aray = array('SicCode' =>$SicCode ,'price'=>$price);
             }
             echo json_encode($aray);
        }
    }

    function getLorryNo(){
        $result = $this->tickets_model->getLorryNo();
        //print_r($result);
        $html='<option value="">-- Select Lorry No --</option>';
        foreach ($result as $key => $value) {
           $html.="<option value='".$value->LorryNo."'>".$value->LorryNo." | ".$value->DriverName." | ".$value->RegNumber."</option>";
        }
       echo $html;
    }
    
    function getLorryNoDetails(){
        if($_POST){
             $id = $_POST['id'];
             $result = $this->tickets_model->getLorryNoDetails($id);
             $aray=array();
            // print_r($result);
             if($result){
                $LorryNo  = $result->LorryNo;
                $DriverName  = $result->DriverName;
                $RegNumber  = $result->RegNumber;
                $Tare  = round($result->Tare,2);
                $Haulier  = $result->Haulier;
				$ltsignature  = $result->ltsignature;
                $aray = array('LorryNo' =>$LorryNo ,'DriverName'=>$DriverName,'RegNumber'=>$RegNumber,'Tare'=>$Tare,'Haulier'=>$Haulier,'ltsignature'=>$ltsignature);
             }
           echo  json_encode($aray);
        }
    }

    function getOpportunitiesList(){

       $result = $this->tickets_model->getOpportunitiesList();
        //print_r($result);
        $html='<option value="">-- Select Opportunity --</option>';
        foreach ($result as $key => $value) {
           $html.="<option value='".$value->OpportunityID."'>".$value->OpportunityName."</option>";
        }
       echo $html;  
    }


    function CheckDuplicateTicket(){

        $id = $_POST['id'];
		$tno = $_POST['tno']; 
        $result['duplicate'] = $this->tickets_model->CheckDuplicateTicket($id,$tno);            
		if($result['duplicate']>0){ echo(json_encode(array('status'=>FALSE))); }else{ echo(json_encode(array('status'=>TRUE,'status1'=>$result['duplicate']))); }
        //    if ($result > 0) { echo(json_encode(array('status'=>FALSE)));   }
        //    else { echo(json_encode($result)); }
    }

    function loadAllOpportunitiesByCompany(){
        $id = $_POST['id'];
        $result['Opportunity_list'] = $this->tickets_model->getAllOpportunitiesByCompany($id) ;           
            if ($result > 0) { echo(json_encode($result)); }
            else { echo(json_encode(array('status'=>FALSE))); }

    }

    function LoadMaterials(){

        $type = $_POST['id'];
        $result['material_list'] = $this->tickets_model->getMaterialList($type);  
		 
        if ($result > 0) { echo(json_encode($result)); }
        else { echo(json_encode(array('status'=>FALSE))); }

    }



    function getCustomerDetails(){

        if($_POST){
             $id = $_POST['id'];
             $result = $this->tickets_model->getCustomerDetails($id);
             $aray=array();
             $aray = array('CompanyID' =>'' ,'CompanyName'=>'','address'=>'');
             if($result){
                $CompanyID  = $result->CompanyID;
                $CompanyName  = $result->CompanyName;
                $address  = $result->Street1.', '.$result->Street2.', '.$result->Town.', '.$result->County.'- '.$result->PostCode;
                
                $aray = array('CompanyID' =>$CompanyID ,'CompanyName'=>$CompanyName,'address'=>$address);
             }
           echo  json_encode($aray);
        }

    }


    function genrateBarcode(){        

         $filename = $this->input->post('TicketUniqueID').'.png';
         $TicketNo=$this->input->post('TicketNo');

        $filepath = WEB_ROOT_PATH.'assets/Invoice/'.$filename;

        $text=$this->input->post('TicketUniqueID'); 
        $size="100";
        $orientation="horizontal";
        $code_type="code128a";
        $print=true;
        $SizeFactor=2;

    $code_string = "";
    // Translate the $text into barcode the correct $code_type
    if ( in_array(strtolower($code_type), array("code128", "code128b")) ) {
        $chksum = 104;
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ( $X = 1; $X <= strlen($text); $X++ ) {
            $activeKey = substr( $text, ($X-1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum=($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211214" . $code_string . "2331112";
    } elseif ( strtolower($code_type) == "code128a" ) {
        $chksum = 103;
        $text = strtoupper($text); // Code 128A doesn't support lower case
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","NUL"=>"111422","SOH"=>"121124","STX"=>"121421","ETX"=>"141122","EOT"=>"141221","ENQ"=>"112214","ACK"=>"112412","BEL"=>"122114","BS"=>"122411","HT"=>"142112","LF"=>"142211","VT"=>"241211","FF"=>"221114","CR"=>"413111","SO"=>"241112","SI"=>"134111","DLE"=>"111242","DC1"=>"121142","DC2"=>"121241","DC3"=>"114212","DC4"=>"124112","NAK"=>"124211","SYN"=>"411212","ETB"=>"421112","CAN"=>"421211","EM"=>"212141","SUB"=>"214121","ESC"=>"412121","FS"=>"111143","GS"=>"111341","RS"=>"131141","US"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","CODE B"=>"114131","FNC 4"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ( $X = 1; $X <= strlen($text); $X++ ) {
            $activeKey = substr( $text, ($X-1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum=($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211412" . $code_string . "2331112";
    } elseif ( strtolower($code_type) == "code39" ) {
        $code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

        // Convert to uppercase
        $upper_text = strtoupper($text);

        for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
            $code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
        }

        $code_string = "1211212111" . $code_string . "121121211";
    } elseif ( strtolower($code_type) == "code25" ) {
        $code_array1 = array("1","2","3","4","5","6","7","8","9","0");
        $code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

        for ( $X = 1; $X <= strlen($text); $X++ ) {
            for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
                if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
                    $temp[$X] = $code_array2[$Y];
            }
        }

        for ( $X=1; $X<=strlen($text); $X+=2 ) {
            if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
                $temp1 = explode( "-", $temp[$X] );
                $temp2 = explode( "-", $temp[($X + 1)] );
                for ( $Y = 0; $Y < count($temp1); $Y++ )
                    $code_string .= $temp1[$Y] . $temp2[$Y];
            }
        }

        $code_string = "1111" . $code_string . "311";
    } elseif ( strtolower($code_type) == "codabar" ) {
        $code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
        $code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

        // Convert to uppercase
        $upper_text = strtoupper($text);

        for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
            for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
                if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
                    $code_string .= $code_array2[$Y] . "1";
            }
        }
        $code_string = "11221211" . $code_string . "1122121";
    }

    // Pad the edges of the barcode
    $code_length = 20;
    if ($print) {
        $text_height = 30;
    } else {
        $text_height = 0;
    }
    
    for ( $i=1; $i <= strlen($code_string); $i++ ){
        $code_length = $code_length + (integer)(substr($code_string,($i-1),1));
        }

    if ( strtolower($orientation) == "horizontal" ) {
        $img_width = $code_length*$SizeFactor;
        $img_height = $size;
    } else {
        $img_width = $size;
        $img_height = $code_length*$SizeFactor;
    }

    $image = imagecreate($img_width, $img_height + $text_height);
    $black = imagecolorallocate ($image, 0, 0, 0);
    $white = imagecolorallocate ($image, 255, 255, 255);

    imagefill( $image, 0, 0, $white );
    if ( $print ) {
        imagestring($image, 5, 31, $img_height, $text, $black );
    }

    $location = 10;
    for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
        $cur_size = $location + ( substr($code_string, ($position-1), 1) );
        if ( strtolower($orientation) == "horizontal" )
            imagefilledrectangle( $image, $location*$SizeFactor, 0, $cur_size*$SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black) );
        else
            imagefilledrectangle( $image, 0, $location*$SizeFactor, $img_width, $cur_size*$SizeFactor, ($position % 2 == 0 ? $white : $black) );
        $location = $cur_size;
    }
    
    // Draw barcode to the screen or save in a file
    if ( $filepath=="" ) {
        header ('Content-type: image/png');
        imagepng($image);
        imagedestroy($image);
    } else {
        imagepng($image,$filepath);
        imagedestroy($image);       
    }

     $ticketsInfo = array('Barcode'=>$filename);
     $cond = array('TicketNo' => $TicketNo);
     $this->Common_model->update("tickets",$ticketsInfo, $cond);     

    echo $filename;
}  
public function generatePdf($pdfId){
        $conditions = array(
                 'TicketNo' => $pdfId
                );
        $data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
        $data['tickets'] = $this->Common_model->get_pdf_data($pdfId); 
        $html=$this->load->view('Tickets/ticket_pdf', $data, true);
         //this the the PDF filename that user will get to download
        $pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$data['tickets']['TicketUniqueID'].".pdf";
         //load mPDF library
        $this->load->library('m_pdf');

       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
         
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "F");
        $cond = array(
              'TicketNo' => $pdfId
        );
        $ticketsInfo = array('pdf_name'=> $data['tickets']['TicketUniqueID'].".pdf");
        $this->Common_model->update("tickets",$ticketsInfo, $cond); 
        $data['ticketsRecords'] = $this->tickets_model->ticketsListing();            
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tickets Listing';
            $this->global['active_menu'] = 'tickets'; 
            $this->loadViews("Tickets/tickets", $this->global, $data, NULL);
         

    }

	public function mypdf(){   
		include_once APPPATH.'/third_party/mpdf/mpdf.php'; 

		$html='<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
		<div style="width:100%;margin-bottom: 0px;margin-top: 0px;" >	
		<div style="width:100%;float: left;font-size: 12px;" > 		
		<center><img src="'.site_url().'assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="100">  </center>  	
		'.$PDFContent[0]->address.' <br/>		
		<b>Tel:</b>  '.$PDFContent[0]->phone.'   (Head Office)<br/> 		
		<b>Email:</b> '.$PDFContent[0]->email.'  <br/>		
		<b>Web:</b> '.$PDFContent[0]->website.'     <br/><br/> 		
		<b>'.$PDFContent[0]->head1.'</b><br>		
		<b>'.$PDFContent[0]->head2.'</b><br><br>				
		<b>WASTE LICENSE NO.:</b> '.$PDFContent[0]->waste_licence.'<br>
		<b>PERMIT REFERENCE NO:</b> '.$PDFContent[0]->reference.'<br><br><br>
		
		<b>Conveyance Note</b><br><br>
		
		<b>Conveyance Note: </b> #'.$dataarr[0]->ConveyanceNo.'  <br>	
		<b>Date Time: </b>'.date("d-m-Y H:i").' <br> 	
		<b>Company Name: </b> '.$dataarr[0]->CompanyName.' <br>		
		<b>Site Address: </b> '.$dataarr[0]->OpportunityName.'<br>		
		<b>Tip Address: </b> kdfjhskdjhfskjdhfksjhdfk<br><br>		
		
		<b>Material: </b> '.$MaterialnameQRY['MaterialName'].' <br><br>				
		<b>Driver Name: </b> '.$user['DriverName'].'<br>		
		<b>Vehicle Reg. No. </b> '.$user['RegNumber'].' <br><br><br>		 		 
		<img src="'.base_url().'/uploads/Signature/'.$SignatureUploadfile_name.'"><br><br>
		<b>Received By: </b> '.$CustomerName.' <br>
		</div></div></body></html>';						

		$pdfFilePath = WEB_ROOT_PATH."assets/".rand().".pdf"; 
		$mpdf =  new mPDF('utf-8', array(104,254));
		$mpdf->AddPage('P','','','','',5,5,5,5,5,5);
		$mpdf->keep_table_proportions = false;
		$mpdf->WriteHTML($html);
		$mpdf->Output($pdfFilePath); 
		
		/*
		$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
		$data['tickets'] = $this->Common_model->get_pdf_data('141'); 
		//var_dump($data);
		//exit;
         $html=$this->load->view('Tickets/ticket_pdf_test', $data, true); 
         //this the the PDF filename that user will get to download
        $pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$data['tickets']['TicketUniqueID'].".pdf";
         //load mPDF library
        $this->load->library('m_pdf'); 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);  
        //download it.
        $this->m_pdf->pdf->Output($pdfFilePath, "D");
		*/
		exit;

    }

	function sigJsonToImage ($json, $options = array()) {
		  $defaultOptions = array(
			'imageSize' => array(399, 199)
			,'bgColour' => array(0xff, 0xff, 0xff)
			,'penWidth' => 2
			,'penColour' => array(0x14, 0x53, 0x94)
			,'drawMultiplier'=> 12
		  );

		  $options = array_merge($defaultOptions, $options);

		  $img = imagecreatetruecolor($options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][1] * $options['drawMultiplier']);

		  if ($options['bgColour'] == 'transparent') {
			imagesavealpha($img, true);
			$bg = imagecolorallocatealpha($img, 0, 0, 0, 127);
		  } else {
			$bg = imagecolorallocate($img, $options['bgColour'][0], $options['bgColour'][1], $options['bgColour'][2]);
		  }

		  $pen = imagecolorallocate($img, $options['penColour'][0], $options['penColour'][1], $options['penColour'][2]);
		  imagefill($img, 0, 0, $bg);

		  if (is_string($json))
			$json = json_decode(stripslashes($json));

		  foreach ($json as $v)
			$this->drawThickLine($img, $v->lx * $options['drawMultiplier'], $v->ly * $options['drawMultiplier'], $v->mx * $options['drawMultiplier'], $v->my * $options['drawMultiplier'], $pen, $options['penWidth'] * ($options['drawMultiplier'] / 2));

		  $imgDest = imagecreatetruecolor($options['imageSize'][0], $options['imageSize'][1]);

		  if ($options['bgColour'] == 'transparent') {
			imagealphablending($imgDest, false);
			imagesavealpha($imgDest, true);
		  }

		  imagecopyresampled($imgDest, $img, 0, 0, 0, 0, $options['imageSize'][0], $options['imageSize'][0], $options['imageSize'][0] * $options['drawMultiplier'], $options['imageSize'][0] * $options['drawMultiplier']);
		  imagedestroy($img);

		  return $imgDest;
	}

	/**
	 *  Draws a thick line
	 *  Changing the thickness of a line using imagesetthickness doesn't produce as nice of result
	 *
	 *  @param object $img
	 *  @param int $startX
	 *  @param int $startY
	 *  @param int $endX
	 *  @param int $endY
	 *  @param object $colour
	 *  @param int $thickness
	 *
	 *  @return void
	 */
	function drawThickLine ($img, $startX, $startY, $endX, $endY, $colour, $thickness) {
		  $angle = (atan2(($startY - $endY), ($endX - $startX)));

		  $dist_x = $thickness * (sin($angle));
		  $dist_y = $thickness * (cos($angle));

		  $p1x = ceil(($startX + $dist_x));
		  $p1y = ceil(($startY + $dist_y));
		  $p2x = ceil(($endX + $dist_x));
		  $p2y = ceil(($endY + $dist_y));
		  $p3x = ceil(($endX - $dist_x));
		  $p3y = ceil(($endY - $dist_y));
		  $p4x = ceil(($startX - $dist_x));
		  $p4y = ceil(($startY - $dist_y));

		  $array = array(0=>$p1x, $p1y, $p2x, $p2y, $p3x, $p3y, $p4x, $p4y);
		  imagefilledpolygon($img, $array, (count($array)/2), $colour);
	}
	 
    
}

?>
