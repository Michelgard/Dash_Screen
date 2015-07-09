<?php

  function htmlspecialchars_array(array $array) {
    foreach($array as $key => $val) {
      $array[$key] = (is_array($val)) ? htmlspecialchars_array($val) : htmlspecialchars($val);
    }
    return $array;
  }

  /////////////////////////////////////////////////
  //  Meteo
  /////////////////////////////////////////////////

  function meteo () {

    $meteo  = '<div id="cont_MzAxODl8NXwzfDJ8MXxGRkZGRkZ8M3xGRkZGRkZ8Y3wx"><div id="spa_MzAxODl8NXwzfDJ8MXxGRkZGRkZ8M3xGRkZGRkZ8Y3wx"><a id="a_MzAxODl8NXwzfDJ8MXxGRkZGRkZ8M3xGRkZGRkZ8Y3wx" href="http://www.meteocity.com/france/nimes_v30189/" rel="nofollow" target="_blank" style="color:#333;text-decoration:none;">Météo Nîmes</a> © meteocity.com</div><script type="text/javascript" src="http://widget.meteocity.com/js/MzAxODl8NXwzfDJ8MXxGRkZGRkZ8M3xGRkZGRkZ8Y3wx"></script></div>';
    return $meteo;
  }
  
  /////////////////////////////////////////////////
  //  Meteo paris
  /////////////////////////////////////////////////

  function meteoparis () {

    $meteoparis  = '<div id="cont_NzUwNTZ8NXw1fDV8MXxCQkUwRkZ8MXwwMDAwMDB8Y3wx"><div id="spa_NzUwNTZ8NXw1fDV8MXxCQkUwRkZ8MXwwMDAwMDB8Y3wx"><a id="a_NzUwNTZ8NXw1fDV8MXxCQkUwRkZ8MXwwMDAwMDB8Y3wx" href="http://www.meteocity.com/france/paris_v75056/" rel="nofollow" target="_blank" style="color:#333;text-decoration:none;">Météo Paris</a> © meteocity.com</div><script type="text/javascript" src="http://widget.meteocity.com/js/NzUwNTZ8NXw1fDV8MXxCQkUwRkZ8MXwwMDAwMDB8Y3wx"></script></div>';
    return $meteoparis;
  }
///////////////////////////////////////////////////
// Température exterieur
///////////////////////////////////////////////////
function tempext () {
	$html       = '';

	// récupération de la valeur de la base de donnée vérifier en amont
include("Connexion/connexion.php");

// Max ID de la base
$reponse = $bdd->query('select MAX(ID_Temp_Ext) from Temp_Ext');
$Max_ID = $reponse->fetch();
 $ID =$Max_ID[0];

//dernière valeur
$reponse = $bdd->query("select Temp_Temp_Ext from Temp_Ext where ID_Temp_Ext = '$ID'");
$Temp = $reponse->fetch();
$temperature=$Temp[0];
	
		 $temperature = round($temperature, 1);
		$temp = explode(".", $temperature);
	  
		$html .= '<div class="container">';
		$html .= '  <div class="de">';
		$html .= '     <div class="den">';
		$html .= '      <div class="dene">';
		$html .= '       <div class="denem">';
		$html .= '       <div class="deneme">';
		$html .= $temp[0];
		$html .= '<span>.';
		$html .= $temp[1];
		$html .= '</span><strong>&deg;</strong>';          
		$html .= '      </div>';
		$html .= '  <BR><BR><BR><BR><BR><strong>EXT</strong></div>';
		$html .= '    </div>';
		$html .= '   </div>';
		$html .= '   </div>';    
		$html .= '</div>';

	return $html;
}

///////////////////////////////////////////////////
// Température salon
//////////////////////////////////////////////////

