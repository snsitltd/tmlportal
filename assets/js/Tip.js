 
$(document).ready(function(){
	
	var AddTip = $("#AddTip");
	
	var validator = AddTip.validate({
		
		rules:{
			TipName :{ required : true }, 
			Street1 :{ required : true }, 
			Town :{ required : true },
			County :{ required : true },  
			PostCode :{ required : true } 
		},
		messages:{
			CompanyName :{ required : "This field is required" }, 
			Street1 :{ required : "This field is required" }, 
			Town :{ required : "This field is required" },
			County :{ required : "This field is required" },
			PostCode :{ required : "This field is required" } 
		}
	}); 
	
	jQuery(document).on("click", ".DeleteTip", function(){
		var TipID = $(this).attr("data-TipID"),
			hitURL = baseURL + "DeleteTip",
			currentRow = $(this);			
		
		var confirmation = confirm("Are you sure to delete this record ?");
		
		if(confirmation){
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { TipID : TipID } 
			}).done(function(data){
				//console.log(data); 
				if(data.status = true) { currentRow.parents('tr').remove(); alert("Record successfully deleted"); }
				else if(data.status = false) { alert("Record deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	}); 
	
	
});
