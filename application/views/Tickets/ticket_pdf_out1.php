<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head> 
<body> 
<div style="width:100%;margin-bottom: 0px;margin-top: 0px; font-size: 10px;" >	
	<div style="width:100%;" >
		<div style="width:35%;float: left;" > 		
			<img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['outpdf_header_logo']?>" width ="80" > 
		</div>
		<div style="width:65%;float: right;text-align: right;" > 		 
			<b><?php echo $content['outpdf_title']; ?></b><br/> 		
			<?php echo $content['outpdf_address']; ?> <br/> 		
			<b>Phone:</b> <?php echo $content['outpdf_phone']; ?>
		</div>
	</div>	
	<div style="width:100%;float: left;" >   
		<b>Email:</b> <?php echo $content['outpdf_email']; ?> <br/>		
		<b>Web:</b> <?php echo $content['outpdf_website']; ?> <br/>		
		<b>Waste License No: </b> <?php echo $content['waste_licence']; ?> <br/><hr>
		<center><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></center><br/> 
		<b>Ticket NO:</b> <?php echo $tickets['TicketNumber']; ?><br>		
		<b>Date Time: </b><?php echo $tickets['tdate']; ?> <br>		 
		<b>Driver Name: </b> <?php echo $tickets['DriverName'];?><br>	 
		<b>Vehicle Reg. No. </b><?php echo $tickets['RegNumber']; ?> <br>
		<b>Haulier: </b> <?php echo $tickets['Hulller']; ?> <br>
		<b>Driver Signature: </b> <br>
		<div><img src="<?php echo $tickets1['ds']; ?>" width ="100" height="40" style="float:left"> </div>  <br> 
		<b>Company Name: </b> <?php echo $tickets['CompanyName']; ?> <br>		
		<b>Site Address: </b> <?php echo $tickets['OpportunityName']; ?><br>		 		
		<b>Material: </b> <?php echo $tickets['MaterialName']; ?> <br>
		<b>SIC Code: </b> <?php echo $tickets['SicCode']; ?> <br>
		<b>Gross Weight: </b> <?php echo round($tickets['GrossWeight']); ?> KGs <br>		
		<b>Tare Weight: </b> <?php echo round($tickets['Tare']); ?> KGs <br>		
		<b>Net Weight: </b> <?php echo round($tickets['Net']); ?> KGs <br>
		<p style="font-size: 8px;"><?php echo $content['outpdf_para1']; ?> <br> 
		<?php echo $content['outpdf_para2']; ?><br> 
		<b><?php echo $content['outpdf_para3']; ?></b></p> 
	</div>
	<div style="width:100%;float: left;" >
		<b>Received By: </b><br>
		<div><img src="<?php echo $tickets1['driversignature1']; ?>" width ="100" height="40" style="float:left"></div>
		<?php echo $tickets1['CompanyName1']; ?>
		<p style="font-size: 8px;"><b><?php echo $content['outpdf_para4']; ?></b><br><br> 
			<b>VAT Reg. No: </b> <?php echo $content['VATRegNo']; ?>    <br> 
			<b>Company Reg. No: </b><?php echo $content['CompanyRegNo']; ?><br>   
			<?php echo $content['FooterText']; ?>  
		</p> 
	</div>  
</div>
</body>
</html> 