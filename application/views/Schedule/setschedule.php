<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Upload data
        
      </h1>
    </section>
    
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
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
                
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->    



              <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Set Columns</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="uploaddatasubmit" action="<?php echo base_url() ?>importcsvfilesubmit" method="post" role="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $SInfo['id'];?>"  > 
                    <input type="hidden" name="filename" value="<?php echo $SInfo['filename'];?>"  > 
                    <input type="hidden" name="type" value="<?php echo $SInfo['type'];?>"  > 
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-4">  

                                <label>Database Columns </label>
                                    <?php foreach ($database_columns as $key => $value) { ?>
                                     <div class="form-group">                                        
                                        <input type="text" class="form-control required" value="<?php echo $value;?>" readonly > 
                                    </div> 
                                  <?php   } ?>       

                                </div>

                                 <div class="col-md-4"> 

                                 <label>CSV Header</label> 

                                    <?php //for($i=0;$i<count($csv_header);$i++){ ?>
                                    <?php foreach ($database_columns as $key => $value) { ?>
                                    <div class="form-group">  
                                    <!-- <select name="csv_col_<?=$i?>" class="form-control required"> -->
                                    <select name="csvdb[<?php echo $value;?>]" class="form-control">
                                    <option value="">--Select column--</option>
                                    <?php foreach ($csv_header as $key => $value) { ?>                                  
                                    <option value="<?php echo $key?>"><?php echo $value;?></option>                                        
                                    <?php   } ?>
                                    </select>
                                    
                                    </div> 
                                      <?php   } ?>
                                                                    
                                </div>


                                 <div class="col-md-4">  

                                 <label>Example Data</label> 

                                  <?php foreach ($example_data as $key => $value) { ?>   
                                     <div class="form-group">                                        
                                        <input type="text" class="form-control required" value="<?php echo $value;?>" name="csvData[<?php echo $key?>]" readonly> 
                                    </div> 
                                  <?php   } ?>                                   
                                                                    
                                </div>
                              
                            </div>

                            <div class="row">

                                <div class="col-md-6"> 
                                    

                                     <div class="form-group">                                        
                                       <label for="isschedule">Is schedule <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="isschedule" name="isschedule">
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>                                            
                                        </select>
                                    </div>                                 

                                </div>

                            </div>                            
                            
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>

                    </form>
                </div>

                
                
               
            </div>
            
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/schedule.js" type="text/javascript"></script>