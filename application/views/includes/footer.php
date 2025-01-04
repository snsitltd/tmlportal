<footer class="main-footer">
	<div class="pull-right hidden-xs"><b><?php echo WEB_PAGE_TITLE; ?></b> <?php echo WEB_PAGE_SUBTITLE; ?> | <?php echo WEB_PAGE_VERSION; ?></div>
	<strong>©<?php echo date('Y') ?> SNS IT LTD. System Designed and Maintained by <a href="http://snsitltd.com/">SNS IT LTD <?php //echo WEB_PAGE_TITLE; 
																																?></a>. All rights reserved.</strong>
</footer>

<script>
    const baseURL = '<?= base_url() ?>';
</script>

<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/dist/js/app.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/bootstrap-select.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js'); ?>" type="text/javascript"></script>

<?php /* if($active_menu =="addopportunity" || $active_menu =="uploaddata" || $active_menu =="content" || $active_menu =="adduser" || 
		$active_menu =="edituser" ||  $active_menu =="viewuser" ||  $active_menu =="edittip" ||  $active_menu =="addtip" || 
		$active_menu =="editcompanies" ||  $active_menu =="addcompanies" ||  $active_menu =="viewcompanies" ||  $active_menu =="addcontact" || 
		$active_menu =="editcontact" ||  $active_menu =="viewcontact" ||  $active_menu =="addopportunity" ||  $active_menu =="editProduct" || 
		$active_menu =="addProduct" ||  $active_menu =="editContact" ||  $active_menu =="addContact" ||  $active_menu =="viewopportunity"  ||
		$active_menu =="adddriver" ||  $active_menu =="editdriver" ||  $active_menu =="editdriverlogin" ||  $active_menu =="viewdriver"  ||
		$active_menu =="editmaterial" ||  $active_menu =="addmaterial" ||  $active_menu =="viewmaterial" ||  $active_menu =="addbooking"  ||
		$active_menu =="editbooking" ||  $active_menu =="intickets" ||  $active_menu =="outtickets" ||  $active_menu =="colltickets"  || 
		$active_menu =="editintickets" ||  $active_menu =="viewintickets" ||  $active_menu =="editouttickets" ||  $active_menu =="viewouttickets"  || 
		$active_menu =="editcolltickets" ||  $active_menu =="viewcollectiontickets" ||  $active_menu =="outtickets" ||  $active_menu =="colltickets"  
		){ */ ?>
<?php //}else{ 
?>
<!-- DataTables -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
<?php //} 
?>

<?php if (
	$active_menu == "addopportunity" || $active_menu == "editopportunity"  || $active_menu == "editincompleted" || $active_menu =="tips"  || $active_menu == "incompletedtickets" || $active_menu == "loads"
	|| $active_menu == "ticketreports" || $active_menu == "materialreports" || $active_menu == "tmlreports" || $active_menu == "eareports"|| $active_menu =="executivesummarydriverlist"
	|| $active_menu == "tippedinreports" || $active_menu == "ticketpaymentreports" || $active_menu == "MaterialReports" || $active_menu == "addproduct" || $active_menu == "editproduct"
	|| $active_menu == "tickets" || $active_menu == "conveyance" || $active_menu == "haulage"
) { ?>

	<!-- bootstrap datetimepicker -->
	<script src="<?php echo base_url('assets/plugins/datepicker/moment.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datetimepicker.min.js'); ?>"></script>
	<!-- daterangepicker -->
	<script src="<?php echo base_url('assets/plugins/daterangepicker/moment.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker-v2.js'); ?>"></script>
<?php } ?>

