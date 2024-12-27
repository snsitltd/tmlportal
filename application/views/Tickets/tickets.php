<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header"> <h1> <i class="fa fa-users"></i> Tickets Management <small>Add, Edit, Delete</small>   </h1>    </section>

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
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>In-Tickets"><i class="fa fa-plus"></i> Add In Ticket</a>
                     <a class="btn btn-primary" href="<?php echo base_url(); ?>Out-Tickets"><i class="fa fa-plus"></i> Add Out Ticket</a>
                      <a class="btn btn-primary" href="<?php echo base_url(); ?>Collection-Tickets"><i class="fa fa-plus"></i> Add Collection Ticket</a>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Tickets List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap table-responsive"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th width="10" align="right">T.No </th>                        
						<th width="100" >Date </th>                        
                        <th >Company Name</th>
						<th >Site Name</th>
						<th width="50">Lorry No</th>
                        <th width="50">Veh.No</th>
                        <th width="100">Driver Name</th> 
                        <th width="40">Gross</th>
                        <th width="40">Tare</th>
                        <th width="40">Net</th> 
                        <th width="50">Operation</th>  
                        <th class="text-center" width="150">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($ticketsRecords)){
                    foreach($ticketsRecords as $key=>$record){ ?>
                    <tr> 
                        <td align="right" data-sort="<?php echo $record->TicketNumber; ?>" ><?php echo $record->TicketNumber." ".$record->TicketGap; ?></td>   
                        <td align="right" data-sort="<?php echo $record->TicketDate1; ?>" > <?php echo $record->TicketDate; ?></td>                        
                        <td><a href="<?php echo base_url().'view-company/'.$record->CompanyID; ?>" ><?php echo $record->CompanyName ?></a></td>
						<td><?php echo $record->OpportunityName ?></td>
                        <td><?php echo $record->driver_id ?></td>
						<td><?php echo $record->RegNumber ?></td>
                        <td><a href="<?php echo base_url().'viewDriver/'.$record->driver_id; ?>" ><?php echo $record->DriverName ?></a></td>
                        <td align="right" ><?php echo round($record->GrossWeight) ?></td>
                        <td align="right" ><?php echo round($record->Tare) ?></td>
                        <td align="right" ><?php echo round($record->Net) ?></td>  
                        <td><?php echo $record->TypeOfTicket ?></td>  
                        <td class="text-center" >                            
                          <?php if($record->pdf_name != "") {?>  <a class="btn btn-sm btn-warning" target="blank" href="<?php echo base_url().'assets/pdf_file/'.$record->pdf_name; ?>" title="View PDF"><i class="fa fa-file-pdf-o"></i></a><?php }?>
						  <a class="btn btn-sm btn-info" href="<?php echo base_url().'OfficeTicket/'.$record->TicketNumber; ?>" title="Create Office Ticket"> G </a>
						  <a class="btn btn-sm btn-info" href="<?php echo base_url().'View-'.$record->TypeOfTicket.'-Ticket/'.$record->TicketNo; ?>" title="View"><i class="fa fa-eye"></i></a>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'edit-'.$record->TypeOfTicket.'-ticket/'.$record->TicketNo; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deleteTicket" href="#" data-ticketno="<?php echo $record->TicketNo; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td> 
                    </tr>
                    <?php } } ?>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/Ticket.js" charset="utf-8"></script>