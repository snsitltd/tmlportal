$(document).ready(function(){ 
	
	$.validator.addMethod("greaterThan", function(value, element){
			var value = parseFloat(value);
			var smaller = parseFloat($("#Tare").val());
	   
           if(value < smaller)     
                { return false; }
           else
                { return true; }
    },"Gross Weight is must greater than Tare.");
	
	$("#Amount").keyup(function(){ 
		var amount = $(this).val() 
		var vat = $('#Vat').val()  
		if(amount==""){ amount =0; } 
		var vatamount = ((parseFloat(amount)*parseFloat(vat))/100)
		var total = (parseFloat(amount) + parseFloat(vatamount)); 
		$('#VatAmount').val(vatamount.toFixed(2));
		$('#TotalAmount').val(total.toFixed(2)); 
	}); 
	
    $("input[name$='PaymentType']").click(function() {
        var pvalue = $(this).val(); 
		if(pvalue!=0){
			$("div.pblock").show();
		}else{
			$("div.pblock").hide();
		}
    }); 
	
	$.fn.UpdateCompanyDD = function(){ 
		$.ajax({
		type : "POST",
		dataType : "json",
		url: baseURL+"getCompanyList",
		data : ""
		}).done(function(data){ 
			//console.log(data);      
			if(data.status==false){	
				var options = ' <option value="0">-- ADD COMPANY --</option>';
				$("#CompanyID").html(options).selectpicker('refresh'); 
			}else{ 	 
				var options = '<option value="0">-- ADD COMPANY --</option>';
				for (var i = 0; i < data.company_list.length; i++) { 
					options += '<option value="' + data.company_list[i].CompanyID + '">' + data.company_list[i].CompanyName + '</option>';
				} 
				$("#CompanyID").html(options).selectpicker('refresh'); 
			} 
		}); 
	}
	$.fn.UpdateLorryDD = function(){ 
		$.ajax({
		type : "POST",
		dataType : "json",
		url: baseURL+"getLorryList",
		data : ""
		}).done(function(data){ 
			//console.log(data);      
			if(data.status==false){	
				var options = ' <option value="0">-- ADD LORRY --</option>';
				$("#LorryNo").html(options).selectpicker('refresh'); 
			}else{ 	 
				var options = '<option value="0">-- ADD LORRY --</option>';
				for (var i = 0; i < data.lorry_list.length; i++) { 
				options += '<option value="' + data.lorry_list[i].LorryNo + '">' + data.lorry_list[i].LorryNo + ' | ' + data.lorry_list[i].DriverName + ' | ' + data.lorry_list[i].RegNumber + ' | ' + data.lorry_list[i].Haulier + ' </option>';
				} 
				$("#LorryNo").html(options).selectpicker('refresh'); 
			} 
		}); 
	}
	$(".VechicleRegNo").on('keyup',function(){    
		var RegNo=$(this).val();	 
		var LorryNo = $('#LorryNo').val(); 		 
		if(LorryNo=='0'){     
			if(RegNo!=''){     
				jQuery.ajax({
					type : "POST",
					dataType : "json",
					url: baseURL+"CheckDuplicateRegNo",
					data : { 'RegNo' : RegNo }  
					}).done(function(data){   
						console.log(data);               
						if(data.STATUS==false){	  
							$("#VechicleRegNo").val('');    
							$("#RegDup").html("Vehicle Already Registered, Please Select From Lorry NO.  ");    
						}else{
							$("#RegDup").html('');    
						}  
				}); 
			}else{
				$("#RegDup").html('');    
			}
		}else{
			$("#RegDup").html('');    
		}	 
   });
   $(".EditVechicleRegNo").on('keyup',function(){    
		var RegNo=$(this).val();	  
		var RegNo1 = $('#RegNo').val()  
		var LorryNo = $('#LorryNo').val(); 		
		if(LorryNo=='0'){     
			if(RegNo!=''){     
				if(RegNo!=RegNo1){     
					jQuery.ajax({
						type : "POST",
						dataType : "json",
						url: baseURL+"CheckDuplicateRegNo",
						data : { 'RegNo' : RegNo }  
						}).done(function(data){   
							console.log(data);               
							if(data.STATUS==false){	  
								//$("#VechicleRegNo").val(RegNo1);    
								$("#RegDup").html("Vehicle Already Registered, Please Select From Lorry NO.  ");    
							}else{
								$("#RegDup").html('');    
							}  
					}); 
				}else{
					$("#VechicleRegNo").val(RegNo1);    
				}
			}  
		}		
		
   });
///######################### Add Office Ticket #########################################
 
	var addOfficeTicketsSubmit = $("#addOfficeTicketsSubmit");
	
	var validator = addOfficeTicketsSubmit.validate({
		 
		rules:{ 
			TicketGap :{ required : true },
			CompanyName: {
				required: function(element) {
					  return $('#CompanyID').val() == 0;
				}
			} ,
			OpportunityID: { required:  true } ,
			Street1: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			County: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			Town: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			PostCode: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			driversignature : { required : true}, 
			TypeOfTicket :{ required : true },
			LorryNo : { required : true},
			VechicleRegNo :{ required : true }, 
			GrossWeight : {maxlength: 5, greaterThan: '#Tare'},
			DriverName :{ required : true }, 
			Amount :{  required: function () { 
                if($("input[name='PaymentType']:checked").val() > 0){ return true;  }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "TypeOfTicket" || element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo"|| element.attr("name") == "County"  ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		},
		submitHandler: function(form){ 
		 
				event.preventDefault();  
				TicketNumber = $( "input[name='TicketNumber']" ).val(),
				TicketGap = $( "input[name='TicketGap']" ).val(),
				WIFNumber = $( "input[name='WIFNumber']" ).val(), 
				TypeOfTicket = $( "#TypeOfTicket" ).val(), 
				Conveyance = $( "input[name='Conveyance']" ).val(), 
				CompanyID = $( "#CompanyID" ).val(),
				
				CompanyName = $( "#CompanyName" ).val(),
				Street1 = $( "#Street1" ).val(),
				County = $( "#County" ).val(),
				Town = $( "#Town" ).val(),
				PostCode = $( "#PostCode" ).val(),
				
				OpportunityID = $( "#OpportunityID" ).val(),
				SiteAddress = $( "input[name='SiteAddress']" ).val(),
				HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
				DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
				SicCode = $( "input[name='SicCode']" ).val(),
				ticket_notes = $( "textarea[name='ticket_notes']" ).val(),
				LorryNo = $( "#LorryNo" ).val(),
				VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
				driverid = $( "input[name='driverid']" ).val(),
				DriverName = $( "input[name='DriverName']" ).val(),
				GrossWeight = $( "input[name='GrossWeight']" ).val(),
				Tare = $( "input[name='Tare']" ).val(),
				Net = $( "input[name='Net']" ).val(),
				 
				MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 
				
				PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
				Amount = $( "input[name='Amount']" ).val(), 
				Vat = $( "input[name='Vat']" ).val(), 
				VatAmount = $( "input[name='VatAmount']" ).val(), 
				TotalAmount = $( "input[name='TotalAmount']" ).val(), 
				PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
				driversignature = $( "input[name='driversignature']" ).val(), 
		 
					
				url = addOfficeTicketsSubmit.attr( "action" ); 
				if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
				var btn= $("input[type=submit]:focus").val();
				if(btn == 'HOLD'){ var is_hold = 1; }else{  var is_hold = 0;  } 
			if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined  && 
			DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && 
			TypeOfTicket !="" && TypeOfTicket !=undefined  && TicketGap !="" && TicketGap !=undefined  && GrossWeight > 0  ){ 	
			
			  // Send the data using post
				var posting = $.post( url, { TicketNumber: TicketNumber,TicketGap: TicketGap,WIFNumber: WIFNumber,TypeOfTicket: TypeOfTicket, 
				Conveyance: Conveyance,is_tml: is_tml,CompanyID: CompanyID,
				CompanyName: CompanyName,Street1: Street1,County: County,Town: Town,PostCode: PostCode,
				OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial,ticket_notes: ticket_notes,
				LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,
				Net: Net, MaterialPrice: MaterialPrice,is_hold: is_hold,
				PaymentType: PaymentType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo ,driversignature: driversignature } );
				 
					$('#overlay').fadeIn();
					posting.done(function( data ) { 
						//alert(data)			
						//$('#result').html(data); 
						$('#overlay').fadeOut(); 
						$("#addOfficeTicketsSubmit")[0].reset();  								  
						$('#VechicleRegNo').attr('readonly', false); 
						$('#VechicleRegNo').val('');
						$('#DriverName').val('');
						$('#Tare').val('');  
						$('#Net').val('');   						
						$("#driversignature").val('');				  
						$('#driverimage').html('');  
						$("div.pblock").hide();
						$('#OpportunityID').selectpicker('refresh');  
						$('#CompanyID').selectpicker('refresh');  
						$('#DescriptionofMaterial').selectpicker('refresh');  
						$('#LorryNo').selectpicker('refresh');  
						$('#OpportunityID').selectpicker('refresh');  
						$.fn.UpdateCompanyDD();
						$.fn.UpdateLorryDD();  
					  if(data=='Error'){
						  alert("Error In  Submitting Data, Please contact Administrator.");
						  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>'); 
					  }else{
							
						if(data.length > 20){	 
						  //alert("New Office (GAP) TICKET created successfully.");  
						  printPDF(data);  
						  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New Office (GAP) TICKET created successfully.</div>'); 
						}else{ return false; }   
					  }   
					}); 
					
				}else{
					$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				}  
		} 
	});

///######################### Add In Ticket #########################################
//GrossWeight : { maxlength: 5, greaterThan: '#Tare'},
	var addTicketsSubmit = $("#addTicketsSubmit");
	
	var validator = addTicketsSubmit.validate({
		 
		rules:{ 
			LorryNo : { required : true}, 
			CompanyName: {
				required: function(element) {
					  return $('#CompanyID').val() == 0;
				}
			} ,
			OpportunityID: { required:  true } ,
			Street1: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			County: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			Town: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			PostCode: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			driversignature : { required : true}, 
			VechicleRegNo :{ required : true },
			SicCode :{ required : true }, 
			GrossWeight :{  required: function () {  
                if($("input[type=submit]:focus").val() == "Submit"){ return true }else{ return false; }
            },maxlength: 5, greaterThan: '#Tare', notEqual: '0' },	
			
			DriverName :{ required : true }, 
			Amount :{  required: function () { 
                if($("input[name='PaymentType']:checked").val() > 0){ return true;  }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},
		messages: { 
			GrossWeight: {
				required: "This Field is Required",               
				number:"Please enter numbers only",
				notEqual:"Amount can not be zero"
			}
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo"|| element.attr("name") == "County" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		},
		submitHandler: function(form){ 
			 
				event.preventDefault();  
				WIFNumber = $( "input[name='WIFNumber']" ).val(), 
				Conveyance = $( "input[name='Conveyance']" ).val(), 
				CompanyID = $( "#CompanyID" ).val(),
				
				CompanyName = $( "#CompanyName" ).val(),
				Street1 = $( "#Street1" ).val(),
				County = $( "#County" ).val(),
				Town = $( "#Town" ).val(),
				PostCode = $( "#PostCode" ).val(),
				
				OpportunityID = $( "#OpportunityID" ).val(),
				SiteAddress = $( "input[name='SiteAddress']" ).val(),
				HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
				DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
				SicCode = $( "input[name='SicCode']" ).val(),
				ticket_notes = $( "textarea[name='ticket_notes']" ).val(),
				LorryNo = $( "#LorryNo" ).val(),
				VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
				driverid = $( "input[name='driverid']" ).val(),
				DriverName = $( "input[name='DriverName']" ).val(),
				GrossWeight = $( "input[name='GrossWeight']" ).val(),
				Tare = $( "input[name='Tare']" ).val(),
				Net = $( "input[name='Net']" ).val(), 
				MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 
				
				FreeSuite = $( "input[name='FreeSuite']:checked" ).val(),  
				OrderNo = $( "input[name='OrderNo']" ).val(), 
				
				PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
				LorryType = $( "input[name='LorryType']:checked" ).val(), 
				Amount = $( "input[name='Amount']" ).val(), 
				Vat = $( "input[name='Vat']" ).val(), 
				VatAmount = $( "input[name='VatAmount']" ).val(), 
				TotalAmount = $( "input[name='TotalAmount']" ).val(), 
				PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
				driversignature = $( "input[name='driversignature']" ).val(), 
				
				url = addTicketsSubmit.attr( "action" ); 
				if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
				if($( "input[name='FreeSuite']" ).is(":checked")){ var FreeSuite = 1; }else{ var FreeSuite = 0;  }
				
				var btn= $("input[type=submit]:focus").val();
				if(btn == 'HOLD'){ var is_hold = 1; }else{  var is_hold = 0;  } 
		  
			if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined  && 
			DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined && GrossWeight > 0  ){ 
 
			  // Send the data using post
				var posting = $.post( url, {  Conveyance: Conveyance, WIFNumber: WIFNumber,is_tml: is_tml,CompanyID: CompanyID,
				CompanyName: CompanyName,Street1: Street1,County: County,Town: Town,PostCode: PostCode,
				OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial,ticket_notes: ticket_notes,
				LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,
				Net: Net, MaterialPrice: MaterialPrice,is_hold: is_hold, FreeSuite: FreeSuite,OrderNo: OrderNo,
				PaymentType: PaymentType,LorryType: LorryType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo ,driversignature: driversignature } );
				  
				 $('#overlay').fadeIn();
					posting.done(function( data ) {   
					//alert(data)
						//$('#result').html(data); 
						$('#overlay').fadeOut(); 
						$('#VechicleRegNo').attr('readonly', false); 
						$('#VechicleRegNo').val('');
						$('#CompanyName').attr('readonly', false); 
						$('#CompanyName').val('');
						$('#Street1').attr('readonly', false); 
						$('#Street1').val('');
						$('#Town').attr('readonly', false); 
						$('#Town').val('');
						$('#PostCode').attr('readonly', false); 
						$('#PostCode').val('');
						$('#DriverName').val('');
						$('#Tare').val('');  
						$('#Net').val('');  
						$("#addTicketsSubmit")[0].reset();  								  
						$("#driversignature").val('');				  
						$('#driverimage').html('');  
						$("div.pblock").hide();
						$("#ShowOrderNo").hide();						
						$('#CompanyID').selectpicker('refresh'); 
						$('#County').selectpicker('refresh'); 
						$('#OpportunityID').selectpicker('refresh'); 
						$('#DescriptionofMaterial').selectpicker('refresh'); 
						$('#LorryNo').selectpicker('refresh');  
						$.fn.UpdateCompanyDD();
						$.fn.UpdateLorryDD();
						
					  if(data=='Error'){
						  alert("Error In  Submitting Data, Please contact Administrator.");
						  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>'); 
					  }else{
							
							//if(data.substring(0,4)=='HOLD'){
							if(data=='HOLD'){
							  //$('#holdtkt').html(data.substring(5,7));  
							  UpdateHoldCount();
							  alert("Hold IN TICKET created successfully.");   
							  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Hold IN TICKET created successfully.</div>'); 
							}else{ 			
								if(data.length > 20){	
								  //alert("New IN TICKET created successfully."); 
								  printPDF(data);  
								  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New IN TICKET created successfully.</div>'); 
								}else{ return false; }  
							}
					  }   
					}); 
				}else{
					//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				} 
		} 
		
	});
	jQuery.validator.addMethod("notEqual", function (value, element, param) { // Adding rules for Amount(Not equal to zero)
		return this.optional(element) || value != '0';
	});
///######################### Add Out Ticket #########################################

	var outTicketssubmit = $("#outTicketssubmit");
	
	var validator = outTicketssubmit.validate({
		
		rules:{ 
			LorryNo : { required : true},
			CompanyName: {
				required: function(element) {
					  return $('#CompanyID').val() == 0;
				}
			} ,
			OpportunityID: { required:  true } ,
			Street1: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			County: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			Town: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			PostCode: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			driversignature : { required : true}, 
			VechicleRegNo :{ required : true },
			DriverName :{ required : true },
			GrossWeight :{  required: function () {  
                if($("input[type=submit]:focus").val() == "Submit"){ return true }else{ return false; }
            },maxlength: 5,  greaterThan: '#Tare', notEqual: '0' },
			Amount :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 0){ return true }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},messages: { 
			GrossWeight: {
				required: "This Field is Required",               
				number:"Please enter numbers only",
				notEqual:"Amount can not be zero"
			}
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo" || element.attr("name") == "County") {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		},
		submitHandler: function(form){  
				event.preventDefault();  
				Conveyance = $( "input[name='Conveyance']" ).val(), 
				CompanyID = $( "#CompanyID" ).val(),
				
				CompanyName = $( "#CompanyName" ).val(),
				Street1 = $( "#Street1" ).val(),
				County = $( "#County" ).val(),
				Town = $( "#Town" ).val(),
				PostCode = $( "#PostCode" ).val(),
				
				OpportunityID = $( "#OpportunityID" ).val(),
				SiteAddress = $( "input[name='SiteAddress']" ).val(), 
				DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),  
				LorryNo = $( "#LorryNo" ).val(),
				VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
				driverid = $( "input[name='driverid']" ).val(),
				DriverName = $( "input[name='DriverName']" ).val(),
				HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
				GrossWeight = $( "input[name='GrossWeight']" ).val(),
				Tare = $( "input[name='Tare']" ).val(),
				Net = $( "input[name='Net']" ).val(), 
				MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 
				SicCode = $( "input[name='SicCode']" ).val(),
				
				OrderNo = $( "input[name='OrderNo']" ).val(), 
				
				PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
				LorryType = $( "input[name='LorryType']:checked" ).val(), 
				Amount = $( "input[name='Amount']" ).val(), 
				Vat = $( "input[name='Vat']" ).val(), 
				VatAmount = $( "input[name='VatAmount']" ).val(), 
				TotalAmount = $( "input[name='TotalAmount']" ).val(), 
				PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
				driversignature = $( "input[name='driversignature']" ).val(), 
				url = outTicketssubmit.attr( "action" ); 
				if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
				var btn= $("input[type=submit]:focus").val();
				if(btn == 'HOLD'){ var is_hold = 1; }else{  var is_hold = 0;  } 
 
		if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined  && 
			DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && GrossWeight > 0 ){ 
				
			  // Send the data using post
				var posting = $.post( url, {  Conveyance: Conveyance,is_tml: is_tml,CompanyID: CompanyID,
				CompanyName: CompanyName,Street1: Street1,County: County,Town: Town,PostCode: PostCode,
				OpportunityID: OpportunityID,SiteAddress: SiteAddress,DescriptionofMaterial: DescriptionofMaterial, 
				LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,HaullerRegNo: HaullerRegNo,GrossWeight: GrossWeight,Tare: Tare, 
				Net: Net, MaterialPrice: MaterialPrice,is_hold: is_hold ,SicCode: SicCode,OrderNo: OrderNo,
				PaymentType: PaymentType,LorryType: LorryType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo,driversignature: driversignature  } );
				 
				$('#overlay').fadeIn();
					posting.done(function( data ) {  
						$('#overlay').fadeOut(); 
					 
						$('#VechicleRegNo').attr('readonly', false); 
						$('#VechicleRegNo').val('');
						$('#CompanyName').attr('readonly', false); 
						$('#CompanyName').val('');
						$('#Street1').attr('readonly', false); 
						$('#Street1').val('');
						$('#Town').attr('readonly', false); 
						$('#Town').val('');
						$('#PostCode').attr('readonly', false); 
						$('#PostCode').val('');
						$('#DriverName').val('');
						$('#Tare').val('');  
						$('#Net').val('');  
						$("#outTicketssubmit")[0].reset();  								  
						$("#driversignature").val('');				  
						$('#driverimage').html('');  
						$("div.pblock").hide(); 
						$("#ShowOrderNo").hide();		
						$('#CompanyID').selectpicker('refresh'); 
						$('#County').selectpicker('refresh'); 
						$('#OpportunityID').selectpicker('refresh'); 
						$('#DescriptionofMaterial').selectpicker('refresh'); 
						$('#LorryNo').selectpicker('refresh'); 
						$.fn.UpdateCompanyDD();
						$.fn.UpdateLorryDD();		
					  if(data=='Error'){
						  alert("Error In  Submitting Data, Please contact Administrator.");
						  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>');
						  
					  }else{
						  //if(data.substring(0,4)=='HOLD'){
						  if(data=='HOLD'){
							  //$('#holdtkt').html(data.substring(5,7));  
							   UpdateHoldCount();
							   alert("Hold OUT TICKET  created successfully.");  
							  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Hold OUT TICKET  created successfully.</div>'); 
						  }else{ 							
							  //alert("New OUT TICKET created successfully."); 
							  printPDF(data); 
							  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> New OUT TICKET  created successfully.</div>');  
						  }
					  }   
					}); 
				}else{
					//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				}  
		}	
		
	});

///######################### Add Collection Ticket #########################################


	var collectionTicketssubmit = $("#collectionTicketssubmit");
	
	var validator = collectionTicketssubmit.validate({
		
		rules:{ 
			LorryNo : { required : true},
			CompanyName: {
				required: function(element) {
					  return $('#CompanyID').val() == 0;
				}
			} ,
			OpportunityID: { required:  true } ,
			Street1: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			County: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			Town: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			PostCode: {
				required: function(element) {
					  return $('#OpportunityID').val() == 0;
				}
			} ,
			driversignature : { required : true}, 
			VechicleRegNo :{ required : true },
			DriverName :{ required : true },
			GrossWeight :{  required: function () {  
                if($("input[type=submit]:focus").val() == "Submit"){ return true }else{ return false; }
            },maxlength: 5,   greaterThan: '#Tare', notEqual: '0'  },
			Amount :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 0){ return true }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},messages: { 
			GrossWeight: {
				required: "This Field is Required",               
				number:"Please enter numbers only",
				notEqual:"Amount can not be zero"
			}
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo" || element.attr("name") == "County") {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		},
		submitHandler: function(form){  
				event.preventDefault();  
				Conveyance = $( "input[name='Conveyance']" ).val(), 
				CompanyID = $( "#CompanyID" ).val(),
				
				CompanyName = $( "#CompanyName" ).val(),
				Street1 = $( "#Street1" ).val(),
				County = $( "#County" ).val(),
				Town = $( "#Town" ).val(),
				PostCode = $( "#PostCode" ).val(),
				
				OpportunityID = $( "#OpportunityID" ).val(),
				SiteAddress = $( "input[name='SiteAddress']" ).val(),
				HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
				DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
				SicCode = $( "input[name='SicCode']" ).val(), 
				LorryNo = $( "#LorryNo" ).val(),
				VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
				DriverName = $( "input[name='DriverName']" ).val(),
				driverid = $( "input[name='driverid']" ).val(),
				GrossWeight = $( "input[name='GrossWeight']" ).val(),
				Tare = $( "input[name='Tare']" ).val(),
				Net = $( "input[name='Net']" ).val(),
				 
				MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 
				
				OrderNo = $( "input[name='OrderNo']" ).val(), 
				
				PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
				LorryType = $( "input[name='LorryType']:checked" ).val(), 
				Amount = $( "input[name='Amount']" ).val(), 
				Vat = $( "input[name='Vat']" ).val(), 
				VatAmount = $( "input[name='VatAmount']" ).val(), 
				TotalAmount = $( "input[name='TotalAmount']" ).val(), 
				PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
				driversignature = $( "input[name='driversignature']" ).val(), 
				
				url = collectionTicketssubmit.attr( "action" ); 

				//if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
				var btn= $("input[type=submit]:focus").val();
				if(btn == 'HOLD'){ var is_hold = 1; }else{  var is_hold = 0;  } 
			
			if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined  && 
			DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && GrossWeight > 0 ){ 
			
			  // Send the data using post
				var posting = $.post( url, { Conveyance: Conveyance, CompanyID: CompanyID,
				CompanyName: CompanyName,Street1: Street1,County: County,Town: Town,PostCode: PostCode,
				OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial, 
				LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode, OrderNo: OrderNo, 
				Net: Net, MaterialPrice: MaterialPrice,is_hold: is_hold, 
				PaymentType: PaymentType,LorryType: LorryType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo ,driversignature: driversignature  } );
				  
				$('#overlay').fadeIn();
					posting.done(function( data ) {    
					$('#overlay').fadeOut();   
						$('#VechicleRegNo').attr('readonly', false); 
						$('#VechicleRegNo').val('');
						$('#CompanyName').attr('readonly', false); 
						$('#CompanyName').val('');
						$('#Street1').attr('readonly', false); 
						$('#Street1').val('');
						$('#Town').attr('readonly', false); 
						$('#Town').val('');
						$('#PostCode').attr('readonly', false); 
						$('#PostCode').val('');
						$('#DriverName').val('');
						$('#Tare').val('');  
						$('#Net').val('');  
						$("#collectionTicketssubmit")[0].reset();  								  
						$("#driversignature").val('');				  
						$('#driverimage').html('');  
						$("div.pblock").hide(); 
						$('#CompanyID').selectpicker('refresh'); 
						$('#County').selectpicker('refresh'); 
						$('#OpportunityID').selectpicker('refresh'); 
						$('#DescriptionofMaterial').selectpicker('refresh'); 
						$('#LorryNo').selectpicker('refresh'); 
						$.fn.UpdateCompanyDD();
						$.fn.UpdateLorryDD();
					  if(data=='Error'){
						  alert("Error In  Submitting Data, Please contact Administrator.");
						  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>');
						  
					  }else{
						  //if(data.substring(0,4)=='HOLD'){
						  if(data=='HOLD'){
							  //$('#holdtkt').html(data.substring(5,7));   
							  UpdateHoldCount();
							  alert("Hold COLLECTION TICKET created successfully.");  
							  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Hold COLLECTION TICKET created successfully.</div>'); 
						  }else{ 							
							  //alert("New COLLECTION TICKET created successfully."); 
							  printPDF(data);  
							  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New COLLECTION TICKET created successfully.</div>'); 
						  }
					  }   
					}); 
				}else{
					//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				}  
		}	 
		
	});
	
///######################### Edit In Ticket #########################################

	
	var EditInTicket = $("#EditInTicket");
	
	var validator = EditInTicket.validate({
		
		rules:{ 
			OpportunityID: { required: true } , 
			LorryNo: { required:  true } ,
			CompanyID: { required:  true } ,
			DescriptionofMaterial: { required:  true } ,
			VechicleRegNo :{ required : true },
			SicCode :{ required : true },
			DriverName :{ required : true },
			GrossWeight : {maxlength: 5, greaterThan: '#Tare', notEqual: '0' },
			Amount :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 0){ return true }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},messages: { 
			GrossWeight: {
				required: "This Field is Required",               
				number:"Please enter numbers only",
				notEqual:"Amount can not be zero"
			}
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} ,
		submitHandler: function(form){ 
				// Stop form from submitting normally
				event.preventDefault();   
				WIFNumber = $( "input[name='WIFNumber']" ).val(),  
				TicketNo = $( "input[name='TicketNo']" ).val(),		
				Conveyance = $( "input[name='Conveyance']" ).val(), 
				CompanyID = $( "#CompanyID" ).val(),
				OpportunityID = $( "#OpportunityID" ).val(),
				SiteAddress = $( "input[name='SiteAddress']" ).val(),
				HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
				DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
				SicCode = $( "input[name='SicCode']" ).val(),
				ticket_notes = $( "textarea[name='ticket_notes']" ).val(),
				LorryNo = $( "#LorryNo" ).val(),
				VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
				driverid = $( "input[name='driverid']" ).val(),
				DriverName = $( "input[name='DriverName']" ).val(),
				GrossWeight = $( "input[name='GrossWeight']" ).val(),
				Tare = $( "input[name='Tare']" ).val(),
				Net = $( "input[name='Net']" ).val(), 
				MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 
				TicketDate = $( "input[name='TicketDate']" ).val(),
				OrderNo = $( "input[name='OrderNo']" ).val(), 
				FreeSuite = $( "input[name='FreeSuite']:checked" ).val(), 
				
				PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
				LorryType = $( "input[name='LorryType']:checked" ).val(), 
				Amount = $( "input[name='Amount']" ).val(), 
				Vat = $( "input[name='Vat']" ).val(), 
				VatAmount = $( "input[name='VatAmount']" ).val(), 
				TotalAmount = $( "input[name='TotalAmount']" ).val(), 
				PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
				driversignature = $( "input[name='driversignature']" ).val(), 
				 
				url = EditInTicket.attr( "action" ); 
				 
				if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }   
				
				if(TicketNo !=""  && CompanyID !=""  && CompanyID !=undefined   && OpportunityID !="" && CompanyID !=0 && OpportunityID !=0 && OpportunityID !=undefined  && 
					DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined && GrossWeight >0  ){ 

				// Send the data using post
				var posting = $.post( url, {  TicketNo: TicketNo, Conveyance: Conveyance, WIFNumber: WIFNumber,is_tml: is_tml,CompanyID: CompanyID,
				OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial,ticket_notes: ticket_notes,
				LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,FreeSuite: FreeSuite,OrderNo: OrderNo,
				Net: Net, MaterialPrice: MaterialPrice, PaymentType: PaymentType,LorryType: LorryType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount, 
				PaymentRefNo: PaymentRefNo ,driversignature: driversignature, TicketDate: TicketDate } ); 
					$('#overlay').fadeIn();
					posting.done(function( data ) {  
						$('#overlay').fadeOut(); 
						if(data=='SAME'){
						  alert("All Values are same as previous. Please update values to change. ");
						  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>All Values are same as previous. Please update values to change.</div>');
						}else if(data.length > 20){
						  //alert("IN TICKET updated successfully."); 
						  printPDF(data); 
						  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> IN TICKET updated successfully.</div>');  
						}   
					}); 
				}else{
					alert(" Company | Opportunity | Material | Lorry Information Must not be Blank. Please check and Try Again ")
					//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				}  
		}
		
	});

///######################### Edit InBound Ticket #########################################

	
	var EditInBound = $("#EditInBound");
	
	var validator = EditInBound.validate({
		
		rules:{ 
			OpportunityID: { required: true } , 
			LorryNo: { required:  true } ,
			CompanyID: { required:  true } ,
			DescriptionofMaterial: { required:  true } ,
			VechicleRegNo :{ required : true },
			SicCode :{ required : true },
			DriverName :{ required : true },
			GrossWeight : {maxlength: 5, greaterThan: '#Tare', notEqual: '0' },
			Amount :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 0){ return true }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} ,messages: { 
			GrossWeight: {
				required: "This Field is Required",               
				number:"Please enter numbers only",
				notEqual:"Amount can not be zero"
			}
		},
		submitHandler: function(form){ 
				// Stop form from submitting normally
				event.preventDefault();   
				WIFNumber = $( "input[name='WIFNumber']" ).val(),  
				TicketNo = $( "input[name='TicketNo']" ).val(),		
				LoadID = $( "input[name='LoadID']" ).val(), 
				Conveyance = $( "input[name='Conveyance']" ).val(), 
				CompanyID = $( "#CompanyID" ).val(),
				OpportunityID = $( "#OpportunityID" ).val(),
				SiteAddress = $( "input[name='SiteAddress']" ).val(),
				HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
				DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
				SicCode = $( "input[name='SicCode']" ).val(),
				ticket_notes = $( "textarea[name='ticket_notes']" ).val(),
				LorryNo = $( "#LorryNo" ).val(),
				VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
				driverid = $( "input[name='driverid']" ).val(),
				DriverName = $( "input[name='DriverName']" ).val(),
				GrossWeight = $( "input[name='GrossWeight']" ).val(),
				Tare = $( "input[name='Tare']" ).val(),
				Net = $( "input[name='Net']" ).val(), 
				MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 
				
				PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
				Amount = $( "input[name='Amount']" ).val(), 
				Vat = $( "input[name='Vat']" ).val(), 
				VatAmount = $( "input[name='VatAmount']" ).val(), 
				TotalAmount = $( "input[name='TotalAmount']" ).val(), 
				PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
				driversignature = $( "input[name='driversignature']" ).val(), 
				 
				url = EditInBound.attr( "action" ); 
				 
				if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }   
				
				if(TicketNo !=""  && CompanyID !=""  && CompanyID !=undefined   && OpportunityID !="" && CompanyID !=0 && OpportunityID !=0 && OpportunityID !=undefined  && 
					DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined && GrossWeight >0  ){ 

				// Send the data using post
				var posting = $.post( url, {  TicketNo: TicketNo, LoadID: LoadID,Conveyance: Conveyance, WIFNumber: WIFNumber,is_tml: is_tml,CompanyID: CompanyID,
				OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial,ticket_notes: ticket_notes,
				LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,
				Net: Net, MaterialPrice: MaterialPrice, PaymentType: PaymentType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount, 
				PaymentRefNo: PaymentRefNo ,driversignature: driversignature } ); 
					$('#overlay').fadeIn();
					posting.done(function( data ) {  
						$('#overlay').fadeOut(); 
						if(data=='SAME'){
						  alert("All Values are same as previous. Please update values to change. ");
						  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>All Values are same as previous. Please update values to change.</div>');
						}else if(data.length > 20){
						  //alert("INBOUND TICKET updated successfully.");  
						  printPDF(data); 
						  //$('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> IN TICKET updated successfully.</div>');  
						  //window.location.href = baseURL+"Inbound-Tickets"; 
						}   
					}); 
				}else{
					alert(" Company | Opportunity | Material | Lorry Information Must not be Blank. Please check and Try Again ")
					//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				}  
		}
		
	});


///######################### Edit InCompleted Ticket #########################################

	
	var EditInCompleted = $("#EditInCompleted");
	
	var validator = EditInCompleted.validate({
		
		rules:{ 
			OpportunityID: { required: true } , 
			LorryNo: { required:  true } ,
			TicketDate: { required:  true } ,
			CompanyID: { required:  true } ,
			DescriptionofMaterial: { required:  true } ,
			VechicleRegNo :{ required : true },
			SicCode :{ required : true },
			DriverName :{ required : true },
			GrossWeight : {maxlength: 5, greaterThan: '#Tare', notEqual: '0' },
			Amount :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 0){ return true }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},messages: { 
			GrossWeight: {
				required: "This Field is Required",               
				number:"Please enter numbers only",
				notEqual:"Amount can not be zero"
			}
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} ,
		submitHandler: function(form){ 
				// Stop form from submitting normally
				event.preventDefault();   
				WIFNumber = $( "input[name='WIFNumber']" ).val(),  
				TicketNo = $( "input[name='TicketNo']" ).val(),		
				TicketDate = $( "input[name='TicketDate']" ).val(),		
				Conveyance = $( "input[name='Conveyance']" ).val(), 
				LoadID = $( "input[name='LoadID']" ).val(), 
				CompanyID = $( "#CompanyID" ).val(),
				OpportunityID = $( "#OpportunityID" ).val(),
				SiteAddress = $( "input[name='SiteAddress']" ).val(),
				HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
				DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
				SicCode = $( "input[name='SicCode']" ).val(),
				ticket_notes = $( "textarea[name='ticket_notes']" ).val(),
				LorryNo = $( "#LorryNo" ).val(),
				VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
				driverid = $( "input[name='driverid']" ).val(),
				DriverName = $( "input[name='DriverName']" ).val(),
				GrossWeight = $( "input[name='GrossWeight']" ).val(),
				Tare = $( "input[name='Tare']" ).val(),
				Net = $( "input[name='Net']" ).val(), 
				MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 
				TicketDate = $( "input[name='TicketNo']" ).val(),
				PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
				Amount = $( "input[name='Amount']" ).val(), 
				Vat = $( "input[name='Vat']" ).val(), 
				VatAmount = $( "input[name='VatAmount']" ).val(), 
				TotalAmount = $( "input[name='TotalAmount']" ).val(), 
				PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
				driversignature = $( "input[name='driversignature']" ).val(), 
				 
				url = EditInCompleted.attr( "action" );  
				if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }   
				
				if(TicketNo !=""  && CompanyID !=""  && CompanyID !=undefined   && OpportunityID !="" && CompanyID !=0 && OpportunityID !=0 && OpportunityID !=undefined  && 
					DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined && GrossWeight >0  ){ 

				// Send the data using post
				var posting = $.post( url, {  TicketNo: TicketNo,TicketDate: TicketDate, Conveyance: Conveyance,LoadID: LoadID, WIFNumber: WIFNumber,is_tml: is_tml,CompanyID: CompanyID,
				OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial,ticket_notes: ticket_notes,
				LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,
				Net: Net, MaterialPrice: MaterialPrice, PaymentType: PaymentType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount, 
				PaymentRefNo: PaymentRefNo ,driversignature: driversignature } ); 
					$('#overlay').fadeIn();
					posting.done(function( data ) {   
						$('#overlay').fadeOut(); 
						if(data=='SAME'){
						  alert("All Values are same as previous. Please update values to change. ");
						  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>All Values are same as previous. Please update values to change.</div>');
						}else if(data.length > 20){
						  //alert("InCompleted TICKET updated successfully.");  
						  printPDF(data); 
						  //$('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> IN TICKET updated successfully.</div>');  
						  //window.setTimeout(function () { window.location.href = baseURL+"Incompleted-Tickets";  }, 6000 ); 
						  //window.location.href = baseURL+"Incompleted-Tickets"; 
						}   
					}); 
				}else{
					alert(" Company | Opportunity | Material | Lorry Information Must not be Blank. Please check and Try Again ")
					//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				}  
		}
		
	});

///######################### Edit Out Ticket #########################################


	var EditOutTicket = $("#EditOutTicket");
	console.log(EditOutTicket)	;
	
	var validator = EditOutTicket.validate({
		
		rules:{ 
			OpportunityID: { required:  true } ,
			LorryNo: { required:  true } ,
			CompanyID: { required:  true } ,
			DescriptionofMaterial: { required:  true } ,
			VechicleRegNo :{ required : true },
			TicketDate: { required:  true } ,
			DriverName :{ required : true },
			GrossWeight : {maxlength: 5,  greaterThan: '#Tare', notEqual: '0' },
			Amount :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 0){ return true }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},messages: { 
			GrossWeight: {
				required: "This Field is Required",               
				number:"Please enter numbers only",
				notEqual:"Amount can not be zero"
			}
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		}, 
		submitHandler: function(form){  
			event.preventDefault();   
			TicketNo = $( "input[name='TicketNo']" ).val(),	
			TicketDate = $( "input[name='TicketNo']" ).val(),
			Conveyance = $( "input[name='Conveyance']" ).val(), 
			CompanyID = $( "#CompanyID" ).val(),
			OpportunityID = $( "#OpportunityID" ).val(),
			SiteAddress = $( "input[name='SiteAddress']" ).val(), 
			DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),  
			LorryNo = $( "#LorryNo" ).val(),
			VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
			driverid = $( "input[name='driverid']" ).val(),
			DriverName = $( "input[name='DriverName']" ).val(),
			HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
			GrossWeight = $( "input[name='GrossWeight']" ).val(),
			Tare = $( "input[name='Tare']" ).val(),
			Net = $( "input[name='Net']" ).val(), 
			MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 
			SicCode = $( "input[name='SicCode']" ).val(),
			is_hold = $( "input[name='is_hold']" ).val(),
			LoadID = $( "input[name='LoadID']" ).val(),
			
			OrderNo = $( "input[name='OrderNo']" ).val(), 
			
			PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
			LorryType = $( "input[name='LorryType']:checked" ).val(), 
			Amount = $( "input[name='Amount']" ).val(), 
			Vat = $( "input[name='Vat']" ).val(), 
			VatAmount = $( "input[name='VatAmount']" ).val(), 
			TotalAmount = $( "input[name='TotalAmount']" ).val(), 
			PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
			driversignature = $( "input[name='driversignature']" ).val(), 
			TicketDate = $( "input[name='TicketDate']" ).val(),
		
			url = EditOutTicket.attr( "action" ); 
			 
			if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
				  
			if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined   && CompanyID !=0 && OpportunityID !=0 && 
				DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && GrossWeight > 0  ){ 
				 
				var posting = $.post( url, { TicketNo: TicketNo,Conveyance: Conveyance,is_tml: is_tml,CompanyID: CompanyID,
				OpportunityID: OpportunityID,SiteAddress: SiteAddress,DescriptionofMaterial: DescriptionofMaterial, 
				LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,HaullerRegNo: HaullerRegNo,GrossWeight: GrossWeight,Tare: Tare, 
				Net: Net, MaterialPrice: MaterialPrice, SicCode: SicCode, OrderNo: OrderNo,
				PaymentType: PaymentType,LorryType: LorryType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo,driversignature: driversignature , TicketDate: TicketDate } );
				 
						$('#overlay').fadeIn();
						posting.done(function( data ) {  
						$('#overlay').fadeOut(); 
						if(data=='SAME'){
						  alert("All Values are same as previous. Please update values to change. ");
						  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>All Values are same as previous. Please update values to change.</div>');
						}else if(data.length > 20){
						  //alert("OUT TICKET updated successfully.");  
							//if(is_hold==1){ 
							//		window.history.back()
							//}else{	 
								if(LoadID =='0' || LoadID ==''){
									printPDF(data);  
								}
								$('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> OUT TICKET updated successfully.</div>');  
							//}	
						}   
					}); 
				}else{
					alert(" Company | Opportunity | Material | Lorry Information Must not be Blank. Please check and Try Again ")
					 window.history.back()
					//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				} 
			} 
		
	});

///######################### Edit Collection Ticket #########################################
	
	var EditCollectionTicket = $("#EditCollectionTicket");
	
	var validator = EditCollectionTicket.validate({
		
		rules:{ 
			OpportunityID: { required:  true } ,
			LorryNo: { required:  true } ,
			CompanyID: { required:  true } ,
			DescriptionofMaterial: { required:  true } ,
			VechicleRegNo :{ required : true },
			SicCode :{ required : true },
			DriverName :{ required : true },
			GrossWeight : {maxlength: 5,  greaterThan: '#Tare', notEqual: '0' },
			Amount :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 0){ return true }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},messages: { 
			GrossWeight: {
				required: "This Field is Required",               
				number:"Please enter numbers only",
				notEqual:"Amount can not be zero"
			}
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} ,
		submitHandler: function(form){ 
				 
				 event.preventDefault();   
					TicketNo = $( "input[name='TicketNo']" ).val(),	
					Conveyance = $( "input[name='Conveyance']" ).val(), 
					CompanyID = $( "#CompanyID" ).val(),
					OpportunityID = $( "#OpportunityID" ).val(),
					SiteAddress = $( "input[name='SiteAddress']" ).val(),
					HaullerRegNo = $( "input[name='HaullerRegNo']" ).val(),
					DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
					SicCode = $( "input[name='SicCode']" ).val(), 
					LorryNo = $( "#LorryNo" ).val(),
					VechicleRegNo = $( "input[name='VechicleRegNo']" ).val(),
					DriverName = $( "input[name='DriverName']" ).val(),
					driverid = $( "input[name='driverid']" ).val(),
					GrossWeight = $( "input[name='GrossWeight']" ).val(),
					Tare = $( "input[name='Tare']" ).val(),
					Net = $( "input[name='Net']" ).val(),

					MaterialPrice = $( "input[name='MaterialPrice']" ).val(), 

					OrderNo = $( "input[name='OrderNo']" ).val(), 
					
					PaymentType = $( "input[name='PaymentType']:checked" ).val(), 
					LorryType = $( "input[name='LorryType']:checked" ).val(), 
					Amount = $( "input[name='Amount']" ).val(), 
					Vat = $( "input[name='Vat']" ).val(), 
					VatAmount = $( "input[name='VatAmount']" ).val(), 
					TotalAmount = $( "input[name='TotalAmount']" ).val(), 
					PaymentRefNo = $( "input[name='PaymentRefNo']" ).val(), 
					driversignature = $( "input[name='driversignature']" ).val(), 
					
					url = EditCollectionTicket.attr( "action" ); 

				//if($( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  } 
				
				if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined   && CompanyID !=0 && OpportunityID !=0 && 
				DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && GrossWeight > 0 ){ 
				
				  // Send the data using post
					var posting = $.post( url, {  TicketNo: TicketNo, Conveyance: Conveyance, CompanyID: CompanyID,
					OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial, 
					LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,OrderNo: OrderNo,
					Net: Net, MaterialPrice: MaterialPrice,  PaymentType: PaymentType,LorryType: LorryType,Amount: Amount,Vat: Vat,VatAmount: VatAmount, 
					TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo ,driversignature: driversignature  } );
					  
						$('#overlay').fadeIn();
						posting.done(function( data ) {  
							$('#overlay').fadeOut(); 
							if(data=='SAME'){
							  alert("All Values are same as previous. Please update values to change. ");
							  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>All Values are same as previous. Please update values to change.</div>');
							}else if(data.length > 20){
							  //alert("Collection TICKET updated successfully."); 
							  printPDF(data); 
							  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Collection TICKET updated successfully.</div>');  
							}   
						}); 
				}else{
					alert(" Company | Opportunity | Material | Lorry Information Must not be Blank. Please check and Try Again ")
					//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
				} 
		}
		
	});
	
