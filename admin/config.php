<?php
include_once 'class/SimpleImage.php';
$simpleImage = new SimpleImage();

$siteName = "Mastershop";
$siteLink = "http://localhost/mastershop/";
$imagesLink = $siteLink.'public/uploads/images/';
define("SITE_LINK", $siteLink);
define("IMAGES_LINK", $imagesLink);
// default images path
$imagesPath = "../public/uploads/images/";

// default files path
$filesPath = "../public/uploads/files/";

// default audio path
$audioPath = "../public/uploads/audio/";

// images different dimension variables
$regularImageW = 800;
$regularImageH= 600;
$medImageW = 400;
$medImageH = 355;
$smallImageW = 150;
$smallImageH = 100;


$fileTypes = array(".xls",".xlsx",".doc",".docx",".pdf",".txt",".rtf",".zip",".flv",".gif",".jpg",".jpeg",".png", ".mp3", ".wav", ".wave", ".ram", ".mpeg", ".mp4");
