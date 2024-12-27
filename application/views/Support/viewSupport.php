<link href='<?= base_url('assets/css/dropzone.css') ?>' type='text/css' rel='stylesheet'>
<script src='<?= base_url('assets/js/dropzone.js') ?>' type='text/javascript'></script>
 <?php $doc = array('doc','docx','ppt','pptx','pdf','xls','xlsx','txt'); ?>

<div class="content-wrapper">
<?php $vfile_start = mt_rand(0, 999999);  ?>
    <section class="content-header"><h1><i class="fa fa-users"></i> View Support Ticket <a class="btn btn-primary" style="float:right" href="<?php echo base_url('Supports'); ?>">  Supports </a></h1> </section>
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
                <div class="box box-primary"> 
                    <?php $this->load->helper("form"); ?> 
                        <div class="box-body">
							<?php if(validation_errors()){ ?>
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<?php echo validation_errors(); ?>
								</div>
							<?php } ?>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="vtitle">Title: </label> <?php echo $cInfo['vtitle'];?>
                                    </div>          
                                </div> 
                            </div> 
							<div class="row">
								<div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Category: </label> <?php if($cInfo['icategory']=="1"){ ?> BUG <?php } ?>
										<?php if($cInfo['icategory']=="2"){ ?> New functionality <?php } ?>
										<?php if($cInfo['icategory']=="3"){ ?> Additional Update <?php } ?>
										<?php if($cInfo['icategory']=="4"){ ?> Support <?php } ?>
										<?php if($cInfo['icategory']=="5"){ ?> Human Error <?php } ?>
                                    </div> 
                                </div> 
							</div>  
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ltdesc">Description: </label> <?php echo $cInfo['ltdesc'];?> 
                                    </div> 
								</div>  
                            </div>   
							<div class="row">
								<div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="fname">Priority: </label> 
										<?php if($cInfo['ipriority']=="0"){ ?> Low <?php } ?>
										<?php if($cInfo['ipriority']=="1"){ ?> Medium <?php } ?>
										<?php if($cInfo['ipriority']=="2"){ ?> High<?php } ?>
                                    </div> 
                                </div> 
								<div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="fname">Status: </label> <?php  if($cInfo['istatus']=="0"){ ?> Open <?php } ?>
										<?php if($cInfo['istatus']=="1"){ ?> Completed <?php } ?>
										<?php if($cInfo['istatus']=="2"){ ?> Awaiting Response <?php } ?>
										<?php if($cInfo['istatus']=="3"){ ?> Response Received <?php } ?>
										<?php if($cInfo['istatus']=="4"){ ?> InProgress <?php } ?>
                                    </div> 
                                </div>  
								<div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="fname">Datetime: </label>  <?php echo $cInfo['tsupdate_date']; ?>
                                    </div> 
                                </div>  
                            </div>  
                            
                            
							<div class="row">
								<div class="col-md-6">
								<?php  
									$map = glob('assets/support/'.$cInfo['vfile_start'].'_*'); 
									foreach ($map as $k){  $ext = '';
										$ext = strtolower(pathinfo($k, PATHINFO_EXTENSION)); 
										if (in_array($ext, $doc)){   ?>
										<a href="<?php echo base_url($k);?>" target="_blank" title="Click To Download" >Download </a>
										<?php }else{?>
										<a href="<?php echo base_url($k);?>" target="_blank" ><img src="<?php echo base_url($k);?>" width="200" style="padding: 10px " ></a>
										<?php }} ?> 
								<hr style="border: 2px solid">
								</div> 
							</div>  
                        </div>  
						<?php if(!empty($CommentRecords)){
							foreach($CommentRecords as $key=>$record){ ?>
							<div class="box-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="ltdesc">Description: </label> <?php echo $record->ltdesc; ?> 
										</div> 
									</div>  
								</div>  									
								<div class="row"> 
									<div class="col-md-3">
										<div class="form-group"> 
											<label for="ltdesc">Comment By: </label> <?php echo $record->created_by; ?>  
										</div> 
									</div>  
									<div class="col-md-3">
										<div class="form-group"> 
											<label for="ltdesc">Datetime: </label> <?php echo $record->tsupdate_date; ?>
										</div>
										 
									</div>  
								</div>  
								<div class="row">
									<div class="col-md-6">
									<?php  
									$map = glob('assets/support/'.$record->vfile_start.'_*'); 
									foreach ($map as $k){  $ext = '';
										$ext = strtolower(pathinfo($k, PATHINFO_EXTENSION)); 
										if (in_array($ext, $doc)){   ?>
										<a href="<?php echo base_url($k);?>" target="_blank" title="Click To Download" >Download </a>
										<?php }else{?>
										<a href="<?php echo base_url($k);?>" target="_blank" ><img src="<?php echo base_url($k);?>" width="200" style="padding: 10px " ></a>
										<?php }} ?>
									<hr style="border: 2px solid">
									</div> 
								</div> 
							</div>
						<?php }} ?>	
						<div class="box-body">  
							<form id="addsupport1" name="addsupport1" action="<?php echo base_url('viewSupport/'.$cInfo['isupport_id']) ?>"  method="post" role="form" >
								<input type="hidden" name="isupport_id" value="<?php echo $cInfo['isupport_id'];?>">
								<input type="hidden" name="vfile_start" value="<?php echo $vfile_start; ?>" >
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="ltdesc">Comment </label>
											<textarea class="form-control required" id="ltdesc" rows="6" name="ltdesc" ></textarea>
										</div>
									</div> 
								</div>  
								<div class="row">  
									<div class="col-md-6">                                
										<div class="form-group">
											<label for="istatus	">Status <span class="required" aria-required="true">*</span></label>
											<select class="form-control required" id="istatus" name="istatus"  data-live-search="true" >   
												<option value="3"   >Response Received </option> 
												<?php if($this->session->userdata['userId']==1){ ?>
													<option value="2"  >Awaiting Response</option>  	
													<option value="4"  >In Progress</option>
												<?php } ?>  
												<option value="1" >Completed</option>
												
											</select><div></div>
										</div>          
									</div> 
								</div>  		
								<div class="box-footer">
									<input type="submit" class="btn btn-primary" value="Submit" />  
								</div>
							</form>
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