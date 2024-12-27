<!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->

 
<!-- Include Date Range Picker -->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script> -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Ticket Report
        <small>Ticket Report</small>
      </h1>
    </section>
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->   
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Ticket Report</h3>
                    </div>  
                    <form name="tickeReport" action="<?php echo base_url('tickets-reports'); ?>" method="post" id="tickeReport" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">Customer</label>
                                        <select class="form-control" name="customer" id="customer"  data-live-search="true" >
                                            <option value=""> SELECT COMPANY </option>
                                            <?php foreach ($company_list as $key => $value) { ?>
											  <option value="<?php echo $value['CompanyID']; ?>" <?php if(set_value('customer')==$value['CompanyID']){ echo "Selected";} ?> ><?php echo $value['CompanyName']; ?></option>
											<?php } ?>
                                        </select> 
                                    </div> 
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">Material</label>
                                       <select class="form-control" name="material" id="material"  data-live-search="true" >
                                            <option value="">Select Material</option>
                                            <?php foreach($materialsRecords as $value){ ?>
                                             <option value="<?php echo $value->MaterialID; ?>" <?php if(set_value('material')==$value->MaterialID){ echo "Selected";} ?>><?php echo $value->MaterialName ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-md-6">     
									<div class="form-group">
										<label>Date range:</label> 
										<div class="input-group">
										  <div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										  </div>
										  <input type="text" class="form-control pull-right" id="reservation"  autocomplete="off"    required="" name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('d/m/Y').'-'.date('d/m/Y'));?>">
										</div>
										<!-- /.input group -->
									</div>                           
                                    <!-- <div class="form-group">
                                        <label for="role">Date</label>
                                        <input type="text" class="form-control" id="reservation" placeholder="" name="role" value="" maxlength="128">
                                    </div> --> 
                                </div> 
                            </div>  
                            <div class="row">
                                <div class="col-md-6">                                
                               
                                    
                                </div>
                              
                            </div>    

                           
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Search" name="search" />
                            <?php if(!empty($ticketsRecords))
                              { ?>
                               <input type="submit" class="btn btn-primary" value="Export"  name="export" />
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
              <h3 class="box-title">Tickets List</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <!-- <th width="20">S.No</th>  -->
                        <th  width="70">Date</th>
                        <th>Company Name</th>
                        <th width="100" >Vehicle Rno</th>
                        <th>Driver Name</th>
                        <th width="70">Gross</th>
                        <th width="70">Tare</th>
                        <th width="70">Net</th> 
                        <th class="text-center" width="30">Actions</th>
                    </tr>
                    </thead>
                      <tbody>
                    <?php if(!empty($ticketsRecords)){ $class = '';
                        foreach($ticketsRecords as $key=>$record){ if($record->LoadID!=0){ $class = 'even1'; }else{ $class = ''; }  ?>
                    <tr class="<?php echo $class; ?>" > 
                        <td><?php echo $record->TicketDate; ?></td>
                        <td><?php echo $record->CompanyName ?></td>
                        <td><?php echo $record->RegNumber ?></td>
                        <td><?php echo $record->DriverName ?></td>
                        <td align="right" ><?php echo round($record->GrossWeight) ?></td>
                        <td align="right" ><?php echo round($record->Tare) ?></td>
                        <td align="right" ><?php echo round($record->Net) ?></td>
                        <!-- <td><?php echo $record->TypeOfTicket ?></td> -->
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'view-ticket/'.$record->TicketNumber; ?>" title="View" target="_blank"><i class="fa fa-eye"></i></a> 
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