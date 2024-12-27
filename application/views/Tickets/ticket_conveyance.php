<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php 
$html = '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head><body> 
<div style="width:100%;margin-bottom: 0px;margin-top: 0px;" >	
	<div style="width:100%; font-size: 11px;" >
		<div style="width:30%;float: left;font-size: 11px;" > 		
			<img src="'.site_url().'assets/Uploads/Logo/'.$PDFContent[0]->logo.'" width ="80"> 
		</div>
		<div style="width:70%;float: right;font-size: 11px;" > 		 
			<b>'.$PDFContent[0]->outpdf_title.'</b><br/> 		
			'.$PDFContent[0]->address.' <br/>		
		</div>
	</div>	
	<div style="width:100%;float: left;font-size: 11px;" >  
		<b>Phone:</b> '.$PDFContent[0]->phone.'<br/> 		
		<b>Email:</b> '.$PDFContent[0]->email.' <br/>		
		<b>Web:</b> '.$PDFContent[0]->website.' <br/><br/>		 
		<b>'.$PDFContent[0]->head1.'</b><br/><br/> 
		<b>WASTE LICENSE NO.: '.$PDFContent[0]->waste_licence.'</b> <br/> 
		<b>PERMIT REFERENCE NO: '.$PDFContent[0]->reference.'</b> <br/><br/>
		<b>CONVEYANCE NOTE </b> <br/>
		<b>Conveyance Note No:</b> '.$dataarr[0]->ConveyanceNo.'<br>		
		<b>Date Time: </b>'.date("d-m-Y H:i").' <br>		 
		<b>Company Name: </b> '.$dataarr[0]->CompanyName.' <br>		
		<b>Site Address: </b> '.$dataarr[0]->OpportunityName.'<br>		 		
		<b>Tip Address: </b> '.$tipadQRY['Street1'].' '.$tipadQRY['Street2'].' '.$tipadQRY['Town'].' '.$tipadQRY['County'].' '.$tipadQRY['PostCode'].'<br>		 		 
		<b>Material: </b> '.$MaterialnameQRY['MaterialName'].'  <br> 
		<b>Driver Name: </b> '.$user['DriverName'].'<br>	 
		<b>Vehicle Reg. No. </b> '.$user['RegNumber'].'  <br>    
	</div>
	<div style="width:100%;float: left;font-size: 11px;" >
		<b>Received By: </b><br>
		<div><img src="'.base_url().'/uploads/Signature/'.$SignatureUploadfile_name.'" width ="90" height="60" style="float:left"></div><br>
		'.$CustomerName.'<br><br>
		<div style="font-size: 10px;"> 
			<b>VAT Reg. No: </b> '.$PDFContent[0]->VATRegNo.' <br>
			<b>Company Reg. No: </b> '.$PDFContent[0]->CompanyRegNo.' <br>  
			'.$PDFContent[0]->FooterText.'  
		</div>
	</div>  
</div></body></html>';


 ?>

<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"></head> 
<body> 
<div style="width:100%;margin-bottom: 0px;margin-top: 0px;" >	
	<div style="width:100%; font-size: 11px;" >
		<div style="width:30%;float: left;font-size: 11px;" > 		
			<img src="<?php echo site_url().'assets/Uploads/Logo/'.$PDFContent[0]->logo; ?>" width ="80"> 
		</div>
		<div style="width:70%;float: right;font-size: 11px;" > 		 
			<b><?php echo $content['outpdf_title']; ?></b><br/> 		
			<?php echo $content['outpdf_address']; ?> <br/>		
		</div>
	</div>	
	<div style="width:100%;float: left;font-size: 11px;" >  
		<b>Phone:</b> <?php echo $content['outpdf_phone']; ?><br/> 		
		<b>Email:</b> <?php echo $content['outpdf_email']; ?> <br/>		
		<b>Web:</b> <?php echo $content['outpdf_website']; ?> <br/><br/>		 
		<b>ALL MATERIALS ARE PRODUCED IN ACCORDANCE WITH WRAP PROTOCOL CONSIGNOR CONFIRMS THAT THE WASTE HIERARCHY HAS BEEN APPLIED</b><br/><br/> 
		<b>WASTE LICENSE NO.: <?php echo $content['waste_licence']; ?></b> <br/> 
		<b>PERMIT REFERENCE NO: <?php echo $content['waste_licence']; ?></b> <br/><br/>
		<b>CONVEYANCE NOTE </b> <br/>
		<b>Conveyance Note No:</b> <?php echo $tickets['TicketNumber']; ?><br>		
		<b>Date Time: </b><?php echo $tickets['tdate']; ?> <br>		 
		<b>Company Name: </b> <?php echo $tickets1['CompanyName1']; ?> <br>		
		<b>Site Address: </b> <?php echo $tickets['OpportunityName']; ?><br>		 		
		<b>Tip Address: </b> <?php echo $tickets['OpportunityName']; ?><br>		 		 
		<b>Material: </b> <?php echo $tickets['MaterialName']; ?> <br> 
		<b>Driver Name: </b> <?php echo $tickets['DriverName'];?><br>	 
		<b>Vehicle Reg. No. </b><?php echo $tickets['RegNumber']; ?> <br>   
		
	</div>
	<div style="width:100%;float: left;font-size: 11px;" >
		<b>Received By: </b><br>
		<div><img src="<?php echo $tickets1['driversignature1']; ?>" width ="90" height="60" style="float:left"></div><br>
		<?php echo $tickets1['CompanyName1']; ?><br><br>
		<div style="font-size: 10px;"> 
			<b>VAT Reg. No: </b> <?php echo $content['VATRegNo']; ?>    <br>
			<b>Company Reg. No: </b><?php echo $content['CompanyRegNo']; ?><br>  
			<?php echo $content['FooterText']; ?>  
		</div>
	</div>  
</div>
</body>
</html> 