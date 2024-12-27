<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
										<option value="0">-- ADD COMPANY --</option>
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
											<option value="0">-- ADD OPPORTUNITY --</option>                                        
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
                                        <input type="text" class="form-control " id="Email"  required="required"  value="<?php echo set_value('Email'); ?>" name="Email"  maxlength="255" >
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
											<option value="1">Loads (Fixed)</option>                                          
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
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Loads"> Days (For TurnAround Only ) </label>
										<select class="form-control select_loads" id="Days" name="Days" required="required"   data-live-search="true" >   
											<option value="1">NA</option> 
                                        </select>   
                                    </div>
                                </div>    
                            </div> 
							
							<div class="row" > 
								<div class="col-md-4" id="d1">
                                    <div class="form-group">
                                        <label for="date-time">Request Date <span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control required" id="BookingDateTime0" value="<?php echo date('d/m/Y'); ?>" name="BookingDateTime[1]" maxlength="100">
                                        </div>
                                    </div> 
								</div>	 
								<div class="col-md-4" id="d2" >
                                    <div class="form-group">
                                        <label for="date-time">Request Date (+1)<span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control required" id="BookingDateTime1" value="<?php echo date('d/m/Y'); ?>" name="BookingDateTime[2]" maxlength="100">
                                        </div>
                                    </div> 
								</div>	 
								<div class="col-md-4" id="d3">
                                    <div class="form-group">
                                        <label for="date-time">Request Date (+2)<span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control required" id="BookingDateTime2" value="<?php echo date('d/m/Y'); ?>" name="BookingDateTime[3]" maxlength="100">
                                        </div>
                                    </div> 
								</div>	 
								<div class="col-md-4" id="d4">
                                    <div class="form-group">
                                        <label for="date-time">Request Date (+3)<span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control required" id="BookingDateTime3" value="<?php echo date('d/m/Y'); ?>" name="BookingDateTime[4]" maxlength="100">
                                        </div>
                                    </div> 
								</div>	 
								<div class="col-md-4" id="d5" >
                                    <div class="form-group">
                                        <label for="date-time">Request Date (+4)<span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control required" id="BookingDateTime4" value="<?php echo date('d/m/Y'); ?>" name="BookingDateTime[5]" maxlength="100">
                                        </div>
                                    </div> 
								</div>	 
								<div class="col-md-4" id="d6">
                                    <div class="form-group">
                                        <label for="date-time">Request Date (+5)<span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control required" id="BookingDateTime5" value="<?php echo date('d/m/Y'); ?>" name="BookingDateTime[6]" maxlength="100">
                                        </div>
                                    </div> 
								</div>	  
								
                            </div> 
							 
							<div class="row">   
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Price"> Price </label>
                                        <input type="text" class="form-control " id="Price" value="<?php echo set_value('Price'); ?>" name="Price" maxlength="20" >
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PurchaseOrderNumber">Purchase Order  </label>
                                        <input type="text" class="form-control " id="PurchaseOrderNumber" value="<?php echo set_value('PurchaseOrderNumber'); ?>" name="PurchaseOrderNumber">
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
<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" language="javascript" > 	

	$("#d2").hide(); $("#d3").hide(); $("#d4").hide();  $("#d5").hide();$("#d6").hide(); 

	$(document).ready(function(){
		$('#BookingDateTime0').datepicker({ 
			format: 'dd-mm-yyyy',
			step: 5,
			multidate: 5,
			closeOnDateSelect: true
		});

//		$('#BookingDateTime0').datetimepicker({ multidate: true });    
		$('#BookingDateTime1').datetimepicker({format: 'DD/MM/YYYY', minDate:new Date() });    
		$('#BookingDateTime2').datetimepicker({format: 'DD/MM/YYYY', minDate:new Date() });    
		$('#BookingDateTime3').datetimepicker({format: 'DD/MM/YYYY', minDate:new Date() });    
		$('#BookingDateTime4').datetimepicker({format: 'DD/MM/YYYY', minDate:new Date() });    
		$('#BookingDateTime5').datetimepicker({format: 'DD/MM/YYYY', minDate:new Date() });    
		
    });    	
	$("#Days").on('change',function(){ 
		var Days=$(this).val();  
		for (var i = 0; i < 7; i++) { 
			if(i<=Days){
				$("#d"+i).show(); 
			}else{ 
				$("#d"+i).hide(); 
			}
		} 
    });    
</script>
<script src="<?php echo base_url('assets/js/Booking.js'); ?>" type="text/javascript"></script> 