var t;
var g;
var m;

var ico = L.icon({
			iconUrl: '../img/ico/point_amb.png',
			iconSize: [30, 30] 
		});

L.Control.SimpleMarkers = L.Control.extend({
    options: {
        position: 'topleft'
    },
    
    onAdd: function () {
        var marker_container = L.DomUtil.create('div', 'marker_controls');
        var add_marker_div = L.DomUtil.create('div', 'add_marker_control', marker_container);
        //var del_marker_div = L.DomUtil.create('div', 'del_marker_control', marker_container);
        add_marker_div.title = 'Dodaj punkt na mapie';
        //del_marker_div.title = 'Delete a marker';
        
        L.DomEvent.addListener(add_marker_div, 'click', L.DomEvent.stopPropagation)
            .addListener(add_marker_div, 'click', L.DomEvent.preventDefault)
            .addListener(add_marker_div, 'click', (function () { this.enterAddMarkerMode() }).bind(this));
        
       // L.DomEvent.addListener(del_marker_div, 'click', L.DomEvent.stopPropagation)
       //     .addListener(del_marker_div, 'click', L.DomEvent.preventDefault)
       //     .addListener(del_marker_div, 'click', (function () { this.enterDelMarkerMode() }).bind(this));
        
        return marker_container;
    },
    
    enterAddMarkerMode: function () {
	if (document.getElementById('odd').checked) {
            map.removeLayer(odo);
        }
	if (document.getElementById('143').checked) {
            map.removeLayer(obo143_sektory);
        }
	if (document.getElementById('141').checked) {
            map.removeLayer(obo141_sektory);
        }
        if (markerList !== '') {
            for (var marker = 0; marker < markerList.length; marker++) {
                if (typeof(markerList[marker]) !== 'undefined') {
                    markerList[marker].removeEventListener('click', this.onMarkerClickDelete);
                } 
            }
        }
        document.getElementById('map').style.cursor = 'crosshair';
        map.addEventListener('click', this.onMapClickAddMarker);
    },
    
    enterDelMarkerMode: function () {
        for (var marker = 0; marker < markerList.length; marker++) {
            if (typeof(markerList[marker]) !== 'undefined') {
                markerList[marker].addEventListener('click', this.onMarkerClickDelete);
            }
        }
    },
    
    onMapClickAddMarker: function (e) {
        map.removeEventListener('click'); 
        document.getElementById('map').style.cursor = 'auto';
        
		t = e.latlng.lat;
		g = e.latlng.lng;
		
		var marker = new L.marker(e.latlng, {icon: ico});
		
		m = marker;
        		
        var popupContent =  "<input type='text' id='tresc' name='tresc' size='15' /> <button onclick=\"zapiszPoz(t,g,m)\"><b>+</b></button><br>"+e.latlng.toString();
        var the_popup = L.popup({maxWidth: 170, closeButton: true, closeOnClick: true});
        the_popup.setContent(popupContent);
         
		marker.addTo(map);
        marker.bindPopup(the_popup).openPopup();
        markerList.push(marker);
		
		if (document.getElementById('odd').checked) {
            map.addLayer(odo);
        }
		if (document.getElementById('143').checked) {
            map.addLayer(obo143_sektory);
        }
		if (document.getElementById('141').checked) {
            map.addLayer(obo141_sektory);
        }		
		
		
        
        return false;    
    },

    onMarkerClickDelete: function (e) {
        map.removeLayer(this);
        var marker_index = markerList.indexOf(this);
        delete markerList[marker_index];
        
        for (var marker = 0; marker < markerList.length; marker++) {
            if (typeof(markerList[marker]) !== 'undefined') {
                markerList[marker].removeEventListener('click', arguments.callee);
            } 
        }
        return false;  
    }
	
	
}

);
function zapiszPoz(t,g){
var tresc = document.getElementById('tresc').value;
var data = new Date();
		var miesiac = data.getMonth() + 1;
       var nazwa = data.getDate() +''+ miesiac +''+ data.getFullYear() +''+ data.getHours() +''+ data.getMinutes() +''+ data.getSeconds();
tresc = 'mapa' + '#' + tresc + '#' + t + '#' + g;
tresc = escape(tresc);
//document.cookie = nazwa+'='+tresc; 
document.cookie = nazwa+'='+tresc+'; expires=Fri, 31 Dec 9999 23:59:59 GMT';
console.log("Dodano ciastko jako punkt");

$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Dodano punkt na mapie<br>Zmiany zostaną uwzględnione po ponownym uruchomieniu mapy"
					});
					
m.closePopup();


//alert(tresc);
}


var markerList = [];