<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>All Ticket List </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" /> 
	<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('assets/dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" /> 
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.css'); ?>">  
	<script src="<?php echo base_url('assets/js/jQuery-2.1.4.min.js'); ?>"></script> 
	<script type="text/javascript">var baseURL = "<?php echo base_url(); ?>";</script>
  </head>
  <body >
   
<section class="content-header"> <h1> <i class="fa fa-users"></i> <?php  //if($cInfo['CompanyName']){ echo $cInfo['CompanyName']." | "; } ?> All Ticket List </h1>    </section> 
<section class="content">   
 <input type="hidden" name="ACCREF" id="ACCREF" value="<?php echo $AccRef; ?>" >
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Tickets List</h3>
				</div> 
				<div class="box-body">
				  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
					  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
					  <thead>
						<tr> 
							<th width="10" align="right">T.No </th>                        
							<th width="50" align="right">Conveyance</th>                        
							<th width="100" >Date </th> 
							<th >Site Name</th> 
							<th width="30">Gross</th>
							<th width="30">Tare</th>
							<th width="30">Net</th>   
						</tr>
						</thead> 
					  </table> 
				  </div>
				</div>
				</div>
				</div> 
			</div> 
		</div>
	</div>
</section> 
<script type="text/javascript" language="javascript" >
	$(document).ready(function(){ 
		var AccRef = $('#AccRef').val();
		var dataTable = $('#ticket-grid').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 2, "desc" ]],
			"columns": [
				{ "data": "TicketNumber" ,"name": "TicketNumber", "data-sort": "TicketNumber_sort" },
				{ "data": "Conveyance" ,"name": "Conveyance", "data-sort": "Conveyance"  },
				{ "data": "TicketDate" ,"name": "TicketDate", "data-sort":"TicketDate1" }, 
				{ "data": "OpportunityName" , "name": "OpportunityName" },  
				{ "data": "GrossWeight" , "name": "GrossWeight" },
				{ "data": "Tare" , "name": "Tare" },
				{ "data": "Net" , "name": "Net" }, 
				//{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('CustomerTicketsAjax/'.$AccRef); ?>", // json datasource
				type: "POST",  // method  , by default get 
				error: function(e){  // error handling
					$(".ticket-grid-error").html("");
					$("#ticket-grid").append('<tbody class="ticket-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#ticket-grid_processing").css("display","none");							
				}//,
				//success: function (data) {  
				//   alert(JSON.stringify( data )); 
				//   console.log(data);
 				//} 
			}, 
			columnDefs: [{ data: null, targets: -1 }],   
			createdRow: function (row, data, dataIndex) {  
			var purl = baseURL+'assets/pdf_file/'+data["pdf_name"]; 
			var curl = baseURL+'assets/conveyance/'+data["ReceiptName"];
			var LoadID = data["LoadID"]; 
			var TypeOfTicket = data["TypeOfTicket"]; 
			
				$(row).find("td:eq(3)").html(data["OpportunityName"]); 
				if(TypeOfTicket=='Out'){ 
					if(LoadID!=0){ 
						$(row).find("td:eq(0)").html('<button class="btn btn-sm btn-warning" target="blank" onclick="PrintNow(\'' +curl+ '\')" title="Click Here to View PDF" alt="Click Here to View PDF" > '+data["TicketNumber"]+' </button>'); 
					}else{
						$(row).find("td:eq(0)").html('<button class="btn btn-sm btn-warning" target="blank" onclick="PrintNow(\'' +purl+ '\')" title="Click Here to View PDF" alt="Click Here to View PDF" > '+data["TicketNumber"]+' </button>'); 	
					}
				}else{
					$(row).find("td:eq(0)").html('<button class="btn btn-sm btn-warning" target="blank" onclick="PrintNow(\'' +purl+ '\')" title="Click Here to View PDF" alt="Click Here to View PDF" > '+data["TicketNumber"]+' </button>'); 
				}
				$(row).find('td:eq(0)').attr('data-sort', data['TicketNumber_sort']); 
				if(LoadID!=0){ 
					if(TypeOfTicket!='Out'){ 
						$(row).find("td:eq(1)").html('<button class="btn btn-sm btn-warning" target="blank" onclick="PrintNow(\'' +curl+ '\')" title="Click Here to View PDF" alt="Click Here to View PDF" > '+data["Conveyance"]+' </button>'); 
					}else{
						$(row).find("td:eq(1)").html(''); 
					}
				}
				$(row).find('td:eq(1)').attr('data-sort', data['Conveyance']);  
				$(row).find('td:eq(2)').attr('data-sort', data['TicketDate1']); 
				
			}
		} ); 
		 
	} );
	
	function PrintNow(htmlPage){     
			var w = window.open(htmlPage); 
			//w.print(false,0,0,true); 
			 //w.print(); 
	}  

</script>  
	<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>  
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
  </body>
</html>