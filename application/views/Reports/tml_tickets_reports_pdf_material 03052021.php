<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"> 
</head>
<!--<style>
    table {
        overflow: wrap;
    }
</style>  -->
</head>
<body> 

<h1 align="center"><?php echo $title; ?></h1>
	<?php
	if(!empty($ticketsRecords)){
		$c=""; $c1=""; $m="";$m1=""; $loads = 0; $i=0;  $loads1 = 0; $net1 = 0;
		$count =  count($ticketsRecords);
		foreach($ticketsRecords as $key=>$record){  
			$c=$record->CompanyID; $m = $record->MaterialID;  
			if($record->is_tml == 1){  $con_width = '50'; $con_width1 = '810';  }else{  $con_width = '150'; $con_width1 = '880';    } ?>
			
			<?php if($m1 != $m ){	?> 
			<?php if($i!=0){ ?>
				<table style="font-size:12px;border: 1px solid #000000 ;"  autosize="1"   width = "1007" cellpadding="5" > 
				<tbody>
					<tr> 
						<td align="right" height="10"  width="<?php echo $con_width1; ?>"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $loads1; ?></b> </td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo round($net1); ?></b>  </td>
					</tr> 
				</tbody>
				</table> 	
			<pagebreak> 
			<?php } ?>	
			
			<?php  $m1=$record->MaterialID; $c1=""; $loads1 = 0;  $net1 = 0;   ?>  	
			
			<table style="font-size:12px" width = "1007" cellpadding="5"  autosize="1" > 
			<tbody>
				<tr><td  height="10"> </td></tr>  
				<tr><td style="border: 1px solid #000000 ;background-color:#F2F2F2" height="30"><b>Material: </b><?php echo $record->MaterialName; ?> </td></tr> 
				<tr><td  height="20"> </td></tr>   
			</tbody>
			</table> 	
			<?php  } ?> 
			<?php if($c1 != $c ){   $c1=$record->CompanyID;   $loads = 0;     ?>   
				<table style="font-size:12px"  width = "1000" cellpadding="5"  autosize="1" > 
				<tbody>
					<tr><td style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2" colspan="9" height="30"><b>Company: </b><?php echo $record->CompanyName; ?></td></tr>  
					<tr> 
						<th width="50" height="10"  align="left">TNo</th> 
						<th width="70" align="left">Date</th>
						<th width="<?php echo $con_width; ?>" align="left">Conveyance</th>
						<th width="50" align="left">LNo</th>
						<th width="80" align="left">VRNO</th>
						<th width="470" align="left" >Site Address</th> 
						<th width="70" align="left">Gross</th>
						<th width="70" align="left">Tare</th>
						<th width="70" align="left">Net</th>   
					</tr>   
				</tbody>
				</table> 	
			<?php } ?> 
				<table style="font-size:12px;page-break-inside:avoid" autosize="1" width = "1007" cellpadding="5" > 
				<tbody>	
					<tr> 
						<td style="border: 1px solid #d3d3d3 ;width:50px;height:10px;"  ><?php  echo trim($record->TicketNumber); ?> </td>  
						<td style="border: 1px solid #d3d3d3 ;width:70px;height:10px;"   ><?php echo trim($record->TicketDate) ?></td>
						<td style="border: 1px solid #d3d3d3 ;height:10px;width:<?php echo $con_width; ?>;"   ><?php echo trim($record->Conveyance) ?></td>
						<td style="border: 1px solid #d3d3d3 ;width:50px;height:10px;" ><?php echo trim($record->driver_id) ?></td>
						<td style="border: 1px solid #d3d3d3 ;width:80px;height:10px;"  ><?php echo trim(strtoupper($record->RegNumber)) ?></td>
						<td style="border: 1px solid #d3d3d3 ;width:470px;height:10px;"  ><?php echo trim($record->SiteName); ?> </td> 
						<td style="border: 1px solid #d3d3d3 ;width:70px;height:10px;" align="right" ><?php echo round(trim($record->GrossWeight)) ?></td>
						<td style="border: 1px solid #d3d3d3 ;width:70px;height:10px;"  align="right" ><?php echo round(trim($record->Tare)) ?></td>
						<td style="border: 1px solid #d3d3d3 ;width:70px;height:10px;"  align="right" ><?php echo round(trim($record->Net)) ?></td>  
					</tr>
				</tbody>
				</table> 	
			<?php $loads = $loads+1;  $loads1 = $loads1+1; $net1 = $net1 + $record->Net;   ?> 
			<?php if( $record->mCount == $loads){?> 
				<table style="font-size:12px"  width = "1007" cellpadding="5"  autosize="1" > 
				<tbody>	
					<tr> 
						<td align="right"  height="10"  width="<?php echo $con_width1; ?>"   style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
						<td align="right" width="70" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $record->mCount; ?></b> </td>
						<td align="right" width="70" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
						<td align="right" width="70" style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo round($record->netTotal); ?></b>  </td>
					</tr> 				
				</tbody>
				</table>  
				<table style="font-size:12px"  width = "1000" cellpadding="5"  autosize="1" > 
				<tbody>	
					<tr><td height="10" width = "1000" > </td></tr>   					
				</tbody>
				</table>  
			<?php } ?> 
			<?php if($i== $count-1){ ?>
				<table style="font-size:12px"  width = "1007" cellpadding="5"  autosize="1" > 
				<tbody>
					<tr> 
						<td align="right" height="10"  width="<?php echo $con_width1; ?>"   style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b>Loads </b></td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo $loads1; ?></b> </td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b> Net</b></td>
						<td align="right" width="70"  style="border: 1px solid #F2F2F2 ;background-color:#F2F2F2"><b><?php echo round($net1); ?></b>  </td>
					</tr> 
				</tbody>
				</table>
				<table style="font-size:12px"  width = "1000" cellpadding="5"  autosize="1" > 
					<tbody>	
						<tr><td height="10" width = "1000" > </td></tr>   					
					</tbody>
				</table>  	
			<?php } ?>	
	<?php $i++; }
	} ?> 		   
</body>
</html>