///###############################################################################

	
	var editInTicketSubmit = $("#editInTicketSubmit");
	
	var validator = editInTicketSubmit.validate({
		
		rules:{ 
			VechicleRegNo :{ required : true },
			SicCode :{ required : true },
			DriverName :{ required : true },
			GrossWeight : {maxlength: 5, greaterThan: '#Tare'},
			Amount :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 0){ return true }else{ return false; }
            } },
			PaymentRefNo :{  required: function () {  
                if($("input[name='PaymentType']:checked").val() > 1){ return true }else{ return false; }
            } },		
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "CompanyID" || element.attr("name") == "OpportunityID" || element.attr("name") == "DescriptionofMaterial" 
			 || element.attr("name") == "LorryNo" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} 
		
	});

 
    var DescriptionofMaterial = $("#DescriptionofMaterial");
    DescriptionofMaterial.on('change',function(){
    var id=$(this).val();
    if(id!=''){
	       $.ajax({
		       url: baseURL+"getMaterialListDetails",
		       type: "POST",
		       data:  {id:id},
		       
			   success: function(data)
			     { //alert(data);
			     	var obj = jQuery.parseJSON(data);
                    $('#SicCode').val( obj.SicCode );
                    $('#MaterialPrice').val( obj.price );
                    
			     	//$('#SicCode').val(data);
			    },
			     error: function(e) 
			      {
			        $("#err").html(e).fadeIn();
			      }          
		    });
        }else{
        	$('#SicCode').val('');
        	$('#MaterialPrice').val('');
        }
    });
    
    var LorryNo = $("#LorryNo");
    LorryNo.on('change',function(){
		var id=$(this).val();   
		if(id.length>0){
			if(id==0){ 
					$('#VechicleRegNo').removeAttr('readonly', false);
					//$('#DriverName').removeAttr('readonly', false);
					//$('#Tare').removeAttr('readonly', false);
					$('#HaullerRegNo').removeAttr('readonly', false);
					$('#VechicleRegNo').val('');
					$('#DriverName').val('');
					$('#Tare').val('');  
					$('#HaullerRegNo').val('');   
					$('#driversignature').val('');  
					$('#driverimage').html('');  
					$('#Net').val('');  // Nilay 			
					
			}else{ 
					$("#RegDup").html('');   
					$('#VechicleRegNo').attr('readonly', true);
					//$('#DriverName').attr('readonly', true);
					//$('#Tare').attr('readonly', true);
					$('#HaullerRegNo').attr('readonly', true);
					 
					var TicketType=$('#TicketType').val();
					$.ajax({
					   url: baseURL+"getLorryNoDetails",
					   type: "POST",
					   data:  {id:id},
					   
					   success: function(data)
						 { 
							var obj = jQuery.parseJSON(data);
							$('#VechicleRegNo').val( obj.RegNumber );
							$('#DriverName').val( obj.DriverName );
							$('#driverid').val( obj.LorryNo );
							$('#HaullerRegNo').val( obj.Haulier );
							$('#driversignature').val( obj.ltsignature );
							if(obj.ltsignature!=""){
								$('#driverimage').html('<img src="'+obj.ltsignature+'" height="400px" width="700px">');  
							}else{
								$('#driverimage').html('');   
							}
							$('#Tare').val( obj.Tare );    
							if(TicketType=='Out'){
								$('#HaullerRegNo').val( obj.Haulier );
							}
							$('#GrossWeight').trigger("change");
						},
						 error: function(e) 
						  {
							$("#err").html(e).fadeIn();
						  }          
					}); 
			}
		}else{
				$('#VechicleRegNo').attr('readonly', true);
				//$('#DriverName').attr('readonly', true);
				//$('#Tare').attr('readonly', true);	
				$('#VechicleRegNo').val('');
				$('#DriverName').val('');
				$('#HaullerRegNo').val('');  
				$('#driversignature').val('');  
				$('#driverimage').html('');  
				$('#Tare').val('');  
				$('#Net').val('');  // Nilay 	 
		}	
			
    });

	$("#Tare").change(function(){
		$('#GrossWeight').trigger("change");
	});

	$("#GrossWeight").change(function(){ 
	     
		var GrossWeight = parseInt($(this).val());
		var Tare = parseInt($('#Tare').val());
		//$('#GrossWeight').val( GrossWeight );
		
		if( GrossWeight > Tare){	
			var net =  GrossWeight - Tare;
			$('#Net').val( net );
		}else{ 
			$('#Net').val( '' );  
		}
	}); 

    $("#TicketGap").on('focusout',function(){ 
	
		var id=$(this).val();   
		var tno = $('#TicketNumber').val();	 
		if(id!=''){     
			jQuery.ajax({
				type : "POST",
				dataType : "json",
				url: baseURL+"CheckDuplicateTicket",
				data : { 'id' : id, 'tno' : tno }  
				}).done(function(data){   
					console.log(data);               
					if(data.status==false){	  
						$("#dup").html("Already in Use");   
					}else{ 	   
						$("#dup").html(data);   
					} 
			}); 
		}
    });

    $("#TypeOfTicket").on('change',function(){ 
	
		var id=$(this).val();    
		if(id!=''){    
			if(id=="In"){ 
				$( "#hide2" ).show();  
			}else{ 
				$( "#hide2" ).hide();  
			}		
			
			jQuery.ajax({
				type : "POST",
				dataType : "json",
				url: baseURL+"LoadMaterials",
				data : { id : id } 
				}).done(function(data){  
					console.log(data);               
					if(data.status==false){	 
						var options = ' <option value="">Select Material Type</option>';
						$("select.select_material").html(options); 
						$('#SicCode').val(''); 
					}else{ 	 
						var options = '<option value="">Select Material Type</option>';
						for (var i = 0; i < data.material_list.length; i++) {
							options += '<option value="' + data.material_list[i].MaterialID + '">' + data.material_list[i].MaterialName + '</option>';
						} 
						$("select.select_material").html(options);  
						$('#DescriptionofMaterial').selectpicker('refresh');  
						$('#SicCode').val(''); 
					} 
			}); 
		}
    });


    $("#CompanyID").on('change',function(){ 
	
		var id=$(this).val();  
		if(id!=0){  
		jQuery.ajax({
			type : "POST",
			dataType : "json",
			url: baseURL+"loadAllOpportunitiesByCompany",
			data : { id : id } 
			}).done(function(data){ 
				console.log(data);      
				if(data.status==false){	 
					var options = ' <option value="0">ADD OPPORTUNITY</option>';
					$("select.select_opportunity").html(options); 

					$('#Street1').val(''); 
					$('#SiteAddress').val(''); 
					$('#Town').attr('readonly', false);	
					$('#Town').val('');
					$('#PostCode').attr('readonly', false);	
					$('#PostCode').val('');
					$('#County').attr('readonly', false); 	

				}else{ 	  
					var options = '<option value="0">ADD OPPORTUNITY</option>';
					for (var i = 0; i < data.Opportunity_list.length; i++) {
						options += '<option value="' + data.Opportunity_list[i].OpportunityID + '">' + data.Opportunity_list[i].OpportunityName + '</option>';
					} 
					$("select.select_opportunity").html(options);  
					$('#OpportunityID').selectpicker('refresh');   
					
					$('#SiteAddress').val(''); 
					$('#CompanyName').attr('readonly', true);	
					$('#CompanyName').val(''); 
					$('#Street1').attr('readonly', false);	
					$('#Street1').val(''); 
					$('#Town').attr('readonly', false);	
					$('#Town').val('');
					$('#PostCode').attr('readonly', false);	
					$('#PostCode').val('');
					$('#County').attr('readonly', false); 	
				} 
			}); 
		}else if(id==0) {  
			var options = ' <option value="0">-- ADD OPPORTUNITY --</option>';
			$("select.select_opportunity").html(options); 
			$('#OpportunityID').selectpicker('refresh');   
			$('#CompanyName').attr('readonly', false);	
			$('#CompanyName').val('');
			$('#SiteAddress').val(''); 
			$('#Street1').attr('readonly', false);	
			$('#Street1').val(''); 
			$('#Town').attr('readonly', false);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', false);	
			$('#PostCode').val('');
			$('#County').attr('readonly', false); 			
		}
    });
	
 
    $(".select_wif").on('change',function(){ 
		
    var id=$(this).val();
		if(id!=''){
			$.ajax({
		       url: baseURL+"GetWIFNumber",
		       type: "POST",
		       data:  {id:id}, 
			   success: function(data){ 
					//alert(data);
			     	var obj = jQuery.parseJSON(data);
                    $('#WIFNumber').val( obj.DocumentNumber );  
			    },
			     error: function(e) 
			      {
			        $("#err").html(e).fadeIn();
			      }          
		    });
        }else{
        	$('#WIFNumber').val(''); 
        }
    });
	
   
   $("#OpportunityID").on('change',function(){
		var address = $("#OpportunityID option:selected").text();
		$('#SiteAddress').val( address );
		
		var id=$(this).val();    
		if(id=="0") { 
			$('#Street1').attr('readonly', false);	
			$('#Street1').val(''); 
			$('#Town').attr('readonly', false);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', false);	
			$('#PostCode').val('');
			$('#County').attr('readonly', false); 			
		}else{
			$('#Street1').attr('readonly', true);	
			$('#Street1').val(''); 
			$('#Town').attr('readonly', true);	
			$('#Town').val('');
			$('#PostCode').attr('readonly', true);	
			$('#PostCode').val('');
			$('#County').attr('readonly', true); 			
		}
		
   });


 
	  jQuery(document).on("click", ".cls-genrate-ticket", function(){

	   alert(baseURL);
		var TicketNo = $(this).attr("data-TicketNo"), 
		    TicketUniqueID = $(this).attr("data-TicketUniqueID"),	   
            
			hitURL = baseURL + "genrateBarcode",
			currentRow = $(this);
			
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { 'TicketNo' : TicketNo, 'TicketUniqueID' : TicketUniqueID } 
			}).done(function(data){
				
				alert(data);

			});
		
	});


