<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes" />
		<meta name="mobile-web-app-capable" content="yes">
		<meta charset="utf-8" />
		<meta property="og:url"			content="https://haustier-thkuenstler.c9users.io/" />
  		<meta property="og:type"        content="website" />
  		<meta property="og:title"       content="Haustiere würden grün wählen" />
  		<meta property="og:description" content="Dein Haustier weiß genau, wie der Hase läuft. Und deshalb würde es grün wählen! Gib ihm eine Stimme." />
  		<meta property="og:image"       content="https://haustier-thkuenstler.c9users.io/uploads/' . $targetFileName . 'Overlay.jpg" />
  		<meta property="fb:app_id"	  	content="1838721583107744"  />
		<link href="css/fonts.css" rel="stylesheet" />
		<link href="css/styles.css" rel="stylesheet" />
		<link href="https://www.gruene.de/tmpl/gfx/icons/favicon.ico?v=bOv55x3EXn" rel="shortcut icon" />
		<title>Haustiere würden grün wählen</title>
	</head>
	
	<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/de_DE/sdk.js#xfbml=1&version=v2.10&appId=1838721583107744";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<div id="container">
		<div align="center"><a href="/" border="0"><img class="logo" src="images/logo.svg"></a></div>
		<h1>Mein Haustier würde Grün wählen!</h1>
	<p class="verstecke">Wähle die Art deines Haustieres. Du siehst als Vorschau einen Löwen mit dem jeweiligen Text. Wähle ggf. einen anderen Spruch unten aus. Mach ein Foto von deinem Haustier, der ausgewählte Text wird drüber gelegt. Speichere das Foto und teile es auf Facebook!</p>

<!-- Auswahl Haustier-->		
		
		<div align="center">
		    <?php	if(!isset($_GET['h']) OR !file_exists('haustiere/' . $_GET['h'])) {
					
					$haustiere = scandir('haustiere');
					echo '<p class="verstecke"></p>';
					foreach($haustiere AS $haustier) {
						if(is_file('haustiere/' . $haustier) OR substr($haustier,0,1) == '.') continue;
						echo '<a href="index.php?h=' . $haustier . '" class="haustier">';
						echo '<img src="haustiere/' . $haustier . '/' . $haustier . '.png" alt="' . $haustier . '"/>';
						echo '</a>';
					}
					echo '</div>';
				} else { 
					$haustier = $_GET['h'];
					if(isset($_GET['t']) AND file_exists('haustiere/' . $haustier . '/' . $_GET['t'])) 
						$thema = preg_replace('/[^a-zA-Z0-9]/','',$_GET['t']);
					else
						$thema = '1'; 
			?>
		</div>

		<div style="position:relative;height:180px;"  class="verstecke">
				<img src="musterbild.jpg" class="muster" style="height:180px"/>
				<img src="haustiere/<?=$haustier?>/<?=$thema?>/overlay.png" class="muster" style="margin-top:80px;margin-left: -125px;height:80px"/>
		</div>
		<form id="formular" action="upload.php" method="post" enctype="multipart/form-data"  class="verstecke">
			<input type="hidden" name="h" value="<?=$haustier?>"/>
			<input type="hidden" name="t" value="<?=$thema?>"/>
			<div class="fileUpload btn btn-success">
				<span>Foto aufnehmen</span>
				<input type="file" id="file" name="file" class="upload" accept="image/*;capture=camera" style="height: 100%">
		</div>
		
			<?php 	$themen = scandir( 'haustiere/' . $haustier );
				if($themen) { ?>
				<div style="margin-top: 20px;border-top: 2px solid #4CB4E7;padding-top:3px"> Andere Themen:<br/> 
		
				<?php	foreach($themen AS $thema){
					if(is_file('haustiere/' . $haustier . '/' . $thema) OR substr($thema,0,1) == '.'  OR $thema == $_GET['t']) continue;
								
					echo '<a href="index.php?h=' . $haustier . '&t=' . $thema . '">';
					echo '<img src="haustiere/' . $haustier . '/' . $thema . '/thumbnail.png" style="height: 90px;margin: 0 2px 2px 0;"/>';
					echo '</a>';
				} ?>
					<br/>Du hast noch einen Vorschlag für einen lustigen Spruch? Dann maile an <a href="mailto:thomas.kuenstler@gruene.de">Thomas Künstler</a>.
				</div>
			<?php 	} ?>
		</form>
				
			<div id="warten" style="display:none">Dein Bild wird bearbeitet. Augenblick bitte...</div>
	<?php 	} ?>
		
		
		<script src="jquery.min.js"></script>
		<script>
			$('#file').change(function(){
				$('#formular').submit();
				$('.verstecke').hide();
				$('#warten').show();
			})
		</script>
		
<!--		<div id="desktopcontainer">
			<div align="center">
				<img class="logo" src="images/logo.svg">
			</div>
			<h1>Mein Haustier würde Grün wählen!</h1>
			<p class="verstecke">Tut uns Leid, diese Anwendung steht nur für mobile Endgeräte zur Verfügung! Schauen Sie doch mal auf gruene.de vorbei…</p>
			<a href="http://www.gruene.de" class="btn">www.gruene.de</a>
		</div> -->
			<hr />
		<div class="fb-share-button" data-href="https://haustier-thkuenstler.c9users.io/" data-layout="button" data-size="large" data-mobile-iframe="true">
		<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fhaustier-thkuenstler.c9users.io%2F&amp;src=sdkpreparse">Auf Facebook Teilen</a></div>
	</div>
		<div align="center"><img class="logo2" src="images/logo_quer.png"></div>
	</body>
</html>