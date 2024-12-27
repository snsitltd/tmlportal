  <?php //print_r($BookingInfo); echo count($BookingInfo); exit; ?>
<?php if(count($BookingInfo)==0){ ?>  

<div class="row"  >  	
		<div class="col-md-8"> 
			<div   >  <b>There is No Such Ticket. Please Try Again.</b></div> 
		</div>  
		<div class="col-md-4 modal-footer" > 
			<button class="btn btn-primary  " type="submit" name="submit" > SAVE </button>  
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>    
</div>
<?php }else{ ?>
<div class="row"> 
	<div class="col-md-6">
		<div class="form-group">
			<label ><b>Conveyance No :  <?php echo $BookingInfo->ConveyanceNo; ?></b></label >  <br> 
			<label ><b>Booking Type : </b></label > <?php if($BookingInfo->BookingType==1){ echo "Collection"; } if($BookingInfo->BookingType==2){ echo "Delivery"; }  if($BookingInfo->BookingType==3){ echo "DayWork"; }   if($BookingInfo->BookingType==4){ echo "Haulage"; }   ?> <br> 
			<label ><b>Load  Type : </b></label > <?php if($BookingInfo->TonBook==1){ echo "Tonnage"; }else{ if($BookingInfo->LoadType==1){ echo "Loads"; }else{ echo "Turnaround"; } } ?> <br> 
			<label ><b>Lorry Type :</b></label > <?php  if($BookingInfo->LorryType==1){ echo "Tipper"; } if($BookingInfo->LorryType==2){ echo "Grab"; } if($BookingInfo->LorryType==3){ echo "Bin"; }    ?> 
		</div> 
	</div> 
	<div class="col-md-6">
		<div class="form-group">
			<label ><b>Driver Name : </b></label > <?php echo $BookingInfo->DriverName; ?>  <br> 
			<label ><b>Lorry No : </b></label > <?php echo $BookingInfo->LorryNo; ?>  <br> 
			<label ><b>Veh Reg Number : </b></label > <?php echo $BookingInfo->VehicleRegNo; ?> <br> 
			<label ><b>Tare: </b></label > <?php echo $BookingInfo->Tare; ?> 
			
		</div> 
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label ><b>Company Name : </b></label > <?php echo $BookingInfo->CompanyName; ?>  <br> 
			<label ><b>Opportunity Name : </b></label > <?php echo $BookingInfo->OpportunityName; ?> <br> 
			<label ><b>Tip Name: </b></label > <?php echo $BookingInfo->TipName; ?> <br> 
			<label ><b>Material Name : </b></label > <?php echo $BookingInfo->MaterialName; ?>  
			
		</div> 
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label ><b>JobStart DateTime : </b></label > <?php echo $BookingInfo->JSDateTime; ?>  <br> 
			<label ><b>SiteIn DateTime : </b></label > <?php echo $BookingInfo->SIDateTime; ?> <br> 
			<label ><b>SiteOut DateTime: </b></label > <?php echo $BookingInfo->SODateTime; ?> <br> 
			<label ><b>JobEnd DateTime : </b></label > <?php echo $BookingInfo->JEDateTime; ?>  
		</div> 
	</div>	
</div>   
</div>  
<form id="SearchConveyanceSubmit" name="SearchConveyanceSubmit" action="<?php echo base_url('SearchConveyanceSubmit/'.$BookingInfo->LoadID); ?>" method="post" role="form" >    
<input type="hidden"  id="LoadID"  value="<?php echo $BookingInfo->LoadID; ?>" name="LoadID">  


<div class="row"  >  	
		<div class="col-md-8"> 
			<div   >  </div> 
		</div>  
		<div class="col-md-4 modal-footer" >
				<div class="form-group">
					<label for="GrossWeight">Gross Weight</label>
					<input type="number" class="form-control required" id="GrossWeight"  value="" name="GrossWeight" maxlength="6"  min="1"  >
				</div>
			<button class="btn btn-primary  " type="submit" name="submit" > SAVE </button>  
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>    
</div>
</form>
<?php } ?>