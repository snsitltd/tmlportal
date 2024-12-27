<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Non App Loads/Lorry List for Booking No : <?php echo $BookingRequestID; ?> 
	<a href="<?php echo base_url('BookingCreateInvoice/'.$BookingRequestID); ?>"  class="btn btn-danger" style="float:right"  > PreInvoice </a> </h1>  
	</section> 
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
		
		<?php //var_dump($RequestInfo); ?>
		<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:600px"> 
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Booking Loads/Lorry Information </h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div> 
				  <div class="modal-body"></div> 
				  <div class="TEST"></div> 
				  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div> 
				</div>
			</div>
		</div>  

		<div class="row"> 
        <div class="col-md-4"> 
		<div class="box box-primary">
             
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Company Name : </label>  <?php echo $RequestInfo['CompanyName'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Opportunity Name : </label>  <?php echo $RequestInfo['OpportunityName'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Contact Name : </label>  <?php echo $RequestInfo['ContactName'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Contact Email : </label>  <?php echo $RequestInfo['ContactEmail'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Contact Mobile : </label>  <?php echo $RequestInfo['ContactMobile'];?> 
							</div> 
						</div> 
					</div>	  
				  <!--  <div class="box-footer">
						<input type="submit" class="btn btn-primary" value="Left Site" /> 
						<input type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;"  value="Cancel" /> 
				   </div> -->
				</div>	 
              </div>                       
        </div>    
		<div class="col-md-4"> 
			<div class="box box-primary"> 
				<div class="box-body"> 
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Waiting Time (Minute) : </label>  <?php echo $RequestInfo['WaitingTime'];?> 
							</div> 
						</div> 
					</div>	
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Wait Charges (1 £/Minute) : </label>  <?php echo $RequestInfo['WaitingCharge'];?> 
							</div> 
						</div> 
					</div>	
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Purchase Order : </label>  <?php echo $RequestInfo['PurchaseOrderNumber'];?> 
							</div> 
						</div> 
					</div>	
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Notes : </label>  <?php echo $RequestInfo['Notes'];?> 
							</div> 
						</div> 
						 
					</div>	 
				</div>	 
			</div>                       
        </div>    
		<div class="col-md-4"> 
			<div class="box box-primary"> 
				<div class="box-body"> 
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Type Of Payment : </label>  <?php if($RequestInfo['PaymentType']=='2'){ echo "CASH"; } 
								if($RequestInfo['PaymentType']=='3'){ echo "CARD"; } ?> 
							</div> 
						</div> 
					</div>	
					 
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Payment Ref Notes : </label>  <?php echo $RequestInfo['PaymentRefNo'];?> 
							</div> 
						</div> 
						 
					</div>	 
				</div>	 
			</div>                       
        </div>     
		</div> 
 		
		<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Non App Loads/Lorry List for Booking No : <?php echo $BookingRequestID; ?></h3>
					<?php if($CountCollection->CountCollection>0){ ?>
					<button class="btn btn-danger AddTicket" data-BookingRequestID = "<?php echo $BookingRequestID;  ?>" data-OpportunityID = "<?php echo $RequestInfo['OpportunityID'];  ?>"  data-CompanyID = "<?php echo $RequestInfo['CompanyID'];  ?>"  style="float:right;margin: 6px "> Add Collection Ticket (<?php echo $CountCollection->CountCollection;  ?>)</button>
					<?php } ?>
					<?php if($CountDelivery->CountDelivery>0){ ?>
					<button class="btn btn-success AddDeliveryTicket" data-BookingRequestID = "<?php echo $BookingRequestID;  ?>" data-OpportunityID = "<?php echo $RequestInfo['OpportunityID'];  ?>"  data-CompanyID = "<?php echo $RequestInfo['CompanyID'];  ?>"  style="float:right;margin: 6px "> Add Delivery Ticket (<?php echo $CountDelivery->CountDelivery;  ?>)</button>
					<?php } ?>
				</div> 
				<div class="box-body">
					<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
						  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
						  <thead>
							<tr>  
								<th width="30" align="right">Conv No </th>  													
								<th width="30" align="right">Booking Type </th>  													
								<th  align="left">Material Name </th>  													
								<th width="30" align="right">LoadType </th>    
								<th width="80" >Driver Name </th>    
								<th width="50">VRNO </th>      
								<th width="30" align="right">NonApp Conveyance </th>  													
								<th width="100" align="right">Conveyance Date</th>                        
								<th width="50" > Gross Weight</th>                        
								<th width="50" >Tare</th>
								<th width="50" >Net</th>  
								<th width="50" >Action</th>      
							</tr>
							</thead>  
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
	$(document).ready(function() {
		
		var dataTable = $('#ticket-grid').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 1, "desc" ]],
			"columns": [  
				{ "data": "ConveyanceNo" ,"name": "ConveyanceNo"  },
				{ "data": "BookingType" ,"name": "BookingType"  },  
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "LoadType" , "name": "LoadType" },   
				{ "data": null }, 				 
				{ "data": null }, 				    
				{ "data": null }, 
				{ "data": null }, 
				{ "data": null }, 
				{ "data": "Tare" , "name": "Tare" },   
				{ "data": "Net" , "name": "Net" },  
				{ "data": null } 				 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('NonAppRequestLoadsAJAX') ?>", // json datasource
				type: "post",  // method  , by default get
				data : { 'BookingRequestID' : <?php echo $BookingRequestID;  ?> } ,
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
				var btype = '';var Ltype ="";var dname =""; var vreg =""; var status ="";var status1 =""; var del =""; 
				if(data["BookingType"] ==1){ 
					$(row).addClass("even1");  btype = 'Collection' ;  
				}else{ 
					$(row).addClass("odd1"); btype = 'Delivery' ;   
				}  
				if(data["TonBook"]==1){
					Ltype = "Tonnage";
				}else{	
					if(data["LoadType"]==1){ Ltype = "Loads"; } if(data["LoadType"]==2){ Ltype = "TurnAround"; } 
				} 
				if(data["VehicleRegNo"]!="" && data["VehicleRegNo"]!=0 ){ 
					vreg = data["VehicleRegNo"]; 
				}else{ 
					vreg = data["rname"]; 
				}  
				$(row).find("td:eq(1)").html(btype); 
				$(row).find("td:eq(3)").html(Ltype);  
				$(row).find("td:eq(4)").html(data["dname"]); 
				$(row).find("td:eq(5)").html(vreg);    
				$(row).find("td:eq(10)").html('<span id="Net'+data["LoadID"]+'">'+data["Net"]+'</span>');    
				$(row).find("td:eq(11)").html('<a class="btn btn-sm btn-success FinishLoad" data-LoadID="'+data["LoadID"]+'" title="Click Here To Finish Load "> Finish </a>');    
				$(row).find("td:eq(6)").html('<input type="text" class="ConveyanceUpdate"  data-LoadID="'+data["LoadID"]+'"  id="NonAppConveyanceNo'+data["LoadID"]+'" style="text-align:right;width:80px" value="'+data["NonAppConveyanceNo"]+'" name="NonAppConveyanceNo'+data["LoadID"]+'" >');	 
				$(row).find("td:eq(7)").html('<input type="text" class="ConveyanceDateUpdate"  data-LoadID="'+data["LoadID"]+'"  id="ConveyanceDate'+data["LoadID"]+'" style="text-align:right;width:120px" value="'+data["ConveyanceDate"]+'" name="ConveyanceDate'+data["LoadID"]+'"   maxlength="20"  >');	
				$(row).find("td:eq(8)").html('<input type="text" class="GrossUpdate" data-Tare="'+data["Tare"]+'" data-LoadID="'+data["LoadID"]+'"  id="GrossWeight'+data["LoadID"]+'" style="text-align:right;width:50px" value="'+data["GrossWeight"]+'" name="GrossWeight'+data["LoadID"]+'"   maxlength="20"  >');	
				
			}
		} ); 
		
		jQuery(document).on("click", ".AddTicket", function(){  
			var BookingRequestID = $(this).attr("data-BookingRequestID"), 
				OpportunityID = $(this).attr("data-OpportunityID"), 
				CompanyID = $(this).attr("data-CompanyID"), 
				hitURL1 = baseURL + "AddTicketBookingRequestAJAX",
				currentRow = $(this);   
				//alert(LoadType);
				//alert(BookingDateID); 
				
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingRequestID' : BookingRequestID, 'OpportunityID' : OpportunityID , 'CompanyID' : CompanyID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					
					$('#empModal .modal-title').html("Allocate Loads / Lorry ");
					$('#empModal .modal-dialog').width(600); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
					 
		});
		
		jQuery(document).on("click", ".AddDeliveryTicket", function(){  
			var BookingRequestID = $(this).attr("data-BookingRequestID"), 
				OpportunityID = $(this).attr("data-OpportunityID"), 
				CompanyID = $(this).attr("data-CompanyID"), 
				hitURL1 = baseURL + "AddDeliveryTicketBookingRequestAJAX",
				currentRow = $(this);   
				//alert(LoadType);
				//alert(BookingDateID); 
				
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingRequestID' : BookingRequestID, 'OpportunityID' : OpportunityID , 'CompanyID' : CompanyID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					
					$('#empModal .modal-title').html("Allocate Loads / Lorry ");
					$('#empModal .modal-dialog').width(600); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
					 
		});
		
		jQuery(document).on("click", ".CreateTicket", function(){  
				 
				var BookingRequestID = $(this).attr("data-BookingRequestID"),
					DriverID = $('#DriverID').val(), 
					Booking = $('#Booking').val(), 
					TipID = $('#TipID').val(),    
					NonAppConveyanceNo = $('#NonAppConveyanceNo').val(),    
					ConveyanceDate = $('#ConveyanceDate').val(),    
					GrossWeight = $('#GrossWeight').val(),
					TicketNo = $('#TicketNo').val(),    
					MaterialID = $('#MaterialID').val(),    
					TipTicketNo = $('#TipTicketNo').val(),    
					TipTicketDate = $('#TipTicketDate').val(),    
					Remarks = $('#Remarks').val(),    
					hitURL1 = baseURL + "NonAppCreateTicketAJAX",
					currentRow = $(this); 
					
					if(TipID!="1"){
						if(GrossWeight<=0 || GrossWeight==""   ){
							alert("Gross Weight Must Required  "); 
							return false; 
						}
					}	
					
					if(TipTicketNo!=""){ 
					if(ConveyanceDate!=""){ 
						if(NonAppConveyanceNo!=""){ 
							if(TipID!="" && TipID>0){  
								if(DriverID!=undefined){   
									jQuery.ajax({
									type : "POST",
									dataType : "json",
									url : hitURL1,
									data : { 'BookingRequestID' : BookingRequestID,'DriverID' : DriverID,'Booking' : Booking, 'TipID' :TipID,'NonAppConveyanceNo' :NonAppConveyanceNo,'ConveyanceDate' :ConveyanceDate,'GrossWeight' :GrossWeight ,'TicketNo' :TicketNo,'TipTicketNo' :TipTicketNo ,'TipTicketDate' :TipTicketDate ,'Remarks' :Remarks, 'MaterialID' :MaterialID } 
									}).success(function(data){ 
										//alert(JSON.stringify( data ));   
										//console.log(data);  
										if(data.status == true) { 
											//jQuery('#loads'+data.BookingDateID).html(parseInt(data.loads));  
											window.location.href = "/NonAppRequestLoads/"+BookingRequestID; 
										}else{ 
											alert("Oooops, Please try again later"); 
										}  
									});  
								}else{ alert("Please Select Driver. "); }	 
							}else{ alert("Please Select Tip Address "); }	
						}else{ alert("Please Enter Conveyance No  "); }	
					}else{ alert("Please Enter Conveyance Date  "); }	 
					}else{ alert("TipTicketNo Must Required  "); }	 
		});
		
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
		
		jQuery(document).on("change", "#NonAppConveyanceNo,#OpportunityID,#CompanyID,#DriverID,#ConveyanceDate", function(){   
			var OpportunityID = $("#OpportunityID").val(), 
				CompanyID = $("#CompanyID").val(),
				DriverID = $("#DriverID").val(),
				ConveyanceDate = $("#ConveyanceDate").val(),
				NonAppConveyanceNo = $("#NonAppConveyanceNo").val(),  
				BookingRequestID = <?php echo $BookingRequestID;  ?>,   
				hitURL4 = baseURL + "FetchTicketFromConveyanceAJAX";
				
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL4,
				data : { 'BookingRequestID' : BookingRequestID,'CompanyID' : CompanyID, 'OpportunityID' : OpportunityID, 'DriverID' : DriverID, 'ConveyanceDate' : ConveyanceDate, 'NonAppConveyanceNo' : NonAppConveyanceNo } 
				}).success(function(data){ 
					//alert(JSON.stringify(data))   
					if(data.status == true) {   
						$('#TicketNo').val(data.TicketNo); 			
						$('#TipTicketNo').val(data.TicketNumber); 			 
						$('#pdf').html(data.pdf); 			 
					}else{
						$('#TicketNo').val(''); 			
						$('#TipTicketNo').val(''); 			 
						$('#pdf').html(''); 			 
					} 
					
				});   
		});	
		
		jQuery(document).on("change", "#TipTicketNo", function(){   
			var TipID = $("#TipID").val(),    
				TipTicketNo = $("#TipTicketNo").val(),    
				hitURL5 = baseURL + "FetchDeliveryTicketNoAJAX";
				if(TipID==1){
					jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL5,
					data : { 'TipTicketNo' : TipTicketNo } 
					}).success(function(data){ 
						//alert(JSON.stringify(data))   
						if(data.status == true) {   
							$('#TicketNo').val(data.TicketNo); 			
							$('#TipTicketNo').val(data.TicketNumber); 			 
							$('#GrossWeight').val(data.GrossWeight); 			  
							$('#TipTicketDate').val(data.TicketDate); 			 
							$('#pdf').html(data.pdf); 			 
						}else{
							$('#TicketNo').val(''); 			
							$('#TipTicketNo').val(''); 			 
							$('#TipTicketDate').val(''); 			
							$('#GrossWeight').val(''); 			 
							$('#pdf').html(''); 			 
						} 
						
					});   
				}
		});	
		
		jQuery(document).on("click", ".CreateDeliveryTicket", function(){  
				 
				var BookingRequestID = $(this).attr("data-BookingRequestID"),
					DriverID = $('#DriverID').val(), 
					Booking = $('#Booking').val(), 
					TipID = $('#TipID').val(),     
					GrossWeight = $('#GrossWeight').val(),
					TicketNo = $('#TicketNo').val(),    
					MaterialID = $('#MaterialID').val(),    
					TipTicketNo = $('#TipTicketNo').val(),    
					TipTicketDate = $('#TipTicketDate').val(),    
					Remarks = $('#Remarks').val(),    
					hitURL1 = baseURL + "NonAppCreateDeliveryTicketAJAX",
					currentRow = $(this); 
					if(TipID!="1"){
						if(GrossWeight<=0 || GrossWeight==""   ){
							alert("Gross Weight Must Required  "); 
							return false; 
						}
					}	
					if(TipTicketDate!=""){
						if(TipTicketNo!=""){  					 
						if(TipID!="" && TipID>0){  
							if(DriverID!=undefined){   
								jQuery.ajax({
								type : "POST",
								dataType : "json",
								url : hitURL1,
								data : { 'BookingRequestID' : BookingRequestID,'DriverID' : DriverID,'Booking' : Booking, 'TipID' :TipID, 'GrossWeight' :GrossWeight ,'TicketNo' :TicketNo,'TipTicketNo' :TipTicketNo ,'TipTicketDate' :TipTicketDate ,'Remarks' :Remarks, 'MaterialID' :MaterialID } 
								}).success(function(data){ 
									//alert(JSON.stringify( data ));   
									//console.log(data);  
									if(data.status == true) { 
										//jQuery('#loads'+data.BookingDateID).html(parseInt(data.loads));  
										window.location.href = "/NonAppRequestLoads/"+BookingRequestID; 
									}else if(data.error == '1') { 
										alert("Please check TicektNo Again. Entered TicketNo has been already Allocated. "); 
									}  
								});  
							}else{ alert("Please Select Driver. "); }	 
						}else{ alert("Please Select Tip Address "); }	 
					}else{ alert("TipTicketNo Must Required  "); }	 
					}else{ alert("TipTicketDate Must Required  "); }	 
		});
	 	 
	}); 
</script>