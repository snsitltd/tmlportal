<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';  

class Invoices extends BaseController{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;
	
	protected $isApprove;
	protected $isPApprove;
	protected $isIApprove;
 
    public function __construct()
    {
        parent::__construct();        
        $this->isLoggedIn();   
		
        $roleCheck = $this->Common_model->checkpermission('invoices'); 
		
        //print_r($roleCheck); 
		//exit;
		
		$this->global['isView'] = $this->isView = $roleCheck->view;   
		$this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
		$this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
		$this->global['isDelete'] = $this->isDelete = $roleCheck->delete; 
		  
		$this->global['active_menu'] = 'dashboard'; 
		$this->load->model("Invoices_model"); 

    }
     
    public function InvoiceLoads(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();
			           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Invoice Loads';
            $this->global['active_menu'] = 'invoiceloads'; 
            
            $this->loadViews("Invoices/InvoiceLoads", $this->global, $data, NULL);
        }
    }
	public function AjaxInvoiceLoads(){  
		$this->load->library('ajax');
		$data = $this->Invoices_model->GetInvoiceLoads();  
		$this->ajax->send($data);
	}
 	
	public function InvoiceLoadsTableMeta(){   		 
		echo '{"Name":"InvoiceLoads","Action":true,"Column":[{"Name":"LoadID","Title":"","Searchable":false,"Class":null},{"Name":"ConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"BookingType","Title":"BType","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"TipName","Title":"Supplier Name","Searchable":true,"Class":null},{"Name":"SuppDate","Title":"SuppTkt Dt","Searchable":false,"Class":null},{"Name":"SuppNo","Title":"SuppTkt No","Searchable":false,"Class":null},{"Name":"PurchaseOrderNo","Title":"PO NO","Searchable":false,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Searchable":true,"Class":null},{"Name":"WaitTime","Title":"Wait Time","Searchable":true,"Class":null},{"Name":"Status","Title":"Status","Searchable":true,"Class":null}]}'; 
    } 
	
	public function InvoiceLoadsExcluded(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();
			           
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Invoice Loads Excluded';
            $this->global['active_menu'] = 'invoiceloadsexcluded'; 
            
            $this->loadViews("Invoices/InvoiceLoadsExcluded", $this->global, $data, NULL);
        }
    }
	
	public function AjaxInvoiceLoadsExcluded(){  
		$this->load->library('ajax');
		$data = $this->Invoices_model->GetInvoiceLoadsExcluded();  
		$this->ajax->send($data);
	}
 	
	public function InvoiceLoadsExcludedTableMeta(){   		 
		echo '{"Name":"InvoiceLoadsExcluded","Action":true,"Column":[{"Name":"LoadID","Title":"","Searchable":false,"Class":null},{"Name":"ConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"BookingType","Title":"BType","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"TipName","Title":"Supplier Name","Searchable":true,"Class":null},{"Name":"SuppDate","Title":"SuppTkt Dt","Searchable":false,"Class":null},{"Name":"SuppNo","Title":"SuppTkt No","Searchable":false,"Class":null},{"Name":"PurchaseOrderNo","Title":"PO NO","Searchable":false,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Searchable":true,"Class":null},{"Name":"WaitTime","Title":"Wait Time","Searchable":true,"Class":null},{"Name":"Status","Title":"Status","Searchable":true,"Class":null}]}'; 
    } 
	function CreatePreInvoiceAllAJAXPOST(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{     
			
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
			
			$data['InvoiceLoads'] = $this->Invoices_model->GetInvoiceLoadsForPreInvoice(); 			
			//var_dump($data['InvoiceLoads']); 
			//exit;
			if(count($data['InvoiceLoads'])>0){
				$Array = array(); 
				//for($a=0;$a>count($data['InvoiceLoads']);$a++){  
				$xx = 0; 

				foreach( $data['InvoiceLoads'] as $row){ 
					if($xx==0){
						$x = $row['CompanyID']; $y = $row['OpportunityID']; $z = $row['MaterialID'];	
					}
					
					if($x == $row['CompanyID'] && $y == $row['OpportunityID'] && $z == $row['MaterialID'] ){ 
						//$xx++;  
						
					//	echo $xx;
					//	echo " ==== ";
					//	echo $x; 
					//	echo " ==== ";
					//	echo $y; 
					//	echo " ==== ";
					//	echo $z;
					//	echo " </br>  ";
						
					}else{
						$Array[] = $xx;
						
						//$xx++; 
						//echo "| else ".$xx." |";
					//	echo " ||| ==== ";
					    $x = $row['CompanyID']; 
					//	echo " ==== ";
					    $y = $row['OpportunityID']; 
					//	echo " ==== ";
					    $z = $row['MaterialID'];
					//	echo " </br>  ";
					} 
					
				    if(count($data['InvoiceLoads'])-1 == $xx){ 
					    $xx++; 
					    $Array[] = $xx; 
					    //echo "|  count ".$xx." |";
					    break; 
					}else{
					    $xx++; 
					} 	
				} 
			} 
			//print_r($Array);
			//exit;
			  
			for($j=0;$j<count($Array);$j++){  
			//for($j=0;$j<3;$j++){  
					/*
					$LastPreInvoiceNumber =  $this->Invoices_model->LastPreInvoiceNo();  
					//echo $LastPreInvoiceNumber['PreInvoiceNumber'];
					//echo "<PRE>";
					//print_r($LastPreInvoiceNumber);
					//echo "<PRE>";
					//exit;
					if($LastPreInvoiceNumber['PreInvoiceNumber']){ 
						$PreInvoiceNumber = str_pad((int)$LastPreInvoiceNumber['PreInvoiceNumber']+1, 7, "0", STR_PAD_LEFT);  
					}else{ 
						$PreInvoiceNumber =  str_pad(1, 7, "0", STR_PAD_LEFT);  
					} */
					//echo $PreInvoiceNumber;
					//exit;
					$RandNum = rand(10,100);

					if($j==0){ $newi = 0;  }else{ $newi = $Array[$j-1];  }
				
					for($i=$newi; $i<$Array[$j]; $i++){  
						
						$InvoiceInfo1 = array('PreInvoiceNumber'=>$RandNum, 'LoadID'=>$data['InvoiceLoads'][$i]['LoadID'], 
						'CreatedUserID'=>$this->session->userdata['userId'] ); 
						$this->Common_model->insert("tbl_invoice_load",$InvoiceInfo1);
						
						//echo $data['InvoiceLoads'][$i]['LoadID'];
						//echo "<br>";		 
						$CompanyID =  $data['InvoiceLoads'][$i]['CompanyID']; 
						$CompanyName =  $data['InvoiceLoads'][$i]['CompanyName']; 
						//echo "<br>";
						$OpportunityID =  $data['InvoiceLoads'][$i]['OpportunityID']; 
						$OpportunityName =  $data['InvoiceLoads'][$i]['OpportunityName']; 
						$InvoiceType =  $data['InvoiceLoads'][$i]['TonBook'];  
						//echo "<br>";
						
					} /// For each 
					if($i>0){ 
						$InvoiceInfo = array('PreInvoiceNumber'=>$RandNum,'PreInvoiceDate'=>date('Y-m-d'), 
						'CompanyID'=>$CompanyID,'CompanyName'=>$CompanyName,'OpportunityID'=>$OpportunityID,
						'OpportunityName'=>$OpportunityName,'InvoiceType'=>$InvoiceType,
						'Status'=>'0','CreatedUserID'=>$this->session->userdata['userId'] ); 
						$InvoiceID = $this->Common_model->insert("tbl_invoice",$InvoiceInfo); 
						 
						$UID =  $this->Invoices_model->UpdateInvoiceID($RandNum,$InvoiceID);    
					}
			}
				
			redirect('InvoiceLoads');
			exit; 
			
			}			
			 
        }
		
    }
	
	
	public function CreatePreInvoiceAJAXPOST(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();
			if ($this->input->server('REQUEST_METHOD') === 'POST'){ 
				
				$LoadIdsCSV = $this->input->post('LoadIdsCSV');  
				$CompanyID = $this->input->post('CompanyID');  
				$CompanyName = $this->input->post('CompanyName');  
				$OpportunityID = $this->input->post('OpportunityID');  
				$OpportunityName = $this->input->post('OpportunityName');  
				$InvoiceType = $this->input->post('TonBook');  
				
				//var_dump($_POST);
				$LoadID = explode(',',$LoadIdsCSV);
				//print_r($LoadID);
				//exit;
				$LastPreInvoiceNumber =  $this->Invoices_model->LastPreInvoiceNo();  
				if($LastPreInvoiceNumber){ 
					$PreInvoiceNumber = str_pad((int)$LastPreInvoiceNumber['PreInvoiceNumber']+1, 7, "0", STR_PAD_LEFT);  
				}else{
					$PreInvoiceNumber =  str_pad(1, 7, "0", STR_PAD_LEFT);  
				}	 
				 
				$InvoiceInfo = array('PreInvoiceNumber'=>$PreInvoiceNumber,'PreInvoiceDate'=>date('Y-m-d'), 
				'CompanyID'=>$CompanyID,'CompanyName'=>$CompanyName,'OpportunityID'=>$OpportunityID,
				'OpportunityName'=>$OpportunityName,'InvoiceType'=>$InvoiceType,
				'Status'=>'0','CreatedUserID'=>$this->session->userdata['userId'] ); 
				$InvoiceID = $this->Common_model->insert("tbl_invoice",$InvoiceInfo); 
				if($InvoiceID){
					
					for($i=0;$i<count($LoadID);$i++){ 
						$InvoiceInfo1 = array('InvoiceID'=>$InvoiceID, 'LoadID'=>$LoadID[$i] , 'CreatedUserID'=>$this->session->userdata['userId'] ); 
						$this->Common_model->insert("tbl_invoice_load",$InvoiceInfo1);	 
					}
					if($InvoiceType ==1){
						redirect('PreInvoiceLoadsTonnage/'.$InvoiceID);
					}else{
						redirect('PreInvoiceLoads/'.$InvoiceID);
					}
					exit;  
				}	   
			}  
        }
    }
 	    
	
	
	
    function CreatePreInvoiceAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$data = array();
			$LoadIds = array();
			
			$LDS  = $this->input->post('LoadID');      
			for($i=0;$i<count($LDS);$i++) {   
				 $LoadIds[] = $LDS[$i]['value']; 
			} 
			 
			$Oppos = $this->Invoices_model->GetOpportunitiesByLoadIDs($LoadIds);  
			if($Oppos[0]->OpportunityID == $Oppos[count($Oppos)-1]->OpportunityID){
				$data['error1'] = 0;
				$data['CompanyID'] =  $Oppos[0]->CompanyID; 
				$data['OpportunityID'] =  $Oppos[0]->OpportunityID; 
				$data['CompanyName'] =  $Oppos[0]->CompanyName; 
				$data['OpportunityName'] =  $Oppos[0]->OpportunityName; 
				$data['TonBook'] =  $Oppos[0]->TonBook;  
				
			}else{ 
				$data['error1'] = 1;
			}	
			if($Oppos[0]->TonBook == $Oppos[count($Oppos)-1]->TonBook){
				$data['error2'] = 0;
			}else{ 
				$data['error2'] = 1;
			}
			
			$data['LoadIdsCSV'] =  implode(',',$LoadIds);
			
			
			//if($Oppos->OpportunityID){
			//foreach ($Oppos as $value) {
				//var_dump($Oppos);	
			//	echo  $value->OpportunityID ."<br>";
			//}
			 
			//var_dump($Oppos);
			//exit;			
			
			$html = $this->load->view('Invoices/CreatePreInvoiceAJAX', $data, true);  
			echo json_encode($html);   
			  
        }
    }
	
	 function CreatePreInvoiceAllAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$data = array();
			    
			
			$html = $this->load->view('Invoices/CreatePreInvoiceAllAJAX', $data, true);  
			echo json_encode($html);   
			  
        }
    }
	
	
	public function PreInvoiceLoadsTableMeta(){
		echo '{"Name":"PreInvoiceLoads","Action":true,"Column":[{"Name":"LoadID","Title":"","Searchable":false,"Class":null},{"Name":"ConveyanceNo","Title":"Conv No","Searchable":true,"Class":null},{"Name":"SiteOutDateTime","Title":"DateTime","Searchable":true,"Class":null},{"Name":"BookingType","Title":"BType","Searchable":true,"Class":null},{"Name":"CompanyName","Title":"Customer Name","Searchable":true,"Class":null},{"Name":"OpportunityName","Title":"Job Site Address","Searchable":true,"Class":null},{"Name":"TipName","Title":"Supplier Name","Searchable":true,"Class":null},{"Name":"SuppDate","Title":"SuppTkt Dt","Searchable":false,"Class":null},{"Name":"SuppNo","Title":"SuppTkt No","Searchable":false,"Class":null},{"Name":"PurchaseOrderNo","Title":"PO NO","Searchable":false,"Class":null},{"Name":"MaterialName","Title":"Product Description","Searchable":true,"Class":null},{"Name":"DriverName","Title":"Driver Name","Searchable":true,"Class":null},{"Name":"VehicleRegNo","Title":"VRNO","Searchable":true,"Class":null},{"Name":"Price","Title":"Price","Searchable":true,"Class":null},{"Name":"WaitTime","Title":"Wait Time","Searchable":true,"Class":null},{"Name":"Status","Title":"Status","Searchable":true,"Class":null}]}'; 
    } 
	
	public function AjaxPreInvoiceLoads(){  
		$this->load->library('ajax');
		$data = $this->Invoices_model->GetPreInvoiceLoads();  
		$this->ajax->send($data);
	}
	
	public function PreInvoiceLoads($InvoiceID){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array(); 
			$data['PreInvoiceLoads'] = $this->Invoices_model->GetPreInvoiceLoads($InvoiceID) ; 
	
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : PreInvoice Loads';
            $this->global['active_menu'] = 'preinvoiceloads'; 
            
            $this->loadViews("Invoices/PreInvoiceLoads", $this->global, $data, NULL);
        }
    }
 	  
	public function PreInvoiceLoadsTonnage($InvoiceID){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array(); 
			$data['PreInvoiceLoads'] = $this->Invoices_model->GetPreInvoiceLoadsTonnage($InvoiceID) ; 
	
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : PreInvoice Loads';
            $this->global['active_menu'] = 'preinvoiceloads'; 
            
            $this->loadViews("Invoices/PreInvoiceLoadsTonnage", $this->global, $data, NULL);
        }
    }
	public function PreInvoice(){ 
          
		$data = array();         
		
		$this->global['pageTitle'] = WEB_PAGE_TITLE.' : PreInvoices';
		$this->global['active_menu'] = 'preinvoice'; 
		
		$this->loadViews("Invoices/PreInvoice", $this->global, $data, NULL); 
    }
	public function AjaxPreInvoicesList(){   
			$this->load->library('ajax');
			$data = $this->Invoices_model->GetPreInvoicesList();   
			$this->ajax->send($data); 
	}
	
	public function MyPreInvoice(){ 
        if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{            
            $data = array();          
            $this->global['pageTitle'] = WEB_PAGE_TITLE.' : My PreInvoice List';
            $this->global['active_menu'] = 'mypreinvoice'; 
            
            $this->loadViews("Invoices/MyPreInvoice", $this->global, $data, NULL);
        }
    }
	  
	public function AjaxMyPreInvoicesList(){  
		$this->load->library('ajax');
		$data = $this->Invoices_model->GetMyPreInvoiceList();   
		$this->ajax->send($data);
	}
	
	function RemovePreInvoiceLoadAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$LoadID  = $this->input->post('LoadID');        
			  
			$Cond = array( 'LoadID' => $LoadID  );   
			$result = $this->Common_model->delete('tbl_invoice_load', $Cond); 
			  
			if ($result > 0) { echo(json_encode(array('status'=>TRUE,'LoadID'=>$LoadID ))); }
            else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	function ExcludeLoadAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$LoadID  = $this->input->post('LoadID');        
			
			$LI = array('Exclude'=>1);  
			$Cond = array( 'LoadID' => $LoadID  );   			
			$result = $this->Common_model->update("tbl_booking_loads1", $LI, $Cond);
				   
			if ($result > 0) { echo(json_encode(array('status'=>TRUE,'LoadID'=>$LoadID ))); }
            else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	function IncludeLoadAJAX(){
        if($this->isEdit == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{   
			$LoadID  = $this->input->post('LoadID');        
			
			$LI = array('Exclude'=>0);  
			$Cond = array( 'LoadID' => $LoadID  );   			
			$result = $this->Common_model->update("tbl_booking_loads1", $LI, $Cond);
				   
			if ($result > 0) { echo(json_encode(array('status'=>TRUE,'LoadID'=>$LoadID ))); }
            else { echo(json_encode(array('status'=>FALSE))); }
			  
        }
    }
	
		

}

?>
