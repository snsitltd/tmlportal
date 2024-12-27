<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>Finished Booking Loads/Lorry </h1>    </section> 
    <section class="content">  
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:1200px"> 
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
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:1200px">  
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Loads/Lorry Timeline</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div>				  
				  <div class="modal-body"> 
				  </div> 
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
						<li  ><a href="<?php echo base_url('Loads'); ?>"   aria-expanded="true">Running </a></li> 
						<li class="active"><a href="#Finished" data-toggle="tab" aria-expanded="false">Finished</a></li>     
						<li class=""><a href="<?php echo base_url('Loads'); ?>"   aria-expanded="false">Cancelled</a></li>     
					</ul> 
					<div class="tab-content">  
						<div class="tab-pane active" id="Finished"> 
							<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Finished Loads/Lorry List</h3>
									</div> 
									<div class="box-body">
										<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
											  <table id="ticket-grid1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
											  <thead>
												<tr> 
													<th width="10" align="right">BNO </th>     
													<th width="30" align="right">Conveyance </th>  
													<th width="10" align="right">Type</th>                        
													<th width="50" > Request Date </th>                        
													<th width="150" >Company Name</th>
													<th >Site Name</th>    
													<th width="210">Material</th>         
													<th width="30" >Loads/Lorry Type</th>     
													<th width="80" >Driver Name </th>    
													<th >VRNO </th>     
													<th width="100">Allo. DateTime </th>     
													<th width="30" >Timeline</th>    
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
		  
		var dataTable1 = $('#ticket-grid1').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 1, "desc" ]],
			"columns": [ 
				{ "data": "BookingID" ,"name": "BookingID"  },
				{ "data": "ConveyanceNo" ,"name": "ConveyanceNo"  },
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "BookingDateTime" ,"name": "BookingDateTime" },
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" },
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "LoadType" , "name": "LoadType" },   
				{ "data": null }, 				 
				{ "data": null }, 				  
				{ "data": "CreateDateTime" , "name": "DateTime" },   
				{ "data": null } 				 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxLoads1') ?>", // json datasource
				type: "post",  // method  , by default get
				error: function(e){  // error handling
				//alert(e);
				console.log(e);     
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
			//alert(data["OpportunityID"]); 
				var btype = '';var Ltype ="";var dname =""; var vreg ="";  var status1 =""; 
				if(data["BookingType"] ==1){ btype = 'Collection' ; $(row).addClass("even1"); }else{ $(row).addClass("odd1"); btype = 'Delivery' ;  } 
				if(data["LoadType"]==1){ Ltype = "Fixed"; } if(data["LoadType"]==2){ Ltype = "TurnAround"; } 
				if(data["DriverName"]!=""){ dname = data["DriverName"]; }else{ dname = data["dname"]; } 
				//if(data["VehicleRegNo"]!=""){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; } 
				//if(data["VehicleRegNo"]!="" && data["VehicleRegNo"]!=0 ){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; } 
				
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingNo="'+data["BookingID"]+'" herf="#" ><i class="fa fa-plus-circle"></i> '+data["BookingID"]+'</a>');   
				$(row).find("td:eq(2)").html(btype); 
				$(row).find("td:eq(4)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(5)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(7)").html(Ltype); 
				$(row).find("td:eq(8)").html(dname); 
				$(row).find("td:eq(9)").html(data["VehicleRegNo"]);  
				$(row).find("td:eq(11)").html('<span class="label label-warning LoadInfo" data-LoadID="'+data["LoadID"]+'"  >Timeline</span> '); 
			}
		} ); 
		 
		
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