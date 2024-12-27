<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
 
class CustomerTickets extends CI_Controller
{ 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CustomerTickets_model'); 
		$this->load->model('Common_model'); 
    }
 
    public function index($AccRef){  
	
		if(trim($AccRef) == ""){
			redirect('NotAvailable');
		}
		
		if(trim($AccRef) != "admin"){				
			$conditions = array( 'AccountRef' => $AccRef );  
			$data['cInfo'] = $this->Common_model->select_where("company",$conditions);  
			
			if(count($data['cInfo']) == 0){
				redirect('NotAvailable');
			}	
		}
		$data['AccRef'] = $AccRef;
        $this->load->view('CustomerTickets/CustomerTickets',$data); 
    }
	
	public function NotAvailable(){  
		echo "Please Check Your AccountRef Or Contact to Administrator. ";
		exit;
    }
	
    /*public function ListTickets($AccRef){  
		$conditions = array( 'AccountRef' => $AccRef );
        $data['cInfo'] = $this->Common_model->select_where("company",$conditions); 
		if(count($data['cInfo']) ==0){
			redirect('CustomerTickets');
		}	
		
		$data['AccRef'] = $AccRef;
        $this->load->view('CustomerTickets/CustomerTickets',$data); 
		
    }*/
	
	public function CustomerTicketsAjax($AccRef){  
		$this->load->library('ajax'); 
		$data = $this->CustomerTickets_model->GetTicketData($AccRef); 
		$this->ajax->send($data);
	}
	
}

?>