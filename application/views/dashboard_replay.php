<link href="https://www.malot.fr/bootstrap-datetimepicker/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="https://www.malot.fr/bootstrap-datetimepicker/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer" aria-hidden="true"></i> Live Tracking Dashboard - Replay Activity For <?php echo $current_driver['DriverName']; ?><br>
      <small>View Driver`s Replay Activity from <?php echo date("d/m/Y H:i", strtotime($_GET['start_time'])); ?> to <?php echo date("d/m/Y H:i", strtotime($_GET['end_time'])); ?></small>


      <div class="back_link" style="position: absolute;right: 20px;top: 35px;">
        <a href="<?php echo base_url ('dashboard_new'); ?>" style="font-size: 16px; color:#000000; text-decoration: underline; font-weight: bold;">< Back</a>
      </div>





    </h1>
  </section>

  <section class="content">

    <div class="row">
      <div class="<?php if (count($live_tracking_data) > 0) { ?>col-lg-4<?php } ?> col-xs-12">

        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Replay Activity</h3>
          </div>



          <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin driver_table">
                <?php if (count($live_tracking_data) > 0) { ?>

                  <thead>
                    <tr>
                      <!-- <th>Type</th> -->
                      <th>Time</th>
                      <th>Load ID</th>
                      <th>ETA</th>
                      <th>Speed</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($live_tracking_data as $k => $row) { ?>
                      <td><?php echo date("d/m/Y H:i",strtotime($row['created_at'])); ?></td>
                      <td><?php echo $row['load_id'] ?></td>
                      <td><?php echo $row['eta'] ?></td>
                      <td><?php echo $row['current_speed'] . ' Miles/Hr' ?></td>
                      </tr>
                    <?php }
                    ?>
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
      <?php if (count($live_tracking_data) > 0) { ?>
        <div class="col-lg-8 col-xs-12">
          <div id="map" style="width: 100%; height: 750px;"></div>

        </div>
      <?php } ?>
    </div>






  </section>
</div>

<input type="hidden" name="origin" id="origin" value="" />
<input type="hidden" name="destination" id="destination" value="" />
<input type="hidden" name="current_location" id="current_location" value="" />


<?php if (count($live_tracking_data) > 0) { ?>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_TOSZMAbYq4BCJDVMds7BVirU9FqrJYI&callback=initMap" type="text/javascript"></script>

  <?php 
  
  if (isset($live_tracking_data) && count($live_tracking_data) > 0) { ?>
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
		  $n = floor(count($liveData) / 3);
			$liveData = array_chunk($liveData, $n ?: 1);
		  foreach ($liveData as $tracing) { 
        ?>
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
            //avoidTolls: true,
            waypoints: waypts,
            optimizeWaypoints: true
          }, function(response, status) {
            if (status === 'OK') {
              directionsDisplay.setMap(map);
              directionsDisplay.setDirections(response);
            } else {
              directionsDisplay.setMap(map);
              //directionsDisplay.setDirections(null);
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
                  markers.push(marker);
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
        /* geocodeLatLng(geocoder, map, "", <?php echo end($live_tracking_data)['latitude'] ?>, <?php echo end($live_tracking_data)['longitude'] ?>, "origin");
        geocodeLatLng(geocoder, map, "", <?php echo $live_tracking_data[0]['latitude'] ?>, <?php echo $live_tracking_data[0]['longitude'] ?>, "destination"); */


        setCurrentPosition(geocoder, map,<?php echo end($live_tracking_data)['latitude'] ?>, <?php echo end($live_tracking_data)['longitude'] ?>,'A');
        setCurrentPosition(geocoder, map, <?php echo $live_tracking_data[0]['latitude'] ?>, <?php echo $live_tracking_data[0]['longitude'] ?>,'B');


        //geocodeLatLng(geocoder, map, "", 51.5229, 0.1308, "destination");
        //setCurrentPosition(geocoder, map, <?php echo $live_tracking_data[0]['latitude'] ?>, <?php echo $live_tracking_data[0]['longitude'] ?>);
        setTimeout(function() {
          var origin = $("#origin").val();
          var destination = $("#destination").val();
          var travel_mode = "DRIVING";
          var directionsDisplay = new google.maps.DirectionsRenderer({
            'draggable': false
          });

          //var directionsService = new google.maps.DirectionsService();
          //displayRoute(travel_mode, origin, destination, directionsService, directionsDisplay);

        }, 1000);

        
        setInterval(function(){
          //$('#empModal').modal('show');  
          hitURL1 = baseURL + "dashboard_replay_activity?start_time=<?php echo $_GET['start_time'] ?>&end_time=<?php echo $_GET['end_time'] ?>&driver_id=<?php echo $_GET['driver_id'] ?>&is_ajax=1",
        jQuery.ajax({
          type: "GET",
          dataType: "json",
          url: hitURL1,
        }).success(function(data) {
          if(data == "no_results"){
            return;
          }
          var latitude = data.latitude;
          var longitude = data.longitude;
          deleteMarkers();
          console.log(latitude);
          console.log(longitude);

          setCurrentPosition(geocoder, map,<?php echo end($live_tracking_data)['latitude'] ?>, <?php echo end($live_tracking_data)['longitude'] ?>,'A');
          setCurrentPosition(geocoder, map, parseFloat(latitude), parseFloat(longitude),'B');



        });
        },10000);
      });
    </script>
  <?php } else { ?>





    
  <?php } ?>
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