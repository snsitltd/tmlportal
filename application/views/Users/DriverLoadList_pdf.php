<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
</head> 
</head>
<body>  
<h3 align="center"><?php echo $title; ?></h3>   
		<table style="font-size:14px" border="1"  width = "800" cellpadding="5" cellspacing="0"  autosize="1" > 
		<tbody> 
			<tr style="background-color:#C1C1C1"> 
				<th  >Driver Name</th>  
				<th width="50">Collection</th>  
				<th width="50">Delivery</th> 
				<th width="50">DayWork</th>  
				<th width="50">Haulage</th> 
				<th width="50">Wasted</th> 
				<th width="50">Cancel</th> 
				<th width="50">Total</th>  
			</tr>  
			<?php if(count($TodayBookingDriver1)>0){ 
					$i = 1; $TCollection = 0; $TDelivery = 0; $TDayWork = 0; $THaulage = 0;  $TWasted = 0; $TCancel = 0; 
					
					foreach($TodayBookingDriver1 as $row){  
					$TCollection = $TCollection + $row['TotalCollection']; 
					$TDelivery = $TDelivery + $row['TotalDelivery']; 
					
					$TDayWork = $TDayWork + $row['TotalDayWork']; 
					$THaulage = $THaulage + $row['TotalHaulage']; 
					
					$TWasted = $TWasted + $row['TotalWasted']; 
					$TCancel = $TCancel + $row['TotalCancel'];  
			?>
			<tr> 
				<td ><?php echo $row['DriverName']; ?> </td>		 
				<td align="right" ><b><?php  echo $row['TotalCollection'];   ?></b> </td>			 
				<td align="right" ><b><?php echo $row['TotalDelivery']; ?></b> </td>			 
				
				<td align="right" ><b><?php  echo $row['TotalDayWork'];   ?></b> </td>			 
				<td align="right" ><b><?php echo $row['TotalHaulage']; ?></b> </td>			 
				
				<td align="right" ><b><?php echo $row['TotalWasted']; ?></b> </td>			 
				<td align="right" ><b><?php echo $row['TotalCancel']; ?></b> </td>			 
				<td align="right" ><b><?php echo $row['TotalCollection']+$row['TotalDelivery']+$row['TotalDayWork']+$row['TotalHaulage']+$row['TotalWasted']+$row['TotalCancel']; ?></b></td>		  	  
			</tr>   
			<?php $i = $i+1; } ?>	  
			<tr style="background-color:#C1C1C1" >  
				<td ><b>Grand Total</b></td>	 
				<td  align="right" ><b><?php echo $TCollection; ?></b> </td>			 
				<td  align="right" ><b><?php echo $TDelivery; ?></b> </td>			 
				<td  align="right" ><b><?php echo $TDayWork; ?></b> </td>			 
				<td  align="right" ><b><?php echo $THaulage; ?></b> </td>			 
				<td  align="right" ><b><?php echo $TWasted; ?></b> </td>			 
				<td  align="right" ><b><?php echo $TCancel; ?></b> </td>			 
				<td  align="right" ><b><?php echo $TCollection+$TDelivery+$TDayWork+$THaulage+$TWasted+$TCancel; ?></b> </td>		  	  
			</tr>      
			<?php }else{ ?>
				<tr>  
					<td align="center" colspan="6" >There is no records.  </td>
				</tr>  
			<?php } ?> 
	</tbody>
</table>
</body>
</html>