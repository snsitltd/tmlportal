<div class="content-wrapper"><section class="content-header"><h1><i class="fa fa-users"></i> Edit Subcontractor  </h1></section> 


<section class="content"> 
<?php echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div>');  ?>  

 <div class="row"> 
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Edit Subcontractor</a></li>   
			  <li class=""><a href="#Loads" data-toggle="tab" aria-expanded="false">Loads</a></li>    
            </ul> 
            <div class="tab-content"> 
              <div class="tab-pane active" id="activity">  
				<form role="form" id="addsubcontractor"  name="addsubcontractor" action="<?php echo base_url('EditSubcontractor/'.$subcontractor['ContractorID']) ?>" method="post" > 
				<input type="hidden" name="ContractorID" id="ContractorID" value="<?php echo $subcontractor['ContractorID'];?>"> 
					<div class="box-body">
						<div class="row">
							<div class="col-md-6">                                
								<div class="form-group">
									<label for="fname">Company Name <span class="required" aria-required="true">*</span></label>
									<input type="text" class="form-control required" value="<?php echo $subcontractor['CompanyName']; ?>" id="CompanyName" name="CompanyName" maxlength="128">
								</div>
								
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="email">Email address </label>
									<input type="email" class="form-control email" id="Email" value="<?php echo $subcontractor['Email']; ?>" name="Email" maxlength="128">
								</div>
							</div>
						</div>
					 
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="Street1">Street 1  </label>
									<input type="text" class="form-control  " id="Street1" value="<?php echo $subcontractor['Street1']; ?>" name="Street1" maxlength="100">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="Street2">Street 2  </label>
									<input type="text" class="form-control  " id="Street2" value="<?php echo $subcontractor['Street2']; ?>" name="Street2" maxlength="100">
								</div>
							</div>
							   
						</div>


						 <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="Town">Town </label>
									<input type="text" class="form-control  " id="Town" value="<?php echo $subcontractor['Town']; ?>" name="Town">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="County">County  </label>                                        
									<select class="form-control  " id="County" name="County"  data-live-search="true" >
										<option value="">Select County</option>
										<?php
										if(!empty($county))
										{
											foreach ($county as $rl)
											{
												?>
												<option value="<?php echo $rl->County ?>" <?php if($rl->County == $subcontractor['County']) {echo "selected=selected";} ?>><?php echo $rl->County ?></option>
												<?php
											}
										}
										?>
									</select>

								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="PostCode">Post Code  </label>
									<input type="text" class="form-control  " id="Postcode" value="<?php echo $subcontractor['Postcode']; ?>" name="Postcode" maxlength="20">
								</div>
							</div>
							
						</div>


						<div class="row">
							

						   <div class="col-md-3">
								<div class="form-group">
									<label for="Phone1">Mobile Number  </label>
									<input type="text" class="form-control digits" id="Mobile" value="<?php echo $subcontractor['Mobile']; ?>" name="Mobile" maxlength="11" minlength="11">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label for="Phone2">Phone</label>
									<input type="text" class="form-control digits" id="Phone" value="<?php echo $subcontractor['Phone']; ?>" name="Phone" maxlength="11" minlength="11">
								</div>
							</div> 
							<div class="col-md-3">
								<div class="form-group">
									<label for="Phone2">Total Current Lorry : </label> <?php echo  $TotalNoLorry; ?>
								</div>
							</div> 
							<div class="col-md-3">
								<div class="form-group">
									<label for="Phone2">Add New Lorry</label>
									<select class="form-control  required" id="Lorry" name="Lorry"  data-live-search="true" >
										<option value="">Add Lorry</option>
										<?php for($i=1;$i<50;$i++){ ?>
											<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
										<?php } ?>
									</select> 
								</div>
							</div> 
						</div> 

					</div>  
					<div class="box-footer">
						<input type="submit" class="btn btn-primary" value="Submit" /> 
						<button onclick="location.href='<?php echo  base_url('Subcontractor')?>';" type="button" class="btn btn-warning">Back</button>
					</div>
				</form>
			    
			  </div>
			    
			  
			<div class="tab-pane" id="Loads"> 
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">Subcontractor Loads/Lorry List</h3>
							</div> 
							<div class="box-body">
								<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
									  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
									  <thead>
										<tr> 
											<th width="10" align="right">BNO </th>   
											<th width="30" align="right">Conveyance </th>  													
											<th width="10" align="right">Type</th>                        
											<th width="50" > Request Date </th>                        
											<th width="150" >Company Name</th>
											<th >Site Name</th>    
											<th width="210">Material</th>         
											<th width="30" >Loads/Lorry Type</th>     
											<th width="80" >Driver Name </th>    
											<th >VRNO </th>     
											<th width="100">Allo. DateTime </th>     
											<th width="60" >Status</th> 
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
			</div> 
            </div>
            <!-- /.tab-content --> 
          </div>
          <!-- /.nav-tabs-custom -->
        </div> 
        </div>  
  
    </section>
    
</div> 
  
<script type="text/javascript" language="javascript" >
	$(document).ready(function() {
			var ContractorID = $('#ContractorID').val();	 
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
				{ "data": "BookingID" ,"name": "BookingID"  },
				{ "data": "ConveyanceNo" ,"name": "ConveyanceNo"  },
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "BookingDateTime" ,"name": "BookingDateTime" },
				{ "data": "CompanyName" , "name": "CompanyName" },
				{ "data": "OpportunityName" , "name": "OpportunityName" },
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "LoadType" , "name": "LoadType" },   
				{ "data": null }, 				 
				{ "data": null }, 				  
				{ "data": "CreateDateTime" , "name": "DateTime" },   
				{ "data": null } 				 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('AjaxSubcontractorLoads') ?>", // json datasource
				type: "post",  // method  , by default get
				data : { 'ContractorID' : ContractorID },  
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
				var btype = '';var Ltype ="";var dname =""; var vreg =""; var status ="";var status1 =""; var del =""; 
				
				if(data["BookingType"] ==1){ $(row).addClass("even1");  btype = 'Collection' ; }else{ $(row).addClass("odd1"); btype = 'Delivery' ;  } 
				if(data["LoadType"]==1){ Ltype = "Fixed"; } if(data["LoadType"]==2){ Ltype = "TurnAround"; } 
				if(data["DriverName"]!=""){ dname = data["DriverName"]; }else{ dname = data["dname"]; } 
				if(data["VehicleRegNo"]!=""){ vreg = data["VehicleRegNo"]; }else{ vreg = data["rname"]; } 
				
				if(data["Status"]=='1'){ status = "ACCEPTED"; status1 = "label-warning";    
				}else if(data["Status"]=='4'){ status = "Finish"; status1 = " label-warning ";  } 
				
				$(row).find("td:eq(0)").html(data["BookingID"]);     
				$(row).find("td:eq(2)").html(btype); 
				$(row).find("td:eq(4)").html(data["CompanyName"] );
				$(row).find("td:eq(5)").html(data["OpportunityName"]);
				$(row).find("td:eq(7)").html(Ltype); 
				$(row).find("td:eq(8)").html(dname); 
				$(row).find("td:eq(9)").html(vreg);  
				$(row).find("td:eq(11)").html('<span class="label '+status1+' LoadInfo" data-LoadID="'+data["LoadID"]+'"  > '+status+' </span> '); 
				  
				
			}
		} );  
		   
	}); 
</script>