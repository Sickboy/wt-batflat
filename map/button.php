<html>
<head>

	<link rel="stylesheet" href="./jspanel/jquery.jspanel.css" type="text/css" media="screen" />
	
</head>
<body>

<script src="./jspanel/vendor/jquery-2.1.3.min.js"></script>
<script src="./jspanel/vendor/jquery-ui-1.11.2.complete/jquery-ui-1.11.2.min.js"></script>
<script src="./jspanel/vendor/jquery.ui.touch-punch.min.js"></script>
<script src="./jspanel/vendor/mobile-detect.min.js"></script>
<script src="./jspanel/jquery.jspanel.min.js"></script>

<?php
 
class yahoo_weather {
 
  public $city_code;
  protected $weather;
 
  public function __construct($city_code) {
    $this->city_code = $city_code;
  }
 
  public function get($get_channel = NULL) {
 
    if(empty($this->weather)) {
 
      try {
        $xml = @new SimpleXMLElement('http://weather.yahooapis.com/forecastrss?w='. $this->city_code .'&u=c', NULL, TRUE);
      } catch (Exception $e) {
        return FALSE;
      }
 
      $xml->registerXpathNamespace('yweather', 'http://xml.weather.yahoo.com/ns/rss/1.0');
 
      $wind       = $xml->xpath('//channel/yweather:wind');
      $atmosphere = $xml->xpath('//channel/yweather:atmosphere');
      $astronomy  = $xml->xpath('//channel/yweather:astronomy');
      $condition  = $xml->xpath('//channel/item/yweather:condition');
      $forecast   = $xml->xpath('//channel/item/yweather:forecast');
 
      $this->weather = array(
        'wind'       => array(
          'chill'      => "{$wind[0]['chill']}",	//chłód(?)
          'direction'  => "{$wind[0]['direction']}",	//kierunek
          'speed'      => "{$wind[0]['speed']}",	//prędkość
          ),
        'atmosphere' => array(
          'humidity'   => "{$atmosphere[0]['humidity']}",	//wilgotność
          'visibility' => "{$atmosphere[0]['visibility']}",	//widoczność
          'pressure'   => "{$atmosphere[0]['pressure']}",	//ciśnienie
          'rising'     => "{$atmosphere[0]['rising']}",
        ),
        'astronomy'  => array(
          'sunrise'    => "{$astronomy[0]['sunrise']}",
          'sunset'     => "{$astronomy[0]['sunset']}",
        ),
        'condition'  => array(
          'text'       => "{$condition[0]['text']}",
          'code'       => "{$condition[0]['code']}",
          'temp'       => "{$condition[0]['temp']}",
          'date'       => "{$condition[0]['date']}",
        ),
        'forecast'   => array(
          'today'      => array(
            'day'        => "{$forecast[0]['day']}",
            'date'       => "{$forecast[0]['date']}",
            'low'        => "{$forecast[0]['low']}",
            'high'       => "{$forecast[0]['high']}",
            'text'       => "{$forecast[0]['text']}",
            'code'       => "{$forecast[0]['code']}",
          ),
          'tomorrow'   => array(
            'day'        => "{$forecast[1]['day']}",
            'date'       => "{$forecast[1]['date']}",
            'low'        => "{$forecast[1]['low']}",
            'high'       => "{$forecast[1]['high']}",
            'text'       => "{$forecast[1]['text']}",
            'code'       => "{$forecast[1]['code']}",
          )
        )
      );
 
      $xml = NULL;
    }
 
    if($get_channel == NULL) {
      return $this->weather;
    }
    else {
      return $this->weather[$get_channel];
    }
  }
}
?>

<?php
$yahoo_weather = new yahoo_weather('522678');
$weather = $yahoo_weather->get();
?>

<?

$weather['wind']['speed'] = round($weather['wind']['speed'], 1);
$kierunek = $weather['wind']['direction'];
//if (($kierunek <207.5) && ($kierunek>157.5)){$kierunek='Pd';};
$kier;

if ((($kierunek <22) && ($kierunek>0)) || (($kierunek <0) && ($kierunek>337.5))){$kierunek=1;$kier='  północny';};
if (($kierunek <67) && ($kierunek>22.5)){$kierunek=2;$kier=' północno - wschodni';};
if (($kierunek <112) && ($kierunek>67.5)){$kierunek=3;$kier=' wschodni';};
if (($kierunek <157) && ($kierunek>112.5)){$kierunek=4;$kier=' południowo - wschodni';};
if (($kierunek <207) && ($kierunek>157.5)){$kierunek=5;$kier=' południowy';};
if (($kierunek <247) && ($kierunek>207.5)){$kierunek=6;$kier=' południowo - zachodni';};
if (($kierunek <292) && ($kierunek>247.5)){$kierunek=7;$kier=' zachodni';};
if (($kierunek <337) && ($kierunek>292.5)){$kierunek=8;$kier=' północno - zachodni';};
if ($kierunek ==0) {;$kier='u brak';};

