 
<script>   
$(document).ready(function() {    
	$('#JobStartDatetime').datetimepicker({ format: 'DD/MM/YYYY HH:mm' });  
	$('#SiteInDatetime').datetimepicker({ format: 'DD/MM/YYYY HH:mm' });  
	$('#SiteOutDatetime').datetimepicker({ format: 'DD/MM/YYYY HH:mm' });  
	$('#SiteInDatetime2').datetimepicker({ format: 'DD/MM/YYYY HH:mm' });  
	$('#SiteOutDatetime2').datetimepicker({ format: 'DD/MM/YYYY HH:mm' });  
	$('#JobEndDatetime').datetimepicker({ format: 'DD/MM/YYYY HH:mm' });  
}); 

</script> 
<form id="DateUpdate" name="DateUpdate" action="<?php echo base_url('DateUpdateHaulage/'.$LoadID); ?>" method="post" role="form" >    
<input type="hidden"  id="LoadID"  value="<?php echo $LoadID; ?>" name="LoadID">  
<div class="row">  
	<div class="col-md-12">  
			<div class="row">   
				<div class="col-md-6" > 
					<div class="form-group">
						<label for="date-time">JobStartDatetime </label>
						<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control required" id="JobStartDatetime" value="<?php echo $JobStart ?>" name="JobStartDatetime" maxlength="21">
						</div>
					</div> 
				</div>	  
				<div class="col-md-6" > 
					<div class="form-group">
						<label for="date-time">SiteInDatetime </label>
						<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control required" id="SiteInDatetime" value="<?php echo $SiteIn ?>" name="SiteInDatetime" maxlength="21">
						</div>
					</div> 
				</div>	  
				<div class="col-md-6" > 
					<div class="form-group">
						<label for="date-time">SiteOutDatetime </label>
						<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control required" id="SiteOutDatetime" value="<?php  echo $SiteOut ?>" name="SiteOutDatetime" maxlength="21">
						</div>
					</div> 
				</div>	 
				<div class="col-md-6" > 
					<div class="form-group">
						<label for="date-time">HaulageInDatetime </label>
						<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control required" id="SiteInDatetime2" value="<?php  echo $HaulageIn ?>" name="SiteInDatetime2" maxlength="21">
						</div>
					</div> 
				</div>	 
				<div class="col-md-6" > 
					<div class="form-group">
						<label for="date-time">HaulageOutDatetime </label>
						<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control required" id="SiteOutDatetime2" value="<?php  echo $HaulageOut ?>" name="SiteOutDatetime2" maxlength="21">
						</div>
					</div> 
				</div>	 	
				<div class="col-md-6" > 
					<div class="form-group">
						<label for="date-time">JobEndDatetime </label>
						<div class="input-group date">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control required" id="JobEndDatetime" value="<?php  echo $JobEnd ?>" name="JobEndDatetime" maxlength="21">
						</div>
					</div> 
				</div>	  
			</div>	  
	</div>  
	<br><br><br>
	<div class="col-md-12">
		<button class="btn btn-primary  " type="submit" name="submit" >  Update TimeStamp </button>  
	</div>   
</div>
</form>
 