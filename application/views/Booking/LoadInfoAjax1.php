 
<table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" >
	<thead>
		<tr>  
			<th width="3">Qty</th>    
			<th align="Left">Driver Name </th>    
			<th width="80" align="Left">Tip Name</th>  
			
		</tr>
	</thead> 
	 <tbody>
	<?php   
	if(!empty($Loads)){ 
	for($i=0;$i<count($Loads);$i++){   ?>
	<tr>  
		<td  align="right"><?php echo $Loads[$i]->QTY; ?></td>                        
		<td  align="Left"><?php if($Loads[$i]->DriverName!=""){ echo $Loads[$i]->DriverName; }else{ echo $Loads[$i]->dname; } ?></td> 
		<td  align="Left"><?php echo $Loads[$i]->TipName ?></td>   
	</tr>
	<?php } } ?>
	</tbody>	
</table>  