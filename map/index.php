<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Koło Łowieckie "Wieniec" w Toruniu - Mapa interaktywna</title>
	
	<link rel="stylesheet" href="leaflet/leaflet.css" />	
	
	<!--- <script type="text/javascript" language="javascript" src="../35gal/lytebox.js"></script>
	<link rel="stylesheet" href="../35gal/lytebox.css" type="text/css" media="screen" /> -->


	<script src="leaflet/leaflet.js"></script>
	<script src="leaflet/TileLayer.GeoJSON.js"></script>
	<script src="leaflet/Leaflet.TileLegend.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="leaflet/jQuery.print.js"></script>
	<script type="text/javascript" src="https://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
	<!--<script src="leaflet/legenda.js"></script>-->
	<script src="leaflet/leaflet.label.js"></script>
	<script src="leaflet/L.Control.Zoomslider.js"></script>
	<script src="leaflet/Control.FullScreen.js"></script>
	<script src="leaflet/leaflet.defaultextent.js"></script>
	<script src="leaflet/leaflet.easyPrint.js"></script>
	<script src="leaflet/Control.SimpleMarkers.js"></script>
	
	<script src="./maps/141.json"></script>
	<script src="./maps/141_sektory.json"></script>
	<script src="./maps/143.json"></script>
	<script src="./maps/143_sektory.json"></script>
	<script src="./maps/forest.json"></script>
	
	<link rel="stylesheet" href="./jspanel/jquery.jspanel.css" type="text/css" media="screen" />
		
	<style>
	
	    html, body, #map {
        margin: 0;
        padding: 0; 
        width: 100%;
        height: 100%;
		}
		#site {
		overflow: hidden;
		}
		.poi li > p, .poi li > div {
        display: inline-block;
        vertical-align: top;
		color: black;
		font-size: 1em;
		}
		.poi li {
        white-space: nowrap;
        overflow: hidden;
		color: black;
		}
		.poi li p {
        padding: 10px;
		color: black;
		}
		
	</style>
	
	<script type="text/javascript">
	//<![CDATA[
		$(window).load(function() { // makes sure the whole site is loaded
			
			setTimeout(doit, 3000) //wait ten seconds before continuing
			
		})
	//]]>
	function doit()
	{	
		$('#status').fadeOut(); // will first fade out the loading animation
		$('#preloader').delay(1).fadeOut('slow'); // will fade out the white DIV that covers the website.
		$('#site').delay(1).css({'overflow':'visible'});
	}
	</script>
</head>
<body>

	<script src="./jspanel/vendor/jquery-2.1.3.min.js"></script>
	<script src="./jspanel/vendor/jquery-ui-1.11.2.complete/jquery-ui-1.11.2.min.js"></script>
	<script src="./jspanel/vendor/jquery.ui.touch-punch.min.js"></script>
	<script src="./jspanel/vendor/mobile-detect.min.js"></script>
	<script src="./jspanel/jquery.jspanel.min.js"></script>

	<div id="preloader">
    <div id="status"><center>Trwa ładowanie mapy</div>
	</div>

	<div id="site">
	<div id="map" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" ></div>
		
<?php

	include('config.php');
	include('legenda.php');
	include('decTOdms.php');
	include('button.php');

