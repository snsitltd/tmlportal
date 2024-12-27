<?php $cls1=""; 
//var_dump($DriverTodayTAList); 
$dl = array();
for($i=0;$i<count($DriverTodayTAList);$i++){
	$dl[$i]=$DriverTodayTAList[$i]['DriverID'];
}
//var_dump($dl);
//$AlloDrv = implode(',',$DriverTodayTAList[0]);
//print_r(array_values($DriverTodayTAList));
//exit;

?>
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Loads/Lorry Booking Allocation </h1>    </section> 
    <section class="content"> 
		<?php 
			$error = $this->session->flashdata('error');
			if($error){
		?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('error'); ?>                    
		</div>
		<?php } ?>
		<?php  
			$success = $this->session->flashdata('success');
			if($success){
		?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
		<?php } ?>  
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:600px"> 
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Booking Loads/Lorry Information </h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div> 
				  <div class="modal-body"></div> 
				  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div> 
				</div>
			</div>
		</div>  
                                  
		<div class="row"> 
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#Today" data-toggle="tab" aria-expanded="true">Today's </a></li> 
						<li class=""><a href="#Pending" data-toggle="tab" aria-expanded="false">OverDue </a></li> 
						<li class=""><a href="#Future" data-toggle="tab" aria-expanded="false">Future </a></li> 
						<li class=""><a href="#Finished" data-toggle="tab" aria-expanded="false">Finished</a></li>     
					</ul> 
					<div class="tab-content"> 
						<div class="tab-pane active" id="Today">   
							<div class="row">
								<div class="col-xs-12">
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Today's Loads/Lorry Booking Allocation</h3>
	</div>   
	<div class="box-body" >
		<div id="example2_wrapper" style="min-height:500px" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
			  <table id="ticket-grid1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
			  <thead>
				<tr> 
					<th width="10" align="right">BNO </th>                        
					<th width="10" align="right">Type</th>                        
					<th width="88" > Request Date </th>                        
					<th >Company Name</th>
					<th >Site Name</th>    
					<th >Material</th>    
					<th width="75" >Load/Lorry Type</th>     
					<th width="20" >No. Of Loads/Lorry </th>      
					<th width="20" >Pending Allocate</th> 
					<th >Tip Address</th>    
					<th >Qty</th>
					<th >Driver</th>      
					<th width="50" >Action</th>     
				</tr>
				</thead> 
				<tbody>
				<?php
				if(!empty($TodayBookingRecords)){
					//var_dump($LorryRecords);
					foreach($TodayBookingRecords as $key=>$record){   
						$lr = array();  $tloads = 0; $pLoads = 0;
						if($record->BookingType ==1){ $cls1='even1'; $lr = explode(',',$record->al_driver_c);  } 
						if($record->BookingType ==2){ $cls1='odd1'; $lr = explode(',',$record->al_driver_d);   }   
						if($record->LoadType ==1){  $pLoads = (int)($record->Loads-$record->TotalLoadAllocated - $record->CancelLoads); $cls =  "driverlstd"; }
						if($record->LoadType ==2){  $pLoads = (int)($record->Loads-$record->DistinctLorry - $record->CancelLoads); $cls =  "driverlstd"; }	 
						//$tloads = (int)$record->Loads-(int)$pLoads;
						$tloads = (int)$pLoads;
							
				?>
				<tr class="<?php echo $cls1; ?>">
					<td ><a class="ShowLoads" data-BookingNo="<?php echo $record->BookingID; ?>" herf="#" ><i class="fa fa-plus-circle"></i> <?php echo $record->BookingID; ?></a></td>
					<td><?php if($record->BookingType ==1){ echo "Collection"; }if($record->BookingType ==2){ echo "Delivery"; } ?></td>
					<td><?php echo $record->BookingDateTime ?></td> 
					<td><a href="<?php echo base_url('view-company/'.$record->CompanyID); ?>" target="_blank" title="<?php echo $record->CompanyName; ?>">
					<?php echo $record->CompanyName ?></a></td>
					<td><a href="<?php echo base_url('View-Opportunity/'.$record->OpportunityID); ?>" target="_blank" title="<?php echo $record->OpportunityName ?>"><?php echo $record->OpportunityName ?></a></td>
					<td><?php echo $record->MaterialName ?></td>
					<td><?php if($record->LoadType==1){ echo "Fixed"; } if($record->LoadType==2){ echo "TurnAround"; } ?></td>
					<td><a href="#"  data-BookingNo="<?php echo $record->BookingID; ?>"  class="ShowLoads" id="TotalLoads<?php echo $record->BookingDateID; ?>" ><?php echo (int)$record->Loads ?></a></td>
					<td><a href="#"  data-BookingDateID="<?php echo $record->BookingDateID; ?>" data-LoadType="<?php echo $record->LoadType; ?>"  class="ShowLoads1" id="loads<?php echo $record->BookingDateID; ?>" ><?php echo (int)$pLoads; ?></a></td> 
					<td ><div id="t<?php echo $record->BookingDateID; ?>"><select  class="form-control tiplst1 selectpicker " data-live-search="true" style="width:120px" id="tip<?php echo $record->BookingDateID; ?>" name="tip<?php echo $record->BookingDateID; ?>"  >
					<?php echo $tloads; if(!empty($TipRecords)){ foreach ($TipRecords as $rl){ ?>
							<option value="<?php echo $rl->TipID ?>" ><?php echo $rl->TipName ?></option>
							<?php
						}}
					?>
					</select></div></td> 
					<td ><div id="q<?php echo $record->BookingDateID; ?>">
					<select  class="form-control selectpicker " data-live-search="true" style="width:200px" id="qty<?php echo $record->BookingDateID; ?>" name="qty<?php echo $record->BookingDateID; ?>"  >
					<?php if($tloads!=0){ for($i=0;$i<$tloads;$i++){ ?>
							<option value="<?php echo $i+1 ?>" <?php if($i+1==1){ echo "checked"; } ?> > <?php echo $i+1; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
					<?php }} ?>
					</select></div></td> 
					<td ><div id="d<?php echo $record->BookingDateID; ?>"><select  class="form-control 	<?php echo $cls; ?> selectpicker" data-live-search="true" style="width:120px" id="driver<?php echo $record->BookingDateID; ?>" name="driver<?php echo $record->BookingDateID; ?>"  >
					<?php if(!empty($LorryRecords1)){ foreach ($LorryRecords1 as $rl){ if (!in_array($rl->LorryNo, $dl)) { ?>
						<option value="<?php echo $rl->LorryNo ?>" ><?php echo $rl->LorryNo.' | '.$rl->DriverName.' | '.$rl->RegNumber ?></option>
					<?php }} } ?>
					<?php if(!empty($LorryListNonApp)){ foreach ($LorryListNonApp as $rl){ 
					if($rl->ContractorLorryNo!=0){ $ln = $rl->ContractorLorryNo; }else{ $ln = $rl->LorryNo;  }
					if (!in_array($rl->LorryNo, $dl)) { ?>
					<option value="<?php echo $rl->LorryNo ?>" ><?php echo $rl->DriverName.' | '.$ln ?></option>
					<?php } } } ?>
					</select></div></td> 													
					<td class="text-center">
					<div id="all<?php echo $record->BookingDateID; ?>"><input type="hidden" name= "MID<?php echo $record->BookingDateID; ?>" id= "MID<?php echo $record->BookingDateID; ?>"  value="<?php echo $record->MaterialID; ?>" >
					<a class="btn btn-sm  btn-info AllocateBooking" herf="#" data-BookingNo="<?php echo $record->BookingID; ?>"  data-BookingDateID="<?php echo $record->BookingDateID; ?>"   title="Allocate Booking">
					<i class="fa fa-check"></i> </a></div> 
					</td>
				</tr>
				<?php
					}
				}else{ ?>  
				<?php } ?>
				</tbody>	
				
			  </table>  
		</div>
	</div>
	</div>
	</div> 
