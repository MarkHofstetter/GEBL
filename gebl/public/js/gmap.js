
function initialize() {

    if (lat == 0 && lon == 0){
    checkMapCookies(); //when map variables not set get them from cookies
    }
    var myLatlng = new google.maps.LatLng(lat, lon);
    var myOptions = {
        zoom: zoom,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.HYBRID
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    //marker for edit or add
    clickedmarker = new google.maps.Marker();
    clickedmarker.setIcon(clickedmarkericon);
    clickedmarker.setZIndex(1000000); //Marker not hidden behind other markers
    if (placemarkerok == true){
        var clickedInfoWindow = new google.maps.InfoWindow;
        clickedInfoWindow.setContent("Positionieren Sie den Marker durch Klicken oder Ziehen");
        clickedInfoWindow.open(map, clickedmarker);
    }
    if (markerid == 0) {// marker not to edit -> set marker in center of map
        placeMarker(myLatlng)
    }
    
  
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
            if (typ == "3") {
                var icon = customIconsBrut[checked] || {};
            }
            else{
                var icon = customIcons[typ] || {};
            }
            if(id == markerid){
                if (typ == "3") {
                    var icon = customIconsBrutAnimated[checked] || {};
                }
                else{
                    var icon = customIconsAnimated[typ] || {};
                }

                clickedmarkericon = icon.icon;
                placeMarker(point); //Marker to Edit!
            }
            else{
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
                if (isDefined ("showAktion")){
                    if (showAktion == id){
                    google.maps.event.trigger(marker, 'click');
                    //fire click event on marker
                    getAktionen(id);
                    //show Aktionen
                    }
                }
            }

        }
    });

    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng)
        }
    );

    if (document.getElementById("ZOOM")){
        document.getElementById("ZOOM").value = map.getZoom();
        google.maps.event.addListener(map, 'zoom_changed', function() {
            document.getElementById("ZOOM").value = map.getZoom()
            });
    }

    geocoder = new google.maps.Geocoder();

    if (placemarkerok == true){
        google.maps.event.addListener(clickedmarker, 'position_changed',
            function() {
                setLatLon(clickedmarker.getPosition());
            });
    }

    //write map lat,lon and zoom every 30 seconds into cookies
    window.setInterval("setMapCookies()",10000);

    

}

function codeAddress() {
    var address = document.getElementById("address").value;
    geocoder.geocode( {
        'address': address,
        'region': 'at'
    },
    function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (placemarkerok == true ){
                placeMarker(results[0].geometry.location);
                map.setCenter(results[0].geometry.location);
            }
            else{
                map.setCenter(results[0].geometry.location);
            }
           
        } else {
            alert("Adresse nicht gefunden! Google Maps Fehler: " + status);
        }
    });
}

function placeMarker(location) {
    if (placemarkerok == true){
        clickedmarker.setMap(map);
        clickedmarker.setPosition(location);
        clickedmarker.setDraggable(true);
        clickedmarker.setIcon(clickedmarkericon);
    //document.getElementById ("G_LAT").value = parseFloat(location.lat());
    //document.getElementById ("G_LON").value = parseFloat(location.lng());
    }
    else
    {
        map.setCenter(location);
        if (markerid > 0){
            var clickedInfoWindow = new google.maps.InfoWindow;
            clickedInfoWindow.setContent("Information zu diesem Marker!");
            clickedInfoWindow.open(map, clickedmarker);
            clickedmarker.setMap(map);
            clickedmarker.setPosition(location);
            clickedmarker.setIcon(clickedmarkericon);
            markerid = 0; //Do not move marker!
        }
    }
    if (document.getElementById("G_LAT") && document.getElementById ("G_LON")){
        document.getElementById ("G_LAT").value = parseFloat(location.lat());
        document.getElementById ("G_LON").value = parseFloat(location.lng());
    }
}

function setLatLon(location){
    document.getElementById ("G_LAT").value = parseFloat(location.lat());
    document.getElementById ("G_LON").value = parseFloat(location.lng());
}


function getCookie(c_name)
{
    if (document.cookie.length>0)
    {
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1)
        {
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}

function setCookie(c_name,value,expiredays)
{   /* example call:
          setCookie('username',username,365);
    */
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+
    ((expiredays==null) ? "" : ";expires="+exdate.toUTCString());
}

function deleteCookie (c_name)
{
  var cookie_date = new Date ( );  // current date & time
  cookie_date.setTime ( cookie_date.getTime() - 1 );
  document.cookie = c_name += "=; expires=" + cookie_date.toGMTString();
}


function setMapCookies (){
     setCookie ('latCookie',map.getCenter().lat(),365);
     setCookie ('lonCookie',map.getCenter().lng(),365);
     setCookie ('zoomCookie',map.getZoom(),365);
}

function checkMapCookies()
{
    lat=getCookie('latCookie');
    lon=getCookie('lonCookie');
    zoom= getCookie('zoomCookie');
    if (lat==null || lat=="" || lat=="0" )
    {
        lat = 48.01208;
    }
    if (lon==null || lon=="" || lon=="0")
    {
        lon = 16.722139;
    }
    if (zoom==null || zoom=="" || zoom=="0" || zoom=="NaN")
    {
        zoom = 14;
    }
    else{
        zoom= parseInt(zoom);
    }


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
    request.setRequestHeader("If-Modified-Since",
        "Sat, 1 Jan 2000 00:00:00 GMT");
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
    script.src =
    "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
    document.body.appendChild(script);
}


function isDefined(variable){
	return this[variable] === undefined ? false : true;
};

  