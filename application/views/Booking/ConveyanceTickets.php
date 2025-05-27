<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
<!--<script src="<?php echo base_url('assets/js/jquery-min.js'); ?>" type="text/javascript"></script>  -->
<link href="<?php echo base_url('assets/css/jquery-ui.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/jquery-ui.js'); ?>" type="text/javascript"></script> 


 
<!--<style>

.large-table-container-2 {
  max-width: 200px;
  overflow-x: scroll;
  overflow-y: auto;
  transform:rotateX(180deg);
}

.large-table-container-2 table {
  transform:rotateX(180deg);
}

</style> -->
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>Collection / Delivery Tickets  
    <a href="https://tml.snsitltd.com/cron/CronDocuments.php" target="_blank" class="btn btn-info" name="exportxls" id="exportxls"  style="float:right;margin: 6px "> Update HandWritten Tickets</a>  </h1>    
	</section> 
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
		<div id="dialog" style="display: none"></div>
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
		
		<div class="modal fade" id="empModal1" role="dialog">
			<div class="modal-dialog"  >  
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Loads/Lorry Timeline</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div>				  
				  <div class="modal-body" id="modal-body"> 
				  </div> 
				  <div class="modal-footer">
						  
				  </div> 
				</div> 
			</div>
		</div> 
		 
		 
		<div class="row"> 
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#Collection" data-toggle="tab" aria-expanded="true">Collection </a></li> 
						<li class=""><a href="<?php echo base_url('DeliveryTickets'); ?>"  aria-expanded="false">Delivery</a></li>      
						<li class=""><a href="<?php echo base_url('DayWorkTickets'); ?>"  aria-expanded="false">DayWork</a></li> 
						<li class=""><a href="<?php echo base_url('HaulageTickets'); ?>"  aria-expanded="false">Haulage</a></li> 						
					</ul> 
					<div class="tab-content"> 
						<div class="tab-pane active" id="Collection">   
							<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title"><b>Conveyance Tickets List</b> </h3>
										<button class="btn btn-warning WaitTimeSplitExcelConv" name="WaitTime" id="WaitTime"  style="float:right;margin: 6px "><i class="fa fa-plus"></i> WaitTime XLS</button> 
										<button class="btn btn-success SplitExcelConv" name="splitxls" id="splitxls"  style="float:right;margin: 6px "><i class="fa fa-plus"></i> Split XLS</button> 
										<button class="btn btn-danger ConveyanceExcelExport" name="exportxls" id="exportxls"  style="float:right;margin: 6px "> Export XLS</button> 
									</div> 
									<div class="box-body">
										<div id="example2_wrapper" class="dataTables_wrapper   form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
											<div class="input-group" style="width:390px;float:left; " >
											  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											  <input type="text" class="form-control " id="reservation" autocomplete="off" onkeydown="return false" placeholder="Search Date Range "  name="reservation" value="" style="width:300px" >  
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

<script type="text/javascript" language="javascript" >

var mdataArray = []; 
// const baseUrl = '<?= base_url() ?>'; // Fetching the correct base URL from CodeIgniter.
var apiUrl = baseURL; 

