<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
  
<div class="content-wrapper"> 
    <section class="content-header"><h1><i class="fa fa-users"></i> Duplicate Booking  Request </h1></section>  
    <section class="content"> 
        <div class="row"> 
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header"> <h3 class="box-title">Booking Information</h3> </div>  
					<div id="result"></div>  
                    <?php $this->load->helper("form"); ?> 
					
					<?php // var_dump($BookingRequest); ?>
                    <form id="AddBooking" name="AddBooking"  action="<?php echo base_url('DuplicateBookingRequestTonnage/'.$BookingRequest['BookingRequestID']); ?>"  method="post" role="form" > 
						<input type="hidden" name="BookingRequestID" id="BookingRequestID" value="<?php echo $BookingRequest['BookingRequestID']; ?>" >
						<input type="hidden" name="CompanyID" id="CompanyID" value="<?php echo $BookingRequest['CompanyID']; ?>" >
						<input type="hidden" name="OpportunityID" id="OpportunityID" value="<?php echo $BookingRequest['OpportunityID']; ?>" >
						<input type="hidden" name="ContactID" id="ContactID" value="<?php echo $BookingRequest['ContactID']; ?>" > 
                        <div class="box-body">
                        <div class="col-md-6">     
                            <div class="row"> 
								<div class="col-md-12">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Company Name </label>
										<input type="text" class="form-control" id="CompanyName" readonly value="<?php echo $BookingRequest['CompanyName']; ?>" name="CompanyName"   > 
                                    </div>
                                </div>   
                            </div>  
							 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="OpportunityID">Opportunity <span class="required">*</span></label> 
										<input type="text" class="form-control" readonly value="<?php echo $BookingRequest['OpportunityName']; ?>" name="OpportunityName"   >  
                                    </div>
                                </div> 	
                            </div>  
							<div class="row">  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1  </label>
                                        <input type="text" class="form-control" readonly value="<?php echo $BookingRequest['Street1']; ?>" name="Street1"   >  
                                    </div>
                                </div> 
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 2  </label>
                                        <input type="text" class="form-control" readonly value="<?php echo $BookingRequest['Street2']; ?>" name="Street2"   >  
                                    </div>
                                </div>  
							</div> 
							<div class="row">  
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Town">Town  </label>
                                        <input type="text" class="form-control" readonly value="<?php echo $BookingRequest['Town']; ?>" name="Town"   >  
                                    </div>
                                </div>  
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="County">County  </label>                                        
                                       <input type="text" class="form-control" readonly value="<?php echo $BookingRequest['County']; ?>" name="County"   >   
                                    </div>
                                </div> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code </label>
                                        <input type="text" class="form-control" readonly value="<?php echo $BookingRequest['PostCode']; ?>" name="PostCode"   >  
                                    </div>
                                </div>   
                            </div>  
                        </div> 
						<div class="col-md-6">    
							<div class="row">
                               <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyID">Select Contact <span class="required">*</span></label>
                                        <select class="form-control" id="ContactID" name="ContactID" required="required" data-live-search="true"   > 
                                        <?php  foreach ($OppoContact as $key => $value) { ?>
                                          <option value="<?php echo $value->ContactID ?>" <?php if($BookingRequest['ContactID']==$value->ContactID){ ?> selected <?php } ?>   ><?php echo $value->ContactName ?></option>
                                        <?php } ?> 
                                        </select>  <div ></div>	  
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Site Contact Name </label>
										<input type="text" class="form-control" id="ContactName"   required="required" value="<?php echo $BookingRequest['ContactName']; ?>" name="ContactName" maxlength="255"  > 
                                    </div>
                                </div>  
							</div>	
							<div class="row"> 
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Site Contact Mobile</label>
										<input type="text" class="form-control" id="ContactMobile"   required="required" value="<?php echo $BookingRequest['ContactMobile']; ?>" name="ContactMobile" maxlength="11"  > 
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ContactEmail">Email Address </label>
                                        <input type="text" class="form-control " id="ContactEmail"   value="<?php echo $BookingRequest['ContactEmail']; ?>" name="ContactEmail"  maxlength="255" >
                                    </div>
                                </div>  			
                            </div>  
							 <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="WaitingTime"> Waiting Time (Minute) </label>
                                        <input type="number" class="form-control " id="WaitingTime"  value="<?php echo $BookingRequest['WaitingTime']; ?>"  name="WaitingTime" maxlength="10" >
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="WaitingCharge"> Wait Charges (1 &pound;/Minute) </label>
                                        <input type="number" class="form-control " id="WaitingCharge"  value="<?php echo $BookingRequest['WaitingCharge']; ?>"  name="WaitingCharge" maxlength="5" >
                                    </div>
                                </div>   
								              
								<div class="col-md-12">
                                    <div class="form-group"> 
                                        <label for="PriceBy">Price By  </label>
                                        <select class="form-control" id="PriceBy" required="required"  name="PriceBy" data-live-search="true"   >
										<option value="">-- Select --</option>
                                        <?php  foreach ($ApprovalUserList as $key => $value) { ?>
                                          <option value="<?php echo $value['userId'] ?>"  <?php if($BookingRequest['PriceBy']==$value['userId']){ ?> selected <?php } ?>  ><?php echo $value['name'] ?></option>
                                        <?php } ?> 
                                        </select>  <div ></div>	  
                                    </div>
                                </div>  
                            </div>  
							<div class="row">                                			
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="Notes" rows="3" name="Notes"><?php echo $BookingRequest['Notes']; ?></textarea>
                                    </div>
                                </div>  
                            </div>    
						</div>  
						 
						<div class="col-md-12">  
						 
							<div class="row">  	
							  <table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
							  <thead>
								<tr>                          
									<th width="3" > </th>  
									<th width="50" >Booking Type</th> 
									<th  >Material </th>   
									<th width="50"  >SIC Code </th>   
									<th width="100"  >Total Ton </th>   
									<th width="100"  >Ton/ Load </th> 
									<th width="80" >Load Type </th>
									<th width="50" >Lorry Type </th>
									<th width="50" >Loads/ Lorry</th> 
									<th width="120" >Request Date </th> 
									<th width="80" >PurchaseOrderNo</th> 
									<th width="50" >Price </th>
									<th width="50" >Total</th>  
								</tr>
								</thead>  
								<tbody id="tbody"> 
								<?php 
								if(!empty($BookingDates)){ 
									foreach($BookingDates as $key=>$record){  $i=0;   ?>
								<tr id="<?php echo $i; ?>"> 
										<td></td> 
										<td>
											<select class="form-control BookingType  " id="BookingType<?php echo $i; ?>"   name="BookingType[]" required="required"  >
												<option value="">Booking Type </option>                                        
												<option value="1" <?php if($record->BookingType ==1){ ?> selected <?php } ?> >Collection</option>                                          
												<option value="2" <?php if($record->BookingType ==2){ ?> selected <?php } ?> >Delivery</option>                                        
											</select><div ></div>
										</td>
										<td><?php $status = 0; if($record->MaterialID > 416){  $status = 1; }else{ $status = 0; }  ?> 
											<select class="form-control Material " id="DescriptionofMaterial<?php echo $i; ?>"     name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
												<option value="">Select Material Type</option>
												<?php if($record->BookingType ==1){ ?>
													<?php foreach($CollectionMaterialList as $key1=>$record1){ ?>
													<?php if($record1->Status  == $status){ ?>
													<option value="<?php echo $record1->MaterialID; ?>"  <?php if($record1->Status == "1"){  ?> <?php } ?>   <?php if($record->MaterialID ==$record1->MaterialID){ ?> selected <?php } ?> data-sic="<?php echo $record1->SicCode; ?>" data-materialid="<?php echo $record1->MaterialID; ?>"   ><?php echo $record1->MaterialName; ?></option>
													<?php } ?>
												<?php } } ?>
												<?php if($record->BookingType ==2){ ?>
													<?php foreach($DeliveryMaterialList as $key1=>$record1){ ?>
													<?php if($record1->Status  == $status){ ?>
													<option value="<?php echo $record1->MaterialID; ?>"   <?php if($record1->Status == "1"){  ?>  <?php } ?>   <?php if($record->MaterialID ==$record1->MaterialID){ ?> selected <?php } ?> data-sic="<?php echo $record1->SicCode; ?>" data-materialid="<?php echo $record1->MaterialID; ?>"   ><?php echo $record1->MaterialName; ?></option>
													<?php }} ?>
												<?php } ?>
														
											</select>   <div ></div>
											<input type="hidden" id="MaterialName<?php echo $i; ?>"  name="MaterialName[]" value="<?php echo $record->MaterialName; ?>"  > 
										</td>
										<td>
											<input type="text" class="form-control" id="SICCode<?php echo $i; ?>"  style="text-align:right"      name="SICCode[]" value="<?php echo $record->SICCode; ?>" >  
										</td>
												
										<td>
											<input type="number" class="form-control required TotalTon"  style="text-align:right"  min="1" id="TotalTon<?php echo $i; ?>"  name="TotalTon[]" value="<?php echo $record->TotalTon; ?>" maxlength="99999" >  
										</td>
										<td>
											<input type="number" class="form-control required TonPerLoad"  style="text-align:right"  min="1" id="TonPerLoad<?php echo $i; ?>"  name="TonPerLoad[]" maxlength="99999"  value="<?php echo $record->TonPerLoad; ?>" >  
										</td>
										<td>
											<select class="form-control LoadType" id="LoadType<?php echo $i; ?>" name="LoadType[]"    required="required"  > 
												<option value="1" <?php if($record->LoadType ==1){ ?> selected <?php } ?> >Loads</option>                                           
											</select> 
										</td>
										<td>
											<select class="form-control LorryType" id="LorryType<?php echo $i; ?>" name="LorryType[]"    data-live-search="true" >  
												<option value="" <?php if($record->LorryType ==0 || $record->LorryType == '' ){ ?> selected <?php } ?>  >Select</option> 
												<option value="1" <?php if($record->LorryType ==1){ ?> selected <?php } ?>  >Tipper</option> 
												<option value="2" <?php if($record->LorryType ==2){ ?> selected <?php } ?>  >Grab</option> 
												<option value="3" <?php if($record->LorryType ==3){ ?> selected <?php } ?>  >Bin</option> 
                                        </select>   
										</td> 
										<td><input type="text" class="form-control Loads" id="Loads<?php echo $i; ?>" readonly style="text-align:right" value="<?php echo $record->Loads;  ?>"  name="Loads[]" required="required"    >  
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" readonly id="BookingDateTime<?php echo $i; ?>" autocomplete="off" name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td>
											<input type="text" class="form-control" id="PurchaseOrderNo<?php echo $i; ?>"    name="PurchaseOrderNo[]"  value="<?php echo $record->PurchaseOrderNo; ?>"  >  
											<div></div>
											<div class="checkbox"> 
												<label> <input type="checkbox" name="OpenPO[]"  <?php if($record->OpenPO==1){ ?> checked <?php } ?>  value="1" id="OpenPO<?php echo $i; ?>"  > Open PO </label>
											</div>
										</td> 
										<td>
											<input type="number" class="form-control Price" id="Price<?php echo $i; ?>"  style="text-align:right" name="Price[]" value="<?php echo $record->Price; ?>"> 
											<span id="pdate1" style="font-size:12px"></span>
										</td> 
										<td  style="text-align:right" >
											<span id="Total<?php echo $i; ?>" style="font-size:12px"><?php echo $record->TotalAmount; ?>   </span>
											<input type="hidden" class="TH" id="TotalHidden<?php echo $i; ?>"  name="TotalHidden[]"    value="<?php echo $record->TotalAmount; ?>"  > 
										</td> 
									</tr>  
								<?php }} ?>
								</tbody>
							  </table> 
							  <table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
								<tr>  
									<td   align='right' ><b>SubTotal</b> </td>
									<td width="107"  style="text-align:right"  ><span id="SubTotal"><?php echo $BookingRequest['SubTotalAmount']; ?></span>
									<input type="hidden" id="PriceSubTotal"  name="SubTotalAmount" value="<?php echo $BookingRequest['SubTotalAmount']; ?>"  > 
									</td> 
								</tr> 
								<tr>  
									<td  align='right'  ><b>VAT (20%)</b></td>
									<td   style="text-align:right" ><span id="Vat"><?php echo $BookingRequest['VatAmount']; ?></span><input type="hidden" id="PriceVat"  name="VatAmount"  value="<?php echo $BookingRequest['VatAmount']; ?>" > </td> 
								</tr> 
								<tr>  
									<td  align='right'  ><b>Total</b></td>
									<td   style="text-align:right" ><span id="AllTotal"><?php echo $BookingRequest['TotalAmount']; ?></span></td> 
								</tr> 
								</tbody>
								</table> 
	
							
							</div>
						</div> 
						 
					  	<?php if($BookingRequest['PaymentType']!=1){ ?> 	 
						<div class="col-md-12 Payment" >  
							<h4 class="box-title"><b>Payment Information</b></h4>
							<div class="row"> 
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Type Of Payment </label>
                                        <div class="checkbox">  
											<label> <input type="radio" name="PaymentType" id="PaymentType" value="2"  > Cash  </label>
											<label> <input type="radio" name="PaymentType" id="PaymentType" value="3" checked > Card </label> 
                                        </div> 
										<!-- <input type="text" class="form-control " id="PaymentType" value="<?php //echo set_value('PaymentType'); ?>" name="PaymentType" maxlength="20" >
										<i id='pdate'></i> -->
                                    </div>
                                </div>    
							</div>
							
							<div class="pblock" > 
								<div class="row"> 
									<div class="col-md-3">
										<div class="form-group">
											<label for="Price">Amount</label>
											<input type="text"  style="text-align:right"  class="form-control " id="TotalAmount" value="<?php echo $BookingRequest['TotalAmount']; ?>" name="TotalAmount" maxlength="20" >
											<i id='pdate111'></i>
										</div>
									</div>    
								</div>
								<div class="row">                                			
									<div class="col-md-3">
										<div class="form-group">
											<label for="notes">Payment Ref/Notes</label>
											<textarea class="form-control" id="PaymentRefNo" rows="3" name="PaymentRefNo"><?php echo $BookingRequest['PaymentRefNo']; ?></textarea>
										</div>
									</div>  
								</div>    
							</div>
							
                        </div>  
						<?php } ?>
						<div class="col-md-12">   
                             <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">   
										<input type="submit" name="submit" style="" class="btn btn-primary" value="Submit" /> 
										<input type="button" name="cancel"  onclick="window.history.go(-1); return false;" style="" class="btn btn-danger" value="Cancel" /> 
                                    </div>
                                </div> 
                            </div>  
                        </div>  
                        </div> 
						</form>
                        </div> 
                   
            </div>
        </div>    
    </section> 
