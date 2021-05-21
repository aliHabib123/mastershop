<?php

require "session_start.php";
include "config.php";
include "change_format.php";
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

//$id = $_GET['id'];
$itemBrandMysqlExtDAO = new ItemBrandMySqlExtDAO();

extract($_POST);

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

$obj =  new ItemBrandMySqlDAO();
$obj->id = $id;
$obj->name = $name;
$obj->image = $image;
$obj->displayOrder = $display_order;
$obj->brandTypeId = 0;

$num = 0;
$update = $itemBrandMysqlExtDAO->update($obj);
if ($update) {
    $num++;
}
// Start of brand category mapping
$brandCategoryMappingMySqlExtDAO = new BrandCategoryMappingMySqlExtDAO();
$mapping = $brandCategoryMappingMySqlExtDAO->queryByBrandId($id);
$mapping = array_map(function ($a) {
    return $a->categoryId;
}, $mapping);
$newMapping = [];
foreach ($categories as $row) {
    array_push($newMapping, $row);
}

$toDelete = implode(',', array_diff($mapping, $newMapping));
$toAdd = array_diff($newMapping, $mapping);
if (!empty($toDelete)) {
    $delete = $brandCategoryMappingMySqlExtDAO->deleteByBrandIdAndCond($id, "category_id IN (" . $toDelete . ")");
    if ($delete) {
        $num++;
    }
}
foreach ($toAdd as $row) {
    $obj = new BrandCategoryMapping();
    $obj->brandId = $id;
    $obj->categoryId = $row;
    $update = $brandCategoryMappingMySqlExtDAO->insert($obj);
    if ($update) {
        $num++;
    }
}
// End of brand category mapping

if ($num > 0) {
    $act = 3;
} else {
    $act = 4;
}

header("Location: display_item_brand.php?act=" . $act);
exit();
