  
<div >
<?php if(!empty($OppoProductLogs)){ ?>
 <table  class="table table-bordered table-hover  "  aria-describedby="example2_info" >  
	<thead>
		<tr> 
			<th width="140" >Log DateTime</th>          
			<!-- <th width="50" >Add/Edit</th>          -->
			<th  width="150" >Location</th>             
			<th >Values</th>             
			<th width="100">Updated By </th>               
		</tr>
	</thead> 
	 <tbody>
	<?php   
	if(!empty($OppoProductLogs)){ 
	for($i=0;$i<count($OppoProductLogs);$i++){    ?>
	<tr  >  
		<td align="right"><?php  echo $OppoProductLogs[$i]->LogDateTime; ?></td>  
		<!-- <td align="right"><?php  //if($BookingLogs[$i]->UpdateType=='1'){ echo "Add"; }else{ echo "Edit"; } ?></td>   -->
		<td align="left" ><?php  echo $OppoProductLogs[$i]->SitePage; ?></td>  
		<td align="left" ><?php  echo $OppoProductLogs[$i]->UpdatedValue; ?></td>  
		<td align="left"><?php echo $OppoProductLogs[$i]->CreatedByName;  ?></td>  
	</tr>
	<?php } } ?>
	</tbody>	
</table> 
<?php } ?> 
</div> 