?>
<style>
.leaflet-wind a {
		  background:#fff url(./img/wind/<?echo $kierunek;?>.png) no-repeat 5px;
		  background-size:25px 25px;
		  display: block;
		  position: absolute; 
		  right: 330px;
		  top: 0px;
		  box-shadow: 0 1px 5px rgba(0,0,0,0.65);
		border-radius: 4px;
		 }
		 
.leaflet-weather a {
		  background:#fff url(./img/ico/weather.png) no-repeat 5px;
		  background-size:29px 29px;
		  display: block;
		  position: absolute; 
		  right: 370px;
		  top: -10px;
		  box-shadow: 0 1px 5px rgba(0,0,0,0.65);
		border-radius: 4px;
		 }
		 
.leaflet-ico a {
		  background:#fff url(./img/ico/icoo.png) no-repeat 5px;
		  background-size:25px 25px;
		  display: block;
		  position: absolute; 
		  right: 410px;
		  top: -20px;
		  box-shadow: 0 1px 5px rgba(0,0,0,0.65);
		border-radius: 4px;
		 }
		 
.leaflet-refresh a {
		  background:#fff url(./img/ico/refresh.png) no-repeat 5px;
		  background-size:22px 22px;
		  display: block;
  }
  
.leaflet-help a {
		  background:#fff url(./img/ico/help.png) no-repeat 5px;
		  background-size:20px 20px;
		  display: block;
  }
  
  .leaflet-info a {
		  background:#fff url(./img/ico/info.png) no-repeat 5px;
		  background-size:28px 28px;
		  display: block;
  }

		 .leaflet-wind-bar {
	box-shadow: 0 1px 5px rgba(0,0,0,0.65);
	border-radius: 4px;
	}
.leaflet-wind-bar a,
.leaflet-wind-bar a:hover {
	background-color: #fff;
	border-bottom: 1px solid #ccc;
	width: 26px;
	height: 26px;
	line-height: 26px;
	display: block;
	text-align: center;
	text-decoration: none;
	color: black;
	}
.leaflet-wind-bar a,
.leaflet-wind-control-layers-toggle {
	background-position: 50% 50%;
	background-repeat: no-repeat;
	display: block;
	}
.leaflet-wind-bar a:hover {
	background-color: #f4f4f4;
	}
.leaflet-wind-bar a:first-child {
	border-top-left-radius: 4px;
	border-top-right-radius: 4px;
	}
.leaflet-wind-bar a:last-child {
	border-bottom-left-radius: 4px;
	border-bottom-right-radius: 4px;
	border-bottom: none;
	}
.leaflet-wind-bar a.leaflet-disabled {
	cursor: default;
	background-color: #f4f4f4;
	color: #bbb;
	}
	.leaflet-wind-touch .leaflet-bar a {
	width: 30px;
	height: 30px;
	line-height: 30px;
	}
	</style>
	
<script>
function status() {

$.jsPanel({
    paneltype: 'hint',
    theme:     'light',
    position:  'top center',
    size:      { width: 400, height: 'auto' },
    content:   "<p class='hintp'>Wiatr<?echo $kier;?>, <br>Prędkość wiatru: <?echo $weather['wind']['speed'];?> km/h<br><br>Widoczność: <?echo $weather['atmosphere']['visibility'];?> km<br>Wilgotność: <?echo $weather['atmosphere']['humidity'];?>%\n\n",
});
}

function Fhelp(){
	//window.open('./help.php', 'edit', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300').focus(); 
	
	$.jsPanel({
	title: "Pomoc",
	position: "center",
	theme: "light",
	size:     { width: 350, height: 270 },
    position: { top: 50, left: 50 },
	controls: { buttons: 'closeonly' },
	content: "<table>		<tr><td align='center'>		<img src='./img/ico/icon-fullscreen.png'  width='30' height='30'/>		</td><td>		Wyświetla mapę na pełnym ekranie		</td></tr>		<tr><td align='center'>		<img src='./img/ico/leaflet.defaultextent.png'  width='30' height='30'/>		</td><td>		Resetuje widok mapy		</td></tr>		<tr><td align='center'>		<img src='./img/ico/print.png'  width='20' height='20'/>		</td><td>		Drukuje aktualnie wyświetlany fragment mapy		</td></tr>		<tr><td align='center'>		<img src='./img/ico/refresh.png' width='25' height='25'  />		</td><td>		Odświerza okno mapy - reset		</td></tr>		<tr><td>		&nbsp		</td></tr>		<tr><td align='center'>		<img src='./img/ico/icoo.png'  width='25' height='25'/>		</td><td>		Strona główna koła		</td></tr>		<tr><td align='center'>		<img src='./img/ico/weather.png'  width='25' height='25'/>		</td><td>		Aktualna pogoda		</td></tr>		<tr><td align='center'>		<img src='./img/wind/0.png' width='25' height='25' />		</td><td>		Aktualnie wiejący wiatr		</td></tr></table>",
	});
}

