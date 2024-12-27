<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Lorry Management  <small>Add, Edit, Delete</small>   
	<a href="<?php echo base_url("Lorry"); ?>" class="btn btn-danger"   style="float:right"  >  Thames Lorry  </a>
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
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Others Lorry List   </h3>
			  <a href="<?php echo base_url("AddLorry"); ?>" class="btn btn-primary"  style="float:right"  >  <i class="fa fa-plus"></i> Add New  </a> 
            </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th width="55" align="right">LorryNo</th>       
                        <th width="100">Reg Number</th>   
                        <th width="70" align="right">Tare</th>  
                        <th >Driver Name</th>   
						<th>Haulier</th>      
                        <th class="text-center" width="70">Actions</th>
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
				{ "data": "LorryNo" ,"name": "LorryNo"  },	 
				{ "data": "RegNumber" ,"name": "RegNumber"  },
				{ "data": "Tare" , "name": "Tare" },
				{ "data": "DriverName" ,"name": "DriverName"  },
				{ "data": "Haulier" , "name": "Haulier" },   
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AJAXDriversOthers') ?>", // json datasource
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
				var AppUser = '';
				if(data["AppUser"]==0){ AppUser = 'Yes'; }else{ AppUser = 'No'; }
				$(row).find("td:eq(5)").html(AppUser); 
				
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'EditLorry/'+data["LorryNo"]+'" title="Update Lorry  "> <i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteDriver" href="#" data-LorryNo="'+data["LorryNo"]+'" title="Delete"><i class="fa fa-trash"></i></a>'); 
			}
		});
 		 
		jQuery(document).on("click", ".deleteDriver", function(){
			var LorryNo = $(this).attr("data-LorryNo"),
				hitURL = baseURL + "DeleteLorry",
				currentRow = $(this);			
			
			var confirmation = confirm("Are you sure to delete this Lorry ?");
			
			if(confirmation){
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { LorryNo : LorryNo } 
				}).done(function(data){
					if(data["status"] == true) { alert("Record successfully deleted"); currentRow.parents('tr').remove(); }
					else if(data["status"] == false) { alert("Ooops, Record deletion failed, There are "+data["count"]+" Tickets Associated with this Driver."); }
					else { alert("Access denied..!"); }
				});
			}
		}); 
	});
	
</script> 