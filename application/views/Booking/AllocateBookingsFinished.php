<?php $cls1="";  ?>
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Finished Loads/Lorry Booking Allocation  </h1>    </section> 
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
					<h4 class="modal-title">Finished  Booking Loads/Lorry Information </h4>
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
						<li class=""><a  href="<?php echo base_url('AllocateBookingsOverdue'); ?>"  aria-expanded="false">OverDue </a></li>
						<li class=""><a href="<?php echo base_url('AllocateBookings'); ?>" aria-expanded="false">Future </a></li>     
						<li  class="active" ><a href="#Finished" data-toggle="tab" aria-expanded="false">Finished</a></li>     
					</ul> 
					<div class="tab-content"> 
						  
						<div class="tab-pane active" id="Finished"> 
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
				
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingDateID="'+data["BookingDateID"]+'" herf="#" >'+data["BookingID"]+'</a>'); 
				$(row).find("td:eq(1)").html(btype); 
				$(row).find("td:eq(3)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(4)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(6)").html(Ltype); 
				$(row).find("td:eq(7)").html('<a href="#"  data-BookingDateID="'+data["BookingDateID"]+'"  class="ShowLoads" id="TotalLoads'+data["BookingDateID"]+'" >'+data["Loads"]+'</a> '); 
				  
			}
		});
   
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
  
	});
	 
</script>