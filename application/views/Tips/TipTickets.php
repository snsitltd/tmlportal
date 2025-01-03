<link href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/jquery-ui.js'); ?>" type="text/javascript"></script>

<div class="content-wrapper" style="height:800px">
	<section class="content-header">
		<h1> <i class="fa fa-users"></i> Tip Tickets : <?php echo $TipInfo['TipName']; ?> </h1>
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
		<div id="dialog" style="display: none"></div>
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:1200px">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">View Images </h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#Collection" data-toggle="tab" aria-expanded="true">Tip Tickets </a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="Collection">
							<div class="row">
								<div class="col-xs-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title"><b>List Of Tip Tickets </b> </h3>
											<button class="btn btn-danger TipTicketExcelExport" name="exportxls" id="exportxls" style="float:right;margin: 6px "> Export XLS</button>
										</div>
										<div class="box-body">
											<div id="example2_wrapper" class="dataTables_wrapper   form-inline dt-bootstrap table-responsive">
												<div class="row">
													<div class="col-sm-6"></div>
													<div class="col-sm-6"></div>
												</div>
												<div class="row">
													<div class="col-sm-12">
														<div class="input-group" style="width:390px;float:left; ">
															<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
															<input type="text" class="form-control " id="reservation" autocomplete="off" onkeydown="return false" placeholder="Search Date Range " name="reservation" value="" style="width:300px">
														</div>
														<div class="large-table-container-2">
															<table id="dtexample" style="width:100%" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
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
	var TipID = <?php echo $TipInfo['TipID']; ?>;
	var GetTableMetaApiEndpoint = 'ViewTipTicketsTableMeta'; //Endpoint returning Table Metadata 
	var GetTableDataApiEndpoint = 'AjaxViewTipTickets'; //Endpoint processing and return Table Data
	var searchID = new URLSearchParams(window.location.search).get('searchID');
	console.log(searchID);

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
						defaultContent: '',
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
					var reservation = document.getElementById("reservation").value;
					if (reservation != "") {
						data.search.value = "";
					}
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
						'search': data.search.value,
						'Reservation': reservation
					};
					//add each column as formdata key/value for filtering
					data['columns'].forEach(function(items, index) {
						col = data['columns'][index]['data'];
						colfilter = data['columns'][index]['search']['value'];
						arr[col] = colfilter;
					});
					arr['TipID'] = TipID
					return arr;
				}
			}, //, "visible": false 
			//"lengthMenu": [10, 50, 100],
			"bLengthChange": false,
			"searching": true,
			"order": [
				[0, "desc"]
			],
			"columnDefs": [{
					"width": "10px",
					"targets": 0
				},
				{
					"width": "105px",
					"targets": 1
				},
				{
					"width": "60px",
					"targets": 2
				},
				{
					"width": "120px",
					"targets": 4
				},
				{
					"width": "50px",
					"targets": 6
				},
				{
					"width": "80px",
					"targets": 8,
					"orderable": false
				}
			],
			rowId: 'LoadID',
			createdRow: function(row, data, dataIndex) {
				var lk1 = baseURL + 'assets/conveyance/' + data["ReceiptName"];
				var conveyanceNo = data["ConveyanceNo"] ? data["ConveyanceNo"] : 'N/A'; // Use 'N/A' or a default value for null
				$(row).find("td:eq(2)").html('<a class="btn btn-sm btn-warning" target="_blank" href="' + lk1 + '" title="View Conveyance Ticket"><i class="fa fa-file-pdf-o"></i> ' + conveyanceNo + ' </a>');

				var receiptName = data["ReceiptName"]; // Store ReceiptName in a separate variable
				var tipTicketID = data["TipTicketID"]; // Use TipTicketID correctly here
				var tipTicketNo = data["TipTicketNo"];
				var tipId = data["TipID"];
				var tipName = data["TipName"];

				// Create the input field
				var inputField = '<input type="text" class="TipTicketNoUpdate" data-TipTicketID="' + tipTicketID + '" id="TipTicketNo' + tipTicketID + '" style="text-align:right;width:80px" value="' + tipTicketNo + '" name="TipTicketNo' + tipTicketID + '" >';

				// Check if there is a value for TipTicketNo
				if (tipId === 1) {
					// For TipID == 1, show a normal hyperlink without additional checks
					if (tipTicketNo) {
						var linkURL = baseURL + 'assets/tiptickets/' + tipTicketID;
						$(row).find("td:eq(6)").html('<a href="' + linkURL + '" target="_blank">' + inputField + '</a>');
					} else {
						// If no TipTicketNo value exists, display only the input field
						$(row).find("td:eq(6)").html(inputField);
					}
				} else {
					// For TipID != 1, validate the link as a PDF
					if (tipTicketNo) {
						const linkURL = `http://193.117.210.98:8081/ticket/Supplier/${tipName}-${tipTicketNo}.pdf`;

						// Simple logic to ensure the URL is a PDF
						if (linkURL.endsWith('.pdf')) {
							// If it looks like a valid PDF URL, make it a hyperlink
							$(row).find("td:eq(6)").html('<a href="' + linkURL + '" target="_blank">' + inputField + '</a>');
						} else {
							// If not a PDF, display only the input field
							$(row).find("td:eq(6)").html(inputField);
						}
					} else {
						// If no TipTicketNo value exists, display only the input field
						$(row).find("td:eq(6)").html(inputField);
					}
				}

				var TP = '';
				if (data["TotalPhotos"] > 0) {
					TP = '<a href="#" class="btn btn-sm btn-info TipImage" data-TipTicketID="' + tipTicketID + '" ><i class="fa fa-image"></i></a>';
				}

				var statusBadge = '';
				switch (data["Status"]) {
					case 'Finished':
						statusBadge = '<span class="badge bg-success">Finished</span>';
						break;
					case 'Cancelled':
						statusBadge = '<span class="badge bg-danger">Cancelled</span>';
						break;
					case 'Wasted':
						statusBadge = '<span class="badge bg-warning">Wasted</span>';
						break;
					case 'Invoice Cancelled':
						statusBadge = '<span class="badge bg-secondary">Invoice Cancelled</span>';
						break;
					default:
						statusBadge = '<span class="badge bg-dark">Unknown</span>';
				}
				$(row).find("td:eq(7)").html(statusBadge);
				$(row).find("td:eq(-1)").html('<a class="btn btn-sm btn-warning" target="blank" href="' + lk1 + '" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> ' + TP);
			},

			serverSide: true,
			"processing": true,
			aoColumns: mdataArray
		});
		if (searchID) {
			table.column(0).search(searchID).draw(); // Replace 0 with the index or key of the "TNO" column
		}

		$('#dtexample thead tr:nth-child(2) th').each(function() {
			var title = $(this).text();
			if (title != '')
				$(this).html('<input type="text" class="sorthandle" title="' + title + '" id="' + title + '" style="width:100%;" />');
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
		$('#reservation').on('change', function() {
			//alert("qqqqqq")
			table.search($(this).val()).draw();
		});

	}
	$(document).ready(function() {
		$('#reservation').daterangepicker({
			locale: {
				format: 'DD/MM/YYYY'
			}
		});
		$('#reservation').val('');
		$('#reservation').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			table.search('').draw();
		});
		getTableMeta();
		jQuery(document).on("click", ".TipImage", function() {
			//$('#empModal').modal('show');  
			var TipTicketID = $(this).attr("data-TipTicketID"),
				hitURL1 = baseURL + "AJAXShowTipTicketImages",
				currentRow = $(this);
			//alert(TipTicketID)
			//console.log(confirmation); 
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				url: hitURL1,
				data: {
					'TipTicketID': TipTicketID
				}
			}).success(function(data) {
				//alert(data)
				$('.modal-body').html(data);
				$('#empModal').modal('show');
			});
		});

		jQuery(document).on("change", ".TipTicketNoUpdate", function() {
			var TipTicketID = $(this).attr("data-TipTicketID"),
				TipTicketNo = $(this).val(),
				hitURL1 = baseURL + "TipTicketNoUpdateAJAX",
				currentRow = $(this);
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				url: hitURL1,
				data: {
					'TipTicketID': TipTicketID,
					'TipTicketNo': TipTicketNo
				}
			}).success(function(data) {
				//alert(JSON.stringify(data))  
				if (data.status == true) {
					$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> TipTicketNo has been Updated Successfully !!! </div>')
				} else {
					$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>')
				}
			});
		});

		jQuery(document).on("click", ".TipTicketExcelExport", function() {


			var TipTicketID = $('#TipTicketID').val(),
				TipDateTime = $('#TipDateTime').val(),
				reservation = $('#reservation').val(),
				ConveyanceNo = $('#ConveyanceNo').val(),
				SiteAddress = $('#SiteAddress').val(),
				DriverName = $('#DriverName').val(),
				MaterialName = $('#MaterialName').val(),
				TipTicketNo = $('#TipTicketNo').val(),
				Remarks = $('#Remarks').val(),
				Search = $('input[type="search"]').val(),
				hitURLCon = baseURL + "TipTicketExcelExport",
				currentRow = $(this);

			if (reservation != "" || TipDateTime != "") {
				//jQuery('#exportxls').prop('disabled', true); 
				jQuery.ajax({
					type: "POST",
					dataType: "json",
					url: hitURLCon,
					data: {
						'Search': Search,
						'TipID': TipID,
						'TipTicketID': TipTicketID,
						'TipDateTime': TipDateTime,
						'reservation': reservation,
						'ConveyanceNo': ConveyanceNo,
						'SiteAddress': SiteAddress,
						'DriverName': DriverName,
						'MaterialName': MaterialName,
						'TipTicketNo': TipTicketNo,
						'Remarks': Remarks
					}
				}).success(function(data) {
					//jQuery('#exportxls').prop('disabled', false); 
					//alert(data.file);
					var $a = $("<a>");
					$a.attr("href", data.file);
					$("body").append($a);
					$a.attr("download", data.FileName);
					$a[0].click();
					$a.remove();
				});
			} else {
				alert("Please Select DateRange OR Datetime ....  ");
			}

		});

	});
</script>