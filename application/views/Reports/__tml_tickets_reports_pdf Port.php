<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
</head> 
</head>
<body>   

<h1 align="center"><?php echo $title; ?></h1> 
	<?php
	if(!empty($ticketsRecords)){
		$c=""; $c1=""; $m="";$m1=""; $s="";$s1=""; $loads = 0; $loads1 = 0;$loads2 = 0; $net1 = 0; $i=0;  
		foreach($ticketsRecords as $key=>$record){ 
			$c=$record->CompanyID; $m = $record->MaterialID;  $s = $record->SiteName;  ?>
			
			<?php if($c1 != $c ){	 ?> 
			<?php if($i!=0){ ?>
				<table style="font-size:12px"  width = "1000" cellpadding="5" > 
				<tbody>
					<tr> 
						<td align="right" width="700"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
						<td align="right" width="100"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $loads1; ?></b> </td>
						<td align="right" width="100"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
						<td align="right" width="100"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo round($net1,2); ?></b>  </td>
					</tr> 
				</tbody>
				</table> 	
			<pagebreak> 
			<?php } ?>		 
			<?php $c1=$record->CompanyID; $m1=""; $loads1 = 0;  $net1 = 0; ?>   
			<table style="font-size:12px" width = "1000" cellpadding="5" > 
			<tbody>
				<tr><td   height="20"> </td></tr>   
				<tr><td style="border: 1px solid #000000 ;background-color:#F2F2F2"  height="30"><b>Company: </b><?php echo $record->CompanyName; ?></td></tr>  
				<tr><td  height="20"> </td></tr>   
			</tbody>
			</table> 
			<?php  } ?> 
				<?php if($m1 != $m ){ $m1=$record->MaterialID;   $loads = 0; $s1="";    ?>   
					<table style="font-size:12px"  width = "1000" cellpadding="5" > 
						<tbody>
							<tr><td style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2" colspan="8" height="30"><b>Material: </b><?php echo $record->MaterialName; ?></td></tr>  
						</tbody>
					</table>  
					
				<?php } ?>   
				<?php if($s1 != $s ){ $s1=$record->SiteName;   $loads2 = 0;   ?> 
				<table style="font-size:12px"  width = "1000" cellpadding="5" > 
					<tbody>
						<tr><td style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2" colspan="8" height="30"><b>Site Address: </b><?php echo $record->SiteName; ?></td></tr> 		 
					</tbody>
				</table> 
				<table style="font-size:12px"  width = "1000" cellpadding="5" > 
						<tbody>
						<tr> 
							<th width="100" align="left">Ticket No.</th>	 
							<th width="100"  align="left">Date</th>
							<th width="300"  align="left">Conveyance</th>
							<th width="50"  align="left">LNo</th>
							<th width="150"  align="left">Vehicle Reg</th>
							<!--<th align="left">Site Address</th> -->
							<th width="100"  align="right">Gross</th>
							<th width="100"  align="right">Tare</th>
							<th width="100"  align="right">Net</th>   
						</tr> 
</tbody>
				</table> 
				<?php } ?> 
<table style="font-size:12px"  width = "1000" cellpadding="5" > 
					<tbody>
				<tr> 
					<td style="border: 1px solid #d3d3d3 ;"  width="100" ><?php  echo trim($record->TicketNumber); ?> </td>  
					<td style="border: 1px solid #d3d3d3 ;"  width="100" ><?php echo trim($record->TicketDate) ?></td>
					<td style="border: 1px solid #d3d3d3 ;"  width="300" ><?php echo trim($record->Conveyance) ?></td>
					<td style="border: 1px solid #d3d3d3 ;"  width="50" ><?php echo trim($record->driver_id) ?></td>
					<td style="border: 1px solid #d3d3d3 ;"  width="150" ><?php echo trim(strtoupper($record->RegNumber)) ?></td>
					<!-- <td style="border: 1px solid #d3d3d3 ;" ><?php //echo trim($record->SiteName); ?> </td> -->
					<td style="border: 1px solid #d3d3d3 ;"  width="100"  align="right" ><?php echo trim($record->GrossWeight) ?></td>
					<td style="border: 1px solid #d3d3d3 ;"  width="100"  align="right" ><?php echo trim($record->Tare) ?></td>
					<td style="border: 1px solid #d3d3d3 ;"  width="100" align="right" ><?php echo trim($record->Net) ?></td>  
				</tr> 
				 </tbody>
				</table> 
			<?php $loads = $loads+1;  $loads1 = $loads1+1; $loads2 = $loads2+1; $net1 = $net1 + $record->Net;    ?> 
			<?php if( $record->mCount == $loads){?> 
<table style="font-size:12px"  width = "1000" cellpadding="5" > 
					<tbody>					<tr> 
						<td align="right" colspan="5" width="700"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
						<td align="right" width="100" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $record->mCount; ?></b> </td>
						<td align="right" width="100" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
						<td align="right" width="100" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $record->netTotal; ?></b>  </td>
					</tr> 
					<tr><td colspan="9" height="20"> </td></tr>   
				</tbody>
				</table> 	 
				
			<?php } ?>  	
	<?php $i++; } } ?>
 
</body>
</html>