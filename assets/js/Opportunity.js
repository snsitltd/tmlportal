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
	
	$('#datepicker3').datetimepicker({format: 'DD/MM/YYYY', }); 
	
	var contactsubmit = $("#Opportunitysubmit");
	var validator = contactsubmit.validate({

		ignore: [],	
		 validateNonVisibleFields: true,
            updatePromptsPosition:true,	
		rules:{  
			CompanyID :{ required : true },
			OpportunityName :{ required : true },
			Street1 :{ required : true }, 
			Town :{ required : true },
			County :{ required : true },			
			PostCode :{ required : true },	 				
			
		},
		messages:{
		 
			CompanyID :{ required : "This field is required" },
			OpportunityName :{ required : "This field is required" },
			Street1 :{ required : "This field is required" }, 
			Town : { required : "This field is required"},
			County : { required : "This field is required" },
			PostCode :{ required : "This field is required" },	 							
			
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "County" || element.attr("name") == "CompanyID") {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} 
	});

	//Qty :{ required : true },
	//PurchaseOrderNo :{ required : true },
	//JobNo :{ required : true } ,
	//Qty :{ required : "This field is required" },
	//PurchaseOrderNo : { required : "This field is required"},
	//JobNo : { digits : "Please enter numbers only" },							
			
	var productSubmit = $("#productSubmit");
	var validator = productSubmit.validate({

		ignore: [],	
		 validateNonVisibleFields: true,
            updatePromptsPosition:true,	
		rules:{
			ProductCode :{ required : true },
			Description :{ required : true },
			DateRequired :{ required : true },
			UnitPrice : { required : true } 
		},
		messages:{
			ProductCode :{ required : "This field is required" },
			Description :{ required : "This field is required" },
			DateRequired :{ required : "This field is required" },
			UnitPrice : { required : "This field is required"}	
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
				
					//$('.Street1').val('');
					//$('.Street2').val('');
					//$('.Town').val('');
					//$('.PostCode').val('');				
					//$(".County").val($(".County option:first").val());
					//$('.OpportunityName').val(""); 			
					
					}else{ 				
					
					//$('.Street1').val(data.Street1);
					//$('.Street2').val(data.Street2);
					//$('.Town').val(data.Town);
					//$('.County option[value="'+data.County+'"]').attr('selected','selected');
					//$('.PostCode').val(data.PostCode);
					

					//var name = "";
					//var Street1 = data.Street1;
					//var Street2 = data.Street2;
					//var Town = data.Town;
					//var County = data.County;
					//var PostCode = data.PostCode;
					//if(Street1!='') name += Street1+', ';
					//if(Street2!='') name += Street2+', ';
					//if(Town!='') name += Town+', ';
					//if(County!='') name += County+', ';
					//if(PostCode!='') name += PostCode;
					//$('.OpportunityName').val(name);  
						//alert(data.contact_list.length);	

						var options = ' <option value="">Select Contact</option>';
						for (var i = 0; i < data.contact_list.length; i++) {
							options += '<option value="' + data.contact_list[i].ContactID + '">' + data.contact_list[i].ContactName + '</option>';
						}
							$("select.select_contact").html(options);
							$('#ContactID').selectpicker('refresh');  
							//$('#County').selectpicker('refresh');  
				} 
			});


});

/*
	jQuery(document).on("click", ".deleteOpportunity", function(){
		
		var OpportunityID = $(this).attr("data-OpportunityID"),
			hitURL = baseURL + "deleteOpportunity",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this record ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { OpportunityID : OpportunityID } 
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


	$("#addnewopportunitynote").on('submit',(function(e) { 
		if($('#Regarding').val()==''){alert('Please enter value in text fileds');return false;} 
		e.preventDefault();

	var data = new FormData(document.getElementById("addnewopportunitynote"));
	
       $.ajax({
       url: baseURL+"/addnewopportunitynoteajax",
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
	    if(data=='invalid'){
	     // invalid file format.
	     $("#err").html("Invalid File !").fadeIn();
	    }else{
	     // view uploaded file.
	     
	     $( ".add-notes-fun" ).append( data );
	     $("#addnewopportunitynote")[0].reset(); 
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
			hitURL = baseURL + "deleteopportunityNotes",
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
			$( ".add-fields-fun" ).append( '<div class="row add-new-fields-fun"> <div class="col-md-3"> <div class="form-group"> <label for="DocumentAttachment">Select Document</label> <input type="file" class="form-control" id="DocumentAttachment" name="DocumentAttachment[]"  multiple> </div></div><div class="col-md-2"> <div class="form-group"> <label for="DocumentType">Document Type</label> <select class="form-control required County" id="DocumentType" name="DocumentType[]" aria-required="true"> <option value="">Select Document Type</option><option value="1">WIF Form</option> <option value="2">Purchase Order</option> <option value="3">Quote</option> <option value="4">Others</option> </select> </div></div><div class="col-md-2"><div class="form-group"><label for="DocumentDetail">Number</label><input type="text" class="form-control" id="DocumentNumber" name="DocumentNumber[]"></div> </div> <div class="col-md-2"> <div class="form-group"> <label for="DocumentDetail">Details</label> <input type="text" class="form-control" id="DocumentDetail" name="DocumentDetail[]"> </div></div><div class="col-md-2"> <div class="form-group"> <br><button class="btn btn-danger remove-doc-fields-btn" type="button"> - Remove </button> </div></div></div>' );

			//$( ".add-fields-fun" ).append( '<div class="row add-new-fields-fun"> <div class="col-md-4"> <div class="form-group"> <label for="DocumentAttachment">Select Document</label> <input type="file" class="form-control" id="DocumentAttachment" name="DocumentAttachment[]"> </div> </div>  <div class="col-md-4"> <div class="form-group"> <label for="DocumentDetail">Details</label> <input type="text" class="form-control" id="DocumentDetail" name="DocumentDetail[]"> </div> </div> <div class="col-md-4"> <div class="form-group"> <br> <button class="btn btn-danger remove-doc-fields-btn" type="button"> - Remove </button> </div> </div> </div> ' );
			
	});


	jQuery(document).on("click", ".remove-doc-fields-btn", function(){
	
		
		$(this).parents('.add-new-fields-fun').remove();
		
	}); 

	jQuery(document).on("click", ".remove-uploaded-doc", function(){

	    var DocumentID = $(this).attr('id'),
			hitURL = baseURL + "deleteOpportunityDocuments",
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
				currentRow.parents('tr').remove();
				//currentRow.parents('.add-new-fields-fun').remove();
				
			});
		}
		 
		
	});
 
    
    
 

});
