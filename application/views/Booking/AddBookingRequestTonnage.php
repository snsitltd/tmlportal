<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"
	rel="stylesheet" />

<div class="content-wrapper">
	<section class="content-header">
		<h1><i class="fa fa-users"></i> Add Booking (Tonnage) </h1>

	</section>
	<section class="content">

		<div class="row">
			<div class="col-md-12">
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class=""><a href="<?php echo base_url('AddBookingRequest'); ?>" aria-expanded="false">Add
								Booking</a></li>
						<li class="active"><a href="#AddBooking2" data-toggle="tab" aria-expanded="true">Add Tonnage
								Booking</a></li>
						<li class=""><a href="<?php echo base_url('AddBookingRequestDaywork'); ?>"
								aria-expanded="false">Add DayWork Booking</a></li>
						<li class=""><a href="<?php echo base_url('AddBookingRequestHaulage'); ?>"
								aria-expanded="false">Add Haulage Booking</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane active">
							<div class="row">
								<div class="col-md-12">
									<!-- general form elements -->
									<div class="box box-primary">
										<div class="box-header">
											<h3 class="box-title">Tonnage Booking Information</h3>
										</div>
										<div id="result"></div>
										<?php $this->load->helper("form"); ?>
										<form id="AddBooking" name="AddBooking"
											action="<?php echo base_url('AddBookingRequestTonnage'); ?>" method="post"
											role="form">
											<div class="box-body">
												<div class="col-md-6">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="CompanyID">Select Company <span
																		class="required">*</span></label>
																<select class="form-control select_company "
																	id="CompanyID" name="CompanyID" required="required"
																	data-live-search="true">
																	<option value="">-- ADD COMPANY --</option>
																	<?php foreach ($company_list as $key => $value) {
																		if ($value['Status'] == 1) { ?>
																			<option value="<?php echo $value['CompanyID'] ?>">
																				<?php echo $value['CompanyName'] ?>
																			</option>
																		<?php }
																	} ?>
																</select> <input type="hidden" id="CompName"
																	name="CompName">
																<div></div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="CompanyName">Company Name </label>
																<input type="text" class="form-control" id="CompanyName"
																	value="<?php echo set_value('CompanyName'); ?>"
																	name="CompanyName" maxlength="255">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<label for="TypeOfCustomer"> Type of Payment: </label> <span
																id="PType">N/A</span>

														</div>
														<div class="col-md-4">
															<label for="CreditLimit"> Credit Limit: </label> <span
																id="CreditLimit">N/A</span>

														</div>
														<div class="col-md-4">
															<label for="Outstanding">Outstanding: </label> <span
																id="Outstanding">N/A</span>

														</div>
													</div>
													<hr>
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label for="OpportunityID">Opportunity <span
																		class="required">*</span></label>
																<select class="form-control select_opportunity "
																	id="OpportunityID" name="OpportunityID"
																	required="required" data-live-search="true">
																	<option value="">-- ADD OPPORTUNITY --</option>
																</select> <input type="hidden" id="OppoName"
																	name="OppoName">
																<div></div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="Street1">Street 1 </label>
																<input type="text" class="form-control required Street1"
																	id="Street1"
																	value="<?php echo set_value('Street1'); ?>"
																	name="Street1" maxlength="255">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="Street1">Street 2 </label>
																<input type="text" class="form-control required Street2"
																	id="Street2"
																	value="<?php echo set_value('Street2'); ?>"
																	name="Street2" maxlength="255">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label for="Town">Town </label>
																<input type="text" class="form-control required Town"
																	id="Town" value="<?php echo set_value('Town'); ?>"
																	name="Town">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="County">County </label>
																<select class="form-control required County" id="County"
																	name="County" data-live-search="true">
																	<option value="">Select County</option>
																	<?php
																	if (!empty($county)) {
																		foreach ($county as $rl) { ?>
																			<option value="<?php echo $rl->County ?>" <?php if ($rl->County == set_value('County')) { ?> selected
																				<?php } ?>><?php echo $rl->County ?>
																			</option>
																			<?php
																		}
																	}
																	?>
																</select>
																<div></div>

															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="PostCode">Post Code </label>
																<input type="text"
																	class="form-control required PostCode" id="PostCode"
																	value="<?php echo set_value('PostCode'); ?>"
																	name="PostCode" maxlength="20">
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">

													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="CompanyID">Select Contact <span
																		class="required">*</span></label>
																<select class="form-control select_contact "
																	id="ContactID" name="ContactID" required="required"
																	data-live-search="true">
																	<option value="0">-- ADD CONTACT --</option>
																</select>
																<div></div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="CompanyName">Site Contact Name </label>
																<input type="text" class="form-control" id="ContactName"
																	required="required"
																	value="<?php echo set_value('ContactName'); ?>"
																	name="ContactName" maxlength="255">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="CompanyName">Site Contact Mobile</label>
																<input type="text" class="form-control"
																	id="ContactMobile" required="required"
																	value="<?php echo set_value('ContactMobile'); ?>"
																	name="ContactMobile" maxlength="11">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="ContactEmail">Email Address </label>
																<input type="text" class="form-control "
																	id="ContactEmail"
																	value="<?php echo set_value('ContactEmail'); ?>"
																	name="ContactEmail" maxlength="255">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label for="WaitingTime"> Waiting Time (Minute) </label>
																<input type="number" class="form-control "
																	id="WaitingTime" value="15" name="WaitingTime"
																	maxlength="10">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label for="WaitingCharge"> Wait Charges
																	(&pound;/Minute) </label>
																<input type="number" class="form-control "
																	id="WaitingCharge" value="1" name="WaitingCharge"
																	maxlength="5">
															</div>
														</div>
														<!--<div class="col-md-6">
									<div class="form-group">
										<label for="PurchaseOrderNumber">Purchase Order  </label>
										<input type="text" class="form-control " id="PurchaseOrderNumber" value="<?php //echo set_value('PurchaseOrderNumber'); ?>" name="PurchaseOrderNumber">
										<div class="checkbox"> 
											<label> <input type="checkbox" name="OpenPO" value="1" id="OpenPO"  > Open PO </label>
										</div> 
									</div>
									
								</div>   -->
														<div class="col-md-12">
															<div class="form-group">
																<label for="PriceBy">Price By </label>
																<select class="form-control" id="PriceBy"
																	required="required" name="PriceBy"
																	data-live-search="true">
																	<option value="">-- Select --</option>
																	<?php foreach ($ApprovalUserList as $key => $value) {
																		if ($value['userId'] != 1) { ?>
																			<option value="<?php echo $value['userId'] ?>">
																				<?php echo $value['name'] ?>
																			</option>
																		<?php }
																	} ?>
																</select>
																<div></div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label for="notes">Notes</label>
																<textarea class="form-control" id="Notes" rows="3"
																	name="Notes"></textarea>
															</div>
														</div>
													</div>

												</div>

												<div class="col-md-12">

													<h4 class="box-title"><b>Loads/Lorry Information</b> <button
															class="btn btn-md btn-success" style="float:right"
															id="addBtn" type="button"> Add Load/Lorry </button> </h4>
												</div>
												<div class="col-md-12">
													<div class="row">
														<table class="table table-bordered table-hover dataTable"
															role="grid" aria-describedby="example2_info">
															<thead>
																<tr>
																	<th width="3"> </th>
																	<th width="50">Booking Type</th>
																	<th>Material </th>
																	<th width="50">SIC Code </th>
																	<th width="50">Total Ton </th>
																	<th width="50">Ton/ Load </th>
																	<th width="50">Load Type </th>
																	<th width="50">Lorry Type </th>
																	<th width="50">Loads/ Lorry</th>
																	<th width="120">Request Date </th>
																	<th width="80">PurchaseOrderNo</th>
																	<th width="50">Price </th>
																	<th width="50">Total</th>
																</tr>
															</thead>
															<tbody id="tbody">

																<tr id="1">
																	<td> </td>
																	<td>
																		<select class="form-control BookingType  "
																			id="BookingType1" data-BID="1"
																			name="BookingType[]" required="required">
																			<option value="">Booking Type</option>
																			<option value="1">Collection</option>
																			<option value="2">Delivery</option>
																		</select>
																		<div></div>
																	</td>
																	<td>
																		<select class="form-control Material "
																			id="DescriptionofMaterial1" data-BID="1"
																			name="DescriptionofMaterial[]"
																			required="required" data-live-search="true">
																			<option value="">Select Material Type
																			</option>
																		</select>
																		<div></div>
																		<input type="hidden" id="MaterialName1"
																			name="MaterialName[]">
																	</td>
																	<td>
																		<input type="text" class="form-control"
																			id="SICCode1" data-BID="1"
																			style="text-align:right" required="required"
																			maxlength="6" name="SICCode[]" value="">
																		<div></div>
																	</td>

																	<td>
																		<input type="number"
																			class="form-control required TotalTon"
																			style="text-align:right" required="required"
																			min="1" id="TotalTon1" data-BID="1"
																			name="TotalTon[]" value="1"
																			maxlength="99999">
																	</td>
																	<td>
																		<input type="number"
																			class="form-control required TonPerLoad"
																			min="1" style="text-align:right"
																			required="required" id="TonPerLoad1"
																			data-BID="1" name="TonPerLoad[]"
																			maxlength="99999" value="1">
																	</td>
																	<td>
																		<select class="form-control LoadType"
																			id="LoadType1" name="LoadType[]"
																			required="required">
																			<option value="1">Loads</option>
																		</select>
																	</td>
																	<td>
																		<select class="form-control LorryType"
																			id="LorryType1" name="LorryType[]"
																			required="required" data-live-search="true">
																			<option value="" <?php if (set_value('LorryType') == "") { ?>
																					selected <?php } ?>>Select</option>
																			<option value="1" <?php if (set_value('LorryType') == 1) { ?>
																					selected <?php } ?>>Tipper</option>
																			<option value="2" <?php if (set_value('LorryType') == 2) { ?>
																					selected <?php } ?>>Grab</option>
																			<option value="3" <?php if (set_value('LorryType') == 3) { ?>
																					selected <?php } ?>>Bin</option>
																		</select>
																		<div></div>
																	</td>
																	<td><input type="text" class="form-control Loads"
																			id="Loads1" readonly
																			style="text-align:right" name="Loads[]">
																	</td>
																	<td>
																		<div class="input-group date">
																			<div class="input-group-addon"><i
																					class="fa fa-calendar"></i></div>
																			<input type="text"
																				class="form-control required BookingDateTime"
																				data-BID='1' readonly
																				id="BookingDateTime1" autocomplete="off"
																				value="" name="BookingDateTime[]"
																				maxlength="65">
																		</div>
																		<div></div>
																	</td>
																	<td>
																		<input type="text" class="form-control"
																			id="PurchaseOrderNo1" data-BID="1"
																			style="text-align:left" maxlength="50"
																			name="PurchaseOrderNo[]" value="">
																		<div></div>
																		<div class="checkbox">
																			<label> <input type="checkbox"
																					name="OpenPO[]" value="1"
																					id="OpenPO1"> Open PO </label>
																		</div>
																	</td>
																	<td>
																		<input type="number" class="form-control Price"
																			id="Price1" style="text-align:right"
																			data-BID="1" name="Price[]" value="">
																		<span id="pdate1" style="font-size:12px"></span>
																	</td>
																	</td>
																	<td style="text-align:right">
																		<span id="Total1" style="font-size:12px"></span>
																		<input type="hidden" id="TotalHidden1"
																			name="TotalHidden[]">
																	</td>
																</tr>

															</tbody>
														</table>
														<table class="table table-bordered table-hover dataTable"
															role="grid" aria-describedby="example2_info">
															<tr>
																<td align='right'><b>SubTotal</b> </td>
																<td width="107" style="text-align:right"><span
																		id="SubTotal"></span>
																	<input type="hidden" id="PriceSubTotal"
																		name="SubTotalAmount">
																</td>
															</tr>
															<tr>
																<td align='right'><b>VAT (20%)</b></td>
																<td style="text-align:right"><span
																		id="Vat"></span><input type="hidden"
																		id="PriceVat" name="VatAmount"> </td>
															</tr>
															<tr>
																<td align='right'><b>Total</b></td>
																<td style="text-align:right"><span id="AllTotal"></span>
																</td>
															</tr>
															</tbody>
														</table>


													</div>
												</div>


												<div class="col-md-12 Payment">
													<h4 class="box-title"><b>Payment Information</b></h4>
													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label for="">Type Of Payment </label>
																<div class="checkbox">
																	<label> <input type="radio" name="PaymentType"
																			id="PaymentType" value="2"> Cash </label>
																	<label> <input type="radio" name="PaymentType"
																			id="PaymentType" value="3" checked> Card
																	</label>
																</div>
																<!-- <input type="text" class="form-control " id="PaymentType" value="<?php //echo set_value('PaymentType'); ?>" name="PaymentType" maxlength="20" >
										<i id='pdate'></i> -->
															</div>
														</div>
													</div>
													<div class="pblock">
														<div class="row">
															<div class="col-md-3">
																<div class="form-group">
																	<label for="Price">Amount</label>
																	<input type="text" class="form-control "
																		id="TotalAmount"
																		value="<?php echo set_value('TotalAmount'); ?>"
																		style="text-align:right" name="TotalAmount"
																		maxlength="20">
																	<i id='pdate111'></i>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-3">
																<div class="form-group">
																	<label for="notes">Payment Ref/Notes</label>
																	<textarea class="form-control" id="PaymentRefNo"
																		rows="3" name="PaymentRefNo"></textarea>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="col-md-12">
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<input type="submit" name="submit" style=""
																	class="btn btn-primary" value="Submit" />
															</div>
														</div>
													</div>
												</div>

											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>
