<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Opportunity Management
        <small>Add / Edit Opportunity</small>
      </h1>
    </section> 
    <section class="content"> 
     <div class="row"> 
        <div class="col-md-12"> 
			<form name="frmop" id="Opportunityubmit" action="<?php echo base_url() ?>addnewOpportunitysubmit" method="post" role="form" enctype="multipart/form-data">
              
              <?php echo validation_errors(); ?>
              <?php $this->load->helper("form"); ?>
                   
                        <div class="box-body">

                         <div class="row">
                                    <div class="col-md-12">
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
                                    </div>
                                </div>    
                            </div>

                            <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="CompanyID">Select Contact <span class="required" aria-required="true">*</span></label>
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
                                        <label for="OpportunityName">Site Address <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required OpportunityName" id="OpportunityName" value="<?php echo set_value('OpportunityName'); ?>" name="OpportunityName" maxlength="128" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Street1" id="Street1" value="<?php echo set_value('Street1'); ?>" name="Street1" maxlength="100">
                                    </div>
                                </div> 

                            </div>
                         
                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Street2" id="Street2" value="<?php echo set_value('Street2'); ?>" name="Street2" maxlength="100">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Town" id="Town" value="<?php echo set_value('Town'); ?>" name="Town">
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
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
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == set_value('County')) {echo "selected=selected";} ?>><?php echo $rl->County ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                </div>

                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required PostCode" id="PostCode" value="<?php echo set_value('PostCode'); ?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>                          
                                   
                            </div>  

                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="PO_Notes">PO Notes <span class="required" aria-required="true">*</span></label>                                     
                                        <textarea class="form-control required" id="PO_Notes"  name="PO_Notes" ><?php echo set_value('PO_Notes'); ?></textarea>
                                    </div>
                                </div>                               

                            </div>

                            

                        </div><!-- /.box-body --> 
                
              </div>
               

                <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />  
                 
            </form>
         
        </div>          
           
        </div> 
           
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/Opportunity.js" type="text/javascript"></script>


<script>
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
});
</script>
