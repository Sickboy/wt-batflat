<?php ob_start(); ?> 
<?php
session_start();
  if(isset($_SESSION['logon']) || isset($_COOKIE['keep'])){
  ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ADM - Map test</title>

	<link rel="stylesheet" href="leaflet/leaflet.css" />	
	<link rel="stylesheet" href="leaflet/leaflet.draw.css" />	
	<link rel="stylesheet" href="./jspanel/jquery.jspanel.css" type="text/css" media="screen" />
	
	<style>
	
	    html, body, #map {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
		cursor: default;
    }
	.poi li > p, .poi li > div { 
        display: inline-block;
        vertical-align: top;
      }
      .poi li {
        white-space: nowrap;
        overflow: hidden;
      }
      .poi li p {
        padding: 10px;
      }

</style>
	
</head>
<body>


	<div id="map" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" ></div>
	
	<script type="text/javascript" language="javascript" src="..35gal/lytebox.js"></script>
	<link rel="stylesheet" href="..35gal/lytebox.css" type="text/css" media="screen" />

	<script src="leaflet/leaflet.js"></script>
	<script src="leaflet/TileLayer.GeoJSON.js"></script>
	<script src="leaflet/Leaflet.TileLegend.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!--<script src="leaflet/legenda.js"></script>-->
	<script src="leaflet/leaflet.label.js"></script>
	<script src="leaflet/Map.ContextMenu.js"></script>
	<script src="leaflet/L.Control.Zoomslider.js"></script>
	<script src="leaflet/Control.FullScreen.js"></script>
	<script src="leaflet/leaflet.draw.js"></script>
	<script src="leaflet/leaflet.defaultextent.js"></script>
	
	<script src="./maps/141.json"></script>
	<script src="./maps/141_sektory.json"></script>
	<script src="./maps/143.json"></script>
	<script src="./maps/143_sektory.json"></script>
	<script src="./maps/forest.json"></script>
	
	<script src="./jspanel/vendor/jquery-2.1.3.min.js"></script>
	<script src="./jspanel/vendor/jquery-ui-1.11.2.complete/jquery-ui-1.11.2.min.js"></script>
	<script src="./jspanel/vendor/jquery.ui.touch-punch.min.js"></script>
	<script src="./jspanel/vendor/mobile-detect.min.js"></script>
	<script src="./jspanel/jquery.jspanel.min.js"></script>
	
