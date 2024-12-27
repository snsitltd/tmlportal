<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
</head> 
</head>
<body>  
<table cellpadding="5"  autosize="1" > 
		<tr>  
			<th align="left" width="150"  style="font-size:12px;border: 1px solid #d3d3d3 ;background-color:#F2F2F2"  >TICKET TYPE : </th>
			<th align="left" width="850"  style="font-size:12px;border: 1px solid #d3d3d3 ;background-color:#F2F2F2"><?php echo $ptype; ?> </th> 
		</tr>    
		<tr>  
			<th align="left" width="150"  style="font-size:12px;border: 1px solid #d3d3d3 ;background-color:#F2F2F2"  >DATE : </th>
			<th align="left" width="850"  style="font-size:12px;border: 1px solid #d3d3d3 ;background-color:#F2F2F2"><?php echo $searchdate; ?> </th> 
		</tr>    
</table>
<br> 
<table style="font-size:12px" cellpadding="5"  autosize="1" > 
<tbody>
		<tr>  
			<th align="left" width="90"  style="background-color:#F2F2F2"  >Ticket Type </th>
			<th align="left" width="650"  style="background-color:#F2F2F2"  >Material Name </th>
			<th align="left" width="100"  style="background-color:#F2F2F2"  >Loads </th>
			<th width="150"  align="left"  style="background-color:#F2F2F2" >Sum Of Net (Tonnes) </th> 
		</tr>  
<?php if(!empty($ticketsRecords)){ $i=1; $total = 0;
	foreach($ticketsRecords as $key=>$record){   ?>  
		<tr>   
			<td style="border: 1px solid #d3d3d3 ;"align="right" ><?php echo $record->TypeOfTicket; ?></td>  
			<td style="border: 1px solid #d3d3d3 ;"align="left" ><?php echo $record->MaterialName ?></td>  
			<td style="border: 1px solid #d3d3d3 ;"align="Left" ><?php echo $record->CountLoads ?></td>  
			<td style="border: 1px solid #d3d3d3 ;"align="right" ><?php echo $record->net_tonnes ?></td>  
		</tr>  
<?php $i++; $total = $total + $record->net_tonnes; }} ?>
		<tr>  
			 
			<th colspan="3" align="right" width="750" style="background-color:#F2F2F2" ><b>GRAND TOTAL</b></th>
			<th width="150"  align="right "  style="background-color:#F2F2F2" ><b><?php echo $total; ?></b></th> 
		</tr> 
</tbody>
</table> 		   
</body>
</html>