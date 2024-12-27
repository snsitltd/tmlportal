<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Opportunity Management  <small>Edit Contact </small>  
	  <a class="btn btn-primary" style="float:right" href="<?php echo base_url('edit-Opportunity/'.$contactInfo['OpportunityID']); ?>"><i class="fa fa-plus"></i> Edit Opportunity</a>
	  </h1>
	  
    </section>
     <section class="content"> 
        <div class="row"> 
        <div class="col-md-12">
          <div class="nav-tabs-custom"> 
            <div class="tab-content">  
			  <div class="row" style="margin-left:0px"> 
			  <form role="form" id="productSubmit" action="<?php echo base_url('Opportunity-EditContact/'.$contactInfo['ContactID']) ?>" method="post" role="form"  >
					  <?php echo validation_errors(); ?>
					  <?php $this->load->helper("form"); ?> 
						<input type="hidden" name="contactID" value="<?=$contactInfo['ContactID']?>"> 
						<input type="hidden" name="OpportunityID" value="<?=$contactInfo['OpportunityID']?>"> 
						<div class="box-body">
                            <div class="row">
                                <div class="col-md-1">                                
                                    <div class="form-group">
                                        <label for="Title">Title </label>
                                        <input type="text" class="form-control  " value="<?php echo $contactInfo['Title']; ?>" id="Title" name="Title" maxlength="128">
                                    </div> 
                                </div> 
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="ContactName">Contact Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="ContactName" value="<?php echo $contactInfo['ContactName']; ?>" name="ContactName" maxlength="128">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PhoneNumber">Phone (Landline)  </label>
                                        <input type="text" class="form-control digits" id="PhoneNumber" value="<?php echo $contactInfo['PhoneNumber']; ?>" name="PhoneNumber" maxlength="12" > 
                                    </div>
                                </div>  
                            </div>
							 <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="MobileNumber">Mobile Number <span class="required" aria-required="true">*</span></label>
                                      
                                        <input type="text" class="form-control required digits" id="MobileNumber" value="<?php echo $contactInfo['MobileNumber']; ?>" name="MobileNumber" maxlength="12"  >
                                    </div>
                                </div> 
                            </div> 
							 <div class="row"> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="EmailAddress">Email Address  </label>
                                        <input type="email" class="form-control   email" id="EmailAddress" value="<?php echo $contactInfo['EmailAddress']; ?>" name="EmailAddress" maxlength="100">
                                    </div>
                                </div>                           
                                   
                            </div> 
							<!-- <div class="row"> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PhoneExtension">Phone Extension  </label>
                                        
                                        <input type="text" class="form-control   digits" id="PhoneExtension" value="<?php //echo $contactInfo['PhoneExtension']; ?>" name="PhoneExtension" maxlength="12">
                                    </div>
                                </div> 
                            </div> -->
 
                            
                            <div class="row">    
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Position">Position </label>
                                        <input type="text" class="form-control  " id="Position" value="<?php echo $contactInfo['Position']; ?>" name="Position" maxlength="100">
                                    </div>
                                </div>  
                            </div> 
                        </div>  
                        <div class="box-footer">
                            <input type="submit" name="submit2" class="btn btn-primary" value="SAVE" />   
                        </div>    
              </form>  
			  </div>   
              </div> 
          </div> 
        </div> 
        </div>    
    </section>
</div>
<script src="<?php echo base_url(); ?>assets/js/Opportunity.js" type="text/javascript"></script>
 
