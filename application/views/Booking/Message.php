<div class="content-wrapper"> 
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Send Driver Message</h1> </section> 
    <section class="content">
	<?php
		$this->load->helper('form');
		$error = $this->session->flashdata('error');
		if($error)
		{
	?>
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<?php echo $this->session->flashdata('error'); ?>                    
	</div>
	<?php } ?>
	<?php  
		$success = $this->session->flashdata('success');
		if($success)
		{
	?>
	<div class="alert alert-success alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<?php echo $this->session->flashdata('success'); ?>
	</div>
	<?php } ?>
		<div class="row">
            <div class="col-xs-12 text-left">
                <div class="form-group">
					<textarea class="form-control" id="message" rows="3" style="width:500px" name="message" ></textarea><br>
                    <button class="btn btn-primary" name="send" id="send" ><i class="fa fa-plus"></i> Send Message</button> 
					<a class="btn btn-info"  href="<?php echo base_url('AllMessage'); ?>" ><i class="fa fa-plus"></i> All Messages</a>  
                </div> 
            </div>
        </div>
		
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Drivers List</h3>
            </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th width="5" ><input type="checkbox" name="checkAll" class="checkAll"> </th>                        
						<th width="10" align="right">LorryNo</th>                         
                        <th >Driver Name</th>   
						<th>Haulier</th>    
						<th width="100">Reg Number</th>   
                        <th width="70" align="right">Tare</th>   
						<th width="100" >MobileNo</th>   
						<th width="200" >Email Address</th>     
                    </tr>
                    </thead> 
                    <tbody>
                    <?php  if(!empty($driverList)){
                        foreach($driverList as $key=>$record){ ?>
                    <tr>      
						<td width="5"  ><input type="checkbox" name="driver" class="checkboxes" value="<?php echo $record->LorryNo ?>" ></td>
                        <td align="right"><?php echo $record->LorryNo ?></td>
                        <td><a href="<?php echo base_url().'viewDriver/'.$record->LorryNo; ?>" ><?php echo $record->DriverName ?></a></td>
                        <td><?php echo $record->Haulier ?></td> 
						<td><?php echo $record->RegNumber ?></td>
                        <td align="right"><?php echo number_format($record->Tare,2) ?></td>
                        <td><?php echo $record->MobileNo ?></td>
						<td><?php echo $record->Email ?></td>		
                    </tr> 
                    <?php  } } ?>
                    </tbody> 
                  </table> 
              </div></div></div>
            </div> 
          </div> 
            </div>
        </div>
    </section>
</div>

<script type="text/javascript" language="javascript" >
	$(document).ready(function() {  
		
		$('.checkAll').click(function(){ 
		  if (this.checked) {
			 $(".checkboxes").prop("checked", true);
		  } else {
			 $(".checkboxes").prop("checked", false);
		  }	
		});
		$("#send").click(function(){ 
		
			var numberOfCheckboxesChecked = $('.checkboxes:checked').length; 
			var Message = $('#message').val(); 
			if(numberOfCheckboxesChecked==0 || Message==""){
				alert("One Driver Must Be Selected And Message Should not be blank. "); 
			}else{
				var dchecked = [];
				$.each($("input[name='driver']:checked"), function(){
				dchecked.push($(this).val());
				});
				var driverids = dchecked.join(",");
				var IDS=driverids, Message=Message, hitURL=baseURL + "SendDriverMessage";
				jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL,
					data : { 'IDS' : IDS, Message:Message } 
					}).success(function(data){
						//console.log(data);  
						//alert(data.status)
						//alert(data.result)
						
						$('#message').val(""); 
						$(".checkboxes").prop("checked", false);
						if(data.status == true) {   
							alert("Message has been sent successfully.");   
						}else{ 
							alert("Oooops, Please try again later"); 
						}  
						
				}); 			
			
			}
		});
		$(".checkboxes").click(function(){
		  var numberOfCheckboxes = $(".checkboxes").length;
		  var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
		  if(numberOfCheckboxes == numberOfCheckboxesChecked) {
			 $(".checkAll").prop("checked", true);
		  } else {
			 $(".checkAll").prop("checked", false);
		  }
		});
	 	
	});
</script>