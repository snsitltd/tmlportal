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
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Opportunity details</a></li>
              <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Documents</a></li>  
              <li class=""><a href="#notes-tabs" data-toggle="tab" aria-expanded="false">Notes</a></li>  

            </ul>
			<form role="form" id="Opportunityubmit" action="<?php echo base_url() ?>editOpportunitysubmit" method="post" role="form" enctype="multipart/form-data">
            <div class="tab-content">

            

              <div class="tab-pane active" id="activity">

              <?php echo validation_errors(); ?>
              <?php $this->load->helper("form"); ?>
              
                    
                    <input type="hidden" name="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
                        <div class="box-body">

                         <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="CompanyID">Select Company <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control select_company" id="CompanyID" name="CompanyID">
                                            <option value="">Select Company</option>
                                            <?php

                                            if(!empty($company_list))
                                            {
                                                foreach ($company_list as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl['CompanyID'] ?>" <?php if($rl['CompanyID']==$opInfo['CompanyID']) echo "selected=selected";?> ><?php echo $rl['CompanyName'] ?></option>
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
                                        <select class="form-control" id="ContactID" name="ContactID">
                                            <option value="">Select Contact</option>
                                            <?php

                                            if(!empty($contact_list))
                                            {
                                                foreach ($contact_list as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl['ContactID'] ?>" <?php if($rl['ContactID']==$opInfo['ContactID']) echo "selected=selected";?> ><?php echo $rl['ContactName'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                </div>    
                            </div>


                            <div class="row">                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="OpportunityName">Site Address <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required OpportunityName" id="OpportunityName" value="<?=$opInfo['OpportunityName']?>" name="OpportunityName" maxlength="128">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Street1" id="Street1" value="<?=$opInfo['Street1']?>" name="Street1" maxlength="100">
                                    </div>
                                </div> 

                            </div>
                         
                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Street2" id="Street2" value="<?=$opInfo['Street2']?>" name="Street2" maxlength="100">
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required Town" id="Town" value="<?=$opInfo['Town']?>" name="Town">
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="County">County <span class="required" aria-required="true">*</span></label>                                        
                                        <select class="form-control required County" id="County" name="County">
                                            <option value="">Select County</option>
                                            <?php
                                            if(!empty($county))
                                            {
                                                foreach ($county as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == $opInfo['County']) {echo "selected=selected";} ?>><?php echo $rl->County ?></option>
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
                                        <input type="text" class="form-control required PostCode" id="PostCode" value="<?=$opInfo['PostCode']?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>                          
                                   
                            </div>  

                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="PO_Notes">PO Notes <span class="required" aria-required="true">*</span></label>                                     
                                        <textarea class="form-control required" id="PO_Notes"  name="PO_Notes" required="required" ><?=$opInfo['PO_Notes']?></textarea>
                                    </div>
                                </div>                               

                            </div>

                        </div><!-- /.box-body --> 

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />                            
                            <button onclick="location.href='<?php echo  base_url('opportunities')?>';" type="button" class="btn btn-warning">Back</button>
                        </div>

                       
                
              </div>
              <!-- /.tab-pane -->


              <div class="tab-pane" id="timeline">              

              <div class="row" style="margin-left:0px">


                <div class="col-md-12"><label>Company documnets  </label></div>

                            <?php
							 
                                if(!empty($documnetfiles))
                                {
                                    foreach ($documnetfiles as $key=>$rl)
                                    {
                                        ?>

                                <div class="row add-new-fields-fun" style="margin-left:0px">                               

                                
                                <div class="col-md-6"> 
                                    <div class="form-group"> 
                                        
                                        <span> <?=$key+1 ?>. <?php echo $rl->DocumentDetail ?> </span>                                     
                                        
                                    </div>
                                </div> 
								 <div class="col-md-2"> 
                                    <div class="form-group"> 
                                        
                                        <span> <?php if($rl->DocumentType == 1){ echo "WIF Form"; } if($rl->DocumentType == 2){ echo "Purchase Order"; } if($rl->DocumentType == 3){ echo "Quote"; } if($rl->DocumentType == 4){ echo "Others"; }  ?> </span>                                     
                                        
                                    </div>
                                </div> 
								
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        
                                        <a href="<?=base_url('assets/Documents/').$rl->DocumentAttachment?>" download >Download</a> |  <a href="<?=base_url('assets/Documents/').$rl->DocumentAttachment?>" target="_blank" >Preview</a> |  <a href="javascript:void(0)" id="<?php echo $rl->DocumentID ?>" class="remove-uploaded-doc">Remove</a>

                                    </div>
                                </div>                                

                            </div> 

                                       
                                        <?php
                                    }
                                }
                            ?> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="DocumentAttachment">Select Document</label>
                                        <input type="file" class="form-control" id="DocumentAttachment" name="DocumentAttachment[]" multiple>
                                    </div>
                                </div>  
								<div class="col-md-3">
                                    <div class="form-group">
                                        <label for="DocumentType">Document Type</label>
                                        <select class="form-control required County" id="DocumentType" name="DocumentType[]" aria-required="true">
                                            <option value="">Select Document Type</option>
											<option value="1">WIF Form</option> 
											<option value="2">Purchase Order</option> 
											<option value="3">Quote</option> 
											<option value="4">Others</option> 
										</select>
                                    </div>
                                </div>
                                <div class="col-md-3"> 
                                    <div class="form-group"> 
                                        <label for="DocumentDetail">Details</label>
                                        <input type="text" class="form-control" id="DocumentDetail" name="DocumentDetail[]">
                                        
                                    </div>
                                </div> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                          <br>
                                          <button class="btn btn-primary add-doc-fields-btn" type="button"> + Add New </button>
                                    </div>
                                </div> 
                </div> 

                <div class="add-fields-fun"></div>

                <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />                            
                            <button onclick="location.href='<?php echo  base_url('opportunities')?>';" type="button" class="btn btn-warning">Back</button>
                        </div>

           
              </div>              
              <!-- /.tab-pane --> 

               </form>

            

            <div class="tab-pane" id="notes-tabs">              

              <div class="row">
            <div class="col-md-6">

          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">All Note</h3>
            </div>
            <div class="box-body">

            <div class="row add-notes-fun">


            <?php
                    if(!empty($allnotes))
                    {
                        foreach ($allnotes as $rl)
                        { 

                           if($rl->NoteAttachement!="") $NoteAttachement = '<a href="'.base_url('assets/Notes/').$rl->NoteAttachement.'"> Download</a>';
                           else $NoteAttachement = 'No';
                            ?>

                         <div class="col-md-12">
                                  <div class="box box-success box-solid">
                                    <div class="box-header with-border">
                                      <h3 class="box-title"><?=$rl->name?></h3> 
                                      <!-- /.box-tools -->

                                      <div class="box-tools pull-right">                
                                   <button type="button" class="btn btn-box-tool remove-note-button" id="<?=$rl->NotesID?>" ><i class="fa fa-times"></i></button>
                                    </div>

                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                     <?=$rl->Regarding?> <span class="label <?=($rl->NoteType==1)?'label-warning':'label-info';?> pull-right"> <?=($rl->NoteType==1)?'Private':'Public';?> </span>
                                     <div> Attachement : <?=$NoteAttachement?> </div>
                                      <div> Date : <?=date("d-m-Y", strtotime($rl->CreateDate));?> </div>
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                        </div>
                                <!-- /.col -->  


                            <?php
                        }
                    }
            ?>
       
      </div>                          

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          </div>
        <!-- /.col (left) -->

        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Add New</h3>
            </div>
            <form role="form" id="addnewopportunitynote" action="#" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="OpportunityID" value="<?php echo $opInfo['OpportunityID'];?>">
                        <div class="box-body">

                        <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="NoteType">Note Type</label><br>
                                        <label class="radio-inline"><input type="radio" name="NoteType" checked value="0">Public</label>
                                        <label class="radio-inline"><input type="radio" name="NoteType" value="1">Private</label>                                      
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Regarding">Regarding</label>
                                        <textarea name="Regarding" id="Regarding" class="form-control required"></textarea>
                                    </div>
                                </div>                                
                                   
                            </div>

                         
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="NoteAttachement">Attachement</label>
                                        <input type="file" class="form-control required" id="NoteAttachement" name="NoteAttachement">
                                    </div>
                                </div>                                
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="IsActive">Status</label>
                                       <select class="form-control required" id="IsActive" name="IsActive">
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>                                            
                                        </select>
                                    </div>
                                </div>
                               
                                   
                            </div>
                           

                        </div><!-- /.box-body -->
                        
                       <div class="box-footer">
                            <input type="Submit" class="btn btn-primary submit-company-note" value="Submit" />
                            
                        </div>

                        </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        </div>
        <!-- /.col (right) -->
      </div>


              </div>
              <!-- /.tab-pane -->                 

               </div>
               <!-- /.tab-content -->
            
          </div>
          <!-- /.nav-tabs-custom -->
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
