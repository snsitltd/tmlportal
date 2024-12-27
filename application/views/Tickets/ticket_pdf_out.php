<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"> 
</head>
<body>
<table>
	<tr>
		<td width="350"><img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['outpdf_header_logo']?>" width ="150"><br><br>
		<span style="font-size: 16px;"><b>WASTE LICENSE No. <?php echo $content['waste_licence']; ?></span></b>   
		</td>
		<td width="500" style="font-size: 12px;" align="right"> 
			<table>
			<tr><td style="font-size: 40px;"><b><?php echo $content['outpdf_title']; ?></b></td></tr>
			<tr><td style="font-size: 16px;"><?php echo $content['outpdf_address']; ?><br/>
					<b>Tel:</b>  <?php echo $content['outpdf_phone']; ?> (Head Office)<br/> 
					<b>Email:</b> <?php echo $content['outpdf_email']; ?> <br/>
					<b>Web:</b> <?php echo $content['outpdf_website']; ?>   
				</td>			 
			</tr>
			</table> 
		</td> 
	</tr>
	<tr ><td colspan="2" height="20"></td></tr>
	<tr ><td colspan="2" style="font-size: 18px;text-align: center;"><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></td></tr>
	<tr ><td colspan="2" height="20"></td></tr>
	<tr ><td colspan="2" style="font-size: 20px;text-align: center;" align="center"><b>OFFICE COPY</b>
</td></tr> 
</table> 
<br> 
<table border="0">
	<tr>
		<td width="170" style="font-size: 16px;" ><b>Date & Time : </b></td>
		<td width="150" style="font-size: 16px;" ><b>Vehicle Reg. No.</b></td>
		<td width="150" style="font-size: 16px;" ><b>Driver Name</b></td>
		<td width="280"  > </td>
	</tr> 
	<tr ><td colspan="4" height="10"></td></tr>
	<tr>
		<td style="font-size: 16px;" ><?php echo $tickets['tdate']; ?></td>
		<td style="font-size: 16px;" ><?php echo $tickets['RegNumber']; ?></td>
		<td style="font-size: 16px;" ><?php echo $tickets['DriverName'];?></td> 
		<td style="font-size: 16px;" > <img src="<?php echo $tickets['driversignature']; ?>" width ="250" height="50" style="float:right"> </td> 
	</tr>  
</table> 
<br><br>  
<table border="0">
	<tr>
		<td width="150" style="font-size: 16px;" ><b>Customer Name :</b></td>
		<td width="300" style="font-size: 16px;" ><?php echo $tickets['CompanyName']; ?></td> 
		<td width="150" style="font-size: 16px;" ><b>Haulier :  </b></td>
		<td width="250" style="font-size: 16px;" ><?php echo $tickets['Hulller']; ?></td>  
	</tr> 
	<tr ><td height="20"colspan="4"></td></tr>  
	<tr ><td colspan="4" style="font-size: 16px;"><b>Site Address:</b> <?php echo $tickets['OpportunityName']; ?> </td></tr> 
</table>  
<br>
<?php 
$LorryType = 0; 
if($tickets['LorryType']!=0){ $LorryType = $tickets['LorryType']; }else{  $LorryType = $tickets['LorryTypeT']; }   
$LT = '';
if($LorryType == 1) { $LT = 'Tipper'; }
else if($LorryType == 2) { $LT = 'Grab'; }
else if($LorryType == 3) { $LT = 'Bin'; }
else{ $LT = ''; }
 ?> 

