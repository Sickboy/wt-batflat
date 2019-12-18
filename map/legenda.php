<?php

	include('config.php');	

?>
	
<?php
		$lat = array();
		$lon = array();
		$amb = array();
		$a = 0;
			
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');

			$wynik = mysql_query("SELECT * FROM map_amb ORDER BY `nr` ASC"); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			
				$lat[a] = $r['lat'];
				$lon[a] = $r['lon'];
				$amb[a] = $r['tytul'];
				
				$ama = $ama."{coordinates: [".$lat[a].",".$lon[a].", 16],text: '".$amb[a]."',thumbnail: './img/ico/ambona_ico.png', id: '".$a."'}, ";
				
				$a = $a + 1;
				
			} 
		};
		
	// --- $ama -> zawiera kolejne pozycje legendy pobrane z BD za pomocą php
		
		?>
		
<?php
		$lat = array();
		$lon = array();
		$zw = array();
		$a = 0;
			
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');

			$wynik = mysql_query("SELECT * FROM map_zw ORDER BY `nr` ASC"); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			
				$lat[a] = $r['lat'];
				$lon[a] = $r['lon'];
				$zw[a] = $r['tytul'];
				
				$zwa = $zwa."{coordinates: [".$lat[a].",".$lon[a].", 16],text: '".$zw[a]."',thumbnail: './img/ico/zw.png', id: '".$a."'},";
				
				$a = $a + 1;
				
			} 
		};
		
	// --- $zwa -> zawiera kolejne pozycje legendy pobrane z BD za pomocą php
		
		?>
		
<?php
		$lat = array();
		$lon = array();
		$pa = array();
		$a = 0;
			
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');

			$wynik = mysql_query("SELECT * FROM map_pas  "); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
			
				$lat[a] = $r['lat'];
				$lon[a] = $r['lon'];
				$pa[a] = $r['tytul'];
				
				$pas = $pas."{coordinates: [".$lat[a].",".$lon[a].", 16],text: '".$pa[a]."',thumbnail: './img/ico/pas.png', id: '".$a."'},";
				
				$a = $a + 1;
				
			} 
		};
		
	// --- $pas -> zawiera kolejne pozycje legendy pobrane z BD za pomocą php
		
?>

<?php
		$lat = array();
		$lon = array();
		$ks = array();
		$a = 0;
			
			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');

			$wynik = mysql_query("SELECT * FROM map_lp ORDER BY `id` ASC"); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
					if($r['nr'] == 1){
			
				$lat[a] = $r['lat'];
				$lon[a] = $r['lon'];
				$ks[a] = $r['tytul'];
				
				$ksi = $ksi."{coordinates: [".$lat[a].",".$lon[a].", 13],text: '".$ks[a]."',thumbnail: './img/ico/bookblack.png', id: '".$a."'},";
				
				
				
			} 
			$a = $a + 1;}
		};
		
	// --- $ksi -> zawiera kolejne pozycje legendy pobrane z BD za pomocą php
		
?>

<script>

	var a = 0;
	var moje = [];
	var cooks = new Object();;
	var cook = '';
	var coor = '';
	var cookies=document.cookie.split("; ");  //tworzymy z niego tablicę ciastek
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
				coor = "["+latc+","+lngc+", 16]"
				cooks = {coordinates: [latc,lngc,'16'],text: tresc ,thumbnail: './img/ico/point_amb_ico.png', id: a};
				moje[a] = cooks;
				a = a + 1;}
	}
	
</script>

<script>
var ambony = [<?echo $ama ?>];	// zaczytanie do zmiennej ambony wartości z php $ama
var zwyzki = [<?echo $zwa ?>];	// zaczytanie do zmiennej zwyzki wartości z php $zwa
var pasniki = [<?echo $pas ?>];	// zaczytanie do zmiennej pasniki wartości z php $pas
var ksiazka = [<?echo $ksi ?>];	// zaczytanie do zmiennej pasniki wartości z php $ks
//var cooks = [document.write(cook)];
		
var legend = {
    title: "Mapa<te style='position: absolute; right: 50px; top: -5px;'><select id='selectMap' name='typ' onChange='javascript:changeMap();'><option value='OSM'>OSM</option><option value='SAT'>SAT</option><option value='TOPO'>TOPO</option></select></te><br><hr>",
    description: "<input id='141' name='141' type='checkbox' checked='checked' onclick='ob141()' /><te>Obwód 135<img src='./img/ico/blue.png' style='position: absolute; right: 50px;'/></te><br><input id='141_sektory' name='141_sektory' type='checkbox' checked='checked' onclick='ob141_sektory()' /><te>Sektory w obwodzie 135<img src='./img/ico/yellow.png' style='position: absolute; right: 50px;' /></te><br><br><input id='143' name='143' type='checkbox' checked='checked' onclick='ob143()' /><te>Obwód 137<img src='./img/ico/red.png' style='position: absolute; right: 50px;'/></te><br><input id='143_sektory' name='143_sektory' type='checkbox' checked='checked' onclick='ob143_sektory()' /><te>Sektory w obwodzie 137<img src='./img/ico/yellow.png' style='position: absolute; right: 50px;' /></te><br><br><input id='odd' name='odd' type='checkbox' onclick='odd()' /><te>Oddziały PGL LP</te><img src='./img/ico/green.png' style='position: absolute; right: 50px;'/><br>",	// dodanie checkboxow do legendy
	// displayPopup: true,
    sections: [
	{
        title: 'Ksiażki pobytu myśliwych na polowaniu',
        className: 'poi',
        keys: ksiazka
    },
	{
        title: 'Ambony',
        className: 'poi',
        keys: ambony
    },
    {
        title: 'Zwyżki',
        className: 'poi',
        keys: zwyzki
    },
	{
        title: 'Paśniki',
        className: 'poi',
        keys: pasniki
    },
	{
        title: 'Moje punkty na mapie',
        className: 'poi',
        keys: moje
    }
]};
</script>