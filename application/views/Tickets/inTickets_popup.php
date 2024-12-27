<script src="<?php echo base_url(); ?>assets/css/jquery.signaturepad.css" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/signaturepad/json2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/js/signaturepad/jquery.signaturepad.js" type="text/javascript"></script>
 <style > 
.popup{ 
    display:none;
	position:fixed;
	top: 10%;
	left: 10%; 
	background-color:#eeeeee;
	border:5px solid #68ad0e;
	width:95%;
	height:95%;
	margin-left:-150px;
	margin-top:-65px;   
	z-index: 9002;
}     
  </style>
 
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Add In Ticket  
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
                    </div><!-- /.box-header -->  
	 
					<div id="result"></div> 
					 
                    <?php $this->load->helper("form"); ?>
                    <form id="addTicketsSubmit" action="<?php echo base_url() ?>AddTicketAJAX" method="post" role="form" enctype="multipart/form-data">
                    <!-- <input type="hidden" name="TypeOfTicket" value="IN"> -->
                        <div class="box-body">
                        <div class="col-md-6">                             
                            <!--<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="TicketTitle">Ticket Title <span class="required"  >*</span></label>
                                        <input type="text" class="form-control" id="TicketTitle" value="<?php echo set_value('TicketTitle'); ?>" name="TicketTitle" required maxlength="50">
                                    </div>
                                </div>
                                                                  
                            </div>-->
							 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="date-time">Date & Time <span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                        <input type="text" class="form-control required" id="datepicker" value="<?php echo date('d/m/Y H:i:s A'); ?>" name="TicketDate" maxlength="100">
                                        </div>
                                    </div>
                                   
                                     
                                </div>
                                   
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="Conveyance">Conveyance Note No </label>
                                        <input type="text" class="form-control" id="Conveyance" value="<?php echo set_value('Conveyance'); ?>" name="Conveyance">
                                    </div>
                                </div> 
                                <div class="col-md-3">

                                    <div class="form-group">
                                        <label for="Conveyance">&nbsp; </label>                                                                  
                                        <div class="checkbox">
                                        <input type="hidden" name="is_tml" value="0">
                                        <label> <input type="checkbox" name="is_tml" value="1"> Is TML Ticket  </label>
                                        </div>

                                    </div>
                                </div>                        
                            </div> 
                           <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="CompanyID">Select Company <span class="required">*</span></label>
                                        <select class="form-control" id="CompanyID" name="CompanyID" required="required"  >
                                        <?php 
                                        echo '<option value="">-- Select Company --</option>';
                                        foreach ($company_list as $key => $value) {
                                          echo "<option value='".$value['CompanyID']."'>".$value['CompanyName']."</option>";
                                        } ?>
                                        </select>
                                    </div>
                                </div>  
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="OpportunityID">Opportunity <span class="required">*</span></label>
                                        <select class="form-control select_opportunity" id="OpportunityID" name="OpportunityID" required="required"  >
                                        <option value="">-- Select Opportunity --</option>                                        
                                        </select>
                                    </div>
                                </div>    
                            </div> 
                            <div class="row">  
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="SiteAddress">Site Address</label>
                                        <input type="text" class="form-control" id="SiteAddress" value="<?php echo set_value('SiteAddress'); ?>" name="SiteAddress" maxlength="100" disabled>
                                    </div>
                                </div>                                   
                            </div>  
                            <div class="row">   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="HaullerRegNo">Haulier Reg. No</label>
                                        <input type="text" class="form-control" id="HaullerRegNo" value="<?php echo set_value('HaullerRegNo'); ?>" name="HaullerRegNo" maxlength="100">
                                    </div>
                                </div> 
                                                               
                            </div> 

                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="DescriptionofMaterial">Description of Material <span class="required">*</span></label>
                                        <!-- <input type="test" class="form-control" id="DescriptionofMaterial" value="<?php echo set_value('DescriptionofMaterial'); ?>" name="DescriptionofMaterial" maxlength="100"> -->
                                        <select class="form-control" id="DescriptionofMaterial" name="DescriptionofMaterial" required="required"  >
                                        <?php 
                                           echo '<option value="">-- Select material type--</option>';
                                            foreach ($Material as $key => $value) {
                                               echo "<option value='".$value->MaterialID."'>".$value->MaterialName."</option>";
                                            }
                                        ?>                                 
                                        </select>
                                    </div>
                                </div> 
                                                               
                            </div> 



                           <!--  <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="MaterialType">IF Material is other type it here</label>
                                        <input type="text" class="form-control" id="MaterialType" value="<?php echo set_value('MaterialType'); ?>" name="MaterialType" maxlength="100">
                                    </div>
                                </div> 
                                                               
                            </div>  -->

                             <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="SicCode">SIC Code <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="SicCode" value="<?php echo set_value('SicCode'); ?>" name="SicCode" maxlength="100" disabled>
                                    </div>
                                </div> 
                                                               
                            </div>
                            
                             <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="notes_id" rows="5" name="ticket_notes"></textarea>
                                    </div>
                                </div> 
                                                               
                            </div>
							
							<div class="row">        
                                <div class="col-md-12">
									<div class="form-group">
                                        <label for="Conveyance">Payment</label>                                                                  
                                        <div class="checkbox"> 
											<label> <input type="radio" name="PaymentType" id="PaymentType" value="0" checked > Credit  </label>
											<label> <input type="radio" name="PaymentType" id="PaymentType"  value="1" > Cash </label>
											<label> <input type="radio" name="PaymentType" id="PaymentType"  value="2" > Card </label>
                                        </div> 
										
                                    </div> 
                                </div>  
								<div class="pblock" style="display: none;"> 
									<div class="col-md-4">
										<div class="form-group">
											<label for="Amount">Amount</label>
											<input type="text" class="form-control required" id="Amount"  required="required"  value="<?php echo set_value('Amount'); ?>" name="Amount" maxlength="10">
										</div>
									</div> 
									<div class="col-md-4">
										<div class="form-group">
											<label for="Vat">VAT (20%)</label>
											<input type="text" class="form-control" id="Vat" readonly value="<?php echo $content['vat'] ?>" name="Vat" >
										</div>
									</div> 
									<div class="col-md-4">
										<div class="form-group">
											<label for="TotalAmount">Total Amount</label>
											<input type="text" class="form-control" id="TotalAmount" readonly  value="<?php echo set_value('TotalAmount'); ?>" name="TotalAmount" maxlength="10">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="PaymentRefNo">Payment Ref No (Only for Card Payment)</label>
											<input type="text" class="form-control" id="PaymentRefNo"  required="required"  value="<?php echo set_value('PaymentRefNo'); ?>" name="PaymentRefNo" >
										</div>
									</div>
								</div>		
                            </div>  

                       
                        </div>

                        <div class="col-md-6"> 


                         <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="LorryNo">Lorry No  <span class="required">*</span></label>
                                       <select class="form-control" id="LorryNo" name="LorryNo" required="required"  >
                                            <?php 

                                                echo '<option value="">-- Select Lorry No --</option>';
												echo '<option value="0">-- ADD Lorry --</option>';
                                                foreach ($Lorry as $key => $value) {
                                                  echo  "<option value='".$value->LorryNo."'>".$value->LorryNo." | ".$value->DriverName." | ".$value->RegNumber."</option>";
                                                }
                                           ?>                                   
                                        </select>
                                    </div>
                                    
                                </div>
                               
                            </div>
                         
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="VechicleRegNo">Vechicle Reg No  <span class="required">*</span></label>
                                        <input type="text" class="form-control required" id="VechicleRegNo" value="<?php echo set_value('VechicleRegNo'); ?>" name="VechicleRegNo" maxlength="100" disabled>
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="DriverName">Driver Name</label>
                                        <input type="hidden"   id="driverid" name="driverid" >
                                        <input type="text" class="form-control required" id="DriverName" value="<?php echo set_value('DriverName'); ?>" name="DriverName" maxlength="50" disabled>
                                    </div>
                                </div>
                                                                  
                            </div>
							
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
									
									<a class="trigger_popup_fricc">Click here to show the popup</a>
										
										<div class="popup">
										<span class="helper"></span>
										<div>
											<div class="popupCloseButton">&times;</div>	
											<div class="sigPad " > 
												
												<div class="sig sigWrapper" style="height:auto;">
													<div class="typed"></div>
													<canvas width="1500" height="500"  style="border:1px solid #000000" ></canvas>
													<input type="hidden" name="output" class="output" >
												</div>
												<ul class="sigNav"> 
													<li class="clearButton"><a href="#clear">Clear</a></li>
												</ul>
											</div> 
										</div>
										</div>	
										
										
                                    </div>
                                </div>
                                                                  
                            </div>


                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="GrossWeight">Gross Weight</label>
                                        <input type="number" class="form-control" id="GrossWeight" value="<?php echo set_value('GrossWeight'); ?>" name="GrossWeight" >
                                    </div>
                                </div>
                                   
                            </div> 

                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Tare">Tare</label>
                                        <input type="number" class="form-control required" id="Tare" value="<?php echo set_value('Tare'); ?>" name="Tare" disabled>
                                    </div>
                                </div> 
                                                               
                            </div> 

                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Net">Net</label>
                                        <input type="number" class="form-control" id="Net" value="<?php echo set_value('Net'); ?>" name="Net" disabled>
                                    </div>
                                </div> 
                                                               
                            </div>  
                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="SourceofMaterial">Source of Material</label>
                                        <input type="text" class="form-control" id="SourceofMaterial" value="<?php echo set_value('SourceofMaterial'); ?>" name="SourceofMaterial" maxlength="100">
                                    </div>
                                </div> 
                                                               
                            </div>  
                             <div class="row">    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Website">Report Number</label>
                                        <input type="text" class="form-control" id="ReportNumber" value="<?php echo set_value('ReportNumber'); ?>" name="ReportNumber" maxlength="100">
                                    </div>
                                </div>                             
                            </div> 
							
                        </div> 
                         </div><!-- /.box-body -->
                        <input type="hidden" name="MaterialPrice" id="MaterialPrice" value=""> 
                        <div class="box-footer">
                            <input type="submit" name="submit" class="btn btn-primary addsubmit" value="Submit" />
                             <input type="submit" name="hold" class="btn btn-primary" value="HOLD" />
                        </div>
                    </form>
                </div>
            </div>
           
        </div>    
    </section>
    
</div>
<script> 
   

    $(document).ready(function() {
			$(".trigger_popup_fricc").click(function(){
			   $('.popup').show();
			}); 
			$('.popupCloseButton').click(function(){
				$('.popup').hide();
			});
      $('.sigPad').signaturePad({drawOnly:true, 
		drawBezierCurves:true,
		lineTop:200 });
	
	jQuery(document).on("click", ".cls-genrate-ticket", function(){
 
		
	});	
		
		
    });
  </script>
<script src="<?php echo base_url(); ?>assets/js/Ticket.js" type="text/javascript"></script>
