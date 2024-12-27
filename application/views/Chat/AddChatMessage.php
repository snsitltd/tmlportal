<style type="text/css">
.lit_unread_count{
	position: absolute;
    right: 5px;
    top: 5px;
    background: #000;
    min-width: 25px;
    min-height: 25px;
    text-align: center;
    line-height: 25px;
    border-radius: 100%;
	color:#fff;
}
.list-group-item.active .lit_unread_count{ display: none!important;}
#chat_box{
	background: #ebe7e7;
}
#chat_box .box{ width:75%; float:left; clear:both;}
#chat_box .box.box-right{ float: right; margin-right: 10px;}
#chat_box .box-header{ border-bottom:1px solid #fff;}
#chat_box .box {
    background: #3c8dbc;
    color: #fff;
    border-top: 0;
    border-radius: 5px;
}
#chat_box .box-header {
    color: #fff;
}
#chat_box .box.box-right{
    background: #ccc;
    color: #000;
    background-image: url(../assets/chat/static/single_tick.png);
    background-position: 99.7% 90%;
    background-size: 12px;
    background-repeat: no-repeat;
}
#chat_box .box.box-right.attachment{
	background-position:99.7% 97.5%;
}
#chat_box .box.box-right.unread{
    background-image: url(../assets/chat/static/double_tick.png);
	background-size: 15px;
}
#chat_box .box.box-right.read{
    background-image: url(../assets/chat/static/blue_tick.png);
	background-size: 15px;
}
#chat_box .box.box-right .box-header {
    color: #000;
}

