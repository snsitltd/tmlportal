<?php 

//echo "<PRE>"; var_dump($Loads); var_dump($Photos);echo "</PRE>";
//var_dump($Photos) 
?>  
<div class="row">
<div class="col-md-12"> 
		<?php if($Photos){ if(count($Photos)>0){ 	//echo "<PRE>"; var_dump($Photos);echo "</PRE>"; ?>   
			<?php for($i=0;$i<count($Photos);$i++){ ?>
			 
			<a href="<?php echo base_url('uploads/Photo/'.$Photos[0]->ImageName); ?>"  target="_blank" ><img src="<?php echo base_url('uploads/Photo/'.$Photos[0]->ImageName); ?>" width="150" height="100"  alt="..." class="margin"> </a>
			  
			<?php } ?>  
		<?php }} ?>   
		
		<?php if($Images){ if(count($Images)>0){ 	//echo "<PRE>"; var_dump($Photos);echo "</PRE>"; ?>   
			<?php for($i=0;$i<count($Images);$i++){ ?>
			 
			<a href="<?php echo base_url('uploads/Photo/'.$Images[0]->ImageName); ?>"  target="_blank" ><img src="<?php echo base_url('uploads/Photo/'.$Images[0]->ImageName); ?>" width="150" height="100"  alt="..." class="margin"> </a>
			  
			<?php } ?>  
		<?php }} ?>   
</div> 
</div>  