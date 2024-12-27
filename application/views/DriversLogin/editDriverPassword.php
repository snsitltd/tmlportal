<div class="content-wrapper"> 
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Drivers Login Management  <small>Edit Driver Password </small> </h1>
    </section>
     <section class="content">
	 <?php echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>', '</div>');  ?>  	
		 <div class="row">  
			<div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Password </h3>
                    </div>  
					<form role="form" id="frm1" name="frm1" action="<?=base_url('editDriverPassword/'.$driver['DriverID'])?>" method="post"  >
                        <input type="hidden" name="DriverID" value="<?php echo $driver['DriverID'];?>"> 
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
                            <input type="submit" class="btn btn-primary" name="submit" value="Submit" />  
                        </div> 
                    </form> 
                </div>
            </div>  
        </div>      
    </section> 
</div>    
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Drivers.js" charset="utf-8"></script>