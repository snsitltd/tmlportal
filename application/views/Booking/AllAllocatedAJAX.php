<?php if(!empty($Loads)){ ?>
<table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" >
	<thead>
		<tr> 
			<th width="5" align="right">No.</th>                        
			<th width="100" align="right">Driver Name </th>                        
			<th width="90" > VRNO</th>                        
			<th width="100" >Tip Name</th>
			<th >Material</th>     
			<th width="115">Allocate DateTime</th>        
			<th width="110">Accept DateTime</th>        
			<th width="20">Status</th>    
		</tr>
	</thead> 
	<tbody>
	<?php   
if(!empty($Loads)){ 
for($i=0;$i<count($Loads);$i++){ ?>
	<tr>  
		<td width="5" align="right"><?php echo $Loads[$i]->ConveyanceNo; ?></td>                        
		<td width="100" ><?php if($Loads[$i]->DriverName!=""){ echo $Loads[$i]->DriverName; }else{ echo $Loads[$i]->dname; } ?></td>
		<td width="90"><?php if($Loads[$i]->VehicleRegNo!=""){ echo $Loads[$i]->VehicleRegNo; }else{ echo $Loads[$i]->vrn; }  ?></td>
		<td width="100"><?php echo $Loads[$i]->TipName ?></td>
		<td ><?php echo $Loads[$i]->MaterialName ?></td>
		<td width="110"><?php  echo $Loads[$i]->CreateDateTime; ?></td>
		<td width="110"><?php if($Loads[$i]->Status!=0){ echo $Loads[$i]->JobStartDateTime; }else{ echo '-'; } ?></td>
		<td width="20"><?php if($Loads[$i]->Status==0){ echo '<span class="label label-danger" > Pending </span>'; } 
		 if($Loads[$i]->Status==1){ echo '<span class="label label-warning" > Accepted </span>';  }  if($Loads[$i]->Status==2){ echo '<span class="label label-primary" > At Site </span>';  }
		 if($Loads[$i]->Status==3){  echo '<span class="label label-default" > Out Site </span>'; }  if($Loads[$i]->Status==4){ echo '<span class="label label-success" > Finish </span>';  } ?>
		</td> 
	</tr>
	<?php } } ?>
	</tbody>	
</table> 
<?php } ?>