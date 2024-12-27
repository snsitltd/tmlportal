<link href='<?= base_url('assets/css/dropzone.css') ?>' type='text/css' rel='stylesheet'>
<script src='<?= base_url('assets/js/dropzone.js') ?>' type='text/javascript'></script>
<?php $vfile_start = mt_rand(0, 999999);  ?>
<script>
		// Add restrictions
		//Dropzone.options.fileupload = {
		 //   acceptedFiles: "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",
		//    maxFilesize: 5 // MB
		//};
	</script>
<div class="content-wrapper"> 
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Add Support Ticket  <a class="btn btn-primary" style="float:right" href="<?php echo base_url('Supports'); ?>">  Supports </a> </h1>
    </section> 
    <section class="content"> 
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->  
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Ticket Details</h3>
                    </div> 
                    <?php $this->load->helper("form"); ?>
                    <form id="addsupport" name="addsupport" action="<?php echo base_url('addSupport') ?>"  method="post" role="form" >
					<input type="hidden" name="vfile_start" value="<?php echo $vfile_start; ?>">
                        <div class="box-body"> 
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="icategory">Category <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="icategory" name="icategory"  data-live-search="true" >
											<option value="">Select Category</option> 
											<option value="5">Human Error</option>
											<option value="1">BUG</option> 
											<option value="2">New functionality </option> 
											<option value="3">Additional Update </option> 
											<option value="4">Support</option> 
											
										</select><div></div>
                                    </div>          
                                </div> 
                            
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="ipriority">Priority <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="ipriority" name="ipriority"  data-live-search="true" >
											<option value="">Select Priority</option> 
											<option value="0">Low</option> 
											<option value="1">Medium</option> 
											<option value="2">High</option> 
										</select><div></div>
                                    </div>          
                                </div> 
                            </div>  
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="vtitle">Title <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('vtitle'); ?>" id="vtitle" name="vtitle" maxlength="255">
                                    </div>          
                                </div> 
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ltdesc">Description <span class="required" aria-required="true">*</span></label>
                                        <textarea class="form-control" id="ltdesc" rows="10" name="ltdesc" ></textarea>
                                    </div>
                                </div> 
                            </div>  
						 
                        </div> 
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />  
                        </div>
                    </form>
					<div class="box-body"> 
						<div class="row">
                            <div class="col-md-6"> 
								<form action="<?php echo base_url('Support/SupportUpload'); ?>"  enctype="multipart/form-data"  class="dropzone" id='fileupload'> 
									<input type="hidden" name="vfile_start" value="<?php echo $vfile_start; ?>">
								</form>
							</div>
						</div>
					</div>
                </div>
            </div>  
			
        </div>    
    </section> 
</div>   
<script src="<?php echo base_url(); ?>assets/js/support.js" type="text/javascript"></script>