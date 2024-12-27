<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>Booking Request Loads/Lorry </h1>    </section> 
    <section class="content">  
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:1200px"> 
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Booking Request Loads/Lorry Information </h4>
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
					<h4 class="modal-title">Not Started Request Loads/Lorry Timeline</h4>
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
						<li class="active"><a href="#Pending" data-toggle="tab" aria-expanded="true">Not Started </a></li> 
						<li class=""><a href="<?php echo base_url('RequestLoads'); ?>"   aria-expanded="true">Running </a></li> 
						<li class=""><a href="<?php echo base_url('RequestLoadsFinished'); ?>"  aria-expanded="false">Finished</a></li>     
						<li class=""><a href="<?php echo base_url('RequestLoadsCancelled'); ?>"  aria-expanded="false">Cancelled</a></li>    
						<a class="btn btn-success" href="<?php echo base_url('RequestLoadsFinishedArchived'); ?>" style="float:right;margin: 6px "> Archived Finished Loads</a>						
					</ul> 
					<div class="tab-content"> 
						<div class="tab-pane active" id="Pending">   
							<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Not Started Loads/Lorry List</h3>
									</div> 
									<div class="box-body">
										<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
											  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
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
													<th width="80" >LorryNo</th>    
													<th >VRNO </th>     
													<th width="100">Allo. DateTime </th>     
													<th width="60" >Status</th> 
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
		var dataTable = $('#ticket-grid').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 1, "desc" ]],
			"columns": [ 
				{ "data": "BookingRequestID" ,"name": "BookingRequestID"  },
				{ "data": "ConveyanceNo" ,"name": "ConveyanceNo"  },
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "BookingDateTime" ,"name": "BookingDateTime" },
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" },
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "LoadType" , "name": "LoadType" },   
				{ "data": "DriverID" , "name": "DriverID" },    
				{ "data": "VehicleRegNo" , "name": "VehicleRegNo" },      			  
				{ "data": "CreateDateTime" , "name": "DateTime" },   
				{ "data": null } 			 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxPendingLoads') ?>", // json datasource
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
				var btype = '';var Ltype =""; var status ="";var status1 =""; var del ="";  
				if(data["BookingType"] ==1){ $(row).addClass("even1");  btype = 'Collection' ; }else if(data["BookingType"] ==2){ $(row).addClass("odd1"); btype = 'Delivery' ;  }else if(data["BookingType"] ==3){ $(row).addClass("odd1"); btype = 'DayWork' ;  }else if(data["BookingType"] ==4){ $(row).addClass("odd1"); btype = 'Haulage' ;  }  
				
				if(data["TonBook"]==1){ Ltype = "Tonnage";
				}else{ if(data["LoadType"]==1){ Ltype = "Loads"; } if(data["LoadType"]==2){ Ltype = "TurnAround"; } }   
				
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingNo="'+data["BookingDateID"]+'" herf="#" ><i class="fa fa-plus-circle"></i> '+data["BookingRequestID"]+'</a>');     
				$(row).find("td:eq(2)").html(btype); 
				$(row).find("td:eq(4)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(5)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(7)").html(Ltype);   
				$(row).find("td:eq(-1)").html('<span class="label label-danger  " data-LoadID="'+data["LoadID"]+'"  > PENDING </span> <a href="#" class="deleteload" data-LoadType="'+data["LoadType"]+'"  data-LoadID="'+data["LoadID"]+'"  data-BookingDateID="'+data["BookingDateID"]+'"  title="Delete Load" > <i class="fa fa-fw fa-times"></i> </a> '); 
				
				  
			}
		} ); 
		  
		 
		jQuery(document).on("click", ".ShowLoads", function(){   
				var BookingID = $(this).attr("data-BookingNo"), 
					hitURL1 = baseURL + "ShowRequestLoadsAJAX",
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
					$('#empModal .modal-title').html("Booking Request Loads / Lorry Information");
					$('#empModal .modal-dialog').width(1200);
					$('#empModal').modal('show');  
				});  
				 
		});
		jQuery(document).on("click", ".deleteload", function(){ 
				var LoadID = $(this).attr("data-LoadID"),
					LoadType = $(this).attr("data-LoadType"),	
					BookingDateID = $(this).attr("data-BookingDateID"),
					hitURL = baseURL + "DeleteRequestLoad",
					currentRow = $(this);	  
				var confirmation = confirm(" Are You Sure ? You want to Delete This Load ? ");
				//console.log(confirmation);
				if(confirmation!=null){ 
					if(confirmation!=""){
						//console.log("Your comment:"+confirmation);
						//alert(confirmation);
						jQuery.ajax({
						type : "POST",
						dataType : "json",
						url : hitURL,
						data : { 'LoadID' : LoadID, 'BookingDateID' : BookingDateID,'confirmation' :confirmation } 
						}).success(function(data){
							//console.log(data);  
							if(data.status != "") { currentRow.parents('tr').remove(); alert("Booking Load has been Deleted"); }
							else{ alert("Oooops, Please try again later"); } 
						});  
					}
				}
		}); 
	 	 
		
	}); 
</script>