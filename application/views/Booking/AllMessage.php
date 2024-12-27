<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>All Messages </h1>    </section> 
    <section class="content">   
		<div class="row"> 
			<div class="col-md-12">
			   <div class="row">
					<div class="col-xs-12 text-right">
						<div class="form-group"> 
							<a class="btn btn-info"  href="<?php echo base_url('Message'); ?>" ><i class="fa fa-plus"></i> Send Messages</a>  
						</div> 
					</div>
				</div> 
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">All Messages</h3>
							</div> 
							<div class="box-body">
								<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
									  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
									  <thead>
										<tr> 
											<th width="100" >DateTime </th>    
											<th >Driver Name</th>     
											<th >Message </th>     
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
				{ "data": "CreateDateTime" ,"name": "CreateDateTime"  },
				{ "data": "DriverName" ,"name": "DriverName"  },	
				{ "data": "Message" ,"name": "Message"  }, 
				{ "data": null } 				 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxMessage') ?>", // json datasource
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
				var status ='';
				if(data["Status"]=='0'){  status = '<span class="label label-success">UNREAD</span>'; 
				}else if(data["Status"]=='1'){   status = '<span class="label label-warning">READ</span>' ;  } 
				$(row).find("td:eq(-1)").html(status);	
			}
		});  
	}); 
</script>