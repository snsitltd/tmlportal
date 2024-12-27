<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Non App Loads/Lorry List  </h1>    </section> 
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
		 
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Non App Loads/Lorry List  </h3>
					</div> 
					<div class="box-body">
						<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
							  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
							  <thead>
								<tr>  
									<th width="30" align="right">BNo </th>  													  
									<th width="30" align="right">Conv No. </th>  													
									<th width="100" align="right">Conv Date</th>                        
									<th  align="left">Company Name </th>  													
									<th  align="left">Opportunity Name </th>  													
									<th  align="left">Material Name </th>  													
									<th width="30" align="right">BType </th>  													
									<th width="30" align="right">LoadType </th>    
									<th width="80" >Driver Name </th>    
									<th width="50">VRNO </th>       
									<th width="50" > GWeight</th>                        
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
				{ "data": "BookingRequestID" ,"name": "BookingRequestID"  }, 
				{ "data": null }, 				 
				{ "data": null }, 				    
				{ "data": "CompanyName" , "name": "CompanyName" },  
				{ "data": "OpportunityName" , "name": "OpportunityName" },  
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "BookingType" ,"name": "BookingType"  },  
				{ "data": "LoadType" , "name": "LoadType" },    
				{ "data": null }, 
				{ "data": null }, 
				{ "data": null }, 
				{ "data": "Tare" , "name": "Tare" },   
				{ "data": "Net" , "name": "Net" },  
				{ "data": null } 				 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AllNonAppRequestLoadsAJAX') ?>", // json datasource
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
				$(row).find("td:eq(1)").html('<input type="text" class="ConveyanceUpdate"  data-LoadID="'+data["LoadID"]+'"  id="NonAppConveyanceNo'+data["LoadID"]+'" style="text-align:right;width:80px" value="'+data["NonAppConveyanceNo"]+'" name="NonAppConveyanceNo'+data["LoadID"]+'" >');	 
				$(row).find("td:eq(2)").html('<input type="text" class="ConveyanceDateUpdate"  data-LoadID="'+data["LoadID"]+'"  id="ConveyanceDate'+data["LoadID"]+'" style="text-align:right;width:120px" value="'+data["ConveyanceDate"]+'" name="ConveyanceDate'+data["LoadID"]+'"   maxlength="20"  >');	
				$(row).find("td:eq(6)").html(btype); 
				$(row).find("td:eq(7)").html(Ltype);  
				$(row).find("td:eq(8)").html(data["dname"]); 
				$(row).find("td:eq(9)").html(vreg);    
				$(row).find("td:eq(10)").html('<input type="text" class="GrossUpdate" data-Tare="'+data["Tare"]+'" data-LoadID="'+data["LoadID"]+'"  id="GrossWeight'+data["LoadID"]+'" style="text-align:right;width:50px" value="'+data["GrossWeight"]+'" name="GrossWeight'+data["LoadID"]+'"   maxlength="20"  >');	
				$(row).find("td:eq(12)").html('<span id="Net'+data["LoadID"]+'">'+data["Net"]+'</span>');    
				$(row).find("td:eq(13)").html('<a class="btn btn-sm btn-success FinishLoad" data-LoadID="'+data["LoadID"]+'" title="Click Here To Finish Load "> Finish </a>');      
				
			}
		} ); 
		
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
	 	 
	}); 
</script>