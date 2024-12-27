<div class="content-wrapper"> 
    <section class="content-header"><h1><i class="fa fa-users"></i> Subcontractor <small>Add, Edit, Delete</small></h1></section> 
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
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url('addSubcontractor'); ?>"><i class="fa fa-plus"></i> Add Subcontractor</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
				<div class="box-header">
					<h3 class="box-title">Subcontractor List</h3>
				</div> 
				<div class="box-body">
				  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
					<table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
					<thead>
						<tr> 
							<th>Company Name</th>
							<th width="200" >Email</th> 
							<th width="100" >Town</th>
							<th width="100" >County</th>
							<th width="70" >PostCode</th>
							<th width="70" >Mobile</th>  
							<th width="70" >Total Lorry</th>  
							<th class="text-center" width="50" >Actions</th>
						</tr>
					</thead> 
					</table> 
				  </div></div></div>
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
			//"order": [[ 1, "asc" ]],
			"columns": [
				{ "data": "CompanyName" ,"name": "CompanyName"  },
				{ "data": "Email" ,"name": "Email"  },
				{ "data": "Town" ,"name": "Town"  },
				{ "data": "County" , "name": "County" },
				{ "data": "PostCode" , "name": "PostCode" }, 
				{ "data": "Mobile" , "name": "Mobile" },  
				{ "data": "TotalLorry" , "name": "TotalLorry" },
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AJAXSubcontractor') ?>", // json datasource
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
				$(row).find("td:eq(-1)").html('  <a class="btn btn-sm btn-info" href="'+baseURL+'EditSubcontractor/'+data["ContractorID"]+'" title="Edit Contractor"><i class="fa fa-pencil"></i></a> '); 
			}
		}); 
 
	} );
	
</script> 
