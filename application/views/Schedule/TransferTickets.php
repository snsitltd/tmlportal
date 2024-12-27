<div class="content-wrapper"> 

    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Transfer Opportunity  </h1>
    </section> 
    <section class="content">   
	<?php
			$this->load->helper('form');
			$error = $this->session->flashdata('error');
			if($error){ ?>
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
		<div class="col-md-12">
			<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
		</div>
	</div>

	<div class="row">
		<form id="TransferTickets" name="TransferTickets" action="<?php echo base_url('TransferTickets'); ?>" method="post" role="form" > 
            <div class="col-xs-4">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Transfer From ( Source )</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group"> 
							<label for="CompanyID">Source Company <span class="required">*</span></label>
							<select class="form-control select_company required" id="CompanyID" name="CompanyID" required="required" data-live-search="true"   >
								<option value="">-- ADD COMPANY --</option>
								<?php foreach ($company_list as $key => $value) { ?>
								<option value="<?php echo $value['CompanyID'] ?>"><?php echo $value['CompanyName'] ?></option>
								<?php } ?>
							</select>   
							<div ></div>	  
						</div> 
						<div class="form-group">
							<label for="OpportunityID">Source Opportunity <span class="required">*</span></label> 
							<select class="form-control select_opportunity required" id="OpportunityID" name="OpportunityID" required="required" data-live-search="true"   >
								<option value="">-- ADD OPPORTUNITY --</option>                                        
							</select> <div ></div>
						</div>  
					</div>   
				</div>  
            </div>
            <!-- /.box-body -->
          </div> 
          </div>
        
            <div class="col-xs-4">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Transfer To ( Destination )</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group"> 
							<label for="CompanyID">Destination Company <span class="required">*</span></label>
							<select class="form-control required" id="CompanyID1" name="CompanyID1" required="required" data-live-search="true"   >
								<option value="">-- ADD COMPANY --</option>
								<?php foreach ($company_list as $key => $value) { ?>
								<option value="<?php echo $value['CompanyID'] ?>"><?php echo $value['CompanyName'] ?></option>
								<?php } ?>
							</select>   
							<div ></div>	  
						</div> 
						<div class="form-group">
							<label for="OpportunityID">Destination Opportunity <span class="required">*</span></label> 
							<select class="form-control select_opportunity1 required" id="OpportunityID1" name="OpportunityID1" required="required" data-live-search="true"   >
								<option value="">-- ADD OPPORTUNITY --</option>                                        
							</select> 
							<div ></div>
						</div> 
						<div class="form-group">
							<input type="hidden" name="OpportunityName1" id="OpportunityName1" >
							<input type="hidden" name="CompanyName1" id="CompanyName1" >
							<input type="submit" name="submit" style="float:right;" class="btn btn-primary" value="Update" />
						</div>   
					</div>   
				</div>  
            </div>
            <!-- /.box-body -->
          </div> 
          </div>
		  </form>
		  
        </div>  
    </section>

</div> 

<script type="text/javascript" language="javascript" >

$(document).ready(function() { 

	var TransferTickets = $("#TransferTickets"); 
	var validator = TransferTickets.validate({  
		rules:{  
			CompanyID: { required:  true } , 
			CompanyID1: { required:  true } , 
			OpportunityID: { required:  true } , 
			OpportunityID1: { required:  true } 
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "CompanyID1" || 
			 element.attr("name") == "OpportunityID" || element.attr("name") == "OpportunityID1" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} 
		
	});
	
	$("#CompanyID").on('change',function(){ 
	
		var id=$(this).val();    
		if(id!=0){  
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url: baseURL+"loadAllOpportunitiesByCompany",
			data : { id : id } 
			}).done(function(data){ 
				console.log(data);      
				if(data.status==false){	 
					var options = ' <option value="">ADD OPPORTUNITY</option>';
					$("select.select_opportunity").html(options);  

				}else{ 	  
					var options = '<option value="">ADD OPPORTUNITY</option>';
					for (var i = 0; i < data.Opportunity_list.length; i++) {
						options += '<option value="' + data.Opportunity_list[i].OpportunityID + '">' + data.Opportunity_list[i].OpportunityName + '</option>';
					} 
					$("select.select_opportunity").html(options);  
					$('#OpportunityID').selectpicker('refresh');    
				} 
			}); 
		} 
    });
	
	$("#CompanyID1").on('change',function(){  
		var id=$(this).val();    
		if(id!=0){  
			jQuery.ajax({
				type : "POST",
				dataType : "json",
				url: baseURL+"loadAllOpportunitiesByCompany",
				data : { id : id } 
				}).done(function(data){ 
					console.log(data);      
					if(data.status==false){	 
						var options = ' <option value="">ADD OPPORTUNITY</option>';
						$("select.select_opportunity").html(options);   
					}else{ 	  
						var options = '<option value="">ADD OPPORTUNITY</option>';
						for (var i = 0; i < data.Opportunity_list.length; i++) {
							options += '<option value="' + data.Opportunity_list[i].OpportunityID + '">' + data.Opportunity_list[i].OpportunityName + '</option>';
						} 
						$("select.select_opportunity1").html(options);  
						$('#OpportunityID1').selectpicker('refresh');      
						$("#CompanyName1").val($("#CompanyID1 option:selected").text());  
					} 
				}); 
		} 
    });
	
	$("#OpportunityID1").on('change',function(){   
		$("#OpportunityName1").val($("#OpportunityID1 option:selected").text());  
    });

});

</script>
    