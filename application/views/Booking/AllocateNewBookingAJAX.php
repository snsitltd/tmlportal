<div class="row">  
	<div class="col-md-12"> 
		<h4><b>Current Booking Details </b></h4>
	</div>
</div>	 
<div class="row">  
	<div class="col-md-6"> 
		<div class="form-group">
			<label ><b>Company Name : </b></label > <?php echo $BookingInfo['CompanyName']; ?>  <br> 
			<label ><b>Opportunity Name : </b></label > <?php echo $BookingInfo['OpportunityName']; ?> <br> 
			<label ><b>Material Name : </b></label > <?php echo $BookingInfo['MaterialName']; ?>  
		</div> 
	</div>  
	<div class="col-md-6"> 
		<div class="form-group">
			<label >Request Date : </label> <?php echo $BookingInfo['BookingDate']; ?>  <br>
			<label >Booking Type : </label> <?php if($BookingInfo['BookingType']==1){ echo "Collection"; } if($BookingInfo['BookingType']==2){ echo "Delivery"; }  if($BookingInfo['BookingType']==3){ echo "DayWork"; }   if($BookingInfo['BookingType']==4){ echo "Haulage"; }   ?> <br>
			<label >Load/Lorry Type : </label> <?php if($BookingInfo['TonBook']==1){ echo "Tonnage"; }else{ if($LoadType==1){ echo "Loads"; }else{ echo "Turnaround"; } } ?> <br>
			<?php if($BookingInfo['TonBook']==1){ ?><label >Ton/Load : </label> <?php  echo $BookingInfo['TonPerLoad'];   ?> <?php } ?>
		</div> 
	</div>  
</div> 
 
<hr>
 
<div class="row">   
	<div class="col-md-2">   
		<div class="form-group">  
			<input type="text" class="form-control required  " id="NewBookingNo" name="NewBookingNo" aria-required="true">
			<input type="hidden" name="BookingType" id="BookingType" value="<?php echo $BookingInfo['BookingType']; ?>" >
			<input type="hidden" name="LoadID" id="LoadID" value="<?php echo $LoadID; ?>" > 
		</div> 
	</div>  
	<div class="col-md-3">
		<button class="btn btn-sm  btn-info FetchBooking"  title="Fetch Booking"><i class="fa fa-search"></i> Fetch Booking </button>  
	</div>   
</div>  
	 
<div class="row" id="NewBookingID" style="display:none">  
	<div class="col-md-12"> 
		<div class="form-group">
			<label ><b>Company Name : </b></label > <span id="CompanyName"></span><br> 
			<label ><b>Opportunity Name : </b></label > <span id="OpportunityName"></span><br>  
			<label ><b>Booking Type: </b></label > <span id="BType"></span> 
		</div> 
	</div>     
	<div class="col-md-6"> 
		<div class="form-group" id="BDID" ></div>  	
	</div> 
</div> 
 