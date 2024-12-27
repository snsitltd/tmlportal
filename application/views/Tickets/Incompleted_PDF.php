<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
<style type="text/css"> 
	#block{
    	width:100%; 
		margin-left: 90px;
		margin-right: 100px;
		font-size: 14px;
    }  
</style>
</head>
<body>
<table>
	<tr>
		<td width="100"><img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['logo']?>" width ="100"> </td>
		<td width="270" style="font-size: 14px;"><?php echo $content['address']; ?> <br/>
	             <b>Tel:</b>  <?php echo $content['phone']; ?> (Head Office)<br/> 
	             <b>Email:</b> <?php echo $content['email']; ?> <br/>
	             <b>Web:</b> <?php echo $content['website']; ?>  
		</td>
		<td width="20"></td>
		<td><span style="font-weight: bold;font-size: 18px;color: #319CEB"><?php echo $content['head1'];?></span><br/><br/>
			<span style="font-weight: bold;font-size: 13px;color: #319CEB"><?php echo $content['head2'];?></span></td>
	</tr>
	<tr ><td colspan="4" height="20"></td></tr>
	<tr ><td colspan="4" style="font-size: 14px;"><b>WASTE LICENSE No. <?php echo $content['waste_licence']; ?></b></td></tr>
	<tr ><td colspan="4" style="font-size: 14px;"><b>PERMIT REFERENCE NO: <?php echo $content['reference'];?></b></td></tr>
	<tr ><td colspan="4" height="20"></td></tr>
	<tr ><td colspan="4" style="font-size: 20px;text-align: center;" align="center"><b>OFFICE COPY</b>
</td></tr> 
</table> 
<br><br>
<table border="1"  cellspacing="0" >
<tr><td>
<table border="0">
	<tr>
		<td width="140" style="font-size: 13px;" ><b>Disposal Ticket No : </b></td>
		<td width="130" style="font-size: 18px;" ><?php echo $tickets['TicketNumber']; ?></td>
		<td width="170" style="font-size: 13px;" ><b>Driver's Name:</b></td>
		<td width="240"  style="font-size: 12px;" ><?php echo $tickets['DriverName'];?></td>
	</tr> 
	<tr ><td colspan="4" height="20"></td></tr>
	<tr>
		<td style="font-size: 13px;" ><b>Date & Time : </b></td>
		<td style="font-size: 12px;" ><?php echo $tickets['tdate']; ?></td>
		<td style="font-size: 13px;" ><b>Driver Signature :</b></td>
		<td style="font-size: 12px;" height="100" ><img src="<?php echo $tickets['driversignature']; ?>" width ="230" height="100"> </td>
	</tr> 
	<tr ><td colspan="4" height="20"></td></tr>
	<tr>
		<td style="font-size: 13px;" ><b>Conveyance Note :</b></td>
		<td style="font-size: 12px;" ><?php echo $tickets['Conveyance']; ?></td>
		<td style="font-size: 13px;" ><b>Vehicle Registration No.</b></td>
		<td style="font-size: 12px;" ><?php echo $tickets['RegNumber']; ?></td>
	</tr>  
</table>
</td></tr>
</table>  
<?php 
$LT = '';
if($tickets['LorryType'] == 1) { $LT = 'Tipper'; }
else if($tickets['LorryType'] == 2) { $LT = 'Grab'; }
else if($tickets['LorryType'] == 3) { $LT = 'Bin'; }
else{ $LT = ''; }
 ?> 
<div style="width:100%;margin-bottom: 20px;margin-top: 20px;" >
	<div style="width:70%;float: left;font-size: 14px;" > 
		<b>Customer Name : </b> <?php echo $tickets['CompanyName']; ?> <br><br>
		<b>Haulier Reg. No :  </b> <?php echo $tickets['Hulller']; ?> <br><br>
		<b>Description of Material:</b> <br> <?php echo $tickets['MaterialName']." ".$LT; ?> , <?php echo $tickets['TypeOfTicket']; ?>
	</div> 
	<div  style="width:25%;float: right;font-size: 14px;text-align:center;"> 
		<div style="width:100%;margin-bottom:5px;" ><b>Weight in KGs</b></div>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:30%;float: left;font-size: 14px;text-align:left;" ><b>GROSS</b></div>
			<div style="width:65%;float: right;font-size: 14px;text-align:right;" ><?php echo round($tickets['GrossWeight']); ?></div>
		</div>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:30%;float: left;font-size: 14px;text-align:left;" ><b>TARE</b></div>
			<div style="width:65%;float: right;font-size: 14px;text-align:right;" ><?php echo round($tickets['Tare']); ?></div>
		</div>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:30%;float: left;font-size: 14px;text-align:left;" ><b>NET</b></div>
			<div style="width:65%;float: right;font-size: 14px;text-align:right;" ><?php echo round($tickets['Net']); ?></div>
		</div> 
	</div>
</div> 

