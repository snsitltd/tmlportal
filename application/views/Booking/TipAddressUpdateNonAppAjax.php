<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">    
<script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script>
<script>
	$(function () {  $('select').selectpicker();  }) 	
</script> 
<form id="TipUpdate" name="TipUpdate" action="<?php echo base_url('TipAddressUpdateNonApp/'.$LoadID); ?>" method="post" role="form" >    
<input type="hidden"  id="LoadID"  value="<?php echo $LoadID; ?>" name="LoadID">  
<div class="row">  
	<div class="col-md-9"> 
		<div>
			<select  class="form-control tiplst1 selectpicker " data-live-search="true" style="width:120px" id="TipID1" name="TipID1"  >
			<?php if(!empty($TipRecords)){ foreach ($TipRecords as $rl){ //if($TipID!=$rl->TipID){ ?>
					<option value="<?php echo $rl->TipID ?>" ><?php echo $rl->TipName ?></option>
			<?php }} //} ?>
			</select>
		</div> 
	</div>  
	<div class="col-md-3">
		<button class="btn btn-primary  " type="submit" name="submit" >  Update Tip </button>  
	</div>   
</div>
</form>
 