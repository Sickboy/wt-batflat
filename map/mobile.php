<html><head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
	<link rel="stylesheet" href="./leaflet/compass.css" />
	<script src="leaflet/leaflet.js"></script>
	
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

	<script src="./leaflet/leaflet.js"></script>
	<script src="./leaflet/control-button-left.js"></script>
	<script src="./leaflet/leaflet-compass.js"></script>
	
	<link rel="stylesheet" href="./leaflet/leaflet-routing-machine.css" />
	<script src="./leaflet/leaflet-routing-machine.js"></script>

<style>
	body {
    padding: 0;
    margin: 0;
}
html, body, #map {
    height: 100%;
}
.fa-fa {
	margin-top: 9px;
	}
layer-list{
font-size: 150%;
}

</style>

	<script src="./maps/141.json"></script>
	<script src="./maps/143.json"></script>
	
</head>
<body>

<?php

	include('config.php');
	include('decTOdms.php');

?>

<div id="map"></div>
<script>

var mbAttr = 'Koło Łowieckie "Wieniec" w Toruniu',
			mbOSM = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
			//mbUrl = 'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
			mbTOPO = 'http://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png';

	    var osm   = L.tileLayer(mbOSM, {maxZoom: 20, attribution: mbAttr});
	    var topo   = L.tileLayer(mbTOPO, {maxZoom: 20, attribution: mbAttr});
		
		var wms_geoportal_raster = L.tileLayer.wms("http://mapy.geoportal.gov.pl/wss/service/img/guest/ORTO/MapServer/WMSServer", {
			layers: 'Raster', //wms_geoportal_raster
			format: 'image/jpeg',
			transparent: true,
			attribution: mbAttr
		});
		
		var wms_geoportal_nazwy = L.tileLayer.wms("http://mapy.geoportal.gov.pl:80/wss/service/pub/guest/G2_PRNG_WMS/MapServer/WMSServer", {
			layers: 'Wies,PozostaleMiejscowosci,PozostaleObiektyFizjograficzne', //wms_geoportal_raster
			format: 'image/gif',
			transparent: true,
			attribution: mbAttr
		});
		
		var sat = L.layerGroup([wms_geoportal_raster, wms_geoportal_nazwy]);
		
		var odo = L.tileLayer.wms("http://mapserver.bdl.lasy.gov.pl/ArcGIS/services/WMS_BDL/mapserver/WMSServer", {
			layers: '4', //wms_geoportal_raster
			format: 'image/gif',
			transparent: true,
			attribution: ""
		});
		
var map = L.map('map', {
			center: {lon: 18.520358, lat: 53.082454},
			zoom: 13,
			layers: [osm]
		});
		
		L.control.scale().addTo(map);
		
		var lock = 1;	//odpowiada za GPS - 0 = wyłaczony, 1 = właczony
	
//map.locate({setView: true, maxZoom: 16});

		var style141 = {
			"clickable": false,
			"color": "blue",
			"fillColor": "#00D",
			"weight": 2,
			"opacity": 1,
			"fillOpacity": 1
			};	
			
		var style143 = {
			"clickable": false,
			"color": "red",
			"fillColor": "#00D",
			"weight": 2,
			"opacity": 1,
			"fillOpacity": 1
			};
			
		var lp = L.icon({
			iconUrl: './img/ico/lplogo.png',
			iconSize: [30, 30]
		});
			
		var pzl = L.icon({
			iconUrl: './img/ico/deer.png',
			iconSize: [30, 30]
		});
			
		var amb = L.icon({
			iconUrl: './img/ico/ambona_ico.png',
			iconSize: [30, 30]
		});
		
		var zw = L.icon({
			iconUrl: './img/ico/zw.png',
			iconSize: [20, 20] 
		});
		
		var pas = L.icon({
			iconUrl: './img/ico/pas.png',
			iconSize: [30, 30] 
		});
		
		var pol = L.icon({
			iconUrl: './img/ico/pol.png',
			iconSize: [30, 30] 
		});
		
		var paz = L.icon({
			iconUrl: './img/ico/paz.png',
			iconSize: [30, 30] 
		});
		
		var ico = L.icon({
			iconUrl: './img/ico/person.png',
			iconSize: [45, 45] 
		});
		
		var im = L.marker([0,0],{icon: ico}).addTo(map);
		
		
		
		function onLocationFound(e) {
			lat = e.latlng.lat;
			lon = e.latlng.lng;
			latlng = e.latlng;
			im.setLatLng(latlng);
			//im.redraw();
			
		}
		function onLocationError() {
			alert('Nie można określić lokalizacji\nGeolokalizacja wyłączona'); 
			lock = 0;
		}
		
		map.on('locationerror', onLocationError);
		map.on('locationfound', onLocationFound);
		
		map.locate({watch: true, setView: true, maxZoom: 16, enableHighAccuracy: true, maximumAge: 10000});
		
		
		
		L.easyButton('fa-home fa-fa', 
              function (){
						map.setView({lon: 18.520358, lat: 53.082454}, 13);
						//map.setZoom(13);

			  }
			  
			  ,
             ''
            )
			
		L.easyButton('fa-link fa-fa', 
              function (){
						window.location.href = "http://wieniectorun.pl/";

			  }
			  
			  ,
             ''
            )
			
		L.easyButton('fa-power-off fa-fa', 
              function (){
						if(lock == 1){
					    map.stopLocate();alert('Geolokalizacja wyłączona');
						lock = 0;
						hist = ''+hist+'<br>-------- GPS OFF --------';}
						else{
						map.locate({watch: true, setView: true, maxZoom: 16, enableHighAccuracy: true, maximumAge: 10000});
						alert('Geookalizacja włączona');
						lock = 1;
						hist = ''+hist+'<br>-------- GPS ON --------';}

			  }
			  
			  ,
             ''
            )