function temp () {
	$html       = '';
	
    if (!defined("THERMOMETER_SENSOR_PATH")) define("THERMOMETER_SENSOR_PATH", "/sys/bus/w1/devices/28-00044cf9b4ff/w1_slave");
    $thermometer = fopen(THERMOMETER_SENSOR_PATH, "r");
    $thermometerReadings = fread($thermometer, filesize(THERMOMETER_SENSOR_PATH));
	fclose($thermometer);
    preg_match("/t=(.+)/", preg_split("/\n/", $thermometerReadings)[1], $matches);
    $temperature = $matches[1] / 1000;
	
    $temperature = round($temperature, 1);
    $temp = explode(".", $temperature);
	if(!array_key_exists( '1', $temp)){$temp[1]='';}
  
	$html .= '<div class="container">';
	$html .= '  <div class="de">';
	$html .= '     <div class="den">';
    $html .= '      <div class="dene">';
    $html .= '       <div class="denem">';
    $html .= '       <div class="deneme">';
    $html .= $temp[0];
	$html .= '<span>.';
	$html .= $temp[1];
	$html .= '</span><strong>&deg;</strong>';          
    $html .= '      </div>';
    $html .= '  <BR><BR><BR><BR><BR><strong>SALON</strong></div>';
    $html .= '    </div>';
    $html .= '   </div>';
	$html .= '   </div>';    
	$html .= '</div>';

return $html;
}
///////////////////////////////////////////////////
// Température graph salon
//////////////////////////////////////////////////

function tempgraph () {

   include("Connexion/connexion.php");

  // L'image 
  $largeur = 650;
  $hauteur = 200;
  $img = imageCreate($largeur, $hauteur);

  // La première couleur de la palette
  // qui constitue la couleur de fond
  // sera le rouge
  $rouge = imageColorAllocate($img, 255, 0, 0);
   $noir  = imageColorAllocate($img, 255, 255, 255);
   
   $font = './Eraser.ttf';
   
  $titre        = "TEMPERATURE SALON ( /24H )";

    imagettftext($img, 20, 0, 90, 40, $noir, $font, $titre);
	
  // Que l'on peut rendre transparent
  imagecolortransparent($img,$rouge); 

// Max ID de la base
$reponse = $bdd->query('select MAX(ID_Temp_Salon) from Temp_Salon');
$Max_ID = $reponse->fetch();
 $ID =$Max_ID[0] - 144;  //144 enregistrement par 24 heures

//Tableau des 144 dernière valeur 24 heures
$reponse = $bdd->query("select Temp_Temp_Salon from Temp_Salon where ID_Temp_Salon > '$ID'");

 $x=50;
 $heure = date("H:i");
 $t = 20;

  while ($Tab_Temp = $reponse->fetch())
   {
	$y=$Tab_Temp['Temp_Temp_Salon'] * 5;
	$tr = $Tab_Temp['Temp_Temp_Salon'];
	$y=200-$y;
	imagefilledrectangle($img, $x-2, $y-1, $x+2, $y+1, $noir);
	
	if (($x == 146) | ($x == 266) | ($x == 386) | ($x == 506)){
	ImageLine($img,$x,$y-10,$x,$y+15,$noir);
	ImageLine($img,$x+1,$y-10,$x+1,$y+15,$noir);
	
	$pluscinq = time() - ($t * 60 * 60);		
	$titre= date ("H:i",$pluscinq);
	$t = $t - 5;
	imagettftext($img, 10, 0, $x -14, $y-15, $noir, $font, $titre);
	
	$titre = $tr . "'C";
	imagettftext($img, 10, 0, $x -14, $y+28, $noir, $font, $titre);
	}
	
  $x=$x+4;
	}
 $reponse->closeCursor(); 
  //ligne y
  ImageLine($img,48,40,48,$hauteur,$noir);
  // ligne et temp
	for ($i = 175; $i > 25; ($i=$i-25)) {
		ImageLine($img,40,$i,48,$i,$noir);
		
		$titre = ((200 - $i)/5) . "'C";
		imagettftext($img, 10, 0, 10, $i+5, $noir, $font, $titre);
	}
 
  // Envoyons le code de l'image 
	header("Content-type: image/png");
	$chemin ="/var/www/graphtemp.png";
	imagePNG($img, $chemin);
	
	$html  = '';
	$html .= '<IMG SRC="graphtemp.png">';

return $html;
  
}

 /////////////////////////////////////////////////
  //  Photo
  /////////////////////////////////////////////////
 
  function photo () {
     
      // $r  = '<img src="';
     $dir = "photodiaporama/";
     // $dir_web = "photo/";
      session_start();
    //  $r = "debut ";
      //if (!isset($_SESSION['photos'])) {
           $_SESSION['photos']= array();
          $i=0;
      //    $r = $r."init";
          if (is_dir($dir)) {
              if ($dh = opendir($dir)) {
                  while (($file = readdir($dh)) !== false) {               
                     $a = $dir."/".$file;
                      //$r = $r." je lis " . $a . " ";
                      if(is_file($a)) {
                         $_SESSION['photos'][$i++]=$dir.$file;}
						  // $_SESSION['photos'][$i++];
                  }
               closedir($dh);
              }
          }
      //}
     
      if (!isset($_SESSION['countPhoto'])) { $_SESSION['countPhoto'] = 0;}
      else {
          if($_SESSION['countPhoto'] < count($_SESSION['photos'])-1)
              $_SESSION['countPhoto']++;
          else
             $_SESSION['countPhoto'] = 0;
      }
    $r ='<img heiht = "100%" width="100%" src="';
	 $r .=  $_SESSION['photos'][$_SESSION['countPhoto']];
	$r .='"/>';
	
   return $r;
  }
   
