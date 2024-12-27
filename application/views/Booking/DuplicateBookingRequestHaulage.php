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
                    <form id="AddBooking" name="AddBooking"  action="<?php echo base_url('DuplicateBookingRequestHaulage/'.$BookingRequest['BookingRequestID']); ?>"  method="post" role="form" > 
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
									<th  > Destination Address</th>    
									<th width="50"  >SIC Code </th>   
									
									<th width="50" >Load Type </th>
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
									foreach($BookingDates as $key=>$record){  $i=0; ?>
								<tr id="<?php echo $i; ?>"> 
										<td> 
										<input type="hidden" id="BookingType<?php echo $i; ?>"   name="BookingType[]"  value = '4'  > 
										<input type="hidden" id="DescriptionofMaterial<?php echo $i; ?>"    name="DescriptionofMaterial[]"  value = '495'  > 
										<input type="hidden" id="MaterialName<?php echo $i; ?>"  name="MaterialName[]" value = 'Haulage'  >  	
										<input type="hidden" id="TipID<?php echo $i; ?>"    name="TipID[]" value="<?php echo $record->TipID; ?>" >      
										<input type="text" readonly id="TipName<?php echo $i; ?>"  class="form-control  "  name="TipName[]" value="<?php echo $record->TipName; ?>" required="required" placeholder="TipName"    >     
										<div ></div>  
										</td>    
										<td><input type="text" class="form-control" id="SICCode<?php echo $i; ?>"  style="text-align:right"  name="SICCode[]" readonly value="<?php echo $record->SICCode; ?>" ></td> 
										 
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
										<td>
											<select class="form-control Loads" id="Loads<?php echo $i; ?>" name="Loads[]" required="required"     data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i == $record->Loads) { ?> selected <?php } ?> ><?php echo $i; ?></option>
                                            <?php } ?>
											</select>    
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" readonly data-BID='<?php echo $i; ?>' id="BookingDateTime<?php echo $i; ?>" autocomplete="off"  name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td>
											<input type="text" class="form-control" id="PurchaseOrderNo<?php echo $i; ?>"    name="PurchaseOrderNo[]" value="<?php echo $record->PurchaseOrderNo; ?>"  >  
											<div></div>
											<div class="checkbox"> 
												<label> <input type="checkbox" name="OpenPO[]" <?php if($record->OpenPO==1){ ?> checked <?php } ?>    value="1" id="OpenPO<?php echo $i; ?>"  > Open PO </label>
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
		  
	 	  //startDate: 'today',
 		$("body").on("click focus", ".BookingDateTime", function(){ 
			$('.BookingDateTime').datepicker({  
				format: 'dd/mm/yyyy',  
				//daysOfWeekDisabled  : [0], 
				multidate: 6, 
				closeOnDateSelect: true
			});  
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
			 
			//alert(MaterialID) 
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
		 
		$("body").on("change", ".Loads", function(){ 
		//$(".Loads").on('change',function(){
		  $('.BookingDateTime').click();
		});
		$("body").on("change", ".Price", function(){ 
		//$(".Price").on('change',function(){  
		
			var PriceVal = parseFloat($(this).val()).toFixed(2);  
			var RID = $(this).attr("data-BID");  
			var BookingDateTime = $( "#BookingDateTime"+RID).val();
			var temp = new Array();
				temp = BookingDateTime.split(",");
			var temp_count = temp.length; 
			var Loads = document.getElementById('Loads'+RID).value; 
			 
			if(PriceVal!=''){     	 
				$( "#Total"+RID).html(parseFloat(PriceVal*Loads*temp_count).toFixed(2)); 
				$( "#TotalHidden"+RID).val(parseFloat(PriceVal*Loads*temp_count).toFixed(2));  
			}  
			var TotalHidden = document.getElementsByName('TotalHidden[]');
			var SubTotal = 0;  
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
		 
		$("body").on("changeDate click", ".BookingDateTime , .LoadType , .Loads , .BookingType, #OpportunityID", function(){  
		//$('.BookingDateTime , .LoadType , .Loads , .BookingType').datepicker().on('changeDate click', function (ev) { 
			//alert(val('#BookingDateTime'));
			//var BookingDateTime = $( "#BookingDateTime").val(); 
			//alert("sdfsdf")
			var BookingDateTime = $(this).val();  
			var RID = $(this).attr("data-BID");
			var OpportunityID = $( "#OpportunityID").val();
			var MaterialID = $( "#DescriptionofMaterial"+RID).val();  
			var BookingType = $( "#BookingType"+RID).val();  
			var Loads = $( "#Loads"+RID).val();  
			var LoadType = $( "#LoadType"+RID).val();    
			var Price = parseFloat($( "#Price"+RID).val()).toFixed(2); 
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
							if(LoadType==1){ 
								if(Prc!='' || Prc!='0' ){ 
									$( "#Total"+RID).html(parseFloat(Prc*Loads*temp_count).toFixed(2)); 
									$( "#TotalHidden"+RID).val(parseFloat(Prc*Loads*temp_count).toFixed(2)); 
								} 
							}else{
								$( "#Total"+RID).html('N/A'); 
								$( "#TotalHidden"+RID).val(0); 
							} 
							if(data.PriceDate){
								if(data.PriceDate!=""){
									$( "#pdate"+RID).html('<b>PriceDate:</b> '+data.PriceDate);  	
								}else{ $( "#pdate"+RID).html(''); }
							}else{ $( "#pdate"+RID).html(''); }
							
							var TotalHidden = document.getElementsByName('TotalHidden[]'); 
							let SubTotal = 0.0;   
							 
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