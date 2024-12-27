 
<div class="content-wrapper"> 
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Lorry Management  <small>View Lorry</small> </h1>
    </section>
     <section class="content">
		 <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->    
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">  Lorry Details</h3>
                    </div>  
                        <div class="box-body">
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Driver Name  </label> <?php echo $driver['DriverName']; ?> 
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="RegNumber">Reg Number </label> <?php echo $driver['RegNumber']; ?> 
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Tare">Tare </label> <?php echo $driver['Tare']; ?> 
                                    </div> 
                                </div> 
                            </div>
							<div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="Haulier">Haulier  </label> <?php echo $driver['Haulier']; ?> 
                                    </div> 
                                </div> 
                            </div>  
							<br>
							<div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">   <?php if($driver['ltsignature']!=""){ ?>
									<label for="Haulier">Haulier  </label><br>
										<img src="<?php echo $driver['ltsignature']; ?>" height="400px" width="700px"><?php } ?> 
                                    </div>
                                </div>
                                                                  
                            </div>  
                        </div> 
                </div>
            </div> 
        </div>      
    </section> 
</div> 