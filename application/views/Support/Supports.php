<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Support Tickets  <a class="btn btn-primary" style="float:right" href="<?php echo base_url('addSupport'); ?>"><i class="fa fa-plus"></i> Add New</a> </h1>
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
				<div class="col-xs-4">
					<div class="box">  
						<div class="box-body"> 
							<p><button class="btn btn-sm btn-danger" title="Open"> Open</button> : Ticket Created  </p>  
						</div>
					</div>
				</div> 			
				<div class="col-xs-4">
					<div class="box">  
						<div class="box-body"> 
							<p><button class="btn btn-sm btn-success" title="Completed"> Completed</button> : Ticket Completed  </p>  
							 
						</div>
					</div>
				</div> 			
				<div class="col-xs-4">
					<div class="box">  
						<div class="box-body">   
							<p><button class="btn btn-sm btn-warning" title=" Awaiting Response">  Awaiting Response</button> : Developer Waiting Response from TML Staff </p>   
						</div>
					</div>
				</div> 
				<div class="col-xs-4">
					<div class="box">  
						<div class="box-body">   
							<p><button class="btn btn-sm btn-danger" title="Response Received "> Response Received</button> : Developer Received Response By TML Staff  </p>   
						</div>
					</div>
				</div> 
				<div class="col-xs-4">
					<div class="box">  
						<div class="box-body">   
							<p><button class="btn btn-sm btn-info" title="InProgress "> InProgress</button> : Developer Working On Ticket </p>  
						</div>
					</div>
				</div> 
			</div>	
			
			
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header"><h3 class="box-title">Support Ticket List</h3></div> 
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="supportdt" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th width="30" >No</th>
						<th width="100" >Created Date</th>
						<th width="100" >Last Updated</th>
                        <th >Title</th>
                        <th  width="100"  >Category</th> 
						<th  width="70"  >Priority</th>  
						<th  width="70"  >Status</th>  
						<th  width="70"  >Created By</th>  
                        <th class="text-center" width="100" >Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(!empty($SupportRecords))
                    {
                        foreach($SupportRecords as $key=>$record)
                        {  ?>
                    <tr>
                        <td><?php echo $record->isupport_id; $record->TIMEDIFFHOUR ?></td> 
						<td><?php echo $record->tscreate_date  ?></td> 
						<td><?php echo $record->tsupdate_date; ?> <br> 
						<?php if($record->istatus!=1){   if($record->TIMEDIFFHOUR>36){ ?><label style="color:red;font-size:10px"><?php echo $record->TIMEDIFFHOUR." Hours Ago" ?> </label> <?php }} ?> </td> 
                        <td><a href="<?php echo base_url('viewSupport/'.trim($record->isupport_id)); ?>" title="View Support Ticket"><?php echo $record->vtitle ?></a></td>
                        <td><?php if($record->icategory==1){ ?> BUG <?php } ?>
						<?php if($record->icategory==2){ ?> New functionality  <?php } ?>
						<?php if($record->icategory==3){ ?> Additional Update  <?php } ?>
						<?php if($record->icategory==4){ ?> Support  <?php } ?>
						<?php if($record->icategory==5){ ?> Human Error  <?php } ?>
						</td>
                        <td><?php if($record->ipriority==0){ ?> <button class="btn btn-sm btn-info" title="Low "> Low </button> <?php } ?> 
						<?php if($record->ipriority==1){ ?> <button class="btn btn-sm btn-warning" title="Medium "> Medium </button> <?php } ?> 
						<?php if($record->ipriority==2){ ?> <button class="btn btn-sm btn-danger " title="High "> High </button> <?php } ?> 
						</td> 
						<td><?php if($record->istatus==0){ ?> <button class="btn btn-sm btn-danger " title="OPEN "> OPEN </button> <?php } ?> 
						<?php if($record->istatus==1){ ?> <button class="btn btn-sm btn-success" title="Completed "> Completed</button> <?php } ?>  
						<?php if($record->istatus==2){ ?> <button class="btn btn-sm btn-warning" title=" Awaiting Response">  Awaiting Response</button> <?php } ?>  
						<?php if($record->istatus==3){ ?> <button class="btn btn-sm btn-danger" title="Response Received "> Response Received</button> <?php } ?>  
						<?php if($record->istatus==4){ ?> <button class="btn btn-sm btn-info" title="InProgress "> InProgress</button> <?php } ?>   
						</td> 
						<td><?php echo $record->created_by ?></td>
                        <td class="text-center"> 
                           <a class="btn btn-sm btn-info" href="<?php echo base_url('viewSupport/'.trim($record->isupport_id)); ?>" title="View"><i class="fa fa-eye"></i></a> 
						   <?php if($record->icreated_by==$this->session->userdata['userId'] || $this->session->userdata['userId'] == 1 ){ ?><a class="btn btn-sm btn-info" href="<?php echo base_url('editSupport/'.trim($record->isupport_id)); ?>" title="View Or Update on Support Ticket"><i class="fa fa-pencil"></i></a> <?php } ?>
                           <?php if($record->istatus==0 ){ ?> <button class="btn btn-sm btn-danger deleteSupport" href="#" data-SupportID="<?php echo $record->isupport_id; ?>" title="Delete"><i class="fa fa-trash"></i></button> <?php } ?>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                  </table>

              </div></div></div>
            </div>
            <!-- /.box-body -->
          </div>

              
            </div>
        </div>
    </section>
</div>
<script>

$(function () {
		 			
        $('#supportdt').DataTable({
			"order": [[ 0, "desc" ]], 
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'i><'col-sm-7'p>>" 
		});
	 
    })
	
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/support.js" charset="utf-8"></script>

