<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Opportunity Management
        <small><?php echo $opInfo['OpportunityName']; ?></small>
      </h1>
    </section>
     <section class="content"> 
		<h4> <b>Company Name: <a href="<?php echo base_url().'view-company/'.$opInfo['CompanyID']; ?>" ><?=$opInfo['CompanyName']?></a></b> 
		<a class="btn btn-sm btn-info" href="<?php echo base_url('edit-Opportunity-Company/'.$opInfo['OpportunityID']); ?>" title="Edit Company Name"> <i class="fa fa-pencil"></i></a>
		</h4>
        <div class="row"> 
        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Opportunity details</a></li> 
              <li class=""><a href="#contact" data-toggle="tab" aria-expanded="false">Contacts</a></li>  
			  <li class=""><a href="#product" data-toggle="tab" aria-expanded="false">Products</a></li>  
			  <li class=""><a href="#tickets" data-toggle="tab" aria-expanded="false">Tickets</a></li>   
			  <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Documents</a></li>  
              <li class=""><a href="#notes-tabs" data-toggle="tab" aria-expanded="false">Notes</a></li>    
            </ul> 
            <div class="tab-content"> 
              <div class="tab-pane active" id="activity">  
			  <form role="form" id="Opportunitysubmit" action="<?php echo base_url('edit-Opportunity/'.$opInfo['OpportunityID']) ?>" method="post" role="form"  >
					  <?php echo validation_errors(); ?>
					  <?php $this->load->helper("form"); ?> 
						<input type="hidden" name="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
                        <div class="box-body">  
            
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
                                            if(!empty($county))
                                            {
                                                foreach ($county as $rl)
                                                {
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
                                        <input type="text" class="form-control  " id="datepicker3"  value="<?php echo $opInfo['OpenDate1']; ?>" name="OpenDate"  >
                                        </div> 
                                    </div> 
								 
									  <div class="form-group">
                                        <label for="WIFRequired"> WIF Required ? </label>
										<select class="form-control  " id="WIFRequired" name="WIFRequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['WIFRequired']=='TBA'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['WIFRequired']=='Yes'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['WIFRequired']=='No'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="WIF">WIF  </label>
                                        <input type="text" class="form-control  " id="WIF" value="<?=$opInfo['WIF']?>" name="WIF" >
                                    </div>
                                </div>  
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="TipTicketRequired"> TIP Ticket(S) Required ?  </label>
										<select class="form-control  " id="TipTicketRequired" name="TipTicketRequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['TipTicketRequired']=='TBA'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['TipTicketRequired']=='Yes'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['TipTicketRequired']=='No'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="TipName">TIP NAME(S) </label>
                                        <textarea  class="form-control  " id="TipName"  name="TipName" rows="3" ><?=$opInfo['TipName']?></textarea>
                                    </div>
								</div>  
								 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="SiteInstRequired"> SITE INSTRUCTIONS Required ?  </label>
										<select class="form-control    " id="SiteInstRequired" name="SiteInstRequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['SiteInstRequired']=='TBA'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['SiteInstRequired']=='Yes'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['SiteInstRequired']=='No'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="SiteNotes">SITE INSTRUCTIONS Note(s)  </label>
                                        <textarea class="form-control  " id="SiteNotes" rows="3" name="SiteNotes" ><?=$opInfo['SiteNotes']?></textarea>
                                    </div> 
                                </div>  
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="PORequired"> PO Required ? </label>
										<select class="form-control    " id="PORequired" name="PORequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['PORequired']=='TBA'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['PORequired']=='Yes'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['PORequired']=='No'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="PO_Notes">PO Note(s)  </label>
                                        <textarea class="form-control  " id="PO_Notes"  rows="3" name="PO_Notes" ><?=$opInfo['PO_Notes']?></textarea>
                                    </div>
                                </div>  
                            </div>
							<div class="row"> 
								<div class="col-md-3">	
									<div class="form-group">
                                        <label for="StampRequired"> STAMP Required ?  </label>
										<select class="form-control  " id="StampRequired" name="StampRequired"  data-live-search="true" >
                                            <option value="0" <?php if($opInfo['StampRequired']=='TBA'){ ?> selected <?php } ?> >TBA</option>
											<option value="1" <?php if($opInfo['StampRequired']=='Yes'){ ?> selected <?php } ?> >Yes</option>
											<option value="2" <?php if($opInfo['StampRequired']=='No'){ ?> selected <?php } ?> >No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="Stamp">STAMP   </label>
                                        <input type="text" class="form-control  " id="Stamp" value="<?=$opInfo['Stamp']?>" name="Stamp" >
                                    </div>
                                </div> 
								<div class="col-md-3"> 
									<div class="form-group">
                                        <label for="AccountNotes">Account Note(s)  </label>
                                        <textarea class="form-control " id="AccountNotes"  rows="3" name="AccountNotes" ><?=$opInfo['AccountNotes']?></textarea>
                                    </div>
                                </div> 
                            </div> 
                        </div><!-- /.box-body -->  
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
				                   
					<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
							<thead>
								<tr>
									<th width="30">S.No</th>
									<th width="200">Product Code</th>
									<th width="150">Purchase Order No</th>
									<th width="150">Job No</th>
									<th width="50">Qty</th>
									<th width="50">Price</th>                     
									<th width="50" class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php  if(!empty($product_list)){
									$i=1; foreach($product_list as $row){  ?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['ProductCode']; ?></td>
									<td><?php echo $row['PurchaseOrderNo']; ?></td>
									<td><?php echo $row['JobNo']; ?></td>
									<td ><?php echo $row['Qty']; ?></td>
									<td><?php echo $row['UnitPrice']; ?></td>                      
									<td class="text-center">                            
										<a class="btn btn-sm btn-info" href="<?php echo base_url().'Opportunity-EditProduct/'.$row['productid']; ?>" title="Edit"><i class="fa fa-pencil"></i></a> 
									</td>
								</tr>
							<?php  $i++; } }  ?>
							</tbody>
					</table>   
				  </div>
				</div>  
		
			  </div> 
			  </div>
			  <div class="tab-pane" id="tickets"> 
			  <div class="row" style="margin:3px">  
				<div class="box-body"> 
				  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive">  
					<table id="example3" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th width="10" align="right">No </th>                        
                        <th >Company Name</th>
                        <th width="50">Veh.No</th>
                        <th width="100">Driver Name</th>
                        <th width="40">Gross</th>
                        <th width="40">Tare</th>
                        <th width="40">Net</th>
                        <th width="45">Date</th>
                        <th width="50">Barcode</th>
                        <th width="50">Operation</th>  
                        <th class="text-center" width="120">Actions</th>
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($ticketsRecords))
                    {
                        foreach($ticketsRecords as $key=>$record)
                        {
                    ?>
                    <tr> 
                        <td align="right" ><?php echo $record->TicketNumber; ?></td>                        
                        <td><a href="<?php echo base_url().'view-company/'.$record->CompanyID; ?>" ><?php echo $record->CompanyName ?></a></td>
                        <td><?php echo $record->RegNumber ?></td>
                        <td><a href="<?php echo base_url().'viewDriver/'.$record->driver_id; ?>" ><?php echo $record->DriverName ?></a></td>
                        <td align="right" ><?php echo $record->GrossWeight ?></td>
                        <td align="right" ><?php echo $record->Tare ?></td>
                        <td align="right" ><?php echo $record->Net ?></td>
                        <td><?php echo substr($record->TicketDate,0,10); // echo date(DATE_TIME_FORMATE,strtotime($record->TicketDate)) ?></td>
                        <td>   <?php if($record->Barcode==""){?> 
                        <a href="javascript:void(0)" data-ticketno="<?php echo $record->TicketNumber; ?>" data-ticketuniqueid="<?php echo $record->TicketUniqueID; ?>" class="cls-genrate-ticket">Generate</a> 
                        <?php } else{ ?> 
                        <a href="<?php echo base_url('/assets/Invoice').'/'.$record->Barcode; ?>" target="_Blank"><img src="<?php echo base_url('/assets/Invoice').'/'.$record->Barcode; ?>" width="100" ></a> 
                        <?php } ?> 
                        </td> 
                        <td><?php echo $record->TypeOfTicket ?></td>  
                        <td class="text-center" >                            
                          <?php if($record->pdf_name != "") {?>  <a class="btn btn-sm btn-warning" target="blank" href="<?php echo base_url().'assets/pdf_file/'.$record->pdf_name; ?>" title="View PDF"><i class="fa fa-file-pdf-o"></i></a><?php }?>
						  <a class="btn btn-sm btn-info" href="<?php echo base_url().'View-'.$record->TypeOfTicket.'-Ticket/'.$record->TicketNumber; ?>" title="View"><i class="fa fa-eye"></i></a> 
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
			
              <!-- /.tab-pane --> 
              <div class="tab-pane" id="timeline">              
			  <form role="form" id="Opportunitysubmit1" action="<?php echo base_url('edit-Opportunity/'.$opInfo['OpportunityID']) ?>" method="post" role="form" enctype="multipart/form-data" >
			  <input type="hidden" name="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
              <div class="row" style="margin-left:0px"> 
              <div class="col-md-12"><label>Company Documents  </label></div> 
                            <?php
							 
                                if(!empty($documnetfiles))
                                {
                                    foreach ($documnetfiles as $key=>$rl)
                                    {
                                        ?>

                                <div class="row add-new-fields-fun" style="margin-left:0px">                               
                                 
                                <div class="col-md-3"> 
                                    <div class="form-group">  
                                        <span> <?=$key+1 ?>. <?php echo $rl->DocumentDetail ?> </span>     
                                    </div>
                                </div> 
								<div class="col-md-2"> 
                                    <div class="form-group">   
                                        <span> <?php if($rl->DocumentType == 1){ echo "WIF Form | ".$rl->DocumentNumber; } if($rl->DocumentType == 2){ echo "Purchase Order"; } if($rl->DocumentType == 3){ echo "Quote"; } if($rl->DocumentType == 4){ echo "Others"; }  ?> </span>                                      
                                    </div>
                                </div>  
                                 <div class="col-md-2">
                                    <div class="form-group"> 
                                        <a href="<?=base_url('assets/Documents/').$rl->DocumentAttachment?>" download >Download</a> |  <a href="<?=base_url('assets/Documents/').$rl->DocumentAttachment?>" target="_blank" >Preview</a> |  <a href="javascript:void(0)" id="<?php echo $rl->DocumentID ?>" class="remove-uploaded-doc">Remove</a> 
                                    </div>
                                </div>        
                            </div>  
                                        <?php
                                    }
                                }
                            ?> 
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
											<option value="4">Others</option> 
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
                           

                        </div><!-- /.box-body -->
                        
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
				url : "<?php echo site_url('AJAXTickets') ?>", // json datasource
				type: "post",  // method  , by default get
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
				$(row).find("td:eq(2)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> '); 
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-warning" target="blank" href="'+baseURL+'assets/pdf_file/'+data["pdf_name"]+'" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'OfficeTicket/'+data["TicketNumber"]+'" title="Create Office Ticket"> G </a> <a class="btn btn-sm btn-info" href="'+baseURL+'View-'+data["TypeOfTicket"]+'-Ticket/'+data["TicketNo"]+'" title="View Ticket"><i class="fa fa-eye"></i></a>  ');
				$(row).find('td:eq(0)').attr('data-sort', data['TicketNumber_sort']);
				$(row).find('td:eq(1)').attr('data-sort', data['TicketDate1']);
			}
		} ); 
		 
	} );
	
</script>

<script src="<?php echo base_url(); ?>assets/js/Opportunity.js" type="text/javascript"></script>
