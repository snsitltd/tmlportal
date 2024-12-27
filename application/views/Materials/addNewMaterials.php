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
                    <form role="form" id="addnewmaterialsubmit" action="<?php echo base_url() ?>addnewmaterialsubmit" method="post" role="form">
                        <div class="box-body">
							<div class="row">
								<div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Type">Material Type <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control " id="Type" name="Type" required="required" > 
                                            <option value="0">Non Hazardous </option>
                                            <option value="1">Hazardous </option>  
											<option value="2">Inert</option>   
											<option value="3">Material</option>   
											<option value="4">DayWork</option>   
                                        </select> 
									</div>
                                </div> 
							</div> 	 
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="MaterialName">Material Name <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" value="<?php echo set_value('MaterialName'); ?>" id="MaterialName" name="MaterialName" maxlength="128">
                                    </div>
                                    
                                </div>
							</div>
							<div class="row">
								<div class="col-md-2">
                                    <div class="form-group">
                                        <label for="MaterialCode">Material Code <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="MaterialCode" value="<?php echo set_value('MaterialCode'); ?>" name="MaterialCode" maxlength="20" >

                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="Operation">Operation <span class="required" aria-required="true">*</span></label>
                                        <select class="form-control material-status" id="Operation" name="Operation" required="required" >
                                            <option value="">-- Select Operation--</option>
                                            <option value="IN">IN</option>
                                            <option value="OUT">OUT</option>
                                            <option value="Collection">Collection</option>                                           
                                        </select><div ></div>

                                    </div>
                                </div> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="SicCode">SIC Code <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="SicCode" value="<?php echo set_value('SicCode'); ?>" name="SicCode" maxlength="10"  >

                                    </div>
                                </div> 
							</div> 
							
                            <div class="row priceRow">
                                <div class="col-md-1" style="width: 0px;">
                                    <div class="form-group">
                                        <label for="defualt_0">&nbsp;</label><br>
                                       <input type="checkbox"  id="defualt_0" value="0" name="price[0][defualt]" title="Defualt" checked="checked" >

                                    </div>
                                </div>

                                <div class="col-md-2">                                
                                    <div class="form-group">
                                        <label for="TMLPrice_0">TML Price  </label>
                                        <input type="text" class="form-control   number" id="TMLPrice_0" name="price[0][TMLPrice]" maxlength="10">
                                    </div>
                                    
                                </div>

                                <!--<div class="col-md-2">
                                    <div class="form-group">
                                        <label for="CustPrice_0">Customer Price <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required number" id="CustPrice_0" name="price[0][CustPrice]" maxlength="10">

                                    </div>
                                </div>-->

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="StartDate_0">Start Date </label>
                                        <input type="text" class="form-control   datepicker" id="StartDate_0"  name="price[0][StartDate]" maxlength="10">

                                    </div>
                                </div>

                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="EndDate">End Date  </label>
                                        <input type="text" class="form-control   datepicker" id="EndDate_0" name="price[0][EndDate]" maxlength="10">

                                    </div>
                                </div>

                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <i class="fa fa-plus-circle add-new-price" style="font-size: 35px; color: green"></i>

                                    </div>
                                </div>

                            </div>



                            <div class="fun-row-price"></div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <div class="checkbox"> 
                                        <label> <input type="checkbox" name="EAProduct" id="EAProduct"  value="1" > EA Product   </label> 
                                        </div>   
                                    </div>
                                </div>
                                   
                            </div> 
                        </div><!-- /.box-body -->                
              
         
                 <div class="box-footer"> <input type="submit" class="btn btn-primary" value="Submit" />  </div>

             
               <!-- /.tab-content -->
            </form>
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
           
           
        </div>    
    </section>
    
</div>
<script src="<?php echo base_url(); ?>assets/js/Materials.js" type="text/javascript"></script>