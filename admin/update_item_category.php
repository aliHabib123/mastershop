<?php

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$id = $_GET['id'];
$itemCategoryMysqlExtDAO = new ItemCategoryMySqlExtDAO();

extract($_POST);
$active = radio_button($active);

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

$obj =  new ItemCategoryMySqlDAO();
$obj->id = $id;
$obj->name = $name;
$obj->image = $image;
$obj->active = $active;
$obj->parentId = $parent_id;
$obj->displayOrder = $display_order;

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
