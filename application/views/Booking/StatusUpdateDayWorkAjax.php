<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">    
<script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script>
<script>
	$(function () {  $('select').selectpicker();  }) 	
</script> 
<form id="StatusUpdate" name="StatusUpdate" action="<?php echo base_url('StatusUpdateDayWork/'.$LoadID); ?>" method="post" role="form" >    
<input type="hidden"  id="LoadID"  value="<?php echo $LoadID; ?>" name="LoadID">  
<div class="row">  
	<div class="col-md-12"> 
		<div>
			<select  class="form-control tiplst1 selectpicker " required data-live-search="true" style="width:80px" id="Status" name="Status"  >
					<option value="" >Select Status  </option> 
					<?php if($Status!='Finished' && $PDF!=''){ ?>
						<option value="4" >Finished</option> 
					<?php } ?>
					<?php if($Status!='Cancelled'){ ?>
						<option value="5" >Cancelled</option> 
					<?php } ?>
					<?php if($Status!='Wasted'){ ?>
						<option value="6" >Wasted Journey</option> 
					<?php } ?>
					<?php if($Status!='8'){ ?>
						<option value="8" >Invoice Cancelled</option> 
					<?php } ?>
			</select>
		</div> 
	</div>  
	<br><br><br>
	<div class="col-md-12">
		<button class="btn btn-primary  " type="submit" name="submit" >  Update Status </button>  
	</div>   
</div>
</form>
 