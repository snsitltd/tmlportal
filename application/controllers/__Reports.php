<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Reports (CompanyController)
 * User Class to control all user related operations.
 * @author : Pooja K
 * @version : 1.0
 * @since : 23 Oct 2018
 */
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
    

     public function index()
    {

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

        if($_POST){
            
             $customer = $this->input->post('customer');
             $material = $this->input->post('material');
             $searchdate = $this->input->post('searchdate');

             $search_array = array();

             $data['ticketsRecords'] = $this->Reports_model->get_tickets_report($searchdate,$customer,$material); 
 		 
             //echo $this->db->last_query();
             if(isset($_POST['export']))  {
                   $object = new PHPExcel();
                  // print_r($_POST); die;
                    $object->setActiveSheetIndex(0);

                    $table_columns = array("Ticket No","Ticket Title", "Ticket Date", "Conveyance","Company Name", "Driver Name", "Vechicle Reg No","Hauller"," Material Name","SIC Cod","Gross Weight","Tare","Net","Source of Material","Report Number","C.Meters");

                    $column = 0;

                    foreach($table_columns as $field)
                    {
                        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                        $column++;
                    }

                    $excel_row = 2;

                    foreach( $data['ticketsRecords'] as $row)
                    {
                        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TicketNo);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->TicketTitle);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->TicketDate);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->Conveyance);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->CompanyName);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->DriverName);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->RegNumber);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->Hulller );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->MaterialName );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->SicCode );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->GrossWeight );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->Tare );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->Net );  
                        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->SOM );  
                        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->Rnum );  
                        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->Cmeter );  

                        $excel_row++;
                    }

                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="Tocket Report.xls"');
                    $object_writer->save('php://output');
                     
             }
            
        }
        
        $data['contactsRecords'] = $this->contacts_model->contactsListing(); 
        $data['materialsRecords'] = $this->Common_model->get_all('materials');    
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Ticket Report';
        $this->global['active_menu'] = 'ticketreports';
        $this->loadViews("Reports/ticket", $this->global, $data, NULL);
    }
	public function tmlticket(){
        
        $data=array();

        if($_POST){
            
             $customer = $this->input->post('customer');
             $material = $this->input->post('material');
             $searchdate = $this->input->post('searchdate');

             $search_array = array();

             $data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report($searchdate,$customer,$material); 
 		 
		// var_dump($data['ticketsRecords']);
		// exit;
             //echo $this->db->last_query();
             if(isset($_POST['export']))  {
                   $object = new PHPExcel();
                  // print_r($_POST); die;
                    $object->setActiveSheetIndex(0);
					$data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report_export($searchdate,$customer,$material); 
                    $table_columns = array("Ticket No","TicketType", "Ticket Date", "Conveyance","Company Name", "Driver Name", "Vechicle Reg No","Hauller"," Material Name","SIC Cod","Gross Weight","Tare","Net","Source of Material","Report Number","C.Meters");

                    $column = 0;

                    foreach($table_columns as $field)
                    {
                        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                        $column++;
                    }

                    $excel_row = 2;

                    foreach( $data['ticketsRecords'] as $row)
                    {
                        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->TicketNo);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->TypeOfTicket	);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->TicketDate);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->Conveyance);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->CompanyName);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->DriverName);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->RegNumber);
                        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->Hulller );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->MaterialName );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->SicCode );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->GrossWeight );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->Tare );
                        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->Net );  
                        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->SOM );  
                        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->Rnum );  
                        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->Cmeter );  

                        $excel_row++;
                    }

                    $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="Tocket Report.xls"');
                    $object_writer->save('php://output');
                     
             }
			 
			 if(isset($_POST['export1']))  { 
			 
				$report = $this->input->post('report');
				if($report==2){ 
					$data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report_export_material($searchdate,$customer,$material); 
					$html=$this->load->view('Reports/tml_tickets_reports_pdf_material', $data, true);
				}else{
					$data['ticketsRecords'] = $this->Reports_model->get_tml_tickets_report_export($searchdate,$customer,$material); 
					$html=$this->load->view('Reports/tml_tickets_reports_pdf', $data, true);
				} 
						
				 //this the the PDF filename that user will get to download 
				 //load mPDF library
				$this->load->library('m_pdf'); 
			   //generate the PDF from the given html
				$this->m_pdf->pdf->AddPage('L'); // Adds a new page in Landscape orientation
				$this->m_pdf->pdf->WriteHTML($html); 
				//download it.
				$this->m_pdf->pdf->Output($data['ticketsRecords'][0]->TicketNo.".pdf", "D");  
                     
             }
            
        }
        
        $data['contactsRecords'] = $this->contacts_model->contactsListing(); 
        $data['materialsRecords'] = $this->Common_model->get_all('materials');    
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : TML Ticket Report';
        $this->global['active_menu'] = 'tmlreports';
        $this->loadViews("Reports/tmlticket", $this->global, $data, NULL);
    }
     public function tmlreports(){
    
        if($_POST){
       
             $data=array();            
           
             $searchdate = $this->input->post('searchdate');
             $searchdates= explode('-', $searchdate);
             $firstDate = $data['firstDate'] = date('Y-m-d',strtotime($searchdates[0]));
             $SecondDate = $data['SecondDate'] = date('Y-m-d',strtotime($searchdates[1]));  

            $this->db->select('m.*,count(t.TicketNo) as total_count,sum(t.Net) as total_net');
            $this->db->from('materials as m');
            $this->db->join('tickets as t', 't.MaterialID = m.MaterialID');               
            $this->db->where('DATE(t.CreateDate) >=', $firstDate);
            $this->db->where('DATE(t.CreateDate) <=', $SecondDate);           
            $this->db->group_by(array("t.MaterialID", "t.TypeOfTicket")); 
            $query = $this->db->get();        
            $data['resultmaterials'] = $query->result();

            //echo '<pre>';print_r($data['resultmaterials']);die;


            foreach ($data['resultmaterials'] as  $key => $materials) {

            $this->db->select('c.*,count(t.TicketNo) as total_count,sum(t.Net) as total_net');
            $this->db->from('company as c');
            $this->db->join('tickets as t', 't.CompanyID = c.CompanyID');               
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
   /*  public function tippedReports(){
    
        if($_POST){
       
             $data=array();           
           
             $searchdate = $this->input->post('searchdate');
             $material= $this->input->post('material'); 


            $searchdates= explode('-', $searchdate);
            $firstDate = $data['firstDate'] = date('Y-m-d',strtotime($searchdates[0]));
            $SecondDate = $data['SecondDate'] = date('Y-m-d',strtotime($searchdates[1]));       
           
            //SELECT tbl_company.* from tbl_company join tbl_tickets on tbl_tickets.CompanyID = tbl_company.CompanyID GROUP BY tbl_tickets.CompanyID 
            $this->db->select('c.*,count(t.TicketNo) as total_count,sum(t.Net) as total_net');
            $this->db->from('company as c');
            $this->db->join('tickets as t', 't.CompanyID = c.CompanyID');               
            $this->db->where('DATE(t.CreateDate) >=', $firstDate);
            $this->db->where('DATE(t.CreateDate) <=', $SecondDate); 
            $this->db->group_by('t.CompanyID');
            $query = $this->db->get();        
            $data['resultcompany'] = $query->result(); 

            foreach ($data['resultcompany'] as  $key => $company) {

            $this->db->select('m.*,count(t.TicketNo) as total_count,sum(t.Net) as total_net');
            $this->db->from('materials as m');
            $this->db->join('tickets as t', 't.MaterialID = m.MaterialID');               
            $this->db->where('DATE(t.CreateDate) >=', $firstDate);
            $this->db->where('DATE(t.CreateDate) <=', $SecondDate); 
            $this->db->where("t.CompanyID", $company->CompanyID);
            $this->db->group_by('t.MaterialID');
            $query1 = $this->db->get();        
            $resultmaterials = $query1->result();
            $data['resultcompany'][$key]->resultmaterials =  $resultmaterials;                           
                       
            }

          
              $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Tipped Reports';
              $this->global['active_menu'] = 'ticketreports';
              $html=$this->load->view('Reports/tipped_pdf', $data, true); 

                $this->load->library('m_pdf');

               // //generate the PDF from the given html
                $this->m_pdf->pdf->WriteHTML($html);
                 
               //  //download it.
                $this->m_pdf->pdf->Output($pdfFilePath, "D");

             
        }
        $data['materialsRecords'] = $this->Common_model->get_all('materials');
        $this->global['pageTitle'] = WEB_PAGE_TITLE.' : Invoice List';       
        $this->global['active_menu'] = 'ticketreports';
        $this->loadViews("Reports/tippedReports", $this->global,$data, NULL);
    } */ // Nilay 
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

         if($this->isView == 0)
        {
            $data = array();
            $this->global['pageTitle'] = 'Error';             
            $this->loadViews("permission", $this->global, $data, NULL);
        }
        else
        {
        $data=array();  
        
             //$Operation = $this->input->post('Operation');
             $data['materialsRecords'] = $this->Common_model->select_all_with_where_result('materials',array("Operation"=>'IN')); 
  

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

        $ticketNo= $this->uri->segment(2);
        $data['ticketsDetail'] = $this->Reports_model->get_tickets_details($ticketNo);
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
}
?>