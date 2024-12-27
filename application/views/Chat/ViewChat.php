<style type="text/css">
.box{ width:75%; float:left; clear:both;}
.box.box-right{ float: right; margin-right: 10px;}
.box-header{ border-bottom:1px solid #fff;}
.box {
    background: #3c8dbc;
    color: #fff;
    border-top: 0;
    border-radius: 5px;
}
.box-header {
    color: #fff;
}
.box.box-right{
    background: #ccc;
    color: #000;
    background-image: url(../assets/chat/static/single_tick.png);
    background-position: 99.7% 90%;
    background-size: 12px;
    background-repeat: no-repeat;
}
.box.box-right.attachment{
	background-position:99.7% 97.5%;
}
.box.box-right.unread{
    background-image: url(../assets/chat/static/double_tick.png);
	background-size: 15px;
}
.box.box-right.read{
    background-image: url(../assets/chat/static/blue_tick.png);
	background-size: 15px;
}
.box.box-right .box-header {
    color: #000;
}

.chat_submission .form-control {
    width: calc(100% - 120px);
    float: left;
    height: 50px;
    line-height: 50px;
}
.chat_submission .btn{
	float: left;
	width:120px;
	border-radius:0;
	height: 50px;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1> <i class="fa fa-users"></i> 
	<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>
		Chat With Driver - <?php echo $_GET['driver_name'];?>
	<?php }else{?>
		Chat History for Lorry #<?php echo $_GET['lorry_no'];?>
	<?php }?>
	</h1>
  </section>
  <section class="content">
    <?php
		$this->load->helper('form');
		$error = $this->session->flashdata('error');
		if($error)
		{
	?>
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $this->session->flashdata('error'); ?> </div>
    <?php } ?>
    <?php  
		$success = $this->session->flashdata('success');
		if($success)
		{
	?>
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $this->session->flashdata('success'); ?> </div>
    <?php } ?>
	<?php $lastMessageId = '';?>
    <div class="row">
      <div class="col-xs-12">
        
		<?php if((!isset($_GET['id']) || empty($_GET['id'])) && empty($driverMessagesList)){?>
		<p style="text-align:center; margin:200px 0 800px 0;">No Messages Found....</p>
		<?php }else{?>
		
		
		
            	<div id="chat_box" style="overflow-y:auto; max-height:1000px;">
					<?php 
					$driverUnreadMessageIds = array();
					?>
					<?php foreach($driverMessagesList as $message){
						
						if($message['message_from'] == "driver" && ($message['status'] == 1 || $message['status'] == 2)){
							$driverUnreadMessageIds[] = $message['id'];
						}	
						
					?>
					<div id="box_<?php echo $message['id']; ?>" class="box  <?php if($message['message_from'] == "admin"){?> <?php if(isset($message['file_name']) && !empty($message['file_name'])){ echo "attachment"; }?> box-right <?php if($message['status'] == "2"){ echo "unread";}elseif($message['status'] == "3"){ echo "read";} ?> <?php }?>">
					<div class="box-header">
                        <h3 class="box-title pull-left"><?php if($message['message_from'] == "admin"){
							echo $message['admin_user'];
						}else{
							echo $message['DriverName'];
						}?></h3>
						<small class="date-time pull-right"><?php echo date("d/m/Y",strtotime($message['CreateDateTime']));?></small>
                    </div>
					<div class="box-body">
						<?php 
						if(isset($message['file_name']) && !empty($message['file_name'])){
							$fileFormat = explode(".", $message['file_name']);
							$fileFormat = end($fileFormat);
							if($fileFormat == "png" || $fileFormat == "jpg" || $fileFormat == "jpeg"){
								$textFormat = '<a href="'.base_url().'/assets/chat/'.$message['file_name'].'" target="_blank" download><img src="'.base_url().'/assets/chat/'.$message['file_name'].'" alt="" style="width: 250px; height: 250px; max-widt: 100%;"></a>';
							}elseif($fileFormat == "pdf"){
								$textFormat = '<a href="'.base_url().'/assets/chat/'.$message['file_name'].'" target="_blank" download><img src="'.base_url().'/assets/chat/static/PDF_file_icon.png" alt="" style="width: 250px; height: auto; max-widt: 100%;"></a>';
							}



							
							echo $textFormat;
						}else{
							echo $message['message'];
						}
						?></div>
					</div>
					<div style="clear:both;"></div>
					
					<?php 
					$lastMessageId = $message['id'];
					}?>
					
					<?php if(isset($_GET['id']) && !empty($_GET['id'])){?>
					<div class="chat_submission">
						<div class="form">
							<form action="" method="post">
								<div class="form-group" style="position: relative;">
									<input type="text" class="form-control" id="message" placeholder="Type your message here..." required />
									<div style="display:none">
										<input type="checkbox" checked="checked" name="driver" value="<?php echo $_GET['id'];?>" />
									</div>

									<div style="display: none">
										<input type="file" name="file-input" id="file-input" >	
									</div>
									<label for="file-input" style="cursor: pointer;"><img src="<?php echo base_url();?>/assets/chat/static/attachment_icon.png" alt="" style="width:25px; position: absolute; right: 130px; top: 12px;" /></label>


									<button type="button" class="btn btn-sm btn-primary" id="chat_send">Send</button>
								</div>
							</form>
						</div>
					</div>
					<?php }?>
					
				</div>
				
				<?php }?>
          
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
// Using jQuery.

$(function() {
	$("#message").keypress(function(e) {
		
		if(e.which == 10 || e.which == 13) {
			e.preventDefault();
			if($("#message").val() == ""){
				return false;
			}
			$("#chat_send").trigger("click");
		}
	});
});
</script>