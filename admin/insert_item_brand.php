<?php

require "session_start.php";
include "config.php";
include 'change_format.php';
include "resize.php";
include '../module/Application/src/Model/include_dao.php';

$itemBrandMysqlExtDAO = new ItemBrandMySqlExtDAO();
extract($_POST);

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

$obj =  new ItemBrandMySqlDAO();
$obj->name = $name;
$obj->image = $image;
$obj->displayOrder = $display_order;

$insert = $itemBrandMysqlExtDAO->insert($obj);
if ($insert) {
    $act = 1;
} else {
    $act = 2;
}

header("Location: display_item_brand.php?act=" . $act);
exit;
