<?php

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$contentMysqlExtDAO = new ContentMySqlExtDAO();

extract($_POST);
$ad = $contentMysqlExtDAO->load($id);

$newSlug = slugify($title);
if ($slug != $newSlug) {
    $c = 1;
    while ($contentMysqlExtDAO->queryBySlug($newSlug)) {
        $newSlug = slugify($title);
        $newSlug = $newSlug . '-' . $c;
        $c++;
    }
}


if ($_FILES['image']['size'] > 0) {
    $newImage = upload_image("image", $imagesPath);
    if (is_file($imagesPath . $newImage)) {
        $simpleImage->load($imagesPath . $newImage);
        $simpleImage->resizeToWidth($medImageW);
        $simpleImage->save($imagesPath . "med_" . $newImage);
        $simpleImage->resizeToWidth($smallImageW);
        $simpleImage->save($imagesPath . "small_" . $newImage);

        if (is_file($imagesPath . $current_image)) {
            unlink($imagesPath . $current_image);
            unlink($imagesPath . "med_" . $current_image);
            unlink($imagesPath . "small_" . $current_image);
        }
    }
    $image = $newImage;
} else {
    $image = $current_image;
}

$obj =  new ContentMySqlDAO();
$obj->id = $id;
$obj->title = $title;
$obj->image = $image;
$obj->details = $details;
$obj->lang = $lang;
$obj->displayOrder = $display_order;
$obj->type = 'ad';
$obj->slug = $newSlug;
$obj->canDelete = $ad->canDelete;

$obj->customUrl = $custom_url;

$update = $contentMysqlExtDAO->update($obj);

if ($update) {
    $num++;
}

if ($num > 0) {
    $act = 3;
} else {
    $act = 4;
}

header("Location: display_ad.php?act=" . $act);
exit();
