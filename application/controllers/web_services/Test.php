<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH.'/third_party/mpdf/mpdf.php';
// Load the Rest Controller library
require APPPATH . '/libraries/REST_Controller.php';

class Test extends REST_Controller {
    public function __construct() { 
        parent::__construct();
        // Load the model
        //$this->load->model('Common_model');
        $this->load->database();
    }
     public function dd_post(){
         $data1['tickets'] = $this->Common_model->get_pdf_data(1); 
         $data1['tickets'] = array(
        						    "driversignature1"=>base_url().'uploads/Signature/'.$dataarr[0]->DriverSign,
        						    "CompanyName1"=>$dataarr[0]->CustomerName,
        						    );
         print_r($data1['tickets']); print_r($data1['tickets1']); exit();
         $loadNo = $this->db->query("select * from tbl_booking where BookingID = '1'");
         $Materi = $loadNo->row_array();
          //$creatDatess = $Materi['CreateDateTime'];
          $creatDatess = '2020-09-01 14:08:27';
         $today = date('Y-m-d H:s:i');
         
         $date_diff = abs(strtotime($creatDatess) - strtotime($today));
        
        $years = floor($date_diff / (365*60*60*24));
        $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        echo $days;
        
        if($days<=5){
            echo "yy";
        }else{
            echo "nn";
        }
        
        $TickIDQRY = $this->db->query("select TicketNo from  tbl_tickets where LoadID = '1'");
                            $TickIDQRY = $TickIDQRY->row_array();
                            
                            if(count($TickIDQRY) > 0){ 
                                $ticketId = $TickIDQRY['TicketNo'];
                                $TicketID = $TickIDQRY['TicketNo'];
                            } else {  $TicketID = '0'; }
                            
                            echo $TicketID;
     }
    
    public function pdf_post(){
        echo "efe";
        exit();
      $ticketId = 1;  
      $TicketUniqueID = 'QCY83JS9GRP7';
        $conditions = array(
'TicketNo' => $ticketId
);

//$data['content'] = $this->Common_model->select_where('content_settings',array('id' => 1));
//$data['tickets'] = $this->Common_model->get_pdf_data($ticketId);

$PDFContentQRY = $this->db->query("select * from tbl_content_settings where id = '1'");
$PDFContent = $PDFContentQRY->result();
//$PDFContent = $PDFContentQRY->row_array();
print_r($PDFContent); 
//echo $PDFContent[0]->logo;
exit;

//$html=$this->load->view('Tickets/ticket_pdf', $data, true);
$html='<table>
	<tr>
		<td width="100"><img src="'.site_url().'assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="100"> </td>
		<td width="270" style="font-size: 14px;">'.$PDFContent[0]->address.'<br/>
	             <b>Tel:</b> '.$PDFContent[0]->phone.' (Head Office)<br/> 
	             <b>Email:</b> '.$PDFContent[0]->email.' <br/>
	             <b>Web:</b> '.$PDFContent[0]->website.'  
		</td>
		<td width="20"></td>
		<td><span style="font-weight: bold;font-size: 18px;color: #319CEB">'.$PDFContent[0]->head1.'</span><br/><br/>
			<span style="font-weight: bold;font-size: 13px;color: #319CEB">'.$PDFContent[0]->head2.'</span></td>
	</tr>
	<tr ><td colspan="4" height="20"></td></tr>
	<tr ><td colspan="4" style="font-size: 14px;"><b>WASTE LICENSE No. '.$PDFContent[0]->waste_licence.'</b></td></tr>
	<tr ><td colspan="4" style="font-size: 14px;"><b>PERMIT REFERENCE NO: '.$PDFContent[0]->reference.'</b></td></tr>
	<tr ><td colspan="4" height="20"></td></tr>
	<tr ><td colspan="4" style="font-size: 20px;text-align: center;" align="center"><b>Conveyance Note</b>
</td></tr> 
</table> 
<table>
    <tr>
        <th>Conveyance Ticket no</th>
        <td>Conveyance Ticket no</td>
    </tr>
    <tr>
        <th>DATE TIME</th>
        <td>CDATE TIME</td>
    </tr>
    <tr>
        <th>company name</th>
        <td>company name</td>
    </tr>
    <tr>
        <th>Site Address</th>
        <td>Site Address</td>
    </tr>
    <tr>
        <th>Material </th>
        <td>Material </td>
    </tr>
    <tr>
        <th>Driver Name</th>
        <td>Driver Name</td>
    </tr>
    <tr>
        <th>Vehicle Reg no</th>
        <td>Vehicle Reg no</td>
    </tr>
    <tr>
        <th>Customer Name</th>
        <td>Customer Name</td>
    </tr>
    
</table>
';

//this the the PDF filename that user will get to download
$pdfFilePath = WEB_ROOT_PATH."assets/conveyance/".$TicketUniqueID.".pdf";
$openPath = "/assets/conveyance/".$TicketUniqueID.".pdf";

$mpdf =  new mPDF('utf-8', array(76,236));
        $mpdf->keep_table_proportions = false;
        $mpdf->WriteHTML($html);
        $mpdf->Output($pdfFilePath);
        $status = "0";
        $message ='Booking data not found.';
        $data = [];
        $this->response([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], REST_Controller::HTTP_OK);   
    }
}