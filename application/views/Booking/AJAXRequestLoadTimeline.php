<?php  //echo "<PRE>"; var_dump($Loads); var_dump($Photos);echo "</PRE>";
//var_dump($Photos);

if ($Loads[0]->DriverName != "") {
	$DriverName = ucfirst($Loads[0]->DriverName);
	$VRN = strtoupper($Loads[0]->VehicleRegNo);
} else {
	$DriverName =  ucfirst($Loads[0]->dname);
	$VRN = strtoupper($Loads[0]->vrn);
} ?>
<style>
	/* Hide only the header of this specific modal */
	#empModal .modal-header {
		display: none !important;
	}
</style>

<section class="content">
	<!-- row -->
	<div class="row">
		<div class="col-md-12">
			<!-- The time line -->
			<style>
				.load-timeline-header {
					background: #d2d6de;
					color: #000000ff;
					padding: 10px 20px;
					font-size: large;
					font-weight: bold;
					border-radius: 6px;
					text-align: left;
					margin-top: 10px;
					margin-bottom: 30px;
				}
			</style>

			<div class="load-timeline-header">
				Load/Lorry Timeline
			</div>

			<ul class="timeline">
				<!-- timeline time label -->

				<li class="time-label">
					<span class="bg-gray"> <?php echo $Loads[0]->CreateDateTime; ?> </span>
				</li>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<li>
					<i class="fa fa-envelope bg-blue"></i>
					<div class="timeline-item">
						<!-- <span class="time"><i class="fa fa-clock-o"></i> 12:05</span> -->
						<h3 class="timeline-header"><a href="mailto:<?php echo $Loads[0]->CreatedByEmail; ?>"><?php echo $Loads[0]->CreatedByName; ?> (<?php echo $Loads[0]->CreatedByMobile; ?>)</a>
							had Allocated a Load / Lorry to <a href="<?php echo base_url('viewDriver/' . $Loads[0]->DriverID); ?>"><?php echo $DriverName; ?> <?php if ($Loads[0]->DriverMobile != "") {
																																									echo "( " . $Loads[0]->DriverMobile . " )";
																																								} ?> </a> </h3>
						<div class="timeline-body">
							<b>Company Name: </b> <?php echo $Loads[0]->CompanyName; ?> <br>
							<b>Site Address: </b> <?php echo $Loads[0]->OpportunityName; ?> <br>
							<b>Material Name: </b> <?php echo $Loads[0]->MaterialName; ?> <br>
							<b>Site Contact Name: </b> <?php echo $Loads[0]->ContactName; ?> <br>
							<b>Site Contact Mobile No.: </b> <?php echo $Loads[0]->ContactMobile; ?> <br>
							<b>Site Contact Email Address: </b> <?php echo $Loads[0]->Email; ?> <br>
							<?php if (trim($Loads[0]->Price) != "") { ?><b>Price: </b> £<?php echo $Loads[0]->Price; ?> <br> <?php } ?>
							<?php if (trim($Loads[0]->PurchaseOrderNumber) != "") { ?><b>Purchase Order No.: </b> <?php echo $Loads[0]->PurchaseOrderNumber; ?> <br> <?php } ?>
							<?php if (trim($Loads[0]->Notes) != "") { ?><b>Notes: </b> <?php echo $Loads[0]->Notes; ?> <?php } ?>
						</div>
					</div>
				</li>
				<!-- END timeline item -->

				<?php if ($Loads[0]->Status > 0) { ?>
					<?php if ($Loads[0]->JobStartDateTime != '00/00/0000 00:00:00') { ?>
						<!-- timeline item -->
						<li class="time-label">
							<span class="bg-blue"> <?php echo $Loads[0]->JobStartDateTime; ?> </span>
						</li>
						<li>
							<i class="fa fa-user bg-aqua"></i>
							<div class="timeline-item">
								<!-- <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>  -->
								<h3 class="timeline-header no-border"><a href="<?php echo base_url('viewDriver/' . $Loads[0]->DriverID); ?>"><?php echo $DriverName; ?> <?php if ($Loads[0]->DriverMobile != "") {
																																											echo "( " . $Loads[0]->DriverMobile . " )";
																																										} ?> </a> has Accepted Load / Lorry Request.</h3>
								<div class="timeline-body">
									<b>Driver Name: </b> <?php echo $DriverName; ?> <br>
									<b>Driver Mobile No.: </b> <?php echo $Loads[0]->DriverMobile; ?> <br>
									<b>Vehicle Reg No (Lorry No): </b> <?php echo $VRN; ?> <br>
								</div>
							</div>
						</li>
						<!-- END timeline item -->
					<?php  }
				}
				if ($Loads[0]->Status > 1) { ?>
					<!-- timeline item -->

					<?php if ($Loads[0]->SiteInDateTime != '00/00/0000 00:00:00') { ?>
						<li class="time-label">
							<span class="bg-yellow"> <?php echo $Loads[0]->SiteInDateTime; ?> </span>
						</li>
						<li>
							<i class="fa fa-user bg-aqua"></i>
							<div class="timeline-item">
								<h3 class="timeline-header no-border"> <a href="<?php echo base_url('viewDriver/' . $Loads[0]->DriverID); ?>"><?php echo $DriverName; ?> <?php if ($Loads[0]->DriverMobile != "") {
																																												echo "( " . $Loads[0]->DriverMobile . " )";
																																											} ?> </a>
									has been Reached to <b><?php echo $Loads[0]->OpportunityName; ?></b> </h3>
							</div>
						</li>
					<?php } ?>

					<!-- END timeline item -->
				<?php  }
				if ($Loads[0]->Status > 2) { ?>
					<?php if ($Loads[0]->SiteOutDateTime != '00/00/0000 00:00:00') { ?>
						<!-- timeline time label -->
						<li class="time-label">
							<span class="bg-red"> <?php echo $Loads[0]->SiteOutDateTime; ?> </span>
						</li>
						<!-- /.timeline-label -->
						<?php if ($Photos) {
							if (count($Photos) > 0) { 	//echo "<PRE>"; var_dump($Photos);echo "</PRE>"; 
						?>
								<!-- timeline item -->
								<li>
									<i class="fa fa-camera bg-purple"></i>
									<div class="timeline-item">
										<h3 class="timeline-header"><a href="<?php echo base_url('viewDriver/' . $Loads[0]->DriverID); ?>"><?php echo $DriverName; ?> <?php if ($Loads[0]->DriverMobile != "") {
																																											echo "( " . $Loads[0]->DriverMobile . " )";
																																										} ?> </a> uploaded photos</h3>
										<div class="timeline-body">
											<?php for ($i = 0; $i < count($Photos); $i++) { ?>
												<a href="<?php echo base_url('uploads/Photo/' . $Photos[0]->ImageName); ?>" target="_blank"><img src="<?php echo base_url('uploads/Photo/' . $Photos[0]->ImageName); ?>" width="150" height="100" alt="..." class="margin"> </a>
											<?php } ?>
										</div>
									</div>
								</li>
						<?php }
						} ?>
						<li>
							<i class="fa fa-user bg-aqua"></i>
							<div class="timeline-item">
								<h3 class="timeline-header no-border"> <a href="<?php echo base_url('viewDriver/' . $Loads[0]->DriverID); ?>"><?php echo $DriverName; ?> <?php if ($Loads[0]->DriverMobile != "") {
																																												echo "( " . $Loads[0]->DriverMobile . " )";
																																											} ?> </a>
									has Generate Receipt.
									<a href="<?php echo base_url('assets/conveyance/' . $Loads[0]->ReceiptName); ?>" title="Click here to View Conveyance Receipt" target="_blank"><i class="fa fa-file-pdf-o"></i> </a>
								</h3>
								<div class="timeline-body">
									<b>Conveyance Ticket No: </b> <?php echo $Loads[0]->ConveyanceNo; ?>
									<a href="<?php echo base_url('assets/conveyance/' . $Loads[0]->ReceiptName); ?>" title="Click here to View Conveyance Receipt" target="_blank"><i class="fa fa-file-pdf-o"></i> </a>
								</div>
							</div>
						</li>
						<!-- END timeline item -->
					<?php  }
				}
				if ($Loads[0]->Status > 3) { ?>
					<?php if ($Loads[0]->JobEndDateTime != '00/00/0000 00:00:00') { ?>
						<li class="time-label">
							<span class="bg-green"> <?php echo $Loads[0]->JobEndDateTime; ?> </span>
						</li>
						<li>
							<i class="fa fa-user bg-aqua"></i>
							<div class="timeline-item">
								<h3 class="timeline-header no-border"> <a href="<?php echo base_url('viewDriver/' . $Loads[0]->DriverID); ?>"><?php echo $DriverName; ?> <?php if ($Loads[0]->DriverMobile != "") {
																																												echo "( " . $Loads[0]->DriverMobile . " )";
																																											} ?> </a>
									has been Left From <b><?php echo $Loads[0]->OpportunityName; ?> <?php //echo $Loads[0]->TipName; 
																									?>.</b> </h3>
							</div>
						</li>
					<?php } ?>
				<?php } ?>


				<?php if ($Loads[0]->Status == 5) { ?>
					<?php if ($Loads[0]->CancelDateTime != '') { ?>
						<li class="time-label">
							<span class="bg-red"> <?php echo $Loads[0]->CancelDateTime; ?> </span>
						</li>
					<?php } ?>
					<li>
						<i class="fa fa-user bg-red"></i>
						<div class="timeline-item">
							<?php if ($Loads[0]->CancelDateTime != '') { ?>
								<h3 class="timeline-header"><a style="color:red" href="mailto:<?php echo $Loads[0]->CancelByEmail; ?>"><?php echo $Loads[0]->CancelByName; ?> (<?php echo $Loads[0]->CancelByMobile; ?>)</a>
									had Cancelled a Load / Lorry to <a style="color:red" href="<?php echo base_url('viewDriver/' . $Loads[0]->DriverID); ?>"><?php echo $DriverName; ?> (<?php echo $Loads[0]->DriverMobile; ?>)</a> </h3>
							<?php } else { ?>
								<h3 class="timeline-header"> Load / Lorry has been Cancelled </h3>
							<?php } ?>
							<div class="timeline-body">
								<b>Notes: </b> <?php echo $Loads[0]->CancelNote; ?>
							</div>
						</div>
					</li>
				<?php } ?>
				<li>
					<i class="fa fa-clock-o bg-red"></i>
				</li>
			</ul>
			<style>
				.activity-timeline-header {
					background: #d2d6de;
					color: #000000ff;
					padding: 10px 20px;
					font-size: large;
					font-weight: bold;
					border-radius: 6px;
					text-align: left;
					margin: 30px 0;
					margin-top: 60px;
				}
			</style>

			<div class="activity-timeline-header">
    Activity Timeline
