<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">  
      <h1> <i class="fa fa-users"></i> PDA Users - <?php echo date("d/m/Y", strtotime($SearchDate));  ?>  </h1>
    </section>
    <section class="content">
    
           <div class="row"> 
            <div class="col-md-12"> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">PDA Users  </h3>
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

          <div class="row" style="height:770px">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header"> <h3 class="box-title">PDA Users List of Date : <?php echo date("d/m/Y", strtotime($SearchDate));  ?>  </h3>  </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="pda" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>  
						<th width="20">LorryNo</th> 
						<th>Driver Name</th>   
						<th >Login Location</th> 
						<th width="100">IPAddress</th> 
						<th width="100">MAC Address</th> 
						<th width="140">LogIn DateTime</th>
						<th width="140">LogOut DateTime</th>
                    </tr>
                    </thead>
						<tbody>
							<?php if(count($TodayPDAUsers)>0){ $i = 1;  $lorry = array() ;
							foreach($TodayPDAUsers as $row){  
							 if (!in_array($row['LorryNo'], $lorry)){  ?>
							<tr> 
								<td ><?php echo $row['LorryNo']; ?> </td>	 	 
								<td ><?php echo $row['DriverName']; ?> </td>		 
								<td ><?php echo $row['LogInLoc']; ?> </td>		   
								<td ><?php echo $row['IPAddress']; ?> </td>		  
								<td ><?php echo $row['MacAddress']; ?> </td>		  
								<td ><?php echo $row['LoginDatetime']; ?> </td>		  
								<td ><span id="LogOut<?php echo $row['LogID']; ?>">
								<?php if($row['LogoutDateTIme'] != '00-00-0000 00:00:00'){ echo $row['LogoutDateTIme']; }else{ ?> 
									<button class="btn btn-danger LogOutDriver"  data-LogID="<?php echo $row['LogID']; ?>"    title="Click To LOGOUT DRIVER">LOGOUT NOW</button>
								<?php } ?> </span>
								</td>		  
							</tr>  
							 <?php $i = $i+1; $lorry[] = $row['LorryNo']; } } }else{ ?>
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
			
	jQuery(document).on("click", ".LogOutDriver", function(){
		var LogID = $(this).attr("data-LogID"),
			hitURL = baseURL + "LogOutDriver",
			currentRow = $(this);			
			//alert(hitURL);	 
			if(confirm("Are You Sure You Want To LogOut This Driver ?")){  
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { 'LogID' : LogID } 
				}).success(function(data){
					//console.log(data);  			
					if(data.status == true) { 
						$('#LogOut'+data.LogID).html(data.LogoutDateTIme);
						alert("Driver LoggedOut Successfully");  
					}else{ alert("Ooooops, Please Try Again Later ..."); } 
				}); 
			}
		 
	});
});
</script>  