/////////////////////////////////////////////////
  //  Fete du jour
  /////////////////////////////////////////////////
 
  function fete () {
     
  $jour=date("d");
  $mois=date("m");
  $fp=fopen("FETES.txt","r");
  while ( ! feof($fp) )
  {
    $ligne=fgets($fp,255);
    $mots=explode(';',$ligne);
    $prenom=$mots[0];
    $jourtrouve=intval($mots[1]);
    $moistrouve=intval($mots[2]); 
    if (($jour==$jourtrouve) && ($mois==$moistrouve))
    {
	$html = '';
	
    $html .='Bonne f&ecirc;te<BR>';
	$html .= $prenom;
    }
  }
  fclose($fp);
	return $html;
  }
  
  // fonction qui recherche le mini et le maxi pour une date donnée
function calcul($date_jour,$bdd,$ext){
if (!$ext){
	$reponse = $bdd->query("select Temp_Temp_Salon from Temp_Salon where DATE(Date_Temp_Salon)  = '$date_jour'");
	$min= 55;
	$max= -40;
	while ($Temp = $reponse->fetch())
	   {
	   if($Temp['Temp_Temp_Salon']>$max)
		{
		  $max=$Temp['Temp_Temp_Salon'];
		}
		if($Temp['Temp_Temp_Salon']<$min)
		{
		  $min=$Temp['Temp_Temp_Salon'];
		}
	 }
}
else {
	$reponse = $bdd->query("select Temp_Temp_Ext from Temp_Ext where DATE(Date_Temp_Ext)  = '$date_jour'");
	$min= 55;
	$max= -40;
	while ($Temp = $reponse->fetch())
	   {
	   if($Temp['Temp_Temp_Ext']>$max)
		{
		  $max=$Temp['Temp_Temp_Ext'];
		}
		if($Temp['Temp_Temp_Ext']<$min)
		{
		  $min=$Temp['Temp_Temp_Ext'];
		}
	 }
}
$reponse->closeCursor();
// retour des 2 valeurs dans un tableau
return array($min, $max);
}
  
  /////////////////////////////////////////////////
  // temp mini maxi salon
  /////////////////////////////////////////////////
 
  function minmax () {
  
  // pour les mois en francais
setlocale(LC_TIME, 'french');

// Connexion à la base
include("Connexion/connexion.php"); 

//construction html pour affichage temp
$html = '';
$html .= '<p align=center style=margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center><b><span style=font-size:13.0pt;line-height:115%;color:white>Temp&eacute;ratures
mini et maxi sur trois jours</span></b></p>';
$html .='<p class=MsoNormal align=center style=text-align:center>';
 
// recuperation de données d'avant hier
$date_jour = date('Y-m-d', strtotime('-2 day'));  //date d'avant hier
$date_ecrite = date('d M', strtotime('-2 day'));  // date pour affichage avec mois eabrégé en lettre
$ext = FALSE;
list($min, $max) = calcul($date_jour,$bdd,$ext);  // lance la fonction de recher mini et maxi du jour

// le html suite
$html .='<span style="color:#FFF; border:1px dotted white">&nbsp;';
$html .=$date_ecrite;
$html .='&nbsp;:&nbsp;<span style=color:#0070C0>';
$html .=$min;
$html .='</span>&nbsp;/&nbsp;<span style=color:red>';
$html .=$max;
$html .='&nbsp;</span></span>&nbsp;&nbsp;&nbsp;';

// recuperation de données d'hier
$date_jour = date('Y-m-d', strtotime('-1 day'));  // date d'hier
$date_ecrite = date('d M', strtotime('-1 day'));  //date pour affichage avec mois eabrégé en lettre
list($min, $max) = calcul($date_jour,$bdd,$ext);  // lance la fonction de recher mini et maxi du jour

// le html suite
$html .='<span style="color:#FFF; border:1px dotted white">&nbsp;';
$html .=$date_ecrite;
$html .='&nbsp;:&nbsp;<span style=color:#0070C0>';
$html .=$min;
$html .='</span>&nbsp;/&nbsp;<span style=color:red>';
$html .=$max;
$html .='&nbsp;</span></span>&nbsp;&nbsp;&nbsp;';

// recuperation de données du jour
$date_jour = date("Y-m-d"); // date du jour
$date_ecrite = date('d M');   //date pour affichage avec mois eabrégé en lettre
list($min, $max) = calcul($date_jour,$bdd,$ext);    // lance la fonction de recher mini et maxi du jour

// le html suite et fin
$html .='<span style="color:#FFF; border:1px dotted white">&nbsp;';
$html .=$date_ecrite;
$html .='&nbsp;:&nbsp;<span style=color:#0070C0>';
$html .=$min;
$html .='</span>&nbsp;/&nbsp;<span style=color:red>';
$html .=$max;
$html .='&nbsp;</span></span>&nbsp;&nbsp;&nbsp;';
$html .= '</p>';

return $html;
}

 
  /////////////////////////////////////////////////
  // temp mini maxi ext
  /////////////////////////////////////////////////
 
  function minmaxext () {
  
  // pour les mois en francais
setlocale(LC_TIME, 'french');

// Connexion à la base
include("Connexion/connexion.php"); 

//construction html pour affichage temp
$html = '';
$html .= '<p align=center style=margin-bottom:0cm;margin-bottom:.0001pt;
text-align:center><b><span style=font-size:13.0pt;line-height:115%;color:white>Temp&eacute;ratures
mini et maxi sur trois jours</span></b></p>';
$html .='<p class=MsoNormal align=center style=text-align:center>';
 
// recuperation de données d'avant hier
$date_jour = date('Y-m-d', strtotime('-2 day'));  //date d'avant hier
$date_ecrite = date('d M', strtotime('-2 day'));  // date pour affichage avec mois eabrégé en lettre
$ext = TRUE;
list($min, $max) = calcul($date_jour,$bdd,$ext);  // lance la fonction de recher mini et maxi du jour

// le html suite
$html .='<span style="color:#FFF; border:1px dotted white">&nbsp;';
$html .=$date_ecrite;
$html .='&nbsp;:&nbsp;<span style=color:#0070C0>';
$html .=$min;
$html .='</span>&nbsp;/&nbsp;<span style=color:red>';
$html .=$max;
$html .='&nbsp;</span></span>&nbsp;&nbsp;&nbsp;';

// recuperation de données d'hier
$date_jour = date('Y-m-d', strtotime('-1 day'));  // date d'hier
$date_ecrite = date('d M', strtotime('-1 day'));  //date pour affichage avec mois eabrégé en lettre
list($min, $max) = calcul($date_jour,$bdd,$ext);  // lance la fonction de recher mini et maxi du jour

// le html suite
$html .='<span style="color:#FFF; border:1px dotted white">&nbsp;';
$html .=$date_ecrite;
$html .='&nbsp;:&nbsp;<span style=color:#0070C0>';
$html .=$min;
$html .='</span>&nbsp;/&nbsp;<span style=color:red>';
$html .=$max;
$html .='&nbsp;</span></span>&nbsp;&nbsp;&nbsp;';

// recuperation de données du jour
$date_jour = date("Y-m-d"); // date du jour
$date_ecrite = date('d M');   //date pour affichage avec mois eabrégé en lettre
list($min, $max) = calcul($date_jour,$bdd,$ext);    // lance la fonction de recher mini et maxi du jour

// le html suite et fin
$html .='<span style="color:#FFF; border:1px dotted white">&nbsp;';
$html .=$date_ecrite;
$html .='&nbsp;:&nbsp;<span style=color:#0070C0>';
$html .=$min;
$html .='</span>&nbsp;/&nbsp;<span style=color:red>';
$html .=$max;
$html .='&nbsp;</span></span>&nbsp;&nbsp;&nbsp;';
$html .= '</p>';

return $html;
}