</div>

<?php if (!empty($updatelogs)) : ?>

    <?php
    if (!function_exists('isJson')) {
        function isJson($string)
        {
            if (!is_string($string)) return false;
            json_decode($string);
            return json_last_error() === JSON_ERROR_NONE;
        }
    }

    $CI = &get_instance();

    function decodeLogDataSimple($rawValue, $CI)
    {
        $decodedArr = [];
        if (empty($rawValue)) return $decodedArr;

        if (isJson($rawValue)) {
            $decoded = json_decode($rawValue, true);
            if (is_array($decoded)) {
                foreach ($decoded as $key => $val) {
                    if (strtolower($key) === 'loadprice') continue;

                    // ✅ Tip Name
                    if (strtolower($key) === 'tipid') {
                        $tipRow = $CI->db->get_where('tbl_tipaddress', ['TipID' => $val])->row();
                        $val = $tipRow ? $tipRow->TipName : "(Unknown Tip)";
                        $key = "Tip Name";
                    }

                    // ✅ Material Name
                    if (strtolower($key) === 'materialid') {
                        $material = $CI->db->get_where('tbl_materials', ['MaterialID' => $val])->row();
                        $val = $material ? $material->MaterialName : "(Unknown Material)";
                        $key = "Material Name";
                    }

                     // ✅ Strict Date Format Conversion
                if (!empty($val) && preg_match('/^\d{4}-\d{2}-\d{2}/', $val)) { 
                    // Only if value looks like a date in YYYY-MM-DD format
                    $dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $val);
                    if ($dateObj) {
                        $val = $dateObj->format('d/m/Y H:i:s'); // ✅ Force DD/MM/YYYY format
                    }
                }

                    $prettyKey = ucwords(str_replace('_', ' ', preg_replace('/([a-z])([A-Z])/', '$1 $2', $key)));
                    $decodedArr[$prettyKey] = $val;
                }
            }
        } else {
            // Handle plain text logs
            $clean = trim(preg_replace('/^Value\s*:/i', '', $rawValue));
            $clean = preg_replace('/^Material\s*Name\s*:\s*/i', '', $clean);

            if (!empty($clean)) {
                $decodedArr["Material Name"] = $clean;
            }
        }

        return $decodedArr;
    }

    function renderOldNewBlocks($oldDataArr, $newDataArr)
    {
        // ✅ Status Map
        $statusMap = [
            4 => 'Finished',
            5 => 'Cancelled',
            6 => 'Wasted Journey',
            7 => 'Invoice Cancelled',
            8 => 'Invoice Cancelled'
        ];

        $html = "";
        $hiddenKeys = ['BookingID', 'BookingDateID'];

        if (!empty($oldDataArr) || !empty($newDataArr)) {
            // 🔶 Yellow "Updated From"
            $html .= "<p><strong style='color: #ff851b;'>Updated From :</strong></p>";
            if (!empty($oldDataArr)) {
                foreach ($oldDataArr as $key => $value) {
                    $normalizedKey = str_replace(' ', '', strtolower($key));
                    if (in_array($normalizedKey, array_map('strtolower', $hiddenKeys))) continue;

                    // ✅ Convert Status number to name
                    if (strtolower($key) === 'status' && isset($statusMap[$value])) {
                        $value = $statusMap[$value];
                    }

                    $html .= "<div><strong>{$key}:</strong> " . htmlspecialchars($value) . "</div>";
                }
            } else {
                $html .= "<div><em>No Old Data</em></div>";
            }

            // 🔶 Yellow "Updated To"
            $html .= "<p style='margin-top:10px;'><strong style='color: #ff851b;'>Updated To :</strong></p>";
            if (!empty($newDataArr)) {
                foreach ($newDataArr as $key => $value) {
                    $normalizedKey = str_replace(' ', '', strtolower($key));
                    if (in_array($normalizedKey, array_map('strtolower', $hiddenKeys))) continue;

                    // ✅ Convert Status number to name
                    if (strtolower($key) === 'status' && isset($statusMap[$value])) {
                        $value = $statusMap[$value];
                    }

                    $html .= "<div><strong>{$key}:</strong> " . htmlspecialchars($value) . "</div>";
                }
            } else {
                $html .= "<div><em>No New Data</em></div>";
            }
        }
        return $html;
    }
    ?>

				<ul class="timeline">
					<?php foreach ($updatelogs as $log) : ?>
						<?php
