<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
<i class="fa fa-users"></i> User Roles
<small>Edit Roles</small>
</h1>
</section>

<section class="content">

<div class="row">
<!-- left column -->
<div class="col-md-8">
<!-- general form elements -->                


<div class="box box-primary">
<div class="box-header">
	<h3 class="box-title">Enter Roles Details</h3>
</div><!-- /.box-header -->
<!-- form start -->
<div class="col-md-4">
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if($error)
{
?>
<div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo $this->session->flashdata('error'); ?>                    
</div>
<?php } ?>
<?php  
$success = $this->session->flashdata('success');
if($success)
{
?>
<div class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
<?php echo $this->session->flashdata('success'); ?>
</div>
<?php } ?>

<div class="row">
<div class="col-md-12">
	<?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
</div>
</div>
</div>
<form role="form" action="<?php echo base_url() ?>editrolessubmit" method="post" id="editrolessubmit" role="form">
	<div class="box-body">
		<div class="row">
			<div class="col-md-3">                                
				<div class="form-group">
					<label for="role">Role <span class="required" aria-required="true">*</span></label>
					<input type="text" class="form-control" id="role" placeholder="User Role" name="role" value="<?php echo $rolesInfo['role']; ?>" maxlength="128" required>
					<input type="hidden" value="<?php echo $rolesInfo['roleId']; ?>" name="roleId" id="roleId" />    
				</div>
				
			</div>
			<div class="col-md-3">	
				<div class="form-group">
					<label for="role">Logout Time </label>
					<select class="form-control" id="logout_time" name="logout_time"  data-live-search="true"   > 
						<option value="1" <?php if($rolesInfo['logout_time']==1){ ?> selected="selected" <?php } ?> >Default</option>  
						<option value="2"  <?php if($rolesInfo['logout_time']==2){ ?> selected="selected" <?php } ?>  >Always ON</option>  
					</select> 
				</div>
			</div> 
		  
		</div> 


		<div class="row">
			<div class="col-md-12">                                
				<div class="form-group">
					<label for="role">Permission</label> <br>
					 <?php if($rolesInfo['role_permission']=='') $role_permission = array();
						   else  $role_permission = json_decode($rolesInfo['role_permission']);
					  ?>

					  <table class="table table-bordered"> 
					  <tr>
					  <th>Module Name</th>
						  <th class="text-center" width="100" >View</th>
						  <th class="text-center" width="100" >Add</th>
						  <th class="text-center" width="100" >Edit</th>
						  <th class="text-center" width="100" >Delete</th>
						  <th class="text-center" width="100" >Approve</th>
						  <th class="text-center" width="100" >Price Approve</th>
						  <th class="text-center" width="100" >Invoice Approve</th>
					  </tr> 
					  <?php foreach (MODULE_ARRAY as $key) { ?>                                          
						
<tr> 
	<td><label><?php if(ucfirst($key)=='Schedule'){ echo "Cron"; }else{ echo ucfirst($key); }?> : </label> </td> 
	<td class="text-center"><input type="hidden" name="role_permission[<?php echo $key;?>][view]" value="0"> 
	<?php if(ucfirst($key)!='Schedule'){  ?>
	<input type="checkbox" id="role_permission" name="role_permission[<?php echo $key;?>][view]" value="1" <?php if(isset($role_permission->$key->view)){ if($role_permission->$key->view==1){  echo 'checked'; }}?> >  
	<?php } ?>
	</td>
	<td class="text-center"><input type="hidden" name="role_permission[<?php echo $key;?>][add]" value="0">
	<?php if(ucfirst($key)!='Schedule'){  ?>
	<input type="checkbox" id="role_permission" name="role_permission[<?php echo $key;?>][add]" value="1" <?php if(isset($role_permission->$key->add)){ if($role_permission->$key->add==1){ echo 'checked'; }}?>>   
	<?php } ?>
	</td>
	<td class="text-center"> <input type="hidden" name="role_permission[<?php echo $key;?>][edit]" value="0"> 
	<input type="checkbox" id="role_permission" name="role_permission[<?php echo $key;?>][edit]" value="1" <?php if(isset($role_permission->$key->edit)){ if($role_permission->$key->edit==1){ echo 'checked'; }} ?>>  
	</td> 
	<td class="text-center"><input type="hidden" name="role_permission[<?php echo $key;?>][delete]" value="0">
	<?php if(ucfirst($key)!='Schedule'){  ?>
	<input type="checkbox" id="role_permission" name="role_permission[<?php echo $key;?>][delete]" value="1" <?php if(isset($role_permission->$key->delete)){  if($role_permission->$key->delete==1){ echo 'checked'; }} ?>> 
	<?php } ?>
	</td>
	<td class="text-center"><input type="hidden" name="role_permission[<?php echo $key;?>][approve]" value="0">
	<?php if(ucfirst($key)=='Booking'){  ?>
	<input type="checkbox" id="role_permission" name="role_permission[<?php echo $key;?>][approve]" value="1" <?php if(isset($role_permission->$key->approve)){  if($role_permission->$key->approve==1){ echo 'checked'; }} ?>> 
	<?php } ?>
	</td>
	<td class="text-center"><input type="hidden" name="role_permission[<?php echo $key;?>][papprove]" value="0">
	<?php if(ucfirst($key)=='Booking'){  ?>
	<input type="checkbox" id="role_permission" name="role_permission[<?php echo $key;?>][papprove]" value="1" <?php if(isset($role_permission->$key->papprove)){  if($role_permission->$key->papprove==1){ echo 'checked'; }} ?>> 
	<?php } ?>
	</td>
	<td class="text-center"><input type="hidden" name="role_permission[<?php echo $key;?>][iapprove]" value="0">
	<?php if(ucfirst($key)=='Booking'){  ?>
	<input type="checkbox" id="role_permission" name="role_permission[<?php echo $key;?>][iapprove]" value="1" <?php if(isset($role_permission->$key->iapprove)){  if($role_permission->$key->iapprove==1){ echo 'checked'; }} ?>> 
	<?php } ?>
	</td>
 <tr>

					  <?php } ?>

					  </table>
					   
				</div>
				
			</div>
		  
		</div>    

	   
	</div><!-- /.box-body -->

	<div class="box-footer">
		<input type="submit" class="btn btn-primary" value="Submit" />
		<button onclick="location.href='<?php echo  base_url('roles')?>';" type="button" class="btn btn-warning">Back</button>
	</div>
</form>
</div>
</div>

</div>    
</section>
</div>

<script src="<?php echo base_url(); ?>assets/js/editUser.js" type="text/javascript"></script>