// deux fonctions pour graph bande passante
function parseData ($stat_file, $up_down) {

  $datas = array();
  if(filemtime($stat_file) < time()-10){return $datas;}
	//if ($up_down == 'up'){
		$cmd ="tail -n 150 /var/www/graphbp/bandepass.txt > /var/www/graphbp/bandepassfin.txt";
		shell_exec ($cmd);
	//}
	$stat_file ="/var/www/graphbp/bandepassfin.txt";
  
  
   $stats = fopen($stat_file, 'r');
    if (flock($stats, LOCK_EX)){
		while (($line = fgets($stats)) !== false) {
		  $explode_line = str_word_count($line, 1, "0123456789.");
		  if($up_down == 'down') {
			$datas[]  = $explode_line[0];
		  }
		  else{ 
			if (array_key_exists(1, $explode_line)) {
				$datas[]  = $explode_line[1];
			}
		  }
		}
	}
	flock($stats, LOCK_UN);
	fclose($stats);

    return $datas;
  }
  
function imagickHisto ($max, $eth, $up_down) {

  $datas = parseData ("/var/www/graphbp/bandepass.txt", $up_down);

 $width            = 150; // largeur du graphique
  $height           = 50; // hauteur du graphique
  $padding          = 1;
  $ticks            = 5;
  
  $image = imageCreate($width, $height);
	
  $background_color = imageColorAllocate($image, 255, 0 ,0); // couleur du fond
  $axes_color       = imageColorAllocate($image, 255, 255 ,255); // couleur des axes
  $texte_color      = imageColorAllocate($image, 255, 255 ,255);
  
  if($up_down == 'down'){
    $data_color = imageColorAllocate($image, 0, 128 ,0); // couleur du graphique pour le download
  }
  else{
    $data_color = imageColorAllocate($image, 0, 0 ,128); // couleur du graphique pour l'upload
  }

	$font = './Eraser.ttf';
	$titre = "$eth - $up_down";
  imagettftext($image, 10, 0, 37, 15, $texte_color, $font, 	$titre);
  
  imagecolortransparent($image, $background_color);
  
  $nb_values        = $width - 2*$padding - 2;
  $max_value        = $height - 2*$padding - 4;

  $nb_datas         = sizeof($datas);
  $trim             = $nb_values - $nb_datas;

  if($trim < 0){$trim = 0;}

  $xx1    = $padding;
  $xy1    = $height - $padding - 1;
  $xx2    = $width - $padding - 1;
  $xy2    = $xy1;
  $yx1    = $xx1;
  $yy1    = $xy1;
  $yx2    = $yx1;
  $yy2    = $padding;
  $half_y = $height/2;
  $half_x = $width/2;

  ImageLine  ($image, $xx1, $xy1, $xx2, $xy2, $axes_color);
  ImageLine  ($image, $yx1, $yy1, $yx2, $yy2, $axes_color);

  ImageLine  ($image, $yx1, $yy2, $yx1+$ticks, $yy2, $axes_color);
  ImageLine  ($image, $yx1, $half_y, $yx1+$ticks, $half_y, $axes_color);

  $first_x = $xx1 + 1 + $trim;
  $last_x  = $xx2 - 1;
  $first_y = $xy1 - 1;
  $last_y  = $yy2 + 1;

  for($i=0;$i<$nb_values;$i++){
    if(isset($datas[$i])){
	
      $value   = $datas[$i]*$max_value/$max;
      $value_y = $first_y - $value;
      $value_x = $first_x + $i;
      ImageLine  ($image, $value_x, $first_y, $value_x, $value_y, $data_color );
    }
  }
  
  header( "Content-Type: image/png" );
  
	echo imagepng($image);
	imagedestroy($image);
  exit;
}


