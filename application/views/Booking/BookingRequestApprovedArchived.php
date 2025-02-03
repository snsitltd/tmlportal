	 <div class="content-wrapper">
	 	<section class="content-header">
	 		<h1> <i class="fa fa-users"></i> Archived Approved Booking Request <small>Add, Edit, Delete</small> </h1>
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
	 		<div class="modal fade" id="empModal" role="dialog">
	 			<div class="modal-dialog" style="width:500px">
	 				<!-- Modal content-->
	 				<div class="modal-content">
	 					<div class="modal-header">
	 						<h4 class="modal-title">Booking Loads/Lorry Information </h4>
	 						<button type="button" class="close" data-dismiss="modal">&times;</button>
	 					</div>

	 					<div class="modal-body"></div>

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
	 						<li class="active"><a href="#" aria-expanded="false">Archived Approved Booking Request</a></li>
	 						<a class="btn btn-success" href="<?php echo base_url('BookingRequest'); ?>" style="float:right;margin: 6px "> Current Booking</a>
	 					</ul>

	 					<div class="tab-content">
	 						<div class="tab-pane active" id="Approved">
	 							<div class="row">
	 								<div class="col-xs-12">
	 									<div class="box">
	 										<div class="box-header">
	 											<h3 class="box-title">Archived Approved Booking List</h3>
	 										</div>
	 										<div class="box-body">
	 											<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
	 												<div class="row">
	 													<div class="col-sm-6"></div>
	 													<div class="col-sm-6"></div>
	 												</div>
	 												<div class="row">
	 													<div class="col-sm-12">
	 														<table id="dtexample1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
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

	 	</section>
	 </div>
	 <script type="text/javascript" language="javascript">
	 	var mdataArray1 = [];

	 	var ColumnData1;
	 	var defaultcol = "";

	 	var apiUrl = baseURL; //Url for Server API

	 	var GetTableMetaApiEndpoint1 = 'BookingRequestTableMeta1'; //Endpoint returning Table Metadata 
	 	var GetTableDataApiEndpoint1 = 'AjaxBookingsRequestArchived'; //Endpoint processing and return Table Data

	 	function getTableMeta1() {
	 		$.ajax({
	 			type: 'POST',
	 			url: apiUrl + GetTableMetaApiEndpoint1,
	 			dataType: 'json',
	 			success: function(data) {
	 				console.log(data);
	 				ColumnData1 = data.Column;

	 				$.each(data.Column, function(index, element) {
	 					$('#dtexample1 thead tr:first-child').append($('<th>', {
	 						text: element.Title
	 					}));
	 					//search
	 					if (element.Searchable == true)
	 						$('#dtexample1 thead tr:nth-child(2)').append($('<th>', {
	 							text: element.Name
	 						}));
	 					else $('#dtexample1 thead tr:nth-child(2)').append($('<th>', {
	 						text: ''
	 					}));
	 					mdataArray1.push({
	 						mData: element.Name,
	 						class: element.Name
	 					});
	 				});
	 				if (data.Action == true) {
	 					// Create First Row Title 
	 					$('#dtexample1 thead tr:first-child').append($('<th>', {
	 						text: 'Action'
	 					}));
	 					// Create remain Row for data 
	 					$('#dtexample1 thead tr:nth-child(2)').append($('<th>', {
	 						text: ''
	 					}));
	 					// Push default content for all nth rows  
	 					//mdataArray.push({ defaultContent: '<span class="deleteBtn"><img src="./Icons/delete.png" style="width:28px" /></span>', class: 'DeleteRow' });
	 					mdataArray1.push({
	 						defaultContent: ' ',
	 						class: ''
	 					});

	 				}

	 				defaultcol = data.Column[0].Title;
	 				//once table headers and table data property set, initialize DT
	 				initializeDataTable1();

	 			}
	 		});
	 	}

	 	function initializeDataTable1() {
	 		//put Input textbox for filtering
	 		$('#dtexample1 thead tr:nth-child(2) th').each(function() {
	 			var title = $(this).text();
	 			if (title != '')
	 				$(this).html('<input type="text" class="sorthandle" style="width:100%;" />');
	 		});
	 		//don't sort when user clicks on input textbox to type for filter
	 		$('#dtexample1').find('thead th').click(function(event) {
	 			if ($(event.target).hasClass('sorthandle')) {
	 				event.stopImmediatePropagation()
	 			}
	 		});
	 		table = $('#dtexample1').DataTable({
	 			"pageLength": 100,
	 			"ajax": {
	 				"url": apiUrl + GetTableDataApiEndpoint1,
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
	 					//colname = 'OpportunityID asc';
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
	 			"columnDefs": [{
	 					"width": "5px",
	 					"targets": 0
	 				},
	 				{
	 					"width": "50px",
	 					"targets": 1
	 				},
	 				{
	 					"width": "30px",
	 					"targets": 5
	 				},
	 				{
	 					"width": "30px",
	 					"targets": 6
	 				},
	 				{
	 					"width": "30px",
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
	 					"width": "30px",
	 					"targets": 12
	 				},

	 				{
	 					"width": "70px",
	 					"targets": 13
	 				},
	 				{
	 					"width": "70px",
	 					"targets": 14
	 				},
	 				{
	 					"width": "40px",
	 					"targets": 15
	 				},
	 				{
	 					"width": "90px",
	 					"targets": 16
	 				}
	 			],
	 			//rowId required when doing update, can put any unique value for each row instead of ID
	 			rowId: 'BookingDateID',
	 			dom: '<"toolbar">frtip',
	 			createdRow: function(row, data, dataIndex) {

	 				var btype = '';
	 				var del = '';
	 				var edi = '';
	 				var LorryType = '';
	 				if (data["BookingType"] == 1) {
	 					$(row).addClass("even1");
	 					btype = 'Collection';
	 				} else {
	 					$(row).addClass("odd1");
	 					btype = 'Delivery';
	 				}
	 				if (data["LoadType"] == 1) {
	 					$(row).find("td:eq(8)").html('Loads');
	 					NoLoads = data["Loads"];
	 				} else {
	 					$(row).find("td:eq(8)").html('TurnAround');
	 					NoLoads = data["Loads"];
	 				}
	 				if (data["LorryType"] == 1) {
	 					LorryType = 'Tipper';
	 				} else if (data["LorryType"] == 2) {
	 					LorryType = 'Grab';
	 				} else if (data["LorryType"] == 3) {
	 					LorryType = 'Bin';
	 				}

	 				//if(data["TotalLoadAllocated"] == '0'){  
					if(data['Status'] == "0"){
						del = '<a class="btn btn-sm btn-danger deleteRequest" href="#" data-BookingDateID="' + data["BookingDateID"] + '"  data-BookingRequestID="' + data["BookingRequestID"] + '"  data-BookingID="' + data["BookingID"] + '" title="Delete"><i class="fa fa-trash"></i></a>';
					}
	 				if (data["TonBook"] == 1) {
	 					$(row).find("td:eq(5)").html(data["TotalLoad"]);
	 					$(row).find("td:eq(6)").html(data["TonPerLoad"]);
	 					$(row).find("td:eq(8)").html('Tonnage');
	 					edi = '<a class="btn btn-sm btn-info" href="' + baseURL + 'EditBookingRequestTonnage/' + data["BookingRequestID"] + '" title="Edit Booking Request Tonnage"><i class="fa fa-pencil"></i></a>';
	 				} else {
	 					if (data["BookingType"] == 3) {
	 						edi = '<a class="btn btn-sm btn-info" href="' + baseURL + 'EditBookingRequestDaywork/' + data["BookingRequestID"] + '" title="Edit Daywork Booking Request"><i class="fa fa-pencil"></i></a>';
	 					} else {
	 						edi = '<a class="btn btn-sm btn-info" href="' + baseURL + 'EditBookingRequest/' + data["BookingRequestID"] + '" title="Edit Booking Request"><i class="fa fa-pencil"></i></a>';
	 					}

	 					$(row).find("td:eq(5)").html('-');
	 					$(row).find("td:eq(6)").html('-');

	 				}
	 				//edi = '<a class="btn btn-sm btn-info" href="'+baseURL+'EditBookingRequest/'+data["BookingRequestID"]+'" title="Edit Booking Request"><i class="fa fa-pencil"></i></a>' ;
	 				//}

	 				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingDateID="' + data["BookingDateID"] + '" herf="#" >  ' + data["BookingRequestID"] + '</a>');
	 				$(row).find("td:eq(7)").html(btype);
	 				$(row).find("td:eq(2)").html(' <a href="' + baseURL + 'view-company/' + data["CompanyID"] + '" target="_blank" title="' + data["CompanyName"] + '">' + data["CompanyName"] + '</a> ');
	 				$(row).find("td:eq(3)").html(' <a href="' + baseURL + 'View-Opportunity/' + data["OpportunityID"] + '" target="_blank" title="' + data["OpportunityName"] + '">' + data["OpportunityName"] + '</a> ');
	 				$(row).find("td:eq(10)").html(LorryType);
	 				$(row).find("td:eq(11)").html('<input type="text" class="GridPrice cls' + data["BookingID"] + '" data-BookingRequestID="' + data["BookingRequestID"] + '"  data-Loads="' + NoLoads + '"  data-BookingID="' + data["BookingID"] + '" data-BookingDateID="' + data["BookingDateID"] + '"  id="Price' + data["BookingDateID"] + '" value="' + data["Price"] + '" name="Price' + data["BookingDateID"] + '" style="width:50px"  maxlength="7"  >');
	 				$(row).find("td:eq(12)").html('<input type="text" class="GridPON cls1' + data["BookingID"] + '" data-BookingID="' + data["BookingID"] + '"  value="' + data["PurchaseOrderNo"] + '" name="PurchaseOrderNo' + data["BookingDateID"] + '" style="width:100px" maxlength="50"   >');
	 				var log = '<button class="btn btn-sm btn-warning BookingLogs" data-BookingID="' + data["BookingID"] + '" title="Booking Logs"><i class="fa fa-history "   title="View Booking Logs" ></i></button>';

	 				$(row).find("td:eq(-1)").html(edi + ' ' + del + ' ' + log);
	 				$(row).find('td:eq(0)').attr('data-sort', data['BookingRequestID']);
	 				$(row).find('td:eq(1)').attr('data-sort', data['BookingDate1']);
	 			},
	 			serverSide: true,
	 			"processing": true,
	 			aoColumns: mdataArray1
	 		});

	 		//call search api when user types in filter input
	 		table.columns().every(function() {
	 			event.preventDefault();
	 			var that = this;
	 			$('input', this.header()).on('keyup change', function() {
	 				if (that.search() !== this.value) {
	 					that.search(this.value).draw();
	 				}
	 			});
	 		});

	 	}

	 	$(document).ready(function() {

	 		getTableMeta1();

	 		jQuery(document).on("change", ".GridPrice", function() {
	 			event.preventDefault();
	 			var BookingID = $(this).attr("data-BookingID"),
	 				BookingRequestID = $(this).attr("data-BookingRequestID"),
	 				Loads = $(this).attr("data-Loads"),
	 				BookingDateID = $(this).attr("data-BookingDateID"),
	 				Price = $(this).val(),
	 				hitURLUP = baseURL + "AJAXUpdateBookingPrice",
	 				currentRow = $(this);
	 			//alert(BookingDateID);
	 			//Price = $('#Price'+BookingDateID).val(),  
	 			jQuery.ajax({
	 				type: "POST",
	 				dataType: "json",
	 				url: hitURLUP,
	 				data: {
	 					'BookingRequestID': BookingRequestID,
	 					'Loads': Loads,
	 					'BookingID': BookingID,
	 					'BookingDateID': BookingDateID,
	 					'Price': Price
	 				}
	 			}).success(function(data) {
	 				//alert(JSON.stringify(data)) 
	 				if (data.status == true) {
	 					$('.cls' + BookingID).val(Price);
	 					$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Price has been Updated Successfully !!! </div>')
	 				} else {
	 					$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>')
	 					//alert("Oooops, Please try again later"); 
	 				}

	 			});

	 		});

	 		jQuery(document).on("change", ".GridPON", function() {

	 			var BookingID = $(this).attr("data-BookingID"),
	 				PON = $(this).val(),
	 				hitURLPON = baseURL + "AJAXUpdatePON",
	 				currentRow = $(this);
	 			jQuery.ajax({
	 				type: "POST",
	 				dataType: "json",
	 				url: hitURLPON,
	 				data: {
	 					'BookingID': BookingID,
	 					'PON': PON
	 				}
	 			}).success(function(data) {
	 				//alert(JSON.stringify(data)) 
	 				if (data.status == true) {
	 					$('.cls1' + BookingID).val(PON);
	 					$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> PurchaseOrderNumber has been Updated Successfully !!! </div>')
	 				} else {
	 					$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>')
	 					//alert("Oooops, Please try again later"); 
	 				}
	 			});

	 		});
	 		jQuery(document).on("click", ".deleteRequest", function() {
	 			//$('#empModal').modal('show');   
	 			event.preventDefault();
	 			var BookingDateID = $(this).attr("data-BookingDateID"),
	 				BookingID = $(this).attr("data-BookingID"),
	 				BookingRequestID = $(this).attr("data-BookingRequestID"),
	 				hitURL1 = baseURL + "DeleteBookingRequestConfirm",
	 				currentRow = $(this);
	 			//console.log(confirmation); 
	 			//alert(BookingDateID)
	 			jQuery.ajax({
	 				type: "POST",
	 				dataType: "json",
	 				url: hitURL1,
	 				data: {
	 					'BookingDateID': BookingDateID,
	 					'BookingID': BookingID,
	 					'BookingRequestID': BookingRequestID
	 				}
	 			}).success(function(data) {
	 				//alert(data)
	 				$('.modal-body').html(data);
	 				$('#empModal .modal-title').html("Delete Booking Request");
	 				$('#empModal .modal-dialog').width(500);
	 				$('#empModal').modal('show');
	 			});

	 		});
	 		jQuery(document).on("click", ".BookingLogs", function() {
	 			var BookingID = $(this).attr("data-BookingID"),
	 				hitURL1 = baseURL + "BookingRequestLogsAJAX",
	 				currentRow = $(this);
	 			//alert(BookingDateID);  
	 			jQuery.ajax({
	 				type: "POST",
	 				dataType: "json",
	 				url: hitURL1,
	 				data: {
	 					'BookingID': BookingID
	 				}
	 			}).success(function(data) {
	 				//alert(data)
	 				$('.modal-body').html(data);

	 				$('#empModal .modal-title').html("View Booking Logs");
	 				$('#empModal .modal-dialog').width(1200);
	 				$('#empModal').modal('show');

	 				//alert(JSON.stringify( data ));   
	 				//console.log(data);   
	 			});

	 		});

	 	});
	 </script>