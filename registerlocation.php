<?php

include 'register.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registerlocation
 *
 * @author RIF01
 */
    
    $head = '';
    $head .= '<script src="//maps.googleapis.com/maps/api/js?sensor=false&libraries=places"
      type="text/javascript"></script>

    <style type="text/css">
      body {
        font-family: sans-serif;
        font-size: 14px;
      }
      #map_canvas {
        height: 400px;
        width: 600px;
        margin-top: 0.6em;
      }
    </style>
    <script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: new google.maps.LatLng(54.4095, -4.6699),
          zoom: 5,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
          mapOptions);

        var input = document.getElementById("searchTextField");
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo("bounds", map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map
        });

        google.maps.event.addListener(autocomplete, "place_changed", function() {
          infowindow.close();
          var place = autocomplete.getPlace();
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }

          var image = new google.maps.MarkerImage(
              place.icon,
              new google.maps.Size(71, 71),
              new google.maps.Point(0, 0),
              new google.maps.Point(17, 34),
              new google.maps.Size(35, 35));
          marker.setIcon(image);
          marker.setPosition(place.geometry.location);

          var address = "";
          if (place.address_components) {
            address = [(place.address_components[0] &&
                        place.address_components[0].short_name || ""),
                       (place.address_components[1] &&
                        place.address_components[1].short_name || ""),
                       (place.address_components[2] &&
                        place.address_components[2].short_name || "")
                      ].join(" ");
          }

          infowindow.setContent("<div><strong>" + place.name + "</strong><br>" + address);
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          google.maps.event.addDomListener(radioButton, "click", function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener("changetype-all", []);
        setupClickListener("changetype-establishment", ["establishment"]);
        setupClickListener("changetype-geocode", ["geocode"]);
      }
      google.maps.event.addDomListener(window, "load", initialize);
    </script>';
    
 $content = '';
 $content .= '
     <form method="POST" action="location.php">
      <input id="searchTextField" required="true" type="text" size="50" title="Enter a valid address from the drop down menu"  placeholder="Enter your location..." name="location">
        <button id="start" onclick="initialize()">This is my location!</button>   </form>         
    <div id="map_canvas"></div><br/>';

$l = new register($content, $head);

?>
