<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
 
class Reports extends BaseController
{

    protected $isView;
    protected $isAdd;
    protected $isEdit;
    protected $isDelete;

	 /**
     * This is default constructor of the class
     */
    public function __construct()
    {

        require_once(APPPATH.'third_party/fpdf17/fpdf.php');
        require_once(APPPATH.'third_party/FPDI/fpdi.php');
        parent::__construct();
        $this->load->model(array('contacts_model','Materials_model','Reports_model'));
        $this->load->library("excel");
        $this->isLoggedIn();      

        $roleCheck = $this->Common_model->checkpermission('reports');

         $this->global['isView'] = $this->isView = $roleCheck->view;   
         $this->global['isAdd'] = $this->isAdd = $roleCheck->add; 
         $this->global['isEdit'] = $this->isEdit = $roleCheck->edit; 
         $this->global['isDelete'] = $this->isDelete = $roleCheck->delete;
         $this->global['active_menu'] = 'dashboard';  


    }
     
     public function index(){

         if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {         
            
            $this->ticket();
        }
    }

    public function ticket(){
        
        $data=array();

		if($this->input->post('search')){
			$customer = $this->input->post('customer');
			$material = $this->input->post('material');
			$searchdate = $this->input->post('searchdate'); 
			
			$data['ticketsRecords'] = $this->Reports_model->get_tickets_report($searchdate,$customer,$material);  
		}	
		
        if($this->input->post('export')){
            
             $customer = $this->input->post('customer');
             $material = $this->input->post('material');
             $searchdate = $this->input->post('searchdate'); 

             $data['ticketsRecords'] = $this->Reports_model->get_tickets_report($searchdate,$customer,$material); 
			 
			$object = new PHPExcel();
			//print_r($_POST); die;
			$object->setActiveSheetIndex(0);

			$table_columns = array("Ticket Date","Company Name","Vechicle Reg No", "Driver Name", "Gross Weight","Tare","Net" );

			$column = 0;

			foreach($table_columns as $field)
			{
				$object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
				$column++;
			}

			$excel_row = 2;

			foreach( $data['ticketsRecords'] as $row)
			{ 
				$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TicketDate); 
				$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->CompanyName);
				$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->RegNumber);
				$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->DriverName); 
				$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, round($row->GrossWeight) );
				$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, round($row->Tare) );
				$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, round($row->Net) );    
				$excel_row++;
			}
			
			for ($i = 'A'; $i !=  $object->getActiveSheet()->getHighestColumn(); $i++) {
				$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
			}
					
			$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="Tocket Report.xls"');
			$object_writer->save('php://output'); 
        }
        
        //$data['contactsRecords'] = $this->contacts_model->contactsListing(); 
		$data['company_list'] = $this->Common_model->CompanyList( );
        $data['materialsRecords'] = $this->Common_model->get_all('materials');    
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Ticket Report';
        $this->global['active_menu'] = 'ticketreports';
        $this->loadViews("Reports/ticket", $this->global, $data, NULL);
    }
	
	public function TicketPayment(){
        
        $data=array();

        if($_POST){
            
            $paymenttype = $this->input->post('paymenttype'); 
            $searchdate = $this->input->post('searchdate');

            $search_array = array(); 
            $data['ticketsRecords'] = $this->Reports_model->get_tickets_payment_report($searchdate,$paymenttype); 
//			var_dump($data['ticketsRecords']);
//			exit;
             //echo $this->db->last_query();
             if(isset($_POST['export']))  {
					$object = new PHPExcel();
					//$object->getActiveSheet()->getColumnDimension('A')->setWidth(6);
					//$object->getActiveSheet()->getColumnDimension('B')->setWidth(12);
					//$object->getActiveSheet()->getColumnDimension('C')->setWidth(60);
					//$object->getActiveSheet()->getColumnDimension('D')->setWidth(60);
					//$object->getActiveSheet()->getColumnDimension('E')->setWidth(60);
					//$object->getActiveSheet()->getColumnDimension('F')->setWidth(12);
					//$object->getActiveSheet()->getColumnDimension('G')->setWidth(12);
					//$object->getActiveSheet()->getColumnDimension('H')->setWidth(13); 

				   $object->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('0.00');
				   $object->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('0.00');
				   $object->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('0.00');

                  // print_r($_POST); die;
                    $object->setActiveSheetIndex(0); 
                    $table_columns = array("Ticket No","Date","Site Name","Company Name", "Material", "Amount","Vat","Total Amount" ); 
                    $column = 0; 
                    foreach($table_columns as $field){
                        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                        $column++;
                    }
                    $excel_row = 2;
					$sum = 0;
                    foreach( $data['ticketsRecords'] as $row){ 
                        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TicketNumber); 
						$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->TicketDate); 
                        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->OpportunityName);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->CompanyName);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->MaterialName);  
                        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->Amount );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->VatAmount );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->TotalAmount );    
						$sum = $sum + $row->TotalAmount;
                        $excel_row++;
                    }
					$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, "SUM");    
					$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $sum );    
					
					for ($i = 'A'; $i !=  $object->getActiveSheet()->getHighestColumn(); $i++) {
						$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
					}

                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="Tocket Report.xls"');
                    $object_writer->save('php://output');
                     
             }
            
        }
        
        $data['contactsRecords'] = $this->contacts_model->contactsListing(); 
        $data['materialsRecords'] = $this->Common_model->get_all('materials');    
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Ticket Payment Report';
        $this->global['active_menu'] = 'ticketpaymentreports';
        $this->loadViews("Reports/TicketPayment", $this->global, $data, NULL);
    }
	
	public function tmlticket(){
        ini_set('memory_limit', '-1');
        $data=array();

        if($_POST){
            
             $ttype = $this->input->post('ttype');
			 $payType = $this->input->post('payType'); 
			 $customer = $this->input->post('customer');
             $material = $this->input->post('material');
             $searchdate = $this->input->post('searchdate');
			 $user = $this->input->post('user');
			 $tml = $this->input->post('tml');
			 $order = $this->input->post('order');
			 $title = "";
			 if($tml=='1'){ $title = "TML IN-OUT (TML)"; }	
			 else if($tml=='0'){ $title = "TML IN-OUT (NON TML)"; }	
			 else if($tml==''){ $title = "TML IN-OUT (ALL)"; }	
			 
             $search_array = array();

             $data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report($searchdate,$customer,$material,$tml,$ttype,$payType,$order,$user); 
 		   
             if(isset($_POST['export']))  {
                   $object = new PHPExcel();
                  // print_r($_POST); die;
                    $object->setActiveSheetIndex(0);
					
                    $table_columns = array("Ticket No","TicketType", "Ticket Date", "Conveyance","OrderNo","Site Name", "Driver Name", "Vechicle Reg No","Hauller"," Material Name","SIC Cod","Gross Weight","Tare","Net");

                    $column = 0; 

                    $excel_row = 2;
					$c=""; $c1=""; $m="";$m1=""; $loads = 0; $loads1 = 0;  $loads2 = 0; $net1 = 0;  $i=0;  $j=0;    $net2 = 0;
					$report = $this->input->post('report');
					if($report==2){ 
							$data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report_export_material($searchdate,$customer,$material,$tml,$ttype,$payType,$order,$user); 
							$count = count($data['ticketsRecords']);
							foreach( $data['ticketsRecords'] as $row)
							{
								$c=$row->CompanyID; $m = $row->MaterialID;
								if($m1 != $m || $c1 != $c ){
									if($j!=0){ 
										$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );							
										$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'Loads');
										$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $loads2);
										$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Net');	
										$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($net2));	
										$excel_row++;	 
									}
								}
								if($m1 != $m ){	 
									if($i!=0){
										$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );							
										$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'Loads');
										$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $loads1);
										$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Net');	
										$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($net1));	
										$excel_row++;
									}	
									$m1=$row->MaterialID; $c1=""; $loads1 = 0;  $net1 = 0; 
									$object->setActiveSheetIndex(0)->mergeCells('A'.$excel_row.':N'.$excel_row.'');
									$object->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row.'')->getFont()->setBold( true );

									$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "Material: ".$row->MaterialName);
									$excel_row++;
								}
								if($c1 != $c ){   $c1=$row->CompanyID; $loads = 0; $loads2 = 0;  $net2 = 0;  $j=0; 
									$object->setActiveSheetIndex(0)->mergeCells('A'.$excel_row.':N'.$excel_row.'');
									$object->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row.'')->getFont()->setBold( true );							
									$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "Company: ".$row->CompanyName);
									$excel_row++;
										$column = 0;
										foreach($table_columns as $field){
											$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );
											$object->getActiveSheet()->setCellValueByColumnAndRow($column, $excel_row, $field);
											$column++;
										}
									$excel_row++;	
								}
								
								$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TicketNumber);
								$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->TypeOfTicket	);
								$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->TicketDate);
								$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->Conveyance);
								$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->OrderNo);
								$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->SiteName);
								$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->DriverName);
								$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->RegNumber);
								$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->Hulller );
								$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->MaterialName );
								$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->SicCode );
								$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, round($row->GrossWeight) );
								$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, round($row->Tare) );
								$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($row->Net) );   

								$excel_row++;
								$net2 = $net2 + $row->Net; $net1 = $net1 + $row->Net; 
								$loads = $loads+1;  $loads1 = $loads1+1;  $loads2 = $loads2+1;  $j = $j+1;
								if($i== $count-1){
									$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );							
									$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'Loads');
									$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $loads2);
									$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Net');	
									$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($net2));	
									$excel_row++;	 
									
									$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );							
									$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'Loads');
									$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $loads1);
									$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Net');	
									$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($net1));	
									$excel_row++;	 
								}	
								/*if( $row->mCount == $loads){ 
									$object->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row.'')->getFont()->setBold( true );							
									$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Loads');
									$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->mCount);
									$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 'Net');	
									$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, round($row->netTotal));	
									$excel_row++;	 
								}*/
								$i++;
								
							}
					}else{
							$data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report_export($searchdate,$customer,$material,$tml,$ttype,$payType,$order,$user); 
							$c=""; $c1=""; $m="";$m1=""; $loads = 0; $loads1 = 0; $net1 = 0; $i=0;  $j=0;   $loads2 = 0;  $net2 = 0;
							$count = count($data['ticketsRecords']);
							foreach( $data['ticketsRecords'] as $row){
								$c=$row->CompanyID; $m = $row->MaterialID;
								if($c1 != $c || $m1 != $m ){ 
									if($j!=0){ 
										$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );							
										$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'Loads');
										$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $loads2);
										$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Net');	
										$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($net2));	
										$excel_row++;	
									}
								}
								if($c1 != $c ){	 $c1=$row->CompanyID; $m1=""; $loads1 = 0;  $net1 = 0;
									$object->setActiveSheetIndex(0)->mergeCells('A'.$excel_row.':N'.$excel_row.'');
									$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );

									$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->CompanyName);
									$excel_row++;
								}
								if($m1 != $m ){ $m1=$row->MaterialID;   $loads = 0; $loads2 = 0;  $net2 = 0;  $j=0;  
									$object->setActiveSheetIndex(0)->mergeCells('A'.$excel_row.':N'.$excel_row.'');
									$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );							
									$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->MaterialName);
									$excel_row++;
										$column = 0;
										foreach($table_columns as $field){
											$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );
											$object->getActiveSheet()->setCellValueByColumnAndRow($column, $excel_row, $field);
											$column++;
										}
									$excel_row++;	
								}
								
								$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TicketNumber);
								$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->TypeOfTicket	);
								$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->TicketDate);
								$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->Conveyance);
								$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->OrderNo);
								$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->SiteName);
								$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->DriverName);
								$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->RegNumber);
								$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->Hulller );
								$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->MaterialName );
								$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->SicCode );
								$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, round($row->GrossWeight) );
								$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, round($row->Tare) );
								$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($row->Net) );   

								$excel_row++;
								$net2 = $net2 + $row->Net; $net1 = $net1 + $row->Net; 
								$loads = $loads+1;  $loads1 = $loads1+1; $loads2 = $loads2+1;  $j = $j+1; 
								if($i== $count-1){ 
									
									$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );							
									$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'Loads');
									$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $loads2);
									$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Net');	
									$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($net2));	
									$excel_row++;	 
									
									$object->getActiveSheet()->getStyle('A'.$excel_row.':N'.$excel_row.'')->getFont()->setBold( true );							
									$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, 'Loads');
									$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $loads1);
									$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'Net');	
									$object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, round($net1));	
									$excel_row++;	 
								}	 
								$i =$i+1;
							} 
					}	 
					for ($i = 'A'; $i !=  $object->getActiveSheet()->getHighestColumn(); $i++) {
						$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
					}
                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="Tocket Report.xls"');
                    $object_writer->save('php://output');
                     
             }
			 
			 if(isset($_POST['export1']))  { 
			 
				$report = $this->input->post('report');
				if($report==2){ 
					$data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report_export_material($searchdate,$customer,$material,$tml,$ttype,$payType,$order,$user); 
					$data['title'] = $title;
					 $html=$this->load->view('Reports/tml_tickets_reports_pdf_material', $data, true);
				}else{
					$data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report_export($searchdate,$customer,$material,$tml,$ttype,$payType,$order,$user); 
					$data['title'] = $title;
					//var_dump($data['ticketsRecords']);
					//exit;
					 $html=$this->load->view('Reports/tml_tickets_reports_pdf', $data, true);
				}  
				
				 
				 //this the the PDF filename that user will get to download 
				 //load mPDF library
				$this->load->library('m_pdf'); 
				//generate the PDF from the given html
				$this->m_pdf->pdf->setFooter('<div align="left">Page {PAGENO} of {nbpg}</div>');

				$this->m_pdf->pdf->AddPage('L'); // Adds a new page in Landscape orientation
				$this->m_pdf->pdf->WriteHTML($html); 
//				echo $html;

				//download it.
				$this->m_pdf->pdf->Output($data['ticketsRecords'][0]->TicketNumber.".pdf", "D");  
                     
             }
            
        }
        
        $data['company_list'] = $this->Common_model->CompanyList( );
		//$data['contactsRecords'] = $this->contacts_model->contactsListing(); 
        $data['materialsRecords'] = $this->Common_model->get_all('materials');    
		$data['Users'] = $this->Common_model->GetAllUsers();    
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML Ticket Report';
        $this->global['active_menu'] = 'tmlreports';
        $this->loadViews("Reports/tmlticket", $this->global, $data, NULL);
    }
	
		public function eareports(){
        
        $data=array();
			$user = $this->input->post('user'); 
			if($_POST){
				
				$type	 = $this->input->post('tickettype');
				$material = $this->input->post('material');
				$county = $this->input->post('county');
				$searchdate = $this->input->post('searchdate');
				
				
				 if($type!=""){ $data['ptype'] = $type; }else{ $data['ptype'] = " IN | OUT "; }
				 if(!empty($county)){ $data['pcounty'] = implode(",",$county); }else{ $data['pcounty'] = "ALL COUNTY"; }
				 $search_array = array(); 
				 $data['ticketsRecords'] = $this->Reports_model->get_ea_report($searchdate,$type,$material,$county,$user);   
			} 
             if(isset($_POST['export']))  { 
				$type	 = $this->input->post('tickettype');
				$material = $this->input->post('material');
				$county = $this->input->post('county');
				$searchdate = $this->input->post('searchdate');
				  
				 if($type==""){ $data['ptype'] = "IN | OUT "; }else{ $data['ptype'] = $type; }
				 $data['searchdate'] = $searchdate;
				 if(!empty($county)){ $data['pcounty'] = implode(",",$county); }else{ $data['pcounty'] = "ALL COUNTY"; }
				 $search_array = array(); 
				 $data['ticketsRecords'] = $this->Reports_model->get_ea_report($searchdate,$type,$material,$county,$user);   
				 
				 if(!empty($data['ticketsRecords'])){
                   $object = new PHPExcel();
                  // print_r($_POST); die;
                    $object->setActiveSheetIndex(0); 
                    $table_columns = array("Ticket Type","Material Name","county", "Sum Of Net (Tonnes)"); 
                    $column = 0;  
                    $excel_row = 2;
					$i=1; $total = 0;  
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'TICKET TYPE ');
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['ptype']);
					$excel_row++; 
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'DATE ');
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['searchdate']);
					$excel_row++;
					//$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'COUNTY ');
					//$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['pcounty']);
					$excel_row++; //$excel_row++;
					foreach($table_columns as $field){
						$object->getActiveSheet()->getStyle('A'.$excel_row.':D'.$excel_row.'')->getFont()->setBold( true );
						$object->getActiveSheet()->setCellValueByColumnAndRow($column, $excel_row, $field);
						$column++;
					}
					$excel_row++;
					foreach( $data['ticketsRecords'] as $row) {  
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TypeOfTicket);
						$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->MaterialName	);
						$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->County);
						$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->net_tonnes);  
						
						$excel_row++; $i++;
						$total = $total + $row->net_tonnes;   
					}
					$excel_row++;
					
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, '');
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, 'GRAND TOTAL ');
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $total);
					for ($i = 'A'; $i !=  $object->getActiveSheet()->getHighestColumn(); $i++) {
						$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
					}
                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="EAREPORTS-'.date("YmdHis").'.xls"');
                    $object_writer->save('php://output');
				 }       
             }
			 
			 if(isset($_POST['export1']))  {   
				$type	 = $this->input->post('tickettype');
				$material = $this->input->post('material');
				$county = $this->input->post('county');
				$searchdate = $this->input->post('searchdate');
				  
				 if($type==""){ $data['ptype'] = "IN | OUT "; }else{ $data['ptype'] = $type; }
				 $data['searchdate'] = $searchdate;
				 if(!empty($county)){ $data['pcounty'] = implode(",",$county); }else{ $data['pcounty'] = "ALL COUNTY"; }
				 $search_array = array(); 
				 $data['ticketsRecords'] = $this->Reports_model->get_ea_report($searchdate,$type,$material,$county,$user);   
				 
				if(!empty($data['ticketsRecords'])){ 
					$PDFNAME = 'EAREPORTS-'.date("YmdHis"); //$this->generateRandomString();
					$html=$this->load->view('Reports/ea_reports_pdf', $data, true);
						
					//this the the PDF filename that user will get to download 
					//load mPDF library
					$this->load->library('m_pdf'); 
					//generate the PDF from the given html
					$this->m_pdf->pdf->AddPage('L'); // Adds a new page in Landscape orientation
					$this->m_pdf->pdf->WriteHTML($html); 
					//download it.
					$this->m_pdf->pdf->Output($PDFNAME.".pdf", "D");  
				}    
             }
		 	
        $data['county'] = $this->Common_model->get_all('county');   
		$data['materialsRecords'] = $this->Common_model->get_all('materials');  
		$data['Users'] = $this->Common_model->GetAllUsers();
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : EA Report';
        $this->global['active_menu'] = 'eareports';
        $this->loadViews("Reports/eareports", $this->global, $data, NULL);
    }
	
	public function MaterialReports(){
        
        $data=array();

			if($_POST){
				
				$type	 = $this->input->post('tickettype'); 
				$searchdate = $this->input->post('searchdate');
				$payType = $this->input->post('payType');    
				$user = $this->input->post('user');    
				$tml = $this->input->post('tml');  
				 
				 if($type!=""){ $data['ptype'] = $type; }else{ $data['ptype'] = " IN | OUT "; } 
				 $search_array = array(); 
				 $data['ticketsRecords'] = $this->Reports_model->GetMaterialReports($searchdate, $type, $tml, $payType, $user);   
			} 
             if(isset($_POST['export']))  { 
				$type	 = $this->input->post('tickettype'); 
				$searchdate = $this->input->post('searchdate');
				$payType = $this->input->post('payType');    
				$tml = $this->input->post('tml');  
				   
				 if($type==""){ $data['ptype'] = "IN | OUT "; }else{ $data['ptype'] = $type; } 
				 $data['searchdate'] = $searchdate;
				 $search_array = array(); 
				 $data['ticketsRecords'] = $this->Reports_model->GetMaterialReports($searchdate, $type, $tml, $payType, $user);   
				 
				 if(!empty($data['ticketsRecords'])){
                   $object = new PHPExcel();
                  // print_r($_POST); die;
                    $object->setActiveSheetIndex(0); 
                    $table_columns = array("Ticket Type","Material Name","Loads", "Sum Of Net (Tonnes)"); 
                    $column = 0;  
                    $excel_row = 2;
					$i=1; $total = 0;  
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'TICKET TYPE ');
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['ptype']);
					$excel_row++; 
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 'DATE ');
					$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $data['searchdate']);
					$excel_row++; 
					$excel_row++; //$excel_row++;
					foreach($table_columns as $field){
						$object->getActiveSheet()->getStyle('A'.$excel_row.':D'.$excel_row.'')->getFont()->setBold( true );
						$object->getActiveSheet()->setCellValueByColumnAndRow($column, $excel_row, $field);
						$column++;
					}
					$excel_row++;
					foreach( $data['ticketsRecords'] as $row) {  
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TypeOfTicket);
						$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->MaterialName	);
						$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->CountLoads);
						$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->net_tonnes);  
						
						$excel_row++; $i++;
						$total = $total + $row->net_tonnes;   
					}
					$excel_row++;
					
					$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, '');
					$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, 'GRAND TOTAL ');
					$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $total);
					for ($i = 'A'; $i !=  $object->getActiveSheet()->getHighestColumn(); $i++) {
						$object->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
					}
                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="MaterialReports-'.date("YmdHis").'.xls"');
                    $object_writer->save('php://output');
				 }       
             }
			 
			 if(isset($_POST['export1']))  {   
				$type	 = $this->input->post('tickettype'); 
				$searchdate = $this->input->post('searchdate');
				$payType = $this->input->post('payType');    
				$tml = $this->input->post('tml');  
				  
				 if($type==""){ $data['ptype'] = "IN | OUT "; }else{ $data['ptype'] = $type; } 
				 $data['searchdate'] = $searchdate;
				 $search_array = array(); 
				 $data['ticketsRecords'] = $this->Reports_model->GetMaterialReports($searchdate, $type, $tml, $payType, $user );    
				if(!empty($data['ticketsRecords'])){ 
					$PDFNAME = 'MaterialReports-'.date("YmdHis");
					$html=$this->load->view('Reports/MaterialReports_pdf', $data, true);
						
					//this the the PDF filename that user will get to download 
					//load mPDF library
					$this->load->library('m_pdf'); 
					//generate the PDF from the given html
					$this->m_pdf->pdf->AddPage('L'); // Adds a new page in Landscape orientation
					$this->m_pdf->pdf->WriteHTML($html); 
					//download it.
					$this->m_pdf->pdf->Output($PDFNAME.".pdf", "D");  
				}    
             }
		 	
        $data['county'] = $this->Common_model->get_all('county');   
		$data['Users'] = $this->Common_model->GetAllUsers();    
		$data['materialsRecords'] = $this->Common_model->get_all('materials');  
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : EA Report';
        $this->global['active_menu'] = 'materialreports';
        $this->loadViews("Reports/MaterialReports", $this->global, $data, NULL);
    }
	
     public function tmlreports(){
    
        if($_POST){
       
             $data=array();            
           
             $searchdate = $this->input->post('searchdate');
             $searchdates= explode('-', $searchdate);
             $firstDate = $data['firstDate'] = date('Y-m-d',strtotime($searchdates[0]));
             $SecondDate = $data['SecondDate'] = date('Y-m-d',strtotime($searchdates[1]));  

            $this->db->select('m.*,count(t.TicketNumber) as total_count,sum(t.Net) as total_net');
            $this->db->from('materials as m');
            $this->db->join('tickets as t', 't.MaterialID = m.MaterialID',"LEFT");               
            $this->db->where('DATE(t.CreateDate) >=', $firstDate);
            $this->db->where('DATE(t.CreateDate) <=', $SecondDate);           
            $this->db->group_by(array("t.MaterialID", "t.TypeOfTicket")); 
            $query = $this->db->get();        
            $data['resultmaterials'] = $query->result();

            //echo '<pre>';print_r($data['resultmaterials']);die;


            foreach ($data['resultmaterials'] as  $key => $materials) {

            $this->db->select('c.*,count(t.TicketNumber) as total_count,sum(t.Net) as total_net');
            $this->db->from('company as c');
            $this->db->join('tickets as t', 't.CompanyID = c.CompanyID',"LEFT");               
            $this->db->where('DATE(t.CreateDate) >=', $firstDate);
            $this->db->where('DATE(t.CreateDate) <=', $SecondDate); 
            $this->db->where("t.MaterialID", $materials->MaterialID);
            $this->db->group_by('t.CompanyID');
            $query1 = $this->db->get();        
            $resultcompany = $query1->result();
            $data['resultmaterials'][$key]->resultcompany =  $resultcompany;                           
                       
            } 

           
             $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tipped Reports';
             $this->global['active_menu'] = 'ticketreports';
             $html=$this->load->view('Reports/tml_pdf', $data, true);        
             
            $this->load->library('m_pdf');

            // //generate the PDF from the given html
            $this->m_pdf->pdf->WriteHTML($html);
             
            //  //download it.
            $this->m_pdf->pdf->Output($pdfFilePath, "D");
        }
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tipped Reports';
        $this->global['active_menu'] = 'ticketreports';
        $this->loadViews("Reports/tml_report", $this->global, NULL);
    }
	 
    public function tippedReportsSubmit(){
        
        $data=array(); 
		
             $searchdate = $this->input->post('searchdate');  

             $data['ticketsRecords'] = $this->Reports_model->get_tipped_report($searchdate); 
             //this the the PDF filename that user will get to download
             //  $pdfFilePath =  WEB_ROOT_PATH."assets/pdf_file/".$TicketUniqueID.".pdf";
             //   //load mPDF library
             $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tipped Reports';
             $this->global['active_menu'] = 'ticketreports';
             $this->loadViews('Reports/tipped_pdf', $data, NULL);       
     

    }

    public function material(){

         if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {
        $data=array();  
        if($_POST){
            
             $Operation = $this->input->post('Operation');
             $data['materialsRecords'] = $this->Common_model->select_all_with_where_result('materials',array("Operation"=>$Operation)); 

         }else{

            $data['materialsRecords'] = $this->Common_model->get_all('materials');
 
         }

        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Material Report';
        $this->global['active_menu'] = 'materialreports';
        $this->loadViews("Reports/material", $this->global, $data, NULL);

		}
    }
	public function tippedReports(){

         if($this->isView == 0){
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }else{
				
			$data=array();  
			
			if($_POST){
            
             $customer = $this->input->post('customer');
             $material = $this->input->post('material');
             $searchdate = $this->input->post('searchdate');

             $search_array = array();

             $data['ticketsRecords'] = $this->Reports_model->get_tippedin_report_export($searchdate,$customer,$material); 
 		   
             if(isset($_POST['export']))  {
					$object = new PHPExcel(); 
                    $object->setActiveSheetIndex(0);
					
                    $table_columns = array("Ticket No","TicketType", "Ticket Date", "Conveyance","Site Name", "Driver Name", "Vechicle Reg No","Hauller"," Material Name","SIC Cod","Gross Weight","Tare","Net"); 
                    $column = 0;  
                    $excel_row = 2;
					$c=""; $c1=""; $m="";$m1=""; $loads = 0; 
			  
					foreach( $data['ticketsRecords'] as $row){
						$c=$row->CompanyID; $m = $row->MaterialID;
						if($m1 != $m ){	 $m1=$row->MaterialID; 
							$object->setActiveSheetIndex(0)->mergeCells('A'.$excel_row.':M'.$excel_row.'');
							$object->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row.'')->getFont()->setBold( true );

							$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "Material: ".$row->MaterialName);
							$excel_row++;
						}
						if($c1 != $c ){   $c1=$row->CompanyID;   $loads = 0;  
							$object->setActiveSheetIndex(0)->mergeCells('A'.$excel_row.':M'.$excel_row.'');
							$object->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row.'')->getFont()->setBold( true );							
							$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, "Company: ".$row->CompanyName);
							$excel_row++;
								$column = 0;
								foreach($table_columns as $field){
									$object->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row.'')->getFont()->setBold( true );
									$object->getActiveSheet()->setCellValueByColumnAndRow($column, $excel_row, $field);
									$column++;
								}
							$excel_row++;	
						}
						
						$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TicketNumber);
						$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->TypeOfTicket	);
						$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->TicketDate);
						$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->Conveyance);
						$object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->SiteName);
						$object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->DriverName);
						$object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->RegNumber);
						$object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->Hulller );
						$object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->MaterialName );
						$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->SicCode );
						$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->GrossWeight );
						$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->Tare );
						$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->Net );   

						$excel_row++;
						$loads = $loads+1;
						if( $row->mCount == $loads){ 
							$object->getActiveSheet()->getStyle('A'.$excel_row.':M'.$excel_row.'')->getFont()->setBold( true );							
							$object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'Loads');
							$object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->mCount);
							$object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 'Net');	
							$object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->netTotal);	
							$excel_row++;	 
						}	 
					}
				  
                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="Tocket Report.xls"');
                    $object_writer->save('php://output');
                     
             } // Export End 
			 
			 if(isset($_POST['export1']))  { 
 
				$html=$this->load->view('Reports/tippedin_reports_pdf', $data, true);
			 
				//this the the PDF filename that user will get to download 
				//load mPDF library
				$this->load->library('m_pdf'); 
				//generate the PDF from the given html
				$this->m_pdf->pdf->AddPage('L'); // Adds a new page in Landscape orientation
				$this->m_pdf->pdf->WriteHTML($html); 
				//download it.
				$this->m_pdf->pdf->Output($data['ticketsRecords'][0]->TicketNumber.".pdf", "D");  
                     
             }
            
        }
        $data['company_list'] = $this->Common_model->CompanyList( );
        //$data['contactsRecords'] = $this->contacts_model->contactsListing(); 
        $data['materialsRecords'] = $this->Common_model->get_all('materials');  
			 

			$this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tipped In Material Report';
			$this->global['active_menu'] = 'tippedinreports';
			$this->loadViews("Reports/tippedReports", $this->global, $data, NULL);

		}
    }
	 
    public function viewTicket(){

         if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {

        $TicketNumber= $this->uri->segment(2);
        $data['ticketsDetail'] = $this->Reports_model->get_tickets_details($TicketNumber);
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Ticket Details';
        $this->global['active_menu'] = 'ticketreports';
        $this->loadViews("Reports/ticketDetails", $this->global, $data, NULL);

    }

    }


 public function invoicelist(){


    $invoice_list = $this->Common_model->get_invoice_list();
       
       
            $start = 1;
            $cnt = 1;

            foreach ($invoice_list as $row) {               

                    $invdt = date('d/m/Y', strtotime($row['INVOICE_DATE']));
                    $INVOICE_NUMBER = $row['INVOICE_NUMBER'];
                    $GUID = $row['GUID'];
                    $ActRevision = $row['ActRevision'];

                    $invoice_images = $this->Common_model->get_invoice_images($GUID,$ActRevision);
                      
                if(count($invoice_images) > 0){ 
                    
                    foreach ($invoice_images as $row13) { 

                    $sub_id = $row13['StorageRevLocationSubID'];
                    if ($sub_id < 10)
                        $s_path = '0000000' . $sub_id;
                    elseif ($sub_id < 100)
                        $s_path = '000000' . $sub_id;
                    elseif ($sub_id < 1000)
                        $s_path = '00000' . $sub_id;
                    else
                        $s_path = '0000' . $sub_id;
                        
                    $path = "http://62.232.123.146:8081/WebImages/" . $s_path . "/" . $row13['DocGUID'] . ".FDD/0000000" . $row13['stroageRev'] . ".REV/Files/" . str_replace(' ', '%20', $row13['sourcefileName']);
                    $ext = explode('.',$row13['sourcefileName']);
                    $xlsFile = false;
                    if($ext[1]=='xls') {
                        $filename1 = WEB_ROOT_PATH."assets/invoice-img/xls" . $row['INVOICE_NUMBER'] . $start . ".xls";
                        if(file_exists($filename1)) {
                            $path1=$path;$xlsFile = true;
                        } else  {
                            $data = file_get_contents($path);
                            $path1=$path;
                            file_put_contents($filename1, $data);
                        }
                    }
                }

            }else{ 
                /*CHECK WITH .XLS file for find any file exist*/
                $invoice_images_any = $this->Common_model->get_invoice_images_any($GUID);

                 if(count($invoice_images_any) > 0){ 

                foreach ($invoice_images_any as $row13) { 

                    $sub_id = $row13['StorageRevLocationSubID'];
                    if ($sub_id < 10)
                        $s_path = '0000000' . $sub_id;
                    elseif ($sub_id < 100)
                        $s_path = '000000' . $sub_id;
                    elseif ($sub_id < 1000)
                        $s_path = '00000' . $sub_id;
                    else
                        $s_path = '0000' . $sub_id;
                        
                    $path = "http://62.232.123.146:8081/WebImages/" . $s_path . "/" . $row13['DocGUID'] . ".FDD/0000000" . $row13['stroageRev'] . ".REV/Files/" . str_replace(' ', '%20', $row13['sourcefileName']);
                    $ext = explode('.',$row13['sourcefileName']);
                    $xlsFile = false;
                    if($ext[1]=='xls') {

                        $filename1 = WEB_ROOT_PATH."assets/invoice-img/xls" . $row['INVOICE_NUMBER'] . $start . ".xls";
                        if(file_exists($filename1)) {
                            $path1=$path; $xlsFile = true;
                        } else  {
                            $data = file_get_contents($path);
                            $path1=$path;
                            file_put_contents($filename1, $data);
                        }

                    }

                   $companyInfo = array('ActRevision' => $row13['RevNo']);
                   $cond = array('GUID' => $GUID,'Invoice_No' => $INVOICE_NUMBER,'doctypeID' => 'd4223346');
                   $this->Common_model->update("documents1",$companyInfo, $cond);

                }

            }

            }

$invdt = date('d/m/Y', strtotime($row['INVOICE_DATE']));
$invoice_array[] = array(
       "path"=>$path,
       "filename1"=>$filename1,
       "start" =>$start,
       "INVOICE_NUMBER"=>$row['INVOICE_NUMBER'],
       "cust_name"=>$row['cust_name'],
       "job_site_address"=>$row['job_site_address'],
       "TML_Ref"=>$row['TML_Ref'],
       "Pages_No"=>$row['Pages_No'],
       "invdt"=>$invdt
    );     
     
            $start++;
            $cnt++;
        } 

        $data['invoice_list'] = $invoice_array;

        //print_r($data['invoice_list']);die;
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Invoice List';
        $this->global['active_menu'] = 'invoice';             
        $this->loadViews("Reports/invoice_list", $this->global, $data, NULL);
         
    }




