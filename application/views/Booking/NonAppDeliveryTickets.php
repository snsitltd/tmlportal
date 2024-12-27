<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i>NonApp Delivery Tickets </h1>    </section> 
    <section class="content"> 
	<div class="msg"></div>
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
		 
		<div class="row"> 
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs"> 
						<li class=""><a href="<?php echo base_url('NonAppConveyanceTickets'); ?>"  aria-expanded="false">Collection</a></li>      
						<li class="active"><a href="#Collection" data-toggle="tab" aria-expanded="true">Delivery </a></li> 
					</ul> 
					<div class="tab-content"> 
						<div class="tab-pane active" id="Collection">   
							<div class="row">
							<div class="col-xs-12">
								<div class="box">
									<div class="box-header">
										<h3 class="box-title"><b>Delivery Tickets List</b> </h3> 
									</div> 
									<div class="box-body">
										<div id="example2_wrapper" class="dataTables_wrapper   form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
												
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
 
var ColumnData;    
var defaultcol = "";
  
var apiUrl = '/'; 
 
var GetTableMetaApiEndpoint = 'NonAppDeliveryTicketsTableMeta';//Endpoint returning Table Metadata 
var GetTableDataApiEndpoint = 'AjaxNonAppDeliveryTickets';//Endpoint processing and return Table Data
  
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
			   
				defaultcol = data.Column[0].Title;
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
				{ "width": "55px", "targets": 2 },    
				{ "width": "55px", "targets": 3 },    
				{ "width": "55px", "targets": 8  }, 
				{ "width": "60px", "targets": 9 },   
				{ "width": "80px", "targets": 10 }, 
				{ "width": "80px", "targets": 11 },  				  
				{ "width": "50px", "targets": 12 },  
				{ "width": "70px", "targets": 13 ,"orderable": false } 
				],
			//rowId required when doing update, can put any unique value for each row instead of ID
			//{  "targets": 5 , "visible": false }, 
				//{  "targets": 6 , "visible": false }, 
				//{  "targets": 7 , "visible": false }, 
				//{  "targets": 8 , "visible": false },   
			rowId: 'LoadID',
		 
			createdRow: function (row, data, dataIndex) {  
				 
				var Ltype ="";var dname =""; var vreg ="";  var Status =""; var Tip="";var tt="";
				 
				Tip =  data["TipName"];  
				if(data["DriverName"]!=""){ dname = data["DriverName"]; }else{ dname = data["dname"]; } 
				if(data["VehicleRegNo"]!=""){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; }   
				if(data["TipID"]!="1" ){ 	
					$(row).find("td:eq(2)").html('<input type="text" class="ConveyanceUpdate"  data-LoadID="'+data["LoadID"]+'"  id="NonAppConveyanceNo'+data["LoadID"]+'" style="text-align:right;width:80px" value="'+data["NonAppConveyanceNo"]+'" name="NonAppConveyanceNo'+data["LoadID"]+'" >');	 
					$(row).find("td:eq(3)").html('<input type="text" class="ConveyanceDateUpdate"  data-LoadID="'+data["LoadID"]+'"  id="ConveyanceDate'+data["LoadID"]+'" style="text-align:right;width:120px" value="'+data["ConveyanceDate"]+'" name="ConveyanceDate'+data["LoadID"]+'"   maxlength="20"  >');	
					
					$(row).find("td:eq(10)").html('<input type="text" class="GrossUpdate" data-Tare="'+data["Tare"]+'" data-LoadID="'+data["LoadID"]+'"  id="GrossWeight'+data["LoadID"]+'" style="text-align:right;width:50px" value="'+data["GrossWeight"]+'" name="GrossWeight'+data["LoadID"]+'"   maxlength="20"  >');	
					$(row).find("td:eq(12)").html('<span id="Net'+data["LoadID"]+'">'+data["Net"]+'</span>');     
					
				}else{
					$(row).find("td:eq(10)").html(data["GrossWeight1"]);	
					$(row).find("td:eq(11)").html(data["Tare1"]);	
					$(row).find("td:eq(12)").html(data["Net1"]);      
				}
				//$(row).find("td:eq(1)").html('<span class="label label-danger">'+data["NonAppConveyanceNo"]+'</span>');   
				$(row).find("td:eq(4)").html('<a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+' </a> ');
				$(row).find("td:eq(5)").html('<a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> ');
				$(row).find("td:eq(6)").html('<button  class="btn btn-primary  btn-info TipUpdate" data-TipID = "'+data["TipID"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Tip Address">'+Tip+'</button> ');
				$(row).find("td:eq(7)").html('<button  class="btn btn-warning  btn-info MaterialUpdate" data-MaterialID = "'+data["MaterialID"]+'" data-LoadID = "'+data["LoadID"]+'" title="Click To Update Material ">'+data["MaterialName"]+'</button> ');	  
				$(row).find("td:eq(8)").html(dname);  
				$(row).find("td:eq(9)").html(vreg);      
				
				$(row).find("td:eq(-1)").html('<a class="btn btn-sm btn-success FinishLoad" data-LoadID="'+data["LoadID"]+'" title="Click Here To Finish Load "> Finish </a>');      				
				//$(row).find("td:eq(13)").html(Status);    
				 				
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
	}  
	
	  
	$(document).ready(function() { 
		  
		getTableMeta();     
		jQuery(document).on("change", ".GrossUpdate", function(){  
			var LoadID = $(this).attr("data-LoadID"),    
				Tare = $(this).attr("data-Tare"),    
				Gross = $(this).val(),  
				hitURLUP = baseURL + "NonAppGrossWeightUpdateAJAX",
				currentRow = $(this);	   
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURLUP,
				data : { 'LoadID' : LoadID, 'Gross' : Gross, 'Tare' : Tare } 
				}).success(function(data){ 
					//alert(JSON.stringify(data))  
					if(data.status == true) {   
						$('#Net'+data.LoadID).html(data.Net); 			
						$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Gross Weight has been Updated Successfully !!! </div>') 
					}else{ 
						$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>') 
					}  
				});   
		});
		
		jQuery(document).on("change", ".ConveyanceUpdate", function(){  
			var LoadID = $(this).attr("data-LoadID"),      
				NonAppConveyanceNo = $(this).val(),  
				hitURL1 = baseURL + "NonAppConveyanceUpdateAJAX",
				currentRow = $(this);	   
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'LoadID' : LoadID, 'NonAppConveyanceNo' : NonAppConveyanceNo  } 
				}).success(function(data){ 
					//alert(JSON.stringify(data))  
					if(data.status == true) {    			
						$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> NonApp Conveyance No has been Updated Successfully !!! </div>') 
					}else{ 
						$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>') 
					}  
				});   
		});	
		 
		jQuery(document).on("change", ".ConveyanceDateUpdate", function(){  
			var LoadID = $(this).attr("data-LoadID"),      
				ConveyanceDate = $(this).val(),  
				hitURL1 = baseURL + "NonAppConveyanceDateUpdateAJAX",
				currentRow = $(this);	   
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'LoadID' : LoadID, 'ConveyanceDate' : ConveyanceDate  } 
				}).success(function(data){ 
					//alert(JSON.stringify(data))  
					if(data.status == true) {    			
						$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Conveyance Date has been Updated Successfully !!! </div>') 
					}else{ 
						$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>') 
					}  
				});   
		});	 
		
		jQuery(document).on("click", ".TipUpdate", function(){  
			var LoadID = $(this).attr("data-LoadID"),  
				TipID = $(this).attr("data-TipID"),  
				hitURL1 = baseURL + "TipAddressUpdateNonAppAjax",
				currentRow = $(this); 
				//alert(LoadType);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'LoadID' : LoadID,'TipID' : TipID  } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data); 
					$('#empModal .modal-title').html("Update Tip Address");
					$('#empModal .modal-dialog').width(500); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
					 
		});
		
		jQuery(document).on("click", ".MaterialUpdate", function(){  
			var LoadID = $(this).attr("data-LoadID"),  
				MaterialID = $(this).attr("data-MaterialID"),  
				hitURL1 = baseURL + "MaterialUpdateNonAppAjax",
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
					$('#empModal .modal-title').html("Update MaterialName ");
					$('#empModal .modal-dialog').width(500); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
					 
		});
		
		jQuery(document).on("click", ".FinishLoad", function(){  
			var LoadID = $(this).attr("data-LoadID"),       
				hitURL2 = baseURL + "NonAppStatusUpdateAJAX",
				currentRow = $(this);	   
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL2,
				data : { 'LoadID' : LoadID } 
				}).success(function(data){ 
					currentRow.parents('tr').remove(); 
					//alert(JSON.stringify(data))  
					if(data.status == true) {    			
						$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Load Status has been Updated Successfully !!! </div>') 
					}else{ 
						$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>') 
					}  
				});   
		});		
		  
	 
	}); 
	 
</script>  
