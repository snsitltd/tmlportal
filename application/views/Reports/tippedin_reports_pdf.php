<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
</head> 
</head>
<body> 
<h1 align="center">TIPPED IN REPORT</h1>

	<?php
	if(!empty($ticketsRecords)){
		$c=""; $c1=""; $m="";$m1=""; $loads = 0;  $i=0;  $loads1 = 0; $net1 = 0;
		foreach($ticketsRecords as $key=>$record){ 
		
			$c=$record->CompanyID; $m = $record->MaterialID;  
			if($m1 != $m ){	 ?> 
			<?php if($i!=0){ ?>
				<table style="font-size:12px"  width = "1000" cellpadding="5" autosize="1"  > 
				<tbody>
					<tr> 
						<td align="right" width="790"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $loads1; ?></b> </td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo round($net1,2); ?></b>  </td>
					</tr> 
				</tbody>
				</table> 	
			<pagebreak> 
			<?php } ?>	
			<?php $m1=$record->MaterialID; $c1=""; $loads1 = 0;  $net1 = 0;   ?>     	
			 
			<table style="font-size:12px" width = "1000" cellpadding="5"  autosize="1" > 
			<tbody>
				<tr><td colspan="9" height="20"> </td></tr>  
				<tr><td style="border: 1px solid #000000 ;background-color:#F2F2F2" colspan="9" height="30"><b>Material: </b><?php echo $record->MaterialName; ?> </td></tr> 
				<tr><td colspan="9" height="20"> </td></tr>   
			</tbody>
			</table> 		   
			
			<?php  } ?> 
			<?php if($c1 != $c ){   $c1=$record->CompanyID;   $loads = 0;    ?>   
			<table style="font-size:12px"  width = "1000" cellpadding="5"  autosize="1" > 
			<tbody>
			
			<tr><td style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2" colspan="9" height="30"><b>Company: </b><?php echo $record->CompanyName; ?></td></tr>  
			<tr> 
				<th width="50" align="left">TNo</th>	 
				<th width="70"  align="left">Date</th>
				<th width="100" align="left">Conveyance</th>
				<th width="50"  align="left">LorryNo</th>
				<th width="73"  align="left">VRNo</th>
				<th align="left">Site Address</th> 
				<th width="70"  align="left">Gross</th>
				<th width="70"  align="left">Tare</th>
				<th width="70"  align="left">Net</th>   
			</tr> 
			<?php } ?> 
			<tr> 
				<td style="border: 1px solid #d3d3d3 ;" width="50"  ><?php  echo  $record->TicketNumber; ?> </td>  
				<td style="border: 1px solid #d3d3d3 ;" width="70" ><?php echo trim($record->TicketDate) ?></td>
				<td style="border: 1px solid #d3d3d3 ;" width="100"  ><?php echo $record->Conveyance ?></td>
				<td style="border: 1px solid #d3d3d3 ;" width="50"  ><?php echo $record->driver_id ?></td>
				<td style="border: 1px solid #d3d3d3 ;" width="73"  ><?php echo trim(strtoupper($record->RegNumber)); ?></td>
				<td style="border: 1px solid #d3d3d3 ;"><?php echo $record->SiteName;?> </td> 
				<td style="border: 1px solid #d3d3d3 ;" width="70"   align="right" ><?php echo $record->GrossWeight ?></td>
				<td style="border: 1px solid #d3d3d3 ;" width="70"  align="right" ><?php echo $record->Tare ?></td>
				<td style="border: 1px solid #d3d3d3 ;" width="70"  align="right" ><?php echo $record->Net ?></td>  
			</tr> 
			<?php $loads = $loads+1; $loads1 = $loads1+1; $net1 = $net1 + $record->Net;    ?> 
			<?php if( $record->mCount == $loads){?>
			<tr>
				<td colspan="5" height="20"> </td>
				<td align="right" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
				<td align="right" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $record->mCount; ?></b> </td>
				<td align="right" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
				<td align="right" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $record->netTotal; ?></b>  </td>
			</tr> 
			<tr><td colspan="9" height="20"> </td></tr>   
			</tbody>
			</table> 		   

			<?php } ?> 
	<?php $i++;} } ?>
</body>
</html>