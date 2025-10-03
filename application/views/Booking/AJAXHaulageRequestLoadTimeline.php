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
							<b>Destination Address: </b> <?php echo $Loads[0]->TipName; ?> <br>
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
				}  ?>
				<?php if ($Loads[0]->Status > 1) { ?>
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
				<?php  } ?>
				<?php if ($Loads[0]->Status > 2) { ?>
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
									has been Left for Destination Address - <b><?php echo $Loads[0]->TipName; ?></b>.
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
				} ?>
				<?php if ($Loads[0]->Status == 4 || $Loads[0]->Status > 6) { ?>
					<!-- timeline item -->
					<?php if ($Loads[0]->SiteInDateTime2 != '00/00/0000 00:00:00') { ?>
						<li class="time-label">
							<span class="bg-yellow"> <?php echo $Loads[0]->SiteInDateTime2; ?> </span>
						</li>
						<li>
							<i class="fa fa-user bg-aqua"></i>
							<div class="timeline-item">
								<h3 class="timeline-header no-border"> <a href="<?php echo base_url('viewDriver/' . $Loads[0]->DriverID); ?>"><?php echo $DriverName; ?> <?php if ($Loads[0]->DriverMobile != "") {
																																											echo "( " . $Loads[0]->DriverMobile . " )";
																																										} ?> </a>
									has been Reached to Destination Address - <b><?php echo $Loads[0]->TipName; ?></b> </h3>
							</div>
						</li>
					<?php } ?>
					<!-- END timeline item -->
				<?php  } ?>

				<?php if ($Loads[0]->Status == 4 || $Loads[0]->Status > 7) { ?>
					<?php if ($Loads[0]->SiteOutDateTime2 != '00/00/0000 00:00:00') { ?>
						<!-- timeline time label -->
						<li class="time-label">
							<span class="bg-red"> <?php echo $Loads[0]->SiteOutDateTime2; ?> </span>
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
									had Generated Receipt.
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
				} ?>


				<?php if ($Loads[0]->Status == 4) { ?>
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
									has been Left From <b><?php echo $Loads[0]->TipName; ?>.</b> </h3>
							</div>
						</li>
				<?php }
				} ?>


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

<?php
if (!empty($updatelogs)) :

    // ✅ Helper functions moved to top
    if (!function_exists('isJson')) {
        function isJson($string)
        {
            if (!is_string($string)) return false;
            json_decode($string);
            return json_last_error() === JSON_ERROR_NONE;
        }
    }

    function normalizeDateValue($value)
    {
        if (empty($value)) return $value;

        $formats = ['Y-m-d H:i:s', 'Y-m-d H:i', 'd/m/Y H:i:s', 'd/m/Y H:i'];
        foreach ($formats as $fmt) {
            $dateObj = DateTime::createFromFormat($fmt, $value);
            if ($dateObj) {
                return $dateObj->format('d-m-Y H:i'); // ✅ Only minutes
            }
        }
        return $value; // not a date
    }

    function decodeLogDataSimple($rawValue, $CI)
    {
        $decodedArr = [];
        if (empty($rawValue)) return $decodedArr;

        if (isJson($rawValue)) {
            $decoded = json_decode($rawValue, true);
            if (is_array($decoded)) {
                foreach ($decoded as $key => $val) {
                    if (strtolower($key) === 'loadprice') continue;

                    // ✅ Convert TipID -> Tip Name
                    if (strtolower($key) === 'tipid') {
                        $tipRow = $CI->db->get_where('tbl_tipaddress', ['TipID' => $val])->row();
                        $val = $tipRow ? $tipRow->TipName : "(Unknown Tip)";
                        $key = "Tip Name";
                    }

                    // ✅ Convert MaterialID -> Material Name
                    if (strtolower($key) === 'materialid') {
                        $material = $CI->db->get_where('tbl_materials', ['MaterialID' => $val])->row();
                        $val = $material ? $material->MaterialName : "(Unknown Material)";
                        $key = "Material Name";
                    }

                    // ✅ Normalize date formats
                    if (!empty($val)) $val = normalizeDateValue($val);

                    $prettyKey = ucwords(str_replace('_', ' ', preg_replace('/([a-z])([A-Z])/', '$1 $2', $key)));
                    $decodedArr[$prettyKey] = $val;
                }
            }
        } else {
            // Handle plain text logs (like "Material Name : X")
            $clean = trim(preg_replace('/^Value\s*:/i', '', $rawValue));
            $clean = preg_replace('/^Material\s*Name\s*:\s*/i', '', $clean);
            if (!empty($clean)) {
                $decodedArr["Material Name"] = $clean;
            }
        }
        return $decodedArr;
    }

    $CI = &get_instance();
?>

<ul class="timeline">
<?php foreach ($updatelogs as $log): ?>
    <?php
    $oldArr = decodeLogDataSimple($log->OldValue, $CI);
    $newArr = decodeLogDataSimple($log->UpdatedValue, $CI);

    $changedFields = [];

    foreach ($newArr as $key => $newVal) {
        $normalizedKey = strtolower(str_replace(' ', '', $key));
        if ($normalizedKey === 'jobstartdatetime') continue; // skip JobStartDatetime

        $oldVal = $oldArr[$key] ?? null;

        $formattedOld = $oldVal;
        $formattedNew = $newVal;

        // ✅ Normalize dates again and ignore seconds when comparing
        $oldDateObj = DateTime::createFromFormat('d-m-Y H:i', normalizeDateValue($oldVal));
        $newDateObj = DateTime::createFromFormat('d-m-Y H:i', normalizeDateValue($newVal));

        if ($oldDateObj && $newDateObj) {
            $formattedOld = $oldDateObj->format('d-m-Y H:i');
            $formattedNew = $newDateObj->format('d-m-Y H:i');
            if ($formattedOld === $formattedNew) continue; // skip if only seconds changed
        }

        if (trim((string)$formattedOld) !== trim((string)$formattedNew)) {
            $changedFields[$key] = [
                'old' => $formattedOld,
                'new' => $formattedNew
            ];
        }
    }

    if (empty($changedFields)) continue; // skip logs without changes

    $logDateObj = DateTime::createFromFormat('Y-m-d H:i:s', $log->LogDateTime);
    $formattedLogDate = $logDateObj ? $logDateObj->format('d-m-Y H:i') : $log->LogDateTime;
    ?>
    <li class="time-label">
        <span style="font-weight:bold; color:#333; background: #d2d6de">
            <?= $formattedLogDate; ?>
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
                <strong style="color:#3c8dbc;"><?= htmlspecialchars($log->CreatedByName); ?></strong>
                updated <b><?= htmlspecialchars(ucfirst($log->SitePage)); ?></b>
            </h3>

            <div class="timeline-body">
                <strong>Updated From :</strong><br>
                <?php foreach ($changedFields as $field => $values): ?>
                    <?= ucwords(str_replace('_', ' ', $field)) ?>: <?= htmlspecialchars($values['old']) ?><br>
                <?php endforeach; ?>

                <br><strong>Updated To :</strong><br>
                <?php foreach ($changedFields as $field => $values): ?>
                    <?= ucwords(str_replace('_', ' ', $field)) ?>: <?= htmlspecialchars($values['new']) ?><br>
                <?php endforeach; ?>
            </div>
        </div>
    </li>
<?php endforeach; ?>
</ul>

<?php else: ?>
    <div style="margin: 30px 0; text-align:center;">
        <span style="color:#555; padding:6px 15px; font-size:medium; border-radius:6px; display:inline-block;">
            No Activity Timeline.
        </span>
    </div>
<?php endif; ?>