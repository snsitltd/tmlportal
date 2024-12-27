  
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Tml Report
        <small>Tml Report</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Tml Report</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="tickeReport" role="form">
                        <div class="box-body">
                            <div class="row">
                              <!--  <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">From Date</label>
                                      <input type="text" class="form-control pull-right" autocomplete="off" id="datepicker" required="" name="searchdate" value="<?php //echo (set_value('searchdate')!=''?set_value('searchdate') : date('m/d/Y'));?>">
                                    </div>
                                    
                                </div> -->
                              <!--   <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">To Date</label>
                                      <input type="text" autocomplete="off"  class="form-control pull-right" id="datepicker" required="" name="searchdate" value="<?php //echo (set_value('searchdate')!=''?set_value('searchdate') : date('m/d/Y'));?>">
                                    </div>
                                    
                                </div> -->
                                <div class="col-md-6">     
                                <div class="form-group">
                                    <label>Date range:</label>

                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input type="text" class="form-control pull-right" id="reservation"  autocomplete="off"   required="" name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('m/d/Y').'-'.date('m/d/Y'));?>">
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
                           
                        </div>
                    </form>
                </div>
            </div>
        
        </div>
   
    </section>
</div>




<script src="<?php echo base_url(); ?>assets/js/Report.js" type="text/javascript"></script>