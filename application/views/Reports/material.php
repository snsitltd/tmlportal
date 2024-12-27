<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Material Report
        <small>Material Report</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Material Report</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="editrolessubmit" role="form">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Operation">Operation</label>
                                        <select class="form-control" name="Operation" id="Operation"  data-live-search="true" >
                                           <option value="">-- Select Operation--</option>
                                            <option value="IN">IN</option>
                                            <option value="OUT">OUT</option>
                                            <option value="Collection">Collection</option>
                                        </select>
                                       
                                    </div>
                                    
                                </div>
                                
                                <!--<div class="col-md-6">     
                                <div class="form-group">
                                    <label>Date range:</label>

                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control pull-right" id="reservation" required="" name="searchdate">
                                    </div>
                                     /.input group 
                                </div>                           
                                     <div class="form-group">
                                        <label for="role">Date</label>
                                        <input type="text" class="form-control" id="reservation" placeholder="" name="role" value="" maxlength="128">
                                    </div> 
                                    
                                </div>-->
                              
                            </div> 


                            <div class="row">
                                <div class="col-md-6">                                
                               
                                    
                                </div>
                              
                            </div>    

                           
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            
                        </div>
                    </form>
                </div>
            </div>
        
        </div>  


          <div class="row">
            <div class="col-xs-12">
            <div class="box">
            <div class="box-header">
              <h3 class="box-title">Material List</h3>              
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">                  
                  <table id="example1" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                  <thead>
                    <tr> 
                        <th width="100">Code</th>
						<th>Material Name</th>
                        <th  width="50">Operation</th>
                        <th  width="50">SicCode</th>  
                    </tr>
                    </thead>
                      <tbody>
                    <?php
                    if(!empty($materialsRecords))
                    {
                        foreach($materialsRecords as $key=>$record)
                        {
                    ?>
                    <tr> 
                        <td><?php echo $record->MaterialCode; ?></td>                        
						<td><?php echo $record->MaterialName; ?></td>                        
                        <td><?php echo $record->Operation ?></td>
                        <td><?php echo $record->SicCode ?></td>
                      
                        
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