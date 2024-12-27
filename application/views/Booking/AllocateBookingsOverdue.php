<?php $cls1="";  ?>
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Overdue Loads/Lorry Booking Allocation </h1>    </section> 
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
				  <div class="TEST"></div> 
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
						<li ><a href="<?php echo base_url('AllocateBookings'); ?>" aria-expanded="true">Today's </a></li> 
						<li class="active" ><a href="#Pending" data-toggle="tab" aria-expanded="false">OverDue </a></li> 
						<li class=""><a href="<?php echo base_url('AllocateBookings'); ?>" aria-expanded="false">Future </a></li>     
						<li class=""><a href="<?php echo base_url('AllocateBookingsFinished'); ?>" aria-expanded="false">Finished </a></li>     
					</ul> 
					<div class="tab-content"> 
						 
						
						
						<div  class="tab-pane active"  id="Pending">   
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
					<th width="50" >Action</th>     
				</tr>
				</thead> 
				<tbody>
				<?php 
				if(!empty($OverdueBookingRecords)){
					foreach($OverdueBookingRecords as $key=>$record){  
						$pLoads=0;  
						if($record->BookingType ==1){ $cls1='even1';  } 
						if($record->BookingType ==2){ $cls1='odd1';  }   
						
						if($record->LoadType ==1){ $pLoads = (int)($record->Loads-$record->TotalLoadAllocated-$record->CancelLoads);   }
						if($record->LoadType ==2){ $pLoads = (int)($record->Loads-$record->DistinctLorry-$record->CancelLoads);  }	 
					?>
				<tr  class="<?php echo $cls1; ?>" id="<?php echo $record->BookingDateID; ?>">
					<td ><a class="ShowLoads" data-BookingDateID="<?php echo $record->BookingDateID; ?>" herf="#" ><?php echo $record->BookingID; ?></a></td>
					<td><?php if($record->BookingType ==1){ echo "Collection"; }if($record->BookingType ==2){ echo "Delivery"; } ?></td>
					<td><?php echo $record->BookingDateTime ?></td> 
					<td><a href="<?php echo base_url('view-company/'.$record->CompanyID); ?>" target="_blank" title="<?php echo $record->CompanyName; ?>">
					<?php echo $record->CompanyName ?></a></td>
					<td><a href="<?php echo base_url('View-Opportunity/'.$record->OpportunityID); ?>" target="_blank" title="<?php echo $record->OpportunityName ?>"><?php echo $record->OpportunityName ?></a></td>
					<td><?php echo $record->MaterialName ?></td>
					<td><?php if($record->LoadType==1){ echo "Fixed"; } if($record->LoadType==2){ echo "TurnAround"; } ?></td>
					<td><a href="#"  data-BookingDateID="<?php echo $record->BookingDateID; ?>"  class="ShowLoads" id="TotalLoads<?php echo $record->BookingDateID; ?>" ><?php echo (int)$record->Loads ?></a></td>
					<td><a href="#"  data-BookingDateID="<?php echo $record->BookingDateID; ?>" data-LoadType="<?php echo $record->LoadType; ?>"  class="ShowLoads1" id="loads<?php echo $record->BookingDateID; ?>" ><?php echo (int)$pLoads; ?></a></td>  			
					<td class="text-center">
					<div id="all<?php echo $record->BookingDateID; ?>">
					<input type="hidden" name= "MID<?php echo $record->BookingDateID; ?>" id= "MID<?php echo $record->BookingDateID; ?>"  value="<?php echo $record->MaterialID; ?>" >
					<a class="btn btn-sm  btn-info Allocate" herf="#" data-BookingNo="<?php echo $record->BookingID; ?>"  data-PendingLoad="<?php echo $pLoads; ?>"  data-LoadType="<?php echo $record->LoadType; ?>"  data-BookingDateID="<?php echo $record->BookingDateID; ?>"  title="Allocate Booking"><i class="fa fa-check"></i> </a>
					<a class="btn btn-sm btn-danger DeleteBooking"  data-BookingDateID="<?php echo $record->BookingDateID; ?>"  href="#" title="Delete"><i class="fa fa-trash"></i></a> 
					<a class="btn btn-sm btn-warning UpdateBookingQTY"  data-BookingID="<?php echo $record->BookingID; ?>"  data-BookingDateID="<?php echo $record->BookingDateID; ?>"  href="#" title="Update Qty"><i class="fa fa-edit"></i></a> 
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
					  
					</div>  
				</div> 
			</div>
		 
            
        </div> 
        
    </section>
</div>  

<script type="text/javascript" language="javascript" >
	  
	$(document).ready(function() { 
		 var dataTable2 = $('#ticket-grid2').DataTable({
			"order": [[ 0, "desc" ]], 
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		});
		 
		  
//##############################################  Open Allocate Modal Box ##############################################

		jQuery(document).on("click", ".Allocate", function(){  
				var BookingID = $(this).attr("data-BookingNo"), 
					BookingDateID = $(this).attr("data-BookingDateID"), 
					LoadType = $(this).attr("data-LoadType"), 
					PendingLoad = $(this).attr("data-PendingLoad"),  
					BookingDate = $(this).attr("data-BookingDate"),   
					hitURL1 = baseURL + "AllocateBookingAJAX1",
					currentRow = $(this);  
					
					//alert(LoadType);
					//alert(BookingDateID); 
					
					jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL1,
					data : { 'BookingID' : BookingID, 'BookingDateID' : BookingDateID ,'LoadType' : LoadType ,'PendingLoad' : PendingLoad ,'BookingDate' : BookingDate  } 
					}).success(function(data){ 
						//alert(data)
						$('.modal-body').html(data);
						
						$('#empModal .modal-title').html("Allocate Loads / Lorry ");
						$('#empModal .modal-dialog').width(1000); 
						$('#empModal').modal('show');  
						
						//alert(JSON.stringify( data ));   
						//console.log(data);   
					}); 
					 
		});

//##############################################  Allocate Booking for today and Overdue ##############################################

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
			if(Qty!="" && Qty>0){ 
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
								if(data.LoadType==1){
								for (i = 0; i < parseInt(data.Alloloads); i++) { 
								  jQuery("select[name=qty"+data.BookingDateID+"] option:last").remove(); 
								}
								jQuery("#qty"+data.BookingDateID).selectpicker('refresh');		
								} 
								if(data.LoadType==2){
									jQuery(".driverlstd option[value='"+DriverID+"']").remove();
									$('.driverlstd').selectpicker('refresh');		
								}
								if(parseInt(data.loads) ==0){   
									$("#ticket-grid2 tbody").find('#'+data.BookingDateID).remove();
									//currentRow.parents('tr').remove(); 
								} 
								$('#LoadAllocated').html(data.ShowLoads);
							}else{ 
								alert("Oooops, Please try again later"); 
							}  
						}); 
					}
				}
			}else{ alert("Please Select Driver. "); }	
			}else{ alert("Please Select Qty "); }	
				
		});
		
 
