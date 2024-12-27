 <script >
 $('select').selectpicker({
		   size: '10'
 });
		
 </script>
 
<form id="UpdateLorryDriver" name="UpdateLorryDriver" action="<?php echo  base_url('UpdateLorryDriverAJAXPOST'); ?>" method="post" role="form" > 
<input type="hidden" name="LorryNo" value="<?php echo $LorryNo; ?>" > 
	<div class="box-body"> 
		<div class="col-md-12"> 
			<?php if($CountAllocation['cnt']==0){ ?> 
				<div class="row">   
					<div class="col-md-12"> 				
						<div class="form-group">
							
							<label for="Loads"> New Driver  </label> 
							<?php //var_dump($CountAllocation); ?>
							<select class="form-control " id="DriverID" name="DriverID" required="required"    data-live-search="true" > 
								<option value="" >Select Driver</option>
								<?php for($i=0;$i<count($DriverList);$i++){ if($LorryDetails['DriverID'] != $DriverList[$i]->DriverID){ ?>
									<option value="<?php echo $DriverList[$i]->DriverID; ?>"  ><?php echo $DriverList[$i]->DriverName.' | '.$DriverList[$i]->MobileNo; ?></option>
								<?php }} ?>
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
			<?php }else{ ?>  
				You can not update driver as there is <b><?php echo $CountAllocation['cnt']; ?></b> Pending Load(s).   
			<?php } ?> 
		</div>  
	</div> 
</form>