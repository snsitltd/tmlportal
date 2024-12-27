<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1><i class="fa fa-users"></i> Opportunity Management  <small>Add / Edit Opportunity</small> </h1>
    </section> 
    <section class="content"> 
     <div class="row"> 
        <div class="col-md-12"> 
             <div class="box box-primary"> 
				<form name="frmop" id="Opportunitysubmit" action="<?php echo base_url() ?>Add-Opportunity" method="post" role="form" >
				  <?php echo validation_errors(); ?>
				  <?php $this->load->helper("form"); ?> 
                        <div class="box-body"> 
                         <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="CompanyID">Select Company <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control select_company" id="CompanyID" name="CompanyID"  data-live-search="true" >
                                            <option value="">Select Company</option>
                                            <?php

                                            if(!empty($company_list))
                                            {
                                                foreach ($company_list as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl['CompanyID'] ?>"><?php echo $rl['CompanyName'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
										<div ></div>

                                    </div>
                                </div>    
                             
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="CompanyID">Select Contact</label>
                                        <select class="form-control select_contact" id="ContactID" name="ContactID"  data-live-search="true" >
                                            <option value="">Select Contact</option> 
                                            <?php

                                            /*if(!empty($contact_list))
                                            {
                                                foreach ($contact_list as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl['ContactID'] ?>"><?php echo $rl['ContactName'] ?></option>
                                                    <?php
                                                }
                                            }*/
                                            ?>
                                                                                        
                                        </select>
                                    </div>
                                </div>    
                            </div>


                            <div class="row">                               
 
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Street1" id="Street1" value="<?php echo set_value('Street1'); ?>" name="Street1" maxlength="100">
                                    </div>
                                </div> 
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="County">County <span class="required" aria-required="true">*</span></label>                                        
                                        <select class="form-control required County" id="County" name="County"  data-live-search="true" >
                                            <option value="">Select County</option>
                                            <?php
                                            if(!empty($county))
                                            {
                                                foreach ($county as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == set_value('County')) { ?> selected <?php } ?> ><?php echo $rl->County ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select><div ></div>

                                    </div>
                                </div>  
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Town">Town <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Town" id="Town" value="<?php echo set_value('Town'); ?>" name="Town">
                                    </div>
                                </div>  
								
                            </div>
                         
                            <div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2 </label>
                                        <input type="text" class="form-control Street2" id="Street2" value="<?php echo set_value('Street2'); ?>" name="Street2" maxlength="100">
                                    </div>
                                </div> 
								
                                 

                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required PostCode" id="PostCode" value="<?php echo set_value('PostCode'); ?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>   
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="careof">Care Of  </label>
                                        <input type="text" class="form-control " id="careof" value="<?php echo set_value('careof'); ?>" name="careof" maxlength="100">
                                    </div>
                                </div>  
                            </div>
 
							<div class="row"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="OpenDate"> Open Date  </label>
										<div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                        <input type="text" class="form-control " id="datepicker3" readonly value="<?php echo date('d/m/Y'); ?>" name="OpenDate"  >
                                        </div> 
                                    </div>
									<!-- <div class="form-group">
                                        <label for="CloseDate"> Close Date  </label>
										<div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                        <input type="text" class="form-control  " id="datepicker4" value="<?php //echo date('d/m/Y'); ?>" name="CloseDate"  >
                                        </div> 
                                    </div> -->
								 
									<div class="form-group">
                                        <label for="WIFRequired"> WIF Required ?  </label>
										<select class="form-control  " id="WIFRequired" name="WIFRequired"  data-live-search="true" >
                                            <option value="0">TBA</option>
											<option value="1">Yes</option>
											<option value="2">No</option>
										</select>	
                                    </div> 
                                 	 
									<div class="form-group">
                                        <label for="WIF">WIF  </label>
                                        <input type="text" class="form-control  " id="WIF" value="<?php echo set_value('WIF'); ?>" name="WIF" >
                                    </div>
                                </div> 		
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="TipTicketRequired"> TIP Ticket(S) Required ? </label>
										<select class="form-control  " id="TipTicketRequired" name="TipTicketRequired"  data-live-search="true" >
                                            <option value="0">TBA</option>
											<option value="1">Yes</option>
											<option value="2">No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="TipName">TIP NAME(S) </label>
                                        <textarea  class="form-control  " id="TipName"  name="TipName" rows="3" ><?php echo set_value('TipName'); ?> </textarea>
                                    </div>
								</div>  
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="SiteInstRequired"> SITE INSTRUCTIONS Required ?   </label>
										<select class="form-control " id="SiteInstRequired" name="SiteInstRequired"  data-live-search="true" >
                                            <option value="0">TBA</option>
											<option value="1">Yes</option>
											<option value="2">No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="SiteNotes">SITE INSTRUCTIONS Note(s)  </label>
                                        <textarea class="form-control  " id="SiteNotes"  rows="3" name="SiteNotes" ><?php echo set_value('SiteNotes'); ?></textarea>
                                    </div> 
                                </div>  
								 <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="PORequired"> PO Required ?  </label>
										<select class="form-control    " id="PORequired" name="PORequired"  data-live-search="true" >
                                            <option value="0">TBA</option>
											<option value="1">Yes</option>
											<option value="2">No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="PO_Notes">PO Note(s)  </label>
                                        <textarea class="form-control  " id="PO_Notes"  rows="3" name="PO_Notes" ><?php echo set_value('PO_Notes'); ?></textarea>
                                    </div>
                                </div> 
                               
                            </div>
							<div class="row"> 
                                 <div class="col-md-3">	
									<div class="form-group">
                                        <label for="StampRequired"> STAMP Required ?  </label>
										<select class="form-control  " id="StampRequired" name="StampRequired"  data-live-search="true" >
                                            <option value="0">TBA</option>
											<option value="1">Yes</option>
											<option value="2">No</option>
										</select>	
                                    </div>
									<div class="form-group">
                                        <label for="Stamp">STAMP   </label>
                                        <input type="text" class="form-control  " id="Stamp" value="<?php echo set_value('Stamp'); ?>" name="Stamp" >
                                    </div>
                                </div> 
                               
								<div class="col-md-3"> 
									<div class="form-group">
                                        <label for="AccountNotes">Account Note(s) </label>
                                        <textarea class="form-control  " id="AccountNotes" rows="3" name="AccountNotes" ><?php echo set_value('AccountNotes'); ?></textarea>
                                    </div>
                                </div> 
								
								<div class="col-md-3">	
									<div class="form-group">
                                        <label for="ContactName">Contact Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="ContactName" value="<?php echo set_value('ContactName'); ?>" name="ContactName" maxlength="128">
                                    </div> 
									<div class="form-group">
                                        <label for="EmailAddress">Email Address  </label>
                                        <input type="email" class="form-control email" id="EmailAddress" value="<?php echo set_value('EmailAddress'); ?>" name="EmailAddress" maxlength="100">
                                    </div>
                                </div> 
								<div class="col-md-3">	
									 
									<div class="form-group">
                                        <label for="MobileNumber">Mobile Number <span class="required" aria-required="true">*</span></label>   
                                        <input type="text" class="form-control required digits" id="MobileNumber" value="<?php echo set_value('MobileNumber'); ?>" name="MobileNumber" maxlength="12" >
                                    </div>
									 
                                </div> 
								
                            </div>
							
                              
                        </div><!-- /.box-body --> 
						<div class="box-footer">
                            <input type="submit" name="submit" class="btn btn-primary" value="Submit" /> 
						</div>
                </form>   
			</div>      
		</div>           
        </div>  
    </section> 
</div>
<script src="<?php echo base_url(); ?>assets/js/Opportunity.js" type="text/javascript"></script>


<script>
/*
$(document).ready(function(){
    
  $(".PostCode,.County,.Town,.Street2,.Street1").blur(function(){

    var name = "";
    var Street1 = $(".Street1").val();
    var Street2 = $(".Street2").val();
    var Town = $(".Town").val();
    var County = $(".County").val();
    var PostCode = $(".PostCode").val();

    if(Street1!='') name += Street1+', ';
    if(Street2!='') name += Street2+', ';
    if(Town!='') name += Town+', ';
    if(County!='') name += County+', ';
    if(PostCode!='') name += PostCode;
    $('.OpportunityName').val(name);    
  });
});*/
</script>