<table border="0" style="font-size: 16px;" > 
	<tr>
		<td width="500"  > 
			<table border="0"> 
				<tr>
					<td width="150" style="font-size: 16px;" ><b>No :</b></td>
					<td width="350" style="font-size: 22px;" align="left" ><b><?php echo $tickets['TicketNumber']; ?></b></td> 
				</tr> 
				<tr ><td height="10" colspan="2"></td></tr>
				<tr> <td colspan="2" style="font-size: 16px;" ><b>Material Delivered</b></td> </tr> 
				<tr ><td height="10" colspan="2"></td></tr> 
				<tr ><td colspan="2" style="font-size: 16px;"><?php echo $tickets['MaterialName']." ".$LT; ?>, <?php echo $tickets['TypeOfTicket']; ?></td></tr> 
				<tr ><td height="10" colspan="2"></td></tr> 
				<tr>
					<td width="150" style="font-size: 16px;" ><b> SIC Code</b></td>
					<td width="350" style="font-size: 16px;"  align="left"  ><?php echo $tickets['SicCode']; ?></td> 
				</tr>
				<?php if($tickets['PaymentType']==2){?>				
				<tr>
					<td width="150" style="font-size: 16px;" ><b> Payment REF No.</b></td>
					<td width="350" style="font-size: 16px;"  align="left"  ><?php echo $tickets['PaymentRefNo']; ?></td> 
				</tr> 
				<?php } ?>
			</table> 
		</td>
		<td width="250" >
			<table border="0">
					 
					<tr ><td colspan="2" align="center" style="font-size: 16px;"><b>Volume (KGs) </b></td></tr>
					<tr ><td colspan="2" height="5"></td></tr>
					<tr>
						<td width="150" style="font-size: 16px;" ><b>GROSS WEIGHT</b></td>
						<td width="100" style="font-size: 16px;"  align="right" ><?php echo round($tickets['GrossWeight']); ?></td> 
					</tr> 
					<tr ><td colspan="4" height="10"></td></tr>
					<tr>
						<td style="font-size: 16px;" ><b>TARE WEIGHT </b></td>
						<td style="font-size: 16px;"  align="right" ><?php echo round($tickets['Tare']); ?></td> 
					</tr>  
					<tr ><td colspan="4" height="10"></td></tr>
					<tr>
						<td  style="font-size: 16px;" ><b>NET WEIGHT </b></td>
						<td  style="font-size: 16px;"  align="right" ><?php echo round($tickets['Net']); ?></td> 
					</tr>
					<tr ><td height="10" colspan="2"></td></tr> 					
					<tr>
						<td  style="font-size: 16px;" ><b>TOTAL</b></td>
						<td  style="font-size: 16px;"  align="right" ><?php echo  round($tickets['Net']); ?></td> 
					</tr>  
			</table> 
		</td> 
	</tr>  
</table>  
<br><br> 
<table border="0"> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3" ><?php echo $content['outpdf_para1']; ?></td></tr> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3"  ><?php echo $content['outpdf_para2']; ?></td></tr> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3"  ><b><?php echo $content['outpdf_para3']; ?></b></td></tr> 
	<tr ><td height="60" style="font-size: 18px;" align="left" >RECEIVED BY  </td><td width ="100"  >  </td><td  width ="200"  height="40" style="font-size: 18px;" align="left" >DATE </td></tr> 
	<tr ><td height="60" style="font-size: 18px;" align="left" colspan="3"  >SIGNATURE  </td></tr> 
	<tr ><td height="20" style="font-size: 13px;"  colspan="3" ><b><?php echo $content['outpdf_para4']; ?></b></td></tr> 
</table>  

<div style="width:100%;float: right;font-size: 11px;margin-bottom: 5px;margin-top: 10px;" >   
	<div style="width:100%;float: right;text-align:right"  ><b>VAT Reg. No: </b> <?php echo $content['VATRegNo']; ?> |  <b>Company Reg. No: </b> <?php echo $content['CompanyRegNo']; ?> | 
	 <?php echo $content['FooterText']; ?></div>
</div>  

<pagebreak>
<table>
	<tr>
		<td width="350"><img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['outpdf_header_logo']?>" width ="150"><br><br>
		<span style="font-size: 16px;"><b>WASTE LICENSE No. <?php echo $content['waste_licence']; ?></span></b>   
		</td>
		<td width="500" style="font-size: 12px;" align="right"> 
			<table>
			<tr><td style="font-size: 40px;"><b><?php echo $content['outpdf_title']; ?></b></td></tr>
			<tr><td style="font-size: 16px;"><?php echo $content['outpdf_address']; ?><br/>
					<b>Tel:</b>  <?php echo $content['outpdf_phone']; ?> (Head Office)<br/> 
					<b>Email:</b> <?php echo $content['outpdf_email']; ?> <br/>
					<b>Web:</b> <?php echo $content['outpdf_website']; ?>   
				</td>			 
			</tr>
			</table> 
		</td> 
	</tr>
	<tr ><td colspan="2" height="20"></td></tr>
	<tr ><td colspan="2" style="font-size: 18px;text-align: center;"><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></td></tr>
	<tr ><td colspan="2" height="20"></td></tr>
	<tr ><td colspan="2" style="font-size: 20px;text-align: center;" align="center"><b>SITE COPY</b>