<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:50%;float: left;font-size: 14px;" ><b>Site Address</b></div> 
	<div  style="width:50%;float: right;font-size: 14px;text-align:center;"><?php if($tickets['PaymentType']!=0){  ?> <b>Payments</b> <?php } ?></div>
</div> 
<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:60%;float: left;font-size: 12px;" ><?php echo $tickets['OpportunityName']; ?> </div> 
	<div  style="width:40%;float: right;font-size: 12px;">
		<?php if($tickets['PaymentType']!=0){  ?>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>Payment Type</b></div> 
			<div  style="width:60%;float: right;"><?php if($tickets['PaymentType']==0){ echo "CREDIT"; } ?>
			<?php if($tickets['PaymentType']==1){ echo "CASH"; } ?>
			<?php if($tickets['PaymentType']==2){ echo "CARD"; } ?></div>
		</div> 
		<?php if($tickets['PaymentType']==2){?>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>REF NO.</b></div> 
			<div  style="width:60%;float: right;"><?php echo $tickets['PaymentRefNo']; ?></div>
		</div> 
		<?php } ?>	
		
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>Amount</b></div> 
			<div  style="width:60%;float: right;">&pound;<?php echo $tickets['Amount']; ?></div>
		</div> 
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>VAT (<?php echo $tickets['Vat']; ?>%) </b></div> 
			<div  style="width:60%;float: right;">&pound;<?php echo $tickets['VatAmount']; ?></div>
		</div> 
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>Total Amount</b></div> 
			<div  style="width:60%;float: right;">&pound;<?php echo $tickets['TotalAmount']; ?></div>
		</div>  
		<?php } ?> 
	</div>
</div>  

<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:100%;float: left;font-size: 14px;" ><b>SIC CODE :</b> <?php echo $tickets['SicCode']; ?></div>  
</div> 

<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:100%;float: left;font-size: 14px;" ><b>Checked By :</b> Machine Driver</div>  
</div> 
<?php if($tickets['TypeOfTicket']=="In"){ ?>
<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:100%;float: left;font-size: 14px;" ><b>Notes:</b> <?php echo $tickets['ticket_notes'];?></div>  
</div> 
<?php } ?> 
<div style="width:100%;float: right;font-size: 12px;margin-bottom: 20px;margin-top: 20px;" >  
<div style="width:50%;float: right;" > 
	<div style="width:100%;float: right;text-align:right"  ><b>VAT Reg. No: </b> <?php echo $content['VATRegNo']; ?>  </div>
	<div style="width:100%;float: right;text-align:right" ><b>Company Reg. No: </b> <?php echo $content['CompanyRegNo']; ?>  </div>
	<div style="width:100%;float: right;text-align:right" ><?php echo $content['FooterText']; ?></div>
</div> 
</div> 
  
<pagebreak>
<table>
	<tr>
		<td width="100"><img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['logo']?>" width ="100"></td>
		<td width="270" style="font-size: 14px;"><?php echo $content['address']; ?> <br/>
	             <b>Tel:</b>  <?php echo $content['phone']; ?> (Head Office)<br/> 
	             <b>Email:</b> <?php echo $content['email']; ?> <br/>
	             <b>Web:</b> <?php echo $content['website']; ?>  
		</td>
		<td width="20"></td>
		<td><span style="font-weight: bold;font-size: 18px;color: #319CEB"><?php echo $content['head1'];?></span><br/><br/>
			<span style="font-weight: bold;font-size: 13px;color: #319CEB"><?php echo $content['head2'];?></span></td>
	</tr>
	<tr ><td colspan="4" height="20"></td></tr>
	<tr ><td colspan="4" style="font-size: 14px;"><b>WASTE LICENSE No. <?php echo $content['waste_licence']; ?></b></td></tr>
	<tr ><td colspan="4" style="font-size: 14px;"><b>PERMIT REFERENCE NO: <?php echo $content['reference'];?></b></td></tr>
	<tr ><td colspan="4" height="20"></td></tr>
	<tr ><td colspan="4" style="font-size: 20px;text-align: center;" align="center"><b>SITE COPY</b>
</td></tr> 
</table> 
<br><br>
<table border="1"  cellspacing="0" >
<tr><td>
<table border="0">
	<tr>
		<td width="140" style="font-size: 13px;" ><b>Disposal Ticket No : </b></td>
		<td width="130" style="font-size: 18px;" ><?php echo $tickets['TicketNumber']; ?></td>
		<td width="170" style="font-size: 13px;" ><b>Driver's Name:</b></td>
		<td width="240"  style="font-size: 12px;" ><?php echo $tickets['DriverName'];?></td>
	</tr> 
	<tr ><td colspan="4" height="20"></td></tr>
	<tr>
		<td style="font-size: 13px;" ><b>Date & Time : </b></td>
		<td style="font-size: 12px;" ><?php echo $tickets['tdate']; ?></td>
		<td style="font-size: 13px;" ><b>Driver Signature :</b></td>
		<td style="font-size: 12px;" ><img src="<?php echo $tickets['driversignature']; ?>" width ="230" height="100"> </td>
	</tr> 
	<tr ><td colspan="4" height="20"></td></tr>
	<tr>
		<td style="font-size: 13px;" ><b>Conveyance Note :</b></td>
		<td style="font-size: 12px;" ><?php echo $tickets['Conveyance']; ?></td>
		<td style="font-size: 13px;" ><b>Vehicle Registration No.</b></td>
		<td style="font-size: 12px;" ><?php echo $tickets['RegNumber']; ?></td>
	</tr>  
