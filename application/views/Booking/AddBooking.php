<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper"> 
    <section class="content-header"><h1><i class="fa fa-users"></i> Add Booking </h1></section>  
    <section class="content">
	
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements --> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Booking Information</h3>
                    </div>  
					<div id="result"></div>  
                    <?php $this->load->helper("form"); ?>
                    <form id="AddBooking" name="AddBooking" action="<?php echo base_url('AddBooking'); ?>" method="post" role="form" > 
                        <div class="box-body">
                        <div class="col-md-6">                             
                            <div class="row">  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date-time">Booking Type <span class="required">*</span></label>
                                        <select class="form-control" id="BookingType" name="BookingType" required="required"  >
											<option value="">Booking Type</option>                                        
											<option value="1">Collection</option>                                          
											<option value="2">Delivery</option>                                        
                                        </select>  <div ></div>	
                                    </div> 
                                </div>                       
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="DescriptionofMaterial">Description of Material <span class="required">*</span></label>
                                         <select class="form-control   select_material" id="DescriptionofMaterial" name="DescriptionofMaterial" required="required" data-live-search="true"  >
										 <option value="">Select Material Type</option> 
                                        </select> <div ></div>	
                                    </div>
                                </div>  
                            </div>  

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyID">Select Company <span class="required">*</span></label>
                                        <select class="form-control select_company " id="CompanyID" name="CompanyID" required="required" data-live-search="true"   >
										<option value="">-- ADD COMPANY --</option>
                                        <?php  foreach ($company_list as $key => $value) { ?>
                                          <option value="<?php echo $value['CompanyID'] ?>"><?php echo $value['CompanyName'] ?></option>
                                        <?php } ?>
                                        </select>  <div ></div>	  
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Company Name </label>
										<input type="text" class="form-control" id="CompanyName" value="<?php echo set_value('CompanyName'); ?>" name="CompanyName" maxlength="255"  > 
                                    </div>
                                </div>  
                            </div>  
							<hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="OpportunityID">Opportunity <span class="required">*</span></label> 
                                        <select class="form-control select_opportunity " id="OpportunityID" name="OpportunityID" required="required" data-live-search="true"   >
											<option value="">-- ADD OPPORTUNITY --</option>                                        
                                        </select> <div ></div>
                                    </div>
                                </div> 	
                            </div>  
							<div class="row">  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1  </label>
                                        <input type="text" class="form-control required Street1" id="Street1" value="<?php echo set_value('Street1'); ?>" name="Street1" maxlength="255">
                                    </div>
                                </div> 
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="County">County  </label>                                        
                                        <select class="form-control required County" id="County" name="County"  data-live-search="true" >
                                            <option value="" >Select County</option>
                                            <?php
                                            if(!empty($county)){
                                                foreach ($county as $rl){ ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == set_value('County')) { ?> selected <?php } ?> ><?php echo $rl->County ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select><div ></div>

                                    </div>
                                </div> 
							</div> 
							<div class="row">  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town  </label>
                                        <input type="text" class="form-control required Town" id="Town" value="<?php echo set_value('Town'); ?>" name="Town">
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code </label>
                                        <input type="text" class="form-control required PostCode" id="PostCode" value="<?php echo set_value('PostCode'); ?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>   
                            </div>  
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyID">Select Contact <span class="required">*</span></label>
                                        <select class="form-control select_contact " id="ContactID" name="ContactID" required="required" data-live-search="true"   >
										<option value="0">-- ADD CONTACT --</option> 
                                        </select>  <div ></div>	  
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Site Contact Name </label>
										<input type="text" class="form-control" id="ContactName"  required="required" value="<?php echo set_value('ContactName'); ?>" name="ContactName" maxlength="255"  > 
                                    </div>
                                </div>  
							</div>	
							<div class="row">
							
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Site Contact Mobile</label>
										<input type="text" class="form-control" id="ContactMobile"  required="required" value="<?php echo set_value('ContactMobile'); ?>" name="ContactMobile" maxlength="11"  > 
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Email">Email Address </label>
                                        <input type="text" class="form-control " id="Email" value="<?php echo set_value('Email'); ?>" name="Email"  maxlength="255" >
                                    </div>
                                </div>  			
                            </div>  
                        </div> 
						 
						<div class="col-md-6"> 
							<div class="row">  
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="LoadType">Loads/Lorry Type<span class="required">*</span></label>
                                        <select class="form-control" id="LoadType" name="LoadType" required="required"  > 
											<option value="1">Loads</option>                                          
											<option value="2">TurnAround</option>                                        
                                        </select>  <div ></div>	
                                    </div> 
                                </div>   	
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Loads"> No of Loads/Lorry<span class="required">*</span></label>
										<select class="form-control " id="Loads" name="Loads" required="required"   data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i == set_value('Loads')) { ?> selected <?php } ?> ><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>   
                                    </div>
                                </div>   
								<div class="col-md-4" >
                                    <div class="form-group">
                                        <label for="date-time">Request Date <span class="required">*</span></label>
                                        <div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control required" id="BookingDateTime" autocomplete="off" value="" name="BookingDateTime" maxlength="65">
                                        </div>  <div ></div>	
                                    </div> 
								</div>	 
								<!--<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Loads"> Days (For TurnAround Only ) </label>
										<select class="form-control select_loads" id="Days" name="Days" required="required"   data-live-search="true" >   
											<option value="1">NA</option> 
                                        </select>   
                                    </div>
                                </div>     -->
                            </div> 
							
							<div class="row" > 
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Loads"> Lorry Type </label>
										<select class="form-control " id="LorryType" name="LorryType"  data-live-search="true" >  
											<option value="" <?php if(set_value('LorryType') =="" ) { ?> selected <?php } ?> >Select</option> 
											<option value="1" <?php if(set_value('LorryType') ==1 ) { ?> selected <?php } ?> >Tipper</option> 
											<option value="2" <?php if(set_value('LorryType') ==2 ) { ?> selected <?php } ?> >Grab</option> 
											<option value="3" <?php if(set_value('LorryType') ==3 ) { ?> selected <?php } ?> >Bin</option> 
                                        </select>   
                                    </div>
                                </div>   
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="WaitingTime"> Waiting Time (Minute) </label>
                                        <input type="number" class="form-control " id="WaitingTime" value="15" name="WaitingTime" maxlength="10" >
                                    </div>
                                </div>  
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="WaitingCharge"> Waiting Charges (1 &pound;/Minute) </label>
                                        <input type="number" class="form-control " id="WaitingCharge" value="1" name="WaitingCharge" maxlength="5" >
                                    </div>
                                </div>   
							</div> 
							<div class="row">                                
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="PurchaseOrderNumber">Purchase Order  </label>
                                        <input type="text" class="form-control " id="PurchaseOrderNumber" value="<?php echo set_value('PurchaseOrderNumber'); ?>" name="PurchaseOrderNumber">
                                    </div>
                                </div>                
								
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Price"> Price </label>
                                        <input type="number" class="form-control " id="Price" value="<?php echo set_value('Price'); ?>" name="Price" maxlength="20" >
										<i id='pdate'></i>
                                    </div>
                                </div>  
								<div class="col-md-4">
                                    <div class="form-group"> 
                                        <label for="PriceBy">Price By  </label>
                                        <select class="form-control" id="PriceBy" name="PriceBy" data-live-search="true"   >
										<option value="">-- Select --</option>
                                        <?php  foreach ($ApprovalUserList as $key => $value) { ?>
                                          <option value="<?php echo $value['userId'] ?>"><?php echo $value['name'] ?></option>
                                        <?php } ?> 
                                        </select>  <div ></div>	  
                                    </div>
                                </div> 
								
							</div> 
							<div class="row">                                			
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="Notes" rows="3" name="Notes"></textarea>
                                    </div>
                                </div>  
                            </div>   
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">   
										<input type="submit" name="submit" style="float:right;" class="btn btn-primary" value="Submit" /> 
                                    </div>
                                </div> 
                            </div>  
                        </div>  
                        </div> 
						</form>
                        </div> 
                   
            </div>
        </div>    
    </section> 
