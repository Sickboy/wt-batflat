<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Koło Łowieckie "Wieniec" w Toruniu - Mapa interaktywna</title>
	
	<link rel="stylesheet" href="leaflet/leaflet.css" />	
	
	<script type="text/javascript" language="javascript" src="../35gal/lytebox.js"></script>
	<link rel="stylesheet" href="../35gal/lytebox.css" type="text/css" media="screen" />

	<script src="leaflet/leaflet.js"></script>
	<script src="leaflet/TileLayer.GeoJSON.js"></script>
	<script src="leaflet/Leaflet.TileLegend.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="leaflet/jQuery.print.js"></script>
	<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
	<!--<script src="leaflet/legenda.js"></script>-->
	<script src="leaflet/leaflet.label.js"></script>
	<script src="leaflet/L.Control.Zoomslider.js"></script>
	<script src="leaflet/Control.FullScreen.js"></script>
	<script src="leaflet/leaflet.defaultextent.js"></script>
	<script src="leaflet/leaflet.easyPrint.js"></script>
	
	<script src="./maps/141.json"></script>
	<script src="./maps/141_sektory.json"></script>
	<script src="./maps/143.json"></script>
	<script src="./maps/143_sektory.json"></script>
	<script src="./maps/forest.json"></script>
	
	<script src="./leaflet/menu.js" type="text/javascript"></script>
	
	<link rel="stylesheet" href="./jspanel/jquery.jspanel.css" type="text/css" media="screen" />
		
	<style>
	
	    html, body,  {
        margin: 0;
        padding: 0; 
        width: 100%;
        height: 100%;
		}
		#map  {
		margin-top: 28px;
        padding: 0; 
        width: 100%;
        height: 100%;
		}
		#site {
		overflow: hidden;
		}
		
		
	</style>
	
	<script type="text/javascript">
	//<![CDATA[
		$(window).load(function() { // makes sure the whole site is loaded
			
			setTimeout(doit, 0000) //wait ten seconds before continuing
			//setTimeout(uwaga, 3000) //wait ten seconds before continuing
			
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
<body style="overflow: hidden;">

	<script src="./jspanel/vendor/jquery-2.1.3.min.js"></script>
	<script src="./jspanel/vendor/jquery-ui-1.11.2.complete/jquery-ui-1.11.2.min.js"></script>
	<script src="./jspanel/vendor/jquery.ui.touch-punch.min.js"></script>
	<script src="./jspanel/vendor/mobile-detect.min.js"></script>
	<script src="./jspanel/jquery.jspanel.min.js"></script>

	<div id="preloader">
    <div id="status"><center>Trwa ładowanie mapy</div>
	</div>
	
	<div id="site">
	<div id="top-menu-wrap" style="position: relative;   z-index: 3;" >
            <div id="top-menu" style="position: absolute;   z-index: 2;" >
                <div>
				<ul class="menu">
					<li><a href="#">Mapa</a>
					<ul>
					<li><a href="#" onclick='L.easyPrint;'>Drukuj</a></li>
					<li><a href="#">Wyjście</a></li>
					</ul>
					</li>
				
					<li><a href="#">Widok</a>
					<ul>
					<li><a href="#" onclick="warstwy_panel()">Warstwy</a></li>
					<li><a href="#" onclick='punkty_panel()'>Punkty</a></li>
					<li><a href="#" onclick='legenda_panel()'>Legenda</a></li>
					</ul>
					</li>
					
					<li><a href="#">↓ Link 5</a>
					<ul>
					<li><a href="#">Link 5.1</a></li>
					<li><a href="#">Link 5.2</a></li>
					</ul>
					</li>
					<li><a href="#">Link 6</a></li>
					</ul>
			</div>
            </div>
        </div>

	
	<div id="map" style="position: absolute; top: 0; left: 0;  z-index: 1;" ></div>
		
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
	
	function uwaga(){
		$.jsPanel({
			paneltype: 'hint',
			theme:     'danger',
			autoclose: 10000,
			position: "center",
			size:      { width: 400, height: 'auto' },
			content:   "<p class='hint'><b>Podane na mapie współrzędne geograficzne są poglądowe i nie są odzwierciedlone w terenie!<br>Systematycznie będziemy aktualizować dane.</b></p>"
		}).css('box-shadow', '0 0 50px 20px rgba(64, 64, 64, 1)');;
	}
	
	function warstwy_panel(){
			$.jsPanel({
		title: "Warstwy",
		id: 'warstwy',
		position: "center",
		theme: "light",
		size:     { width: 300, height: 200 },
		position: { top: 50, right: 50 },
		controls: { buttons: 'closeonly' },
		content: "<te style=' left: 10px; top: 10px;'>Typ Mapy: <select id='selectMap' name='typ' onChange='javascript:changeMap();'><option value='OSM'>OSM</option><option value='SAT'>SAT</option><option value='TOPO'>TOPO</option></select><br><br><input id='141' name='141' type='checkbox' checked='checked' onclick='ob141()' /><te>Obwód 135<img src='./img/ico/blue.png' style='position: absolute; right: 50px;'/></te><br><input id='141_sektory' name='141_sektory' type='checkbox' checked='checked' onclick='ob141_sektory()' /><te>Sektory w obwodzie 135<img src='./img/ico/yellow.png' style='position: absolute; right: 50px;' /></te><br><br><input id='143' name='143' type='checkbox' checked='checked' onclick='ob143()' /><te>Obwód 137<img src='./img/ico/red.png' style='position: absolute; right: 50px;'/></te><br><input id='143_sektory' name='143_sektory' type='checkbox' checked='checked' onclick='ob143_sektory()' /><te>Sektory w obwodzie 137<img src='./img/ico/yellow.png' style='position: absolute; right: 50px;' /></te><br><br><input id='odd' name='odd' type='checkbox' onclick='odd()' /><te>Oddziały PGL LP</te><img src='./img/ico/green.png' style='position: absolute; right: 50px;'/><br></te>",
	});
	}
	
	function print(){
	$("#map").print({stylesheet:"leaflet.css"})
	}
	
	function punkty_panel(){
			$.jsPanel({
		title: "Punkty na mapie",
		position: "center",
		theme: "light",
		size:     { width: 300, height: 200 },
		position: { top: 300, right: 50 },
		controls: { buttons: 'closeonly' },
	});
	}
	
	function legenda_panel(){
			$.jsPanel({
		title: "Legenda",
		position: "center",
		theme: "light",
		size:     { width: 300, height: 200 },
		position: { top: 600, right: 50 },
		controls: { buttons: 'closeonly' },
	});
	}

	
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
			map.addLayer(osm);}
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
			map.addLayer(topo);}
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
			map.addLayer(sat);}
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
			mbOSM = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
			//mbUrl = 'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
			mbTOPO = 'http://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png';

	    var osm   = L.tileLayer(mbOSM, {maxZoom: 20});
	    var topo   = L.tileLayer(mbTOPO, {maxZoom: 20, legend: legend, openLegendOnLoad: true});
		
		var sat = L.tileLayer('http://{s}.{base}.maps.cit.api.here.com/maptile/2.1/maptile/{mapID}/hybrid.day/{z}/{x}/{y}/256/png8?app_id={app_id}&app_code={app_code}', {
			attribution: 'Map &copy; 1987-2014 <a href="http://developer.here.com">HERE</a>',
			subdomains: '1234',
			mapID: 'newest',
			app_id: 'GZn0QiyfNlRs7uPJzbxg',
			app_code: 'WcmIDmsbYorH3nf23GBy8g',
			base: 'aerial',
			minZoom: 2,
			maxZoom: 20,
			legend: legend, openLegendOnLoad: true
		});
		    
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
		
		L.refresh().addTo(map);
		L.help().addTo(map);
		L.info().addTo(map);
		
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
		var odo = L.geoJson(oddzialy, {style: styleOddzialy, onEachFeature: onEachFeatureOdd});
		
		// --- pobieranie wartosci z bazy
		// --- tworzenie markerow
		
		</script>
		<?php
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			$wynik = mysql_query("SELECT * FROM map_point"); 
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
			?>
			<script>
			L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?>').on('click', function(e) {
    console.log("Wybrano: <?echo $r['tytul'];?>")}).addTo(map);
		</script>
		<?php
			}}
		?>

</div>
</body>
</html>
