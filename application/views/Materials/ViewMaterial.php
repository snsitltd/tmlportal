<div class="content-wrapper"> 
    <section class="content-header">
      <h1> <i class="fa fa-users"></i> Material Management <small>View Material</small> </h1>
    </section> 
    <section class="content"> 
        <div class="row"> 
        <div class="col-md-12">
          <div class="nav-tabs-custom">   
			<div class="box-body">
				<div class="row">
					<div class="col-md-6">                                
						<div class="form-group">
							<label for="MaterialName">Material Name </label> <?php echo $mInfo['MaterialName'];?>
						</div>  
						<div class="form-group">
							<label for="MaterialName">Material Code </label> <?php echo $mInfo['MaterialCode'];?>
						</div>  
						<div class="form-group"> 
							<label for="Operation">Operation </label> 
							<?php if($mInfo['Operation']=='IN'){ echo "IN"; } 
							if($mInfo['Operation'] =='OUT'){ echo "OUT"; } 
							if($mInfo['Operation'] =='Collection'){ echo "Collection"; } ?>  
						</div> 
						<div class="form-group">
							<label for="SicCode">SIC Code </label> <?php echo $mInfo['SicCode'];?>  
						</div> 
						<div class="form-group">
							<label for="PriceID"> TML Price </label> <?php echo $mInfo['TMLPrice'];?>  
						</div>
					</div> 
				</div> 
			</div>  
          </div> 
        </div>
        </div>    
    </section>    
</div> 