</td></tr> 
</table> 
<br> 
<table border="0">
	<tr>
		<td width="170" style="font-size: 16px;" ><b>Date & Time : </b></td>
		<td width="150" style="font-size: 16px;" ><b>Vehicle Reg. No.</b></td>
		<td width="150" style="font-size: 16px;" ><b>Driver Name</b></td>
		<td width="280"  > </td>
	</tr> 
	<tr ><td colspan="4" height="10"></td></tr>
	<tr>
		<td style="font-size: 16px;" ><?php echo $tickets['tdate']; ?></td>
		<td style="font-size: 16px;" ><?php echo $tickets['RegNumber']; ?></td>
		<td style="font-size: 16px;" ><?php echo $tickets['DriverName'];?></td> 
		<td style="font-size: 16px;" > <img src="<?php echo $tickets['driversignature']; ?>" width ="250" height="50" style="float:right"> </td> 
	</tr>  
</table> 
<br><br>  
<table border="0">
	<tr>
		<td width="150" style="font-size: 16px;" ><b>Customer Name :</b></td>
		<td width="300" style="font-size: 16px;" ><?php echo $tickets['CompanyName']; ?></td> 
		<td width="150" style="font-size: 16px;" ><b>Haulier :  </b></td>
		<td width="250" style="font-size: 16px;" ><?php echo $tickets['Hulller']; ?></td>  
	</tr> 
	<tr ><td height="20"colspan="4"></td></tr>  
	<tr ><td colspan="4" style="font-size: 16px;"><b>Site Address:</b> <?php echo $tickets['OpportunityName']; ?> </td></tr> 
</table>  
<br> 
<table border="0" style="font-size: 16px;" > 
	<tr>
		<td width="500"  > 
			<table border="0"> 
				<tr>
					<td width="150" style="font-size: 16px;" ><b>No :</b></td>
					<td width="350" style="font-size: 22px;" align="left" ><b><?php echo $tickets['TicketNumber']; ?></b></td> 
				</tr> 
				<tr ><td height="10" colspan="2"></td></tr>
				<tr> <td colspan="2" style="font-size: 16px;" ><b>Material Delivered</b></td> </tr> 
				<tr ><td height="10" colspan="2"></td></tr> 
				<tr ><td colspan="2" style="font-size: 16px;"><?php echo $tickets['MaterialName']." ".$LT; ?>, <?php echo $tickets['TypeOfTicket']; ?></td></tr> 
				<tr ><td height="10" colspan="2"></td></tr> 
				<tr>
					<td width="150" style="font-size: 16px;" ><b>SIC Code </b></td>
					<td width="350" style="font-size: 16px;"  align="left"  ><?php echo $tickets['SicCode']; ?></td> 
				</tr> 
				<?php if($tickets['PaymentType']==2){?>				
				<tr>
					<td width="150" style="font-size: 16px;" ><b> Payment REF No.</b></td>
					<td width="350" style="font-size: 16px;"  align="left"  ><?php echo $tickets['PaymentRefNo']; ?></td> 
				</tr> 
				<?php } ?>
			</table> 
		</td>
		<td width="250" >
			<table border="0">
					 
					<tr ><td colspan="2" align="center" style="font-size: 16px;"><b>Weight In KGs </b></td></tr>
					<tr ><td colspan="2" height="5"></td></tr>
					<tr>
						<td width="150" style="font-size: 16px;" ><b>GROSS WEIGHT</b></td>
						<td width="100" style="font-size: 16px;"  align="right" ><?php echo round($tickets['GrossWeight']); ?></td> 
					</tr> 
					<tr ><td colspan="4" height="10"></td></tr>
					<tr>
						<td style="font-size: 16px;" ><b>TARE WEIGHT </b></td>
						<td style="font-size: 16px;"  align="right" ><?php echo round($tickets['Tare']); ?></td> 
					</tr>  
					<tr ><td colspan="4" height="10"></td></tr>
					<tr>
						<td  style="font-size: 16px;" ><b>NET WEIGHT </b></td>
						<td  style="font-size: 16px;"  align="right" ><?php echo round($tickets['Net']); ?></td> 
					</tr>
					<tr ><td height="10" colspan="2"></td></tr> 					
					<tr>
						<td  style="font-size: 16px;" ><b>TOTAL</b></td>
						<td  style="font-size: 16px;"  align="right" ><?php echo  round($tickets['Net']); ?></td> 
					</tr>  
			</table> 
		</td> 
	</tr>  
