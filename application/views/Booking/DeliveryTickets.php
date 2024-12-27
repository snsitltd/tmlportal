<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>Collection / Delivery Tickets 
	<a href="https://tml.snsitltd.com/cron/CronDocuments.php" target="_blank" class="btn btn-info" name="exportxls1" id="exportxls1"  style="float:right;margin: 6px "> Update HandWritten Tickets</a>  </h1>    </section> 
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
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li ><a href="<?php echo base_url('ConveyanceTickets'); ?>"  aria-expanded="true">Collection </a></li> 
						<li class="active"><a href="#Delivery" data-toggle="tab" aria-expanded="false">Delivery</a></li>      
						<li class=""><a href="<?php echo base_url('DayWorkTickets'); ?>"  aria-expanded="false">DayWork</a></li>  
						<li class=""><a href="<?php echo base_url('HaulageTickets'); ?>"  aria-expanded="false">Haulage</a></li> 						
					</ul> 
					<div class="tab-content">  
						<div class="tab-pane active" id="Delivery"> 
							<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title"><b>Delivery Ticket List</b></h3>
										<button class="btn btn-success SplitExcelDel" name="splitxls1" id="splitxls1"  style="float:right;margin: 6px "><i class="fa fa-plus"></i> Split XLS</button> 
										<button class="btn btn-warning WaitTimeSplitExcelDel" name="WaitTime" id="WaitTime"  style="float:right;margin: 6px "><i class="fa fa-plus"></i> WaitTime XLS</button> 
										<button class="btn btn-danger DeliveryExcelExport" name="exportxls" id="exportxls"  style="float:right;margin: 6px "> Export XLS</button> 
									</div> 
									<div class="box-body">
										<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
											<div class="input-group" style="width:390px;float:left; " >
											  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											  <input type="text" class="form-control " onkeydown="return false" id="reservation1" placeholder="Search Date Range "  name="reservation1" value="" style="width:300px" >  
											</div>  
									
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

<script type="text/javascript" language="javascript" >
 
var mdataArray1 = []; 
   
var ColumnData1;   
var defaultcol = "";
  
var apiUrl = '/'; 

