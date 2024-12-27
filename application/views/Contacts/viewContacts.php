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
            <div class="tab-content">
              <div class="tab-pane active" id="activity">
  
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="Title">Title : </label> <?php echo $cInfo['Title'];?> 
                                    </div>
                                    
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="ContactName">Contact Name :</label> <?php echo $cInfo['ContactName'];?>
                                    </div>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="PhoneNumber">Phone Number : </label> <?php echo $cInfo['PhoneNumber'];?>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="PhoneExtension">Phone Extension : </label><?php echo $cInfo['PhoneExtension'];?>
                                    </div>
                                </div>
                                   
                            </div>


                             <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="MobileNumber">Mobile Number : </label> <?php echo $cInfo['MobileNumber'];?> 
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="EmailAddress">Email Address  :</label> <?php echo $cInfo['EmailAddress'];?>
                                    </div>
                                </div>                           
                                   
                            </div>
 
                            <div class="row">                                
                               <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Position">Position  :</label> <?php echo $cInfo['Position'];?>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="Department">Department  :</label> <?php echo $cInfo['Department'];?> 
                                    </div>
                                </div> 
                            </div> 
                        </div> 
              </div> 
               </div> 
          </div> 
        </div> 
        </div>    
    </section>    
</div> 