<link rel="stylesheet" href="<?php echo base_url(); ?>docs/css/signature-pad.css"> 
<div class="content-wrapper"> 
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Driver Login Management <small> Add / Edit Driver Login</small>
      </h1>
    </section> 
    <section class="content"> 
		 <?php echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div>');  ?> 

        <div class="row"> 
            <div class="col-md-12">   
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Driver Details</h3>
                    </div> 
					<form role="form"  id="frm" name="frm"  action="<?php echo base_url('addDriverLogin'); ?>" method="post" data-parsley-validate >
                        <div class="box-body">
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="DriverName">Driver Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text"   placeholder="Driver Name"  class="form-control required" value="<?php echo set_value('DriverName'); ?>" id="DriverName" name="DriverName" maxlength="128">
                                    </div> 
                                </div> 
                            </div> 
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">UserName <span class="required" aria-required="true">*</span></label>
                                        <input type="text" placeholder="UserName" class="form-control required" value="<?php echo set_value('UserName'); ?>" id="UserName" name="UserName" maxlength="15">
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Email">Email Address </label>
                                        <input type="text" placeholder="Email Address"  class="form-control" value="<?php echo set_value('Email'); ?>" id="Email" name="Email" >
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="MobileNo">Mobile No: <span class="required" aria-required="true">*</span></label>
                                        <input type="text" placeholder="Mobile No"  class="form-control required" value="<?php echo set_value('MobileNo'); ?>" id="MobileNo" name="MobileNo" maxlength="11" minlength="11">
                                    </div> 
                                </div> 
                            </div>
							<br>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> 
										<button type="button" class="btn btn-primary  fullscreen" >Driver Signature</button> 
										<div style="display:none" class="my">
											<div id="signature-pad" class="signature-pad " >
												<div class="signature-pad--body">
												  <canvas></canvas>
												</div>
												<div class="signature-pad--footer">
												  <div class="description">Sign above</div> 
												  <div class="signature-pad--actions">
													<div>
													  <button type="button" id="savepng" class="button btn btn-danger save " data-action="save-png">Save </button> 
													  <button type="button" class="button btn btn-primary clear" data-action="clear">Clear</button>   
													  <button type="button" class="button btn btn-warning fullscreen1" >Close</button>  
													</div> 
												  </div>
												</div>
											</div> 
										</div> 
										<input type="hidden" name="ltsignature" id="ltsignature" value="" >
										<div id="driverimage"></div>
										
                                    </div>
                                </div>
                                                                  
                            </div> 
                        </div>
						<div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit" />  
                        </div> 
                    </form>
                </div>
            </div>
           
        </div>    
    </section>
    
</div> 
<script>   
    $(document).ready(function() {
 
		$(".fullscreen").click(function() { 
			$('.my').show(); 
			$(".signature-pad").width('60%'); 
			$(".signature-pad").height('60%');  
			$(".signature-pad").css({"position":"fixed", "top":"0", "left":"0", "z-index":"9999"});
			resizeCanvas(); 
		});
		$("#savepng").click(function() { 
			$('.my').hide(); 
			var dataURL = signaturePad.toDataURL();  
			$('#driverimage').html('<img src="'+dataURL+'" height="400px" width="700px">');  
			$('#ltsignature').val(dataURL);  
		});
		$(".fullscreen1").click(function() { 
			$('.my').hide(); 
		});
 
    }); 
</script>

  <script src="<?php echo base_url(); ?>docs/js/signature_pad.umd.js"></script>
  <script src="<?php echo base_url(); ?>docs/js/app.js"></script>
<script src="<?= base_url('assets/validation/dist/parsley.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Drivers.js" charset="utf-8"></script>