</div> 
								</div>
						</div>
						</div>
						<div class="tab-pane" id="Pending">   
							<div class="box">
	<div class="box-header">
		<h3 class="box-title">OverDue Loads/Lorry Booking Allocation</h3>
	</div> 
	<div class="box-body" >
		<div id="example2_wrapper" style="min-height:500px" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
			  <table id="ticket-grid2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
			  <thead>
				<tr> 
					<th width="10" align="right">BNO </th>                        
					<th width="10" align="right">Type</th>                        
					<th width="85" > Request Date </th>                        
					<th >Company Name</th>
					<th >Site Name</th>    
					<th >Material</th>    
					<th width="75" >Load/Lorry Type</th>     
					<th width="20" >No. Of Loads/Lorry </th>      
					<th width="20" >Pending Allocate</th>   
					<th >Tip Address</th>    
					<th >Qty</th>					
					<th >Driver</th>      
					<th width="50" >Action</th>    
				</tr>
				</thead> 
				<tbody>
				<?php
				if(!empty($OverdueBookingRecords)){
					foreach($OverdueBookingRecords as $key=>$record){  
						$lr = array(); $pLoads=0; $tloads = 0;
						if($record->BookingType ==1){ $cls1='even1';  $lr = explode(',',$record->al_driver_c);  } 
						if($record->BookingType ==2){ $cls1='odd1'; $lr = explode(',',$record->al_driver_d);   }   
						
						if($record->LoadType ==1){ $pLoads = (int)($record->Loads - $record->TotalLoadAllocated - $record->CancelLoads);  $cls =  "driverlstd"; }
						if($record->LoadType ==2){ $pLoads = (int)($record->Loads - $record->DistinctLorry - $record->CancelLoads); $cls =  "driverlstd"; }	 
						 
					?>
				<tr  class="<?php echo $cls1; ?>">
					<td ><a class="ShowLoads" data-BookingNo="<?php echo $record->BookingID; ?>" herf="#" ><i class="fa fa-plus-circle"></i> <?php echo $record->BookingID; ?></a></td>
					<td><?php if($record->BookingType ==1){ echo "Collection"; }if($record->BookingType ==2){ echo "Delivery"; } ?></td>
					<td><?php echo $record->BookingDateTime ?></td> 
					<td><a href="<?php echo base_url('view-company/'.$record->CompanyID); ?>" target="_blank" title="<?php echo $record->CompanyName; ?>">
					<?php echo $record->CompanyName ?></a></td>
					<td><a href="<?php echo base_url('View-Opportunity/'.$record->OpportunityID); ?>" target="_blank" title="<?php echo $record->OpportunityName ?>"><?php echo $record->OpportunityName ?></a></td>
					<td><?php echo $record->MaterialName ?></td>
					<td><?php if($record->LoadType==1){ echo "Fixed"; } if($record->LoadType==2){ echo "TurnAround"; } ?></td>
					<td><a href="#"  data-BookingNo="<?php echo $record->BookingID; ?>"  class="ShowLoads" id="TotalLoads<?php echo $record->BookingDateID; ?>" ><?php echo (int)$record->Loads ?></a></td>
					<td><a href="#" id="PEN<?php echo $record->BookingDateID; ?>" data-BookingDateID="<?php echo $record->BookingDateID; ?>" data-LoadType="<?php echo $record->LoadType; ?>"  class="ShowLoads1" id="loads<?php echo $record->BookingDateID; ?>" ><?php echo (int)$pLoads; ?><?php //echo $record->PendingAllocated; ?></a></td> 
					
					<td ><div id="t<?php echo $record->BookingDateID; ?>"><select  class="form-control tiplst1 selectpicker " data-live-search="true" style="width:120px" id="tip<?php echo $record->BookingDateID; ?>" name="tip<?php echo $record->BookingDateID; ?>"  >
					<?php if(!empty($TipRecords)){ foreach ($TipRecords as $rl){ ?>
							<option value="<?php echo $rl->TipID ?>" ><?php echo $rl->TipName ?></option>
					<?php }} ?>
					</select></div></td>
					<td ><div id="q<?php echo $record->BookingDateID; ?>">
					<select  class="form-control selectpicker " data-live-search="true" style="width:200px" id="qty<?php echo $record->BookingDateID; ?>" name="qty<?php echo $record->BookingDateID; ?>"  >
					<?php if($pLoads!=0){ for($i=0;$i<$pLoads;$i++){ ?>
							<option value="<?php echo $i+1 ?>" <?php if($i+1==1){ echo "checked"; } ?> > <?php echo $i+1; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
					<?php }} ?>
					</select></div></td> 
					<td ><div id="d<?php echo $record->BookingDateID; ?>"><select  class="form-control 	<?php echo $cls; ?> selectpicker" data-live-search="true" style="width:120px" id="driver<?php echo $record->BookingDateID; ?>" name="driver<?php echo $record->BookingDateID; ?>"  >
					<?php if(!empty($LorryRecords1)){ foreach ($LorryRecords1 as $rl){  if (!in_array($rl->LorryNo, $dl)) {   ?>
						<option value="<?php echo $rl->LorryNo ?>" ><?php echo $rl->LorryNo.' | '.$rl->DriverName.' | '.$rl->RegNumber ?></option>
					<?php }} }?>
					<?php if(!empty($LorryListNonApp)){ foreach ($LorryListNonApp as $rl){ 
					if($rl->ContractorLorryNo!=0){ $ln = $rl->ContractorLorryNo; }else{ $ln = $rl->LorryNo;  }
					if (!in_array($rl->LorryNo, $dl)) { ?>
					<option value="<?php echo $rl->LorryNo ?>" ><?php echo $rl->DriverName.' | '.$ln ?></option>
					<?php } } } ?>
					</select></div></td> 													
					<td class="text-center">
					<div id="all<?php echo $record->BookingDateID; ?>">
					<input type="hidden" name= "MID<?php echo $record->BookingDateID; ?>" id= "MID<?php echo $record->BookingDateID; ?>"  value="<?php echo $record->MaterialID; ?>" >
					<a class="btn btn-sm  btn-info AllocateBooking" herf="#" data-BookingNo="<?php echo $record->BookingID; ?>" data-BookingDateID="<?php echo $record->BookingDateID; ?>"  title="Allocate Booking"><i class="fa fa-check"></i> </a>
					<a class="btn btn-sm btn-danger DeleteBooking"  data-BookingDateID="<?php echo $record->BookingDateID; ?>"  href="#" title="Delete"><i class="fa fa-trash"></i></a>
					 
					</div> 
					</td>
				</tr>
				<?php
					}
				}else{ ?>  
				<?php } ?>
				</tbody>	
				
			  </table>  
		</div>
	</div>
	</div>
	</div> 
