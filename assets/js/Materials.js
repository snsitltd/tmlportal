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
	
	var addnewmaterialsubmit = $("#addnewmaterialsubmit");
	
	var validator = addnewmaterialsubmit.validate({

		ignore: [],	
		 validateNonVisibleFields: true,
            updatePromptsPosition:true,	
		rules:{
			MaterialName :{ required : true },
			Operation :{ required : true },
			SicCode : { required : true},
			TMLPrice : { required : true, number : true },
			//CustPrice : { required : true, number : true },			
			
		},
		messages:{
			MaterialName : { required : "This field is required" },
			Operation : { required : "This field is required" },
			SicCode : { required : "This field is required", },			
			TMLPrice : { required : "This field is required", number : "Please enter numbers only" }
			//CustPrice : { required : "This field is required", number : "Please enter numbers only" },			
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "Operation" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} 
	});



/*
	jQuery(document).on("click", ".deleteMaterials", function(){
		var MaterialID = $(this).attr("data-MaterialID"),
			hitURL = baseURL + "deleteMaterials",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this record ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { MaterialID : MaterialID } 
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
	//var rowIndex = 1;
	jQuery(document).on("click", ".add-new-price", function(){		
		 var rowIndex = $('.priceRow').length;		
		 //$(".fun-row-price").append('<div class="row priceRow"><div class="col-md-1" style="width: 0px;"> <div class="form-group"> <label for="defualt_'+rowIndex+'">&nbsp;</label><br> <input type="checkbox" id="defualt_'+rowIndex+'" name="price['+rowIndex+'][defualt]" value="'+rowIndex+'" title="Defualt"> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="TMLPrice_'+rowIndex+'">TML Price</label> <input type="text" class="form-control required number" value="" id="TMLPrice_'+rowIndex+'" name="price['+rowIndex+'][TMLPrice]" maxlength="10"> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="CustPrice_'+rowIndex+'">Customer Price</label> <input type="text" class="form-control required number" value="" id="CustPrice_'+rowIndex+'" name="price['+rowIndex+'][CustPrice]" maxlength="10"> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="StartDate_'+rowIndex+'">Start Date</label> <input type="text" class="form-control required datepicker" id="StartDate_'+rowIndex+'" value="" name="price['+rowIndex+'][StartDate]" maxlength="10"> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="EndDate_'+rowIndex+'">End Date</label> <input type="text" class="form-control required datepicker" id="EndDate_'+rowIndex+'" value="" name="price['+rowIndex+'][EndDate]" maxlength="10"></div> </div> <div class="col-md-2"> <div class="form-group"> <label>&nbsp;</label><br> <i class="fa fa-minus-circle remove-new-price" style="font-size: 35px; color: red"></i> </div> </div> </div>');
		 $(".fun-row-price").append('<div class="row priceRow"><div class="col-md-1" style="width: 0px;"> <div class="form-group"> <label for="defualt_'+rowIndex+'">&nbsp;</label><br> <input type="checkbox" id="defualt_'+rowIndex+'" name="price['+rowIndex+'][defualt]" value="'+rowIndex+'" title="Defualt"> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="TMLPrice_'+rowIndex+'">TML Price</label> <input type="text" class="form-control required number" value="" id="TMLPrice_'+rowIndex+'" name="price['+rowIndex+'][TMLPrice]" maxlength="10"> </div> </div>  <div class="col-md-2"> <div class="form-group"> <label for="StartDate_'+rowIndex+'">Start Date</label> <input type="text" class="form-control required datepicker" id="StartDate_'+rowIndex+'" value="" name="price['+rowIndex+'][StartDate]" maxlength="10"> </div> </div> <div class="col-md-2"> <div class="form-group"> <label for="EndDate_'+rowIndex+'">End Date</label> <input type="text" class="form-control required datepicker" id="EndDate_'+rowIndex+'" value="" name="price['+rowIndex+'][EndDate]" maxlength="10"></div> </div> <div class="col-md-2"> <div class="form-group"> <label>&nbsp;</label><br> <i class="fa fa-minus-circle remove-new-price" style="font-size: 35px; color: red"></i> </div> </div> </div>');

		 rowIndex++;

		 $( function() {
        $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );

	});


	jQuery(document).on("click", ".remove-new-price", function(){

	$(this).parent().parent().parent().remove();

	});

	jQuery(document).on("change", ".material-status", function(){

	if($(this).val()=='IN') $("#SicCode").val('38.11');
	if($(this).val()=='OUT') $("#SicCode").val('38.21');
	if($(this).val()=='Collection') $("#SicCode").val('38.21');	

	});


});


