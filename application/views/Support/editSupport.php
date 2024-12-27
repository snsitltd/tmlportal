<link href='<?= base_url('assets/css/dropzone.css') ?>' type='text/css' rel='stylesheet'>
<script src='<?= base_url('assets/js/dropzone.js') ?>' type='text/javascript'></script>
<?php $doc = array('doc','docx','ppt','pptx','pdf','xls','xlsx','txt'); ?>

<script>
		// Add restrictions
		Dropzone.options.fileupload = {
		   acceptedFiles: "image/*,application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",
		    maxFilesize: 3 // MB
		};
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Edit Support Ticket <a class="btn btn-primary" style="float:right" href="<?php echo base_url('Supports'); ?>">  Supports </a> </h1>
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
                    <form id="addsupport" name="addsupport" action="<?php echo base_url('editSupport/'.$cInfo['isupport_id']) ?>"  method="post" role="form" enctype="multipart/form-data">
					<input type="hidden" name="isupport_id" value="<?php echo $cInfo['isupport_id'];?>">
					<input type="hidden" name="vfile_start" value="<?php echo $cInfo['vfile_start'];?>">
                        <div class="box-body"> 
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="icategory">Category <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="icategory" name="icategory"  data-live-search="true" >
											<option value="" <?php if($cInfo['icategory']==""){ ?> selected="selected"  <?php } ?> >Select Category</option> 
											<option value="1" <?php if($cInfo['icategory']=="1"){ ?> selected="selected"  <?php } ?>>BUG</option>  
											<option value="2" <?php if($cInfo['icategory']=="2"){ ?> selected="selected"  <?php } ?>>New functionality </option>  
											<option value="3" <?php if($cInfo['icategory']=="3"){ ?> selected="selected"  <?php } ?>>Additional Update</option> 
											<option value="4" <?php if($cInfo['icategory']=="4"){ ?> selected="selected"  <?php } ?>>Support</option> 
											<option value="5" <?php if($cInfo['icategory']=="5"){ ?> selected="selected"  <?php } ?>>Human Error</option> 
										</select><div></div>
                                    </div>          
                                </div> 
                            
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="ipriority">Priority <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="ipriority" name="ipriority"  data-live-search="true" >
											<option value="" <?php if($cInfo['ipriority']==""){ ?> selected="selected"  <?php } ?> >Select Priority</option> 
											<option value="0" <?php if($cInfo['ipriority']=="0"){ ?> selected="selected" <?php } ?> >Low</option> 
											<option value="1" <?php if($cInfo['ipriority']=="1"){ ?> selected="selected"  <?php } ?> >Medium</option> 
											<option value="2" <?php if($cInfo['ipriority']=="2"){ ?> selected="selected"  <?php } ?> >High</option> 
										</select><div></div>
                                    </div>          
                                </div> 
                            </div>  
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="vtitle">Title <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $cInfo['vtitle'];?>" id="vtitle" name="vtitle" maxlength="255">
                                    </div>          
                                </div> 
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ltdesc">Description <span class="required" aria-required="true">*</span></label>
                                        <textarea class="form-control" id="ltdesc" rows="10" name="ltdesc" ><?php echo $cInfo['ltdesc'];?></textarea>
                                    </div>
                                </div> 
                            </div>  
							<div class="row">  
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="istatus	">Status <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="istatus" name="istatus"  data-live-search="true" > 
											<option value="0" <?php if($cInfo['istatus']=="0"){ ?> selected="selected" <?php } ?> >Open</option>   
											<option value="2" <?php if($cInfo['istatus']=="2"){ ?> selected="selected" <?php } ?> >Awaiting Response</option>   
											<option value="3" <?php if($cInfo['istatus']=="3"){ ?> selected="selected" <?php } ?> >Response Received </option>   
											<option value="4" <?php if($cInfo['istatus']=="4"){ ?> selected="selected" <?php } ?> >In Progress</option>   
											<option value="1" <?php if($cInfo['istatus']=="1"){ ?> selected="selected" <?php } ?> >Completed</option>   
										</select><div></div>
                                    </div>          
                                </div> 
                            </div>  
                        </div> 
						<div class="box-body box-body-nopadding">
						<?php  
						$map = glob('assets/support/'.$cInfo['vfile_start'].'_*'); 
						foreach ($map as $k){  $ext = '';
							$ext = strtolower(pathinfo($k, PATHINFO_EXTENSION)); 
							if (in_array($ext, $doc)){   ?>
							<a href="<?php echo base_url($k);?>" target="_blank" title="Click To Download" >Download </a>
							<?php }else{?>
							<a href="<?php echo base_url($k);?>" target="_blank" ><img src="<?php echo base_url($k);?>" width="200" style="padding: 10px " ></a>
							<?php }} ?> 
						 
						</div>
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />  
                        </div>
                    </form>
					<form action="<?php echo base_url('Support/SupportUpload'); ?>"  enctype="multipart/form-data"  class="dropzone" id='fileupload'> 
						<input type="hidden" name="vfile_start" value="<?php echo $cInfo['vfile_start'];?>" >
					</form>
					
                </div>
            </div> 
        </div>    
    </section>  
</div>
<script src="<?php echo base_url(); ?>assets/js/support.js" type="text/javascript"></script>