</div> 
						</div>
						<div class="tab-pane" id="Future">   
							<div class="row">
								<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Future Loads/Lorry Booking Allocation</h3>
									</div> 
<div class="box-body" >
	<div id="example2_wrapper" style="min-height:500px" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
		  <table id="ticket-grid3" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
		  <thead>
			<tr > 
				<th width="10" align="right">BNO </th>                        
				<th width="10" align="right">Type</th>                        
				<th width="85" > Request Date </th>                        
				<th >Company Name</th>
				<th >Site Name</th>    
				<th >Material</th>    
				<th width="75" >Load/Lorry Type</th>     
				<th width="20" >No. Of Loads/Lorry </th>      
				<th width="20" >Pending Allocate</th>  
				<th >Tip Address</th>    
				<th >Qty</th>			 
				<th >Driver</th>      
				<th >Action</th>    
			</tr>
			</thead> 
			<tbody>
			<?php
			if(!empty($BookingRecords)){ 
				foreach($BookingRecords as $key=>$record){ 
						$lr = array(); $lr = explode(',',$record->al_driver); 
						if($record->BookingType ==1){ $cls1='even1';  } 
						if($record->BookingType ==2){ $cls1='odd1'; }
						if($record->LoadType ==1){  $pLoads = (int)($record->Loads-$record->TotalLoadAllocated); }
						if($record->LoadType ==2){  $pLoads = (int)($record->Loads-$record->DistinctLorry); }	 
						//$tloads = (int)$record->Loads-(int)$pLoads;
						$tloads = (int)$pLoads;		
				?>
			<tr  class="<?php echo $cls1; ?>" >
				<td ><a class="ShowLoads" data-BookingNo="<?php echo $record->BookingID; ?>" herf="#" ><i class="fa fa-plus-circle"></i> <?php echo $record->BookingID; ?></a></td>
				<td><?php if($record->BookingType ==1){ echo "Collection"; }if($record->BookingType ==2){ echo "Delivery"; } ?></td>
				<td><?php echo $record->BookingDateTime ?></td> 
				<td><a href="<?php echo base_url('view-company/'.$record->CompanyID); ?>" target="_blank" title="<?php echo $record->CompanyName; ?>">
				<?php echo $record->CompanyName ?></a></td>
				<td><a href="<?php echo base_url('View-Opportunity/'.$record->OpportunityID); ?>" target="_blank" title="<?php echo $record->OpportunityName ?>"><?php echo $record->OpportunityName ?></a></td>
				<td><?php echo $record->MaterialName ?></td>
				<td><?php if($record->LoadType==1){ echo "Fixed"; } if($record->LoadType==2){ echo "TurnAround"; } ?></td>
				<td><a href="#"  data-BookingNo="<?php echo $record->BookingID; ?>"  class="ShowLoads" id="TotalLoads<?php echo $record->BookingDateID; ?>" ><?php echo (int)$record->Loads ?></a></td>
				<td><a href="#"   data-BookingDateID="<?php echo $record->BookingDateID; ?>" data-LoadType="<?php echo $record->LoadType; ?>"  class="ShowLoads1" id="loads<?php echo $record->BookingDateID; ?>" ><?php echo (int)$pLoads; ?></a></td> 
				
				<td ><div id="t<?php echo $record->BookingDateID; ?>"><select  class="form-control tiplst1 selectpicker " data-live-search="true" style="width:120px" id="tip<?php echo $record->BookingDateID; ?>" name="tip<?php echo $record->BookingDateID; ?>"  >
				<?php if(!empty($TipRecords)){ foreach ($TipRecords as $rl){ ?>
						<option value="<?php echo $rl->TipID ?>" ><?php echo $rl->TipName ?></option>
						<?php
					}}
				?>
				</select></div></td>
				<td ><div id="q<?php echo $record->BookingDateID; ?>">
					<select  class="form-control selectpicker " data-live-search="true" style="width:200px" id="qty<?php echo $record->BookingDateID; ?>" name="qty<?php echo $record->BookingDateID; ?>"  >
					<?php if($tloads!=0){ for($i=0;$i<$tloads;$i++){ ?>
							<option value="<?php echo $i+1 ?>" <?php if($i+1==1){ echo "checked"; } ?> > <?php echo $i+1; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
					<?php }} ?>
					</select></div></td> 
				<td ><div id="d<?php echo $record->BookingDateID; ?>"><select  class="form-control 	<?php echo $record->BookingDateTime ?> selectpicker" data-live-search="true" style="width:120px" id="driver<?php echo $record->BookingDateID; ?>" name="driver<?php echo $record->BookingDateID; ?>"  >
				<?php if(!empty($LorryRecords)){ foreach ($LorryRecords as $rl){ //if(!in_array($rl->LorryNo, $lr)){ ?>
						<option value="<?php echo $rl->LorryNo ?>" ><?php echo $rl->DriverName; ?></option>
				<?php }} //} ?>
				<?php if(!empty($LorryListNonApp)){ foreach ($LorryListNonApp as $rl){  ?>
					<option value="<?php echo $rl->LorryNo ?>" ><?php echo $rl->DriverName.' | '.$rl->ContractorLorryNo ?></option>
					<?php } } ?>
				</select></div></td> 													
				<td class="text-center">
				<div id="all<?php echo $record->BookingDateID; ?>">
				<input type="hidden" id= "dt<?php echo $record->BookingDateID; ?>"  value="<?php echo $record->BookingDateTime1; ?>" >
				<input type="hidden" name= "MID<?php echo $record->BookingDateID; ?>" id= "MID<?php echo $record->BookingDateID; ?>"  value="<?php echo $record->MaterialID; ?>" >
				<a class="btn btn-sm  btn-info AllocateBooking1" herf="#" data-BookingNo="<?php echo $record->BookingID; ?>"  data-BookingDate="<?php echo $record->BookingDateTime; ?>"  data-BookingDateID="<?php echo $record->BookingDateID; ?>"   title="Allocate Booking"><i class="fa fa-check"></i> </a></div> 
				</td>
			</tr>
			<?php
					}
				}else{ ?>  
				<?php } ?>
			</tbody>	
			
		  </table>  
	</div>