public function gen_invoices($invoice_id)
    {

$fetch_data = $this->Common_model->get_invoice_info($invoice_id);
$res = $this->Common_model->get_invoice_items($fetch_data['INVOICE_NUMBER']);
// initiate FPDI  
$pdf = new FPDI();  
// add a page
$pdf->AddPage();  
// set the sourcefile  
$pdf->setSourceFile(WEB_ROOT_PATH.'assets/test.pdf');  
// import page 1  
$tplIdx = $pdf->importPage(1);  
// use the imported page and place it at point 10,10 with a width of 200 mm   (This is the image of the included pdf)
$pdf->useTemplate($tplIdx, 0, 0, 210,300);  
// now write some text above the imported page
$pdf->SetTextColor(0,0,0);
 $pdf->SetFont('Arial','U',22);  
$pdf->SetXY(95, 55);  
$pdf->Write(0, "COPY");

$pdf->SetFont('Arial','',10);  
$pdf->SetXY(13, 68);  
$pdf->Write(0, $fetch_data['NAME']);
$pdf->SetXY(13, 73);  
$pdf->Write(0, $fetch_data['ADDRESS_1']);
$pdf->SetXY(13, 78);  
$pdf->Write(0, $fetch_data['ADDRESS_2']);
$pdf->SetXY(13, 83);  
$pdf->Write(0, $fetch_data['ADDRESS_3']);
$pdf->SetXY(13, 88);  
$pdf->Write(0, $fetch_data['ADDRESS_4']);
$pdf->SetXY(13, 93);  
$pdf->Write(0, $fetch_data['ADDRESS_5']);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',11); 
$pdf->SetXY(128, 68);  
$pdf->Write(0, "Invoice No.");
$pdf->SetXY(128, 76);  
$pdf->Write(0, "Invoice Date");
$pdf->SetXY(128, 84);  
$pdf->Write(0, "Cust.Order No.");
$pdf->SetXY(128, 92);  
$pdf->Write(0, "Account No.");
$pdf->SetFont('Arial','',11); 
$pdf->SetXY(160, 68);  
$pdf->Write(0, $fetch_data['INVOICE_NUMBER']);
$pdf->SetXY(160, 76);  
$pdf->Write(0, date('d-m-Y',strtotime($fetch_data['INVOICE_DATE'])));
$pdf->SetXY(160, 84);  
$pdf->Write(0, $fetch_data['CUST_ORDER_NUMBER']);
$pdf->SetXY(160, 92);  
$pdf->Write(0, $fetch_data['ACCOUNT_REF']);
$pdf->SetXY(13, 111);  
$pdf->SetFont('Arial','B',10); 
$pdf->Write(0, "Quantity");
$pdf->SetXY(30, 111);  
$pdf->Write(0, "Details");
$pdf->SetXY(88, 111);  
$pdf->Write(0, "TML Ref:".$fetch_data['TML_Ref']);
$pdf->SetXY(142, 111);  
$pdf->Write(0, "Unit Price");
$pdf->SetXY(180, 111);  
$pdf->Write(0, "Total");
$pdf->SetFont('Arial','',10); 
$k=0;
foreach ($res as $key => $ls) {
       
$pdf->SetXY(15, 120+$k);  
$pdf->Write(0, number_format((float)$ls['QUANTITY'], 2, '.', ''));
$pdf->SetXY(30, 120+$k);  
$pdf->Write(0, $ls['DESCRIPTION']);
$pdf->SetXY(88, 120+$k);  
$pdf->Write(0, "");
$pdf->SetXY(143, 120+$k);  
//$pdf->Write(0, number_format((float)$ls['UNIT_PRICE'], 2, '.', ''));
$pdf->Cell(17,0,number_format((float)$ls['UNIT_PRICE'], 2, '.', ''),0,1,"R");
$pdf->SetXY(181, 120+$k);  
//$pdf->Write(0, number_format((float)$ls['UNIT_PRICE']*$ls['QUANTITY'], 2, '.', ''));
$pdf->Cell(12,0,number_format((float)$ls['UNIT_PRICE']*$ls['QUANTITY'], 2, '.', ''),0,1,"R");
if($ls['TAX_RATE']!='') {
      $tax_rate=$ls['TAX_RATE'];
      }
$k=$k+5;
}
$jobsite=explode(",",$fetch_data['job_site_address']);

$y=0;
for ($x=0; $x<sizeof($jobsite); $x++)
  {
    $pdf->SetXY(13, 245+$y);  
    $pdf->Write(0, ltrim($jobsite[$x]));
    $y=$y+5;
  } 
$pdf->SetXY(13, 273);  
$pdf->Write(0, "All Accounts Strictly 30 Days From Invoice Date");
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(126, 248);  
$pdf->Write(0, "Total Net Amount");
$pdf->SetXY(126, 256);  
$pdf->Write(0, "Vat ");
$pdf->SetXY(126, 264);  
$pdf->Write(0, "Invoice Total");
 $pdf->SetFont('Arial','',10);
 
  $pdf->SetXY(132, 256);  
$pdf->Write(0, "@ ".$tax_rate."%");
$pdf->SetXY(170, 248);  
//$pdf->Write(0, number_format((float)$fetch_data['INVOICE_NET'], 2, '.', ''));
$pdf->Cell(25,0,number_format((float)$fetch_data['INVOICE_NET'], 2, '.', ''),0,1,"R");
$pdf->SetXY(170, 256);  
//$pdf->Write(0, number_format((float)$fetch_data['INVOICE_GROSS']-$fetch_data['INVOICE_NET'], 2, '.', ''));
$pdf->Cell(25,0,number_format((float)$fetch_data['INVOICE_GROSS']-$fetch_data['INVOICE_NET'], 2, '.', ''),0,1,"R");
$pdf->SetXY(170, 264);  
//$pdf->Write(0, number_format((float)$fetch_data['INVOICE_GROSS'], 2, '.', ''));
$pdf->Cell(25,0,number_format((float)$fetch_data['INVOICE_GROSS'], 2, '.', ''),0,1,"R");

    
$pdf->Output();
    }



