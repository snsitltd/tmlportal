<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">  
      <h1> <i class="fa fa-users"></i> Executive Summary - <?php echo date("d/m/Y", strtotime($SearchDate));  ?>  
	  <a class="btn btn-success" href="<?php  echo base_url('ExecutiveSummaryDriverList'); ?>" style="float:right;margin: 6px "> Executive Summary Driver List</a>
	  </h1>
    </section>
    <section class="content">
	<div class="row"> 
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Executive Summary  </h3>
                    </div>  
                    <form name="PDA" action="<?php //echo base_url('PDAUsers'); ?>" method="post" id="PDA" role="form">
                        <div class="box-body">
                            <div class="row"> 
                                <div class="col-md-3">     
									<div class="form-group">
										<label>Select Date:</label> 
										<div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                        <input type="text" autocomplete="off" class="form-control " id="SearchDate" value="<?php //echo date('d/m/Y'); ?>" name="SearchDate"  > 
                                        </div>  
									</div>                               
                                </div> 
								<div class="col-md-3">     
										<label> </label> 
										
									<div class="form-group"> 
										<input type="submit" class="btn btn-primary" value="Search" name="search" />
									</div>                               
                                </div> 
                            </div>   
                        </div>   
                    </form> 
                </div>
            </div> 
        </div>  

		 <div class="row">
            <div class="col-lg-2 col-xs-6"> 
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><a href="<?php echo base_url('PDAUsers'); ?>" ><?php echo count($TodayPDAUsers); ?></a></h3>
                  <p>PDA Users</p>
                </div>
                <div class="icon">
                 <i class="fa fa-users"></i>
                </div> 
              </div>
            </div> 
            <div class="col-lg-2 col-xs-6"> 
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $TodayTotalJobsAllocated; ?></h3>
                  <p>No of Total Jobs Allocated</p>
                </div>
                <div class="icon">
                 <i class="fa fa-users"></i>
                </div>
                <!-- <a href="<?php echo base_url(); ?>PDAUsers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div> 
            <div class="col-lg-2 col-xs-6"> 
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $TodayTotalJobsFinished; ?></h3>
                  <p>No Of Jobs Finished</p>
                </div>
                <div class="icon">
                 <i class="fa fa-users"></i>
                </div>
                <!-- <a href="<?php echo base_url(); ?>PDAUsers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div> 
			<div class="col-lg-2 col-xs-6"> 
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $TodayTotalJobsCancelled; ?></h3>
                  <p>No Of Jobs Cancelled </p>
                </div>
                <div class="icon">
                 <i class="fa fa-users"></i>
                </div>
                <!-- <a href="<?php echo base_url(); ?>PDAUsers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div> 
            <div class="col-lg-2 col-xs-6"> 
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $TodayTotalJobsWasted; ?></h3>
                  <p>No Of Wasted Journey</p>
                </div>
                <div class="icon">
                 <i class="fa fa-users"></i>
                </div>
                <!-- <a href="<?php echo base_url(); ?>PDAUsers" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div> 
          </div>
		  
           
          <div class="row" style="height:770px">
			<div class="col-xs-12">
            <div class="box">
            <div class="box-header"> <h3 class="box-title">Booking List of Date : <?php echo date("d/m/Y", strtotime($SearchDate));  ?>  </h3>  </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="pda" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th width="20" rowspan="2">BNo</th> 
						<th  rowspan="2" >Opportunity Name</th>  
						<th width="50" colspan="2" align="center" >Tonnage (Ton)</th>  
						<th width="50" colspan="2" align="center" >Loads</th>  
						<th width="50" colspan="2" align="center" >TurnAround</th>  
						<th width="50"  rowspan="2" >DayWork</th>  
						<th width="50"  rowspan="2" >Haulage</th>  
                    </tr>
					<tr> 
						<th width="50">Collection</th>  
						<th width="50">Delivery</th> 
						<th width="50">Collection</th>  
						<th width="50">Delivery</th> 
						<th width="50">Collection</th> 
						<th width="50">Delivery</th>  
                    </tr>
                    </thead>
						<tbody>
							<?php if(count($TodayBooking)>0){ 
							
							$i = 1; $LCollection = 0; $LDelivery = 0; $TCollection = 0; $TDelivery = 0; 
							$TonCollection = 0; $TonDelivery = 0;$LDayWork = 0;$LHaulage = 0; 
							
							foreach($TodayBooking as $row){  
							
								$LCollection = $LCollection + $row['LoadCollection']; 
								$LDelivery = $LDelivery + $row['LoadDelivery']; 
								$TCollection = $TCollection + $row['TACollection']; 
								$TDelivery = $TDelivery + $row['TADelivery']; 
								$TonCollection = $TonCollection + $row['TonCollection']; 
								$TonDelivery = $TonDelivery + $row['TonDelivery'];  
								$LDayWork = $LDayWork + $row['LoadDayWork']; 
								$LHaulage = $LHaulage + $row['LoadHaulage']; 
							
							?>
							<tr>
								<td ><?php echo $row['BookingRequestID']; ?> </td>		 
								<td ><?php echo $row['OpportunityName']; ?> </td>		 
								<td align="right" ><?php echo $row['TonCollection']; ?> </td>			 
								<td align="right"  ><?php echo $row['TonDelivery']; ?> </td>			 
								<td align="right" ><?php echo $row['LoadCollection']; ?> </td>			 
								<td align="right"  ><?php echo $row['LoadDelivery']; ?> </td>			 
								<td align="right"  ><?php echo $row['TACollection']; ?> </td>			 
								<td align="right"  ><?php echo $row['TADelivery']; ?> </td>			 
								<td align="right"  ><?php echo $row['LoadDayWork']; ?> </td>			 
								<td align="right"  ><?php echo $row['LoadHaulage']; ?> </td>			 
							</tr>   
							<?php $i = $i+1; } ?> 
							<tr style="background-color:#C1C1C1" > 
								<td  colspan="2"><b>Grand Total</b></td>	 
								<td  align="right" ><b><?php echo $TonCollection; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TonDelivery; ?></b> </td>			 
								<td  align="right" ><b><?php echo $LCollection; ?></b> </td>			 
								<td  align="right" ><b><?php echo $LDelivery; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TCollection; ?></b> </td>		  	  
								<td  align="right" ><b><?php echo $TDelivery; ?></b> </td>		  	  
								<td  align="right" ><b><?php echo $LDayWork; ?></b> </td>		  	  
								<td  align="right" ><b><?php echo $LHaulage; ?></b> </td>		  	  
							</tr>      
							<?php }else{ ?>
								<tr>  
									<td align="center" colspan="6" >There is no records.  </td>
								</tr>  
							<?php } ?>	
							
						</tbody>
                  </table>

              </div></div></div>
            </div> 
          </div> 
            </div>
			
		  
		  
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header"> <h3 class="box-title">Opportunity List of Date : <?php echo date("d/m/Y", strtotime($SearchDate));  ?>  </h3>  </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="pda" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th width="20">No</th> 
						<th>Opportunity Name</th>  
						<th width="50">Collection</th>  
						<th width="50">Delivery</th> 
						<th width="50">DayWork</th>  
						<th width="50">Haulage</th> 
						<th width="50">Total</th>
                    </tr>
                    </thead>
						<tbody>
							<?php if(count($TodayBookingOpportunity)>0){ 
								$i = 1; $TCollection = 0; $TDelivery = 0; $TDayWork = 0; $THaulage = 0; 
							foreach($TodayBookingOpportunity as $row){  
								$TCollection = $TCollection + $row['TotalCollection']; 
								$TDelivery = $TDelivery + $row['TotalDelivery']; 
								$TDayWork = $TDayWork + $row['TotalDayWork']; 
								$THaulage = $THaulage + $row['TotalHaulage']; 
							
							?>
							<tr>
								<td ><?php echo $i; ?> </td>		 
								<td ><?php echo $row['OpportunityName']; ?> </td>		 
								<td align="right" <?php if($row['TotalCollection']>0){ ?> style="background-color:#00a65a" <?php } ?> ><?php echo $row['TotalCollection']; ?> </td>			 
								<td align="right" <?php if($row['TotalDelivery']>0){ ?> style="background-color:#00c0ef" <?php } ?> ><?php echo $row['TotalDelivery']; ?> </td>			 
								<td align="right" <?php if($row['TotalDayWork']>0){ ?> style="background-color:#00a65a" <?php } ?>><?php echo $row['TotalDayWork']; ?> </td>			 
								<td align="right" <?php if($row['TotalHaulage']>0){ ?> style="background-color:#00c0ef" <?php } ?> ><?php echo $row['TotalHaulage']; ?> </td>			 
								<td align="right" <?php if($row['TotalCollection']+$row['TotalDelivery']+$row['TotalDayWork']+$row['TotalHaulage']>0){ ?> style="background-color:#00a65a" <?php } ?>  ><?php echo $row['TotalCollection']+$row['TotalDelivery']+$row['TotalDayWork']+$row['TotalHaulage']; ?> </td>		  	  
							</tr>   
							<?php $i = $i+1; } ?> 
							<tr style="background-color:#C1C1C1" > 
							 	 
								<td  colspan="2"  ><b>Grand Total</b></td>	 
								<td  align="right" ><b><?php echo $TCollection; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TDelivery; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TDayWork; ?></b> </td>			 
								<td  align="right" ><b><?php echo $THaulage; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TCollection+$TDelivery+$TDayWork+$THaulage; ?></b> </td>		  	  
							</tr>      
							<?php }else{ ?>
								<tr>  
									<td align="center" colspan="6" >There is no records.  </td>
								</tr>  
							<?php } ?>	
							
						</tbody>
                  </table>

              </div></div></div>
            </div> 
          </div> 
            </div>
			
			 <div class="col-xs-12">
            <div class="box">
            <div class="box-header"> <h3 class="box-title">Material List of Date : <?php echo date("d/m/Y", strtotime($SearchDate));  ?>  </h3>  </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="pda" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th width="20">No</th> 
						<th  >Material Name</th>   
						<th width="100">No of  Loads</th>
                    </tr>
                    </thead>
						<tbody>
							<?php if(count($TodayBookingMaterial)>0){ $i = 1; $Total = 0; 
							foreach($TodayBookingMaterial as $row){  
							$Total = $Total + $row['Total'];  ?>
							<tr>
								<td ><?php echo $i; ?> </td>		 
								<td ><?php echo $row['MaterialName']; ?> </td>		  	 
								<td  align="right" ><?php echo $row['Total']; ?> </td>		  	  
							</tr>   
							<?php $i = $i+1; } ?> 
							<tr style="background-color:#C1C1C1" > 
							 	 
								<td colspan="2" ><b>Grand Total</b></td>	  
								<td  align="right" ><b><?php echo $Total; ?></b> </td>		  	  
							</tr>       
							<?php }else{ ?>
								<tr>  
									<td align="center" colspan="6" >There is no records.  </td>
								</tr>  
							<?php } ?>	
							
						</tbody>
                  </table>

              </div></div></div>
            </div> 
          </div> 
            </div>
			
			<div class="col-xs-12">
            <div class="box">
            <div class="box-header"> <h3 class="box-title">Driver List of Date : <?php echo date("d/m/Y", strtotime($SearchDate));  ?>  </h3>  </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                   <table id="pda" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
						<th  >Driver Name</th>  
						<th width="50">Collection</th>  
						<th width="50">Delivery</th> 
						<th width="50">DayWork</th>  
						<th width="50">Haulage</th> 
						<th width="50">Wasted</th> 
						<th width="50">Cancel</th> 
						<th width="50">Total</th>
                    </tr>
                    </thead>
						<tbody>
							<?php if(count($TodayBookingDriver)>0){ 
							$i = 1; $TCollection = 0; $TDelivery = 0; $TDayWork = 0; $THaulage = 0;  $TWasted = 0; $TCancel = 0; 
							
							foreach($TodayBookingDriver as $row){  
							$TCollection = $TCollection + $row['TotalCollection']; 
							$TDelivery = $TDelivery + $row['TotalDelivery']; 
							
							$TDayWork = $TDayWork + $row['TotalDayWork']; 
							$THaulage = $THaulage + $row['TotalHaulage']; 
							
							$TWasted = $TWasted + $row['TotalWasted']; 
							$TCancel = $TCancel + $row['TotalCancel'];  
							?>
							<tr> 
								<td ><?php echo $row['DriverName']; ?> </td>		 
								<td align="right" <?php if($row['TotalCollection']>0){ ?> style="background-color:#00a65a" <?php } ?>  ><b><?php  echo $row['TotalCollection'];   ?></b> </td>			 
								<td align="right"  <?php if($row['TotalDelivery']>0){ ?> style="background-color:#00c0ef" <?php } ?>  ><b><?php echo $row['TotalDelivery']; ?></b> </td>			 
								
								<td align="right" <?php if($row['TotalDayWork']>0){ ?> style="background-color:#00a65a" <?php } ?>  ><b><?php  echo $row['TotalDayWork'];   ?></b> </td>			 
								<td align="right"  <?php if($row['TotalHaulage']>0){ ?> style="background-color:#00c0ef" <?php } ?>  ><b><?php echo $row['TotalHaulage']; ?></b> </td>			 
								
								<td align="right" <?php if($row['TotalWasted']>0){ ?> style="background-color:#f39c12" <?php } ?>  ><b><?php echo $row['TotalWasted']; ?></b> </td>			 
								<td align="right" <?php if($row['TotalCancel']>0){ ?> style="background-color:#dd4b39" <?php } ?>  ><b><?php echo $row['TotalCancel']; ?></b> </td>			 
								<td align="right" <?php if(($row['TotalCollection']+$row['TotalDelivery']+$row['TotalDayWork']+$row['TotalHaulage']+$row['TotalWasted']+$row['TotalCancel'])>0){ ?> style="background-color:#00a65a" <?php } ?>  >
								
								<b><?php echo $row['TotalCollection']+$row['TotalDelivery']+$row['TotalDayWork']+$row['TotalHaulage']+$row['TotalWasted']+$row['TotalCancel']; ?></b> </td>		  	  
							</tr>   
							<?php $i = $i+1; } ?> 
							<tr style="background-color:#C1C1C1" >  
								<td ><b>Grand Total</b></td>	 
								<td  align="right" ><b><?php echo $TCollection; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TDelivery; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TDayWork; ?></b> </td>			 
								<td  align="right" ><b><?php echo $THaulage; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TWasted; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TCancel; ?></b> </td>			 
								<td  align="right" ><b><?php echo $TCollection+$TDelivery+$TDayWork+$THaulage+$TWasted+$TCancel; ?></b> </td>		  	  
							</tr>      
							<?php }else{ ?>
								<tr>  
									<td align="center" colspan="6" >There is no records.  </td>
								</tr>  
							<?php } ?>	
							
						</tbody>
                  </table>

              </div></div></div>
            </div> 
          </div> 
            </div>
			
        </div>    
    </section>
</div>
<script >
$(document).ready(function(){
	$('#SearchDate').datepicker({  
		format: 'dd/mm/yyyy', 
		endDate: 'today',   
		daysOfWeekDisabled  : [0], 
		closeOnDateSelect: true
	});  
			
	//$('#SearchDate').datetimepicker({format: 'DD/MM/YYYY' }); 
		/*$('#pda').DataTable({
			"order": [[ 0, "asc" ]], 
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		}); */
});
</script>  