jQuery( "#addOfficeTicketsSubmit1" ).submit(function( event ) {

	// Stop form from submitting normally
	event.preventDefault(); 

	// Get some values from elements on the page:
	  var $form = $( this ),
		TicketNumber = $form.find( "input[name='TicketNumber']" ).val(),
		TicketGap = $form.find( "input[name='TicketGap']" ).val(),
		WIFNumber = $form.find( "input[name='WIFNumber']" ).val(), 
		TypeOfTicket = $form.find( "#TypeOfTicket" ).val(), 
		Conveyance = $form.find( "input[name='Conveyance']" ).val(), 
		CompanyID = $( "#CompanyID" ).val(),
		OpportunityID = $( "#OpportunityID" ).val(),
		SiteAddress = $form.find( "input[name='SiteAddress']" ).val(),
		HaullerRegNo = $form.find( "input[name='HaullerRegNo']" ).val(),
		DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
		SicCode = $form.find( "input[name='SicCode']" ).val(),
		ticket_notes = $form.find( "textarea[name='ticket_notes']" ).val(),
		LorryNo = $( "#LorryNo" ).val(),
		VechicleRegNo = $form.find( "input[name='VechicleRegNo']" ).val(),
		driverid = $form.find( "input[name='driverid']" ).val(),
		DriverName = $form.find( "input[name='DriverName']" ).val(),
		GrossWeight = $form.find( "input[name='GrossWeight']" ).val(),
		Tare = $form.find( "input[name='Tare']" ).val(),
		Net = $form.find( "input[name='Net']" ).val(),
		 
		MaterialPrice = $form.find( "input[name='MaterialPrice']" ).val(), 
		
		PaymentType = $form.find( "input[name='PaymentType']:checked" ).val(), 
		Amount = $form.find( "input[name='Amount']" ).val(), 
		Vat = $form.find( "input[name='Vat']" ).val(), 
		VatAmount = $form.find( "input[name='VatAmount']" ).val(), 
		TotalAmount = $form.find( "input[name='TotalAmount']" ).val(), 
		PaymentRefNo = $form.find( "input[name='PaymentRefNo']" ).val(), 
		driversignature = $form.find( "input[name='driversignature']" ).val(), 
 
	 		
		url = $form.attr( "action" ); 
		if($form.find( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
		var btn= $(this).find("input[type=submit]:focus").val();
		if(btn == 'HOLD'){ var is_hold = 1; }else{  var is_hold = 0;  } 
	if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined  && 
	DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && 
	TypeOfTicket !="" && TypeOfTicket !=undefined  && TicketGap !="" && TicketGap !=undefined  && GrossWeight > 0  ){ 	
	
	  // Send the data using post
		var posting = $.post( url, { TicketNumber: TicketNumber,TicketGap: TicketGap,WIFNumber: WIFNumber,TypeOfTicket: TypeOfTicket, Conveyance: Conveyance,is_tml: is_tml,CompanyID: CompanyID,
		OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial,ticket_notes: ticket_notes,
		LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,
		Net: Net, MaterialPrice: MaterialPrice,is_hold: is_hold,
		PaymentType: PaymentType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo ,driversignature: driversignature } );
		 
			$('#overlay').fadeIn();
			posting.done(function( data ) { 
//alert(data)			
			//$('#result').html(data); 
				$('#overlay').fadeOut();
				$('#VechicleRegNo').attr('disabled', 'disabled');
				$('#DriverName').attr('disabled', 'disabled');
				//$('#Tare').attr('disabled', 'disabled');	
				$('#VechicleRegNo').val('');
				$('#DriverName').val('');
				$('#Tare').val('');  
				$('#Net').val('');  
				
			  if(data=='Error'){
				  alert("Error In  Submitting Data, Please contact Administrator.");
				  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>');
				  $("#addTicketsSubmit")[0].reset();
				  $("#driversignature").val('');				  
				  $('#driverimage').html('');  
			  }else{
					
				if(data.length > 20){	
			
				  alert("New Office (GAP) TICKET created successfully.");
				  //window.open(data, '_blank');   
				  printPDF(data); 
				  $("#addOfficeTicketsSubmit")[0].reset();  								  
				  $("#driversignature").val('');				  
				  $('#driverimage').html('');  
				  $("div.pblock").hide();
				  $('#OpportunityID').selectpicker('refresh');  
				  $('#CompanyID').selectpicker('refresh');  
				  $('#DescriptionofMaterial').selectpicker('refresh');  
				  $('#LorryNo').selectpicker('refresh');  
				  $('#OpportunityID').selectpicker('refresh');  
				  
				  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New Office (GAP) TICKET created successfully.</div>'); 
				}else{ return false; }   
			  }   
			}); 
			
		}else{
			$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
		} 
});  

 
jQuery( "#addTicketsSubmit1" ).submit(function( event ) {

	// Stop form from submitting normally
	event.preventDefault(); 

	// Get some values from elements on the page:
	  var $form = $( this ), 
		WIFNumber = $form.find( "input[name='WIFNumber']" ).val(), 
		Conveyance = $form.find( "input[name='Conveyance']" ).val(), 
		CompanyID = $( "#CompanyID" ).val(),
		OpportunityID = $( "#OpportunityID" ).val(),
		SiteAddress = $form.find( "input[name='SiteAddress']" ).val(),
		HaullerRegNo = $form.find( "input[name='HaullerRegNo']" ).val(),
		DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
		SicCode = $form.find( "input[name='SicCode']" ).val(),
		ticket_notes = $form.find( "textarea[name='ticket_notes']" ).val(),
		LorryNo = $( "#LorryNo" ).val(),
		VechicleRegNo = $form.find( "input[name='VechicleRegNo']" ).val(),
		driverid = $form.find( "input[name='driverid']" ).val(),
		DriverName = $form.find( "input[name='DriverName']" ).val(),
		GrossWeight = $form.find( "input[name='GrossWeight']" ).val(),
		Tare = $form.find( "input[name='Tare']" ).val(),
		Net = $form.find( "input[name='Net']" ).val(), 
		MaterialPrice = $form.find( "input[name='MaterialPrice']" ).val(), 
		
		PaymentType = $form.find( "input[name='PaymentType']:checked" ).val(), 
		Amount = $form.find( "input[name='Amount']" ).val(), 
		Vat = $form.find( "input[name='Vat']" ).val(), 
		VatAmount = $form.find( "input[name='VatAmount']" ).val(), 
		TotalAmount = $form.find( "input[name='TotalAmount']" ).val(), 
		PaymentRefNo = $form.find( "input[name='PaymentRefNo']" ).val(), 
		driversignature = $form.find( "input[name='driversignature']" ).val(), 
		
		url = $form.attr( "action" ); 
		if($form.find( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
		var btn= $(this).find("input[type=submit]:focus").val();
		if(btn == 'HOLD'){ var is_hold = 1; }else{  var is_hold = 0;  } 
 

	if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined  && 
	DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && GrossWeight > 0  ){ 

	  // Send the data using post
		var posting = $.post( url, {  Conveyance: Conveyance, WIFNumber: WIFNumber,is_tml: is_tml,CompanyID: CompanyID,
		OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial,ticket_notes: ticket_notes,
		LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,
		Net: Net, MaterialPrice: MaterialPrice,is_hold: is_hold,	
		PaymentType: PaymentType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo ,driversignature: driversignature } );
		  
		 $('#overlay').fadeIn();
			posting.done(function( data ) {   
			//$('#result').html(data); 
				$('#overlay').fadeOut();
				$('#CompanyID').selectpicker('refresh'); 
				$('#OpportunityID').selectpicker('refresh'); 
				$('#DescriptionofMaterial').selectpicker('refresh'); 
				$('#LorryNo').selectpicker('refresh'); 
				$('#VechicleRegNo').attr('disabled', 'disabled');
				$('#DriverName').attr('disabled', 'disabled');
				//$('#Tare').attr('disabled', 'disabled');	
				$('#VechicleRegNo').val('');
				$('#DriverName').val('');
				$('#Tare').val('');  
				$('#Net').val('');  
				
			  if(data=='Error'){
				  alert("Error In  Submitting Data, Please contact Administrator.");
				  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>');
				  $("#addTicketsSubmit")[0].reset();
				  $("#driversignature").val('');				  
				  $('#driverimage').html('');  
			  }else{
				  if(data=='HOLD'){
					  alert("Hold IN TICKET created successfully."); 
					  $("#addTicketsSubmit")[0].reset(); 				   					  
					  $("#driversignature").val('');				  
					  $('#driverimage').html('');  
					  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Hold IN TICKET created successfully.</div>'); 
				  }else{ 			
						if(data.length > 20){	
						  alert("New IN TICKET created successfully.");
						  //window.open(data, '_blank');   
						  printPDF(data); 
						  $("#addTicketsSubmit")[0].reset();  								  
						  $("#driversignature").val('');				  
						  $('#driverimage').html('');  
						  $("div.pblock").hide();
						  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New IN TICKET created successfully.</div>'); 
						}else{ return false; }  
				  }
			  }   
			}); 
		}else{
			//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
		} 
});  

jQuery( "#outTicketssubmit1" ).submit(function( event ) {
	
	// Stop form from submitting normally
	event.preventDefault(); 
	// Get some values from elements on the page:
	  var $form = $( this ), 
		Conveyance = $form.find( "input[name='Conveyance']" ).val(), 
		CompanyID = $( "#CompanyID" ).val(),
		OpportunityID = $( "#OpportunityID" ).val(),
		SiteAddress = $form.find( "input[name='SiteAddress']" ).val(), 
		DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),  
		LorryNo = $( "#LorryNo" ).val(),
		VechicleRegNo = $form.find( "input[name='VechicleRegNo']" ).val(),
		driverid = $form.find( "input[name='driverid']" ).val(),
		DriverName = $form.find( "input[name='DriverName']" ).val(),
		HaullerRegNo = $form.find( "input[name='HaullerRegNo']" ).val(),
		GrossWeight = $form.find( "input[name='GrossWeight']" ).val(),
		Tare = $form.find( "input[name='Tare']" ).val(),
		Net = $form.find( "input[name='Net']" ).val(), 
		MaterialPrice = $form.find( "input[name='MaterialPrice']" ).val(), 
		SicCode = $form.find( "input[name='SicCode']" ).val(),
		
		PaymentType = $form.find( "input[name='PaymentType']:checked" ).val(), 
		Amount = $form.find( "input[name='Amount']" ).val(), 
		Vat = $form.find( "input[name='Vat']" ).val(), 
		VatAmount = $form.find( "input[name='VatAmount']" ).val(), 
		TotalAmount = $form.find( "input[name='TotalAmount']" ).val(), 
		PaymentRefNo = $form.find( "input[name='PaymentRefNo']" ).val(), 
		driversignature = $form.find( "input[name='driversignature']" ).val(), 
		url = $form.attr( "action" ); 
		if($form.find( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
		var btn= $(this).find("input[type=submit]:focus").val();
		if(btn == 'HOLD'){ var is_hold = 1; }else{  var is_hold = 0;  } 

if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined  && 
	DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && GrossWeight > 0 ){ 
		
	  // Send the data using post
		var posting = $.post( url, {  Conveyance: Conveyance,is_tml: is_tml,CompanyID: CompanyID,
		OpportunityID: OpportunityID,SiteAddress: SiteAddress,DescriptionofMaterial: DescriptionofMaterial, 
		LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,HaullerRegNo: HaullerRegNo,GrossWeight: GrossWeight,Tare: Tare, 
		Net: Net, MaterialPrice: MaterialPrice,is_hold: is_hold ,SicCode: SicCode,
		PaymentType: PaymentType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo,driversignature: driversignature  } );
		 
		$('#overlay').fadeIn();
			posting.done(function( data ) {  
			$('#overlay').fadeOut();
			//$('#result').html(data); 
			  if(data=='Error'){
				  alert("Error In  Submitting Data, Please contact Administrator.");
				  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>');
				  $("#outTicketssubmit")[0].reset(); 
				   $("#driversignature").val('');				  
				  $('#driverimage').html('');  
			  }else{
				  if(data=='HOLD'){
					  alert("Hold OUT TICKET  created successfully."); 
					  $("#outTicketssubmit")[0].reset(); 				   
					  $("#driversignature").val('');				  
					  $('#driverimage').html('');  
					  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Hold OUT TICKET  created successfully.</div>'); 
				  }else{ 							
					  alert("New OUT TICKET created successfully."); 
					  printPDF(data);
					  $("#outTicketssubmit")[0].reset(); 
					  $("#driversignature").val('');				  
					  $('#driverimage').html('');  
					  $("div.pblock").hide();
					  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> New OUT TICKET  created successfully.</div>'); 
					   //window.open(data, '_blank');   
					    
				  }
			  }   
			}); 
		}else{
			//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
		} 
});

jQuery( "#collectionTicketssubmit1" ).submit(function( event ) { 
	
 	// Stop form from submitting normally
	 event.preventDefault(); 
	// Get some values from elements on the page:
	  var $form = $( this ), 
		Conveyance = $form.find( "input[name='Conveyance']" ).val(), 
		CompanyID = $( "#CompanyID" ).val(),
		OpportunityID = $( "#OpportunityID" ).val(),
		SiteAddress = $form.find( "input[name='SiteAddress']" ).val(),
		HaullerRegNo = $form.find( "input[name='HaullerRegNo']" ).val(),
		DescriptionofMaterial = $( "#DescriptionofMaterial" ).val(),
		SicCode = $form.find( "input[name='SicCode']" ).val(), 
		LorryNo = $( "#LorryNo" ).val(),
		VechicleRegNo = $form.find( "input[name='VechicleRegNo']" ).val(),
		DriverName = $form.find( "input[name='DriverName']" ).val(),
		driverid = $form.find( "input[name='driverid']" ).val(),
		GrossWeight = $form.find( "input[name='GrossWeight']" ).val(),
		Tare = $form.find( "input[name='Tare']" ).val(),
		Net = $form.find( "input[name='Net']" ).val(),
		 
		MaterialPrice = $form.find( "input[name='MaterialPrice']" ).val(), 
		
		PaymentType = $form.find( "input[name='PaymentType']:checked" ).val(), 
		Amount = $form.find( "input[name='Amount']" ).val(), 
		Vat = $form.find( "input[name='Vat']" ).val(), 
		VatAmount = $form.find( "input[name='VatAmount']" ).val(), 
		TotalAmount = $form.find( "input[name='TotalAmount']" ).val(), 
		PaymentRefNo = $form.find( "input[name='PaymentRefNo']" ).val(), 
		driversignature = $form.find( "input[name='driversignature']" ).val(), 
		
		url = $form.attr( "action" ); 

		if($form.find( "input[name='is_tml']" ).is(":checked")){ var is_tml = 1; }else{ var is_tml = 0;  }
		var btn= $(this).find("input[type=submit]:focus").val();
		if(btn == 'HOLD'){ var is_hold = 1; }else{  var is_hold = 0;  } 
	
	if(CompanyID !=""  && CompanyID !=undefined  && OpportunityID !="" && OpportunityID !=undefined  && 
	DescriptionofMaterial !="" &&DescriptionofMaterial !=undefined  && LorryNo !="" && LorryNo !=undefined  && GrossWeight > 0  ){ 
	
	  // Send the data using post
		var posting = $.post( url, { Conveyance: Conveyance,is_tml: is_tml,CompanyID: CompanyID,
		OpportunityID: OpportunityID,SiteAddress: SiteAddress,HaullerRegNo: HaullerRegNo,DescriptionofMaterial: DescriptionofMaterial, 
		LorryNo: LorryNo,VechicleRegNo: VechicleRegNo,DriverName: DriverName,driverid: driverid,GrossWeight: GrossWeight,Tare: Tare,SicCode: SicCode,
		Net: Net, MaterialPrice: MaterialPrice,is_hold: is_hold,
		PaymentType: PaymentType,Amount: Amount,Vat: Vat,VatAmount: VatAmount,TotalAmount: TotalAmount,PaymentRefNo: PaymentRefNo ,driversignature: driversignature  } );
		  
		$('#overlay').fadeIn();
			posting.done(function( data ) {   
			$('#overlay').fadeOut();
			  if(data=='Error'){
				  alert("Error In  Submitting Data, Please contact Administrator.");
				  $('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Error In  Submitting Data, Please contact Administrator.</div>');
				  $("#collectionTicketssubmit")[0].reset(); 
				  $("#driversignature").val('');				  
				  $('#driverimage').html('');  
			  }else{
				  if(data=='HOLD'){
					  alert("Hold COLLECTION TICKET created successfully."); 
					  $("#collectionTicketssubmit")[0].reset(); 				   
					  $("#driversignature").val('');				  
					  $('#driverimage').html('');  
					  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Hold COLLECTION TICKET created successfully.</div>'); 
				  }else{ 							
					  alert("New COLLECTION TICKET created successfully.");
					  //window.open(data, '_blank');   
					  printPDF(data); 
					  $("#collectionTicketssubmit")[0].reset(); 
					  $("#driversignature").val('');				  
					  $('#driverimage').html('');  
					  $("div.pblock").hide();
					  $('#result').html('<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>New COLLECTION TICKET created successfully.</div>'); 
				  }
			  }   
			}); 
		}else{
			//$('#result').html('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Madatory Fields Required. </div>');
		} 
});


    
});

