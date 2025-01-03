<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper">
	<section class="content-header">
		<h1> <i class="fa fa-users"></i>Conveyance Tickets </h1>
	</section>
	<section class="content">
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:1200px">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Loads/Lorry Timeline</h4>
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
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title"><b>Conveyance Tickets List</b></h3>
							</div>
							<div class="box-body">
								<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">
									<div class="row">
										<div class="col-sm-6"></div>
										<div class="col-sm-6"></div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="input-group" style="width:390px;float:left; ">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control " id="reservation" placeholder="Search Date Range " name="reservation" value="" style="width:300px">
											</div>

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

											<!-- <table id="ticket-grid1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
								  <thead>
									<tr>     
										<th width="70" align="right">Conv No</th>  
										<th width="10" align="right">Type</th>                        
										<th width="100" > Date Time </th>                        
										<th width="150" >Company Name</th>
										<th >Site Address</th>    
										<th width="210">Material</th>     
										<th width="80" >Driver Name </th>    
										<th >VRNO </th>       
										<th width="30" >Timeline</th>    
									</tr>
									</thead>  
								  </table> -->
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

	var GetTableMetaApiEndpoint = 'ConveyanceTicketsTableMeta'; //Endpoint returning Table Metadata 
	var GetTableDataApiEndpoint = 'AjaxConveyanceTickets'; //Endpoint processing and return Table Data

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
						'search': data.search.value
					};
					//add each column as formdata key/value for filtering
					data['columns'].forEach(function(items, index) {
						col = data['columns'][index]['data'];
						colfilter = data['columns'][index]['search']['value'];
						arr[col] = colfilter;
					});
					arr['reservation'] = reservation
					return arr;
				}
			},
			//"lengthMenu": [10, 50, 100],
			"bLengthChange": false,
			"searching": true,
			"order": [
				[0, "desc"]
			],
			"columnDefs": [{
					"width": "70px",
					"targets": 0
				},
				{
					"width": "100px",
					"targets": 1
				},
				{
					"width": "100px",
					"targets": 5
				},
				{
					"width": "50px",
					"targets": 6
				},
				{
					"width": "50px",
					"targets": 7
				},
				{
					"width": "70px",
					"targets": 8
				}
			],
			//rowId required when doing update, can put any unique value for each row instead of ID
			rowId: 'LoadID',
			dom: 'Blfrtip',
			buttons: [{
				"extend": 'excel',
				"text": 'Export XLS  ',
				//"text": ' <i class="fa fa-file-excel-o"  ></i> Export XLS  ',
				"titleAttr": 'Export XLS',
				exportOptions: {
					format: {
						header: function(data, columnIdx) {
							//return columnIdx === 0 ? "Category" : data; columnIdx === 1 ? "dddddddd" : data;
							if (columnIdx == 0) {
								data = 'Conveyance No ';
							}
							//if(columnIdx == 1){ data = 'Type'; } 
							if (columnIdx == 1) {
								data = 'DateTime';
							}
							if (columnIdx == 2) {
								data = 'Company Name';
							}
							if (columnIdx == 3) {
								data = 'Site Address';
							}
							if (columnIdx == 4) {
								data = 'Material';
							}
							if (columnIdx == 5) {
								data = 'Driver Name';
							}
							if (columnIdx == 6) {
								data = 'Veh.No';
							}
							if (columnIdx == 7) {
								data = 'Status';
							}

							return columnIdx === 0 ? "Conveyance No	" : data;
						}
					}
				},
				"action": function newexportaction(e, dt, button, config) {
					var self = this;
					var oldStart = dt.settings()[0]._iDisplayStart;

					dt.one('preXhr', function(e, s, data) {
						// Just this once, load all data from the server...
						data.start = 0;
						data.length = 2147483647;
						dt.one('preDraw', function(e, settings) {
							// Call the original action function
							if (button[0].className.indexOf('buttons-copy') >= 0) {
								$.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
							} else if (button[0].className.indexOf('buttons-excel') >= 0) {
								$.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
									$.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
									$.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
							} else if (button[0].className.indexOf('buttons-csv') >= 0) {
								$.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
									$.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
									$.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
							} else if (button[0].className.indexOf('buttons-pdf') >= 0) {
								$.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
									$.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
									$.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
							} else if (button[0].className.indexOf('buttons-print') >= 0) {
								$.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
							}
							dt.one('preXhr', function(e, s, data) {
								// DataTables thinks the first item displayed is index 0, but we're not drawing that.
								// Set the property to what it was before exporting.
								settings._iDisplayStart = oldStart;
								data.start = oldStart;
							});
							// Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
							setTimeout(dt.ajax.reload, 0);
							// Prevent rendering of the full data to the DOM
							return false;
						});
					});
					// Requery the server with the new one-time export settings
					dt.ajax.reload();
				}
			}, ],
			createdRow: function(row, data, dataIndex) {
				//alert(data["OpportunityID"]); 
				//var btype = ''; 
				var Ltype = "";
				var dname = "";
				var vreg = "";
				var Status = "";
				//if(data["BookingType"] ==1){ btype = 'Collection' ; }else{ btype = 'Delivery' ;  }  
				if (data["DriverName"] != "") {
					dname = data["DriverName"];
				} else {
					dname = data["dname"];
				}
				if (data["VehicleRegNo"] != "") {
					vreg = data["VehicleRegNo"];
				} else {
					vreg = data["rname"];
				}
				if (data["Status"] == "4") {
					Status = '<span class="label label-success"> Finished </span>';
				}
				if (data["Status"] == "5") {
					Status = '<span class="label label-danger"> Cancelled </span>';
				}
				if (data["Status"] == "6") {
					Status = '<span class="label label-warning"> Wasted </span>';
				}

				//$(row).find("td:eq(1)").html(btype); 
				$(row).find("td:eq(2)").html('<a href="' + baseURL + 'view-company/' + data["CompanyID"] + '" target="_blank" title="' + data["CompanyName"] + '">' + data["CompanyName"] + ' </a> ');
				$(row).find("td:eq(3)").html('<a href="' + baseURL + 'View-Opportunity/' + data["OpportunityID"] + '" target="_blank" title="' + data["OpportunityName"] + '">' + data["OpportunityName"] + '</a> ');

				$(row).find("td:eq(5)").html(dname);
				$(row).find("td:eq(6)").html(vreg);
				$(row).find("td:eq(7)").html(Status);
				$(".buttons-excel").removeClass("dt-button").addClass("btn btn-primary");

				$(row).find("td:eq(-1)").html('<a class="btn btn-sm btn-warning" target="blank" href="' + baseURL + 'assets/conveyance/' + data["ReceiptName"] + '" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> <a  href="#" class="btn btn-sm btn-warning LoadInfo"  data-LoadID="' + data["LoadID"] + '"  ><i class="fa fa-history"></i></a> ');
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

		/*var dataTable1 = $('#ticket-grid1').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true, 
			"deferRender": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 0, "desc" ]],
			"columns": [  
				{ "data": "ConveyanceNo" ,"name": "ConveyanceNo"  },
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "SiteOutDateTime1" ,"name": "SiteOutDateTime"  },
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" },
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": null }, 				 
				{ "data": null }, 				    
				{ "data": null } 				 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxConveyanceTickets') ?>", // json datasource
				type: "post",  // method  , by default get
				error: function(e){  // error handling
				//alert(e);
				console.log(e);     
					$(".ticket-grid-error").html("");
					$("#ticket-grid").append('<tbody class="ticket-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#ticket-grid_processing").css("display","none");							
				}//,
				//success: function (data) { 
					 //data = JSON.parse(data);
				//   alert(JSON.stringify( data )); 
 				//} 
			}, 
			columnDefs: [{ data: null, targets: -1 }],   
			createdRow: function (row, data, dataIndex) { 
			//alert(data["OpportunityID"]); 
				var btype = '';var Ltype ="";var dname =""; var vreg ="";  var status1 =""; 
				if(data["BookingType"] ==1){ btype = 'Collection' ; }else{ btype = 'Delivery' ;  }  
				if(data["DriverName"]!=""){ dname = data["DriverName"]; }else{ dname = data["dname"]; } 
				if(data["VehicleRegNo"]!=""){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; } 
				  
				$(row).find("td:eq(1)").html(btype); 
				$(row).find("td:eq(3)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(4)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				 
				$(row).find("td:eq(6)").html(dname); 
				$(row).find("td:eq(7)").html(vreg);   
				$(row).find("td:eq(-1)").html('<a class="btn btn-sm btn-warning" target="blank" href="'+baseURL+'assets/conveyance/'+data["ReceiptName"]+'" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> <a  href="#" class="btn btn-sm btn-warning LoadInfo"  data-LoadID="'+data["LoadID"]+'"  ><i class="fa fa-history"></i></a> '); 
			}
		} ); */

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////

		jQuery(document).on("click", ".LoadInfo", function() {
			$('#empModal').modal('show');
			var LoadID = $(this).attr("data-LoadID"),
				hitURL1 = baseURL + "AJAXShowLoadsDetails",
				currentRow = $(this);
			//console.log(confirmation); 
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				url: hitURL1,
				data: {
					'LoadID': LoadID
				}
			}).success(function(data) {
				//alert(data)
				$('.modal-body').html(data);
				$('#empModal').modal('show');
			});
		});

	});
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>