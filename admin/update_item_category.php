<?php

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$id = $_GET['id'];
$itemCategoryMysqlExtDAO = new ItemCategoryMySqlExtDAO();

extract($_POST);

$newSlug = slugify($name);
if ($slug != $newSlug) {
    $c = 1;
    while ($itemCategoryMysqlExtDAO->queryBySlug($newSlug)) {
        $newSlug = slugify($name);
        $newSlug = $newSlug . '-' . $c;
        $c++;
    }
}
$active = radio_button($active);
$isFeatured = radio_button($is_featured);

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

if ($_FILES['banner_image']['size'] > 0) {
    $newBannerImage = upload_image("banner_image", $imagesPath);
    if (is_file($imagesPath . $newBannerImage)) {
        if (is_file($imagesPath . $current_banner_image)) {
            unlink($imagesPath . $current_banner_image);
        }
    }
    $bannerImage = $newBannerImage;
} else {
    $bannerImage = $current_banner_image;
}

$obj =  new ItemCategory();
$obj->id = $id;
$obj->name = $name;
$obj->image = $image;
$obj->bannerImage = $bannerImage;
$obj->active = $active;
$obj->parentId = $parent_id;
$obj->displayOrder = $display_order;
$obj->megaMenuDisplayOrder = $mega_menu_display_order;
$obj->isFeatured = $isFeatured;
if ($lang_id == 1) {
    $obj->slug = $newSlug;
}
$obj->langId = $lang_id;
$obj->translationId = $translation_id;

$update = $itemCategoryMysqlExtDAO->update($obj);

if ($update) {
    $num++;
}

if ($num > 0) {
    $act = 3;
} else {
    $act = 4;
}

$queryParamsArray = [];
$queryParamsArray['act'] = $act;
if ($parent_id != 0) {
    $queryParamsArray['id'] = $parent_id;
}
$queryParams = http_build_query($queryParamsArray);
header("Location: display_item_category.php?" . $queryParams);
exit();