</div> 
<script type="text/javascript" language="javascript" > 	 
	$(document).ready(function(){ 
		  
		$('#tbody').on('click', '.remove', function () {   
			$(this).closest('tr').remove(); 
		});   
		 
		$("body").on("keydown change blur", ".TotalTon , .TonPerLoad", function(){   
			//alert("sdfsdf"); 
			
			var RID = $(this).attr("data-BID");   
			var TotalTon = $( "#TotalTon"+RID).val();  
			var TonPerLoad = $( "#TonPerLoad"+RID).val();   
			var TotalLoad = Math.round(TotalTon/TonPerLoad); 
			console.log(TotalTon+'===='+TonPerLoad+'===='+TotalLoad );
			$('#Loads'+RID).val(TotalLoad);
			//$('select[id=Loads'+RID+']').val(TotalLoad);
			//$('#Loads'+RID).selectpicker('refresh') 
			$('.BookingDateTime').click();
			
		});  
		
	 	  //startDate: 'today',
 		$("body").on("click focus", ".BookingDateTime", function(){ 
			$('.BookingDateTime').datepicker({  
				format: 'dd/mm/yyyy', 
				 
				//daysOfWeekreadonly  : [0], 
				multidate: 6, 
				closeOnDateSelect: true
			});  
		});
		$('.BookingDateTime').datepicker({  
			format: 'dd/mm/yyyy', 
			 
			daysOfWeekreadonly  : [0], 
			multidate: 6, 
			closeOnDateSelect: true
		}); 
		//"input[name^='news']"
		$("body").on("change", ".Material", function(){   
			var RID = $(this).attr("data-BID");  
			$('#DescriptionofMaterial'+RID).selectpicker('refresh');   
			var selectedText = $(this).find("option:selected").text(); 
			var selected = $(this).find('option:selected'); 
			var sic = selected.data('sic');  
			var MaterialID = selected.data('materialid');  
			var OpportunityID = $("#OpportunityID").val();   
			$("#MaterialName"+RID).val(selectedText);  
			$("#SICCode"+RID).val(sic);  
			if(OpportunityID!='' && MaterialID!='' ){     	 
				
				jQuery.ajax({
					type : "POST",
					dataType : "json",
					url: baseURL+"/LoadSICCodeProduct",
					data : { OpportunityID : OpportunityID, MaterialID : MaterialID } 
					}).done(function(data){  
						//alert(JSON.stringify( data ));     
						//console.log(data); 
						//alert(data.SICCODE[0].SICCode);
						if(data.SICCODE[0].SICCode!=''){	   
							$("#SICCode"+RID).val(data.SICCODE[0].SICCode);  							 
						}  
				}); 
			} 
			
				$('.BookingDateTime').click();    
		});  
		$("body").on("change", ".LoadType", function(){ 
		//$(".LoadType").on('change',function(){
		  $('.BookingDateTime').click();
		});
		$("body").on("change", ".Loads", function(){ 
		//$(".Loads").on('change',function(){
		  $('.BookingDateTime').click();
		});
		$("body").on("change", ".Price", function(){ 
		//$(".Price").on('change',function(){  
		
			 
			var PriceVal=parseFloat($(this).val()).toFixed(2);
			var RID = $(this).attr("data-BID");  
			var BookingDateTime = $( "#BookingDateTime"+RID).val();
			var temp = new Array();
				temp = BookingDateTime.split(",");
			var temp_count = temp.length; 
			var Loads = document.getElementById('Loads'+RID).value; 
			var TotalTon = document.getElementById('TotalTon'+RID).value;
			
			if(PriceVal!=''){  
				$( "#Total"+RID).html(parseFloat(PriceVal*TotalTon*temp_count).toFixed(2)); 
				$( "#TotalHidden"+RID).val(parseFloat(PriceVal*TotalTon*temp_count).toFixed(2));  
				
			}  
			var TotalHidden = document.getElementsByName('TotalHidden[]');
			let SubTotal = 0;  
			$(".TH").each(function() {   
				if(!isNaN(this.value) && this.value.length!=0) { 
					SubTotal += parseFloat(this.value);
				} 
			});
			$("#SubTotal").html(SubTotal.toFixed(2));  
			$("#PriceSubTotal").val(SubTotal); 
			
			var Vat = parseFloat((SubTotal*20)/100).toFixed(2);
			$("#Vat").html(Vat); 
			$("#PriceVat").val(Vat); 
			
			var AllTotal = (parseFloat(SubTotal)+parseFloat(Vat)).toFixed(2);
			$("#AllTotal").html(AllTotal);  
			$("#TotalAmount").val(AllTotal);   	
			   
		});  
		$("body").on("change", ".BookingType", function(){ 
		//$(".BookingType").on('change',function(event){   
			var id=$(this).val();  
			var RID = $(this).attr("data-BID");
			if(id!=''){     	 
				jQuery.ajax({
					type : "POST",
					dataType : "json",
					url: baseURL+"/LoadBookingMaterials",
					data : { id : id } 
					}).done(function(data){  
						//alert(JSON.stringify( data ));    
						//console.log(data);               
						if(data.status==false){	  
							var options = ' <option value="">Select Material Type</option>';
							$("select#DescriptionofMaterial"+RID).html(options);  
						}else{ 	 
							var sty = '';
							var options = '<option value="">Select Material Type</option>';
							for (var i = 0; i < data.material_list.length; i++) {
								if(data.material_list[i].Status==1){ sty = 'style="background-color:#dd4b39;color:white;font-weight: bold;"' }else{ sty= ''; }
								options += '<option value="' + data.material_list[i].MaterialID + '"   data-sic="' + data.material_list[i].SicCode + '" data-materialid="' + data.material_list[i].MaterialID + '"  >' + data.material_list[i].MaterialName + '</option>';
							} 
							//$("select#DescriptionofMaterial"+RID).html(options);  
							$('#DescriptionofMaterial'+RID).html(options);  
							$('#DescriptionofMaterial'+RID).selectpicker('refresh');     
							
						} 
						$('.BookingDateTime').click();
				}); 
			} 
			 
		}); 
		$("body").on("changeDate click", ".BookingDateTime , .LoadType ,  .Loads , .BookingType, #OpportunityID", function(){  
		//$('.BookingDateTime , .LoadType , .Loads , .BookingType').datepicker().on('changeDate click', function (ev) { 
			//alert(val('#BookingDateTime'));
			//var BookingDateTime = $( "#BookingDateTime").val(); 
			//alert("sdfsdf")
			//var BookingDateTime = $(this).val();  
			var RID = $(this).attr("data-BID");
			var BookingDateTime = $( "#BookingDateTime"+RID).val();
			var OpportunityID = $( "#OpportunityID").val();
			
			var MaterialID = $( "#DescriptionofMaterial"+RID).val();  
			var BookingType = $( "#BookingType"+RID).val();  
			var Loads = $( "#Loads"+RID).val();  
			var LoadType = $( "#LoadType"+RID).val();    
			var Price = parseFloat( $("#Price"+RID).val() ).toFixed(2);  
			var TotalTon = document.getElementById('TotalTon'+RID).value; 
			if(OpportunityID!='' && OpportunityID!=0 && MaterialID!='' && BookingType!='' ){ 
				var temp = new Array();
				temp = BookingDateTime.split(",");
				var temp_count = temp.length;
				for (i = 0; i < temp.length; i++) { 
					var dt = new Array();
					dt = temp[i].split("/");
					
					temp[i] = dt[2]+'-'+dt[1]+'-'+dt[0];
					//alert(temp[i]);
				}  
				temp.sort();
				if(BookingDateTime!=""){
					var DateRequired = temp[0]; 
					var HitUrl = baseURL + "ShowOppoProductPriceAJAX"; 
					$.ajax({
						type : "POST",
						dataType : "json",
						url : HitUrl,
						data : { 'OpportunityID' : OpportunityID,'MaterialID' : MaterialID,'DateRequired' : DateRequired } 
						}).success(function(data){  
						
							var Prc = Price;
							if(data.Price){
								var Prc = data.Price;
							} 
							if(Prc!='' || Prc!='0' ){ 
								$( "#Price"+RID).val(parseFloat((Prc)).toFixed(2));  
							}else{ 
								$( "#Price"+RID).val(0);  Prc = 0; 
							} 	  
								 
									console.log(parseFloat(Prc*TotalTon*temp_count).toFixed(2));
									$( "#Total"+RID).html(parseFloat(Prc*TotalTon*temp_count).toFixed(2)); 
									$( "#TotalHidden"+RID).val(parseFloat(Prc*TotalTon*temp_count).toFixed(2));  
							 
							if(data.PriceDate){
								if(data.PriceDate!=""){
									$( "#pdate"+RID).html('<b>PriceDate:</b> '+data.PriceDate);  	
								}else{ $( "#pdate"+RID).html(''); }
							}else{ $( "#pdate"+RID).html(''); }
							
							var TotalHidden = document.getElementsByName('TotalHidden[]'); 
							let SubTotal = 0;   
							 
							$(".TH").each(function() {   
								if(!isNaN(this.value) && this.value.length!=0) {
									SubTotal += parseFloat(this.value);
								} 
							}); 
							
							$("#SubTotal").html(SubTotal.toFixed(2));  
							$("#PriceSubTotal").val(SubTotal); 
							
							var Vat = parseFloat((SubTotal*20)/100).toFixed(2);
							$("#Vat").html(Vat); 
							$("#PriceVat").val(Vat); 
							
							var AllTotal = (parseFloat(SubTotal)+parseFloat(Vat)).toFixed(2);
							$("#AllTotal").html(AllTotal);  
							$("#TotalAmount").val(AllTotal);  
							  
					});   
				}else{  
					//$( "#Price"+RID).val('');  
					//$( "#pdate"+RID).html('');  
					//$( "#Total"+RID).html(0); 
					//$( "#TotalHidden"+RID).val(0); 
				} 
			}else{ 	//$( "#Price"+RID).val('');  
					//$( "#pdate"+RID).html('');  
					//$( "#Total"+RID).html(0); 
					//$( "#TotalHidden"+RID).val(0);  
			}  
			
			 
		});	  
		$("input[name$='PaymentType']").click(function() {
			var pvalue = $(this).val(); 
			if(pvalue!=0){
				$("div.pblock").show();
			}else{
				$("div.pblock").hide();
			}
		}); 
    });    	 
	
	
</script>

 
<script src="<?php echo base_url('assets/js/Booking1.js'); ?>" type="text/javascript"></script> 