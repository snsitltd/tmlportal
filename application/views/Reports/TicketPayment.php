<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Ticket Payment Report
        <small>Ticket Payment Report</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Ticket Payment Report</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="tickeReport" role="form">
                        <div class="box-body">
                            <div class="row"> 
                                <div class="col-md-3">                                
                                    <div class="form-group">
									   <label for="role">Payment Type</label>
                                       <select class="form-control" name="paymenttype" id="paymenttype"  data-live-search="true" >
                                            <option value="">Select Payment Type</option> 
                                             <option value="1" <?php if(set_value('paymenttype')==1){ echo "Selected";} ?>>CASH</option> 
											 <option value="2" <?php if(set_value('paymenttype')==2){ echo "Selected";} ?>>CARD</option> 
                                        </select>
                                    </div> 
                                </div> 
                                <div class="col-md-3">     
									<div class="form-group">
										<label>Date range:</label> 
										<div class="input-group">
										  <div class="input-group-addon"> <i class="fa fa-calendar"></i></div>
										  <input type="text" class="form-control pull-right" id="reservation" required=""  autocomplete="off"  name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('d/m/Y').'-'.date('d/m/Y'));?>">
										</div> 
									</div>                      
                                </div> 
                            </div>  
                            <div class="row">
                                <div class="col-md-6">    
                                </div> 
                            </div>     
                        </div><!-- /.box-body --> 
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Search" />
                            <?php if(!empty($ticketsRecords)){ ?>
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
                        <th  width="20">TNo.</th>
                        <th width="50">Date</th>
                        <th >Site Name</th>
                        <th>Company Name</th>
                        <th>Material</th>
                        <th width="50">Amount</th>
                        <th width="50">Vat</th> 
						<th width="50">Total</th> 
                        <th width="30" class="text-center" width="30">Actions</th>
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($ticketsRecords)){ $class = '';
                        foreach($ticketsRecords as $key=>$record){ if($record->LoadID!=0){ $class = 'even1'; }else{ $class = ''; } 
                    ?>
                    <tr class="<?php echo $class; ?>" >
						<td><?php echo $record->TicketNumber ?></td>
                        <td><?php echo $record->TicketDate ?></td>
						<td><?php echo $record->OpportunityName ?></td>
                        <td><?php echo $record->CompanyName ?></td>
                        <td><?php echo $record->MaterialName ?></td> 
                        <td align="right" ><?php echo $record->Amount ?></td>
                        <td align="right" ><?php echo $record->VatAmount ?></td>
                        <td align="right" ><?php echo $record->TotalAmount ?></td> 
                        <td class="text-center">                            
                            <a class="btn btn-sm btn-info" href="<?php echo base_url().'view-ticket/'.$record->TicketNumber; ?>" title="View" target="_blank"><i class="fa fa-eye"></i></a> 
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