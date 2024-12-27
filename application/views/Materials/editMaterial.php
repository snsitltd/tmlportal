<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-users"></i> Material Management
        <small>Add / Edit Material</small>
      </h1>
    </section>


    <section class="content">
    
        <div class="row">

        <div class="col-md-12">
          <div class="nav-tabs-custom">
              

              <?php echo validation_errors(); ?>
              <?php $this->load->helper("form"); ?>
                    <form role="form" id="addnewmaterialsubmit" action="<?php echo base_url() ?>editmaterialsubmit" method="post" role="form">
                        <input type="hidden" name="MaterialID" value="<?php echo $mInfo->MaterialID;?>">
                        <div class="box-body">
							<div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Type">Material Type <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control " id="Type" name="Type" required="required" > 
                                            <option value="0" <?php if($mInfo->Type=='0') echo 'selected'; ?> >Non Hazardous </option>
                                            <option value="1" <?php if($mInfo->Type=='1') echo 'selected'; ?> >Hazardous </option> 
											<option value="2" <?php if($mInfo->Type=='2') echo 'selected'; ?> >Inert </option> 
											<option value="3" <?php if($mInfo->Type=='3') echo 'selected'; ?> >Material</option> 
											<option value="4" <?php if($mInfo->Type=='4') echo 'selected'; ?> >DayWork</option> 
											
                                        </select> 
									</div>
                                </div> 
							</div> 	 
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="MaterialName">Material Name <span class="required" aria-required="true">*</span></label>
                                         <input type="text" class="form-control required" value="<?php echo $mInfo->MaterialName;?>" id="MaterialName" name="MaterialName" maxlength="128">
                                    </div>
                                    
                                </div>
							</div>	
							<div class="row">
								<div class="col-md-2">
                                    <div class="form-group">
                                        <label for="MaterialCode">Material Code <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="MaterialCode" value="<?php echo $mInfo->MaterialCode;?>" name="MaterialCode" maxlength="20" >

                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">

                                        <label for="Operation">Operation <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control material-status" id="Operation" name="Operation" required="required" >
                                            <option value="">-- Select Operation--</option>
                                            <option value="IN" <?php if($mInfo->Operation=='IN') echo 'selected';?> >IN</option>
                                            <option value="OUT" <?php if($mInfo->Operation=='OUT') echo 'selected';?>>OUT</option>
                                            <option value="Collection" <?php if($mInfo->Operation=='Collection') echo 'selected';?> >Collection</option>                                            
                                        </select><div ></div>

                                    </div>
                                </div>
                             
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="SicCode">SIC Code <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control    " id="SicCode" value="<?php echo $mInfo->SicCode;?>" name="SicCode" maxlength="10"  >
                                    </div>
                                </div>
							</div>	
							<div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PriceID"> TML Price  </label>
                                         <select class="form-control" id="PriceID" name="PriceID"   >
                                            <?php foreach ($price_list as $key => $value) { ?>
                                             <option value="<?php echo $value['PriceID']?>" <?php if($value['PriceID']==$mInfo->PriceID) echo 'selected';?> ><?php echo $value['TMLPrice']?></option>
                                             <?php } ?>
                                        </select> 
                                    </div>
                                </div>
                                   
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <div class="checkbox"> 
                                        <label> <input type="checkbox" name="EAProduct" id="EAProduct"  value="1" <?php if($mInfo->EAProduct==1){ ?> checked <?php } ?>  > EA Product   </label> 
                                        </div>   
                                    </div>
                                </div>
                                   
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" /> 
						</div> 
                
             
           
               <!-- /.tab-content -->
            </form>
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
           
           
        </div>    
    </section>    

    
</div>
<script src="<?php echo base_url(); ?>assets/js/Materials.js" type="text/javascript"></script>