<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Company Management
        <small>Add / Edit Company</small>
      </h1>
    </section>

     <section class="content">
    
        <div class="row">

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Company details</a></li>               
              <li class=""><a href="#notes-tabs" data-toggle="tab" aria-expanded="false">Notes</a></li>    
			  <?php if($cInfo['SageURL']!=''){ ?>
				<li ><a href="<?php echo base_url('SageCompany/'.$cInfo['CompanyID']); ?>"   > SAGE (<?php echo $cInfo['AccountRef'];?>)</a></li>         
			  <?php } ?>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="activity">

              <?php echo validation_errors(); ?>
              <?php $this->load->helper("form"); ?>
                    <form role="form" id="addnewcompanysubmit" action="<?php echo base_url() ?>editCompanySubmit" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="CompanyID" value="<?php echo $cInfo['CompanyID'];?>">
                        <div class="box-body"> 
						<div class="row">
							<div class="col-md-3">                                
								<div class="form-group">
									<label for="fname">Company REF  </label>
									<input type="text" class="form-control " value="<?php echo $cInfo['AccountRef'];?>" id="AccountRef" name="AccountRef" maxlength="255">
								</div> 
							</div>      
                         
							<div class="col-md-3">
								<div class="form-group">
									<label for="Status">Status</label>
								   <select class="form-control required" id="Status" name="Status">
										<option value="1" <?php if($cInfo['Status']==1){ ?> selected <?php } ?> >Active</option>
										<option value="0" <?php if($cInfo['Status']==0){ ?> selected <?php } ?>  >InActive</option>                                            
									</select>
								</div>
							</div> 
						</div> 	
                        <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Company Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo $cInfo['CompanyName'];?>" id="CompanyName" name="CompanyName" maxlength="128">
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address  </label>
                                        <input type="email" class="form-control   email" id="EmailID" value="<?php echo $cInfo['EmailID'];?>" name="EmailID" maxlength="128">
                                    </div>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1 <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="Street1" value="<?php echo $cInfo['Street1'];?>" name="Street1" maxlength="100">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2  </label>
                                        <input type="text" class="form-control  " id="Street2" value="<?php echo $cInfo['Street2'];?>" name="Street2" maxlength="100">
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="Town" value="<?php echo $cInfo['Town'];?>" name="Town">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="County">County <span class="required" aria-required="true">*</span></label>                                        
                                        <select class="form-control required" id="County" name="County"  data-live-search="true" >
                                            <option value="">Select County</option>
                                            <?php
                                            if(!empty($county))
                                            {
                                                foreach ($county as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == $cInfo['County']) { echo "selected=selected";} ?>><?php echo $rl->County ?></option>
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
                                        <label for="PostCode">Post Code  </label>
                                        <input type="text" class="form-control  " id="PostCode" value="<?php echo $cInfo['PostCode'];?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>

                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Phone1">Mobile Number 1  </label>
                                        <input type="text" class="form-control   digits" id="Phone1" value="<?php echo $cInfo['Phone1'];?>" name="Phone1" maxlength="11" minlength="11">
                                    </div>
                                </div>
                                   
                            </div>



                            <div class="row">                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Phone2">Mobile Number 2</label>
                                        <input type="text" class="form-control digits" id="Phone2" value="<?php echo $cInfo['Phone2'];?>" name="Phone2" maxlength="11" minlength="11">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Fax">Fax </label>
                                        <input type="text" class="form-control  " id="Fax" value="<?php echo $cInfo['Fax'];?>" name="Fax" maxlength="11">
                                    </div>
                                </div>
                                   
                            </div>

                            <div class="row">                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Website">Website (eg. http://example.com/)</label>
                                        <input type="text" class="form-control" id="Website" value="<?php echo $cInfo['Website'];?>" name="Website" maxlength="100">
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Country">Country <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control required" id="Country" name="Country"  data-live-search="true" >
                                            <option value="">Select Country</option>
                                            <?php
                                            if(!empty($country))
                                            {
                                                foreach ($country as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl->country_code ?>" <?php if($rl->country_code == $cInfo['CountryCode']) {echo "selected=selected";} ?>><?php echo $rl->country_name ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                   
                            </div>
                            <hr>
							<h3> Sage Details </h3>
							 <div class="row">  
                                <div class="col-md-4">
								
                                    <div class="form-group">
										<div class="checkbox">  
											<label> <input type="radio" name="PaymentType" id="PaymentType" value="1" <?php if($cInfo['PaymentType']==1){ echo "checked"; } ?>  > Credit  </label>
											<label> <input type="radio" name="PaymentType" id="PaymentType"  value="2" <?php if($cInfo['PaymentType']==2){ echo "checked"; } ?> > Cash  </label> 
											<!-- <label> <input type="radio" name="PaymentType" id="PaymentType"  value="3" <?php if($cInfo['PaymentType']==3){ echo "checked"; } ?> > Card </label> -->
                                        </div> 
                                        <!--<label for="PaymentType">Payment Type</label>
                                        <input type="text" class="form-control" id="PaymentType" value="<?php echo $cInfo['PaymentType'];?>" name="PaymentType" maxlength="100"> -->
                                    </div>
                                </div>  

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="CreditLimit">Creditlimit</label>
                                        <input type="text" class="form-control" id="CreditLimit" value="<?php echo $cInfo['CreditLimit'];?>" name="CreditLimit" maxlength="100">
                                    </div>
                                </div>  
								
								<div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Outstanding">Outstanding</label>
                                        <input type="text" class="form-control" id="Outstanding" value="<?php echo $cInfo['Outstanding'];?>" name="Outstanding" maxlength="100">
                                    </div>
                                </div>  

                                   
                            </div>
							<hr>
							
                           <div class="col-md-12"><label>Company documnets  </label></div>

                            <?php
                                if(!empty($documnetfiles))
                                {
                                    foreach ($documnetfiles as $key=>$rl)
                                    {
                                        ?>

                                <div class="row add-new-fields-fun">  

                                <div class="col-md-2"> 
                                   
                                </div>                              

                               

                                <div class="col-md-4"> 
                                    <div class="form-group"> 
                                        
                                        <span> <?=$key+1?>. <?php echo $rl->DocumentDetail ?> </span>                                     
                                        
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


                              <div class="row">                               

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="DocumentAttachment">Select Document</label>
                                        <input type="file" class="form-control" id="DocumentAttachment" name="DocumentAttachment[]">
                                    </div>
                                </div>  

                                <div class="col-md-4"> 
                                    <div class="form-group"> 
                                        <label for="DocumentDetail">Details</label>
                                        <input type="text" class="form-control" id="DocumentDetail" name="DocumentDetail[]">
                                        
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                          <br>
                                          <button class="btn btn-primary add-doc-fields-btn" type="button"> + Add New </button>
                                    </div>
                                </div>

                            </div> 

                <div class="add-fields-fun"></div>

                           

                        </div><!-- /.box-body -->
                        
                       <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                             <button onclick="location.href='<?php echo  base_url('companies')?>';" type="button" class="btn btn-warning">Back</button>
                        </div>

                          </form>
                
              </div>                      
            

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
                                     <?=$rl->Regarding?> <span class="label <?=($rl->NoteType==1)?'label-warning':'label-info';?>   pull-right"> <?=($rl->NoteType==1)?'Private':'Public';?> </span>
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
            <form role="form" id="addnewcompanynote" action="#" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="CompanyID" value="<?php echo $cInfo['CompanyID'];?>">
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

                 

               </div>
               <!-- /.tab-content -->
            
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
           
           
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/Company.js" type="text/javascript"></script>