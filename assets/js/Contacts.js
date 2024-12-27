/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */
//Title :{ required : true },
//PhoneExtension : { digits : true },
//Position :{ required : true },			
//Department :{ required : true },
//Title :{ required : "This field is required" },
//PhoneExtension : { digits : "Please enter numbers only" },
//Position :{ required : "This field is required" },			
//Department :{ required : "This field is required" },			
$(document).ready(function(){
	
	var contactsubmit = $("#contactsubmit");
	
	var validator = contactsubmit.validate({

		ignore: [],	
		 validateNonVisibleFields: true,
            updatePromptsPosition:true,	
		rules:{
			
			ContactName :{ required : true },
			//EmailAddress : { required : true, email : true },
			//PostCode :{ required : true },								
			//PhoneNumber : { required : true, digits : true }, 
			MobileNumber : { digits : true }, 
			//CompanyName :{ required : true },
			//EmailID : { required : true, email : true },
			//Street1 :{ required : true },
			//Street2 :{ required : true },
			//Town :{ required : true },
			//County :{ required : true },
			//PostCode :{ required : true },					
			//Phone1 : { required : true, digits : true },
			//Phone2 : { digits : true },
			//Fax :{ required : true },
			//Website :{ url : true },
			//Country :{ required : true },		
			
		},
		messages:{
			
			ContactName :{ required : "This field is required" },
			//EmailAddress : { required : "This field is required", email : "Please enter valid email address" },			
			//PostCode :{ required : "This field is required" },			
			//PhoneNumber : { required : "This field is required", digits : "Please enter numbers only" },	
			
			MobileNumber : { digits : "Please enter numbers only" },	
			
			//CompanyName :{ required : "This field is required" },
			//EmailID : { required : "This field is required", email : "Please enter valid email address" },
			//Street1 :{ required : "This field is required" },
			//Street2 :{ required : "This field is required" },
			//Town :{ required : "This field is required" },
			//County :{ required : "This field is required" },
			//PostCode :{ required : "This field is required" },			
			//Phone1 : { required : "This field is required", digits : "Please enter numbers only" },	
			//Phone2 : { digits : "Please enter numbers only" },	
			//Fax :{ required : "This field is required" },
			//Website :{ required : "Please enter valid url" },
			//Country :{ required : "This field is required" },		
			
		}
	});

	$('.select_company').on('change', function() {

  
  var company_id = this.value;
  hitURL = baseURL + "getCompanyDetails",

  jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { company_id : company_id } 
			}).done(function(data){
				console.log(data);               
				if(data.status==false){	
				
				

				$('.CompanyName').val('');
				$('.EmailID').val('');
				$('.Street1').val('');
				$('.Street2').val('');
				$('.Town').val('');
				$('.PostCode').val('');
				$('.Phone1').val('');
				$('.Phone2').val('');
				$('.Fax').val('');
				$('.Website').val('');
				$(".County").val($(".County option:first").val());
				$(".Country").val($(".Country option:first").val());	
				
				}else{ 				
				$('.CompanyName').val(data.CompanyName);
				$('.EmailID').val(data.EmailID);
				$('.Street1').val(data.Street1);
				$('.Street2').val(data.Street2);
				$('.Town').val(data.Town);
				$('.PostCode').val(data.PostCode);
				$('.Phone1').val(data.Phone1);
				$('.Phone2').val(data.Phone2);
				$('.Fax').val(data.Fax);
				$('.Website').val(data.Website);
				$('.County option[value="'+data.County+'"]').attr('selected','selected');	
				$('.Country option[value="'+data.CountryCode+'"]').attr('selected','selected');	

			}
				
			});


});





});
