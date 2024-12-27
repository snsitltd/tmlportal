<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"> 
      <h1>
        <i class="fa fa-users"></i> Opportunity Management
        <small><?php echo $opInfo['OpportunityName']; ?></small>
      </h1>
    </section>
     <section class="content"> 
		<h4> <b>Company Name: <a href="<?php echo base_url().'view-company/'.$opInfo['CompanyID']; ?>" ><?=$opInfo['CompanyName']?></a></b></h4>
        <div class="row"> 
        <div class="col-md-12">
          <div class="nav-tabs-custom"> 
            <div class="tab-content"> 
              <div class="tab-pane active" id="activity">  
			  <form id="OpportunityCompanysubmit" action="<?php echo base_url('edit-Opportunity-Company/'.$opInfo['OpportunityID']) ?>" method="post" role="form"  >
			  <?php 
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>                    
                </div>
                <?php } ?>
                <?php  
                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
			    <b><?php echo validation_errors(); ?> </b>
				<input type="hidden" name="OpportunityID" id="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
				<div class="box-body"> 
					<div class="row">  	
						<div class="col-md-4">
							<div class="form-group"> 
								<select class="form-control" id="CompanyID" name="CompanyID"  data-live-search="true" >
									<option value="">-- SELECT COMPANY NAME --</option>
									<?php if(!empty($company_list)){
										foreach ($company_list as $rl){ if($rl['CompanyName']!=""){ ?>
											<option value="<?php echo $rl['CompanyID'] ?>" <?php if($opInfo['CompanyID'] == $rl['CompanyID'] ){ ?> selected <?php } ?>  >
											<?php echo $rl['CompanyName'] ?></option>
									<?php }}} ?>
								</select> 
							</div>
						</div>    
						<div class="col-md-2">
							<div class="form-group"> 
								<input type="submit" name="submit" class="btn btn-primary" value="UPDATE" />  
							</div>
						</div>  
					</div>  
					</div> 
				</div> 
              </form> 
			  <div class="row" style="margin:3px">  
				<div class="box-body">
					  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
						  <table id="ticket-grid" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
						  <thead>
							<tr> 
								<th width="10" align="right">T.No </th>                        
								<th width="100" >Date </th>                        
								<th >Company Name</th> 
								<th >Conveyance</th>
								<th width="20">Lorry</th>
								<th width="50">Veh.No</th>
								<th width="100">Driver Name</th> 
								<th width="30">Gross</th>
								<th width="30">Tare</th>
								<th width="30">Net</th> 
								<th width="30">OP</th>   
								<th class="text-center" width="50">Actions</th> 
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
          </div> 
        </div> 
        </div>    
    </section>
</div>
<script type="text/javascript" language="javascript" >
$(document).ready(function() {
		var OppoID = $('#OpportunityID').val();	 
		var dataTable = $('#ticket-grid').DataTable({
			"processing": true,
			"serverSide": true,
			"pageLength": 100,
			"searchable": true,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>",
			"order": [[ 1, "desc" ]],
			"columns": [
				{ "data": "TicketNumber" ,"name": "TicketNumber", "data-sort": "TicketNumber_sort" },
				{ "data": "TicketDate" ,"name": "TicketDate", "data-sort":"TicketDate1" },
				{ "data": "CompanyName" , "name": "CompanyName" }, 
				{ "data": "Conveyance" , "name": "Conveyance" },
				{ "data": "driver_id" , "name": "driver_id" },
				{ "data": "RegNumber" , "name": "RegNumber" },
				{ "data": "DriverName" , "name": "DriverName" },
				{ "data": "GrossWeight" , "name": "GrossWeight" },
				{ "data": "Tare" , "name": "Tare" },
				{ "data": "Net" , "name": "Net" },
				{ "data": "TypeOfTicket", "name": "TypeOfTicket" }, 
				{ "data": null } 
			  ],
			"aoColumnDefs": [ { "bSearchable": false, "aTargets": [ -1 ] } ], 
			"ajax":{
				url : "<?php echo site_url('OppoTickets') ?>", // json datasource
				type: "post",  // method  , by default get
				data : { 'OppoID' : OppoID },  
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
				$(row).find('td:eq(0)').attr('data-sort', data['TicketNumber_sort']);
				$(row).find('td:eq(1)').attr('data-sort', data['TicketDate1']);
				$(row).find("td:eq(2)").html(' <a href="'+baseURL+'view-company/'+data["CompanyID"]+'" target="_blank" title="'+data["CompanyName"]+'">'+data["CompanyName"]+'</a> '); 
				$(row).find("td:eq(-1)").html(' <a class="btn btn-sm btn-warning" target="blank" href="'+baseURL+'assets/pdf_file/'+data["pdf_name"]+'" title="View PDF"><i class="fa fa-file-pdf-o"></i></a> <a class="btn btn-sm btn-info" href="'+baseURL+'View-'+data["TypeOfTicket"]+'-Ticket/'+data["TicketNo"]+'" title="View Ticket"><i class="fa fa-eye"></i></a>  ');
			}
		});   
		
});
	
</script>

<script src="<?php echo base_url(); ?>assets/js/Opportunity.js" type="text/javascript"></script> 