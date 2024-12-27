  
<div >
<?php if(!empty($PriceLogs)){ ?>
<table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" >
	<thead>
		<tr> 
			<th width="5" align="right">No.</th>                        
			<th >Updated By </th>              
			<th width="115" >Log DateTime</th>          
		</tr>
	</thead> 
	 <tbody>
	<?php   
	if(!empty($PriceLogs)){ 
	for($i=0;$i<count($PriceLogs);$i++){    ?>
	<tr class="<?php echo $cls1; ?>">  
		<td width="5" align="right"><?php echo $i+1; ?></td>                        
	<td align="left"><?php echo $PriceLogs[$i]->CreatedByName."( ".$PriceLogs[$i]->CreatedByMobile." )";  ?></td> 
		<td width="100" align="right"><?php  echo $PriceLogs[$i]->LogDateTime; ?></td> 
	</tr>
	<?php } } ?>
	</tbody>	
</table> 
<?php } ?> 
</div> 