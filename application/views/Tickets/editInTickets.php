<script>

	//$(document).ready(function() { 		 
	//		$('#TicketDate').datetimepicker( );
	//});  

</script>

<script src="<?php echo base_url('assets/js/print.js'); ?>" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo base_url('docs/css/signature-pad.css'); ?>">
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<i class="fa fa-users"></i> Edit In Ticket
			<small>Add / Edit Ticket</small>
		</h1>
	</section>
	<section class="content">
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

					</div><!-- /.box-header -->
					<!-- form start -->
					<?php
					$this->load->helper('form');
					$error = $this->session->flashdata('error');
					if ($error) {
						?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $error; ?>
						</div>
					<?php }
					$success = $this->session->flashdata('success');
					if ($success) {
						?>
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<?php echo $success; ?>
						</div>
					<?php } ?>
					<?php $this->load->helper("form"); ?>
					<form role="form" id="EditInTicket" name="EditInTicket"
						action="<?php echo base_url("EditTicketAJAX"); ?>" method="post">
						<input type="hidden" name="LoadID" id="LoadID" value="">
						<div class="box-body">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="Conveyance">Conveyance Note No </label>
											<input type="text" class="form-control" id="Conveyance" required="required"
												value="<?php echo $tickets['Conveyance']; ?>" name="Conveyance">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="TicketDate">Date Time</label>
											<input type="datetime-local" class="form-control" id="TicketDate"
												name="TicketDate" value="<?php echo $tickets['TicketDate']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>&nbsp; </label>
											<div class="checkbox" style="margin-top:0px;">
												<?php if ($tickets['LoadID'] == 0) { ?>
													<button type="button" class="btn btn-sm btn-warning LinkConveyance"
														data-TicketNo="<?php echo $tickets['TicketNo']; ?>"
														title="Link Conveyance" style="font-size:14px"><i
															class="fa fa-search"></i> <b>Link Conveyance</b> </button>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="Conveyance">&nbsp; </label>
											<div class="checkbox">
												<label> <input type="checkbox" name="is_tml" id="is_tml" value="1" <?php if ($tickets['is_tml'] == 1)
													echo 'checked'; ?>> Is TML Ticket
												</label>
											</div>
										</div>

									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>&nbsp; </label>
											<div id="ShowOrderNo" <?php if ($tickets['is_tml'] == 1) { ?>
													style="display:none" <?php } else { ?> <?php } ?>>
												<input type="text" class="form-control" id="OrderNo"
													placeholder="OrderNumber" value="<?php echo $tickets['OrderNo']; ?>"
													name="OrderNo">
											</div>
										</div>

									</div>

									<!-- <div class="col-md-12"> 
									<div class="form-group">
										<label for="Conveyance">&nbsp; </label>                                                                  
										<div class="checkbox">
										<input type="hidden" name="is_tml" value="0">
										<label> <input type="checkbox" name="is_tml" value="1" <?php //if($tickets['is_tml']==1) echo 'checked'; ?> > Is TML Ticket  </label>
										</div> 
									</div>
								</div> -->
								</div>

								<!--<div class="row">   
								<div class="col-md-12"> 
									<div class="form-group">
										<label for="date-time">Ticket DateTime </label>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control required" id="TicketDate" value="<?php //echo $tickets['TicketDate'] ?>" name="TicketDate" maxlength="21">
										</div>
									</div> 
								</div>                         
							</div>-->

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="CompanyID">Select Company <span
													class="required">*</span></label>
											<select class="form-control" id="CompanyID" name="CompanyID"
												data-live-search="true" required="required" aria-required="true">
												<?php
												if ($tickets['LoadID'] > 0) {
													echo '';
													foreach ($company_list as $key => $value) {
														if ($value['CompanyID'] == $tickets['CompanyID']) {
															echo "<option value='" . $value['CompanyID'] . "' selected >" . $value['CompanyName'] . "</option>";
														}
													}

												} else {

													echo '<option value="">-- Select Company --</option>';
													foreach ($company_list as $key => $value) {
														$selected = "";
														if ($value['CompanyID'] == $tickets['CompanyID']) {
															$selected = "Selected";
														}
														echo "<option value='" . $value['CompanyID'] . "' " . $selected . " >" . $value['CompanyName'] . "</option>";
													}
												}


												?>
											</select>
											<div></div>
										</div>
									</div>
								</div>



								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="OpportunityID">Opportunity <span
													class="required">*</span></label>
											<select class="form-control select_opportunity select_wif"
												id="OpportunityID" data-live-search="true" name="OpportunityID"
												required="required" aria-required="true">
												<?php
												if ($tickets['LoadID'] > 0) {
													foreach ($opprtunities as $key => $value) {
														if ($value->OpportunityID == $tickets['OpportunityID']) {
															echo "<option value='" . $value->OpportunityID . "' selected >" . $value->OpportunityName . "</option>";
														}
													}
												} else {
													echo '<option value="">-- Select Opportunity --</option>';
													foreach ($opprtunities as $key => $value) {
														$selected = "";
														if ($value->OpportunityID == $tickets['OpportunityID']) {
															$selected = "Selected";
														}
														echo "<option value='" . $value->OpportunityID . "' " . $selected . ">" . $value->OpportunityName . "</option>";
													}
												} ?>
											</select>
											<div></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="WIFNumber">WIF FORM No. </label>
											<input type="text" class="form-control" id="WIFNumber"
												value="<?php echo $tickets['WIFNumber']; ?>" readonly name="WIFNumber">
										</div>
									</div>
								</div>


								<div class="row">

									<div class="col-md-12">
										<div class="form-group">
											<label for="SiteAddress">Site Address</label>
											<input type="text" class="form-control" id="SiteAddress"
												value="<?php if ($tickets['OpportunityID'] != "") {
													echo $SiteAddress->OpportunityName;
												} ?>"
												name="SiteAddress" maxlength="100" readonly>
										</div>
									</div>

								</div>


								<?php $status = 1; //if($tickets['MaterialID'] > 416){  $status = 1; }else{ $status = 0; } //echo $status;  ?>
								<div class="row">

									<div class="col-md-8">
										<div class="form-group">
											<label for="DescriptionofMaterial">Description of Material <span
													class="required">*</span></label>
											<select class="form-control" id="DescriptionofMaterial"
												name="DescriptionofMaterial" data-live-search="true" required="required"
												aria-required="true">
												<?php
												echo '<option value="">-- Select material type--</option>';
												foreach ($Material as $key => $value) {
													$selected = "";
													if ($value->MaterialID == $tickets['MaterialID']) {
														$selected = "Selected";
													}
													if ($value->Status == $status) {
														echo "<option value='" . $value->MaterialID . "' " . $selected . ">" . $value->MaterialName . "</option>";
													}
												}
												?>
											</select>
											<div></div>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="SicCode">SIC Code <span class="required">*</span></label>
											<input type="text" class="form-control" id="SicCode"
												value="<?php echo $tickets['SicCode']; ?>" name="SicCode"
												maxlength="100" readonly>
										</div>
									</div>

								</div>

								<div class="row">

									<div class="col-md-12">
										<div class="form-group">
											<label for="notes">Notes</label>
											<textarea class="form-control" id="ticket_notes" rows="1"
												name="ticket_notes"><?php echo $tickets['ticket_notes']; ?></textarea>
										</div>
									</div>

								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="Conveyance">Payment</label>
											<div class="checkbox">
												<label> <input type="radio" name="PaymentType" id="PaymentType"
														value="0" <?php if ($tickets['PaymentType'] == 0) { ?> checked <?php } ?>> Credit </label>
												<label> <input type="radio" name="PaymentType" id="PaymentType"
														value="1" <?php if ($tickets['PaymentType'] == 1) { ?> checked <?php } ?>> Cash </label>
												<label> <input type="radio" name="PaymentType" id="PaymentType"
														value="2" <?php if ($tickets['PaymentType'] == 2) { ?> checked <?php } ?>> Card </label>
											</div>

										</div>
									</div>
									<div class="pblock" <?php if ($tickets['PaymentType'] == 0) { ?> style="display: none;"
										<?php } ?>>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Amount">Amount</label>
												<input type="text" class="form-control" id="Amount"
													value="<?php echo $tickets['Amount']; ?>" name="Amount"
													maxlength="10">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="Vat">VAT (20%)</label>
												<input type="text" class="form-control" id="VatAmount" readonly
													value="<?php echo $tickets['VatAmount']; ?>" name="VatAmount">
												<input type="hidden" id="Vat" value="<?php echo $tickets['Vat']; ?>"
													name="Vat">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="TotalAmount">Total Amount</label>
												<input type="text" class="form-control" id="TotalAmount" readonly
													value="<?php echo $tickets['TotalAmount']; ?>" name="TotalAmount"
													maxlength="10">
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<label for="PaymentRefNo">Payment Ref No (Only for Card Payment)</label>
												<input type="text" class="form-control" id="PaymentRefNo"
													value="<?php echo $tickets['PaymentRefNo']; ?>" name="PaymentRefNo">
											</div>
										</div>
									</div>
								</div>


							</div>

							<div class="col-md-6">
								<?php

								$LorryType = 0;
								if ($tickets['LorryType'] != 0) {
									$LorryType = $tickets['LorryType'];
								} else {
									$LorryType = $tickets['LorryTypeT'];
								}

								?>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="Conveyance">LorryType</label>
											<div class="checkbox">
												<label> <input type="radio" class="LorryType" name="LorryType"
														id="LorryType" value="1" <?php if ($LorryType == 1) { ?> checked
														<?php } ?>> Tipper </label>
												<label> <input type="radio" class="LorryType" name="LorryType"
														id="LorryType" value="2" <?php if ($LorryType == 2) { ?> checked
														<?php } ?>> Grab </label>
												<label> <input type="radio" class="LorryType" name="LorryType"
														id="LorryType" value="3" <?php if ($LorryType == 3) { ?> checked
														<?php } ?>> Bin </label>
											</div>

										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="LorryNo">Lorry No <span class="required">*</span></label>
											<select class="form-control" id="LorryNo" name="LorryNo"
												aria-required="true" data-live-search="true">
												<?php
												echo '<option value="0">-- ADD Lorry --</option>';
												foreach ($Lorry as $key => $value) {
													$selected = "";
													if ($tickets['driver_id'] == $value->LorryNo) {
														$selected = "Selected";
													}
													echo "<option value='" . $value->LorryNo . "' " . $selected . " > " . $value->LorryNo . " | " . $value->DriverName . " | " . $value->RegNumber . " | " . $value->Haulier . "</option>";
												}
												?>
											</select>
											<div></div>
										</div>

									</div>


									<div class="col-md-6">
										<div class="form-group">
											<label for="DriverName">Driver Name</label>
											<input type="text" class="form-control required" id="DriverName"
												value="<?php echo $tickets['DriverName']; ?>" name="DriverName"
												maxlength="50">
											<input type="hidden" id="driverid"
												value="<?php echo $tickets['driver_id']; ?>" name="driverid">

										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label for="VechicleRegNo">Vechicle Reg No <span
													class="required">*</span></label>
											<input type="hidden" id="RegNo" value="<?php echo $tickets['RegNumber']; ?>"
												name="RegNo">
											<input type="text"
												class="form-control required EditVechicleRegNo VechicleRegNo"
												id="VechicleRegNo" value="<?php echo $tickets['RegNumber']; ?>"
												name="VechicleRegNo" maxlength="100">
											<div id="RegDup" style="color:red"></div>
										</div>
									</div>


									<div class="col-md-6">
										<div class="form-group">
											<label for="HaullerRegNo">Haulier</label>
											<input type="text" class="form-control" id="HaullerRegNo"
												value="<?php echo $tickets['Hulller']; ?>" readonly name="HaullerRegNo"
												maxlength="100">
										</div>
									</div>

								</div>
								<div class="row">

									<div class="col-md-4">
										<div class="form-group">
											<label for="GrossWeight">Gross Weight</label>
											<input type="number" class="form-control  required" id="GrossWeight"
												onKeyPress="if(this.value.length==6) return false;"
												value="<?php if ($tickets['GrossWeight'] != 0) {
													echo round($tickets['GrossWeight']);
												} else {
													echo "";
												} ?>"
												name="GrossWeight" maxlength="6">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="Tare">Tare</label>
											<input type="number" class="form-control  required" id="Tare"
												value="<?php echo $tickets['Tare']; ?>" name="Tare">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="Net">Net</label>
											<input type="number" class="form-control  required" id="Net"
												value="<?php echo $tickets['Net']; ?>" name="Net" readonly>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<button type="button" class="btn btn-primary fullscreen">Driver
												Signature</button>
											<input type="button" name="submit1" id="submit1"
												style="float:right;display:none;" class="btn btn-success"
												value="Submit" />
											<input type="submit" name="submit" id="submit" class="btn btn-primary"
												style="float:right; " value="Submit" />
											<button onclick="location.href='<?php echo base_url('All-Tickets') ?>';"
												type="button" style="float:right;margin-right:5px;"
												class="btn btn-warning">CANCEL</button>
											<div style="display:none" class="my">
												<div id="signature-pad" class="signature-pad ">
													<div class="signature-pad--body">
														<canvas></canvas>
													</div>
													<div class="signature-pad--footer">
														<div class="description">Sign above</div>
														<div class="signature-pad--actions">
															<div>
																<button type="button" id="savepng"
																	class="button btn btn-danger save "
																	data-action="save-png">Save </button>
																<button type="button"
																	class="button btn btn-primary clear"
																	data-action="clear">Clear</button>
																<button type="button"
																	class="button btn btn-warning fullscreen1">Close</button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<input type="hidden" name="driversignature" class="required"
												id="driversignature" value="<?php echo $tickets['driversignature']; ?>">
											<div id="driverimage"><?php if ($tickets['driversignature'] != "") { ?>
													<img src="<?php echo $tickets['driversignature']; ?>" height="400px"
														width="700px"><?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="MaterialPrice" id="MaterialPrice"
							value="<?php echo $tickets['MaterialPrice']; ?>">
						<input type="hidden" name="TicketType" id="TicketType" value="In">
						<input type="hidden" name="TicketNo" id="TicketNo" value="<?php echo $tickets['TicketNo']; ?>">
						<!-- <div class="box-footer">
							<input type="submit"  name="submit"  class="btn btn-primary" style="float:right; "  value="Submit" /> 
							<button onclick="location.href='<?php echo base_url('All-Tickets') ?>';" type="button" style="float:right;margin-right:5px;"  class="btn btn-warning">CANCEL</button>
						</div> -->
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
<script>

	$(document).ready(function () {
		$(document).on("click", ".LinkConveyance", function () {
			var Conveyance = $('#Conveyance').val(),
				TicketNo = $(this).attr("data-TicketNo"),
				hitURL1 = baseURL + "LinkConveyanceAJAX",
				currentRow = $(this);

			$.ajax({
				type: "POST",
				dataType: "json",
				url: hitURL1,
				data: { 'Conveyance': Conveyance, 'TicketNo': TicketNo }
			}).success(function (data) {

				//alert(JSON.stringify( data ));   
				//console.log(data);  

				if (data.LoadID > 0) {
					$('#LoadID').val(data.LoadID);
					$('.LorryType').attr('disabled', 'disabled');
					//$('#is_tml').attr('disabled', 'disabled');	 
					$('.fullscreen').attr('disabled', 'disabled');
					$('#submit').hide();
					$('#submit1').show();
					$('.VechicleRegNo').attr('readonly', true);
					$('#DriverName').attr('readonly', true);
					$('#HaullerRegNo').attr('readonly', true);
					$('#Tare').attr('readonly', true);
					$('#GrossWeight').attr('readonly', true);

					//alert(data)
					//alert(JSON.stringify(data));
					//alert(data.LoadID);
					//$('.modal-body').html(data); 
					//$('#empModal .modal-title').html("Search Conveyance Ticket ");
					//$('#empModal .modal-dialog').width(1000); 
					//$('#empModal').modal('show');  

					//alert(JSON.stringify( data ));   
					//console.log(data);   

				} else {
					alert("No Conveyance Ticket Found. ");
				}
			});

		});


		$(document).on("click", "#submit1", function () {
			//alert("asdfasdf")
			var LoadID = $('#LoadID').val(),
				TicketNo = $('#TicketNo').val(),

				PaymentType = $('#PaymentType').val(),
				Amount = $('#Amount').val(),
				Vat = $('#Vat').val(),
				VatAmount = $('#VatAmount').val(),
				TotalAmount = $('#TotalAmount').val(),
				PaymentRefNo = $('#PaymentRefNo').val(),
				ticket_notes = $('#ticket_notes').val(),
				hitURL1 = baseURL + "EditConveyanceTicketAJAX",
				currentRow = $(this);
			if (LoadID > 0) {
				$('#overlay').fadeIn();
				$.ajax({
					type: "POST",
					dataType: "json",
					url: hitURL1,
					data: {
						'LoadID': LoadID, 'TicketNo': TicketNo, 'Vat': Vat, 'VatAmount': VatAmount,
						'TotalAmount': TotalAmount, 'PaymentRefNo': PaymentRefNo, 'ticket_notes': ticket_notes
					}
				}).success(function (data) {

					alert(JSON.stringify(data));

					$('#overlay').fadeOut();
					$(".fullscreen").removeAttr('disabled');
					$('#submit').show();
					$('#submit1').hide();
					$("#hold").removeAttr('disabled');
					$('#Tare').attr('readonly', false);
					$('#DriverName').attr('readonly', false);

					if (data == 'Error') {
						alert("Error In  Submitting Data, Please contact Administrator.");
						$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>');
					} else {
						if (data.length > 20) {
							printPDF(data);
							$('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New IN TICKET created successfully.</div>');
						} else { return false; }
					}
				});
			} else {
				alert("Please Enter GrossWeight.");
			}
		});

		//$('#TicketDate').datetimepicker({ format: 'DD/MM/YYYY HH:mm',defaultDate:'now'  });  


		$(".fullscreen").click(function () {
			$('.my').show();
			$(".signature-pad").width('60%');
			$(".signature-pad").height('60%');
			$(".signature-pad").css({ "position": "fixed", "top": "0", "left": "0", "z-index": "9999" });
			resizeCanvas();
		});
		$("#savepng").click(function () {
			$('.my').hide();
			var dataURL = signaturePad.toDataURL();
			$('#driverimage').html('<img src="' + dataURL + '" height="400px" width="700px">');
			$('#driversignature').val(dataURL);
		});
		$(".fullscreen1").click(function () {
			$('.my').hide();
		});
		$("#is_tml").click(function () {
			if ($(this).is(":checked")) {
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