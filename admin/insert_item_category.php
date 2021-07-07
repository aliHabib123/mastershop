<?php

require "session_start.php";
include "config.php";
include 'change_format.php';
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$itemCategoryMysqlExtDAO = new ItemCategoryMySqlExtDAO();
extract($_POST);

$slug = slugify($name);
$c = 1;
while ($itemCategoryMysqlExtDAO->queryBySlug($slug)) {
    $slug = slugify($title);
    $slug = $slug . '-' . $c;
    $c++;
}

$active = radio_button($active);
$isFeatured = radio_button($is_featured);
$image = upload_image("image", "$imagesPath");
if (is_file($imagesPath . $image)) {
    $simpleImage->load($imagesPath . $image);
    $simpleImage->resizeToWidth($medImageW);
    $simpleImage->save($imagesPath . "med_" . $image);
    $simpleImage->resizeToWidth($smallImageW);
    $simpleImage->save($imagesPath . "small_" . $image);
} else {
    $image = "";
}

$bannerImage = upload_image("banner_image", "$imagesPath");
if (!is_file($imagesPath . $bannerImage)) {
    $bannerImage = "";
}

$obj =  new ItemCategory();
$obj->name = $name;
$obj->image = $image;
$obj->bannerImage = $bannerImage;
$obj->parentId = $parent_id;
$obj->displayOrder = $display_order;
$obj->megaMenuDisplayOrder = $mega_menu_display_order;
$obj->active = $active;
$obj->isFeatured = $isFeatured;
$obj->slug = $slug;
$obj->langId = 1;

$insert = $itemCategoryMysqlExtDAO->insert($obj);
if ($insert) {
    $act = 1;
} else {
    $act = 2;
}

$queryParamsArray = [];
$queryParamsArray['act'] = $act;
if ($parent_id != 0) {
    if ($main_parent_id != 0) {
        $queryParamsArray['id'] = $main_parent_id;
        $queryParamsArray['subId'] = $parent_id;
    } else {
        $queryParamsArray['id'] = $parent_id;
    }
}
$queryParams = http_build_query($queryParamsArray);
header("Location: display_item_category.php?" . $queryParams);
exit;
