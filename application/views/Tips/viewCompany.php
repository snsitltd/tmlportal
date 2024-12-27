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
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url('edit-company/'.$cInfo['CompanyID']); ?>"><i class="fa fa-plus"></i> Edit Company</a>
                </div>
            </div>
        </div>
        <div class="row">

        <div class="col-md-12">
          <div class="nav-tabs-custom"> 
            <div class="tab-content">
              <div class="tab-pane active" id="activity"> 
                        <div class="box-body">

                        <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Company Name: </label> <?php echo $cInfo['CompanyName'];?> 
                                    </div>
                                    
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email">Email address: </label> <?php echo $cInfo['EmailID']; ?> 
                                    </div>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Street1">Street 1: </label> <?php echo $cInfo['Street1'];?> 
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Street2">Street 2: </label> <?php echo $cInfo['Street2'];?> 
                                    </div>
                                </div>
                                   
                            </div> 
                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Town">Town: </label> <?php echo $cInfo['Town'];?> 
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="County">County: </label> <?php $cInfo['County']; ?>  
                                    </div>
                                </div>
                                   
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="PostCode">Post Code: </label> <?php echo $cInfo['PostCode'];?> 
                                    </div>
                                </div>

                               <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Phone1">Mobile Number 1: </label> <?php echo $cInfo['Phone1'];?> 
                                    </div>
                                </div>
                                   
                            </div>



                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Phone2">Mobile Number 2: </label> <?php echo $cInfo['Phone2'];?> 
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Fax">Fax: </label> <?php echo $cInfo['Fax'];?> 
                                    </div>
                                </div>
                                   
                            </div>

                            <div class="row">                               

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Website">Website :</label> <?php echo $cInfo['Website'];?> 
                                    </div>
                                </div>  

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Country">Country: </label> <?php echo $cInfo['CountryCode']; ?> 
                                    </div>
                                </div> 
                            </div>  

                        </div><!-- /.box-body --> 
                
              </div>                      
            

         
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
           
           
        </div>    
    </section>
    
</div> 