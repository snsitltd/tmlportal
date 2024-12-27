<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> NonApp Users Loads/Lorry </h1>    </section> 
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
			<div class="modal-dialog" style="width:1200px">  
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">  NonApp Users Loads/Lorry Information </h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div> 
				  <div class="modal-body"></div> 
				  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div> 
				</div>
			</div>
		</div>   
		<?php //var_dump($NonAppsLoads); ?>
		<div class="row"> 
			<div class="col-md-12">   
				<div class="row">
					<div class="col-xs-12">
						<form id="subcontractor" name="subcontractor" action="<?php echo base_url('NonAppsLoads'); ?>" method="post" role="form" > 
						<div class="box"> 
							<div class="box-body"> 
								<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
									  <table id="ticket-grid11111" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
									  <thead>
										<tr>    
											<th width="10" align="right">BNO </th>   
											<th width="30" align="right">Conveyance </th>  													
											<th width="10" align="right">Type</th>                        
											<th width="70" > Request Date </th>                        
											<th width="150" >Company Name</th>
											<th >Site Name</th>    
											<th width="210">Material</th>         
											<th width="30" >Loads/Lorry Type</th>     
											<th width="80" >Driver Name </th>    
											<th >VRNO </th>     
											<th width="120">Allo. DateTime </th> 
											<th width="30">Action</th> 
										</tr>
						<?php
				if(!empty($NonAppsLoads)){ 
					foreach($NonAppsLoads as $key=>$record){    
						if($record->BookingType ==1){ $cls1='even1';  } 
						if($record->BookingType ==2){ $cls1='odd1';   }    
				?>
				<tr class="<?php echo $cls1; ?>">
					<td ><a class="ShowLoads" data-BookingDateID="<?php echo $record->BookingDateID; ?>" herf="#" ><?php echo $record->BookingID; ?></a></td>
					<td><?php echo $record->ConveyanceNo ?></td> 
					<td><?php if($record->BookingType ==1){ echo "Collection"; }if($record->BookingType ==2){ echo "Delivery"; } ?></td>
					<td><?php echo $record->BookingDateTime ?></td> 
					<td><a href="<?php echo base_url('view-company/'.$record->CompanyID); ?>" target="_blank" title="<?php echo $record->CompanyName; ?>">
					<?php echo $record->CompanyName ?></a></td>
					<td><a href="<?php echo base_url('View-Opportunity/'.$record->OpportunityID); ?>" target="_blank" title="<?php echo $record->OpportunityName ?>"><?php echo $record->OpportunityName ?></a></td>
					<td><?php echo $record->MaterialName ?></td>
					<td><?php if($record->LoadType==1){ echo "Fixed"; } if($record->LoadType==2){ echo "TurnAround"; } ?></td> 
					<td><?php echo $record->dDriverName ?></td>
					<td><?php echo $record->rname ?></td>
					<td><?php echo $record->CreateDateTime ?></td>
					
					<td class="text-center">
						<div id="all<?php echo $record->BookingDateID; ?>">
						<input type="hidden" name= "MID<?php echo $record->BookingDateID; ?>" id= "MID<?php echo $record->BookingDateID; ?>"  value="<?php echo $record->MaterialID; ?>" >
						<a class="btn btn-sm  btn-info UpdateLoad" herf="#" data-BookingNo="<?php echo $record->BookingID; ?>" data-BookingDateID="<?php echo $record->BookingDateID; ?>"  title="Finish Load"><i class="fa fa-pencil"></i> </a> 
						</div> 
					</td>
				</tr>
				<?php
					}
				}else{ ?>  
				<?php } ?>
										</thead>  
									  </table> 
								</div> 
							</div>
							</div>
							</div> 
							</form>	
						</div> 
					</div>
				</div>  
			</div> 
        </div>
    </section>
</div>  
<script type="text/javascript" language="javascript" >
	$(document).ready(function() {   
		//$('#TicketDate').datetimepicker({format: 'DD-MM-YYYY HH:mm' });   
//##############################################  Open Update Modal Box ##############################################

		jQuery(document).on("click", ".UpdateLoad", function(){  
				var BookingID = $(this).attr("data-BookingNo"), 
					BookingDateID = $(this).attr("data-BookingDateID"),  
					hitURL1 = baseURL + "UpdateBookingLoadAJAX",
					currentRow = $(this);    
					//alert(BookingDateID);  
					jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL1,
					data : { 'BookingID' : BookingID, 'BookingDateID' : BookingDateID } 
					}).success(function(data){ 
						//alert(data)
						$('.modal-body').html(data); 
						$('#empModal .modal-title').html("Modify Booking Load ");
						$('#empModal .modal-dialog').width(1000); 
						$('#empModal').modal('show');  
						
						//alert(JSON.stringify( data ));   
						//console.log(data);   
					}); 
					 
		});

		jQuery(document).on("click", ".LoadInfo", function(){   
		$('#empModal').modal('show');  
				var LoadID = $(this).attr("data-LoadID"), 
					hitURL1 = baseURL + "AJAXShowLoadsDetails",
					currentRow = $(this);  
				//console.log(confirmation); 
				//alert(LoadID)
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'LoadID' : LoadID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					$('#empModal').modal('show');  
				});  
				 
		});
		jQuery(document).on("click", ".ShowLoads", function(){   
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
				//	alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Booking Loads / Lorry Information");
					$('#empModal .modal-dialog').width(1200);
					$('#empModal').modal('show');  
				});   	 
		}); 		
		  
	}); 
</script>