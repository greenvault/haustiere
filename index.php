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
  
<?PHP
   # =================================================================
   #      PopSelect
   # Populate a select drop-down list
   # CurrentVal is the selected option, if any
   # If Auto is set to 1, selection will auto-submit form to the location
   #  URL designated in that option's value.
   # AutoString may be used in auto mode if each option has the same preceeding value.
   #  For instance: "thisfile.php?getvar=" may be used if the option values are all processed
   #  by the same file.
   # kv determines whether the selected option is based on key (0) or value (1)
   # Size is the number of rows
   # Javascript event handlers may be used if Auto is set on. Simply enter the code
   #  for the JS field. Event should be single-quoted in function string.
   # Complex example:
   # PopSelect('Name', $Array, 'Selected, 'ClassName', 0, 1, '../directory/runthisfile.html?var=value',20,'onclick="(DoFunction());"')
   # =================================================================
function PopSelect($sName, $sArray, $CurrentVal, $sClass='', $kv=1, $Auto=0, $AutoString='', $Size=0, $JS="")
{
   $html='<select';
   if(!empty($sClass)){$html .= ' Class="' . $sClass . '" ';}
   $html .= ' name="' . $sName . '" id="' . $sName . '"';
   if($Size)
   {
      $html .= ' size="' . $Size . '"';
   }
   if($Auto)
   {
      $html .= ' onchange="if(options[selectedIndex].value){location = options[selectedIndex].value}"';
      if(!empty($JS))
      {
         $JSCode = strtolower($JS);
         if(substr($JSCode,0,8) == "onchange")
         {
            $JS = substr($JS,10); // Remove "onchange" and starting quote
            $html = substr($html,0,-1) . '; '; // Replace last quote with colin
            $html .= $JS;
         }
         else
         {
            $html .= ' ' . $JS;
         }
      }
   }
   else
   {
      if(!empty($JS))
      {
         $JSCode = strtolower($JS);
         $html .= ' ' . $JS;
      }
   }
   $html .= '>' . "\n";
   foreach($sArray as $key => $value)
   {
      if($kv==1){$SelectedVal = $value;}else{$SelectedVal = $key;}
      $html .= '<option value="';
      if(!empty($AutoString))
      {
         $html .= $AutoString . $key . '"';
      }
      else
      {
         $html .= $key . '"';
      }
      if($SelectedVal == $CurrentVal)
      {
         $html .= ' selected';
      }
      $html .= '>' . $value . '</option>' . "\n";
   }
   $html .= '</select>';
   return $html;
}
?>

<?php
if(isset($_GET['t']) AND file_exists('themen/' . $_GET['t'])) 
  $thema = preg_replace('/[^a-zA-Z0-9]/','',$_GET['t']);
else
  $thema = 'planetb';
?>
<?php include("auswahl.php"); ?>

<div id="container">
<div align="center"><img class="logo" src="images/logo.svg"></div>
<h1>Mein Haustier würde Grün wählen!</h1>
<p class="verstecke">Wähle die Art deines Haustieres und ggf. einen der alternativen Texte aus. Mach ein Foto von deinem Haustier, der ausgewählte Text wird drüber gelegt. 
Speichere das Foto und teile es auf Facebook!
</p>

<?php echo PopSelect('haustier',$haustier2,''); ?>
<br /><br />
<?php echo "Mein Haustier: $haustier" ?>
<br /><br />

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
