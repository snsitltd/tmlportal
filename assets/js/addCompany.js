/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */

$(document).ready(function(){
	
	var addCompanyForm = $("#addnewcompanysubmit");
	
	var validator = addCompanyForm.validate({
		
		rules:{
			CompanyName :{ required : true },
			EmailID : { required : true, email : true },
			Street1 :{ required : true },
			Street2 :{ required : true },
			Town :{ required : true },
			County :{ required : true },
			PostCode :{ required : true },					
			Phone1 : { required : true, digits : true },
			Phone2 : { digits : true },
			Fax :{ required : true },
			Website :{ url : true },
			Country :{ required : true },		
			
		},
		messages:{
			CompanyName :{ required : "This field is required" },
			EmailID : { required : "This field is required", email : "Please enter valid email address" },
			Street1 :{ required : "This field is required" },
			Street2 :{ required : "This field is required" },
			Town :{ required : "This field is required" },
			County :{ required : "This field is required" },
			PostCode :{ required : "This field is required" },			
			Phone1 : { required : "This field is required", digits : "Please enter numbers only" },	
			Phone2 : { digits : "Please enter numbers only" },	
			Fax :{ required : "This field is required" },
			Website :{ required : "Please enter valid url" },
			Country :{ required : "This field is required" },		
			
		}
	});
});
