$(document).ready(function(){
    $('#reservation').daterangepicker({ locale: { format: 'DD/MM/YYYY' }});
	var tickeReport = $("#tickeReport");	
	var validator = tickeReport.validate();
});