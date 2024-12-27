<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">    
<script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script> 

<script>
	$(function () {  
		$('select').selectpicker();   
		$('#ConveyanceDate').datepicker({  
			format: 'dd/mm/yyyy',   
			closeOnDateSelect: true
		});  
		$('#TipTicketDate').datepicker({  
			format: 'dd/mm/yyyy',   
			closeOnDateSelect: true
		});  

	}) 	
</script> 
<input type="hidden" name="CompanyID" id="CompanyID" value="<?php echo $CompanyID; ?>"   >
<input type="hidden" name="OpportunityID" id="OpportunityID" value="<?php echo $OpportunityID; ?>"   >
<div class="row">  
	<div class="col-md-12"> 
		<div >
			<select  class="form-control selectpicker " data-live-search="true" style="width:120px" id="Booking" name="Booking"  >
			<?php if(!empty($Bookings)){ foreach ($Bookings as $rl){ ?>
			<option value="<?php echo $rl->BookingID ?>|<?php echo $rl->BookingDateID ?>|<?php echo $rl->MaterialID ?>" ><?php echo $rl->BookingType." | ".$rl->LoadType." | ".$rl->LorryType." | ".$rl->BookingDate." | ".$rl->MaterialName ?></option>
			<?php }} ?>
			</select>
		</div> 
	</div>   
</div>   
<br>
<div class="row">  

	<div class="col-md-6"> 
		<div  >
			<select  class="form-control tiplst1 selectpicker " data-live-search="true" style="width:120px" id="TipID" name="TipID"  >
			<?php if(!empty($TipRecords)){ foreach ($TipRecords as $rl){ ?>
					<option value="<?php echo $rl->TipID ?>" ><?php echo $rl->TipName ?></option>
			<?php }} ?>
			</select>
		</div> 
	</div>   
	 
	<div class="col-md-6">
		<div >
			<select  class="form-control selectpicker" data-live-search="true" style="width:120px" id="DriverID" name="DriverID"  > 
			<?php if(!empty($LorryListNonApp)){ foreach ($LorryListNonApp as $rl){ 
			if($rl->ContractorLorryNo!=0){ $ln = $rl->ContractorLorryNo; }else{ $ln = $rl->LorryNo;  }
			if($rl->RegNumber!=''){ $rn = " | ".$rl->RegNumber; }else{ $rn = "";  }
			//if (!in_array($rl->LorryNo, $dl)) { ?>
				<option value="<?php echo $rl->LorryNo ?>|<?php echo $rl->Tare ?>" ><?php echo $rl->DriverName.' | '.$ln." ".$rn ?></option>
			<?php } } //} ?>
			</select> 
		</div>
	</div>  	
</div>  		
<br>
 
<div class="row">  	
	<div class="col-md-12"> 
	<label for="date-time">Material (If Change):   </label>
		<select  class="form-control selectpicker" data-live-search="true" style="width:120px" id="MaterialID" name="MaterialID"  > 
		<?php 
			echo '<option value="">Select Material </option>';
			foreach ($Material as $key => $value) {
			   echo "<option value='".$value->MaterialID."'>".$value->MaterialName."</option>";
			}
		?>  
		</select>  
	</div>   
</div>    
<br> 
<div class="row">   
	<div class="col-md-6" > 
		<div class="form-group">
			<label for="date-time">Conveyance Date:   </label>
			<div class="input-group date">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				<input type="text" class="form-control" id="ConveyanceDate" required  name="ConveyanceDate" maxlength="65">
			</div>
		</div> 
	</div>	  
	
	<div class="col-md-6" > 
		<div class="form-group"> 
			<div class="form-group"> 
				<label for="CompanyName">Conveyance Ticket </label>
				<input type="text" class="form-control" id="NonAppConveyanceNo" required value="" name="NonAppConveyanceNo" maxlength="20"  > 
			</div>  
		</div> 
	</div>	   
	
	<div class="col-md-6">
		<div class="form-group">
			<label for="GrossWeight">Gross Weight</label>
			<input type="number" class="form-control required" id="GrossWeight" onKeyPress="if(this.value.length==5) return false;" value="<?php echo set_value('GrossWeight'); ?>" name="GrossWeight"  maxlength="6"  >
		</div>
	</div> 
	<hr>
</div> 	
<div class="row">   
	<div class="col-md-6" > 
		<div class="form-group"> 
			<div class="form-group"> 
				<label for="CompanyName">TipTicket No. </label>
				<input type="hidden"   id="TicketNo"  value="" name="TicketNo" > 
				<input type="text" class="form-control" id="TipTicketNo" required value="" name="TipTicketNo" maxlength="20"  > 
				<span id="pdf"></span>
			</div>  
		</div> 
	</div>	   
	<div class="col-md-6" > 
		<div class="form-group">
			<label for="date-time">Tip Ticket Date:   </label>
			<div class="input-group date">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				<input type="text" class="form-control" id="TipTicketDate" required  name="TipTicketDate" maxlength="65">
			</div>
		</div> 
	</div>	   
	<div class="col-md-12">                                
		<div class="form-group">
			<label for="fname">Remarks: </label>  
			<textarea class="form-control" id="Remarks" rows="3" name="Remarks"></textarea> 
		</div> 
	</div> 
</div>
<div class="row">   
	<div class="col-md-12">
		<button class="btn btn-sm  btn-info CreateTicket"  data-BookingRequestID="<?php echo $BookingRequestID; ?>" title="Create Ticket"><i class="fa fa-check"></i> Create Ticket </button>  
	</div>   
</div> 
</div> 
