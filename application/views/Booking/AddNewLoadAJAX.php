<?php echo '<tr id="1">
	<td>
		<select class="form-control BookingType" id="BookingType2" data-BID="2" name="BookingType[]" required="required"  >
			<option value="">Booking Type</option>                                        
			<option value="1">Collection</option>                                          
			<option value="2">Delivery</option>                                        
		</select><div ></div>
	</td>
	<td>
		<select class="form-control Material" id="DescriptionofMaterial2" name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
			<option value="">Select Material Type</option> 
		</select><div ></div>
	</td>
	<td>
		<select class="form-control LoadType" id="LoadType2" name="LoadType[]" required="required"  > 
			<option value="1">Loads</option>                                          
			<option value="2">TurnAround</option>                                        
		</select> 
	</td>
	<td>
		<select class="form-control LorryType" id="LorryType2" name="LorryType[]"  data-live-search="true" >  
			<option value=""  >Select</option> 
			<option value="1"  >Tipper</option> 
			<option value="2"   >Grab</option> 
			<option value="3"  >Bin</option> 
		</select>   
	</td> 
	<td>
		<select class="form-control Loads" id="Loads2" name="Loads[]" required="required"   data-live-search="true" > 
		<?php for($i=1;$i<100;$i++){ ?>
				<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
		<?php } ?>
		</select>    
	</td>
	<td>
		<div class="input-group date">
			<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
			<input type="text" class="form-control required BookingDateTime" data-BID="2" id="BookingDateTime2" autocomplete="off" value="" name="BookingDateTime[]" maxlength="65">
		</div>  
		<div ></div> 										
	</td>
	<td>
		<input type="text" class="form-control Price" id="Price1" data-BID="2"    name="Price[]" value="" > 
		<span id="pdate2" style="font-size:12px"></span> 
	</td>
	<td>
		<span id="Total2" style="font-size:12px"></span>
		<input type="hidden" id="TotalHidden2"  name="TotalHidden[]"  > 
	</td> 
</tr>';
?>