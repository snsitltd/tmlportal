<div class="content-wrapper">   
	<section class="content-header"> <h1><i class="fa fa-users"></i> Opportunity Management  <small><?php echo $opInfo['OpportunityName']; ?></small>  </h1> </section>
	<section class="content"> 
		<h4> <b>Company Name: <a href="<?php echo base_url().'view-company/'.$opInfo['CompanyID']; ?>" ><?=$opInfo['CompanyName']?></a></b> 
		<a class="btn btn-sm btn-info" href="<?php echo base_url('edit-Opportunity-Company/'.$opInfo['OpportunityID']); ?>" title="Edit Company Name"> <i class="fa fa-pencil"></i></a>
		</h4>
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
			<div class="modal-dialog" style="width:1200px">  
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Booking Loads/Lorry Information </h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div> 
				  <div class="modal-body"></div> 
				  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div> 
				</div>
			</div>
		</div>  
        <div class="row"> 
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Opportunity details</a></li> 
              <li class=""><a href="#contact" data-toggle="tab" aria-expanded="false">Contacts</a></li>  
			  <li class=""><a href="#product" data-toggle="tab" aria-expanded="false">Products</a></li>  
			  <li class=""><a href="#Bookings" data-toggle="tab" aria-expanded="false">Bookings</a></li>   
			  <li class=""><a href="#tickets" data-toggle="tab" aria-expanded="false">Tickets</a></li>    
			  <li class=""><a href="#tip" data-toggle="tab" aria-expanded="false">Tip</a></li>    
			  <li class=""><a href="#documents" data-toggle="tab" aria-expanded="false">Documents</a></li>  
              <li class=""><a href="#notes-tabs" data-toggle="tab" aria-expanded="false">Notes</a></li>    
            </ul> 
            <div class="tab-content"> 
              <div class="tab-pane active" id="activity">  
			  <form role="form" id="Opportunitysubmit" action="<?php echo base_url('edit-Opportunity/'.$opInfo['OpportunityID']) ?>" method="post" role="form"  >
					  <?php echo validation_errors(); ?>
					  <?php $this->load->helper("form"); ?> 
						<input type="hidden" name="OpportunityID" id="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
                        <div class="box-body">   
							 <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Status">Status</label>
                                       <select class="form-control required" id="Status" name="Status">
                                            <option value="1" <?php if($opInfo['Status']==1){ ?> selected <?php } ?> >Active</option>
                                            <option value="0" <?php if($opInfo['Status']==0){ ?> selected <?php } ?>  >InActive</option>                                            
                                        </select>
                                    </div>
                                </div> 
                            </div> 
							
							<div class="row">  	
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="OpportunityName">Site Address <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required OpportunityName" readonly id="OpportunityName" value="<?=$opInfo['OpportunityName']?>" name="OpportunityName" >
                                    </div>
                                </div> 
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="County">County <span class="required" aria-required="true">*</span></label>                                        
                                        <select class="form-control required County" id="County" name="County" data-live-search="true" >
                                            <option value="">Select County</option>
                                            <?php
                                            if(!empty($county)){
                                                foreach ($county as $rl){
                                                    ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if(trim($rl->County) == trim($opInfo['County'])) { ?>  selected <?php  } ?> ><?php echo $rl->County; ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select> <div ></div>
                                    </div>
                                </div>  
                            </div> 
                            <div class="row"> 
							<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Street1" id="Street1" value="<?=$opInfo['Street1']?>" name="Street1" maxlength="100">
                                    </div>
                                </div>   
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Town" id="Town" value="<?=$opInfo['Town']?>" name="Town">
                                    </div>
                                </div> 
                            </div>  
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2  </label>
                                        <input type="text" class="form-control Street2" id="Street2" value="<?=$opInfo['Street2']?>" name="Street2" maxlength="100">
                                    </div>
                                </div>  
                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required PostCode" id="PostCode" value="<?=$opInfo['PostCode']?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>             
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="careof">Care Of  </label>
                                        <input type="text" class="form-control " id="careof" value="<?=$opInfo['careof']?>" name="careof" maxlength="100">
                                    </div>
                                </div>             
                            </div>   
							<div class="row"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="OpenDate"> Open Date  </label>
										<div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                        <input type="text" class="form-control  " id="datepicker3" 
										<?php if($opInfo['OpenDate'] == NULL || $opInfo['OpenDate'] == '' || $opInfo['OpenDate'] == '1970-01-01' || $opInfo['OpenDate'] == '0000-00-00'   ){ ?>   <?php }else{ ?>   <?php } ?> value="<?php echo $opInfo['OpenDate1']; ?>"  name="OpenDate"  >
                                        </div> 
                                    </div> 
								 
									  <div class="form-group">
                                        <label for="WIFRequired"> WIF Required ? </label>
										<select class="form-control  " id="WIFRequired" name="WIFRequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['WIFRequired']=='0'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['WIFRequired']=='1'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['WIFRequired']=='2'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="WIF">WIF  </label>
                                        <input type="text" class="form-control  " id="WIF" value="<?=$opInfo['WIF']?>" name="WIF" >
                                    </div>
                                </div>  
                                <div class="col-md-3">
									<div class="form-group">
                                        <label for="StampRequired"> STAMP Required ?  </label>
										<select class="form-control  " id="StampRequired" name="StampRequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['StampRequired']=='0'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['StampRequired']=='1'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['StampRequired']=='2'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div> 
									
                                    <div class="form-group">
                                        <label for="Stamp">STAMP   </label>
										<textarea class="form-control  " id="Stamp" rows="5" name="Stamp" ><?php echo $opInfo['Stamp']?></textarea>
                                        <!-- <input type="text" class="form-control  " id="Stamp" value="<?=$opInfo['Stamp']?>" name="Stamp" > -->
                                    </div>
									
									
									
								</div>  
								 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="SiteInstRequired"> SITE INSTRUCTIONS Required ?  </label>
										<select class="form-control    " id="SiteInstRequired" name="SiteInstRequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['SiteInstRequired']=='0'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['SiteInstRequired']=='1'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['SiteInstRequired']=='2'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="SiteNotes">SITE INSTRUCTIONS Note(s)  </label>
                                        <textarea class="form-control  " id="SiteNotes" rows="5" name="SiteNotes" ><?=$opInfo['SiteNotes']?></textarea>
                                    </div> 
                                </div>  
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="PORequired"> PO Required ? </label>
										<select class="form-control    " id="PORequired" name="PORequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['PORequired']=='0'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['PORequired']=='1'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['PORequired']=='2'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="PO_Notes">PO Note(s)  </label>
                                        <textarea class="form-control  " id="PO_Notes"  rows="5" name="PO_Notes" ><?=$opInfo['PO_Notes']?></textarea>
                                    </div>
									
									
                                </div>  
                            </div>
							<div class="row"> 
								<div class="col-md-3">	
									<div class="form-group">
                                        <label for="TipTicketRequired"> TIP Ticket(S) Required ?  </label>
										<select class="form-control  " id="TipTicketRequired" name="TipTicketRequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['TipTicketRequired']=='0'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['TipTicketRequired']=='1'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['TipTicketRequired']=='2'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="TipName">TIP Notes </label>
                                        <textarea  class="form-control  " id="TipName_ACT" name="TipName_ACT" rows="5" ><?=$opInfo['TipName_ACT']?></textarea>
                                    </div>
									
									
									
                                </div> 
								<div class="col-md-3"> 
									<div class="form-group">
                                        <label for="TipName">TIP NAME(S) </label>
                                        <textarea  class="form-control  " readonly id="TipName"  name="TipName" rows="5" ><?=$opInfo['TipName']?></textarea>
                                    </div>
									
									
								
								
                                </div>  
								<?php  //var_dump($SiteContact); echo count($SiteContact); ?>
								
								<?php if(count($SiteContact)>0){ ?>
									<div class="col-md-3">	
										<div class="form-group">
											<label for="ContactName"><b>Site Contact Name :</b>  </label> 
											<input type="text" class="form-control  " id="ContactName" value="<?php echo $SiteContact[0]->ContactName; ?>" name="ContactName" maxlength="100">  
											<input type="hidden" value="<?php echo $SiteContact[0]->ContactID; ?>" name="ContactID" >  
										</div> 
										<div class="form-group">
											<label for="text"><b>Site Contact Mobile :</b> </label>
											<input type="text" class="form-control  " id="MobileNumber" value="<?php echo $SiteContact[0]->MobileNumber; ?>" name="MobileNumber" maxlength="14">   
										</div>
									</div>
								<?php }else{ ?>
									<div class="col-md-3">	
										<div class="form-group">
											<label for="ContactName"><b>Site Contact Name :</b>  </label> 
											<input type="text" class="form-control  " id="ContactName" value="<?php echo $opInfo['CUST_SiteContactName_024406636']; ?>" name="ContactName" maxlength="100">    
											<input type="hidden"  name="ContactID" >  
										</div> 
										<div class="form-group">
											<label for="text"><b>Site Contact Mobile :</b> </label>
											<input type="text" class="form-control  " id="MobileNumber" value="<?php echo $opInfo['CUST_Mobile_015736621']; ?>" name="MobileNumber" maxlength="14">   
										</div>
									</div>
								<?php } ?>
								<div class="col-md-3">	
									<div class="form-group">
                                        <label for="AccountNotes">Account Note(s)  </label>
                                        <textarea class="form-control " id="AccountNotes"  rows="3" name="AccountNotes" ><?=$opInfo['AccountNotes']?></textarea>
                                    </div>
								</div>	
								<!-- <div class="col-md-6">	
									<div class="form-group">
										<label for="ContactName"><b>Site Contact Name :</b>  <?php //echo $opInfo['CUST_SiteContactName_024406636']; ?> </label> 
                                        <input type="text" class="form-control  " id="CUST_SiteContactName_024406636" value="<?php //echo $opInfo['CUST_SiteContactName_024406636']; ?>" name="CUST_SiteContactName_024406636" maxlength="100">  
									</div> 
									<div class="form-group">
										<label for="text"><b>Site Contact Mobile :</b> <?php //echo $opInfo['CUST_Mobile_015736621']; ?> </label>
										<input type="text" class="form-control  " id="CUST_Mobile_015736621" value="<?php //echo $opInfo['CUST_Mobile_015736621']; ?>" name="CUST_Mobile_015736621" maxlength="100">   
									</div>
								</div>  -->
                            </div>   
                        </div> 
                        <div class="box-footer">
                            <input type="submit" name="submit" class="btn btn-primary" value="SAVE" />   
                        </div> 
              </form>
			  </div>
			  <div class="tab-pane" id="contact"> 
			  <div class="row" style="margin:3px">  
				<div class="box-body">
				<div class="row">
					<div class="col-xs-12 text-right">
						<div class="form-group">
							<a class="btn btn-primary" href="<?php echo base_url("Opportunity-AddContact/".$opInfo['OpportunityID']); ?>"><i class="fa fa-plus"></i> Add New</a>
						</div>
					</div>
				</div>
				
				  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">                   
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th width="50">S.No</th>
                        <th width="100">Title</th>
                        <th>Name</th>
                        <th width="200">Email</th>  
                        <th width="200">Position</th>                    
                        <th  width="100">Mobile Number</th>                     
                        <th  width="100" class="text-center">Actions</th>
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($opContactList))
                    {
                        foreach($opContactList as $key=>$record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><?php echo $record->Title ?></td>
                        <td><?php echo $record->ContactName ?></td>
                        <td><?php echo $record->EmailAddress ?></td> 
                        <td><?php echo $record->Position ?></td>                         
                        <td><?php echo $record->MobileNumber ?></td>                      
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'Opportunity-EditContact/'.$record->ContactID; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                           <!-- <a class="btn btn-sm btn-danger deleteContacts" href="#" data-ContactID="<?php echo $record->ContactID; ?>" title="Delete"><i class="fa fa-trash"></i></a> -->
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                  </table>
 
			  </div>
				</div>  
		
			  </div> 
			  </div>
			  
			  <div class="tab-pane" id="product"> 
			  <div class="row" style="margin:3px">  
				<div class="box-body">
				<div class="row">
					<div class="col-xs-12 text-right">
						<div class="form-group">
							<a class="btn btn-primary" href="<?php echo base_url("Opportunity-AddProduct/".$opInfo['OpportunityID']); ?>"><i class="fa fa-plus"></i> Add New</a>
						</div>
					</div>
				</div>
				  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">  
					<table id="exampleproduct" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
						<thead>
							<tr> 
							<th width="30" >Product Code</th>
								<th width="150" >Product Description</th>
								<th width="100" >Comments</th>
								
								<th width="20" class="text-right" >Qty</th>
								<th width="20"  >LoadType</th>
								<th width="20"  >LorryType</th>
								<th width="20" align="right" >No<br>Days</th> 
								<th width="40" >Date Required</th> 
								<th width="20" class="text-right"  >Price</th>                     
								<th width="100" >Purchase Order No</th>  
								<th width="20" class="text-right" >Booking No</th>  
								<th width="50" >PaymentRef</th>
								<th width="80" >PriceBy</th>  
								<th width="50" >JobNo</th>
								<th width="100" >Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php  if(!empty($product_list)){ 
								$i=1; foreach($product_list as $key=>$record){  ?>
							<tr> 
								<td><?php echo $record->MaterialCode;  ?></td>
								<td><?php echo $record->MaterialName;  ?></td>
								<td><?php echo $record->Comments;  ?></td>
								
								<td align="right" ><?php echo $record->Qty;  ?></td>
								<td align="right" ><?php if($record->TonBook == "1"){ echo "Tonnage"; }else{ if($record->LoadType == "1"){ echo "Load"; }else{  echo "TurnAround"; } } ?></td>
								<td>
								
								<?php if($record->BookingID > 0){  
										if($record->LorryType == "1"){ echo "Tipper"; }  if($record->LorryType == "2"){ echo "Grab"; }   if($record->LorryType == "3"){ echo "Bin"; } 
									}else{
										if($record->ProductLorryType == "1"){ echo "Tipper"; }  if($record->ProductLorryType == "2"){ echo "Grab"; }   if($record->ProductLorryType == "3"){ echo "Bin"; } 
									}		?> 								
								</td>  
								<td  align="right" > <?php echo $record->TotalDays; ?></td> 
								<td data-order="<?php echo $record->DateRequired1; ?>" > <?php echo $record->DateRequired; ?></td> 
								<td align="right" >£<?php echo $record->UnitPrice;  ?></td>                      
								<td><?php echo $record->PurchaseOrderNo;  ?></td>  
								<td  align="right"><?php if($record->BookingRequestID!=''){ ?><a href="<?php echo base_url('EditBookingRequest/'.$record->BookingRequestID); ?>" ><?php echo $record->BookingRequestID; ?></a><?php } ?></td>   
								<td><?php echo $record->PaymentRefNo;  ?></td>
								<td><?php  echo $record->PriceByName; ?></td>  
								<td><?php if($record->JobNo!=null ){ echo $record->JobNo; }else{ echo 'N/A'; } ?></td>  
								<td class="text-center">                            
									<a class="btn btn-sm btn-info" href="<?php echo base_url().'Opportunity-EditProduct/'.$record->productid; ?>" title="Edit"><i class="fa fa-pencil"></i></a> 
									<a href="#" class="btn btn-sm btn-danger  DeleteProduct" data-ProductID="<?php echo $record->productid; ?>"  title="Delete Product Price" > <i class="fa fa-trash"></i> </a> 
									<button class="btn btn-sm btn-warning OppoProductLogs" data-ProductID="<?php  echo $record->productid; ?>" title="Product Logs"><i class="fa fa-history "   title="View Product Logs" ></i></button> 
								</td>
							</tr>
						<?php  $i++; } }  ?>
						</tbody>
					</table>   
				  </div>
				</div>  
		
			  </div> 
			  </div>
			  <div class="tab-pane" id="tip"> 
			  <div class="row" style="margin:3px">   
				<div class="box-body">
				  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
					  <table id="exampletip" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
					  <thead>
						<tr>
							<th width="10">No</th>
							<th>Tip Name</th> 
							<th  width="100" >Town</th>
							<th  width="100" >County</th>
							<th width="150" >Tip Ref No.</th>   
							<th width="50" >Status</th>  
							<th class="text-center" width="50" >Actions</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if(!empty($TipAuthoListing)){
							foreach($TipAuthoListing as $key=>$record){ ?>
						<tr>
							<td><?php echo $key+1 ?></td>
							<td><?php echo $record->TipName ?></td> 
							<td><?php echo $record->Town ?></td>
							<td><?php echo $record->County ?></td>
							<td><?php echo $record->TipRefNo ?></td>   
							<td><?php if($record->TableID != null){  if($record->Status == "0"){ echo "Authorised"; }else{ echo "Unauthorised"; } }else{ echo "NONE"; } ?></td>  
							<td class="text-center">   
							<button class="btn btn-sm btn-info EditAutho" data-TipID="<?php echo $record->TipID; ?>" title="Authorize"><i class="fa fa-edit" ></i></button>   
							</td>
						</tr>
						<?php
							}
						}
						?>
						</tbody>
					  </table> 
				  </div>
				  </div>
				  </div>
				</div> 
		
			  </div> 
			  </div>
			  <div class="tab-pane" id="Bookings"> 
			  <div class="row" style="margin:3px">  
				<div class="box-body">
					  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
						  <table id="booking-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
						  <thead>
							<tr> 
								<th width="10" align="right">BNo </th>                        
								<th width="100" >Request Date(s) </th>   
								<th >Material</th> 
								<th width="10" align="right">Type</th>                        
								<th width="50" >Load Type</th> 
								<th width="50" >Lorry Type</th> 
								<th width="50">Loads Lorry</th>            
								<th width="50">Approve</th>  
								<th width="100" >Created By </th>  
							</tr>
							</thead> 
						  </table> 
					  </div>
					</div>
					</div>
					</div> 
		
			  </div> 
			  </div>
			  
			  
			  <div class="tab-pane" id="tickets"> 
			  <div class="row" style="margin:3px">  
				<div class="box-body">
					  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
						  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
						  <thead>
							<tr> 
								<th width="10" align="right">T.No </th>                        
								<th width="100" >Date </th>                        
								<th >Company Name</th> 
								<th >Conveyance</th>
								<th width="20">Lorry</th>
								<th width="50">Veh.No</th>
								<th width="100">Driver Name</th> 
								<th width="30">Gross</th>
								<th width="30">Tare</th>
								<th width="30">Net</th> 
								<th width="30">OP</th>   
								<th class="text-center" width="50">Actions</th> 
							</tr>
							</thead> 
						  </table> 
					  </div>
					</div>
					</div>
					</div> 
		
			  </div> 
			  </div>
			
              <!-- /.tab-pane --> 
              <div class="tab-pane" id="documents">              
			  <form role="form" id="Opportunitysubmit1" action="<?php echo base_url('edit-Opportunity/'.$opInfo['OpportunityID']) ?>" method="post" role="form" enctype="multipart/form-data" >
			  <input type="hidden" name="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
              <div class="row" style="margin-left:0px"> 
			  
				 
				<div class="col-md-3">
					<div class="form-group">
						<label for="DocumentAttachment">Select Document</label>
						<input type="file" class="form-control" id="DocumentAttachment" name="DocumentAttachment[]" multiple>
					</div>
				</div>  
				<div class="col-md-2">
					<div class="form-group">
						<label for="DocumentType">Document Type</label>
						<select class="form-control required County" id="DocumentType" name="DocumentType[]" aria-required="true">
							<option value="">Select Document Type</option>
							<option value="1">WIF Form</option> 
							<option value="2">Purchase Order</option> 
							<option value="3">Quote</option> 
							<option value="5">Email Orders</option> 
							<option value="4">Others</option> 
							<option value="6">Traffic Management</option> 
						</select>
					</div>
				</div>
				<div class="col-md-2"> 
					<div class="form-group"> 
						<label for="DocumentDetail">Number</label>
						<input type="text" class="form-control" id="DocumentNumber" name="DocumentNumber[]"> 
					</div>
				</div> 
				<div class="col-md-2"> 
					<div class="form-group"> 
						<label for="DocumentDetail">Details</label>
						<input type="text" class="form-control" id="DocumentDetail" name="DocumentDetail[]"> 
					</div>
				</div> 
				<div class="col-md-2">
					<div class="form-group">
						  <br>
						  <button class="btn btn-primary add-doc-fields-btn" type="button"> + Add New </button>
					</div>
				</div> 
                </div>  
                <div class="add-fields-fun"></div> 
                <div class="box-footer">
                    <input type="submit" name="submit1" class="btn btn-primary" value="SAVE" />     
                </div> 
				<div class="row" style="margin-left:0px"> 
				<div class="col-md-12"><label>Company Documents  </label></div>
			  
				<div class="col-md-12">
					<table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
					  <thead>
						<tr> 
							<th width="10" align="right">No </th>                         
							<th >Attachment Name </th> 
							<th width="120" >Date </th>   
							<th width="200" >Document Type </th>
							<th >Details</th> 
							<th class="text-center" width="100">Actions</th> 
						</tr>
						<?php 
						if(!empty($documnetfiles)){
							$i=0;
							foreach ($documnetfiles as $key=>$rl){  
							
							$url =  base_url('assets/Documents/').$rl->DocumentAttachment;
							$HI = get_headers($url);  
							//echo var_dump($HI)."<br>"; 
							if($HI[0]!='HTTP/1.1 404 Not Found'){  $i=$i+1;  ?> 
						<tr>
							<td><?=$i ?></td>
							<td><a href="<?php echo base_url('assets/Documents/').$rl->DocumentAttachment; ?>" target="_blank" ><?php echo $rl->DocumentAttachment; ?></a></td>
							<td><?php echo $rl->DocDate ?></td>
							<td><?php if($rl->DocumentType == 1){ echo "WIF Form | ".$rl->DocumentNumber; } 
							if($rl->DocumentType == 2){ echo "Purchase Order"; } 
							if($rl->DocumentType == 3){ echo "Quote"; } 
							if($rl->DocumentType == 4){ echo "Others"; }
							if($rl->DocumentType == 5){ echo "Email Order"; }  
							if($rl->DocumentType == 6){ echo "Traffic Management"; }  ?></td>
							<td><?php echo $rl->DocumentDetail ?> </td>
							<td> <a href="<?=base_url('assets/Documents/').$rl->DocumentAttachment?>" target="_blank" class="btn btn-sm btn-info" ><i class="fa fa-eye"></i></a> 
								<a href="javascript:void(0)" id="<?php echo $rl->DocumentID ?>" class="remove-uploaded-doc btn btn-sm btn-danger"  ><i class="fa fa-trash"></i></a> 
							</td>
						</tr>
						<?php }} } ?>
						</thead> 
					  </table> 
				  </div>  
				  </div> 
				</form>
              </div>      
			  
            <div class="tab-pane" id="notes-tabs">              

              <div class="row">
            <div class="col-md-6">

          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">All Note</h3>
            </div>
            <div class="box-body"> 
            <div class="row add-notes-fun"> 
            <?php
                    if(!empty($allnotes))
                    {
                        foreach ($allnotes as $rl)
                        { 

                           if($rl->NoteAttachement!="") $NoteAttachement = '<a href="'.base_url('assets/Notes/').$rl->NoteAttachement.'"> Download</a>';
                           else $NoteAttachement = 'No';
                            ?>

                         <div class="col-md-12">
                                  <div class="box box-success box-solid">
                                    <div class="box-header with-border">
                                      <h3 class="box-title"><?=$rl->name?></h3> 
                                      <!-- /.box-tools -->

                                      <div class="box-tools pull-right">                
                                   <button type="button" class="btn btn-box-tool remove-note-button" id="<?=$rl->NotesID?>" ><i class="fa fa-times"></i></button>
                                    </div>

                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                     <?=$rl->Regarding?> <span class="label <?=($rl->NoteType==1)?'label-warning':'label-info';?> pull-right"> <?=($rl->NoteType==1)?'Private':'Public';?> </span>
                                     <div> Attachement : <?=$NoteAttachement?> </div>
                                      <div> Date : <?=date("d-m-Y", strtotime($rl->CreateDate));?> </div>
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                        </div>
                                <!-- /.col -->  


                            <?php
                        }
                    }
            ?>
       
      </div>                          

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          </div>
        <!-- /.col (left) -->

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Add New</h3>
            </div>
					<form role="form" id="addnewopportunitynote" action="#" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="OpportunityID" value="<?php echo $opInfo['OpportunityID'];?>">
                        <div class="box-body"> 
                        <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="NoteType">Note Type</label><br>
                                        <label class="radio-inline"><input type="radio" name="NoteType" checked value="0">Public</label>
                                        <label class="radio-inline"><input type="radio" name="NoteType" value="1">Private</label>                                      
                                    </div>  
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Regarding">Regarding</label>
                                        <textarea name="Regarding" id="Regarding" class="form-control required"></textarea>
                                    </div>
                                </div>                                 
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="NoteAttachement">Attachement</label>
                                        <input type="file" class="form-control required" id="NoteAttachement" name="NoteAttachement">
                                    </div>
                                </div>                                 
                            </div> 
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="IsActive">Status</label>
                                       <select class="form-control required" id="IsActive" name="IsActive">
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>                                            
                                        </select>
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                       <div class="box-footer">
                            <input type="Submit" class="btn btn-primary submit-company-note" value="Submit" /> 
                        </div> 
                    </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <!-- /.col (right) -->
      </div>


              </div>
              <!-- /.tab-pane -->                 

               </div>
               <!-- /.tab-content -->
            
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
           
           
        </div>    
    </section>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function() {	
		 
		$('#exampleproduct').DataTable({
			"order": [[ 4, "desc" ]], 
			"pageLength": -1,
			"paging": false,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		});
		
		$('#exampletip').DataTable({
			"order": [[ 4, "desc" ]], 
			"pageLength": -1,
			"paging": false,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		});
		
		var cur_tab = location.hash;	
		if(cur_tab!=''){
			$('a[href=' + location.hash + ']').tab('show');
		}
		var OppoID = $('#OpportunityID').val();	 
		var dataTable = $('#ticket-grid').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 1, "desc" ]],
			"columns": [
				{ "data": "TicketNumber" ,"name": "TicketNumber", "data-sort": "TicketNumber_sort" },
				{ "data": "TicketDate" ,"name": "TicketDate", "data-sort":"TicketDate1" },
				{ "data": "CompanyName" , "name": "CompanyName" }, 
				{ "data": "Conveyance" , "name": "Conveyance" },
				{ "data": "driver_id" , "name": "driver_id" },
				{ "data": "RegNumber" , "name": "RegNumber" },
				{ "data": "DriverName" , "name": "DriverName" },
				{ "data": "GrossWeight" , "name": "GrossWeight" },
				{ "data": "Tare" , "name": "Tare" },
				{ "data": "Net" , "name": "Net" },
				{ "data": "TypeOfTicket", "name": "TypeOfTicket" }, 
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('OppoTickets') ?>", // json datasource
				type: "post",  // method  , by default get
				data : { 'OppoID' : OppoID },  
				error: function(e){  // error handling
					$(".ticket-grid-error").html("");
					$("#ticket-grid").append('<tbody class="ticket-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#ticket-grid_processing").css("display","none");							
				}//,
				//success: function (data) {  
				//   alert(JSON.stringify( data )); 
				//   console.log(data);
 				//} 
			}, 
			columnDefs: [{ data: null, targets: -1 }],   
			createdRow: function (row, data, dataIndex) {  
				$(row).find('td:eq(0)').attr('data-sort', data['TicketNumber_sort']);
				$(row).find('td:eq(1)').attr('data-sort', data['TicketDate1']);
				$(row).find("td:eq(2)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> '); 
				if(data["TypeOfTicket"]=="Out"){
					if(data["LoadID"]!=0 && data["ReceiptName"]!=""){
						pdf_path = baseURL+'assets/conveyance/'+data["ReceiptName"];
					}else{
						pdf_path = baseURL+'assets/pdf_file/'+data["pdf_name"];
					}
				}else{	
					pdf_path = baseURL+'assets/pdf_file/'+data["pdf_name"];
				} 
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-warning" target="blank" href="'+pdf_path+'" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'View-'+data["TypeOfTicket"]+'-Ticket/'+data["TicketNo"]+'" title="View Ticket"><i class="fa fa-eye"></i></a>  ');
			}
		});  
		var dataTable = $('#booking-grid').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 1, "desc" ]],
			"columns": [
				{ "data": "BookingRequestID" ,"name": "BookingRequestID"  },
				{ "data": "BookingDate" ,"name": "BookingDate", "data-sort": "BookingDate" },				   
				{ "data": "MaterialName" , "name": "MaterialName" },  
				{ "data": "BookingType" ,"name": "BookingType"  },
				{ "data": "LoadType" , "name": "LoadType" }, 
				{ "data": null}, 
				{ "data": "Loads" , "name": "Loads" }, 
				{ "data": "BookingDateStatus","name": "BookingDateStatus", "data-sort": "BookingDateStatus" }, 				 
				{ "data": "BookedName" , "name": "BookedName" }
			],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				
				url : "<?php echo site_url('AjaxOppoBookings') ?>", // json datasource
				type: "post",  // method  , by default get
				data : { 'OppoID' : OppoID },  
				error: function(e){  // error handling
				//alert(e);
				//console.log(e);     
					$(".ticket-grid-error").html("");
					$("#ticket-grid").append('<tbody class="ticket-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#ticket-grid_processing").css("display","none");							
				}
			}, 
			columnDefs: [{ data: null, targets: -1 }],   
			createdRow: function (row, data, dataIndex) {  
				
				var btype = ''; var status = '';  
				if(data["BookingType"] ==1){ $(row).addClass("even1");  btype = 'Collection' ; }else{  $(row).addClass("odd1");  btype = 'Delivery' ;  } 
				if(data["LoadType"] == 1){ $(row).find("td:eq(4)").html('Loads'); }else{  $(row).find("td:eq(4)").html('TurnAround'); } 
				
				if(data["LorryType"] == 1){ $(row).find("td:eq(5)").html('Tipper'); } 
				if(data["LorryType"] == 2){ $(row).find("td:eq(5)").html('Grab'); } 
				if(data["LorryType"] == 3){ $(row).find("td:eq(5)").html('Bin'); } 
				
				if(data["BookingDateStatus"] == '1'){ status = '<span class="label label-success">Approved</span>' ;  }
				if(data["BookingDateStatus"] == '0'){ status = '<div id="ap---'+data["BookingDateID "]+'" ><a class="btn btn-danger" herf="#"  title="Approved Booking"><i class="glyphicon glyphicon-ok"></i></a></div>' ;  } 
				$(row).find("td:eq(0)").html('<a class="ShowLoads" data-BookingNo="'+data["BookingDateID"]+'" herf="#" ><i class="fa fa-plus-circle"></i> '+data["BookingRequestID"]+'</a>');  
				$(row).find("td:eq(3)").html(btype); 
				$(row).find("td:eq(-2)").html(status);	  
				$(row).find('td:eq(-2)').attr('data-sort', data['BookingDateStatus']); 
			}
		}); 		
			jQuery(document).on("click", ".EditAutho", function(){  
			
			//$('#empModal').modal('show');  
					var TipID = $(this).attr("data-TipID"),  
						OpportunityID = $('#OpportunityID').val();
						hitURL1 = baseURL + "EditAuthoAJAX",
						currentRow = $(this);   
						//alert(TipID);
						//alert(OpportunityID);
					jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL1,
					data : { 'TipID' : TipID,'OpportunityID' : OpportunityID } 
					}).success(function(data){ 
						//alert(data)
						$('.modal-body').html(data);
						$('#empModal .modal-title').html("Edit Tip Authorize");
						$('#empModal .modal-dialog').width(500);
						$('#empModal').modal('show');  
					});  
					 
			});
			
			jQuery(document).on("click", ".ShowLoads", function(){   
				var BookingID = $(this).attr("data-BookingNo"), 
					hitURL1 = baseURL + "ShowLoadsAJAX",
					currentRow = $(this);  
				//console.log(confirmation); 
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingID' : BookingID } 
				}).success(function(data){ 
				//	alert(data)
					$('.modal-body').html(data);
					$('#empModal .modal-title').html("Booking Loads / Lorry Information");
					$('#empModal .modal-dialog').width(1200);
					$('#empModal').modal('show');  
				});   
			});
			jQuery(document).on("click", ".DeleteProduct", function(){ 
				var ProductID = $(this).attr("data-ProductID"), 
					hitURL = baseURL + "DeleteProductPrice",
					currentRow = $(this);
				var confirmation = confirm(" Are You Sure ? You want to Delete Current Product Price ? ");
				//console.log(confirmation);
				if(confirmation!=null){ 
					if(confirmation!=""){
						//console.log("Your comment:"+confirmation);
						//alert(confirmation);
						jQuery.ajax({
						type : "POST",
						dataType : "json",
						url : hitURL,
						data : { 'ProductID' : ProductID ,'confirmation' :confirmation } 
						}).success(function(data){
							//console.log(data);  
							if(data.status != "") { currentRow.parents('tr').remove(); alert("Selected Product Price has been Deleted"); }
							else{ alert("Oooops, Please try again later"); } 
						});  
					}
				}
		}); 
		jQuery(document).on("click", ".OppoProductLogs", function(){  
			var ProductID = $(this).attr("data-ProductID"),  
				hitURL1 = baseURL + "OppoProductLogsAJAX",
				currentRow = $(this);   
				//alert(BookingDateID);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'ProductID' : ProductID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					
					$('#empModal .modal-title').html("View Product Logs");
					$('#empModal .modal-dialog').width(1200); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
				 
	});
		
});
	
</script> 
<script src="<?php echo base_url(); ?>assets/js/Opportunity.js" type="text/javascript"></script> 