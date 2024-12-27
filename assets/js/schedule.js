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
	
	var uploaddatasubmit = $("#uploaddatasubmit");
	
	var validator = uploaddatasubmit.validate({
		
		rules:{
			title :{ required : true },			
			filedata : { required : true },			
			uploadfile : { required : true}
		},
		messages:{
			title :{ required : "This field is required" },
			filedata : { required : "This field is required" },
			uploadfile : { required : "This field is required"}			
		}
	});
});


$('input[name=logo]').change(function(e){
  var fileName = e.target.files[0].name;

  //Get reference of FileUpload.
    var fileUpload = document.getElementById("fileUploadimage");
 
    //Check whether the file is valid Image.
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
 
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    if (height < 120 || width < 120) {
                        return false;
                    }else{
                    alert("Height and Width must be less than 120px.");
                    return false;

                    }
                    
                };
 
            }
        } else {
            alert("This browser does not support HTML5.");
            return false;
        }
    } else {
        alert("Please select a valid Image file.");
        return false;
    }


});

