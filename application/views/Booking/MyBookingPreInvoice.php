<?php $cls1="";  ?>
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> My Booking PreInvoice </h1>    </section> 
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
						<li class="active"><a href="#all" data-toggle="tab" aria-expanded="true" >My PreInvoices</a></li>         
						<li class=""><a href="<?php echo base_url('BookingPreInvoice'); ?>"  aria-expanded="false" >All PreInvoices </a></li> 
					</ul> 
					
					<div class="tab-content"> 
						<div class="tab-pane active" id="all">   
							<div class="row">
								<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title">My Booking PreInvoice  </h3>
									</div> 
									<div class="box-body" >
										<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
											  <table id="PreInvoice" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
											  <thead>
												<tr> 
													<th width="80" align="right">Booking NO </th>                         
													<th width="100" > Booking Date </th>                        
													<th >Company Name</th>
													<th >Site Name</th>      
													<th width="50" >Status </th> 
													<th width="50" >Action </th> 
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
		
		<div class="row">
			
		</div>  
    </section>
</div>  

<script type="text/javascript" language="javascript" >
	  
	$(document).ready(function() { 
		   
		var dataTable = $('#PreInvoice').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 0, "desc" ]],
			"columns": [
				{ "data": "BookingRequestID" ,"name": "BookingRequestID"  }, 
				{ "data": "BookingDateTime" ,"name": "BookingDateTime"  }, 
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" }, 
				{ "data": null }, 
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxMyPreInvoiceList') ?>", // json datasource
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
				//var view = '<a class="btn btn-sm btn-warning" href="'+baseURL+'BookingCreateInvoice/'+data["BookingRequestID"]+'" title="Pre Invoice"><i class="fa fa-file"></i></a>' ;
				if(data["TonBook"]==1){
					var view = '<a class="btn btn-sm btn-warning" href="'+baseURL+'BookingCreateInvoiceTonnage/'+data["BookingRequestID"]+'" title="Pre Invoice"><i class="fa fa-file"></i></a>' ;
				}else{
					var view = '<a class="btn btn-sm btn-warning" href="'+baseURL+'BookingCreateInvoice/'+data["BookingRequestID"]+'" title="Pre Invoice"><i class="fa fa-file"></i></a>' ;	
				}
				if(data["InvoiceHold"]=='1' ){
					$(row).find("td:eq(-2)").html('<span class="label label-warning " title="'+data["InvoiceComment"]+'" > HOLD </span>'); 
				}else{
					$(row).find("td:eq(-2)").html('');  
				}
				
				$(row).find("td:eq(-1)").html(view);
				$(row).find("td:eq(2)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(3)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');  	
			}
		}); 
	});
	 
</script>