</div>
<script type="text/javascript" language="javascript">
	$(document).ready(function () {
		var rowIdx = 2;

		// jQuery button click event to add a row.
		$('#addBtn').on('click', function () {
			var Append = '<tr id="' + rowIdx + '" >';
			Append += '<td> <button class="btn btn-sm btn-danger remove" title="Remove "><i class="fa fa-remove"></i></button> </td>';
			Append += '<td><select class="form-control BookingType" id="BookingType' + rowIdx + '" data-BID="' + rowIdx + '" name="BookingType[]" required="required"  ></select><div ></div></td>';
			Append += '<td><select class="form-control Material " id="DescriptionofMaterial' + rowIdx + '"  data-BID="' + rowIdx + '" name="DescriptionofMaterial[]" required="required" data-live-search="true"  ></select><div ></div></td><input type="hidden" id="MaterialName' + rowIdx + '"  name="MaterialName[]"  > ';
			Append += '<td><input type="text" class="form-control" id="SICCode' + rowIdx + '" data-BID="1" style="text-align:right" maxlength="6" name="SICCode[]" value="" ></td>';

			Append += '<td><input type="number" data-BID="' + rowIdx + '"  min="1" maxlength="99999" value="1"   style="text-align:right"  class="form-control TotalTon" id="TotalTon' + rowIdx + '" name="TotalTon[]" required="required"  > </td>';
			Append += '<td><input type="number"  data-BID="' + rowIdx + '" min="1" maxlength="99999"  value="1"   style="text-align:right"  class="form-control TonPerLoad" id="TonPerLoad' + rowIdx + '" name="TonPerLoad[]" required="required"  >  </td>';

			Append += '<td><select class="form-control LoadType" id="LoadType' + rowIdx + '" name="LoadType[]" required="required"  ></select> </td>';
			Append += '<td><select class="form-control LorryType" id="LorryType' + rowIdx + '" name="LorryType[]"  data-live-search="true" required="required"></select></td>';

			Append += '<td><input type="text" class="form-control Loads" id="Loads' + rowIdx + '" readonly style="text-align:right" name="Loads[]"  > </td>';

			//Append += '<td><select class="form-control required Loads" id="Loads'+rowIdx+'" name="Loads[]"  data-live-search="true" >'; 
			//Append += '</select></td>'; 

			Append += '<td><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input readonly type="text" class="form-control required BookingDateTime" data-BID="' + rowIdx + '" id="BookingDateTime' + rowIdx + '" autocomplete="off" value="" name="BookingDateTime[]" maxlength="65"></div><div ></div></td>';
			Append += '<td><input type="text" class="form-control" id="PurchaseOrderNo' + rowIdx + '"  data-BID="1"  maxlength="50" name="PurchaseOrderNo[]" value="" ><div ></div><div class="checkbox"><label> <input type="checkbox" name="OpenPO[]" value="1" id="OpenPO1"  > Open PO </label></div></td>';
			Append += '<td><input type="number"   style="text-align:right"  class="form-control Price" id="Price' + rowIdx + '" data-BID="' + rowIdx + '" name="Price[]" value="" ><span id="pdate' + rowIdx + '" style="font-size:12px"></span></td>';
			Append += '<td  style="text-align:right" ><span id="Total' + rowIdx + '" style="font-size:12px"></span><input type="hidden" id="TotalHidden' + rowIdx + '"  name="TotalHidden[]"  > </td>';
			Append += '</tr>';
			$('#tbody').append(Append);

			var BTOptions = '<option value="">Booking Type</option><option value="1">Collection</option><option value="2">Delivery</option>';
			$("#BookingType" + rowIdx).html(BTOptions).selectpicker('refresh');

			var MTOptions = '<option value="">Select Material Type</option>';
			$("#DescriptionofMaterial" + rowIdx).html(MTOptions).selectpicker('refresh');

			var LTOptions = '<option value="1">Loads</option>';
			$("#LoadType" + rowIdx).html(LTOptions).selectpicker('refresh');

			var LRTOptions = '<option value="" >Select</option><option value="1" >Tipper</option><option value="2" >Grab</option><option value="3" >Bin</option>';
			$("#LorryType" + rowIdx).html(LRTOptions).selectpicker('refresh');

			//var LO = '';
			//for (i=1; i<=25; i++){   LO += '<option value="'+i+'"  >'+i+'</option>'; }  
			//$("#Loads"+rowIdx).html(LO).selectpicker('refresh'); 

			rowIdx++;


			$("#BookingType" + rowIdx).prop("required", true);
			$("#DescriptionofMaterial" + rowIdx).prop("required", true);
			$("#SICCode" + rowIdx).prop("required", true);
			$("#LoadType" + rowIdx).prop("required", true);
			$("#LorryType" + rowIdx).prop("required", true);
			$("#Loads" + rowIdx).prop("required", true);
			$("#BookingDateTime" + rowIdx).prop("required", true);

		});

		$('#tbody').on('click', '.remove', function () {
			$(this).closest('tr').remove();
		});

		$("body").on("keydown change", ".TotalTon , .TonPerLoad", function () {
			//alert("sdfsdf"); 

			var RID = $(this).attr("data-BID");
			var TotalTon = $("#TotalTon" + RID).val();
			var TonPerLoad = $("#TonPerLoad" + RID).val();
			var TotalLoad = Math.round(TotalTon / TonPerLoad);

			//console.log(TotalTon+'===='+TonPerLoad+'===='+TotalLoad );

			$('#Loads' + RID).val(TotalLoad);

			//$('select[id=Loads'+RID+']').val(TotalLoad);
			//$('#Loads'+RID).selectpicker('refresh')  

			$('.Price').click();


		});

		function formatDate(date) {
			var d = new Date(date),
				month = '' + (d.getMonth() + 1),
				day = '' + d.getDate(),
				year = d.getFullYear();

			if (month.length < 2) month = '0' + month;
			if (day.length < 2) day = '0' + day;

			return [day, month, year].join('-');
		}

		var PastDate = new Date(
			new Date().getFullYear(),
			new Date().getMonth() - 3,
			new Date().getDate()
		);
		//alert(formatDate(oneMonthAgo)); 

		$("body").on("click focus", ".BookingDateTime", function () {
			$('.BookingDateTime').datepicker({
				format: 'dd/mm/yyyy',
				startDate: 'today',
				//daysOfWeekDisabled  : [0], 
				multidate: 6,
				closeOnDateSelect: true
			});
		});
		/*$('.BookingDateTime').datepicker({  
				format: 'dd/mm/yyyy', 
				startDate: 'today', 
				daysOfWeekDisabled  : [0], 
				multidate: 6, 
				closeOnDateSelect: true
			});  */
		//"input[name^='news']"


	$("body").on("change", ".Material", function () {
	var RID = $(this).attr("data-BID");
	$('#DescriptionofMaterial' + RID).selectpicker('refresh');
	var selectedText = $(this).find("option:selected").text();
	var selected = $(this).find('option:selected');
	var sic = selected.data('sic');
	var MaterialID = selected.data('materialid');
	var OpportunityID = $("#OpportunityID").val();
	$("#MaterialName" + RID).val(selectedText);
	$("#SICCode" + RID).val(sic);

	if (OpportunityID != '' && MaterialID != '') {
		jQuery.ajax({
			type: "POST",
			dataType: "json",
			url: baseURL + "/LoadSICCodeProduct",
			data: { OpportunityID: OpportunityID, MaterialID: MaterialID }
		}).done(function (data) {
			if (data.SICCODE[0].SICCode != '') {
				$("#SICCode" + RID).val(data.SICCODE[0].SICCode);
			}
		});
	}
});
	// 	$("body").on("change", ".Material", function () {
	// 		var RID = $(this).attr("data-BID");
	// 		var selectedText = $(this).find("option:selected").text();
	// 		var selected = $(this).find('option:selected');
	// 		var sic = selected.data('sic');
	// 		var MaterialID = selected.data('materialid');
	// 		var OpportunityID = $("#OpportunityID").val();

	// 		console.log("Selected Material: ", selectedText);
	// 		console.log("Material ID: ", MaterialID);
	// 		console.log("Opportunity ID: ", OpportunityID);

	// 		// Update Material Name and SIC Code inputs
	// 		$("#MaterialName" + RID).val(selectedText);
	// 		$("#SICCode" + RID).val(sic);

	// 		if (OpportunityID != '' && MaterialID != '') {
	// 			// Make the AJAX call
	// 			jQuery.ajax({
	// 				type: "POST",
	// 				dataType: "json",
	// 				url: baseURL + "/LoadSICCodeProduct",  // Make sure URL is correct
	// 				data: {
	// 					OpportunityID: OpportunityID,
	// 					MaterialID: MaterialID
	// 				}
	// 			})
	// 				.done(function (data) {
	// 					console.log("AJAX response:", data);

	// 					// Check if the response contains the SICCode
	// 					if (data.status && data.SICCODE && data.SICCODE.SICCode !== "") {
	// 						console.log("SICCode fetched: ", data.SICCODE.SICCode);
	// 						$("#SICCode" + RID).val(data.SICCODE.SICCode); // Set SICCode value in the appropriate field
	// 					} else {
	// 						$("#SICCode" + RID).val(''); // Clear the field if no SICCode
	// 					}
	// 				})
	// 				.fail(function (jqXHR, textStatus, errorThrown) {
	// 					console.log("AJAX request failed", textStatus, errorThrown);
	// 				});
	// 		}
	// 	});


	// });

	/*$("body").on("change", ".Material", function(){   
		var RID = $(this).attr("data-BID");  
		var selectedText = $(this).find("option:selected").text(); 
		$("#MaterialName"+RID).val(selectedText);  
	 
	});*/



	$("body").on("change", ".LoadType", function () {
		//$(".LoadType").on('change',function(){
		$('.BookingDateTime').click();
	});
	$("body").on("change", ".Loads", function () {
		//$(".Loads").on('change',function(){
		$('.BookingDateTime').click();
	});
	$("body").on("change", ".Price", function () {
		//$(".Price").on('change',function(){  

		var PriceVal = parseFloat($(this).val()).toFixed(2);
		var RID = $(this).attr("data-BID");
		var BookingDateTime = $("#BookingDateTime" + RID).val();
		var temp = new Array();
		temp = BookingDateTime.split(",");
		var temp_count = temp.length;
		var Loads = document.getElementById('Loads' + RID).value;
		var TotalTon = document.getElementById('TotalTon' + RID).value;

		if (PriceVal != '') {
			$("#Total" + RID).html(parseFloat(PriceVal * TotalTon * temp_count).toFixed(2));
			$("#TotalHidden" + RID).val(parseFloat(PriceVal * TotalTon * temp_count).toFixed(2));

		}
		var TotalHidden = document.getElementsByName('TotalHidden[]');
		let SubTotal = 0;
		for (var i = 0; i < TotalHidden.length; i++) {
			if (TotalHidden[i].value == "") { TotalHidden[i].value = 0; }
			SubTotal += parseFloat(TotalHidden[i].value);
		}
		$("#SubTotal").html(SubTotal.toFixed(2));
		$("#PriceSubTotal").val(SubTotal);

		var Vat = parseFloat((SubTotal * 20) / 100).toFixed(2);
		$("#Vat").html(Vat);
		$("#PriceVat").val(Vat);

		var AllTotal = (parseFloat(SubTotal) + parseFloat(Vat)).toFixed(2);
		$("#AllTotal").html(AllTotal);
		$("#TotalAmount").val(AllTotal);
	});
	$("body").on("change", ".BookingType", function () {
		//$(".BookingType").on('change',function(event){   
		var id = $(this).val();
		var RID = $(this).attr("data-BID");

		if (id != '') {
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				url: baseURL + "/LoadBookingMaterials",
				data: { id: id }
			}).done(function (data) {
				//alert(JSON.stringify( data ));    
				//console.log(data);               
				if (data.status == false) {
					var options = ' <option value="">Select Material Type</option>';
					$("select#DescriptionofMaterial" + RID).html(options);
				} else {
					var sty = '';
					var options = '<option value="">Select Material Type</option>';
					for (var i = 0; i < data.material_list.length; i++) {
						if (data.material_list[i].Status == 1) { sty = 'style="background-color:#dd4b39;color:white;font-weight: bold;"' } else { sty = ''; }
						options += '<option value="' + data.material_list[i].MaterialID + '" data-sic="' + data.material_list[i].SicCode + '" data-materialid="' + data.material_list[i].MaterialID + '"  >' + data.material_list[i].MaterialName + '</option>';
					}
					//$("select#DescriptionofMaterial"+RID).html(options);  
					$('#DescriptionofMaterial' + RID).html(options);
					$('#DescriptionofMaterial' + RID).selectpicker('refresh');

				}
				$('.BookingDateTime').click();
			});
		}

	});
	$("body").on("change", ".LorryType", function () {
		$('.BookingDateTime').click();
	});
	$("body").on("changeDate click change", ".BookingDateTime , .LoadType , .Loads , .BookingType,.Material, #OpportunityID", function () {
		//$('.BookingDateTime , .LoadType , .Loads , .BookingType').datepicker().on('changeDate click', function (ev) { 
		//alert(val('#BookingDateTime'));
		//var BookingDateTime = $( "#BookingDateTime").val(); 

		//var BookingDateTime = $(this).val();  
		var RID = $(this).attr("data-BID");
		//console.log(RID);
		var BookingDateTime = $("#BookingDateTime" + RID).val();
		//alert(BookingDateTime)
		//console.log(BookingDateTime);
		var OpportunityID = $("#OpportunityID").val();
		var MaterialID = $("#DescriptionofMaterial" + RID).val();
		var BookingType = $("#BookingType" + RID).val();
		var Loads = $("#Loads" + RID).val();
		var LoadType = $("#LoadType" + RID).val();
		var LorryType = $("#LorryType" + RID).val();
		var Price = parseFloat($("#Price" + RID).val()).toFixed(2);
		var TotalTon = document.getElementById('TotalTon' + RID).value;
		if (OpportunityID != '' && OpportunityID != 0 && MaterialID != '' && BookingType != '') {
			var temp = new Array();
			temp = BookingDateTime.split(",");
			var temp_count = temp.length;
			for (i = 0; i < temp.length; i++) {
				var dt = new Array();
				dt = temp[i].split("/");

				temp[i] = dt[2] + '-' + dt[1] + '-' + dt[0];
				//alert(temp[i]);
			}
			temp.sort();
			if (BookingDateTime != "") {
				var DateRequired = temp[0];
				var HitUrl = baseURL + "ShowOppoProductPriceTonnageAJAX";
				$.ajax({
					type: "POST",
					dataType: "json",
					url: HitUrl,
					data: { 'OpportunityID': OpportunityID, 'MaterialID': MaterialID, 'DateRequired': DateRequired, 'LorryType': LorryType }
				}).success(function (data) {
					//var Prc = 0;
					var Prc = Price;
					if (data.Price) {
						var Prc = data.Price;
					}
					if (data.OpenPO == 1) {
						$("#PurchaseOrderNo" + RID).val(data.PON);
						$('#OpenPO' + RID).prop('checked', true);
					} else {
						//$( "#PurchaseOrderNo"+RID).val('');  
					}
					if (Prc != '' && Prc != '0' && Prc != 'NaN') {
						$("#Price" + RID).val(parseFloat((Prc)).toFixed(2));
					} else {
						$("#Price" + RID).val(0); Prc = 0;
					}

					$("#Total" + RID).html(parseFloat(Prc * TotalTon * temp_count).toFixed(2));
					$("#TotalHidden" + RID).val(parseFloat(Prc * TotalTon * temp_count).toFixed(2));

					if (data.PriceDate) {
						if (data.PriceDate != "") {
							$("#pdate" + RID).html('<b>PriceDate:</b> ' + data.PriceDate);
						} else { $("#pdate" + RID).html(''); }
					} else { $("#pdate" + RID).html(''); }

					var TotalHidden = document.getElementsByName('TotalHidden[]');
					let SubTotal = 0;
					for (var i = 0; i < TotalHidden.length; i++) {
						if (TotalHidden[i].value == "") { TotalHidden[i].value = 0; }
						SubTotal += parseFloat(TotalHidden[i].value);
					}

					$("#SubTotal").html(SubTotal.toFixed(2));
					$("#PriceSubTotal").val(SubTotal);

					var Vat = parseFloat((SubTotal * 20) / 100).toFixed(2);
					$("#Vat").html(Vat);
					$("#PriceVat").val(Vat);

					var AllTotal = (parseFloat(SubTotal) + parseFloat(Vat)).toFixed(2);
					$("#AllTotal").html(AllTotal);
					$("#TotalAmount").val(AllTotal);

				});
			} else {
				//$( "#Price"+RID).val('');  
				//$( "#pdate"+RID).html('');  
				//$( "#Total"+RID).html(0); 
				//$( "#TotalHidden"+RID).val(0); 
			}
		} else { 	//$( "#Price"+RID).val('');  
			//$( "#pdate"+RID).html('');  
			//$( "#Total"+RID).html(0); 
			//$( "#TotalHidden"+RID).val(0);  
		}


	});
	$("input[name$='PaymentType']").click(function () {
		var pvalue = $(this).val();
		if (pvalue != 0) {
			$("div.pblock").show();
		} else {
			$("div.pblock").hide();
		}
	});
	});
	$('#AddBooking').on('submit', function (event) {
		let isValid = true;
		console.log("Form submitted");
		// alert("hoila");
		// Select only LorryType dropdowns
		$(this).find('.LorryType[required]').each(function () {
			if (!$(this).val()) {
				isValid = false;
				console.log("false");

				$(this).css("border", "1px solid red"); // Highlight empty fields
			} else {
				$(this).css("border", ""); // Remove highlight if valid
			}
		});

		if (!isValid) {
			event.preventDefault(); // Stop form submission
			alert("Please select a Lorry Type.");
		}
	});

</script>


<script src="<?php echo base_url('assets/js/Booking1.js'); ?>" type="text/javascript"></script>