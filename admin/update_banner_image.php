<?php

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$id = $_GET['id'];
$bannerImageMysqlExtDAO = new BannerImageMySqlExtDAO();

extract($_POST);

if ($_FILES['image']['size'] > 0) {
    $newImage=upload_image("image", $imagesPath);
    if (is_file($imagesPath.$newImage)) {
        $simpleImage->load($imagesPath.$newImage);
        $simpleImage->resizeToWidth($medImageW);
        $simpleImage->save($imagesPath."med_".$newImage);
        $simpleImage->resizeToWidth($smallImageW);
        $simpleImage->save($imagesPath."small_".$newImage);

        if (is_file($imagesPath.$current_image)) {
            unlink($imagesPath.$current_image);
            unlink($imagesPath."med_".$current_image);
            unlink($imagesPath."small_".$current_image);
        }
    }
    $image = $newImage;
} else{
	$image = $current_image;
}

$obj =  new BannerImageMySqlDAO();
$obj->id = $id;
$obj->imageName = $image;
$obj->caption1 = $caption1;
$obj->caption2 = $caption2;
$obj->buttonText = $button_text;
$obj->buttonLink = $button_link;
$obj->bannerId = $location;
$obj->buttonLinkTarget = "_blank";

$update = $bannerImageMysqlExtDAO->update($obj);

if ($update) {
    $num++;
}

if ($num>0) {
    $act=3;
} else {
    $act=4;
}

$queryParams = http_build_query(
    [
        'act' => $act,
        'id' => $location,
    ]
);

header("Location: display_banner_image.php?".$queryParams);
exit();
