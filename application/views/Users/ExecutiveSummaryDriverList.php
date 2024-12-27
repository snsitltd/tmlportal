<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">  
      <h1> <i class="fa fa-users"></i> Loads Done By Driver During - <?php echo date("d/m/Y", strtotime($FirstDate));  ?> - <?php echo date("d/m/Y", strtotime($SecondDate));  ?> 
	  <a class="btn btn-success" href="<?php  echo base_url('ExecutiveSummary'); ?>" style="float:right;margin: 6px "> Executive Summary </a>
	  </h1>
    </section>
    <section class="content">
	<div class="row"> 
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Loads Done By Driver  </h3>
                    </div>  
                    <form name="PDA" action="<?php //echo base_url('PDAUsers'); ?>" method="post" id="PDA" role="form">
                        <div class="box-body">
                            <div class="row"> 
                                <div class="col-md-3">     
									 <div class="form-group"> 
										<div class="input-group">
										  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
										  <input type="text" class="form-control pull-right" id="reservation"  autocomplete="off"    required="" name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('m/d/Y').'-'.date('m/d/Y'));?>">
										</div>  
									</div>                        
                                </div> 
								
								<div class="col-md-3">       
									<div class="form-group"> 
										<input type="submit" class="btn btn-primary" value="Search" name="search" />
									</div>                               
                                </div> 
                            </div>   
                        </div>   
						<div class="box-footer"> 
							<?php if(count($TodayBookingDriver1)>0){ ?> 
								<input type="submit" class="btn btn-warning  " value="Export XLS"  name="export" />
								<input type="submit" class="btn btn-success  " value="Export PDF"  name="export1" /> 
							<?php } ?>		
                        </div>
                    </form> 
                </div>
            </div> 
        </div>  
 
           
          <div class="row" style="height:770px">   
			<div class="col-xs-12">
            <div class="box">
            <div class="box-header"> <h3 class="box-title">Loads Done By Driver During  <?php echo date("d/m/Y", strtotime($FirstDate));  ?> - <?php echo date("d/m/Y", strtotime($SecondDate));  ?>  </h3>  </div> 
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
							<?php if(count($TodayBookingDriver1)>0){ 
							$i = 1; $TCollection = 0; $TDelivery = 0; $TDayWork = 0; $THaulage = 0;  $TWasted = 0; $TCancel = 0; 
							
							foreach($TodayBookingDriver1 as $row){  
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
    $('#reservation').daterangepicker({ locale: { format: 'DD/MM/YYYY' }});
	var PDA = $("#PDA");	
	var validator = PDA.validate();
}); 
</script>  