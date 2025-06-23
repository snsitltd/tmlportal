<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<div class="content-wrapper"> 
    <style>
        a{
            text-decoration : none;
        }
    </style>
    <section class="content-header"><h1><i class="fa fa-users"></i> Driver Load/Lorry Report </h1></section>
    <section class="content"> 
        <div class="row"> 
            <div class="col-md-12">  
                <div class="box box-primary">
                    <div class="box-header"><h3 class="box-title">Select Driver And Date</h3></div>  
                    <form name="DriverLoads" action="<?php echo base_url('DriverLoads'); ?>" method="post" id="DriverLoads" role="form">
                        <div class="box-body">
                            <div class="row"> 
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="role">Drivers</label> 
                                       <select class="form-control" name="driver" id="driver" required data-live-search="true" > 
											<option value="" >SELECT DRIVER </option>
                                            <?php foreach($DriverList as $value){ ?>
                                            
											<option value="<?php echo $value['DriverID']; ?>" <?php if(set_value('driver')==$value['DriverID']){ echo "Selected";} ?>><?php echo $value['DriverName']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div> 
                                </div>
                                <div class="col-md-3">     
									<div class="form-group">
                                        <label for="date-time">Date <span class="required">*</span></label>
                                        <div class="input-group date">
                                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input type="text" class="form-control required" id="searchdate" value="<?php if(set_value('searchdate')){ echo set_value('searchdate'); }else{ echo date('d/m/Y'); } ?>" name="searchdate" maxlength="64">
                                        </div>
                                    </div>  
                                </div> 
                            </div>  
                            <div class="row">
                                <div class="col-md-6">                                 
                                </div> 
                            </div>     
                        </div> 
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Search" name="search" /> 
                        </div>
                    </form>
                </div>
            </div> 
        </div> 
		<?php if(!empty($searchdate)){ ?>
		<div class="row"> 

		      <h3 class="profile-username text-center"><?php echo $DriverDetails[0]['DriverName']; ?></h3>  
			  <h4 class="profile-username text-center"><?php echo $searchdate; ?></h4>  
			  <?php 
                $combinedData = array_merge($DriverLoadsCollection, $DriverLoadsDelivery);
                
                    // Display only the first VehicleRegNo, if available
                    if (!empty($combinedData)) {
                        $firstVehicle = reset($combinedData); // Get the first item
                        echo '<h4 class="profile-username text-center">' . htmlspecialchars($firstVehicle->VehicleRegNo) . '</h4>';
                    }
                ?>
			  
			<!-- <div class="col-md-6"> 
			  <div class="box box-primary">
				<div class="box-body box-profile">  
			
				  <ul class="list-group list-group-unbordered">
					<li class="list-group-item">
					  <b>Followers</b> <a class="pull-right">1,322</a>
					</li>
					<li class="list-group-item">
					  <b>Following</b> <a class="pull-right">543</a>
					</li>
					<li class="list-group-item">
					  <b>Friends</b> <a class="pull-right">13,287</a>
					</li>
				  </ul>  
				</div> 
			  </div> 
			</div> -->
			
		</div>
		<?php } ?>
		
        <div class="row"> 
			<div class="col-xs-12"> 
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>Driver Loads (Collection and Delivery)</b></h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table table-striped" border="1">
                            <tr style="outline: thin solid">
                                <th colspan="4"></th>
                                <th colspan="4"><center>Site Times</center></th>
                                <th colspan="2"></th>
                            </tr> 
                            <tr style="outline: thin solid">
                                <th style="text-align:center">Company Name / Site Address</th>
                                <th style="text-align:center">Tip Address</th>
                                <th style="text-align:center">Material</th>
                                <th width="100" style="text-align:center">Conv. No.</th>
                                <th width="140" style="text-align:center">Start Time</th>
                                <th width="140" style="text-align:center">Time In</th>
                                <th width="140" style="text-align:center">Time Out</th>
                                <th width="140" style="text-align:center">Tip In Time</th>
                                <th width="90" style="text-align:center">Tip Ticket</th>  
                                <th width="50" style="text-align:center">Expense</th>  
                            </tr> 
            
                            <?php 
                            // Merge the Collection and Delivery Data
                            $combinedData = array_merge($DriverLoadsCollection, $DriverLoadsDelivery);
            
                            // Sort the data by 'AllocatedDateTime' or another time field
                            usort($combinedData, function($a, $b) {
                                return strtotime($a->AllocatedDateTime) - strtotime($b->AllocatedDateTime);
                            });
            
                            if (!empty($combinedData)) {
                                foreach ($combinedData as $key => $record) { 
                                    
                                    // Ensure all fields have a value, set default value if missing
                                    $companyName = !empty($record->CompanyName) ? $record->CompanyName : 'N/A';
                                    $opportunityName = !empty($record->OpportunityName) ? $record->OpportunityName : 'N/A';
                                    $tipName = !empty($record->TipName) ? $record->TipName : 'N/A';
                                    $materialName = !empty($record->MaterialName) ? $record->MaterialName : 'N/A';
                                    $conveyanceNo = !empty($record->ConveyanceNo) ? $record->ConveyanceNo : 'N/A';
                                    $jobStartDateTime = !empty($record->JobStartDateTime) ? $record->JobStartDateTime : 'N/A';
                                    $siteInDateTime = !empty($record->SiteInDateTime) ? $record->SiteInDateTime : 'N/A';
                                    $siteOutDateTime = !empty($record->SiteOutDateTime) ? $record->SiteOutDateTime : 'N/A';
                                    $tipTicketDateTime = !empty($record->TicketDateTime) ? $record->TicketDateTime : 'N/A';
                                    $ticketNumber = !empty($record->TicketNumber) ? $record->TicketNumber : "";
                                    $tipTicketID = !empty($record->TipTicketID) ? $record->TipTicketID : '';
                                    $suppNo = !empty($record->SuppNo) ? $record->SuppNo : '';
                                    $expenses = !empty($record->Expenses) ? $record->Expenses : 'N/A';
                                    $receiptName = !empty($record->ReceiptName) ? $record->ReceiptName : '';
                                    $pdfName = !empty($record->pdf_name) ? $record->pdf_name : '';
                                    $typeOfTicket = !empty($record->TypeOfTicket) ? $record->TypeOfTicket : ''; // from tbl_ticket

                                    // Display data in rows
                                    echo "<tr style='outline: thin solid'>
                                            <td>{$companyName} <br> {$opportunityName}</td>
                                            <td>{$tipName}  {$suppNo}</td>
                                            <td>{$materialName}</td>";
                            
                                    
                                    // Conveyance No with a link logic
                                    $conveyanceNo = isset($record->ConveyanceNo) ? $record->ConveyanceNo : null;
                                    if ($conveyanceNo) {
                                        $url = "https://tml.snsitltd.com/assets/conveyance/{$record->ReceiptName}";

                    echo "<td><a href='{$url}' target='_blank'>{$conveyanceNo}</a></td>";
                  } else {
                    echo "<td>{$conveyanceNo}</td>";
                  }
                  echo "
                                        <td>{$jobStartDateTime}</td>
                                          <td>{$siteInDateTime}</td>
                                          <td>{$siteOutDateTime}</td>
                                          <td>{$tipTicketDateTime}</td>";
                                    $searchIDTic = urlencode($ticketNumber);
                                      $searchID = urlencode($tipTicketID);
                                //         // Construct the first URL for /All-Tickets with search ID
                                //  // $url1 = "https://tml.snsitltd.com/assets/pdf_file/" . $record->TicketPdfName;
                                //   $url1 = "https://tml.snsitltd.com/assets/pdf_file/" . $record->pdf_name;  
                                // //  $url1 = "https://tml.snsitltd.com/assets/conveyance/" . $record->ReceiptName;
                                //     if ($tipTicketID) {
                                //         // Base URL for tip tickets
                                //         $baseUrl = "https://tml.snsitltd.com/";
                                //         $searchID = urlencode($tipTicketID);
                                //         $searchIDTic = urlencode($ticketNumber);
                                    
                                //         // Construct the first URL for conveyance PDF
                                //         $url1 = "https://tml.snsitltd.com/assets/conveyance/" . $record->ReceiptName;
                                //        // $url1 = "https://tml.snsitltd.com/assets/pdf_file/" . $record->pdf_name;  
                                //         // Construct the second URL for the original tip ticket
                                //         $url2 = $baseUrl . "assets/tiptickets/" . $searchID . ".pdf";
                                    
                                //         // Display each URL as a plain clickable number
                                //         echo "<td>";
                                //         echo "<a href='{$url1}' target='_blank'>{$ticketNumber}</a><br>";
                                //         echo "<a href='{$url2}' target='_blank'>{$tipTicketID}</a>";
                                //         echo "</td>";
                                //     } else {
                                //         // If there's no tip ticket, just show the conveyance link
                                //         echo "<td>";
                                //         echo "<a href='{$url1}' target='_blank'>{$record->TicketNumber}</a>";
                                       
                                //         echo "</td>";
                                //     }


                                    // Construct the second URL for the original tip ticket
                         $url2 = $baseUrl . "assets/tiptickets/" . $searchID . ".pdf";
                           $urlConveyance = "https://tml.snsitltd.com/assets/conveyance/{$receiptName}";          
                        // Tip Ticket logic: based on TypeOfTicket
                        echo "<td>";
                        if (!empty($tipTicketID)) {
                            if ($typeOfTicket === 'out') {
                                // Show conveyance receipt
                                echo "<a href='{$urlConveyance}' target='_blank'>{$ticketNumber}</a><br>";
                                 echo "<a href='{$url2}' target='_blank'>{$tipTicketID}</a><br>";
                            } else {
                                // Show PDF ticket
                                $pdfUrl = "https://tml.snsitltd.com/assets/pdf_file/{$pdfName}";
                                echo "<a href='{$pdfUrl}' target='_blank'>{$ticketNumber}</a><br>";
                                 echo "<a href='{$url2}' target='_blank'>{$tipTicketID}</a><br>";
                            }
                        } else {
                            // No tip ticket ID, show receipt
                            echo "<a href='{$urlConveyance}' target='_blank'>{$ticketNumber}</a>";
                        }
                        echo "</td>";
                                    
                                    echo "<td>{$expenses}</td></tr>";
                                }
                            } else {
                                // No records found message
                                echo "<tr style='outline: thin solid'><td colspan='10'>There are no records available for collection or delivery.</td></tr>";
                            }
                            ?>

                        </table>
                    </div>
                </div>  
            </div>


        </div>     
		

        
        <div class="row">
			
			<div class="col-xs-12"> 
				<div class="box">
					<div class="box-header"  >
					  <h3 class="box-title"><b>DayWork</b></h3>
					</div> 
					<div class="box-body no-padding">
					  <table class="table table-striped" border="1">
						<tr style="outline: thin solid">
						  <th colspan="3"></th>
						  <th colspan="3"  ><center>Site Times</center></th>
						  <th colspan="3"  ></th>
						</tr> 
						
						<tr style="outline: thin solid">
						  <th style="text-align:center" >Company Name / Site Address</th>
						  <th  style="text-align:center" >Tip Address</th>
						  <th style="text-align:center" >Material</th> 
						  
						  <th  width="140" style="text-align:center" >Start Time</th> 
						  <th width="140" style="text-align:center" >Time In</th>
						  <th width="140" style="text-align:center" >Time Out</th>
							<th width="140" style="text-align:center" >End Time</th>
							<th width="100" style="text-align:center" >Ticket No.</th>		
						<th width="50" style="text-align:center" >Expense</th>  							
						</tr> 
						<?php if(!empty($DriverLoadsDayWork)){
								foreach($DriverLoadsDayWork as $key=>$record){ ?>
							<tr style="outline: thin solid">
							  <td><?php echo $record->CompanyName." <br>".$record->OpportunityName; ?></td>
							  <td><?php echo $record->TipName; ?></td>
							  <td><?php echo $record->MaterialName; ?></td>  
							  <td><?php echo $record->JobStartDateTime; ?></td>
							  <td><?php echo $record->SiteInDateTime; ?></td>
							  <td><?php echo $record->SiteOutDateTime; ?></td>
							  <td><?php echo $record->JobEndDateTime; ?></td>
								<td ><?php echo $record->ConveyanceNo; ?></td>	
								<td><?php echo $record->Expenses; ?></td> 								
							</tr> 
						<?php } }else{ ?>
							<tr style="outline: thin solid"><td colspan="9"> There is no Daywork Records Available. </td></tr>
						<?php } ?>
						
					  </table>
					</div> 
				</div>  
			</div> 
        </div> 	
        
        <div class="row">
			
			<div class="col-xs-12"> 
				<div class="box">
					<div class="box-header"  >
					  <h3 class="box-title"><b>Haulage</b></h3>
					</div> 
					<div class="box-body no-padding">
					  <table class="table table-striped" border="1">
						<tr style="outline: thin solid">
						  <th colspan="3"></th>
						  <th colspan="3"  ><center>Collection Times</center></th>
						  <th colspan="3"  ><center>Delivery Times</center></th>
						  <th   ></th>
						</tr> 
						
						<tr style="outline: thin solid">
						  <th  style="text-align:center" >Collection Address</th>
						  <th  style="text-align:center" >Destination Address</th>
						  <th style="text-align:center" >Material</th>  
						  <th  width="140" style="text-align:center" >Start Time</th> 
						  <th width="140" style="text-align:center" >Time In</th>
						  <th width="140" style="text-align:center" >Time Out</th>
						  <th width="140" style="text-align:center" >Time In</th>
						  <th width="140" style="text-align:center" >Time Out</th>
						  <th width="140" style="text-align:center" >End Time</th>						  
						  <th width="100" style="text-align:center" >Ticket No.</th>
						  <th width="50" style="text-align:center" >Expense</th>  
						</tr> 
						<?php if(!empty($DriverLoadsHaulage)){
								foreach($DriverLoadsHaulage as $key=>$record){ ?>
							<tr style="outline: thin solid">
							  <td><?php echo $record->CompanyName." <br>".$record->OpportunityName; ?></td>
							  <td><?php echo $record->TipName; ?></td>
							  <td><?php echo $record->MaterialName; ?></td>  
							  <td><?php echo $record->JobStartDateTime; ?></td>
							  <td><?php echo $record->SiteInDateTime; ?></td>
							  <td><?php echo $record->SiteOutDateTime; ?></td>
							  <td><?php echo $record->SiteInDateTime2; ?></td>
							  <td><?php echo $record->SiteOutDateTime2; ?></td>
							  <td><?php echo $record->JobEndDateTime; ?></td>
								<td ><?php echo $record->ConveyanceNo; ?></td>	
								<td><?php echo $record->Expenses; ?></td> 								
							</tr> 
						<?php } }else{ ?>
							<tr style="outline: thin solid"><td colspan="10" > There is no Haulage Records Available. </td></tr>
						<?php } ?>
						
					  </table>
					</div> 
				</div>  
			</div> 
        </div> 	
		
    </section>
</div> 
<script type="text/javascript" language="javascript" > 	 
	$(document).ready(function(){
		$('#searchdate').datepicker({  
			format: 'dd/mm/yyyy', 
			endDate: '+0d',			
			daysOfWeekDisabled  : [0],
			autoclose: true   
		}); 		
    });    	 
</script> 
