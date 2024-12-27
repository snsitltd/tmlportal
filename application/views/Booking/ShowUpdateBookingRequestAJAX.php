 
<form id="CancelBooking" name="CancelBooking" action="<?php echo  base_url('ShowUpdateBookingRequestAJAXPOST'); ?>" method="post" role="form" > 
<input type="hidden" name="BookingID" value="<?php echo $BookingID; ?>" > 
	<div class="box-body"> 
		<div class="col-md-12"> 
			<div class="row">   
				<div class="col-md-12">
					<div class="form-group">
						<label for="Loads"> Current Total Loads/Lorry: <?php echo $TotalLoads; ?> </label> 
					</div> 					
					<div class="form-group">
						<label for="Loads"> New Total Loads/Lorry </label>
						<select class="form-control " id="Loads" name="Loads" required="required"   data-live-search="true" > 
							<option value="" >Select</option>
							<?php for($i=($TotalLoads-$PendingLoads);$i<=50;$i++){ ?>
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