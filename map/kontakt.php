<html>
<head>
<meta charset="utf-8">
</head>
<body>
				<link rel="stylesheet" href="../map/leaflet/leaflet.css" />	
				
				<script type="text/javascript" language="javascript" src="/35gal/lytebox.js"></script>
				<link rel="stylesheet" href="/35gal/lytebox.css" type="text/css" media="screen" />

				<script src="../map/leaflet/leaflet.js"></script>
				<script src="../map/leaflet/TileLayer.GeoJSON.js"></script>
				<script src="../map/leaflet/Leaflet.TileLegend.js"></script>
				<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
				<script src="../map/leaflet/jQuery.print.js"></script>
				<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.3.0"></script>
				<!--<script src="leaflet/legenda.js"></script>-->
				<script src="../map/leaflet/leaflet.label.js"></script>
				<script src="../map/leaflet/leaflet.defaultextent.js"></script>
				
				<script src="../map/maps/141.json"></script>
				<script src="../map/maps/141_sektory.json"></script>
				<script src="../map/maps/143.json"></script>
				<script src="../map/maps/143_sektory.json"></script>
				
				<div id="map" style="width: 100%; height: 100%;" ></div>
					
			<?php

				include('../map/config.php');
				include('../map/legenda.php');

			?>
				
				<script>
				
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

					// --- tworzenie mapy
				
					var mbAttr = 'Koło Łowieckie "Wieniec" w Toruniu',
						mbOSM = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
						//mbUrl = 'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
						mbTOPO = 'http://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png';

					var topo   = L.tileLayer(mbOSM, {maxZoom: 20});
						
					var map = L.map('map', {
						center: {lon: 18.5203, lat: 53.0825},
						zoom: 13,
						attributionControl: false,
						//zoomsliderControl: true,
						//zoomControl: false,
						layers: [topo], 
						defaultExtentControl: true,
					});
							
					// --- ikony
					
					var lp = L.icon({
						iconUrl: '../map/img/ico/lplogo.png',
						iconSize: [30, 30]
					});
						
					var pzl = L.icon({
						iconUrl: '../map/img/ico/deer.png',
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
				
					// --- tworzenie warstw
				
					var obo143_sektory = L.geoJson(sektory143, {style: styleSektory, onEachFeature: onEachFeature}).addTo(map);
					var obo141_sektory = L.geoJson(sektory141, {style: styleSektory, onEachFeature: onEachFeature}).addTo(map);
					var obo143 = L.geoJson(obwod143, {style: style143}).addTo(map);
					var obo141 = L.geoJson(obwod141, {style: style141}).addTo(map);
					
					// --- pobieranie wartosci z bazy
					// --- tworzenie markerow
					
					</script>
					
			<?php
						mysql_connect($server,$login,$haslo) or die("cannot connect");
						mysql_select_db($bd) or die("cannot select DB");
						mysql_query('SET NAMES \'utf8\'');
						
						$wynik = mysql_query("SELECT * FROM map_lp"); 

						if(mysql_num_rows($wynik) > 0) { 
							while($r = mysql_fetch_assoc($wynik)) { 
								
								if($r['lat'] == '53.0825'){
									
									?>
					
					<script>
					
						L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px; color: #000000;"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?></p>').addTo(map).openPopup();
					</script>
					
			<?php
									
								}
								else{
			?>
					
					<script>
					
						L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<p style="width: 200px; color: #000000;"><center><b><?echo $r['tytul']?></b><hr></center></p><p><?echo $r['tresc']?></p>').addTo(map);
					
					</script>
					
			<?php
								}
						} 
					}
					
			?>
</body>
</html>