<script src="<?php echo base_url('assets/js/print.js'); ?>" type="text/javascript"></script>    
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
      <h1><i class="fa fa-users"></i> Booking Invoice : <?php echo $InvoiceInfo['InvoiceNumber']; ?></h1>
	</section>

     <section class="content"> 
			<?php echo validation_errors(); ?>
			  <?php //var_dump($RequestInfo); ?>
              <?php $this->load->helper("form"); ?>  
        <div class="row"> 
        <div class="col-md-12"> 
		<div class="box box-primary">
             
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Company Name : </label>  <?php echo $InvoiceInfo['CompanyName'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Opportunity Name : </label>  <?php echo $InvoiceInfo['OpportunityName'];?> 
							</div> 
						</div> 
					</div>
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Contact Name : </label>  <?php echo $InvoiceInfo['ContactName'];?> 
							</div> 
						</div> 
					</div> 
					<div class="row">
						<div class="col-md-12">                                
							<div class="form-group">
								<label for="fname">Contact Mobile : </label>  <?php echo $InvoiceInfo['ContactMobile'];?> 
							</div> 
						</div> 
					</div>	  
				   
				</div>	 
              </div>                       
        </div>    
		    
		</div> 
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Booking Invoice Items</h3>
				</div> 
				<div class="box-body">
					<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
	 			 
  <table   class="table table-bordered table-hover dataTable tgrid" role="grid" aria-describedby="example2_info">
  <thead>
	<tr>                            
		<th width="30" >No </th> 
		<th >Material</th>      
		<th width="50" >Qty</th>     
		<th width="80" >Total Price</th>     
	</tr>
	</thead> 
	<tbody>
	<?php 
	if(!empty($InvoiceItems)){   $i=1;  $SubTotal = 0;
		foreach($InvoiceItems as $key=>$record){  ?>
			<tr class="<?php echo $cls1; ?>" > 
				<td align="right" ><?php echo $record->ItemNumber; ?></td> 
				<td><?php echo $record->Description; ?>  </td>     
				<td align="right" ><?php echo round($record->Qty) ?></td> 
				<td align="right" ><?php echo $record->GrossAmount ?></td>     
			</tr> 
	<?php $i = $i+1; } ?> 
		<tr style="background-color:#f9f9f1">  
			<td  align='right' >  </td>
			<td  align='right' >  </td> 
			<td  align='right' ><b>SubTotal</b> </td>
			<td  align="right" ><span id="SubTotal"><?php echo  $InvoiceInfo['SubTotalAmount']; ?></span></td> 
		</tr> 
		<tr style="background-color:#f9f9f1">   
			<td  align='right' >  </td>
			<td  align='right' >  </td> 
			<td  align='right'   ><b>VAT (20%)</b></td>
			<td align="right" ><span id="Vat"><?php echo $InvoiceInfo['VatAmount']; ?></span></td> 
		</tr> 
		<tr style="background-color:#f9f9f1">   
			<td  align='right' >  </td>
			<td  align='right' >  </td> 
			<td  align='right'   ><b>Total</b></td>
			<td align="right"  ><span id="TotalAmount"><?php echo  $InvoiceInfo['FinalAmount']; ?></span> </td> 
		</tr>  
	<?php  } ?> 
	</tbody>	 
  </table> 
					</div>
				</div> 
				</div>  
				</div> 
			</div>  					
		</div>
	</div> 	
 
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
 