function Finfo(){
	//window.open('./help.php', 'edit', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,fullscreen=no,channelmode=no,width=500,height=300').focus(); 
	
	$.jsPanel({
	title: "Informacje",
	position: "center",
	theme: "light",
	size:     { width: 350, height: 220 },
    position: { top: 70, left: 70 },
	controls: { buttons: 'closeonly' },
	content: "<p class='hintp'>Koło Łowieckie 'Wieniec' w Toruniu.<br>Interaktywna mapa obwodów 135 i 137<br><br>Wykonanie <a href='http://www.acomp24.pl'>@Comp</a> Wersja 0.9.3<br><br><b>Podane na mapie współrzędne geograficzne są poglądowe i nie są odzwierciedlone w terenie!<br>Systematycznie będziemy aktualizować dane.</b><br><br>Wszystkie błędy oraz sugestie<br> proszę zgłaszać na adres <a href='mailto:kontakt@acomp24.pl'>kontakt@acomp24.pl</a></p>",
	});
}

	// --- WIATR

L.Control.Wind = L.Control.extend({
    options: {
        position: 'topright',
        title: 'Aktualny wiatr',
    },

    onAdd: function () {
        var container = L.DomUtil.create('div', 'leaflet-wind leaflet-wind-bar leaflet-control');

        this.link = L.DomUtil.create('a', 'leaflet-control-easyPrint-button leaflet-bar-part', container);
        this.link.href = "javascript:status();";
		this.link.title = this.options.title;

        return container;
    },
    
  
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);
    },
});

L.wind = function() {
  return new L.Control.Wind();
};

	// --- POGODA

L.Control.Weather = L.Control.extend({
    options: {
        position: 'topright',
        title: 'Pogoda',
    },

    onAdd: function () {
        var container = L.DomUtil.create('div', 'leaflet-weather leaflet-wind-bar leaflet-control');

        this.link = L.DomUtil.create('a', 'leaflet-control-easyPrint-button leaflet-bar-part', container);
        this.link.href = "javascript:window.open('http://www.wieniectorun.pl/5012.php');";
		this.link.title = this.options.title;

        return container;
    },
    
  
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);
    },
});

L.weather = function() {
  return new L.Control.Weather();
};

	// --- STRONA KOŁA

L.Control.Ico = L.Control.extend({
    options: {
        position: 'topright',
        title: 'Strona główna koła',
    },

    onAdd: function () {
        var container = L.DomUtil.create('div', 'leaflet-ico leaflet-wind-bar leaflet-control');

        this.link = L.DomUtil.create('a', 'leaflet-control-easyPrint-button leaflet-bar-part', container);
        this.link.href = "javascript:window.open('http://www.wieniectorun.pl');";
		this.link.title = this.options.title;

        return container;
    },
    
  
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);
    },
});

L.ico = function() {
  return new L.Control.Ico();
};

	// --- REFRESH

L.Control.Refresh = L.Control.extend({
    options: {
        position: 'topleft',
        title: 'Odświerz',
    },

    onAdd: function () {
        var container = L.DomUtil.create('div', 'leaflet-refresh leaflet-wind-bar leaflet-control');

        this.link = L.DomUtil.create('a', 'leaflet-control-easyPrint-button leaflet-bar-part', container);
        this.link.href = "javascript:location.reload();";
		this.link.title = this.options.title;

        return container;
    },
    
  
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);
    },
});

L.refresh = function() {
  return new L.Control.Refresh();
};

	// --- HELP

L.Control.Help = L.Control.extend({
	options: {
		position: 'topleft',
		title: 'Pomoc'
	},

    onAdd: function () {
        var container = L.DomUtil.create('div', 'leaflet-help leaflet-wind-bar leaflet-control');

        this.link = L.DomUtil.create('a', 'leaflet-control-easyPrint-button leaflet-bar-part', container);
        this.link.href = "javascript:Fhelp()";
		this.link.title = this.options.title;
		
		return container;
    },
    
  
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);
    },
});

L.help = function() {
  return new L.Control.Help();
};

	// --- INFO

L.Control.Info = L.Control.extend({
	options: {
		position: 'topleft',
		title: 'Informacje'
	},

    onAdd: function () {
        var container = L.DomUtil.create('div', 'leaflet-info leaflet-wind-bar leaflet-control');

        this.link = L.DomUtil.create('a', 'leaflet-control-easyPrint-button leaflet-bar-part', container);
        this.link.href = "javascript:Finfo()";
		this.link.title = this.options.title;
		
		return container;
    },
    
  
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);
    },
});

L.info = function() {
  return new L.Control.Info();
};

	// --- zwierz

L.Control.Animals = L.Control.extend({
	options: {
		position: 'topleft',
		title: 'Pomoc'
	},

    onAdd: function () {
        var container = L.DomUtil.create('div', 'leaflet-help leaflet-wind-bar leaflet-control');

        this.link = L.DomUtil.create('a', 'leaflet-control-easyPrint-button leaflet-bar-part', container);
        this.link.href = "javascript:Animals()";
		this.link.title = this.options.title;

        return container;
    },
    
  
    _click: function (e) {
        L.DomEvent.stopPropagation(e);
        L.DomEvent.preventDefault(e);
    },
});

L.animals = function() {
  return new L.Control.Animals();
};
</script>

</body>
</html>