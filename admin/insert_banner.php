<?php 

require "session_start.php";
include "config.php";
include 'change_format.php';
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$bannerMysqlExtDAO = new BannerMySqlExtDAO();
extract($_POST);

$active=radio_button($active);
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

$bannerObj =  new BannerMySqlDAO();
$bannerObj->title = $title;
$bannerObj->location = $location;
$bannerObj->image = $image;
$bannerObj->displayOrder = $display_order;
$bannerObj->active = $active;

$insert = $bannerMysqlExtDAO->insert($bannerObj);
if ($insert) {
    $act=1;
} else {
    $act=2;
}

header("Location: display_banner.php?act=".$act);
exit;