#chat_box .chat_submission .form-control {
    width: calc(100% - 120px);
    float: left;
    height: 50px;
    line-height: 50px;
}
#chat_box .chat_submission .btn{
	float: left;
	width:120px;
	border-radius:0;
	height: 50px;
}
#chat_box .box-right span.icon_read_unread{
	position: absolute;
    right: 0px;
    width: 20px;
    height: 20px;
    bottom: 2px;
}
#chat_box .box-right .tooltip{
	right: 0 !important;
	left: auto !important;
}
#chat_box .box-right .tooltip-inner{
	min-width:230px;
}
</style>
<div class="content-wrapper">
  <section class="content-header">
    <h1> <i class="fa fa-users"></i> Send Driver Message</h1>
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
    <div class="row">
      <div class="col-xs-12 text-left">
        <div class="form-group">
          <textarea class="form-control" id="message" rows="3" style="width:500px" name="message" ></textarea>
          <br>
          <button class="btn btn-primary" name="send" id="sendAll" ><i class="fa fa-plus"></i> Send Message</button>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Drivers List</h3>
          </div>
          <div class="box-body">
            <div class="col-sm-3">
              <div class="all_chat_messages_new">
			  <input type="checkbox" name="checkAll" class="checkAll">
			  <label for="checkAll">Select All</label>
                <ul class="list-group">
                  <?php  if(!empty($driverList)){
                        foreach($driverList as $key=>$record){ 
						$url = '/AddChatMessage/?lorry_no='.$record['LorryNo'].'&id='.$record['driver_id'].'&driver_name='.$record['driver_name'];
						?>
						  <li class="list-group-item <?php if((isset($_GET['lorry_no']) && $_GET['lorry_no'] == $record['LorryNo'])){ echo "active"; }?>">
						  	<div class="row">
							
								<div id="count_<?php echo $record['LorryNo']; ?>" class="lit_unread_count" <?php if($record['unread_messages'] == 0){?> style="display: none;" <?php }?>><?php echo $record['unread_messages']; ?></div>
							
							
							
								<div class="col-xs-1">
									<?php if(isset($record['driver_id']) && !empty($record['driver_id'])){?>
									<input type="checkbox" name="driver" class="checkboxes" value="<?php echo $record['driver_id']; ?>" >
									<div style="display: none;">
									  <input type="checkbox" name="lorry_no" class="checkboxes_lorry" value="<?php echo $record['LorryNo']; ?>" >
									</div>
									<?php }?>
								</div>
								<div class="col-xs-11">
							<a href="<?php echo $url; ?>" style="color: <?php if((isset($_GET['lorry_no']) && $_GET['lorry_no'] == $record['LorryNo'])){ echo "#fff"; }else{ echo "#000"; }?>" >
							
							<div class="current_lorry"><strong>Lorry: </strong><?php echo $record['LorryNo']; ?></div>
							<?php if(isset($record['driver_id']) && !empty($record['driver_id'])){?>
							<div class="current_driver"><strong>Driver: </strong><?php echo $record['driver_name']; ?></div>
							<?php }?>
							<div class="current_reg"><strong>Reg Number: </strong><?php echo $record['RegNumber']; ?></div>
							
							</a>
								</div>
							</div>
							
						  </li>
						<?php }
				  	}?>
                </ul>
              </div>
            </div>
            <div class="col-sm-8">
			<?php if((!isset($_GET['lorry_no']) || empty($_GET['lorry_no']))){?>
				<p style="text-align:center; margin:100px 0 100px 0;">Select a Driver to Start Messaging....</p>
			<?php }else{?>
			
			<div id="chat_box" style="overflow-y:auto; max-height:1000px;">
					
					<?php if(empty($driverMessagesList)){?>
						<p style="text-align:center; margin:100px 0 100px 0;">No Messages Found.</p>
					<?php }?>
					
					
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
						
						
						<?php 
						$readString = '';
						if(isset($message['read_time']) && !empty($message['read_time'])){
							$readString.= 'Seen At: '.$message['read_time'].' ';
							if(empty($message['delivered_time'])){
								$readString.= 'Delivered At: '.$message['read_time'];
							}
						}
						if(isset($message['delivered_time']) && !empty($message['delivered_time'])){
							$readString.= 'Delivered At: '.$message['delivered_time'];
						}
						?>
						
						<span class="icon_read_unread" title="<?php echo $readString; ?>"></span>
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
									<input type="text" class="form-control" id="message_single" placeholder="Type your message here..." required />
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
			
			
			</div>
			<?php }?>
            
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<script type="text/javascript" language="javascript" >
	$(document).ready(function() {  
		
		$('.checkAll').click(function(){ 
		  if (this.checked) {
			 $(".checkboxes").prop("checked", true);
			 $(".checkboxes_lorry").prop("checked", true);
		  } else {
			 $(".checkboxes").prop("checked", false);
			 $(".checkboxes_lorry").prop("checked", false);
		  }	
		});
		/*$("#send").click(function(){ 
		
			var numberOfCheckboxesChecked = $('.checkboxes:checked').length; 
			var Message = $('#message').val(); 
			if(numberOfCheckboxesChecked==0 || Message==""){
				alert("One Driver Must Be Selected And Message Should not be blank. "); 
			}else{
				var dchecked = [];
				var lorryChecked = [];
				$.each($("input[name='driver']:checked"), function(){
				    var lorryNo = $(this).next().find("input").attr("value");
    				dchecked.push($(this).val());
    				lorryChecked.push(lorryNo);
				});
				var driverids = dchecked.join(",");
				var lorryids = lorryChecked.join(",");
				var IDS=driverids, Message=Message, hitURL=baseURL + "SendDriverChatMessage";
				jQuery.ajax({
					type : "POST",
					dataType : "json",
					url : hitURL,
					data : { 'IDS' : IDS, Message:Message, LorryNo:lorryids } 
					}).success(function(data){
						//console.log(data);  
						//alert(data.status)
						//alert(data.result)
						
						$('#message').val(""); 
						$(".checkboxes").prop("checked", false);
						if(data.status == true) {   
							alert("Message has been sent successfully.");   
						}else{ 
							alert("Oooops, Please try again later"); 
						}  
						
				}); 			
			
			}
		});*/
		$(".checkboxes").click(function(){
		  var numberOfCheckboxes = $(".checkboxes").length;
		  var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
		  if(numberOfCheckboxes == numberOfCheckboxesChecked) {
			 $(".checkAll").prop("checked", true);
		  } else {
			 $(".checkAll").prop("checked", false);
		  }
		});
	 	
	});
</script>
<script type="text/javascript">
// Using jQuery.

$(function() {
	$("#message_single").keypress(function(e) {
		
		if(e.which == 10 || e.which == 13) {
			e.preventDefault();
			if($("#message_single").val() == ""){
				return false;
			}
			$("#chat_send").trigger("click");
		}
	});
});
</script>
