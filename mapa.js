<script type="text/javascript">
  function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 17,
    center: {lat: -23.5254833, lng: -46.651721}
  });
  
var geocoder = new google.maps.Geocoder();
var infowindow = new google.maps.InfoWindow;

geocodeAddress(geocoder, map, infowindow);
  
}

function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

function geocodeAddress(geocoder, resultsMap, infowindow) {
	
  var address = " Av. Rudge, 315";
  
  geocoder.geocode({'address': address}, function(results, status) {
	  
	console.log(results[0]);
	
    if (status === google.maps.GeocoderStatus.OK) {
		
      resultsMap.setCenter(results[0].geometry.location);
	  
      var marker = new google.maps.Marker({
        map: resultsMap,
        position: results[0].geometry.location,
		title: results[0].formatted_address,
    	animation: google.maps.Animation.DROP
      });
	  
	  marker.addListener('click', toggleBounce);
	  
	  infowindow.setContent(results[0].formatted_address);
      infowindow.open(resultsMap, marker);
	  
    } else {
		
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
  
}

</script>