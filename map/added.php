<?php

include('config.php');

			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');

			$wynik = mysql_query("SELECT * FROM map_point ORDER BY 'tytul'"); 

			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
				
					echo $r['tytul'].' | '.$r['lat'].' | '.$r['lon'].'<br>'.$r['tresc'].'<br><br>';
				
			} 
		};
		

echo $ama;
?>