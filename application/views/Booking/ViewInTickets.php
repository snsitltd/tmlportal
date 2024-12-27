<link rel="stylesheet" href="<?php echo base_url(); ?>docs/css/signature-pad.css">
  
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> View InTicket  </h1>
    </section>
    
    <section class="content">
		<div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements --> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Ticket Information</h3>
                    </div> 
                        <div class="box-body">
                        <div class="col-md-12"> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="date-time">Date & Time:   </label> <?php echo date('d/m/Y H:i:s',strtotime($TicketInfo['TicketDate'])); ?> 
                                    </div> 
                                </div>  
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Conveyance">Conveyance Note No:  </label> <?php echo $TicketInfo['Conveyance']; ?> 
                                    </div>
                                </div>
								<div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Conveyance">Is TML Ticket ? :  </label> <?php if($TicketInfo['is_tml']==1){ echo "YES"; }else{ echo "NO"; } ?> 
                                    </div>
                                </div>        
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="CompanyID">Company Name: </label> <?php echo $TicketInfo['CompanyName']; ?> 
                                    </div>
                                </div>  
                             
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="OpportunityID">Opportunity: </label> <?php echo $TicketInfo['OpportunityName']; ?> 
                                    </div>
                                </div>                             
                               
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="SiteAddress">Site Address: </label> <?php echo $TicketInfo['OpportunityName']; ?> 
                                    </div>
                                </div>
 
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="DescriptionofMaterial">Description of Material: </label> <?php echo $TicketInfo['MaterialName']; ?> 
                                    </div>
                                </div> 
   
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="SicCode">SIC Code: </label> <?php echo $TicketInfo['SicCode']; ?> 
                                    </div>
                                </div> 
                               
                                                               
                            </div> 
                       
                        </div>

                         

                        </div> 
                         
                </div>
            </div>
			
			<div class="col-md-6"> 
				 <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Driver Information</h3>
                    </div> 
                        <div class="box-body">  
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="VechicleRegNo">Lorry No: </label>  <?php echo $TicketInfo['driver_id']; ?> 
                                    </div>
                                </div> 
 							
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="VechicleRegNo">Vechicle Reg No: </label>  <?php echo $TicketInfo['RegNumber']; ?> 
                                    </div>
                                </div> 
                             
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="DriverName">Driver Name :</label>   <?php echo $TicketInfo['DriverName']; ?> 
                                    </div>
                                </div> 
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="GrossWeight">Gross Weight: </label>  <?php echo $TicketInfo['GrossWeight']; ?>  
                                    </div>
                                </div>
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Tare">Tare: </label> <?php echo $TicketInfo['Tare']; ?>  
                                    </div>
                                </div> 
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Net">Net: </label>  <?php echo $TicketInfo['Net']; ?>  
                                    </div>
                                </div> 
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Website">Report Number: </label> <?php echo $TicketInfo['Rnum']; ?>  
                                    </div>
                                </div>      
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="HaullerRegNo">Haulier Reg. No : </label>    <?php echo $TicketInfo['Hulller']; ?> 
                                    </div>
                                </div>    
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="SourceofMaterial">Source of Material : </label> <?php echo $TicketInfo['SOM']; ?>   
                                    </div>
                                </div>  
								
								
                                                   
                            </div>
							<div class="row">
                                <div class="col-md-12">
								<div class="form-group">
                                        <label for="Net">Driver Signature : </label>   
										<?php if($TicketInfo['driversignature']!=""){ ?>
										<img src="<?php echo $TicketInfo['driversignature']; ?>" height="160px" width="750px"><?php } ?>   
								</div>		 
                                </div>
                                                                  
                            </div>  
							

				</div></div>
                        </div>
						
           
        </div>  
		<div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements --> 
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Payment Information</h3>
                    </div> 
                        <div class="box-body"> 
							<div class="row">        
                                <div class="col-md-12">
									<div class="form-group">
                                        <label for="Conveyance">Payment : </label>  <?php if($TicketInfo['PaymentType']==0){ ?> Credit <?php } ?> 
										<?php if($TicketInfo['PaymentType']==1){ ?> Cash <?php } ?> 
										<?php if($TicketInfo['PaymentType']==2){ ?> Cards <?php } ?> 
                                    </div> 
                                </div>  
								<div class="pblock" <?php if($TicketInfo['PaymentType']==0){ ?> style="display: none;" <?php } ?> > 
									<div class="col-md-4">
										<div class="form-group">
											<label for="Amount">Amount :</label> <?php echo number_format($TicketInfo['Amount']); ?> 
										</div>
									</div> 
									<div class="col-md-4">
										<div class="form-group">
											<label for="Vat">VAT (20%) : </label> <?php echo number_format($TicketInfo['Vat']); ?> 
										</div>
									</div> 
									<div class="col-md-4">
										<div class="form-group">
											<label for="TotalAmount">Total Amount : </label> <?php echo number_format($TicketInfo['TotalAmount']); ?> 
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="PaymentRefNo">Payment Ref No : </label> <?php echo $TicketInfo['PaymentRefNo']; ?> 
										</div>
									</div>
								</div>		
                            </div>  
                        </div> 
                        </div>  
                </div> 
			
			<div class="col-md-6"> 
				<div class="box box-primary">
					<div class="box-header">
						<h3 class="box-title">Note: </h3>
					</div> 
					<div class="box-body">  
						<div class="row"> 
							<div class="col-md-6">
								<div class="form-group"> <?php echo $TicketInfo['ticket_notes']; ?>  </div>
							</div>  
						</div>    
					</div>
				</div>
            </div> 
        </div> 
         
    </section>
    
</div>    