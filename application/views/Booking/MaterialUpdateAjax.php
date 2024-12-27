    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-select.css'); ?>">    
    <script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script>
    <script>
    	$(function () {  $('select').selectpicker();  }) 	
    </script> 
    <?php $status = 1; //if($MaterialID > 416){  $status = 1; }else{ $status = 0; } //echo $status;  ?>
    
    <form id="MaterialUpdate" name="MaterialUpdate" action="<?php echo base_url('MaterialUpdate/'.$LoadID); ?>" method="post" role="form" >    
    <input type="hidden"  id="LoadID"  value="<?php echo $LoadID; ?>" name="LoadID">  
    <div class="row">  
    	<div class="col-md-12"> 
    		<div>
    			<select  class="form-control tiplst1 selectpicker " required data-live-search="true" style="width:120px" id="MaterialID1" name="MaterialID1"  >
    					<option value="" >Select Material</option>
    			<?php if(!empty($MaterialRecords)){ 
    			        foreach ($MaterialRecords as $rl){ 
    			            if($MaterialID!=$rl->MaterialID){ 
    			                if($rl->Status == $status){  
    					            if($rl->MaterialID == '494' || $rl->MaterialID == '495' ){ }else{ ?>
    					                <option value="<?php echo $rl->MaterialID ?>" ><?php  echo $rl->MaterialName ?></option>
    			       <?php }} }}} ?>
    			</select>
    		</div> 
    	</div>  
    	<br><br><br>
    	<div class="col-md-12">
    		<button class="btn btn-primary  " type="submit" name="submit" >  Update Material </button>  
    	</div>   
    </div>
    </form>
     