</table>
</td></tr>
</table> 
<div style="width:100%;margin-bottom: 20px;margin-top: 20px;" >
	<div style="width:70%;float: left;font-size: 14px;" > 
		<b>Customer Name : </b> <?php echo $tickets['CompanyName']; ?> <br><br>
		<b>Haulier Reg. No :  </b> <?php echo $tickets['Hulller']; ?> <br><br>
		<b>Description of Material:</b> <br> <?php echo $tickets['MaterialName']; ?>, <?php echo $tickets['TypeOfTicket']; ?>
	</div> 
	<div  style="width:25%;float: right;font-size: 14px;text-align:center;"> 
		<div style="width:100%;margin-bottom:5px;" ><b>Weight in KGs</b></div>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:30%;float: left;font-size: 14px;text-align:left;" ><b>GROSS</b></div>
			<div style="width:65%;float: right;font-size: 14px;text-align:right;" ><?php echo round($tickets['GrossWeight']); ?></div>
		</div>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:30%;float: left;font-size: 14px;text-align:left;" ><b>TARE</b></div>
			<div style="width:65%;float: right;font-size: 14px;text-align:right;" ><?php echo round($tickets['Tare']); ?></div>
		</div>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:30%;float: left;font-size: 14px;text-align:left;" ><b>NET</b></div>
			<div style="width:65%;float: right;font-size: 14px;text-align:right;" ><?php echo round($tickets['Net']); ?></div>
		</div> 
	</div>
</div> 

<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:50%;float: left;font-size: 14px;" ><b>Site Address</b></div> 
	<div  style="width:50%;float: right;font-size: 14px;text-align:center;"><?php if($tickets['PaymentType']!=0){  ?> <b>Payments</b> <?php } ?></div>
</div> 
<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:60%;float: left;font-size: 12px;" ><?php echo $tickets['OpportunityName']; ?> </div> 
	<div  style="width:40%;float: right;font-size: 12px;">
		<?php if($tickets['PaymentType']!=0){  ?>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>Payment Type</b></div> 
			<div  style="width:60%;float: right;"><?php if($tickets['PaymentType']==0){ echo "CREDIT"; } ?>
			<?php if($tickets['PaymentType']==1){ echo "CASH"; } ?>
			<?php if($tickets['PaymentType']==2){ echo "CARD"; } ?></div>
		</div> 
		<?php if($tickets['PaymentType']==2){?>
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>REF NO.</b></div> 
			<div  style="width:60%;float: right;"><?php echo $tickets['PaymentRefNo']; ?></div>
		</div> 
		<?php } ?>	
		
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>Amount</b></div> 
			<div  style="width:60%;float: right;">&pound;<?php echo $tickets['Amount']; ?></div>
		</div> 
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>VAT (<?php echo $tickets['Vat']; ?>%) </b></div> 
			<div  style="width:60%;float: right;">&pound;<?php echo $tickets['VatAmount']; ?></div>
		</div> 
		<div style="width:100%;margin-bottom: 5px;" >
			<div style="width:35%;float: left;" ><b>Total Amount</b></div> 
			<div  style="width:60%;float: right;">&pound;<?php echo $tickets['TotalAmount']; ?></div>
		</div>  
		<?php } ?> 
	</div>
</div>  

<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:100%;float: left;font-size: 14px;" ><b>SIC CODE :</b> <?php echo $tickets['SicCode']; ?></div>  
</div> 

<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:100%;float: left;font-size: 14px;" ><b>Checked By :</b> Machine Driver</div>  
</div> 
<?php if($tickets['TypeOfTicket']=="In"){ ?>
<div style="width:100%;margin-bottom: 10px;" >
	<div style="width:100%;float: left;font-size: 14px;" ><b>Notes:</b> <?php echo $tickets['ticket_notes'];?></div>  
</div> 
<?php } ?> 

<div style="width:100%;float: right;font-size: 12px;margin-bottom: 20px;margin-top: 20px;" >  
<div style="width:50%;float: right;" > 
	<div style="width:100%;float: right;text-align:right"  ><b>VAT Reg. No: </b> <?php echo $content['VATRegNo']; ?>  </div>
	<div style="width:100%;float: right;text-align:right" ><b>Company Reg. No: </b> <?php echo $content['CompanyRegNo']; ?>  </div>
	<div style="width:100%;float: right;text-align:right" ><?php echo $content['FooterText']; ?></div>
</div> 
</div>   
</body>
</html> 