<?php

	include('config.php');
	include('legenda.php');
	include('decTOdms.php');

	?>
	 <script>

	
	
	
	// --- funkcje do wyswietlania warstw przy zaznaczeniu checkboxa
	
	function ob143_sektory(){
		if (document.getElementById('143_sektory').checked){
				  map.addLayer(obo143_sektory) ;
		}else{
					map.removeLayer(obo143_sektory);
		}
	}
	function ob143(){
		if (document.getElementById('143').checked){
				  map.addLayer(obo143) ;
		}else{
					map.removeLayer(obo143);
		}
	}
	function ob141_sektory(){
		if (document.getElementById('141_sektory').checked){
				  map.addLayer(obo141_sektory) ;
		}else{
					map.removeLayer(obo141_sektory);
		}
	}
	function ob141(){
		if (document.getElementById('141').checked){
				  map.addLayer(obo141) ;
		}else{
					map.removeLayer(obo141);
		}
	}
	function odd(){
		if (document.getElementById('odd').checked){
				  map.addLayer(odo) ;
		}else{
					map.removeLayer(odo);
		}
	}
	
	// --- funkcja zmieniająca typ mapy po zmianie SELECT'a
	
	function changeMap() {
		var x = document.getElementById("selectMap").value;
		if(x == 'OSM'){
			map.removeLayer(topo);
			map.removeLayer(sat);
			map.addLayer(osm);}
		if(x == 'TOPO'){
			map.removeLayer(osm);
			map.removeLayer(sat);
			map.addLayer(topo);}
		if(x == 'SAT'){
			map.removeLayer(osm);
			map.removeLayer(topo);
			map.addLayer(sat);}
	}
	
	// --- funkcja wyswietlajaca popup przy kliknieciu na polygon
	
	function onEachFeature(feature, layer) {
    if (feature.properties && feature.properties.name) {
        //layer.bindPopup(feature.properties.name);		- zwykły popup
		layer.bindLabel(feature.properties.name, { noHide: true });
    }
	}
	
	function onEachFeatureOdd(feature, layer) {
    if (feature.properties && feature.properties.ref) {
        layer.bindLabel('Oddział ' + feature.properties.ref, { noHide: true });
    }
	}
	
	// --- funkcje PPM
	
	function showCoordinates (e) {
	      alert(e.latlng);
		  panel_gr.content.append("asdf");
    }
	
	function addthis (e) {
		var lat = e.latlng.lat;
		var lon = e.latlng.lng;
	    window.open('./edit.php?page=3&lat='+lat+'&lon='+lon, 'edit', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300').focus(); 
		  
		  
		return false;
    }
	
	function add (e) {
		window.open('./edit.php?page=3', 'edit', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300').focus(); 
		  
		  
		return false;
    }
	
	function refresh (e) {
	      location.reload();
    }
	
	function show (e) {
	      alert(drawnItems);
    }

		// --- tworzenie mapy
	
		var mbAttr = 'Koło Łowieckie "Wieniec" w Toruniu',
			mbOSM = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
			//mbUrl = 'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
			mbTOPO = 'http://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png';

	    var osm   = L.tileLayer(mbOSM, {maxZoom: 20, legend: legend, openLegendOnLoad: true});
	    var topo   = L.tileLayer(mbTOPO, {maxZoom: 20, legend: legend, openLegendOnLoad: true});
		
		var sat = L.tileLayer('http://{s}.{base}.maps.cit.api.here.com/maptile/2.1/maptile/{mapID}/hybrid.day/{z}/{x}/{y}/256/png8?app_id={app_id}&app_code={app_code}', {
			attribution: 'Map &copy; 1987-2014 <a href="http://developer.here.com">HERE</a>',
			subdomains: '1234',
			mapID: 'newest',
			app_id: 'GZn0QiyfNlRs7uPJzbxg',
			app_code: 'WcmIDmsbYorH3nf23GBy8g',
			base: 'aerial',
			minZoom: 0,
			maxZoom: 20,
			legend: legend, openLegendOnLoad: true
		});
		    
		var map = L.map('map', {
			center: {lon: 18.566444, lat: 53.078665},
			zoom: 13,
			attributionControl: false,
			layers: [osm],
			defaultExtentControl: true,
			contextmenu: true,
			contextmenuWidth: 140,
			contextmenuItems: [{
				text: 'Wspolrzedne',
				callback: showCoordinates
				},{
				text: 'Dodaj tutaj',
				callback: addthis
				},{
				text: 'Dodaj...',
				callback: add
				},{
				text: 'Odswierz',
				callback: refresh
				}
			]
		});
		
		var legendControl = (new L.Control.TileLegend()).addTo(map);
		
		// --- rysowanie
		/*
		var drawnItems = new L.FeatureGroup();
		map.addLayer(drawnItems);

		var drawControl = new L.Control.Draw({
			draw: {
				position: 'topleft',
				rectangle: false,
				marker: false,
				polygon: false,
				polyline: false,
				circle: {
					shapeOptions: {
						color: '#662d91'
					}
				}
			},
			edit: {
				featureGroup: drawnItems
			}
		});
		map.addControl(drawControl);

		
		
		
		map.on('draw:created', function (e) {
			var type = e.layerType,
				layer = e.layer;
				rad = layer.getRadius();
				latlng = layer.getLatLng();
				lat = latlng.lat;
				lng = latlng.lng;
				//var shape = layer.toGeoJSON()
				//var shape_for_db = JSON.stringify(shape);
				//drawnItems.addLayer(layer);
				//alert(shape_for_db);
				
				
				
				
				window.open('./edit.php?page=6&lat='+lat+'&lng='+lng+'&rad='+rad+'', 'edit', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300').focus(); return false;

		
		
		//window.open('./edit.php?page=6','','width=600,height=400', shape_for_db);
	
				
		});	*/
		
		// http://stackoverflow.com/questions/24018630/how-to-save-a-completed-polygon-points-leaflet-draw-to-mysql-table
		
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
	
		var obo143_sektory = L.geoJson(sektory143, {style: styleSektory, onEachFeature: onEachFeature});
		var obo141_sektory = L.geoJson(sektory141, {style: styleSektory, onEachFeature: onEachFeature});
		var obo143 = L.geoJson(obwod143, {style: style143}).addTo(map);
		var obo141 = L.geoJson(obwod141, {style: style141}).addTo(map);
		var odo = L.geoJson(oddzialy, {style: styleOddzialy, onEachFeature: onEachFeatureOdd});
		
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
				mar_amb[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<h4 style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></h4><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?></small><br><br><center><a href="./edit.php?page=1&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=1&id=<?echo $r['id'] ?>&typ=amb\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Edytuj</a>&nbsp&nbsp&nbsp<a href="./edit.php?page=5&id=<?echo $r['id']?>&typ=amb" onclick="window.open(\'./edit.php?page=5&id=<?echo $r['id']?>&typ=amb \', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Usun</a></center>').addTo(map);

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
				mar_zw[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<h4 style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></h4><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?></small><br><br><center><a href="./edit.php?page=1&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=1&id=<?echo $r['id'] ?>&typ=zw\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Edytuj</a>&nbsp&nbsp&nbsp<a href="./edit.php?page=5&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=5&id=<?echo $r['id'] ?>&typ=zw\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Usun</a></center>').addTo(map);

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
				mar_pas[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<h4 style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></h4><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?></small><br><br><center><a href="./edit.php?page=1&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=1&id=<?echo $r['id'] ?>&typ=pas\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Edytuj</a>&nbsp&nbsp&nbsp<a href="./edit.php?page=5&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=5&id=<?echo $r['id'] ?>\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Usun</a></center>').addTo(map);

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
				mar_lp[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<h4 style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></h4><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?></small><br><br><center><a href="./edit.php?page=1&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=1&id=<?echo $r['id'] ?>\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Edytuj</a>&nbsp&nbsp&nbsp<a href="./edit.php?page=5&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=5&id=<?echo $r['id'] ?>\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Usun</a></center>').addTo(map);

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
				mar_poz[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<h4 style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></h4><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?></small><br><br><center><a href="./edit.php?page=1&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=1&id=<?echo $r['id'] ?>\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Edytuj</a>&nbsp&nbsp&nbsp<a href="./edit.php?page=5&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=5&id=<?echo $r['id'] ?>\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Usun</a></center>').addTo(map);

				
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
				mar_paz[a] = new L.marker({lon: <?echo $r['lon']?>, lat: <?echo $r['lat']?>}, {icon: <?echo $r['typ']?>}).bindPopup('<h4 style="width: 200px"><center><b><?echo $r['tytul']?></b><hr></center></h4><p><?echo $r['tresc']?><br><br><small><center><?echo dec_lat($r['lat'])?>&nbsp<?echo dec_lng($r['lon'])?></small><br><br><center><a href="./edit.php?page=1&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=1&id=<?echo $r['id'] ?>\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Edytuj</a>&nbsp&nbsp&nbsp<a href="./edit.php?page=5&id=<?echo $r['id'] ?>" onclick="window.open(\'./edit.php?page=5&id=<?echo $r['id'] ?>\', \'edit\', \'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300\').focus(); return false" >Usun</a></center>').addTo(map);

				
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
<?php
	
		  }
  
  else{
	header('location: ../admin/index.php');   
	  
  }
  
  ob_end_flush();
		
?>