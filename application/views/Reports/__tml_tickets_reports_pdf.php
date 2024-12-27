<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
</head> 
</head>
<body>  
<table border="1" cellspacing="0"  >
<tr cellspacing="0" >
		<td style="width: 15px; ">No</th> 
		<td style="width: 80px;">Date</td>
		<td >Company Name</td>
		<td style="width: 60px;">REG No</td>
		<td style="width: 100px;">Driver Name</td>
		<td style="width: 60px;">Gross</td>
		<td style="width: 60px;">Tare</td>
		<td style="width: 60px;" align= "right" valign="middle">Net</td> 
	</tr>    
	<?php
	if(!empty($ticketsRecords))
	{ $i=0;
		foreach($ticketsRecords as $key=>$record)
		{ $i++;
	?>  
	<tr cellspacing="0" >
		<td ><?php echo $i; ?></td> 
		<td align= "left" style="font-size: 12px;" ><?php echo $record->TicketDate; ?></td>
		<td align= "left"  style="font-size: 12px;" ><?php echo $record->CompanyName; ?></td>
		<td align= "left" style="font-size: 12px;"  ><?php echo $record->RegNumber; ?></td>
		<td align= "left"  style="font-size: 12px;" ><?php echo $record->DriverName; ?></td>
		<td align= "right" style="font-size: 12px;"  ><?php echo $record->GrossWeight; ?></td>
		<td align= "right"  style="font-size: 12px;" ><?php echo $record->Tare; ?></td>
		<td align= "right"  style="font-size: 12px;" ><?php echo $record->Net; ?></td> 
	</tr>
	<?php }} ?>
	 
  </table> 
</body>
</html>