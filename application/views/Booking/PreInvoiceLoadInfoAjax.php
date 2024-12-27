 
<table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" >
	<thead>
		<tr> 
			<th width="20" >Conv No.</th>                        
			<th width="20" >Ticket No.</th>               
			<th width="100">Ticket DateTime</th>        			
			<th width="100" align="right">Driver Name </th>                        
			<th width="50" > VRNO</th>                        
			<!-- <th  > Haulier</th>  -->
			<th width="40" > Gross</th> 
			<th width="40" > Tare</th> 
			<th width="40" > Net</th>  
			<th >Tip Name</th>
			<th >Material</th>         
			<th width="40" > WaitTime (Min)</th>  			
			<th width="30" > Wait Charges</th>  
			<th width="20">Status</th>    
			<th width="80" >Price</th>  
		</tr>
	</thead> 
	 <tbody>
	<?php   
	if(!empty($Loads)){ 
	for($i=0;$i<count($Loads);$i++){ 
		$cls1 = "";
		if($Loads[$i]->AutoCreated ==1){ $cls1='even1';  }else{ $cls1='odd1';   } ?>
	<tr class="<?php echo $cls1; ?>">  
		<td   align="right"><a href="<?php echo base_url('assets/conveyance/'.$Loads[$i]->ConvPDF); ?>" title="View Conveyance Ticket" target="_blank" > <?php echo $Loads[$i]->ConveyanceNo; ?></a></td>                        
		<td   align="right"><a href="<?php echo base_url('assets/pdf_file/'.$Loads[$i]->TicketPDF); ?>" title="View Ticket" target="_blank" > <?php echo $Loads[$i]->TicketNumber; ?></a></td>                        
		<td   align="right"><?php echo $Loads[$i]->TicketDate; ?></td>                        
		<td   ><?php  echo $Loads[$i]->DriverName; ?></td>
		<td  ><?php  echo $Loads[$i]->VehicleRegNo; ?></td>
		<!-- <td  ><?php  //echo $Loads[$i]->Haulier; ?></td>-->
		<td  align="right"><?php  echo $Loads[$i]->GrossWeight; ?></td>
		<td  align="right"><?php  echo $Loads[$i]->Tare; ?></td>
		<td  align="right"><?php  echo $Loads[$i]->Net; ?></td> 
		<td  ><?php echo $Loads[$i]->TipName ?></td>
		<td ><?php echo $Loads[$i]->MaterialName ?></td> 
		<td align="right" ><?php if($Loads[$i]->WaitTime>0){ echo $Loads[$i]->WaitTime; }else{ echo "0"; } ?></td> 
		<td align="right"  ><?php if($Loads[$i]->WaitTime>0){ echo ($Loads[$i]->WaitTime*$Loads[$i]->WaitingCharge); }else{ echo '0'; } ?></td>  
		<td  ><?php if($Loads[$i]->Status==0){ echo '<span class="label label-danger" > Pending </span>'; } 
		 if($Loads[$i]->Status==1){ echo '<span class="label label-warning" > Accepted </span>';  }  if($Loads[$i]->Status==2){ echo '<span class="label label-primary" > At Site </span>';  }
		 if($Loads[$i]->Status==3){  echo '<span class="label label-default" > Out Site </span>'; }  if($Loads[$i]->Status==4){ echo '<span class="label label-success" > Finish </span>';  } 
		 if($Loads[$i]->Status==5){  echo '<span class="label label-danger" > Cancel </span>'; }  if($Loads[$i]->Status==6){ echo '<span class="label label-danger" > Wasted </span>';  }  
		 ?>
		</td> 
		<td><input type="text" value="<?php echo $Loads[$i]->Price; ?>"  style="width:60px" name="LoadPrice<?php echo $Loads[$i]->LoadID; ?>" >
		<button class="btn btn-sm btn-info LoadPriceUpdate" type="button" name="Submit<?php echo $Loads[$i]->LoadID; ?>"  > OK </button>
		</td>
	</tr>
	<?php } } ?>
	</tbody>	
</table> 