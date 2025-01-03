<div class="content-wrapper">
	<section class="content-header">
		<h1> <i class="fa fa-users"></i> Inbound Tickets </h1>
	</section>
	<section class="content">
		<div class="msg"></div>
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
						<h3 class="box-title"><b>Inbound Tickets List</b></h3>
						<a class="btn btn-primary" href="<?php echo base_url(); ?>Collection-Tickets" style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add Collection Ticket</a>
						<a class="btn btn-success" href="<?php echo base_url(); ?>Out-Tickets" style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add Out Ticket</a>
						<a class="btn btn-danger" href="<?php echo base_url(); ?>In-Tickets" style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add In Ticket</a>
						<?php if ($CountInBoundTicketsPDF[0]['ccnt'] > 0) { ?>
							<a class="btn btn-danger" href="<?php echo base_url(); ?>InBoundPDF" target="_blank" style="float:right;margin: 6px "><i class="fa fa-plus"></i> Create PDFs (<?php echo $CountInBoundTicketsPDF[0]['ccnt']; ?>)</a>
						<?php } ?>
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

	var GetTableMetaApiEndpoint = 'InboundTicketsTableMeta'; //Endpoint returning Table Metadata 
	var GetTableDataApiEndpoint = 'AJAXInboundTickets'; //Endpoint processing and return Table Data

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

				//$(row).find("td:eq(1)").html('<input type="text" class="GridDate  "  data-TicketNo="'+data["TicketNo"]+'"  id="TicketDate'+data["TicketNo"]+'" style="text-align:right;width:120px" value="'+data["TicketDate"]+'" name="TicketDate'+data["TicketNo"]+'"   maxlength="20"  >');
				$(row).find("td:eq(1)").html(data["TicketDate"]);
				$(row).find("td:eq(2)").html(' <a href="' + baseURL + 'view-company/' + data["CompanyID"] + '" target="_blank" title="' + data["CompanyName"] + '">' + data["CompanyName"] + '</a> ');
				$(row).find("td:eq(3)").html(' <a href="' + baseURL + 'View-Opportunity/' + data["OpportunityID"] + '" target="_blank" title="' + data["OpportunityName"] + '">' + data["OpportunityName"] + '</a> ');
				$(row).find("td:eq(8)").html('<input type="text" class="GridGross"  data-TicketNo="' + data["TicketNo"] + '"   data-Tare="' + data["Tare"] + '"  id="Gross' + data["TicketNo"] + '" style="text-align:right;width:70px" value="' + data["GrossWeight"] + '" name="Gross' + data["TicketNo"] + '"   maxlength="10"  >');
				$(row).find("td:eq(-1)").html('<a class="btn btn-sm btn-info" href="' + baseURL + 'EditInBound/' + data["TicketNo"] + '" title="Edit Inbound Ticket"><i class="fa fa-pencil"></i></a>');

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
		jQuery(document).on("change", ".GridDate111111111", function() {
			event.preventDefault();
			var TicketNo = $(this).attr("data-TicketNo"),
				TicketDate = $(this).val(),
				hitURLUP1 = baseURL + "AJAXUpdateTicketDate",
				currentRow = $(this);
			//alert(BookingDateID);
			//Price = $('#Price'+BookingDateID).val(),  
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				url: hitURLUP1,
				data: {
					'TicketNo': TicketNo,
					'TicketDate': TicketDate
				}
			}).success(function(data) {
				//alert(JSON.stringify(data)) 
				if (data.status == true) {
					//$('.cls'+BookingID).val(Price); 
					//currentRow.parents('tr').remove();
					//alert("asdfasdfadf");
					$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Ticket Date has been Updated Successfully !!! </div>')
				} else {
					$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>')
					//alert("Oooops, Please try again later"); 
				}

			});

		});
		jQuery(document).on("change", ".GridGross", function() {
			event.preventDefault();
			var TicketNo = $(this).attr("data-TicketNo"),
				Tare = $(this).attr("data-Tare"),
				Gross = $(this).val(),
				hitURLUP = baseURL + "AJAXUpdateGrossWeight",
				currentRow = $(this);
			//alert(BookingDateID);
			//Price = $('#Price'+BookingDateID).val(),  
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				url: hitURLUP,
				data: {
					'TicketNo': TicketNo,
					'Gross': Gross,
					'Tare': Tare
				}
			}).success(function(data) {
				//alert(JSON.stringify(data)) 
				if (data.status == true) {
					//$('.cls'+BookingID).val(Price); 
					currentRow.parents('tr').remove();
					$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Gross Weight has been Updated Successfully !!! </div>')
				} else {
					$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>')
					//alert("Oooops, Please try again later"); 
				}

			});

		});


	});
</script>