var GetTableMetaApiEndpoint1 = 'DeliveryTicketsTableMeta';//Endpoint returning Table Metadata 
var GetTableDataApiEndpoint1 = 'AjaxDeliveryTickets';//Endpoint processing and return Table Data

    
	
	function getTableMeta1() {

		$.ajax({
			type: 'POST',
			url: apiUrl + GetTableMetaApiEndpoint1,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				ColumnData1 = data.Column;
				
				$.each(data.Column, function (index, element) {
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
					mdataArray1.push({ mData: element.Name, class: element.Name });
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
					mdataArray1.push({ defaultContent: '',  class: '' });

				}
			   
				defaultcol = data.Column[0].Title;
				//once table headers and table data property set, initialize DT
				initializeDataTable1();

			}
		});
	} 
    
	function initializeDataTable1() {
		//put Input textbox for filtering
		$('#dtexample1 thead tr:nth-child(2) th').each(function () {
			var title = $(this).text();
			if (title != '')
				$(this).html('<input type="text" class="sorthandle"  title="'+title+'" id="'+title+'" style="width:100%;" />');
		});
		//don't sort when user clicks on input textbox to type for filter
		$('#dtexample1').find('thead th').click(function (event) {
			if ($(event.target).hasClass('sorthandle')) {
				event.stopImmediatePropagation()
			}
		}); 
		table1 = $('#dtexample1').DataTable({
			
			"pageLength": 100,
			"bAutoWidth": false, 
			"ajax": {
				"url" : apiUrl +GetTableDataApiEndpoint1, 
				"type": "POST",
				data: function (data) {
					editIndexTable = -1;
					var colname;
					var reservation1 = document.getElementById("reservation1").value; 
					if(reservation1!=""){
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
						'draw': data.draw, 'length': data.length,
						'sort': colname, 'start': data.start, 'search': data.search.value, 'Reservation1': reservation1
					};
					//add each column as formdata key/value for filtering
					data['columns'].forEach(function (items, index) {
						col = data['columns'][index]['data'];
						colfilter = data['columns'][index]['search']['value'];
						arr[col] = colfilter;
					});
					//arr['reservation1'] = reservation1
					return arr;
				}
			},
			//"lengthMenu": [10, 50, 100],
			"bLengthChange": false , 
			"searching": true,
			"order": [[ 1, "desc" ]],
			"columnDefs": [
				 { "width": "40px", "targets": 0 }, 
				  { "width": "50px", "targets": 1 }, 
				  { "width": "100px", "targets": 4 , "visible": true ,"orderable": true  }, 
				  { "width": "100px", "targets": 6 },
				  { "width": "50px", "targets": 7 },  
				  { "width": "50px", "targets": 8 },  
				  { "width": "50px", "targets": 9 },  
				  { "width": "50px", "targets": 10  , "visible": true},  
				  { "width": "70px", "targets": 11 ,"orderable": false }  
				],
			//rowId required when doing update, can put any unique value for each row instead of ID
			rowId: 'LoadID', 
			createdRow: function (row, data, dataIndex) {  
					//alert(data["OpportunityID"]); 
				//var btype = ''; 
				var Ltype ="";var dname =""; var vreg ="";  var Status =""; 
				//if(data["BookingType"] ==1){ btype = 'Collection' ; }else{ btype = 'Delivery' ;  }  
				if(data["DriverName"]!=""){ dname = data["DriverName"]; }else{ dname = data["dname"]; } 
				if(data["VehicleRegNo"]!=""){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; } 
				
				if(data["Status"]=="Finished"){ Status = '<button class="btn   btn-success StatusUpdate" data-PDF = "'+data["ReceiptName"]+'" data-Status = "4" data-TicketNo = "'+data["TicketNo"]+'"  data-LoadID = "'+data["LoadID"]+'" title="Click To Update Status ">Finished</button> '; }  	 
				if(data["Status"]=="Cancelled"){ Status = '<button class="btn   btn-danger StatusUpdate" data-PDF = "'+data["ReceiptName"]+'"  data-Status = "5" data-TicketNo = "'+data["TicketNo"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Status ">Cancelled</button> ';  } 
				if(data["Status"]=="Wasted"){ Status = '<button class="btn   btn-warning StatusUpdate" data-PDF = "'+data["ReceiptName"]+'"  data-Status = "6" data-TicketNo = "'+data["TicketNo"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Status "> Wasted </button> '; } 
				if(data["Status"]=="Finished" ){
					$(row).find("td:eq(1)").html('<button  class="btn btn-warning  btn-info DateUpdate"  data-TicketNo = "'+data["TicketNo"]+'"    data-LoadID = "'+data["LoadID"]+'" data-JobStartDateTime = "'+data["JobStart"]+'"  data-SiteInDateTime = "'+data["SiteIn"]+'"  data-SiteOutDateTime = "'+data["SiteOut"]+'"  data-JobEndDateTime = "'+data["JobEnd"]+'" title="Click To Update Date "  >'+data["SiteOutDateTime"]+'</button> ');	
					$(row).find("td:eq(5)").html('<button  class="btn btn-warning  btn-info MaterialUpdate" data-MaterialID = "'+data["MaterialID"]+'" data-TicketNo = "'+data["TicketNo"]+'"  data-LoadID = "'+data["LoadID"]+'" title="Click To Update Material ">'+data["MaterialName"]+'</button> ');	
				}else{
					$(row).find("td:eq(1)").html(data["SiteOutDateTime"]);		
					$(row).find("td:eq(5)").html(data["MaterialName"]);	
				}
				$(row).find("td:eq(2)").html('<i data-BookingRequestID = "'+data["BookingRequestID"]+'"  data-BookingDateID = "'+data["BookingDateID"]+'" data-LoadID = "'+data["LoadID"]+'"  class="fa fa-pencil AllocateNewBooking"></i>  <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(3)").html('<i data-BookingRequestID = "'+data["BookingRequestID"]+'"  data-BookingDateID = "'+data["BookingDateID"]+'" data-LoadID = "'+data["LoadID"]+'"  class="fa fa-pencil AllocateNewBooking"></i>  <a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				if(data["DOCID"]!="" && data["DOCID"]!=null){
					var tn = data["TicketNumber"]; 
					var tn1 = tn.trim();  
					$(row).find("td:eq(0)").html('<a href="http://193.117.210.98:8081/ticket/Delivery/'+tn1+'.pdf" target="_blank" ><span class="label label-danger">'+data["TicketNumber"]+'</span></a>' ); 
				}else{ 
					if(data["ReceiptName"]!="" && data["ReceiptName"]!=".pdf"  ){ $(row).find("td:eq(0)").html('<a href="'+baseURL+'assets/conveyance/'+data["ReceiptName"]+'" target="_blank" >'+data["TicketNumber"]+' </a> '); }  
				}

				
				
				$(row).find("td:eq(6)").html(dname); 
				$(row).find("td:eq(7)").html(vreg);   
				if(data["Price"]=='NaN'){
					$(row).find("td:eq(9)").html('0');    
				}else{ 
					$(row).find("td:eq(9)").html(data["Price"]);    
				}					
				$(row).find("td:eq(9)").html(Status);    
				$(".buttons-excel").removeClass("dt-button").addClass("btn btn-primary");               
				var wt = '';  
				 
				if(data["WaitTime"]>60){
					wt = '<span class="label label-danger" > '+data["WaitTime"]+' Min</span>';
				}else if(data["WaitTime"]>20){
					wt = '<span class="label label-warning" > '+data["WaitTime"]+' Min</span>'; 
			    }else if(data["WaitTime"]>0){
					wt = '<span class="label label-success" > '+data["WaitTime"]+' Min</span>';
				}else if(data["WaitTime"]==0){
					wt = '<span class="label label-info" > '+data["WaitTime"]+' Min</span>';
				}else{ 
					wt = '<span class="label label-info" > N/A </span>'; 
				}  
				 
				$(row).find("td:eq(8)").html(wt); 
					
					
				$(row).find("td:eq(-1)").html('<a class="btn btn-sm btn-warning" target="blank" href="'+baseURL+'assets/conveyance/'+data["ReceiptName"]+'" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> <a  href="#" class="btn btn-sm btn-warning LoadInfo"  data-LoadID="'+data["LoadID"]+'"  ><i class="fa fa-history"></i></a> '); 
				},  
			serverSide: true, "processing": true,
			aoColumns: mdataArray1
		});

		//call search api when user types in filter input
		table1.columns().every(function () {
			var that = this;
			$('input', this.header()).on('keyup change', function () {
				if (that.search() !== this.value) {
					that.search(this.value).draw();
				}
			});
		}); 
		$('#reservation1').on('change', function () {
			//alert("qqqqqq")
			table1.search($(this).val()).draw();
		});
		//$('#reservation1').unbind();

	}  
	 
	 
	$(document).ready(function() {  
		
		$('#reservation1').daterangepicker({ locale: { format: 'DD/MM/YYYY' }}); 
		$('#reservation1').val('');  
		$('#reservation1').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val(''); 
			table1.search('').draw();  
		});
		 
		getTableMeta1();
		jQuery(document).on("click", ".LoadInfo", function(){   
			$('#empModal').modal('show');  
			var LoadID = $(this).attr("data-LoadID"), 
				hitURL1 = baseURL + "AJAXShowRequestLoadsDetails",
				currentRow = $(this);  
			//console.log(confirmation); 
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL1,
			data : { 'LoadID' : LoadID } 
			}).success(function(data){ 
				//alert(data)
				$('.modal-body').html(data);
				$('#empModal').modal('show');  
			});    
		});
		jQuery(document).on("click", ".MaterialUpdate", function(){  
			var LoadID = $(this).attr("data-LoadID"),  
				TicketNo = $(this).attr("data-TicketNo"),  
				MaterialID = $(this).attr("data-MaterialID"),  
				hitURL1 = baseURL + "MaterialUpdateDeliveryAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'LoadID' : LoadID,'MaterialID' : MaterialID ,'TicketNo' : TicketNo  } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data); 
					$('#empModal .modal-title').html("Update Material Name ");
					$('#empModal .modal-dialog').width(500); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
					 
		});		  
		jQuery(document).on("click", ".StatusUpdate", function(){ 
 
			var LoadID = $(this).attr("data-LoadID"),  
				TicketNo = $(this).attr("data-TicketNo"),   
				Status = $(this).attr("data-Status"),  
				PDF = $(this).attr("data-PDF"),  
				hitURL2 = baseURL + "DeliveryStatusUpdateAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL2,
				data : { 'LoadID' : LoadID,'Status' : Status,'PDF' : PDF ,'TicketNo' : TicketNo  } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data); 
					$('#empModal .modal-title').html("Update Status ");
					$('#empModal .modal-dialog').width(500); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
					 
		});
		jQuery(document).on("click", ".SplitExcelDel", function(){  
			var CompanyName = $('#CompanyName').val(),  
				OpportunityName =  $('#OpportunityName').val(),  
				reservation1 =  $('#reservation1').val(),  
				SiteOutDateTime =  $('#SiteOutDateTime').val(),  
				TicketNumber =  $('#TicketNumber').val(),  
				MaterialName =  $('#MaterialName').val(),  
				DriverName =  $('#DriverName').val(),  
				VehicleRegNo =  $('#VehicleRegNo').val(),  
				WaitTime =  $('#WaitTime').val(),   
				Status =  $('#Status').val(),   
				Price =  $('#Price').val(),  
				PurchaseOrderNo =  $('#PurchaseOrderNo').val(),  
				Search =  $('input[type="search"]').val(), 
				hitURL1 = baseURL + "SplitExcelDelAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation1' : reservation1 , 'SiteOutDateTime' : SiteOutDateTime ,'TicketNumber' : TicketNumber ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime,'Status' : Status,'Price' : Price,'PurchaseOrderNo' : PurchaseOrderNo,'Search' : Search  } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data); 
					$('#empModal .modal-title').html("Excel Export for Job Site Address");
					$('#empModal .modal-dialog').width(500); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				});  	 
		});
		jQuery(document).on("click", ".DeliveryExcelExport", function(){   
		
			var CompanyName = $('#CompanyName').val(),  
				OpportunityName =  $('#OpportunityName').val(),  
				reservation1 =  $('#reservation1').val(),  
				SiteOutDateTime =  $('#SiteOutDateTime').val(),  
				TicketNumber =  $('#TicketNumber').val(),  
				MaterialName =  $('#MaterialName').val(),  
				DriverName =  $('#DriverName').val(),  
				VehicleRegNo =  $('#VehicleRegNo').val(),  
				WaitTime =  $('#WaitTime').val(),   
				Status =  $('#Status').val(),   
				Price =  $('#Price').val(), 
				PurchaseOrderNo =  $('#PurchaseOrderNo').val(),  
				Search =  $('input[type="search"]').val(), 
				hitURL1 = baseURL + "DeliveryExcelExport",
				currentRow = $(this);  
				//alert(LoadType);  
				if(reservation1 !="" || SiteOutDateTime !=""){ 
				
					jQuery('#exportxls').prop('disabled', true);  
					
					jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL1,
					data : { 'Search' : Search, 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation1' : reservation1 , 'SiteOutDateTime' : SiteOutDateTime , 'TicketNumber' : TicketNumber ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime ,'Status' : Status ,'Price' : Price ,'PurchaseOrderNo' : PurchaseOrderNo } 
					}).success(function(data){ 
					jQuery('#exportxls').prop('disabled', false); 
					//alert(data.file);
						var $a = $("<a>");
						$a.attr("href",data.file);
						$("body").append($a);
						$a.attr("download",data.FileName);
						$a[0].click();
						$a.remove();   
					});  	 
				}else{
					alert("Please Select DateRange OR Datetime ....  ");
				}		 
		});
		jQuery(document).on("click", ".WaitTimeSplitExcelDel", function(){  
			var CompanyName = $('#CompanyName').val(),  
				OpportunityName =  $('#OpportunityName').val(),  
				reservation1 =  $('#reservation1').val(),  
				SiteOutDateTime =  $('#SiteOutDateTime').val(),  
				TicketNumber =  $('#TicketNumber').val(),  
				MaterialName =  $('#MaterialName').val(),  
				DriverName =  $('#DriverName').val(),  
				VehicleRegNo =  $('#VehicleRegNo').val(),  
				WaitTime =  $('#WaitTime').val(),   
				Status =  $('#Status').val(),   
				Price =  $('#Price').val(),  
				PurchaseOrderNo =  $('#PurchaseOrderNo').val(),  
				Search =  $('input[type="search"]').val(), 
				hitURL1 = baseURL + "WaitTimeSplitExcelDelAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation1' : reservation1 , 'SiteOutDateTime' : SiteOutDateTime ,'TicketNumber' : TicketNumber ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime,'Status' : Status,'Price' : Price,'PurchaseOrderNo' : PurchaseOrderNo,'Search' : Search  } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data); 
					$('#empModal .modal-title').html("Excel Export for Job Site Address");
					$('#empModal .modal-dialog').width(500); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				});  	 
		});
		
		jQuery(document).on("click", ".DateUpdate", function(){  
		 
			var LoadID = $(this).attr("data-LoadID"),   
				TicketNo = $(this).attr("data-TicketNo"),  
				JobStartDateTime = $(this).attr("data-JobStartDateTime"),   
				SiteInDateTime = $(this).attr("data-SiteInDateTime"),   
				SiteOutDateTime = $(this).attr("data-SiteOutDateTime"),   
				JobEndDateTime = $(this).attr("data-JobEndDateTime"),   
				hitURL3 = baseURL + "DateUpdateDeliveryAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json", 
				url : hitURL3,
				data : { 'LoadID' : LoadID , 'TicketNo' : TicketNo , 'SiteInDateTime' : SiteInDateTime ,'JobStartDateTime' : JobStartDateTime ,'SiteOutDateTime' : SiteOutDateTime ,'JobEndDateTime' : JobEndDateTime } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data); 
					$('#empModal .modal-title').html("Update TimeStamp ");
					$('#empModal .modal-dialog').width(500); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
					 
		});
		jQuery(document).on("click", ".AllocateNewBooking", function(){  
			var LoadID = $(this).attr("data-LoadID"), 
				BookingDateID = $(this).attr("data-BookingDateID"), 
				BookingRequestID = $(this).attr("data-BookingRequestID"), 
				hitURL1 = baseURL + "AllocateNewBookingAJAX",
				currentRow = $(this);  
				
				//alert(LoadID);
				//alert(BookingDateID); 
				
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingRequestID' : BookingRequestID, 'LoadID' : LoadID, 'BookingDateID' : BookingDateID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					
					$('#empModal .modal-title').html("Allocate To New Booking  ");
					$('#empModal .modal-dialog').width(1000); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
				 
	});
	
	
	jQuery(document).on("click", ".FetchBooking", function(){  
		var BookingRequestID = $('#NewBookingNo').val(), 
			BookingType = $('#BookingType').val(), 
			hitURL1 = baseURL + "FetchBookingRequestAJAX",
			currentRow = $(this); 
			if(BookingRequestID >0){      
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingRequestID' : BookingRequestID,'BookingType' : BookingType } 
				}).success(function(data){ 
					//alert(JSON.stringify( data ));    
					//alert(JSON.stringify(data.BookingInfo));   
					//alert(data.BookingInfo);  
					//alert(JSON.stringify( data.BookingInfo['LoadType'] ));   
					//alert(data.BDID);  
					//console.log(data);  
					if(data.status == true) { 
						//jQuery('#loads'+data.BookingDateID).html(parseInt(data.loads));  
						jQuery("#NewBookingID").css("display", "block");
						jQuery('#CompanyName').html(data.CompanyName);    
						jQuery('#OpportunityName').html(data.OpportunityName);    
						jQuery('#BType').html(data.BookingType);    
						jQuery('#BDID').html(data.BDID);      
					}else{ 
						jQuery("#NewBookingID").css("display", "none"); 
						alert("Invalid Booking Request Number, Please try again later"); 
					}  
				});    
			}else{ 
				jQuery("#NewBookingID").css("display", "none");
				alert("Please Enter Booking Request Number  ");  
			}	
			
	}); 
	
	jQuery(document).on("click", ".UpdateBookingRequest", function(){  
		var LoadID = $('#LoadID').val(), 
			BookingDateID = $('#BookingDateID').val(),
			BookingRequestID = $('#NewBookingNo').val(),
			BookingType = $('#BookingType').val(),
			hitURL1 = baseURL + "UpdateBookingRequestAJAX",
			currentRow = $(this); 
			
			if(BookingRequestID >0){      
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingRequestID' : BookingRequestID,'BookingDateID' : BookingDateID,'LoadID' : LoadID , 'BookingType' : BookingType } 
				}).success(function(data){ 
					//alert(JSON.stringify( data ));     
					//console.log(data);  
					if(data.status == true) {  
						window.location.href = baseURL+'DeliveryTickets' 
					}else{  
						alert("Oooops, Please try again later"); 
					}  
				});    
			}else{ 
				jQuery("#NewBookingID").css("display", "none");
				alert("Please Enter Booking Request Number  ");  
			}	
			
	}); 
		  
	}); 
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>  
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>  