<?php if ($active_menu == "addbooking" || $active_menu == "loads" || $active_menu == "editbooking" || $active_menu =="tips" || $active_menu =="duplicatebooking"  || $active_menu == "incompletedtickets" || $active_menu == "pdausers"  || $active_menu == "nonapprequestloads"  || $active_menu == "executivesummary"  || $active_menu == "driverloads" || $active_menu == "addproduct" || $active_menu == "editproduct"    || $active_menu == "tickets"  || $active_menu == "conveyance") { ?>
	<script src="<?php echo base_url('assets/js/bootstrap-datepicker.js'); ?>"></script>
<?php } ?>
<script src="<?php echo base_url('assets/plugins//toastr/toastr.min.js'); ?>"></script>
<script type="text/javascript">
	toastr.options = {
		closeButton: false,
		positionClass: 'toast-bottom-right',
		onclick: function() {
			window.location.href = '/AddChatMessage';
		},
		hideMethod: 'noop',
		disableTimeOut: true,
	};



	var windowURL = window.location.href;
	pageURL = windowURL.substring(0, windowURL.lastIndexOf('/'));
	var x = $('a[href="' + pageURL + '"]');
	x.addClass('active');
	x.parent().addClass('active');
	var y = $('a[href="' + windowURL + '"]');
	y.addClass('active');
	y.parent().addClass('active');

	$(function() {


		$('body').on('mouseenter', '.icon_read_unread', function() {
			$(this).tooltip({
				show: {
					effect: "slideDown",
					delay: 250
				},
				position: {
					my: "left top",
					at: "left bottom"
				},
				hide: {
					duration: 1000000
				}
			});
		})

		/*		
				
		*/
		//$('select').selectpicker();
		$('select').selectpicker({
			size: '10'
		});
		var dataTable = $('#Tickets').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [
				[0, "desc"]
			],
			"ajax": {
				url: "<?php echo base_url('AjaxTickets') ?>", // json datasource
				type: "post", // method  , by default get
				error: function(e) { // error handling
					$(".employee-grid-error").html("");
					$("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">Sorry, Something is wrong</th></tr></tbody>');
					$("#employee-grid_processing").css("display", "none");
				}
			}
		});

		$('#example1').DataTable({
			"order": [
				[1, "desc"]
			],
			"pageLength": 100,
			dom: "<'row'<'col-sm-3'l><'col-sm-6'f><'col-sm-3'p>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row'<'col-sm-5'i><'col-sm-7'p>>"
		});
		//"columnDefs" : [{"targets":1, "type":"date-eu"}], 
		$('#example2').DataTable();
		$('#example3').DataTable();
	})
</script>

<?php if($_SERVER['REMOTE_ADDR'] == ""){?>

<script src="<?php echo base_url('node_modules/socket.io/client-dist/socket.io.js'); ?>"></script>
<script type="text/javascript">
	var socket = io.connect('https://' + window.location.hostname + ':3000');
	$("#sendAll").click(function() {
		var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
		var Message = $('#message').val();
		if (numberOfCheckboxesChecked == 0 || Message == "") {
			alert("One Driver Must Be Selected And Message Should not be blank. ");
		} else {
			var dchecked = [];
			var lorryChecked = [];
			$.each($("input[name='driver']:checked"), function() {
				var lorryNo = $(this).next().find("input").attr("value");
				dchecked.push($(this).val());
				lorryChecked.push(lorryNo);
			});
			var driverids = dchecked.join(",");
			var lorryids = lorryChecked.join(",");
			var IDS = driverids,
				Message = Message,
				hitURL = baseURL + "SendDriverChatMessage";
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				url: hitURL,
				data: {
					'IDS': IDS,
					Message: Message,
					LorryNo: lorryids
				}
			}).success(function(data) {
				//console.log(data);  
				//alert(data.status)
				//alert(data.result)

				$('#message').val("");
				$(".checkboxes").prop("checked", false);
				if (data.status == true) {
					alert("Message has been sent successfully.");
					if (data.status == true) {
						jQuery.each(data.all_result, function(index) {
							socket.emit('new_message', {
								message: data.all_result[index].message,
								created_at: data.all_result[index].created_at,
								admin_user: data.all_result[index].admin_user,
								driver_id: data.all_result[index].driver_id,
								id: data.all_result[index].id,
								lorry_no: data.all_result[index].lorry_no,
								message_from: data.all_result[index].message_from,
								updated_at: data.all_result[index].updated_at,
								driver_name: data.all_result[index].driver_name,
								status: data.all_result[index].status,
							});
						});
					}
				} else {
					alert("Oooops, Please try again later");
				}
			})
		}
	});
