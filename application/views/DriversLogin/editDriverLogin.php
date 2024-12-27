<link rel="stylesheet" href="<?php echo base_url(); ?>docs/css/signature-pad.css">
<div class="content-wrapper"> 
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Driver Management  <small>Edit Driver Login </small> </h1>
    </section>
     <section class="content">
	 <?php echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div>');  ?> 
		 <div class="row"> 
            <div class="col-md-6"> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Driver Login </h3>
                    </div> 
					
                    <form role="form"  id="frm" name="frm"  action="<?=base_url('editDriverLogin/'.$driver['LorryNo'])?>" method="post"  >
                        <input type="hidden" name="LorryNo" value="<?php echo $driver['LorryNo'];?>"> 
                        <div class="box-body">
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Driver Name  </label> : <?php echo $driver['DriverName']; ?> 
                                    </div> 
                                </div>  
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Mobile No  </label> : <?php if($driver['MobileNo']!=0){ echo $driver['MobileNo']; }else{ echo "NONE"; } ?> 
                                    </div> 
                                </div>  
                            </div>
							<div class="row"> 
								<div class="col-md-6">
									<div class="form-group">
										<label for="MobileNo">Update Mobile No. <span class="required" aria-required="true">*</span></label>
										<input type="text" class="form-control" id="MobileNo" placeholder="Enter Mobile No. " name="MobileNo"  maxlength="11" minlength="11" required>
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
		 <div class="row">  
			<div class="col-md-6"> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Password </h3>
                    </div>  
					<form role="form" id="frm1" name="frm1" action="<?=base_url('editDriverLogin/'.$driver['LorryNo'])?>" method="post"  >
                        <input type="hidden" name="LorryNo" value="<?php echo $driver['LorryNo'];?>"> 
                        <div class="box-body"> 
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="password">Password <span class="required" aria-required="true">*</span></label>
										<input type="password" class="form-control" id="password" placeholder="Password" name="password" maxlength="20" >
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="cpassword">Confirm Password <span class="required" aria-required="true">*</span></label>
										<input type="password" class="form-control" id="cpassword" placeholder="Confirm Password" name="cpassword" maxlength="20">
									</div>
								</div>
							</div>
                        </div>
						<div class="box-footer">
                            <input type="submit" class="btn btn-primary" name="submit1" value="Submit" />  
                        </div> 
                    </form> 
                </div>
            </div> 
        </div>      
    </section> 
</div>   
<script src="<?php echo base_url(); ?>docs/js/app.js"></script>
<script src="<?= base_url('assets/validation/dist/parsley.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Drivers.js" charset="utf-8"></script>