?>
	
	<script>
	
	console.log("Interaktywna mapa obwodów");
	console.log("Koło Łowieckie 'Wieniec' w Toruniu");
	console.log("Created by Lukasz Pawlowski");
	console.log("pl90@wieniectorun.pl");
	console.log("---- <? echo date('l jS F Y h:i:s A'); ?> ----");
	

	
	// --- funkcje do wyswietlania warstw przy zaznaczeniu checkboxa
	
	function ob143_sektory(){
		if (document.getElementById('143_sektory').checked){
				  map.addLayer(obo143_sektory) ;
				  $.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Włączono 'Sektory w obwodzie 137'"
					});
				console.log("Włączono 'Sektory w obwodzie 137'");
		}else{
					map.removeLayer(obo143_sektory);
					$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Wyłączono 'Sektory w obwodzie 137'"
					});
					console.log("Wyłączono 'Sektory w obwodzie 137'");
		}
	}
	function ob143(){
		if (document.getElementById('143').checked){
				  map.addLayer(obo143) ;
				  $.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Włączono 'Obwód 137'"
					});
				  console.log("Włączono 'Obwód 137'");
		}else{
					map.removeLayer(obo143);
					$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Wyłączono 'Obwód 137'"
					});
					console.log("Wyłączono 'Obwód 137'");
		}
	}
	function ob141_sektory(){
		if (document.getElementById('141_sektory').checked){
				  map.addLayer(obo141_sektory) ;
				  $.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Włączono 'Sektory w obwodzie 135'"
					});
				console.log("Włączono 'Sektory w obwodzie 135'");
		}else{
					map.removeLayer(obo141_sektory);
					$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Wyłączono 'Sektory w obwodzie 135'"
					});
				console.log("Wyłączono 'Sektory w obwodzie 135'");
		}
	}
	function ob141(){
		if (document.getElementById('141').checked){
				  map.addLayer(obo141) ;
				  $.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Włączono 'Obwód 135'"
					});
				  console.log("Włączono 'Obwód 135'");
		}else{
					map.removeLayer(obo141);
					$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Wyłączono 'Obwód 135'"
					});
					console.log("Wyłączono 'Obwód 135'");
		}
	}
	function odd(){
		if (document.getElementById('odd').checked){
				  map.addLayer(odo) ;
				  $.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Włączono 'Oddziały'"
					});
					console.log("Włączono 'Oddziały'");
		}else{
					map.removeLayer(odo);
					$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Wyłączono 'Oddziały'"
					});
					console.log("Wyłączono 'Oddziały'");
		}
	}
	
	// --- funkcja zmieniająca typ mapy po zmianie SELECT'a
	
	function changeMap() {
		var x = document.getElementById("selectMap").value;
		if(x == 'OSM'){
				$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Wybrano typ mapy: OSM"
					});
					console.log("Wybrano typ mapy: OSM");
			map.removeLayer(topo);
			map.removeLayer(sat);
			map.addLayer(osm);
			if (document.getElementById('odd').checked){
				  odo.bringToFront() ;}}
		if(x == 'TOPO'){
				$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Wybrano typ mapy: TOPO"
					});
					console.log("Wybrano typ mapy: TOPO");
			map.removeLayer(osm);
			map.removeLayer(sat);
			map.addLayer(topo);
			if (document.getElementById('odd').checked){
				  odo.bringToFront() ;}}
		if(x == 'SAT'){
				$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Wybrano typ mapy: SAT"
					});
					console.log("Wybrano typ mapy: SAT");
			map.removeLayer(osm);
			map.removeLayer(topo);
			map.addLayer(sat);
			if (document.getElementById('odd').checked){
				odo.bringToFront() ;}}
	}
	
	// --- funkcja wyswietlajaca popup przy kliknieciu na polygon
	
	function onEachFeature(feature, layer) {
    if (feature.properties && feature.properties.name) {
        //layer.bindPopup(feature.properties.name);		- zwykły popup
		layer.bindLabel(feature.properties.name, { 
			noHide: true, 
			className: 'leaflet-label'
			});
    }
	}
	
	function onEachFeatureOdd(feature, layer) {
    if (feature.properties && feature.properties.ref) {
        layer.bindLabel('Oddział ' + feature.properties.ref, { noHide: true, className: 'leaflet-label' });
    }
	}

		// --- tworzenie mapy
	
		var mbAttr = 'Koło Łowieckie "Wieniec" w Toruniu',
			mbOSM = 'http:s//{s}.tile.osm.org/{z}/{x}/{y}.png';
			//mbUrl = 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
			mbTOPO = 'https://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png';

	    var osm   = L.tileLayer(mbOSM, {maxZoom: 20, legend: legend, openLegendOnLoad: true});
	    var topo   = L.tileLayer(mbTOPO, {maxZoom: 20, legend: legend, openLegendOnLoad: true});
		
		/*var sat = L.tileLayer('http://{s}.{base}.maps.cit.api.here.com/maptile/2.1/maptile/{mapID}/hybrid.day/{z}/{x}/{y}/256/png8?app_id={app_id}&app_code={app_code}', {
			attribution: 'Map &copy; 1987-2014 <a href="http://developer.here.com">HERE</a>',
			subdomains: '1234',
			mapID: 'newest',
			app_id: 'GZn0QiyfNlRs7uPJzbxg',
			app_code: 'WcmIDmsbYorH3nf23GBy8g',
			base: 'aerial',
			minZoom: 2,
			maxZoom: 20,
			legend: legend, openLegendOnLoad: true
		});*/
		
		var wms_geoportal_raster = L.tileLayer.wms("https://mapy.geoportal.gov.pl/wss/service/img/guest/ORTO/MapServer/WMSServer", {
			layers: 'Raster', //wms_geoportal_raster
			format: 'image/jpeg',
			transparent: true,
			attribution: mbAttr
		});
		
		var wms_geoportal_nazwy = L.tileLayer.wms("https://mapy.geoportal.gov.pl:80/wss/service/pub/guest/G2_PRNG_WMS/MapServer/WMSServer", {
			layers: 'Wies,PozostaleMiejscowosci,PozostaleObiektyFizjograficzne', //wms_geoportal_raster
			format: 'image/gif',
			transparent: true,
			attribution: mbAttr
		});
		
		var sat = L.layerGroup([wms_geoportal_raster, wms_geoportal_nazwy]);
					
		var map = L.map('map', {
			center: {lon: 18.566444, lat: 53.078665},
			zoom: 13,
			attributionControl: false,
			//zoomsliderControl: true,
			//zoomControl: false,
			layers: [osm], 
			defaultExtentControl: true,
			fullscreenControl: true,
		    fullscreenControlOptions: {
			position: 'topleft',
			forceSeparateButton: true
			}
		});
		
		var legendControl = (new L.Control.TileLegend()).addTo(map);
		//L.control.navbar().addTo(map);
		
		L.easyPrint({title: "Drukuj"}).addTo(map);
		L.ico().addTo(map);
		L.refresh().addTo(map);
		L.help().addTo(map);
		L.info().addTo(map);
		
		var marker_controls = new L.Control.SimpleMarkers();
		map.addControl(marker_controls);
		
		// --- ikony
		
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
		
		/*var amb = L.divIcon({		--- zastosowanie CSS ?
			className: 'leaflet-div-icon-amb',
			iconSize: [30, 30]
		});*/
		
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
		
		var usr = L.icon({
			iconUrl: './img/ico/point_amb.png',
			iconSize: [30, 30] 
		});
		
		// --- style polyline
				
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
			
		var styleSektory = {
			"color": "yellow",
			"fillColor": "yellow",
			"weight": 2,
			"opacity": 1,
			"fillOpacity": 0.1
			};
			
		var styleOddzialy = {
			"color": "green",
			"weight": 1,
			};	
	
		// --- tworzenie warstw
	
		var obo143_sektory = L.geoJson(sektory143, {style: styleSektory, onEachFeature: onEachFeature}).addTo(map);
		var obo141_sektory = L.geoJson(sektory141, {style: styleSektory, onEachFeature: onEachFeature}).addTo(map);
		var obo143 = L.geoJson(obwod143, {style: style143}).addTo(map);
		var obo141 = L.geoJson(obwod141, {style: style141}).addTo(map);
		// odd z pliku .json var odo = L.geoJson(oddzialy, {style: styleOddzialy, onEachFeature: onEachFeatureOdd});
		
		var odo = L.tileLayer.wms("http://mapserver.bdl.lasy.gov.pl/ArcGIS/services/WMS_BDL/mapserver/WMSServer", {
			layers: '3', //wms_geoportal_raster
			format: 'image/gif',
			transparent: true,
			attribution: ""
		});
		
		// --- pobieranie wartosci z bazy
		// --- tworzenie markerow
		
		// --- markery AMB przechowywane w tablicy mar_amb[]
		
		var mar_amb = new Array();
		var a = 0;
		</script>
		<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			$wynik = mysql_query("SELECT * FROM map_amb ORDER BY `nr` ASC"); 
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			?>
			<script>
				mar_amb[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?>').openPopup().on('click', function(e) {
				console.log("Wybrano: <?echo $r['tytul'];?>")}).addTo(map);
				a = a+1;
			</script>
		<?php
			}}
		?>
		
		<script>
		
		// --- markery ZW przechowywane w tablicy mar_ZW[]
		
		var mar_zw = new Array();
		var a = 0;
		</script>
		<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			$wynik = mysql_query("SELECT * FROM map_zw ORDER BY `nr` ASC"); 
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			?>
			<script>
				mar_zw[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?>').openPopup().on('click', function(e) {
				console.log("Wybrano: <?echo $r['tytul'];?>")}).addTo(map);
				a = a+1;
			</script>
		<?php
			}}
		?>
		
		<script>
		
		// --- markery PAS przechowywane w tablicy mar_pas[]
		
		var mar_pas = new Array();
		var a = 0;
		</script>
		<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			$wynik = mysql_query("SELECT * FROM map_pas ORDER BY `nr` ASC"); 
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			?>
			<script>
				mar_pas[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?>').openPopup().on('click', function(e) {
				console.log("Wybrano: <?echo $r['tytul'];?>")}).addTo(map);
				a = a+1;
			</script>
		<?php
			}}
		?>
		
		<script>
		
		// --- markery LP przechowywane w tablicy mar_lp[]
		
		var mar_lp = new Array();
		var a = 0;
		</script>
		<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			$wynik = mysql_query("SELECT * FROM map_lp ORDER BY `id` ASC"); 
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			?>
			<script>
				mar_lp[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?>').openPopup().on('click', function(e) {
				console.log("Wybrano: <?echo $r['tytul'];?>")}).addTo(map);
				a = a+1;
			</script>
		<?php
			}}
				
		// markery pol
		
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			$wynik = mysql_query("SELECT * FROM map_pol "); 
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			?>
			<script>
				L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?>').openPopup().on('click', function(e) {
				console.log("Wybrano: <?echo $r['tytul'];?>")}).addTo(map);
				
			</script>
		<?php
			}}
				
		// markery paz
		
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			$wynik = mysql_query("SELECT * FROM map_paz "); 
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			?>
			<script>
				L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?>').openPopup().on('click', function(e) {
				console.log("Wybrano: <?echo $r['tytul'];?>")}).addTo(map);
				
			</script>
		<?php
			}}
		?>
		
		<script>
		
		function remmappoint(){
			var nazwa = document.getElementById("nazwahid").value;
			//alert(nazwa);
			document.cookie = nazwa + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
			console.log("Usunięto ciastko");
			$.jsPanel({
						paneltype: 'hint',
						theme:     'light',
						autoclose: 5000,
						position:  'top center',
						size:      { width: 400, height: 'auto' },
						content:   "<p class='hintp'>Usunięto punkt na mapie<br>Zmiany zostaną uwzględnione po ponownym uruchomieniu mapy"
					});
				
		
		}
		
		var mar_point = new Array();
		var a = 0;
		for (i=0; i<cookies.length; i++) {
			var nazwaCookie=cookies[i].split("=")[0]; //nazwa ciastka
			var wartoscCookie=cookies[i].split("=")[1]; //wartość ciastka
			var trescesc = unescape(wartoscCookie);
			var	tresc = trescesc.split('#');
			var latc = tresc[2];
			var lngc = tresc[3];		
			var check = tresc[0];
				tresc = tresc[1];
			if (check == 'mapa'){
				mar_point[a] = new L.marker({lon: lngc, lat: latc}, {icon: usr}).bindPopup('<center><b>'+tresc+'</b><br><br><input type="hidden" id="nazwahid" value="'+nazwaCookie+'" /><button type="submit" name="del" value="del" onclick="javascript:remmappoint();">Usuń</button></center>').addTo(map);
				a = a+1;
				}
		}
			
		</script>

</div>
</body>
</html>
