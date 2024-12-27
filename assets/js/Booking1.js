$(document).ready(function(){ 
	$.fn.UpdateCompanyDD = function(){ 
		$.ajax({
		type : "POST",
		dataType : "json",
		url: baseURL+"/getCompanyList",
		data : ""
		}).done(function(data){ 
			//console.log(data);      
			if(data.status==false){	
				var options = ' <option value="0">-- ADD COMPANY --</option>';
				$("#CompanyID").html(options).selectpicker('refresh'); 
			}else{ 	 
				var options = '<option value="0">-- ADD COMPANY --</option>';
				for (var i = 0; i < data.company_list.length; i++) { 
					options += '<option value="' + data.company_list[i].CompanyID + '">' + data.company_list[i].CompanyName + '</option>';
				} 
				$("#CompanyID").html(options).selectpicker('refresh'); 
			} 
		}); 
	}
	 
  
///######################### AddBooking #########################################
 
	var AddBooking = $("#AddBooking"); 
	var validator = AddBooking.validate({ 
		rules:{  
			BookingType :{ required : true }, 
			CompanyName: {
				required: function(element) {
					  return $('#CompanyID').val() == 0;
				}
			} ,
			OpportunityID: { required:  true } ,
			BookingDateTime: { required:  true } ,
			Street1: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			County: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			Town: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			PostCode: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			}  	
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "BookingType[]" || element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial[]"  || element.attr("name") == "LorryType[]" 
			 || element.attr("name") == "County" || element.attr("name") == "BookingDateTime[]" || element.attr("name") == "PriceBy" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			 }  
		} 		
	});
	  /* "url": "http://193.117.210.98:5495/sdata/accounts50/GCRM/7B6447298A-F14B-48EA-9EAC-A3955968B3217D/tradingAccounts?select=reference&count=1&format=json",
			  "method": "GET",
			  'Contact-type': 'application/json',
			  "timeout": 0, 
			  "headers": {
				"Authorization": "Basic YWN0OmFjdA=="
			  }, */
			  
	 /*$("#CompanyID").on('change',function(){ 
	   event.preventDefault(); 
		/// For SAge TEST   
		var USERNAME = 'act';
		var PASSWORD = 'act';
		
			jQuery.ajax({
				type : "POST",
				dataType : "jsonp", 
				contentType: 'application/json; charset=utf-8',  		
				url: "http://193.117.210.98:5495/sdata/accounts50/GCRM/%7B6447298A-F14B-48EA-9EAC-A3955968B321%7D/tradingAccounts?select=reference&count=1&format=json", 
				headers: {
					"Authorization": "Basic YWN0OmFjdA==" 
				}  
			}).done(function(data){ 
				alert(data);
				console.log(data);               
				  
			});  
		
    });  */

	
    $("#CompanyID").on('change',function(){ 
		event.preventDefault();

		var id=$(this).val();    
		if(id!=0){  
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url: baseURL+"/LoadOppoByCompany",
			data : { id : id } 
			}).done(function(data){ 
				console.log(data);               
				if(data.status==false){	
					var options = ' <option value="0">ADD OPPORTUNITY</option>';
					$("select.select_opportunity").html(options); 
				}else{ 	 
					var options = '<option value="0">ADD OPPORTUNITY</option>';
					for (var i = 0; i < data.Opportunity_list.length; i++) {
						options += '<option value="' + data.Opportunity_list[i].OpportunityID + '">' + data.Opportunity_list[i].OpportunityName + '</option>';
					} 
					$("select.select_opportunity").html(options);  
					$('#OpportunityID').selectpicker('refresh');    
					//alert(data.SagePaymentType); 
				 
					if(data.SagePaymentType=='Card Only'){
						$('#PType').html('Cash/Card');      
					}else if(data.SagePaymentType=='Credit'){ 
						$('#PType').html('Credit');  
					}else{ $('#PType').html('N/A'); }
					
				 
					/*if(data.CompanyInfo[0].PaymentType==1){
						$('#PType').html('Credit');  
					}else if(data.CompanyInfo[0].PaymentType==2){ 
						$('#PType').html('Cash/Card');     
					}else{ $('#PType').html('N/A'); } */
					  
					$('#CompName').val(data.CompanyInfo[0].CompanyName);   
					//$("input[name=PaymentType][value="+data.CompanyInfo[0].PaymentType+"]").attr('checked', 'checked'); 
					
					if(data.SagePaymentType=='Card Only'){
						$("div.Payment").show();	  
					}else{
						$("div.Payment").hide();
					}
					
					/*if(data.CompanyInfo[0].PaymentType==1){
						$("div.Payment").hide();
					}else{
						$("div.Payment").show();	 
					}*/	
					//$('#CreditLimit').html(data.CompanyInfo[0].CreditLimit);  
					//$('#Outstanding').html(data.CompanyInfo[0].Outstanding);  
					$('#CreditLimit').html(data.SageCreditLimit);  
					$('#Outstanding').html(data.SageOutstanding);  
					
					$('#CompanyName').attr('readonly', true);	
					$('#CompanyName').val(''); 
				} 
					
			}); 
		}else if(id==0) { 
		
			$('#CompanyName').attr('readonly', false);	
			$('#CompanyName').val('');
			$('#Street1').attr('readonly', false);	
			$('#Street1').val(''); 
			$('#Street2').attr('readonly', false);	
			$('#Street2').val(''); 
			$('#Town').attr('readonly', false);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', false);	
			$('#PostCode').val('');
			$('#County').attr('readonly', false); 			

			$('#PType').html("");  
			$('#CompName').val("");  
			$('#PaymentType').val("");  
			$('#CreditLimit').html("");  
			$('#Outstanding').html("");  
			
		}else if(id=='') { 
			$('#CompanyName').attr('readonly', false);	
			$('#CompanyName').val('');
			$('#Street1').attr('readonly', false);	
			$('#Street1').val(''); 
			$('#Street2').attr('readonly', false);	
			$('#Street2').val(''); 
			$('#Town').attr('readonly', false);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', false);	
			$('#PostCode').val('');
			$('#County').attr('readonly', false); 			
			
			$('#PType').html("");  
			$('#CompName').val("");  
			$('#PaymentType').val("");  
			$('#CreditLimit').html("");  
			$('#Outstanding').html("");  
		}
		
    }); 
	
   $("#OpportunityID").on('change',function(){
		var address = $("#OpportunityID option:selected").text();
		 
		var id=$(this).val();    
		if(id!=0){  
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url: baseURL+"/LoadOpportunityContacts",
			data : { id : id } 
			}).done(function(data){   
				//alert(data.status)	
				//alert(JSON.stringify( data ));    
				
				if(data.status==false){	 
					var options = ' <option value="0">ADD CONTACT</option>';
					$("select.select_contact").html(options);  
				//	$('#PurchaseOrderNumber').val(''); 
				}else{  
					
					
					$('#OppoName').val(data.OppDetails[0].OpportunityName);
					$('#Street1').val(data.OppDetails[0].Street1);  
					$('#Street2').val(data.OppDetails[0].Street2);  
					$('#Town').val(data.OppDetails[0].Town);  
					$('#PostCode').val(data.OppDetails[0].PostCode);  
					$('select[name=County]').val(data.OppDetails[0].County);
					$('#County').selectpicker('refresh')
					
					if(data.contact_list.length>0){	
						var options = ''; 
					}else{ 
						var options = '<option value="0">ADD CONTACT</option>';  
					}
					var ContactID = ''; 
					for (var i = 0; i < data.contact_list.length; i++) {  
						if(i == 0){ ContactID = data.contact_list[i].ContactID;
							ContactName = data.contact_list[i].ContactName;
							MobileNumber = data.contact_list[i].MobileNumber;						
							ContactEmail = data.contact_list[i].ContactEmail;						 
						}else{ ContactID = ''; } 
						options += '<option value="' + data.contact_list[i].ContactID + '"  >' + data.contact_list[i].ContactName + '</option>';
					}  
					
					$("select.select_contact").html(options);  
					$('#ContactID').selectpicker('refresh');    
					 
					if(data.contact_list.length>0){   
						$('select[name=ContactID]').val(ContactID); 
						$('#ContactName').val(ContactName);  
						$('#ContactMobile').val(MobileNumber);  
						$('#ContactEmail').val(ContactEmail);  
					}else{  
						$('select[name=ContactID]').val('0'); 
						$('#ContactName').attr('readonly', false);	 
						$('#ContactName').val('');   
						$('#ContactMobile').val('');  
						$('#ContactEmail').val('');   
					}
					 
					$('#ContactID').selectpicker('refresh');   
					//if(data.OppPO.length>0){
						//$('#PurchaseOrderNumber').val(data.OppPO[0].PurchaseOrderNumber);
				//	}else{
					//	$('#PurchaseOrderNumber').val('');
					//}
					$('select[name=PriceBy]').val(data.OppPriceBy[0].PriceBy); 
					$('#PriceBy').selectpicker('refresh');  
				} 
				$('.BookingDateTime').click();
			}); 
			
			$('#Street1').attr('readonly', true);	 
			$('#Street2').attr('readonly', true);	 
			$('#Town').attr('readonly', true);	 
			$('#PostCode').attr('readonly', true);	 
			$('#County').attr('readonly', true);  
		}else if(id==0) {  
		//	$('#PurchaseOrderNumber').val(''); 			
			var options = ' <option value="0">ADD CONTACT</option>';
			$("select.select_contact").html(options); 
			$('#OppoName').val('');
			$('#Street1').attr('readonly', false);	
			$('#Street1').val(''); 
			$('#Street2').attr('readonly', false);	
			$('#Street2').val(''); 
			$('#Town').attr('readonly', false);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', false);	
			$('#PostCode').val('');
			$('#County').attr('readonly', false); 	
			$('#ContactID').selectpicker('refresh');   
			$('#ContactName').attr('readonly', false);	 
			$('#ContactName').val(''); 
			
		}   
		$('.BookingDateTime').click();
		
   });
	$("#ContactID").on('change',function(){ 
		 
		var id=$(this).val();    
		if(id==0){    
			$('#ContactName').attr('readonly', false);	
			$('#ContactMobile').attr('readonly', false);	
			$('#Email').attr('readonly', false);	
			//$('#ContactName').val('');  
			//$('#Email').val('');  
			//$('#ContactMobile').val('');  
		}else{   
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url: baseURL+"/DisplayContactDetails",
			data : { id : id } 
			}).done(function(data){ 
				if(data.status == false){	  		
				}else{  
					jQuery('#ContactName').val(data.contact[0].ContactName);	
					jQuery('#ContactMobile').val(data.contact[0].MobileNumber);	
					jQuery('#Email').val(data.contact[0].EmailAddress);	  
				} 
			}); 
		 
			//$('#ContactName').val('');  
			//$('#ContactMobile').val('');  
			//$('#Email').val('');  
		} 
		
   });
    
	
});
 
	
function UpdateCompanyDD1(){  	  
	jQuery.ajax({
	type : "POST",
	dataType : "json",
	url: baseURL+"/getCompanyList",
	data : ""
	}).done(function(data){ 
		//console.log(data);     
		
		if(data.status==false){	
			var options = ' <option value="0">-- ADD COMPANY dd--</option>';
			jQuery("select.select_company").html(options); 
		}else{ 	 
			var options = '<option value="0">ADD COMPANY dd </option>';
			for (var i = 0; i < 3; i++) {
				alert(data.company_list[i].CompanyName);
				options += '<option value="' + data.company_list[i].CompanyID + '">' + data.company_list[i].CompanyName + '</option>';
			} 
			jQuery("select.select_company").html(options);   
		} 
	});  
} 