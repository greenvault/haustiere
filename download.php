<?php


if( !isset($_GET['file'])) die();
$file = $_GET['file'];

if( preg_match('/\/download$/', $file)){
	$download = true;
	$file = preg_replace( '/\/download$/', '', $file );
}

$filename = realpath('uploads/' . $file);
$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch ($file_extension) {
    case "pdf": $ctype="application/pdf"; break;
    case "exe": $ctype="application/octet-stream"; break;
    case "zip": $ctype="application/zip"; break;
    case "doc": $ctype="application/msword"; break;
    case "xls": $ctype="application/vnd.ms-excel"; break;
    case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpe": case "jpeg":
    case "jpg": $ctype="image/jpg"; break;
    default: $ctype="application/force-download";
}

if (!file_exists($filename)) {
    die("Datei existiert nicht.");
}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Content-Type: $ctype");
header("Content-Disposition: attachment; filename=\"".basename($filename)."\";");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".@filesize($filename));
set_time_limit(0);

@readfile("$filename") or die("File not found.");