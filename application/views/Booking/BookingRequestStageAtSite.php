<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Booking Request Load <small> Set Stage to Reach / At Site</small></h1>
	</section>

     <section class="content"> 
        <div class="row"> 
        <div class="col-md-6"> 
		<div class="box box-primary">
              <?php echo validation_errors(); ?>
			  <?php //var_dump($LoadInfo); ?>
              <?php $this->load->helper("form"); ?>
                    <form role="form" id="AddStage" action="<?php echo base_url('BookingRequestStageAtSite/'.$LoadInfo->LoadID) ?>" method="post" >
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
                                        <label for="fname">Current Status : </label>  Accepted 
                                    </div> 
                                </div> 
                            </div>    
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="fname">TipNumber : (Optional)</label>  
										<input type="text" class="form-control" id="TipNumber" value="<?php echo $LoadInfo->TipNumber;?>" name="TipNumber" maxlength="11"  > 
                                    </div> 
                                </div> 
                            </div>   	
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="fname">Gross Weight : (Optional)</label>  
										<input type="text" class="form-control" id="GrossWeight" value="<?php echo $LoadInfo->GrossWeight;?>" name="GrossWeight" maxlength="11"  > 
                                    </div> 
                                </div> 
                            </div>   	
							<div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Notes : (Optional)</label>  
										<textarea class="form-control" id="Notes1" style="width:500px" rows="3" name="Notes1"></textarea>
                                    </div> 
                                </div> 
                            </div>   
						   <div class="box-footer">
								<input type="submit" class="btn btn-primary" value="REACH / At Site" /> 
								<input type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;"  value="Cancel" /> 
						   </div>
						</div>		
                        </form> 
              </div>                       
        </div>    
    </section> 
</div> 