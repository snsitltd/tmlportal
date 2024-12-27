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
			 if(element.attr("name") == "BookingType" || element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "County" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			 }  
		} 		
	});
	  
	 
	
///###############################################################################
  /*
    var DescriptionofMaterial = $("#DescriptionofMaterial");
    DescriptionofMaterial.on('change',function(){
    var id=$(this).val();
    if(id!=''){
	       $.ajax({
		       url: baseURL+"/getMaterialListDetails",
		       type: "POST",
		       data:  {id:id},
		       
			   success: function(data)
			     { //alert(data);
			     	var obj = jQuery.parseJSON(data);
                    $('#SicCode').val( obj.SicCode );
                    $('#MaterialPrice').val( obj.price );
                    
			     	//$('#SicCode').val(data);
			    },
			     error: function(e) 
			      {
			        $("#err").html(e).fadeIn();
			      }          
		    });
        }else{
        	$('#SicCode').val('');
        	$('#MaterialPrice').val('');
        }
    });
    */  
    $("#BookingType").on('change',function(){  
		var id=$(this).val();     
		if(id!=''){    
			if(id=="1"){ $( "#hide2" ).show();  }else{ $( "#hide2" ).hide();  }		 
			jQuery.ajax({
				type : "POST",
				dataType : "json",
				url: baseURL+"/LoadBookingMaterials",
				data : { id : id } 
				}).done(function(data){  
					//alert(JSON.stringify( data ));    
					//console.log(data);               
					if(data.status==false){	  
						var options = ' <option value="">Select Material Type</option>';
						$("select.select_material").html(options);  
					}else{ 	  
						var options = '<option value="">Select Material Type</option>';
						for (var i = 0; i < data.material_list.length; i++) {
							options += '<option value="' + data.material_list[i].MaterialID + '">' + data.material_list[i].MaterialName + '</option>';
						} 
						$("select.select_material").html(options);  
						$('#DescriptionofMaterial').selectpicker('refresh');   
					} 
			}); 
		}
    }); 
	/*
    $("#LoadType").on('change',function(){  
		var id=$(this).val();   
		if(id=='1'){    
			var options = ''; 
				options += '<option value="1">NA</option>';			 
			$("select.select_loads").html(options);  
			$('#Days').selectpicker('refresh');   
			$("#d2").hide(); $("#d3").hide(); $("#d4").hide(); $("#d5").hide(); $("#d6").hide();  
		}else if(id=='2') {   
				var options = '';
				options = '<option value="1">Turn Around </option>';
				options += '<option value="2">Turn Around + 1 Day </option>';
				options += '<option value="3">Turn Around + 2 Days </option>';
				options += '<option value="4">Turn Around + 3 Days </option>';
				options += '<option value="5">Turn Around + 4 Days </option>';
				options += '<option value="6">Turn Around + 5 Days </option>'; 
			$("select.select_loads").html(options);  
			$('#Days').selectpicker('refresh');  
			
		}
    }); 
	*/
	
    $("#CompanyID").on('change',function(){ 
	
		var id=$(this).val();    
		if(id!=0){  
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url: baseURL+"/loadAllOpportunitiesByCompany",
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
					$('#CompanyName').attr('readonly', true);	
					$('#CompanyName').val(''); 
				} 
			}); 
		}else if(id==0) { 
			$('#CompanyName').attr('readonly', false);	
			$('#CompanyName').val('');
			$('#Street1').attr('readonly', false);	
			$('#Street1').val(''); 
			$('#Town').attr('readonly', false);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', false);	
			$('#PostCode').val('');
			$('#County').attr('readonly', false); 			
		}else if(id=='') { 
			$('#CompanyName').attr('readonly', false);	
			$('#CompanyName').val('');
			$('#Street1').attr('readonly', false);	
			$('#Street1').val(''); 
			$('#Town').attr('readonly', false);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', false);	
			$('#PostCode').val('');
			$('#County').attr('readonly', false); 			
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
			
				//alert(JSON.stringify( data ));   
				   
				if(data.status==false){	
					var options = ' <option value="0">ADD CONTACT</option>';
					$("select.select_contact").html(options); 
				}else{ 	 
					var options = '<option value="0">ADD CONTACT</option>';
					for (var i = 0; i < data.contact_list.length; i++) {
						options += '<option value="' + data.contact_list[i].ContactID + '">' + data.contact_list[i].ContactName + '</option>';
					}  
					$('#Street1').val(data.OppDetails[0].Street1);  
					$('#Town').val(data.OppDetails[0].Town);  
					$('#PostCode').val(data.OppDetails[0].PostCode);  
					$('select[name=County]').val(data.OppDetails[0].County);
					$('#County').selectpicker('refresh')
 
					$("select.select_contact").html(options);  
					$('#ContactID').selectpicker('refresh');   
					$('#ContactName').attr('readonly', false);	 
					$('#ContactName').val('');  
				} 
			}); 
			
			$('#Street1').attr('readonly', true);	 
			$('#Town').attr('readonly', true);	
			//$('#Town').val('');
			$('#PostCode').attr('readonly', true);	
			//$('#PostCode').val('');
			$('#County').attr('readonly', true);  
		}else if(id==0) {  
			var options = ' <option value="0">ADD CONTACT</option>';
			$("select.select_contact").html(options); 
			$('#Street1').attr('readonly', false);	
			$('#Street1').val(''); 
			$('#Town').attr('readonly', false);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', false);	
			$('#PostCode').val('');
			$('#County').attr('readonly', false); 	
			$('#ContactID').selectpicker('refresh');   
			$('#ContactName').attr('readonly', false);	 
			$('#ContactName').val('');  			
		}   
		$('#BookingDateTime').click();
		
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