<div class="content-wrapper">
	<section class="content-header">
		<h1> <i class="fa fa-users"></i> Collection NonAPP HOLD Tickets Management </h1>
	</section>
	<section class="content">
		<?php
		$error = $this->session->flashdata('error');
		if ($error) {
		?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $this->session->flashdata('error'); ?>
			</div>
		<?php } ?>
		<?php
		$success = $this->session->flashdata('success');
		if ($success) {
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
						<h3 class="box-title"><b>Collection NonAPP HOLD Tickets List</b></h3>
						<a class="btn btn-primary" href="<?php echo base_url(); ?>Collection-Tickets" style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add Collection Ticket</a>
						<a class="btn btn-success" href="<?php echo base_url(); ?>Out-Tickets" style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add Out Ticket</a>
						<a class="btn btn-danger" href="<?php echo base_url(); ?>In-Tickets" style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add In Ticket</a>
					</div>
					<div class="box-body">
						<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
							<div class="row">
								<div class="col-sm-6"></div>
								<div class="col-sm-6"></div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<table id="dtexample" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
										<thead id="headD">
											<tr></tr>
											<tr></tr>
										</thead>
										<tbody id="dataD" runat="server"></tbody>
										<tfoot>
											<tr> </tr>
										</tfoot>
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
<script type="text/javascript" language="javascript">
	var mdataArray = [];

	var ColumnData;
	var defaultcol = "";

	var apiUrl = baseURL;

	var GetTableMetaApiEndpoint = 'HoldTicketsTableMeta'; //Endpoint returning Table Metadata 
	var GetTableDataApiEndpoint = 'AJAXHoldTickets'; //Endpoint processing and return Table Data

	function getTableMeta() {

		$.ajax({
			type: 'POST',
			url: apiUrl + GetTableMetaApiEndpoint,
			dataType: 'json',
			success: function(data) {
				console.log(data);
				ColumnData = data.Column;

				$.each(data.Column, function(index, element) {
					$('#dtexample thead tr:first-child').append($('<th>', {
						text: element.Title
					}));
					//search
					if (element.Searchable == true)
						$('#dtexample thead tr:nth-child(2)').append($('<th>', {
							text: element.Name
						}));
					else $('#dtexample thead tr:nth-child(2)').append($('<th>', {
						text: ''
					}));
					mdataArray.push({
						mData: element.Name,
						class: element.Name
					});
				});
				if (data.Action == true) {
					// Create First Row Title 
					$('#dtexample thead tr:first-child').append($('<th>', {
						text: 'Action'
					}));
					// Create remain Row for data 
					$('#dtexample thead tr:nth-child(2)').append($('<th>', {
						text: ''
					}));
					// Push default content for all nth rows  
					//mdataArray.push({ defaultContent: '<span class="deleteBtn"><img src="./Icons/delete.png" style="width:28px" /></span>', class: 'DeleteRow' });
					mdataArray.push({
						defaultContent: ' ',
						class: ''
					});

				}

				defaultcol = data.Column[0].Title;
				//once table headers and table data property set, initialize DT
				initializeDataTable();

			}
		});
	}

	function initializeDataTable() {

		//put Input textbox for filtering
		$('#dtexample thead tr:nth-child(2) th').each(function() {
			var title = $(this).text();
			if (title != '')
				$(this).html('<input type="text" class="sorthandle" style="width:100%;" />');
		});
		//don't sort when user clicks on input textbox to type for filter
		$('#dtexample').find('thead th').click(function(event) {
			if ($(event.target).hasClass('sorthandle')) {
				event.stopImmediatePropagation()
			}
		});
		table = $('#dtexample').DataTable({
			"pageLength": 100,
			"ajax": {
				"url": apiUrl + GetTableDataApiEndpoint,
				"type": "POST",
				data: function(data) {
					editIndexTable = -1;
					var colname;

					var sort = data.order[0].column;
					if (!data['columns'][sort]['data'] == '')
						colname = data['columns'][sort]['data'] + ' ' + data.order[0].dir;
					//in case no sorted col is there, sort by first col
					else colname = defaultcol + " asc";

					var colarr = [];
					//colname = 'TicketNo DESC ';
					var colfilter, col;
					var arr = {
						'draw': data.draw,
						'length': data.length,
						'sort': colname,
						'start': data.start,
						'search': data.search.value
					};
					//add each column as formdata key/value for filtering
					data['columns'].forEach(function(items, index) {
						col = data['columns'][index]['data'];
						colfilter = data['columns'][index]['search']['value'];
						arr[col] = colfilter;
					});
					return arr;
				}
			},
			"lengthMenu": [10, 50, 100],
			"searching": true,
			"order": [
				[1, "desc"]
			],
			"columnDefs": [{
					"width": "60px",
					"targets": 0
				},
				{
					"width": "80px",
					"targets": 1
				},
				{
					"width": "20px",
					"targets": 5
				},
				{
					"width": "50px",
					"targets": 6
				},
				{
					"width": "100px",
					"targets": 7
				},
				{
					"width": "30px",
					"targets": 8
				},
				{
					"width": "30px",
					"targets": 9
				},
				{
					"width": "30px",
					"targets": 10
				},
				{
					"width": "30px",
					"targets": 11
				},
				{
					"width": "90px",
					"targets": 12
				},
			],
			//rowId required when doing update, can put any unique value for each row instead of ID
			rowId: 'TicketNo',
			dom: '<"toolbar">frtip',
			createdRow: function(row, data, dataIndex) {
				var DName = "";
				if (data["LoadID"] != 0) {
					DName = data["LoginDriverName"];
				} else {
					DName = data["DriverName"];
				}
				$(row).find("td:eq(7)").html(DName);
				$(row).find("td:eq(2)").html(' <a href="' + baseURL + 'view-company/' + data["CompanyID"] + '" target="_blank" title="' + data["CompanyName"] + '">' + data["CompanyName"] + '</a> ');
				$(row).find("td:eq(3)").html(' <a href="' + baseURL + 'View-Opportunity/' + data["OpportunityID"] + '" target="_blank" title="' + data["OpportunityName"] + '">' + data["OpportunityName"] + '</a> ');
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="' + baseURL + 'View-' + data["TypeOfTicket"] + '-Ticket/' + data["TicketNo"] + '" title="View Ticket"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="' + baseURL + 'edit-' + data["TypeOfTicket"] + '-ticket/' + data["TicketNo"] + '" title="Edit Ticket"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteTicket" href="#" data-ticketno="' + data["TicketNo"] + '" title="Delete"><i class="fa fa-trash"></i></a>');
				$(row).find('td:eq(0)').attr('data-sort', data['TicketNumber_sort']);
				$(row).find('td:eq(1)').attr('data-sort', data['TicketDate1']);
			},
			serverSide: true,
			"processing": true,
			aoColumns: mdataArray
		});

		//call search api when user types in filter input
		table.columns().every(function() {
			var that = this;
			$('input', this.header()).on('keyup change', function() {
				if (that.search() !== this.value) {
					that.search(this.value).draw();
				}
			});
		});
	}


	$(document).ready(function() {
		getTableMeta();


		/*var dataTable = $('#ticket-grid').DataTable({
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
				url : "<?php echo site_url('AJAXHoldTickets') ?>", // json datasource
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
				$(row).find("td:eq(2)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> ');
				$(row).find("td:eq(3)").html(' <a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-info" href="'+baseURL+'View-'+data["TypeOfTicket"]+'-Ticket/'+data["TicketNo"]+'" title="View Ticket"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'edit-'+data["TypeOfTicket"]+'-ticket/'+data["TicketNo"]+'" title="Edit Ticket"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteTicket" href="#" data-ticketno="'+data["TicketNo"]+'" title="Delete"><i class="fa fa-trash"></i></a>');
				$(row).find('td:eq(0)').attr('data-sort', data['TicketNumber_sort']);
				$(row).find('td:eq(1)').attr('data-sort', data['TicketDate1']);
			}
		} );*/

		//for delete update
		jQuery(document).on("click", ".deleteTicket", function() {
			var TicketNo = $(this).attr("data-TicketNo"),
				hitURL = baseURL + "deleteNotes",
				currentRow = $(this);
			//alert(hitURL);	
			var confirmation = prompt("Why do you want to delete?", "");

			//var confirmation = confirm("Are you sure to delete this record ?");
			//console.log(confirmation);
			if (confirmation != null) {

				if (confirmation != "") {
					//console.log("Your comment:"+confirmation);
					//alert(confirmation);
					jQuery.ajax({
						type: "POST",
						dataType: "json",
						url: hitURL,
						data: {
							'TicketNo': TicketNo,
							'confirmation': confirmation
						}
					}).success(function(data) {
						//console.log(data);

						currentRow.parents('tr').remove();
						if (data.status != "") {
							alert("Record successfully deleted");
						} else {
							alert("Record deletion failed");
						}

					});

				}
			}
		});

	});
</script>