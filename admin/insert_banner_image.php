<?php 

require "session_start.php";
include "config.php";
include 'change_format.php';
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$bannerImageMysqlExtDAO = new BannerImageMySqlExtDAO();
extract($_POST);

$image=upload_image("image", "$imagesPath");
if (is_file($imagesPath.$image)) {
    $simpleImage->load($imagesPath.$image);
    $simpleImage->resizeToWidth($medImageW);
    $simpleImage->save($imagesPath."med_".$image);
    $simpleImage->resizeToWidth($smallImageW);
    $simpleImage->save($imagesPath."small_".$image);
} else {
    $image="";
}

$obj =  new BannerImageMySqlDAO();
$obj->imageName = $image;
$obj->caption1 = $caption1;
$obj->caption2 = $caption2;
$obj->buttonText = $button_text;
$obj->buttonLink = $button_link;
$obj->bannerId = $location;
$obj->buttonLinkTarget = "_blank";

$insert = $bannerImageMysqlExtDAO->insert($obj);
if ($insert) {
    $act=1;
} else {
    $act=2;
}

header("Location: display_banner_image.php?act=".$act);
exit;