public function slip_list($invoice_id)
    {

    $ls1 = $this->Common_model->get_invoice_documents($invoice_id);
    $GUID = $ls1['GUID'];
    $ActRevision = $ls1['ActRevision'];
    /* Get data. */   
    $result = $this->Common_model->get_invoice_images($GUID,$ActRevision);

    //echo '<pre>';print_r($result);die;
       
       
            $start = 1;
            $cnt = 1;


    foreach ($result as $key => $row) {         

            $sub_id = $row['StorageRevLocationSubID'];
           if ($sub_id < 10)
                $s_path = '0000000' . $sub_id;
            elseif ($sub_id < 100)
                $s_path = '000000' . $sub_id;
            elseif ($sub_id < 1000)
                $s_path = '00000' . $sub_id;
            else
                $s_path = '0000' . $sub_id;
            

                $ext=explode('.',$row['sourcefileName']);

                $ext=explode('.',$row['sourcefileName']);           

            $path = "http://62.232.123.146:8081/WebImages/" . $s_path . "/" . $row['DocGUID'] . ".FDD/0000000" . $row['stroageRev'] . ".REV/Files/" . str_replace(' ', '%20', $row['sourcefileName']);
                $ext=explode('.',$row['sourcefileName']);
                if($ext[1]=='TIF') {
            $filename = WEB_ROOT_PATH."assets/invoice-img/image" . $invoice_id . $start . ".jpg";
                    
                    
            if (!file_exists($filename)) {             
        
               /* try {
                    // Saving every page of a TIFF separately as a JPG thumbnail
                    $images = new Imagick($path);
                    foreach ($images as $i => $image) {
                        // Providing 0 forces thumbnail Image to maintain aspect ratio
                        $image->thumbnailImage(768, 0);
                        $image->writeImage(WEB_ROOT_PATH."assets/invoice-img/image" . $invoice_id . $start . ".jpg");
                        //echo "<img src='image$start.jpg' alt='images' ></img>";
                    }
                    $images->clear();
                } catch (Exception $e) {
                    //echo $e->getMessage();
                }*/
            }
     
                if($ext[1]=='TIF') {
                    $fName = explode('/',$filename);
                }  else {
                    $fName = explode('/',$filename1);
                }
                                 
            //$convdt = date('d/m/Y', strtotime($row['ConvTktDate']));
                $output = "";

            $output.="<tr>
                                    
                                <td>" . $start . "</td>";
                                if($ext[1]=='TIF') {
                                $output.="<td><a class='popImg' onclick=\"return linkClick('$filename')\" style='cursor: pointer'><img width='100' height='100' src='$filename' style='height:160px !important; width:100px !important;'/></a> <font style='display:none;'>" . $path . " </font></td>";
                                $output.="<td> <a class='popImg' onclick=\"return linkClick('$filename')\" style='cursor: pointer'>View </a></td>";
                                
                            }  else {
                                    $output.="<td><a href='#'style='cursor: pointer' onclick = \"viewxls('$filename1');\"><img width='100' height='100' src='img/excel_icon.gif' style='height:100px !important; width:100px !important;'/> </a><font style='display:none;'>" . $path . " </font></td>";                            
                                $output.="<td> <a href='#'style='cursor: pointer' onclick = \"viewxls('$filename1');\">View </a></td>";
                                
                            }
                        
        $output.="<td style='text-align:right;'><input id='list_invoice_".$cnt."' type='checkbox' name='list_invoices[]' value='".$fName[1]."'></td>";
                        

            $output.="</tr>";
            } 
            $start++;
$cnt++;
       } 
     
    
    echo "success|" . $output;
    // PAGINATION - END



    }
	function generateRandomString($length = 12) {
		return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
}
?>