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
	


	jQuery(document).on("click", ".deleteCounty", function(){
		var ID = $(this).attr("data-ID"),
			hitURL = baseURL + "deleteCounty",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this record ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { ID : ID } 
			}).done(function(data){
				console.log(data);
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Record successfully deleted"); }
				else if(data.status = false) { alert("Record deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});



	$(document).on("click", ".county-edit-model", function () 
    {

      var ID = $(this).attr('data-ID');
      var County = $(this).attr('data-County'); 

      $(".modal-body #EditID").val( ID );
      $(".modal-body #EditCounty").val( County );
      
    });




});
