<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
        <small>Add, Edit, Delete</small>
      </h1>
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
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <?php if($isAdd==1){?><a class="btn btn-primary" href="<?php echo base_url(); ?>Add-New-Company"><i class="fa fa-plus"></i> Add New</a> 
					<?php } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
				<div class="box-header">
					<h3 class="box-title">Company List</h3>
				</div> 
				<div class="box-body">
				  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
					<table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
					<thead>
						<tr> 
							<th>Company Name</th>
							<th>Email</th> 
							<th width="70" >Town</th>
							<th width="70" >County</th>
							<th width="70" >PostCode</th>
							<th width="70" >Phone Number</th> 
							<th width="30" >Status</th>
							<th class="text-center" width="100" >Actions</th>
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
		var isView = "<?php echo $isView; ?>";
		var isEdit = "<?php echo $isEdit; ?>";
		var isDelete = "<?php echo $isDelete; ?>";
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
				{ "data": "EmailID" ,"name": "EmailID"  },
				{ "data": "Town" ,"name": "Town"  },
				{ "data": "County" , "name": "County" },
				{ "data": "PostCode" , "name": "PostCode" }, 
				{ "data": "Phone1" , "name": "Phone1" }, 
				{ "data": null }, 
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AJAXCompanies') ?>", // json datasource
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
			//alert(data["Status"])
			
				$(row).find("td:eq(0)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> '); 
				if(isEdit=='1'){ var cls = " company_status_deactive "; var cls1 = " company_status_active "; 
				}else{ var cls = " "; var cls1 = " "; }
				if(data["Status"]==1){
					$(row).find("td:eq(6)").html(' <a href="javascript:void(0)" class="label label-success '+cls+'" data-table-name="company"  data-id="'+data["CompanyID"]+'" >Active</a> '); 
				}else if(data["Status"]==0){
					$(row).find("td:eq(6)").html(' <a href="javascript:void(0)" class="label label-danger '+cls1+'" data-table-name="company" data-id="'+data["CompanyID"]+'" >InActive</a> '); 	
				}
				
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'view-company/'+data["CompanyID"]+'" title="View Company"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'edit-company/'+data["CompanyID"]+'" title="Edit Company"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteCompany" href="#" data-CompanyID="'+data["CompanyID"]+'" title="Delete"><i class="fa fa-trash"></i></a>');
				 
			}
		} );
		//<a class="btn btn-sm btn-danger deleteCompany" href="#" data-CompanyID="'+data["CompanyID"]+'" title="Delete"><i class="fa fa-trash"></i></a>
		
		jQuery(document).on("click", ".deleteCompany", function(){
			var CompanyID = $(this).attr("data-CompanyID"),
				hitURL = baseURL + "deleteCompany",
				currentRow = $(this); 
			var confirmation = confirm("Are you sure to delete this record ?"); 
			if(confirmation){
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { CompanyID : CompanyID } 
				}).done(function(data){
					console.log(data); 
					if(data.status == true) { alert("Record successfully deleted"); currentRow.parents('tr').remove(); }
					else if(data.status == false) { alert("Delete Failed as There are "+data.count+" Opportunity Associated with This Company."); }
					else { alert("Access denied..!"); }
				});
			}
		});

		 
	} );
	
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/Company.js'); ?>" charset="utf-8"></script>
