
<link href="https://www.malot.fr/bootstrap-datetimepicker/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="https://www.malot.fr/bootstrap-datetimepicker/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer" aria-hidden="true"></i> Live Tracking Dashboard<br>
      <small>Track Driver`s Live Locations</small>
      <?php if (isset($_GET['booking_id']) && !empty($_GET['booking_id']) && isset($_GET['driver_id']) && !empty($_GET['driver_id']) && isset($_GET['load_id']) && !empty($_GET['load_id']) && isset($_GET['vehicle_reg_no']) && !empty($_GET['vehicle_reg_no']) && isset($_GET['opportunity_id']) && !empty($_GET['opportunity_id'])) {?>
      <div class="back_link" style="position: absolute;right: 20px;top: 35px;">
        <a href="<?php echo base_url ('dashboard_new'); ?>" style="font-size: 16px; color:#000000; text-decoration: underline; font-weight: bold;">< Back</a>
      </div>
      <?php }?>



    </h1>
  </section>

  <section class="content">

    <?php /*?><div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3><?= $company_count; ?></h3>
            <p>Total Companies</p>
          </div>
          <div class="icon">
            <i class="fa fa-building-o" aria-hidden="true"></i>
          </div>
          <a href="<?= base_url('companies'); ?>" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3><?= $contact_count; ?></h3>
            <p>Total Contacts</p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="<?= base_url('contacts'); ?>" class="small-box-footer">See All <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3><?= $user_count; ?></h3>
            <p>Total Users</p>
          </div>
          <div class="icon">
            <i class="fa fa-users"></i>
          </div>
          <a href="<?php echo base_url(); ?>userListing" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3><?= $ticket_count; ?></h3>
            <p>Total Tickets</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?php echo base_url(); ?>All-Tickets" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
    </div> <?php */ ?>


    <div class="row">
      <div class="col-lg-4 col-xs-12">

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Live Tracking</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin driver_table">
                <?php 
				$exisitngLorryNums = array();
				if (count($loads['data']) > 0) { ?>

                  <thead>
                    <tr>
                      <!-- <th>Type</th> -->
                      <th>Name</th>
                      <th>Lorry Number</th>
                      <th>Haulier</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($loads['recordsTotal'] > 0) {
                      foreach ($loads['data'] as $k => $row) { ?>
                        <?php 
						if(in_array($row['LorryNo'],$exisitngLorryNums)){ continue;}
						
						
						$url = base_url('dashboard_new') . '?booking_id=' . $row['BookingID'] . '&driver_id=' . $row['DriverLoginID'] . '&load_id=' . $row['LoadID'] . '&vehicle_reg_no=' . $row['VehicleRegNo'] . '&opportunity_id=' . $row['OpportunityID']; ?>

                        <?php if (isset($row['DriverName']) && !empty($row['DriverName'])) {
                          $driverName = $row['DriverName'];
                        } else {
                          $driverName = $row['dname'];
                        }
                        ?>


                        <?php
                        $class = "";
                        if (isset($_GET['booking_id']) && !empty($_GET['booking_id']) && isset($_GET['driver_id']) && !empty($_GET['driver_id']) && isset($_GET['load_id']) && !empty($_GET['load_id']) && isset($_GET['vehicle_reg_no']) && !empty($_GET['vehicle_reg_no']) && isset($_GET['opportunity_id']) && !empty($_GET['opportunity_id'])) {
                          if ($_GET['booking_id'] == $row['BookingID'] && $_GET['driver_id'] == $row['DriverLoginID'] && $_GET['load_id'] == $row['LoadID'] && $_GET['vehicle_reg_no'] == $row['VehicleRegNo'] && $_GET['opportunity_id'] == $row['OpportunityID']) {
                            $class = "is_current_load";
                          }
                        } ?>




                        <tr style="cursor:pointer;" data-booking_id="<?php echo $row['BookingID']; ?>" data-driver_id="<?php echo $row['DriverLoginID']; ?>" data-load_id="<?php echo $row['LoadID']; ?>" data-vehicle_reg_no="<?php echo $row['VehicleRegNo']; ?>" data-opportunity_id="<?php echo $row['OpportunityID']; ?>" data-driver_name="<?php echo $driverName; ?>" onclick="window.location='<?php echo $url; ?>'" class="<?php echo $class; ?>">






                          <!-- <td>
                          <?php if ($row['BookingType'] == "1") {
                            echo "Collection";
                          } else {
                            echo "Delivery";
                          }
                          ?>
                        </td> -->
                          <td>
                            <?php echo $driverName; ?>
                          </td>
                          <td>
                            <?php 
							
							if (isset($row['LorryNo']) && $row['LorryNo'] != 0) {
                              echo $row['LorryNo'];
							  $exisitngLorryNums[] = $row['LorryNo'];
                            } else {
                              echo "-";
                            }

                            /* $getLAtLong = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($row['OpportunityName']) . "&key=AIzaSyC_TOSZMAbYq4BCJDVMds7BVirU9FqrJYI";

                            $curl = curl_init($url);
                            curl_setopt($curl, CURLOPT_URL, $getLAtLong);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                            $headers = array(
                              "Accept: application/json",
                            );
                            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                            //for debug only!
                            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                            $resp = curl_exec($curl);
                            curl_close($curl);



                            $getLAtLongDetails = json_decode($resp, true);
                            $loads['data'][$k]['lat'] = $getLAtLongDetails['results'][0]['geometry']['location']['lat'];
                            $loads['data'][$k]['long'] = $getLAtLongDetails['results'][0]['geometry']['location']['lng']; */




                            ?>


                            <?php if (isset($_GET['booking_id']) && !empty($_GET['booking_id']) && isset($_GET['driver_id']) && !empty($_GET['driver_id']) && isset($_GET['load_id']) && !empty($_GET['load_id']) && isset($_GET['vehicle_reg_no']) && !empty($_GET['vehicle_reg_no']) && isset($_GET['opportunity_id']) && !empty($_GET['opportunity_id'])) {
                              if ($_GET['booking_id'] == $row['BookingID'] && $_GET['driver_id'] == $row['DriverLoginID'] && $_GET['load_id'] == $row['LoadID'] && $_GET['vehicle_reg_no'] == $row['VehicleRegNo'] && $_GET['opportunity_id'] == $row['OpportunityID']) {
                                
                                
                                $getLAtLong = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($row['OpportunityName']) . "&key=AIzaSyC_TOSZMAbYq4BCJDVMds7BVirU9FqrJYI";

                                $curl = curl_init($url);
                                curl_setopt($curl, CURLOPT_URL, $getLAtLong);
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                                $headers = array(
                                  "Accept: application/json",
                                );
                                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                                //for debug only!
                                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                                $resp = curl_exec($curl);
                                curl_close($curl);



                                $getLAtLongDetails = json_decode($resp, true);
                                $loads['data'][$k]['lat'] = $getLAtLongDetails['results'][0]['geometry']['location']['lat'];
                                $loads['data'][$k]['long'] = $getLAtLongDetails['results'][0]['geometry']['location']['lng'];

                                $currentLoad = $loads['data'][$k];
                              }
                            } ?>


                          </td>

                          <td>Thames Materials Ltd.</td>

                        </tr>
                      <?php }
                    } else { ?>
                      <tr>
                        <td align="center" colspan="3">There is no records. </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                <?php } else { ?>
                  <tr>
                    <td align="center" colspan="3">There are no records. </td>
                  </tr>
                <?php } ?>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->

          <!-- /.box-footer -->
        </div>

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">All Drivers</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin driver_table">
                <?php if (count($driverList) > 0) { ?>

                  <thead>
                    <tr>
                      <!-- <th>Type</th> -->
                      <th>Name</th>
                      <th>LorryNo</th>
                      <th>Haulier</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (count($driverList) > 0) {
                      foreach ($driverList as $k => $row) { 
					  if(in_array($row->LorryNo,$exisitngLorryNums)){ continue;}
					  ?>
					  <tr data-driver_id="<?php echo $row->DriverID; ?>"  data-driver_name="<?php echo $row->DriverName; ?>">
                        <td><?php echo $row->DriverName;?></td>
                        <td><?php echo $row->LorryNo;?></td>
                        <td><?php echo $row->Haulier;?></td>
                        </tr>
                      <?php }
                    } else { ?>
                      <tr>
                        <td align="center" colspan="3">There is no records. </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                <?php } else { ?>
                  <tr>
                    <td align="center" colspan="3">There are no records. </td>
                  </tr>
                <?php } ?>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.box-body -->

          <!-- /.box-footer -->
        </div>

      </div>
      
        <div class="col-lg-8 col-xs-12">
          <div id="map" style="width: 100%; height: 750px;"></div>


          <?php if (isset($_GET['booking_id']) && !empty($_GET['booking_id']) && isset($_GET['driver_id']) && !empty($_GET['driver_id']) && isset($_GET['load_id']) && !empty($_GET['load_id']) && isset($_GET['vehicle_reg_no']) && !empty($_GET['vehicle_reg_no']) && isset($_GET['opportunity_id']) && !empty($_GET['opportunity_id'])) { ?>
            <div class="row">
              <div class="col-xs-12">
                <?php
                $bookingType = '';
                if ($currentLoad['BookingType'] == "1") {
                  $bookingType = "Collection";
                } else {
                  $bookingType = "Delivery";
                }
                if ($currentLoad['LoadType'] == "1") {
                  $loadType = "Load";
                } elseif ($currentLoad['LoadType'] == "2") {
                  $loadType = "TurnAround";
                } else {
                  $loadType = "";
                }
                ?>
                <div class="table-responsive">
                  <table class="table no-margin job_type_table" border="1" style="border-color: #fff;">
                    <thead>
                      <tr>
                        <th style="background: #3c8dbc;color:#fff;vertical-align: top; font-size:16px;">Job Type</th>
                        <th style="background: #3c8dbc;color:#fff;vertical-align: top; font-size:16px;">Driver Name</th>
                        <th style="background: #3c8dbc;color:#fff;vertical-align: top; font-size:16px;">Vehicle reg</th>
                        <th style="background: #3c8dbc;color:#fff;vertical-align: top; font-size:16px;">Site Name</th>
                        <th style="background: #3c8dbc;color:#fff;vertical-align: top; font-size:16px;">Tip Site</th>
                        <th style="background: #3c8dbc;color:#fff;vertical-align: top; font-size:16px;">ETA</th>
                        <th style="background: #3c8dbc;color:#fff;vertical-align: top; font-size:16px;">Lorry Number</th>
                        <th style="background: #3c8dbc;color:#fff;vertical-align: top; font-size:16px;">Current Speed</th>
                      </tr>
                    </thead>
                    <tr>
                      <td style="background: #bdecff;"><?php echo $loadType . ' - ' . $bookingType; ?></td>
                      <td style="background: #bdecff;"><?php
                                                        if (isset($currentLoad['DriverName']) && !empty($currentLoad['DriverName'])) {
                                                          echo $currentLoad['DriverName'];
                                                        } else {
                                                          echo $currentLoad['dname'];
                                                        }
                                                        ?></td>
                      <td style="background: #bdecff;"><?php
                                                        if (isset($currentLoad['VehicleRegNo']) && $currentLoad['VehicleRegNo'] != 0) {
                                                          echo $currentLoad['VehicleRegNo'];
                                                        } else {
                                                          echo $currentLoad['rname'];
                                                        }
                                                        ?></td>
                      <td style="background: #bdecff;"><?php echo $currentLoad['OpportunityName']; ?></td>
                      <td style="background: #bdecff;"><?php echo $currentLoad['tipaddress_tipname'] . ', ' . $currentLoad['tipaddress_street1'] . ', ' . $currentLoad['tipaddress_street2'] . ', ' . $currentLoad['tipaddress_town'] . ', ' . $currentLoad['tipaddress_country'] . ', ' . $currentLoad['tipaddress_postcode']; ?></td>
                      <td style="background: #bdecff;">
                        <?php if (count($live_tracking_data) > 0) {
                          echo $live_tracking_data[0]['eta'];
                        } else {
                          echo "-";
                        } ?>
                      </td>
                      <td style="background: #bdecff;"><?php echo $currentLoad['LorryNo']; ?></td>
                      <td style="background: #bdecff;">
                        <?php if (count($live_tracking_data) > 0) {
                          echo $live_tracking_data[0]['current_speed'] . ' Miles/Hr';
                        } else {
                          echo "-";
                        } ?>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>



            <?php if (isset($_GET['booking_id']) && !empty($_GET['booking_id']) && isset($_GET['driver_id']) && !empty($_GET['driver_id']) && isset($_GET['load_id']) && !empty($_GET['load_id']) && isset($_GET['vehicle_reg_no']) && !empty($_GET['vehicle_reg_no']) && isset($_GET['opportunity_id']) && !empty($_GET['opportunity_id'])) { ?>
              <div class="accordion" id="accordionExample" style="margin-top:15px;">
                <div class="card" style="margin-bottom:10px;">
                  <div class="card-header collapsed" id="heading_due_jobs" data-toggle="collapse" data-target="#collapse_due_jobs" aria-expanded="true" aria-controls="collapse_due_jobs">
                    <div class="box-header" style="background: #3c8dbc;color: #fff;">
                      <h3 class="box-title" style="display:block;">Today`s due Jobs <i class="fa fa-plus rotate-icon" style="float:right; margin-right:5px;"></i></h3>
                    </div>
                  </div>
                  <div id="collapse_due_jobs" class="collapse" aria-labelledby="heading_due_jobs" data-parent="#accordionExample">
                    <div class="card-body">
                      <div class="box-body">
                        <div class="table-responsive">
                          <table class="table no-margin">
                            <?php if (isset($running_loads['data']) && !empty($running_loads['data'])) { ?>
                              <thead>
                                <tr>
                                  <th>BNO</th>
                                  <th>Type</th>
                                  <th>Company Name</th>
                                  <th>Site Name</th>
                                  <th>Material</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                foreach ($running_loads['data'] as $row) {
                                ?>
                                  <tr>
                                    <td><a class="ShowLoads" data-BookingDateID="<?php echo $row['BookingDateID']; ?>" herf="javascript:void(0);"><?php echo $row['BookingID']; ?></a></td>
                                    <td><?php
                                        if ($row['BookingType'] == "1") {
                                          echo "Collection";
                                        } else {
                                          echo "Delivery";
                                        }
                                        ?></td>
                                    <td><?php echo $row['CompanyName']; ?></td>
                                    <td><?php echo $row['OpportunityName']; ?></td>

                                    <td><?php echo $row['MaterialName']; ?></td>
                                  </tr>
                                <?php } ?>

                              </tbody>
                            <?php } else { ?>
                              <tr>
                                <td align="center" colspan="3">There are no records. </td>
                              </tr>
                            <?php } ?>
                          </table>
                        </div>
                        <!-- /.table-responsive -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" style="margin-bottom:10px;">
                  <div class="card-header collapsed" id="heading_completed_jobs" data-toggle="collapse" data-target="#collapse_completed_jobs" aria-expanded="true" aria-controls="collapse_completed_jobs">
                    <div class="box-header" style="background: #3c8dbc;color: #fff;">
                      <h3 class="box-title" style="display:block;">Recently Completed Jobs <i class="fa fa-plus rotate-icon" style="float:right; margin-right:5px;"></i></h3>
                    </div>
                  </div>
                  <div id="collapse_completed_jobs" class="collapse" aria-labelledby="heading_completed_jobs" data-parent="#accordionExample">
                    <div class="card-body">
                      <div class="box-body">
                        <div class="table-responsive">
                          <table class="table no-margin">
                            <?php if (isset($completed_loads['data']) && !empty($completed_loads['data'])) { ?>
                              <thead>
                                <tr>
                                  <th>BNO</th>
                                  <th>Type</th>
                                  <th>Company Name</th>
                                  <th>Site Name</th>
                                  <th>Material</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                foreach ($completed_loads['data'] as $row) {
                                ?>
                                  <tr>
                                    <td><?php echo $row['BookingID']; ?></td>
                                    <td><?php
                                        if ($row['BookingType'] == "1") {
                                          echo "Collection";
                                        } else {
                                          echo "Delivery";
                                        }
                                        ?></td>
                                    <td><?php echo $row['CompanyName']; ?></td>
                                    <td><?php echo $row['OpportunityName']; ?></td>

                                    <td><?php echo $row['MaterialName']; ?></td>
                                  </tr>
                                <?php } ?>

                              </tbody>
                            <?php } else { ?>
                              <tr>
                                <td align="center" colspan="3">There are no records. </td>
                              </tr>
                            <?php } ?>
                          </table>
                        </div>
                        <!-- /.table-responsive -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card" style="margin-bottom:10px;">
                  <div class="card-header collapsed" id="heading_tomorrow_jobs" data-toggle="collapse" data-target="#collapse_tomorrow_jobs" aria-expanded="true" aria-controls="collapse_tomorrow_jobs">
                    <div class="box-header" style="background: #3c8dbc;color: #fff;">
                      <h3 class="box-title" style="display:block;">Tomorrow`s Jobs <i class="fa fa-plus" style="float:right; margin-right:5px;"></i></h3>
                    </div>
                  </div>
                  <div id="collapse_tomorrow_jobs" class="collapse" aria-labelledby="heading_tomorrow_jobs" data-parent="#accordionExample">
                    <div class="card-body">
                      <div class="box-body">
                        <div class="table-responsive">
                          <table class="table no-margin">
                            <?php if (isset($tomorrow_loads['data']) && !empty($tomorrow_loads['data'])) { ?>
                              <thead>
                                <tr>
                                  <th>BNO</th>
                                  <th>Type</th>
                                  <th>Company Name</th>
                                  <th>Site Name</th>
                                  <th>Material</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                foreach ($tomorrow_loads['data'] as $row) {
                                ?>
                                  <tr>
                                    <td><?php echo $row['BookingID']; ?></td>
                                    <td><?php
                                        if ($row['BookingType'] == "1") {
                                          echo "Collection";
                                        } else {
                                          echo "Delivery";
                                        }
                                        ?></td>
                                    <td><?php echo $row['CompanyName']; ?></td>
                                    <td><?php echo $row['OpportunityName']; ?></td>

                                    <td><?php echo $row['MaterialName']; ?></td>
                                  </tr>
                                <?php } ?>

                              </tbody>
                            <?php } else { ?>
                              <tr>
                                <td align="center" colspan="3">There are no records. </td>
                              </tr>
                            <?php } ?>
                          </table>
                        </div>
                        <!-- /.table-responsive -->
                      </div>
                    </div>
                  </div>
                </div>


              </div>

            <?php } ?>











          <?php } ?>


        </div>
      
    </div>






  </section>
</div>

<input type="hidden" name="origin" id="origin" value="" />
<input type="hidden" name="destination" id="destination" value="" />
<input type="hidden" name="current_location" id="current_location" value="" />


  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_TOSZMAbYq4BCJDVMds7BVirU9FqrJYI&region=GB&callback=initMap" type="text/javascript"></script>

  <?php if (isset($live_tracking_data) && count($live_tracking_data) > 0) { ?>
    <script>
      $(function() {
        var origin, destination, map;
        var markers = [];
        // add input listeners
        initMap();
        // init or load map
        function initMap() {
          var myLatLng = {
            lat: <?php echo $live_tracking_data[0]['latitude'] ?>,
            lng: <?php echo $live_tracking_data[0]['longitude'] ?>
          };
          const geocoder = new google.maps.Geocoder();
          const infowindow = new google.maps.InfoWindow();
          map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: myLatLng,
          });
        }
        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
          for (let i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
          }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
          setMapOnAll(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
          setMapOnAll(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
          clearMarkers();
          markers = [];
        }

        function displayRoute(travel_mode, origin, destination, directionsService, directionsDisplay) {
          const waypts = [];
          <?php 
		  $liveData = array_reverse($live_tracking_data);
		  //$liveData = array_chunk($liveData,8);
		  $n = floor(count($liveData) / 6);
		$liveData = array_chunk($liveData, $n ?: 1);
		  foreach ($liveData as $tracing) { ?>
            var wayLatLng = {
              lat: <?php echo $tracing[0]['latitude'] ?>,
              lng: <?php echo $tracing[0]['longitude'] ?>
            };
            waypts.push({
              location: wayLatLng,
              stopover: false,
            });
          <?php } ?>
          directionsService.route({
            origin: origin,
            destination: destination,
            travelMode: travel_mode,
            avoidTolls: true,
            waypoints: waypts,
            optimizeWaypoints: true,
          }, function(response, status) {
            if (status === 'OK') {
              directionsDisplay.setMap(map);
              directionsDisplay.setDirections(response);
            } else {
              directionsDisplay.setMap(null);
              directionsDisplay.setDirections(null);
              alert('Could not display directions due to: ' + status);
            }
          });
        }
        // calculate distance , after finish send result to callback function
        function calculateDistance(travel_mode, origin, destination) {

          var DistanceMatrixService = new google.maps.DistanceMatrixService();
          DistanceMatrixService.getDistanceMatrix({
            origins: [origin],
            destinations: [destination],
            travelMode: google.maps.TravelMode[travel_mode],
            unitSystem: google.maps.UnitSystem.IMPERIAL, // miles and feet.
            // unitSystem: google.maps.UnitSystem.metric, // kilometers and meters.
            avoidHighways: false,
            avoidTolls: false
          }, save_results);
        }
        // save distance results
        function save_results(response, status) {
          /* if (status != google.maps.DistanceMatrixStatus.OK) {
              $('#result').html(err);
          } else {
              var origin = response.originAddresses[0];
              var destination = response.destinationAddresses[0];
              if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
                  $('#result').html("Sorry , not available to use this travel mode between " + origin + " and " + destination);
              } else {
                  var distance = response.rows[0].elements[0].distance;
                  var duration = response.rows[0].elements[0].duration;
                  var distance_in_kilo = distance.value / 1000; // the kilo meter
                  var distance_in_mile = distance.value / 1609.34; // the mile
                  var duration_text = duration.text;
                  appendResults(distance_in_kilo, distance_in_mile, duration_text);
                  sendAjaxRequest(origin, destination, distance_in_kilo, distance_in_mile, duration_text);
              }
          } */
        }
        // get formatted address based on current position and set it to input
        function setCurrentPosition(geocoder, map, lat, long,markerLabel='') {
          const infowindow = new google.maps.InfoWindow();
          geocodeLatLng(geocoder, map, infowindow, lat, long, "",markerLabel);
        }

        function geocodeLatLng(geocoder, map, infowindow = "", lat, long, elementId,markerLabel='') {
          const latlng = {
            lat: lat,
            lng: long,
          };
          var formattedaddress = '';
          geocoder.geocode({
            location: latlng
          }, (results, status) => {
            if (status === "OK") {
              if (results[0]) {
                formattedaddress = results[0].formatted_address;
                if (elementId !== "") {
                  $("#" + elementId).val(formattedaddress);
                }

                if (infowindow !== "") {
                  const marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    label: markerLabel,
                  });
                  infowindow.setContent(results[0].formatted_address);
                  infowindow.open(map, marker);
                  if(markerLabel !== "A" && markerLabel !== "B"){
                    markers.push(marker);
                  }
                }
              } else {
                window.alert("No results found");
              }
            } else {
              window.alert("Geocoder failed due to: " + status);
            }
          });
          return formattedaddress;
        }

        const geocoder = new google.maps.Geocoder();
        /* geocodeLatLng(geocoder, map, "", <?php echo end($live_tracking_data)['latitude'] ?>, <?php echo end($live_tracking_data)['longitude'] ?>, "origin",'A'); */
        setCurrentPosition(geocoder, map, <?php echo end($live_tracking_data)['latitude'] ?>, <?php echo end($live_tracking_data)['longitude'] ?>, 'A');



        //geocodeLatLng(geocoder, map, "", 51.5229, 0.1308, "destination");
        //geocodeLatLng(geocoder, map, "", 23.0535, 72.5470, "destination");
        //geocodeLatLng(geocoder, map, "", <?php echo $currentLoad['lat'];?>, <?php echo $currentLoad['long'];?>, "destination",'B');
        setCurrentPosition(geocoder, map, <?php echo $currentLoad['lat'];?>, <?php echo $currentLoad['long'];?>, 'B');
		
		
		
		    setCurrentPosition(geocoder, map, <?php echo $live_tracking_data[0]['latitude'] ?>, <?php echo $live_tracking_data[0]['longitude'] ?>,'C');
			//map.setCenter(new google.maps.LatLng(parseFloat(<?php echo $live_tracking_data[0]['latitude'] ?>), parseFloat(<?php echo $live_tracking_data[0]['longitude'] ?>)));
			//map.setZoom(16);
		/* setTimeout(function() {
          var origin = $("#origin").val();
          var destination = $("#destination").val();
          var travel_mode = "DRIVING";
          var directionsDisplay = new google.maps.DirectionsRenderer({
            'draggable': false
          });
          var directionsService = new google.maps.DirectionsService();
          displayRoute(travel_mode, origin, destination, directionsService, directionsDisplay);

        }, 1000); */

        setInterval(function(){
          //$('#empModal').modal('show');  
          hitURL1 = baseURL + "dashboard_new?booking_id=<?php echo $_GET['booking_id'] ?>&driver_id=<?php echo $_GET['driver_id'] ?>&load_id=<?php echo $_GET['load_id'] ?>&vehicle_reg_no=<?php echo $_GET['vehicle_reg_no'] ?>&opportunity_id=<?php echo $_GET['opportunity_id'] ?>&is_ajax=1",
        jQuery.ajax({
          type: "GET",
          dataType: "json",
          url: hitURL1,
        }).success(function(data) {
          if(data == "no_results"){
            return;
          }
          console.log(data);
          var latitude = data.latitude;
          var longitude = data.longitude;
          deleteMarkers();
          setCurrentPosition(geocoder, map, parseFloat(latitude), parseFloat(longitude),'C');
		  map.setCenter(new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude)));
		  map.setZoom(16);
        });
        },10000);

      });
    </script>
  <?php } else { ?>





    <script type="text/javascript">
      
      var locations = [
        <?php if (count($loads['data']) > 0) {
          foreach ($loads['data'] as $k => $row) {

            if (isset($row['VehicleRegNo']) && $row['VehicleRegNo'] != 0) {
              $vehicleRegNo = $row['VehicleRegNo'];
              $map_vehicleRegNo = '<b>VehicleRegNo: </b>'.$row['VehicleRegNo'].'<br>';
            } else {
              $vehicleRegNo = $row['rname'];
              $map_vehicleRegNo = '<b>VehicleRegNo: </b>'.$row['rname'].'<br>';
            }
            if(isset($row['live_tracking_data']) && !empty($row['live_tracking_data'])){
                $lat = $row['live_tracking_data'][0]['latitude'];
                $long = $row['live_tracking_data'][0]['longitude'];
            }else{
              continue;
            }

            
        
            if (isset($row['DriverName']) && !empty($row['DriverName'])) {
              $map_driverName = '<b>Driver: </b>'.$row['DriverName'].'<br><div style="height:5px; width:100%;"></div>';
            } else {
              $map_driverName = '<b>Driver: </b>'.$row['dname'].'<br><div style="height:5px; width:100%;"></div>';
            }
            if (isset($row['LorryNo']) && $row['LorryNo'] != 0) {
              $map_lorryNo = '<b>LorryNo: </b>'.$row['LorryNo'].'<br><div style="height:5px; width:100%;"></div>';
            } else {
              $map_lorryNo = '<b>LorryNo: </b>-<br><div style="height:5px; width:100%;"></div>';
            }


            ?>['<?php echo $map_driverName.$map_lorryNo.$map_vehicleRegNo; ?>', <?php echo $lat; ?>, <?php echo $long; ?>, <?php echo $k + 1; ?>],
          <?php } ?>

         <?php }else{?>
          <?php }?>
      ];
      <?php if(isset($lat) && !empty($lat) && isset($long) && !empty($long)){ ?>
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      <?php }else{?>
        var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(51.536260, -0.490720),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      <?php }?>

      var markers = [];
      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (let i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

      var infowindow = new google.maps.InfoWindow();

      var marker, i;

      for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map
        });
        markers.push(marker);


        google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          }
        })(marker, i));
      }
      setInterval(function(){
          //$('#empModal').modal('show');  
          hitURL1 = baseURL + "dashboard_new?is_ajax=1",
        jQuery.ajax({
          type: "GET",
          dataType: "json",
          url: hitURL1,
        }).success(function(data) {
          if(data == "no_results"){
            return;
          }
          console.log(data);
          //var latitude = data.latitude;
          //var longitude = data.longitude;
          deleteMarkers();
          var infowindow = new google.maps.InfoWindow();
          var marker, i;
          var locations = data;
          for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(locations[i][1], locations[i][2]),
              map: map
            });
            markers.push(marker);
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
              }
            })(marker, i));
          }

        });
        },10000);
    </script>
  <?php } ?>



<style type="text/css">
  /* CSS3 */

  /* The whole thing */
  .custom-right-menu {
    display: none;
    z-index: 1000;
    position: absolute;
    overflow: hidden;
    border-top: 4px solid #3c8dbc;
    white-space: nowrap;
    font-family: sans-serif;
    background: #FFF;
    color: #333;
    border-radius: 0;
    padding: 0;
    box-shadow: 0px 3px 9px -1px #000;
  }

  .custom-right-menu:before,
  .custom-right-menu:after {
    content: '';
    position: absolute;
    bottom: 100%;
    left: 19px;
    border: 11px solid transparent;
    border-bottom-color: #dddddd;
  }

  .custom-right-menu:after {
    left: 20px;
    border: 10px solid transparent;
    border-bottom-color: #ffffff;
  }

  /* Each of the items in the list */
  .custom-right-menu li {
    padding: 8px 12px;
    cursor: pointer;
    list-style-type: none;
    transition: all .3s ease;
    user-select: none;
    border-bottom: 1px solid #ddd;
    padding: 11px 15px;
  }

  .custom-right-menu li:hover {
    background-color: #DEF;
  }

  .modal-header .close {
    margin-top: 0;
    position: absolute;
    right: 10px;
    top: 13px;
    font-size: 21px;
    color: #fff;
    opacity: 1;
    border: 1px solid #fff;
    border-radius: 100%;
    width: 24px;
    height: 24px;
    line-height: 9px;
    padding-bottom: 2px;
  }

  .driver_table tr.is_current_load {
    background: #3c8dbc;
    color: #fff;
  }

  .box.box-info {
    border-top-color: #3c8dbc;
  }

  .modal-header {
    min-height: 16.43px;
    padding: 10px 15px;
    border-bottom: 1px solid #e5e5e5;
    background: #3c8dbc;
    color: #fff;
  }

  .job_type_table,
  .job_type_table tr,
  .job_type_table td,
  .job_type_table th {
    border-color: #fff !important;
  }

  .card-header .box-title .fa-plus:before {
    content: "\f068";
  }

  .card-header.collapsed .box-title .fa-plus:before {
    content: "\f067";
  }

  .accordion .card-body {
    border: 1px solid #3c8dbc;
  }
</style>

<ul class='custom-right-menu'>
  <li data-action="send_message" data-driver="">Send Message</li>
  <!-- <li data-action="request_update" data-driver="">Request Update</li> -->
  <li data-action="replay" data-driver="">Replay Vehicle Activity</li>
</ul>
<div class="modal" id="send_message" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Send Message To Drivers</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <?php if (!empty($driverList)) { ?>
            <ul class="list-unstyled">
				<li>
                  <input type="checkbox" class="checkboxes" id="drivermine_checkall" value="1">
                  <label for="drivermine_checkall">Select All</label>
                </li>
              <?php foreach ($driverList as $key => $record) { ?>
                <li>
                  <input type="checkbox" name="driver_messages" class="checkboxes" id="drivermine_<?php echo $record->LorryNo ?>" value="<?php echo $record->LorryNo ?>">
                  <label for="drivermine_<?php echo $record->LorryNo ?>"><?php echo $record->DriverName ?> (<?php echo $record->MobileNo ?>) (<?php echo $record->Email ?>)</label>
                </li>
              <?php  } ?>
            </ul>
			
          <?php } ?>
        </div>
        <div class="form-group">
          <textarea class="form-control" id="message" rows="3" style="width:500px" name="message" placeholder="Please add your comments here..." required></textarea>
          <input type="hidden" name="cur_driver_id" id="cur_driver_id" value="" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Send Message</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="replay_vehicle_activities" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Replay Vehicle Activity Criteria</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="get" id="view_activity_form">
          <div class="form-group">
            <label for="start_time">Start Date/time <span class="required">*</span></label>
            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              <input type="text" class="form-control required" id="start_time" autocomplete="off" value="" name="start_time" maxlength="65">
            </div>
            <div></div>
          </div>

          <div class="form-group">
            <label for="end_time">End Date/time <span class="required">*</span></label>
            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              <input type="text" class="form-control required" id="end_time" autocomplete="off" value="" name="end_time" maxlength="65">
            </div>
            <div></div>
          </div>
          <input type="hidden" name="cur_driver_id" id="cur_driver_id" value="" />
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary view_activity">View Activity</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  <script type="text/javascript" language="javascript">
    function populateEndDate() {
      var date2 = $('#start_time').datetimepicker('getDate');
      date2.setDate(date2.getDate() + 1);
      $('#end_time').datetimepicker('setDate', date2);
      $("#end_time").datetimepicker("option", "minDate", date2);
    }
    $(document).ready(function() {
      $('#start_time').datetimepicker({
        format: 'dd/mm/yyyy hh:ii',
        startDate: 'today',
        endDate: '+0d',
        autoclose: true,
        onSelect: function(date) {
          populateEndDate();
        }
      });
      $('#end_time').datetimepicker({
        format: 'dd/mm/yyyy hh:ii',
        startDate: 'today',
        //endDate: '+0d',
        autoclose: true,
        onClose: function() {
          var dt1 = $('#start_time').datetimepicker('getDate');
          var dt2 = $('#end_time').datetimepicker('getDate');
          if (dt2 <= dt1) {
            var minDate = $('#end_time').datetimepicker('option', 'minDate');
            $('#end_time').datetimepicker('setDate', minDate);
          }
        }
      });
    });
  </script>
</div>
<div class="modal fade" id="empModal" role="dialog">
  <div class="modal-dialog" style="width:600px">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Booking Loads/Lorry Information </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body"></div>
      <div class="TEST"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(".driver_table tbody tr").bind("contextmenu", function(event) {

    // Avoid the real one
    event.preventDefault();

    var driverId = $(this).attr("data-driver_id");
    var driverName = $(this).attr("data-driver_name");

    $('#replay_vehicle_activities #cur_driver_id').val(driverId);
    $('#replay_vehicle_activities .modal-title').html("Replay Vehicle Activity Criteria - " + driverName);

    // Show contextmenu
    $(".custom-right-menu").finish().toggle(100).

    // In the right position (the mouse)
    css({
      top: event.pageY + "px",
      left: event.pageX + "px"
    });
  });


  // If the document is clicked somewhere
  $(document).bind("mousedown", function(e) {

    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-right-menu").length > 0) {
      // Hide it
      $(".custom-right-menu").hide(100);
    }
  });


  // If the menu element is clicked
  $(".custom-right-menu li").click(function() {
    // This is the triggered action name
    switch ($(this).attr("data-action")) {
      // A case for each action. Your actions here
      case "send_message":
        jQuery("#send_message").modal("show");
        break;
        /* case "request_update":
          //alert("second");
          break; */
      case "replay":
        jQuery("#replay_vehicle_activities").modal("show");
        break;
    }
    // Hide it AFTER the action was triggered
    $(".custom-right-menu").hide(100);
  });
  $(document).ready(function() {
        $("#send_message .btn-primary").on("click", function() {
          var dchecked = [];
          $.each($("input[name='driver_messages']:checked"), function() {
            dchecked.push($(this).val());
          });
          var driverID = dchecked.join(",");
          var message = $('#send_message #message').val();
          if (driverID == "") {
            alert("Driver Must Be Selected. ");
          } else if (message == "") {
            alert("Message Should not be blank. ");
          } else {
            var IDS = driverID,
              Message = message,
              hitURL = baseURL + "SendDriverMessage";
            jQuery.ajax({
              type: "POST",
              dataType: "json",
              url: hitURL,
              data: {
                'IDS': IDS,
                Message: Message
              }
            }).success(function(data) {
              $('#send_message #message').val("");
              if (data.status == true) {
                alert("Message has been sent successfully.");
                $("#send_message").modal("hide");
              } else {
                alert("Oooops, Please try again later");
              }

            });

          }
        })
        $(document).ready(function() {
          $("#replay_vehicle_activities .btn-primary").on("click", function() {
            var start_time = $('#replay_vehicle_activities #start_time').val();
            var end_time = $('#replay_vehicle_activities #end_time').val();
            var driverID = $('#replay_vehicle_activities #cur_driver_id').val();
            if (driverID == "") {
              alert("Driver Must Be Selected. ");
            } else if (start_time == "") {
              alert("Start Time Should not be blank. ");
            } else if (end_time == "") {
              alert("End Time Should not be blank. ");
            } else {
              var redirectURL = baseURL + "dashboard_replay_activity?start_time=" + start_time + "&end_time=" + end_time + "&driver_id=" + driverID;
              $("#replay_vehicle_activities").modal("hide");
              window.open(redirectURL, '_blank');
            }
          })
          $('#send_message').on('hidden.bs.modal', function() {
            $('#send_message #message').val("");
            $("input[name='driver_messages']:checked").prop("checked", false);
            //$('#send_message #cur_driver_id').val("");
            //$('#send_message .modal-title').html("Send Message");
          });
          $('#replay_vehicle_activities').on('hidden.bs.modal', function() {
            $('#replay_vehicle_activities #message').val("");
            $('#replay_vehicle_activities #cur_driver_id').val("");
            $('#replay_vehicle_activities .modal-title').html("Replay Vehicle Activity Criteria");
          });
          var rightSectionHeight = $(".content > .row > .col-lg-8").height();
          //$(".content > .row > .col-lg-4 > .box.box-info").css("min-height", rightSectionHeight + "px");

        })
		
		jQuery("#drivermine_checkall").on("change",function(){
			if(jQuery(this).prop("checked")){
				jQuery(this).parent().parent().find('.checkboxes').prop("checked",true);
			}else{
				jQuery(this).parent().parent().find('.checkboxes').prop("checked",false);
			}
		})
      });
  //##############################################  Show Booking Info in modal  ##############################################		
  jQuery(document).on("click", ".ShowLoads", function() {
    //$('#empModal').modal('show');  
    var BookingDateID = $(this).attr("data-BookingDateID"),
      hitURL1 = baseURL + "ShowLoadsAJAX",
      currentRow = $(this);
    //console.log(confirmation); 
    jQuery.ajax({
      type: "POST",
      dataType: "json",
      url: hitURL1,
      data: {
        'BookingDateID': BookingDateID
      }
    }).success(function(data) {
      //alert(data)
      $('#empModal .modal-body').html(data);
      $('#empModal .modal-title').html("Booking Loads / Lorry Information");
      $('#empModal .modal-dialog').width(1200);
      $('#empModal').modal('show');
    });

  });

  //##############################################  Show Pending allocate Booking Info in modal  ##############################################				

  jQuery(document).on("click", ".ShowLoads1", function() {
    //$('#empModal').modal('show');  
    var BookingDateID = $(this).attr("data-BookingDateID"),
      LoadType = $(this).attr("data-LoadType"),
      hitURL1 = baseURL + "ShowLoadsAJAX1",
      currentRow = $(this);
    //console.log(confirmation); 
    //alert(LoadType)
    jQuery.ajax({
      type: "POST",
      dataType: "json",
      url: hitURL1,
      data: {
        'BookingDateID': BookingDateID,
        'LoadType': LoadType
      }
    }).success(function(data) {
      //alert(data)
      $('#empModal .modal-body').html(data);
      $('#empModal .modal-title').html("Booking Loads / Lorry Information");
      $('#empModal .modal-dialog').width(600);
      $('#empModal').modal('show');
    });
	
	

  });
</script>