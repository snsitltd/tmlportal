<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Tip Address <small>Add Tip Address</small></h1>
    </section> 
    <section class="content"> 
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->  
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Tip Address Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="AddTip" action="<?php echo base_url('AddTip') ?>" method="post" >
                        <div class="box-body">
							<div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="HType">Tip Type <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control " id="HType" name="HType[]" required="required" multiple > 
                                            <option value="0">Non Hazardous </option>
                                            <option value="1">Hazardous </option> 
											<option value="2">Inert </option> 
											<option value="3">Material </option> 
											<option value="4">DayWork </option> 
                                        </select> 
									</div>
                                </div> 
							</div> 	 
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="TipName">Tip Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('TipName'); ?>" id="TipName" name="TipName" maxlength="128">
                                    </div> 
                                </div> 
                            </div>
							
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Price">Price  </label>
                                        <input type="text" class="form-control  " value="<?php echo set_value('Price'); ?>" id="Price" name="Price" maxlength="10">
                                    </div> 
                                </div> 
                            </div>
                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="Street1" value="<?php echo set_value('Street1'); ?>" name="Street1" maxlength="100">
                                    </div>
                                </div>
							</div>
                         
                            <div class="row">	
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2 </label>
                                        <input type="text" class="form-control " id="Street2" value="<?php echo set_value('Street2'); ?>" name="Street2" maxlength="100">
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="Town" value="<?php echo set_value('Town'); ?>" name="Town">
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
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == set_value('County')) {echo "selected=selected";} ?>><?php echo $rl->County ?></option>
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
                                        <input type="text" class="form-control  " id="PostCode" value="<?php echo set_value('PostCode'); ?>" name="PostCode" maxlength="20">
                                    </div>
                                </div> 
                            </div>    
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PostCode">Permit Reference Number  </label>
                                        <input type="text" class="form-control  " id="PermitRefNo" value="<?php echo set_value('PermitRefNo'); ?>" name="PermitRefNo" maxlength="200">
                                    </div>
                                </div> 
                            </div>    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />  
                        </div>
                    </form>
                </div>
            </div> 
        </div>    
    </section> 
</div>
<script src="<?php echo base_url('assets/js/Tip.js'); ?>" type="text/javascript"></script>