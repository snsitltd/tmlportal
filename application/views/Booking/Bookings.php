
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Booking <small>Add, Edit, Delete</small>   </h1>    </section> 
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
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url('AddBooking'); ?>"><i class="fa fa-plus"></i> Add Booking</a> 
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Booking List</h3>
					</div> 
					<div class="box-body">
						<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
							  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
							  <thead>
								<tr> 
									<th width="10" align="right">BNo </th>                        
									<th width="50" >Request Date(s) </th>  
									<th >Company Name</th>
									<th >Site Name</th>  
									<th >Material</th> 
									<th width="10" align="right">Type</th>                        
									<th width="40" >Load Type</th> 
									<th width="20">Loads Lorry</th>           
									<th width="20">Lorry Type</th>           
									<th >Notes</th>    
									<th width="50">Approve</th> 
									<th class="text-center" width="50">Actions</th> 
									<th width="110" >Created By </th>  
									<th width="100" >Created DateTIme </th>  
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
			"order": [[ 10, "asc" ] ,[ 0, "desc" ]  ], 
			"columns": [
				{ "data": "BookingID" , "name": "BookingID" , "data-sort": "BookingID" },
				{ "data": "BookingDate" , "name": "BookingDate" , "data-sort": "BookingDate" },				  
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" },  
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "LoadType" , "name": "LoadType" }, 
				{ "data": "Loads" , "name": "Loads" }, 
				{ "data": null },  
				{ "data": "Notes" , "name": "Notes" },  
				{ "data": "Status","name": "Status", "data-sort": "Status" }, 				
				{ "data": null },
				{ "data": "BookedName" , "name": "BookedName" },
				{ "data": "CreateDateTime" , "name": "CreateDateTime" }
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxBookings') ?>", // json datasource
				type: "post",  // method  , by default get
				error: function(e){  // error handling
				//alert(e);
				//console.log(e);     
					$(".ticket-grid-error").html("");
					$("#ticket-grid").append('<tbody class="ticket-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#ticket-grid_processing").css("display","none");							
				}
			}, 
			columnDefs: [{ data: null, targets: -1 }],   
			createdRow: function (row, data, dataIndex) {  

				var btype = ''; var status = ''; var del = '';var edi = '';var LorryType = '';
				if(data["BookingType"] ==1){ $(row).addClass("even1");  btype = 'Collection' ; }else{  $(row).addClass("odd1");  btype = 'Delivery' ;  } 
				if(data["LoadType"] == 1){ $(row).find("td:eq(6)").html('Loads'); }else{  $(row).find("td:eq(6)").html('TurnAround'); }
				if(data["LorryType"] == 1){ LorryType = 'Tipper'; }else if(data["LorryType"] == 2){ LorryType = 'Grab'; }else if(data["LorryType"] == 3){ LorryType = 'Bin'; }
				
				if(data["Status"] == '1'){ status = '<span class="label label-success">Approved</span>' ; del = '' ; edi = '';  }
				if(data["Status"] == '0'){ status = '<div id="ap'+data["BookingID"]+'" ><a class="btn btn-danger ApproveBooking" herf="#" data-BookingNo="'+data["BookingID"]+'" title="Click Here To Approve Booking"><i class="glyphicon glyphicon-ok"></i></a></div>' ; 	}
				if(data["TotalLoadAllocated"] == '0'){  
					del = '<a class="btn btn-sm btn-danger deleteTicket" href="#" data-BookingNo="'+data["BookingID"]+'" title="Delete"><i class="fa fa-trash"></i></a>' ;	 
					edi = '<a class="btn btn-sm btn-info" href="'+baseURL+'EditBooking/'+data["BookingID"]+'" title="Edit Booking"><i class="fa fa-pencil"></i></a>' ;
				}
				
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingNo="'+data["BookingID"]+'" herf="#" ><i class="fa fa-plus-circle"></i> '+data["BookingID"]+'</a>');  
				$(row).find("td:eq(5)").html(btype);
				$(row).find("td:eq(2)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> ');
				$(row).find("td:eq(3)").html(' <a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> '); 
				$(row).find("td:eq(-6)").html(LorryType);	 
				$(row).find("td:eq(-4)").html(status);	 
				$(row).find("td:eq(-3)").html(' '+edi+' '+del);
				$(row).find('td:eq(9)').attr('data-sort', data['Status']); 
				$(row).find('td:eq(0)').attr('data-sort', data['BookingID']); 
			}
		});

		jQuery(document).on("click", ".ApproveBooking", function(){ 
				var BookingNo = $(this).attr("data-BookingNo"),
					hitURL = baseURL + "ApproveBooking",
					currentRow = $(this);	  
				var confirmation = confirm(" Are You Sure ? You want to Confirm This Booking ? ");
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
							if(data.status != "") { //currentRow.parents('tr').remove(); 
							jQuery('#ap'+data.BookingID).html('<span class="label label-success">Approved</span>');
							//alert("Selcted Booking has been Approved"); 
							}
							else{ alert("Oooops, Please try again later"); } 
						}); 
					}
				}
		});
			jQuery(document).on("click", ".ShowLoads", function(){   
				var BookingID = $(this).attr("data-BookingNo"), 
					hitURL1 = baseURL + "ShowBLoadsAJAX",
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
</script>