<div class="content-wrapper"> 
    <section class="content-header">
    <h1><i class="fa fa-users"></i> Tip Tickets : <?php echo $TipInfo['TipName'];?></h1>
    </section>
    <section class="content"> 
		<?php
			$this->load->helper('form');
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

         
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">List Of Tip Tickets</h3>
            </div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="TipTickets" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
						<th width="80">Tip TicketID </th>
						<th width="100">DateTime</th>
						<th width="70">Conveyance</th>
                        <th>Site Address </th>
                        <th width="100">Driver Name </th> 
                        <th width="150" >Material Name </th>
						<th width="70" >TipTicketNo	</th>
                        <th width="200">Remarks</th>    
						<th width="30">Action</th>    
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($TipRecords)){
                        foreach($TipRecords as $key=>$record){ ?>
                    <tr> 
						<td><?php echo $record->TipTicketID ?></td>
						<td><?php echo $record->TipDateTime ?></td>
						<td><a class="btn btn-sm btn-warning" target="blank" href="<?php echo base_url('assets/conveyance/'.$record->ReceiptName); ?>" title="View Conveyance Ticket"><i class="fa fa-file-pdf-o"></i> <?php echo $record->ConveyanceNo ?></a></td>
                        <td><?php echo $record->SiteAddress ?></td> 
                        <td><?php echo $record->DriverName ?></td>
						<td><?php echo $record->MaterialName ?></td>
                        <td><?php if($record->TipTicketNo!='0'){  ?>
							<?php if($record->TipTicketNo!='' ){  ?>
							
							<?php //if($record->TipTicketID=='215' ){ 
							$url =  "http://193.117.210.98:8081/ticket/Supplier/".$TipInfo['TipName']."-".$record->TipTicketNo.".pdf";
							$HI = get_headers($url); 
							//} ?>
							<?php if($HI[1]=='Content-Type: application/pdf'){ ?> 
								<a href="<?php echo $url; ?>" target="_blank" > <?php echo $record->TipTicketNo; ?> </a> 
							<?php }else{ echo $record->TipTicketNo; } ?>
							
							<?php  } } ?>
						</td>
                        <td><?php echo $record->Remarks ?></td> 
						<td><a class="btn btn-sm btn-warning" target="blank" href="<?php echo base_url().'assets/tiptickets/'.$record->TipTicketID.'.pdf'; ?>" title="View PDF"><i class="fa fa-file-pdf-o"></i></a></td> 
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                  </table> 
              </div>
			  </div>
			  </div>
            </div> 
          </div> 
            </div>
        </div>
    </section>
</div> 


<script type="text/javascript"> 
    $(function () {  
        $('#TipTickets').DataTable({
			"order": [[ 0, "desc" ]], 
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		}); 
    }) 
	 
	
</script> 