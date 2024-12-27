<!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->

 
<!-- Include Date Range Picker -->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script> -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> TML IN-OUT Ticket Report
        <small>TML IN-OUT Ticket Report</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">TML IN-OUT Ticket Report</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="tickeReport" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">Customer</label>
                                        <select class="form-control" name="customer" id="customer">
                                            <option value="">Select Customer</option>
                                            <?php foreach($contactsRecords as $value){ ?>
                                             <option value="<?php echo $value->ContactID; ?>" <?php if(set_value('customer')==$value->ContactID){ echo "Selected";} ?>><?php echo $value->ContactName ?></option>
                                            <?php } ?>
                                        </select>
                                       
                                    </div>
                                    
                                </div>
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">Material</label>
                                       <select class="form-control" name="material" id="material">
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
                                      <input type="text" class="form-control pull-right" id="reservation" required="" name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('m/d/Y').'-'.date('m/d/Y'));?>">
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
                            <input type="submit" class="btn btn-primary" value="Search" />
                            <?php if(!empty($ticketsRecords))
                              { ?>
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
              <h3 class="box-title">TML IN-OUT Ticket Report List</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Ticket Title</th>
                        <th>Date</th>
                        <th>Company Name</th>
                        <th>Vehicle Rno</th>
                        <th>Driver Name</th>
                        <th>Gross</th>
                        <th>Tare</th>
                        <th>Net</th>
                        <!-- <th>Operation</th> -->
                      
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($ticketsRecords))
                    {
                        foreach($ticketsRecords as $key=>$record)
                        {
                    ?>
                    <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><?php echo $record->TicketTitle; ?></td>
                        <td><?php echo date('d/m/Y h:i:s A',strtotime($record->TicketDate)) ?></td>
                        <td><?php echo $record->CompanyName ?></td>
                        <td><?php echo $record->RegNumber ?></td>
                        <td><?php echo $record->DriverName ?></td>
                        <td><?php echo $record->GrossWeight ?></td>
                        <td><?php echo $record->Tare ?></td>
                        <td><?php echo $record->Net ?></td>
                        <!-- <td><?php echo $record->TypeOfTicket ?></td> -->
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'view-ticket/'.$record->TicketNo; ?>" title="View" target="_blank"><i class="fa fa-eye"></i></a>
                           
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
 
<script src="<?php echo base_url(); ?>assets/js/Report.js" type="text/javascript"></script>