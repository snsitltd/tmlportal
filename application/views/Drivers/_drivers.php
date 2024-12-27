<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Lorry Management  <small>Add, Edit, Delete</small> </h1> </section> 
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
	<div class="modal fade" id="empModal" role="dialog">
		<div class="modal-dialog" style="width:600px">  
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
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a href="<?php echo base_url("addDriver"); ?>" class="btn btn-primary" data-toggle="modal"  >  <i class="fa fa-plus"></i> Add New  </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Lorry List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th width="55" align="right">Lorry No</th>                        
                        <th >Driver Name</th>   
                        <th width="100">Reg Number</th>   
                        <th width="70" align="right">Tare</th>  
                        <th>Haulier</th>        
						<th  width="55">AppUser</th>
                        <th class="text-center" width="150">Actions</th>
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
				{ "data": "DriverName" ,"name": "DriverName"  },
				{ "data": "RegNumber" ,"name": "RegNumber"  },
				{ "data": "Tare" , "name": "Tare" },
				{ "data": "Haulier" , "name": "Haulier" },   
				//{ "data": "TotalTickets" , "name": "TotalTickets" },   
				{ "data": null }, 
				{ "data": null } 
			  ],v
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AJAXDrivers') ?>", // json datasource
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
				var del= ""; var au= ""; var EditDri= ""; var DN= "";
				//if(data["AppUser"] == 1 ){ au = "NO"; } 
				if(data["AppUser"] == 0 && data["ContractorID"] != 0  ){ au = "<b>Yes</b>"; EditDri = ' <a class="btn btn-sm btn-warning UpdateLorryDriver" data-LorryNo="'+data["LorryNo"]+'"  href="#" title="Update Lorry Driver"> <i class="fa fa-edit"></i></a>'; 
				}else{ au = "NO"; EditDri = '';  } 
				EditDri = ' <a class="btn btn-sm btn-warning UpdateLorryDriver" data-LorryNo="'+data["LorryNo"]+'"  href="#" title="Update Lorry Driver"> <i class="fa fa-edit"></i></a>'; 
				if(data["DriverID"] != '0'){ DN  = data["DriverName"]; }else{ DN  = data["dname"]; } 
				
				$(row).find("td:eq(-2)").html(au);	
				if(DN!=''){
					$(row).find("td:eq(1)").html(DN);	
				}else{ 
					$(row).find("td:eq(1)").html(data["dname"]);	 
				}
				//if(data["TotalTickets"]>0){ del = ""; }else{ del = '<a class="btn btn-sm btn-danger deleteDriver" href="#" data-LorryNo="'+data["LorryNo"]+'" title="Delete"><i class="fa fa-trash"></i></a>'; } 
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'viewDriver/'+data["LorryNo"]+'" title="View Driver"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'editDriver/'+data["LorryNo"]+'" title="Update Lorry  "> <i class="fa fa-pencil"></i></a>  '+EditDri+' <a class="btn btn-sm btn-danger deleteDriver" href="#" data-LorryNo="'+data["LorryNo"]+'" title="Delete"><i class="fa fa-trash"></i></a>');
//				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'viewDriver/'+data["LorryNo"]+'" title="View Driver"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'editDriverLogin/'+data["LorryNo"]+'" title="Edit Driver Login"><i class="fa fa-user"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'editDriver/'+data["LorryNo"]+'" title="Edit Company"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteDriver" href="#" data-LorryNo="'+data["LorryNo"]+'" title="Delete"><i class="fa fa-trash"></i></a>');
			}
		} );
 		
		jQuery(document).on("click", ".UpdateLorryDriver", function(){  
		//$('#empModal').modal('show');   
				var LorryNo = $(this).attr("data-LorryNo"),   
					hitURL1 = baseURL + "UpdateLorryDriverAJAX",
					currentRow = $(this);  
				//console.log(confirmation); 
				//alert(PendingLoads)
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'LorryNo' : LorryNo } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Update Lorry Driver ");
					$('#empModal .modal-dialog').width(500);
					$('#empModal').modal('show');  
				});  
				 
		});
		jQuery(document).on("click", ".deleteDriver", function(){
			var LorryNo = $(this).attr("data-LorryNo"),
				hitURL = baseURL + "deleteDriver",
				currentRow = $(this);			
			
			var confirmation = confirm("Are you sure to delete this record ?");
			
			if(confirmation)
			{
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

		 
	} );
	
</script>

<!-- <script src="<?= base_url('assets/validation/dist/parsley.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Drivers.js" charset="utf-8"></script> -->
  




