 
<form id="CancelBooking" name="CancelBooking" action="<?php echo  base_url('ShowLoadsDeleteBookingAJAXPOST'); ?>" method="post" role="form" > 
<input type="hidden" name="BookingDateID" value="<?php echo $BookingDateID; ?>" >
<input type="hidden" name="PendingLoads" value="<?php echo $PendingLoads; ?>" >
	<div class="box-body"> 
		<div class="col-md-12"> 
			<div class="row">   
				<div class="col-md-12">
					<div class="form-group">
						<label for="Loads"> Cancel Loads/Lorry </label>
						<select class="form-control " id="CancelLoads" name="CancelLoads" required="required"   data-live-search="true" > 
							<option value="" >Select</option>
							<?php for($i=1;$i<=$PendingLoads;$i++){ ?>
								<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
							<?php } ?>
						</select>   
					</div> 					
				</div>     
				<div class="col-md-12">
					<div class="form-group">
						<label for="notes">Notes</label>
						<textarea class="form-control" id="CancelNote" rows="3" name="CancelNote"></textarea>
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