// température du CPU
function tempcpu () {
$temp = exec('cat /sys/class/thermal/thermal_zone0/temp');
		//On divise par 1000 pour convertir
		$tempconv  =  $temp / 1000;
		 //Un chiffre après la virgule ça suffit
		 $temppi = round($tempconv,1);

  $width            = 85; // largeur du graphique
  $height           = 30; // hauteur du graphique
  $padding          = 1;
  $ticks            = 5;
  
  $image = imageCreate($width, $height);
	
  $background_color = imageColorAllocate($image, 255, 0 ,0); // couleur du fond
  $axes_color       = imageColorAllocate($image, 255, 0 ,0); // couleur des axes
  $texte_color      = imageColorAllocate($image, 255, 255 ,255);
  
 
    $color_vert = imageColorAllocate($image, 0, 255 ,0); 
    $color_orange = imageColorAllocate($image, 255, 192 ,0);
	$color_rouge = imageColorAllocate($image, 255, 0 ,0);

  imagecolortransparent($image, $background_color);

$temppir = round($tempconv,0);
  for($i=0;$i<$temppir;$i++){
    $value_x = $i;
	if ($temppir < 60){
      ImageLine  ($image, $value_x, 0, $value_x, 30, $color_vert );
	}
	if (($temppir > 60) AND ($temppir < 75)){
      ImageLine  ($image, $value_x, 0, $value_x, 30, $color_orange );
	}
	if ($temppir > 80){
      ImageLine  ($image, $value_x, 0, $value_x, 30, $color_rouge );
	}
	
  }
	
  $font = './Eraser.ttf';
  $titre = $temppi . "'C";
  imagettftext($image, 10, 0, 25, 20, $texte_color, $font, 	$titre);
  
  header( "Content-Type: image/png" );
  $chemin= "/var/www/graphbp.png";
  imagePNG($image, $chemin);
  $html ='<div id="cpu">Température du PI</div><IMG border=1 SRC="graphbp.png">';
  
	return $html;
  }
  
  
  //Memoire disponible
  function memoire () {
  $cmd ="free -m > /var/www/graphbp/mem.txt";
	shell_exec ($cmd);
	
	$stat_file ="/var/www/graphbp/mem.txt";
  
  
   $stats = fopen($stat_file, 'r');
    $i=0;
	while ($i < 3) {
		$line = fgets($stats);
		$explode_line = str_word_count($line, 1, "0123456789.");
		$memutilise = $explode_line[2];
		$memfree =$explode_line[3];
		$i++;
    }
	$memtotal = 437;
	$nbbarre = ($memutilise / $memtotal) * 100;
	$nbbarre = round($nbbarre,0);
	
  $width            = 100; // largeur du graphique
  $height           = 30; // hauteur du graphique
  $padding          = 1;
  $ticks            = 5;
  
  $image = imageCreate($width, $height);
	
  $background_color = imageColorAllocate($image, 255, 0 ,0); // couleur du fond
  $axes_color       = imageColorAllocate($image, 255, 0 ,0); // couleur des axes
  $texte_color      = imageColorAllocate($image, 255, 255 ,255);
  
 
    $color_vert = imageColorAllocate($image, 0, 255 ,50); 
  
  imagecolortransparent($image, $background_color);

  for($i=0;$i<$nbbarre;$i++){
    $value_x = $i;
      ImageLine  ($image, $value_x, 0, $value_x, 30, $color_vert );
    }
	
  $font = './Eraser.ttf';
  $titre = $nbbarre . "'/,";
  imagettftext($image, 10, 0, 25, 20, $texte_color, $font, 	$titre);
  
 header( "Content-Type: image/png" );
  
	echo imagepng($image);
	imagedestroy($image);
  exit;
  }
  
  //vitesse cpu
  function donneesusageCPU() {

	$result = shell_exec ('grep "^cpu " /proc/stat');

	$explode_line = str_word_count($result, 1, "0123456789.");

	$valeur = $explode_line[1] + $explode_line[2] + $explode_line[3];

	return $valeur;
}

  function cpu() {
$timer =1 ;

$mesure_1 = donneesusageCPU();

sleep ($timer);

$mesure_2 = donneesusageCPU();

 $CPU_USAGE=($mesure_2 - $mesure_1)/($timer);
 $CPU_USAGE = round ($CPU_USAGE, 0);
 $CPU_USAGE = $CPU_USAGE . "\n";

 
 $donnee = file("/var/www/graphbp/cpu.txt");
 
 if(!array_key_exists(99, $donnee)){
	shell_exec ('cp /var/www/graphbp/cpu2.txt /var/www/graphbp/cpu.txt');
	$donnee = file("/var/www/graphbp/cpu.txt");
 }
 
	$donnee[] = $CPU_USAGE;
	$fichier=fopen('/var/www/graphbp/cpu.txt', "w");
	if (flock($fichier, LOCK_EX)){
		fputs($fichier,'');
		$i=0;
		foreach($donnee as $d)
		{
			if($i!=0)
			{
				fputs($fichier,$d);
			}
			$i++;
		}
	}
	flock($fichier, LOCK_UN);
	fclose($fichier);

	$donnee = file("/var/www/graphbp/cpu.txt");
	
		
  $width            = 100; // largeur du graphique
  $height           = 50; // hauteur du graphique
  $padding          = 1;
  $ticks            = 5;
  
  $image = imageCreate($width, $height);
	
  $background_color = imageColorAllocate($image, 255, 0 ,0); // couleur du fond
  $axes_color       = imageColorAllocate($image, 255, 0 ,0); // couleur des axes
  $texte_color      = imageColorAllocate($image, 255, 255 ,255);
  
   $color_vert = imageColorAllocate($image, 0, 255 ,50); 
  
 imagecolortransparent($image, $background_color);

  for($i=0;$i<100;$i++){
  
    $value_x = $i;
	if ($donnee[$i]>100){
		$donnee[$i]=100;
	}
	$donnee[$i]= (50 - ($donnee[$i]/2));
	
      ImageLine  ($image, $value_x,50 , $value_x, $donnee[$i], $color_vert );
    }
	  
 header( "Content-Type: image/png" );
  
	echo imagepng($image);
	imagedestroy($image);
  exit;
  
  }
  
  // temps uptime
  
  function readbleTime($seconds) {
        $y = floor($seconds / 60 / 60 / 24 / 365);
        $d = floor($seconds / 60 / 60 / 24) % 365;
        $h = floor(($seconds / 3600) % 24);
        $m = floor(($seconds / 60) % 60);
        $s = $seconds % 60;

        $string = '';

        if ($y > 0) {
            $yw = $y > 1 ? ' ans ' : ' an ';
            $string .= $y . $yw;
        }

        if ($d > 0) {
            $dw = 'j ';
            $string .= $d . $dw;
        }

        if ($h > 0) {
            $hw = 'h ';
            $string .= $h . $hw;
        }

        if ($m > 0) {
            $mw = 'mn ';
            $string .= $m . $mw;
        }

        return preg_replace('/\s+/', ' ', $string);
    }