function UpdateHoldCount(){  	  
	$.ajax({
	   url: baseURL+"GetHoldCount",
	   type: "POST",
	   data:  "", 
	   success: function(data){ 
			//alert(data);
			$('#holdtkt').html(data);  			
		}           
	}); 
}

	
function UpdateCompanyDD1(){  	  
	jQuery.ajax({
	type : "POST",
	dataType : "json",
	url: baseURL+"getCompanyList",
	data : ""
	}).done(function(data){ 
		//console.log(data);     
		
		if(data.status==false){	
			var options = ' <option value="0">-- ADD COMPANY dd--</option>';
			jQuery("select.select_company").html(options); 
		}else{ 	 
			var options = '<option value="0">ADD COMPANY dd </option>';
			for (var i = 0; i < 3; i++) {
				alert(data.company_list[i].CompanyName);
				options += '<option value="' + data.company_list[i].CompanyID + '">' + data.company_list[i].CompanyName + '</option>';
			} 
			jQuery("select.select_company").html(options);   
		} 
	});  
}

/*
//for delete update
jQuery(document).on("click", ".deleteTicket", function(){
		var TicketNo = $(this).attr("data-TicketNo"),
			hitURL = baseURL + "deleteNotes",
			currentRow = $(this);			
			//alert(hitURL);	
		var confirmation = prompt("Why do you want to delete?", "");

		//var confirmation = confirm("Are you sure to delete this record ?");
		//console.log(confirmation);
		if(confirmation!=null)
		{
			
			if(confirmation!="")
			{
				//console.log("Your comment:"+confirmation);
				//alert(confirmation);
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { 'TicketNo' : TicketNo,'confirmation' :confirmation } 
			}).success(function(data){
				//console.log(data);
				
				currentRow.parents('tr').remove();
				if(data.status != "") { alert("Record successfully deleted"); }
				else{ alert("Record deletion failed"); }
				
			});
			
		}
		}
	});
*/
 
function printPDF(htmlPage){   
	if(navigator.userAgent.indexOf("Firefox") != -1 ) {  
		var w = window.open(htmlPage); 
		window.setTimeout(function () { w.print(); }, 3000 );
	}else{
		printJS(htmlPage); 
	} 	
}  
  