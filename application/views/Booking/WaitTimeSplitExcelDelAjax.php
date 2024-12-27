<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">    
<script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script>
<script>
	$(function () {  $('select').selectpicker();  }) 	
		var isLoading = false;

	jQuery(document).on("click", ".SplitExcelDelExport", function(){  
	if (!isLoading) {

		isLoading = true; 
			var CompanyName = $('#CompanyName').val(),  
				OpportunityID = $('#OpportunityID').val(),  
				OpportunityName =  $('#OpportunityName').val(),  
				reservation1 =  $('#reservation1').val(),   
				SiteOutDateTime =  $('#SiteOutDateTime').val(),  
				TicketNumber =  $('#TicketNumber').val(),  
				MaterialName =  $('#MaterialName').val(),  
				DriverName =  $('#DriverName').val(),  
				VehicleRegNo =  $('#VehicleRegNo').val(),  
				WaitTime =  $('#WaitTime').val(),   
				Status =  $('#Status').val(),   
				Price =  $('#Price').val(),  
				PurchaseOrderNumber =  $('#PurchaseOrderNumber').val(),  
				Search =  $('input[type="search"]').val(),    
				
				hitURLSP = baseURL + "WaitTimeSplitExcelDelExport",
				currentRow = $(this);  
				 
				jQuery('#SplitExcelDelExport').prop('disabled', true); 
				
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURLSP,
				data : { 'OpportunityID' : OpportunityID, 'CompanyName' : CompanyName,'OpportunityName' : OpportunityName ,'reservation1' : reservation1 ,'SiteOutDateTime' : SiteOutDateTime ,'TicketNumber' : TicketNumber ,'MaterialName' : MaterialName ,'DriverName' : DriverName ,'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime,'Status' : Status ,'PurchaseOrderNumber' : PurchaseOrderNumber ,'Price' : Price ,'Search' : Search   } 
				}).success(function(data){ 
					jQuery('#SplitExcelDelExport').prop('disabled', false); 
					/*var $a = $("<a>");
					$a.attr("href",data.file);
					$("body").append($a);
					$a.attr("download",data.FileName);
					$a[0].click();
					$a.remove(); 
					isLoading = false;		*/
					 
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
		
		jQuery(document).on("click", ".DownloadAll", function(){  
		if (!isLoading) {

		isLoading = true; 
		var CompanyName = $('#CompanyName').val(),   
			OpportunityName =  $('#OpportunityName').val(),  
			reservation1 =  $('#reservation1').val(),   
			SiteOutDateTime =  $('#SiteOutDateTime').val(),  
			TicketNumber =  $('#TicketNumber').val(),  
			MaterialName =  $('#MaterialName').val(),  
			DriverName =  $('#DriverName').val(),  
			VehicleRegNo =  $('#VehicleRegNo').val(),  
			WaitTime =  $('#WaitTime').val(),   
			Status =  $('#Status').val(),   
			Price =  $('#Price').val(),  
			PurchaseOrderNumber =  $('#PurchaseOrderNumber').val(),  
			Search =  $('input[type="search"]').val(),  
				
			hitURLSP = baseURL + "WaitTimeSplitExcelDelExportAll",
			currentRow = $(this);   
			
			jQuery('#DownloadAll').prop('disabled', true); 
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURLSP,
			data : { 'CompanyName' : CompanyName, 'OpportunityName' : OpportunityName ,'reservation1' : reservation1 ,  'SiteOutDateTime' : SiteOutDateTime ,'TicketNumber' : TicketNumber , 'MaterialName' : MaterialName ,'DriverName' : DriverName ,'Search' : Search, 'VehicleRegNo' : VehicleRegNo ,'WaitTime' : WaitTime ,'Status' : Status ,'Price' : Price, 'PurchaseOrderNumber' : PurchaseOrderNumber   } 
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
			<button class="btn btn-primary SplitExcelDelExport " type="button" id="SplitExcelDelExport" >  Export </button>    
			<button class="btn btn-success DownloadAll " type="button" id="DownloadAll" >  Download All </button>   
	</div>   
</div>
 