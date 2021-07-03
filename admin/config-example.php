<?php
date_default_timezone_set('Asia/Beirut');
ini_set('display_errors', '1');
ini_set('log_errors', '1');
ini_set('error_log', 'C:\xampp\htdocs\mastershop\error_log.log');
error_reporting(E_ALL ^ E_DEPRECATED);
include_once 'class/SimpleImage.php';
$simpleImage = new SimpleImage();

$siteName = "Mastershop";
$siteLink = "http://localhost/mastershop/";
$imagesLink = $siteLink.'public/uploads/images/';

// default images path
$imagesPath = "../public/uploads/images/";

// default files path
$filesPath = "../public/uploads/files/";

// default audio path
$audioPath = "../public/uploads/audio/";

define("SITE_LINK", $siteLink);
define("ADMIN_LINK", $siteLink . "admin/");
define("IMAGES_LINK", $imagesLink);
define('IMAGES_PATH', $imagesPath);
define('FILES_PATH', $filesPath);
define('AUDIO_PATH', $audioPath);

// images different dimension variables
$regularImageW = 800;
$regularImageH= 600;
$medImageW = 400;
$medImageH = 355;
$smallImageW = 150;
$smallImageH = 100;


$fileTypes = array(".xls",".xlsx",".doc",".docx",".pdf",".txt",".rtf",".zip",".flv",".gif",".jpg",".jpeg",".png", ".mp3", ".wav", ".wave", ".ram", ".mpeg", ".mp4");
