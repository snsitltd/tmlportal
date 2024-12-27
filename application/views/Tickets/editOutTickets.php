<script src="<?php echo base_url('assets/js/print.js'); ?>" type="text/javascript"></script>   
<link rel="stylesheet" href="<?php echo base_url('docs/css/signature-pad.css'); ?>">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Edit Out Ticket
        <small>Add / Edit Ticket</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Ticket Information</h3>
                    </div> 
					<div id="result"></div> 
                    <?php
					$this->load->helper('form');
					$error = $this->session->flashdata('error');
					if($error)
					{
						?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $error; ?>                    
						</div>
					<?php }
					$success = $this->session->flashdata('success');
					if($success)
					{
						?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $success; ?>                    
						</div>
					<?php } ?>
        
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="EditOutTicket"   name="EditOutTicket"   action="<?php echo base_url("EditOutTicketAJAX"); ?>"  method="post"  > 
					<input type="hidden" name="is_hold" id="is_hold" value="<?php echo $tickets['is_hold'];  ?>">
					<input type="hidden" name="LoadID" id="LoadID" value="<?php echo $tickets['LoadID'];  ?>">
                        <div class="box-body">
                        <div class="col-md-6">            
                            <div class="row">  
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Conveyance">Conveyance Note No </label>
                                        <input type="text" class="form-control" id="Conveyance" value="<?php echo $tickets['Conveyance']; ?>" name="Conveyance">
                                    </div>
                                </div>

                                 <div class="col-md-2"> 
										<div class="form-group">
                                        <label for="Conveyance">&nbsp; </label>                                                                  
                                        <div class="checkbox"> 
                                        <label> <input type="checkbox" name="is_tml" id="is_tml"  value="1" <?php if($tickets['is_tml']==1) echo 'checked';?> > Is TML Ticket  </label> 
                                        </div> 
                                    </div>
									
                                </div>  
								<div class="col-md-4"> 
										<div class="form-group">
                                        <label  >&nbsp; </label>                                                                  
                                        <div id="ShowOrderNo" <?php if($tickets['is_tml']==1) { ?> style="display:none"  <?php  }else{  ?>  <?php } ?> >   
											<input type="text" class="form-control" id="OrderNo" placeholder = "OrderNumber" value="<?php echo $tickets['OrderNo']; ?>" name="OrderNo"> 		  
                                        </div> 
                                    </div>
									
                                </div>  

                                                                  
                            </div>
							<div class="row">                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Booking Notes : </label> 
										<?php if($BookingNotes['Notes']){ ?> <?php echo $BookingNotes['Notes']; ?> <?php }else{ echo 'NONE';} ?>
                                    </div>
                                </div>                               
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="CompanyID">Select Company <span class="required">*</span></label>
                                        <select class="form-control" id="CompanyID" name="CompanyID" required="required" data-live-search="true"  aria-required="true">
                                         <?php 
                                        if($tickets['LoadID']>0){ 
											echo '';
											foreach ($company_list as $key => $value) {  
												if($value['CompanyID']==$tickets['CompanyID']){
													echo "<option value='".$value['CompanyID']."' selected >".$value['CompanyName']."</option>";
												}  
											} 
											
										}else{
											
											echo '<option value="">-- Select Company --</option>';
											foreach ($company_list as $key => $value) { 
												$selected= "";
												if($value['CompanyID']== $tickets['CompanyID']){
													//$selected= "Selected"; 
													echo "<option value='".$value['CompanyID']."' selected >".$value['CompanyName']."</option>";
												}else{
													if($value['Status']==1){
														echo "<option value='".$value['CompanyID']."'   >".$value['CompanyName']."</option>";
													} 	
												}  
											} 
										}
										
										
										?>  
                                        </select><div ></div>
                                    </div>
                                </div>  
                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="OpportunityID">Opportunity <span class="required">*</span></label>
                                        <select class="form-control select_opportunity" id="OpportunityID" name="OpportunityID" data-live-search="true"  required="required" aria-required="true">
                                        <?php 
										 if($tickets['LoadID']>0){  
											foreach ($opprtunities as $key => $value) { 
												if($value->OpportunityID==$tickets['OpportunityID']){
													echo "<option value='".$value->OpportunityID."' selected >".$value->OpportunityName."</option>";
												} 
											} 
										 }else{
											echo '<option value="">-- Select Opportunity --</option>';
											foreach ($opprtunities as $key => $value) {
												$selected= "";
												if($value->OpportunityID==$tickets['OpportunityID']){
													//$selected= "Selected";
													echo "<option value='".$value->OpportunityID."' Selected>".$value->OpportunityName."</option>";
												}else{
													if($value->Status==1){
														echo "<option value='".$value->OpportunityID."'  >".$value->OpportunityName."</option>";
													} 	
												}  
												//echo "<option value='".$value->OpportunityID."' ".$selected.">".$value->OpportunityName."</option>";
											} 
										 }?>
                                        </select><div ></div>
                                    </div>
                                </div>   	
                                   
                            </div>                           
                           

                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="SiteAddress">Delivery Site</label>
                                        <input type="text" class="form-control" id="SiteAddress" value="<?php  if($tickets['OpportunityID']!=""){ echo $SiteAddress->OpportunityName; } ?>" name="SiteAddress" maxlength="100" readonly> 
                                    </div>
                                </div>
                                   
                            </div>                            
							<?php $status = 1; //if($tickets['MaterialID'] > 416){  $status = 1; }else{ $status = 0; } //echo $status;  ?> 
							<div class="row">                               

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="DescriptionofMaterial">Description of Material: <span class="required">*</span></label>
                                        <!-- <input type="test" class="form-control" id="DescriptionofMaterial" value="<?php echo set_value('DescriptionofMaterial'); ?>" name="DescriptionofMaterial" maxlength="100"> -->
                                        <select class="form-control" id="DescriptionofMaterial" name="DescriptionofMaterial"  data-live-search="true" required="required" aria-required="true">
                                        <?php 
                                           echo '<option value="">-- Select material type--</option>';
                                            foreach ($Material as $key => $value) {
                                                $selected= "";
                                                if($value->MaterialID==$tickets['MaterialID']){
                                                    $selected= "Selected";
                                                }
												if($value->Status == $status){
													echo "<option value='".$value->MaterialID."' ".$selected.">".$value->MaterialName."</option>";
												}	
                                            }
                                        ?>                                    
                                        </select><div ></div>
                                    </div>
                                </div> 
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="SicCode">SIC Code <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="SicCode" value="<?php echo $tickets['SicCode']; ?>" name="SicCode" maxlength="100" disabled>
                                    </div>
                                </div> 	
                                                               
                            </div> 
							
							<div class="row">        
                                <div class="col-md-12">
									<div class="form-group">
                                        <label for="Conveyance">Payment</label>                                                                  
                                        <div class="checkbox"> 
											<label> <input type="radio" name="PaymentType" id="PaymentType" value="0" <?php if($tickets['PaymentType']==0){ ?> checked <?php } ?> > Credit  </label>
											<label> <input type="radio" name="PaymentType" id="PaymentType"  value="1" <?php if($tickets['PaymentType']==1){ ?> checked <?php } ?>  > Cash </label>
											<label> <input type="radio" name="PaymentType" id="PaymentType"  value="2" <?php if($tickets['PaymentType']==2){ ?> checked <?php } ?>  > Card </label>
                                        </div> 
										
                                    </div> 
                                </div>  	
                            </div> 
							<div class="row">    
								<div class="pblock" <?php if($tickets['PaymentType']==0){ ?> style="display: none;" <?php } ?> > 
									<div class="col-md-4">
										<div class="form-group">
											<label for="Amount">Amount</label>
											<input type="text" class="form-control" id="Amount" value="<?php echo $tickets['Amount']; ?>"  name="Amount" maxlength="10">
										</div>
									</div> 
									<div class="col-md-4">
										<div class="form-group">
											<label for="Vat">VAT (20%)</label>
											<input type="text" class="form-control" id="VatAmount" readonly value="<?php echo $tickets['VatAmount']; ?>" name="VatAmount" >
											<input type="hidden" id="Vat" value="<?php echo $tickets['Vat']; ?>" name="Vat" >
										</div> 
									</div> 
									<div class="col-md-4">
										<div class="form-group">
											<label for="TotalAmount">Total Amount</label>
											<input type="text" class="form-control" id="TotalAmount" readonly  value="<?php echo $tickets['TotalAmount']; ?>"  name="TotalAmount" maxlength="10">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="PaymentRefNo">Payment Ref No (Only for Card Payment)</label>
											<input type="text" class="form-control" id="PaymentRefNo" value="<?php echo $tickets['PaymentRefNo']; ?>"  name="PaymentRefNo" >
										</div>
									</div>
								</div>		
                            </div>
  
                        </div>

                        <div class="col-md-6"> 
