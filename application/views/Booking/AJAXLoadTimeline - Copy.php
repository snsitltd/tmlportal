<?php  //echo "<PRE>"; var_dump($Loads); var_dump($Photos);echo "</PRE>";
//var_dump($Photos);

if($Loads[0]->DriverName!=""){ $DriverName = ucfirst($Loads[0]->DriverName); $VRN = strtoupper($Loads[0]->VehicleRegNo);  }else{ $DriverName =  ucfirst($Loads[0]->dname);  $VRN = strtoupper($Loads[0]->vrn);  } ?>
<section class="content"> 
<!-- row -->
<div class="row">
<div class="col-md-12">
  <!-- The time line -->
  <ul class="timeline">
	<!-- timeline time label -->
	
	<li class="time-label">
		  <span class="bg-gray"> <?php echo $Loads[0]->CreateDateTime; ?>  </span>
	</li>
	<!-- /.timeline-label -->
	<!-- timeline item -->
	<li>
	  <i class="fa fa-envelope bg-blue"></i> 
	  <div class="timeline-item">
		<!-- <span class="time"><i class="fa fa-clock-o"></i> 12:05</span> -->
		<h3 class="timeline-header"><a href="mailto:<?php echo $Loads[0]->CreatedByEmail; ?>"><?php echo $Loads[0]->CreatedByName; ?> (<?php echo $Loads[0]->CreatedByMobile; ?>)</a>
		had Allocated a Load / Lorry to <a href="<?php echo base_url('viewDriver/'.$Loads[0]->DriverID); ?>" ><?php echo $DriverName; ?> (<?php echo $Loads[0]->DriverMobile; ?>)</a> </h3> 
		<div class="timeline-body">
		   <b>Company Name: </b> <?php echo $Loads[0]->CompanyName; ?> <br>
		   <b>Site Address: </b> <?php echo $Loads[0]->OpportunityName; ?>  <br> 
		   <b>Material Name: </b> <?php echo $Loads[0]->MaterialName; ?>  <br> 
		   <b>Site Contact Name: </b> <?php echo $Loads[0]->ContactName; ?>  <br>  
		   <b>Site Contact Mobile No.: </b> <?php echo $Loads[0]->ContactMobile; ?>  <br>  
		   <b>Site Contact Email Address: </b> <?php echo $Loads[0]->Email; ?>  <br> 
		   <?php if(trim($Loads[0]->Price)!=""){ ?><b>Price: </b> £<?php echo $Loads[0]->Price; ?>  <br> <?php } ?>
		   <?php if(trim($Loads[0]->PurchaseOrderNumber)!=""){ ?><b>Purchase Order No.: </b> <?php echo $Loads[0]->PurchaseOrderNumber; ?>  <br> <?php } ?>
		   <?php if(trim($Loads[0]->Notes)!=""){ ?><b>Notes: </b> <?php echo $Loads[0]->Notes; ?> <?php } ?>
		</div> 
	  </div>
	</li>
	<!-- END timeline item -->
	
	<?php if($Loads[0]->Status>0){ ?>
	<!-- timeline item -->
	<li class="time-label">
		  <span class="bg-blue"> <?php echo $Loads[0]->JobStartDateTime; ?>  </span>
	</li>
	<li>
	  <i class="fa fa-user bg-aqua"></i> 
	  <div class="timeline-item">
		<!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>  -->
		<h3 class="timeline-header no-border"><a href="<?php echo base_url('viewDriver/'.$Loads[0]->DriverID); ?>" ><?php echo $DriverName; ?> (<?php echo $Loads[0]->DriverMobile; ?>)</a> has Accepted Load / Lorry Request.</h3>
		<div class="timeline-body">
		   <b>Driver Name: </b> <?php echo $DriverName; ?> <br>
		   <b>Driver Mobile No.: </b> <?php echo $Loads[0]->DriverMobile; ?>  <br> 
		   <b>Vehicle Reg No (Lorry No): </b> <?php echo $VRN; ?>  <br> 
		</div> 
	  </div>
	</li>
	<!-- END timeline item --> 
	<?php  } if($Loads[0]->Status>1){ ?> 
	<!-- timeline item -->
	<li class="time-label">
		  <span class="bg-yellow"> <?php echo $Loads[0]->SiteInDateTime; ?>  </span>
	</li>
	<li>
	  <i class="fa fa-user bg-aqua"></i> 
	  <div class="timeline-item"> 
		<h3 class="timeline-header no-border"> <a href="<?php echo base_url('viewDriver/'.$Loads[0]->DriverID); ?>" ><?php echo $DriverName; ?> (<?php echo $Loads[0]->DriverMobile; ?>)</a> 
		has been Reached to <b><?php echo $Loads[0]->OpportunityName; ?></b> </h3>
	  </div>
	</li>
	<!-- END timeline item -->
	<?php  } if($Loads[0]->Status>2){ ?>
		<!-- timeline time label -->
		<li class="time-label">
			  <span class="bg-red"> <?php echo $Loads[0]->SiteOutDateTime; ?> </span>
		</li>
		<!-- /.timeline-label -->	
		<?php if($Photos){ if(count($Photos)>0){ 	//echo "<PRE>"; var_dump($Photos);echo "</PRE>"; ?>
		<!-- timeline item -->
		<li>
		  <i class="fa fa-camera bg-purple"></i> 
		  <div class="timeline-item">  
			<h3 class="timeline-header"><a href="<?php echo base_url('viewDriver/'.$Loads[0]->DriverID); ?>" ><?php echo $DriverName; ?> (<?php echo $Loads[0]->DriverMobile; ?>)</a>  uploaded photos</h3> 
			<div class="timeline-body">
			<?php for($i=0;$i<count($Photos);$i++){ ?>
			  <a href="<?php echo base_url('uploads/Photo/'.$Photos[0]->ImageName); ?>"  target="_blank" ><img src="<?php echo base_url('uploads/Photo/'.$Photos[0]->ImageName); ?>" width="150" height="100"  alt="..." class="margin"> </a>
			<?php } ?>
			</div> 
		  </div>
		</li>
		<?php }} ?>
		<li>
		  <i class="fa fa-user bg-aqua"></i> 
		  <div class="timeline-item"> 
			<h3 class="timeline-header no-border"> <a href="<?php echo base_url('viewDriver/'.$Loads[0]->DriverID); ?>" ><?php echo $DriverName; ?> (<?php echo $Loads[0]->DriverMobile; ?>)</a> 
			has Generate Receipt. 
			<a href="<?php echo base_url('assets/conveyance/'.$Loads[0]->ReceiptName); ?>" title="Click here to View Conveyance Receipt" target="_blank" ><i class="fa fa-file-pdf-o"></i> </a> </h3>
			<div class="timeline-body">
			   <b>Conveyance Ticket No: </b> <?php echo $Loads[0]->ConveyanceNo; ?>   
			   <a href="<?php echo base_url('assets/conveyance/'.$Loads[0]->ReceiptName); ?>" title="Click here to View Conveyance Receipt" target="_blank" ><i class="fa fa-file-pdf-o"></i> </a>
			</div> 
		  </div>
		</li>
		<!-- END timeline item -->
	<?php  } if($Loads[0]->Status>3){ ?>
	
	<li class="time-label">
		  <span class="bg-green"> <?php echo $Loads[0]->JobEndDateTime; ?> </span>
	</li>
	<li>
	  <i class="fa fa-user bg-aqua"></i> 
	  <div class="timeline-item"> 
		<h3 class="timeline-header no-border"> <a href="<?php echo base_url('viewDriver/'.$Loads[0]->DriverID); ?>" ><?php echo $DriverName; ?> (<?php echo $Loads[0]->DriverMobile; ?>)</a> 
		has been Left From <?php echo $Loads[0]->OpportunityName; ?> <?php //echo $Loads[0]->TipName; ?>. </h3> 
	  </div>
	</li>	
	<?php } ?>
	<li>
	  <i class="fa fa-clock-o bg-gray"></i>
	</li>
  </ul>
</div>
<!-- /.col -->
</div>
<!-- /.row --> 

</section>