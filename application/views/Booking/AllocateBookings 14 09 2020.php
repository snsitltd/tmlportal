<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>Allocate Booking Loads/Lorry</h1>    </section> 
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
        <!-- <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url('AddBooking'); ?>"><i class="fa fa-plus"></i> Add Booking</a> 
                </div> 
            </div>
        </div> --> 
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:1200px"> 
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Booking Loads/Lorry Information</h4>
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
            <div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Approved Booking Loads/Lorry List</h3>
					</div> 
					<div class="box-body">
						<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
							  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
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
									<th width="20" >Pending Allocate</th>     
									<th width="20" >No. Days</th>     
									<th >Tip Address</th>    
									<th >Driver</th>    
									<th >Action</th>    
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
				{ "data": "BookingID" ,"name": "BookingID"  },
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "BookingDateTime" ,"name": "BookingDateTime" },
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" },
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "LoadType" , "name": "LoadType" },  
				{ "data": "Loads" , "name": "Loads" },    
				{ "data": null }, 				
				{ "data": null },   
				{ "data": null }, 				
				{ "data": null }, 				
				{ "data": null }
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxAllocatedBookings') ?>", // json datasource
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
			//alert(data["OpportunityID"]);
			//alert(data["TotalLoadAllocated"]);
				var btype = '';var Ltype ="";
				if(data["BookingType"] ==1){ btype = 'Collection' ; }else{ btype = 'Delivery' ;  } 
				if(data["LoadType"]==1){ Ltype = "Fixed"; } if(data["LoadType"]==2){ Ltype = "TurnAround"; } 
				
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingNo="'+data["BookingID"]+'" herf="#" ><i class="fa fa-plus-circle"></i> '+data["BookingID"]+'</a>'); 
				$(row).find("td:eq(1)").html(btype); 
				$(row).find("td:eq(3)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(4)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(6)").html(Ltype); 
				$(row).find("td:eq(7)").html('<a href="#"  data-BookingNo="'+data["BookingID"]+'"  class="ShowLoads" id="TotalLoads'+data["BookingID"]+'" >'+data["Loads"]+'</a> '); 
				 
				if(data["LoadType"]==1){ 
					$(row).find("td:eq(8)").html('<a href="#"  data-BookingNo="'+data["BookingID"]+'"  class="ShowLoads" id="loads'+data["BookingID"]+'" >'+parseInt(parseInt(data["Loads"])-parseInt(data["TotalLoadAllocated"]))+'</a> ');
					 
					if(parseInt(parseInt(data["Loads"])-parseInt(data["TotalLoadAllocated"])) !=0 ){ 
						$(row).find("td:eq(-1)").html('<div id="all'+data["BookingID"]+'"><input type="hidden" name= "MID'+data["BookingID"]+'" id= "MID'+data["BookingID"]+'"  value="'+data["MaterialID"]+'" ><a class="btn btn-info AllocateBooking"  herf="#" data-BookingNo="'+data["BookingID"]+'" title="Allocate Booking"><i class="fa fa-check"></i> Allocate </a> </div>');	
						$(row).find("td:eq(-3)").html('<div id="t'+data["BookingID"]+'"><select  class="form-control tiplst" style="width:120px" id="tip'+data["BookingID"]+'" name="tip'+data["BookingID"]+'"  ></select></div>');	
						$(row).find("td:eq(-2)").html('<div id="d'+data["BookingID"]+'"><select  class="form-control driverlst" style="width:120px" id="driver'+data["BookingID"]+'" name="driver'+data["BookingID"]+'"  ></select></div>');	
					}else{
						$(row).find("td:eq(-1)").html('<span class="label label-danger ShowLoads" data-BookingNo="'+data["BookingID"]+'" ><i class="fa fa-check"></i> Allocated </span>');
						$(row).find("td:eq(-3)").html('None');	
						$(row).find("td:eq(-2)").html('None');	
					}	
					$(row).find("td:eq(9)").html('-'); 
				}else {  
					$(row).find("td:eq(8)").html('<a href="#"  data-BookingNo="'+data["BookingID"]+'"  class="ShowLoads" id="loads'+data["BookingID"]+'" >'+parseInt(parseInt(data["Loads"])-parseInt(data["DistinctLorry"]))+'</a>');
					 
					if(parseInt(data["DistinctLorry"]) < data["Loads"]  ){ 
						$(row).find("td:eq(-1)").html('<div id="all'+data["BookingID"]+'"><input type="hidden" name= "MID'+data["BookingID"]+'" id= "MID'+data["BookingID"]+'"  value="'+data["MaterialID"]+'" ><a class="btn btn-info AllocateBooking" herf="#" data-BookingNo="'+data["BookingID"]+'" title="Allocate Booking"><i class="fa fa-check"></i> Allocate </a></div> ');						
						$(row).find("td:eq(-3)").html('<div id="t'+data["BookingID"]+'"><select  class="form-control tiplst" style="width:120px" id="tip'+data["BookingID"]+'" name="tip'+data["BookingID"]+'"  ></select></div>');	
						$(row).find("td:eq(-2)").html('<div id="d'+data["BookingID"]+'"><select  class="form-control driverlst" style="width:120px" id="driver'+data["BookingID"]+'" name="driver'+data["BookingID"]+'"  ></select></div>');	 
					}else{ 
						$(row).find("td:eq(-1)").html('<span class="label label-danger ShowLoads" data-BookingNo="'+data["BookingID"]+'" ><i class="fa fa-check"></i> Allocated </span>');	
						$(row).find("td:eq(-3)").html('None');	
						$(row).find("td:eq(-2)").html('None');	
					}
					$(row).find("td:eq(9)").html(data["Days"]); 
				} 
			}
		});
		
		jQuery(document).on("click", ".AllocateBooking", function(){  
				var BookingID = $(this).attr("data-BookingNo"),
					DriverID = $('#driver'+BookingID).val(),
					Driver = $("#driver"+BookingID+" option:selected").html(); 
					TipID = $('#tip'+BookingID).val(),
					MaterialID = $('#MID'+BookingID).val(),
					Loads = $('#loads'+BookingID).html(), 			
					TotalLoads = $('#TotalLoads'+BookingID).html(),
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
						data : { 'BookingID' : BookingID,'DriverID' :DriverID,'TipID' :TipID,'MaterialID' :MaterialID,'Loads' :Loads,'TotalLoads' :TotalLoads,'confirmation' :confirmation } 
						}).success(function(data){ 
							//alert(JSON.stringify( data ));   
							//console.log(data);  
							if(data.status == true) { 
								jQuery('#loads'+data.BookingID).html(parseInt(data.loads)); 
								if(parseInt(data.loads) ==0){
									jQuery('#all'+data.BookingID).html('<span class="label label-danger ShowLoads" data-BookingNo="'+data.BookingID+'" ><i class="fa fa-check"></i> Allocated </span>'); 
									jQuery('#t'+data.BookingID).html('None'); 
									jQuery('#d'+data.BookingID).html('None'); 
								}
								//alert("Load has been Allocated"); 
								//jQuery('.modal-body').html(data);
								$('.modal-body').html('Load Has Been Allocated to Driver <br><br> <b>Driver Name: </b>'+data.DriverName+'<br>  <b>Lorry No:</b> '+data.LorryNo+' <br> <b>Vehicle Registration No.:</b> '+data.RegNumber); 
								$('#empModal .modal-title').html("Load Allocated");
								$('#empModal .modal-dialog').width(500);
								$('#empModal').modal('show');  
								

							}else{ 
								alert("Oooops, Please try again later"); 
							} 

							//$('#ticket-grid').DataTable().ajax.reload();  
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
		$('#ticket-grid').on( 'draw.dt', function () { 
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url: baseURL+"/GetDriverList",
			data : ""
			}).done(function(data){ 
				//console.log(data);      
				var options = '';
				if(data.status==false){	 
					jQuery(".driverlst").html(options);
				}else{ 
					for (var i = 0; i < data.driver_list.length; i++) { 
					options += '<option value="' + data.driver_list[i].LorryNo + '"> ' + data.driver_list[i].LorryNo + ' | ' + data.driver_list[i].DriverName + ' | ' + data.driver_list[i].RegNumber + '</option>';
					} 
					jQuery(".driverlst").html(options);
				} 
			}); 
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url: baseURL+"/GetTipList",
			data : ""
			}).done(function(data){ 
				//console.log(data);      
				var options = '';
				if(data.status==false){	 
					jQuery(".tiplst").html(options);
				}else{ 
					for (var i = 0; i < data.tip_list.length; i++) { 
					options += '<option value="' + data.tip_list[i].TipID + '">' + data.tip_list[i].TipName + '</option>';
					} 
					jQuery(".tiplst").html(options); 
				} 
			}); 
		});
		
		
	 	
	});
	//jQuery.fn.UpdateDriverDD(); 
</script>