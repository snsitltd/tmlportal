<script src="<?php echo base_url('assets/js/print.js'); ?>" type="text/javascript"></script>   
<link rel="stylesheet" href="<?php echo base_url('docs/css/signature-pad.css'); ?>">
<style>
td.details-control {
    background: url('/assets/images/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('/assets/images/details_close.png') no-repeat center center;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-users"></i> Booking PreInvoice 
	  <a href="<?php echo base_url('NonAppRequestLoads/'.$RequestInfo['BookingRequestID']); ?>"  class="btn btn-danger" style="float:right"  >Add Tickets</a>
	  </h1>
	</section>
	<div class="modal fade" id="empModal" role="dialog">
			<div class="modal-dialog" style="width:600px"> 
				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<h4 class="modal-title">Price Logs Information</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				  </div> 
				  <div class="modal-body"></div> 
				  <div class="TEST"></div> 
				  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div> 
				</div>
			</div>
		</div>  
                   
     <section class="content"> 
			<?php echo validation_errors(); ?>
			  <?php //var_dump($RequestInfo); ?>
              <?php $this->load->helper("form"); ?>  
        <div class="row"> 
        <div class="col-md-4"> 
		<div class="box box-primary">
             
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Company Name : </label>  <?php echo $RequestInfo['CompanyName'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Opportunity Name : </label>  <?php echo $RequestInfo['OpportunityName'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Contact Name : </label>  <?php echo $RequestInfo['ContactName'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Contact Email : </label>  <?php echo $RequestInfo['ContactEmail'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Contact Mobile : </label>  <?php echo $RequestInfo['ContactMobile'];?> 
							</div> 
						</div> 
					</div>	  
				  <!--  <div class="box-footer">
						<input type="submit" class="btn btn-primary" value="Left Site" /> 
						<input type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;"  value="Cancel" /> 
				   </div> -->
				</div>	 
              </div>                       
        </div>    
		<div class="col-md-4"> 
			<div class="box box-primary"> 
				<div class="box-body"> 
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Waiting Time (Minute) : </label>  <?php echo $RequestInfo['WaitingTime'];?> 
							</div> 
						</div> 
					</div>	
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Wait Charges (1 £/Minute) : </label>  <?php echo $RequestInfo['WaitingCharge'];?> 
							</div> 
						</div> 
					</div>	
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Purchase Order : </label>  <?php echo $RequestInfo['PurchaseOrderNumber'];?> 
							</div> 
						</div> 
					</div>	
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Notes : </label>  <?php echo $RequestInfo['Notes'];?> 
							</div> 
						</div> 
						 
					</div>	 
				</div>	 
			</div>                       
        </div>    
		<div class="col-md-4"> 
			<div class="box box-primary"> 
				<div class="box-body"> 
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Type Of Payment : </label>  <?php if($RequestInfo['PaymentType']=='2'){ echo "CASH"; } 
								if($RequestInfo['PaymentType']=='3'){ echo "CARD"; } ?> 
							</div> 
						</div> 
					</div>	
					 
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Payment Ref Notes : </label>  <?php echo $RequestInfo['PaymentRefNo'];?> 
							</div> 
						</div> 
						<div class="col-md-12">                                
							<div class="form-group">
								 
							</div> 
						</div> 
					</div>	 
				</div>	 
			</div>                       
        </div>     
		</div> 
		
		 
<form id="CreateInvoice" name="CreateInvoice"  action="<?php echo base_url('BookingCreateInvoice/'.$RequestInfo['BookingRequestID']); ?>"  method="post" role="form" > 		
<input type="hidden" value="<?php echo $RequestInfo['BookingRequestID']; ?>"  name="BookingRequestID" id="BookingRequestID"  > 
<input type="hidden" value="<?php echo $RequestInfo['CompanyID']; ?>"  name="CompanyID" id="CompanyID"  > 
<input type="hidden" value="<?php echo $RequestInfo['CompanyName']; ?>"  name="CompanyName" id="CompanyName"  > 
<input type="hidden" value="<?php echo $RequestInfo['OpportunityID']; ?>"  name="OpportunityID" id="OpportunityID"  > 
<input type="hidden" value="<?php echo $RequestInfo['OpportunityName']; ?>"  name="OpportunityName" id="OpportunityName"  > 
<input type="hidden" value="<?php echo $RequestInfo['ContactID']; ?>"  name="ContactID" id="ContactID"  > 
<input type="hidden" value="<?php echo $RequestInfo['ContactName']; ?>"  name="ContactName" id="ContactName"  > 
<input type="hidden" value="<?php echo $RequestInfo['ContactMobile']; ?>"  name="ContactMobile" id="ContactMobile"  > 
<input type="hidden" value="<?php echo $RequestInfo['ContactEmail']; ?>"  name="ContactEmail" id="ContactEmail"  > 
<input type="hidden" value="20"  name="TaxRate" id="TaxRate"  >  		
 		
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Booking Load List</h3>
					<!-- <button id="HLD" type="button"  name="HLD"  class="btn btn-danger" style="float:right" data-BookingRequestID="<?php //echo $RequestInfo['BookingRequestID']; ?>"  >Hold Selected Load</button> -->
				</div> 
				<?php //var_dump($LoadInfo); ?>
				<div class="box-body">
					<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
 	 			
  <table   class="table table-bordered table-hover dataTable tgrid" role="grid" aria-describedby="example2_info">
  <thead>
	<tr>  
		<th width="20" > </th>                        
		<th width="82" > Request Date </th>                        
		<th width="10" align="right">Type</th>                        
		<th >Material</th>    
		<th width="75" >Load/Lorry Type</th> 
		<th width="30">Lorry Type</th>   
		<th width="30" >Total Loads/Lorry </th> 
		<th width="100" >Price/Load</th>     
		<th width="80" >Total Price</th>     
	</tr>
	</thead> 
	<tbody>
	<?php 
	if(!empty($LoadInfo)){  $SubAmount =0;

		foreach($LoadInfo as $key=>$record){ 
		$LD = array(); $filterBy = $record->BookingDateID; 
		$LD = array_filter($Loads, function ($var)use ($filterBy) {
			return ($var['BookingDateID'] == $filterBy );
		});   
		$LD = array_values($LD); 
		if(count($LD)>0){
			
		//var_dump($LD);	
		//$SubAmount = $SubAmount + (float)round($record->TotalAmount,2);  
		//$SubAmount = $SubAmount + (float)round($record->Price,2);  
		
		?>
	<tr class="<?php echo $cls1; ?>" data-BookingDateID="<?php echo $record->BookingDateID; ?>" >
		<td class="details-control" > </td>
		<td ><?php echo $record->BookingDateTime; ?></td>
		<td><?php if($record->BookingType ==1){ echo "Collection"; }if($record->BookingType ==2){ echo "Delivery"; } ?></td>
		<td><?php echo $record->MaterialName ?><!-- <input type="hidden" value="<?php //echo $record->MaterialName; ?>"  name="MaterialName<?php //echo $record->BookingDateID; ?>" > --></td>   
		<td><?php if($record->LoadType==1){ echo "Fixed"; } if($record->LoadType==2){ echo "TurnAround"; } ?></td>
		<td><?php if($record->LorryType ==1){ echo "Tipper"; }if($record->LorryType ==2){ echo "Grab"; }if($record->LorryType ==3){ echo "Bin"; } ?></td>    
		<td align="right" ><?php echo (int)$record->Loads ?>
			 <input type="hidden" value="<?php echo (int)$record->Loads  ?>" name="Loads<?php echo $record->BookingDateID; ?>" id="Loads<?php echo $record->BookingDateID; ?>" > 
		</td> 
		<td align="right" >
		<input type="hidden" value="<?php echo $record->BookingDateID; ?>"  name="BookingDateID[]" >
		<i class="fa fa-history  PriceLogs"  data-BookingID="<?php echo $record->BookingID; ?>"  title="View  Price Logs" ></i>
		<input type="text" class="decimal" value="<?php echo (float)round($record->Price,2); ?>"  style="width:50px" name="Price<?php echo $record->BookingDateID; ?>" id="Price<?php echo $record->BookingDateID; ?>" >
		<button class="btn btn-sm btn-info PriceUpdate" type="button" data-BookingDateID="<?php echo $record->BookingDateID; ?>" name="Submit<?php echo $record->BookingDateID; ?>"  > OK </button></td> 
		<td align="right"  data-TotalPrice="TotalPrice<?php echo $record->BookingDateID; ?>"  >
		<span class="TotalPrice" id="TP<?php echo $record->BookingDateID; ?>"><?php echo (float)round($record->TotalAmount,2); ?></span>
		<input type="hidden" value="<?php echo (float)round($record->TotalAmount,2); ?>"  name="TotalPrice<?php echo $record->BookingDateID; ?>" id="TotalPrice<?php echo $record->BookingDateID; ?>" >
		</td> 
	</tr>
	<tr id='hiddenRow<?php echo $record->BookingDateID; ?>' style="display:none" >
		<td colspan="9" > 			 
			<table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" > 
			<thead>
				<tr> 
					<th width="10" ></th>                        
					<th width="20" >Conv No.</th>                        
					<th width="20" >Ticket No.</th>               
					<th width="100">Ticket DateTime</th>        			
					<th width="100" align="right">Driver Name </th>                        
					<th width="50" > VRNO</th>    
					<th width="40" > Gross</th> 
					<th width="40" > Tare</th> 
					<th width="40" > Net</th>  
					<th >Tip Name</th>
					<th >Material</th>         
					<th width="40" > WaitTime (Min)</th>  			
					<th width="30" > Wait Charges</th>  
					<th width="20">Status</th>    
					<th width="50" >Price</th>  
				</tr>
			</thead> 
			<tbody>
			<?php       
			//var_dump($LD);
			for($i=0;$i<count($LD);$i++){  
				$SubAmount = $SubAmount + (float)round($record->Price,2);  
				$cls1 = ""; 
				if($LD[$i]['AutoCreated'] ==1){ $cls1='even1';  }else{ $cls1='odd1';   } ?> 
			 <tr class="<?php echo $cls1; ?>">  
				<td align="center" >
					<a  class="HoldMe" data-LoadID="<?php echo $LD[$i]['LoadID']; ?>"  data-BookingDateID="<?php echo $record->BookingDateID; ?>" title="Hold Load"> <i class="fa   fa-times"></i> </a> 
				</td>
				<?php if($record->BookingType==1){ ?>	
					<?php if($LD[$i]['TipID']==1 ){ ?> 				
						<?php if($LD[$i]['AppUser']==0 ){ ?> 				
							<td align="right"><a href="<?php echo base_url('assets/conveyance/'.$LD[$i]['ConvPDF']); ?>" title="View Conveyance Ticket" target="_blank" > <?php echo $LD[$i]['ConveyanceNo']; ?></a></td>                        
							<td align="right"><a href="<?php echo base_url('assets/pdf_file/'.$LD[$i]['TicketPDF']); ?>" title="View Ticket" target="_blank" > <?php echo $LD[$i]['TicketNumber']; ?></a></td>                         
							<td align="right"><?php echo $LD[$i]['TicketDate']; ?></td>                        
						<?php }else{ ?>
							<td align="right"><a href="http://193.117.210.98:8081/ticket/Conveyance/<?php echo $LD[$i]['TicketConveyance'].".pdf"; ?>" title="View Conveyance Ticket" target="_blank" > <?php echo $LD[$i]['NonAppConveyanceNo']; ?></a></td>                        
							<td align="right"><a href="<?php echo base_url('assets/pdf_file/'.$LD[$i]['TicketPDF']); ?>" title="View Ticket" target="_blank" > <?php echo $LD[$i]['TicketNumber']; ?></a></td>                         
							<td align="right"><?php echo $LD[$i]['TicketDate']; ?></td>                        
						<?php } ?>
					<?php }else{ ?>
						<?php if($LD[$i]['AppUser']==0 ){ ?> 				
							<td align="right"><a href="<?php echo base_url('assets/conveyance/'.$LD[$i]['ConvPDF']); ?>" title="View Conveyance Ticket" target="_blank" > <?php echo $LD[$i]['ConveyanceNo']; ?></a></td>                        
							<td align="right"><a href="http://193.117.210.98:8081/ticket/Supplier/<?php echo $LD[$i]['TipName']."-".$LD[$i]['TipTicketNo'].".pdf"; ?>" title="View Tip Ticket" target="_blank" > <?php echo $LD[$i]['TipTicketNo']; ?></a></td>                         
							<td align="right"><?php echo $LD[$i]['TipTicketDate']; ?></td>                        
						<?php }else{ ?>
							<td align="right"><a href="http://193.117.210.98:8081/ticket/Conveyance/<?php echo $LD[$i]['NonAppConveyanceNo'].".pdf"; ?>" title="View Conveyance Ticket" target="_blank" > <?php echo $LD[$i]['NonAppConveyanceNo']; ?></a></td>                        
							<td align="right"><a href="http://193.117.210.98:8081/ticket/Supplier/<?php echo $LD[$i]['TipName']."-".$LD[$i]['TipNumber'].".pdf"; ?>" title="View Ticket" target="_blank" > <?php echo $LD[$i]['TipNumber']; ?></a></td>                         
							<td align="right"><?php echo $LD[$i]['SiteOutDateTime']; ?></td>                        
						<?php } ?>
					<?php } ?>	
				<?php }  ?>
				<?php if($record->BookingType==2){ ?>	
					<?php if($LD[$i]['TipID']==1 ){ ?> 				
						<?php if($LD[$i]['AppUser']==0 ){ ?> 				
							<td align="right">-</td>                        
							<td align="right"><a href="<?php echo base_url('assets/pdf_file/'.$LD[$i]['TicketPDF']); ?>" title="View Ticket" target="_blank" > <?php echo $LD[$i]['TicketNumber']; ?></a></td>                         
							<td align="right"><?php echo $LD[$i]['TicketDate']; ?></td>                        
						<?php }else{ ?>
							<td align="right">-</td>                        
							<td align="right"><a href="<?php echo base_url('assets/pdf_file/'.$LD[$i]['TicketPDF']); ?>" title="View Ticket" target="_blank" > <?php echo $LD[$i]['TicketNumber']; ?></a></td>                         
							<td align="right"><?php echo $LD[$i]['TicketDate']; ?></td>                        
						<?php } ?>
					<?php }else{ ?>
						<?php if($LD[$i]['AppUser']==0 ){ ?> 				
							<td align="right">-</td>                        
							<td align="right"><a href="<?php echo base_url('assets/pdf_file/'.$LD[$i]['TicketPDF']); ?>" title="View Ticket" target="_blank" > <?php echo $LD[$i]['TicketNumber']; ?></a></td>                         
							<td align="right"><?php echo $LD[$i]['TicketDate']; ?></td>                        
						<?php }else{ ?>
							<td align="right">-</td>                        
							<td align="right"><a href="http://193.117.210.98:8081/ticket/Supplier/<?php echo $LD[$i]['TipName']."-".$LD[$i]['TipNumber'].".pdf"; ?>" title="View Ticket" target="_blank" > <?php echo $LD[$i]['TipNumber']; ?></a></td>                         
							<td align="right"><?php echo $LD[$i]['SiteOutDateTime']; ?></td>                        
						<?php } ?>
					<?php } ?>	
				<?php } ?> 
				 
				<td ><?php  echo $LD[$i]['DriverName']; ?></td>
				<td ><?php  echo  $LD[$i]['VehicleRegNo']; ?></td> 
				
				<td align="right"><?php  echo $LD[$i]['GrossWeight']; ?></td>
				<td align="right"><?php  echo $LD[$i]['Tare'];  ?></td>
				<td align="right"><?php  echo $LD[$i]['Net']; ?></td> 
				
				
				<td ><?php echo $LD[$i]['TipName']; ?></td>
				<td ><?php echo $LD[$i]['MaterialName'];  ?></td> 
				<td align="right" ><?php if($LD[$i]['WaitTime']>0){ echo $LD[$i]['WaitTime']; }else{ echo "0"; } ?></td> 
				<td align="right"  ><?php if($LD[$i]['WaitTime']>0){ echo ($LD[$i]['WaitTime']*$LD[$i]['WaitingCharge']); }else{ echo '0'; } ?></td>  
				<td ><?php if($LD[$i]['Status']==0){ echo '<span class="label label-danger" > Pending </span>'; } 
				 if($LD[$i]['Status']==1){ echo '<span class="label label-warning" > Accepted </span>';  }  if($LD[$i]['Status']==2){ echo '<span class="label label-primary" > At Site </span>';  }
				 if($LD[$i]['Status']==3){  echo '<span class="label label-default" > Out Site </span>'; }  if($LD[$i]['Status']==4){ echo '<span class="label label-success" > Finish </span>';  } 
				 if($LD[$i]['Status']==5){  echo '<span class="label label-danger" > Cancel </span>'; }  if($LD[$i]['Status']==6){ echo '<span class="label label-danger" > Wasted </span>';  }  
				 ?>
				</td> 
				<td><input type="text" value="<?php echo $LD[$i]['Price']; ?>" class="LoadPrice<?php echo $record->BookingDateID; ?>" data-BookingDateID="<?php echo $record->BookingDateID; ?>" style="width:60px" name="LoadPrice<?php echo $LD[$i]['LoadID']; ?>" > 
				<input type="hidden" value="<?php echo $LD[$i]['MaterialID']; ?>"  name="MaterialID<?php echo $LD[$i]['LoadID']; ?>" > 
				<input type="hidden" value="<?php echo $LD[$i]['Status']; ?>"  name="LoadStatus<?php echo $LD[$i]['LoadID']; ?>" >  
				<input type="hidden" value="<?php echo $LD[$i]['BookingDateID']; ?>"  name="BookingDateID<?php echo $LD[$i]['LoadID']; ?>" > 
				<input type="hidden" value="<?php echo $LD[$i]['LoadID']; ?>"  name="LoadID[]" >
				</td>
			</tr>   
			<?php } ?>
			</tbody>	
		</table> 
			<?php  //} ?>  
		</td>
	</tr>
	<?php } ?> 
	<?php } ?> 
		<tr style="background-color:#f9f9f1">  
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td> 
			<td  align='right' ><b>SubTotal</b> </td>
			<td  align="right" ><span id="SubTotal"><?php echo (float)round($SubAmount); ?></span> <input type="hidden" value="<?php echo (float)round($SubAmount); ?>"  name="SubTotalAmount" id="SubTotalAmount"  > </td> 
		</tr> 
		<tr style="background-color:#f9f9f1">  
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td> 
			<td  align='right'   ><b>VAT (20%)</b></td>
			<td align="right" ><span id="Vat"><?php echo $Vat = (float)round(($SubAmount*20)/100); ?></span> <input type="hidden" value="<?php echo $Vat; ?>"  name="VatAmount" id="VatAmount"  > </td> 
		</tr> 
		<tr style="background-color:#f9f9f1">  
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td>
			<td  align='right' >  </td> 
			<td  align='right'   ><b>Total</b></td>
			<td align="right"  ><span id="TotalAmount"><?php echo (float)round($SubAmount+$Vat); ?></span> <input type="hidden" value="<?php echo (float)round($SubAmount+$Vat); ?>"  name="FinalAmount" id="FinalAmount"  > </td> 
		</tr>  
	<?php } ?> 
	</tbody>	 
  </table> 
					</div>
				</div> 
				</div>  	 
				</div> 
			</div>  					
		</div>
	</div> 	
	<?php if(count($LD)>0){ ?>		
   	<div class="row"> 
		<div class="col-md-12"> 
			<div class="box box-primary"> 
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group"> 
								<input type="checkbox" id="InvoiceHold" name="InvoiceHold"  <?php if($RequestInfo['InvoiceHold']==1){ ?> checked <?php } ?> value="1" /> <b> HOLD Invoice  </b> <i>( Check This Box to Put Invoice On HOLD )</i>
							</div> 
						</div> 
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Comment: </label>  
								<textarea class="form-control" id="InvoiceComment" rows="3" name="InvoiceComment" placeholder="Please Enter Your Any Comment Here."></textarea> 
							</div> 
						</div>  		
						
						<div class="col-md-12">                                
							<div class="form-group">   
									<input type="submit" name="submit" style="float:right" class="btn btn-primary" value="Proceed To Confirm" /> 
							</div>  
						</div>  			
						
					</div> 
				</div>	 
			</div>                       
		</div>     		  
	</div>  
	<?php } ?>
	</form>	
    </section> 
	
		<?php if(count($Comments)>0){  ?>
		<section class="content">  
		<h3 class="box-title">List Of Comments</h3>
			<div class="row">
				<div class="col-md-12"> 
				  <ul class="timeline"> 
				  <?php foreach($Comments as $key=>$record){ if($record->userId == $this->session->userdata['userId'] ){ $class = 'bg-red'; }else{ $class = "bg-blue"; }   ?>
					<li class="time-label">
						  <span class="<?php echo $class;  ?>"> <?php echo $record->CommentDate;  ?> </span>
					</li> 
					<li>
					  <i class="fa fa-comment <?php echo $class;  ?>"></i>  
					  <div class="timeline-item"> 
						<h3 class="timeline-header"> <b> <?php echo $record->CreatedByName;  ?>( <?php echo $record->CreatedByMobile;  ?> | <?php echo $record->CreatedByEmail;  ?> )  </b> </h3> 
						<div class="timeline-body">
							<p> <?php echo $record->Comment;  ?> </p> 
						</div> 
					  </div>
					</li>  	  
					<?php } ?>
					<li>
					  <i class="fa fa-clock-o bg-gray"></i>
					</li>
				  </ul>
				</div> 
			</div>  
		</section>
	<?php } ?>

</div>  

<script > 
 
$(document).ready(function() {
	
    var table = $('#ticket-grid1').DataTable( {  
        "bLengthChange": false ,
		"searching": false,
	    "bPaginate": false,
		"ordering": false,
		"bInfo": false 
    } );

	jQuery(document).on("click", ".PriceLogs", function(){  
			var BookingID = $(this).attr("data-BookingID"),  
				hitURL1 = baseURL + "BookingPriceLogsAJAX",
				currentRow = $(this);   
				//alert(BookingDateID);  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL1,
				data : { 'BookingID' : BookingID } 
				}).success(function(data){ 
					//alert(data)
					$('.modal-body').html(data);
					
					$('#empModal .modal-title').html("View Price Logs");
					$('#empModal .modal-dialog').width(500); 
					$('#empModal').modal('show');  
					
					//alert(JSON.stringify( data ));   
					//console.log(data);   
				}); 
				 
	});


	/*$("#HLD").click(function(){   
		var HOLD = $("input[name='HoldLoad']:checked").map(function() {
			return this.value;
		}).get().join(','); 
		var BookingRequestID = $(this).attr("data-BookingRequestID"), 
			hitURLUP = baseURL + "CreateInvoiceHoldLoadAJAX",
			currentRow = $(this);	   
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURLUP,
			data : { 'HOLD' : HOLD, 'BookingRequestID' : BookingRequestID } 
			}).success(function(data){ 
				//alert(JSON.stringify(data))  
				if(data.status == true) {   
					window.location.href = "/BookingCreateInvoice/"+BookingRequestID; 
				}   
			});    
	}); */
	
	$(".HoldMe").click(function(){  
	  
		var LoadID = $(this).attr("data-LoadID"), 
			BookingDateID = $(this).attr("data-BookingDateID"), 
			hitURLUP = baseURL + "HoldLoadAJAX",
			currentRow = $(this);
 
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURLUP,
			data : {  'LoadID' : LoadID   } 
			}).success(function(data){ 
				//alert(JSON.stringify(data))   
				if(data.status == true) {    
					currentRow.closest('tr').remove(); 	 
					var sum = 0;
					$('.LoadPrice'+BookingDateID).each(function(){
						sum += parseFloat($(this).val());
					});  
					$('#TP'+BookingDateID).html(parseFloat(sum).toFixed(2));
					$('#TotalPrice'+BookingDateID).val(parseFloat(sum).toFixed(2));
					
					var sum1 = 0;
					$('.TotalPrice').each(function(){
						sum1 += parseFloat($(this).html());
					});
					
					$('#SubTotal').html(parseFloat(sum1).toFixed(2));
					$('#SubTotalAmount').val(parseFloat(sum1).toFixed(2));
					
					var Vat = parseFloat((sum1*20)/100);
					$('#Vat').html(parseFloat(Vat).toFixed(2));  
					$('#VatAmount').val(parseFloat(Vat).toFixed(2));  
					
					var TotalAmount = parseFloat(sum1) + parseFloat(Vat);
					$('#TotalAmount').html(parseFloat(TotalAmount).toFixed(2)); 
					$('#FinalAmount').val(parseFloat(TotalAmount).toFixed(2)); 
				}   
			});   
 
	});
	
	jQuery(document).on("click", ".PriceUpdate", function(){   
		var BookingDateID = $(this).attr("data-BookingDateID"), 
			Loads = $('#Loads'+BookingDateID).val(),  
			Price = $('#Price'+BookingDateID).val();  
			
			$('#TP'+BookingDateID).html(parseFloat(Loads*Price).toFixed(2));
			$('#TotalPrice'+BookingDateID).val(parseFloat(Loads*Price).toFixed(2));
			$('.LoadPrice'+BookingDateID).val(parseFloat(Price).toFixed(2));
			
			var sum = 0;
			$('.TotalPrice').each(function(){
				sum += parseFloat($(this).html()); 
			});  
			$('#SubTotal').html(parseFloat(sum).toFixed(2));
			$('#SubTotalAmount').val(parseFloat(sum).toFixed(2));
			
			var Vat = parseFloat((sum*20)/100);
			$('#Vat').html(parseFloat(Vat).toFixed(2));   
			$('#VatAmount').val(parseFloat(Vat).toFixed(2));  
			
			var TotalAmount = parseFloat(sum)+parseFloat(Vat); 
			$('#TotalAmount').html(parseFloat(TotalAmount).toFixed(2));
			$('#FinalAmount').val(parseFloat(TotalAmount).toFixed(2)); 			
			 
	});
	
	jQuery(document).on("keyup","[class^='LoadPrice']", function(){   
		//alert("sdfsdfsdf");
		var BookingDateID = $(this).attr("data-BookingDateID"), 
			Price = parseFloat($( this ).val()); 
			var sum = 0;
			$('.LoadPrice'+BookingDateID).each(function(){
				sum += parseFloat($(this).val());
			});  
			$('#TP'+BookingDateID).html(parseFloat(sum).toFixed(2));
			$('#TotalPrice'+BookingDateID).val(parseFloat(sum).toFixed(2));
			
			var sum1 = 0;
			$('.TotalPrice').each(function(){
				sum1 += parseFloat($(this).html());
			});
			
			$('#SubTotal').html(parseFloat(sum1).toFixed(2));
			$('#SubTotalAmount').val(parseFloat(sum1).toFixed(2));
			
			var Vat = parseFloat((sum1*20)/100);
			$('#Vat').html(parseFloat(Vat).toFixed(2));  
			$('#VatAmount').val(parseFloat(Vat).toFixed(2));  
			
			var TotalAmount = parseFloat(sum1) + parseFloat(Vat);
			$('#TotalAmount').html(parseFloat(TotalAmount).toFixed(2)); 
			$('#FinalAmount').val(parseFloat(TotalAmount).toFixed(2)); 
			
	});
	 
	
	
	$('.tgrid tbody').on('click', 'td.details-control', function () { 
	 
        var tr = $(this).closest('tr');  
        var row = table.row( tr );   
	    var BookingDateID = $(this).closest('tr').attr('data-BookingDateID'); 
		  
        if($('#hiddenRow'+BookingDateID).closest('tr').is(':visible')){  
			$('#hiddenRow'+BookingDateID).hide()
            tr.removeClass('shown');
        }else {    
			$('#hiddenRow'+BookingDateID).show()
			tr.addClass('shown'); 
        }
		
    });	
    // Add event listener for opening and closing details
    /*$('#ticket-grid1 tbody').on('click', 'td.details-control', function () { 
        var tr = $(this).closest('tr');
        var row = table.row( tr );   
	    var BookingDateID = $(this).closest('tr').attr('data-BookingDateID');
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }else {
            // Open this row 
			var hitURL1 = baseURL + "ShowPreInvoiceAllLoadsAJAX"; 
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL1,
			data : { 'BookingDateID' : BookingDateID } 
			}).success(function(data){ 
				//alert(data) 
				//row.child( format(row.data()) ).show(); 
				row.child( data).show(); 
				tr.addClass('shown');
			});  
 			
			
        }
    }); */
	
	
} );
</script>