</script>
<script type="text/javascript" language="javascript">

	$(document).ready(function() {

        var receivedMessageIds = [];

		if ($("#chat_box").length > 0) {
			$("#chat_box").scrollTop($("#chat_box")[0].scrollHeight);


            var container = $('.all_chat_messages_new_no_tiles');
            var scrollTo = $('.all_chat_messages_new_no_tiles .list-group-item.active');
    
            // Calculating new position of scrollbar
            var position = scrollTo.offset().top 
                    - container.offset().top 
                    + container.scrollTop();
    
            // Setting the value of scrollbar
            container.scrollTop(position);

			$('html, body').animate({
				scrollTop: 3031
			}, "fast");
			$('.checkAll').click(function() {
				if (this.checked) {
					$(".checkboxes").prop("checked", true);
				} else {
					$(".checkboxes").prop("checked", false);
				}
			});
		}


		var socket = io.connect('https://' + window.location.hostname + ':3000');

		var lastMessageId = '';

		<?php if (isset($_GET['lorry_no']) && !empty($_GET['lorry_no'])) { ?>
			$("#chat_send").click(function() {
				var numberOfCheckboxesChecked = $('.checkboxes:checked').length;
				var Message = $('#message_single').val();
				if (Message == "") {
					alert("Message Should not be blank. ");
				} else {
					var dchecked = [];
					$.each($("input[name='driver']:checked"), function() {
						dchecked.push($(this).val());
					});
					var driverids = dchecked.join(",");
					var IDS = driverids,
						Message = Message,
						hitURL = baseURL + "SendDriverChatMessage";
					jQuery.ajax({
						type: "POST",
						dataType: "json",
						url: hitURL,
						data: {
							'IDS': IDS,
							Message: Message,
							LorryNo: '<?php echo $_GET['lorry_no']; ?>'
						}
					}).success(function(data) {
						$('#message_single').val("");
						$(".checkboxes").prop("checked", false);
						if (data.status == true) {
							socket.emit('new_message', {
								message: data.resultData.message,
								created_at: data.resultData.created_at,
								admin_user: data.resultData.admin_user,
								driver_id: data.resultData.driver_id,
								id: data.resultData.id,
								lorry_no: data.resultData.lorry_no,
								message_from: data.resultData.message_from,
								updated_at: data.resultData.updated_at,
								driver_name: data.resultData.driver_name,
								status: data.resultData.status,
							});
						} else {
							alert("Oooops, Please try again later");
						}
					});
				}
			});


			const fileInput = document.getElementById("file-input");
			if ($("#file-input").length > 0) {
				fileInput.addEventListener("change", (event) => {

					var dchecked = [];
					$.each($("input[name='driver']:checked"), function() {
						dchecked.push($(this).val());
					});
					var driverids = dchecked.join(",");
					var IDS = driverids,
						Message = Message,
						hitURL = baseURL + "SendDriverChatMessage";

					var fd = new FormData();
					var file = event.target.files[0];

					var fileType = file.type.split("/")[1];
					if (fileType == "png" || fileType == "jpg" || fileType == "jpeg" || fileType == "pdf") {

					} else {
						alert('Please upload PDF, PNG or JPEG files only.');
						return;
					}


					fd.append("label", "WEBUPLOAD");
					fd.append('file_upload', $('#file-input')[0].files[0]);
					fd.append('file_name', '<?php echo strtotime(date("Y-m-d H:i:s")); ?>.' + file.type.split("/")[1]);
					fd.append('IDS', IDS);
					fd.append('LorryNo', '<?php echo $_GET['lorry_no']; ?>');
					$.ajax({
						url: baseURL + "SendDriverChatMessage",
						type: "POST",
						data: fd,
						dataType: "json",
						processData: false, // tell jQuery not to process the data
						contentType: false // tell jQuery not to set contentType
					}).done(function(data) {

						var reader = new FileReader();
						reader.readAsArrayBuffer(file);


						console.log(file);
						reader.onload = (event) => {
							socket.emit("file_attachment", {
								data: event.target.result,
								format: file.type,
								full_name: data.resultData.file_name,
								message: data.resultData.message,
								created_at: data.resultData.created_at,
								admin_user: data.resultData.admin_user,
								driver_id: data.resultData.driver_id,
								id: data.resultData.id,
								lorry_no: data.resultData.lorry_no,
								message_from: data.resultData.message_from,
								updated_at: data.resultData.updated_at,
								driver_name: data.resultData.driver_name,
								status: data.resultData.status,
								file_name: data.resultData.file_name
							});
						};
					});




					/*  */
				});
			}
		<?php } ?>
		socket.on('new_message', function(data) {
			var messageId = '';
			if (data.id == "") {

			} else {
				messageId = data.id;
				<?php if (isset($_GET['lorry_no']) && !empty($_GET['lorry_no'])) { ?>
					if (data.lorry_no == '<?php echo $_GET['lorry_no'] ?>' && $("#chat_box").length > 0) {
						var html = '';
						if (data.message_from == "admin") {
							var className = "box-right";
							var adminName = data.admin_user;
						} else {
							var className = "";
							var adminName = data.driver_name;
						}
						var d = data.created_at;
						d = d.split(" ");
						d = d[0];
						d = d.replace("-", "/");
						d = d.replace("-", "/");

						html = html + '<div id="box_' + messageId + '" class="box ' + className + '"><div class="box-header"><h3 class="box-title pull-left">' + adminName + '</h3><small class="date-time pull-right">' + d + '</small></div><div class="box-body">' + data.message + '</div><span class="icon_read_unread"></span></div><div style="clear:both;"></div>';
						lastMessageId = data.id;
						if (html !== '') {
							$(html).insertBefore(".chat_submission");
							$("#chat_box").scrollTop($("#chat_box")[0].scrollHeight);
						}
                        if (data.message_from == "driver" && document.hasFocus()) {
                            socket.emit('seen_message', {
                                id: messageId,
                                status:3,
                            });
                        }else{
							receivedMessageIds.push(messageId);
						}
					} else {
                        if ($("#count_" + data.lorry_no).length > 0) {
                            var currentUnreadMessages = $("#count_" + data.lorry_no).text();
                            currentUnreadMessages = parseInt(currentUnreadMessages) + 1;
                            $("#count_" + data.lorry_no).text(currentUnreadMessages);
                            $("#count_" + data.lorry_no).show();
                        }
					}
				<?php }else{ ?> 
                    if ($("#count_" + data.lorry_no).length > 0) {
                        var currentUnreadMessages = $("#count_" + data.lorry_no).text();
                        currentUnreadMessages = parseInt(currentUnreadMessages) + 1;
                        $("#count_" + data.lorry_no).text(currentUnreadMessages);
                        $("#count_" + data.lorry_no).show();
                    }
                <?php } ?>
                if (data.message_from == "driver") {
                    var popupText = '';
                    popupText = data.message;
                    toastr.success(popupText, 'New message from '+data.driver_name);
                }    
                

			}

		});


		socket.on('file_attachment', function(data) {
			var messageId = '';
			if (data.id == "") {
				
			} else {
				messageId = data.id;
				<?php if (isset($_GET['lorry_no']) && !empty($_GET['lorry_no'])) { ?>
					if (data.lorry_no == '<?php echo $_GET['lorry_no'] ?>' && $("#chat_box").length > 0) {
						var html = '';
						if (data.message_from == "admin") {
							var className = "box-right";
							var adminName = data.admin_user;
						} else {
							var className = "";
							var adminName = data.driver_name;
						}
						var d = data.created_at;
						d = d.split(" ");
						d = d[0];
						d = d.replace("-", "/");
						d = d.replace("-", "/");

						var fileFormat = data.file_name.split(".")[1];
						if (fileFormat == "png" || fileFormat == "jpg" || fileFormat == "jpeg") {
							var textFormat = '<a href="' + baseURL + '/assets/chat/' + data.file_name + '" target="_blank" download><img src="' + baseURL + '/assets/chat/' + data.file_name + '" alt="" style="width: 250px; height: 250px; max-widt: 100%;"></a>';
						} else if (fileFormat == "pdf") {
							//var textFormat = '<iframe src="'+baseURL+'/assets/chat/'+data.file_name+'" style="width:100%; height:500px;" frameborder="0"></iframe>';
							var textFormat = '<a href="' + baseURL + '/assets/chat/' + data.file_name + '" target="_blank" download><img src="' + baseURL + '/assets/chat/static/PDF_file_icon.png" alt="" style="width: 250px; height: auto; max-widt: 100%;"></a>';
						}

						html = html + '<div id="box_' + messageId + '" class="box attachment ' + className + '"><div class="box-header"><h3 class="box-title pull-left">' + adminName + '</h3><small class="date-time pull-right">' + d + '</small></div><div class="box-body">' + textFormat + '</div><span class="icon_read_unread"></span></div><div style="clear:both;"></div>';
						lastMessageId = data.id;
						if (html !== '') {
							$(html).insertBefore(".chat_submission");
							$("#chat_box").scrollTop($("#chat_box")[0].scrollHeight);
							/* socket.emit('seen_message', {
								id: messageId,
								status:3,
							}); */
						}
					} else {
						if ($("#count_" + data.lorry_no).length > 0) {
                            var currentUnreadMessages = $("#count_" + data.lorry_no).text();
                            currentUnreadMessages = parseInt(currentUnreadMessages) + 1;
                            $("#count_" + data.lorry_no).text(currentUnreadMessages);
                            $("#count_" + data.lorry_no).show();
                        }
                        /* socket.emit('receive_message', {
							id: messageId,
							status:2,
						}); */
					}
				<?php }else{ ?>
                    if ($("#count_" + data.lorry_no).length > 0) {
                        var currentUnreadMessages = $("#count_" + data.lorry_no).text();
                        currentUnreadMessages = parseInt(currentUnreadMessages) + 1;
                        $("#count_" + data.lorry_no).text(currentUnreadMessages);
                        $("#count_" + data.lorry_no).show();
                    }
                <?php } ?>
                if (data.message_from == "driver") {
                    var popupText = '';
                    popupText = data.message;
                    toastr.success(popupText, 'New message from '+data.driver_name);
                }  
			}
		});


		<?php if (isset($driverMessagesList) && !empty($driverMessagesList)) {
			$driverUnreadMessageIds = array();
			foreach ($driverMessagesList as $message) {
				if ($message['message_from'] == "driver" && ($message['status'] == 1 || $message['status'] == 2)) {
					if (!empty($message['file_name'])) {
						continue;
					}
					$driverUnreadMessageIds[] = $message['id'];
				}
			}
		?>
			<?php foreach ($driverUnreadMessageIds as $driverUnreadMessageId) { ?>
				setTimeout(function(){
					socket.emit('seen_message', {
						id: '<?php echo $driverUnreadMessageId; ?>',
						status: 3,
					});
				}, 200);
				
			<?php } ?>
		<?php } ?>
		
		
		<?php if (isset($_GET['lorry_no']) && !empty($_GET['lorry_no']) && isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['driver_name']) && !empty($_GET['driver_name'])) { ?>
		setInterval(function(){
			if (document.hasFocus()) {
				receivedMessageIds.forEach(function (item, index) {
				  setTimeout(function(){
					  socket.emit('seen_message', {
							id: item,
						status: 3,
					});
					receivedMessageIds.splice($.inArray(item, receivedMessageIds), 1);
				  }, 200);
				});
			}
		}, 2000);
		<?php }?>
		
		
		


		socket.on('receive_message', function(data) {
			var fd = new FormData();
			var readTime = '';
			var deliverTime = '';
			var currentId = data.id;
			if (currentId == "") {
				return false;
			}
			fd.append("message_id", data.id);
			fd.append('message_status', data.status);
			fd.append('type', 'update_status');
			$.ajax({
				url: baseURL + "SendDriverChatMessage",
				type: "POST",
				data: fd,
				dataType: "json",
				processData: false, // tell jQuery not to process the data
				contentType: false // tell jQuery not to set contentType
			}).done(function(data) {
				readTime = data.read_time;
				deliverTime = data.delivered_time;
				if ($("#box_" + currentId).length > 0) {
					var readString = '';
					if (readTime == "") {} else {
						readString += 'Seen At: ' + readTime + ' ';
						if (deliverTime == '') {
							readString += 'Delivered At: ' + readTime;
						}
					}
					if (deliverTime == "") {} else {
						readString += 'Delivered At: ' + deliverTime;
					}
					$("#box_" + currentId + " .icon_read_unread").attr("title", readString);
					$("#box_" + currentId + " .icon_read_unread").attr("data-original-title", readString);
				}
				console.log(data);
			});
			if ($("#box_" + data.id).length > 0) {
				$("#box_" + data.id).addClass("unread");
			}
		});
		socket.on('seen_message', function(data) {
			console.log(data.id);
			var fd = new FormData();
			var readTime = '';
			var deliverTime = '';
			var currentId = data.id;
			if (currentId == "") {
				return false;
			}
			fd.append("message_id", data.id);
			fd.append('message_status', data.status);
			fd.append('type', 'update_status');
			$.ajax({
				url: baseURL + "SendDriverChatMessage",
				type: "POST",
				data: fd,
				dataType: "json",
				processData: false, // tell jQuery not to process the data
				contentType: false // tell jQuery not to set contentType
			}).done(function(data) {
				readTime = data.read_time;
				deliverTime = data.delivered_time;
				if ($("#box_" + currentId).length > 0) {
					var readString = '';
					if (readTime == "") {} else {
						readString += 'Seen At: ' + readTime + ' ';
						if (deliverTime == '') {
							readString += 'Delivered At: ' + readTime;
						}
					}
					if (deliverTime == "") {} else {
						readString += 'Delivered At: ' + deliverTime;
					}
					$("#box_" + currentId + " .icon_read_unread").attr("title", readString);
					$("#box_" + currentId + " .icon_read_unread").attr("data-original-title", readString);
				}
				console.log(data);
			});
			if ($("#box_" + data.id).length > 0) {
				$("#box_" + data.id).addClass("read");
			}

		});

		$(document).on("click", "#chat_box .box a", function() {
			var boxDiv = $(this).parent().parent();
			if (boxDiv.hasClass("box-right")) {
				return;
			}
			if (boxDiv.hasClass("read")) {
				return;
			}
			var curId = boxDiv.attr("id");
			curId = curId.replace("box_", "");
			socket.emit('seen_message', {
				id: curId,
				status: 3,
			});
		})
	});
</script>

<?php }?>




</body>

</html>