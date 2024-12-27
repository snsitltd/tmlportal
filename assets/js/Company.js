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
	
	var addCompanyForm = $("#addnewcompanysubmit");
	
	var validator = addCompanyForm.validate({
		
		rules:{
			CompanyName :{ required : true },
			
			Street1 :{ required : true },
			//Street2 :{ required : true },
			Town :{ required : true },
			County :{ required : true },
			
			Country :{ required : true },		
			
		},
		messages:{
			CompanyName :{ required : "This field is required" },
			
			Street1 :{ required : "This field is required" },
			//Street2 :{ required : "This field is required" },
			Town :{ required : "This field is required" },
			County :{ required : "This field is required" },
			Country :{ required : "This field is required" },		
			
		}
	});

/*
	jQuery(document).on("click", ".deleteCompany", function(){
		var CompanyID = $(this).attr("data-CompanyID"),
			hitURL = baseURL + "deleteCompany",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this record ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { CompanyID : CompanyID } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Record successfully deleted"); }
				else if(data.status = false) { alert("Record deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
*/

	jQuery(document).on("click", ".company_status_deactive", function(){
		var table = $(this).attr("data-table-name"),
		    CompanyID = $(this).attr("data-id"),
			hitURL = baseURL + "companyChangeStatus";
			currentRow = $(this);	
			var confirmation = confirm("Are you sure you want to deactivate ?"); 
			if(confirmation){			
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { table : table,CompanyID : CompanyID , Status : 0 } 
			}).done(function(data){
				console.log(data);				
				if(data.status = true) { currentRow.removeClass('company_status_deactive label-success').addClass('company_status_active label-danger'); currentRow.text('InActive'); }
				
			});
			}
		
	});

	jQuery(document).on("click", ".company_status_active", function(){
		var table = $(this).attr("data-table-name"),
		    CompanyID = $(this).attr("data-id"),
			hitURL = baseURL + "companyChangeStatus";
			currentRow = $(this);	
			var confirmation = confirm("Are you sure you want to Activate ?"); 
			if(confirmation){			
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { table : table, CompanyID : CompanyID , Status : 1 } 
				}).done(function(data){
					console.log(data);				
					if(data.status = true) { currentRow.removeClass('company_status_active label-danger').addClass('company_status_deactive label-success'); currentRow.text('Active'); }				
				});
			}
	});




$("#addnewcompanynote").on('submit',(function(e) {

	if($('#Regarding').val()==''){alert('Please enter value in text fileds');return false;}

	 e.preventDefault();

	var data = new FormData(document.getElementById("addnewcompanynote"));

 
       $.ajax({
       url: baseURL+"/addnewcompanynoteajax",
       type: "POST",
       data:  data,
       contentType: false,
       cache: false,
	   processData:false,
	   async: false,
	   beforeSend : function()
	   {
	      $("#err").fadeOut();
	   },
	   success: function(data)
	      {
	    if(data=='invalid')
	    {
	     // invalid file format.
	     $("#err").html("Invalid File !").fadeIn();
	    }
	    else
	    {
	     // view uploaded file.
	     
	     $( ".add-notes-fun" ).append( data );
	     $("#addnewcompanynote")[0].reset(); 
	    }
	      },
	     error: function(e) 
	      {
	        $("#err").html(e).fadeIn();
	      }          
    });

 }));


jQuery(document).on("click", ".remove-note-button", function(){
		var NotesID = $(this).attr('id'),
			hitURL = baseURL + "deleteCompanyNotes",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this Note ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { NotesID : NotesID } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('.box-solid').remove();
				
			});
		}
	});


jQuery(document).on("click", ".add-doc-fields-btn", function(){
		
		$( ".add-fields-fun" ).append( '<div class="row add-new-fields-fun"> <div class="col-md-4"> <div class="form-group"> <label for="DocumentAttachment">Select Document</label> <input type="file" class="form-control" id="DocumentAttachment" name="DocumentAttachment[]"> </div> </div>  <div class="col-md-4"> <div class="form-group"> <label for="DocumentDetail">Details</label> <input type="text" class="form-control" id="DocumentDetail" name="DocumentDetail[]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <br> <button class="btn btn-danger remove-doc-fields-btn" type="button"> - Remove </button> </div> </div> </div> ' );
		
	});


jQuery(document).on("click", ".remove-doc-fields-btn", function(){
	
		
		$(this).parents('.add-new-fields-fun').remove();
		
	});



jQuery(document).on("click", ".remove-uploaded-doc", function(){

	    var DocumentID = $(this).attr('id'),
			hitURL = baseURL + "deleteCompanyDocuments",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this documents ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { DocumentID : DocumentID } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('.add-new-fields-fun').remove();
				
			});
		}

	
		
		
		
	});

	
	
});
