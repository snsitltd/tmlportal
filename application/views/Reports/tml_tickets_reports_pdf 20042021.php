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
		$c=""; $c1=""; $m="";$m1=""; $loads = 0; $loads1 = 0; $net1 = 0; $i=0;  
		$count =  count($ticketsRecords);
		foreach($ticketsRecords as $key=>$record){ 
			$c=$record->CompanyID; $m = $record->MaterialID;   
			if($record->is_tml == 1){  $con_width = '50'; $con_width1 = '810';  }else{  $con_width = '150'; $con_width1 = '880';    } ?>
			
			<?php if($c1 != $c ){	 ?> 
				<?php if($i!=0){ ?>
					<table style="font-size:12px"  width = "1007" cellpadding="5" autosize="1"  > 
					<tbody>
						<tr> 
							<td align="right" width="<?php echo $con_width1; ?>"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
							<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $loads1; ?></b> </td>
							<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
							<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo round($net1); ?></b>  </td>
						</tr> 
					</tbody>
					</table> 	
				<pagebreak> 
				<?php } ?>		 
			<?php $c1=$record->CompanyID; $m1=""; $loads1 = 0;  $net1 = 0; ?>   
			<table style="font-size:12px" width = "1007" cellpadding="5"  autosize="1" > 
			<tbody>
				<tr><td colspan="9" height="10"> </td></tr>   
				<tr><td style="border: 1px solid #000000 ;background-color:#F2F2F2" colspan="9" height="30"><b>Company: </b><?php echo $record->CompanyName; ?></td></tr>  
				<tr><td colspan="9" height="10"> </td></tr>   
			</tbody>
			</table> 
			<?php  } ?> 
				<?php if($m1 != $m ){ $m1=$record->MaterialID;   $loads = 0;   ?>   
					<table style="font-size:12px"  width = "1000" cellpadding="5"  autosize="1" > 
					<tbody>
						<tr><td style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2" colspan="9" height="30"><b>Material: </b><?php echo $record->MaterialName; ?></td></tr> 
						<tr> 
							<th width="50" align="left">TNo</th> 
							<th width="70"  align="left">Date</th>
							<th width="<?php echo $con_width; ?>" align="left">Conveyance</th>
							<th width="50"  align="left">LNo</th>
							<th width="80"  align="left">VRNO</th>
							<th width="470" align="left" >Site Address</th> 
							<th width="70"  align="left">Gross</th>
							<th width="70"  align="left">Tare</th>
							<th width="70"  align="left">Net</th>   
						</tr>  
				<?php } ?>  
				<tr> 
					<td style="border: 1px solid #d3d3d3 ;" ><?php  echo trim($record->TicketNumber); ?> </td>  
					<td style="border: 1px solid #d3d3d3 ;" ><?php echo trim($record->TicketDate) ?></td>
					<td style="border: 1px solid #d3d3d3 ;" ><?php echo trim($record->Conveyance) ?></td>
					<td style="border: 1px solid #d3d3d3 ;" ><?php echo trim($record->driver_id) ?></td>
					<td style="border: 1px solid #d3d3d3 ;" ><?php echo trim(strtoupper($record->RegNumber)) ?></td>
					<td style="border: 1px solid #d3d3d3 ;" ><?php echo trim($record->SiteName); ?> </td> 
					<td style="border: 1px solid #d3d3d3 ;" align="right" ><?php echo round(trim($record->GrossWeight)) ?></td>
					<td style="border: 1px solid #d3d3d3 ;" align="right" ><?php echo round(trim($record->Tare)) ?></td>
					<td style="border: 1px solid #d3d3d3 ;" align="right" ><?php echo round(trim($record->Net)) ?></td>  
				</tr>  
			<?php $loads = $loads+1;  $loads1 = $loads1+1; $net1 = $net1 + $record->Net;    ?> 
			<?php if( $record->mCount == $loads){?> 
					<tr> 
						<td align="right" colspan="6" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
						<td align="right"  width="70" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $record->mCount; ?></b> </td>
						<td align="right" width="70" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
						<td align="right" width="70" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo round($record->netTotal); ?></b>  </td>
					</tr> 
					<tr><td colspan="10" height="10"> </td></tr>   
				</tbody>
				</table> 	  
			<?php } ?>  
			<?php if($i== $count-1){ ?>
				<table style="font-size:12px"  width = "1007" cellpadding="5"  autosize="1" > 
				<tbody>
					<tr> 
						<td align="right" width="<?php echo $con_width1; ?>"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $loads1; ?></b> </td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo round($net1); ?></b>  </td>
					</tr> 
				</tbody>
				</table> 	 
			<?php } ?>	
	<?php $i++; } } ?> 
</body>
</html>