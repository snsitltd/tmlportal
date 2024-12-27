<script src="<?php echo base_url('assets/js/print.js'); ?>" type="text/javascript"></script>   
<link rel="stylesheet" href="<?php echo base_url('docs/css/signature-pad.css'); ?>">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"><h1><i class="fa fa-users"></i> Add In Ticket <small>Add / Edit Ticket</small></h1></section>  
    <section class="content"> 
	<?php 
			$error = $this->session->flashdata('error');
			if($error){
		?>
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('error'); ?>                    
		</div>
		<?php } ?>
		<?php  
			$success = $this->session->flashdata('success');
			if($success){
		?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
		<?php } ?>  
	<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:600px"> 
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Conveyance Ticket Info </h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div> 
				  <div class="modal-body"></div> 
				  <div class="TEST"></div> 
				  
				</div>
			</div>
		</div>  
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements --> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Ticket Information</h3>
                    </div>  
					<div id="result"></div> 
                    <?php $this->load->helper("form"); ?>
                    <form id="addTicketsSubmit" name="addTicketsSubmit" action="<?php echo base_url('AddTicketAJAX'); ?>" method="post" role="form" > 
					<input type="hidden" name="LoadID" id="LoadID" value="" >
                        <div class="box-body">
                        <div class="col-md-6">                             
                            <div class="row">  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Conveyance">Conveyance Note No </label>
                                        <input type="text" class="form-control" id="Conveyance"  required="required" value="<?php echo set_value('Conveyance'); ?>" name="Conveyance"> 		
										<button type="button" class="btn btn-sm btn-info SearchConveyance" title="Search Conveyance" style="font-size:14px" ><i class="fa fa-search"></i> <b>Search Conveyance</b> </button>				
                                    </div> 
                                </div> 
								<div class="col-md-2"> 
										<div class="form-group">
                                        <label for="Conveyance">&nbsp; </label>                                                                  
                                        <div class="checkbox"> 
                                        <label> <input type="checkbox" name="is_tml" id="is_tml"  value="1" checked > Is TML Ticket  </label> 
                                        </div> 
                                    </div>
									
                                </div>            
								<div class="col-md-4"> 
										<div class="form-group">
                                        <label  >&nbsp; </label>                                                                  
                                        <div id="ShowOrderNo" style="display:none" >   
											<input type="text" class="form-control" id="OrderNo" placeholder = "OrderNumber" value="<?php echo set_value('OrderNo'); ?>" name="OrderNo"> 		  
                                        </div> 
                                    </div>
									
                                </div>      
                                
                            </div>  
							  
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyID">Select Company <span class="required">*</span></label>
                                        <select class="form-control select_company " id="CompanyID" name="CompanyID" required="required" data-live-search="true"   >
											<option value="0">-- ADD COMPANY --</option>
											<?php foreach ($company_list as $key => $value) { 
											if($value['Status']==1){?>
											<option value="<?php echo $value['CompanyID'] ?>"><?php echo $value['CompanyName'] ?></option>
											<?php }} ?>
                                        </select>   
										<div ></div>	  
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Company Name </label>
										<input type="text" class="form-control" id="CompanyName" value="<?php echo set_value('CompanyName'); ?>" name="CompanyName" maxlength="255"  > 
                                    </div>
                                </div>  
                            </div>  
							<hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="OpportunityID">Opportunity <span class="required">*</span></label> 
                                        <select class="form-control select_opportunity select_wif  " id="OpportunityID" name="OpportunityID" required="required" data-live-search="true"   >
											<option value="0">-- ADD OPPORTUNITY --</option>                                        
                                        </select> <div ></div>
                                    </div>
                                </div>   
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="WIFNumber">WIF FORM No. </label>
                                        <input type="text" class="form-control" id="WIFNumber" value="<?php echo set_value('WIFNumber'); ?>" name="WIFNumber" readonly>  
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1  </label>
                                        <input type="text" class="form-control required Street1" id="Street1" value="<?php echo set_value('Street1'); ?>" name="Street1" maxlength="255">
                                    </div>
                                </div> 
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="County">County  </label>                                        
                                        <select class="form-control required County" id="County" name="County"  data-live-search="true" >
                                            <option value="" >Select County</option>
                                            <?php
                                            if(!empty($county)){
                                                foreach ($county as $rl){ ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == set_value('County')) { ?> selected <?php } ?> ><?php echo $rl->County ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select><div ></div>

                                    </div>
                                </div> 
							</div> 
							<div class="row">  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town  </label>
                                        <input type="text" class="form-control required Town" id="Town" value="<?php echo set_value('Town'); ?>" name="Town">
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code </label>
                                        <input type="text" class="form-control required PostCode" id="PostCode" value="<?php echo set_value('PostCode'); ?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>   
                            </div>  
							<hr>
                            <div class="row">                                
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="DescriptionofMaterial">Description of Material <span class="required">*</span></label>
                                         <select class="form-control DescriptionofMaterial" id="DescriptionofMaterial" name="DescriptionofMaterial" required="required" data-live-search="true"  >
                                        <?php 
                                           echo '<option value="">-- Select material type--</option>';
                                            foreach ($Material as $key => $value) {
                                               echo "<option value='".$value->MaterialID."'>".$value->MaterialName."</option>";
                                            }
                                        ?>                                 
                                        </select><div ></div>
                                    </div>
                                </div>  
                                <div class="col-md-4">
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
                                        <textarea class="form-control" id="ticket_notes" rows="1" name="ticket_notes"></textarea>
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
											<input type="text" class="form-control" id="VatAmount" readonly value="<?php echo set_value('VatAmount'); ?>" name="VatAmount" >
											<input type="hidden" id="Vat" value="<?php echo $content['vat'] ?>" name="Vat" >
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
                                        <label for="Conveyance">LorryType</label>                                                                  
                                        <div class="checkbox"> 
											<label> <input type="radio" class="LorryType" name="LorryType" id="LorryType" value="1" checked > Tipper  </label>
											<label> <input type="radio" class="LorryType" name="LorryType" id="LorryType"  value="2"  > Grab </label>
											<label> <input type="radio" class="LorryType" name="LorryType" id="LorryType"  value="3" > Bin </label>
                                        </div> 
										
                                    </div> 
                                </div>  	
                            </div>
                         <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="LorryNo">Lorry No  <span class="required">*</span></label>
                                       <select class="form-control LorryNo" id="LorryNo" name="LorryNo" required="required"  data-live-search="true" >
                                            <?php  
												echo '<option value="0">-- ADD Lorry --</option>';
                                                foreach ($Lorry as $key => $value) {
                                                  echo  "<option value='".$value->LorryNo."'>".$value->LorryNo." | ".$value->DriverName." | ".$value->RegNumber." | ".$value->Haulier."</option>";
                                                }
                                           ?>                                   
                                        </select><div ></div>
                                    </div> 
                                </div> 
								
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="DriverName">Driver Name</label>
                                        <input type="hidden" id="driverid" name="driverid" >
                                        <input type="text" class="form-control required" id="DriverName" value="<?php echo set_value('DriverName'); ?>" name="DriverName" maxlength="50" >
                                    </div>
                                </div>                          
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="VechicleRegNo">Vechicle Reg No  <span class="required">*</span></label>
                                        <input type="text" class="form-control required VechicleRegNo" id="VechicleRegNo" value="<?php echo set_value('VechicleRegNo'); ?>" name="VechicleRegNo" maxlength="100"  >
										<div id="RegDup" style="color:red"></div>
                                    </div>
                                </div> 
                              
                             
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="HaullerRegNo">Haulier</label>
                                        <input type="text" class="form-control" id="HaullerRegNo" value="<?php echo set_value('HaullerRegNo'); ?>" name="HaullerRegNo" disabled maxlength="100">
                                    </div>
                                </div>                           
                            </div> 
							
							<hr>
                            <div class="row">   
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="GrossWeight">Gross Weight</label>
                                        <input type="number" class="form-control required" id="GrossWeight" onKeyPress="if(this.value.length==5) return false;" value="<?php echo set_value('GrossWeight'); ?>" name="GrossWeight"  maxlength="6"  >
                                    </div>
                                </div> 
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Tare">Tare</label>
                                        <input type="number" class="form-control required" id="Tare" value="<?php echo set_value('Tare'); ?>" name="Tare"  >
                                    </div>
                                </div>                       
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Net">Net</label>
                                        <input type="number" class="form-control" id="Net" value="<?php echo set_value('Net'); ?>" name="Net" readonly>
                                    </div>
                                </div>                              
                            </div> 
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> 
										<button type="button" class="btn btn-primary button fullscreen" >Driver Signature</button> 
										<input type="button" name="submit1" id="submit1" style="float:right;display:none;" class="btn btn-success" value="Submit" />
										
										<input type="submit" name="submit" id="submit" style="float:right;" class="btn btn-primary" value="Submit" />
										<input type="submit" name="hold"  id="hold"  style="float:right;margin-right:5px;" class="btn btn-warning" value="HOLD" />
							 
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
										<input type='hidden' name="driversignature" id="driversignature" required value="" >
										<div id="driverimage"></div>
										
                                    </div>
                                </div>
                                                                  
                            </div> 
                        </div> 
                         </div><!-- /.box-body -->
                        <input type="hidden" name="MaterialPrice" id="MaterialPrice" value=""> 
                        <!-- <div class="box-footer" >
                             <input type="submit" name="submit" style="float:right;" class="btn btn-primary" value="Submit" />
                             <input type="submit" name="hold" style="float:right;margin-right:5px;" class="btn btn-warning" value="HOLD" /> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section> 
</div>  
<script>   
    $(document).ready(function() { 
		
//##############################################  Open Allocate Modal Box ##############################################
		 
		$(document).on("click", ".SearchConveyance", function(){  
				var Conveyance = $('#Conveyance').val(),    
					hitURL1 = baseURL + "SearchConveyanceAJAX",
					currentRow = $(this);   
					
					//alert(Conveyance); 
					
					$.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL1,
					data : { 'Conveyance' : Conveyance   } 
					}).success(function(data){ 
						
						if(data.LoadID>0){
						$('#LoadID').val(data.LoadID); 
						
						var COptions = ' <option value="'+data.CompanyID+'">'+data.CompanyName+'</option>';
						$("select.select_company").html(COptions); 
						$('#CompanyID').selectpicker('refresh');  	
						
						var OOptions = ' <option value="'+data.OpportunityID+'">'+data.OpportunityName+'</option>';
						$("select.select_opportunity").html(OOptions); 
						$('#OpportunityID').selectpicker('refresh');
						$('#SiteAddress').val(data.OpportunityName); 
						$('#CompanyName').val(''); 
						$('#CompanyName').attr('readonly', true);	
						$('#Street1').val(''); 
						$('#Street1').attr('readonly', true);	
						$('#Town').val(''); 
						$('#Town').attr('readonly', true);		
						$('#PostCode').val(''); 
						$('#PostCode').attr('readonly', true);	  
						$('#SiteAddress').attr('readonly', true); 					
						//$('#County').attr('disabled', true); 	
						  
						//var MOptions = ' <option value="'+data.MaterialID+'">'+data.MaterialName+'</option>';
						//$("select.DescriptionofMaterial").html(MOptions); 
						//$('#DescriptionofMaterial').selectpicker('refresh');
						
						$('select[name=DescriptionofMaterial]').val(data.MaterialID); 
						$('#DescriptionofMaterial').selectpicker('refresh');
						 
						 
						$('#SicCode').val(data.SicCode); 
						$('#SicCode').attr('readonly', true);	
						
						$('input[name="LorryType"][value="'+data.LorryType+'"]').prop("checked", true); 
						$('.LorryType').attr('disabled', 'disabled');	 
						$( "#is_tml" ).prop( "checked", true );
						$('#is_tml').attr('disabled', 'disabled');	 
						
						$('.fullscreen').attr('disabled', 'disabled');	 
						$('#submit').hide(); 
						$('#submit1').show(); 
						$('#hold').attr('disabled', 'disabled');
						
						
						var LOptions = ' <option value="'+data.LorryNo+'">'+data.LorryNo+' | '+data.DriverName+' | '+data.VehicleRegNo+' </option>';
						$("select.LorryNo").html(LOptions); 
						$('#LorryNo').selectpicker('refresh');
						
						$('.VechicleRegNo').val(data.VehicleRegNo); 
						$('.VechicleRegNo').attr('readonly', true);	
						
						$('#DriverName').val(data.DriverName); 
						$('#DriverName').attr('readonly', true);	

						$('#HaullerRegNo').val(data.Haulier); 
						$('#HaullerRegNo').attr('readonly', true);	

						$('#Tare').val(data.Tare); 
						$('#Tare').attr('readonly', true);									
						  
						$('#driverimage').html('<img src="'+data.ltsignature+'" height="400px" width="700px">');  
						$('#driversignature').val(data.ltsignature);  
			
						//alert(data)
						//alert(JSON.stringify(data));
						//alert(data.LoadID);
						//$('.modal-body').html(data); 
						//$('#empModal .modal-title').html("Search Conveyance Ticket ");
						//$('#empModal .modal-dialog').width(1000); 
						//$('#empModal').modal('show');  
						
						//alert(JSON.stringify( data ));   
						//console.log(data);   
						
						}else{
							alert("No Conveyance Ticket Found. ");
						}
					}); 
					 
		});
		
		$(document).on("click", "#submit1", function(){  
			//alert("asdfasdf")
			var LoadID = $('#LoadID').val(),        
				GrossWeight = $('#GrossWeight').val(),      
				PaymentType = $('#PaymentType').val(),      
				Amount = $('#Amount').val(),      
				Vat = $('#Vat').val(),      
				VatAmount = $('#VatAmount').val(),      
				TotalAmount = $('#TotalAmount').val(),      
				PaymentRefNo = $('#PaymentRefNo').val(),      
				ticket_notes = $('#ticket_notes').val(),    
				hitURL1 = baseURL + "AddConveyanceTicketAJAX",
				currentRow = $(this);   
				
				if(LoadID > 0 && GrossWeight > 0  ){  
					$('#overlay').fadeIn();
					$.ajax({
						type : "POST",
						dataType : "json",
						url : hitURL1,
						data : { 'LoadID' : LoadID, 'GrossWeight' : GrossWeight , 'Vat' : Vat  , 'VatAmount' : VatAmount  , 
						'TotalAmount' : TotalAmount  , 'PaymentRefNo' : PaymentRefNo  , 'ticket_notes' : ticket_notes } 
						}).success(function(data){ 
							//alert(data)
							//alert(data)
							//alert(JSON.stringify(data));
							
							$('#overlay').fadeOut(); 
							$(".fullscreen").removeAttr('disabled');  
							$('#submit').show(); 
							$('#submit1').hide(); 
							$("#hold").removeAttr('disabled');   
							$('#Tare').attr('readonly', false);	
							$('#DriverName').attr('readonly', false);	
							
							$('input[name="LorryType"][value="1"]').prop("checked", true); 
							$(".LorryType").removeAttr('disabled');   
							$("#is_tml").removeAttr('disabled');    
							
							var options = ' <option value="0">ADD OPPORTUNITY</option>';
							$("select.select_opportunity").html(options); 
							$('#OpportunityID').selectpicker('refresh');
							
							$('#VechicleRegNo').attr('readonly', false); 
							$('#VechicleRegNo').val('');
							$('#CompanyName').attr('readonly', false); 
							$('#CompanyName').val('');
							$('#Street1').attr('readonly', false); 
							$('#Street1').val('');
							$('#Town').attr('readonly', false); 
							$('#Town').val('');
							$('#PostCode').attr('readonly', false); 
							$('#PostCode').val('');
							$('#DriverName').val('');
							$('#Tare').val('');  
							$('#Net').val('');  
							$("#addTicketsSubmit")[0].reset();  								  
							$("#driversignature").val('');				  
							$('#driverimage').html('');  
							$("div.pblock").hide(); 
							$('#CompanyID').selectpicker('refresh'); 
							$('#County').selectpicker('refresh'); 
							$('#OpportunityID').selectpicker('refresh'); 
							$('#DescriptionofMaterial').selectpicker('refresh'); 
							$('#LorryNo').selectpicker('refresh');  
							$.fn.UpdateCompanyDD();
							$.fn.UpdateLorryDD();
							if(data=='Error'){
								  alert("Error In  Submitting Data, Please contact Administrator.");
								  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>'); 
							  }else{ 			
								if(data.length > 20){	 
								  printPDF(data);  
								  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New IN TICKET created successfully.</div>'); 
								}else{ return false; }   
							  }   
					});  
				}else{
					alert("Please Enter GrossWeight.");
				}	
		});
		
		$("#is_tml").click(function() {   
			if($(this).is(":checked")) {  
				$("#ShowOrderNo").hide();  
			} else {
				$("#ShowOrderNo").show();  
			}  
		});
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
<script src="<?php echo base_url(); ?>assets/js/Ticket.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>docs/js/signature_pad.umd.js"></script>
<script src="<?php echo base_url(); ?>docs/js/app.js"></script>