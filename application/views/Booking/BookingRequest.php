	 
<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Booking Request <small>Add, Edit, Delete</small>   </h1>    </section> 
    <section class="content" > 
	
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
						<li class="active"><a href="#Pending" data-toggle="tab" aria-expanded="true">Pending </a></li> 
						<li class=""><a href="<?php echo base_url('BookingRequestApproved'); ?>"  aria-expanded="false">Approved</a></li>        
						<a class="btn btn-danger" href="<?php echo base_url('BookingRequestApprovedArchived'); ?>" style="float:right;margin: 6px "> Archived Booking</a> 
						<a class="btn btn-success" href="<?php echo base_url('AddBookingRequest'); ?>" style="float:right;margin: 6px "><i class="fa fa-plus"></i> Add Booking</a> 
					</ul> 
					
					<div class="tab-content"> 
						<div class="tab-pane active" id="Pending">   
							<div class="row">
								<div class="col-xs-12">
									<div class="box">
										<div class="box-header">
											<h3 class="box-title">Pending Booking List</h3>
										</div> 
										<div class="box-body">
											<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
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
  
var apiUrl = '/';   //Url for Server API
 
var GetTableMetaApiEndpoint = 'BookingRequestTableMeta';//Endpoint returning Table Metadata 
var GetTableDataApiEndpoint = 'AjaxBookingsRequest1';//Endpoint processing and return Table Data
  
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
  
