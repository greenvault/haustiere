<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes">
<meta name="mobile-web-app-capable" content="yes">
<meta charset="utf-8"/>
  <link href="styles.css" rel="stylesheet">
<title>Sharepic Mobile</title>

</head>

<body>
<?php

if(isset($_POST['t']) AND file_exists('themen/' . $_POST['t'])) 
	$thema = $_POST['t'];
else
	$thema = 'planetb';

$ds          = DIRECTORY_SEPARATOR;  
$storeFolder = 'uploads';  
 
// Lösche alle Bilder, die älter als eine Stunde sind
$files = scandir( $storeFolder);
foreach($files AS $file){
	if(substr($file,0,1) == '.') continue;
	if( time() - filemtime($storeFolder . $ds . $file) > 3600 ) 
		unlink($storeFolder . $ds . $file);
}

if (!empty($_FILES)) {   

	$targetFileName = rand(1,1000000);  
	$targetFileExtension = strToLower(substr($_FILES['file']['name'],-4));
	if( !in_array($targetFileExtension, array('.jpg','.png'))) die();

    $tempFile = $_FILES['file']['tmp_name'];                         
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  

    $uploadedfile = $targetPath . $targetFileName.$targetFileExtension;
    move_uploaded_file($tempFile, $uploadedfile);  

    list($width, $height) = getimagesize($uploadedfile);   

    list($overlaywidth, $overlayheight) = getimagesize("themen/$thema/overlay.png");  



	// Erzeuge ein Overlay in der passenden Größe
	$size = 0.8; // Anteil des Overlays an der Gesamtbreite, nur bezogen auf die Breite
	$myoverlaywidth = round($width * $size);
	$myoverlayheight = round( $myoverlaywidth / ($overlaywidth/$overlayheight));
	$abstand = round($width / 10);
	$abstand_unten = round($height/2 - $myoverlayheight/2);
	$logow = round($width/15);
	$abstand_logo = round(($width - $logow ) / 2 );
	$abstand_logo_unten = $height - (1.5 * $logow);
	//$command1 =  " -resize  $mywidth themen/$thema/overlay_muster.png themen/$thema/overlay.png";




	 $command2 = " -auto-orient $uploadedfile themen/$thema/overlay.png  -geometry {$myoverlaywidth}x20000+{$abstand}+{$abstand_unten} -composite sonnenblume.png -geometry {$logow}x20000+{$abstand_logo}+{$abstand_logo_unten} -composite	 uploads/{$targetFileName}Overlay.jpg";

	$command3 = " -geometry {$myoverlaywidth}x20000+{$abstand}+{$abstand_unten} themen/$thema/overlay.png  $uploadedfile  uploads/{$targetFileName}Overlay.jpg";

	$command4 = " -geometry {$logow}x20000+{$abstand_logo}+{$abstand_logo_unten} sonnenblume.png  uploads/{$targetFileName}Overlay.jpg  uploads/{$targetFileName}Overlay.jpg";

	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {		
		echo exec('convert.exe ' . $command2);
	}else{
		exec('gm composite ' . $command3);
		exec('gm composite ' . $command4);
	}

	//unlink($targetPath. $targetFileName.$targetFileExtension);


	echo  '<a href="download.php?file='.$targetFileName . 'Overlay.jpg"><img src="uploads/' . $targetFileName . 'Overlay.jpg" style="border:1px solid black;width:100%;height:auto;max-height:100%;max-width:100%"/></a><h1>Tippe auf das Bild, um es herunterzuladen.<br/><a href="index.php?t='. $thema. '">Nochmal</a></h1>' ;
/*
	$size = getimagesize( $targetPath . $targetFileName . '.jpg' );

	$return = array ('name' => $targetFileName . '.jpg',
					 'width' => $size[0],
					 'height' => $size[1]
		);
	echo json_encode( $return );
	*/
}

?>

</body>
</html>