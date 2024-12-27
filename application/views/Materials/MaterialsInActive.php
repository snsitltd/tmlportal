<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Materials Management  </h1>
    </section>

    <section class="content">

    <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?> 
		<div class="row"> 
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li ><a href="<?php echo base_url('materiallist'); ?>"  aria-expanded="false">Active </a></li> 
						<li class="active"><a href="#InActive"  aria-expanded="true">InActive</a></li>         
					</ul>  
					<div class="tab-content"> 
						<div class="tab-pane active" id="InActive">   
							<div class="row">
								<div class="col-xs-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">InActive Material List </h3>
										</div> 
										<div class="box-body">
										  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
											  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
											  <thead>
												<tr  > 
													<th width="70">Code</th>
													<th>Material</th>
													<th width="120">Operation IN/OUT</th>                        
													<th width="70">Price ID</th>
													<th  width="70">SIC Code</th>                           
													<th  width="50" class="text-center">Actions</th>
												</tr>
												</thead> 
											  </table>

										  </div></div></div>
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
				{ "data": "MaterialCode" ,"name": "MaterialCode"  },
				{ "data": "MaterialName" ,"name": "MaterialName"  },
				{ "data": "Operation" ,"name": "Operation"  },
				{ "data": "PriceID" , "name": "PriceID" },
				{ "data": "SicCode" , "name": "SicCode" },  
				{ "data": null },  
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AJAXMaterialsInActive') ?>", // json datasource
				type: "post",  // method  , by default get
				error: function(e){  // error handling
					$(".ticket-grid-error").html("");
					$("#ticket-grid").append('<tbody class="ticket-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#ticket-grid_processing").css("display","none");							
				}//,
				//success: function (data) {  
				//   alert(JSON.stringify( data )); 
 				//} 
			}, 
			columnDefs: [{ data: null, targets: -1 }],   
			createdRow: function (row, data, dataIndex) {   
//				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'view-material/'+data["MaterialID"]+'" title="View Material"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'edit-material/'+data["MaterialID"]+'" title="Edit Material"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteMaterials" href="#" data-MaterialID="'+data["MaterialID"]+'" title="Delete"><i class="fa fa-trash"></i></a>');
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'view-material/'+data["MaterialID"]+'" title="View Material"><i class="fa fa-eye"></i></a>  '); 
			}
		} );
		
		
		
	jQuery(document).on("click", ".deleteMaterials", function(){
		var MaterialID = $(this).attr("data-MaterialID"),
			hitURL = baseURL + "deleteMaterials",
			currentRow = $(this);			 
		var confirmation = confirm("Are you sure to delete this record ?"); 	
		if(confirmation){
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { MaterialID : MaterialID } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Record successfully deleted"); }
				else if(data.status = false) { alert("Record deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
	
	
	} );
	
</script>
