<script src="<?php echo base_url('assets/js/print.js'); ?>" type="text/javascript"></script>   
<link rel="stylesheet" href="<?php echo base_url('docs/css/signature-pad.css'); ?>">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Booking Load <small> Set Stage to Left Site</small></h1>
	</section>

     <section class="content"> 
        <div class="row"> 
        <div class="col-md-6"> 
		<div class="box box-primary">
              <?php echo validation_errors(); ?>
			  <?php //var_dump($LoadInfo); ?>
              <?php $this->load->helper("form"); ?>
                    <form role="form" id="AddStage" action="<?php echo base_url('BookingStageLeftSite/'.$LoadInfo->LoadID) ?>" method="post" >
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
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">SIC Code : </label>  <?php echo $LoadInfo->SicCode;?> 
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Tip Name : </label>  <?php echo $LoadInfo->TipName;?> 
                                    </div> 
                                </div> 
                            </div>   
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Current Status : </label>  At Site 
                                    </div> 
                                </div> 
                            </div>   
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Customer Name : </label>  
										<input type="text" class="form-control " id="CustomerName" value="<?php echo set_value('CustomerName'); ?>" name="CustomerName">
                                    </div> 
                                </div> 
                            </div>     
							
							<div class="row">
                                <div class="col-md-12">                                		
									<div id="signature-pad" class="signature-pad " >
										<div class="signature-pad--body">
										  <canvas></canvas>
										</div>
										<div class="signature-pad--footer">
										  <div class="description">Sign above</div> 
										  <div class="signature-pad--actions">
											<div>
											  <button type="button" id="savepng" class="button btn btn-danger save " data-action="save-png">Save </button> 
											  <button type="button" class="button btn btn-primary clear" data-action="clear">Clear</button>   
											  
											</div> 
										  </div>
										</div>
									</div>  
								</div>  
							</div>  
									<input type='hidden' name="Signature" id="Signature" required value="" >	
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Notes : (Optional)</label>  
										<textarea class="form-control" id="Notes2" style="width:500px" rows="3" name="Notes2"></textarea>
                                    </div> 
                                </div> 
                            </div>   
						   <div class="box-footer">
								<input type="submit" class="btn btn-primary" value="Left Site" /> 
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
	$("#savepng").click(function() {  
		var dataURL = signaturePad.toDataURL();    
		$('#Signature').val(dataURL);  
	}); 
});	
</script> 
<script src="<?php echo base_url(); ?>docs/js/signature_pad.umd.js"></script>
<script src="<?php echo base_url(); ?>docs/js/app.js"></script>