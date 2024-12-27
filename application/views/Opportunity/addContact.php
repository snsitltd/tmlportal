<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Opportunity Management
        <small>Add Contact</small>
		<a class="btn btn-primary" style="float:right" href="<?php echo base_url('edit-Opportunity/'.$opInfo['OpportunityID']); ?>"><i class="fa fa-plus"></i> Edit Opportunity</a>
      </h1>
    </section>
    
    <section class="content"> 
        <div class="row">

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            
            <div class="tab-content">
              <div class="tab-pane active" id="activity">

              <?php echo validation_errors(); ?>
              <?php $this->load->helper("form"); ?>
                    <form role="form" id="contactsubmit" action="<?php echo base_url('Opportunity-AddContact/'.$opInfo['OpportunityID']) ?>" method="post" role="form">
					<input type="hidden" name="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-1">                                
                                    <div class="form-group">
                                        <label for="Title">Title </label>
                                        <input type="text" class="form-control  " value="<?php echo set_value('Title'); ?>" id="Title" name="Title" maxlength="128">
                                    </div> 
                                </div> 
                                   
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="ContactName">Contact Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="ContactName" value="<?php echo set_value('ContactName'); ?>" name="ContactName" maxlength="128">
                                    </div>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PhoneNumber">Phone Number  </label>
                                        <input type="text" class="form-control digits" id="PhoneNumber" value="<?php echo set_value('PhoneNumber'); ?>" name="PhoneNumber" maxlength="12" >

                                    </div>
                                </div>

                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PhoneExtension">Phone Extension </label>
                                        
                                        <input type="text" class="form-control digits" id="PhoneExtension" value="<?php echo set_value('PhoneExtension'); ?>" name="PhoneExtension" maxlength="12">
                                    </div>
                                </div> -->
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="MobileNumber">Mobile Number <span class="required" aria-required="true">*</span></label>
                                      
                                        <input type="text" class="form-control required digits" id="MobileNumber" value="<?php echo set_value('MobileNumber'); ?>" name="MobileNumber" maxlength="12" >
                                    </div>
                                </div>

                                
                            </div> 
							<div class="row">
                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="EmailAddress">Email Address  </label>
                                        <input type="email" class="form-control email" id="EmailAddress" value="<?php echo set_value('EmailAddress'); ?>" name="EmailAddress" maxlength="100">
                                    </div>
                                </div>                           
                                   
                            </div> 
                            <div class="row">    
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Position">Position  </label>
                                        <input type="text" class="form-control  " id="Position" value="<?php echo set_value('Position'); ?>" name="Position" maxlength="100">
                                    </div>
                                </div> 
                               
                            </div> 
                        </div><!-- /.box-body --> 
                
              </div>
              <!-- /.tab-pane --> 

                 <div class="box-footer"> <input type="submit" name="submit2" class="btn btn-primary" value="SAVE" /> </div>

               </div>
               <!-- /.tab-content -->
            </form>
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
           
           
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/Contacts.js" type="text/javascript"></script>