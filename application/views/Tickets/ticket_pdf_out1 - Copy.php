<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head> 
<body> 
<div style="width:100%;margin-bottom: 0px;margin-top: 0px;" >	
<div style="width:100%;float: left;font-size: 12px;" > 		
<center><img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['outpdf_header_logo']?>" width ="100">  </center> 
<b><?php echo $content['outpdf_title']; ?></b><br/> 		
<?php echo $content['outpdf_address']; ?><br/> 		
<b>Tel:</b> kdfjhskdjhfskjdhfksjhdfk  (Head Office)<br/> 		
<b>Email:</b> kdfjhskdjhfskjdhfksjhdfk <br/>		
<b>Web:</b>kdfjhskdjhfskjdhfksjhdfk   <br/><br/><br/>

<b>WASTE LICENSE NO.: <?php echo $content['waste_licence']; ?></b> <br/><br/>		
<b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b><br/>		<br/>		

<b>Ticket NO:</b> <?php echo $tickets['TicketNumber']; ?><br>		
<b>Date Time: </b><?php echo $tickets['tdate']; ?> <br><br>				

<b>Driver Name: </b> <?php echo $tickets['DriverName'];?><br>	 
<b>Vehicle Reg. No. </b><?php echo $tickets['RegNumber']; ?> <br>
<b>Haulier: </b> <?php echo $tickets['Hulller']; ?> <br>
<b>Driver Signature: </b> <br><img src="<?php echo $tickets1['driversignature1']; ?>" width ="90" height="90" style="float:left"><br>	 <br><br>	<br>	 		 
 </div>
 <div style="width:100%;float: left;font-size: 12px;" >
<b>Customer Name: </b> <?php echo $tickets1['CompanyName1']; ?> <br>		
<b>Site Address: </b> <?php echo $tickets['OpportunityName']; ?><br>		 		
<b>Material: </b> <?php echo $tickets['MaterialName']; ?> <br>
<b>SIC Code: </b> <?php echo $tickets['SicCode']; ?> <br><br>				

<b>Gross Weight: </b> <?php echo round($tickets['GrossWeight']); ?> KGs <br>		
<b>Tare Weight: </b> <?php echo round($tickets['Tare']); ?> KGs <br>		
<b>Net Weight: </b> <?php echo round($tickets['Net']); ?> KGs <br><br>		

<p style="font-size: 9px;"><?php echo $content['outpdf_para1']; ?> <br> 
<?php echo $content['outpdf_para1']; ?><br> 
<b><?php echo $content['outpdf_para1']; ?></b></p><br><br>

<br><br><br><br><br></div>
<div style="width:100%;float: left;font-size: 12px;" >
<b>Received By: </b> <br><img src="<?php echo $tickets1['driversignature1']; ?>" width ="90" height="90" style="float:left"><br><br><br><br><br><br><?php echo $tickets1['CompanyName1']; ?><br><br> <br>
<div style="font-size: 10px;"> 
<b>VAT Reg. No: </b> <?php echo $content['VATRegNo']; ?>    <br>
<b>Company Reg. No: </b><?php echo $content['CompanyRegNo']; ?><br>  
<?php echo $content['FooterText']; ?>  </div>
</div>  
</div></body></html> 