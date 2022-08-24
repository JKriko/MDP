<?php
// Initialize the session
session_start();
$user_name = $_SESSION["user_name"] ;
$device_name = $_SESSION["device_name"];
$floor = $_SESSION["floor"];
$location = $_SESSION["location"];
$longitude = $_SESSION["longitude"];
$latitude = $_SESSION["latitude"];
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Map</title>

    <!-- leaflet css  -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="./data/point.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        #map {
            width: 100%;
            height: 100vh;
        }
        body{ font: 14px sans-serif; text-align: center; color: black; background-position: center; background-repeat: no-repeat; background-attachment: fixed; background-size: 1400px 800px; }
    </style>
</head>
<body>
    
    <div id="map">
        <div class="leaflet-control coordinate"></div>
    </div>
</body>
<footer>
<!-- //<form action="table.php" method="post"> -->
    <p><a href="table.php">Go to Table</a></p>
    
<!-- //</form> -->

</footer>

</html>

<!-- leaflet js  -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    // Map initialization 
    var map = L.map('map').setView([33.8547, 35.8623], 9.25); //Setting up Lebanon Coordinates.

    //osm layer
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    osm.addTo(map);

    // water color 
    var watercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
        attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        subdomains: 'abcd',
        minZoom: 1,
        maxZoom: 16,
        ext: 'jpg'
    });
   // watercolor.addTo(map);

   // dark map 
   var dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
    subdomains: 'abcd',
    maxZoom: 19
});
// dark.addTo(map)

 // google street 
 googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});
 //googleStreets.addTo(map);

  //google satellite
  googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});
 //googleSat.addTo(map)

 //Marker
 var myIcon = L.icon({
    iconUrl: 'img/red_marker.png',
    iconSize: [25, 25],
});
 var singleMarker = L.marker([33.8547, 35.8623], { icon: myIcon });
 var popup = singleMarker.bindPopup('This is the Lebanon. ' + singleMarker.getLatLng()).openPopup()
 popup.addTo(map);

 
 var secondMarker = L.marker([33.5, 35.5], { icon: myIcon});
 //secondMarker.addTo(map);

 //console.log(singleMarker.toGeoJSON())


 //LAYER CONTROL
 
 var baseMaps = {
     "OSM": osm,
     "Water color map": watercolor,
     'Dark': dark,
     'Google Street': googleStreets,
     "Google Satellite": googleSat,
 };
 var overlayMaps = {
    "First Marker": singleMarker,
    'Second Marker': secondMarker,
 };

 L.control.layers(baseMaps, overlayMaps).addTo(map);



  /*==============================================
                GEOJSON
    ================================================*/
    function createCustomIcon (feature, latlng) {
        let myIcon = L.icon({
          iconUrl: 'img/red_marker.png',
          iconSize:     [25, 25], // width and height of the image in pixels
        })
        return L.marker(latlng, { icon: myIcon })
      }
      
      // create an options object that specifies which function will called on each feature
      let myLayerOptions = {
        pointToLayer: createCustomIcon
      }

      // create the GeoJSON layer
     // var pointData = L.geoJSON(pointJson, myLayerOptions)
      //var popp = pointData.bindPopup('This is the Nepal. '+ singleMarker.getLatLng()).openPopup()
      //popp.addTo(map);

      var pointData = L.geoJSON(pointJson, {
        onEachFeature: function (feature, layer) {
          layer.bindPopup(feature.properties.party).openPopup();
        }
      }).addTo(map);

</script>




