/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */
//EmailID : { required : true, email : true },
//PostCode :{ required : true },					
//			Phone1 : { required : true, digits : true },
//			Phone2 : { digits : true },
//			Fax :{ required : true },
//			Website :{ url : true },
//EmailID : { required : "This field is required", email : "Please enter valid email address" },
//			PostCode :{ required : "This field is required" },			
//			Phone1 : { required : "This field is required", digits : "Please enter numbers only" },	
			//Phone2 : { digits : "Please enter numbers only" },	
			//Fax :{ required : "This field is required" },
			//Website :{ required : "Please enter valid url" },
			
$(document).ready(function(){
	
	var addsupport = $("#addsupport");
	
	var validator = addsupport.validate({
		
		rules:{
			icategory :{ required : true }, 
			ipriority :{ required : true },
			vtitle :{ required : true },
			ltdesc :{ required : true } 
		},
		messages:{
			icategory :{ required : "This field is required" }, 
			ipriority :{ required : "This field is required" },
			vtitle :{ required : "This field is required" },
			ltdesc :{ required : "This field is required" } 
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "icategory" || element.attr("name") == "ipriority" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		}
	});
	
	var addsupport1 = $("#addsupport1"); 
	var validator1 = addsupport1.validate({
		
		rules:{ 
			ltdesc :{ required : true } 
		},
		messages:{ 
			ltdesc :{ required : "This field is required" } 
		} 
	});
	 

	jQuery(document).on("click", ".deleteSupport", function(){
		alert("sadfasdf");
		var SupportID = $(this).attr("data-SupportID"),
			hitURL = baseURL + "deleteSupport",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this record ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { SupportID : SupportID } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Record successfully deleted"); }
				else if(data.status = false) { alert("Record deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});

	jQuery(document).on("click", ".company_status_deactive", function(){
		var table = $(this).attr("data-table-name"),
		    CompanyID = $(this).attr("data-id"),
			hitURL = baseURL + "companyChangeStatus";
			currentRow = $(this);	
					
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { table : table,CompanyID : CompanyID , Status : 0 } 
			}).done(function(data){
				console.log(data);				
				if(data.status = true) { currentRow.removeClass('company_status_deactive label-success').addClass('company_status_active label-danger'); currentRow.text('Deactive'); }				
			});
		
	});

	jQuery(document).on("click", ".company_status_active", function(){
		var table = $(this).attr("data-table-name"),
		    CompanyID = $(this).attr("data-id"),
			hitURL = baseURL + "companyChangeStatus";
			currentRow = $(this);	
					
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { table : table, CompanyID : CompanyID , Status : 1 } 
			}).done(function(data){
				console.log(data);				
				if(data.status = true) { currentRow.removeClass('company_status_active label-danger').addClass('company_status_deactive label-success'); currentRow.text('Active'); }				
			});
		
	}); 

	
	
});
