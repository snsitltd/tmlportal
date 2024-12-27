<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper"> 
    <section class="content-header"><h1><i class="fa fa-users"></i> Opportunity Management <small>Add Product</small> </h1> </section> 
    <section class="content"> 
        <div class="row"> 
        <div class="col-md-12">
          <div class="nav-tabs-custom"> 
            <div class="tab-content">
              <div class="tab-pane active" id="activity">  
					  <?php echo validation_errors(); ?>
					  <?php $this->load->helper("form"); ?>
                    <form role="form" id="productSubmit" action="<?php echo base_url('Opportunity-AddProduct/'.$opInfo['OpportunityID']) ?>" method="post"  >
					<input type="hidden" name="OpportunityID" value="<?=$opInfo['OpportunityID']?>">
                       <div class="box-body">   
                            <div class="row">  
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="MaterialID">Product Code <span class="required" aria-required="true">*</span></label>
										<select class="form-control" id="MaterialID" name="MaterialID" required="required" data-live-search="true"  >
                                        <?php 
                                           echo '<option value="">-- SELECT PRODUCT CODE--</option>';
                                            foreach ($Material as $key => $value) {
                                               echo "<option value='".$value->MaterialID."'>".$value->MaterialCode." | ".$value->MaterialName."</option>";
                                            }
                                        ?>                                 
                                        </select> 
										<div></div>
                                    </div>
                                </div>  
								<div class="col-md-2">
                                    <div class="form-group">
                                        <label >Lorry Type <span class="required" aria-required="true">*</span></label>
										<select class="form-control" id="LorryType" name="LorryType"  data-live-search="true" required="required" >
											<option value="" > SELECT LorryType  </option>  
											<option value="1" > Tipper </option>  
											<option value="2" > Grab </option>  
											<option value="3" > Bin </option>  
                                        </select> 
										<div></div>
                                    </div>
                                </div>  
								 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Qty">Qty </label>
                                        <input type="text" class="form-control  " id="Qty" value=" " name="Qty" maxlength="128">
                                    </div>
                                </div>  
							</div>
                            <div class="row">	
								 <div class="col-md-6"> 
									<div class="form-group">
                                        <label for="DateRequired"> Date Required <span class="required" aria-required="true">*</span></label>
										<div class="input-group date">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                        <input type="text" class="form-control required" id="datepicker"   value="<?php echo date('d/m/Y'); ?>" name="DateRequired"  >
                                        </div> 
										<div></div>
                                    </div>
                                </div>  
								 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="UnitPrice">Price  <span class="required" aria-required="true">*</span></label>
                                        <input type="text" class="form-control required" id="UnitPrice" value=" " name="UnitPrice" maxlength="128">
                                    </div>
                                </div>  
							</div>
                            <div class="row">	
								 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="PurchaseOrderNo">Purchase Order No  </label>
                                        <input type="text" class="form-control  " id="PurchaseOrderNo" value=" " name="PurchaseOrderNo" maxlength="128">
                                    </div>
                                </div>  
								 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Job No  </label>
                                        <input type="text" class="form-control  " id="JobNo" value=" " name="JobNo" maxlength="128">
                                    </div>
                                </div>  
							</div>
                            <div class="row">	
								<div class="col-md-6">
									<div class="form-group">
											<label for="SiteNotes">Comments </label>
											<textarea class="form-control   " id="Comments" rows="3" name="Comments" ></textarea>
									</div>   
								</div>   
								<div class="col-md-6">
									<div class="form-group">
											<label for="Description">Product Description </label>
											<textarea class="form-control " id="Description" rows="3" name="Description" ></textarea>
									</div>   
								</div>     
								<div class="col-md-6">
									<div class="form-group">
										<label for="Description">Additional Product Info </label>
										<textarea class="form-control " id="ProductInfo" rows="3" name="ProductInfo" ></textarea>
									</div>   
								</div>     
                            </div>  
                        </div> 
                        <div class="box-footer">
                            <input type="submit" name="submit2" class="btn btn-primary" value="SAVE" />   
                        </div>  
						</form> 
              </div> 
              </div> 
          </div> 
        </div> 
        </div>    
    </section> 
</div> 

<script type="text/javascript" language="javascript" > 	
  

$(document).ready(function(){
	
	var productSubmit = $("#productSubmit");
	
	var validator = productSubmit.validate({

		ignore: [],	
		 validateNonVisibleFields: true,
            updatePromptsPosition:true,	
		rules:{ 
			MaterialID :{ required : true }, 
			DateRequired :{ required : true },
			UnitPrice : { required : true } 
		},
		messages:{ 
			MaterialID :{ required : "This field is required" }, 
			DateRequired :{ required : "This field is required" },
			UnitPrice : { required : "This field is required"}			 
		},
		errorPlacement: function(error, element) { 
			 if(element.attr("name") == "DateRequired"  ||element.attr("name") == "MaterialID" ) {
				error.appendTo( element.parent("div").next("div") );
			  } else {
				error.insertAfter(element);
			  }  
		} 
	});
	var MaterialID = $("#MaterialID");
    MaterialID.on('change',function(){
    var id=$(this).val();
    if(id!=''){
	       $.ajax({
		       url: baseURL+"/GetMaterialDetails",
		       type: "POST",
		       data:  {id:id},
		       
			   success: function(data)
			     { //alert(data);
			     	var obj = jQuery.parseJSON(data); 
                    $('#Description').val( obj.MaterialName ); 
			    },
			     error: function(e) 
			      {
			        $("#err").html(e).fadeIn();
			      }          
		    });
        }else{
        	$('#Description').val(''); 
        }
    });
	
	$('#datepicker').datepicker({  
		format: 'dd/mm/yyyy',  
		//daysOfWeekDisabled  : [0], 
		closeOnDateSelect: true
	}); 		 
	
});
</script>
 
