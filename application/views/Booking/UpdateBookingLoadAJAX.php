<script src="<?php echo base_url('assets/css/bootstrap-datepicker.css'); ?>"></script> 
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/bootstrap-datetimepicker.min.css'); ?>" />
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datetimepicker.min.js'); ?>"></script>
<!-- bootstrap datetimepicker -->
<script src="<?php echo base_url('assets/plugins/datepicker/moment.min.js'); ?>"></script> 	
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datetimepicker.min.js'); ?>"></script> 	
<script>
$(document).ready(function() {   
	$('#SiteInDateTime').datetimepicker({format: 'DD-MM-YYYY HH:mm' });    
	$('#SiteOutDateTime').datetimepicker({format: 'DD-MM-YYYY HH:mm' });    
}) 	
</script>  
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<label >Request Date : </label> <?php echo $BookingInfo['BookingDate']; ?> 
		</div> 
	</div> 
	<div class="col-md-3">
		<div class="form-group">
			<label >Booking Type : </label> <?php if($BookingInfo['BookingType']==1){ echo "Collection"; }else{ echo "Delivery"; } ?> 
		</div> 
	</div> 
	<div class="col-md-3">
		<div class="form-group">
			<label >Load/Lorry Type : </label> <?php if($LoadType==1){ echo "Fixed"; }else{ echo "Turnaround"; } ?> 
		</div> 
	</div> 
	<div class="col-md-3">
		<div class="form-group">
			<label >No of Load/Lorry : </label> <?php echo $BookingInfo['Loads']; ?>
		</div> 
	</div>  
</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label ><b>Company Name : </b></label > <?php echo $BookingInfo['CompanyName']; ?>  <br> 
			<label ><b>Opportunity Name : </b></label > <?php echo $BookingInfo['OpportunityName']; ?> <br> 
			<label ><b>Material Name : </b></label > <?php echo $BookingInfo['MaterialName']; ?> 
		</div> 
	</div> 
</div> 
 
<div class="row">  
	<div class="col-md-4"> 
		<div class="form-group">
			<label for="date-time">SiteIn DateTime <span class="required">*</span></label>
			<div class="input-group date">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				<input type="text" class="form-control required" id="SiteInDateTime" value="" name="SiteInDateTime" maxlength="65">
			</div>
		</div> 
	</div> 
	<div class="col-md-4"> 
		<div class="form-group">
			<label for="date-time">SiteOut DateTime <span class="required">*</span></label>
			<div class="input-group date">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				<input type="text" class="form-control required" id="SiteOutDateTime" value="" name="SiteOutDateTime" maxlength="65">
			</div>
		</div> 
	</div> 
	<div class="col-md-4"> 
		<div class="form-group">
			<label for="date-time">  </label>
			<div class="input-group "> 
				<a class="btn btn-sm  btn-info UpdateBookingLoad" herf="#"  data-BookingNo="<?php echo $BookingID; ?>"  data-BookingDateID="<?php echo $BookingDateID; ?>" title="Save Booking Load Info "> SAVE </a>  
			</div>
		</div> 
	</div>  
	 
</div>
</div> 