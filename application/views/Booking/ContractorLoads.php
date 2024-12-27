<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Pending  Contractor Loads/Lorry </h1>    </section> 
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
					<h4 class="modal-title">  Pending Contractor Loads/Lorry Information </h4>
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
				<div class="row">
					<div class="col-xs-12">
						<form id="subcontractor" name="subcontractor" action="<?php echo base_url('ContractorLoads'); ?>" method="post" role="form" > 
						<div class="box">
							<div class="box-header"><h3 class="box-title">Pending Contractor Loads/Lorry List</h3> <input type="submit" name="submit" style="float:right;" class="btn btn-primary" value="Finish Load" />  </div> 
							<div class="box-body">
							
								<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
									  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
									  <thead>
										<tr>  
											<th width="10" align="right"><input type="checkbox" id="checkAll"/></th>   
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
										</tr>
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
				{ "data": null,"orderable": false }, 				 
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
				{ "data": "CreateDateTime" , "name": "DateTime" } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxContractorLoads') ?>", // json datasource
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
				var btype = '';var Ltype ="";var dname =""; var vreg =""; var status ="";var status1 =""; var del =""; 
				if(data["BookingType"] ==1){ $(row).addClass("even1");  btype = 'Collection' ; }else{ $(row).addClass("odd1"); btype = 'Delivery' ;  } 
				if(data["LoadType"]==1){ Ltype = "Fixed"; } if(data["LoadType"]==2){ Ltype = "TurnAround"; } 
				if(data["DriverName"]!=""){ dname = data["DriverName"]; }else{ dname = data["dDriverName"]; } 
				if(data["VehicleRegNo"]!=""){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; } 
				
				if(data["Status"]=='0'){ status = "PENDING"; status1 = "label-danger"; del=' <a href="#" class="deleteload" data-LoadID="'+data["LoadID"]+'"  title="Delete Load" > <i class="fa fa-fw fa-times"></i> </a> '; 
				}else if(data["Status"]=='1'){ status = "ACCEPTED"; status1 = "label-warning"; del=' <a href="#" class="cancelload" data-LoadID="'+data["LoadID"]+'"  title="Cancel Load" > <i class="fa fa-ban"  ></i> </a> '  
				}else if(data["Status"]=='2'){ status = "AT SITE"; status1 = "label-primary"; del=' <a href="#" class="cancelload" data-LoadID="'+data["LoadID"]+'"  title="Cancel Load" > <i class="fa fa-ban"  ></i> </a> ' 
				}else if(data["Status"]=='3'){ status = "LEFT SITE"; status1 = " label-default "; del=' <a href="#" class="cancelload" data-LoadID="'+data["LoadID"]+'"  title="Cancel Load" > <i class="fa fa-ban"  ></i> </a> ' } 
				var conv = data["ConveyanceNo"];
				$(row).find("td:eq(0)").html('<input type="checkbox" name="chkbox[]" value="'+conv+'"  /> '); 
				$(row).find("td:eq(1)").html('<a class="ShowLoads" data-BookingNo="'+data["BookingID"]+'" herf="#" ><i class="fa fa-plus-circle"></i> '+data["BookingID"]+'</a>');     
				$(row).find("td:eq(3)").html(btype); 
				$(row).find("td:eq(5)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(6)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(8)").html(Ltype); 
				$(row).find("td:eq(9)").html(dname); 
				$(row).find("td:eq(10)").html(vreg);    
				
			}
		} ); 
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 
		$("#checkAll").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
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