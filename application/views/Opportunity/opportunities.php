<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Opportunity Management
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
                    <a class="btn btn-primary" href="<?php echo base_url('Add-Opportunity'); ?>"><i class="fa fa-plus"></i> Add New</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Opportunity List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                       <!--  <th width="10" >No</th>-->
                        <th>Site Address</th>
                        <th width="120" >Town</th>
                        <th width="70" >County</th>
                        <th width="70" >Post Code</th>
						<th width="70" >OpenDate</th>
                        <th>CompanyName</th>    
						<th width="70">Status</th>    						
                        <th class="text-center" width="100" >Actions</th>
                    </tr>
                    </thead> 
                  </table> 
              </div></div></div>
            </div>
            <!-- /.box-body -->
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
				{ "data": "OpportunityName" ,"name": "OpportunityName"  },
				{ "data": "Town" ,"name": "Town"  },
				{ "data": "County" , "name": "County" },
				{ "data": "PostCode" , "name": "PostCode" }, 
				{ "data": "OpenDate" , "name": "OpenDate" }, 
				{ "data": "CompanyName" , "name": "CompanyName" }, 
				{ "data": null },
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AJAXOpportunity') ?>", // json datasource
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
				$(row).find("td:eq(5)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> ');
				$(row).find("td:eq(4)").html(data["OpenDate1"]);
				$(row).find("td:eq(0)").html(' <a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				 //alert(data["Status"]); 
				if(data["Status"]==1){
					$(row).find("td:eq(6)").html(' <a href="javascript:void(0)" class="label label-success oppo_status_deactive" data-table-name="tbl_opportunities"  data-id="'+data["OpportunityID"]+'" >Active</a> '); 
				}else if(data["Status"]==0){
					$(row).find("td:eq(6)").html(' <a href="javascript:void(0)" class="label label-danger oppo_status_active" data-table-name="tbl_opportunities" data-id="'+data["OpportunityID"]+'" >InActive</a> '); 	
				}
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" title="View Ticket"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'edit-Opportunity/'+data["OpportunityID"]+'" title="Edit Opportunity"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteOpportunity" href="#" data-OpportunityID="'+data["OpportunityID"]+'" title="Delete"><i class="fa fa-trash"></i></a>'); 
			}
		} );
//<a class="btn btn-sm btn-danger deleteOpportunity" href="#" data-OpportunityID="'+data["OpportunityID"]+'" title="Delete"><i class="fa fa-trash"></i></a>		
		jQuery(document).on("click", ".deleteOpportunity", function(){
			var OpportunityID = $(this).attr("data-OpportunityID"),
				hitURL = baseURL + "deleteOpportunity",
				currentRow = $(this);			 
			var confirmation = confirm("Are you sure to delete this record ?"); 
			if(confirmation){
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { OpportunityID : OpportunityID } 
				}).done(function(data){
					console.log(data);  
					if(data.status == true) { alert("Record successfully deleted"); currentRow.parents('tr').remove(); }
					else if(data.status == false) { 
					alert("Delete Failed as There are "+data.count_ticket+" Ticket | "+data.count_booking+" Booking | "+data.count_tip+" TipTickets | "+data.count_tipautho+" Tip Authorized | "+data.count_notes+" Notes | "+data.count_contacts+" Contacts | "+data.count_document+" Document Records Associated with This Opportunity."); }
					else { alert("Access denied..!"); }
				});
			}
		});

		jQuery(document).on("click", ".oppo_status_deactive", function(){
		var table = $(this).attr("data-table-name"),
		    OpportunityID = $(this).attr("data-id"),
			hitURL = baseURL + "OppoChangeStatus";
			currentRow = $(this);	
			var confirmation = confirm("Are you sure you want to InActivate ?"); 
			if(confirmation){		
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { table : table,OpportunityID : OpportunityID , Status : 0 } 
				}).done(function(data){
					console.log(data);				
					if(data.status = true) { currentRow.removeClass('oppo_status_deactive label-success').addClass('oppo_status_active label-danger'); currentRow.text('InActive'); }
					
				});
			}
		
	});

	jQuery(document).on("click", ".oppo_status_active", function(){
		var table = $(this).attr("data-table-name"),
		    OpportunityID = $(this).attr("data-id"),
			hitURL = baseURL + "OppoChangeStatus";
			currentRow = $(this);	
			var confirmation = confirm("Are you sure you want to activate ?"); 
			if(confirmation){				
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { table : table, OpportunityID : OpportunityID , Status : 1 } 
				}).done(function(data){
					console.log(data);				
					if(data.status = true) { currentRow.removeClass('oppo_status_active label-danger').addClass('oppo_status_deactive label-success'); currentRow.text('Active'); }				
				});
			}
		
	});
	
		 
	} );
	
</script>