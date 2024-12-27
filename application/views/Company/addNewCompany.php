<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
        <small>Add / Edit Company</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->  
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Company Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="addnewcompanysubmit" action="<?php echo base_url() ?>addnewcompanysubmit" method="post" role="form" enctype="multipart/form-data">
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
                                        <input type="email" class="form-control email" id="EmailID" value="<?php echo set_value('EmailID'); ?>" name="EmailID" maxlength="128">
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
                                        <label for="Town">Town <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="Town" value="<?php echo set_value('Town'); ?>" name="Town">
                                    </div>
                                </div>

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

                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Phone1">Mobile Number 1  </label>
                                        <input type="text" class="form-control digits" id="Phone1" value="<?php echo set_value('Phone1'); ?>" name="Phone1" maxlength="11" minlength="11">
                                    </div>
                                </div>
                                   
                            </div>



                            <div class="row">                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Phone2">Mobile Number 2</label>
                                        <input type="text" class="form-control digits" id="Phone2" value="<?php echo set_value('Phone2'); ?>" name="Phone2" maxlength="11" minlength="11">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Fax">Fax  </label>
                                        <input type="text" class="form-control  " id="Fax" value="<?php echo set_value('Fax'); ?>" name="Fax" maxlength="11">
                                    </div>
                                </div>
                                   
                            </div>

                            <div class="row">                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Website">Website (eg. http://example.com/)</label>
                                        <input type="URL" class="form-control" id="Website" value="<?php echo set_value('Website'); ?>" name="Website" maxlength="100">
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Country">Country <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="Country" name="Country"  data-live-search="true" >
                                            <option value="">Select Country</option>
                                            <?php
                                            if(!empty($country))
                                            {
                                                foreach ($country as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->country_code ?>" 
													<?php if($rl->country_code == set_value('country_code')) { echo "selected=selected"; }else if($rl->country_code == 'GB'){ echo "selected=selected";  } ?> ><?php echo $rl->country_name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                   
                            </div>
							<hr>
							<h3> Sage Details </h3>
							 <div class="row">  
                                <div class="col-md-4">
                                    <div class="form-group">
										<div class="checkbox">  
											<label> <input type="radio" name="PaymentType" id="PaymentType" value="1" > Credit  </label>
											<label> <input type="radio" name="PaymentType" id="PaymentType"  value="2" > Cash  </label> 
											<!-- <label> <input type="radio" name="PaymentType" id="PaymentType"  value="3" > Card </label>  -->
                                        </div> 
										
                                        <!-- <label for="PaymentType">Payment Type</label>
                                        <input type="text" class="form-control" id="PaymentType" value="<?php //echo set_value('PaymentType'); ?>" name="PaymentType" maxlength="100"> -->
                                    </div>
                                </div>  

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="CreditLimit">Creditlimit</label>
                                        <input type="text" class="form-control" id="CreditLimit" value="<?php echo set_value('CreditLimit'); ?>" name="CreditLimit" maxlength="100">
                                    </div>
                                </div>  
								
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Outstanding">Outstanding</label>
                                        <input type="text" class="form-control" id="Outstanding" value="<?php echo set_value('Outstanding'); ?>" name="Outstanding" maxlength="100">
                                    </div>
                                </div>  

                                   
                            </div>
                               <hr>

                              <div class="row">                               

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="DocumentAttachment">Select Document</label>
                                        <input type="file" class="form-control" id="DocumentAttachment" name="DocumentAttachment[]">
                                    </div>
                                </div>  

                                <div class="col-md-4"> 
                                    <div class="form-group"> 
                                        <label for="DocumentDetail">Details</label>
                                        <input type="text" class="form-control" id="DocumentDetail" name="DocumentDetail[]">
                                        
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                          <br>
                                          <button class="btn btn-primary add-doc-fields-btn" type="button"> + Add New </button>
                                    </div>
                                </div>

                </div> 

                <div class="add-fields-fun"></div>


                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                            <button onclick="location.href='<?php echo  base_url('companies')?>';" type="button" class="btn btn-warning">Back</button>
                        </div>
                    </form>
                </div>
            </div>
           
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/Company.js" type="text/javascript"></script>