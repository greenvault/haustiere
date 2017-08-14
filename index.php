<!DOCTYPE html>
<html>
<head>

<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes">
<meta name="mobile-web-app-capable" content="yes">
<meta charset="utf-8"/>
  <link href="css/fonts.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
<title>Haustierwahlkampf</title>

</head>

<body>
<?php
if(isset($_GET['t']) AND file_exists('themen/' . $_GET['t'])) 
  $thema = preg_replace('/[^a-zA-Z0-9]/','',$_GET['t']);
else
  $thema = 'planetb';
?>
<div id="container">
<h1>Dein grünes Foto</h1>
<p  class="verstecke">Schieße ein Handyfoto und der Text wird drüber gelegt.
</p>

<div style="position:relative;height:180px;"  class="verstecke">
	<img src="musterbild.jpg" class="muster" style="height:180px"/>
	<img src="themen/<?=$thema?>/overlay.png" class="muster" style="margin-top:80px;margin-left: 10px;height:80px"/>
</div>

<form id="formular" action="upload.php" method="post" enctype="multipart/form-data"  class="verstecke">
<input type="hidden" name="t" value="<?=$thema?>"/>
<div class="fileUpload btn btn-success">
    <span>Foto aufnehmen</span>
    <input type="file" id="file" name="file" class="upload" accept="image/*;capture=camera" style="height: 100%">
</div>

<div style="margin-top: 20px;border-top: 2px solid #4CB4E7;padding-top:3px">
Andere Themen:<br/> 
<?php
$themen = scandir('themen');
foreach($themen AS $thema){
  if(is_file('themen/' . $thema) OR substr($thema,0,1) == '.'  OR $thema == $_GET['t']) continue;

  echo '<a href="index.php?t=' . $thema . '">';
    echo '<img src="themen/' . $thema . '/thumbnail.png" style="height: 90px;margin: 0 2px 2px 0;"/>';
  echo '</a>';
}
?>

<br/>
Du möchtest ein eigenes Overlay nutzen? Maile an <a href="MAILTO:thomas.rose@gruene-bayern.de">Thomas Rose</a>.
</div>
	
</form>

<div id="warten" style="display:none">
Dein Bild wird bearbeitet. Augenblick bitte...
</div>




</div>


<script src="jquery.min.js"></script>
<script>
$('#file').change(function(){
	$('#formular').submit();
	$('.verstecke').hide();
	$('#warten').show();
})
</script>


</body>
</html>
