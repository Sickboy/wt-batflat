<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ADM - Map</title>
	
</head>
<body>

<?php

	include('config.php');

	?>
<?php
switch($_GET['page']) //inicjujemy zmienna get i jej nazwe
     {
		case '1':	// --- edycja
			$id = $_GET['id'];	
			$typ = $_GET['typ'];
			
			$table = '`map_'.$typ."`";

			mysql_connect($server,$login,$haslo) or die("cannot connect");;
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');
				
			$wynik = mysql_query("SELECT * FROM ".$table." WHERE `id`='".$id."'") 
			or die('B��d zapytania');

			echo '<form method="post" action="./edit.php?page=2&id='.$id.'&table='.$table.'">
			<table>';
				
			if(mysql_num_rows($wynik) > 0) { 
				while($r = mysql_fetch_assoc($wynik)) { 
					echo '
					
						<tr><td>
						lat: <input type="text" name="lat" id="lat" value="'.$r['lat'].'" size="15" /> </td>
						<td>
						lon: <input type="text" name="lon" id="lon" value="'.$r['lon'].'" size="15" /></td></tr></table>
						tytul: <input type="text" name="tytul" id="tytul" value="'.$r['tytul'].'" size="38" />
						
						<textarea name="tresc" id="tresc" rows="10" cols="45" >'.$r['tresc'].'</textarea><br><br>
						<button  type="submit" value="Zatwierdz" title="Zatwierdz">Zatwierdz zmiany</button>
						';
			}    
			}
			
			echo '<button  type="submit" value="Zatwierdz" title="Zamknij" onClick="window.close()">Zamknij</button>';
			echo '</form>';
			
		break;
		
		case '2':	// --- edycja zapis
			$id = $_GET['id'];
			$table = $_GET['table'];
			
			$lat = $_POST['lat'];
			$lon = $_POST['lon'];
			$tytul = $_POST['tytul'];
			$tresc = $_POST['tresc'];
			
			mysql_connect($server,$login,$haslo) or die("cannot connect");;
			mysql_select_db($bd) or die("cannot select DB");
			mysql_query('SET NAMES \'utf8\'');

			$wynik = mysql_query("UPDATE ".$table." SET `tresc` = '".$tresc."',`tytul` = '".$tytul."',`lon` = '".$lon."',`lat` = '".$lat."' WHERE `id`='".$id."'") 
			or die('B��d zapytania'); ; 
			
			?><script>window.close()</script><?
		break;
		
		case '3':	// --- dodanie
			$lat = $_GET['lat'];
			$lon = $_GET['lon'];
			echo '<form method="post" action="./edit.php?page=4">
			<table>';
			echo '
			
			<tr><td>
			typ:</td><td> <select name="typ">
					<option>lp</option>
					<option>pzl</option>
					<option selected="selected">amb</option>
					<option>zw</option>
					<option>ksi</option> <!-- ksiazka wpisów -->
					<option>pas</option> <!--  pasnik -->
					<option>pol</option> <!--  poletko zgryzowe -->
					<option>paz</option> <!--  pas zaporowy -->
				</select> &nbsp&nbsp</td><td>
				<button  type="button" value="submit" title="submit" onClick=\'alert("lp -> Ikona Lasów Państwowych\npzl -> Ikona PZŁ\namb -> Ambona\nzw -> Zwyżka\npas -> Paśnik\npol -> Poletko zgryzowe\npaz -> Pas zaporowy\n\nlat -> Latitude\nlon -> Longitude")\' >Pomoc</button></td></tr><tr><td>
			lat:</td><td> <input type="text" name="lat" size="15" value="'.$lat.'"/>&nbsp&nbsp</td></tr><tr><td>			
			lon:</td><td> <input type="text" name="lon" size="15" value="'.$lon.'"/>&nbsp&nbsp</td></tr><tr><td>
			tytul:</td><td> <select name="pre"><option></option><option>Ambona numer</option><option>Zwyżka numer</option></select><input type="text" name="tytul" size="43"/>&nbsp&nbsp</td></tr><tr><td>
			tresc:</td><td> <textarea name="tresc" id="tresc" rows="8" cols="45" ></textarea></td></tr>
			';
			echo '</table>
			&nbsp &nbsp 
			<button  type="submit" value="submit" title="submit" >Zatwierdz</button>
			';
			echo '<button  type="submit" value="Zatwierdz" title="Zamknij" onClick="window.close()">Zamknij</button>';
			echo '</form>';
		break;
		
		case '4':	// --- dodanie zapis
			$typ = $_POST['typ'];
			$lat = $_POST['lat'];
			$lon = $_POST['lon'];
			$pre = $_POST['pre'];
			$tytul = $_POST['tytul'];
			$tresc = $_POST['tresc'];
			
			$amb = 'amb';
			$zw = 'zw';
			$pas = 'pas';
			
			$preamb = 'Ambona numer';
			$prezw = 'Zwyżka numer';
			$prenull = '';
			
			/*if ($typ === $amb){
				$tytul = 'Ambona numer '.$tytul;
				};
				
			if ($typ === $zw){
				$tytul = 'Zwyżka numer '.$tytul;
				};
				
			if ($typ === $pas){
				$tytul = 'Paśnik';
				};*/
				
				
			if ($pre != $prenull){
				$tytul = $pre.' '.$tytul;};
							
			include('config.php');
			
			$table = '`map_'.$typ."`";

			mysql_connect($server,$login,$haslo) or die("cannot connect");
			mysql_query('SET NAMES \'utf8\'');
			mysql_select_db($bd) or die("cannot select DB");
			
			$zapytanie = "INSERT INTO ".$table." (`typ`, `lat`, `lon`, `tytul`, `tresc`) VALUES ('".$typ."','".$lat."','".$lon."','".$tytul."', '".$tresc."')";
			mysql_query($zapytanie); 
			
			//echo $zapytanie;
			
			?><script>window.close()</script><?
		break;
		case '5':	// --- usuwanie
			$id = $_GET['id'];
			$typ = $_GET['typ'];
			$table = '`map_'.$typ.'`';
			
			echo 'ID: '.$id;
			echo '<br>'.$table;
			
			?>
			<script>
				if(confirm("Czy napewno chcesz usunać wpis o id: <?echo $id?> z tabeli: map_<?echo $typ?>?")){
				<?
					mysql_connect($server,$login,$haslo) or die("cannot connect");;
					mysql_select_db($bd) or die("cannot select DB");
					$wynik = mysql_query("DELETE FROM ".$table." WHERE `id`='".$id."'")
					or die('B��d zapytania');
				?>
				document.write('Usunięto');
				window.close();
				}
				else{
				document.write('<br><br>Nieusunięto');
				window.close();
				}
			</script>
			<?
		break;
		case '6':	// --- dodanie zwierza
			$lat = $_GET['lat'];
			$lng = $_GET['lng'];
			$rad = $_GET['rad'];
			echo 'lat: '.$lat.'<br>lng: '.$lng.'<br>rad: '.$rad;
			
			echo '
				<form method="post" action="./edit.php?page=7&lat='.$lat.'&lng='.$lng.'&rad='.$rad.'">
				<select name="typ">
					<option>jelen</option>
					<option>sarna</option>
					<option>dzik</option>
					<option>los</option>
					<option>daniel</option>
				</select><br>
				<button  type="submit" value="submit" title="submit" >Zatwierdz</button>
				<button  type="submit" value="Zatwierdz" title="Zamknij" onClick="window.close()">Zamknij</button>
				</form>';
		break;
		case '7':
			$lat = $_GET['lat'];
			$lng = $_GET['lng'];
			$rad = $_GET['rad'];			
			$typ = $_POST['typ'];
			mysql_connect($server,$login,$haslo) or die("cannot connect");;
			mysql_select_db($bd) or die("cannot select DB");

			$zapytanie = "INSERT INTO `map_animal`(`lat`, `lng`, `rad`, `typ`) VALUES ('".$lat."','".$lng."','".$rad."','".$typ."')";
			mysql_query($zapytanie); 
			?><script>
				document.write('Dodano.');
				window.close();
			</script><?
		break;
		case '8':
			$lat = $_GET['lat'];
			$lon = $_GET['lon'];
			echo '<form method="post" action="./edit.php?page=9">
			<table>';
			echo '
			
			<tr><td>
			</td><td>
			</td></tr><tr><td>
			lat:</td><td> <input type="text" id="lat" name="lat" size="25" value="'.$lat.'"/>&nbsp&nbsp</td></tr><tr><td>			
			lon:</td><td> <input type="text" id="lon" name="lon" size="25" value="'.$lon.'"/>&nbsp&nbsp</td></tr><tr><td>
			tresc:</td><td> <textarea name="tresc" id="tresc" rows="8" cols="27" ></textarea></td></tr>
			';
			echo '</table>
			&nbsp &nbsp <p align="right">
			<button  type="submit" value="submit" title="submit" >Zatwierdz</button>
			';
			echo '<button  type="submit" value="Zatwierdz" title="Zamknij" onClick="window.close()">Zamknij</button>';
			echo '</form>';
		break;
		case '9':
			$lat = $_POST['lat'];
			$lon = $_POST['lon'];			
			$tresc = $_POST['tresc'];
			mysql_connect($server,$login,$haslo) or die("cannot connect");;
			mysql_select_db($bd) or die("cannot select DB");

			$zapytanie = "INSERT INTO `map_temp`(`lat`, `lon`, `tresc`) VALUES ('".$lat."','".$lon."','".$tresc."')";
			mysql_query($zapytanie); 
			?><script>
				document.write('Dodano.');
				window.close();
			</script><?
		break;
		default: //strona glowna
		break;
		}
		?>
		
</body>
</html>