//"url": apiUrl + GetTableDataApiEndpoint,
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
        },
        "lengthMenu": [10, 50, 100], "searching": true,
		 "columnDefs": [
			  { "width": "10px", "targets": 0 },
			  { "width": "50px", "targets": 1 }, 
			  { "width": "30px", "targets": 5 },
			  { "width": "30px", "targets": 6 },
			  { "width": "30px", "targets": 7 },
			  { "width": "30px", "targets": 8 },
			  { "width": "30px", "targets": 9 },
			  { "width": "30px", "targets": 10 },
			  
			  { "width": "30px", "targets": 11 },
			  { "width": "30px", "targets": 12 },
			  
			  { "width": "70px", "targets": 13 },
			  { "width": "70px", "targets": 14 },
			  { "width": "40px", "targets": 15 },
			  { "width": "90px", "targets": 16 }
			  
			],
        //rowId required when doing update, can put any unique value for each row instead of ID
        rowId: 'BookingDateID',
        dom: '<"toolbar">frtip',
		createdRow: function (row, data, dataIndex) {  

				var btype = ''; var bstatus = ''; var del = '';var edi = ''; var prc_app = ''; var LorryType = ''; var NoLoads = 0;
				if(data["BookingType"] ==1){ $(row).addClass("even1");  btype = 'Collection' ; }else if(data["BookingType"] ==2){  $(row).addClass("odd1");  btype = 'Delivery' ;   }else if(data["BookingType"] ==3){  $(row).addClass("odd1");  btype = 'DayWork' ;   }else if(data["BookingType"] ==4){  $(row).addClass("odd1");  btype = 'Haulage' ;  } 
				if(data["LoadType"] == 1){ $(row).find("td:eq(8)").html('Loads');  NoLoads = data["Loads"]; }else{  $(row).find("td:eq(8)").html('TurnAround'); }
				if(data["LorryType"] == 1){ LorryType = 'Tipper'; }else if(data["LorryType"] == 2){ LorryType = 'Grab'; }else if(data["LorryType"] == 3){ LorryType = 'Bin'; }
				
				//if(data["BookingDateStatus"] == '1'){ status = '<span class="label label-success">Approved</span>' ; del = '' ; edi = '';  }
				//if(data["BookingDateStatus"] == '0'){ 
				//status = '<div id="ap'+data["BookingDateID"]+'" ><a class="btn btn-danger ApproveBooking" herf="#" data-BookingDateID="'+data["BookingDateID"]+'" data-Price="'+data["Price"]+'" title="Click Here To Approve Booking"><i class="glyphicon glyphicon-ok"></i></a></div>' ; 	
				//}
				bstatus = '<a class="btn btn-sm  btn-success ApproveBooking" href="#" data-BookingDateID="'+data["BookingDateID"]+'" data-Price="'+data["Price"]+'" title="Click Here To Approve Booking"><i class="glyphicon glyphicon-ok"></i></a>';
				//if(data["TotalLoadAllocated"] == '0'){  
					del = '<a class="btn btn-sm btn-danger deleteRequest" href="#" data-BookingDateID="'+data["BookingDateID"]+'"  data-BookingRequestID="'+data["BookingRequestID"]+'"  data-BookingID="'+data["BookingID"]+'" title="Delete"><i class="fa fa-trash"></i></a>' ;	 
					if(data["TonBook"] == 1){		  
						$(row).find("td:eq(5)").html(data["TotalLoad"]);
						$(row).find("td:eq(6)").html(data["TonPerLoad"]);
						$(row).find("td:eq(8)").html('Tonnage'); 
						
						edi = '<a class="btn btn-sm btn-info" href="'+baseURL+'EditBookingRequestTonnage/'+data["BookingRequestID"]+'" title="Edit Booking Request Tonnage"><i class="fa fa-pencil"></i></a>' ;
					}else{
						if(data["BookingType"] ==3){
							edi = '<a class="btn btn-sm btn-info" href="'+baseURL+'EditBookingRequestDaywork/'+data["BookingRequestID"]+'" title="Edit Daywork Booking Request"><i class="fa fa-pencil"></i></a>' ;
						}else if(data["BookingType"] ==4){
							edi = '<a class="btn btn-sm btn-info"  href="'+baseURL+'EditBookingRequestHaulage/'+data["BookingRequestID"]+'" title="Edit Haulage Booking Request"><i class="fa fa-pencil"></i></a>' ;	
						}else{			
							edi = '<a class="btn btn-sm btn-info" href="'+baseURL+'EditBookingRequest/'+data["BookingRequestID"]+'" title="Edit Booking Request"><i class="fa fa-pencil"></i></a>' ;	
						}
						$(row).find("td:eq(5)").html('-');
						$(row).find("td:eq(6)").html('-');
						
					}
				//}
				
				
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingDateID="'+data["BookingDateID"]+'" herf="#" >  '+data["BookingRequestID"]+'</a>');  
				$(row).find("td:eq(7)").html(btype);
				$(row).find("td:eq(2)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> ');
				$(row).find("td:eq(3)").html(' <a href="'+baseURL+'View-Opportunity/'+data["OpportunityID"]+'" target="_blank" title="'+data["OpportunityName"]+'">'+data["OpportunityName"]+'</a> '); 
				$(row).find("td:eq(10)").html(LorryType);	
				if(data["PriceApproved"] == '0'){		  
					$(row).find("td:eq(11)").html('<span id="PrcApr'+data["BookingDateID"]+'"><input type="text" class="GridPrice cls'+data["BookingID"]+'" data-BookingRequestID="'+data["BookingRequestID"]+'"  data-Loads="'+NoLoads+'"  data-BookingID="'+data["BookingID"]+'" data-BookingDateID="'+data["BookingDateID"]+'"  id="Price'+data["BookingDateID"]+'" value="'+data["Price"]+'" name="Price'+data["BookingDateID"]+'" style="width:50px"  maxlength="7"  ></span>');	
					//prc_app = '<a class="btn btn-sm btn-default ApprovePrice" href="#" data-BookingDateID="'+data["BookingDateID"]+'"  data-Price="'+data["Price"]+'"  title="Click Here to Approve Price"><i class="fa fa-eur "></i></a>' ;
				}else{ 
					$(row).find("td:eq(11)").html(data["Price"]);	
				}
				var OpenPO = '';
				if(data["OpenPO"] == '1'){
					OpenPO = '<br> <span style="font-size:12px"><input type="checkbox" class="GridOpenPO op1'+data["BookingID"]+'" data-BookingID="'+data["BookingID"]+'"   name="OpenPO'+data["BookingDateID"]+'" value="1" checked  > OpenPO </span>';
				}else{
					OpenPO = '<br> <span style="font-size:12px"><input type="checkbox"  class="GridOpenPO op1'+data["BookingID"]+'" data-BookingID="'+data["BookingID"]+'"   name="OpenPO'+data["BookingDateID"]+'" value="1"   > OpenPO </span>';
				}
				$(row).find("td:eq(12)").html('<input type="text" class="GridPON cls1'+data["BookingID"]+'" data-BookingID="'+data["BookingID"]+'"  value="'+data["PurchaseOrderNo"]+'" name="PurchaseOrderNo'+data["BookingDateID"]+'" style="width:100px" maxlength="50"   >'+OpenPO);	
				
				
				var log = '<button class="btn btn-sm btn-warning BookingLogs" data-BookingID="'+data["BookingID"]+'" title="Booking Logs"><i class="fa fa-history "   title="View Booking Logs" ></i></button>' ;	 
				
				//$(row).find("td:eq(-1)").html(edi+' '+del+' '+log ); 
				$(row).find("td:eq(-1)").html(bstatus+' '+edi+' '+del+' '+log ); 
			//	$(row).find('td:eq(9)').attr('data-sort', data['BookingDateStatus']); 
				$(row).find('td:eq(0)').attr('data-sort', data['BookingRequestID']); 
				$(row).find('td:eq(1)').attr('data-sort', data['BookingDate1']); 
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
      
} 
   	
	$(document).ready(function() {
		
		getTableMeta(); 
			jQuery(document).on("click", ".ApproveBooking", function(){ 
			event.preventDefault();
			var BookingDateID = $(this).attr("data-BookingDateID"), 
				Price = $(this).attr("data-Price"),
				hitURL = baseURL + "ApproveBookingRequest",
				currentRow = $(this);	  
			var confirmation = confirm(" Price/Load : "+Price+" \n Are You Sure ? \n You want to Confirm This Booking ? ");
			//console.log(confirmation);
			if(confirmation!=null){ 
				if(confirmation!=""){
					//console.log("Your comment:"+confirmation);
					//alert(confirmation);
					jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL,
					data : { 'BookingDateID' : BookingDateID,'confirmation' :confirmation } 
					}).success(function(data){
						//console.log(data);  
						if(data.status != "") { 
							currentRow.parents('tr').remove(); 
							//jQuery('#ap'+data.BookingDateID).html('<span class="label label-success">Approved</span>');
							alert("Selcted Booking has been Approved"); 
						}else{ 
							alert("Oooops, Please try again later"); 
						} 
					}); 
				}
			}
		});
		
		jQuery(document).on("click", ".ApprovePrice", function(){ 
			
			var BookingDateID = $(this).attr("data-BookingDateID"), 
				Price = $(this).attr("data-Price"),
				hitURL = baseURL + "ApproveBookingPrice",
				currentRow = $(this);	  
			var confirmation = confirm(" Price : "+Price+" \n Are You Sure ? \n You want to Confirm This Booking Price ? ");
			//console.log(confirmation);
			if(confirmation!=null){ 
				if(confirmation!=""){
					//console.log("Your comment:"+confirmation);
					//alert(confirmation);
					jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL,
					data : { 'BookingDateID' : BookingDateID,'Price' : Price,'confirmation' :confirmation } 
					}).success(function(data){
						//console.log(data);  
						//alert(data.status);
						if(data.status == true) {  
							jQuery('#PrcApr'+data.BookingDateID).html(data.Price);
							alert("Selcted Booking Price has been Approved"); 
						}else{ 
							alert("Oooops, Please try again later"); 
						} 
					}); 
				}
			}
		});
		 
		
		jQuery(document).on("change", ".GridPrice", function(){ 
			
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
					type : "POST",
					dataType : "json",
					url : hitURLUP,
					data : { 'BookingRequestID' : BookingRequestID, 'Loads' : Loads, 'BookingID' : BookingID, 'BookingDateID' : BookingDateID, 'Price' : Price } 
					}).success(function(data){ 
						//alert(JSON.stringify(data)) 
						if(data.status == true) {  
							$('.cls'+BookingID).val(Price); 
							$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Price has been Updated Successfully !!! </div>') 
						}else{ 
							$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>')
							//alert("Oooops, Please try again later"); 
						} 
						
					});  
			 
		});
		
		jQuery(document).on("change", ".GridPON", function(){ 
			
			var BookingID = $(this).attr("data-BookingID"),   
				PON = $(this).val(),  
				hitURLPON = baseURL + "AJAXUpdatePON",
				currentRow = $(this);	     
				jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURLPON,
					data : { 'BookingID' : BookingID, 'PON' : PON } 
					}).success(function(data){ 
						//alert(JSON.stringify(data)) 
						if(data.status == true) {  
							$('.cls1'+BookingID).val(PON); 
							$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> PurchaseOrderNumber has been Updated Successfully !!! </div>') 
						}else{ 
							$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>')
							//alert("Oooops, Please try again later"); 
						}  
					});  
			 
		});
		jQuery(document).on("change", ".GridOpenPO", function(){ 
			
			var BookingID = $(this).attr("data-BookingID"),    
				hitURLPON = baseURL + "AJAXUpdateOpenPO",
				currentRow = $(this); 
				var ischecked= $(this).is(':checked');
				if(ischecked){ OpenPO = 1;  }else{ var OpenPO = 0; } 
				jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURLPON,
					data : { 'BookingID' : BookingID, 'OpenPO' : OpenPO } 
					}).success(function(data){ 
						//alert(JSON.stringify(data)) 
						if(data.status == true) {   
							if(OpenPO==1){
								$('.op1'+BookingID).prop('checked', true); 
							}else{
								$('.op1'+BookingID).prop('checked', false); 
							}
							$('.msg').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> OpenPO has been Updated Successfully !!! </div>') 
						}else{ 
							$('.msg').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please Try Again Later !!! </div>')
							//alert("Oooops, Please try again later"); 
						}  
					});  
			 
		});
		jQuery(document).on("click", ".deleteRequest", function(){  
			 
		//$('#empModal').modal('show');   
				var BookingDateID  = $(this).attr("data-BookingDateID"),
				BookingID  = $(this).attr("data-BookingID"),
				BookingRequestID  = $(this).attr("data-BookingRequestID"),
					hitURL1 = baseURL + "DeleteBookingRequestConfirm",
					currentRow = $(this);  
				//console.log(confirmation); 
				//alert(BookingDateID)
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingDateID' : BookingDateID,'BookingID' : BookingID,'BookingRequestID' : BookingRequestID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Delete Booking Request");
					$('#empModal .modal-dialog').width(500);
					$('#empModal').modal('show');  
				});  
				 
		});
		jQuery(document).on("click", ".BookingLogs", function(){  
			var BookingID = $(this).attr("data-BookingID"),  
				hitURL1 = baseURL + "BookingRequestLogsAJAX",
				currentRow = $(this);   
				//alert(BookingDateID);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingID' : BookingID } 
				}).success(function(data){ 
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