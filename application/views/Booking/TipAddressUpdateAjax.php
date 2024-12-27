
<script>   
$(document).ready(function() {    
	$('#TipTicketDatetime').datetimepicker({ format: 'DD/MM/YYYY HH:mm' });  

	$('select').selectpicker(); 	
}); 

</script>  
<?php //var_dump($CheckTicketNumber); ?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">    
<script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script>

<form id="TipUpdate" name="TipUpdate" action="<?php echo base_url('TipAddressUpdate/'.$LoadID); ?>" method="post" role="form" >    
<input type="hidden"  id="LoadID"  value="<?php echo $LoadID; ?>" name="LoadID">  
<div class="row" style="width:500px">  
	<div class="col-md-12"> 
		<div>
			<div class="form-group">
				<label for="TipID">Tip Address</label>
				<select  class="form-control tiplst1 selectpicker required" onchange="showDiv('hidden_div', this)"  data-live-search="true" style="width:120px" id="TipID1" name="TipID1"  >
				<?php if(!empty($TipRecords)){ foreach ($TipRecords as $rl){ if($TipID!=$rl->TipID){ ?>
						<option value="<?php echo $rl->TipID ?>" ><?php echo $rl->TipName ?></option>
				<?php }} } ?>
				</select>
			</div> 		
		</div> 
	</div> 	
</div> 		
<div class="row" style="width:500px">  	
	<div class="col-md-6"> 
		<div id="Gross"  >
			<div class="form-group">
				<label for="GrossWeight">Gross Weight</label>
				<input type="number" class="form-control required" id="GrossWeight"  value="" name="GrossWeight" maxlength="6"  min="1"  >
			</div>	 
		</div> 
	</div> 
	<div class="col-md-6" > 
		<div class="form-group">
			<label for="date-time">Ticket DateTime </label>
			<div class="input-group date">
				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
				<input type="text" class="form-control  " id="TipTicketDatetime" name="TipTicketDatetime" maxlength="21">
			</div>
		</div> 
	</div>	
</div> 		
<div class="row" >  	
	<div class="col-md-6">
		<div class="form-group">
			<label for="Conveyance">Conveyance No </label>
			<input type="text" class="form-control" id="ConveyanceNo"  readonly name="ConveyanceNo" value="<?php echo $ConveyanceNo; ?>" >  
		</div>
	</div> 		

	<div class="col-md-6">
		<div class="form-group">
			<label for="Conveyance">Ticket Number </label>
			<input type="text" class="form-control" id="TicketNumber"  readonly name="TicketNumber" value="<?php echo $CheckTicketNumber['TicketNumber']; ?>" >  
			<input type="hidden" name="TicketNo" value="<?php echo $CheckTicketNumber['TicketNo']; ?>" >
		</div>
	</div> 		 
</div>
	
<div class="row"   style="width:500px;" >  	 
	<?php if(!empty($TipRecords)){  ?>
		<div class="col-md-12 modal-footer"    >
			<button class="btn btn-primary  " type="submit" name="submit" > SAVE </button>  
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>   
	<?php } ?>
</div>
</form>