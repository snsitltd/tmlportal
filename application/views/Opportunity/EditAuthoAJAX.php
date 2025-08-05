  
<form id="CancelBooking" name="CancelBooking" action="<?php echo  base_url('EditAuthoAJAXPOST'); ?>" method="post" role="form" > 
<input type="hidden" name="OpportunityID" value="<?php echo $OpportunityID; ?>" >
<input type="hidden" name="TipID" value="<?php echo $TipID; ?>" >
<input type="hidden" name="TableID" value="<?php echo $TableID; ?>" >
	<div class="box-body"> 
		<div class="col-md-12"> 
			<div class="row">   
				<div class="col-md-12">
					<div class="form-group">
						<label for="Loads"> Status</label>
						<select class="form-control " id="Status" name="Status" required="required"   data-live-search="true" > 
 						<option value="0" <?php if (isset($Autho['Status']) && $Autho['Status'] == 0) echo 'selected'; ?>>Authorised</option>
						<option value="1" <?php if($TableID!=""){ if($Autho['Status']==1){ ?> selected <?php }}else{ echo "selected"; } ?> >UnAuthorised</option> 
						</select>   
					</div> 					
				</div>     
				<div class="col-md-12">
					<div class="form-group">
						<label for="notes">Tip Ref No.</label>
						<input type="text" class="form-control required" value="<?php if($TableID!=""){  echo $Autho['TipRefNo']; } ?>"  id="TipRefNo"  name="TipRefNo" > 
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