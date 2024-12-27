<link rel="stylesheet" href="<?php echo base_url(); ?>docs/css/signature-pad.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Lorry Management
        <small>Add / Edit Lorry</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->    
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Lorry Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?> 
                    <form role="form" action="<?php echo base_url('AddLorry'); ?>" method="post" data-parsley-validate >
                        <div class="box-body"> 
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="integer">Lorry No <span class="required" aria-required="true">*</span></label>
                                          <input name="LorryNo" id="LorryNo" required type="Number" min="1" max="200" class="form-control col-md-7 col-xs-12"  placeholder="Lorry No" maxlength="3" > 										 
                                    </div> 
                                </div>  
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="RegNumber">Reg Number<span class="required" aria-required="true">*</span></label>
                                         <input name="RegNumber" required="" data-parsley-type="alphanum" data-parsley-length="[2,128]" data-parsley-regsno="RegNumber"  class="form-control col-md-7 col-xs-12"  placeholder="RegNumber" data-parsley-remote-reverse="true">
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="Tare">Tare <span class="required" aria-required="true">*</span></label>
                                        <input id="Tare" class="form-control col-md-7 col-xs-12" name="Tare" placeholder="Tare" required="required" type="text" min="0" max="2000000" step="100" data-parsley-validation-threshold="1" data-parsley-trigger="keyup"     data-parsley-type="number" >
                                    </div> 
                                </div>  
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="Haulier">Haulier   <span class="required" aria-required="true">*</span></label>
										 <select class="form-control" id="Haulier" name="Haulier" data-live-search="true"  required  >
											<option value="">-- SELECT Haulier --</option> 
											<option value="1" > Thames Material Ltd. </option> 
											<option value="0" > Others </option> 
                                        </select>  
                                    </div> 
                                </div> 
                            </div>
							
							<br>
							<div class="row">
							
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckHeight">Truck Height  </label>
                                         <input name="TruckHeight"   class="form-control col-md-7 col-xs-12"  placeholder="Truck Height" >
                                    </div> 
                                </div>  
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckWidth">Truck Width  </label>
                                         <input name="TruckWidth"  class="form-control col-md-7 col-xs-12"  placeholder="Truck Width" >
                                    </div> 
                                </div> 
                            </div>
							<br>
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckLength">Truck Length  </label>
                                         <input name="TruckLength" class="form-control col-md-7 col-xs-12"  placeholder="Truck Length" >
                                    </div> 
                                </div> 
                             
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckWeightTotal">Truck Weight Total  </label>
                                         <input name="TruckWeightTotal"    class="form-control col-md-7 col-xs-12"  placeholder="TruckWeightTotal" >
                                    </div> 
                                </div> 
                            </div>
							<br>
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckMaxSpeed">Truck Max Speed	  </label>
                                         <input name="TruckMaxSpeed"  class="form-control col-md-7 col-xs-12"  placeholder="Truck Max Speed" >
                                    </div> 
                                </div> 
								
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckWeightAxle">Truck Weight Axle  </label>
                                         <input name="TruckWeightAxle"   class="form-control col-md-7 col-xs-12"  placeholder="TruckWeightAxle" >
                                    </div> 
                                </div> 
                            </div>
							<br>
							<div class="row"> 
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="DriverName">Driver Name </label>
                                         <input name="DriverName" type="text"  class="form-control col-md-7 col-xs-12"  placeholder="Driver Name" id="DriverName" >
                                    </div> 
                                </div>  
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="MacAddress">MAC Address</label>
                                         <input name="MacAddress" type="text"  class="form-control col-md-7 col-xs-12"  placeholder="MAC Address" id="MacAddress" ><br>
										 <i> <b>Notes : MacAddress Blank will Consider NonApp User</b></i> 
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
										<input type="hidden" name="driversignature" id="driversignature" value="" >
										<div id="driverimage"></div>
										
                                    </div>
                                </div>
                                                                  
                            </div> 
                        </div>
						
						<div class="box-footer">
                            <input type="submit" class="btn btn-success" value="Submit" />  
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
			$('#driversignature').val(dataURL);  
		});
		$(".fullscreen1").click(function() { 
			$('.my').hide(); 
		});
 
    }); 
</script> 
<script src="<?php echo base_url(); ?>docs/js/signature_pad.umd.js"></script>
<script src="<?php echo base_url(); ?>docs/js/app.js"></script>
<script src="<?php echo base_url('assets/validation/dist/parsley.js')?>"></script>
<script  src="<?php echo base_url(); ?>assets/js/Drivers.js" charset="utf-8"></script>
