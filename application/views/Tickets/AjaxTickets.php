<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Tickets Management <small>Add, Edit, Delete</small>   </h1>    </section> 
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
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>In-Tickets"><i class="fa fa-plus"></i> Add In Ticket</a>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>Out-Tickets"><i class="fa fa-plus"></i> Add Out Ticket</a>
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>Collection-Tickets"><i class="fa fa-plus"></i> Add Collection Ticket</a>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Tickets List</h3>
					</div> 
					<div class="box-body">
					  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
						  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
						  <thead>
							<tr> 
								<th width="10" align="right">T.No </th>                        
								<th width="100" >Date </th>                        
								<th >Company Name</th>
								<th >Site Name</th>
								<th >Conveyance</th>
								<th width="20">Lorry</th>
								<th width="50">Veh.No</th>
								<th width="100">Driver Name</th> 
								<th width="30">Gross</th>
								<th width="30">Tare</th>
								<th width="30">Net</th> 
								<th width="30">OP</th>   
								<th class="text-center" width="150">Actions</th> 
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
				{ "data": "TicketNumber" ,"name": "TicketNumber", "data-sort": "TicketNumber_sort" },
				{ "data": "TicketDate" ,"name": "TicketDate", "data-sort":"TicketDate1" },
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" }, 
				{ "data": "Conveyance" , "name": "Conveyance" },
				{ "data": "driver_id" , "name": "driver_id" },
				{ "data": "RegNumber" , "name": "RegNumber" },
				{ "data": "DriverName" , "name": "DriverName" },
				{ "data": "GrossWeight" , "name": "GrossWeight" },
				{ "data": "Tare" , "name": "Tare" },
				{ "data": "Net" , "name": "Net" },
				{ "data": "TypeOfTicket", "name": "TypeOfTicket" }, 
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AJAXTickets') ?>", // json datasource
				type: "post",  // method  , by default get
				error: function(e){  // error handling
					$(".ticket-grid-error").html("");
					$("#ticket-grid").append('<tbody class="ticket-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#ticket-grid_processing").css("display","none");							
				}//,
				//success: function (data) {  
				//   alert(JSON.stringify( data )); 
				//   console.log(data);
 				//} 
			}, 
			columnDefs: [{ data: null, targets: -1 }],   
			createdRow: function (row, data, dataIndex) { 
				$(row).find("td:eq(2)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> ');
				$(row).find("td:eq(3)").html(' <a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				var pdf_path ='';
				if(data["TypeOfTicket"]=="Out"){
					if(data["LoadID"]!=0 && data["ReceiptName"]!=""){
						pdf_path = baseURL+'assets/conveyance/'+data["ReceiptName"];
					}else{
						pdf_path = baseURL+'assets/pdf_file/'+data["pdf_name"];
					}
				}else{	
					pdf_path = baseURL+'assets/pdf_file/'+data["pdf_name"];
				}
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-warning" target="blank" href="'+pdf_path+'" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'OfficeTicket/'+data["TicketNumber"]+'" title="Create Office Ticket"> G </a> <a class="btn btn-sm btn-info" href="'+baseURL+'View-'+data["TypeOfTicket"]+'-Ticket/'+data["TicketNo"]+'" title="View Ticket"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'edit-'+data["TypeOfTicket"]+'-ticket/'+data["TicketNo"]+'" title="Edit Ticket"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteTicket" href="#" data-ticketno="'+data["TicketNo"]+'" title="Delete"><i class="fa fa-trash"></i></a>');
				$(row).find('td:eq(0)').attr('data-sort', data['TicketNumber_sort']);
				$(row).find('td:eq(1)').attr('data-sort', data['TicketDate1']);
			}
		} );
	//	$('#ticket-grid thead tr').clone(true).appendTo( '#ticket-grid thead' );
	/*	$('#ticket-grid thead tr:eq(1) th').each( function (i) {
			var title = $(this).text(); 
			var tw = $(this).width();	
			$(this).html( '<input type="text"  style="width:'+tw+'px" placeholder="Search '+title+'" />' );
	 
			$( 'input', this ).on( 'keyup change', function () {
				if ( dataTable.column(i).search() !== this.value ) {
					dataTable
						.column(i)
						.search( this.value )
						.draw();
				}
			} );
		} );
	 
		$('#ddticket-grid thead th').each(function () {
            var title = $(this).text();
			var tw = $(this).width();	 
            $(this).html(title+' <input type="text" style="width:'+tw+'px" placeholder="' + title + '" />');
        }); */
		 
		//for delete update
		jQuery(document).on("click", ".deleteTicket", function(){
			var TicketNo = $(this).attr("data-TicketNo"),
				hitURL = baseURL + "deleteNotes",
				currentRow = $(this);			
				//alert(hitURL);	
			var confirmation = prompt("Why do you want to delete?", "");

			//var confirmation = confirm("Are you sure to delete this record ?");
			//console.log(confirmation);
			if(confirmation!=null)
			{
				
				if(confirmation!="")
				{
					//console.log("Your comment:"+confirmation);
					//alert(confirmation);
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { 'TicketNo' : TicketNo,'confirmation' :confirmation } 
				}).success(function(data){
					//console.log(data);
					
					currentRow.parents('tr').remove();
					if(data.status != "") { alert("Record successfully deleted"); }
					else{ alert("Record deletion failed"); }
					
				});
				
			}
			}
		});
		 
	} );
	
</script>