var ColumnData;    
var defaultcol = "";
  
 
var GetTableMetaApiEndpoint = 'ConveyanceTicketsTableMeta';//Endpoint returning Table Metadata 
var GetTableDataApiEndpoint = 'AjaxConveyanceTickets';//Endpoint processing and return Table Data
  
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
					mdataArray.push({ defaultContent: '',  class: '' });

				}
			   
				//defaultcol = data.Column[1].Title;
				defaultcol = data.Column[1].Name;
				//once table headers and table data property set, initialize DT
				initializeDataTable();

			}
		});
	} 
	
	function initializeDataTable() {
		//put Input textbox for filtering
		
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
					editIndexTable = -1;
					var colname;
					var reservation = document.getElementById("reservation").value; 
					if(reservation!=""){
						data.search.value = "";
					} 
					//alert(JSON.stringify(data));
					//console.log(confirmation); 

					var sort = data.order[0].column;
					//alert(data['columns'][sort]['data'])
					
					if (!data['columns'][sort]['data'] == '')
						colname = data['columns'][sort]['data'] + ' ' + data.order[0].dir; 
					else colname = " SiteOutDateTime DESC ";
					//else colname = defaultcol + " asc";
					//alert(colname)
					//in case no sorted col is there, sort by first col
					var colarr = [];
					//colname = 'SiteOutDateTime DESC ';
					var colfilter, col;
					var arr = {
						'draw': data.draw, 'length': data.length,
						'sort': colname, 'start': data.start, 'search': data.search.value, 'Reservation': reservation
					};
					//add each column as formdata key/value for filtering
					data['columns'].forEach(function (items, index) {
						col = data['columns'][index]['data'];
						colfilter = data['columns'][index]['search']['value'];
						arr[col] = colfilter;
					});
					//arr['reservation'] = reservation
					return arr;
				}
			}, //, "visible": false 
			//"lengthMenu": [10, 50, 100],
			"bLengthChange": false ,
			"searching": true,
			"order": [[ 1, "desc" ]],
			"columnDefs": [  
				{ "width": "55px", "targets": 0 },  
				{ "width": "55px", "targets": 1 }, 
				{ "width": "100px", "targets": 4 }, 
				{ "targets": 5,"orderable": false }, 
				{ "width": "55px",  "targets": 6 , "visible": true ,"orderable": false }, 
				{ "width": "55px", "targets": 7 , "visible": true ,"orderable": false }, 
				{ "width": "60px", "targets": 8 , "visible": true ,"orderable": false},   
				{ "width": "80px", "targets": 10 },  				  
				{ "width": "50px", "targets": 11 },  	
				{ "width": "50px", "targets": 12 },  
				{ "width": "50px", "targets": 13 },
				{ "width": "70px", "targets": 14 },
				{ "width": "70px", "targets": 15 ,"orderable": false }
				],
			//rowId required when doing update, can put any unique value for each row instead of ID
			//{  "targets": 5 , "visible": false }, 
				//{  "targets": 6 , "visible": false }, 
				//{  "targets": 7 , "visible": false }, 
				//{  "targets": 8 , "visible": false },   
			rowId: 'LoadID', 
			createdRow: function (row, data, dataIndex) {
				//var btype = ''; 
				var Ltype ="";var dname =""; var vreg ="";  var Status =""; var Tip="";var tt=""; 
				//if(data["BookingType"] ==1){ btype = 'Collection' ; }else{ btype = 'Delivery' ;  }  
				if(data["DriverLoginID"]=="0"){
					if(data["DriverName"]!=""){ dname = data["DriverName"]; }else{ dname = data["dname"]; } 
				}else{
					if(data["dname"]!=""){ dname = data["dname"]; }else{ dname = data["DriverName"]; } 
				}
				if(data["BookingMaterialID"]==data["MaterialID"]){ MClass = 'warning'  }else{  MClass = 'danger'  }	
				//if(data["VehicleRegNo"]!=""){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; } 
				
				//if(data["Status"]=="Finished"){ Status = '<span class="label label-success"> '+data["Status"]+' </span>'; } 
				if(data["Status"]=="Finished"){ Status = '<button  class="btn   btn-success StatusUpdate" data-PDF = "'+data["ReceiptName"]+'" data-Status = "'+data["Status"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Status ">'+data["Status"]+'</button> '; }  	 
				if(data["Status"]=="Cancelled"){ Status = '<button  class="btn   btn-danger StatusUpdate" data-PDF = "'+data["ReceiptName"]+'"  data-Status = "'+data["Status"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Status ">'+data["Status"]+'</button> ';  } 
				if(data["Status"]=="Wasted"){ Status = '<button  class="btn   btn-warning StatusUpdate" data-PDF = "'+data["ReceiptName"]+'"  data-Status = "'+data["Status"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Status ">'+data["Status"]+'</button> '; } 
				if(data["Status"] == "Cancelled Invoice") { 
                    Status = '<button class="btn btn-secondary StatusUpdate" data-PDF="' + data["ReceiptName"] + '" data-Status="' + data["Status"] + '" data-LoadID="' + data["LoadID"] + '" title="Click To Update Status">' + data["Status"] + '</button>';
                } 
				//$(row).find("td:eq(1)").html(btype); 
				if(data["Status"]=="Finished" ){
					$(row).find("td:eq(1)").html('<button  class="btn btn-warning  btn-info DateUpdate"  data-LoadID = "'+data["LoadID"]+'" data-JobStartDateTime = "'+data["JobStart"]+'"  data-SiteInDateTime = "'+data["SiteIn"]+'"  data-SiteOutDateTime = "'+data["SiteOut"]+'"  data-JobEndDateTime = "'+data["JobEnd"]+'" title="Click To Update Date "  >'+data["SiteOutDateTime"]+'</button> ');	
				}else{
					$(row).find("td:eq(1)").html(data["SiteOutDateTime"]);		
				}
				$(row).find("td:eq(2)").html('<i data-BookingRequestID = "'+data["BookingRequestID"]+'"  data-BookingDateID = "'+data["BookingDateID"]+'" data-LoadID = "'+data["LoadID"]+'"  class="fa fa-pencil AllocateNewBooking"></i> <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				//$(row).find("td:eq(3)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');

				$(row).find("td:eq(3)").html('<i data-BookingRequestID = "'+data["BookingRequestID"]+'"  data-BookingDateID = "'+data["BookingDateID"]+'" data-LoadID = "'+data["LoadID"]+'"  class="fa fa-pencil AllocateNewBooking"></i> <a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a>');
				
				//$(row).find("td:eq(10)").html(dname);
				$(row).find("td:eq(10)").html(data["DriverName"]); 
				//$(row).find("td:eq(11)").html(vreg); 
				$(row).find("td:eq(11)").html(data["VehicleRegNo"]); 
				
				if(data["Price"]=='NaN'){
					$(row).find("td:eq(12)").html('0');    
				}else{
				    if(data["BookingMaterialID"]==data["MaterialID"]){
					    $(row).find("td:eq(12)").html(data["Price"]);    
				    }else{
				        $(row).find("td:eq(12)").html('0');
				    }
				}
				$(row).find("td:eq(14)").html(Status);  
				//if(data["TipAddressUpdate"]!=""){  tt = data["TipAddressUpdate"].split(',');  Tip = tt[0]; 
				//}else{ 
				Tip =  data["TipName"]; 
				//}
				if(data["Status"]=="Finished" ){
					//if(data["ReceiptName"]!=""){ $(row).find("td:eq(0)").html('<a href="'+baseURL+'assets/conveyance/'+data["ReceiptName"]+'" target="_blank" >'+data["ConveyanceNo"]+' </a> '); } 
					if(data["ReceiptName"]!=""){ 
						//if(data["AutoAllocated"]==1){ var ConvAA = '<span class="label label-danger">'+data["ConveyanceNo"]+'</span>';  
						//}else{ var ConvAA = data["ConveyanceNo"]; }
						
						$(row).find("td:eq(0)").html('<a href="'+baseURL+'assets/conveyance/'+data["ReceiptName"]+'" target="_blank" data-PDF = "'+baseURL+'assets/conveyance/'+data["ReceiptName"]+'"  class="ShowPDF" >'+data["ConveyanceNo"]+' </a> '); 
						 
					}else{  
						//alert(data["ConveyanceGUID"])
						if(data["ConveyanceGUID"]!=null ){ 
							$(row).find("td:eq(0)").html('<a href="http://193.117.210.98:8081/ticket/Conveyance/'+data["TicketConveyance"]+'.pdf" target="_blank" ><span class="label label-danger">'+data["TicketConveyance"]+'</span> </a>' ); 
						}else{ 
							if(data["TicketConveyance"]!=null){
								$(row).find("td:eq(0)").html('<span class="label label-danger">'+data["TicketConveyance"]+'</span>');  
							} 
						}
					}		
					//}else{ $(row).find("td:eq(0)").html(data["TicketConveyance"]); } 
					
					if(data["TipID"]=="1"){ 
						//if(data["Net"]>"0" && data["pdf_name"]!="" && data["pdf_name"]!=".pdf"  && data["SuppNo"]>0   ){ 
						if(data["IsInBound"] == "0"  && data["Net"]>"0"  && data["SuppNo"]>"0"   ){   
							$(row).find("td:eq(7)").html('<a href="'+baseURL+'assets/pdf_file/'+data["pdf_name"]+'" target="_blank" >'+data["SuppNo"]+' </a> '); 
							$(row).find("td:eq(6)").html(data["SuppDate"]); 
						}else{ 
							$(row).find("td:eq(7)").html(`<span class="badge bg-primary">${data["SuppNo"]}</span>`); 
							$(row).find("td:eq(6)").html(data["SuppDate"]); 
						} 
						
					}else{  
						
						if(data["TipTicketNo"]>"0" ){
							$(row).find("td:eq(6)").html(data["TipTicketDate"]); 
							$(row).find("td:eq(7)").html('<a href="http://193.117.210.98:8081/ticket/Supplier/'+data["TipName"]+'-'+data["TipTicketNo"]+'.pdf" target="_blank" >'+data["TipTicketNo"]+' </a> '); 
						}else{ 
							$(row).find("td:eq(7)").html('-'); 
							$(row).find("td:eq(6)").html('-'); 
						}
					} 
					 
					$(row).find("td:eq(4)").html('<button  class="btn btn-primary  btn-info TipUpdate" data-conveyance = "'+data["ConveyanceNo"]+'" data-OppoID = "'+data["OpportunityID"]+'"  data-TipID = "'+data["TipID"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Tip Address">'+Tip+'</button> ');
					$(row).find("td:eq(9)").html('<button  class="btn btn-'+MClass+'  btn-info MaterialUpdate" data-MaterialID = "'+data["MaterialID"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Material ">'+data["MaterialName"]+'</button> ');	
				}else{
					if(data["ReceiptName"]!=""){ 
						$(row).find("td:eq(0)").html('<a href="'+baseURL+'assets/conveyance/'+data["ReceiptName"]+'" target="_blank" data-PDF = "'+baseURL+'assets/conveyance/'+data["ReceiptName"]+'"  class="ShowPDF" >'+data["ConveyanceNo"]+' </a> '); 
					}	
					$(row).find("td:eq(4)").html(data["TipName"]);
					$(row).find("td:eq(9)").html(data["MaterialName"]);
				}
				
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
				 
				$(row).find("td:eq(13)").html(wt); 
					
				$(".buttons-excel").removeClass("dt-button").addClass("btn btn-primary");               
               
                var cpdf = '';
                if (data["ReceiptName"] != '') {
                    cpdf = '<a class="btn btn-sm btn-warning me-1" target="_blank" href="' + baseURL + 'assets/conveyance/' + data["ReceiptName"] + '" title="View PDF"><i class="fa fa-file-pdf-o"></i></a>';
                }
                
                var pdaButton = '';
                if (data["TipTicketID"] && data["TipTicketID"].trim() !== '') {
                    if(data["TipID"] != 1){
                        pdaButton = '<a class="btn btn-sm btn-primary me-1" target="_blank" href="https://tml.snsitltd.com/ViewTipTickets/' + data["TipID"] + '?searchID=' + data["TipTicketID"] + '" title="View PDA Ticket"><i class="fa fa-search"></i></a>';
                    }
                }
                
                $(row).find("td:eq(-1)").html(
                    '<div class="d-flex align-items-center">' +
                    cpdf +
                    pdaButton +
                    '<a href="#" class="btn btn-sm btn-warning LoadInfo" data-LoadID="' + data["LoadID"] + '" title="Load Info"><i class="fa fa-history"></i></a>' +
                    '</div>'
                );

				
				},  
			serverSide: true, "processing": true,
			aoColumns: mdataArray
		});
		

		$('#dtexample thead tr:nth-child(2) th').each(function () {
			var title = $(this).text();
			if (title != '')
				$(this).html('<input type="text" class="sorthandle" title="'+title+'" id="'+title+'" style="width:100%;" />');
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
		$('#reservation').on('change', function () {
			//alert("qqqqqq")
			table.search($(this).val()).draw();
		});
		
		//$('#splitxls11').on('click', function () {
			//alert(document.getElementById("CompanyName").value)
			 
			
			//table.search($(this).val()).draw();
		//});
		
	}  
	
	  
	$(document).ready(function() { 
		$('#reservation').daterangepicker({ locale: { format: 'DD/MM/YYYY' }}); 
		$('#reservation').val('');  
		$('#reservation').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val(''); 
			table.search('').draw();  
		});
		 
		
		getTableMeta();    
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
		 
		
		jQuery(document).on("click", ".TipUpdate", function(){  
			var LoadID = $(this).attr("data-LoadID"),  
				TipID = $(this).attr("data-TipID"),  
				OppoID = $(this).attr("data-OppoID"),
				ConveyanceNo = $(this).attr("data-conveyance"), 
				
				hitURL1 = baseURL + "TipAddressUpdateAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'LoadID' : LoadID,'TipID' : TipID ,'OppoID' : OppoID ,'ConveyanceNo' : ConveyanceNo  } 
				}).success(function(data){ 
					//alert(data)
					$('#modal-body').html(data); 
					$('#empModal1 .modal-title').html("Update Conveyance | Tip Address");
					$('#empModal1 .modal-dialog').width(500); 
					$('#empModal1').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				});  
		});
		
		jQuery(document).on("click", ".MaterialUpdate", function(){  
			var LoadID = $(this).attr("data-LoadID"),  
				MaterialID = $(this).attr("data-MaterialID"),  
				hitURL1 = baseURL + "MaterialUpdateAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'LoadID' : LoadID,'MaterialID' : MaterialID  } 
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
		
		jQuery(document).on("click", ".DateUpdate", function(){  
		 
			var LoadID = $(this).attr("data-LoadID"),   
				JobStartDateTime = $(this).attr("data-JobStartDateTime"),   
				SiteInDateTime = $(this).attr("data-SiteInDateTime"),   
				SiteOutDateTime = $(this).attr("data-SiteOutDateTime"),   
				JobEndDateTime = $(this).attr("data-JobEndDateTime"),   
				hitURL3 = baseURL + "DateUpdateAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json", 
				url : hitURL3,
				data : { 'LoadID' : LoadID , 'SiteInDateTime' : SiteInDateTime ,'JobStartDateTime' : JobStartDateTime ,'SiteOutDateTime' : SiteOutDateTime ,'JobEndDateTime' : JobEndDateTime } 
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
		
		jQuery(document).on("click", ".StatusUpdate", function(){ 
 
			var LoadID = $(this).attr("data-LoadID"),  
				Status = $(this).attr("data-Status"),  
				PDF = $(this).attr("data-PDF"),  
				hitURL2 = baseURL + "StatusUpdateAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL2,
				data : { 'LoadID' : LoadID,'Status' : Status,'PDF' : PDF  } 
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
		
		jQuery(document).on("click", ".SplitExcelConv", function(){  
			var CompanyName = $('#CompanyName').val(),  
				OpportunityName =  $('#OpportunityName').val(),  
				reservation =  $('#reservation').val(),  
				TipName =  $('#TipName').val(),  
				SiteOutDateTime =  $('#SiteOutDateTime').val(),  
				ConveyanceNo =  $('#ConveyanceNo').val(),  
				MaterialName =  $('#MaterialName').val(),  
				DriverName =  $('#DriverName').val(),  
				VehicleRegNo =  $('#VehicleRegNo').val(),  
				WaitTime =  $('#WaitTime').val(),   
				Status =  $('#Status').val(),   
				hitURL1 = baseURL + "SplitExcelConvAjax",
				currentRow = $(this);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation' : reservation ,'TipName' : TipName ,'SiteOutDateTime' : SiteOutDateTime ,'ConveyanceNo' : ConveyanceNo ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime,'Status' : Status  } 
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
		
		jQuery(document).on("click", ".WaitTimeSplitExcelConv", function(){  
			var CompanyName = $('#CompanyName').val(),  
				OpportunityName =  $('#OpportunityName').val(),  
				reservation =  $('#reservation').val(),  
				TipName =  $('#TipName').val(),  
				SiteOutDateTime =  $('#SiteOutDateTime').val(),  
				ConveyanceNo =  $('#ConveyanceNo').val(),  
				MaterialName =  $('#MaterialName').val(),  
				DriverName =  $('#DriverName').val(),  
				VehicleRegNo =  $('#VehicleRegNo').val(),  
				WaitTime =  $('#WaitTime').val(),   
				Status =  $('#Status').val(),   
				hitURL1 = baseURL + "WaitTimeSplitExcelConvAjax",
				currentRow = $(this);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation' : reservation ,'TipName' : TipName ,'SiteOutDateTime' : SiteOutDateTime ,'ConveyanceNo' : ConveyanceNo ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime,'Status' : Status  } 
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
		
		jQuery(document).on("click", ".ConveyanceExcelExport", function(){  
			
			
		var CompanyName = $('#CompanyName').val(),   
			OpportunityName =  $('#OpportunityName').val(),  
			reservation =  $('#reservation').val(),  
			TipName =  $('#TipName').val(),  
			SiteOutDateTime =  $('#SiteOutDateTime').val(),  
			ConveyanceNo =  $('#ConveyanceNo').val(),  
			MaterialName =  $('#MaterialName').val(),  
			DriverName =  $('#DriverName').val(),  
			Price =  $('#Price').val(),  
			Search =  $('input[type="search"]').val(),    
			VehicleRegNo =  $('#VehicleRegNo').val(),  
			WaitTime =  $('#WaitTime').val(),  
			Status =  $('#Status').val(),    
			hitURLCon = baseURL + "ConveyanceExcelExportNew",
			currentRow = $(this);   
			
			if(reservation !="" || SiteOutDateTime !=""){ 
				jQuery('#exportxls').prop('disabled', true); 
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURLCon,
				data : { 'Search' : Search, 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation' : reservation ,'TipName' : TipName ,'SiteOutDateTime' : SiteOutDateTime ,'ConveyanceNo' : ConveyanceNo ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime ,'Status' : Status ,'Price' : Price } 
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
	 
    jQuery(document).on("hover", ".ShowPDF", function(){   
		var fileName = $(this).attr("data-PDF");
            $("#dialog").dialog({
                modal: true,
                title: fileName,
                width: 600,
                height: 550,
                buttons: {
                    Close: function () {
                        $(this).dialog('close');
                    }
                },
                open: function () {
                    var object = "<object data=\"{FileName}\" type=\"application/pdf\" width=\"600px\" height=\"500px\">";
                    object += "If you are unable to view file, you can download from <a href = \"{FileName}\">here</a>";
                    object += " or download <a target = \"_blank\" href = \"http://get.adobe.com/reader/\">Adobe PDF Reader</a> to view the file.";
                    object += "</object>";
                    object = object.replace(/{FileName}/g,fileName);
                    $("#dialog").html(object);
                }
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
						window.location.href = baseURL+'ConveyanceTickets' 
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

