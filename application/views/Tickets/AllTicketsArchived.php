 
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<!-- <link href="https://cdn.datatables.net/datetime/1.1.0/css/dataTables.dateTime.min.css" rel="stylesheet" type="text/css" /> -->

<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Tickets Management (Archived)    <a class="btn btn-success" href="<?php echo base_url(); ?>All-Tickets"  style="float:right;margin: 6px "> Recent Tickets</a>  </h1>    </section> 
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
            <div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title"><b>All Archived Tickets List</b></h3>   
						<a class="btn btn-primary" href="<?php echo base_url(); ?>Collection-Tickets"  style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add Collection Ticket</a>
						<a class="btn btn-success" href="<?php echo base_url(); ?>Out-Tickets"  style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add Out Ticket</a> 
						<a class="btn btn-danger" href="<?php echo base_url(); ?>In-Tickets"  style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add In Ticket</a> 
						 
					</div>  
					<div class="box-body">
					  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
						<div class="input-group" style="width:390px;float:left; " >
						  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
						  <input type="text" class="form-control " id="reservation" placeholder="Search Date Range "  name="reservation" value="" style="width:300px" >  
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

var mdataArray = []; 

var ColumnData;   
var defaultcol = "";
  
var apiUrl = '/'; 
 
var GetTableMetaApiEndpoint = 'AllTicketsTableMetaArchived';//Endpoint returning Table Metadata 
var GetTableDataApiEndpoint = 'AllTicketsAJAXArchived';//Endpoint processing and return Table Data
  
	function getTableMeta() {
		$.ajax({
			type: 'POST',
			url: apiUrl + GetTableMetaApiEndpoint,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				ColumnData = data.Column;
				
				$.each(data.Column, function (index, element) {
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
					mdataArray.push({ mData: element.Name, class: element.Name });
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
					mdataArray.push({ defaultContent: ' ', class: '' });

				}
			   
				defaultcol = data.Column[0].Title;
				//once table headers and table data property set, initialize DT
				initializeDataTable();

			}
		});
	} 
   
	function initializeDataTable() {
		//put Input textbox for filtering
		$('#dtexample thead tr:nth-child(2) th').each(function () {
			var title = $(this).text();
			if (title != '')
				$(this).html('<input type="text" class="sorthandle" style="width:100%;" />');
		});
		//don't sort when user clicks on input textbox to type for filter
		$('#dtexample').find('thead th').click(function (event) {
			if ($(event.target).hasClass('sorthandle')) {
				event.stopImmediatePropagation()
			}
		});
		table = $('#dtexample').DataTable({
			"pageLength": 100,
			"ajax": {
				"url" : apiUrl +GetTableDataApiEndpoint, 
				"type": "POST",
				data: function (data) {
					//alert(data);
					//alert(JSON.stringify( data )); 
					
					editIndexTable = -1;
					var colname;
					//var StartDate = document.getElementById("StartDate").value;
					//var EndDate = document.getElementById("EndDate").value;
					var reservation = document.getElementById("reservation").value;
					//alert(reservation)
					if(reservation!=""){
						data.search.value = "";
					} 
					
					//if(StartDate!="" || EndDate!=""){
					//	data.search.value = "";
					//} 
					
					var sort = data.order[0].column;
					if (!data['columns'][sort]['data'] == '')
						colname = data['columns'][sort]['data'] + ' ' + data.order[0].dir;
					//in case no sorted col is there, sort by first col
					else colname = defaultcol + " asc";
					
					var colarr = [];
					//colname = 'TicketNo DESC ';
					var colfilter, col;
					var arr = {
						'draw': data.draw, 'length': data.length,
						'sort': colname, 'start': data.start, 'search': data.search.value
					};
					//add each column as formdata key/value for filtering
					data['columns'].forEach(function (items, index) {
						col = data['columns'][index]['data'];
						colfilter = data['columns'][index]['search']['value'];
						arr[col] = colfilter;
					});
					 
					//alert(data.search.value); 
					arr['reservation'] = reservation
					//arr['StartDate'] = StartDate
					//arr['EndDate'] = EndDate
					
					return arr;
				}
			},
			//"lengthMenu": [10, 50, 100],
			"bLengthChange": false ,
			"searching": true,
			"order": [[ 1, "desc" ]],
			"columnDefs": [
				  { "width": "60px", "targets": 0 },
				  { "width": "80px", "targets": 1 },  
				  { "width": "20px", "targets": 5 },
				  { "width": "50px", "targets": 6 },
				  { "width": "100px", "targets": 7 },
				  { "width": "30px", "targets": 8 },
				  { "width": "30px", "targets": 9 },
				  { "width": "30px", "targets": 10 },
				  { "width": "30px", "targets": 11 },
				  { "width": "150px", "targets": 12 },
				],
			//rowId required when doing update, can put any unique value for each row instead of ID
			rowId: 'TicketNo',
			dom: 'Blfrtip',
                    buttons: [{
                            "extend": 'excel', 
                            "text": ' <i class="fa fa-file-excel-o"  ></i> Export ',
                            "titleAttr": 'Export To Excel',
							exportOptions: {
							  format: {
								header: function ( data, columnIdx ) {
								  //return columnIdx === 0 ? "Category" : data; columnIdx === 1 ? "dddddddd" : data;
								  if(columnIdx == 0){ data = 'TNO'; } 
								  if(columnIdx == 1){ data = 'Date'; } 
								  if(columnIdx == 2){ data = 'Company Name'; } 
								  if(columnIdx == 3){ data = 'Site Name'; } 
								  if(columnIdx == 4){ data = 'Conveyance'; } 
								  if(columnIdx == 5){ data = 'Lorry'; } 
								  if(columnIdx == 6){ data = 'Veh.No'; } 
								  if(columnIdx == 7){ data = 'Driver Name'; } 
								  if(columnIdx == 8){ data = 'Gross'; } 
								  if(columnIdx == 9){ data = 'Tare'; } 
								  if(columnIdx == 10){ data = 'Net'; } 
								  if(columnIdx == 11){ data = 'OP'; } 
								  
								  return columnIdx === 0 ? "TNO	" : data;
								}
							  }
							},
                            "action": function newexportaction(e, dt, button, config) {
								 var self = this;
								 var oldStart = dt.settings()[0]._iDisplayStart;
								  
								 dt.one('preXhr', function (e, s, data) {
									 // Just this once, load all data from the server...
									 data.start = 0;
									 data.length = 2147483647;
									 dt.one('preDraw', function (e, settings) {
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
										 dt.one('preXhr', function (e, s, data) {
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
                        },
                    ],
			createdRow: function (row, data, dataIndex) {  
					$(row).find("td:eq(2)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> ');
					$(row).find("td:eq(3)").html(' <a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
					var pdf_path ='';
					if(data["TypeOfTicket"]=="Out"){
						if(data["LoadID"]!=0 && data["ReceiptName"]!=""){
							var str = new String(data["ReceiptName"]); 
							if(str.length > 5){
								pdf_path = baseURL+'assets/conveyance/'+data["ReceiptName"];
							}else{
								pdf_path = baseURL+'assets/pdf_file/'+data["pdf_name"];
							}
						}else{
							pdf_path = baseURL+'assets/pdf_file/'+data["pdf_name"];
						}
					}else{	
						pdf_path = baseURL+'assets/pdf_file/'+data["pdf_name"];
					} 
					$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-warning" target="blank" href="'+pdf_path+'" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'OfficeTicket/'+data["TicketNumber"]+'" title="Create Office Ticket"> G </a> <a class="btn btn-sm btn-info" href="'+baseURL+'View-'+data["TypeOfTicket"]+'-Ticket/'+data["TicketNo"]+'" title="View Ticket"><i class="fa fa-eye"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'edit-'+data["TypeOfTicket"]+'-ticket/'+data["TicketNo"]+'" title="Edit Ticket"><i class="fa fa-pencil"></i></a> <a class="btn btn-sm btn-danger deleteTicket" href="#" data-ticketno="'+data["TicketNo"]+'" title="Delete"><i class="fa fa-trash"></i></a>');
					if(data["DOCID"]!="" && data["DOCID"]!=null){
						var tn = data["TicketNumber"]; 
						var tn1 = tn.trim();  
						$(row).find("td:eq(0)").html('<a href="http://193.117.210.98:8081/ticket/Delivery/'+tn1+'.pdf" target="_blank" ><span class="label label-danger">'+data["TicketNumber"]+'</span></a>' ); 
					}
				},  
			serverSide: true, "processing": true,
			aoColumns: mdataArray
		});
		
		//call search api when user types in filter input
		table.columns().every(function () {
			var that = this;
			$('input', this.header()).on('keyup change', function () {
				if (that.search() !== this.value) {
					that.search(this.value).draw();
				}
			});
		});   
		 
		//$('#min').keyup(function(){
		//	  table.search($(this).val()).draw();
		//})
		
		//$('#StartDate, #EndDate').on('change', function () {
			//alert("qqqqqq")
		//	table.search($(this).val()).draw();
		//});
		$('#reservation').on('change', function () {
			//alert("qqqqqq")
			table.search($(this).val()).draw();
		});

	}  
	 
	
	$(document).ready(function() {
		$('#reservation').daterangepicker({ locale: { format: 'DD/MM/YYYY' }}); 
		$('#reservation').val('');  
		$('#reservation').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val(''); 
			table.search('').draw();  
		});

		//var StartDate, EndDate; 
		// Custom filtering function which will search data in column four between two values
		/*$.fn.dataTable.ext.search.push(
			function( settings, data, dataIndex ) {
				alert("sdfsdf")
				var min = minDate.val();
				var max = maxDate.val();
				var date = new Date( data[4] ); 
				if (
					( min === null && max === null ) ||
					( min === null && date <= max ) ||
					( min <= date   && max === null ) ||
					( min <= date   && date <= max )
				){
					return true;
				}
				return false;
			}
		);  
		 
		StartDate = new DateTime($('#StartDate'), {
			format: 'DD/MM/YYYY'
		});
		EndDate = new DateTime($('#EndDate'), {
			format: 'DD/MM/YYYY'
		}); */
		
		
		getTableMeta();  

		//for delete update
		jQuery(document).on("click", ".deleteTicket", function(){
			var TicketNo = $(this).attr("data-TicketNo"),
				hitURL = baseURL + "deleteNotes",
				currentRow = $(this);			
				//alert(hitURL);	
			var confirmation = prompt("Why do you want to delete?", "");

			//var confirmation = confirm("Are you sure to delete this record ?");
			//console.log(confirmation);
			if(confirmation!=null){ 
				if(confirmation!=""){
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
			
	});
	
</script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>  
<!-- 
<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.0/js/dataTables.dateTime.min.js"></script>  
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>  
-->
