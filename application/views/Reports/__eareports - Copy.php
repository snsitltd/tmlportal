<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> EA Report
        <small>EA Report</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">EA Report</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="tickeReport" >
                        <div class="box-body">
                            <div class="row">
								<div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">Ticket Type</label>
                                        <select class="form-control" name="tickettype" id="tickettype"  data-live-search="true" >
                                            <option value="">ALL Types</option> 
                                             <option value="In">IN</option> 
											 <option value="Out">OUT</option> 
                                        </select> 
                                    </div> 
                                </div> 
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                       <label for="role">Material</label>
                                       <select class="form-control" name="material[]" id="material" multiple  data-live-search="true" > 
                                            <?php foreach($materialsRecords as $value){ ?>
                                             <option value="<?php echo trim($value->MaterialID); ?>" <?php if(isset($_POST['material'])) { if(in_array($value->MaterialID, $_POST['material'])){ echo "Selected"; }} ?>  ><?php echo $value->MaterialName ?></option>
                                            <?php } ?>
                                        </select>
										<i>Notes: For Multiple selection Press Cntl Button + Click </i>
                                    </div> 
                                </div> 
                                <div class="col-md-6">     
									<div class="form-group">
                                        <label for="role">County</label>
                                        <select class="form-control" name="county[]" id="county" multiple  data-live-search="true"  > 
                                            <?php foreach($county as $value){ ?>
                                             <option value="<?php echo trim($value->County); ?>" <?php if(isset($_POST['county'])) { if(in_array($value->County, $_POST['county'])){ echo "Selected"; }} ?> >
											 <?php echo $value->County ?></option>
                                            <?php } ?>
                                        </select>
										<i>Notes: For Multiple selection Press Cntl Button + Click </i>
                                    </div> 
                                </div> 
                            </div>  
                            <div class="row">
                                <div class="col-md-6">   
                                </div> 
                            </div>     
                        </div> 
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Search" />
                            <?php if(!empty($ticketsRecords)){ ?>
                               <input type="submit" class="btn btn-primary" value="Export XLS"  name="export" />
							   <input type="submit" class="btn btn-primary" value="Export PDF"  name="export1" />
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        
        </div>

          <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">EA Report List</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                   <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">   
					<thead>
                    <tr>  					
						<th width="40"> Type</th>	 
						<th>Material Name</th>  
						<th width="100">County</th> 	
						<th width="100">Net in Tonnes</th>   
                        <th width="70" class="text-center" >Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(!empty($ticketsRecords)){ 
                        foreach($ticketsRecords as $key=>$record){ ?> 
                    <tr> 
						<td><?php echo $record->TypeOfTicket; ?></td>  
						<td><?php echo $record->MaterialName ?></td> 
                        <td ><?php echo $record->County ?></td> 
                        <td align="right" ><?php echo $record->net_tonnes ?></td> 
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'view-ticket/'.$record->TicketNo; ?>" title="View" target="_blank"><i class="fa fa-eye"></i></a> 
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
 
<script src="<?php echo base_url(); ?>assets/js/Report.js" type="text/javascript"></script>