<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper"> 
    <section class="content-header"><h1><i class="fa fa-users"></i> Edit Booking </h1></section>  
    <section class="content"> 
        <div class="row"> 
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Booking Information</h3>
                    </div>   
					<div id="result"></div>   
                    <form id="EditBooking" name="EditBooking" action="<?php echo base_url('EditBooking/'.$bookings['BookingID']); ?>" method="post" role="form" > 
					<input type="hidden" name= "BookingID" value="<?php echo $bookings['BookingID']; ?>" >
                        <div class="box-body">
                        <div class="col-md-6">                             
                            <div class="row">  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date-time">Booking Type <span class="required">*</span></label>
                                        <select class="form-control" id="BookingType" name="BookingType" required="required"  >
											<option value="" <?php if($bookings['BookingType'] ==''){ ?> selected <?php } ?> >Booking Type</option>                                        
											<option value="1" <?php if($bookings['BookingType'] =='1'){ ?> selected <?php } ?> >Collection </option>                                          
											<option value="2" <?php if($bookings['BookingType'] =='2'){ ?> selected <?php } ?> >Delivery</option>                                        
                                        </select>  <div ></div>	
                                    </div> 
                                </div>                       
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="DescriptionofMaterial">Description of Material <span class="required">*</span></label>
                                         <select class="form-control select_material" id="DescriptionofMaterial" name="DescriptionofMaterial" data-live-search="true"  required="required" aria-required="true">
                                        <?php 
                                           echo '<option value="">-- Select material type--</option>';
                                            foreach ($Material as $key => $value) {
                                                $selected= "";
                                                if($value->MaterialID==$bookings['MaterialID']){
                                                    $selected= "Selected";
                                                }
                                               echo "<option value='".$value->MaterialID."' ".$selected.">".$value->MaterialName."</option>";
                                            }
                                        ?>                                    
                                        </select><div ></div>	
                                    </div>
                                </div>  
                            </div>  

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> 
                                        <label for="CompanyID">Select Company <span class="required">*</span></label>
                                        <select class="form-control" id="CompanyID" name="CompanyID"  data-live-search="true" required="required" aria-required="true">
                                        <?php 
                                        echo '<option value="">-- Select Company --</option>';
                                        foreach ($company_list as $key => $value) {

                                            $selected= "";
                                            if($value['CompanyID']==$bookings['CompanyID']){
                                                $selected= "Selected";

                                            }

                                          echo "<option value='".$value['CompanyID']."' ".$selected." >".$value['CompanyName']."</option>";
                                        } ?>
                                        </select><div ></div>	  
                                    </div>
                                </div>  
								 
                            </div>  
							<hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="OpportunityID">Opportunity <span class="required">*</span></label> 
                                        <select class="form-control select_opportunity " id="OpportunityID" data-live-search="true" name="OpportunityID" required="required" aria-required="true">
                                        <?php 
                                          echo '<option value="">-- Select Opportunity --</option>';
                                        foreach ($opprtunities as $key => $value) {
                                             $selected= "";
                                            if($value->OpportunityID==$bookings['OpportunityID']){
                                                $selected= "Selected";
                                            }
                                          echo "<option value='".$value->OpportunityID."' ".$selected.">".$value->OpportunityName."</option>";
                                        } ?>
                                        </select><div ></div>
                                    </div>
                                </div> 	
                            </div>   
							
							<hr> 
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyID">Select Contact <span class="required">*</span></label>
										<select class="form-control select_contact" id="ContactID" data-live-search="true"  name="ContactID" required="required" aria-required="true"  >
                                        <?php 
                                        echo '<option value=""> SELECT CONTACT </option>';
                                        foreach ($contacts as $key => $value) {
                                             $selected= "";
                                            if($value->ContactID==$bookings['ContactID']){
                                                $selected= "Selected";
                                            }
                                          echo "<option value='".$value->ContactID."' ".$selected.">".$value->ContactName."</option>";
                                        } ?>
                                        </select><div ></div> 
										
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Site Contact Name </label>
										<input type="text" class="form-control" id="ContactName" required="required" value="<?php echo $bookings['ContactName']; ?>" name="ContactName" maxlength="255"  > 
                                    </div>
                                </div> 
								 
                            </div>  
							<div class="row"> 
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Site Contact Mobile</label>
										<input type="text" class="form-control" id="ContactMobile"  required="required"  value="<?php echo $bookings['ContactMobile']; ?>" name="ContactMobile" maxlength="11"  > 
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Email">Email Address </label>
                                        <input type="text" class="form-control " id="Email"  value="<?php echo $bookings['Email']; ?>" name="Email"  maxlength="255" >
                                    </div>
                                </div>  			
                            </div>  
                        </div> 
						<div class="col-md-6"> 
							<div class="row">  
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="LoadType">Loads/Lorry Type <span class="required">*</span></label>
                                        <select class="form-control" id="LoadType" name="LoadType" required="required"  > 
											<option value="1" <?php if($bookings['LoadType'] =='1'){ ?> selected <?php } ?> >Loads (Fixed) </option>                                          
											<option value="2"  <?php if($bookings['LoadType'] =='2'){ ?> selected <?php } ?> >TurnAround</option>                                        
                                        </select>  <div ></div>	
                                    </div> 
                                </div>   	
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Loads">No Of Loads/Lorry <span class="required">*</span></label> 
											<select class="form-control select_loads" id="Loads" name="Loads" required="required" data-live-search="true" > 
												<?php for($i=1;$i<100;$i++){ ?>
														<option value="<?php echo $i; ?>" <?php if($i == $bookings['Loads']) { ?> selected <?php } ?> ><?php echo $i; ?></option>
												<?php } ?>
											</select>    
                                    </div>
                                </div>  
								<div class="col-md-4" >
                                    <div class="form-group">
                                        <label for="date-time">Request Date <span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control required" id="BookingDateTime" value="<?php echo $booking_dateCSV; ?>" name="BookingDateTime" maxlength="65">
                                        </div>
                                    </div> 
								</div>	 								 
                            </div>   
							<div class="row">   
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Loads"> Lorry Type </label>
										<select class="form-control " id="LorryType" name="LorryType"  data-live-search="true" >  
											<option value="" <?php if($bookings['LorryType'] ==''){ ?> selected <?php } ?> >Select</option> 
											<option value="1" <?php if($bookings['LorryType'] =='1'){ ?> selected <?php } ?> >Tipper</option> 
											<option value="2" <?php if($bookings['LorryType'] =='2'){ ?> selected <?php } ?> >Grab</option> 
											<option value="3" <?php if($bookings['LorryType'] =='3'){ ?> selected <?php } ?> >Bin</option> 
                                        </select>   
                                    </div>
                                </div>  
								<?php if($bookings['WaitingTime']!=0){ $Wtime = $bookings['WaitingTime']; }else{  $Wtime = '15'; }  ?>
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="WaitingTime"> Waiting Time (Minute) </label>
                                        <input type="number" class="form-control " id="WaitingTime"  value="<?php echo $Wtime; ?>"   name="WaitingTime" maxlength="10" >
                                    </div>
                                </div>  
								<?php if($bookings['WaitingCharge']!=0){  $WCharges = $bookings['WaitingCharge']; }else{  $WCharges = '1'; }  ?>
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="WaitingCharge"> Waiting Charges (1 &pound;/Minute) </label>
                                        <input type="number" class="form-control " id="WaitingCharge"  value="<?php echo $WCharges; ?>"  name="WaitingCharge" maxlength="5" >
                                    </div>
                                </div> 
                            </div>   
							<div class="row">                                
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="PurchaseOrderNumber">Purchase Order  </label>
                                        <input type="text" class="form-control " id="PurchaseOrderNumber" value="<?php echo $bookings['PurchaseOrderNumber']; ?>" name="PurchaseOrderNumber">
                                    </div>
                                </div>    
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Price"> Price </label>
                                        <input type="text" class="form-control " id="Price" value="<?php echo $bookings['Price']; ?>" name="Price" maxlength="20" >
                                    </div>
                                </div>    
                                
								<div class="col-md-4">
                                    <div class="form-group"> 
                                        <label for="PriceBy">Price By  </label>
                                        <select class="form-control" id="PriceBy" name="PriceBy" data-live-search="true"   >
										<option value="">-- Select --</option>
                                        <?php  foreach ($ApprovalUserList as $key => $value) { ?>
                                          <option value="<?php echo $value['userId'] ?>" <?php if($bookings['PriceBy']==$value['userId']){ ?> selected="selected" <?php } ?> ><?php echo $value['name'] ?></option>
                                        <?php } ?> 
                                        </select>  <div ></div>	  
                                    </div>
                                </div> 
							</div>   
							<div class="row">                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="Notes" rows="3" name="Notes"><?php echo $bookings['Notes']; ?></textarea>
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
    });
	/*$("#Days").on('change',function(){ 
		var Days=$(this).val();  
		for (var i = 0; i < 7; i++) { 
			if(i<=Days){
				$("#d"+i).show(); 
			}else{ 
				$("#d"+i).hide(); 
			}
		} 
    });     */  
</script>
<script src="<?php echo base_url('assets/js/Booking.js'); ?>" type="text/javascript"></script> 