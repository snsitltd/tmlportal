<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Upload data
        
      </h1>
    </section>
    
    <section class="content">

      <?php
                    $this->load->helper('form');
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
                
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements --> 
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="uploaddatasubmit" action="<?php echo base_url() ?>uploaddatasubmit" method="post" role="form" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="title">Title <span class="required" aria-required="true">*</span> </label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('title'); ?>" id="title" name="title" maxlength="128">
                                    </div>
                                    
                                </div>
                              
                            </div>

                            <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="type">File Data <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="type" name="type">
                                        
                                            <option value="">--Select--</option>
                                            <option value="company">Company</option> 
                                            <option value="opportunities">Opportunities</option>
                                            <option value="contacts">Contacts</option>
                                            <option value="notes">Notes</option>
                                            <option value="documents">Documents</option> 
                                            <!--<option value="materials">materials</option>
                                            <option value="drivers">drivers</option>-->
                                            

                                             <option value="company_to_opportunities">Company to Opportunity</option> 

                                             <option value="company_to_note">Company to Notes</option>
                                             <option value="company_to_contact">Company to Contacts</option>
                                             <option value="company_to_document">Company to Documents</option>
                                              
                                              <option value="opportunity_to_note">Opportunity to Notes</option>
                                              <option value="opportunity_to_contact">Opportunity to Contact</option> 
                                              <option value="opportunity_to_document">Opportunity to Documents</option> 
                                              
                                              
                                              <option value="test">Test</option>

                                                                                       
                                        </select>
                                    </div>
                                </div>                                
                            </div>

                           

                            <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uploadfile">Select File <span class="required" aria-required="true">*</span></label>
                                        <input type="file" name="uploadfile" class="form-control required">
                                    </div>
                                </div>                                
                            </div>

                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>

                    </form>
                </div>
            </div>
            
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/schedule.js" type="text/javascript"></script>