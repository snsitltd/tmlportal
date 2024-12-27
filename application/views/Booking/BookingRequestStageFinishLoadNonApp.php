<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Booking Load <small> Set Stage to Finish ( NON APP USER)</small></h1>
	</section>

     <section class="content"> 
        <div class="row"> 
        <div class="col-md-6"> 
		<div class="box box-primary">
              <?php echo validation_errors(); ?>
			  <?php //var_dump($LoadInfo); ?>
              <?php $this->load->helper("form"); ?>
                    <form role="form" id="AddStage" action="<?php echo base_url('BookingRequestStageFinishLoadNonApp/'.$LoadInfo->LoadID) ?>" method="post" >
                        <input type="hidden" name="LoadID" value="<?php echo $LoadInfo->LoadID;?>">
                        <div class="box-body">
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Company Name : </label>  <?php echo $LoadInfo->CompanyName;?> 
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Opportunity Name : </label>  <?php echo $LoadInfo->OpportunityName;?> 
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Material Name : </label>  <?php echo $LoadInfo->MaterialName;?> 
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">SIC Code : </label>  <?php echo $LoadInfo->SicCode;?> 
                                    </div> 
                                </div> 
                             
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Tip Name : </label>  <?php echo $LoadInfo->TipName;?> 
                                    </div> 
                                </div> 
                            </div>    
							<hr>
							<!--<div class="row"> 
								<div class="col-md-6" > 
									<div class="form-group">
										<label for="date-time">Conveyance Date:   </label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control required" id="JobStartDateTime"  name="JobStartDateTime" maxlength="65">
										</div>
									</div> 
								</div>	  
							</div> -->
							
							<div class="row">   
								<div class="col-md-6" > 
									<div class="form-group"> 
										<div class="form-group"> 
											<label for="CompanyName">Conveyance Ticket </label>
											<input type="text" class="form-control" id="NonAppConveyanceNo" required value="<?php echo set_value('NonAppConveyanceNo'); ?>" name="NonAppConveyanceNo" maxlength="20"  > 
										</div>  
									</div> 
								</div>	  
							 
								<div class="col-md-6" > 
									<div class="form-group">
										<label for="date-time">Conveyance Date:   </label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control" id="ConveyanceDate" required  name="ConveyanceDate" maxlength="65">
										</div>
									</div> 
								</div>	  
							</div>
							<hr>
							
							<!--<div class="row">   
								<div class="col-md-6" > 
									<div class="form-group"> 
										<div class="form-group"> 
											<label for="CompanyName">Tip Ticket No </label>
											<input type="text" class="form-control" id="TipTicketNo" value="<?php echo set_value('TipTicketNo'); ?>" name="TipTicketNo" maxlength="255"  > 
										</div>  
									</div> 
								</div>	  
							 
								<div class="col-md-6" > 
									<div class="form-group">
										<label for="date-time">Tip Ticket Date:   </label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control" id="TipTicketDate"  name="TipTicketDate" maxlength="65">
										</div>
									</div> 
								</div>	  
							</div>
							<hr> -->
							<div class="row">   
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="GrossWeight">Gross Weight</label>
                                        <input type="number" class="form-control required" id="GrossWeight" onKeyPress="if(this.value.length==5) return false;" value="<?php echo set_value('GrossWeight'); ?>" name="GrossWeight"  maxlength="6"  >
                                    </div>
                                </div> 
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Tare">Tare</label>
                                        <input type="number" class="form-control required" id="Tare" value="<?php echo $LoadInfo->lorry_tare; ?>" name="Tare" readonly  >
                                    </div>
                                </div>                       
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Net">Net</label>
                                        <input type="number" class="form-control" id="Net" name="Net" readonly>
                                    </div>
                                </div>                              
                            </div> 
							
							<hr>
							<!-- <div class="row">   
								<div class="col-md-6" > 
									<div class="form-group">
										<label for="date-time">SiteIn DateTime:   </label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control  required" id="SiteInDateTime"  name="SiteInDateTime" maxlength="65">
										</div>
									</div> 
								</div>	  
							 
								<div class="col-md-6" > 
									<div class="form-group">
										<label for="date-time">SiteOut DateTime: </label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control  required" id="SiteOutDateTime"  name="SiteOutDateTime" maxlength="65">
										</div>
									</div> 
								</div>	  
							</div>	 -->
							
							<hr>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Notes : (Optional)</label>  
										<textarea class="form-control" id="Notes" style="width:380px" rows="3" name="Notes"></textarea>
                                    </div> 
                                </div> 
                            </div>   
						   <div class="box-footer">
						   <?php if($LoadInfo->LoadType==2){ ?>
								<input type="submit" name="continue" class="btn btn-default" value="Continue" /> 
							<?php } ?>	
								<input type="submit" name="finish" class="btn btn-primary" value="Finish" /> 
								<input type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;"  value="Cancel" /> 
						   </div>
						</div>		
                        </form> 
              </div>                       
        </div>    
    </section> 
</div> 


<script>   
$(document).ready(function() {   

	$("#Tare").change(function(){
		$('#GrossWeight').trigger("change");
	});

	$("#GrossWeight").change(function(){ 
	     
		var GrossWeight = parseInt($(this).val());
		var Tare = parseInt($('#Tare').val());
		//$('#GrossWeight').val( GrossWeight );
		
		if( GrossWeight > Tare){	
			var net =  GrossWeight - Tare;
			$('#Net').val( net );
		}else{ 
			$('#Net').val( '' );  
		}
	}); 

	$('#ConveyanceDate').datetimepicker({format: 'YYYY-MM-DD HH:mm' });  
	$('#TipTicketDate').datetimepicker({format: 'YYYY-MM-DD HH:mm' });  
	
	$('#SiteInDateTime').datetimepicker({format: 'YYYY-MM-DD HH:mm' });  
	$('#SiteOutDateTime').datetimepicker({format: 'YYYY-MM-DD HH:mm' });  
	//$('#JobStartDateTime').datetimepicker({format: 'DD-MM-YYYY' });  
}); 

</script>