function uptime(){
	$uptime = shell_exec("cat /proc/uptime");
	$uptime = explode(" ", $uptime);
			
	$string = readbleTime($uptime[0]);
	echo "<div><img src='uptime.png' align='middle'></div><strong>$string</strong>";

}

 /////////////////////////////////////////////////
  //  température extérieur
  /////////////////////////////////////////////////
 
  function tempgraphext(){
   include("Connexion/connexion.php");

  // L'image 
  $largeur = 650;
  $hauteur = 240;
  $img = imageCreate($largeur, $hauteur);

  // La première couleur de la palette
  // qui constitue la couleur de fond
  // sera le rouge
  $rouge = imageColorAllocate($img, 255, 0, 0);
   $noir  = imageColorAllocate($img, 255, 255, 255);
   
   $font = './Eraser.ttf';
   
  $titre        = "TEMPERATURE EXTERIEUR ( /24H )";

    imagettftext($img, 20, 0, 90, 40, $noir, $font, $titre);
	
  // Que l'on peut rendre transparent
 imagecolortransparent($img,$rouge); 

//Tableau des  24 heures
$reponse = $bdd->query("SELECT * 
FROM  `Temp_Ext` 
WHERE  `Date_Temp_Ext` 
BETWEEN DATE_SUB( 
CURRENT_TIMESTAMP , INTERVAL 24 HOUR ) 
AND CURRENT_TIMESTAMP ");

 $x=50;
 $heure = date("H:i");
 $t = 20;

	while ($Tab_Temp = $reponse->fetch())
   {
	   if ($Tab_Temp['Temp_Temp_Ext'] >= 0){
			$y=($Tab_Temp['Temp_Temp_Ext'] * 2.5) + 25;
			$y=200-$y;
			imagefilledrectangle($img, $x-2, $y-1, $x+2, $y+1, $noir);
		}	
		if ($Tab_Temp['Temp_Temp_Ext'] < 0){
			$y=($Tab_Temp['Temp_Temp_Ext'] + 10) * 2.5;
			$y=200-$y;
			imagefilledrectangle($img, $x-2, $y-1, $x+2, $y+1, $noir);
		}	
		
		$tr = $Tab_Temp['Temp_Temp_Ext'];
		if (($x == 146) | ($x == 266) | ($x == 386) | ($x == 506)){
			ImageLine($img,$x,$y-10,$x,$y+15,$noir);
			ImageLine($img,$x+1,$y-10,$x+1,$y+15,$noir);
			
			$titre= date ("H:i", strtotime($Tab_Temp['Date_Temp_Ext']));
			imagettftext($img, 10, 0, $x -14, $y-15, $noir, $font, $titre);
			
			$titre = $tr . "'C";
			imagettftext($img, 10, 0, $x -14, $y+28, $noir, $font, $titre);
		}
		$x=$x+4;
	}
 $reponse->closeCursor(); 
  //ligne y
  ImageLine($img,48,40,48,$hauteur -20,$noir);
  // ligne et temp
	for ($i = 200; $i > 25; ($i=$i-25)) {
		ImageLine($img,40,$i,48,$i,$noir);
		
		switch ($i) {
			case 200:
			$titre = "-10'C";;
			break;
			case 175:
			$titre = "0'C";;
			break;
			case 150:
			$titre = "10'C";;
			break;
			case 125:
			$titre = "20'C";;
			break;
			case 100:
			$titre = "30'C";;
			break;
			case 75:
			$titre = "40'C";;
			break;
			case 50:
			$titre = "50'C";;
			break;
		}	
		imagettftext($img, 10, 0, 8, $i+4, $noir, $font, $titre);
	}
 
   // Envoyons le code de l'image 
	header("Content-type: image/png");
	$chemin ="/var/www/graphtempext.png";
	imagePNG($img, $chemin);
	
	$html  = '';
	$html .= '<IMG SRC="graphtempext.png">';

return $html;
 
  }
?>
