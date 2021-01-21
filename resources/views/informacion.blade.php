<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0BU9xbauWZcWtnD-eAQaFKU9vYJQ8Mn8&callback=initMap&libraries=&v=weekly"
      defer
    ></script>

    <style type="text/css">
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <script>
      let map;

      function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
          center: { lat: 20.174091, lng: -90.136502 },
          zoom: 8,
        });
      }

    </script>
  </head>
  <body>
    <div id="map"></div>
  </body>
</html>