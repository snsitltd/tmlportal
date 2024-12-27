<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper"> 
    <section class="content-header"><h1><i class="fa fa-users"></i> Add Booking </h1></section>  
    <section class="content">
	
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements --> 
                <div class="box box-primary">
                    <div class="box-header"> <h3 class="box-title">Booking Information</h3> </div>  
					<div id="result"></div>  
                    <?php $this->load->helper("form"); ?>
                    <form id="AddBooking" name="AddBooking"  action="<?php echo base_url('AddBookingRequest'); ?>"  method="post" role="form" > 
                        <div class="box-body">
                        <div class="col-md-6">     
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyID">Select Company <span class="required">*</span></label>
                                        <select class="form-control select_company " id="CompanyID" name="CompanyID" required="required" data-live-search="true"   >
										<option value="">-- ADD COMPANY --</option>
                                        <?php  foreach ($company_list as $key => $value) { ?>
                                          <option value="<?php echo $value['CompanyID'] ?>"><?php echo $value['CompanyName'] ?></option>
                                        <?php } ?>
                                        </select>  <input type="hidden" id="CompName"  name="CompName"  >
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
							<div class="row">
								<div class="col-md-4"> 
										<label for="TypeOfCustomer"> Type of Payment: </label> <span id="PType" >N/A</span> 
									 
								</div>  
								<div class="col-md-4"> 
										<label for="CreditLimit"> Credit Limit: </label> <span id="CreditLimit" >N/A</span> 
								 
								</div>   
								<div class="col-md-4"> 
										<label for="Outstanding">Outstanding: </label> <span id="Outstanding" >N/A</span> 
									 
								</div>   
							</div>   
							<hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="OpportunityID">Opportunity <span class="required">*</span></label> 
                                        <select class="form-control select_opportunity " id="OpportunityID" name="OpportunityID" required="required" data-live-search="true"   >
											<option value="">-- ADD OPPORTUNITY --</option>                                        
                                        </select> <input type="hidden" id="OppoName"  name="OppoName"  ><div ></div>
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
                        </div> 
						<div class="col-md-6">                              
                           
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyID">Select Contact <span class="required">*</span></label>
                                        <select class="form-control select_contact " id="ContactID" name="ContactID" required="required" data-live-search="true"   >
										<option value="0">-- ADD CONTACT --</option> 
                                        </select>  <div ></div>	  
                                    </div>
                                </div>
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Site Contact Name </label>
										<input type="text" class="form-control" id="ContactName"  required="required" value="<?php echo set_value('ContactName'); ?>" name="ContactName" maxlength="255"  > 
                                    </div>
                                </div>  
							</div>	
							<div class="row"> 
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="CompanyName">Site Contact Mobile</label>
										<input type="text" class="form-control" id="ContactMobile"  required="required" value="<?php echo set_value('ContactMobile'); ?>" name="ContactMobile" maxlength="11"  > 
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ContactEmail">Email Address </label>
                                        <input type="text" class="form-control " id="ContactEmail" value="<?php echo set_value('ContactEmail'); ?>" name="ContactEmail"  maxlength="255" >
                                    </div>
                                </div>  			
                            </div>  
							 <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="WaitingTime"> Waiting Time (Minute) </label>
                                        <input type="number" class="form-control " id="WaitingTime" value="15" name="WaitingTime" maxlength="10" >
                                    </div>
                                </div>  
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="WaitingCharge"> Wait Charges (1 &pound;/Minute) </label>
                                        <input type="number" class="form-control " id="WaitingCharge" value="1" name="WaitingCharge" maxlength="5" >
                                    </div>
                                </div>   
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PurchaseOrderNumber">Purchase Order  </label>
                                        <input type="text" class="form-control " id="PurchaseOrderNumber" value="<?php echo set_value('PurchaseOrderNumber'); ?>" name="PurchaseOrderNumber">
                                    </div>
                                </div>                
								<div class="col-md-6">
                                    <div class="form-group"> 
                                        <label for="PriceBy">Price By  </label>
                                        <select class="form-control" id="PriceBy" name="PriceBy" data-live-search="true"   >
										<option value="">-- Select --</option>
                                        <?php  foreach ($ApprovalUserList as $key => $value) { ?>
                                          <option value="<?php echo $value['userId'] ?>"><?php echo $value['name'] ?></option>
                                        <?php } ?> 
                                        </select>  <div ></div>	  
                                    </div>
                                </div>  
                            </div>  
							<div class="row">                                			
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="Notes" rows="3" name="Notes"></textarea>
                                    </div>
                                </div>  
                            </div>   
							
						</div>  
						
						
						<div class="col-md-12">  
							<div class="row">  	
							  <table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
							  <thead>
								<tr>                          
									<th width="50" >Booking Type</th> 
									<th width="200" >Material </th>   
									<th width="50" >Load Type </th>
									<th width="50" >Lorry Type </th>
									<th width="50" >Loads/Lorry</th> 
									<th width="100" >Request Date </th> 
									<th width="50" >Price </th>
									<th width="50" >Total</th> 
								</tr>
								</thead>  
								<tbody id="tbody"> 
								
								<tr id="1"> 
										<td>
											<select class="form-control BookingType" id="BookingType1" data-BID="1" name="BookingType[]" required="required"  >
												<option value="">Booking Type</option>                                        
												<option value="1">Collection</option>                                          
												<option value="2">Delivery</option>                                        
											</select><div ></div>
										</td>
										<td>
											<select class="form-control Material" id="DescriptionofMaterial1" name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
												<option value="">Select Material Type</option> 
											</select><div ></div>
										</td>
										<td>
											<select class="form-control LoadType" id="LoadType1" name="LoadType[]" required="required"  > 
												<option value="1">Loads</option>                                          
												<option value="2">TurnAround</option>                                        
											</select> 
										</td>
										<td>
											<select class="form-control LorryType" id="LorryType1" name="LorryType[]"  data-live-search="true" >  
												<option value="" <?php if(set_value('LorryType') =="" ) { ?> selected <?php } ?> >Select</option> 
												<option value="1" <?php if(set_value('LorryType') ==1 ) { ?> selected <?php } ?> >Tipper</option> 
												<option value="2" <?php if(set_value('LorryType') ==2 ) { ?> selected <?php } ?> >Grab</option> 
												<option value="3" <?php if(set_value('LorryType') ==3 ) { ?> selected <?php } ?> >Bin</option> 
                                        </select>   
										</td> 
										<td>
											<select class="form-control Loads" id="Loads1" name="Loads[]" required="required"   data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i == set_value('Loads')) { ?> selected <?php } ?> ><?php echo $i; ?></option>
                                            <?php } ?>
											</select>    
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" data-BID='1' id="BookingDateTime1" autocomplete="off" value="" name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td>
											<input type="text" class="form-control Price" id="Price1" data-BID="1"    name="Price[]" value="" > 
											<span id="pdate1" style="font-size:12px"></span>
										</td>
										</td>
										<td>
											<span id="Total1" style="font-size:12px"></span>
											<input type="hidden" id="TotalHidden1"  name="TotalHidden[]"  > 
										</td> 
									</tr>  
									
								</tbody>
							  </table> 
								<button class="btn btn-md btn-primary"  id="addBtn" type="button">  Add Load  </button>
							</div>
						</div> 
						
						
						
						<div class="col-md-12">      
							<h4 class="box-title"><b>Loads/Lorry Information</b></h4>
						</div>  	
						<!-- <div class="col-md-12">  
							<div class="row">  					
								<table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
								  <thead>
									<tr>                          
										<th width="50" >Booking Type</th> 
										<th width="200" >Material </th>   
										<th width="50" >Load Type </th>
										<th width="50" >Lorry Type </th>
										<th width="50" >Loads/Lorry</th> 
										<th width="100" >Request Date </th> 
										<th width="50" >Price </th>
										<th width="50" >Total</th>
										
									</tr>
									</thead> 
									<tbody> 	
									<tr> 
										<td>
											<select class="form-control BookingType" id="BookingType1" data-BID="1" name="BookingType[]" required="required"  >
												<option value="">Booking Type</option>                                        
												<option value="1">Collection</option>                                          
												<option value="2">Delivery</option>                                        
											</select><div ></div>
										</td>
										<td>
											<select class="form-control Material" id="DescriptionofMaterial1" name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
												<option value="">Select Material Type</option> 
											</select><div ></div>
										</td>
										<td>
											<select class="form-control LoadType" id="LoadType1" name="LoadType[]" required="required"  > 
												<option value="1">Loads</option>                                          
												<option value="2">TurnAround</option>                                        
											</select> 
										</td>
										<td>
											<select class="form-control LorryType" id="LorryType1" name="LorryType[]"  data-live-search="true" >  
												<option value="" <?php if(set_value('LorryType') =="" ) { ?> selected <?php } ?> >Select</option> 
												<option value="1" <?php if(set_value('LorryType') ==1 ) { ?> selected <?php } ?> >Tipper</option> 
												<option value="2" <?php if(set_value('LorryType') ==2 ) { ?> selected <?php } ?> >Grab</option> 
												<option value="3" <?php if(set_value('LorryType') ==3 ) { ?> selected <?php } ?> >Bin</option> 
                                        </select>   
										</td> 
										<td>
											<select class="form-control Loads" id="Loads1" name="Loads[]" required="required"   data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i == set_value('Loads')) { ?> selected <?php } ?> ><?php echo $i; ?></option>
                                            <?php } ?>
											</select>    
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" data-BID='1' id="BookingDateTime1" autocomplete="off" value="" name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td>
											<input type="text" class="form-control Price" id="Price1" data-BID="1"    name="Price[]" value="" > 
											<span id="pdate1" style="font-size:12px"></span>
										</td>
										</td>
										<td>
											<span id="Total1" style="font-size:12px"></span>
											<input type="hidden" id="TotalHidden1"  name="TotalHidden[]"  > 
										</td> 
									</tr>  
									<tr> 
										<td>
											<select class="form-control BookingType" id="BookingType2" data-BID="2"  name="BookingType[]" required="required"  >
												<option value="">Booking Type</option>                                        
												<option value="1">Collection</option>                                          
												<option value="2">Delivery</option>                                        
											</select>
										</td>
										<td>
											<select class="form-control   Material" id="DescriptionofMaterial2" name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
												<option value="">Select Material Type</option> 
											</select>
										</td>
										<td>
											<select class="form-control LoadType" id="LoadType2" name="LoadType[]" required="required"  > 
												<option value="1">Loads</option>                                          
												<option value="2">TurnAround</option>                                        
											</select> 
										</td>
										<td>
											<select class="form-control LorryType" id="LorryType2" name="LorryType[]"  data-live-search="true" >  
												<option value="" >Select</option> 
												<option value="1" >Tipper</option> 
												<option value="2" >Grab</option> 
												<option value="3" >Bin</option> 
                                        </select>   
										</td> 
										<td>
											<select class="form-control Loads" id="Loads2" name="Loads[]" required="required"   data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>"   ><?php echo $i; ?></option>
                                            <?php } ?>
											</select>    
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" data-BID='2'  id="BookingDateTime2" autocomplete="off" value="" name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td><input type="text" class="form-control Price" id="Price2" data-BID="2" name="Price[]" value="" > 
										<span id="pdate2" style="font-size:12px"></span></td>
										<td>
											<span id="Total2" style="font-size:12px"></span>
											<input type="hidden" id="TotalHidden2"  name="TotalHidden[]"  > 
										</td> 
										
									</tr>  
									<tr> 
										<td>
											<select class="form-control BookingType" id="BookingType3" data-BID="3"  name="BookingType[]" required="required"  >
												<option value="">Booking Type</option>                                        
												<option value="1">Collection</option>                                          
												<option value="2">Delivery</option>                                        
											</select>
										</td>
										<td>
											<select class="form-control   Material" id="DescriptionofMaterial3" name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
												<option value="">Select Material Type</option> 
											</select>
										</td>
										<td>
											<select class="form-control LoadType" id="LoadType3" name="LoadType[]" required="required"  > 
												<option value="1">Loads</option>                                          
												<option value="2">TurnAround</option>                                        
											</select> 
										</td>
										<td>
											<select class="form-control LorryType" id="LorryType3" name="LorryType[]"  data-live-search="true" >  
												<option value=""  >Select</option> 
												<option value="1"  >Tipper</option> 
												<option value="2"  >Grab</option> 
												<option value="3"  >Bin</option> 
                                        </select>   
										</td> 
										<td>
											<select class="form-control Loads" id="Loads3" name="Loads[]" required="required"   data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i == set_value('Loads')) { ?> selected <?php } ?> ><?php echo $i; ?></option>
                                            <?php } ?>
											</select>    
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" id="BookingDateTime3" data-BID='3' autocomplete="off" value="" name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td><input type="text" class="form-control Price" id="Price3" data-BID="3" name="Price[]" > 
										<span id="pdate3" style="font-size:12px"></span></td>
										<td>
											<span id="Total3" style="font-size:12px"></span>
											<input type="hidden" id="TotalHidden3"  name="TotalHidden[]"  > 
										</td>  
									</tr>    
									
									<tr> 
										<td>
											<select class="form-control BookingType" id="BookingType4" data-BID="4"  name="BookingType[]" required="required"  >
												<option value="">Booking Type</option>                                        
												<option value="1">Collection</option>                                          
												<option value="2">Delivery</option>                                        
											</select>
										</td>
										<td>
											<select class="form-control   Material" id="DescriptionofMaterial4" name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
												<option value="">Select Material Type</option> 
											</select>
										</td>
										<td>
											<select class="form-control LoadType" id="LoadType4" name="LoadType[]" required="required"  > 
												<option value="1">Loads</option>                                          
												<option value="2">TurnAround</option>                                        
											</select> 
										</td>
										<td>
											<select class="form-control LorryType" id="LorryType4" name="LorryType[]"  data-live-search="true" >  
												<option value="" <?php if(set_value('LorryType') =="" ) { ?> selected <?php } ?> >Select</option> 
												<option value="1" <?php if(set_value('LorryType') ==1 ) { ?> selected <?php } ?> >Tipper</option> 
												<option value="2" <?php if(set_value('LorryType') ==2 ) { ?> selected <?php } ?> >Grab</option> 
												<option value="3" <?php if(set_value('LorryType') ==3 ) { ?> selected <?php } ?> >Bin</option> 
                                        </select>   
										</td> 
										<td>
											<select class="form-control Loads" id="Loads4" name="Loads[]" required="required"   data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i == set_value('Loads')) { ?> selected <?php } ?> ><?php echo $i; ?></option>
                                            <?php } ?>
											</select>    
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" id="BookingDateTime4" data-BID='4' autocomplete="off" value="" name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td><input type="text" class="form-control Price" id="Price4" data-BID="4" name="Price[]" > 
										<span id="pdate4" style="font-size:12px"></span></td>
										<td>
											<span id="Total4" style="font-size:12px"></span>
											<input type="hidden" id="TotalHidden4"  name="TotalHidden[]"  > 
										</td>  
									</tr>   
									
									<tr> 
										<td>
											<select class="form-control BookingType" id="BookingType5" data-BID="5"  name="BookingType[]" required="required"  >
												<option value="">Booking Type</option>                                        
												<option value="1">Collection</option>                                          
												<option value="2">Delivery</option>                                        
											</select>
										</td>
										<td>
											<select class="form-control   Material" id="DescriptionofMaterial5" name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
												<option value="">Select Material Type</option> 
											</select>
										</td>
										<td>
											<select class="form-control LoadType" id="LoadType5" name="LoadType[]" required="required"  > 
												<option value="1">Loads</option>                                          
												<option value="2">TurnAround</option>                                        
											</select> 
										</td>
										<td>
											<select class="form-control LorryType" id="LorryType5" name="LorryType[]"  data-live-search="true" >  
												<option value="" <?php if(set_value('LorryType') =="" ) { ?> selected <?php } ?> >Select</option> 
												<option value="1" <?php if(set_value('LorryType') ==1 ) { ?> selected <?php } ?> >Tipper</option> 
												<option value="2" <?php if(set_value('LorryType') ==2 ) { ?> selected <?php } ?> >Grab</option> 
												<option value="3" <?php if(set_value('LorryType') ==3 ) { ?> selected <?php } ?> >Bin</option> 
                                        </select>   
										</td> 
										<td>
											<select class="form-control Loads" id="Loads5" name="Loads[]" required="required"   data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i == set_value('Loads')) { ?> selected <?php } ?> ><?php echo $i; ?></option>
                                            <?php } ?>
											</select>    
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" id="BookingDateTime5" data-BID='5' autocomplete="off" value="" name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td><input type="text" class="form-control Price" id="Price5" data-BID="5" name="Price[]" > 
										<span id="pdate5" style="font-size:12px"></span></td>
										<td>
											<span id="Total5" style="font-size:12px"></span>
											<input type="hidden" id="TotalHidden5"  name="TotalHidden[]"  > 
										</td>  
									</tr>   
									
									<tr> 
										<td>
											<select class="form-control BookingType" id="BookingType6" data-BID="6"  name="BookingType[]" required="required"  >
												<option value="">Booking Type</option>                                        
												<option value="1">Collection</option>                                          
												<option value="2">Delivery</option>                                        
											</select>
										</td>
										<td>
											<select class="form-control   Material" id="DescriptionofMaterial6" name="DescriptionofMaterial[]" required="required" data-live-search="true"  >
												<option value="">Select Material Type</option> 
											</select>
										</td>
										<td>
											<select class="form-control LoadType" id="LoadType6" name="LoadType[]" required="required"  > 
												<option value="1">Loads</option>                                          
												<option value="2">TurnAround</option>                                        
											</select> 
										</td>
										<td>
											<select class="form-control LorryType" id="LorryType6" name="LorryType[]"  data-live-search="true" >  
												<option value="" <?php if(set_value('LorryType') =="" ) { ?> selected <?php } ?> >Select</option> 
												<option value="1" <?php if(set_value('LorryType') ==1 ) { ?> selected <?php } ?> >Tipper</option> 
												<option value="2" <?php if(set_value('LorryType') ==2 ) { ?> selected <?php } ?> >Grab</option> 
												<option value="3" <?php if(set_value('LorryType') ==3 ) { ?> selected <?php } ?> >Bin</option> 
                                        </select>   
										</td> 
										<td>
											<select class="form-control Loads" id="Loads6" name="Loads[]" required="required"   data-live-search="true" > 
                                            <?php for($i=1;$i<100;$i++){ ?>
                                                    <option value="<?php echo $i; ?>" <?php if($i == set_value('Loads')) { ?> selected <?php } ?> ><?php echo $i; ?></option>
                                            <?php } ?>
											</select>    
										</td>
										<td>
											<div class="input-group date">
												<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
												<input type="text" class="form-control required BookingDateTime" id="BookingDateTime6" data-BID='6' autocomplete="off" value="" name="BookingDateTime[]" maxlength="65">
											</div>  
											<div ></div> 										
										</td>
										<td><input type="text" class="form-control Price" id="Price6" data-BID="6" name="Price[]" > 
										<span id="pdate6" style="font-size:12px"></span></td>
										<td>
											<span id="Total6" style="font-size:12px"></span>
											<input type="hidden" id="TotalHidden6"  name="TotalHidden[]"  > 
										</td>  
									</tr>   
									 
									
									<tr> 
										<td colspan="6"> </td> 
										<td><b>SubTotal</b> </td>
										<td><span id="SubTotal"></span>
										<input type="hidden" id="PriceSubTotal"  name="SubTotalAmount"  > 
										</td> 
									</tr> 
									<tr> 
										<td colspan="6"> </td> 
										<td><b>VAT (20%)</b></td>
										<td><span id="Vat"></span><input type="hidden" id="PriceVat"  name="VatAmount"  > </td> 
									</tr> 
									<tr> 
										<td colspan="6"> </td> 
										<td><b>Total</b></td>
										<td><span id="AllTotal"></span></td> 
									</tr> 
									</tbody>
								  </table> 
							</div>  -->
						</div>
						<div id="nilay"></div>	
						<div class="col-md-12">      
							<h4 class="box-title"><b>Payment Information</b></h4>
						</div>  	 
						<div class="col-md-12">  
							<div class="row"> 
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Type Of Payment </label>
                                        <div class="checkbox">  
											<label> <input type="radio" name="PaymentType" id="PaymentType" value="0" checked > Credit  </label>
											<label> <input type="radio" name="PaymentType" id="PaymentType" value="1" > Cash /Card </label> 
                                        </div> 
										<!-- <input type="text" class="form-control " id="PaymentType" value="<?php //echo set_value('PaymentType'); ?>" name="PaymentType" maxlength="20" >
										<i id='pdate'></i> -->
                                    </div>
                                </div>    
							</div>
							<div class="pblock" style="display: none;" > 
								<div class="row"> 
									<div class="col-md-3">
										<div class="form-group">
											<label for="Price">Amount</label>
											<input type="text" class="form-control " id="TotalAmount" value="<?php echo set_value('TotalAmount'); ?>" name="TotalAmount" maxlength="20" >
											<i id='pdate111'></i>
										</div>
									</div>    
								</div>
								<div class="row">                                			
									<div class="col-md-3">
										<div class="form-group">
											<label for="notes">Payment Ref/Notes</label>
											<textarea class="form-control" id="PaymentRefNo" rows="3" name="PaymentRefNo"></textarea>
										</div>
									</div>  
								</div>    
							</div>
                        </div>  
						
						<div class="col-md-12">   
                             <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">   
										<input type="submit" name="submit" style="" class="btn btn-primary" value="Submit" /> 
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
		var rowIdx = 2; 
		 
		// jQuery button click event to add a row.
		$('#addBtn').on('click', function () {  
			var Append = '<tr id="'+rowIdx+'" ><td><select class="form-control BookingType" id="BookingType'+rowIdx+'" data-BID="'+rowIdx+'" name="BookingType[]" required="required"  ></select><div ></div></td>';
			Append += '<td><select class="form-control Material " id="DescriptionofMaterial'+rowIdx+'" name="DescriptionofMaterial[]" required="required" data-live-search="true"  ></select><div ></div></td>'; 
			Append += '<td><select class="form-control LoadType" id="LoadType'+rowIdx+'" name="LoadType[]" required="required"  > <option value="1">Loads</option><option value="2">TurnAround</option></select> </td>'; 
			Append += '<td><select class="form-control LorryType" id="LorryType'+rowIdx+'" name="LorryType[]"  data-live-search="true" ><option value="" >Select</option><option value="1" >Tipper</option><option value="2" >Grab</option><option value="3" >Bin</option></select></td>'; 
			Append += '<td><select class="form-control Loads" id="Loads'+rowIdx+'" name="Loads[]" required="required"   data-live-search="true" >';
			for (i=1; i<=25; i++){   Append += '<option value="'+i+'"  >'+i+'</option>'; }  
 			Append += '</select></td>'; 
			Append += '<td><div class="input-group date"><div class="input-group-addon"><i class="fa fa-calendar"></i></div><input type="text" class="form-control required BookingDateTime" data-BID="'+rowIdx+'" id="BookingDateTime'+rowIdx+'" autocomplete="off" value="" name="BookingDateTime[]" maxlength="65"></div><div ></div></td>'; 
			Append += '<td><input type="text" class="form-control Price" id="Price1" data-BID="'+rowIdx+'"    name="Price[]" value="" ><span id="pdate1" style="font-size:12px"></span></td>'; 
			Append += '<td><span id="Total1" style="font-size:12px"></span><input type="hidden" id="TotalHidden1"  name="TotalHidden[]"  > </td> </tr>'; 
			$('#tbody').append(Append); 	 
			var BTOptions = '<option value="">Booking Type</option><option value="1">Collection</option><option value="2">Delivery</option>';
			$("#BookingType"+rowIdx).html(BTOptions).selectpicker('refresh'); 
			
			var MTOptions = '<option value="">Select Material Type</option> ';
			$("#DescriptionofMaterial"+rowIdx).html(MTOptions).selectpicker('refresh'); 
			//$('.BookingType').selectpicker('refresh');
			//$('.Material').selectpicker('refresh'); 
			rowIdx++; 	
 		});
		$("#addBtn7777").on('click',function(){ 
	
			var id=rowIdx;    
			if(id!=0){  
			jQuery.ajax({
				type : "POST",
				dataType : "json",
				url: baseURL+"/AddNewLoad",
				data : { id : id } 
				}).done(function(data){ 
					//console.log(data);   
					//alert(data)					
		 $('#nilay').html(data);
				}); 
			} 
			
		});  
		  
      // jQuery button click event to remove a row.
     /* $('#tbody').on('click', '.remove', function () {
  
        // Getting all the rows next to the row
        // containing the clicked button
        var child = $(this).closest('tr').nextAll();
  
        // Iterating across all the rows 
        // obtained to change the index
        child.each(function () {
  
          // Getting <tr> id.
          var id = $(this).attr('id');
  
          // Getting the <p> inside the .row-index class.
          var idx = $(this).children('.row-index').children('p');
  
          // Gets the row number from <tr> id.
          var dig = parseInt(id.substring(1));
  
          // Modifying row index.
          idx.html(`Row ${dig - 1}`);
  
          // Modifying row id.
          $(this).attr('id', `R${dig - 1}`);
        });
  
        // Removing the current row.
        $(this).closest('tr').remove();
  
        // Decreasing total number of rows by 1.
        rowIdx--;
      }); */
	  
	  
 		
		$('.BookingDateTime').datepicker({  
			format: 'dd/mm/yyyy', 
			startDate: 'today', 
			multidate: 6,
			daysOfWeekDisabled  : [0], 
			closeOnDateSelect: true
		});  
		$(".Material").on('change',function(){
		  $('.BookingDateTime').click();
		}); 
		$(".LoadType").on('change',function(){
		  $('.BookingDateTime').click();
		});
		$(".Loads").on('change',function(){
		  $('.BookingDateTime').click();
		});
		$(".Price").on('change',function(){  
		
			var PriceVal=$(this).val();  
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
			for (var i = 0; i < TotalHidden.length; i++) { 
				//alert(TotalHidden[i].value);
				//alert(document.getElementById('TotalHidden'+i));
				SubTotal += parseInt(TotalHidden[i].value);   
				//SubTotal += parseFloat(SubTotal+TotalHidden[i].value).toFixed(2);    
			}  
			$("#SubTotal").html(SubTotal);  
			$("#PriceSubTotal").val(SubTotal); 
			
			var Vat = (SubTotal*20/100)
			$("#Vat").html(Vat); 
			$("#PriceVat").val(Vat); 
			
			var AllTotal = (SubTotal+Vat)
			$("#AllTotal").html(AllTotal);  
			$("#TotalAmount").val(AllTotal);   
		});  
		$(".BookingType").on('change',function(event){  
		alert("asdfasdf");
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
							var options = '<option value="">Select Material Type</option>';
							for (var i = 0; i < data.material_list.length; i++) {
								options += '<option value="' + data.material_list[i].MaterialID + '">' + data.material_list[i].MaterialName + '</option>';
							} 
							$("select#DescriptionofMaterial"+RID).html(options);  
							$('#DescriptionofMaterial'+RID).selectpicker('refresh');   
						} 
						$('.BookingDateTime').click();	
				}); 
			} 
			 
		}); 
		$('.BookingDateTime , .LoadType , .Loads , .BookingType').datepicker().on('changeDate click', function (ev) { 
			//alert(val('#BookingDateTime'));
			//var BookingDateTime = $( "#BookingDateTime").val();
			var BookingDateTime = $(this).val();  
			var RID = $(this).attr("data-BID");
			var OpportunityID = $( "#OpportunityID").val();
			var MaterialID = $( "#DescriptionofMaterial"+RID).val();  
			var BookingType = $( "#BookingType"+RID).val();  
			var Loads = $( "#Loads"+RID).val();  
			var LoadType = $( "#LoadType"+RID).val();   
             
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
							var Prc = 0;
							if(data.Price){
								var Prc = data.Price;
							} 
							if(Prc!='' || Prc!='0' ){ 
								$( "#Price"+RID).val(parseFloat((Prc)).toFixed(2));  
							}else{ $( "#Price"+RID).val(0);  Prc = 0; } 	

							if(LoadType==1){ 
								$( "#Total"+RID).html(parseFloat(Prc*Loads*temp_count).toFixed(2)); 
								$( "#TotalHidden"+RID).val(parseFloat(Prc*Loads*temp_count).toFixed(2)); 
							}else{
								$( "#Total"+RID).html('N/A'); 
								$( "#TotalHidden"+RID).val(0); 
							}
							 
							if(data.PriceDate){
								if(data.PriceDate!=""){
									$( "#pdate"+RID).html('<b>PriceDate:</b> '+data.PriceDate);  	
								}else{ $( "#pdate"+RID).html(''); }
							}
							
							var TotalHidden = document.getElementsByName('TotalHidden[]');
							var SubTotal = 0; 
							for (var i = 0; i < TotalHidden.length; i++) { 
								//alert(TotalHidden[i].value);
								//alert(document.getElementById('TotalHidden'+i));
								SubTotal += parseInt(TotalHidden[i].value);   
								//SubTotal += parseFloat(SubTotal+TotalHidden[i].value).toFixed(2);    
							}   
							
							$("#SubTotal").html(SubTotal);  
							$("#PriceSubTotal").val(SubTotal); 
							 
							var Vat = (SubTotal*20/100)
							$("#Vat").html(Vat); 
							$("#PriceVat").val(Vat); 
							
							var AllTotal = (SubTotal+Vat)
							$("#AllTotal").html(AllTotal);  
							$("#TotalAmount").val(AllTotal); 
							
					});   
				}else{ 	
					$( "#Price"+RID).val('');  
					$( "#pdate"+RID).html('');  
					$( "#Total"+RID).html(0); 
					$( "#TotalHidden"+RID).val(0); 
				} 
			}else{ 	$( "#Price"+RID).val('');  
					$( "#pdate"+RID).html('');  
					$( "#Total"+RID).html(0); 
					$( "#TotalHidden"+RID).val(0);  
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