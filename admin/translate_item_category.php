<?php

require "session_start.php";
include "config.php";
include '../module/Application/src/Model/include_dao.php';

$itemCategoryMysqlExtDAO = new ItemCategoryMySqlExtDAO();

$id = $_GET['id'];
$itemCategory = $itemCategoryMysqlExtDAO->load($id);

if($itemCategory->translationId){
    header("Location: edit_item_category.php?id=" . $itemCategory->translationId);
    exit;
} else {
    $itemCategoryCopy = clone $itemCategory;
    $itemCategoryCopy->langId = 2;
    $itemCategoryCopy->slug = '';
    $translationId = $itemCategoryMysqlExtDAO->insert($itemCategoryCopy);
    $itemCategory->translationId = $translationId;
    $update = $itemCategoryMysqlExtDAO->update($itemCategory);
    header("Location: edit_item_category.php?id=" . $translationId);
    exit;
}


