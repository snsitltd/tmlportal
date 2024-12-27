/**
 * File : addUser.js
 * 
 * This file contain the validation of add user form
 * 
 * Using validation plugin : jquery.validate.js
 * 
 * @author Kishor Mali
 */
Parsley.addValidator('regsno', {
    validateString: function(value) {
    var ret=true;
    $.ajax ({
            url: baseURL+'checkRegNumber/',
            data: { val : value },
            type: 'post',
            async: false,
            success: function( result ) {
                if(result == 0){
                    ret =  false;
                }else{
                    ret =  true;
                }
                
            }
        });
   // return $.ajax(baseURL+'checkRegNumber/' + value)
   //alert(ret);
   return ret;
  },
  messages: {en: 'This value already exist.'}
});
Parsley.addValidator('editregsno', {
    validateString: function(value) {
    var ret=true;
    var EditLorryNo = $('#EditLorryNo').val();
    $.ajax ({
            url: baseURL+'checkRegEditNumber/',
            data: { val : value ,EditLorryNo:EditLorryNo},
            type: 'post',
            async: false,
            success: function( result ) {
                if(result == 0){
                    ret =  false;
                }else{
                    ret =  true;
                }
                
            }
        });
   // return $.ajax(baseURL+'checkRegNumber/' + value)
   //alert(ret);
   return ret;
  },
  messages: {en: 'This value already exist.'}
});

$(document).ready(function(){ 

	var addsubcontractor = $("#addsubcontractor");
	
	var validator = addsubcontractor.validate({
		
		rules:{
			CompanyName :{ required : true }			
		},
		messages:{
			CompanyName :{ required : "This field is required" }  
		}
	});

/*
	jQuery(document).on("click", ".deleteDriver", function(){
		var LorryNo = $(this).attr("data-LorryNo"),
			hitURL = baseURL + "deleteDriver",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this record ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { LorryNo : LorryNo } 
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

	$(document).on("click", ".driver-edit-model", function () 
    {

      var LorryNo = $(this).attr('data-LorryNo');
      var DriverName = $(this).attr('data-DriverName');
      var RegNumber = $(this).attr('data-RegNumber');
      var Tare = $(this).attr('data-Tare');
      var Haulier = $(this).attr('data-Haulier'); 

      $(".modal-body #EditLorryNo").val( LorryNo );
      $(".modal-body #EditDriverName").val( DriverName );
      $(".modal-body #EditRegNumber").val( RegNumber );
      $(".modal-body #EditTare").val( Tare );
      $(".modal-body #EditHaulier").val( Haulier );
    });




});
