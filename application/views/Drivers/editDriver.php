<link rel="stylesheet" href="<?php echo base_url(); ?>docs/css/signature-pad.css">
<div class="content-wrapper"> 
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Lorry Management  <small>Add / Edit Lorry</small> </h1>
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
                    <form role="form" action="<?=base_url('editdriversubmit')?>" method="post" data-parsley-validate >
                        <input type="hidden" name="LorryNo" value="<?php echo $driver['LorryNo'];?>">
						<input type="hidden" name="AppUser" value="<?php echo $driver['AppUser'];?>">
					
                        <div class="box-body">
							<!-- <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Driver Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" placeholder="Driver Name"  class="form-control required" value="<?php //echo $driver['DriverName']; ?>" id="DriverName" name="DriverName" maxlength="128">
                                    </div> 
                                </div> 
                            </div> -->
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group"> 
                                        <label for="DriverID">Current  DRIVER </label>
                                        <select class="form-control" id="DriverID" name="DriverID" disabled data-live-search="true"   >
											<option value="0">-- SELECT DRIVER --</option>
											<?php foreach ($driver_login_list as $key => $value) { ?>
											<option value="<?php echo $value['DriverID'] ?>" <?php if($driver['DriverID']==$value['DriverID']){ ?> selected="selected" <?php } ?> ><?php echo $value['DriverName'] ?></option>
											<?php } ?>
                                        </select>   
										<div ></div>	  
                                    </div>
                                </div> 
                            </div>
							
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="RegNumber">Reg Number<span class="required" aria-required="true">*</span></label>
                                         <input name="RegNumber" value="<?php echo $driver['RegNumber']; ?>"   class="form-control col-md-7 col-xs-12"  placeholder="RegNumber" >
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Tare">Tare <span class="required" aria-required="true">*</span></label>
                                        <input id="Tare" class="form-control col-md-7 col-xs-12" name="Tare" placeholder="Tare" required="required" type="text" min="0" max="2000000" step="100"   value="<?php echo $driver['Tare']; ?>"  data-parsley-validation-threshold="1" data-parsley-trigger="keyup" data-parsley-type="number" >
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Haulier">Haulier <span class="required" aria-required="true">*</span></label>
                                        <input id="Haulier" class="form-control col-md-7 col-xs-12" 
                                          name="Haulier" placeholder="Haulier" required="required" minlength="2" maxlength="128"  value="<?php echo $driver['Haulier']; ?>"  type="text">
                                    </div> 
                                </div> 
                            </div>  
							<br>
							<div class="row">
							
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckHeight">Truck Height  </label>
                                         <input name="TruckHeight" value="<?php echo $driver['TruckHeight']; ?>"   class="form-control col-md-7 col-xs-12"  placeholder="Truck Height" >
                                    </div> 
                                </div>  
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckWidth">Truck Width  </label>
                                         <input name="TruckWidth" value="<?php echo $driver['TruckWidth']; ?>"   class="form-control col-md-7 col-xs-12"  placeholder="Truck Width" >
                                    </div> 
                                </div> 
                            </div>
							<br>
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckLength">Truck Length  </label>
                                         <input name="TruckLength" value="<?php echo $driver['TruckLength']; ?>" class="form-control col-md-7 col-xs-12"  placeholder="Truck Length" >
                                    </div> 
                                </div> 
                             
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckWeightTotal">Truck Weight Total  </label>
                                         <input name="TruckWeightTotal" value="<?php echo $driver['TruckWeightTotal']; ?>"   class="form-control col-md-7 col-xs-12"  placeholder="TruckWeightTotal" >
                                    </div> 
                                </div> 
                            </div>
							<br>
							<div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckMaxSpeed">Truck Max Speed	  </label>
                                         <input name="TruckMaxSpeed" value="<?php echo $driver['TruckMaxSpeed']; ?>"   class="form-control col-md-7 col-xs-12"  placeholder="Truck Max Speed" >
                                    </div> 
                                </div> 
                             
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="TruckWeightAxle">Truck Weight Axle  </label>
                                         <input name="TruckWeightAxle" value="<?php echo $driver['TruckWeightAxle']; ?>"   class="form-control col-md-7 col-xs-12"  placeholder="TruckWeightAxle" >
                                    </div> 
                                </div> 
                            </div>
							
							
							<br>
							<!-- <div class="row">
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
										<input type="hidden" name="ltsignature" id="ltsignature" value="<?php echo $driver['ltsignature']; ?>" >
										<div id="driverimage"><?php if($driver['Signature']!=""){ ?>
										<img src="<?php echo base_url('/assets/DriverSignature/'.$driver['Signature']); ?>" height="400px" width="700px"><?php } ?></div>  
                                    </div>
                                </div>
                                                                  
                            </div>   -->
                        </div>
						<div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />  
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
<script src="<?php echo base_url('assets/validation/dist/parsley.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Drivers.js" charset="utf-8"></script>