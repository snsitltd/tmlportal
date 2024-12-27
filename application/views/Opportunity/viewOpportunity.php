<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Opportunity Management
        <small>View Opportunity</small>
      </h1>
    </section>
	
	<section class="content">
	<div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url('edit-Opportunity/'.$opInfo['OpportunityID']); ?>"><i class="fa fa-plus"></i> Edit Opportunity</a>
                </div>
            </div>
        </div>
		<div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements --> 
                <div class="box box-primary"> 
                        <div class="box-body">  
                            <div class="row">  
                                
								<div class="col-md-12">
                                    <div class="form-group">
                                        <label for="OpportunityName"><b>Site Address : </label> <?php echo $opInfo['OpportunityName']; ?> </b>
                                    </div>
                                </div> 
								<div class="col-md-12">
                                    <div class="form-group">
                                        <label >Company Name : </label> <a href="<?php echo base_url().'view-company/'.$opInfo['CompanyID']; ?>" ><?php echo $opInfo['CompanyName']; ?></a> 
                                    </div>
                                </div> 
								<div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Street1">Street 1 : </label> <?php echo $opInfo['Street1']; ?> 
                                    </div>
                                </div>  
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Street2">Street 2 : </label> <?php echo $opInfo['Street2']?> 
                                    </div>
                                </div>  
								
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="County">County : </label>  <?php echo $opInfo['County']; ?>  
                                    </div>
                                </div>  
                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town : </label> <?php echo $opInfo['Town']; ?> 
                                    </div>
                                </div>  
                                
                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code:  </label> <?php echo $opInfo['PostCode']; ?> 
                                    </div>
                                </div>             
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="careof">Care Of:  </label> <?php echo $opInfo['careof']?> 
                                    </div>
                                </div>             
                             
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="OpenDate"> Open Date: </label> <?php echo $opInfo['OpenDate1']; ?>  
                                    </div>
								</div>
                                <div class="col-md-6">								
									<div class="form-group">
                                        <label for="CloseDate"> Close Date: </label> <?php echo $opInfo['CloseDate1']; ?> 
                                    </div> 
								</div>  
                                <div class="col-md-6">	
									  <div class="form-group"> <label for="WIFRequired"> WIF Required ? : </label>  
										<?php echo $opInfo['WIFRequired']; ?>  
                                    </div>
								</div>	
								<div class="col-md-6">		
									<div class="form-group">
                                        <label for="WIF">WIF:  </label> <?php echo $opInfo['WIF']; ?> 
                                    </div>
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="TipTicketRequired"> TIP Ticket(S) Required ?  : </label>
										<?php  echo $opInfo['TipTicketRequired']; ?>   
                                    </div>
								</div>	
								<div class="col-md-6">			
									<div class="form-group">
                                        <label for="TipName">TIP NAME(S) :  </label> <?php echo $opInfo['TipName']?> 
                                    </div>
								</div>  
                                <div class="col-md-6">	
									<div class="form-group">
                                        <label for="StampRequired"> STAMP Required ? :  </label> 
										<?php echo $opInfo['StampRequired']; ?>    
                                    </div>
								</div>	
								<div class="col-md-6">			
									<div class="form-group">
                                        <label for="Stamp">STAMP  : </label> <?php echo $opInfo['Stamp']; ?> 
                                    </div>
                                </div> 
                            </div>
							<div class="row"> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="SiteInstRequired"> SITE INSTRUCTIONS Required ? :  </label>
										<?php echo $opInfo['SiteInstRequired']; ?>  
                                    </div>
								</div>	
								<div class="col-md-6">			
									<div class="form-group">
                                        <label for="SiteNotes">SITE INSTRUCTIONS Note(s) : </label> <?php echo $opInfo['SiteNotes']; ?> 
                                    </div> 
                                </div>  
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PORequired"> PO Required ? :  </label>
										<?php echo $opInfo['PORequired']; ?> 
                                    </div>
								</div>	
								<div class="col-md-6">			
									<div class="form-group">
                                        <label for="PO_Notes">PO Note(s)  :  </label> <?php echo $opInfo['PO_Notes']; ?> 
                                    </div>
                                </div>  
								<div class="col-md-6"> 
									<div class="form-group">
                                        <label for="AccountNotes">Account Note(s) : </label> <?php echo $opInfo['AccountNotes']?> 
                                    </div>
                                </div> 
								<div class="col-md-6"> 
									<div class="form-group">
                                        <label for="AccountNotes">ACT : </label> <?php if($opInfo['isAct']==1){ echo "Yes"; }else{ echo "NO";} ?> 
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                         
                </div>
            </div> 
        </div>   
    </section> 
</div> 
