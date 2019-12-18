<?
function dec_lat($dec) {
    $vars = explode(".",$dec);
    $deg = $vars[0];
     $deg = str_replace("-", "", "$deg");
    $tempma = "0.".$vars[1];
    $tempma = $tempma * 3600;
    $min = floor($tempma / 60);
    $sec = $tempma - ($min*60);
    $sec = round("$sec", 2);

  if (strpos($dec, '-') !== false) { 
   $latPos = "S";
   } else {
   $latPos = "N";
  }
return "$latPos$deg&deg;$min&apos;$sec&quot;";
} 
	
function dec_lng($dec) {

    $vars = explode(".",$dec);
    $deg = $vars[0];
     $deg = str_replace("-", "", "$deg");
    $tempma = "0.".$vars[1];

    $tempma = $tempma * 3600;
    $min = floor($tempma / 60);
    $sec = $tempma - ($min*60);
    $sec = round("$sec", 2);

  if (strpos($dec, '-') !== false) { 
   $latPos = "W";
   } else {
   $latPos = "E";
  }  
return "$latPos$deg&deg;$min&apos;$sec&quot;";
}

?>