var obo143 = L.geoJson(obwod143, {style: style143}).addTo(map);
var obo141 = L.geoJson(obwod141, {style: style141}).addTo(map);
		
var LGamb = L.layerGroup();
var LGzw = L.layerGroup();
var LGlp = L.layerGroup();


			var mar_amb;
			var a = 0;
			</script>
			
<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			
			$wynik = mysql_query("SELECT * FROM map_lp"); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
					
?>

		<script>
		
			L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?> <?echo dec_lng($r['lon'])?>').addTo(map);
			
		</script>
		
<?php
				
			} 
		}
?>
<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			
			$wynik = mysql_query("SELECT * FROM map_amb"); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
					
?>

		<script>
		
			mar_amb = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?> <?echo dec_lng($r['lon'])?>');
			//L.marker({lon: 18.520342, lat: 53.082529}, {icon: lplogo}).bindPopup("<h4><center>Leśniczówka Olek</center></h4><p><a href='http://www.wieniectorun.pl/maps/img/picture/olek.jpeg' ><img src=http://www.wieniectorun.pl/maps/img/picture/olek.jpeg height='51' width='71' align='right'/></a>Siedziba Koła Łowieckieo Wieniec<br>Olek 1<br>87-148 Łysomice").addTo(map);
			LGamb.addLayer(mar_amb);
			a = a+1;
		</script>
		
<?php
				
			} 
		}
?>
<script>
			var mar_zw;
			var a = 0;
			</script>
<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			
			$wynik = mysql_query("SELECT * FROM map_zw"); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
					
?>

		<script>
		
			mar_zw = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?> <?echo dec_lng($r['lon'])?>');
			//L.marker({lon: 18.520342, lat: 53.082529}, {icon: lplogo}).bindPopup("<h4><center>Leśniczówka Olek</center></h4><p><a href='http://www.wieniectorun.pl/maps/img/picture/olek.jpeg' ><img src=http://www.wieniectorun.pl/maps/img/picture/olek.jpeg height='51' width='71' align='right'/></a>Siedziba Koła Łowieckieo Wieniec<br>Olek 1<br>87-148 Łysomice").addTo(map);
			LGzw.addLayer(mar_zw);
			a = a+1;
		</script>
		
<?php
				
			} 
		}
?>
<script>
			var mar_lp;
			var a = 0;
			</script>
<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			
			$wynik = mysql_query("(SELECT * FROM map_pas) UNION (SELECT * FROM map_paz) UNION (SELECT * FROM map_pol)"); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
					
?>

		<script>
		
			mar_lp = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?> <?echo dec_lng($r['lon'])?>');
			//L.marker({lon: 18.520342, lat: 53.082529}, {icon: lplogo}).bindPopup("<h4><center>Leśniczówka Olek</center></h4><p><a href='http://www.wieniectorun.pl/maps/img/picture/olek.jpeg' ><img src=http://www.wieniectorun.pl/maps/img/picture/olek.jpeg height='51' width='71' align='right'/></a>Siedziba Koła Łowieckieo Wieniec<br>Olek 1<br>87-148 Łysomice").addTo(map);
			LGlp.addLayer(mar_lp);
			a = a+1;
		</script>
		
<?php
				
			} 
		}
?>
<script>
LGamb.addTo(map);
LGzw.addTo(map);

var baseMaps = {
    "<b><span style='font-size: 130%;'>OSM": osm,
    "<b><span style='font-size: 130%;'>TOPO": topo,
	"<b><span style='font-size: 130%;'>SAT": sat
};
var overlayMaps = {
	"<b><span style='font-size: 130%;'>Oddziały": odo,
    "<b><span style='font-size: 130%;'>Ambony": LGamb,
    "<b><span style='font-size: 130%;'>Zwyżki": LGzw,
    "<b><span style='font-size: 130%;'>Pozostałe</span>": LGlp,
	};

L.control.layers(baseMaps, overlayMaps).addTo(map);

		map.addControl( new L.Control.Compass() );//inizialize control

</script>	

</body>
</html>