<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Contact Management
        <small>Add / Edit Contact</small>
      </h1>
    </section>


    <section class="content">
    
        <div class="row">

        <div class="col-md-12">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab" aria-expanded="true">Contact details</a></li>
              <li class=""><a href="#timeline" data-toggle="tab" aria-expanded="false">Company details</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="activity">

              <?php echo validation_errors(); ?>
              <?php $this->load->helper("form"); ?>
                    <form role="form" id="contactsubmit" action="<?php echo base_url() ?>editContactsSubmit" method="post" role="form">
                        <input type="hidden" name="ContactID" value="<?php echo $cInfo['ContactID'];?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Title">Title <span class="required" aria-required="true">*</span></label>
                                         <input type="text" class="form-control required" value="<?php echo $cInfo['Title'];?>" id="Title" name="Title" maxlength="128">
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ContactName">Contact Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="ContactName" value="<?php echo $cInfo['ContactName'];?>" name="ContactName" maxlength="128">
                                    </div>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PhoneNumber">Phone Number <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required digits" id="PhoneNumber" value="<?php echo $cInfo['PhoneNumber'];?>" name="PhoneNumber" maxlength="10" minlength="10">

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PhoneExtension">Phone Extension <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required digits" id="PhoneExtension" value="<?php echo $cInfo['PhoneExtension'];?>" name="PhoneExtension" maxlength="10">
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="MobileNumber">Mobile Number <span class="required" aria-required="true">*</span></label>
                                      <input type="text" class="form-control required digits" id="MobileNumber" value="<?php echo $cInfo['MobileNumber'];?>" name="MobileNumber" maxlength="10" minlength="10" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="EmailAddress">Email Address <span class="required" aria-required="true">*</span></label>
                                        <input type="email" class="form-control required email" id="EmailAddress" value="<?php echo $cInfo['EmailAddress'];?>" name="EmailAddress" maxlength="100">
                                    </div>
                                </div>                           
                                   
                            </div>


                            <div class="row">                               

                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Position">Position <span class="required" aria-required="true">*</span></label>
                                         <input type="text" class="form-control required" id="Position" value="<?php echo $cInfo['Position'];?>" name="Position" maxlength="100">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Department">Department <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control" id="Department" value="<?php echo $cInfo['Department'];?>" name="Department" maxlength="100">
                                    </div>
                                </div>
                                   
                            </div>

                        </div><!-- /.box-body -->
                        
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <button onclick="location.href='<?php echo  base_url('contacts')?>';" type="button" class="btn btn-warning">Back</button>
                  </div> 
                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">

               <div class="box-body">

               <?php //print_r($company_list);die; ?>

                <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="CompanyID">Select Company <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control select_company" id="CompanyID" name="CompanyID">
                                            <option value="0">Select Company</option>
                                            <?php

                                            if(!empty($company_list))
                                            {
                                                foreach ($company_list as $rl)
                                                {
                                                    ?>
                                                    <option value="<?php echo $rl['CompanyID'] ?>" <?php if($rl['CompanyID']==$cInfo['CompanyID']) echo "selected=selected";?> ><?php echo $rl['CompanyName'] ?></option>
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
                                        <label for="fname">Company Name</label>
                                        <input type="text" class="form-control required CompanyName" value="<?php echo $cInfo['CompanyName'];?>" id="CompanyName" name="CompanyName" maxlength="128">
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="text" class="form-control required email EmailID" id="EmailID" value="<?php echo $cInfo['EmailID'];?>" name="EmailID" maxlength="128">
                                    </div>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street1">Street 1</label>
                                        <input type="text" class="form-control required Street1" id="Street1" value="<?php echo $cInfo['Street1'];?>" name="Street1" maxlength="100">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Street2">Street 2</label>
                                        <input type="text" class="form-control required Street2" id="Street2" value="<?php echo $cInfo['Street2'];?>" name="Street2" maxlength="100">
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Town">Town</label>
                                        <input type="text" class="form-control required Town" id="Town" value="<?php echo $cInfo['Town'];?>" name="Town">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="County">County</label>                                        
                                        <select class="form-control required County" id="County" name="County">
                                            <option value="">Select County</option>
                                            <?php
                                            if(!empty($county))
                                            {
                                                foreach ($county as $rl)
                                                { 
                                                    ?>
                                                    <option value="<?php echo $rl->County ?>" <?php if($rl->County == $cInfo['County']) {echo "selected=selected";} ?>><?php echo $rl->County ?></option>
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
                                        <label for="PostCode">Post Code</label>
                                        <input type="text" class="form-control required PostCode" id="PostCode" value="<?php echo $cInfo['PostCode'];?>" name="PostCode" maxlength="20">
                                    </div>
                                </div>

                               <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Phone1">Mobile Number 1</label>
                                        <input type="text" class="form-control required digits Phone1" id="Phone1" value="<?php echo $cInfo['Phone1'];?>" name="Phone1" maxlength="10">
                                    </div>
                                </div>
                                   
                            </div>



                            <div class="row">                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Phone2">Mobile Number 2</label>
                                        <input type="text" class="form-control digits Phone2" id="Phone2" value="<?php echo $cInfo['Phone2'];?>" name="Phone2" maxlength="10">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Fax">Fax</label>
                                        <input type="text" class="form-control required Fax" id="Fax" value="<?php echo $cInfo['Fax'];?>" name="Fax" maxlength="20">
                                    </div>
                                </div>
                                   
                            </div>

                            <div class="row">                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Website">Website</label>
                                        <input type="text" class="form-control Website" id="Website" value="<?php echo $cInfo['Website'];?>" name="Website" maxlength="100">
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Country">Country</label>
                                        <select class="form-control Country required" id="Country" name="Country">
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
                            

                        </div><!-- /.box-body -->  

                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <button onclick="location.href='<?php echo  base_url('contacts')?>';" type="button" class="btn btn-warning">Back</button>
                  </div>
               
              </div>
              <!-- /.tab-pane --> 
                               

               </div>
               <!-- /.tab-content -->
            </form>
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
           
           
        </div>    
    </section>    

    
</div>
<script src="<?php echo base_url(); ?>assets/js/Contacts.js" type="text/javascript"></script>