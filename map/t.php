<?php

include('config.php');
include('decTOdms.php');

mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
			$wynik = mysql_query("SELECT * FROM map_point"); 
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				

			
				echo htmlspecialchars("new L.marker({lon: ".$r['lon'].", lat: ".$r['lat']."}, {icon: ".$r['typ']."}).bindPopup('<p style=\'width: 200px\'><center><b>".$r['tytul']."</b><hr></center></p><p>".$r['tresc']."<br><br><small><center>".dec_lat($r['lat'])."&nbsp".dec_lng($r['lon'])."').openPopup().addTo(map);")."<br><br>";

		
			}}

?>
