<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>Allocated Drivers</h1>    </section> 
    <section class="content">  
		
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
						<li class="active"><a href="#Running" data-toggle="tab" aria-expanded="true">Running </a></li>  
					</ul> 
					<div class="tab-content"> 
						<div class="tab-pane active" id="Running">   
							<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">Allocated Drivers List</h3>
									</div> 
									<div class="box-body">
										<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
											  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
											  <thead>
												<tr>  
												
													<th width="30" align="right">Con.</th>  													                        
													<th width="35" >Type </th>    
													<th >Driver </th>    
													<th width="40" >VRNO </th>     
													<th >Site Name</th>    
													<th >Material</th>           
													<th width="85" >Request Date </th>    
													<th width="120">Allocated Datetime</th>     
													<th width="114">JobStart Datetime</th>     
													<th width="107">SiteIn Datetime </th>     
													<th width="107">SiteOut Datetime </th>     
													<th width="107">JobEnd Datetime </th>     
													<th width="30" >Status</th>    
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
			"order": [[ 0, "desc" ]],
			"columns": [ 
				{ "data": "ConveyanceNo" ,"name": "ConveyanceNo"  },
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "DriverName" ,"name": "DriverName"  },
				{ "data": "VehicleRegNo" ,"name": "VehicleRegNo"  }, 
				{ "data": "OpportunityName" , "name": "OpportunityName" },
				{ "data": "MaterialName" , "name": "MaterialName" }, 
				{ "data": "BookingDateTime" ,"name": "BookingDateTime" }, 				  
				{ "data": "CreateDateTime" , "name": "DateTime" },   
				{ "data": "JobStartDateTime" , "name": "JobStartDateTime" },    
				{ "data": "SiteInDateTime" , "name": "SiteInDateTime" },   
				{ "data": "SiteOutDateTime" , "name": "SiteOutDateTime" },    
				{ "data": "JobEndDateTime" , "name": "JobEndDateTime" },   
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxAllocateDrivers') ?>", // json datasource
				type: "post",  // method  , by default get
				error: function(e){  // error handling
				alert(e);
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
				var status = ""; var status1="";
				if(data["BookingType"] ==1){ $(row).addClass("even1");  btype = 'Collection' ;}else{ $(row).addClass("odd1");   btype = 'Delivery' ; } 
				if(data["DriverName"]!=""){ dname = data["DriverName"]; }else{ dname = data["dname"]; } 
				if(data["VehicleRegNo"]!=""){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; } 
				$(row).find("td:eq(1)").html(btype); 
				$(row).find("td:eq(2)").html(data["dname"]); 
				$(row).find("td:eq(3)").html(vreg);  
				
				if(data["Status"]=='0'){ status = "PENDING"; status1 = "label-danger"; 
				}else if(data["Status"]=='1'){ status = "ACCEPTED"; status1 = "label-warning"; }else 
				if(data["Status"]=='2'){ status = "AT SITE"; status1 = "label-primary";}else 
				if(data["Status"]=='3'){ status = "LEFT SITE"; status1 = " label-default "; }else 
				if(data["Status"]=='4'){ status = "FINISH"; status1 = " label-success "; } else 
				if(data["Status"]=='5'){ status = "CANCEL"; status1 = " label-danger "; } else 
				if(data["Status"]=='6'){ status = "WASTED"; status1 = " label-warning "; } 
				
			//alert(data["OpportunityID"]);   
				$(row).find("td:eq(-1)").html('<span class="label '+status1+' LoadInfo" data-LoadID="'+data["LoadID"]+'"  >'+status+'</span>'); 
			}
		} ); 
		  
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
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
	 	
	}); 
</script>