<form id="DBooking" name="DBooking" action="<?php echo  base_url('DeleteBookingRequest'); ?>" method="post" role="form" > 
<input type="hidden" name="BookingDateID" value="<?php echo $BookingDateID; ?>" > 
<input type="hidden" name="BookingID" value="<?php echo $BookingID; ?>" > 
<input type="hidden" name="BookingRequestID" value="<?php echo $BookingRequestID; ?>" > 
	<div class="box-body"> 
		<div class="col-md-12"> 
			<?php if($CountLoads->CountLoads=='0'){ ?>
			
			<div class="row">   
				<div class="col-md-12">
					<div class="form-group">
						<label for="Loads"> Are You Sure You want to Delete this Booking Request ? </label> 
					</div> 					
					 
				</div>     
			</div>   
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">   
						<button type="submit" style="float:right;" class="btn btn-danger" value="submit" > Delete  </button>
					</div>
				</div> 
			</div> 
			<?php } if($CountLoads->CountLoads>0){ ?>
			<div class="row">   
				<div class="col-md-12">
					<div class="form-group">
						  Booking Request Could not be deleted as There is <b><?php echo $CountLoads->CountLoads; ?> Load(s) </b> already Allocated from this Booking Request.   
					</div> 					 
				</div>     
			</div>   
			<?php } ?>
			
		</div>  
	</div>  
</form>	