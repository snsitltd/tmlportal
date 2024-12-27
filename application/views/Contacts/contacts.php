<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Contact Management
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
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>Add-New-Contacts"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Contact List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                         <th width="50">Title</th> 
                        <th>Name</th>
                        <th width="150">Email</th> 
                        <th width="100">Department</th>
                        <th width="100">Position</th> 
                        <th>Company</th>
						<th>Opportunity</th>                       
                        <th width="80">Mobile </th>                     
                        <th class="text-center" width="70">Actions</th>
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

//{ "data": "CompanyName" , "name": "CompanyName" },   
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
				{ "data": "Title" ,"name": "Title"  },		
				{ "data": "ContactName" ,"name": "ContactName"  },
				{ "data": "EmailAddress" ,"name": "EmailAddress"  },
				{ "data": "Department" ,"name": "Department"  },
				{ "data": "Position" , "name": "Position" }, 
				{ "data": null },
				{ "data": null },
				{ "data": "MobileNumber" , "name": "MobileNumber" },     
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AJAXContacts') ?>", // json datasource
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
			
				$(row).find("td:eq(-4)").html(' <a  href="'+baseURL+'view-company/'+data["CompanyID"]+'" title="View Company Details">'+data["CompanyName"]+'</a> '); 	 
				$(row).find("td:eq(-3)").html(' <a  href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" title="View Opportunity Details">'+data["OpportunityName"]+'</a> '); 	 
				//$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'view-contacts/'+data["ContactID"]+'" title="View Contact"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'edit-contacts/'+data["ContactID"]+'" title="Edit Contact"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteContacts" href="#" data-ContactID="'+data["ContactID"]+'" title="Delete"><i class="fa fa-trash"></i></a>'); 	 
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'view-contacts/'+data["ContactID"]+'" title="View Contact"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'edit-contacts/'+data["ContactID"]+'" title="Edit Contact"><i class="fa fa-pencil"></i></a> '); 	 				
			}
		} );
		 
		jQuery(document).on("click", ".deleteContacts", function(){
			var ContactID = $(this).attr("data-ContactID"),
				hitURL = baseURL + "deleteContacts",
				currentRow = $(this);			
			
			var confirmation = confirm("Are you sure to delete this record ?");
			
			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { ContactID : ContactID } 
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
