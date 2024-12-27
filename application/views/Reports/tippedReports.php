  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Tipped IN Material Report
        <small>Tipped IN Material Report</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                         <h3 class="box-title"> Tipped IN Material Report</h3>  
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="tickeReport" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">Customer</label>
                                        <select class="form-control" name="customer" id="customer"   data-live-search="true" >
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
              <h3 class="box-title"> Tipped IN Material Report</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                   <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">  

                   
                  <thead>
                    <tr> 					
                        <th width="50">Date</th>
						<th>Conveyance</th>
						<th width="50">LorryNo</th>
                        <th width="80">Vehicle Rno</th>
                        <th>Site Address</th> 
                        <th width="70" >Gross</th>
                        <th width="70">Tare</th>
                        <th width="70">Net</th>  
                        <th width="50" class="text-center" >Actions</th>
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
                        <td><?php echo $record->TicketDate; ?></td>
						<td><?php echo $record->Conveyance ?></td>
                        <td><?php echo $record->driver_id ?></td>
                        <td><?php echo $record->RegNumber ?></td>
                        <td><?php echo $record->SiteName; // $record->Street1.", ".$record->Street2.", <br> ".$record->Town.", ".$record->County.", ".$record->PostCode; ?></td> 
                        <td align="right" ><?php echo $record->GrossWeight ?></td>
                        <td align="right" ><?php echo $record->Tare ?></td>
                        <td align="right" ><?php echo $record->Net ?></td> 
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