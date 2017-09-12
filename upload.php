<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes" />
		<meta name="mobile-web-app-capable" content="yes">
		<meta charset="utf-8" />
  		<link href="css/fonts.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">
		<link href="https://www.gruene.de/tmpl/gfx/icons/favicon.ico?v=bOv55x3EXn" rel="shortcut icon">
		<title>Haustiere würden grün wählen</title>
		
	</head>
	
	<body>
 	<div id=container>
  	<div align="center"><a href="/" border="0"><img class="logo" src="images/logo.svg"></a></div>
		<h1>Mein Haustier würde Grün wählen!</h1>
		
	<?php
	
	if(isset($_POST['t']) AND isset($_POST['h']) AND file_exists('haustiere/' . $_POST['h'] . '/' . $_POST['t'])) {
		$thema = $_POST['t'];
		$haustier = $_POST['h'];
	} else {
		$thema = '1';
	}
	
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
	
	    list($overlaywidth, $overlayheight) = getimagesize("haustiere/$haustier/$thema/overlay.png");  
	
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
	
		$command2 = " -auto-orient $uploadedfile haustiere/$haustier/$thema/overlay.png  -geometry {$myoverlaywidth}x20000+{$abstand}+{$abstand_unten} -composite sonnenblume.png -geometry {$logow}x20000+{$abstand_logo}+{$abstand_logo_unten} -composite	uploads/{$targetFileName}Overlay.jpg";
		$command3 = " -geometry {$myoverlaywidth}x20000+{$abstand}+{$abstand_unten} haustiere/$haustier/$thema/overlay.png  $uploadedfile  uploads/{$targetFileName}Overlay.jpg";
		$command4 = " -geometry {$logow}x20000+{$abstand_logo}+{$abstand_logo_unten} sonnenblume.png uploads/{$targetFileName}Overlay.jpg  uploads/{$targetFileName}Overlay.jpg";
	
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {		
			echo exec('convert.exe ' . $command2);
		}else{
			exec('gm composite ' . $command3);
			exec('gm composite ' . $command4);
		}
	
		//unlink($targetPath. $targetFileName.$targetFileExtension);
	
	
		echo  '<a href="download.php?file='.$targetFileName . 'Overlay.jpg"><img src="uploads/' . $targetFileName . 'Overlay.jpg" style="border:1px solid black;width:100%;height:auto;max-height:100%;max-width:100%"/></a>';
    echo '<hr />';
    echo '<h2>Tippe auf das Bild, um es herunterzuladen und teile es auf Facebook!<br /><a href="index.php">Nochmal</a></h1>';
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
	<div align="center"><img class="logo2" src="images/logo_quer.png"></div>
	</div>
	</body>
</html>



