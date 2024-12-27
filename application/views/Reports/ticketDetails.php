<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Ticket Details
        <small>Ticket Details</small>
      </h1>
    </section>
    
    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Ticket Details</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                     <form role="form" id="addTicketsSubmit" action="<?php echo base_url() ?>addTicketsSubmit" method="post" role="form" enctype="multipart/form-data">
                    <!-- <input type="hidden" name="TypeOfTicket" value="IN"> -->
                        <div class="box-body"> 
                                <div class="col-md-12">   
                                   <?php if($ticketsDetail) { ?>                          
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Ticket No :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->TicketNumber; ?> 
                                                </div>
                                            </div>
                                        </div>
                                         
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Date & Time :</label>

                                                <div class="col-sm-10">
                                                  <?php echo date('d/m/Y h:i:s A',strtotime($ticketsDetail->TicketDate)); ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Conveyance :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->Conveyance; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Company Name :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->CompanyName; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Opportunity :</label>

                                                <div class="col-sm-10">
                                                  <a href="<?php echo base_url().'View-Opportunity/'.$ticketsDetail->OpportunityID; ?>" ><?php echo $ticketsDetail->OpportunityName; ?></a> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Company Name :</label>

                                                <div class="col-sm-10">
                                                  <a href="<?php echo base_url().'view-company/'.$ticketsDetail->CompanyID; ?>" ><?php echo $ticketsDetail->CompanyName; ?> </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Site Address / Delivery Site :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->Street1.', '.$ticketsDetail->Street2.', '.$ticketsDetail->Town.', '.$ticketsDetail->County.'- '.$ticketsDetail->PostCode; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Hauller Reg. No :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->Hulller; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Description of Material :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->MaterialName; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">SIC Code :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->SicCode; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Vechicle Reg No :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->RegNumber; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Driver Name :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->DriverName; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Gross Weight :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->GrossWeight; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Tare :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->Tare; ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Net :</label>

                                                <div class="col-sm-10">
                                                  <?php echo $ticketsDetail->Net; ?> 
                                                </div>
                                            </div>
                                        </div>
                                           
                                                                          
                                    </div>
                                  <?php } ?>
                                </div>

                          <div class="col-md-2">     </div>
                         </div><!-- /.box-body -->
                       
                        
                    </form>
                </div><!-- /.box-body -->
    
                        
                    
                </div>
            </div>
        
        </div>    
    </section>
</div>

<script src="<?php echo base_url(); ?>assets/js/Report.js" type="text/javascript"></script>