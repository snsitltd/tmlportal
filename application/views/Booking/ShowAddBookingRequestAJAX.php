 
<form id="CancelBooking" name="CancelBooking" action="<?php echo  base_url('ShowAddBookingRequestAJAXPOST'); ?>" method="post" role="form" > 
<input type="hidden" name="BookingID" value="<?php echo $BookingID; ?>" > 
<input type="hidden" name="TotalLoads" value="<?php echo $TotalLoads; ?>" > 
	<div class="box-body"> 
		<div class="col-md-12"> 
			<div class="row">   
				<div class="col-md-12">
					<div class="form-group">
						<label for="Loads"> Current Total Loads/Lorry: <?php echo $TotalLoads; ?> </label> 
					</div> 					
					<div class="form-group">
						<label for="Loads"> Add No Of Loads/Lorry </label>
						<select class="form-control " id="Loads" name="Loads" required="required"   data-live-search="true" >  
							<?php for($i=1;$i<=50;$i++){ ?>
								<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
							<?php } ?>
						</select>   
					</div> 					
				</div>     
			</div>   
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">   
						<input type="submit" name="submit" style="float:right;" class="btn btn-primary" value="Save" /> 
					</div>
				</div> 
			</div>  
		</div>  
	</div> 
</form>