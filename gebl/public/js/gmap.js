
 function initialize() {

    if (lat == 0 && lon == 0){
    lat = 48.20833;
    lon = 16.373064;
    }
    var myLatlng = new google.maps.LatLng(lat, lon);
    var myOptions = {
      zoom: 12,
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.HYBRID
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    geocoder = new google.maps.Geocoder();
    //draw points from xml
     var infoWindow = new google.maps.InfoWindow;
    // Change this depending on the name of your PHP file
      downloadUrl(urlmarkers, function(data) {
     var xml = parseXml(data);
     var markers = xml.documentElement.getElementsByTagName("marker");
     for (var i = 0; i < markers.length; i++) {
        var id = markers[i].getAttribute("id");
        var name = markers[i].getAttribute("name");
        var typ = markers[i].getAttribute("typ");
        var checked = markers[i].getAttribute("checked");
        var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lon")));
        var icon = customIcons[checked] || {};
        var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon,
            shadow: icon.shadow
            });
          marker.set("name",name);
          marker.set("typ",typ);
          marker.set("id",id);
          marker.set ("checked", checked);
          bindInfoWindow(marker, map, infoWindow);
        }
      });

  }

   function codeAddress() {
    var address = document.getElementById("address").value;
    geocoder.geocode( { 'address': address,'region': 'at'}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);

      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }

  function placeMarker(location) {
  var clickedLocation = new google.maps.LatLng(location);
  var marker = new google.maps.Marker({
      position: location,
      map: map
  });

   document.getElementById("position").innerHTML="Position clicked " + location.lat()
        + " " + location.lng();
  //map.setCenter(location);
}



    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

    function doNothing() {}



 function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
  }



  