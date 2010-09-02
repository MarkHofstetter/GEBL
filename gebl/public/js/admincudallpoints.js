   function bindInfoWindow(marker, map, infoWindow) {
      google.maps.event.addListener(marker, 'click', function() {

          document.getElementById("pointname").innerHTML="Name: " + marker.get("name");
          var html = ""
          var markerid = marker.get('id');
          var markername = marker.get('name');
           
                 switch (marker.get("typ")){

                 case "1":
                 html = "<h4>"+ markername + "</h4>" + "Typ: Adresse <br>";
                 document.getElementById("info").innerHTML="";
                 html = html + "<input type='button' value='Löschen' onclick='deleteMarker("+ markerid +")'/>"
                 break;

                 case "2":
                 html = "<h4>"+ markername + "</h4>" + "Typ: Falle <br>";
                 document.getElementById("info").innerHTML="";
                 html = html + "<input type='button' value='Löschen' onclick='deleteMarker("+ markerid +")'/>"
                 break;

                 case "3":
                     
                     switch (marker.get("checked")){
                     case "1":
                       html = "<h4>"+ markername + "</h4>" + "Typ: Brutstätte <br>";
                       html = html + "<input type='button' value='Alle Daten zeigen' onclick='getbrutInfo("+ markerid +")'/> <br>";
                       html = html + "<input type='button' value='Aktionen' onclick='getBrutAktionen("+ markerid +")'/> <br>";
                       html = html + "<input type='button' value='Editieren' onclick='editBrut("+ markerid +")'/><br>"
                       html = html + "<input type='button' value='Löschen' onclick='deleteMarker("+ markerid +")'/><br>"
                       document.getElementById("info").innerHTML="";
                     break; 
                     
                     case "0":
                       html = "<h4>"+ markername + "</h4>" + "Typ: ungeprüfte Brutstätte <br>";
                       html = html + "<input type='button' value='Alle Daten zeigen' onclick='getbrutInfo("+ markerid +")'/><br>";
                       html = html + "<input type='button' value='Editieren' onclick='editBrut("+ markerid +")'/><br>"
                       html = html + "<input type='button' value='Status Geprüft setzen'  onclick='setBrutChecked("+ markerid +")'/><br>";
                       html = html + "<input type='button' value='Löschen' onclick='deleteMarker("+ markerid +")'/>"
                       document.getElementById("info").innerHTML="";
                     }
                
                 
                 default:
                 document.getElementById("info").innerHTML="";
                 //document.getElementById("infobutton").style.visibility = "hidden";
                 }
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
            }

        );
    }


    
  /*  function getBrutAktionen(g_id) {
        window.location.href="/admin/listonebrutstaetteaktionen"
    + "/g_id/" + g_id
    + "/lat/" + map.getCenter().lat()
    + "/lon/" +  map.getCenter().lng()
     + "/zoom/" + map.getZoom();
    }
  */

    function getBrutAktionen(g_id){
      document.getElementById("info").innerHTML="Lade Daten ....";

      downloadUrl("/admin/listonebrutstaetteaktionen/format/xml/g_id/" + g_id, function(data){

                      var xml = parseXml(data);
                      var aktionen = xml.documentElement.getElementsByTagName("aktion");
                      if (aktionen.length==0){
                        var aktionenhtml = "Für diesen Punkt wurden noch keine Aktionen gemeldet!<br>";
                        }
                      else{
                          var aktionenhtml = "<table id='aktionen'>"+
                                             "<th>Datum</th>"+
                                             "<th>Aktion</th>"+
                                             "<th>Kommentar</th>";
                          for (var i = 0; i < aktionen.length; i++) {
                            var a_datum = aktionen[i].getAttribute("a_datum");
                            var at_text = aktionen[i].getAttribute("at_text");
                            var a_text = aktionen[i].getAttribute("a_text");
                            if (a_text.length > 60){
                            a_text = "<span title=\"" +
                                     a_text + "\">" +
                                     a_text.substr(0,59) +
                                     "...<br> <em>Alles zeigen: Cursor über den Text bewegen!</em> " +
                                     "</span>";
                                     
                            }

                            aktionenhtml = aktionenhtml +
                             "<tr>" +
                             "<td>" + a_datum + "</td>" +
                             "<td>" + at_text + "</td>" +
                             "<td>" + a_text + "</td>";
                          }
                            aktionenhtml = aktionenhtml + "</table>";
                            
                       }
                      aktionenhtml = aktionenhtml +
                      "<input type='button' value='Neue Aktion eingeben' onclick='addAktion("
                      + g_id +")'/>";
                      document.getElementById("info").innerHTML = aktionenhtml;

                      });
    }


    function addAktion(g_id) {
    window.location.href="/admin/addaktion"
    + "/g_id/" + g_id
    + "/lat/" + map.getCenter().lat()
    + "/lon/" +  map.getCenter().lng()
     + "/zoom/" + map.getZoom();
    }

    function editBrut(g_id) {
        window.location.href="/admin/editbrutstaette"
    + "/g_id/" + g_id
    + "/lat/" + map.getCenter().lat()
    + "/lon/" +  map.getCenter().lng()
     + "/zoom/" + map.getZoom();
    }

    function setBrutChecked(g_id) {
        window.location.href="/admin/setbrutchecked"
    + "/g_id/" + g_id
    + "/lat/" + map.getCenter().lat()
    + "/lon/" +  map.getCenter().lng()
     + "/zoom/" + map.getZoom();
    }

     function deleteMarker(g_id) {
        window.location.href="/admin/deletepoint"
    + "/id/" + g_id
    + "/lat/" + map.getCenter().lat()
    + "/lon/" +  map.getCenter().lng()
     + "/zoom/" + map.getZoom();
    }

    function getbrutInfo(g_id){
      document.getElementById("info").innerHTML="Lade Daten ....";

      downloadUrl("/admin/listonebrutstaette/format/xml/g_id/" + g_id, function(data){

                      var xml = parseXml(data);
                      var brut = xml.documentElement.getElementsByTagName("brutstaette");
                      var b_id = brut[0].getAttribute("b_id");
                      var b_nr = brut[0].getAttribute("b_nr");
                      var b_groesse = brut[0].getAttribute("b_groesse");
                      var b_gewaesser_art = brut[0].getAttribute("b_gewaesser_art");
                      var b_zugang = brut[0].getAttribute("b_zugang");
                      var b_p_id = brut[0].getAttribute("b_p_id");
                      var b_g_id = brut[0].getAttribute("b_g_id");
                      var b_bek_art = brut[0].getAttribute("b_bek_art");
                      var b_text = brut[0].getAttribute("b_text");
                      var b_kontaktdaten = brut[0].getAttribute("b_kontaktdaten");
                      var aktionen = xml.documentElement.getElementsByTagName("aktion");
                      var infohtml ="<h4>Daten zu dieser Brutstätte:</h4>" +
                                   "b_id = " + b_id + "<br>" +
                                   "b_nr = " + b_nr + "<br>" +
                                   "b_groesse = " + b_groesse + "<br>" +
                                   "b_gewaesser_art = " + b_gewaesser_art + "<br>" +
                                   "b_zugang = " + b_zugang + "<br>" +
                                   "b_p_id = " + b_p_id + "<br>" +
                                   "b_g_id = " + b_g_id + "<br>" +
                                   "b_bek_art = " + b_bek_art + "<br>" +
                                   "b_text = " + b_text + "<br>" +
                                   "b_kontaktdaten = " + b_kontaktdaten + "<br>";

                      var aktionenhtml = ""
                      for (var i = 0; i < aktionen.length; i++) {
                        aktionenhtml = aktionenhtml +
                         "<h4>Aktion " + i + "</h4>" +
                         "a_id =" + aktionen[i].getAttribute("a_id") + "<br>" +
                         "a_nr =" + aktionen[i].getAttribute("a_nr") + "<br>" +
                         "a_typ =" + aktionen[i].getAttribute("a_typ") + "<br>" +
                         "a_betreff =" + aktionen[i].getAttribute("a_betreff") + "<br>" +
                         "a_datum =" + aktionen[i].getAttribute("a_datum") + "<br>" +
                         "a_p_id =" + aktionen[i].getAttribute("a_p_id") + "<br>" +
                         "a_b_id =" + aktionen[i].getAttribute("a_b_id") + "<br>" +
                         "a_f_id =" + aktionen[i].getAttribute("a_f_id") + "<br>" +
                         "a_text =" + aktionen[i].getAttribute("a_text") + "<br>";


                      }
                      document.getElementById("info").innerHTML = infohtml + aktionenhtml;

                      });
    }


    function getadresseInfo(g_id){

    }

    function getfalleInfo(g_id){

    }

    function addBrutstaette(){
    window.location.href="/admin/addbrutstaette"
                            + "/lat/" + map.getCenter().lat()
                            + "/lon/" +  map.getCenter().lng()
                            + "/zoom/" + map.getZoom();
    }


