function bindInfoWindow(marker, map, infoWindow) {
    google.maps.event.addListener(marker, 'click', function() {
       
        var html = ""
        var markername = marker.get('name');
          
        switch (marker.get("checked")){

            case "0":
                html = "<h4>"+ markername + "</h4>" + "Brutstätte noch nicht vom Administrator überprüft!<br>";
                break;

            case "1":
                html = "<h4>"+ markername + "</h4>" + "Brutstätte bereits vom Administrator überprüft!<br>";
                break;

        }
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
    }

    );
}



function addBrutstaette(){
    window.location.href="/guest/addbrutstaette"
    + "/lat/" + map.getCenter().lat()
    + "/lon/" +  map.getCenter().lng();
}