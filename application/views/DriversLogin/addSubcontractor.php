
<div class="content-wrapper"> 
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Add Subcontractor  
      </h1>
    </section> 
    <section class="content"> 
		 <?php echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div>');  ?> 

        <div class="row"> 
            <div class="col-md-12">   
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Add Subcontractor Details</h3>
                    </div> 
					<form role="form" id="addsubcontractor"  name="addsubcontractor" action="<?php echo base_url('addSubcontractor') ?>" method="post" > 
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Company Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('CompanyName'); ?>" id="CompanyName" name="CompanyName" maxlength="128">
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address </label>
                                        <input type="email" class="form-control email" id="Email" value="<?php echo set_value('Email'); ?>" name="Email" maxlength="128">
                                    </div>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1  </label>
                                        <input type="text" class="form-control  " id="Street1" value="<?php echo set_value('Street1'); ?>" name="Street1" maxlength="100">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2  </label>
                                        <input type="text" class="form-control  " id="Street2" value="<?php echo set_value('Street2'); ?>" name="Street2" maxlength="100">
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town </label>
                                        <input type="text" class="form-control  " id="Town" value="<?php echo set_value('Town'); ?>" name="Town">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="County">County  </label>                                        
                                        <select class="form-control  " id="County" name="County"  data-live-search="true" >
                                            <option value="">Select County</option>
                                            <?php if(!empty($county)){
                                                foreach ($county as $rl){ ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == set_value('County')) {echo "selected=selected";} ?>><?php echo $rl->County ?></option>
                                            <?php } } ?>
                                        </select> 
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code  </label>
                                        <input type="text" class="form-control  " id="Postcode" value="<?php echo set_value('Postcode'); ?>" name="Postcode" maxlength="20">
                                    </div>
                                </div> 								
                            </div>
                            <div class="row">
                                 
                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Phone1">Mobile Number  </label>
                                        <input type="text" class="form-control digits" id="Mobile" value="<?php echo set_value('Mobile'); ?>" name="Mobile" maxlength="11" minlength="11">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Phone2">Phone</label>
                                        <input type="text" class="form-control digits" id="Phone" value="<?php echo set_value('Phone'); ?>" name="Phone" maxlength="11" minlength="11">
                                    </div>
                                </div> 
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Phone2">Total Lorry</label>
										<select class="form-control  required" id="Lorry" name="Lorry"  data-live-search="true" >
                                            <option value="">Select Total Lorry</option>
                                            <?php for($i=1;$i<50;$i++){ ?>
                                                <option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                </div> 
                            </div> 
 
                        </div>  
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" /> 
                            <button onclick="location.href='<?php echo  base_url('Subcontractor')?>';" type="button" class="btn btn-warning">Back</button>
                        </div>
                    </form>
                </div>
            </div>
           
        </div>    
    </section>
    
</div> 
  