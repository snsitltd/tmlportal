<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">    
<script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script>
<script> 
	$(function () {  $('select').selectpicker();  }) 	
	var isLoading = false;
	jQuery(document).on("click", ".WaitTimeSplitExcelExport", function(){  
		if (!isLoading) { 
			isLoading = true; 	
			var CompanyName = $('#CompanyName').val(),  
			OpportunityID = $('#OpportunityID').val(),  
			OpportunityName =  $('#OpportunityName').val(),  
			reservation =  $('#reservation').val(),  
			TipName =  $('#TipName').val(),  
			SiteOutDateTime =  $('#SiteOutDateTime').val(),  
			ConveyanceNo =  $('#ConveyanceNo').val(),  
			MaterialName =  $('#MaterialName').val(),  
			DriverName =  $('#DriverName').val(),  
			Price =  $('#Price').val(),  
			Search =  $('input[type="search"]').val(),    
			VehicleRegNo =  $('#VehicleRegNo').val(),  
			WaitTime =  $('#WaitTime').val(),    
			Status =  $('#Status').val(),    
			hitURLSP = baseURL + "WaitTimeSplitExcelExport",
			currentRow = $(this);  
			 
			jQuery('#SplitExcelExport').prop('disabled', true); 
			
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURLSP,
			data : { 'Search' : Search, 'OpportunityID' : OpportunityID, 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation' : reservation ,'TipName' : TipName ,'SiteOutDateTime' : SiteOutDateTime ,'ConveyanceNo' : ConveyanceNo ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime ,'Status' : Status ,'Price' : Price  } 
			}).success(function(data){ 
				jQuery('#SplitExcelExport').prop('disabled', false); 
				/*var $a = $("<a>");
				$a.attr("href",data.file);
				$("body").append($a);
				$a.attr("download",data.FileName);
				$a[0].click();
				$a.remove();   
				isLoading = false;*/
				
			//alert(data.FileName)
				//jQuery('#DownloadAll').prop('disabled', false);
				var $a = $("<a>");
				$a.attr("href",data.FileName);
				//$a.attr("href",data.file);
				$("body").append($a);
				$a.attr("download",data.FileName);
				$a[0].click();
				$a.remove();
				isLoading = false;	
				
			});  
		}			
	});
	
	jQuery(document).on("click", ".WaitTimeDownloadAll", function(){  
		if (!isLoading) { 
			isLoading = true; 	    
			var CompanyName = $('#CompanyName').val(),   
				OpportunityName =  $('#OpportunityName').val(),  
				reservation =  $('#reservation').val(),  
				TipName =  $('#TipName').val(),  
				SiteOutDateTime =  $('#SiteOutDateTime').val(),  
				ConveyanceNo =  $('#ConveyanceNo').val(),  
				MaterialName =  $('#MaterialName').val(),  
				DriverName =  $('#DriverName').val(),  
				Price =  $('#Price').val(),  
				Search =  $('input[type="search"]').val(),    
				VehicleRegNo =  $('#VehicleRegNo').val(),  
				WaitTime =  $('#WaitTime').val(),    
				Status =  $('#Status').val(),    
				hitURLSP = baseURL + "WaitTimeSplitExcelExportAll",
				currentRow = $(this);  
				 
				jQuery('#DownloadAll').prop('disabled', true); 
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURLSP,
				data : { 'Search' : Search, 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation' : reservation ,'TipName' : TipName ,'SiteOutDateTime' : SiteOutDateTime ,'ConveyanceNo' : ConveyanceNo ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime ,'Status' : Status ,'Price' : Price   } 
				}).success(function(data){ 
					//alert(data.FileName)
					jQuery('#DownloadAll').prop('disabled', false);
					var $a = $("<a>");
					$a.attr("href",data.FileName);
					//$a.attr("href",data.file);
					$("body").append($a);
					$a.attr("download",data.FileName);
					$a[0].click();
					$a.remove();
					isLoading = false;					
				});  	 
		}		
	});
</script>
<!-- <form id="SplitExcel" name="SplitExcel" action="<?php //echo base_url('SplitExcelConv11111'); ?>" method="post" role="form" >     -->

<?php //var_dump($CompanyOppoRecords); ?>
<div class="row">  
	<div class="col-md-12"> 
		<div>
			<select class="form-control " name="OpportunityID" id="OpportunityID"  required data-size="10"  data-live-search="true" >  
				 
				<?php if(!empty($CompanyOppoRecords)){ foreach ($CompanyOppoRecords as $rl){  ?>
						<option value="<?php echo $rl->OpportunityID ?>" ><b><?php echo $rl->CompanyName; ?>  </b>| <?php echo $rl->OpportunityName; ?></option>
				<?php }} ?>
			</select>
		</div> 
	</div>
	<br><br>
	  
	<div class="col-md-12"> 
		<button class="btn btn-primary WaitTimeSplitExcelExport " type="button" id="WaitTimeSplitExcelExport" >  Export </button>   
		<button class="btn btn-success WaitTimeDownloadAll " type="button" id="WaitTimeDownloadAll" >  Download All </button>   
	</div>   
</div>

<!--</form> -->
 