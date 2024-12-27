<!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->

 
<!-- Include Date Range Picker -->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script> -->


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Tipped Report
        <small>Tipped Report</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Tipped Report</h3>
                    
                    </div><!-- /.box-header -->
                    <!-- form start -->
                   
                    <form role="form" action="<?php echo current_url() ?>" method="post" id="tickeReport" role="form">
                        <div class="box-body">
                            <div class="row">
                         
                                <div class="col-md-6">     
                                <div class="form-group">
                                    <label>Date range:</label>

                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                      </div>
                                      <input  type="text" class="form-control required pull-right" id="reservation" required="" name="searchdate" value="<?php echo (set_value('searchdate')!=''?set_value('searchdate') : date('m/d/Y').'-'.date('m/d/Y'));?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>                           
                                 
                                    
                                </div>
                                   <!--<div class="col-md-6">     
                                <div class="form-group">
                                    <label>Material:</label>
                                        <select class="form-control" name="material" id="material">
                                           <option value="">-- Select Operation--</option>
                                           <?php foreach ($materialsRecords as $value) {?>
                                                     <option value="<?php echo $value->MaterialID ; ?>"><?php echo $value->MaterialName ; ?></option>
                                         <?php   } ?>
                                     
                                          
                                        </select> 
                                </div>                           
                                 
                                    
                                </div>-->
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