</div> 
<script type="text/javascript" language="javascript" > 	 
	$(document).ready(function(){
		$('#BookingDateTime').datepicker({  
			format: 'dd/mm/yyyy', 
			startDate: 'today', 
			multidate: 6,
			daysOfWeekDisabled  : [0], 
			closeOnDateSelect: true
		});  
		$("#DescriptionofMaterial").on('change',function(){
		  $('#BookingDateTime').click();
		});
		$("#BookingType").on('change',function(){ 
		  $('#BookingDateTime').click();
		});
		$('#BookingDateTime').datepicker().on('changeDate click', function (ev) { 
			//alert(val('#BookingDateTime'));
			var BookingDateTime = $( "#BookingDateTime").val();
			var OpportunityID = $( "#OpportunityID").val();
			var MaterialID = $( "#DescriptionofMaterial").val(); 
				
			if(OpportunityID!='' && OpportunityID!=0 && MaterialID!=''){
				var temp = new Array();
				temp = BookingDateTime.split(",");
				for (i = 0; i < temp.length; i++) { 
					var dt = new Array();
					dt = temp[i].split("/");
					
					temp[i] = dt[2]+'-'+dt[1]+'-'+dt[0];
					//alert(temp[i]);
				} 
				temp.sort();
				if(BookingDateTime!=""){
					var DateRequired = temp[0]; 
					var HitUrl = baseURL + "ShowOppoProductPriceAJAX"; 
					$.ajax({
						type : "POST",
						dataType : "json",
						url : HitUrl,
						data : { 'OpportunityID' : OpportunityID,'MaterialID' : MaterialID,'DateRequired' : DateRequired } 
						}).success(function(data){ 
							//alert(data.Price)
							$( "#Price").val(data.Price); 
							$( "#PurchaseOrderNumber").val(data.PurchaseOrderNo); 
							$( "#pdate").html('<b>PriceDate:</b> '+data.PriceDate); 
					});  
				}else{ 	$( "#Price").val(''); $( "#PurchaseOrderNumber").val(''); $( "#pdate").html('');   } 
			}else{ 	$( "#Price").val(''); $( "#PurchaseOrderNumber").val(''); $( "#pdate").html('');   }  
		});	  
    });    	 
</script>
<script src="<?php echo base_url('assets/js/Booking.js'); ?>" type="text/javascript"></script> 