//##############################################  Show Booking Info in modal  ##############################################		
		
		jQuery(document).on("click", ".ShowLoads", function(){  
		//$('#empModal').modal('show');  
				var BookingDateID = $(this).attr("data-BookingDateID"), 
					hitURL1 = baseURL + "ShowLoadsAJAX",
					currentRow = $(this);  
				//console.log(confirmation); 
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingDateID' : BookingDateID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Booking Loads / Lorry Information");
					$('#empModal .modal-dialog').width(1200);
					$('#empModal').modal('show');  
				});  
				 
		});

//##############################################  Show Pending allocate Booking Info in modal  ##############################################				
		
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

/*##############################################  Delete Booking   ##############################################*/		

		jQuery(document).on("click", ".DeleteBooking", function(){  
		//$('#empModal').modal('show');  
				var BookingDateID = $(this).attr("data-BookingDateID"),  
					PendingLoads = $('#loads'+BookingDateID).html();
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

/*##############################################  Update Booking Qty   ##############################################*/		

		jQuery(document).on("click", ".UpdateBookingQTY", function(){  
		//$('#empModal').modal('show');   
				var BookingID = $(this).attr("data-BookingID"),  
					BookingDateID = $(this).attr("data-BookingDateID"),  
					PendingLoads = $('#loads'+BookingDateID).html(),
					TotalLoads = $('#TotalLoads'+BookingDateID).html(),
					hitURL1 = baseURL + "ShowUpdateBookingAJAX",
					currentRow = $(this);  
				//console.log(confirmation); 
				//alert(PendingLoads)
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingID' : BookingID,'PendingLoads' : PendingLoads,'TotalLoads' : TotalLoads } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Booking Loads / Lorry Information");
					$('#empModal .modal-dialog').width(500);
					$('#empModal').modal('show');  
				});  
				 
		});

		 
	});
	 
</script>