</table>  
<br><br> 
<table border="0"> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3" ><?php echo $content['outpdf_para1']; ?></td></tr> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3"  ><?php echo $content['outpdf_para2']; ?></td></tr> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3"  ><b><?php echo $content['outpdf_para3']; ?></b></td></tr> 
	<tr ><td height="60" style="font-size: 18px;" align="left" >RECEIVED BY  </td><td width ="100"  >  </td><td  width ="200"  height="40" style="font-size: 18px;" align="left" >DATE </td></tr> 
	<tr ><td height="60" style="font-size: 18px;" align="left" colspan="3"  >SIGNATURE  </td></tr> 
	<tr ><td height="20" style="font-size: 13px;"  colspan="3" ><b><?php echo $content['outpdf_para4']; ?></b></td></tr> 
</table>   

<div style="width:100%;float: right;font-size: 11px;margin-bottom: 5px;margin-top: 10px;" >   
	<div style="width:100%;float: right;text-align:right"  ><b>VAT Reg. No: </b> <?php echo $content['VATRegNo']; ?> |  <b>Company Reg. No: </b> <?php echo $content['CompanyRegNo']; ?> | 
	 <?php echo $content['FooterText']; ?></div>
</div>  
<pagebreak>
<table>
	<tr>
		<td width="350"><img src="<?php echo site_url().'assets/Uploads/Logo/'.$content['outpdf_header_logo']?>" width ="150"><br><br>
		<span style="font-size: 16px;"><b>WASTE LICENSE No. <?php echo $content['waste_licence']; ?></b></span>   
		</td>
		<td width="500" style="font-size: 12px;" align="right"> 
			<table>
			<tr><td style="font-size: 40px;"><b><?php echo $content['outpdf_title']; ?></b></td></tr>
			<tr><td style="font-size: 16px;"><?php echo $content['outpdf_address']; ?><br/>
					<b>Tel:</b>  <?php echo $content['outpdf_phone']; ?> (Head Office)<br/> 
					<b>Email:</b> <?php echo $content['outpdf_email']; ?> <br/>
					<b>Web:</b> <?php echo $content['outpdf_website']; ?>   
				</td>			 
			</tr>
			</table> 
		</td> 
	</tr>
	<tr ><td colspan="2" height="20"></td></tr>
	<tr ><td colspan="2" style="font-size: 18px;text-align: center;"><b>COMBINED CONVEYANCE CONTROLLED WASTE TRANSFER NOTE</b></td></tr>
	<tr ><td colspan="2" height="20"></td></tr>
	<tr ><td colspan="2" style="font-size: 20px;text-align: center;" align="center"><b>WEIGHBRIDGE COPY</b>
</td></tr> 
</table> 
<br> 
<table border="0">
	<tr>
		<td width="170" style="font-size: 16px;" ><b>Date & Time : </b></td>
		<td width="150" style="font-size: 16px;" ><b>Vehicle Reg. No.</b></td>
		<td width="150" style="font-size: 16px;" ><b>Driver Name</b></td>
		<td width="280"  > </td>
	</tr> 
	<tr ><td colspan="4" height="10"></td></tr>
	<tr>
		<td style="font-size: 16px;" ><?php echo $tickets['tdate']; ?></td>
		<td style="font-size: 16px;" ><?php echo $tickets['RegNumber']; ?></td>
		<td style="font-size: 16px;" ><?php echo $tickets['DriverName'];?></td> 
		<td style="font-size: 16px;" > <img src="<?php echo $tickets['driversignature']; ?>" width ="250" height="50" style="float:right"> </td> 
	</tr>  
</table>  
<br><br>  
<table border="0">
	<tr>
		<td width="150" style="font-size: 16px;" ><b>Customer Name :</b></td>
		<td width="300" style="font-size: 16px;" ><?php echo $tickets['CompanyName']; ?></td> 
		<td width="150" style="font-size: 16px;" ><b>Haulier :  </b></td>
		<td width="250" style="font-size: 16px;" ><?php echo $tickets['Hulller']; ?></td>  
	</tr> 
	<tr ><td height="20"colspan="4"></td></tr>  
	<tr ><td colspan="4" style="font-size: 16px;"><b>Site Address:</b> <?php echo $tickets['OpportunityName']; ?> </td></tr> 
