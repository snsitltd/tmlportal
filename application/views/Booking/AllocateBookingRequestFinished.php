<?php $cls1="";  ?>
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Loads/Lorry Booking Request Allocation </h1>    </section> 
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
					<h4 class="modal-title">  Loads/Lorry Booking Allocation</h4>
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
						<li ><a href="<?php echo base_url('AllocateBookingRequest'); ?>" aria-expanded="true">Today's </a></li> 
						<li class=""><a  href="<?php echo base_url('AllocateBookingRequestOverdue'); ?>"  aria-expanded="false">OverDue </a></li>
						<li class=""><a href="<?php echo base_url('AllocateBookingRequestFuture'); ?>"  aria-expanded="false">Future </a></li> 
						<li  class="active" ><a href="#Finished" data-toggle="tab" aria-expanded="false">Finished</a></li>     
						<a class="btn btn-success" href="<?php echo base_url('AllocateBookingRequestFinishedArchived'); ?>" style="float:right;margin: 6px "> Archived Finished Allocation</a>
					</ul> 
					
					<div class="tab-content"> 
						 <div class="tab-pane active" id="Finished">   
							<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title"> Finished Loads/Lorry Booking Allocation </h3>   
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
													<th width="20">Lorry Type</th>   													
													<th width="75" >Load/Lorry Type</th>     
													<th width="20" >No. Of Loads/Lorry </th> 
													<th width="40" >Action</th>     
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
				{ "data": null },  				
				{ "data": "LoadType" , "name": "LoadType" },  
				{ "data": "Loads" , "name": "Loads" } ,
				{ "data": null },  				
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxAllocatedBookingsRequest1') ?>", // json datasource
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
				var btype = ''; var Ltype =""; var LorryType = '';
		//		if(data["BookingType"] ==1){ $(row).addClass("even1");   btype = 'Collection' ; }else{ $(row).addClass("odd1");  btype = 'Delivery' ;  } 
			if (data["BookingType"] == 1) {
    $(row).addClass("even1");
    btype = 'Collection';
} else if (data["BookingType"] == 2) {
    $(row).addClass("odd1");
    btype = 'Delivery';
} else if (data["BookingType"] == 3) {
    $(row).addClass("daywork1");
    btype = 'Daywork';
} else if (data["BookingType"] == 4) {
    $(row).addClass("haulage1");
    btype = 'Haulage';
} else {
    $(row).addClass("notfound1");
    btype = 'Booking Not Found';
}
	
				if(data["TonBook"]==1){
					Ltype = "Tonnage";
				}else{	
				if(data["LoadType"]==1){ Ltype = "Loads"; } if(data["LoadType"]==2){ Ltype = "TurnAround"; } 
				}
				if(data["LorryType"] == 1){ LorryType = 'Tipper'; }else if(data["LorryType"] == 2){ LorryType = 'Grab'; }else if(data["LorryType"] == 3){ LorryType = 'Bin'; }
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingDateID="'+data["BookingDateID"]+'" herf="#" >'+data["BookingRequestID"]+'</a>'); 
				$(row).find("td:eq(1)").html(btype); 
				$(row).find("td:eq(6)").html(LorryType);
				$(row).find("td:eq(3)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(4)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(7)").html(Ltype); 
				$(row).find("td:eq(8)").html('<a href="#"  data-BookingDateID="'+data["BookingDateID"]+'"  class="ShowLoads" id="TotalLoads'+data["BookingDateID"]+'" >'+data["Loads"]+'</a> '); 
				 
				//if(data["LoadType"]==1){ 
				//	$(row).find("td:eq(8)").html('-'); 
				//}else {   
				//	$(row).find("td:eq(8)").html(data["Days"]); 
				//}  				
				if(data["BookingDateDiff"]<6){
					$(row).find("td:eq(-1)").html('<a class="btn btn-sm btn-warning AddBookingQTY"  data-BookingID="'+data["BookingID"]+'"  data-BookingDateID="'+data["BookingDateID"]+'"  href="#" title="Add Qty"><i class="fa fa-plus"></i></a> ');	
				}else{ $(row).find("td:eq(-1)").html(''); }
			}
		});
  
//##############################################  Show Booking Info in modal  ##############################################		
		
		jQuery(document).on("click", ".ShowLoads", function(){  
		//$('#empModal').modal('show');  
				var BookingDateID = $(this).attr("data-BookingDateID"), 
					hitURL1 = baseURL + "ShowRequestLoadsAJAX",
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
		
		jQuery(document).on("click", ".AddBookingQTY", function(){  
		//$('#empModal').modal('show');   
				var BookingID = $(this).attr("data-BookingID"),  
					BookingDateID = $(this).attr("data-BookingDateID"),   
					TotalLoads = $('#TotalLoads'+BookingDateID).html(),
					hitURL1 = baseURL + "ShowAddBookingRequestAJAX",
					currentRow = $(this);  
				//console.log(confirmation); 
				//alert(PendingLoads)
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingID' : BookingID,'TotalLoads' : TotalLoads } 
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