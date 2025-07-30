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
                    
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="tickeReport">
                        <div class="box-body">
                            <div class="row d-flex flex-wrap align-items-end" style="gap: 10px;">

                                <!-- Ticket Type -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Ticket Type</label>
                                        <select class="form-control" name="tickettype" id="tickettype">
                                            <option value="">ALL Types</option>
                                            <option value="In" <?php if(set_value('tickettype') =="In"){ echo "selected"; } ?>>IN</option>
                                            <option value="Out" <?php if(set_value('tickettype') =="Out"){ echo "selected"; } ?>>OUT</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Material -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Material</label>
                                        <select class="form-control" name="material[]" id="material" multiple>
                                            <?php foreach($materialsRecords as $value){ ?>
                                                <option value="<?php echo trim($value->MaterialID); ?>" <?php if(isset($_POST['material']) && in_array($value->MaterialID, $_POST['material'])){ echo "selected"; } ?>>
                                                    <?php echo $value->MaterialName ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- County -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>County</label>
                                        <select class="form-control" name="county[]" id="county" multiple>
                                            <?php foreach($county as $value){ ?>
                                                <option value="<?php echo trim($value->County); ?>" <?php if(isset($_POST['county']) && in_array($value->County, $_POST['county'])){ echo "selected"; } ?>>
                                                    <?php echo $value->County ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Date Range -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date range:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input type="text" class="form-control" autocomplete="off" id="reservation" required name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('d/m/Y').'-'.date('d/m/Y'));?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Users -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Users</label>
                                        <select class="form-control" name="user[]" id="user" multiple>
                                            <?php foreach($Users as $value){ ?>
                                                <option value="<?php echo $value->userId; ?>" <?php if(set_value('user') && in_array($value->userId, set_value('user'))){ echo "selected"; } ?>>
                                                    <?php echo $value->name ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                    
                                <?php if(!empty($ticketsRecords)){ ?>
                                <div class="col-md-3">
                                    <div class="form-group d-flex" style="gap: 5px; margin-top: 25px;">
                                        <input type="submit" class="btn btn-primary" value="Search">
                                        <input type="submit" class="btn btn-primary" value="Export XLS" name="export" />
                                        <input type="submit" class="btn btn-primary" value="Export PDF" name="export1" />
                                    </div>
                                </div>
                                <?php } ?>

                            </div>
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