</table>  
<br> 
<table border="0" style="font-size: 16px;" > 
	<tr>
		<td width="500"  > 
			<table border="0"> 
				<tr>
					<td width="150" style="font-size: 16px;" ><b>No :</b></td>
					<td width="350" style="font-size: 22px;" align="left" ><b><?php echo $tickets['TicketNumber']; ?></b></td> 
				</tr> 
				<tr ><td height="10" colspan="2"></td></tr>
				<tr> <td colspan="2" style="font-size: 16px;" ><b>Material Delivered</b></td> </tr> 
				<tr ><td height="10" colspan="2"></td></tr> 
				<tr ><td colspan="2" style="font-size: 16px;"><?php echo $tickets['MaterialName']." ".$LT; ?>, <?php echo $tickets['TypeOfTicket']; ?></td></tr> 
				<tr ><td height="10" colspan="2"></td></tr> 
				<tr>
					<td width="150" style="font-size: 16px;" ><b>SIC Code</b></td>
					<td width="350" style="font-size: 16px;"  align="left"  ><?php echo $tickets['SicCode']; ?></td> 
				</tr> 
				<?php if($tickets['PaymentType']==2){?>				
				<tr>
					<td width="150" style="font-size: 16px;" ><b> Payment REF No.</b></td>
					<td width="350" style="font-size: 16px;"  align="left"  ><?php echo $tickets['PaymentRefNo']; ?></td> 
				</tr> 
				<?php } ?>
			</table> 
		</td>
		<td width="250" >
			<table border="0">
					 
					<tr ><td colspan="2" align="center" style="font-size: 16px;"><b>Weight In KGs </b></td></tr>
					<tr ><td colspan="2" height="5"></td></tr>
					<tr>
						<td width="150" style="font-size: 16px;" ><b>GROSS WEIGHT</b></td>
						<td width="100" style="font-size: 16px;"  align="right" ><?php echo round($tickets['GrossWeight']); ?></td> 
					</tr> 
					<tr ><td colspan="4" height="10"></td></tr>
					<tr>
						<td style="font-size: 16px;" ><b>TARE WEIGHT </b></td>
						<td style="font-size: 16px;"  align="right" ><?php echo round($tickets['Tare']); ?></td> 
					</tr>  
					<tr ><td colspan="4" height="10"></td></tr>
					<tr>
						<td  style="font-size: 16px;" ><b>NET WEIGHT </b></td>
						<td  style="font-size: 16px;"  align="right" ><?php echo round($tickets['Net']); ?></td> 
					</tr>
					<tr ><td height="10" colspan="2"></td></tr> 					
					<tr>
						<td  style="font-size: 16px;" ><b>TOTAL</b></td>
						<td  style="font-size: 16px;"  align="right" ><?php echo  round($tickets['Net']); ?></td> 
					</tr>  
			</table> 
		</td> 
	</tr>  
</table>  
<br><br> 
<table border="0"> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3" ><?php echo $content['outpdf_para1']; ?></td></tr> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3"  ><?php echo $content['outpdf_para2']; ?></td></tr> 
	<tr ><td height="20" style="font-size: 13px;" colspan="3"  ><b><?php echo $content['outpdf_para3']; ?></b></td></tr> 
	<tr ><td height="60" style="font-size: 18px;" align="left" >RECEIVED BY  </td><td width ="100"  >  </td><td  width ="200"  height="40" style="font-size: 18px;" align="left" >DATE </td></tr> 
	<tr ><td height="60" style="font-size: 18px;" align="left" colspan="3"  >SIGNATURE  </td></tr> 
	<tr ><td height="20" style="font-size: 13px;"  colspan="3" ><b><?php echo $content['outpdf_para4']; ?></b></td></tr> 
</table>  

<div style="width:100%;float: right;font-size: 11px;margin-bottom: 5px;margin-top: 10px;" >   
	<div style="width:100%;float: right;text-align:right"  ><b>VAT Reg. No: </b> <?php echo $content['VATRegNo']; ?> |  <b>Company Reg. No: </b> <?php echo $content['CompanyRegNo']; ?> | 
	 <?php echo $content['FooterText']; ?></div>
</div>    
</body>
</html> 