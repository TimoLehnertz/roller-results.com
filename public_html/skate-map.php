<?php
include_once "header.php";
include_once "api/index.php";
echoRandWallpaper();

?>
<main class="main competition-page">
    <div class="top-site">
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" preserveAspectRatio="none" viewBox="0 0 1680 40" class="curvature" style="bottom: -1px;"><path d="M0 40h1680V30S1340 0 840 0 0 30 0 30z" fill="#ddd"></path></svg>
    <div class="light section no-shadow">
        <h1 class="headline">Inline Speedskate track map - <span class="font color orange">Beta</span></h1>
        <div class="flex">
            <div id="map" style="width: 500px; height: 400px;"></div>
            <!-- <iframe
            id="map"
                width="1000"
                height="500"
                style="border:0"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAZriMrsCFOsEEAKcRLxdtI6V8b9Fbfd-c&q=Space+Needle,Seattle+WA"></iframe> -->
        </div>
    </div>
</main>
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.11&sensor=false" type="text/javascript"></script> -->
<!-- <script src="http://maps.google.com/maps/api/js?key=AIzaSyAZriMrsCFOsEEAKcRLxdtI6V8b9Fbfd-c" type="text/javascript"></script> -->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyBaiCV41PXiWeysrwCHbN-lRT8hYTAX6p4" type="text/javascript"></script>
<script>
    var locations = [
      ['Bondi Beach', -33.890542, 151.274856, 4],
      ['Coogee Beach', -33.923036, 151.259052, 5],
      ['Cronulla Beach', -34.028249, 151.157507, 3],
      ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
      ['Maroubra Beach', -33.950198, 151.259302, 1]
    ];
    
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    
    var infowindow = new google.maps.InfoWindow();

    var marker, i;
    
    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });
      
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
</script>
<?php
    include_once "footer.php";
?>