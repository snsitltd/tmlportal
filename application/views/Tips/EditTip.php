<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Tip Address <small>Add / Edit Tip Address</small></h1>
	</section>

     <section class="content"> 
        <div class="row"> 
        <div class="col-md-6"> 
		<div class="box box-primary">
              <?php echo validation_errors(); ?>
              <?php $this->load->helper("form"); ?>
                    <form role="form" id="AddTip" action="<?php echo base_url('EditTip/'.$TipInfo['TipID']) ?>" method="post" >
                        <input type="hidden" name="TipID" value="<?php echo $TipInfo['TipID'];?>">
                        <div class="box-body">
							<div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Type">Tip Type <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control " id="HType" name="HType[]" required="required" multiple > 
                                            <option value="0" <?php if (strpos($TipInfo['HType'], '0') !== false) echo 'selected'; ?> >Non Hazardous </option>
                                            <option value="1" <?php if (strpos($TipInfo['HType'], '1') !== false)   echo 'selected'; ?> >Hazardous </option> 
											<option value="2" <?php if (strpos($TipInfo['HType'], '2') !== false)   echo 'selected'; ?> >Inert </option>  
											<option value="3" <?php if (strpos($TipInfo['HType'], '3') !== false)   echo 'selected'; ?> >Material</option>  
											<option value="4" <?php if (strpos($TipInfo['HType'], '4') !== false)   echo 'selected'; ?> >DayWork</option>  
                                        </select> 
									</div>
                                </div> 
							</div> 	 
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Tip Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $TipInfo['TipName'];?>" id="TipName" name="TipName">
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Price">Price</label>
                                        <input type="text" class="form-control  " value="<?php echo $TipInfo['Price'];?>" id="Price" name="Price" maxlength="10">
                                    </div> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="Street1" value="<?php echo $TipInfo['Street1'];?>" name="Street1" >
                                    </div>
                                </div>
							</div>
                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2  </label>
                                        <input type="text" class="form-control " id="Street2" value="<?php echo $TipInfo['Street2'];?>" name="Street2" >
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="Town" value="<?php echo $TipInfo['Town'];?>" name="Town">
                                    </div>
                                </div>
							</div>
                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="County">County <span class="required" aria-required="true">*</span></label>                                        
                                        <select class="form-control required" id="County" name="County"  data-live-search="true" >
                                            <option value="">Select County</option>
                                            <?php
                                            if(!empty($county))
                                            {
                                                foreach ($county as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == $TipInfo['County']) {echo "selected=selected";} ?>><?php echo $rl->County ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select> 
                                    </div>
                                </div>                                   
                            </div>
 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code  </label>
                                        <input type="text" class="form-control  " id="PostCode" value="<?php echo $TipInfo['PostCode'];?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>
							</div>
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PostCode">Permit Reference Number  </label>
                                        <input type="text" class="form-control  " id="PermitRefNo" value="<?php echo $TipInfo['PermitRefNo'];?>" name="PermitRefNo" maxlength="200">
                                    </div>
                                </div> 
                            </div> 
						   <div class="box-footer">
								<input type="submit" class="btn btn-primary" value="Submit" /> 
						   </div>
						</div>		
                        </form> 
              </div>                       
        </div>    
    </section> 
</div>
<script src="<?php echo base_url('assets/js/Tip.js'); ?>" type="text/javascript"></script>