<?php 

$LorryType = 0; 
if($tickets['LorryType']!=0){ $LorryType = $tickets['LorryType']; }else{  $LorryType = $tickets['LorryTypeT']; }  

?>
							<div class="row">        
                                <div class="col-md-12">
									<div class="form-group">
                                        <label for="Conveyance">LorryType</label>                                                                  
                                        <div class="checkbox"> 
											<label> <input type="radio" name="LorryType" id="LorryType" value="1"  <?php if($LorryType==1){ ?> checked <?php } ?> > Tipper  </label>
											<label> <input type="radio" name="LorryType" id="LorryType"  value="2"  <?php if($LorryType==2){ ?> checked <?php } ?>> Grab </label>
											<label> <input type="radio" name="LorryType" id="LorryType"  value="3"  <?php if($LorryType==3){ ?> checked <?php } ?> > Bin </label>
                                        </div> 
										
                                    </div> 
                                </div>  	
                            </div>
                         <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="LorryNo">Lorry No  <span class="required">*</span></label>
                                       <select class="form-control" id="LorryNo" name="LorryNo" aria-required="true" data-live-search="true" >
                                           <?php  
												echo '<option value="0">-- ADD Lorry --</option>';
                                                foreach ($Lorry as $key => $value) {
                                                  $selected= "";
                                                  if($tickets['driver_id']==$value->LorryNo){
                                                     $selected= "Selected";
                                                  }
                                                  echo  "<option value='".$value->LorryNo."'  ".$selected." >".$value->LorryNo." | ".$value->DriverName." | ".$value->RegNumber." | ".$value->Haulier."</option>";
                                                }
                                           ?>                                    
                                        </select><div ></div>
                                    </div>
                                    
                                </div>
 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="DriverName">Driver Name</label>
                                        <input type="text" class="form-control required" id="DriverName" value="<?php echo $tickets['DriverName']; ?>" name="DriverName" maxlength="50"  >
                                          <input type="hidden"   id="driverid"  value="<?php echo $tickets['driver_id']; ?>" name="driverid" >
                                    </div>
                                </div>
 
 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="VechicleRegNo">Vechicle Reg No  <span class="required">*</span></label>
										<input type="hidden" id="RegNo" value="<?php echo $tickets['RegNumber']; ?>" name="RegNo"   >
                                        <input type="text" class="form-control required EditVechicleRegNo" id="VechicleRegNo" value="<?php echo $tickets['RegNumber']; ?>" name="VechicleRegNo" maxlength="100" readonly>
										<div id="RegDup" style="color:red"></div>
                                    </div>
                                </div>
                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="HaullerRegNo">Haulier</label>
                                        <input type="text" class="form-control" id="HaullerRegNo" value="<?php echo $tickets['Hulller']; ?>" name="HaullerRegNo" maxlength="100" readonly>
                                    </div>
                                </div> 
                                                               
                            </div> 

                           
                            <div class="row">                               

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="GrossWeight">Gross Weight</label>
                                        <input type="text" class="form-control required" id="GrossWeight"  onKeyPress="if(this.value.length==6) return false;"  
										value="<?php if($tickets['GrossWeight']!=0){ echo round($tickets['GrossWeight']); }else{ echo "";} ?>"  name="GrossWeight" maxlength="6"  >
                                    </div>
                                </div>
                                   
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Tare">Tare</label>
                                        <input type="number" class="form-control" id="Tare" value="<?php echo $tickets['Tare']; ?>" name="Tare"  >
                                    </div>
                                </div> 
                                                               
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Net">Net</label>
                                        <input type="number" class="form-control" id="Net" value="<?php echo $tickets['Net']; ?>" name="Net" readonly>
                                    </div>
                                </div> 
                                                               
                            </div> 
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> 
										<button type="button" class="btn btn-primary fullscreen" >Driver Signature</button> 
										<input type="submit" name="submit" class="btn btn-primary" value="Submit" style="float:right; "  /> 
							<button onclick="location.href='<?php echo  base_url('All-Tickets')?>';" style="float:right;margin-right:5px;"  type="button" class="btn btn-warning">CANCEL</button>
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
										
										<input type="hidden" name="driversignature"  class="required"  id="driversignature" value="<?php echo $Dsignature; ?>" >
										<div id="driverimage"><?php if($Dsignature!=""){ ?> <img src="<?php echo $Dsignature; ?>" height="400px" width="700px"> <?php } ?></div>
										
                                    </div>
                                </div>
                                                                  
                            </div> 
							  
                        </div>

                         </div><!-- /.box-body -->
                        <input type="hidden" name="MaterialPrice" id="MaterialPrice" value="<?php echo $tickets['MaterialPrice']; ?>">
                        <input type="hidden" name="TicketType" id="TicketType" value="Out">
                        <input type="hidden" name="TicketNo" id="TicketNo" value="<?php echo $tickets['TicketNo']; ?>">
                        <!-- <div class="box-footer">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit" style="float:right; "  /> 
							<button onclick="location.href='<?php echo  base_url('All-Tickets')?>';" style="float:right;margin-right:5px;"  type="button" class="btn btn-warning">CANCEL</button>
                        </div> -->
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
	$("#is_tml").click(function() {   
			if($(this).is(":checked")) {  
				$("#ShowOrderNo").hide();  
			} else {
				$("#ShowOrderNo").show();  
			}  
		});

});
</script>
<script src="<?php echo base_url(); ?>assets/js/Ticket.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>docs/js/signature_pad.umd.js"></script>
<script src="<?php echo base_url(); ?>docs/js/app.js"></script>