</div>
</div>
</div> 
								</div> 
								</div>
						</div>
						</div>
						<div class="tab-pane" id="Finished"> 
							<div class="row">
								<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Allocated Loads/Lorry </h3>
									</div> 
									<div class="box-body" >
										<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
											  <table id="ticket-grid4" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
											  <thead>
												<tr> 
													<th width="10" align="right">BNO </th>                        
													<th width="10" align="right">Type</th>                        
													<th width="100" > Request Date </th>                        
													<th >Company Name</th>
													<th >Site Name</th>    
													<th >Material</th>    
													<th width="75" >Load/Lorry Type</th>     
													<th width="20" >No. Of Loads/Lorry </th> 
												</tr>
												</thead>  
											  </table> 
										</div>
									</div>
									</div>
									</div> 
								</div> 
								</div>
							</div>
						
						</div> 
					</div>  
				</div> 
			</div>
		 
            
        </div> 
        
    </section>
</div>  

<script type="text/javascript" language="javascript" >
	  
	$(document).ready(function() { 
		 
		$('#ticket-grid1').DataTable({
			"order": [[ 0, "desc" ]], 
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		});
		$('#ticket-grid2').DataTable({
			"order": [[ 0, "desc" ]], 
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		});
		$('#ticket-grid3').DataTable({
			"order": [[ 0, "desc" ]], 
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		});
		
		var dataTable = $('#ticket-grid4').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 0, "desc" ]],
			"columns": [
				{ "data": "BookingID" ,"name": "BookingID"  },
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "BookingDateTime" ,"name": "BookingDateTime" },
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" },
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "LoadType" , "name": "LoadType" },  
				{ "data": "Loads" , "name": "Loads" } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxAllocatedBookings1') ?>", // json datasource
				type: "post",  // method  , by default get
				error: function(e){  // error handling
				//alert(e);
				//console.log(e);     
					$(".ticket-grid-error").html("");
					$("#ticket-grid").append('<tbody class="ticket-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#ticket-grid_processing").css("display","none");							
				}//,
				//success: function (data) { 
					 //data = JSON.parse(data);
				//   alert(JSON.stringify( data )); 
 				//} 
			}, 
			columnDefs: [{ data: null, targets: -1 }],   
			createdRow: function (row, data, dataIndex) {  
				var btype = '';var Ltype ="";
				if(data["BookingType"] ==1){ $(row).addClass("even1");   btype = 'Collection' ; }else{ $(row).addClass("odd1");  btype = 'Delivery' ;  } 
				if(data["LoadType"]==1){ Ltype = "Fixed"; } if(data["LoadType"]==2){ Ltype = "TurnAround"; } 
				
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingNo="'+data["BookingID"]+'" herf="#" ><i class="fa fa-plus-circle"></i> '+data["BookingID"]+'</a>'); 
				$(row).find("td:eq(1)").html(btype); 
				$(row).find("td:eq(3)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(4)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(6)").html(Ltype); 
				$(row).find("td:eq(7)").html('<a href="#"  data-BookingNo="'+data["BookingID"]+'"  class="ShowLoads" id="TotalLoads'+data["BookingDateID"]+'" >'+data["Loads"]+'</a> '); 
				 
				//if(data["LoadType"]==1){ 
				//	$(row).find("td:eq(8)").html('-'); 
				//}else {   
				//	$(row).find("td:eq(8)").html(data["Days"]); 
				//}  				
			//	$(row).find("td:eq(-1)").html('<span class="label label-danger ShowLoads" data-BookingNo="'+data["BookingID"]+'" ><i class="fa fa-check"></i> Allocated </span>');	
			}
		});
		 
		jQuery(document).on("click", ".AllocateBooking", function(){  
				var BookingID = $(this).attr("data-BookingNo"),
					BookingDateID = $(this).attr("data-BookingDateID"),
					DriverID = $('#driver'+BookingDateID).val(),
					Driver = $("#driver"+BookingDateID+" option:selected").html(); 
					TipID = $('#tip'+BookingDateID).val(),
					Qty = $('#qty'+BookingDateID).val(),
					MaterialID = $('#MID'+BookingDateID).val(),
					AllocatedDateTime = $('#dt'+BookingDateID).val(),
					Loads = $('#loads'+BookingDateID).html(), 			
					TotalLoads = $('#TotalLoads'+BookingDateID).html(),
					hitURL1 = baseURL + "AllocateBookingAJAX",
					currentRow = $(this); 
			if(Driver!=undefined){ 
				var confirmation = confirm("Driver Details: "+Driver+"  \r\n\r\nAre You Sure ? You want to Confirm This Load ? ");
				//console.log(confirmation);
				if(confirmation!=null){ 
					if(confirmation!=""){ 
						jQuery.ajax({
						type : "POST",
						dataType : "json",
						url : hitURL1,
						data : { 'BookingID' : BookingID,'BookingDateID' : BookingDateID,'BookingDate' : '','DriverID' :DriverID,'TipID' :TipID,'Qty' :Qty,'AllocatedDateTime' :AllocatedDateTime,'MaterialID' :MaterialID,'Loads' :Loads,'TotalLoads' :TotalLoads,'confirmation' :confirmation } 
						}).success(function(data){ 
							//alert(JSON.stringify( data ));   
							//console.log(data);  
							if(data.status == true) { 
								jQuery('#loads'+data.BookingDateID).html(parseInt(data.loads));  
								for (i = 0; i < parseInt(data.Alloloads); i++) { 
								  jQuery("select[name=qty"+data.BookingDateID+"] option:last").remove(); 
								}
								jQuery("#qty"+data.BookingDateID).selectpicker('refresh');		
								//if(data.BookingType==1){
								//	jQuery(".driverlstc option[value='"+DriverID+"']").remove();
								//	$('.driverlstc').selectpicker('refresh');		
								//}		
								if(data.LoadType==2){
									jQuery(".driverlstd option[value='"+DriverID+"']").remove();
									$('.driverlstd').selectpicker('refresh');		
								}
								if(parseInt(data.loads) ==0){ 
									currentRow.parents('tr').remove(); 
								} 
							}else{ 
								alert("Oooops, Please try again later"); 
							}  
						}); 
					}
				}
			}else{ alert("Please Select Driver. "); }	
				
		});
		jQuery(document).on("click", ".AllocateBooking1", function(){  
				var BookingID = $(this).attr("data-BookingNo"),
					BookingDateID = $(this).attr("data-BookingDateID"),
					BookingDate = $(this).attr("data-BookingDate"),
					DriverID = $('#driver'+BookingDateID).val(),
					Driver = $("#driver"+BookingDateID+" option:selected").html(); 
					TipID = $('#tip'+BookingDateID).val(),
					Qty = $('#qty'+BookingDateID).val(),
					MaterialID = $('#MID'+BookingDateID).val(),
					AllocatedDateTime = $('#dt'+BookingDateID).val(),
					Loads = $('#loads'+BookingDateID).html(), 			
					TotalLoads = $('#TotalLoads'+BookingDateID).html(),
					hitURL1 = baseURL + "AllocateBookingAJAX",
					currentRow = $(this);  
				var confirmation = confirm("Driver Details: "+Driver+"  \r\n\r\nAre You Sure ? You want to Confirm This Load ? ");
				//console.log(confirmation);
				if(confirmation!=null){ 
					if(confirmation!=""){ 
						jQuery.ajax({
						type : "POST",
						dataType : "json",
						url : hitURL1,
						data : { 'BookingID' : BookingID,'BookingDateID' : BookingDateID,'BookingDate' : BookingDate,'DriverID' :DriverID,'TipID' :TipID,'Qty' :Qty,'AllocatedDateTime' :AllocatedDateTime,'MaterialID' :MaterialID,'Loads' :Loads,'TotalLoads' :TotalLoads,'confirmation' :confirmation } 
						}).success(function(data){ 
							//alert(JSON.stringify( data ));   
							//console.log(data);  
							if(data.status == true) { 
								jQuery('#loads'+data.BookingDateID).html(parseInt(data.loads));  
								for (i = 0; i < parseInt(data.Alloloads); i++) { 
								  jQuery("select[name=qty"+data.BookingDateID+"] option:last").remove(); 
								}
								jQuery("#qty"+data.BookingDateID).selectpicker('refresh');		
								//jQuery("."+data.BookingDate+" option[value='"+DriverID+"']").remove();
								//$("."+data.BookingDate).selectpicker('refresh');		
								if(parseInt(data.loads) ==0){ 
									currentRow.parents('tr').remove(); 
								} 
							}else{ 
								alert("Oooops, Please try again later"); 
							}  
						}); 
					}
				}
		});
		jQuery(document).on("click", ".ShowLoads", function(){  
		//$('#empModal').modal('show');  
				var BookingID = $(this).attr("data-BookingNo"), 
					hitURL1 = baseURL + "ShowLoadsAJAX",
					currentRow = $(this);  
				//console.log(confirmation); 
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingID' : BookingID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Booking Loads / Lorry Information");
					$('#empModal .modal-dialog').width(1200);
					$('#empModal').modal('show');  
				});  
				 
		});
		jQuery(document).on("click", ".ShowLoads1", function(){  
		//$('#empModal').modal('show');  
				var BookingDateID = $(this).attr("data-BookingDateID"),  
					LoadType = $(this).attr("data-LoadType"), 
					hitURL1 = baseURL + "ShowLoadsAJAX1",
					currentRow = $(this);  
				//console.log(confirmation); 
				//alert(LoadType)
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingDateID' : BookingDateID,'LoadType' : LoadType } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Booking Loads / Lorry Information");
					$('#empModal .modal-dialog').width(600);
					$('#empModal').modal('show');  
				});  
				 
		});
		jQuery(document).on("click", ".DeleteBooking", function(){  
		//$('#empModal').modal('show');  
				var BookingDateID = $(this).attr("data-BookingDateID"),  
					PendingLoads = $('#PEN'+BookingDateID).html();
					hitURL1 = baseURL + "ShowLoadsDeleteBookingAJAX",
					currentRow = $(this);  
				//console.log(confirmation); 
				//alert(PendingLoads)
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingDateID' : BookingDateID,'PendingLoads' : PendingLoads } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Booking Loads / Lorry Information");
					$('#empModal .modal-dialog').width(500);
					$('#empModal').modal('show');  
				});  
				 
		});
		jQuery(document).on("click", ".deleteTicket", function(){ 
			var BookingNo = $(this).attr("data-BookingNo"),
				hitURL = baseURL + "DeleteBooking",
				currentRow = $(this);	  
			var confirmation = confirm(" Are You Sure ? You want to Delete This Booking ? ");
			//console.log(confirmation);
			if(confirmation!=null){ 
				if(confirmation!=""){
					//console.log("Your comment:"+confirmation);
					//alert(confirmation);
					jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL,
					data : { 'BookingNo' : BookingNo,'confirmation' :confirmation } 
					}).success(function(data){
						//console.log(data);  
						if(data.status != "") { currentRow.parents('tr').remove(); alert("Booking has been Deleted"); }
						else{ alert("Oooops, Please try again later"); } 
					}); 
				}
			}
		}); 
		   
	});
	

	//jQuery.fn.UpdateDriverDD(); 
</script>