$dateObj = DateTime::createFromFormat('Y-m-d H:i:s', $log->LogDateTime);
$formattedDate = $dateObj ? $dateObj->format('d/m/Y H:i:s') : $log->LogDateTime;
?>
<li class="time-label">
    <span style="font-weight:bold; color:#333; background: #d2d6de">
        <?= $formattedDate; ?>
    </span>
</li>


						<li>
							<i class="fa fa-edit bg-orange"></i>
							<div class="timeline-item p-3">
								<?php
								if (stripos($log->SitePage, 'material update') !== false) $log->SitePage = "Material";
								if (stripos($log->SitePage, 'date update') !== false) $log->SitePage = "Date";
								if (stripos($log->SitePage, 'tip update') !== false) $log->SitePage = "Tip Address";
								if (stripos($log->SitePage, 'booking update') !== false) $log->SitePage = "Booking";
								if (stripos($log->SitePage, 'status update') !== false) $log->SitePage = "Status";

								$oldArr = decodeLogDataSimple($log->OldValue, $CI);
								$newArr = decodeLogDataSimple($log->UpdatedValue, $CI);
								?>

								<h3 class="timeline-header">
									<strong style="color:#3c8dbc;"><?= $log->CreatedByName; ?></strong>
									updated <b><?= ucfirst($log->SitePage); ?></b>
								</h3>

								<div class="timeline-body">
									<?= renderOldNewBlocks($oldArr, $newArr); ?>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>

			<?php else : ?>
				<div style="margin: 30px 0; text-align:center;">
					<span style="color:#555; padding:6px 15px; font-size:medium; border-radius:6px; display:inline-block;">
						No Activity Timeline.
					</span>
				</div>
			<?php endif; ?>
			<div>
    <?php if (!empty($driverlogs)) : ?>
        <p>Logs Have Data</p>

    <?php elseif (empty($driverlogs)) : ?>
        <p>Driver Logs Empty</p>

    <?php else : ?>
        <p>No Information To Show</p>
    <?php endif; ?>
</div>

		</div>
	</div>
</section>